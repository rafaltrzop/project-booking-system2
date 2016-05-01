<?php
/**
 * Simple tasks model.
 *
 * @copyright (c) 2016 Tomasz Chojna
 * @link http://epi.chojna.info.pl
 */

namespace Model;

/**
 * Class Tasks.
 *
 * @package Model
 * @author Tomasz Chojna
 */
class Tasks
{
  /**
   * Source data.
   *
   * @access private
   * @var array $data
   */
  private $data = array(
    array(
      'id' => 1,
      'name' => 'Morbi malesuada',
      'notes' => 't faucibus, diam quis ornare egesta',
      'is_active' => 1,
      'tags' => array(
        'company', 'important'
      ),
    ),
    array(
      'id' => 2,
      'name' => 'Phasellus congue',
      'notes' => 'Nunc eleifend mi ut eros sodales placerat',
      'is_active' => 1,
      'tags' => array(
        'important', 'home'
      ),
    ),
    array(
      'id' => 3,
      'name' => 'Curabitur sed enim',
      'notes' => '',
      'is_active' => 1,
      'tags' => array(
        'home'
      ),
    ),
    array(
      'id' => 4,
      'name' => 'Praesent',
      'notes' => 'Suspendisse porttitor ut libero sed suscipit',
      'is_active' => 1,
      'tags' => array(
        'home'
      ),
    ),
    array(
      'id' => 5,
      'name' => 'Maecenas euismod',
      'notes' => 'Aenean semper, tellus in cursus venenatis',
      'is_active' => 1,
      'tags' => array(
        'company'
      ),
    ),

  );

  /**
   * Tasks constructor.
   *
   * @access public
   */
  public function __construct()
  {
  }

  /**
   * Gets all tasks.
   *
   * @access public
   * @return array Result
   */
  public function findAll()
  {
    return $this->data;
  }

  /**
   * Find record by Id.
   *
   * @access public
   * @param integer $id Record Id
   * @return array Result
   */
  public function find($id)
  {
    $result = array();

    if ($id != '' && ctype_digit((string)$id)) {
      foreach ($this->data as $row) {
        if ($row['id'] == $id) {
          $result = $row;
          break;
        }
      }
    }
    return $result;
  }

}
