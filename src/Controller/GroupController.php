<?php
/**
 * Group controller.
 */

namespace Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Form\GroupType;
use Form\DeleteGroupType;
use Model\Groups;
use Model\Users;

/**
 * Class GroupController.
 *
 * @package Controller
 */
class GroupController implements ControllerProviderInterface
{
  /**
   * Routing settings.
   *
   * @param Silex\Application $app Silex application
   * @return Silex\ControllerCollection Result
   */
  public function connect(Application $app)
  {
    $groupController = $app['controllers_factory'];
    $groupController->get('/list', array($this, 'listAction'))
      ->bind('group_list');
    $groupController->match('/add', array($this, 'addAction'))
      ->bind('group_add');
    $groupController->match('/edit/{id}', array($this, 'editAction'))
      ->bind('group_edit');
    $groupController->post('/delete/{id}', array($this, 'deleteAction'))
      ->bind('group_delete');
    return $groupController;
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
    $modUserId = $userModel->getCurrentUserId();

    $groupModel = new Groups($app);
    $groups = $groupModel->findGroupsForMod($modUserId);

    $deleteForms = array();
    foreach ($groups as $group) {
      $deleteForms[$group['id']] = $app['form.factory']->createBuilder(
        new DeleteGroupType()
      )->getForm()->createView();
    }

    $view['groups'] = $groups;
    $view['forms'] = $deleteForms;

    return $app['twig']->render('Group/list.html.twig', $view);
  }

  /**
   * Add action.
   *
   * @param Silex\Application $app Silex application
   * @param Symfony\Component\HttpFoundation\Request $request Request object
   * @return string Response
   */
  public function addAction(Application $app, Request $request)
  {
    $view = array();

    $groupForm = $app['form.factory']->createBuilder(
      new GroupType()
    )->getForm();

    $groupForm->handleRequest($request);

    if ($groupForm->isValid()) {
      $groupData = $groupForm->getData();
      $userModel = new Users($app);
      $groupData['mod_user_id'] = $userModel->getCurrentUserId();

      $groupModel = new Groups($app);
      $groupModel->createGroup($groupData);

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

    $view['form'] = $groupForm->createView();

    return $app['twig']->render('Group/add.html.twig', $view);
  }

  /**
   * Edit action.
   *
   * @param Silex\Application $app Silex application
   * @param Symfony\Component\HttpFoundation\Request $request Request object
   * @return string Response
   */
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
        $app['url_generator']->generate('group_list')
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
        $app['url_generator']->generate('group_list')
      );
    }

    $view['form'] = $groupForm->createView();

    return $app['twig']->render('Group/edit.html.twig', $view);
  }

  /**
   * Delete action.
   *
   * @param Silex\Application $app Silex application
   * @param Symfony\Component\HttpFoundation\Request $request Request object
   * @return string Response
   * @todo Redirect - what return type?
   */
  public function deleteAction(Application $app, Request $request)
  {
    $id = (int) $request->get('id', 0);
    $groupModel = new Groups($app);
    $group = $groupModel->findGroup($id);

    if ($group['id'] == null) {
      $app['session']->getFlashBag()->add(
        'message',
        array(
          'type' => 'warning',
          'icon' => 'warning',
          'content' => $app['translator']->trans(
            'group.delete-messages.not-found'
          )
        )
      );
    } else {
      $groupNotUsed = $group['used'] == null;
      if ($groupNotUsed) {
        $deleteForm = $app['form.factory']->createBuilder(
          new DeleteGroupType()
        )->getForm();

        $deleteForm->handleRequest($request);

        if ($deleteForm->isValid()) {
          $groupModel->deleteGroup($id);

          $app['session']->getFlashBag()->add(
            'message',
            array(
              'type' => 'success',
              'icon' => 'check',
              'content' => $app['translator']->trans(
                'group.delete-messages.success'
              )
            )
          );
        } else {
          $app['session']->getFlashBag()->add(
            'message',
            array(
              'type' => 'alert',
              'icon' => 'times',
              'content' => $app['translator']->trans(
                'group.delete-messages.form-not-valid-error'
              )
            )
          );
        }
      } else {
        $app['session']->getFlashBag()->add(
          'message',
          array(
            'type' => 'alert',
            'icon' => 'times',
            'content' => $app['translator']->trans(
              'group.delete-messages.used-alert'
            )
          )
        );
      }
    }

    return $app->redirect(
      $app['url_generator']->generate('group_list')
    );
  }
}
