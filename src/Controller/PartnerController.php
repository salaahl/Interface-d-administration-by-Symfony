<?php

namespace App\Controller;

use App\Entity\FitnesspPartenaire;
use App\Repository\FitnesspPartenaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/partner', name: 'app_partners_controller')]
class PartnerController extends AbstractController
{
    #[Route('/', name: 'app_partners')]
    public function partnersList(FitnesspPartenaireRepository $partnerRepository, Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');

        $stmt = $partnerRepository->findAll();

        $partners = [];
        $city = [];
        $mail = [];
        $rights_level = [];
        $number_structures = [];

        foreach($stmt as $partner)
        {   
            $city[] = htmlspecialchars($partner->getNom());
            $mail[] = htmlspecialchars($partner->getMail());
            $rights_level[] = htmlspecialchars($partner->getNiveauDroits());
            $number_structures[] = htmlspecialchars($partner->getNombreDeStructures());
        }

        $partners['city'] = $city;
        $partners['mail'] = $mail;
        $partners['rights_level'] = $rights_level;
        $partners['number_structures'] = $number_structures;


        return $this->render('partner/p_list.html.twig', [
            'partners' => $partners,
        ]);
    }

    #[Route('/find', name: 'app_partners_find')]
    public function partnersFind(FitnesspPartenaireRepository $partnerRepository,
    Request $request,
    ManagerRegistry $doctrine): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');

        $db = $doctrine->getManager()->getConnection();

        if ($request->isMethod('POST') && isset($_POST['find_partner'])) {
            $str = (string) trim($_POST['find_partner']);

            $reponse = [];

            $city = [];
            $mail = [];
            $rights_level = [];
            $number_structures = [];

            // Peut aussi s'écrire : WHERE nom LIKE ? || '%'
            $partnersFound = $db
            ->prepare(
                "SELECT nom, mail, niveau_droits, nombre_de_structures
                FROM fitnessp_partenaire
                WHERE nom LIKE CONCAT(?, '%')
                LIMIT 3"
            )
            ->executeQuery([$str])
            ->fetchAllAssociative();

            foreach($partnersFound as $partner)
            {
                $city[] = htmlspecialchars($partner['nom']);
                $mail[] = htmlspecialchars($partner['mail']);
                $rights_level[] = htmlspecialchars($partner['niveau_droits']);
                $number_structures[] = htmlspecialchars($partner['nombre_de_structures']);
            }

            $reponse['city'] = $city;
            $reponse['mail'] = $mail;
            $reponse['rights_level'] = $rights_level;
            $reponse['number_structures'] = $number_structures;

            return new JsonResponse($reponse);
        }

        return $this->render('partner/p_find.html.twig', [
            'partners' => 'return',
        ]);
    }

    /*
    Je ne sais pas par quel moyen, mais le paramètre id s'injecte automatiquement
    dans la variable $partner, ce qui m'évite de définir une variable $id et d'ensuite
    faire une requête avec l'id pour récupérer les infos de l'utilisateur.
    */
    #[Route('/{id}', name: 'app_partner_profile')]
    public function partnerProfile(
        FitnesspPartenaire $partner = null,
        Request $request,
        ManagerRegistry $doctrine
        ): Response
    {
        $this->denyAccessUnlessGranted('ROLE_PARTNER', null, 'User tried to access a page without having ROLE_PARTNER');

        // Partner permissions        
        if ($request->isMethod('POST') && isset($_POST['id'])) {
            
            $statut = $_POST['statut_toggle'] == 'true' ? 1 : 0;
            $perm ='';

            if($_POST['id'] == 'perm_boissons') {
                $partner->setPermBoissons($statut);
                $perm ='boissons';
            } else if($_POST['id'] == 'perm_planning') {
                $partner->setPermPlanning($statut);
                $perm ='planning';
            } else if($_POST['id'] == 'perm_newsletter') {
                $partner->setPermNewsletter($statut);
                $perm ='newsletter';
            } else if($_POST['id'] == 'statut_partner') {
                $partner->setNiveauDroits(
                    $_POST['statut_toggle'] == 'true' ? 2 : 0
                );
                $perm ='statut du partenaire';
            }

            $entityManager = $doctrine->getManager();
            $entityManager->persist($partner);
            $entityManager->flush();

            return new Response('La permission "'.$perm.'" a bien été modifiée.');
        }

        // Delete partner        
        if ($request->isMethod('POST') && isset($_POST['delete_partner'])) {
            
            $entityManager = $doctrine->getManager();
            $entityManager->remove($partner);
            $entityManager->flush();

            return $this->redirectToRoute('app_partners_controllerapp_partners');
        }

        // Partner strutures query
        $db = $doctrine->getManager()->getConnection();
        $structures = [];
        $s_adresse = [];
        $s_mail = [];
        $s_mail_partenaire = [];

        $stmt = $db
            ->prepare(
                "SELECT adresse, s.mail, mail_partenaire
                FROM FitnessP_Structure s
                JOIN FitnessP_Partenaire p
                ON s.mail_partenaire = p.mail
                WHERE s.mail_partenaire = ?"
            )
            ->executeQuery([$partner->getMail()])
            ->fetchAllAssociative();

        foreach($stmt as $structure)
        {
            $s_adresse[] = htmlspecialchars($structure['adresse']);
            $s_mail[] = htmlspecialchars($structure['mail']);
            $s_mail_partenaire[] = htmlspecialchars($structure['mail_partenaire']);
        }

        $structures['address'] = $s_adresse;
        $structures['mail'] = $s_mail;
        $structures['mail_partenaire'] = $s_mail_partenaire;

        return $this->render('partner/p_profile.html.twig', [
            'nom' => htmlspecialchars($partner->getNom()),
            'mail' => htmlspecialchars($partner->getMail()),
            'niveauDroits' => htmlspecialchars($partner->getNiveauDroits()),
            'permBoissons' => htmlspecialchars($partner->getPermBoissons()),
            'permPlanning' => htmlspecialchars($partner->getPermPlanning()),
            'permNewsletter' => htmlspecialchars($partner->getPermNewsletter()),
            'structures' => $structures,
        ]);
    }
}