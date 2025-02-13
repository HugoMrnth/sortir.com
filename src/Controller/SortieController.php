<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Lieu;
use App\Entity\Sortie;
use App\Form\ParticipantFormType;
use App\Form\SortieFormType;
use App\Data\SearchData;
use App\Form\SearchForm;
use App\Repository\SortieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class SortieController extends AbstractController
{
    #[Route('/', name: 'sortie_list', methods: ['GET'])]
    public function list(SortieRepository $sortieRepository, Request $request, ValidatorInterface $validator): Response
    {
        $user = $this->getUser();

        $sorties = $sortieRepository->findSortiesList($user);

        $data = new SearchData();

        $searchForm = $this->createForm(SearchForm::class, $data, ['user' => $user]);
        $searchForm->handleRequest($request);

        $errors = $validator->validate($data);

        if ($searchForm->isSubmitted() && $searchForm->isValid() && count($errors) === 0) {
            $sorties = $sortieRepository->findSearch($data, $user);
        }

        return $this->render('sortie/list.html.twig', [
            'sorties' => $sorties,
            'user' => $user,
            'searchForm' => $searchForm->createView(),
            'errors' => $errors,
        ]);
    }
    #[Route('/sorties/lieu/{id}', name: 'sortie_lieu', methods: ['GET'])]
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


    #[Route('/sorties/{id}', name: 'sortie_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function showSortie($id, SortieRepository $sortieRepository): Response
    {
        $sortie = $sortieRepository->find($id);
        return $this->render('sortie/show.html.twig', [
            'sortie' => $sortie,
        ]);
    }

    #[Route('/sorties/create', name: 'sortie_create', methods: ['GET', 'POST'])]
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
