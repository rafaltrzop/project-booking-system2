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

  public function findAvailableProjectsInGroup($groupId)
  {
    $query = '
      SELECT id, topic
      FROM projects
      WHERE group_id = :group_id AND user_id IS NULL
      ORDER BY topic
    ';
    $statement = $this->db->prepare($query);
    $statement->bindValue('group_id', $groupId, \PDO::PARAM_INT);
    $statement->execute();
    $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

    return $result;
  }

  public function bookProject($bookProjectData)
  {
    $query = 'UPDATE projects SET user_id = :user_id WHERE id = :id';
    $statement = $this->db->prepare($query);

    $statement->bindValue('user_id', $bookProjectData['user_id'], \PDO::PARAM_INT);
    $statement->bindValue('id', $bookProjectData['id'], \PDO::PARAM_INT);

    $statement->execute();
  }

  public function checkIfUserBookedProject($userId)
  {
    $query = 'SELECT EXISTS(SELECT * FROM projects WHERE user_id = :user_id)';
    $statement = $this->db->prepare($query);
    $statement->bindValue('user_id', $userId, \PDO::PARAM_INT);
    $statement->execute();
    $result = (bool) $statement->fetchColumn();

    return $result;
  }

  public function getCurrentUserProjectId($userId)
  {
    $query = 'SELECT id FROM projects WHERE user_id = :user_id';
    $statement = $this->db->prepare($query);
    $statement->bindValue('user_id', $userId, \PDO::PARAM_INT);
    $statement->execute();
    $result = $statement->fetchColumn();

    return $result;
  }
}
