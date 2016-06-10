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

  public function findGroup($id)
  {
    $query = '
      SELECT g.id, name, min(user_id) AS used
      FROM groups g
      LEFT JOIN projects p ON g.id = p.group_id
      WHERE g.id = :id
    ';
    $statement = $this->db->prepare($query);
    $statement->bindValue('id', $id, \PDO::PARAM_INT);
    $statement->execute();
    $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

    return current($result);
  }

  public function findAllGroups()
  {
    $query = 'SELECT id, name FROM groups';
    $result = $this->db->fetchAll($query);
    return $result;
  }

  public function findGroupsForMod($modUserId)
  {
    $query = '
      SELECT g.id, name, min(user_id) AS used
      FROM groups g
      LEFT JOIN projects p ON g.id = p.group_id
      WHERE mod_user_id = :mod_user_id
      GROUP BY g.id
      ORDER BY name
    ';
    $statement = $this->db->prepare($query);
    $statement->bindValue('mod_user_id', $modUserId, \PDO::PARAM_INT);
    $statement->execute();
    $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

    return $result;
  }

  public function createGroup($groupData)
  {
    $query = '
      INSERT INTO groups(name, mod_user_id)
      VALUES (:name, :mod_user_id)
    ';
    $statement = $this->db->prepare($query);

    $statement->bindValue('name', $groupData['name'], \PDO::PARAM_STR);
    $statement->bindValue('mod_user_id', $groupData['mod_user_id'], \PDO::PARAM_INT);

    $statement->execute();
  }

  public function updateGroup($groupData)
  {
    $query = '
      UPDATE groups
      SET name = :name
      WHERE id = :id
    ';
    $statement = $this->db->prepare($query);

    $statement->bindValue('name', $groupData['name'], \PDO::PARAM_STR);
    $statement->bindValue('id', $groupData['id'], \PDO::PARAM_INT);

    $statement->execute();
  }

  public function deleteGroup($id)
  {
    $this->db->delete('groups', array('id' => $id));
  }
}
