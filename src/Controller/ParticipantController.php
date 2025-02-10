<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Form\ParticipantFormType;
use App\Repository\ParticipantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/profile')]
class ParticipantController extends AbstractController
{
    #[Route('/{id}', name: 'participant_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function showProfile($id, ParticipantRepository $participantRepository): Response
    {
        $participant = $participantRepository->find($id);
        return $this->render('participant/show.html.twig', [
            'participant' => $participant,
        ]);
    }

    #[Route('/{id}/edit', name: 'participant_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, UserPasswordHasherInterface $userPasswordHasher, Participant $participant, EntityManagerInterface $em): Response
    {
        if ($participant !== $this->getUser()) {
            return $this->redirectToRoute('participant_show', ['id' => $participant->getId()]);
        }
        $participantForm = $this->createForm(ParticipantFormType::class, $participant);
        $participantForm->handleRequest($request);


        if ($participantForm->isSubmitted() && $participantForm->isValid()) {
            if ($participantForm->get('password')->getData() != '') {
                if ($participantForm->get('password')->getData() !== $participantForm->get('confirm')->getData()) {
                    $participantForm->get('confirm')->addError(new FormError('Les deux mots de passe ne correspondent pas'));
                    return $this->render('participant/edit.html.twig', [
                        'form' => $participantForm
                    ]);
                } else {
                    $plainPassword = $participantForm->get('password')->getData();
                    $participant->setPassword($userPasswordHasher->hashPassword($participant, $plainPassword));
                }
            }

            $em->persist($participant);
            $em->flush();
            $this->addFlash('success', 'Participant modifié avec succès.');
            return $this->redirectToRoute('participant_edit', ['id' => $participant->getId()]);
        }
        return $this->render('participant/edit.html.twig', [
            'form' => $participantForm
        ]);
    }


}