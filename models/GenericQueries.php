<?php
// set strict types
declare (strict_types = 1);

// require modules
require_once __DIR__ . '/../config/DBConnection.php';

// use namespaces
use Config\DBConnection;

class GenericQueries extends DBConnection
{

    /**
     * Database connection object
     * @var PDO|null
     */
    protected $db_connection = null;

    /**
     * Database table name
     * @var string
     */
    protected string $table_name = "";

    public function __construct()
    {
        // get the database connection
        $this->db_connection = $this->open_connection();
    }

    /**
     * Inserts data
     * @param array $attrib_names An array of the class attribute names to be inserted.
     *
     * Attribute names without column names ```[ <attribute_name> ]```. Eg:
     * ```[
     * "client_email",
     * "row_id"
     * ]```
     *
     * Attribute names with column names ```[ <attribute_name> => <column_name> ]```. Eg:
     * ```[
     * "client_email" => "email",
     * "row_id" => "id"
     * ]```
     * @param bool $with_column_names Whether the array passed as the first argument contains the database table names
     * or only the attribute names of the model
     * @return bool true for success and false for failure
     */
    public function insert_data(array $attrib_names, bool $with_column_names = false): bool
    {
        /**
         * A comma separated string of column names
         * @var string
         */
        $column_names = "";
        /**
         * A comma separated string of column names
         * @var string
         */
        $column_bind_placeholders = "";

        try
        {

            if ($with_column_names) {
                // prepare statement
                foreach ($attrib_names as $attrib => $col_name) {
                    if (strlen($column_names) === 0) {
                        $column_names .= $col_name;
                        $column_bind_placeholders .= ":" . $col_name;
                    } else {
                        $column_names .= "," . $col_name;
                        $column_bind_placeholders .= ",:" . $col_name;
                    }
                }
                $stmt = $this->db_connection->prepare("INSERT INTO " . $this->table_name . " (" . $column_names . ") VALUES(" . $column_bind_placeholders . ");");

                // bind parameters
                foreach ($attrib_names as $attrib => $col_name) {
                    if (gettype($this->{$attrib}) !== "integer") {
                        $stmt->bindValue(":" . $col_name, $this->{$attrib}, PDO::PARAM_STR);
                    } else {
                        $stmt->bindValue(":" . $col_name, $this->{$attrib}, PDO::PARAM_INT);
                    }
                }

                // execute the query
                $stmt->execute();

                return true;
            } else {
                // prepare statement
                foreach ($attrib_names as $attrib) {
                    if (strlen($column_names) === 0) {
                        $column_names .= $attrib;
                        $column_bind_placeholders .= ":" . $attrib;
                    } else {
                        $column_names .= "," . $attrib;
                        $column_bind_placeholders .= ",:" . $attrib;
                    }
                }
                $stmt = $this->db_connection->prepare("INSERT INTO " . $this->table_name . " (" . $column_names . ") VALUES(" . $column_bind_placeholders . ");");

                // bind parameters
                foreach ($attrib_names as $attrib) {
                    if (gettype($this->{$attrib}) !== "integer") {
                        $stmt->bindValue(":" . $attrib, $this->{$attrib}, PDO::PARAM_STR);
                    } else {
                        $stmt->bindValue(":" . $attrib, $this->{$attrib}, PDO::PARAM_INT);
                    }
                }
                
                // execute the query
                $stmt->execute();

                return true;
            }
        } catch (PDOException $e) {
            var_dump($e->getMessage());
            return false;
        }
    }

