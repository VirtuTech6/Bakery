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

    #[Route('', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $categories = $this->categoryRepository->findAll();
        
        $categoriesData = array_map(function($category) {
            return [
                'id' => $category->getId(),
                'name' => $category->getName(),
                'description' => $category->getDescription(),
                'imageName' => $category->getImageName(),
                'imageUrl' => $category->getImageName() ? '/images/categories/' . $category->getImageName() : null
            ];
        }, $categories);

        return $this->json($categoriesData);
    }

    #[Route('/{id}', methods: ['GET'])]
    #[IsGranted('ROLE_MANAGER')]
    public function show(int $id): JsonResponse
    {
        $category = $this->categoryRepository->find($id);

        if (!$category) {
            return $this->json(['message' => 'Catégorie non trouvée'], Response::HTTP_NOT_FOUND);
        }

        $categoryData = [
            'id' => $category->getId(),
            'name' => $category->getName(),
            'description' => $category->getDescription(),
            'imageName' => $category->getImageName(),
            'imageUrl' => $category->getImageName() ? '/images/categories/' . $category->getImageName() : null
        ];

        return $this->json($categoryData);
    }

    #[Route('', methods: ['POST'])]
    #[IsGranted('ROLE_MANAGER')]
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        
        if ($request->files->has('image')) {
            $data['imageFile'] = $request->files->get('image');
        }

        $category = $this->categoryRepository->create($data);

        return $this->json($category, Response::HTTP_CREATED);
    }

    #[Route('/{id}', methods: ['PUT'])]
    #[IsGranted('ROLE_MANAGER')]
    public function update(Request $request, int $id): JsonResponse
    {
        $category = $this->categoryRepository->find($id);
        
        if (!$category) {
            return $this->json(['message' => 'Catégorie non trouvée'], Response::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);
        
        if ($request->files->has('image')) {
            $data['imageFile'] = $request->files->get('image');
        }

        $category = $this->categoryRepository->update($category, $data);

        return $this->json($category);
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

        return $this->json(null, Response::HTTP_NO_CONTENT);
    }
}
