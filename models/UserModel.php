<?php
// declare namespace
namespace Model;

/**
 * User model
 */
class UserModel
{

    /**
     * Name of database user table
     * @var string
     */
    protected $table;

    /**
     * Unique ID of the user
     * @var int
     */
    protected $id;

    /**
     * User's full name
     * @var string
     */
    protected $fullname;

    /**
     * Unique username of the user
     * @var string
     */
    protected $username;

    /**
     * User's password hash
     * @var string
     */
    protected $password;

    /**
     * User's access privilege
     * @var int
     */
    protected $privilege;

    /**
     * Last login time
     * @var string
     */
    protected $last_login;

    /**
     * User's access status (whether login is blocked or not)
     * @var int
     */
    protected $status;

    /**
     * The time the account was created
     * @var string
     */
    protected $created_at;

    /**
     * Last time the user details were updated
     * @var string
     */
    protected $updated_at;

    // CONSTRUCTOR
    public function __contruct(?int $id, ?string $fullname, ?string $username, ?string $password, ?int $privilege, ?string $last_login, ?int $status, ?string $created_at, ?string $updated_at)
    {
        $this->$id = intval($id);
        $this->fullname = $fullname;
        $this->username = $username;
        $this->password = password_hash($password, PASSWORD_BCRYPT);
        $this->privilege = intval($privilege);
        $this->last_login = $last_login;
        $this->status = intval($status);
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }

    // SETTERS

    /**
     * Set user's ID
     * @param int|string $id User's ID
     */
    public function set_id($id)
    {
        $this->id = intval($id);
    }

    /**
     * Set user's full name
     * @param string $fullname User's full name
     */
    public function set_fullname($fullname)
    {
        $this->$fullname = $fullname;
    }

    /**
     * Set user's username
     * @param string $username User's username
     */
    public function set_username($username)
    {
        $this->$username = $username;
    }

    /**
     * Set user's password hash
     * @param string $password User's password
     */
    public function set_password($password)
    {
        $this->$password = password_hash($password, PASSWORD_BCRYPT);
    }

    /**
     * Set user's privilege
     * @param int|string $privilege User's privilege
     */
    public function set_privilege($privilege)
    {
        $this->$privilege = intval($privilege);
    }

    /**
     * Set user's last login time
     * @param string $last_login User's last login time
     */
    public function set_last_login($last_login)
    {
        $this->$last_login = $last_login;
    }

    /**
     * Set user's status
     * @param int|string $status User's status
     */
    public function set_status($status)
    {
        $this->$status = intval($status);
    }

    /**
     * Set user's account creation time
     * @param string $created_at User's account creation time
     */
    public function set_created_at($created_at)
    {
        $this->$created_at = $created_at;
    }

    /**
     * Set user's account update time
     * @param string $updated_at User's account update time
     */
    public function set_updated_at($updated_at)
    {
        $this->$updated_at = $updated_at;
    }

    // GETTERS

    /**
     * Return user's ID
     */
    public function get_id(): int
    {
        return $this->id;
    }

    /**
     * Return user's fullname
     */
    public function get_fullname(): string
    {
        return $this->fullname;
    }

    /**
     * Return user's username
     */
    public function get_username(): string
    {
        return $this->username;
    }

    /**
     * Return user's password hash
     */
    public function get_password(): string
    {
        return $this->password;
    }

    /**
     * Return user's privilege
     */
    public function get_privilege(): int
    {
        return $this->privilege;
    }

    /**
     * Return user's last login time
     */
    public function get_last_login(): string
    {
        return $this->last_login;
    }

    /**
     * Return user's status
     */
    public function get_status(): int
    {
        return $this->status;
    }

    /**
     * Return user's account creation time
     */
    public function get_created_at(): string
    {
        return $this->created_at;
    }

    /**
     * Return user's account update time
     */
    public function get_updated_at(): string
    {
        return $this->updated_at;
    }

    // HELPER METHODS

    /**
     * Compare clear text string with password hash
     * @param string $clear_text Clear text string
     * @return bool Returns TRUE if the password and hash match, or FALSE otherwise.
     */
    public function compare_password($clear_text): bool {
        return password_verify($clear_text, $this->password);
    }

}