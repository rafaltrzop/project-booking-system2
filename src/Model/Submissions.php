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

  public function createSubmission($userId, $projectId)
  {
    $query = 'SELECT mod_user_id FROM groups g LEFT JOIN projects p ON g.id = p.group_id WHERE p.id = :id;';
    $statement = $this->db->prepare($query);
    $statement->bindValue('id', $projectId, \PDO::PARAM_INT);
    $statement->execute();
    $modUserId = $statement->fetchColumn();

    $query = '
      INSERT INTO submissions(user_id, project_id, submitted_at, mod_user_id)
      VALUES (:user_id, :project_id, NOW(), :mod_user_id)
    ';
    $statement = $this->db->prepare($query);

    $statement->bindValue('user_id', $userId, \PDO::PARAM_INT);
    $statement->bindValue('project_id', $projectId, \PDO::PARAM_INT);
    $statement->bindValue('mod_user_id', $modUserId, \PDO::PARAM_INT);

    $statement->execute();
  }

  public function checkIfUserSubmittedProject($userId)
  {
    $query = 'SELECT EXISTS(SELECT * FROM submissions WHERE user_id = :user_id)';
    $statement = $this->db->prepare($query);
    $statement->bindValue('user_id', $userId, \PDO::PARAM_INT);
    $statement->execute();
    $result = (bool) $statement->fetchColumn();

    return $result;
  }

  public function findSubmissionsForMod($modUserId)
  {
    $query = '
      SELECT submitted_at, first_name, last_name, topic, mark, s.id
      FROM submissions s
      LEFT JOIN users u ON s.user_id = u.id
      LEFT JOIN projects p ON s.project_id = p.id
      WHERE mod_user_id = :mod_user_id
      ORDER BY submitted_at DESC
    ';
    $statement = $this->db->prepare($query);
    $statement->bindValue('mod_user_id', $modUserId, \PDO::PARAM_INT);
    $statement->execute();
    $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

    return $result;
  }

  public function rateSubmission($rateData)
  {
    $query = '
      UPDATE submissions
      SET mark = :mark
      WHERE id = :id
    ';
    $statement = $this->db->prepare($query);

    $statement->bindValue('mark', $rateData['mark'], \PDO::PARAM_STR);
    $statement->bindValue('id', $rateData['id'], \PDO::PARAM_INT);

    $statement->execute();
  }
}
