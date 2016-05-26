<?php

namespace Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Form\GroupType;
use Model\Groups;
use Model\Users;

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

    $addForm = $app['form.factory']->createBuilder(
      new GroupType()
    )->getForm();

    $addForm->handleRequest($request);

    if ($addForm->isValid()) {
      $addData = $addForm->getData();
      $userModel = new Users($app);
      $addData['mod_user_id'] = $userModel->getCurrentUserId();

      $groupModel = new Groups($app);
      $groupModel->createGroup($addData);

      $app['session']->getFlashBag()->add(
        'message',
        array(
          'type' => 'success',
          'icon' => 'check',
          'content' => $app['translator']->trans('group.add-messages.success')
        )
      );
    }

    $view['form'] = $addForm->createView();

    return $app['twig']->render('Group/add.html.twig', $view);
  }
}
