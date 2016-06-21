<?php
/**
 * User profile type.
 */

namespace Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Silex\Application;

/**
 * Class UserProfileType.
 *
 * @package Form
 */
class UserProfileType extends AbstractType
{
  /**
   * Silex application.
   *
   * @var \Silex\Application $app
   */
    private $app;

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
     * @param \Silex\Application $app Silex application
     * @param array $groups Groups data
     * @param array $roles Roles data
     */
    public function __construct(Application $app, $groups, $roles = null)
    {
        $this->app = $app;
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

        if (isset($options['validation_groups'])
        && count($options['validation_groups'])
        && in_array('user-edit', $options['validation_groups'])
        ) {
            $builder->add(
                'role_id',
                'choice',
                array(
                    'choices' => $this->roleChoices(),
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
                            'groups' => array('signup-default')
                        )
                    )
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
                    'invalid_message' => $this->app['translator']->trans('signup.form.repeat-password-error'),
                    'first_options'  => array('label' => 'signup.form.password'),
                    'second_options' => array('label' => 'signup.form.repeat-password'),
                    'required' => true,
                    'options' => array(
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
                'password',
                'repeated',
                array(
                    'type' => 'password',
                    'invalid_message' => $this->app['translator']->trans('signup.form.repeat-password-error'),
                    'first_options'  => array('label' => 'user.edit-form.new-password'),
                    'second_options' => array('label' => 'user.edit-form.repeat-new-password'),
                    'required' => false,
                    'options' => array(
                        'max_length' => 30,
                        'constraints' => array(
                            new Assert\Length(
                                array(
                                    'groups' => array('user-edit'),
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
        foreach ($this->groups as $group) {
            $groupChoices[$group['id']] = $group['name'];
        }
        return $groupChoices;
    }

    /**
     * Prepares data for role choices field.
     *
     * @return array Role choices
     */
    private function roleChoices()
    {
        $roleChoices = array();
        foreach ($this->roles as $role) {
            $roleChoices[$role['id']] = $role['name'];
        }
        return $roleChoices;
    }
}
