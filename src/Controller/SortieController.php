<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\SortieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/sorties')]
class SortieController extends AbstractController
{
    #[Route('/', name: 'sortie_list', methods: ['GET'])]
    public function list(SortieRepository $sortieRepository): Response
    {
        //TODO appeler requête pour trouver toutes les sorties par état "ouverte" (revoir la doc client)
        //$sorties = $sortieRepository->findBy(['no_etat' => 2]);
        $sorties = $sortieRepository->findAll();

        //TODO passer les sorties à twig
        return $this->render('sortie/list.html.twig', [
            'sorties' => $sorties
        ]);
    }
}
