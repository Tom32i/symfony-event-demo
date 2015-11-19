<?php

namespace StoreBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="list")
     */
    public function indexAction(Request $request)
    {
        $form = $this->createForm('StoreBundle\Form\ProductType', null, [
            'action' => $this->generateUrl('new'),
        ]);

        return $this->render('StoreBundle:Default:index.html.twig', [
            'products' => $this->getRepository()->findAll(),
            'form'     => $form->createView(),
        ]);
    }

    /**
     * @Route("/new", name="new")
     */
    public function newAction(Request $request)
    {
        $form = $this->createForm('StoreBundle\Form\ProductType');

        if ($form->handleRequest($request)->isValid()) {
            $product = $form->getData();
            $this->getManager()->persist($product);
            $this->getManager()->flush($product);

            return $this->redirectToRoute('list');
        }

        return $this->render('StoreBundle:Default:index.html.twig', [
            'products' => $this->getRepository()->findAll(),
            'form'     => $form->createView(),
        ]);
    }

    /**
     * Get entity manager
     *
     * @return Doctrine\ORM\EntityManagerInterface
     */
    private function getManager()
    {
        return $this->getDoctrine()->getManager();
    }

    /**
     * Get product repository
     *
     * @return \Doctrine\ORM\EntityRepository
     */
    private function getRepository()
    {
        return $this->getDoctrine()->getRepository('StoreBundle\Entity\Product');
    }
}
