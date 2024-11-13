<?php

namespace App\Controller;

use App\Entity\Order;
use App\Service\CartService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class OrderController extends AbstractController
{
    #[Route('/order/create', name: 'app_order_add')]
    public function createOrder(CartService $cartService, Request $request, EntityManagerInterface $entityManager): Response
    {
        // On récupère les produits du panier.
        $products = $cartService->getCartItems($request);

        // On calcule le montant total du panier.
        $total = $cartService->calculateCartTotal($products);

        // On récupère l'utilisateur connecté.
        $user = $this->getUser();

        $order = new Order();
        $order->setUser($user);
        $order->setOrderDate(new \DateTime());
        $order->setTotalAmount($total);

        // On sauvegarde la commande.
        $entityManager->persist($order);
        $entityManager->flush();

        return $this->redirectToRoute('app_cart_show');
    }
}
