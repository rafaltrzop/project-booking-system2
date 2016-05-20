<?php

namespace Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

class SubmitProjectType extends AbstractType
{
  // private $projects;
  //
  // public function __construct($projects)
  // {
  //   $this->projects = $projects;
  // }

  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    // $builder->add(
    //   'id',
    //   'choice',
    //   array(
    //     'choices' => $this->projectChoices(),
    //     'label' => 'user.book-project-form.project',
    //     'required' => true,
    //     'expanded' => true,
    //     'constraints' => array(
    //       new Assert\NotBlank()
    //     )
    //   )
    // );

    $builder->add(
      'submit',
      'submit',
      array(
        'label' => 'user.submit-project-form.submit'
      )
    );
  }

  public function getName()
  {
    return 'submit_project_form';
  }

  // private function projectChoices()
  // {
  //   $projectChoices = array();
  //   foreach ($this->projects as $project)
  //   {
  //     $projectChoices[$project['id']] = $project['topic'];
  //   }
  //   return $projectChoices;
  // }
}
