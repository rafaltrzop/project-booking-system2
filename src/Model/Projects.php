<?php
/**
 * Projects model.
 */

namespace Model;

use Silex\Application;

/**
 * Class Projects.
 *
 * @package Model
 */
class Projects
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
     * Finds project by ID.
     *
     * @param integer $id Project ID
     * @return array Result
     */
    public function findProject($id)
    {
        $query = '
      SELECT id, topic, group_id, user_id
      FROM projects
      WHERE id = :id
    ';
        $statement = $this->db->prepare($query);
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return current($result);
    }

    /**
     * Finds available projects in group.
     *
     * @param integer $groupId Group ID
     * @return array Result
     */
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

    /**
     * Books project for user.
     *
     * @param array $projectData Project details
     */
    public function bookProject($projectData)
    {
        $query = 'UPDATE projects SET user_id = :user_id WHERE id = :id';
        $statement = $this->db->prepare($query);

        $statement->bindValue('user_id', $projectData['user_id'], \PDO::PARAM_INT);
        $statement->bindValue('id', $projectData['id'], \PDO::PARAM_INT);

        $statement->execute();
    }

    /**
     * Checks if user booked project.
     *
     * @param integer $userId User ID
     * @return boolean Result
     */
    public function checkIfUserBookedProject($userId)
    {
        $query = 'SELECT EXISTS(SELECT * FROM projects WHERE user_id = :user_id)';
        $statement = $this->db->prepare($query);
        $statement->bindValue('user_id', $userId, \PDO::PARAM_INT);
        $statement->execute();
        $result = (bool) $statement->fetchColumn();

        return $result;
    }

    /**
     * Gets current user project ID.
     *
     * @param integer $userId User ID
     * @return integer Result
     */
    public function getCurrentUserProjectId($userId)
    {
        $query = 'SELECT id FROM projects WHERE user_id = :user_id';
        $statement = $this->db->prepare($query);
        $statement->bindValue('user_id', $userId, \PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetchColumn();

        return $result;
    }

    /**
     * Gets project summary by user ID.
     *
     * @param integer $userId User ID
     * @return array Result
     */
    public function getProjectSummary($userId)
    {
        $query = '
      SELECT topic, submitted_at, first_name, last_name, mark
      FROM submissions s
      LEFT JOIN users u ON s.mod_user_id = u.id
      LEFT JOIN projects p ON s.project_id = p.id
      WHERE s.user_id = :user_id
    ';
        $statement = $this->db->prepare($query);
        $statement->bindValue('user_id', $userId, \PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return current($result);
    }

    /**
     * Creates new project.
     *
     * @param array $projectData Project details
     */
    public function createProject($projectData)
    {
        $query = '
      INSERT INTO projects(topic, group_id)
      VALUES (:topic, :group_id)
    ';
        $statement = $this->db->prepare($query);

        $statement->bindValue('topic', $projectData['topic'], \PDO::PARAM_STR);
        $statement->bindValue('group_id', $projectData['group_id'], \PDO::PARAM_INT);

        $statement->execute();
    }

    /**
     * Updates details of existing project.
     *
     * @param array $projectData Project details
     */
    public function updateProject($projectData)
    {
        $query = '
      UPDATE projects
      SET topic = :topic
      WHERE id = :id
    ';
        $statement = $this->db->prepare($query);

        $statement->bindValue('topic', $projectData['topic'], \PDO::PARAM_STR);
        $statement->bindValue('id', $projectData['id'], \PDO::PARAM_INT);

        $statement->execute();
    }

    /**
     * Deletes project by ID.
     *
     * @param integer $id Project ID
     */
    public function deleteProject($id)
    {
        $this->db->delete('projects', array('id' => $id));
    }

    /**
     * Finds projects overview for mod.
     *
     * @param integer $modUserId Mod ID
     * @return array Result
     */
    public function findProjectsOverviewForMod($modUserId)
    {
        $query = '
      SELECT first_name, last_name, email, name, topic
      FROM projects p
      LEFT JOIN users u ON p.user_id = u.id
      LEFT JOIN groups g ON p.group_id = g.id
      WHERE email IS NOT NULL AND mod_user_id = :mod_user_id
      ORDER BY name, first_name, last_name
    ';
        $statement = $this->db->prepare($query);
        $statement->bindValue('mod_user_id', $modUserId, \PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }

    /**
     * Finds projects from group.
     *
     * @param integer $groupId Group ID
     * @return array Result
     */
    public function findProjectsFromGroup($groupId)
    {
        $query = '
      SELECT id, topic, user_id AS reserved
      FROM projects
      WHERE group_id = :group_id
      ORDER BY topic
    ';
        $statement = $this->db->prepare($query);
        $statement->bindValue('group_id', $groupId, \PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }
}
