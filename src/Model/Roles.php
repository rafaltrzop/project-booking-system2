<?php
/**
 * Roles model.
 */

namespace Model;

use Silex\Application;

/**
 * Class Roles.
 *
 * @package Model
 */
class Roles
{
  /**
   * Database object.
   *
   * @var \Doctrine\DBAL\Connection $db
   */
  private $db;

  /**
   * Object constructor.
   *
   * @param \Silex\Application $app Silex application
   */
  public function __construct(Application $app)
  {
    $this->db = $app['db'];
  }

  /**
   * Finds all roles.
   *
   * @return array Result
   */
  public function findAllRoles()
  {
    $query = 'SELECT id, name FROM roles';
    $result = $this->db->fetchAll($query);
    return $result;
  }
}
