<?php

namespace Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Form\LogInType;

class LogInController implements ControllerProviderInterface
{
  public function connect(Application $app)
  {
    $logInController = $app['controllers_factory'];
    $logInController->get('/', array($this, 'indexAction'))
      ->bind('login');
    return $logInController;
  }

  public function indexAction(Application $app, Request $request)
  {
    $view = array();

    $logInForm = $app['form.factory']
      ->createBuilder(new LogInType(), array())->getForm();

    $logInForm->handleRequest($request);

    if ($logInForm->isValid()) {
      $logInData = $logInForm->getData();
      // $tagModel = new Tags($app);
      // dodac obsluge bledow
      // try catch na ponizszej linii
      // $tagModel->save($tagData);
      // $app['session']->getFlashBag()->add(
      //   'message',
      //   array(
      //     'type' => 'success',
      //     'content' => $app['translator']->trans('messages.add.success')
      //   )
      // );
      // return $app->redirect(
      //   $app['url_generator']->generate('tags')
      // );
    }

    $view['form'] = $logInForm->createView();

    return $app['twig']->render('LogIn/index.html.twig', $view);
  }
}
