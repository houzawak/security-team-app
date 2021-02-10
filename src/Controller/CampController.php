<?php

namespace App\Controller;

use App\Entity\Camp;
use App\Entity\Commune;
use App\Entity\Prefecture;
use App\Entity\Region;
use App\Entity\Ville;
use App\Form\CampType;
use App\Repository\CampRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/camp")
 */
class CampController extends AbstractController
{
    /**
     * @Route("/", name="camp_index", methods={"GET"})
     */
    public function index(CampRepository $campRepository): Response
    {
        return $this->render('camp/index.html.twig', [
            'camps' => $campRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="camp_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $camp = new Camp();
        $form = $this->createForm(CampType::class, $camp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($camp);
            $entityManager->flush();

            return $this->redirectToRoute('camp_index');
        }

        $em = $this->getDoctrine()->getManager();
        $regions = $em->getRepository(Region::class)->findAll();
        $prefectures = $em->getRepository(Prefecture::class)->findAll();
        $communes = $em->getRepository(Commune::class)->findAll();
        $villes = $em->getRepository(Ville::class)->findAll();

        return $this->render('camp/new.html.twig', [
            'camp' => $camp,
            'form' => $form->createView(),
            'regions' => $regions,
            "prefectures"=>$prefectures,
            "communes"=>$communes,
            "villes"=>$villes,
            'page_title'=>'Enregistrer un Camp ou un poste'
        ]);
    }

    /**
     * @Route("/{code}", name="camp_show", methods={"GET"})
     */
    public function show(Camp $camp): Response
    {
        return $this->render('camp/show.html.twig', [
            'camp' => $camp,
        ]);
    }

    /**
     * @Route("/{code}/edit", name="camp_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Camp $camp): Response
    {
        $form = $this->createForm(CampType::class, $camp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('camp_index');
        }

        $em = $this->getDoctrine()->getManager();
        $regions = $em->getRepository(Region::class)->findAll();
        $prefectures = $em->getRepository(Prefecture::class)->findAll();
        $communes = $em->getRepository(Commune::class)->findAll();
        $villes = $em->getRepository(Ville::class)->findAll();

        return $this->render('camp/edit.html.twig', [
            'camp' => $camp,
            'form' => $form->createView(),
            "regions"=>$regions,
            "prefectures"=>$prefectures,
            "communes"=>$communes,
            "villes"=>$villes
        ]);
    }

    /**
     * @Route("/{code}", name="camp_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Camp $camp): Response
    {
        if ($this->isCsrfTokenValid('delete'.$camp->getCode(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($camp);
            $entityManager->flush();
        }

        return $this->redirectToRoute('camp_index');
    }
}
