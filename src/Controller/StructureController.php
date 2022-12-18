<?php

namespace App\Controller;

use App\Entity\FitnesspStructure;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;

#[Route('partner/structure', name: 'app_structure_controller')]
class StructureController extends AbstractController
{
    #[Route('/{id}', name: 'app_structure_profile')]
    public function structureProfile(
        FitnesspStructure $structure = null,
        Request $request,
        ManagerRegistry $doctrine
        ): Response
    {      
        $this->denyAccessUnlessGranted('ROLE_STRUCTURE');

        // Structure permission
        if ($request->isMethod('POST') && isset($_POST['id'])) {
            
            $statut = $_POST['statut_toggle'] == 'true' ? 1 : 0;
            $perm ='';

            if($_POST['id'] == 'perm_boissons') {
                $structure->setPermBoissons($statut);
                $perm ='boissons';
            } else if($_POST['id'] == 'perm_planning') {
                $structure->setPermPlanning($statut);
                $perm ='planning';
            } else if($_POST['id'] == 'perm_newsletter') {
                $structure->setPermNewsletter($statut);
                $perm ='newsletter';
            }

            $entityManager = $doctrine->getManager();
            $entityManager->persist($structure);
            $entityManager->flush();

            return new Response('La permission "'.$perm.'" a bien été modifiée.');
        }

        // Delete structure        
        if ($request->isMethod('POST') && isset($_POST['delete_structure'])) {
            
            $entityManager = $doctrine->getManager();
            $entityManager->remove($structure);
            $entityManager->flush();

            return $this->redirectToRoute('app_partners_controllerapp_partners');
        }

        return $this->render('structure/s_profile.html.twig', [
            'mailPartner' => htmlspecialchars($structure->getMailPartenaire()),
            'address' => htmlspecialchars($structure->getAdresse()),
            'mail' => htmlspecialchars($structure->getMail()),
            'rightsLevel' => htmlspecialchars($structure->getNiveauDroits()),
            'permDrinks' => htmlspecialchars($structure->getPermBoissons()),
            'permPlanning' => htmlspecialchars($structure->getPermPlanning()),
            'permNewsletter' => htmlspecialchars($structure->getPermNewsletter()),
        ]);
    }
}