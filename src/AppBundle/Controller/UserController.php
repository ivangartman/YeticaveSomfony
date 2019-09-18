<?php


namespace AppBundle\Controller;


use AppBundle\Entity\Users;
use AppBundle\Form\UsersType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

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

    /**
     * @Route("/login", name="login")
     * @param   Request              $request
     * @param   AuthenticationUtils  $authUtils
     *
     * @return Response
     */
    public function loginAction(Request $request, AuthenticationUtils $authUtils)
    {
        //Проверка выполнения входа пользователем
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException('Вход в систему уже выполнен');
        }

        $categories = $this
            ->getDoctrine()
            ->getRepository('AppBundle:Category')
            ->findCategory()
        ;

            // получить ошибку входа, если она есть
            $error = $authUtils->getLastAuthenticationError();
            // последнее имя пользователя, введенное пользователем
            $lastUsername = $authUtils->getLastUsername();

        return $this->render('@App/users/login.html.twig', array(
            'categories' => $categories,
            'searchMessage' => '',
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction()
    {

    }
}
