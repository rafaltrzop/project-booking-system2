<?php
/**
 * User provider.
 */

namespace Provider;

use Silex\Application;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Model\Users;

/**
 * Class UserProvider.
 *
 * @package Provider
 */
class UserProvider implements UserProviderInterface
{
  /**
   * Silex application.
   *
   * @var Application $app
   */
  private $app;

  /**
   * Object constructor.
   *
   * @param Application $app Silex application
   */
  public function __construct(Application $app)
  {
    $this->app = $app;
  }

  /**
   * Load user by username.
   *
   * @param string $email User login
   * @return User Result
   */
  public function loadUserByUsername($email)
  {
    $userModel = new Users($this->app);
    $user = $userModel->loadUserByEmail($email);
    return new User(
      $user['email'],
      $user['password'],
      $user['roles'],
      true,
      true,
      true,
      true
    );
  }

  /**
   * Refresh user.
   *
   * @param UserInterface $user User
   * @return User Result
   */
  public function refreshUser(UserInterface $user)
  {
    if (!$user instanceof User) {
      throw new UnsupportedUserException(
        sprintf(
          'Instances of "%s" are not supported.',
          get_class($user)
        )
      );
    }
    return $this->loadUserByUsername($user->getUsername());
  }

  /**
   * Check if supports selected class.
   *
   * @param string $class Class name
   * @return bool
   */
  public function supportsClass($class)
  {
    return $class === 'Symfony\Component\Security\Core\User\User';
  }
}
