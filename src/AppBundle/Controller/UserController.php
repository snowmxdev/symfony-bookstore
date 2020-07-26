<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User as EntityUser;
use AppBundle\Form\Model\User as FormUser;
use AppBundle\Form\Type\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class UserController extends Controller
{
  /**
   * @Route("/registration", name="AppBundle_User_userRegistration")
   *
   * Akcija za registraciju
   * @return Response
   */
  public function userRegistrationAction(Request $request)
  {
    $formUser = new FormUser();
    $form = $this->createForm(UserType::class, $formUser);
    $form->handleRequest($request);

    if($form->isSubmitted() && $form->isValid()) {

      $userEntity = new EntityUser();

      $name = $form['name']->getData();
      $surname = $form['surname']->getData();
      $email = $form['email']->getData();
      $password = $this->get('security.password_encoder')
        ->encodePassword($userEntity, $form['password']->getData());
      $now = new \DateTime('now');

      $userEntity->setName($name);
      $userEntity->setSurname($surname);
      $userEntity->setEmail($email);
      $userEntity->setPassword($password);
      $userEntity->setCreated($now);
      $userEntity->setRoles();

      $entityManager = $this->getDoctrine()->getManager();
      $entityManager->persist($userEntity);
      $entityManager->flush();

      $this->authenticateUser($userEntity);

      $request->getSession()
        ->getFlashBag()
        ->add('success', '- Uspješno ste registrirani! ');

       return $this->render('AppBundle:Welcome:homepage.html.twig', array(
         'name' => $name,
         'lastName' => $surname,
       ));
    }

    return $this->render('AppBundle:User:userRegistration.html.twig', [
      'form' => $form->createView()
    ]);
  }

  /**
   * Akcija za automatski login nakon registracije
   * @param  EntityUser $user
   */
  private function authenticateUser(EntityUser $user)
  {
      $providerKey = 'main';
      $token = new UsernamePasswordToken($user, null, $providerKey, $user->getRoles());

      $this->container->get('security.token_storage')->setToken($token);
  }

}
