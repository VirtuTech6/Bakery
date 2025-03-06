<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Crée un nouvel utilisateur
     */
    public function createUser(
        string $firstName,
        string $lastName,
        string $email,
        string $password,
        string $address,
        string $phone,
        string $role = 'ROLE_USER'
    ): User {
        $user = new User();
        $user->setFirstName($firstName)
             ->setLastName($lastName)
             ->setEmail($email)
             ->setPassword($password)
             ->setAddress($address)
             ->setPhone($phone)
             ->setRole($role)
             ->setCreatedAt(new \DateTimeImmutable());

        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();

        return $user;
    }

    /**
     * Supprime un utilisateur
     */
    public function deleteUser(User $user): void
    {
        $this->getEntityManager()->remove($user);
        $this->getEntityManager()->flush();
    }

    /**
     * Modifie un utilisateur
     */
    public function updateUser(User $user, array $data): User
    {
        if (isset($data['firstName'])) {
            $user->setFirstName($data['firstName']);
        }
        if (isset($data['lastName'])) {
            $user->setLastName($data['lastName']);
        }
        if (isset($data['email'])) {
            $user->setEmail($data['email']);
        }
        if (isset($data['password'])) {
            $user->setPassword($data['password']);
        }
        if (isset($data['address'])) {
            $user->setAddress($data['address']);
        }
        if (isset($data['phone'])) {
            $user->setPhone($data['phone']);
        }
        if (isset($data['role'])) {
            $user->setRole($data['role']);
        }

        $this->getEntityManager()->flush();

        return $user;
    }
}