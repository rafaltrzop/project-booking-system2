<?php

namespace Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

class BookProjectType extends AbstractType
{
  private $projects;

  public function __construct($projects)
  {
    $this->projects = $projects;
  }

  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder->add(
      'id',
      'choice',
      array(
        'choices' => $this->projectChoices(),
        'label' => 'project.book-form.project',
        'required' => true,
        'expanded' => true,
        'constraints' => array(
          new Assert\NotBlank()
        )
      )
    );

    $builder->add(
      'submit',
      'submit',
      array(
        'label' => 'project.book-form.submit'
      )
    );
  }

  public function getName()
  {
    return 'book_project_form';
  }

  private function projectChoices()
  {
    $projectChoices = array();
    foreach ($this->projects as $project)
    {
      $projectChoices[$project['id']] = $project['topic'];
    }
    return $projectChoices;
  }
}
