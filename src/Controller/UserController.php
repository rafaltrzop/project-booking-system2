<?php

namespace Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Model\Projects;
use Model\Users;

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
    $users = new Users($app);
    $userId = $users->getCurrentUserId();

    $projects = new Projects($app);
    $userBookedProject = $projects->checkIfUserBookedProject($userId);

    if ($userBookedProject) {
      return $app->redirect(
        $app['url_generator']->generate('project_submit')
      );
    } else {
      return $app->redirect(
        $app['url_generator']->generate('project_book')
      );
    }
  }
}
