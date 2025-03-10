<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/api/categories')]
class CategoryController extends AbstractController
{
    public function __construct(
        private CategoryRepository $categoryRepository
    ) {}

    private function validateCategoryData(array $data): array
    {
        $requiredFields = ['name', 'description'];
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
            'description' => $request->request->get('description')
        ];

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

    private function formatCategoryResponse(Category $category): array
    {
        return [
            'id' => $category->getId(),
            'name' => $category->getName(),
            'description' => $category->getDescription(),
            'imageName' => $category->getImageName(),
            'imageUrl' => $category->getImageName() ? '/images/categories/' . $category->getImageName() : null
        ];
    }

    #[Route('', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $categories = $this->categoryRepository->findAll();
        $categoriesData = array_map([$this, 'formatCategoryResponse'], $categories);
        return $this->json(['categories' => $categoriesData]);
    }

    #[Route('/{id}', methods: ['GET'])]
    #[IsGranted('ROLE_MANAGER')]
    public function show(int $id): JsonResponse
    {
        $category = $this->categoryRepository->find($id);

        if (!$category) {
            return $this->json(['message' => 'Catégorie non trouvée'], Response::HTTP_NOT_FOUND);
        }

        return $this->json(['category' => $this->formatCategoryResponse($category)]);
    }

    #[Route('', methods: ['POST'])]
    #[IsGranted('ROLE_MANAGER')]
    public function create(Request $request): JsonResponse
    {
        try {
            $data = $this->extractFormData($request);
            $this->validateCategoryData($data);

            $category = new Category();
            $category->setName($data['name']);
            $category->setDescription($data['description']);
            
            if ($request->files->has('image')) {
                $category->setImageFile($request->files->get('image'));
            }
            
            $this->categoryRepository->save($category, true);

            return $this->json([
                'message' => 'Catégorie créée avec succès',
                'category' => $this->formatCategoryResponse($category)
            ], Response::HTTP_CREATED);
        } catch (\InvalidArgumentException $e) {
            return $this->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route('/{id}', methods: ['PUT'])]
    #[IsGranted('ROLE_MANAGER')]
    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $category = $this->categoryRepository->find($id);
            
            if (!$category) {
                return $this->json(['message' => 'Catégorie non trouvée'], Response::HTTP_NOT_FOUND);
            }

            $data = $this->extractFormData($request);
            $this->validateCategoryData($data);

            $category->setName($data['name']);
            $category->setDescription($data['description']);
            
            if ($request->files->has('image')) {
                $category->setImageFile($request->files->get('image'));
            }
            
            $this->categoryRepository->save($category, true);

            return $this->json([
                'message' => 'Catégorie mise à jour avec succès',
                'category' => $this->formatCategoryResponse($category)
            ]);
        } catch (\InvalidArgumentException $e) {
            return $this->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route('/{id}', methods: ['DELETE'])]
    #[IsGranted('ROLE_MANAGER')]
    public function delete(int $id): JsonResponse
    {
        $category = $this->categoryRepository->find($id);
        
        if (!$category) {
            return $this->json(['message' => 'Catégorie non trouvée'], Response::HTTP_NOT_FOUND);
        }

        $this->categoryRepository->remove($category, true);
        return $this->json(['message' => 'Catégorie supprimée avec succès']);
    }
}
