<?php

namespace App\Repository;

use App\Entity\Category;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class CategoryRepository extends ServiceEntityRepository
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
}
