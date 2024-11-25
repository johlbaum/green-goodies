<?php

namespace App\Twig;

use App\Service\CartService;
use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class CartExtension extends AbstractExtension
{
    private $cartService;
    private $requestStack; // Permet d'accéder à la requête HTTP actuelle (via RequestStack) pour récupérer la session où est stocké le panier utilisateur.

    public function __construct(CartService $cartService, RequestStack $requestStack)
    {
        $this->cartService = $cartService;
        $this->requestStack = $requestStack;
    }

    /**
     * Retourne les fonctions Twig personnalisées disponibles dans les templates.
     * Chaque fonction est définie via une instance de TwigFunction.
     *
     * @return array Un tableau de fonctions Twig.
     */
    public function getFunctions(): array
    {
        return [
            // Fonction Twig :
            // Nom : 'cart_total_quantity' — utilisé dans le template 'Header' pour afficher la quantité totale d'articles dans le panier.
            // Callback : [$this, 'getTotalQuantity'] — appelle la méthode getTotalQuantity de cette classe.
            new TwigFunction('cart_total_quantity', [$this, 'getTotalQuantity']),
        ];
    }

    /**
     * Calcul et retourne la quantité totale d'articles dans le panier.
     *
     * @return int La quantité totale d'articles dans le panier.
     */
    public function getTotalQuantity(): int
    {
        // On récupère la requête HTTP actuelle pour accéder à la session.
        $request = $this->requestStack->getCurrentRequest();

        // On utilise le service pour calculer la quantité totale d'articles.
        return $this->cartService->getTotalQuantity($request);
    }
}
