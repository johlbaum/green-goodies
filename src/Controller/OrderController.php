<?php

namespace App\Controller;

use App\Entity\Order;
use App\Form\OrderType;
use App\Service\CartService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class OrderController extends AbstractController
{
    /**
     * Création d'une commande.
     */
    #[Route('/order/create', name: 'app_order_add')]
    public function createOrder(CartService $cartService, Request $request, EntityManagerInterface $entityManager): Response
    {
        // On récupère les produits du panier.
        $products = $cartService->getCartItems($request);

        // On calcule le montant total du panier.
        $total = $cartService->calculateCartTotal($products);

        // On récupère l'utilisateur connecté.
        $user = $this->getUser();

        // On crée une nouvelle commande.
        $order = new Order();
        $order->setUser($user);
        $order->setOrderDate(new \DateTime());
        $order->setTotalAmount($total);

        // On associe les produits à la commande.
        foreach ($products as $cartItem) {
            $product = $cartItem['product'];
            $order->addProduct($product);
        }

        // On génère le formulaire.
        $orderForm = $this->createForm(OrderType::class);

        // Les données envoyées via la requête HTTP sont récupérées et mappées sur les champs du formulaire.
        $orderForm->handleRequest($request);

        // Validation de la soumission et des contraintes de validation du formulaire.
        if ($orderForm->isSubmitted() && $orderForm->isValid()) {

            // On sauvegarde la commande.
            $entityManager->persist($order);
            $entityManager->flush();

            // On vide le panier après la commande.
            $cartService->clearCart($request);

            // On ajoute un message de confirmation de création de la commande.
            $this->addFlash('success-order', 'Votre commande a été passée avec succès ! Vous pouvez accéder au récapitulatif de votre commande en cliquant sur l\'onglet "Mon compte".');

            return $this->redirectToRoute('app_cart_show');
        }

        return $this->render('cart/index.html.twig', [
            'products' => $products,
            'total' => $total,
            'orderForm' => $orderForm,
        ]);
    }
}
