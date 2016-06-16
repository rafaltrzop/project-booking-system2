<?php

namespace Model;

use Silex\Application;

class Roles
{
  private $db;

  public function __construct(Application $app)
  {
    $this->db = $app['db'];
  }

  public function findAllRoles()
  {
    $query = 'SELECT id, name FROM roles';
    $result = $this->db->fetchAll($query);
    return $result;
  }
}
