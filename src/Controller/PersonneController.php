<?php

namespace App\Controller;

use App\Entity\Personne;
use App\Entity\Region;
use App\Entity\Prefecture;
use App\Entity\Commune;
use App\Entity\Ville;
use App\Entity\Camp;
use App\Form\PersonneType;
use App\Repository\PersonneRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @Route("/personne")
 */
class PersonneController extends AbstractController
{
    /**
     * @Route("/", name="personne_index", methods={"GET"})
     */
    public function index(PersonneRepository $personneRepository): Response
    {
        return $this->render('personne/index.html.twig', [
            'personnes' => $personneRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="personne_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $personne = new Personne();
        $form = $this->createForm(PersonneType::class, $personne);
        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $brochureFile */
            $photoFile = $form->get('photo')->getData();
            if ($photoFile) {
                $originalFilename = pathinfo($photoFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$photoFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $photoFile->move(
                        $this->getParameter('photos_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    
                }
                $personne->setPhoto($newFilename);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($personne);
            $entityManager->flush();

            return $this->redirectToRoute('personne_index');
        }

        
        $regions = $em->getRepository(Region::class)->findAll();
        $prefectures = $em->getRepository(Prefecture::class)->findAll();
        $communes = $em->getRepository(Commune::class)->findAll();
        $villes = $em->getRepository(Ville::class)->findAll();
        $camps = $em->getRepository(Camp::class)->findAll();

        return $this->render('personne/new.html.twig', [
            'personne' => $personne,
            'form' => $form->createView(),
            'page_title'=>'Enregistrer une Personne/Agent',
            "regions"=>$regions,
            "prefectures"=>$prefectures,
            "communes"=>$communes,
            "villes"=>$villes,
            "camps"=>$camps
        ]);
    }

    /**
     * @Route("/{id}", name="personne_show", methods={"GET"})
     */
    public function show(Personne $personne): Response
    {
        return $this->render('personne/show.html.twig', [
            'personne' => $personne,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="personne_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Personne $personne): Response
    {
        $form = $this->createForm(PersonneType::class, $personne);
        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $brochureFile */
            $photoFile = $form->get('photo')->getData();
            if ($photoFile) {
                $originalFilename = pathinfo($photoFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$photoFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $photoFile->move(
                        $this->getParameter('photos_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    
                }
                $personne->setPhoto($newFilename);
            }

            $em->flush();

            return $this->redirectToRoute('personne_index');
        }

        $regions = $em->getRepository(Region::class)->findAll();
        $prefectures = $em->getRepository(Prefecture::class)->findAll();
        $communes = $em->getRepository(Commune::class)->findAll();
        $villes = $em->getRepository(Ville::class)->findAll();
        $camps = $em->getRepository(Camp::class)->findAll();

        return $this->render('personne/edit.html.twig', [
            'personne' => $personne,
            'form' => $form->createView(),
            'page_title'=>'Modifier les informations une Personne/Agent',
            "regions"=>$regions,
            "prefectures"=>$prefectures,
            "communes"=>$communes,
            "villes"=>$villes,
            "camps"=>$camps
        ]);
    }

    /**
     * @Route("/{id}", name="personne_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Personne $personne): Response
    {
        if ($this->isCsrfTokenValid('delete'.$personne->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($personne);
            $entityManager->flush();
        }

        return $this->redirectToRoute('personne_index');
    }
}
