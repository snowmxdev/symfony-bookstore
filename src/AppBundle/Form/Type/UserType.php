<?php
namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use AppBundle\Form\Model\User;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array('required' => false ,
              'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px' )))
            ->add('surname', TextType::class, array('required' => false,
              'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px' )))
            ->add('email', EmailType::class, array('required' => false,
              'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px' )))
            ->add('password', PasswordType::class, array('required' => false,
              'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px' )))
            ->add('save', SubmitType::class, array('label' => 'Potvrdi registraciju', 'attr' => array(
              'class' => 'btn btn-primary', 'style' => 'margin-bottom:15px')));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'method' => 'post',
            'data_class' => User::class,
            'csrf_protection' => true,
            'error_bubbling' => true,
        ));
    }
}
