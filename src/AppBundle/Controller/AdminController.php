<?php

namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Form\Model\Book as FormBook;
use AppBundle\Form\Type\BookType;

/**
 * AdminController klasa
 */
class AdminController extends Controller
{
  /**
   * @Route("/users", name="AppBundle_User_usersList")
   *
   * Akcija za prikaz liste korisnika
   * @return Response
   */
  public function usersListAction(Request $request)
  {
    $users = $this->get('app.user_repository')->findAll();

    return $this->render('AppBundle:User:userList.html.twig', [
        'users' => $users
    ]);
  }

  /**
   * @Route("/users/{userId}", name="AppBundle_User_userDetails")
   *
   * Akcija za prikaz pojedinog korisnika
   * @return Response
   */
  public function usersDetailsAction(Request $request, int $userId)
  {
    $user = $this->get('app.user_repository')->findUserById($userId);
    if (!$user) {
     throw $this->createNotFoundException('Korisnik nije pronadjen');
   }

   return $this->render('AppBundle:User:userDetails.html.twig', [
       'user' => $user
   ]);
  }

  /**
   * @Route("admin/users/{userId}", name="AppBundle_Admin_deleteUser")
   *
   * Akcija za brisanje korisnika
   * @return Response
   */
  public function usersDeleteAction(Request $request, int $userId)
  {
    $user = $this->get('app.user_repository')->findOneBy(array('id' => $userId));
    if (!$user) {
     throw $this->createNotFoundException('Korisnik nije pronadjen');
    }
    $em = $this->getDoctrine()->getManager();
    $em->remove($user);
    $em->flush();

    $request->getSession()
      ->getFlashBag()
      ->add('success', '- Uspješno ste izbrisali korisnika! ');

   return $this->render('AppBundle:Welcome:homepage.html.twig');
  }

  /**
   * @Route("/admin/books/{bookId}", name="AppBundle_Admin_deleteBook")
   *
   * Akcija za brisanje knjige
   * @return Response
   */
  public function deleteBookAction(Request $request, int $bookId)
  {
    $book = $this->get('app.book_repository')->findOneBy(array('id' => $bookId));
    if (!$book) {
     throw $this->createNotFoundException('Brisanje nije uspjelo');
   }

   $em = $this->getDoctrine()->getManager();
   $em->remove($book);
   $em->flush();

   $request->getSession()
     ->getFlashBag()
     ->add('success', '- Uspješno ste izbrisali knjigu! ');


   return $this->render('AppBundle:Welcome:homepage.html.twig');
  }

  /**
   * @Route("/admin/you/should/not/be/here/mortal")
   */
  public function noTimeAction(Request $request)
  {
    $array =
      '1 - napredna pretrag(zanr,autor,cijena...), elastic_search?<br/>'.
      '2 - zabranit dodavanje knjige koja nije dostupna<br/>'.
      '3 - za rating dodati zvjezdice<br/>'.
      '4 - ajax za  potvrdu narudbe(umisto da radim sa session)<br/>'.
      '5 - dodati adminu mogucnost promjene raspolozivosti knjige<br/>'.
      '6 - prikaz korisnika + njegove narudbe(ako postoje)<br/>'.
      '7 - ';

   return new Response('<html><body>Šta mi je činit...<br/>'.$array.'</body></html>');
  }
}
