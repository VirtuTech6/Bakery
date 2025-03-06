<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use App\Repository\CategoryRepository;

#[Route('/api/products')]
class ProductController extends AbstractController
{
    #[Route('', name: 'get_products', methods: ['GET'])]
    public function getAllProducts(ProductRepository $productRepository): JsonResponse
    {
        $products = $productRepository->findAll();
        
        $productsData = array_map(function($product) {
            return [
                'id' => $product->getId(),
                'name' => $product->getName(),
                'description' => $product->getDescription(),
                'price' => $product->getPrice(),
                'stock' => $product->getStock(),
                'weight' => $product->getWeight(),
                'ingredients' => $product->getIngredients(),
                'category' => $product->getCategory(),
                'imageName' => $product->getImageName(),
                'imageUrl' => $product->getImageName() ? '/images/products/' . $product->getImageName() : null
            ];
        }, $products);

        return $this->json([
            'products' => $productsData,
        ]);
    }

    #[Route('/{id}', name: 'get_product', methods: ['GET'])]
    public function getProduct(int $id, ProductRepository $productRepository): JsonResponse
    {
        $product = $productRepository->findOneById($id);

        if (!$product) {
            return $this->json([
                'message' => 'Produit non trouvé'
            ], 404);
        }

        $productData = [
            'id' => $product->getId(),
            'name' => $product->getName(),
            'description' => $product->getDescription(),
            'price' => $product->getPrice(),
            'stock' => $product->getStock(),
            'weight' => $product->getWeight(),
            'ingredients' => $product->getIngredients(),
            'category' => $product->getCategory(),
            'imageName' => $product->getImageName(),
            'imageUrl' => $product->getImageName() ? '/images/products/' . $product->getImageName() : null
        ];

        return $this->json([
            'product' => $productData
        ]);
    }

    #[Route('', name: 'create_product', methods: ['POST'])]
    #[IsGranted('ROLE_MANAGER')]
    public function createProduct(
        Request $request, 
        ProductRepository $productRepository,
        CategoryRepository $categoryRepository
    ): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        // Validation des données
        if (!isset($data['name']) || !isset($data['description']) || !isset($data['price']) ||
            !isset($data['stock']) || !isset($data['weight']) || !isset($data['ingredients']) ||
            !isset($data['category_id'])) {
            return $this->json([
                'message' => 'Données manquantes'
            ], 400);
        }

        // Récupération de la catégorie
        $category = $categoryRepository->find($data['category_id']);
        if (!$category) {
            return $this->json([
                'message' => 'Catégorie non trouvée'
            ], 404);
        }

        $product = new Product();
        $product->setName($data['name']);
        $product->setDescription($data['description']);
        $product->setPrice($data['price']);
        $product->setStock($data['stock']);
        $product->setWeight($data['weight']);
        $product->setIngredients($data['ingredients']);
        $product->setCategory($category);
        
        // Gestion de l'image si présente
        if ($request->files->has('image')) {
            $imageFile = $request->files->get('image');
            $product->setImageFile($imageFile);
        }
        
        $productRepository->create($product, true);

        return $this->json([
            'message' => 'Produit créé avec succès',
            'product' => $product
        ], 201);
    }

    #[Route('/{id}', name: 'delete_product', methods: ['DELETE'])]
    #[IsGranted('ROLE_MANAGER')]
    public function deleteProduct(
        int $id, 
        ProductRepository $productRepository
    ): JsonResponse
    {
        $product = $productRepository->findOneById($id);

        if (!$product) {
            return $this->json([
                'message' => 'Produit non trouvé'
            ], 404);
        }

        $productRepository->remove($product, true);

        return $this->json([
            'message' => 'Produit supprimé avec succès'
        ]);
    }

    #[Route('/{id}', name: 'update_product', methods: ['PUT'])]
    #[IsGranted('ROLE_MANAGER')]
    public function updateProduct(
        int $id,
        Request $request,
        ProductRepository $productRepository
    ): JsonResponse
    {
        $product = $productRepository->findOneById($id);

        if (!$product) {
            return $this->json([
                'message' => 'Produit non trouvé'
            ], 404);
        }

        $data = json_decode($request->getContent(), true);
        
        // Gestion de l'image si présente
        if ($request->files->has('image')) {
            $imageFile = $request->files->get('image');
            $product->setImageFile($imageFile);
        }

        $updatedProduct = $productRepository->update($product, $data);

        return $this->json([
            'message' => 'Produit mis à jour avec succès',
            'product' => $updatedProduct
        ]);
    }
}
