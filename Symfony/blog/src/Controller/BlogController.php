<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog_index")
    */

    public function index()
    {
        return $this->render('blog/index.html.twig', [
            'owner' => 'Helyam',
            ]);
    }

    /**
   * @Route("/blog/show/{slug}", requirements={"slug"="[a-z0-9\-]+"}, defaults={"slug"="Article sans titre"}, name="blog_slug")
   */
    public function show($slug)
    {
        $Replace = str_replace("-", " ", $slug);
        $Replace = ucwords($Replace);
        return $this->render('blog/show.html.twig', ["show" => $Replace]);
    }
}
