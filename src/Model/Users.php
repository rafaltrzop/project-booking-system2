<?php
/**
 * Users model.
 */

namespace Model;

use Silex\Application;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

/**
 * Class Users.
 *
 * @package Model
 */
class Users
{
    /**
     * Database object.
     *
     * @var \Doctrine\DBAL\Connection $db
     */
    private $db;

    /**
     * Security encoder digest object.
     *
     * @var \Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder $securityEncoderDigest
     */
    private $securityEncoderDigest;

    /**
     * Security token storage object.
     *
     * @var \Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken $securityTokenStorage
     */
    private $securityTokenStorage;

    /**
     * Object constructor.
     *
     * @param \Silex\Application $app Silex application
     */
    public function __construct(Application $app)
    {
        $this->db = $app['db'];
        $this->securityEncoderDigest = $app['security.encoder.digest'];
        $this->securityTokenStorage = $app['security.token_storage']->getToken();
    }

    /**
     * Loads user by email.
     *
     * @param string $email User email
     * @throws UsernameNotFoundException
     * @return array Result
     */
    public function loadUserByEmail($email)
    {
        $user = $this->getUserByEmail($email);

        if (!$user || !count($user)) {
            throw new UsernameNotFoundException(
                sprintf('Username "%s" does not exist.', $email)
            );
        }

        $roles = $this->getUserRoles($user['id']);

        if (!$roles || !count($roles)) {
            throw new UsernameNotFoundException(
                sprintf('Username "%s" does not exist.', $email)
            );
        }

        return array(
            'email' => $user['email'],
            'password' => $user['password'],
            'roles' => $roles
        );
    }

    /**
     * Gets user data by email.
     *
     * @param string $email User email
     * @throws \PDOException
     * @return array Result
     */
    public function getUserByEmail($email)
    {
        try {
            $query = '
                SELECT id, email, password, role_id
                FROM users
                WHERE email = :email
            ';
            $statement = $this->db->prepare($query);
            $statement->bindValue('email', $email, \PDO::PARAM_STR);
            $statement->execute();
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

            return !$result ? array() : current($result);
        } catch (\PDOException $e) {
            return array();
        }
    }

    /**
     * Gets user roles by user ID.
     *
     * @param integer $userId User ID
     * @throws \PDOException
     * @return array Result
     */
    public function getUserRoles($userId)
    {
        $roles = array();

        try {
            $query = '
                SELECT roles.name as role
                FROM users
                INNER JOIN roles
                ON users.role_id = roles.id
                WHERE users.id = :user_id
            ';
            $statement = $this->db->prepare($query);
            $statement->bindValue('user_id', $userId, \PDO::PARAM_INT);
            $statement->execute();
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

            if ($result && count($result)) {
                $result = current($result);
                $roles[] = $result['role'];
            }

            return $roles;
        } catch (\PDOException $e) {
            return $roles;
        }
    }

    /**
     * Creates new user.
     *
     * @param array $signUpData User details
     */
    public function createUser($signUpData)
    {
        $passwordHash = $this->securityEncoderDigest->encodePassword($signUpData['password'], '');
        $query = '
            INSERT INTO users(group_id, first_name, last_name, email, password)
            VALUES (:group_id, :first_name, :last_name, :email, :password)
        ';
        $statement = $this->db->prepare($query);

        $statement->bindValue('group_id', $signUpData['group_id'], \PDO::PARAM_INT);
        $statement->bindValue('first_name', $signUpData['first_name'], \PDO::PARAM_STR);
        $statement->bindValue('last_name', $signUpData['last_name'], \PDO::PARAM_STR);
        $statement->bindValue('email', $signUpData['email'], \PDO::PARAM_STR);
        $statement->bindValue('password', $passwordHash, \PDO::PARAM_STR);

        $statement->execute();
    }

    /**
     * Updates details of existing user.
     *
     * @param array $userData User details
     */
    public function updateUser($userData)
    {
        if ($userData['role_id'] == 1 || $userData['role_id'] == 2) {
            $userData['group_id'] = null;
        }

        $query = '
            UPDATE users
            SET role_id = :role_id, group_id = :group_id, first_name = :first_name,
                last_name = :last_name, email = :email
            WHERE id = :id
        ';
        $statement = $this->db->prepare($query);

        $statement->bindValue('role_id', $userData['role_id'], \PDO::PARAM_INT);
        $statement->bindValue('group_id', $userData['group_id'], \PDO::PARAM_INT);
        $statement->bindValue('first_name', $userData['first_name'], \PDO::PARAM_STR);
        $statement->bindValue('last_name', $userData['last_name'], \PDO::PARAM_STR);
        $statement->bindValue('email', $userData['email'], \PDO::PARAM_STR);
        $statement->bindValue('id', $userData['id'], \PDO::PARAM_INT);

        $statement->execute();

        if ($userData['password'] != null) {
            $passwordHash = $this->securityEncoderDigest->encodePassword($userData['password'], '');
            $this->db->update(
                'users',
                array('password' => $passwordHash),
                array('id' => $userData['id'])
            );
        }
    }

    /**
     * Gets current user group ID.
     *
     * @return integer Result
     */
    public function getCurrentUserGroupId()
    {
        $email = $this->securityTokenStorage->getUser()->getUsername();

        $query = 'SELECT group_id FROM users WHERE email = :email';
        $statement = $this->db->prepare($query);
        $statement->bindValue('email', $email, \PDO::PARAM_STR);
        $statement->execute();
        $result = $statement->fetchColumn();

        return $result;
    }

    /**
     * Gets current user ID.
     *
     * @return integer Result
     */
    public function getCurrentUserId()
    {
        $email = $this->securityTokenStorage->getUser()->getUsername();

        $query = 'SELECT id FROM users WHERE email = :email';
        $statement = $this->db->prepare($query);
        $statement->bindValue('email', $email, \PDO::PARAM_STR);
        $statement->execute();
        $result = $statement->fetchColumn();

        return $result;
    }

    /**
     * Finds all users.
     *
     * @return array Result
     */
    public function findAllUsers()
    {
        $query = '
            SELECT u.id, role_id, group_id, first_name, last_name, email, g.name AS group_name, r.name AS role_name
            FROM users u
            LEFT JOIN groups g ON u.group_id = g.id
            LEFT JOIN roles r ON u.role_id = r.id
            ORDER BY role_id, first_name, last_name
        ';
        $result = $this->db->fetchAll($query);

        return $result;
    }

    /**
     * Finds user by ID.
     *
     * @param integer $id User ID
     * @return array Result
     */
    public function findUser($id)
    {
        $query = '
            SELECT id, role_id, group_id, first_name, last_name, email
            FROM users
            WHERE id = :id
        ';
        $statement = $this->db->prepare($query);
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return current($result);
    }

    /**
     * Deletes user by ID.
     *
     * @param integer $id User ID
     */
    public function deleteUser($id)
    {
        $this->db->delete('users', array('id' => $id));
    }
}
