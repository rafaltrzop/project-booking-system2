<?php
/**
 * Book project type.
 */

namespace Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class BookProjectType.
 *
 * @package Form
 */
class BookProjectType extends AbstractType
{
    /**
     * Projects data.
     *
     * @var array $projects
     */
    private $projects;

    /**
     * BookProjectType constructor.
     *
     * @param array $projects Projects data
     */
    public function __construct($projects)
    {
        $this->projects = $projects;
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
            'id',
            'choice',
            array(
            'choices' => $this->projectChoices(),
            'label' => 'project.book-form.project',
            'required' => true,
            'expanded' => true,
            'constraints' => array(
            new Assert\NotBlank()
            )
            )
        );

        $builder->add(
            'submit',
            'submit',
            array(
            'label' => 'project.book-form.submit'
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
        return 'book_project_form';
    }

    /**
     * Prepares data for project choices field.
     *
     * @return array Project choices
     */
    private function projectChoices()
    {
        $projectChoices = array();
        foreach ($this->projects as $project) {
            $projectChoices[$project['id']] = $project['topic'];
        }
        return $projectChoices;
    }
}
