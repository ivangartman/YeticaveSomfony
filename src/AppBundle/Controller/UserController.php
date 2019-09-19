<?php


namespace AppBundle\Controller;


use AppBundle\Form\UsersType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends Controller
{
    /**
     * @Route("signUp", name="signUp")
     *
     * @param   Request  $request
     *
     * @return Response
     */
    public function signUpAction(Request $request)
    {
        $categories = $this
            ->getDoctrine()
            ->getRepository('AppBundle:Category')
            ->findCategory()
        ;

        $form = $this->createForm(UsersType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $add = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($add);
            $em->flush();
//            $this->addFlash('success', 'Saved');
            return $this->redirectToRoute('signUp');
        }

        return $this->render('@App/users/signUp.html.twig', [
            'categories' => $categories,
            'searchMessage' => '',
            'addUserForm' => $form->createView(),
        ]);
    }
}