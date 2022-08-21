<?php

namespace App\Controller;

use App\Entity\Phone;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'add_to_cart')]
    public function addToCart(Request $request) 
    {
        $session = $request->getSession();
        $id = $request->get('phoneid');
        $session->set('phoneid',$id);
        $phone = $this->getDoctrine()->getRepository(Phone::class)->find($id);
        $session->set('phone', $phone);
        $quantity = $request->get('quantity');
        $session->set('quantity', $quantity);
        $date = date('Y/m/d');  //get current date
        $session->set('date', $date);
        $datetime = date('Y/m/d H:i:s'); //get current date + time
        $session->set('date', $date);
        $session->set('datetime', $datetime);
        $phone_price = $phone->getPrice();
        $order_price = $phone_price * $quantity;
        $session->set('price', $order_price);
        $user = $this->getUser(); //get current user
        $session->set('user', $user);
        return $this->render('cart/cart.html.twig');
    }

    #[Route('/order', name: 'make_order')]
    public function makeOrder(Request $request, ManagerRegistry $managerRegistry) 
    {
        $session = new Session();

        $phone = $this->getDoctrine()->getRepository(Phone::class)->find($session->get('phoneid'));
        $phone_quantity = $phone->getQuantity();
        $order_quantity = $session->get('quantity');
        $new_quantity = $phone_quantity - $order_quantity;
        $phone->setQuantity($new_quantity);

        $manager = $managerRegistry->getManager();
        $manager->persist($phone);
        $manager->flush();


        $this->addFlash('Info', 'Order phone successfully !');
  
        return $this->redirectToRoute('phone_list',
    );
    }
}
