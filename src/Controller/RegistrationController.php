<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class RegistrationController extends AbstractController
{
    /**
     * Création du compte d'un utilisateur.
     */
    #[Route('/register', name: 'app_register')]
    public function register(
        Request $request,
        UserPasswordHasherInterface $userPasswordHasher,
        EntityManagerInterface $entityManager,
        Security $security
    ): Response {
        // On crée un nouvel objet utilisateur.
        $user = new User();

        // On génère le formulaire d'inscription en lui passant l'objet utilisateur.
        $form = $this->createForm(RegistrationFormType::class, $user);

        // On traite les données envoyées dans la requête HTTP et on les associe au formulaire.
        $form->handleRequest($request);

        // Si le formulaire est soumis et valide, on procède à l'enregistrement de l'utilisateur.
        if ($form->isSubmitted() && $form->isValid()) {

            // On récupère le mot de passe en clair depuis le formulaire.
            $plainPassword = $form->get('plainPassword')->getData();

            // On hache le mot de passe en clair avant de le stocker dans la base de données.
            $user->setPassword($userPasswordHasher->hashPassword($user, $plainPassword));

            // On définit les rôles de l'utilisateur (le rôle par défaut est "ROLE_USER").
            $user->setRoles(["ROLE_USER"]);

            // On enregistre l'utilisateur dans la base de données.
            $entityManager->persist($user);
            $entityManager->flush();

            // On authentifie l'utilisateur.
            $security->login($user);

            // On redirige l'utilisateur vers la page d'accueil après l'inscription.
            return $this->redirectToRoute('app_home');
        }

        // Si le formulaire n'est pas encore soumis ou valide, on l'affiche à l'utilisateur.
        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form
        ]);
    }
}
