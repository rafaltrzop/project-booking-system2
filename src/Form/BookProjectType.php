<?php

namespace Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

class BookProjectType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder->add(
      'project',
      'choice',
      array(
        // 'choices' => $this->groupChoices(),
        'choices' => array(
          '1' => 'Lorem ipsum dolor sit amet',
          '2' => 'Lorem ipsum dolor sit amet',
          '3' => 'Lorem ipsum dolor sit amet',
          '4' => 'Lorem ipsum dolor sit amet',
          '5' => 'Lorem ipsum dolor sit amet'
        ),
        'label' => 'user.book-project-form.project',
        'required' => true,
        'expanded' => true,
        'constraints' => array(
          new Assert\NotBlank(),
          // new Assert\Choice(
          //   array(
          //     'choices' => $this->groupIds()
          //   )
          // )
        )
      )
    );

    $builder->add(
      'submit',
      'submit',
      array(
        'label' => 'user.book-project-form.submit'
      )
    );
  }

  public function getName()
  {
    return 'book_project_form';
  }
}
