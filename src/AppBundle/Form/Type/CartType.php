<?php
namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use AppBundle\Form\Model\Cart;

class CartType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      ->add('amount',ChoiceType::class, array(
        'label' => 'Vaša ocjena: ', 'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px' )))

      ->add('save', SubmitType::class, array('label' => 'Potvrdi nanna', 'attr' => array(
            'class' => 'btn btn-primary', 'style' => 'margin-bottom:15px')));
  }

  public function configureOptions(OptionsResolver $resolver)
  {
      $resolver->setDefaults(array(
          'method' => 'post',
          'data_class' => Cart::class,
          'csrf_protection' => false,
      ));
  }
}
