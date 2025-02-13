<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Lieu;
use App\Entity\Sortie;
use App\Form\ParticipantFormType;
use App\Form\SortieFormType;
use App\Repository\SortieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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
    #[Route('/lieu/{id}', name: 'sortie_lieu', methods: ['GET'])]
    public function getLieuData(Lieu $lieu): JsonResponse
    {
        return new JsonResponse([
            'ville' => $lieu->getVille()->getNom(),
            'cp' => $lieu->getVille()->getCodePostal(),
            'rue' => $lieu->getRue(),
            'latitude' => $lieu->getLatitude(),
            'longitude' => $lieu->getLongitude(),
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

    #[Route('/create', name: 'sortie_create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $sortie = new Sortie();
        $form = $this->createForm(SortieFormType::class, $sortie);
        $form->handleRequest($request);

        dump($form->getData());
        if ($form->isSubmitted() && $form->isValid()) {
        }

            return $this->render('sortie/create.html.twig', [
            'form' => $form,
        ]);
    }
}
