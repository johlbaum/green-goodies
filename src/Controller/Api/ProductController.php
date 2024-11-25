<?php

namespace App\Controller\Api;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\SerializerInterface;

class ProductController extends AbstractController
{
    /**
     * Permet de récupérer la liste des produits.
     */
    #[Route('/api/products', name: 'api_products', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function getProducts(ProductRepository $productRepository, SerializerInterface $serializer): JsonResponse
    {
        // On récupère tous les produits.
        $products = $productRepository->findAll();

        // On sérialise les données des produits en JSON.
        $jsonData = $serializer->serialize($products, 'json');

        // On renvoie une réponse JSON contenant les produits sérialisés avec un statut HTTP 200.
        return new JsonResponse($jsonData, 200, [], true);
    }
}
