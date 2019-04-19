<?php

namespace App\Repository;

use App\Entity\Category;
use Symfony\Bridge\Doctrine\RegistryInterface;
use App\Repository\CategoryRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

final class CategoryRepository extends ServiceEntityRepository implements CategoryRepositoryInterface
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Category::class);
    }

    public function fetchCategories(): array
    {
        $qb =  $this->createQueryBuilder('c')
            ->orderBy('c.id', 'DESC')
            ->setMaxResults(10)
            ->getQuery();

        return $qb->getArrayResult();
    }

    public function insertCategory(Category $category): void
    {
        $this->_em->persist($category);
        $this->_em->flush();
    }

    public function updateCategory(Category $category): void
    {
        $this->_em->persist($category);
        $this->_em->flush();
    }
}

