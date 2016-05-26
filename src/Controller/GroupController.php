<?php

namespace Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Form\GroupType;

class GroupController implements ControllerProviderInterface
{
  public function connect(Application $app)
  {
    $groupController = $app['controllers_factory'];
    $groupController->match('/add', array($this, 'addAction'))
      ->bind('group_add');
    return $groupController;
  }

  public function addAction(Application $app, Request $request)
  {
    $view = array();

    // $projectModel = new Projects($app);
    // $userModel = new Users($app);

    $addForm = $app['form.factory']->createBuilder(
      new GroupType()
    )->getForm();

    $addForm->handleRequest($request);

    if ($addForm->isValid()) {
      // $bookData = $addForm->getData();
      // $bookData['user_id'] = $userModel->getCurrentUserId();
      //
      // $projectModel->bookProject($bookData);
      //
      // $app['session']->getFlashBag()->add(
      //   'message',
      //   array(
      //     'type' => 'success',
      //     'icon' => 'check',
      //     'content' => $app['translator']->trans('project.book-messages.success')
      //   )
      // );
      //
      // return $app->redirect(
      //   $app['url_generator']->generate('project_submit')
      // );
    }

    $view['form'] = $addForm->createView();

    return $app['twig']->render('Group/add.html.twig', $view);
  }
}
