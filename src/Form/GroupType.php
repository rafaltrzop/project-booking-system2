<?php
/**
 * Group type.
 */

namespace Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class GroupType.
 *
 * @package Form
 */
class GroupType extends AbstractType
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

  /**
   * Getter for form name.
   *
   * @return string Form name
   */
  public function getName()
  {
    return 'group_form';
  }
}
