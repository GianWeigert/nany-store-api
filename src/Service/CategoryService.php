<?php

namespace App\Service;

use App\Entity\Category;
use App\Input\CategoryInput;
use App\Service\Interfaces\CategoryServiceInterface;
use App\Repository\Interfaces\CategoryRepositoryInterface;

final class CategoryService implements CategoryServiceInterface
{
    private $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
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

        $this->categoryRepository->insertCategory($category);

        return $category;
    }

    public function edit(CategoryInput $categoryInput, int $id): Category
    {
        $category = $this->categoryRepository->find($id);
        $this->buildCategory($category, $categoryInput);

        $this->categoryRepository->updateCategory($category);

        return $category;
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

