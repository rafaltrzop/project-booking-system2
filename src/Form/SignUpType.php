<?php

namespace Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SignUpType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder->add(
      'firstname',
      'text',
      array(
        'label' => 'signup.form.firstname',
        'required' => true,
        'max_length' => 30,
        'attr' => array(
          'autofocus' => true
        )
      )
    );

    $builder->add(
      'lastname',
      'text',
      array(
        'label' => 'signup.form.lastname',
        'required' => true,
        'max_length' => 30
      )
    );

    $builder->add(
      'group',
      'choice',
      array(
        'choices' => array(
          '1' => '2014/2015',
          '2' => '2015/2016'
        ),
        'label' => 'signup.form.group',
        'required' => true,
        'empty_value' => ''
      )
    );

    $builder->add(
      'email',
      'email',
      array(
        'label' => 'login.form.email',
        'required' => true,
        'max_length' => 60
      )
    );

    $builder->add(
      'password',
      'password',
      array(
        'label' => 'login.form.password',
        'required' => true,
        'max_length' => 30
      )
    );

    $builder->add(
      'submit',
      'submit',
      array(
        'label' => 'signup.form.submit'
      )
    );
  }

  public function getName()
  {
    return 'signup_form';
  }
}