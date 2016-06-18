<?php
/**
 * Project controller.
 */

namespace Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Form\BookProjectType;
use Form\SubmitProjectType;
use Form\ProjectType;
use Form\DeleteProjectType;
use Model\Projects;
use Model\Users;
use Model\Submissions;
use Model\Groups;

/**
 * Class ProjectController.
 *
 * @package Controller
 */
class ProjectController implements ControllerProviderInterface
{
    /**
     * Routing settings.
     *
     * @param \Silex\Application $app Silex application
     * @return \Silex\ControllerCollection Result
     */
    public function connect(Application $app)
    {
        $projectController = $app['controllers_factory'];
        $projectController->get('/list', array($this, 'listAction'))
            ->bind('project_list');
        $projectController->match('/book', array($this, 'bookAction'))
            ->bind('project_book');
        $projectController->match('/submit', array($this, 'submitAction'))
            ->bind('project_submit');
        $projectController->match('/summary', array($this, 'summaryAction'))
            ->bind('project_summary');
        $projectController->get('/overview', array($this, 'overviewAction'))
            ->bind('project_overview');
        $projectController->match('/add', array($this, 'addAction'))
            ->bind('project_add');
        $projectController->match('/edit/{id}', array($this, 'editAction'))
            ->bind('project_edit');
        $projectController->post('/delete/{id}', array($this, 'deleteAction'))
            ->bind('project_delete');
        return $projectController;
    }

    /**
     * List action.
     *
     * @param \Silex\Application $app Silex application
     * @param \Symfony\Component\HttpFoundation\Request $request Request object
     * @return string Response
     */
    public function listAction(Application $app, Request $request)
    {
        $view = array();

        $userModel = new Users($app);
        $modUserId = $userModel->getCurrentUserId();

        $groupModel = new Groups($app);
        $groups = $groupModel->findGroupsForMod($modUserId);

        $deleteForms = array();
        $projectModel = new Projects($app);
        foreach ($groups as &$group) {
            $group['projects'] = $projectModel->findProjectsFromGroup($group['id']);
            foreach ($group['projects'] as $project) {
                $deleteForms[$project['id']] = $app['form.factory']->createBuilder(
                    new DeleteProjectType()
                )->getForm()->createView();
            }
        }

        $view['groups'] = $groups;
        $view['forms'] = $deleteForms;

        return $app['twig']->render('Project/list.html.twig', $view);
    }

    /**
     * Book action.
     *
     * @param \Silex\Application $app Silex application
     * @param \Symfony\Component\HttpFoundation\Request $request Request object
     * @return string Response
     * @todo Return value mixed because of possible redirect?
     */
    public function bookAction(Application $app, Request $request)
    {
        $view = array();

        $projectModel = new Projects($app);
        $userModel = new Users($app);

        $bookForm = $app['form.factory']->createBuilder(
            new BookProjectType(
                $projectModel->findAvailableProjectsInGroup(
                    $userModel->getCurrentUserGroupId()
                )
            )
        )->getForm();

        $bookForm->handleRequest($request);

        if ($bookForm->isValid()) {
            $bookData = $bookForm->getData();
            $bookData['user_id'] = $userModel->getCurrentUserId();

            $projectModel->bookProject($bookData);

            $app['session']->getFlashBag()->add(
                'message',
                array(
                    'type' => 'success',
                    'icon' => 'check',
                    'content' => $app['translator']->trans('project.book-messages.success')
                )
            );

            return $app->redirect(
                $app['url_generator']->generate('project_submit')
            );
        }

        $view['form'] = $bookForm->createView();

        return $app['twig']->render('Project/book.html.twig', $view);
    }

    /**
     * Submit action.
     *
     * @param \Silex\Application $app Silex application
     * @param \Symfony\Component\HttpFoundation\Request $request Request object
     * @return string Response
     * @todo Return value mixed because of possible redirect?
     */
    public function submitAction(Application $app, Request $request)
    {
        $view = array();

        $submitForm = $app['form.factory']->createBuilder(
            new SubmitProjectType()
        )->getForm();

        $submitForm->handleRequest($request);

        if ($submitForm->isValid()) {
            $projectModel = new Projects($app);
            $userModel = new Users($app);

            $userId = $userModel->getCurrentUserId();
            $projectId = $projectModel->getCurrentUserProjectId($userId);
            $userBookedProject = $projectModel->checkIfUserBookedProject($userId);

            if ($userBookedProject) {
                $submissionModel = new Submissions($app);
                $submissionModel->createSubmission($userId, $projectId);
            }

            $app['session']->getFlashBag()->add(
                'message',
                array(
                    'type' => 'success',
                    'icon' => 'check',
                    'content' => $app['translator']->trans('project.submit-messages.success')
                )
            );

            return $app->redirect(
                $app['url_generator']->generate('project_summary')
            );
        }

        $view['form'] = $submitForm->createView();

        return $app['twig']->render('Project/submit.html.twig', $view);
    }

    /**
     * Summary action.
     *
     * @param \Silex\Application $app Silex application
     * @param \Symfony\Component\HttpFoundation\Request $request Request object
     * @return string Response
     */
    public function summaryAction(Application $app, Request $request)
    {
        $view = array();

        $userModel = new Users($app);
        $userId = $userModel->getCurrentUserId();

        $projectModel = new Projects($app);
        $view['summary'] = $projectModel->getProjectSummary($userId);

        return $app['twig']->render('Project/summary.html.twig', $view);
    }

