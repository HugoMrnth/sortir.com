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
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/sorties')]
class SortieController extends AbstractController
{
    #[Route('/', name: 'sortie_list', methods: ['GET'])]
    public function list(SortieRepository $sortieRepository, Request $request, ValidatorInterface $validator): Response
    {
        $user = $this->getUser();
        //TODO sorties site = site.user && etat != historisé + attention select automatiquement sur site correspondant (affichage)
        $sorties = $sortieRepository->findBy(['site' => $user->getSite()->getId()]);

        $data = new SearchData();

        $searchForm = $this->createForm(SearchForm::class, $data, ['user' => $user]);
        $searchForm->handleRequest($request);

        $errors = $validator->validate($data);

        if ($searchForm->isSubmitted() && $searchForm->isValid() && count($errors) === 0) {
            $sorties = $sortieRepository->findSearch($data, $user);
        }

        return $this->render('sortie/list.html.twig', [
            'sorties' => $sorties,
            'searchForm' => $searchForm->createView(),
            'errors' => $errors,
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
