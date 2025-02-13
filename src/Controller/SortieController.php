<?php

declare(strict_types=1);

namespace App\Controller;

use App\Data\SearchData;
use App\Form\SearchForm;
use App\Repository\SortieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/sorties')]
class SortieController extends AbstractController
{
    #[Route('/', name: 'sortie_list', methods: ['GET'])]
    public function list(SortieRepository $sortieRepository, Request $request): Response
    {
        $user = $this->getUser();
        //TODO sorties site = site.user && etat != historisé + attention select automatiquement sur site correspondant (affichage)
        //$sorties = $sortieRepository->findBy(['site' => $user->getSite()->getId()]);

        $data = new SearchData();

        $searchForm = $this->createForm(SearchForm::class, $data);
        $searchForm->handleRequest($request);

        $sorties = $sortieRepository->findSearch($data, $user);

        return $this->render('sortie/list.html.twig', [
            'sorties' => $sorties,
            'searchForm' => $searchForm->createView(),
        ]);
    }

    #[Route('/{id}', name: 'sortie_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function showSortie($id, SortieRepository $sortieRepository): Response
    {
        $sortie = $sortieRepository->find($id);
        return $this->render('sortie/show.html.twig', [
            'sortie' => $sortie,
        ]);
    }

}
