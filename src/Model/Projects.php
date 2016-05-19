<?php

namespace Model;

use Silex\Application;

class Projects
{
  private $db;

  public function __construct(Application $app)
  {
    $this->db = $app['db'];
  }

  public function findAll()
  {
    // $query = 'SELECT id, topic FROM projects WHERE group_id = ?';
    $query = 'SELECT id, topic FROM projects';
    $result = $this->db->fetchAll($query);
    return $result;
  }
}
