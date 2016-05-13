<?php

namespace Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Form\SignUpType;
use Model\Groups;

class SignUpController implements ControllerProviderInterface
{
  public function connect(Application $app)
  {
    $signUpController = $app['controllers_factory'];
    $signUpController->get('/', array($this, 'indexAction'))
      ->bind('signup');
    return $signUpController;
  }

  public function indexAction(Application $app, Request $request)
  {
    $view = array();
    $groups = new Groups($app);

    $signUpForm = $app['form.factory']
      ->createBuilder(new SignUpType($groups->findAll()))->getForm();

    $signUpForm->handleRequest($request);

    if ($signUpForm->isValid()) {
      $signUpData = $signUpForm->getData();
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

    $view['form'] = $signUpForm->createView();

    return $app['twig']->render('SignUp/index.html.twig', $view);
  }
}
