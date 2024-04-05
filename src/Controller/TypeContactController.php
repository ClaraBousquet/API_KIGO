<?php

namespace App\Controller;

use App\Entity\TypeContact;
use App\Form\TypeContactType;
use App\Repository\TypeContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/type/contact')]
class TypeContactController extends AbstractController
{
    #[Route('/', name: 'app_type_contact_index', methods: ['GET'])]
    public function index(TypeContactRepository $typeContactRepository): Response
    {
        return $this->render('type_contact/index.html.twig', [
            'type_contacts' => $typeContactRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_type_contact_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $typeContact = new TypeContact();
        $form = $this->createForm(TypeContactType::class, $typeContact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($typeContact);
            $entityManager->flush();

            return $this->redirectToRoute('app_type_contact_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('type_contact/new.html.twig', [
            'type_contact' => $typeContact,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_type_contact_show', methods: ['GET'])]
    public function show(TypeContact $typeContact): Response
    {
        return $this->render('type_contact/show.html.twig', [
            'type_contact' => $typeContact,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_type_contact_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TypeContact $typeContact, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TypeContactType::class, $typeContact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_type_contact_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('type_contact/edit.html.twig', [
            'type_contact' => $typeContact,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_type_contact_delete', methods: ['POST'])]
    public function delete(Request $request, TypeContact $typeContact, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typeContact->getId(), $request->request->get('_token'))) {
            $entityManager->remove($typeContact);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_type_contact_index', [], Response::HTTP_SEE_OTHER);
    }
}
