<?php

namespace App\Controller;

use App\Form\OrderType;
use App\Service\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CartController extends AbstractController
{
    /**
     * Affiche le panier.
     */
    #[Route('/cart/show', name: 'app_cart_show')]
    public function showCart(Request $request, CartService $cartService): Response
    {
        // On récupère les produits du panier.
        $products = $cartService->getCartItems($request);

        // On calcule le montant total du panier.
        $total = $cartService->calculateCartTotal($products);

        // On génère le formulaire de création de commande.
        $orderForm = $this->createForm(OrderType::class);

        return $this->render('cart/index.html.twig', [
            'products' => $products,
            'total' => $total,
            'orderForm' => $orderForm,
        ]);
    }

    /**
     * Supprime le contenu du panier.
     */
    #[Route('/cart/delete', name: 'app_cart_delete')]
    public function deleteCart(Request $request, CartService $cartService): Response
    {
        $cartService->clearCart($request);

        return $this->redirectToRoute('app_cart_show');
    }
}