    /**
     * Selects data
     * @param array $params_named_array A named array of the parameters to use in the where clause. Format array(ATTRIBUTE => VALUE)
     * @param array $target_attribs A array of the names of the attributes to be selected
     * @return mixed Can be a named array, null or boolean
     */
    public function select_data(array $params_named_array, array $target_attribs, $single = true): mixed
    {
        try
        {
            // set the placeholders for the prepared statement
            $where_conditions = "";
            foreach ($params_named_array as $attrib => $val) {
                $comma = strlen($where_conditions) == 0 ? "" : " AND ";
                $where_conditions .= $comma . strtoupper($attrib) . "=:" . $attrib;
            }
            # get the attributes to be selected in the string format
            $target_attribs_str = strtoupper(implode(",", $target_attribs));
            // prepare the statement
            $stmt = $this->db_connection->prepare("SELECT " . $target_attribs_str . " FROM " . $this->table_name . " WHERE " . $where_conditions . ";");
            // bind the placeholders to their corresponding values
            foreach ($params_named_array as $attrib => $val) {
                if (!is_int($val)) {
                    $stmt->bindValue(":" . $attrib, $val, PDO::PARAM_STR);
                } else {
                    $stmt->bindValue(":" . $attrib, $val, PDO::PARAM_INT);
                }
            }
            // execute the query
            $stmt->execute();
            // return the results
            if (!$single) {
                return $stmt->fetchAll();
            }
            return $stmt->fetch();
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Updates data
     * @param array $params_named_array A named array of the parameters to use in the where clause. Format array(ATTRIBUTE => VALUE)
     * @param array $targets_named_array A named array of the parameters to use in the to set the new values. Format array(ATTRIBUTE => VALUE)
     * @return bool true for success and false for failure
     */
    public function update_data(array $params_named_array, array $targets_named_array): bool
    {
        try
        {
            // create prefixes for placeholders
            $where_prefix = "W_";
            $target_prefix = "T_";
            // set the placeholders for the prepared statement
            $where_conditions = "";
            foreach ($params_named_array as $attrib => $val) {
                $comma = strlen($where_conditions) == 0 ? "" : " AND ";
                $where_conditions .= $comma . strtoupper($attrib) . "=:" . $where_prefix . $attrib;
            }
            $targets_update_str = "";
            foreach ($targets_named_array as $attrib => $val) {
                $set_and_comma = strlen($targets_update_str) == 0 ? "SET " : ", ";
                $targets_update_str .= $set_and_comma . strtoupper($attrib) . "=:" . $target_prefix . $attrib;
            }
            // prepare the statement
            $stmt = $this->db_connection->prepare("UPDATE " . $this->table_name . " " . $targets_update_str . " WHERE " . $where_conditions . ";");
            // bind the placeholders to their corresponding values
            foreach ($params_named_array as $attrib => $val) {
                if (!is_int($val)) {
                    $stmt->bindValue(":" . $where_prefix . $attrib, $val, PDO::PARAM_STR);
                } else {
                    $stmt->bindValue(":" . $where_prefix . $attrib, $val, PDO::PARAM_INT);
                }
            }
            foreach ($targets_named_array as $attrib => $val) {
                if (!is_int($val)) {
                    $stmt->bindValue(":" . $target_prefix . $attrib, $val, PDO::PARAM_STR);
                } else {
                    $stmt->bindValue(":" . $target_prefix . $attrib, $val, PDO::PARAM_INT);
                }
            }
            // execute the query
            $stmt->execute();
            // return the results
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Deletes data
     * @param array $params_named_array A named array of the parameters to use in the where clause. Format array(ATTRIBUTE => VALUE)
     * @return bool true for success and false for failure
     */
    public function delete_data(array $params_named_array): bool
    {
        try
        {
            // set the placeholders for the prepared statement
            $where_conditions = "";
            foreach ($params_named_array as $attrib => $val) {
                $comma = strlen($where_conditions) == 0 ? "" : " AND ";
                $where_conditions .= $comma . strtoupper($attrib) . "=:" . $attrib;
            }
            // prepare the statement
            $stmt = $this->db_connection->prepare("DELETE FROM " . $this->table_name . " WHERE " . $where_conditions . ";");
            // bind the placeholders to their corresponding values
            foreach ($params_named_array as $attrib => $val) {
                if (!is_int($val)) {
                    $stmt->bindValue(":" . $attrib, $val, PDO::PARAM_STR);
                } else {
                    $stmt->bindValue(":" . $attrib, $val, PDO::PARAM_INT);
                }
            }
            // execute the query
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function __destruct()
    {
        // close the database connection
        $this->close_connection();
    }

}
