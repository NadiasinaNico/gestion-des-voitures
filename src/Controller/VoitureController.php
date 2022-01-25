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
     * @Route("/admin/creation_voiture", name="creation_voiture")
     * @Route("/modification/{id}", name="modificationVoiture", methods="GET|POST")
     */
    public function modification(Voiture $voitures = null, Request $request, ManagerRegistry $managerRegistry): Response
    {
        if ($voitures == null){
            $voitures = new Voiture();
        }
        $form = $this->createForm(VoitureType::class, $voitures);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $managerRegistry->getManager();
            $em->persist($voitures);
            $this->addFlash("success", "L'action a été effectue");
            $em->flush();
            return $this->redirectToRoute("administration");
        }
        return $this->render('voiture/voiture_modification.html.twig', [
            "voitures" => $voitures,
            'form' => $form->createView(),
            'isModif' => false,
        ]);
    }

    /**
     * @Route("/admin/suppression/{id}", name="suppression_voiture", methods="SUP")
     */
    public function suppression(Request $request, Voiture $voitures,  ManagerRegistry $managerRegistry)
    {
        if($this->isCsrfTokenValid("SUP".$voitures->getId(), $request->get("_token"))){
            $em = $managerRegistry->getManager();
            $em->remove($voitures);
            $this->addFlash("danger", "La suppression à été effectue ");
            $em->flush();
            return $this->redirectToRoute('administration');
        }
       
    }
}
