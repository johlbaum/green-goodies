<?php

namespace App\Controller;

use App\Form\CartItemType;
use App\Repository\ProductRepository;
use App\Service\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProductController extends AbstractController
{
    /**
     * Affiche la liste de tous les produits.
     */
    #[Route('/', name: 'app_home')]
    public function index(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAll();

        return $this->render('home/index.html.twig', [
            'products' => $products
        ]);
    }

    /**
     * Affiche le détail d'un produit et gère l'ajout d'un produit au panier.
     */
    #[Route('/product/{id}', name: 'app_product_detail')]
    public function show(
        int $id,
        ProductRepository $productRepository,
        Request $request,
        CartService $cartService
    ): Response {

        // On récupère le produit consulté.
        $product = $productRepository->find($id);

        // Si le produit est déjà dans le panier, on récupère la quantité actuelle du produit dans le panier.
        $quantityInCart = $cartService->getProductQuantityInCart($id, $request);

        // On génère le formulaire en lui passant en option la valeur initiale de l'input.
        $form = $this->createForm(CartItemType::class, null, [
            'quantity' => $quantityInCart > 0 ? $quantityInCart : 1,
        ]);

        // Les données envoyées via la requête HTTP sont récupérées et mappées sur les champs du formulaire.
        $form->handleRequest($request);

        // Validation de la soumission et des contraintes de validation du formulaire.
        if ($form->isSubmitted() && $form->isValid()) {

            // On récupère la quantité que l'utilisateur a envoyé dans le formulaire.
            $data = $form->getData();
            $selectedQuantity = $data['quantity'];

            // Si la quantité sélectionnée par l'utilisateur est 0 et que le produit ne figure pas déjà dans le panier.
            if ($selectedQuantity == 0 && $quantityInCart == 0) {
                $this->addFlash('error-cart', 'La quantité doit être d\'au moins 1 pour ajouter un produit au panier.');
            } else {

                // Si la quantité sélectionnée par l'utilisateur est 0 et que le produit figure déjà dans le panier.
                if ($selectedQuantity == 0 && $quantityInCart > 0) {

                    // On supprime le produit du panier.
                    $cartService->removeFromCart($product->getId(), $request);

                    // On envoie un message à l'utilisateur.
                    $this->addFlash('success-cart', 'Le produit a été supprimé du panier.');
                }

                // Si la quantité sélectionnée par l'utilisateur est supérieure à zero.
                if ($selectedQuantity > 0) {

                    // On met à jour le panier.
                    $cartService->updateCart($id, $selectedQuantity, $request);

                    // On envoie un message à l'utilisateur.
                    $this->addFlash('success-cart', $quantityInCart > 0 ? 'Le produit a été mis à jour dans votre panier.' : 'Le produit a été ajouté au panier.');
                }
            }

            return $this->redirectToRoute('app_product_detail', ['id' => $id]);
        }

        return $this->render('product/index.html.twig', [
            'product' => $product,
            'form' => $form,
            'isProductInCart' => $quantityInCart > 0
        ]);
    }
}
