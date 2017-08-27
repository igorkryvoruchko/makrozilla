<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/app", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/creates", name="creates")
     */

    public function createAction(EntityManagerInterface $em)
    {

        // you can fetch the EntityManager via $this->getDoctrine()
        // or you can add an argument to your action: createAction(EntityManagerInterface $em)
        $em = $this->getDoctrine()->getManager();

        $product = new Product();
        $product->setName('dick');
        $product->setPrice(201.99);
        $product->setDescription('big dick!');

        // tells Doctrine you want to (eventually) save the Product (no queries yet)
        $em->persist($product);

        // actually executes the queries (i.e. the INSERT query)
        $em->flush();

        return new Response('Saved new product with id '.$product->getId());
    }

    /**
     * @Route("/edit", name="edit")
     */

    public function editAction()
    {
        $doctrine = $this->getDoctrine();
        $em = $doctrine->getManager();
        $em2 = $doctrine->getManager();
    }
// if you have multiple entity managers, use the registry to fetch them


    /**
     * @Route("/show/{productId}", name="show_product")
     */
    public function showAction($productId)
    {
        $product = $this->getDoctrine()
            ->getRepository(Product::class)
            ->find($productId);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$productId
            );
        }

        return new Response('this is a '.$product->getName().'<br> price: '.$product->getPrice().'<br> description: '.$product->getDescription());
        // ... do something, like pass the $product object into a template
    }

    /**
     * @Route("/show_all", name="show_all")
     */

    public function showAllAction()
    {
        $repository = $this->getDoctrine()->getRepository(Product::class);

        $product = $repository->findAll();

        return $this->render('default/index.html.twig', array('product'=>$product));

    }

    /**
     * @Route("/admin")
     */
    public function adminAction()
    {
        return new Response('<html><body>Admin page!</body></html>');
    }
}
