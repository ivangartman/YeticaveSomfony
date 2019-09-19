<?php


namespace AppBundle\Controller;


use AppBundle\Service\AppFunctioins;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Entity\Category;


class LotController extends Controller
{
    /**
     * @Route("lot/{id}", name="lot", requirements={"id": "[0-9]+"})
     *
     * @param $id
     *
     * @return Response
     */
    public function lotAction($id)
    {
        $categories = $this
            ->getDoctrine()
            ->getRepository('AppBundle:Category')
            ->findCategory()
        ;
        $lots = $this
            ->getDoctrine()
            ->getRepository('AppBundle:Lots')
            ->findLot($id);
        if (!$lots) {
            throw $this->createNotFoundException('Product not found');
        }
        $rates = $this
            ->getDoctrine()
            ->getRepository('AppBundle:Rates')
            ->findRates($id);
//        $min_rate = minrate($link, $page);
        return $this->render('@App/lot/lot.html.twig', [
            'categories' => $categories,
            'lots' => $lots,
            'rates' => $rates,
            'searchMessage' => '',
        ]);
    }
}
