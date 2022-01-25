<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\Persistence\ManagerRegistry;
use PharIo\Manifest\Author;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index(Request $request,  ManagerRegistry $managerRegistry, UserPasswordEncoderInterface $encoder): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $password_crypte = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password_crypte);
            $user->setRoles("ROLE_USER");
            $em = $managerRegistry->getManager();
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute("connexion");
        }

        return $this->render('user/user.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/connexion", name="connexion")
     */
    public function connexion(AuthenticationUtils $util): Response
    {
        return $this->render('user/connexion.html.twig',[
            "lastUserName" => $util->getLastUsername(),
            "error" => $util->getLastAuthenticationError()
        ]);
    }
    /**
     * @Route("/deconnexion", name="deconnexion")
     */
    public function deconnexion()
    {
    
    }
}
