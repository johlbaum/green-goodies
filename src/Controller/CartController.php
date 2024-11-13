<?php

namespace App\Controller;

use App\Service\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CartController extends AbstractController
{
    #[Route('/cart/add', name: 'app_cart_add')]
    public function addToCart(Request $request, CartService $cartService): Response
    {
        $productId = (int) $request->request->get('product_id');
        $quantity = (int) $request->request->get('quantity');

        $cartService->addToCart($productId, $quantity, $request);

        return $this->redirectToRoute('app_cart_add');
    }

    #[Route('/cart/show', name: 'app_cart_show')]
    public function showCart(Request $request, CartService $cartService): Response
    {
        // On récupère les produits du panier.
        $products = $cartService->getCartItems($request);

        // On calcule le montant total du panier.
        $total = $cartService->calculateCartTotal($products);

        return $this->render('cart/index.html.twig', [
            'products' => $products,
            'total' => $total
        ]);
    }

    #[Route('/cart/delete', name: 'app_cart_delete')]
    public function deleteCart(Request $request): Response
    {
        $session = $request->getSession();
        $session->remove('cart');

        return $this->redirectToRoute('app_cart_show');
    }
}
