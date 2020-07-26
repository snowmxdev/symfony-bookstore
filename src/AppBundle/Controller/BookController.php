<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Book as EntityBook;
use AppBundle\Entity\Author as EntityAuthor;
use AppBundle\Entity\BookReview as ReviewEntity;
use AppBundle\Entity\Publisher;
use AppBundle\Entity\BookCategory;
use AppBundle\Form\Model\Book as FormBook;
use AppBundle\Form\Model\Cart as FormCart;
use AppBundle\Form\Model\BookReview as FormReview;
use AppBundle\Form\Model\SearchBookParameter;
use AppBundle\Form\Type\BookType;
use AppBundle\Form\Type\CartType;
use AppBundle\Form\Type\BookReviewType;
use AppBundle\Form\Type\SearchBookParameterType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Session\Session;

class BookController extends Controller
{
    /**
     * @Route("/books/add", name="AppBundle_Book_addBook")
     * @Security("has_role('ROLE_ADMIN')")
     *
     * Akcija za dodavanje knjige
     * @return Response
     */
    public function addBookAction(Request $request)
    {
      $formBook = new FormBook();
      $form = $this->createForm(BookType::class, $formBook);
      $form->handleRequest($request);

      if($form->isSubmitted() && $form->isValid()) {

        $formBook = $form->getData();
        $entityManager = $this->getDoctrine()->getManager();

        $entityBook = new EntityBook();
        $entityBook->setName($formBook->bookName);
        $entityBook->setBinding($formBook->binding);
        $entityBook->setPrice($formBook->price);
        $entityBook->setPages($formBook->pages);
        $entityBook->setYearPublishing($formBook->yearPublishing);
        $entityBook->setIsbn($formBook->isbn);
        $entityBook->setAvailability($formBook->availability);
        $entityBook->setDescription($formBook->description);
        $entityBook->setSpecialOffer($formBook->specialOffer);
        //naci id Publisher i category
        $publisher = $entityManager->getRepository('AppBundle:Publisher')->findPublisherByName($formBook->publisher);
        $category = $entityManager->getRepository('AppBundle:BookCategory')->findCategoryByName($formBook->category);
        //postavit id-ove
        $entityBook->setIdPublisher($publisher->getId());
        $entityBook->setIdCategory($category->getId());

        //dohvati id autora
        $authorName = $form['author']->getData();
        $authorRepository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Author');
        $author = $authorRepository->findAuthorByName($authorName);

        if(!$author) {
          // ako ne postoji dodati ga, ovaj dio se ne izvrsava jer je odabir preko
          // dropdowna-a, treba dodati polje za dodavanje novog autora
          $entityAuthor = new EntityAuthor();
          $entityAuthor->setName($author);
          $entityManager->persist($entityAuthor);
          $entityManager->flush();
          $authorId = $entityAuthor->getId();
        } else {
          $authorId = $author['id'];
        }

        $entityBook->setIdAuthor($authorId);
        $entityBook->setSpecialOffer($formBook->specialOffer);
        // za cover
        $coverBook = $form['bookCover']->getData();
        $coverName = $form['bookName']->getData().'.jpg';
        $coverBook->move($this->getParameter('covers_directory'),$coverName);

        $entityManager->persist($entityBook);
        $entityManager->flush();

        $request->getSession()
          ->getFlashBag()
          ->add('success', '- Uspješno ste dodali knjigu! ');

        return $this->render('AppBundle:Welcome:homepage.html.twig');
      }

      return $this->render('AppBundle:Books:addBook.html.twig', [
        'form' => $form->createView()
      ]);
    }

    /**
     * @Route("/books", name="AppBundle_Book_showBooks")
     *
     * Akcija za prikaz ponude, uz formu za filtriranje
     */
    public function showBooksAction(Request $request)
    {
      $form = $this->get('form.factory')->createNamed(null, SearchBookParameterType::class, new SearchBookParameter());
      $form->handleRequest($request);

      if($form->isSubmitted()) {
        $formData = $form->getData();
        $idAuthor = $this->get('app.author_repository')->findAuthorByName($formData->author);
        $formData->author = $idAuthor['id'];
        $books = $this->get('app.book_repository')->findByParameters($formData);
      } else {
        $books = $this->get('app.book_repository')->findAll();
      }

      return $this->render('AppBundle:Books:bookList.html.twig', [
        'books' => $books,
        'form' => $form->createView(),
      ]);
    }

