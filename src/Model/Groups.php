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

  public function findAllGroups()
  {
    $query = 'SELECT id, name FROM groups';
    $result = $this->db->fetchAll($query);
    return $result;
  }

  public function findGroupsForMod($modUserId)
  {
    $query = '
      SELECT id, name
      FROM groups
      WHERE mod_user_id = :mod_user_id
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
}
