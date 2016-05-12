<?php

namespace Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class LogInType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder->add(
      'email',
      'email',
      array(
        'label' => 'login.form.email',
        'required' => true,
        'max_length' => 60,
        'attr' => array(
          'autofocus' => true
        )
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
        'label' => 'login.form.submit'
      )
    );
  }

  public function getName()
  {
    return 'login_form';
  }
}
