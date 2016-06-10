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
   * @param Silex\Application $app Silex application
   * @return Silex\ControllerCollection Result
   */
  public function connect(Application $app)
  {
    $userController = $app['controllers_factory'];
    $userController->get('/redirect', array($this, 'redirectAction'))
      ->bind('user_redirect');
    $userController->get('/list', array($this, 'listAction'))
      ->bind('user_list');
    return $userController;
  }

  /**
   * Redirect action.
   *
   * @param Silex\Application $app Silex application
   * @param Symfony\Component\HttpFoundation\Request $request Request object
   * @return string Response
   * @todo Redirect - what return type?
   */
  public function redirectAction(Application $app, Request $request)
  {
    $userModel = new Users($app);
    $userId = $userModel->getCurrentUserId();

    $projectModel = new Projects($app);
    $userBookedProject = $projectModel->checkIfUserBookedProject($userId);

    $submissionModel = new Submissions($app);
    $userSubmittedProject = $submissionModel->checkIfUserSubmittedProject($userId);

    if($userSubmittedProject) {
      return $app->redirect(
        $app['url_generator']->generate('project_summary')
      );
    }

    if ($userBookedProject) {
      return $app->redirect(
        $app['url_generator']->generate('project_submit')
      );
    }

    return $app->redirect(
      $app['url_generator']->generate('project_book')
    );
  }

  /**
   * List action.
   *
   * @param Silex\Application $app Silex application
   * @param Symfony\Component\HttpFoundation\Request $request Request object
   * @return string Response
   */
  public function listAction(Application $app, Request $request)
  {
    $view = array();

    $userModel = new Users($app);
    $users = $userModel->findAllUsers();

    // $groupModel = new Groups($app);
    // $groups = $groupModel->findGroupsForMod($modUserId);
    //
    // $deleteForms = array();
    // foreach ($groups as $group) {
    //   $deleteForms[$group['id']] = $app['form.factory']->createBuilder(
    //     new DeleteGroupType()
    //   )->getForm()->createView();
    // }

    $view['users'] = $users;
    // $view['forms'] = $deleteForms;

    return $app['twig']->render('User/list.html.twig', $view);
  }
}
