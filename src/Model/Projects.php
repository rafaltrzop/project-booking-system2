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

  public function findAllProjectsInGroup($groupId)
  {
    $query = 'SELECT id, topic FROM projects WHERE group_id = :group_id ORDER BY topic';
    $statement = $this->db->prepare($query);
    $statement->bindValue('group_id', $groupId, \PDO::PARAM_INT);
    $statement->execute();
    $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

    return $result;
  }
}
