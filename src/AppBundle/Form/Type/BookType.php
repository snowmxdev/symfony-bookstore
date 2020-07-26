<?php
namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use AppBundle\Form\Model\Book;
use AppBundle\Form\Model\BookCategory;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class BookType extends AbstractType
{
    private $entityManager;

    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
          ->add('bookName', TextType::class, array(
            'label' => 'Ime knjige','attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px' )))
          ->add('author',ChoiceType::class, array(
            'label' => 'Autor','choices' => $this->getAuthorsChoice(), 'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px' )))
          ->add('publisher', ChoiceType::class, array(
           'label' => 'Izdavac', 'choices' => $this->getPublishersChoice(), 'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px' )))
          ->add('binding', ChoiceType::class, array('choices' => array('Meka' => 'Meka', 'Tvrda' => 'Tvrda'),
            'label' => 'Uvez','attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px' )))
          ->add('price', MoneyType::class, array(
            'label' => 'Cijena','attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px' )))
          ->add('pages', NumberType::class, array(
            'label' => 'Broj stranica','attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px' )))
          ->add('yearPublishing', ChoiceType::class, array(
            'label' => 'Godina izdanja','choices' => $this->buildYearChoices(), 'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px' )))
          ->add('isbn', TextType::class, array(
            'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px' )))
          ->add('description', TextType::class, array(
            'label' => 'Kratki opis','attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px' )))
          ->add('category', ChoiceType::class, array('choices' => $this->getCategoryChoice(),
            'label' => 'Kategorija','attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px' )))
          ->add('specialOffer', ChoiceType::class, array('choices' => array('Ne' => 'Ne', 'Da' => 'Da') ,
            'label' => 'Posebna ponuda', 'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px' )))
          ->add('availability', ChoiceType::class, array('choices' => array('Dostupno' => 'Dostupno', 'Nedostupno' => 'Nedostupno') ,
            'label' => 'Raspolozivost','attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px' )))
          ->add('bookCover', FileType::class, array('label' => 'Cover za knjigu (jpg datoteka)', 'required' => false ,
            'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px' )))
          ->add('save', SubmitType::class, array('label' => 'Dodaj knjigu', 'attr' => array(
            'class' => 'btn btn-primary', 'style' => 'margin-bottom:15px')));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'method' => 'post',
            'data_class' => Book::class,
        ));
    }

    public function getPublishersChoice()
    {
      $allPublishers = $this->entityManager->getRepository('AppBundle:Publisher')->findAll();
      $publisherChoices = [];
      foreach ($allPublishers as $publisher) {
        $publisherChoices[$publisher->getPublisherName()] = $publisher->getPublisherName();
      }
      return $publisherChoices;
    }

    public function buildYearChoices() {
        $distance = 60;
        $yearsBefore = date('Y', mktime(0, 0, 0, date("m"), date("d"), date("Y") - $distance));
        $yearsAfter = date('Y', mktime(0, 0, 0, date("m"), date("d"), date("Y") + 0));
        return array_combine(range($yearsBefore, $yearsAfter), range($yearsBefore, $yearsAfter));
    }

    public function getCategoryChoice()
    {
      $allCategorys = $this->entityManager->getRepository('AppBundle:BookCategory')->findAll();
      $categorysChoice = [];
      foreach ($allCategorys as $category) {
        $categorysChoice[$category->getCategoryName()] = $category->getCategoryName();
      }

      return $categorysChoice;
    }

    public function getAuthorsChoice()
    {
      $allAuthors = $this->entityManager->getRepository('AppBundle:Author')->findAll();
      $authorChoices = [];
      foreach ($allAuthors as $author) {
        $authorChoices[$author->getName()] = $author->getName();
      }

      return $authorChoices;
    }
}
