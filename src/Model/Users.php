<?php

namespace Model;

use Silex\Application;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

class Users
{
  private $db;

  public function __construct(Application $app)
  {
    $this->db = $app['db'];
  }

  public function loadUserByEmail($email)
  {
    $user = $this->getUserByEmail($email);

    if (!$user || !count($user)) {
      throw new UsernameNotFoundException(
        sprintf('Username "%s" does not exist.', $email)
      );
    }

    $roles = $this->getUserRoles($user['id']);

    if (!$roles || !count($roles)) {
      throw new UsernameNotFoundException(
        sprintf('Username "%s" does not exist.', $email)
      );
    }

    return array(
      'email' => $user['email'],
      'password' => $user['password'],
      'roles' => $roles
    );
  }

  public function getUserByEmail($email)
  {
    try {
      $query = '
        SELECT
          `id`, `email`, `password`, `role_id`
        FROM
          `users`
        WHERE
          `email` = :email
      ';
      $statement = $this->db->prepare($query);
      $statement->bindValue('email', $email, \PDO::PARAM_STR);
      $statement->execute();
      $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
      return !$result ? array() : current($result);
    } catch (\PDOException $e) {
      return array();
    }
  }

  public function getUserRoles($userId)
  {
    $roles = array();
    try {
      $query = '
        SELECT
          `roles`.`name` as `role`
        FROM
          `users`
        INNER JOIN
          `roles`
        ON `users`.`role_id` = `roles`.`id`
        WHERE
          `users`.`id` = :user_id
      ';
      $statement = $this->db->prepare($query);
      $statement->bindValue('user_id', $userId, \PDO::PARAM_INT);
      $statement->execute();
      $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
      if ($result && count($result)) {
        $result = current($result);
        $roles[] = $result['role'];
      }
      return $roles;
    } catch (\PDOException $e) {
      return $roles;
    }
  }
}
