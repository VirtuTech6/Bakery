<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[Route('/api', name: 'api_')]
class SecurityController extends AbstractController
{
    #[Route('/login', name: 'login', methods: ['POST'])]
    public function login(): JsonResponse
    {
        // Cette méthode reste vide car le JWT est géré par LexikJWTAuthenticationBundle
        // La logique d'authentification est gérée automatiquement
        return $this->json(['message' => 'Cette route est gérée par le firewall JWT']);
    }

    #[Route('/register', name: 'register', methods: ['POST'])]
    public function register(
        Request $request,
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $entityManager
    ): JsonResponse {
        $content = $request->getContent();
        $data = json_decode($content, true);

        // Vérification si le JSON est valide
        if (json_last_error() !== JSON_ERROR_NONE) {
            return $this->json([
                'error' => 'JSON invalide'
            ], Response::HTTP_BAD_REQUEST);
        }

        // Debug du contenu reçu
        error_log('Contenu reçu : ' . print_r($data, true));

        // Vérification des champs requis
        $requiredFields = ['email', 'password', 'firstName', 'lastName', 'address', 'phone'];
        foreach ($requiredFields as $field) {
            if (!isset($data[$field]) || empty($data[$field])) {
                return $this->json([
                    'error' => "Le champ $field est obligatoire"
                ], Response::HTTP_BAD_REQUEST);
            }
        }

        $user = new User();
        $user->setEmail($data['email']);
        $user->setFirstName($data['firstName']);
        $user->setLastName($data['lastName']);
        $user->setAddress($data['address']);
        $user->setPhone($data['phone']);
        $user->setRole('ROLE_USER');
        $user->setCreatedAt(new \DateTimeImmutable());

        // Hashage du mot de passe
        $hashedPassword = $passwordHasher->hashPassword($user, $data['password']);
        $user->setPassword($hashedPassword);

        $entityManager->persist($user);
        $entityManager->flush();

        return $this->json([
            'message' => 'Utilisateur créé avec succès'
        ], Response::HTTP_CREATED);
    }
}