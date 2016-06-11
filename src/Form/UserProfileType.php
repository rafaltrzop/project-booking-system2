<?php
/**
 * User profile type.
 */

namespace Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class UserProfileType.
 *
 * @package Form
 */
class UserProfileType extends AbstractType
{
  /**
   * Groups data.
   *
   * @var array $groups
   */
  private $groups;

  /**
   * Roles data.
   *
   * @var array $roles
   */
  private $roles;

  /**
   * UserProfileType constructor.
   *
   * @param array $groups Groups data
   * @param array $roles Roles data
   */
  public function __construct($groups, $roles = null)
  {
    $this->groups = $groups;
    $this->roles = $roles;
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
          new Assert\NotBlank(
            array(
              'groups' => array('signup-default', 'user-edit')
            )
          ),
          new Assert\Length(
            array(
              'groups' => array('signup-default', 'user-edit'),
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
          new Assert\NotBlank(
            array(
              'groups' => array('signup-default', 'user-edit')
            )
          ),
          new Assert\Length(
            array(
              'groups' => array('signup-default', 'user-edit'),
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
          new Assert\NotBlank(
            array(
              'groups' => array('signup-default', 'user-edit')
            )
          )
        )
      )
    );

    if (isset($options['validation_groups'])
      && count($options['validation_groups'])
      && in_array('user-edit', $options['validation_groups'])
    ) {
      $builder->add(
        'role_id',
        'choice',
        array(
          // to do: add method for gathering roles
          'choices' => $this->groupChoices(),
          'label' => 'user.edit-form.role',
          'required' => true,
          'empty_value' => '',
          'constraints' => array(
            new Assert\NotBlank(
              array(
                'groups' => array('user-edit')
              )
            )
          )
        )
      );
    }

    $builder->add(
      'email',
      'email',
      array(
        'label' => 'signup.form.email',
        'required' => true,
        'max_length' => 60,
        'constraints' => array(
          new Assert\NotBlank(
            array(
              'groups' => array('signup-default', 'user-edit')
            )
          ),
          new Assert\Email(
            array(
              'groups' => array('signup-default', 'user-edit')
            )
          ),
          new Assert\Length(
            array(
              'groups' => array('signup-default', 'user-edit'),
              'min' => 5,
              'max' => 60
            )
          )
        )
      )
    );

    if (isset($options['validation_groups'])
      && count($options['validation_groups'])
      && !in_array('user-edit', $options['validation_groups'])
    ) {
      $builder->add(
        'password',
        'repeated',
        array(
          'type' => 'password',
          'invalid_message' => 'The password fields must match.',
          'first_options'  => array('label' => 'signup.form.password'),
          'second_options' => array('label' => 'signup.form.repeat-password'),
          'options' => array(
            'required' => true,
            'max_length' => 30,
            'constraints' => array(
              new Assert\NotBlank(
                array(
                  'groups' => array('signup-default')
                )
              ),
              new Assert\Length(
                array(
                  'groups' => array('signup-default'),
                  'min' => 5,
                  'max' => 30
                )
              )
            )
          )
        )
      );
    }

    if (isset($options['validation_groups'])
      && count($options['validation_groups'])
      && in_array('user-edit', $options['validation_groups'])
    ) {
      $builder->add(
        'submit',
        'submit',
        array(
          'label' => 'user.edit-form.submit'
        )
      );
    }

    if (isset($options['validation_groups'])
      && count($options['validation_groups'])
      && !in_array('user-edit', $options['validation_groups'])
    ) {
      $builder->add(
        'submit',
        'submit',
        array(
          'label' => 'signup.form.submit'
        )
      );
    }
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

  /**
   * Sets default options for form.
   *
   * @param OptionsResolverInterface $resolver
   */
  public function setDefaultOptions(OptionsResolverInterface $resolver)
  {
    $resolver->setDefaults(
      array(
        'validation_groups' => 'signup-default',
      )
    );
  }

  /**
   * Prepares data for group choices field.
   *
   * @return array Group choices
   */
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