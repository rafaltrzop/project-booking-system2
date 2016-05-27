<?php

namespace Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;

class AdminController implements ControllerProviderInterface
{
  public function connect(Application $app)
  {
    $adminController = $app['controllers_factory'];
    $adminController->get('/', array($this, 'indexAction'))
      ->bind('admin');
    $adminController->get('/add', array($this, 'addAction'))
      ->bind('admin_add');
    $adminController->get('/edit', array($this, 'editAction'))
      ->bind('admin_edit');
    $adminController->get('/delete', array($this, 'deleteAction'))
      ->bind('admin_delete');
    return $adminController;
  }

  public function indexAction(Application $app, Request $request)
  {
    return $app['twig']->render('Admin/index.html.twig');
  }

  public function addAction(Application $app, Request $request)
  {
    return $app['twig']->render('Admin/add.html.twig');
  }

  public function editAction(Application $app, Request $request)
  {
    return $app['twig']->render('Admin/edit.html.twig');
  }

  public function deleteAction(Application $app, Request $request)
  {
    return $app['twig']->render('Admin/delete.html.twig');
  }
}
