<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Route("/contact", name="contact")
     * @Route("/{slug}-{id}", name="home_get_post")
     * @Route("/login", name="login")
     */
    public function index(): Response
    {
        return $this->render('index.html.twig');
    }
}
