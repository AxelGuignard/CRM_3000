<?php

namespace App\Controller;

use App\Entity\Company;
use App\Repository\CompanyRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CompanyController extends AbstractController
{
    /**
     * @Route("/admin/company", name="company", methods={"GET"})
     */
    public function show(CompanyRepository $companyRepository): Response
    {
        $companyRepository->findAll();
        return new Response($this->renderView("company.html.twig", ["companies" => $companyRepository->findAll()]));
    }

    /**
     * @Route("/admin/company", name="addCompany", methods={"POST"})
     */
    public function add(Request $request, ManagerRegistry $doctrine)
    {
        $entityManager = $doctrine->getManager();

        $company = new Company();
        $company->setName($request->request->get("name"));
        $company->setAddress($request->request->get("address"));

        $entityManager->persist($company);
        $entityManager->flush();
        return $this->redirectToRoute("company");
    }
}