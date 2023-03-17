<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Entity\Brand;
use App\Entity\Partner;
use App\Entity\Structure;
use App\Form\AdminType;
use App\Form\PartenaireType;
use App\Form\StructureType;
use App\Repository\BrandRepository;
use App\Repository\PartnerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;
use App\Service\ServiceController;
use Symfony\Component\Mailer\Mailer;

class UserCreateController extends AbstractController
{
    #[Route('/user/create/admin', name: 'app_user_create_admin')]
    public function createAdmin(
        BrandRepository $brandRepository,
        ManagerRegistry $doctrine,
        Request $request
        ): Response
    {
                
        $admin = new Admin();
        $form = $this->createForm(AdminType::class, $admin);

        $form->handleRequest($request);

        if ($form->isSubmitted()) 
        {
            $brand = $brandRepository->findOneBy( ['name' => 'FitnessP']);

            if(!isset($brand)) {
                $new_brand = new Brand();
                $new_brand->setName('FitnessP');

                $entityManager = $doctrine->getManager();
                $entityManager->persist($new_brand);
                $entityManager->flush();
            }

            $mail = $_POST['admin']['mail'];
            $password = password_hash($_POST['admin']['password'], PASSWORD_DEFAULT);
            $brand = $brandRepository->findOneBy( ['name' => 'FitnessP']);

            $admin->setBrandName($brand);
            $admin->setMail($mail);
            $admin->setPassword($password);
            $admin->setRights(3);

            $entityManager = $doctrine->getManager();
            $entityManager->persist($admin);
            $entityManager->flush();

            return new Response('Administrateur enregistré.');
        }
        
        return $this->render('user_create/admin.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/user/create/partner', name: 'app_user_create_partner')]
    public function createPartner(
        ManagerRegistry $doctrine, 
        Request $request,
        MailerInterface $mailer,
        ServiceController $serviceController
        ): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');

        $partner = new Partner();
        $form = $this->createForm(PartenaireType::class, $partner);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            $mail = $_POST['partenaire']['mail'];
            $password = password_hash($_POST['partenaire']['mot_de_passe'], PASSWORD_DEFAULT);
            $name = $_POST['partenaire']['nom'];

            $partner->setBrandName('FitnessP');
            $partner->setCity($name);
            $partner->setMail($mail);
            $partner->setPassword($password);
            $partner->setRights(2);

            $entityManager = $doctrine->getManager();
            $entityManager->persist($partner);
            $entityManager->flush();

            // Envoyer un mail...
            // Initialisation des données. Méthode de récup différente selon l'environnemment
            $from_email =
            $_SERVER["SERVER_NAME"] == "127.0.0.1:8000"
            ? $_ENV['FROM_EMAIL']
            : getenv("FROM_EMAIL");

            $from_name =
            $_SERVER["SERVER_NAME"] == "127.0.0.1:8000"
            ? $_ENV['FROM_NAME']
            : getenv("FROM_NAME");

            $to_email = $_SERVER["SERVER_NAME"] == "127.0.0.1:8000" ? $_ENV['TO_EMAIL'] : $mail;

            $email = (new Email())
            ->from(new Address($from_email, $from_name))
            ->to($to_email)
            ->subject('Vos identifiants')
            ->html($serviceController->mailConfirmation('partenaire de ' . $name, $mail, $password));

            $mailer->send($email);

            return new Response('Utilisateur ajouté !');
        }

        return $this->render('user_create/partner.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/user/create/structure', name: 'app_user_create_structure')]
    public function createStructure(
        PartnerRepository $partnerRepository, 
        ManagerRegistry $doctrine, 
        Request $request,
        Mailer $mailer,
        ServiceController $serviceController
        ): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');
        
        $partners = $partnerRepository->findAll();

        $structure = new Structure();
        $form = $this->createForm(StructureType::class, $structure);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            $partner = $partnerRepository->findOneBy([
                'nom' => $_POST['partenaire'],
            ]);

            $mail = $_POST['structure']['mail'];
            $password = password_hash($_POST['structure']['mot_de_passe'], PASSWORD_DEFAULT);
            $adresse = $_POST['structure']['adresse'];

            $structure->setCity($partner->getCity());
            $structure->setMail($mail);
            $structure->setPassword($password);
            $structure->setAddress($adresse);
            $structure->setRights(1);

            $entityManager = $doctrine->getManager();
            $entityManager->persist($structure, $partner);
            $entityManager->flush();

            // Envoyer un mail...
            // Initialisation des données. Méthode de récup différente selon l'environnemment
            $from_email =
            $_SERVER["SERVER_NAME"] == "127.0.0.1:8000"
            ? $_ENV['FROM_EMAIL']
            : getenv("FROM_EMAIL");

            $from_name =
            $_SERVER["SERVER_NAME"] == "127.0.0.1:8000"
            ? $_ENV['FROM_NAME']
            : getenv("FROM_NAME");

            $to_email = $_SERVER["SERVER_NAME"] == "127.0.0.1:8000" ? $_ENV['TO_EMAIL'] : $mail;

            $email = (new Email())
            ->from(new Address($from_email, $from_name))
            ->to($to_email)
            ->subject('Vos identifiants')
            ->html($serviceController->mailConfirmation('structure du ' . $adresse, $mail, $password));

            $mailer->send($email);

            return new Response('Utilisateur ajouté !');
        }

        return $this->render('user_create/structure.html.twig', [
            'form' => $form->createView(),
            'partners' => $partners,
        ]);
    }
}