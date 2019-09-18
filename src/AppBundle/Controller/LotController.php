<?php


namespace AppBundle\Controller;


use AppBundle\Entity\Lots;
use AppBundle\Entity\Rates;
use AppBundle\Form\LotsType;
use AppBundle\Form\RatesType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class LotController extends Controller
{
    /**
     * @Route("lot/{id}", name="lot", requirements={"id": "[0-9]+"})
     *
     * @param            $id
     *
     * @param   Request  $request
     *
     * @return Response
     */
    public function lotAction($id, Request $request)
    {
        //Получение категорий
        $categories = $this
            ->getDoctrine()
            ->getRepository('AppBundle:Category')
            ->findCategory();
        //Получение лота по ID
        $lots = $this
            ->getDoctrine()
            ->getRepository('AppBundle:Lots')
            ->findLot($id);
        if (!$lots) {
            throw $this->createNotFoundException('Product not found');
        }
        //Получение последней ставки по ID лота
        $ratesLotId = $this
            ->getDoctrine()
            ->getRepository('AppBundle:Rates')
            ->findRatesLotId($id);
        //Получение всех ставок по ID лота
        $rates = $this
            ->getDoctrine()
            ->getRepository('AppBundle:Rates')
            ->findRates($id);
        //Подсчёт минимальной ставки
        foreach ($lots as $key => $lot) {
            $priceLotMax = $lot['price'];
            $stepRate    = $lot['stepRate'];
        }
        if ($ratesLotId) {
            foreach ($ratesLotId as $key => $rate) {
                $priceMax = $rate['price'];
            }
        } else {
            $priceMax = $priceLotMax;
        }
        $minRate = $priceMax + floor(($priceMax / 100) * $stepRate);

        //Получение сущности пользователя
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        //Поиск сущности лота по ID
        $em    = $this->getDoctrine()->getManager();
        $lotId = $em->getRepository('AppBundle:Lots')->find($id);

        //Форма добавления ставки
        $rate = new Rates();
        $form = $this->createForm(RatesType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $add = $rate
                ->setLot($lotId)
                ->setUser($user)
                ->setPrice($form->get('price')->getData());

            $em = $this->getDoctrine()->getManager();
            $em->persist($add);
            $em->flush();

            return $this->redirectToRoute('lot', ['id' => $id]);
        }

        return $this->render('@App/lot/lot.html.twig', [
            'categories'    => $categories,
            'lots'          => $lots,
            'ratesLotId'    => $ratesLotId,
            'rates'         => $rates,
            'searchMessage' => '',
            'minRate'       => $minRate,
            'addRateForm'   => $form->createView(),
            'user'          => $user
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

        //Получение ID пользователя
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        //Получение категорий
        $categories = $this
            ->getDoctrine()
            ->getRepository('AppBundle:Category')
            ->findCategory();
        //Форма добавления лота
        $form = $this->createForm(LotsType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $add = $form->getData();
            $em  = $this->getDoctrine()->getManager();
            $em->persist($add);
            $em->flush();

            return $this->redirectToRoute('addLot');
        }

        //Запоминание Id пользователя
        $form->get('user')->setData($user);

        return $this->render('@App/lot/addLot.html.twig', [
            'categories'    => $categories,
            'searchMessage' => '',
            'addLotForm'    => $form->createView(),
        ]);
    }
}
