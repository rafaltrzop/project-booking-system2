<?php

namespace Provider;

use Silex\Application;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Model\Users;

class UserProvider implements UserProviderInterface
{
  private $app;

  public function __construct(Application $app)
  {
    $this->app = $app;
  }

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

  public function supportsClass($class)
  {
    return $class === 'Symfony\Component\Security\Core\User\User';
  }
}
