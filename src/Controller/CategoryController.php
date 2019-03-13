<?php

namespace App\Controller;

use App\Entity\Category;
use App\Input\CategoryInput;
use App\Service\CategoryService;
use Symfony\Component\Validator\Validation;
use App\Validation\CreateCategoryValidation;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/categories")
 */
class CategoryController extends AbstractController
{
    private $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * @Route(name="list_categories", methods={"GET"})
     */
    public function listCategories(Request $request): Response
    {
        $categories = $this->categoryService->getAllCategories();

        return $this->json(
            ['data' => $categories],
            Response::HTTP_OK
        );
    }

    /**
     * @Route("/{id}", name="get_category", methods={"GET"})
     */
    public function getCategory(Request $request, int $id): Response
    {
        $categoryRepository = $this->getDoctrine()->getRepository(Category::class);
        $category = $categoryRepository->find($id);

        $data = [
            'name' => $category->getName(),
            'slug' => $category->getSlug(),
            'enabeld' => $category->isEnabled(),
            'createdAt' => $category->getCreatedAt(),
            'updatedAt' => $category->getUpdatedAt()
        ];

        return $this->json(
            ['data' => $data],
            Response::HTTP_OK
        );
    }

    /**
     * @Route(name="create_category", methods={"POST"})
     */
    public function createCategory(Request $request): Response
    {
        $requestContent = $request->getContent();
        $requestData = json_decode($requestContent, true);

        $validator = Validation::createValidator();
        $validation = new CreateCategoryValidation($validator);

        if (!$validation->isValid($requestData)) {
            $data['data']['error'] = $validation->getMessages();

            return $this->json(
                $data,
                Response::HTTP_BAD_REQUEST
            );
        }

        $categoryInput = new CategoryInput($requestData);
        $category = $this->categoryService->create($categoryInput);

        return $this->json(
            ['data' => $category->getId()],
            Response::HTTP_CREATED
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