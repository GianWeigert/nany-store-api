<?php

namespace App\Service;

use App\Entity\Category;
use App\Input\CategoryInput;
use Doctrine\ORM\EntityManagerInterface;

class CategoryService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->categoryRepository = $entityManager->getRepository(Category::class);
    }

    public function getAll(): array
    {
        $categories = $this->categoryRepository->fetchCategories();

        return $categories;
    }

    public function getById(int $id): Category
    {
        $category = $this->categoryRepository->find($id);

        return $category;
    }

    public function create(CategoryInput $categoryInput): Category
    {
        $category = $this->getCategory();
        $this->buildCategory($category, $categoryInput);

        $this->entityManager->persist($category);
        $this->entityManager->flush();

        return $category;
    }

    public function edit(CategoryInput $categoryInput, int $id): void
    {
        $category = $this->categoryRepository->find($id);
        $this->buildCategory($category, $categoryInput);

        $this->entityManager->persist($category);
        $this->entityManager->flush();
    }

    private function getCategory(): Category
    {
        return new Category();
    }

    private function buildCategory(Category $category, CategoryInput $categoryInput): Category
    {
        $category->setName($categoryInput->getName());
        $category->setSlug($categoryInput->getSlug());
        $category->setEnabled($categoryInput->getEnabled());

        return $category;
    }
}
