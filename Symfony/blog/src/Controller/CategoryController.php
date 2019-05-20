<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{
    /**
    * Show all row from article's entity
    *
    * @Route("/blog/addArticle", name="add_category")
    * @return Response A response instance
    */
    public function add(Request $request, ObjectManager $manager)
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            echo "iamdansif";
            $data = $form->getData();
            dump($data);
            $manager->persist($data);
            $manager->flush();
            
            // $data contient les données du $_POST
            // Faire une recherche dans la BDD avec les infos de $data...
        }
        

        return $this->render(
            '/blog/addArticle.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }
}
