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
    $query = '
      INSERT INTO submissions(user_id, project_id, submitted_at)
      VALUES (:user_id, :project_id, NOW())
    ';
    $statement = $this->db->prepare($query);

    $statement->bindValue('user_id', $userId, \PDO::PARAM_INT);
    $statement->bindValue('project_id', $projectId, \PDO::PARAM_INT);

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

  public function findAllSubmissions()
  {
    $query = '
      SELECT submitted_at, first_name, last_name, topic, mark, s.id
      FROM submissions s
      LEFT JOIN users u ON s.user_id = u.id
      LEFT JOIN projects p ON s.project_id = p.id
      ORDER BY submitted_at DESC
    ';
    $result = $this->db->fetchAll($query);
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
