<?php
/**
 * User controller.
 */

namespace Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Model\Projects;
use Model\Users;
use Model\Submissions;
use Model\Groups;
use Model\Roles;
use Form\UserProfileType;
use Form\DeleteUserType;

/**
 * Class UserController.
 *
 * @package Controller
 */
class UserController implements ControllerProviderInterface
{
    /**
     * Routing settings.
     *
     * @param \Silex\Application $app Silex application
     * @return \Silex\ControllerCollection Result
     */
    public function connect(Application $app)
    {
        $userController = $app['controllers_factory'];
        $userController->get('/redirect', array($this, 'redirectAction'))
            ->bind('user_redirect');
        $userController->get('/list', array($this, 'listAction'))
            ->bind('user_list');
        $userController->match('/edit/{id}', array($this, 'editAction'))
            ->bind('user_edit');
        $userController->match('/delete/{id}', array($this, 'deleteAction'))
            ->bind('user_delete');
        return $userController;
    }

    /**
     * Redirect action.
     *
     * @param \Silex\Application $app Silex application
     * @param \Symfony\Component\HttpFoundation\Request $request Request object
     * @return RedirectResponse Response
     */
    public function redirectAction(Application $app, Request $request)
    {
        try {
            $userModel = new Users($app);
            $userId = $userModel->getCurrentUserId();

            $projectModel = new Projects($app);
            $userBookedProject = $projectModel->checkIfUserBookedProject($userId);

            $submissionModel = new Submissions($app);
            $userSubmittedProject = $submissionModel->checkIfUserSubmittedProject($userId);

            if ($userSubmittedProject) {
                return $app->redirect(
                    $app['url_generator']->generate('project_summary')
                );
            }

            if ($userBookedProject) {
                return $app->redirect(
                    $app['url_generator']->generate('project_presubmit')
                );
            }

            return $app->redirect(
                $app['url_generator']->generate('project_book')
            );
        } catch (\PDOException $e) {
            $app['session']->getFlashBag()->add(
                'message',
                array(
                    'type' => 'alert',
                    'icon' => 'times',
                    'content' => $app['translator']->trans('none.messages.db-error')
                )
            );

            return $app->redirect(
                $request->headers->get('referer')
            );
        }
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
        try {
            $view = array();

            $userModel = new Users($app);
            $users = $userModel->findAllUsers();

            $view['users'] = $users;

            return $app['twig']->render('User/list.html.twig', $view);
        } catch (\PDOException $e) {
            $app['session']->getFlashBag()->add(
                'message',
                array(
                    'type' => 'alert',
                    'icon' => 'times',
                    'content' => $app['translator']->trans('none.messages.db-error')
                )
            );

            return $app->redirect(
                $request->headers->get('referer')
            );
        }
    }

    /**
     * Edit action.
     *
     * @param \Silex\Application $app Silex application
     * @param \Symfony\Component\HttpFoundation\Request $request Request object
     * @return string Response
     */
    public function editAction(Application $app, Request $request)
    {
        try {
            $view = array();

            $id = (int) $request->get('id', 0);
            $userModel = new Users($app);
            $user = $userModel->findUser($id);

            if (!$user) {
                $app['session']->getFlashBag()->add(
                    'message',
                    array(
                        'type' => 'warning',
                        'icon' => 'warning',
                        'content' => $app['translator']->trans(
                            'user.edit-messages.not-found'
                        )
                    )
                );

                return $app->redirect(
                    $app['url_generator']->generate('user_list')
                );
            }

            $groupModel = new Groups($app);
            $roleModel = new Roles($app);
            $userProfileForm = $app['form.factory']->createBuilder(
                new UserProfileType(
                    $app,
                    $groupModel->findAllGroups(),
                    $roleModel->findAllRoles()
                ),
                $user,
                array('validation_groups' => 'user-edit')
            )->getForm();

            $userProfileForm->handleRequest($request);

            if ($userProfileForm->isValid()) {
                $userData = $userProfileForm->getData();
                $userModel->updateUser($userData);

                $app['session']->getFlashBag()->add(
                    'message',
                    array(
                        'type' => 'success',
                        'icon' => 'check',
                        'content' => $app['translator']->trans('user.edit-messages.success')
                    )
                );

                return $app->redirect(
                    $app['url_generator']->generate('user_list')
                );
            }

            $view['id'] = $id;
            $view['form'] = $userProfileForm->createView();

            return $app['twig']->render('User/edit.html.twig', $view);
        } catch (\PDOException $e) {
            $app['session']->getFlashBag()->add(
                'message',
                array(
                    'type' => 'alert',
                    'icon' => 'times',
                    'content' => $app['translator']->trans('none.messages.db-error')
                )
            );

            return $app->redirect(
                $request->headers->get('referer')
            );
        }
    }

    /**
     * Delete action.
     *
     * @param \Silex\Application $app Silex application
     * @param \Symfony\Component\HttpFoundation\Request $request Request object
     * @return RedirectResponse Response
     */
    public function deleteAction(Application $app, Request $request)
    {
        try {
            $view = array();

            $deleteForm = $app['form.factory']->createBuilder(
                new DeleteUserType()
            )->getForm();

            $id = (int) $request->get('id', 0);
            $userModel = new Users($app);
            $user = $userModel->findUser($id);

            if (!$user) {
                $app['session']->getFlashBag()->add(
                    'message',
                    array(
                        'type' => 'warning',
                        'icon' => 'warning',
                        'content' => $app['translator']->trans(
                            'user.delete-messages.not-found'
                        )
                    )
                );

                return $app->redirect(
                    $app['url_generator']->generate('user_list')
                );
            } else {
                $deleteForm->handleRequest($request);

                if ($deleteForm->isValid()) {
                    $userModel->deleteUser($id);

                    $app['session']->getFlashBag()->add(
                        'message',
                        array(
                            'type' => 'success',
                            'icon' => 'check',
                            'content' => $app['translator']->trans(
                                'user.delete-messages.success'
                            )
                        )
                    );

                    return $app->redirect(
                        $app['url_generator']->generate('user_list')
                    );
                }
            }

            $view['id'] = $id;
            $view['form'] = $deleteForm->createView();

            return $app['twig']->render('User/delete.html.twig', $view);
        } catch (\PDOException $e) {
            $app['session']->getFlashBag()->add(
                'message',
                array(
                    'type' => 'alert',
                    'icon' => 'times',
                    'content' => $app['translator']->trans('none.messages.db-error')
                )
            );

            return $app->redirect(
                $request->headers->get('referer')
            );
        }
    }
}
