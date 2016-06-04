<?php

namespace Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
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
          new Assert\NotBlank(
            array(
              'groups' => array('project-default', 'project-edit')
            )
          ),
          new Assert\Length(
            array(
              'max' => 180,
              'groups' => array('project-default', 'project-edit')
            )
          )
        )
      )
    );

    if (isset($options['validation_groups'])
      && count($options['validation_groups'])
      && !in_array('project-edit', $options['validation_groups'])
    ) {
      $builder->add(
        'group_id',
        'choice',
        array(
          'choices' => $this->groupChoices(),
          'label' => 'project.form.group',
          'required' => true,
          'empty_value' => '',
          'constraints' => array(
            new Assert\NotBlank(
              array(
                'groups' => array('project-default')
              )
            )
          )
        )
      );
    }

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

  public function setDefaultOptions(OptionsResolverInterface $resolver)
  {
    $resolver->setDefaults(
      array(
        'validation_groups' => 'project-default',
      )
    );
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
