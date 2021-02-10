<?php


namespace App\Controller;

use App\Entity\Commune;
use App\Entity\Personne;
use App\Entity\Prefecture;
use App\Entity\Region;
use App\Entity\Ville;
use App\Entity\Camp;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="homepage", methods={"GET"})
     * @return Response
     */
    public function index()
    {
        return $this->redirectToRoute('dashboard');
        /*$em = $this->getDoctrine()->getManager();
        $regions = $em->getRepository(Region::class)->findAll();
        $prefectures = $em->getRepository(Prefecture::class)->findAll();
        $communes = $em->getRepository(Commune::class)->findAll();
        $villes = $em->getRepository(Ville::class)->findAll();
        $camps = $em->getRepository(Camp::class)->findAll();
        return $this->render("index.html.twig", [
            "regions"=>$regions,
            "prefectures"=>$prefectures,
            "communes"=>$communes,
            "villes"=>$villes,
            "camps"=>$camps
        ]);*/
    }
    
    /**
     * @Route("/search", name="search", methods={"GET"})
     * @return Response
     */
    public function search()
    {
        $em = $this->getDoctrine()->getManager();
        $regions = $em->getRepository(Region::class)->findAll();
        $prefectures = $em->getRepository(Prefecture::class)->findAll();
        $communes = $em->getRepository(Commune::class)->findAll();
        $villes = $em->getRepository(Ville::class)->findAll();
        $camps = $em->getRepository(Camp::class)->findAll();
        return $this->render("index.html.twig", [
            "regions"=>$regions,
            "prefectures"=>$prefectures,
            "communes"=>$communes,
            "villes"=>$villes,
            "camps"=>$camps
        ]);
    }

    /**
     * @Route("/load-data", name="load_data", methods={"GET"},
     *  options={"expose"=true})
     */
    public function loadData()
    {
        $em = $this->getDoctrine()->getManager();
        $regionEntities = $em->getRepository(Region::class)->findAll();
        $regions = [];
        foreach ($regionEntities as $r){
            $regions[] = $r->toArray();
        }
        $prefectureEntities = $em->getRepository(Prefecture::class)->findAll();
        $prefectures = [];
        foreach ($prefectureEntities as $r){
            $prefectures[] = $r->toArray();
        }
        $communeEntities = $em->getRepository(Commune::class)->findAll();
        $communes = [];
        foreach ($communeEntities as $r){
            $communes[] = $r->toArray();
        }
        $villeEntities = $em->getRepository(Ville::class)->findAll();
        $villes = [];
        foreach ($villeEntities as $r){
            $villes[] = $r->toArray();
        }
        $campEntities = $em->getRepository(Camp::class)->findAll();
        $camps = [];
        foreach ($campEntities as $r){
            $camps[] = $r->toArray();
        }

        return new JsonResponse([
            "status"=>"success",
            "data"=>[
                "regions"=>$regions,
                "prefectures"=>$prefectures,
                "communes"=>$communes,
                "villes"=>$villes,
                "camps"=>$camps
            ]
        ]);
    }

    /**
     * @Route("dashboard", name="dashboard", methods={"GET"})
     */
    public function dashboard()
    {
        return $this->render("dashboard.html.twig");
    }

    /**
     * @param Request $request
     * @return  JsonResponse
     * @Route("search-team", name="search_team", methods={"GET"}, options={"expose"=true})
     */
    public function searchTeam(Request $request, \Symfony\Component\Asset\Packages $assetsManager)
    {
        $response = new JsonResponse();
        try{
            $data = [];
            $req_region = $request->get("region");
            $req_prefecture = $request->get("prefecture");
            $req_commune = $request->get("commune");
            $req_ville = $request->get("ville");
            $req_camp = $request->get("camp");

            $em = $this->getDoctrine()->getManager();
            $personnes = $em->getRepository(Personne::class)->search($req_region,$req_prefecture,$req_commune,$req_ville,$req_camp);
            foreach($personnes as $p){
                $tmp = $p->toArray();
                $tmp["photo"] = $assetsManager->getUrl($this->getParameter("photos_directory").DIRECTORY_SEPARATOR.$p->getPhoto() );
                $data[] = $tmp;

                //$data[] = $p->toArray();
            }
            $response->setData([
                "status"=>"success",
                "data"=>$data
            ]);
        }catch(\Exception $e){
            $response->setData([
                "status"=>"fail",
                "message"=>"Une erreur s'est produite : ".$e->getMessage()
            ]);
        }

        return $response;
    }

}
