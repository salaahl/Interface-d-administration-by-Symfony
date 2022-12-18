<?php

namespace App\Controller;

use App\Entity\Fitnessp;
use App\Entity\FitnesspAdmin;
use App\Entity\FitnesspPartenaire;
use App\Entity\FitnesspStructure;
use App\Repository\FitnesspRepository;
use App\Form\AdminType;
use App\Form\PartenaireType;
use App\Form\StructureType;
use App\Repository\FitnesspPartenaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;


class UserCreateController extends AbstractController
{
    #[Route('/user/create/admin', name: 'app_user_create_admin')]
    public function createAdmin(
        FitnesspRepository $brandRepository,
        ManagerRegistry $doctrine,
        Request $request
        ): Response
    {
                
        $admin = new FitnesspAdmin();
        $form = $this->createForm(AdminType::class, $admin);

        $form->handleRequest($request);

        if ($form->isSubmitted()) 
        {
            $brand = $brandRepository->find('FitnessP');

            if(!isset($brand)) {
                $new_brand = new Fitnessp();
                $new_brand->setMarque('FitnessP');
            }

            $mail = $_POST['admin']['mail'];
            $password = password_hash($_POST['admin']['mot_de_passe'], PASSWORD_DEFAULT);

            $admin->setMarque('FitnessP');
            $admin->setMail($mail);
            $admin->setMotDePasse($password);
            $admin->setNiveauDroits(3);

            $entityManager = $doctrine->getManager();
            $entityManager->persist($admin);
            $entityManager->flush();

            return new Response('Utilisateur ajouté !');
        }
        
        return $this->render('user_create/admin.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/user/create/partner', name: 'app_user_create_partner')]
    public function createPartner(
        ManagerRegistry $doctrine, 
        Request $request
        ): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');

        $partner = new FitnesspPartenaire();
        $form = $this->createForm(PartenaireType::class, $partner);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            $mail = $_POST['partenaire']['mail'];
            $password = password_hash($_POST['partenaire']['mot_de_passe'], PASSWORD_DEFAULT);
            $name = $_POST['partenaire']['nom'];

            $partner->setMarque('FitnessP');
            $partner->setNom($name);
            $partner->setMail($mail);
            $partner->setMotDePasse($password);
            $partner->setNiveauDroits(2);
            $partner->setPremiereConnexion(0);
            $partner->setNombreDeStructures(0);

            $entityManager = $doctrine->getManager();
            $entityManager->persist($partner);
            $entityManager->flush();

            return new Response('Utilisateur ajouté !');
        }

        return $this->render('user_create/partner.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/user/create/structure', name: 'app_user_create_structure')]
    public function createStructure(
        FitnesspPartenaireRepository $partnerRepository, 
        ManagerRegistry $doctrine, 
        Request $request
        ): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');
        
        $partners = $partnerRepository->findAll();

        $structure = new FitnessPStructure();
        $form = $this->createForm(StructureType::class, $structure);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            $partner = $partnerRepository->findOneBy([
                'nom' => $_POST['partenaire'],
            ]);

            $mail = $_POST['structure']['mail'];
            $password = password_hash($_POST['structure']['mot_de_passe'], PASSWORD_DEFAULT);
            $adresse = $_POST['structure']['adresse'];

            $structure->setMailPartenaire($partner->getMail());
            $structure->setMail($mail);
            $structure->setMotDePasse($password);
            $structure->setAdresse($adresse);
            $structure->setNiveauDroits(1);
            $structure->setPremiereConnexion(0);
            $partner->setNombreDeStructures(+1);

            $entityManager = $doctrine->getManager();
            $entityManager->persist($structure, $partner);
            $entityManager->flush();

            return new Response('Utilisateur ajouté !');
        }

        return $this->render('user_create/structure.html.twig', [
            'form' => $form->createView(),
            'partners' => $partners,
        ]);
    }
}