<?php

namespace StoreBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use StoreBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="list")
     */
    public function indexAction(Request $request)
    {
        $form = $this->createForm('StoreBundle\Form\ProductType');

        if ($form->handleRequest($request)->isValid()) {
            $this->getManager()->persist($form->getData());
            $this->getManager()->flush();

            return $this->redirectToRoute('list');
        }

        return $this->render('StoreBundle:Default:index.html.twig', [
            'products' => $this->getRepository()->findAll(),
            'form'     => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete")
     * @ParamConverter()
     */
    public function deleteAction(Request $request, Product $product)
    {
        $this->getManager()->remove($product);
        $this->getManager()->flush();

        return $this->redirectToRoute('list');
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
