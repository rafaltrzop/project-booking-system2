<?php

namespace Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

class GroupType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder->add(
      'name',
      'text',
      array(
        'label' => 'group.form.name',
        'required' => true,
        'max_length' => 30,
        'attr' => array(
          'autofocus' => true
        ),
        'constraints' => array(
          new Assert\NotBlank(),
          new Assert\Length(
            array(
              'max' => 30
            )
          )
        )
      )
    );

    $builder->add(
      'submit',
      'submit',
      array(
        'label' => 'group.form.submit'
      )
    );
  }

  public function getName()
  {
    return 'group_form';
  }
}
