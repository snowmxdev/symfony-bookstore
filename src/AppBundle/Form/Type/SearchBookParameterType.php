<?php
namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use AppBundle\Form\Model\SearchBookParameter;


class SearchBookParameterType extends AbstractType
{
  private $entityManager;

  public function __construct($entityManager)
  {
      $this->entityManager = $entityManager;
  }

  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      ->add('priceFrom', NumberType::class, [
        'required' => false,
        'label' => false,
        'invalid_message' => 'Cijena Od mora biti broj',
        'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px' )
      ])
      ->add('priceTo', NumberType::class, [
        'required' => false,
        'label' => false,
        'invalid_message' => 'Cijena Do mora biti broj',
        'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px ' )
      ])

      ->add('author', ChoiceType::class, [
        'choices' => $this->getAuthorChoices(),
        'expanded' => false,
        'multiple' => false,
        'label' => false,
        'required' => false,
        'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px ' )
      ])
      ->add('save', SubmitType::class, array('label' => 'Pretraži', 'attr' => array(
        'class' => 'btn btn-info', 'style' => 'margin-bottom:15px')));
    ;
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults(array(
      'method' => 'get',
      'data_class' => SearchBookParameter::class,
      'csrf_protection' => false,
    ));
  }

  public function getAuthorChoices()
  {
    $allAuthors = $this->entityManager->getRepository('AppBundle:Author')->findAll();
    $authorChoices = [];
    foreach ($allAuthors as $author) {
      $authorChoices[$author->getName()] = $author->getName();
    }

    return $authorChoices;
  }

}
