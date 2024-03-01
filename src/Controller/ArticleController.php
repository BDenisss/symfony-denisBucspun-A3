<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ArticleController extends AbstractController
{


    #[Route(path: '/', name: 'article_index')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $articles = $entityManager->getRepository(Article::class)->findAll();
        return $this->render('article/index.html.twig', [
            'articles' => $articles,
        ]);
    }

    
    #[Route(path: '/article/{slug}', name: 'article_show_by_slug')]
    public function showSlug(string $slug, Request $request, EntityManagerInterface $entityManager): Response
    {
        $article = $entityManager->getRepository(Article::class)->findOneBy(['slug' => $slug]);
    
        if (!$article) {
            throw $this->createNotFoundException('No article found for slug '.$slug);
        }
    
        $editForm = $this->createForm(ArticleType::class, $article);
        $editForm->handleRequest($request);
    
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('article_show_by_slug', ['slug' => $article->getSlug()]);
        }
    
        return $this->render('article/show.html.twig', [
            'article' => $article,
            'edit_form' => $editForm->createView(),
        ]);
    }
    

    #[Route('/article', name: 'article_index', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $articles = $entityManager->getRepository(Article::class)->findAll();

        $article = new Article();
        $createForm = $this->createForm(ArticleType::class, $article);
        $createForm->handleRequest($request);
    
        if ($createForm->isSubmitted() && $createForm->isValid()) {
            $entityManager->persist($article);
            $entityManager->flush();
    
            return $this->redirectToRoute('article_index');
        }
    
        return $this->render('article/index.html.twig', [
            'articles' => $articles,
            'create_form' => $createForm->createView(),
        ]);
    }

    

    #[Route('article/edit/{id}', name: 'article_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Article $article, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('article_index');
        }

        return $this->render('article/edit.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }






    #[Route('/article/delete/{id}', name: 'article_delete', methods: ['POST'])]
    public function delete(Request $request, $id, EntityManagerInterface $entityManager): Response
    {
        $article = $entityManager->getRepository(Article::class)->find($id);

        if (!$article) {
            throw $this->createNotFoundException('No article found for id '.$id);
        }

        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            $entityManager->remove($article);
            $entityManager->flush();
        }

        return $this->redirectToRoute('article_index');
    }




    
}

