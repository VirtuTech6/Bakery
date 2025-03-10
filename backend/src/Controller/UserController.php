<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\EntityManagerInterface;

class UserController extends AbstractController
{
    private $passwordHasher;
    private $entityManager;

    public function __construct(
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $entityManager
    ) {
        $this->passwordHasher = $passwordHasher;
        $this->entityManager = $entityManager;
    }

    #[Route('/api/user/profile', name: 'app_user_profile', methods: ['GET'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function getUserProfile(): JsonResponse
    {
        // Récupère l'utilisateur connecté
        $user = $this->getUser();
        
        if (!$user instanceof User) {
            throw new AccessDeniedException('Accès non autorisé');
        }

        // Prépare les données de l'utilisateur
        $userData = [
            'id' => $user->getId(),
            'firstName' => $user->getFirstName(),
            'lastName' => $user->getLastName(),
            'email' => $user->getEmail(),
            'address' => $user->getAddress(),
            'phone' => $user->getPhone(),
            'role' => $user->getRole(),
            'createdAt' => $user->getCreatedAt()?->format('Y-m-d H:i:s')
        ];

        return $this->json($userData);
    }

    #[Route('/api/user/{id}', name: 'app_user_delete', methods: ['DELETE'])]
    #[IsGranted('ROLE_MANAGER')]
    public function deleteUser(User $user): JsonResponse
    {
        $this->entityManager->remove($user);
        $this->entityManager->flush();

        return $this->json([
            'message' => 'Utilisateur supprimé avec succès'
        ]);
    }

    #[Route('/api/user/me', name: 'app_user_role', methods: ['GET'])]
    public function getUserRole(): JsonResponse
    {
        // Récupère l'utilisateur connecté
        $user = $this->getUser();
        
        if (!$user instanceof User) {
            throw new AccessDeniedException('Accès non autorisé');
        }

        // Prépare le rôle de l'utilisateur
        $userData = [
            'role' => $user->getRole(),
        ];

        return $this->json($userData);
    }

    #[Route('/api/users', name: 'app_users_list', methods: ['GET'])]
    #[IsGranted('ROLE_MANAGER')]
    public function getAllUsers(): JsonResponse
    {
        $users = $this->entityManager
            ->getRepository(User::class)
            ->findAll();

        $usersData = array_map(function (User $user) {
            return [
                'id' => $user->getId(),
                'firstName' => $user->getFirstName(),
                'lastName' => $user->getLastName(),
                'email' => $user->getEmail(),
                'address' => $user->getAddress(),
                'phone' => $user->getPhone(),
                'role' => $user->getRole(),
                'createdAt' => $user->getCreatedAt()?->format('Y-m-d H:i:s')
            ];
        }, $users);

        return $this->json($usersData);
    }

    #[Route('/api/user', name: 'app_user_create', methods: ['POST'])]
    #[IsGranted('ROLE_MANAGER')]
    public function createUser(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        
        // Vérification des champs requis
        $requiredFields = ['email', 'password'];
        foreach ($requiredFields as $field) {
            if (!isset($data[$field]) || empty($data[$field])) {
                return $this->json([
                    'error' => "Le champ '$field' est obligatoire"
                ], 400);
            }
        }

        // Validation basique du format email
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return $this->json([
                'error' => "Le format de l'email n'est pas valide"
            ], 400);
        }

        $user = new User();
        $user->setFirstName($data['firstName'] ?? '');
        $user->setLastName($data['lastName'] ?? '');
        $user->setEmail($data['email']);
        $user->setPassword($this->passwordHasher->hashPassword($user, $data['password']));
        $user->setAddress($data['address'] ?? '');
        $user->setPhone($data['phone'] ?? '');
        $user->setRole($data['role'] ?? 'ROLE_USER');
        $user->setCreatedAt(new \DateTimeImmutable());

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $this->json([
            'message' => 'Utilisateur créé avec succès',
            'id' => $user->getId()
        ], 201);
    }

    #[Route('/api/user/{id}', name: 'app_user_update', methods: ['PUT'])]
    #[IsGranted('ROLE_MANAGER')]
    public function updateUser(User $user, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        // Validation basique du format email si présent
        if (isset($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return $this->json([
                'error' => "Le format de l'email n'est pas valide"
            ], 400);
        }

        // Si un nouveau mot de passe est fourni, le hasher
        if (isset($data['password'])) {
            $data['password'] = $this->passwordHasher->hashPassword($user, $data['password']);
        }

        $userRepository = $this->entityManager->getRepository(User::class);
        $updatedUser = $userRepository->updateUser($user, $data);

        return $this->json([
            'message' => 'Utilisateur modifié avec succès',
            'user' => [
                'id' => $updatedUser->getId(),
                'firstName' => $updatedUser->getFirstName(),
                'lastName' => $updatedUser->getLastName(),
                'email' => $updatedUser->getEmail(),
                'address' => $updatedUser->getAddress(),
                'phone' => $updatedUser->getPhone(),
                'role' => $updatedUser->getRole(),
                'createdAt' => $updatedUser->getCreatedAt()?->format('Y-m-d H:i:s')
            ]
        ]);
    }
}
