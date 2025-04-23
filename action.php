<?php
session_start();
include("config.php");

class DataOperation extends Database
{
    public function login_method($table, $username, $password)
    {
        $sql = "SELECT * FROM $table WHERE username = :username AND password = :password";
        $stmt = $this->con->prepare($sql);
        $stmt->execute([
            ':username' => $username,
            ':password' => $password
        ]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            if (strtolower($row['usertype']) === 'admin') {
                $_SESSION['usertype'] = $row['usertype'];
                $_SESSION['userid'] = $row['userid'];
            }
            return 1;
        }
        return 0;
    }

    public function insert_record($table, $fields, $print = 0)
    {
        $columns = implode(", ", array_keys($fields));
        $placeholders = ":" . implode(", :", array_keys($fields));
        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        if ($print) {
            echo $sql;
            print_r($fields);
            die;
        }

        $stmt = $this->con->prepare($sql);
        return $stmt->execute($fields);
    }

    public function update_record($table, $where, $fields, $print = 0)
    {
        $set = "";
        foreach ($fields as $key => $value) {
            $set .= "$key = :$key, ";
        }
        $set = rtrim($set, ", ");

        $condition = "";
        foreach ($where as $key => $value) {
            $condition .= "$key = :where_$key AND ";
        }
        $condition = rtrim($condition, "AND ");

        $sql = "UPDATE $table SET $set WHERE $condition";

        if ($print) {
            echo $sql;
            die;
        }
        $params = array_merge(
            $fields,
            array_combine(
                array_map(fn($k) => "where_$k", array_keys($where)),
                array_values($where)
            )
        );

        $stmt = $this->con->prepare($sql);
        $stmt->execute($params);
        return $stmt->rowCount();
    }
    public function delete_record($table, $where, $print = 0)
    {
        $condition = "";
        foreach ($where as $key => $value) {
            $condition .= "$key = :$key AND ";
        }
        $condition = rtrim($condition, "AND ");
        $sql = "DELETE FROM $table WHERE $condition";

        if ($print) {
            echo $sql;
            die;
        }
        $stmt = $this->con->prepare($sql);
        $stmt->execute($where);
        return $stmt->rowCount();
    }

    public function select_record($table, $where, $print = 0)
    {
        $condition = "";
        foreach ($where as $key => $value) {
            $condition .= "$key = :$key AND ";
        }
        $condition = rtrim($condition, "AND ");
        $sql = "SELECT * FROM $table WHERE $condition LIMIT 1";

        if ($print) {
            echo $sql;
            die;
        }

        $stmt = $this->con->prepare($sql);
        $stmt->execute($where);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function get_user_by_email($table, $email)
    {
        $sql = "SELECT * FROM $table WHERE email = :email LIMIT 1";
        $stmt = $this->con->prepare($sql);
        $stmt->execute([':email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function getvalfield($tablename, $column, $condition, $print = 0)
{
    $sql = "SELECT $column FROM $tablename WHERE $condition LIMIT 1";
    
    if ($print == 1) {
        echo $sql;
    }

    $stmt = $this->con->prepare($sql);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row && isset($row[$column])) {
        return $row[$column];
    }

    return null;
}
public function executequery($sql)
{
    // Initialize an empty array to hold the results
    $array = array();

    // Prepare and execute the query
    try {
        // Execute the query
        $stmt = $this->con->prepare($sql);
        $stmt->execute();

        // Fetch all the rows from the query result
        $array = $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        // Handle any errors with a message
        die("Error executing query: " . $e->getMessage());
    }

    // Return the result array
    return $array;
}function test_input($data)
{
    $data = trim($data);
    $data = addslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

}

$obj = new DataOperation;
