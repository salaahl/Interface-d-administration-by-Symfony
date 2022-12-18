<?php

namespace App\Controller;

use App\Entity\Fitnessp;
use App\Entity\FitnesspAdmin;
use App\Entity\FitnesspPartenaire;
use App\Entity\FitnesspStructure;
use App\Repository\FitnesspAdminRepository;
use App\Repository\FitnesspPartenaireRepository;
use App\Repository\FitnesspStructureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class CrudController extends AbstractController
{
    /**
     * @Route("/read")
     */
    public function read(ManagerRegistry $doctrine, FitnesspAdminRepository $adminRepository, FitnesspPartenaireRepository $partnerRepository, FitnesspStructureRepository $structureRepository): Response
    {
        // Retourne un tableau avec tous les users en base de données
        $adminAll = $adminRepository->findAll();
        // Retourne un tableau avec tous les users qui ont cet email et ce username
        $adminBy = $adminRepository->findBy([
            'mail' => 'email@example.com',
            'marque' => 'nomUtilisateur',
        ]);
        // Retourne l'entité User d'id 1
        $adminId = $adminRepository->find(1);
        // Retourne SOUS FORME DE TABLEAU la première entité User trouvée ayant cet email et ce username
        $adminCombine = $adminRepository->findOneBy([
            'mail' => 'email@example.com',
            'marque' => 'nomUtilisateur',
        ]);
        // Méthode magique qui retourne la première entité User trouvée ayant cet email
        $adminFirst = $adminRepository->findOneByMail('email@example.com');

        //
        $partnerId = $partnerRepository->find('salsdu19@gmail.com');
        $partnerAll = $partnerRepository->findAll();
        //

        $structuresAll = $structureRepository->findAll();
        
        //

        $db = $doctrine->getManager()->getConnection();
        
        $partnersFound = $db
            ->prepare(
                "SELECT nom
                FROM Fitnessp_partenaire
                WHERE nom LIKE CONCAT(?, '%')
                LIMIT 3"
            )
            ->executeQuery(['p'])
            ->fetchAllAssociative();

        $partners = $partnerRepository->findAll();

        $reponse = [];
        $city = [];
        $mail = [];
        $rights_level = [];
        $number_structures = [];

        foreach($partners as $partner)
        {   
            $city[] = htmlspecialchars($partner->getNom());
            $mail[] = htmlspecialchars($partner->getMail());
            $rights_level[] = htmlspecialchars($partner->getNiveauDroits());
            $number_structures[] = htmlspecialchars($partner->getNombreDeStructures());
        }

        $reponse['city'] = $city;
        $reponse['mail'] = $mail;
        $reponse['rights_level'] = $rights_level;
        $reponse['number_structures'] = $number_structures;

        return new Response(var_dump($partnersFound));
    }

    /**
    * Fetch via primary key because {id} is in the route. A déclarer avec le "FitnesspPartenaire $partner"
    *
    * @Route("/lire/{id}")
    */
    public function readById(FitnesspPartenaire $partner = null, FitnesspStructure $structure = null, ManagerRegistry $doctrine, FitnesspAdminRepository $adminRepository, FitnesspPartenaireRepository $partnerRepository, FitnesspStructureRepository $structureRepository): Response
    {
        

        return new Response(var_dump($partner));
    }

    /**
     * @Route("/update")
     */
    public function update(FitnesspPartenaireRepository $partnerRepository, ManagerRegistry $doctrine): Response
    {
        $partner = $partnerRepository->findOneByMail('salsdu19@gmail.com');
        $partner->setPermBoissons(0);

        $entityManager = $doctrine->getManager();

        $entityManager->persist($partner);
        $entityManager->flush();

        return new Response('Utilisateur ajouté !');
    }

    /**
     * @Route("/drop")
     */
    public function drop(ManagerRegistry $doctrine, FitnessPAdminRepository $adminRepository): Response
    {
        $userId = $adminRepository->find('sokhona.salaha@gmail.com');
        
        $entityManager = $doctrine->getManager();
        $entityManager->remove($userId);
        $entityManager->flush();        

        return new Response('Utilisateur supprimé !');
    }
}