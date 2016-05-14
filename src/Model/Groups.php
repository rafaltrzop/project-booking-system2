<?php

namespace Model;

use Silex\Application;

class Groups
{
  private $db;

  public function __construct(Application $app)
  {
    $this->db = $app['db'];
  }

  public function findAll()
  {
    $query = 'SELECT id, name FROM groups';
    $result = $this->db->fetchAll($query);
    return $result;
  }
}
