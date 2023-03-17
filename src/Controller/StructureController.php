<?php

namespace App\Controller;

use App\Entity\Structure;
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
        Structure $structure = null,
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
                $structure->setDrinksPermission($statut);
                $perm ='boissons';
            } else if($_POST['id'] == 'perm_planning') {
                $structure->setPlanningPermission($statut);
                $perm ='planning';
            } else if($_POST['id'] == 'perm_newsletter') {
                $structure->setNewsletterPermission($statut);
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
            'cityPartner' => htmlspecialchars($structure->getCity()),
            'address' => htmlspecialchars($structure->getAddress()),
            'mail' => htmlspecialchars($structure->getMail()),
            'rightsLevel' => htmlspecialchars($structure->getRights()),
            'permDrinks' => htmlspecialchars($structure->getDrinksPermission()),
            'permPlanning' => htmlspecialchars($structure->getPlanningPermission()),
            'permNewsletter' => htmlspecialchars($structure->getNewsletterPermission()),
        ]);
    }
}