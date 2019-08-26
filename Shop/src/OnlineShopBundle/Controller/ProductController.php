<?php

namespace OnlineShopBundle\Controller;

use OnlineShopBundle\Entity\Category;
use OnlineShopBundle\Entity\Product;
use OnlineShopBundle\Form\ProductType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends Controller
{
    /**
     * @Route("/create", name="product_create")
     *
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function create(Request $request)
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        $category = $this
            ->getDoctrine()
            ->getRepository(Category::class)
            ->findAll();

        if($form->isSubmitted())
        {
            $product->setAuthor($this->getUser());
           $em = $this->getDoctrine()->getManager();
           $em->persist($product);
           $em->flush();

           return $this->redirectToRoute("shop_index");
        }

        return $this->render('products/create.html.twig',
            ['form' => $form->createView(),
                'category' => $category]);
    }

    /**
     * @Route("/edit/{id}", name="product_edit")
     *
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(Request $request, $id)
    {
        $product = $this
            ->getDoctrine()
            ->getRepository(Product::class)
            ->find($id);
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if($form->isSubmitted())
        {
            $em = $this->getDoctrine()->getManager();
            $em->merge($product);
            $em->flush();

            return $this->redirectToRoute("shop_index");
        }

        return $this->render('products/edit.html.twig',
            [
                'form' => $form -> createView(),
                'product' => $product
            ]);
    }


    /**
     * @Route("/delete/{id}", name="product_delete")
     *
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function delete(Request $request, $id)
    {
        $product = $this
            ->getDoctrine()
            ->getRepository(Product::class)
            ->find($id);
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if($form->isSubmitted())
        {
            $em = $this->getDoctrine()->getManager();
            $em->remove($product);
            $em->flush();

            return $this->redirectToRoute("shop_index");
        }

        return $this->render('products/delete.html.twig',
            [
                'form' => $form->createView(),
                'product' => $product
            ]);
    }


    /**
     * @Route("/product/{id}", name="product_view")
     *
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function view($id)
    {
        $product = $this
            ->getDoctrine()
            ->getRepository(Product::class)
            ->find($id);



        return $this->render("products/view.html.twig",
            ['product' => $product]);
    }

}
