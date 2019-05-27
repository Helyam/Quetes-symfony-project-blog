<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Article;
use App\Entity\Category;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ArticleSearchType;

class BlogController extends AbstractController
{
    /**
    * Show all row from article's entity
    *
    * @Route("/", name="blog_index")
    * @return Response A response instance
    */
    public function index(): Response
    {
        $articles = $this->getDoctrine()
          ->getRepository(Article::class)
          ->findAll();
        if (!$articles) {
            throw $this->createNotFoundException(
                'No article found in article\'s table.'
          );
        }

        
        $categories = $this->getDoctrine()
          ->getRepository(Category::class)
          ->findAll();

        /*return $this->render(
            'blog/index.html.twig',
            ['articles' => $articles,
            'categories' => $categories]
        );*/

        $form = $this->createForm(
            ArticleSearchType::class,
            null,
            ['method' => Request::METHOD_GET]
        );
     
        return $this->render(
            'blog/index.html.twig',
            [
            'articles' => $articles,
            'form' => $form->createView(),
            'categories' => $categories
         ]
     );
    }

    /**
     * Getting a article with a formatted slug for title
    *
    * @param string $slug The slugger
    *
    * @Route("/blog/show/{slug<^[a-z0-9-]+$>}",
    *     defaults={"slug" = null},
    *     name="blog_show")
    *  @return Response A response instance
    */
    public function show(?string $slug) : Response
    {
        if (!$slug) {
            throw $this
            ->createNotFoundException('No slug has been sent to find an article in article\'s table.');
        }

        $slug = preg_replace(
            '/-/',
            ' ',
            ucwords(trim(strip_tags($slug)), "-")
        );

        $article = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findOneBy(['title' => mb_strtolower($slug)]);

        if (!$article) {
            throw $this->createNotFoundException(
                'No article with '.$slug.' title, found in article\'s table.'
      );
        }

        return $this->render(
            'blog/show.html.twig',
            [
              'article' => $article,
              'slug' => $slug,
      ]
    );
    }
    
    /**
    * Show all row from article's entity
    *
    * @Route("/blog/category/{name}", name="show_category",
    *     defaults={"name" = "javascript"})
    * @return Response A response instance
    */
    public function showByCategory(Category $categoryName) : Response
    {
        $article = $categoryName->getArticles();
        return $this->render(
            'blog/category.html.twig',
            [
              'articles' => $article,
              'category' => $categoryName
            ]
        );
    }
}
