<?php

namespace OnlineShopBundle\Controller;

use OnlineShopBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends Controller
{
    /**
     *
     * @Route("/", name="shop_index")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $products = $this->getDoctrine()->getRepository(Product::class)
            ->findAll();

        return $this->render('home/index.html.twig',
            ['products' => $products]);
    }
}
