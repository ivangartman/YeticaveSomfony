<?php


namespace AppBundle\Controller;


use AppBundle\Form\LotsType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


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

    /**
     * @Route("addLot", name="addLot")
     *
     * @param   Request  $request
     *
     * @return Response
     */
    public function addLotAction(Request $request)
    {
        $categories = $this
            ->getDoctrine()
            ->getRepository('AppBundle:Category')
            ->findCategory()
        ;

        $form = $this->createForm(LotsType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $add = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($add);
            $em->flush();

            return $this->redirectToRoute('addLot');
        }

        return $this->render('@App/lot/addLot.html.twig', [
            'categories' => $categories,
            'searchMessage' => '',
            'addLotForm' => $form->createView(),
        ]);
    }
}
