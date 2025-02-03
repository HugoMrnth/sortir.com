<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class MainController extends AbstractController
{

    #[Route('/', name: "main_home", methods: ["GET"])]
    public function home(): Response
    {
        return $this->render('main/home.html.twig', [
            "hello" => "Bienvenue sur mon site"
        ]);

    }
//
//    #[Route('/about', name: "main_about", methods: ["GET"])]
//    public function about(): Response
//    {
//        return $this->render('main/about.html.twig');
//
//    }
}