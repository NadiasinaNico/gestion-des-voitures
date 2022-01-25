<?php

namespace App\Controller;


use App\Entity\Voiture;
use App\Form\VoitureType;
use App\Repository\VoitureRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VoitureController extends AbstractController
{
    /**
     * @Route("/", name="voiture")
     */
    public function index(VoitureRepository $voitureRepository, PaginatorInterface $paginatorInterface, Request $request): Response
    {
        $voiture = $paginatorInterface->paginate($voitureRepository->findAll(),
        $request->query->getInt('page', 1), 6);
        return $this->render('voiture/voiture.html.twig',[
            "voiture" => $voiture,
            "admin" => false
            ]);
    }
    /**
     * @Route("/modification/{id}", name="modificationVoiture")
     */
    public function modification(Voiture $voitures, Request $request, ManagerRegistry $managerRegistry): Response
    {
        $form = $this->createForm(VoitureType::class, $voitures);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $managerRegistry->getManager();
            $em->persist($voitures);
            $em->flush();
            return $this->redirectToRoute("administration");
        }
        return $this->render('voiture/voiture_modification.html.twig', [
            "voitures" => $voitures,
            'form' => $form->createView(),
        ]);
    }
}
