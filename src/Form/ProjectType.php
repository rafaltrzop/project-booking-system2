<?php
/**
 * Project type.
 */

namespace Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class ProjectType.
 *
 * @package Form
 */
class ProjectType extends AbstractType
{
  /**
   * Groups data.
   *
   * @var array $groups
   */
  private $groups;

  /**
   * ProjectType constructor.
   *
   * @param array $groups Groups data
   */
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
      'topic',
      'text',
      array(
        'label' => 'project.form.topic',
        'required' => true,
        'max_length' => 180,
        'attr' => array(
          'autofocus' => true
        ),
        'constraints' => array(
          new Assert\NotBlank(
            array(
              'groups' => array('project-default', 'project-edit')
            )
          ),
          new Assert\Length(
            array(
              'max' => 180,
              'groups' => array('project-default', 'project-edit')
            )
          )
        )
      )
    );

    if (isset($options['validation_groups'])
      && count($options['validation_groups'])
      && !in_array('project-edit', $options['validation_groups'])
    ) {
      $builder->add(
        'group_id',
        'choice',
        array(
          'choices' => $this->groupChoices(),
          'label' => 'project.form.group',
          'required' => true,
          'empty_value' => '',
          'constraints' => array(
            new Assert\NotBlank(
              array(
                'groups' => array('project-default')
              )
            )
          )
        )
      );
    }

    $builder->add(
      'submit',
      'submit',
      array(
        'label' => 'project.form.submit'
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
    return 'project_form';
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
        'validation_groups' => 'project-default',
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
