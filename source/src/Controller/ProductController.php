<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class ProductController extends AbstractController
{
    /**
     * @Route("/product", name="create_product")
     * @param ManagerRegistry $doctrine
     * @return Response
     */
    public function createProduct(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        $product = new Product();
        $product->setName('My first title name №'. rand(0, 100));
        $product->setDescription('It is description of my product');
        $product->setPrice(10);
        $product->setTime(new \DateTime());
        $product->setNumber(1899);

        $entityManager->persist($product);
        $entityManager->flush();

        return new Response('well done');
    }
}
