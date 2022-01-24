<?php

namespace App\Controller;

use App\Repository\VoitureRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    /**
     * @Route("/administration", name="administration")
     */
    public function index(VoitureRepository $voitureRepository, PaginatorInterface $paginatorInterface, Request $request): Response
    {
        $voiture = $paginatorInterface->paginate($voitureRepository->findAll(),
        $request->query->getInt('page', 1), 6);
        return $this->render('voiture/voiture.html.twig',[
            "voiture" => $voiture,
            "admin" => true
            ]);
    }
}
