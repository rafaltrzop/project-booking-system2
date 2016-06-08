<?php
/**
 * Sign up type.
 */

namespace Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class SignUpType.
 *
 * @package Form
 */
class SignUpType extends AbstractType
{
  private $groups;

  public function __construct($groups)
  {
    $this->groups = $groups;
  }

  /**
   * Form builder.
   *
   * @param FormBuilderInterface $builder Form builder
   * @param array $options Form options
   */
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder->add(
      'first_name',
      'text',
      array(
        'label' => 'signup.form.firstname',
        'required' => true,
        'max_length' => 30,
        'attr' => array(
          'autofocus' => true
        ),
        'constraints' => array(
          new Assert\NotBlank(),
          new Assert\Length(
            array(
              'min' => 2,
              'max' => 30
            )
          )
        )
      )
    );

    $builder->add(
      'last_name',
      'text',
      array(
        'label' => 'signup.form.lastname',
        'required' => true,
        'max_length' => 30,
        'constraints' => array(
          new Assert\NotBlank(),
          new Assert\Length(
            array(
              'min' => 2,
              'max' => 30
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
        'label' => 'signup.form.group',
        'required' => true,
        'empty_value' => '',
        'constraints' => array(
          new Assert\NotBlank()
        )
      )
    );

    $builder->add(
      'email',
      'email',
      array(
        'label' => 'signup.form.email',
        'required' => true,
        'max_length' => 60,
        'constraints' => array(
          new Assert\NotBlank(),
          new Assert\Email(),
          new Assert\Length(
            array(
              'min' => 5,
              'max' => 60
            )
          )
        )
      )
    );

    $builder->add(
      'password',
      'password',
      array(
        'label' => 'signup.form.password',
        'required' => true,
        'max_length' => 30,
        'constraints' => array(
          new Assert\NotBlank(),
          new Assert\Length(
            array(
              'min' => 5,
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
        'label' => 'signup.form.submit'
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
    return 'signup_form';
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
