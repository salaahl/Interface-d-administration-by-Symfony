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
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;

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
        Request $request,
        MailerInterface $mailer
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

            // Logique d'envoi des mails de confirmation
            $mailConfirmation =
            "
            <html lang='fr'>
                <head>
                    <meta charset='utf-8'>
                    <meta name='viewport' content='width=device-width'>
                    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx' crossorigin='anonymous'>
                    
                    <style>
                    body
                    {
                        display: flex;
                        justify-content: center;
                        align-items: center;
                    }
                    table
                    {
                        width: 50vw;
                        border: 1rem solid highlight;
                        background-color: lightgray;
                    }
                    th
                    {
                        background-color: gray;
                    }
                    td
                    {
                        border: 1px solid gray;
                    }
                    </style>
                
                </head>
                <body>
                    <table>
                    <thead>
                        <tr>
                        <th colspan='2'>Bienvenue sur Fitness P !</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan='2'>
                                Bonjour partenaire de " . htmlspecialchars($name) . ",<br>
                                Voici vos identifiants de connexion. Notez que le mot de passe n'est valable que pour la première connexion. 
                                Il devra être changé lors de la première connexion au site.
                            </td>
                        </tr>
                        <tr>
                            <td>mail :</td>
                            <td>" . htmlspecialchars($mail) . "</td>
                        </tr>
                        <tr>
                            <td>mot de passe :</td>
                            <td>" . htmlspecialchars($password) . "</td>
                        </tr>
                        <tr>
                            <td colspan='2'><a href='https://ecf-salaha.herokuapp.com/login.html' class='btn btn-primary'>Se connecter</a></td>
                        </tr>
                    </tbody>
                    </table>
                    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js' integrity='sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa' crossorigin='anonymous'></script>
                </body>
            </html>";

            // Etape 2 : envoyer un mail...
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
            ->html($mailConfirmation);

            $mailer->send($email);

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