<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Category>
 *
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $criteria = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    /**
     * Crée une nouvelle catégorie dans la base de données
     * @param array $data Les données de la catégorie
     * @return Category
     */
    public function create(array $data): Category
    {
        $category = new Category();
        
        if (isset($data['name'])) {
            $category->setName($data['name']);
        }
        if (isset($data['description'])) {
            $category->setDescription($data['description']);
        }
        if (isset($data['imageFile'])) {
            $category->setImageFile($data['imageFile']);
        }

        $this->getEntityManager()->persist($category);
        $this->getEntityManager()->flush();

        return $category;
    }

    public function remove(Category $category, bool $flush = false): void
    {
        $this->getEntityManager()->remove($category);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Met à jour une catégorie dans la base de données
     * @param Category $category La catégorie à mettre à jour
     * @param array $data Les nouvelles données de la catégorie
     * @return Category
     */
    public function update(Category $category, array $data): Category
    {
        if (isset($data['name'])) {
            $category->setName($data['name']);
        }
        if (isset($data['description'])) {
            $category->setDescription($data['description']);
        }
        if (isset($data['imageFile'])) {
            $category->setImageFile($data['imageFile']);
        }

        $this->getEntityManager()->flush();

        return $category;
    }
}
