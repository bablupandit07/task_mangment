<?php
date_default_timezone_set('Asia/Kolkata');

class Database
{
    public $con;

    public function __construct()
    {
        $dbhost = "localhost";
        $dbuser = "root";
        $dbpass = "";
        $dbname = "task_mngt";

        try {
            $dsn = "mysql:host=$dbhost;dbname=$dbname;charset=utf8mb4";
            $this->con = new PDO($dsn, $dbuser, $dbpass);
            // Set error mode to exceptions
            $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }
}
