<?php
// src/Controller/CategoryController.php
namespace App\Controller;

use App\Entity\Category;
use App\Entity\Program;
use Doctrine\ORM\Mapping\Id;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
* @Route("/category", name="category_")
*/
class CategoryController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        $categories = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findAll();

    return $this->render('category/index.html.twig', [
        'categories' => $categories ,
     ]);
    }

    /**
     * @Route("/{categoryName}/", methods={"GET"}, name="show")
     */
    public function show(string $categoryName) : Response
    {
        $checkCategory = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findBy(
                ['name' => $categoryName],
            );


            if (empty($checkCategory)) {

                throw $this->createNotFoundException(
                    'Aucune catégorie nommée '.$categoryName
                ) ;
            }

        $programs = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findBy(
                ['category' => $checkCategory[0]->getId()],
            );

        return $this->render('category/show.html.twig', [
            'programs' => $programs,
            'categoryName'=> $categoryName,
        ])
        ;
    }
}