    /**
     * Overview action.
     *
     * @param \Silex\Application $app Silex application
     * @param \Symfony\Component\HttpFoundation\Request $request Request object
     * @return string Response
     */
    public function overviewAction(Application $app, Request $request)
    {
        $view = array();

        $userModel = new Users($app);
        $modUserId = $userModel->getCurrentUserId();

        $projectModel = new Projects($app);
        $view['overview'] = $projectModel->findProjectsOverviewForMod($modUserId);

        return $app['twig']->render('Project/overview.html.twig', $view);
    }

    /**
     * Add action.
     *
     * @param \Silex\Application $app Silex application
     * @param \Symfony\Component\HttpFoundation\Request $request Request object
     * @return string Response
     * @todo Return value mixed because of possible redirect?
     */
    public function addAction(Application $app, Request $request)
    {
        $view = array();

        $userModel = new Users($app);
        $modUserId = $userModel->getCurrentUserId();

        $groupModel = new Groups($app);
        $addForm = $app['form.factory']->createBuilder(
            new ProjectType($groupModel->findGroupsForMod($modUserId)),
            array(),
            array('validation_groups' => 'project-default')
        )->getForm();

        $addForm->handleRequest($request);

        if ($addForm->isValid()) {
            $addData = $addForm->getData();

            $projectModel = new Projects($app);
            $projectModel->createProject($addData);

            $app['session']->getFlashBag()->add(
                'message',
                array(
                    'type' => 'success',
                    'icon' => 'check',
                    'content' => $app['translator']->trans('project.add-messages.success')
                )
            );

            return $app->redirect(
                $app['url_generator']->generate('project_add')
            );
        }

        $view['form'] = $addForm->createView();

        return $app['twig']->render('Project/add.html.twig', $view);
    }

    /**
     * Edit action.
     *
     * @param \Silex\Application $app Silex application
     * @param \Symfony\Component\HttpFoundation\Request $request Request object
     * @return string Response
     * @todo Return value mixed because of possible redirect?
     */
    public function editAction(Application $app, Request $request)
    {
        $view = array();

        $id = (int) $request->get('id', 0);
        $projectModel = new Projects($app);
        $project = $projectModel->findProject($id);

        if (!$project) {
            $app['session']->getFlashBag()->add(
                'message',
                array(
                    'type' => 'warning',
                    'icon' => 'warning',
                    'content' => $app['translator']->trans(
                        'project.edit-messages.not-found'
                    )
                )
            );

            return $app->redirect(
                $app['url_generator']->generate('project_list')
            );
        }

        $userModel = new Users($app);
        $modUserId = $userModel->getCurrentUserId();

        $groupModel = new Groups($app);
        $modGroups = $groupModel->findGroupsForMod($modUserId);

        $modGroupsIds = array();
        foreach ($modGroups as $modGroup) {
            $modGroupsIds[] = $modGroup['id'];
        }

        if (!in_array($project['group_id'], $modGroupsIds)) {
            $app['session']->getFlashBag()->add(
                'message',
                array(
                    'type' => 'warning',
                    'icon' => 'warning',
                    'content' => $app['translator']->trans(
                        'project.edit-messages.not-allowed'
                    )
                )
            );

            return $app->redirect(
                $app['url_generator']->generate('project_list')
            );
        }

        $projectForm = $app['form.factory']->createBuilder(
            new ProjectType($modGroups),
            $project,
            array('validation_groups' => 'project-edit')
        )->getForm();

        $projectForm->handleRequest($request);

        if ($projectForm->isValid()) {
            $projectData = $projectForm->getData();
            $projectModel->updateProject($projectData);

            $app['session']->getFlashBag()->add(
                'message',
                array(
                    'type' => 'success',
                    'icon' => 'check',
                    'content' => $app['translator']->trans('project.edit-messages.success')
                )
            );

            return $app->redirect(
                $app['url_generator']->generate('project_list')
            );
        }

        $view['form'] = $projectForm->createView();

        return $app['twig']->render('Project/edit.html.twig', $view);
    }

    /**
     * Delete action.
     *
     * @param \Silex\Application $app Silex application
     * @param \Symfony\Component\HttpFoundation\Request $request Request object
     * @return string Response
     * @todo Redirect - what return type?
     */
    public function deleteAction(Application $app, Request $request)
    {
        $id = (int) $request->get('id', 0);
        $projectModel = new Projects($app);
        $project = $projectModel->findProject($id);

        if (!$project) {
            $app['session']->getFlashBag()->add(
                'message',
                array(
                    'type' => 'warning',
                    'icon' => 'warning',
                    'content' => $app['translator']->trans(
                        'project.delete-messages.not-found'
                    )
                )
            );
        } else {
            $projectNotReserved = $project['user_id'] == null;
            if ($projectNotReserved) {
                $deleteForm = $app['form.factory']->createBuilder(
                    new DeleteProjectType()
                )->getForm();

                $deleteForm->handleRequest($request);

                if ($deleteForm->isValid()) {
                    $projectModel->deleteProject($id);

                    $app['session']->getFlashBag()->add(
                        'message',
                        array(
                            'type' => 'success',
                            'icon' => 'check',
                            'content' => $app['translator']->trans(
                                'project.delete-messages.success'
                            )
                        )
                    );
                } else {
                    $app['session']->getFlashBag()->add(
                        'message',
                        array(
                            'type' => 'alert',
                            'icon' => 'times',
                            'content' => $app['translator']->trans(
                                'project.delete-messages.form-not-valid-error'
                            )
                        )
                    );
                }
            } else {
                $app['session']->getFlashBag()->add(
                    'message',
                    array(
                        'type' => 'alert',
                        'icon' => 'times',
                        'content' => $app['translator']->trans(
                            'project.delete-messages.reserved-alert'
                        )
                    )
                );
            }
        }

        return $app->redirect(
            $app['url_generator']->generate('project_list')
        );
    }
}
