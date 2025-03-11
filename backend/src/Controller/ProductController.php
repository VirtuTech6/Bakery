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

class ProductController extends AbstractController
{
    private function validateProductData(array $data): array
    {
        $requiredFields = ['name', 'description', 'price', 'stock', 'weight', 'ingredients', 'category_id'];
        $missingFields = [];

        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                $missingFields[] = $field;
            }
        }

        if (!empty($missingFields)) {
            throw new \InvalidArgumentException('Champs manquants : ' . implode(', ', $missingFields));
        }

        return $data;
    }

    private function extractFormData(Request $request): array
    {
        $data = [
            'name' => $request->request->get('name'),
            'description' => $request->request->get('description'),
            'price' => $request->request->get('price'),
            'stock' => $request->request->get('stock'),
            'weight' => $request->request->get('weight'),
            'ingredients' => $request->request->get('ingredients'),
            'category_id' => $request->request->get('category_id')
        ];

        // Si les données ne sont pas dans request, essayer de les récupérer du contenu brut
        if (in_array(null, $data, true)) {
            $content = $request->getContent();
            foreach ($data as $key => $value) {
                if ($value === null && preg_match('/name="' . $key . '"\s*(.*?)\s*--/', $content, $matches)) {
                    $data[$key] = trim($matches[1]);
                }
            }
        }

        return $data;
    }

    private function formatProductResponse(Product $product): array
    {
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
    }

    #[Route('/api/public/products', name: 'get_products', methods: ['GET'])]
    public function getAllProducts(ProductRepository $productRepository): JsonResponse
    {
        $products = $productRepository->findAll();
        $productsData = array_map([$this, 'formatProductResponse'], $products);

        return $this->json(['products' => $productsData]);
    }

    #[Route('/api/public/products/{id}', name: 'get_product', methods: ['GET'])]
    public function getProduct(int $id, ProductRepository $productRepository): JsonResponse
    {
        $product = $productRepository->findOneById($id);

        if (!$product) {
            return $this->json(['message' => 'Produit non trouvé'], 404);
        }

        return $this->json(['product' => $this->formatProductResponse($product)]);
    }

    #[Route('/api/products', name: 'create_product', methods: ['POST'])]
    #[IsGranted('ROLE_MANAGER')]
    public function createProduct(
        Request $request, 
        ProductRepository $productRepository,
        CategoryRepository $categoryRepository
    ): JsonResponse
    {
        try {
            $data = $this->extractFormData($request);
            $this->validateProductData($data);

            $category = $categoryRepository->find($data['category_id']);
            if (!$category) {
                return $this->json(['message' => 'Catégorie non trouvée'], 404);
            }

            $product = new Product();
            $product->setName($data['name']);
            $product->setDescription($data['description']);
            $product->setPrice($data['price']);
            $product->setStock($data['stock']);
            $product->setWeight($data['weight']);
            $product->setIngredients($data['ingredients']);
            $product->setCategory($category);
            
            if ($request->files->has('image')) {
                $product->setImageFile($request->files->get('image'));
            }
            
            $productRepository->save($product, true);

            return $this->json([
                'message' => 'Produit créé avec succès',
                'product' => $this->formatProductResponse($product)
            ], 201);
        } catch (\InvalidArgumentException $e) {
            return $this->json(['message' => $e->getMessage()], 400);
        }
    }

    #[Route('/api/products/{id}', name: 'update_product', methods: ['POST'])]
    #[IsGranted('ROLE_MANAGER')]
    public function updateProduct(
        int $id,
        Request $request,
        ProductRepository $productRepository,
        CategoryRepository $categoryRepository
    ): JsonResponse
    {
        try {
            $product = $productRepository->findOneById($id);
            if (!$product) {
                return $this->json(['message' => 'Produit non trouvé'], 404);
            }

            $data = $this->extractFormData($request);
            $this->validateProductData($data);

            $category = $categoryRepository->find($data['category_id']);
            if (!$category) {
                return $this->json(['message' => 'Catégorie non trouvée'], 404);
            }

            $product->setName($data['name']);
            $product->setDescription($data['description']);
            $product->setPrice($data['price']);
            $product->setStock($data['stock']);
            $product->setWeight($data['weight']);
            $product->setIngredients($data['ingredients']);
            $product->setCategory($category);
            
            if ($request->files->has('image')) {
                $imageFile = $request->files->get('image');
                if ($imageFile) {
                    $product->setImageFile($imageFile);
                }
            }
            
            $productRepository->save($product, true);

            return $this->json([
                'message' => 'Produit mis à jour avec succès',
                'product' => $this->formatProductResponse($product)
            ]);
        } catch (\InvalidArgumentException $e) {
            return $this->json(['message' => $e->getMessage()], 400);
        }
    }

    #[Route('/api/products/{id}', name: 'delete_product', methods: ['DELETE'])]
    #[IsGranted('ROLE_MANAGER')]
    public function deleteProduct(int $id, ProductRepository $productRepository): JsonResponse
    {
        $product = $productRepository->findOneById($id);

        if (!$product) {
            return $this->json(['message' => 'Produit non trouvé'], 404);
        }

        $productRepository->remove($product, true);
        return $this->json(['message' => 'Produit supprimé avec succès']);
    }
}
