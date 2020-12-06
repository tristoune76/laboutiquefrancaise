<?php

namespace App\Controller;

use App\Form\ChangePasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AccountPasswordController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    /**
     * @Route("/compte/modifier-mon-mot-de-passe", name="account_password")
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return Response
     */
    public function index(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $notification ='';
        
        
        $user = $this->getUser();
        $form = $this->createForm(ChangePasswordType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $oldPassword = $form->get('oldPassword')->getData();
            if($encoder->isPasswordValid($user, $oldPassword))
            {
                $newPassword = $form->get('newPassword')->getData();
                $password = $encoder->encodePassword($user, $newPassword);

                $user->setPassword($password);
                $this->entityManager->flush();
                $notification = 'Votre de passe a été modifié avec succès!';
            }
            else
            {
                $notification = 'Votre mot de passe actuel n\'est pas le bon';

            }

        }

        
        return $this->render('account/password.html.twig',[
                    'form' => $form->createView(),
                    'notification'  =>  $notification
        ]);
    }
}
