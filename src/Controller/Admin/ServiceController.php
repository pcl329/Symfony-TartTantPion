<?php

namespace App\Controller\Admin;

use App\Entity\Service;
use App\Form\ServiceType;
use App\Repository\ServiceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/service')]
class ServiceController extends AbstractController
{
    #[Route('/', name: 'app_service_index', methods:['GET'])]
    public function index(ServiceRepository $serviceRepository): Response
    {
        return $this->render('service/index.html.twig', [
            'services' => $serviceRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_service_new', methods:['GET', 'POST'])]
    public function new(Request $request, ServiceRepository $serviceRepository): Response
    {
        $service = new Service();
        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form-> isValid()) {
            $serviceRepository->add($service, true);

            return $this->redirectToRoute('app_service_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('service/new.html.twig', [
            'services' => $service,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_service_show', methods:['GET'])]
    public function show(Service $service): Response
    {
        return $this->render('service/show.html.twig', [
            'services' => $service,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_service_edit', methods:['GET', 'POST'])]
    public function edit(Request $request, Service $service, ServiceRepository $ServiceRepository): Response
    {
        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form-> isValid()) {
            $ServiceRepository->add($service, true);

            return $this->redirectToRoute('app_service_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('service/edit.html.twig', [
            'services' => $service,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_service_delete', methods:['POST'])]
    public function delete(Request $request, Service $service, ServiceRepository $ServiceRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$service->getId(),  $request->request->get('_token'))) {
            $ServiceRepository->remove($service, true);         
        }
        return $this->redirectToRoute('app_service_index', [], Response::HTTP_SEE_OTHER);
    }
}