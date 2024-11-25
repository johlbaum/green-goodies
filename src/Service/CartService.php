<?php

namespace App\Service;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;

class CartService
{
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * Ajoute ou met à jour la quantité d'un produit dans le panier.
     *
     * @param int $productId : L'ID du produit à ajouter ou à mettre à jour dans le panier.
     * @param int $selectedQuantity : La quantité du produit à ajouter ou à mettre à jour.
     * @param Request $request : L'objet Request contenant la session actuelle pour récupérer le panier.
     */
    public function updateCart(int $productId, int $selectedQuantity, $request): void
    {
        // On récupère le panier actuel depuis la session ou un tableau vide si aucun panier n'est trouvé.
        $session = $request->getSession();
        $cart = $session->get('cart', []);

        // Si le produit est déjà dans le panier, on ajoute la quantité spécifiée à la quantité existante.
        if (isset($cart[$productId])) {
            $cart[$productId] += $selectedQuantity;
        } else {
            // Si le produit n'est pas encore dans le panier, on l'ajoute.
            $cart[$productId] = $selectedQuantity;
        }

        // On met à jour la session avec le panier modifié.
        $session->set('cart', $cart);
    }

    /**
     * Récupère les produits présents dans le panier avec leurs quantités.
     *
     * @param Request $request : L'objet Request contenant la session actuelle pour accéder au panier.
     * @return array : Un tableau contenant les objets produits et leurs quantités. 
     */
    public function getCartItems($request): array
    {
        // On récupère le panier actuel depuis la session ou un tableau vide si aucun panier n'est trouvé.
        $session = $request->getSession();
        $cart = $session->get('cart', []);

        $products = [];

        // Pour chaque produit dans le panier, on récupère le produit et sa quantité.
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

    /**
     * Calcule le total du panier.
     *
     * @param array $products : Tableau contenant les produits et leurs quantités. 
     * @return float : Total du panier, arrondi à deux décimales.
     */
    public function calculateCartTotal(array $products): float
    {
        $total = 0;

        foreach ($products as $product) {
            // On ajoute au total le prix du produit multiplié par sa quantité.
            $total += $product['product']->getPrice() * $product['quantity'];
        }

        // On retourne le total arrondi à deux décimales.
        return round($total, 2);
    }

    /**
     * Vide le panier en supprimant toutes les données liées au panier dans la session.
     *
     * @param Request $request : L'objet Request contenant la session actuelle pour accéder au panier.
     */
    public function clearCart($request): void
    {
        // On récupère la session actuelle.
        $session = $request->getSession();

        // On supprime le panier de la session.
        $session->remove('cart');
    }

    /**
     * Récupère la quantité d'un produit spécifique dans le panier.
     * 
     * @param int $productId : L'ID du produit dont on veut connaître la quantité.
     * @param Request $request : L'objet Request contenant la session actuelle pour récupérer le panier.
     * @return int : La quantité du produit dans le panier. Retourne 0 si le produit n'est pas dans le panier.
     */
    public function getProductQuantityInCart(int $productId, $request): int
    {
        // On récupère le panier actuel depuis la session ou un tableau vide si aucun panier n'est trouvé.
        $session = $request->getSession();
        $cart = $session->get('cart', []);

        // On retourne la quantité du produit spécifié ou 0 s'il n'est pas dans le panier.
        return $cart[$productId] ?? 0;
    }

    /**
     * Supprime un produit du panier.
     *
     * @param int $productId : L'ID du produit à supprimer du panier.
     * @param Request $request : L'objet Request contenant la session actuelle pour récupérer le panier.
     */
    public function removeFromCart(int $productId, $request): void
    {
        // On récupère le panier actuel depuis la session ou un tableau vide si aucun panier n'est trouvé.
        $session = $request->getSession();
        $cart = $session->get('cart', []);

        // On vérifie si le produit existe dans le panier.
        if (isset($cart[$productId])) {
            // On supprime le produit du panier.
            unset($cart[$productId]);

            // On met à jour la session avec le panier modifié.
            $session->set('cart', $cart);
        }
    }

    /**
     * Calcule le nombre total d'articles dans le panier.
     *
     * @param Request $request : L'objet Request contenant la session actuelle pour récupérer le panier.
     * @return int : Le nombre total d'articles dans le panier.
     */
    public function getTotalQuantity($request): int
    {
        // On récupère le panier actuel depuis la session ou un tableau vide si aucun panier n'est trouvé.
        $session = $request->getSession();
        $cart = $session->get('cart', []);

        // On calcule le total des quantités.
        return array_sum($cart);
    }
}
