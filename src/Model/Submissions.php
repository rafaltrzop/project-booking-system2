<?php

namespace Model;

use Silex\Application;

class Submissions
{
  private $db;

  public function __construct(Application $app)
  {
    $this->db = $app['db'];
  }

  public function add($userId, $projectId)
  {
    $query = '
      INSERT INTO submissions(user_id, project_id, submitted_at)
      VALUES (:user_id, :project_id, NOW())
    ';
    $statement = $this->db->prepare($query);

    $statement->bindValue('user_id', $userId, \PDO::PARAM_INT);
    $statement->bindValue('project_id', $projectId, \PDO::PARAM_INT);

    $statement->execute();
  }
}
