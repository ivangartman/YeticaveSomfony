<?php


namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends Controller
{
    /**
     * @Route("search", name="search")
     *
     * @param   Request  $request
     *
     * @return Response
     */
    public function lotAction(Request $request)
    {
        $search = $request->query->get('search');

        $session = new Session();
        $session->invalidate();
        $session->start();

        $session->getFlashBag()->add('warning', $search);
//        $session->getFlashBag()->set('warning', 'Failed to update name');
        // отобразить ошибки
        foreach ($session->getFlashBag()->get('warning', array()) as $message) {
            $searchMessage = $message;
        }
        $categories = $this
            ->getDoctrine()
            ->getRepository('AppBundle:Category')
            ->findCategory()
        ;
        $lots = $this
            ->getDoctrine()
            ->getRepository('AppBundle:Lots')
            ->findSearch($search);
        if (!$lots) {
            throw $this->createNotFoundException('Лот не найден ');
        }
        return $this->render('@App/search/search.html.twig', [
            'categories' => $categories,
            'lots' => $lots,
//            'search' => $search,
            'searchMessage' => $searchMessage,
        ]);
    }
}
