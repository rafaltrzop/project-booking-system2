<?php

namespace Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

class ProjectType extends AbstractType
{
  private $groups;

  public function __construct($groups)
  {
    $this->groups = $groups;
  }

  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder->add(
      'id',
      'hidden'
    );

    $builder->add(
      'topic',
      'text',
      array(
        'label' => 'project.form.topic',
        'required' => true,
        'max_length' => 180,
        'attr' => array(
          'autofocus' => true
        ),
        'constraints' => array(
          new Assert\NotBlank(),
          new Assert\Length(
            array(
              'max' => 180
            )
          )
        )
      )
    );

    $builder->add(
      'group_id',
      'choice',
      array(
        'choices' => $this->groupChoices(),
        'label' => 'project.form.group',
        'required' => true,
        'empty_value' => '',
        'constraints' => array(
          new Assert\NotBlank()
        )
      )
    );

    $builder->add(
      'submit',
      'submit',
      array(
        'label' => 'project.form.submit'
      )
    );
  }

  public function getName()
  {
    return 'project_form';
  }

  private function groupChoices()
  {
    $groupChoices = array();
    foreach ($this->groups as $group)
    {
      $groupChoices[$group['id']] = $group['name'];
    }
    return $groupChoices;
  }
}
