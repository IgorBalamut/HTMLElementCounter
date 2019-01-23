<?php

require_once 'app/config/database.php';

// class for connection with config parameters
class DBConnection
{
    private $host;
    private $user;
    private $password;
    private $database;

    public function __construct()
    {
        $this->host     = HOST;
        $this->user     = DB_USER;
        $this->password = DB_PASSWORD;
        $this->database = DB_NAME;
    }

    //method to create connection with object
    private function connect()
    {
        // create connection
        $conn = new mysqli($this->host, $this->user, $this->password, $this->database);

        // check connection
        if ($conn->connect_error) {
            die("Connection failed: ".$conn->connect_error);
        }

        return $conn;
    }

    //method to create connection just with class
    public function DBConnect()
    {
        // create connection
        $conn = new mysqli(HOST, DB_USER, DB_PASSWORD, DB_NAME);

        // check connection
        if ($conn->connect_error) {
            die("Connection failed: ".$conn->connect_error);
        }

        return $conn;
    }
}