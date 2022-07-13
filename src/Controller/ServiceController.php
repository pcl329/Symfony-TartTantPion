<?php

namespace App\Controller;

use App\Entity\Service;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ServiceController extends AbstractController
{
    #[Route('/service/{id}', name: 'app_service_membres')]
    public function index(Service $service): Response
    {
        return $this->render('home/service.html.twig', [
            'controller_name' => 'ServiceController',
            'service' => $service,
        ]);
    }
}
