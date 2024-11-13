<?php

namespace App\Service;

use App\Repository\ProductRepository;

class CartService
{
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function addToCart(int $productId, int $quantity, $request): void
    {
        // On accède à la session.
        $session = $request->getSession();

        // On récupère les valeurs associées à la clé 'cart' sous forme de tableau dans la session,
        // ou on renvoie un tableau vide si aucun produit n'a été ajouté au panier.
        $cart = $session->get('cart', []);

        // Si le produit est déjà dans le panier, on ajoute la nouvelle quantité à l'existante.
        if (isset($cart[$productId])) {
            $cart[$productId] += $quantity;
            // Si la quantité est supérieure à 0, on ajoute l'ID du produit et la quantité associée au panier.
        } else if ($quantity > 0) {
            $cart[$productId] = $quantity;
            // Si la quantité est 0, on supprime le produit du panier.
        } else {
            unset($cart[$productId]);
        }

        $session->set('cart', $cart);
    }

    public function getCartItems($request): array
    {
        // On accède à la session.
        $session = $request->getSession();

        $cart = $session->get('cart', []);

        $products = [];

        foreach ($cart as $productId => $quantity) {
            $product = $this->productRepository->find($productId);
            if ($product) {
                $products[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                ];
            }
        }

        return $products;
    }

    public function calculateCartTotal(array $products): float
    {
        $total = 0;

        foreach ($products as $item) {
            $total += $item['product']->getPrice() * $item['quantity'];
        }

        return $total;
    }
}
