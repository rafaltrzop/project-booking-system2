<?php

namespace Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

class SubmitProjectType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder->add(
      'submit',
      'submit',
      array(
        'label' => 'project.submit-form.submit'
      )
    );
  }

  public function getName()
  {
    return 'submit_project_form';
  }
}
