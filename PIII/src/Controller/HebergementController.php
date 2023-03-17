<?php

namespace App\Controller;

use App\Data\SearchData;
use App\Entity\Hebergement;
use App\Form\HebergementType;
use App\Form\SearchFormType;
use App\Repository\HebergementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/hebergement")
 */
class HebergementController extends AbstractController
{
    /**
     * @Route("/", name="app_hebergement_index", methods={"GET"})
     */
    public function index(HebergementRepository $hebergementRepository,Request $request): Response
    {$data = new SearchData();
        $form = $this->createForm(SearchFormType::class, $data);

        $form->handleRequest($request);

        $Hebergement=$hebergementRepository ->findSearch($data);
        return $this->render('hebergement/index.html.twig', [
            'hebergements' => $Hebergement,'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/new", name="app_hebergement_new", methods={"GET", "POST"})
     */
    public function new(Request $request, HebergementRepository $hebergementRepository): Response
    {
        $hebergement = new Hebergement();
        $form = $this->createForm(HebergementType::class, $hebergement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hebergementRepository->add($hebergement);
            return $this->redirectToRoute('app_hebergement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('hebergement/new.html.twig', [
            'hebergement' => $hebergement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_hebergement_show", methods={"GET"})
     */
    public function show(Hebergement $hebergement): Response
    {
        return $this->render('hebergement/show.html.twig', [
            'hebergement' => $hebergement,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_hebergement_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Hebergement $hebergement, HebergementRepository $hebergementRepository): Response
    {
        $form = $this->createForm(HebergementType::class, $hebergement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hebergementRepository->add($hebergement);
            return $this->redirectToRoute('app_hebergement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('hebergement/edit.html.twig', [
            'hebergement' => $hebergement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_hebergement_delete", methods={"POST"})
     */
    public function delete(Request $request, Hebergement $hebergement, HebergementRepository $hebergementRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$hebergement->getId(), $request->request->get('_token'))) {
            $hebergementRepository->remove($hebergement);
        }

        return $this->redirectToRoute('app_hebergement_index', [], Response::HTTP_SEE_OTHER);
    }
}
