<?php

namespace App\Service;

use App\Entity\Category;
use App\Input\CategoryInput;

interface CategoryServiceInterface
{
    public function getAll(): array;

    public function getById(int $id): Category;

    public function create(CategoryInput $categoryInput): Category;

    public function edit(CategoryInput $categoryInput, int $id): Category;
}
