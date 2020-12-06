<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/mon-panier", name="cart")
     * @param Cart $cart
     * @return Response
     */
    public function index(Cart $cart): Response
    {

        $cartComplet = $cart->getFull();
        return $this->render('cart/index.html.twig',[
            'cart'  =>  $cartComplet
        ]);
    }

    /**
     * @Route("/cart/add/{id}", name="add-to-cart")
     * @param Cart $cart
     * @param $id
     * @return Response
     */
    public function add(Cart $cart, $id): Response
    {
        $cart->add($id);
        return $this->redirectToRoute('cart');
    }

    /**
     * @Route("/cart/remove", name="remove-my-cart")
     * @param Cart $cart
     * @return Response
     */
    public function remove(Cart $cart): Response
    {
        $cart->remove();
        return $this->redirectToRoute('products');
    }

    /**
     * @Route("/cart/delete/{id}", name="delete-of-cart")
     * @param Cart $cart
     * @param $id
     * @return Response
     */
    public function delete(Cart $cart, $id): Response
    {
        $cart->delete($id);
        return $this->redirectToRoute('cart');
    }



    /**
     * @Route("/cart/retire/{id}", name="retire-of-cart")
     * @param Cart $cart
     * @param $id
     * @return Response
     */
    public function retire(Cart $cart, $id): Response
    {
        $cart->retire($id);
        return $this->redirectToRoute('cart');
    }



}
