<?php

namespace App\Controller;

use App\Entity\Category;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/categories")
 */
class CategoryController extends AbstractController
{
    /**
     * @Route(name="list_categories", methods={"GET"})
     */
    public function listCategories(Request $request): Response
    {
        $categoryRepository = $this->getDoctrine()->getRepository(Category::class);
        $categories = $categoryRepository->fetchCategories();

        return $this->json(
            ['data' => $categories],
            Response::HTTP_OK
        );
    }

    /**
     * @Route(name="create_category", methods={"POST"})
     */
    public function createCategory(Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getEntityManager();
        $requestContent = $request->getContent();
        $requestData = json_decode($requestContent, true);
        
        $name = $requestData['name'];
        $slug = $requestData['slug'];
        $enabled = $requestData['enabled'];

        $category = new Category();
        $category->setName($name);
        $category->setSlug($slug);
        $category->setEnabled($enabled);

        $entityManager->persist($category);
        $entityManager->flush();

        return $this->json(
            ['data' => $category->getId()],
            Response::HTTP_OK
        );
    }

    /**
     * @Route("/{id}", name="edit_category", methods={"PUT"})
     */
    public function editCategory(Request $request, int $id): Response
    {
        $entityManager = $this->getDoctrine()->getEntityManager();
        $categoryRepository = $this->getDoctrine()->getRepository(Category::class);
        $requestContent = $request->getContent();
        $requestData = json_decode($requestContent, true);

        $name = $requestData['name'];
        $slug = $requestData['slug'];
        $enabled = $requestData['enabled'];

        $category = $categoryRepository->find($id);
        $category->setName($name);
        $category->setSlug($slug);
        $category->setEnabled($enabled);

        $entityManager->persist($category);
        $entityManager->flush();

        return $this->json([], Response::HTTP_NO_CONTENT);
    }
}