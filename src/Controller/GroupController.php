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
    $groupController->get('/', array($this, 'indexAction'))
      ->bind('group');
    $groupController->match('/add', array($this, 'addAction'))
      ->bind('group_add');
    $groupController->match('/edit/{id}', array($this, 'editAction'))
      ->bind('group_edit');
    $groupController->get('/delete/{id}', array($this, 'deleteAction'))
      ->bind('group_delete');
    return $groupController;
  }

  public function indexAction(Application $app, Request $request)
  {
    $view = array();

    $userModel = new Users($app);
    $modUserId = $userModel->getCurrentUserId();

    $groupModel = new Groups($app);
    $groups = $groupModel->findGroupsForMod($modUserId);

    $view['groups'] = $groups;

    return $app['twig']->render('Group/index.html.twig', $view);
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

      return $app->redirect(
        $app['url_generator']->generate('group_add')
      );
    }

    $view['form'] = $addForm->createView();

    return $app['twig']->render('Group/add.html.twig', $view);
  }

  public function editAction(Application $app, Request $request)
  {
    $view = array();

    $id = (int) $request->get('id', 0);
    $groupModel = new Groups($app);
    $group = $groupModel->findGroup($id);

    if (!$group) {
      $app['session']->getFlashBag()->add(
        'message',
        array(
          'type' => 'warning',
          'icon' => 'warning',
          'content' => $app['translator']->trans(
            'group.edit-messages.not-found'
          )
        )
      );

      return $app->redirect(
        $app['url_generator']->generate('group')
      );
    }

    $groupForm = $app['form.factory']->createBuilder(
      new GroupType(),
      $group
    )->getForm();

    $groupForm->handleRequest($request);

    if ($groupForm->isValid()) {
      $groupData = $groupForm->getData();
      $groupModel->updateGroup($groupData);

      $app['session']->getFlashBag()->add(
        'message',
        array(
          'type' => 'success',
          'icon' => 'check',
          'content' => $app['translator']->trans('group.edit-messages.success')
        )
      );

      return $app->redirect(
        $app['url_generator']->generate('group')
      );
    }

    $view['form'] = $groupForm->createView();

    return $app['twig']->render('Group/edit.html.twig', $view);
  }
}
