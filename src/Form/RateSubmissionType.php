<?php
/**
 * Rate submission type.
 */

namespace Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class RateSubmissionType.
 *
 * @package Form
 */
class RateSubmissionType extends AbstractType
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
            'id',
            'hidden',
            array(
                'required' => true,
                'constraints' => array(
                    new Assert\NotBlank()
                )
            )
        );

        $builder->add(
            'mark',
            'choice',
            array(
                'choices' => array(
                    '2.0' => '2.0',
                    '2.5' => '2.5',
                    '3.0' => '3.0',
                    '3.5' => '3.5',
                    '4.0' => '4.0',
                    '4.5' => '4.5',
                    '5.0' => '5.0'
                ),
                'label' => false,
                'required' => true,
                'empty_value' => '',
                'attr' => array(
                    'class' => 'rate-form-select'
                ),
                'constraints' => array(
                    new Assert\NotBlank()
                )
            )
        );

        $builder->add(
            'submit',
            'submit',
            array(
                'label' => 'submission.rate-form.submit'
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
        return 'rate_submission_form';
    }
}
