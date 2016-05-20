<?php

namespace Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Form\BookProjectType;
use Model\Projects;
use Model\Users;

class UserController implements ControllerProviderInterface
{
  public function connect(Application $app)
  {
    $userController = $app['controllers_factory'];
    $userController->match('/', array($this, 'bookProjectAction'))
      ->bind('user');
    return $userController;
  }

  public function bookProjectAction(Application $app, Request $request)
  {
    $view = array();
    $projects = new Projects($app);
    $users = new Users($app);

    $bookProjectForm = $app['form.factory']->createBuilder(
      new BookProjectType(
        $projects->findAvailableProjectsInGroup(
          $users->getCurrentUserGroupId()
        )
      )
    )->getForm();

    $bookProjectForm->handleRequest($request);

    if ($bookProjectForm->isValid()) {
      $bookProjectData = $bookProjectForm->getData();
      $bookProjectData['user_id'] = $users->getCurrentUserId();

      $projectModel = new Projects($app);
      $projectModel->bookProject($bookProjectData);
      $app['session']->getFlashBag()->add(
        'message',
        array(
          'type' => 'success',
          'icon' => 'check',
          'content' => $app['translator']->trans('user.book-project-messages.success')
        )
      );
      // return $app->redirect(
      //   $app['url_generator']->generate('auth_login')
      // );
    }

    $view['form'] = $bookProjectForm->createView();

    return $app['twig']->render('User/index.html.twig', $view);
  }
}
