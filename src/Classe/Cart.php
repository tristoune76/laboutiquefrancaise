<?php
namespace App\Classe;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Cart
{
    /**
     * @var SessionInterface
     */
    private $session;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * Cart constructor.
     * @param SessionInterface $session
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(SessionInterface $session, EntityManagerInterface $entityManager)
    {
        $this->session = $session;
        $this->entityManager = $entityManager;
    }

    /**
     * @param $id
     */
    public function add($id)
    {
        $cart = $this->session->get('cart', []);
        if(empty($cart[$id]))
        {
            $cart[$id] = 1;
        }
        else
        {
            $cart[$id] ++;
        }
        $this->session->set('cart', $cart);
    }

    /**
     * @param $id
     */
    public function retire($id)
    {
        $cart = $this->session->get('cart', []);
        if($cart[$id] <= 1)
        {
            unset($cart[$id]);
        }
        else
        {
            $cart[$id] --;
        }
        $this->session->set('cart', $cart);
    }

    /**
     * @param $id
     */
    public function delete($id)
    {
        $cart = $this->session->get('cart', []);

            unset($cart[$id]);

            $this->session->set('cart', $cart);
    }

    /**
     * @return mixed
     */
    public function get()
    {
       return ($this->session->get('cart'));
    }

    /**
     * @return mixed
     */
    public function remove()
    {
        return ($this->session->remove('cart'));
    }

    /**
     * @return array
     */
    public function getFull()
    {
        $cartComplete = [];
        if (!empty($this->get()))
        {
            foreach ($this->get() as $id => $quantity) {
                $productObject = $this->entityManager->getRepository(Product::class)->findOneById($id);
                if (!$productObject)
                {
                    $this->delete($id);
                    continue;
                }
                else
                {
                    $cartComplete[$id] = [
                        'product' => $productObject,
                        'quantite' => $quantity
                    ];
                }
            }
        }
        return $cartComplete;
    }
}