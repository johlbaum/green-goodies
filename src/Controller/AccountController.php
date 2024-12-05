<?php

namespace App\Controller;

use App\Form\ApiAccessType;
use App\Form\DeleteAccountType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AccountController extends AbstractController
{
    /**
     * Affiche le compte de l'utilisateur.
     */
    #[Route('/account/show', name: 'app_account_show')]
    public function showAccount(): Response
    {
        /**
         * @var App\Entity\User $user
         */
        // On récupère les commandes de l'utilisateur connecté.
        $user = $this->getUser();
        $orders = $user->getOrders();

        // On génère le formulaire d'activation de l'accès à l'API en lui passant en option la valeur initiale de l'input.
        $apiAccessForm = $this->createForm(ApiAccessType::class, options: [
            'is_enabled' => $user->isApiAccessEnabled(),
        ]);

        // On génère le formulaire de suppression du compte de l'utilisateur. 
        $deleteAccountForm = $this->createForm(DeleteAccountType::class);

        return $this->render('account/index.html.twig', [
            'orders' => $orders,
            'user' => $user,
            'apiAccessForm' => $apiAccessForm,
            'deleteAccountForm' => $deleteAccountForm,
        ]);
    }

    /**
     * Gère la suppression du compte utilisateur.
     */
    #[Route('/account/delete', name: 'app_account_delete')]
    public function deleteAccount(Request $request, EntityManagerInterface $entityManager, Security $security): Response
    {
        // On génère le formulaire de suppression du compte de l'utilisateur. 
        $form = $this->createForm(DeleteAccountType::class);

        // La requête HTTP est analysée pour déterminer si le formulaire a été soumis.
        $form->handleRequest($request);

        // On traite la soumission du formulaire.
        if ($form->isSubmitted()) {

            // On récupère l'utilisateur connecté.
            $user = $this->getUser();

            // On supprime son compte.
            $entityManager->remove($user);
            $entityManager->flush();

            // On déconnecte l'utilisateur.
            $security->logout(false);

            // On envoie un message de confirmation.
            $this->addFlash('success', 'Votre compte a été supprimé.');

            // On redirige l'utilisateur vers la page d'accueil.
            return $this->redirectToRoute('app_home');
        }

        // On redirige l'utilisateur vers la page de gestion de son compte en cas d'échec.
        return $this->redirectToRoute('app_account_show');
    }

    /**
     * Gère l'activation de l'accès API de l'utilisateur.
     */
    #[Route('/account/update-api-access', name: 'app_account_update_api_access')]
    public function updateApiAccess(Request $request, EntityManagerInterface $entityManager): Response
    {

        // On génère le formulaire d'activation de l'accès à l'API.
        $form = $this->createForm(ApiAccessType::class);

        // La requête HTTP est analysée pour déterminer si le formulaire a été soumis.
        $form->handleRequest($request);

        // On traite la soumission du formulaire.
        if ($form->isSubmitted()) {

            /**
             * @var App\Entity\User $user
             */
            // On récupère l'utilisateur connecté.
            $user = $this->getUser();

            // On met à jour le statut d'activation de l'accès API.
            $user->setApiAccessEnabled(!$user->isApiAccessEnabled());

            // On enregistre les changements en base de données.
            $entityManager->flush();

            // On envoie un message de confirmation.
            $this->addFlash('success-api', 'Votre accès API a été mis à jour.');

            // On redirige l'utilisateur vers son compte.
            return $this->redirectToRoute('app_account_show');
        }

        // On redirige l'utilisateur vers la page de gestion de son compte en cas d'échec.
        return $this->redirectToRoute('app_account_show');
    }
}
