<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;



class ArticleController extends AbstractController
{


    #[Route(path: '/article', name: 'article_index')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $articles = $entityManager->getRepository(Article::class)->findAll();
        return $this->render('article/index.html.twig', [
            'articles' => $articles,
        ]);
    }

    #[Route(path: '/article/{id}', name: 'article_show')]
    public function show(EntityManagerInterface $entityManager, int $id): Response
    {
        $article = $entityManager->getRepository(Article::class)->find($id);
    
        if (!$article) {
            throw $this->createNotFoundException(
                'No article found for id '.$id
            );
        }
    
        return $this->render('article/show.html.twig', [
            'article' => $article,
            'controller_name' => 'ArticleController',
        ]);
    }
    
    #[Route(path: '/article/{slug}', name: 'article_show')]
    public function showSlug(string $slug, EntityManagerInterface $entityManager): Response
    {
        $article = $entityManager->getRepository(Article::class)->findOneBy(['slug' => $slug]);

        if (!$article) {
            throw $this->createNotFoundException('No article found for slug '.$slug);
        }

        return $this->render('article/show.html.twig', [
            'article' => $article,
        ]);
    }

    
}

