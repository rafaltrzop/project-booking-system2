<?php

namespace Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Form\SignUpType;
use Model\Groups;
use Model\Users;

class SignUpController implements ControllerProviderInterface
{
  public function connect(Application $app)
  {
    $signUpController = $app['controllers_factory'];
    $signUpController->match('/', array($this, 'newAction'))
      ->bind('signup');
    return $signUpController;
  }

  public function newAction(Application $app, Request $request)
  {
    $view = array();
    $groups = new Groups($app);

    $signUpForm = $app['form.factory']->createBuilder(
      new SignUpType($groups->findAll())
    )->getForm();

    $signUpForm->handleRequest($request);

    if ($signUpForm->isValid()) {
      $signUpData = $signUpForm->getData();

      $userModel = new Users($app);
      $userModel->createUser($signUpData);
      $app['session']->getFlashBag()->add(
        'message',
        array(
          'type' => 'success',
          'icon' => 'check',
          'content' => $app['translator']->trans('signup.messages.success')
        )
      );
      return $app->redirect(
        $app['url_generator']->generate('auth_login')
      );
    }

    $view['form'] = $signUpForm->createView();

    return $app['twig']->render('SignUp/new.html.twig', $view);
  }
}