    /**
    * Akcija koja servira slike smještaja.
    *
    * Ako slika ne postoji, servira se no-image.jpg slika.
    *
    * @Route("/books/image/main/{bookId}", name="AppBundle_Book_mainImage")
    */
    public function mainImageAction(int $bookId)
    {
      $book = $this->get('app.book_repository')->findBookById($bookId);
      if (!$book) {
       throw $this->createNotFoundException('Knjiga nije pronadjen');
      }
      $bookName = $book->getName();
      $imagePath = __DIR__.'/../Resources/images/covers/'.$bookName.'.jpg';
      if (!file_exists($imagePath)) {
          $imagePath = __DIR__.'/../Resources/images/covers/no-cover.jpg';
      }
      $response = new BinaryFileResponse($imagePath);
      $response->headers->set('Content-Type', 'image/jpeg');

      //  return new Response('<html><body>ss</body></html>');
      return $response;
    }

    /**
     * @Route("/books/{bookId}", name="AppBundle_Book_detailsBook")
     *
     * Akcija za prikaz knjge detaljno
     * @return Response
     */
    public function detailsBookAction(Request $request, int $bookId)
    {
      if ($this->isGranted('ROLE_USER') == false) {
        return $this->redirectToRoute('AppBundle_Security_login');
      }

      $book = $this->get('app.book_repository')->findBookById($bookId);

      if (!$book) {
       throw $this->createNotFoundException('Knjiga nije pronadena');
      }

      $author = $this->getDoctrine()->getManager()
        ->getRepository('AppBundle:Author')->findAuthorById($book->getIdAuthor());

      $publisher = $this->getDoctrine()->getManager()
        ->getRepository('AppBundle:Publisher')->findPublisherById($book->getIdPublisher());

      $category = $this->getDoctrine()->getManager()
        ->getRepository('AppBundle:BookCategory')->findCategoryById($book->getIdCategory());

      $userId= $this->get('security.token_storage')->getToken()->getUser()->getId();
      //ako je vec glasova, onda samp prikazati prosjecnu ocjenu, ako nije onda formu
      $voted = $this->get('app_book_review_repository')->isUserReviewedBook($bookId, $userId);

      $voting = "idle";

      $rating = null;

      if($voted) {
        $rating = $this->get('app_book_review_repository')->findReviewsForBook($bookId);

        $voting = 'hasRating';

        return $this->render('AppBundle:Books:book.html.twig', [
            'book' => $book,
            'author' => $author,
            'category' => $category,
            'publisher' => $publisher,
            'voting' => $voting,
            'rating' => $rating[0]['avg_rating']
        ]);
      } else {
        $voting = "noRating";

        $formReview = new FormReview();
        $form = $this->createForm(BookReviewType::class, $formReview);
        $form->handleRequest($request);

        $rating = $this->get('app_book_review_repository')->findReviewsForBook($bookId);
        if($rating) {
          $vote = 'canVote';
          $rating = $rating[0]['avg_rating'];
        }

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $formReview = $form->getData()->review;
            $bookReviewEntity = new ReviewEntity();
            $bookReviewEntity->setBookId($bookId);
            $bookReviewEntity->setUserId($userId);
            $bookReviewEntity->setReview($formReview);

            $entityManager->persist($bookReviewEntity);
            $entityManager->flush();
            $voting = 'hasRating';
            $rating = $this->get('app_book_review_repository')->findReviewsForBook($bookId);
            $rating = $rating[0]['avg_rating'];
        }
      }

