<?php
namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use AppBundle\Form\Model\BookReview;

class BookReviewType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      ->add('review',ChoiceType::class, array(
        'label' => 'Vaša ocjena: ','choices' => array(
          'Užasno loše' => 1,
          'Ima i gorih' => 2,
          'Zlatna sredina' => 3,
          'Izvrsna' => 4,
          'Rezervirati mjesto na polici' => 5), 'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px' )))

      ->add('save', SubmitType::class, array('label' => 'Postavi ocijenu', 'attr' => array(
            'class' => 'btn btn-primary', 'style' => 'margin-bottom:15px')));
  }

  public function configureOptions(OptionsResolver $resolver)
  {
      $resolver->setDefaults(array(
          'method' => 'post',
          'data_class' => BookReview::class,
          'csrf_protection' => true,
      ));
  }
}
