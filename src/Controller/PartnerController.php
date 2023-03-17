<?php

namespace App\Controller;

use App\Entity\Partner;
use App\Repository\PartnerRepository;
use App\Repository\StructureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/partner', name: 'app_partners_controller')]
class PartnerController extends AbstractController
{
    #[Route('/list', name: 'app_partners_list')]
    public function partnersList(
        PartnerRepository $partnerRepository,
        Request $request
    ): Response {
        //$this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');
        $partners = $partnerRepository->findAll();
        var_dump($partners);

        return $this->render('partner/list.html.twig', [
            'partners' => $partners,
        ]);
    }

    #[Route('/search', name: 'app_partners_search')]
    public function partnerSearch(
        Request $request,
        ManagerRegistry $doctrine
    ): Response {
        //$this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');

        $db = $doctrine->getManager()->getConnection();

        if ($request->isMethod('POST') && isset($_POST['find_partner'])) {


            return new JsonResponse($response);
        }

        return $this->render('partner/search.html.twig');
    }

    /*
    Je ne sais pas par quel moyen, mais le paramètre id s'injecte automatiquement
    dans la variable $partner, ce qui m'évite de définir une variable $id et d'ensuite
    faire une requête avec l'id pour récupérer les infos de l'utilisateur.
    */
    #[Route('/{city}', name: 'app_partner_profile')]
    public function partnerProfile(
        $city = null,
        PartnerRepository $partnerRepository,
        StructureRepository $structureRepository,
        Request $request,
        ManagerRegistry $doctrine
    ): Response {
        //$this->denyAccessUnlessGranted('ROLE_PARTNER', null, 'User tried to access a page without having ROLE_PARTNER');

        // Partner permissions        
        if ($request->isMethod('POST')) {
            //Il faut peut-être faire un "find()" et avec l'id du coup car les méthodes ne fonctionnent pas
            $partner = $partnerRepository->findBy(["city" => $city]);

            if (isset($_POST['id'])) {


                $entityManager = $doctrine->getManager();
                $entityManager->persist($partner);
                $entityManager->flush();
                die();
            }

            // Delete partner        
            if (isset($_POST['delete_partner'])) {

                $entityManager = $doctrine->getManager();
                $entityManager->remove($partner);
                $entityManager->flush();

                return $this->redirectToRoute('app_partners_list');
            }
        }

        $db = $doctrine->getManager()->getConnection();
        $partner = $partnerRepository->findBy(["city" => $city]);
        $structures = $structureRepository->findBy(["city" => $city]);

        return $this->render('partner/profile.html.twig', [
            'partner' => $partner,
            'structures' => $structures
        ]);
    }
}
