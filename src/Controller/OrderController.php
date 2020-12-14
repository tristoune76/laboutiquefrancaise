<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Order;
use App\Entity\OrderDetails;
use App\Form\OrderType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;

class OrderController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager=$entityManager;
    }

    /**
     * @Route("/commande", name="commande")
     * @param Cart $cart
     * @param Request $request
     * @return Response
     */
    public function index(Cart $cart, Request $request): Response
    {
        if (empty($this->getUser()->getAdresses()->getValues())) {
            return $this->redirectToRoute('account_adresse_add');
        }

        $form = $this->createForm(OrderType::class, null, [
            'user' => $this->getUser()
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            dd($form);
        }

        return $this->render('order/index.html.twig', [
            'form' => $form->createView(),
            'cart' => $cart->getFull()
        ]);
    }


    /**
     * @Route("/commande/add", name="commande_add", methods = {"POST"})
     * @param Cart $cart
     * @param Request $request
     * @return Response
     */
    public function add(Cart $cart, Request $request): Response
    {
        $form = $this->createForm(OrderType::class, null, [
            'user'  =>  $this->getUser()
        ]);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            // enregistrer ma commande - Order



            $order = new Order();
            $date = new \DateTime();
            $carriers = $form->get('transporteurs')->getData();
            $delivery = $form->get('adresses')->getData();

            $deliveryContent = $delivery->getFirstname().' '.$delivery->getLastname();
            $deliveryContent .= '</br>'.$delivery->getPhone();

            if ($delivery->getCompany())
            {
                $deliveryContent .= '</br>'.$delivery->getCompany();
            }
            $deliveryContent .= '</br>'.$delivery->getAdresse();
            $deliveryContent .= '</br>'.$delivery->getPostal().' '.$delivery->getCity();
            $deliveryContent .= '</br>'.$delivery->getLand();


            $order->setUser($this->getUser());
            $order->setCarrierName($carriers->getName());
            $order->setCarrierPrice($carriers->getPrix());
            $order->setCreatedAt($date);
            $order->setDelivery($deliveryContent);
            $order->setIsPaied(0);

            $this->entityManager->persist($order);

            foreach ($cart->getFull() as $product)
            {
                $orderDetails = new OrderDetails();
                $orderDetails->setMyOrder($order);
                $orderDetails->setProduct($product['product']->getName());
                $orderDetails->setPrice($product['product']->getPrix());
                $orderDetails->setQuantite($product['quantite']);
                $orderDetails->setTotal($product['product']->getPrix() * $product['quantite']);

                $this->entityManager->persist($orderDetails);


            }

//            $this->entityManager->flush();
            return $this->render('order/add.html.twig',[
                'cart'  => $cart->getFull(),
                'delivery'=> $deliveryContent,
                'carrier'   =>  $carriers
            ]);
        }
        return $this->redirectToRoute('cart');
    }
}
