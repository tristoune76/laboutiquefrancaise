<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Adresse;
use App\Form\AdressesType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountAdresseController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager= $entityManager;
    }

    /**
     * @Route("/compte/adresses", name="account_adresse")
     */
    public function index(): Response
    {

        //dd($this->getUser()->getAdresses());
        return $this->render('account/adresse.html.twig');
    }

    /**
     * @Route("/compte/adresses/add", name="account_adresse_add")
     * @param Request $request
     * @param Cart $cart
     * @return Response
     */
    public function add(Request $request, Cart $cart): Response
    {
        $adresse = new Adresse;
        $form = $this->createForm(AdressesType::class, $adresse);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $adresse->setUser($this->getUser());
            $this->entityManager->persist($adresse);
            $this->entityManager->flush();
            if ($cart->get())
            {
                return $this->redirect('/commande');
            }
            else
            {
                return $this->redirect('/compte/adresses');
            }
        }

        //dd($this->getUser()->getAdresses());

        return $this->render('account/adresse_form.html.twig', [
            'form'  =>  $form->createView()
        ]);
    }

    /**
     * @Route("/compte/adresses/edit/{id}", name="account_adresse_edit")
     * @param Request $request
     * @return Response
     */
    public function edit(Request $request, $id): Response
    {
        $adresse = $this->entityManager->getRepository(Adresse::class)->findOneById($id);
        if(!$adresse || $adresse->getUser() != $this->getUser())
        {
            return $this->redirect('compte/adresses');
        }

        $form = $this->createForm(AdressesType::class, $adresse);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $this->entityManager->flush();
            return $this->redirect('/compte/adresses');
        }

        //dd($this->getUser()->getAdresses());
        return $this->render('account/adresse_form.html.twig', [
            'form'  =>  $form->createView()
        ]);
    }

    /**
     * @Route("/compte/adresses/delete/{id}", name="account_adresse_delete")
     * @param Request $request
     * @return Response
     */
    public function delete( $id): Response
    {
        $adresse = $this->entityManager->getRepository(Adresse::class)->findOneById($id);
        if($adresse && $adresse->getUser() == $this->getUser())
        {
            $this->entityManager->remove($adresse);
            $this->entityManager->flush();

        }
        //dd($this->getUser()->getAdresses());
        return $this->render('account/adresse.html.twig');
    }




}
