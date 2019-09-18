<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{

    /**
     * @Route("/", name="homepage")
     *
     */
    public function indexAction()
    {
        $categories = $this
          ->getDoctrine()
          ->getRepository('AppBundle:Category')
          ->findCategory();
        $lots = $this
          ->getDoctrine()
          ->getRepository('AppBundle:Lots')
          ->findLots();

        return $this->render('@App/default/index.html.twig', [
          'categories'    => $categories,
          'lots'          => $lots,
          'searchMessage' => '',
          'catId'         => '',
        ]);
    }

}
