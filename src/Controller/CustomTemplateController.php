<?php

namespace App\Controller;

use App\Entity\CustomTemplate;
use App\Form\CustomTemplateType;
use App\Repository\CustomTemplateRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\TemplateGenerator;
/**
 * @Route("/custom/template")
 */
class CustomTemplateController extends AbstractController
{
    /**
     * @Route("/", name="custom_template_index", methods={"GET"})
     */
    public function index(CustomTemplateRepository $customTemplateRepository, TemplateGenerator $tempGen): Response
    {
        // $tempGen->generate('iman', array('iman' => '1111122222222222'));
        // exit();
        return $this->render('custom_template/index.html.twig', [
            'custom_templates' => $customTemplateRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="custom_template_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $customTemplate = new CustomTemplate();
        $form = $this->createForm(CustomTemplateType::class, $customTemplate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($customTemplate);
            $entityManager->flush();

            return $this->redirectToRoute('custom_template_index');
        }

        return $this->render('custom_template/new.html.twig', [
            'custom_template' => $customTemplate,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="custom_template_show", methods={"GET"})
     */
    public function show(CustomTemplate $customTemplate): Response
    {
        return $this->render('custom_template/show.html.twig', [
            'custom_template' => $customTemplate,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="custom_template_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, CustomTemplate $customTemplate): Response
    {
        $form = $this->createForm(CustomTemplateType::class, $customTemplate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('custom_template_index');
        }

        return $this->render('custom_template/edit.html.twig', [
            'custom_template' => $customTemplate,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="custom_template_delete", methods={"DELETE"})
     */
    public function delete(Request $request, CustomTemplate $customTemplate): Response
    {
        if ($this->isCsrfTokenValid('delete'.$customTemplate->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($customTemplate);
            $entityManager->flush();
        }

        return $this->redirectToRoute('custom_template_index');
    }
}
