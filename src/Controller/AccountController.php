<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AccountController extends AbstractController
{
    #[Route('/account/show', name: 'app_account_show')]
    public function showAccount(): Response
    {
        // On récupère l'utilisateur connecté.
        $user = $this->getUser();

        // On récupère les commandes.
        if ($user instanceof User) {
            $orders = $user->getOrders();
        }

        return $this->render('account/index.html.twig', [
            'orders' => $orders
        ]);
    }

    #[Route('/account/delete', name: 'app_account_delete')]
    public function deleteAccount(EntityManagerInterface $entityManager, Security $security): Response
    {
        // On récupère l'utilisateur connecté.
        $user = $this->getUser();

        // On supprime l'utilisateur et les commandes associées.
        $entityManager->remove($user);
        $entityManager->flush();

        // On déconnecte l'utilisateur.
        $security->logout(false);

        // On redirige l'utilisateur vers la page d'accueil.
        return $this->redirectToRoute('app_home');
    }
}
