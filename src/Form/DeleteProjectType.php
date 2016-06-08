<?php
/**
 * Delete project type.
 */

namespace Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class DeleteProjectType.
 *
 * @package Form
 */
class DeleteProjectType extends AbstractType
{
  /**
   * Form builder.
   *
   * @param FormBuilderInterface $builder Form builder
   * @param array $options Form options
   */
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder->add(
      'submit',
      'submit',
      array(
        'label' => 'project.delete-form.submit'
      )
    );
  }

  /**
   * Getter for form name.
   *
   * @return string Form name
   */
  public function getName()
  {
    return 'delete_project_form';
  }
}
