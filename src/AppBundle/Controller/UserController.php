<?php


namespace AppBundle\Controller;


use AppBundle\Entity\Users;
use AppBundle\Form\UsersType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends Controller
{
    /**
     * @Route("signUp", name="signUp")
     *
     * @param   Request                       $request
     *
     * @param   UserPasswordEncoderInterface  $passwordEncoder
     *
     * @return Response
     */
    public function signUpAction(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $categories = $this
            ->getDoctrine()
            ->getRepository('AppBundle:Category')
            ->findCategory()
        ;
        $user = new Users();
        $form = $this->createForm(UsersType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){

            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

//            $add = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
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