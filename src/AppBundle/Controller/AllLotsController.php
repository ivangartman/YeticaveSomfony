<?php


namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AllLotsController extends Controller
{
    /**
     * @Route("allLot/{id}", name="allLot", requirements={"id": "[0-9]+"})
     *
     * @param $id
     *
     * @return Response
     */
    public function indexAction($id)
    {
        $categories = $this
            ->getDoctrine()
            ->getRepository('AppBundle:Category')
            ->findCategory();
        $lots  = $this
            ->getDoctrine()
            ->getRepository('AppBundle:Lots')
            ->findAllLots($id);
        if (!$lots) {
            throw $this->createNotFoundException('Product not found');
        }

        foreach ($lots as $key=>$item) {
            $catName = $item;
        }
        return $this->render('@App/allLots/allLots.html.twig', [
            'categories' => $categories,
            'lots'       => $lots,
            'catId'      => $id,
            'catName'    => $catName,
            'searchMessage' => '',
        ]);
    }
}
