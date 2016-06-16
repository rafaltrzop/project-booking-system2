<?php

namespace Model;

use Silex\Application;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

class Users
{
  private $db;
  private $securityEncoderDigest;
  private $securityTokenStorage;

  public function __construct(Application $app)
  {
    $this->db = $app['db'];
    $this->securityEncoderDigest = $app['security.encoder.digest'];
    $this->securityTokenStorage = $app['security.token_storage']->getToken();
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
        SELECT id, email, password, role_id
        FROM users
        WHERE email = :email
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
        SELECT roles.name as role
        FROM users
        INNER JOIN roles
        ON users.role_id = roles.id
        WHERE users.id = :user_id
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

  public function createUser($signUpData)
  {
    $passwordHash = $this->securityEncoderDigest->encodePassword($signUpData['password'], '');
    $query = '
      INSERT INTO users(group_id, first_name, last_name, email, password)
      VALUES (:group_id, :first_name, :last_name, :email, :password)
    ';
    $statement = $this->db->prepare($query);

    $statement->bindValue('group_id', $signUpData['group_id'], \PDO::PARAM_INT);
    $statement->bindValue('first_name', $signUpData['first_name'], \PDO::PARAM_STR);
    $statement->bindValue('last_name', $signUpData['last_name'], \PDO::PARAM_STR);
    $statement->bindValue('email', $signUpData['email'], \PDO::PARAM_STR);
    $statement->bindValue('password', $passwordHash, \PDO::PARAM_STR);

    $statement->execute();
  }

  public function updateUser($userData)
  {
    $query = '
      UPDATE users
      SET role_id = :role_id, group_id = :group_id, first_name = :first_name, last_name = :last_name, email = :email
      WHERE id = :id
    ';
    $statement = $this->db->prepare($query);

    $statement->bindValue('role_id', $userData['role_id'], \PDO::PARAM_INT);
    $statement->bindValue('group_id', $userData['group_id'], \PDO::PARAM_INT);
    $statement->bindValue('first_name', $userData['first_name'], \PDO::PARAM_STR);
    $statement->bindValue('last_name', $userData['last_name'], \PDO::PARAM_STR);
    $statement->bindValue('email', $userData['email'], \PDO::PARAM_STR);
    $statement->bindValue('id', $userData['id'], \PDO::PARAM_INT);

    $statement->execute();
  }

  public function getCurrentUserGroupId()
  {
    $email = $this->securityTokenStorage->getUser()->getUsername();

    $query = 'SELECT group_id FROM users WHERE email = :email';
    $statement = $this->db->prepare($query);
    $statement->bindValue('email', $email, \PDO::PARAM_STR);
    $statement->execute();
    $result = $statement->fetchColumn();

    return $result;
  }

  public function getCurrentUserId()
  {
    $email = $this->securityTokenStorage->getUser()->getUsername();

    $query = 'SELECT id FROM users WHERE email = :email';
    $statement = $this->db->prepare($query);
    $statement->bindValue('email', $email, \PDO::PARAM_STR);
    $statement->execute();
    $result = $statement->fetchColumn();

    return $result;
  }

  public function findAllUsers()
  {
    $query = '
      SELECT u.id, role_id, group_id, first_name, last_name, email, g.name AS group_name, r.name AS role_name
      FROM users u
      LEFT JOIN groups g ON u.group_id = g.id
      LEFT JOIN roles r ON u.role_id = r.id
      ORDER BY role_id, first_name, last_name
    ';
    $result = $this->db->fetchAll($query);
    return $result;
  }

  public function findUser($id)
  {
    $query = '
      SELECT id, role_id, group_id, first_name, last_name, email
      FROM users
      WHERE id = :id
    ';
    $statement = $this->db->prepare($query);
    $statement->bindValue('id', $id, \PDO::PARAM_INT);
    $statement->execute();
    $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

    return current($result);
  }
}
