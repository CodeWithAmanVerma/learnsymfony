<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    /**
     * @Route("/user/dashboard", name="front_dashboard")
     */
    public function index(PostRepository $postRepository): Response
    {
        $posts = $postRepository->findBy([
            'post_author' => $this->getUser()
        ]);

        return $this->render('frontend/user/dashboard.html.twig', [
            'posts' => $posts
        ]);
    }

    /**
     * @Route("/user/profile", name="front_profile")
     */
    public function profile(PostRepository $postRepository): Response
    {
        $posts = $postRepository->findBy([
            'post_author' => $this->getUser()
        ]);

        return $this->render('frontend/user/dashboard.html.twig', [
            'posts' => $posts
        ]);
    }
}
