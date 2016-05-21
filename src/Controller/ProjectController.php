<?php

namespace Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Form\BookProjectType;
use Form\SubmitProjectType;
use Model\Projects;
use Model\Users;
use Model\Submissions;

class ProjectController implements ControllerProviderInterface
{
  public function connect(Application $app)
  {
    $userController = $app['controllers_factory'];
    $userController->match('/book', array($this, 'bookAction'))
      ->bind('project_book');
    $userController->match('/submit', array($this, 'submitAction'))
      ->bind('project_submit');
    return $userController;
  }

  public function bookAction(Application $app, Request $request)
  {
    $view = array();

    $projects = new Projects($app);
    $users = new Users($app);

    $bookForm = $app['form.factory']->createBuilder(
      new BookProjectType(
        $projects->findAvailableProjectsInGroup(
          $users->getCurrentUserGroupId()
        )
      )
    )->getForm();

    $bookForm->handleRequest($request);

    if ($bookForm->isValid()) {
      $bookData = $bookForm->getData();
      $bookData['user_id'] = $users->getCurrentUserId();

      $projectModel = new Projects($app);
      $projectModel->bookProject($bookData);

      $app['session']->getFlashBag()->add(
        'message',
        array(
          'type' => 'success',
          'icon' => 'check',
          'content' => $app['translator']->trans('user.book-project-messages.success')
        )
      );

      return $app->redirect(
        $app['url_generator']->generate('project_submit')
      );
    }

    $view['form'] = $bookForm->createView();

    return $app['twig']->render('Project/book.html.twig', $view);
  }

  public function submitAction(Application $app, Request $request)
  {
    $view = array();

    $submitForm = $app['form.factory']->createBuilder(
      new SubmitProjectType()
    )->getForm();

    $submitForm->handleRequest($request);

    if ($submitForm->isValid()) {
      $submitData = $submitForm->getData();

      $projects = new Projects($app);
      $users = new Users($app);

      $userId = $users->getCurrentUserId();
      $projectId = $projects->getCurrentUserProjectId($userId);
      $userBookedProject = $projects->checkIfUserBookedProject($userId);

      if ($userBookedProject) {
        $submissions = new Submissions($app);
        $submissions->add($userId, $projectId);
      }

      $app['session']->getFlashBag()->add(
        'message',
        array(
          'type' => 'success',
          'icon' => 'check',
          'content' => $app['translator']->trans('user.submit-project-messages.success')
        )
      );

      // return $app->redirect(
      //   $app['url_generator']->generate('project_summary')
      // );
    }

    $view['form'] = $submitForm->createView();

    return $app['twig']->render('Project/submit.html.twig', $view);
  }
}
