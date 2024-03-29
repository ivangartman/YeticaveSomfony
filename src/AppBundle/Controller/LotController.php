<?php


namespace AppBundle\Controller;


use AppBundle\Entity\Lots;
use AppBundle\Entity\Rates;
use AppBundle\Form\LotsType;
use AppBundle\Form\RatesType;
use AppBundle\Service\FileUploader;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
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
     * @param Request    $request
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
        //Получение последней ставки по ID лота (массив)
        $ratesLotId = $this
          ->getDoctrine()
          ->getRepository('AppBundle:Rates')
          ->findRatesLotId($id);
        //Получение последней ставки по ID лота (объект)
        $ratesLots = $this
          ->getDoctrine()
          ->getRepository('AppBundle:Rates')
          ->findRatesLot($id);
        //Получение всех ставок по ID лота
        $rates = $this
          ->getDoctrine()
          ->getRepository('AppBundle:Rates')
          ->findRates($id);
        //Подсчёт минимальной ставки
        $priceLotMax = '';
        foreach ($lots as $key => $lot) {
            $priceLotMax = $lot['price'];
            $stepRate = $lot['stepRate'];
        }
        $priceMax = '';
        if ($ratesLotId) {
            foreach ($ratesLotId as $key => $rate) {
                $priceMax = $rate['price'];
            }
        } else {
            $priceMax = $priceLotMax;
        }
        $minRate = $priceMax + floor(($priceMax / 100) * $stepRate);

        //Получение ID пользователя сделавшего ставку
        $ratesLot = ['user' => ['id' => 0]];
        if ($ratesLots) {
            foreach ($ratesLots as $key => $rate) {
                $ratesLot = $rate;
            }
        }

        //Получение сущности пользователя
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        //Поиск сущности лота по ID
        $em = $this->getDoctrine()->getManager();
        $lotId = $em->getRepository('AppBundle:Lots')->find($id);
        dump($lotId);
        //Форма добавления ставки
        $rate = new Rates();
        $form = $this->createForm(RatesType::class);
        $form->handleRequest($request);
        $error = '';
        if ($form->isSubmitted() && $form->isValid()) {

            if ($form->get('price')->getData() < $minRate) {
                $error = "Сделайте ставку неменее " . $minRate;
            } else {
                $add = $rate
                  ->setLot($lotId)
                  ->setUser($user)
                  ->setPrice($form->get('price')->getData());
                $em = $this->getDoctrine()->getManager();
                $em->persist($add);
                $em->flush();

                return $this->redirectToRoute('lot', ['id' => $id]);
            }
        }

        return $this->render('@App/lot/lot.html.twig', [
          'categories'    => $categories,
          'lots'          => $lots,
          'ratesLotId'    => $ratesLotId,
          'rates'         => $rates,
          'searchMessage' => '',
          'minRate'       => $minRate,
          'addRateForm'   => $form->createView(),
          'user'          => $user,
          'error'         => $error,
          'ratesLot'      => $ratesLot,
          'lotId'         => $lotId,
          'catId'         => '',
        ]);
    }

    /**
     * @Route("addLot", name="addLot")
     *
     * @param Request      $request
     *
     * @param FileUploader $fileUploader
     *
     * @return Response
     * @throws \Exception
     */
    public function addLotAction(Request $request, FileUploader $fileUploader)
    {
        //Получение ID пользователя
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        //Получение категорий
        $categories = $this
          ->getDoctrine()
          ->getRepository('AppBundle:Category')
          ->findCategory();
        //Получение текущей даты
        $tomorrow_Date = new DateTime('tomorrow');
        $errorsData = '';
        //Форма добавления лота
        $lot = new Lots();
        $form = $this->createForm(LotsType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //Валидация даты
            if ($form->get('dateEnd')->getData()->format('Y-m-d') < $tomorrow_Date->format('Y-m-d')) {
                $errorsData
                  = 'Введите дату больше текущей, хотя бы на один день';
            } else {
                //Сохранение изображения
                /** @var UploadedFile $imgFile */
                $imgFile = $form['pictureUrl']->getData();
                $imgFileName = $fileUploader->upload($imgFile);
                //Сохранение данных из формы в БД
//                $add = $form->getData();
                $add = $lot
                  ->setName($form->get('name')->getData())
                  ->setCategory($form->get('category')->getData())
                  ->setContent($form->get('content')->getData())
                  ->setPictureUrl($imgFileName)
                  ->setPrice($form->get('price')->getData())
                  ->setStepRate($form->get('stepRate')->getData())
                  ->setDateEnd($form->get('dateEnd')->getData())
                  ->setUser($user);
                $em = $this->getDoctrine()->getManager();
                $em->persist($add);
                $em->flush();

                return $this->redirectToRoute('addLot');
            }
        }
//                //Запоминание Id пользователя
//                $form->get('user')->setData($user);

        return $this->render('@App/lot/addLot.html.twig', [
          'categories'    => $categories,
          'searchMessage' => '',
          'addLotForm'    => $form->createView(),
          'errorsData'    => $errorsData,
          'catId'         => '',
        ]);
    }

}