      return $this->render('AppBundle:Books:book.html.twig', [
          'book' => $book,
          'author' => $author,
          'category' => $category,
          'publisher' => $publisher,
          'form' => $form->createView(),
          'voting' => $voting,
          'rating' => $rating,
          'vote' => $vote
      ]);
    }

    /**
     * @Route("/cart", name="AppBundle_Book_shopingCart")
     *
     * Akcija za prikaz kosarice
     * @return Response
     */
    public function cartAction(Request $request)
    {
      if ($this->isGranted('ROLE_USER') == false) {
        return $this->redirectToRoute('AppBundle_Security_login');
      }

      $data = $request->request->get('request');

      $session = $request->getSession();
      $arrayOfBookIDs = $session->get('BookId');

      if($arrayOfBookIDs == null) {
        $arrayOfBooks = [];
      } else {
        foreach ($arrayOfBookIDs as $bookId) {
          $book = $this->get('app.book_repository')->findBookById($bookId);
          $arrayOfBooks[] = $book;
        }
      }

      return $this->render('AppBundle:Books:shopingCart.html.twig', array(
        'books' => $arrayOfBooks,
      ));
    }


    /**
     * @Route("/cartAction/{bookId}", name="AppBundle_Book_addingToCartAction")
     *
     * Akcija za dodavanje knjige u kosaricu
     * @return Response
     */
    public function addingToCartAction(Request $request, int $bookId)
    {
      $session = $request->getSession();
      $arrayOfBookIDs = $session->get('BookId');

      if ($arrayOfBookIDs == null) {
        $arrayOfBookIDs = [];
      }

      $arrayOfBookIDs[] = $bookId;

      $session->set('BookId', $arrayOfBookIDs);

      return $this->redirectToRoute('AppBundle_Book_shopingCart');
    }

    /**
     * @Route("/cartAction/delete/{bookId}", name="AppBundle_Book_removeBookInCart")
     *
     * Akcija za brisanje knjigeiz kosarice
     * @return Response
     */
    public function removeBookInCartAction(Request $request, int $bookId)
    {
      $session = $request->getSession();
      $arrayOfBookIDs = $session->get('BookId');

      $key = array_search($bookId, $arrayOfBookIDs);

      unset($arrayOfBookIDs[$key]);
      $session->set('BookId', $arrayOfBookIDs);

      return $this->redirectToRoute('AppBundle_Book_shopingCart');
    }

    /**
     * @Route("/cart/emptyCart", name="AppBundle_Book_emptyCart")
     *
     * Akicja za brisanje svi knjiga iz kosarice
     * @return Response
     */
    public function emptyCartAction(Request $request)
    {
      $session = $request->getSession();
      $session = $session->remove('BookId');

      return $this->redirectToRoute('AppBundle_Book_shopingCart');
    }

    /**
     * @Route("/cart/order", name="AppBundle_Book_orderBook")
     *
     * Akcija za prikaz narudbe
     * @return Response
     */
    public function orderBooksAction(Request $request)
    {
      $session = $request->getSession();
      $arrayOfBookIDs = $session->get('BookId');
      $user= $this->get('security.token_storage')->getToken()->getUser();
      $totalPrice = 0;

      if($arrayOfBookIDs == null) {
        $arrayOfBooks = [];
      } else {
        foreach ($arrayOfBookIDs as $bookId) {
          $book = $this->get('app.book_repository')->findBookById($bookId);
          $arrayOfBooks[] = $book;
        }
      }

      foreach ($arrayOfBooks as $book) {
        $totalPrice += $book->getPrice();
      }

      return $this->render('AppBundle:Books:orderBook.html.twig', array(
        'books' => $arrayOfBooks,
        'user' => $user,
        'totalPrice' => $totalPrice,
      ));
    }

    /**
     * @Route("/cart/checkout", name="AppBundle_Book_checkout")
     *
     * Akcija za metodu placanje i dotavu. [NIJE IMPLEMENTIRANO]
     * @return Response
     */
    public function checkoutAction(Request $request)
    {
      return $this->render('AppBundle:Books:checkout.html.twig');
    }
}
