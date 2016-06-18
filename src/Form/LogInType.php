<?php
/**
 * Log in form.
 */

namespace Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class LogInType.
 *
 * @package Form
 */
class LogInType extends AbstractType
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
            'email',
            'email',
            array(
                'label' => 'auth.form.email',
                'required' => true,
                'max_length' => 60,
                'attr' => array(
                    'autofocus' => true
                ),
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
                'label' => 'auth.form.password',
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
                'label' => 'auth.form.submit'
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
        return 'login_form';
    }
}
