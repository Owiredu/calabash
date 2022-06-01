<?php

// set strict types
declare(strict_types=1);

// declare namespace
namespace Config;

// require modules

// use namespaces
use PDO;


/**
 * Handles database connection opening and termination
 */
class DBConnection
{
    // set the connection parameters as constants
    const SERVERNAME = "127.0.0.1";
    const USERNAME = "root";
    const PASSWORD = "";
    const DATABASE = "teltita";
    const PORT = 3306;

    // initialize the connection object
    protected $conn = null;

    /**
     * Creates and returns a connection to the database
     * @return PDO PHP Data Object
     */
    final protected function open_connection()
    {
        try {
            // set connection options
            $options = array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            );
            // create connection object
            $this->conn = new PDO(
                "mysql:host=" . self::SERVERNAME . ";dbname=" . self::DATABASE . ";port=" . self::PORT,
                self::USERNAME,
                self::PASSWORD,
                $options
            );
            // return the connection object
            return $this->conn;
        } catch (PDOException $e) {
            // return null if the connection fails
            return null;
        }
    }

    /**
     * Closes the database connection
     */
    final protected function close_connection()
    {
        // close the connection
        $this->conn = null;
    }
}
