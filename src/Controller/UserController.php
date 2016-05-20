<?php

namespace Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Form\BookProjectType;
use Form\SubmitProjectType;
use Model\Projects;
use Model\Users;

class UserController implements ControllerProviderInterface
{
  public function connect(Application $app)
  {
    $userController = $app['controllers_factory'];
    $userController->match('/', array($this, 'indexAction'))
      ->bind('user');
    $userController->match('/book', array($this, 'bookProjectAction'))
      ->bind('user_book_project');
    $userController->match('/submit', array($this, 'submitProjectAction'))
      ->bind('user_submit_project');
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
        $app['url_generator']->generate('user_submit_project')
      );
    } else {
      return $app->redirect(
        $app['url_generator']->generate('user_book_project')
      );
    }
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
      return $app->redirect(
        $app['url_generator']->generate('user_submit_project')
      );
    }

    $view['form'] = $bookProjectForm->createView();

    return $app['twig']->render('User/book.html.twig', $view);
  }

  public function submitProjectAction(Application $app, Request $request)
  {
    $view = array();

    $projects = new Projects($app);
    $users = new Users($app);

    $submitProjectForm = $app['form.factory']->createBuilder(
      new SubmitProjectType(
        $projects->findAvailableProjectsInGroup(
          $users->getCurrentUserGroupId()
        )
      )
    )->getForm();

    $submitProjectForm->handleRequest($request);

    if ($submitProjectForm->isValid()) {
      $submitProjectData = $submitProjectForm->getData();
      $submitProjectData['user_id'] = $users->getCurrentUserId();

      $projectModel = new Projects($app);
      $projectModel->bookProject($submitProjectData);
      $app['session']->getFlashBag()->add(
        'message',
        array(
          'type' => 'success',
          'icon' => 'check',
          'content' => $app['translator']->trans('user.submit-project-messages.success')
        )
      );
      // return $app->redirect(
      //   $app['url_generator']->generate('user_overview_project')
      // );
    }

    $view['form'] = $submitProjectForm->createView();

    return $app['twig']->render('User/submit.html.twig', $view);
  }
}
