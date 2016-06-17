<?php
/**
 * Sign up controller.
 */

namespace Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Form\UserProfileType;
use Model\Groups;
use Model\Users;

/**
 * Class SignUpController.
 *
 * @package Controller
 */
class SignUpController implements ControllerProviderInterface
{
  /**
   * Routing settings.
   *
   * @param \Silex\Application $app Silex application
   * @return \Silex\ControllerCollection Result
   */
  public function connect(Application $app)
  {
    $signUpController = $app['controllers_factory'];
    $signUpController->match('/', array($this, 'newAction'))
      ->bind('signup');
    return $signUpController;
  }

  /**
   * New action.
   *
   * @param \Silex\Application $app Silex application
   * @param \Symfony\Component\HttpFoundation\Request $request Request object
   * @return string Response
   * @todo Return value mixed because of possible redirect?
   */
  public function newAction(Application $app, Request $request)
  {
    $view = array();

    $groupModel = new Groups($app);
    $signUpForm = $app['form.factory']->createBuilder(
      new UserProfileType($groupModel->findAllGroups()),
      array(),
      array('validation_groups' => 'signup-default')
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
