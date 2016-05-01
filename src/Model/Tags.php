<?php
/**
 * Tags model.
 *
 * @copyright (c) 2016 Tomasz Chojna
 * @link http://epi.chojna.info.pl
 */

namespace Model;

use Silex\Application;

/**
 * Class Tags.
 *
 * @package Model
 * @author Tomasz Chojna
 * @use Silex\Application
 */
class Tags
{
  /**
   * Db access object.
   *
   * @var Silex\Provider\DoctrineServiceProvider $db
   */
  private $db = null;

  /**
   * Tags constructor.
   *
   * @param Application $app Silex application object
   */
  public function __construct(Application $app)
  {
    $this->db = $app['db'];
  }

  /**
   * Find all tags.
   *
   * @return array Result
   */
  public function findAll()
  {
    $query = 'SELECT id, name FROM tags';
    $result = $this->db->fetchAll($query);
    return !$result ? array() : $result;
  }

  /**
   * Gets single tag.
   *
   * @param integer $id Record Id
   * @return array Result
   */
  public function find($id)
  {
    if ($id != '' && ctype_digit((string)$id)) {
      $query = 'SELECT id, name FROM tags WHERE id= :id';
      $statement = $this->db->prepare($query);
      $statement->bindValue('id', $id, \PDO::PARAM_INT);
      $statement->execute();
      $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
      return !$result ? array() : current($result);
    } else {
      return array();
    }
  }
}
