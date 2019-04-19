<?php

namespace App\Repository;

use App\Entity\Category;

interface CategoryRepositoryInterface
{
    public function fetchCategories(): array;

    public function insertCategory(Category $category): void;

    public function updateCategory(Category $category): void;
}
