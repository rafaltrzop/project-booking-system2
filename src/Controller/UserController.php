<?php

namespace Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Model\Projects;
use Model\Users;
use Model\Submissions;

class UserController implements ControllerProviderInterface
{
  public function connect(Application $app)
  {
    $userController = $app['controllers_factory'];
    $userController->get('/', array($this, 'indexAction'))
      ->bind('user');
    return $userController;
  }

  public function indexAction(Application $app, Request $request)
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
}
