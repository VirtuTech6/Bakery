<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    /**
     * @return Product[]
     */
    public function findAll(): array
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Trouve un produit par son ID
     * @return Product|null
     */
    public function findOneById(int $id): ?Product
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }
    /**
     * Supprime un produit de la base de données
     * @param Product $product Le produit à supprimer
     * @param bool $flush Si true, exécute immédiatement la requête
     * @return void
     */
    public function remove(Product $product, bool $flush = false): void
    {
        $this->getEntityManager()->remove($product);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Crée un nouveau produit dans la base de données
     * @param array $data Les données du produit
     * @return Product
     */
    public function create(array $data): Product
    {
        $product = new Product();
        
        if (isset($data['name'])) {
            $product->setName($data['name']);
        }
        if (isset($data['description'])) {
            $product->setDescription($data['description']);
        }
        if (isset($data['category'])) {
            $product->setCategory($data['category']);
        }
        if (isset($data['price'])) {
            $product->setPrice($data['price']);
        }
        if (isset($data['stock'])) {
            $product->setStock($data['stock']);
        }
        if (isset($data['weight'])) {
            $product->setWeight($data['weight']);
        }
        if (isset($data['ingredients'])) {
            $product->setIngredients($data['ingredients']);
        }
        if (isset($data['imageFile'])) {
            $product->setImageFile($data['imageFile']);
        }

        $this->getEntityManager()->persist($product);
        $this->getEntityManager()->flush();

        return $product;
    }

    /**
     * Met à jour un produit dans la base de données
     * @param Product $product Le produit à mettre à jour
     * @param array $data Les nouvelles données du produit
     * @return Product
     */
    public function update(Product $product, array $data): Product
    {
        if (isset($data['name'])) {
            $product->setName($data['name']);
        }
        if (isset($data['description'])) {
            $product->setDescription($data['description']);
        }
        if (isset($data['category'])) {
            $product->setCategory($data['category']);
        }
        if (isset($data['price'])) {
            $product->setPrice($data['price']);
        }
        if (isset($data['stock'])) {
            $product->setStock($data['stock']);
        }
        if (isset($data['weight'])) {
            $product->setWeight($data['weight']);
        }
        if (isset($data['ingredients'])) {
            $product->setIngredients($data['ingredients']);
        }
        if (isset($data['imageFile'])) {
            $product->setImageFile($data['imageFile']);
        }

        $this->getEntityManager()->flush();

        return $product;
    }

    /**
     * Sauvegarde un produit dans la base de données
     * @param Product $product Le produit à sauvegarder
     * @param bool $flush Si true, exécute immédiatement la requête
     * @return void
     */
    public function save(Product $product, bool $flush = false): void
    {
        $this->getEntityManager()->persist($product);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
