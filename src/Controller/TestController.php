<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    /**
     * @Route("/article/{id}", name="app_test")
     */
    public function test(Article $article): Response
    {
        return $this->render("base.html.twig", [
            "article" => $article
        ]);
    }

    /**
     * @Route("/", name="app_all")
     */
    public function all(ArticleRepository $articleRepository): Response
    {
        return $this->render("all.html.twig", [
            "articles" => $articleRepository->findAll()
        ]);
    }
}
