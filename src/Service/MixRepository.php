<?php

namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class MixRepository extends AbstractController
{
    /**
     * @Route("/mix")
     */
    public function read(ManagerRegistry $doctrine): Response
    {
        
    }
}