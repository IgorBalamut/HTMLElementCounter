<?php

require_once 'app/config/database.php';

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

    /**
     * Create DB connection      
     * 
     * @return $conn
     */ 
    public function DBConnect()
    {
        mysqli_report(MYSQLI_REPORT_STRICT); 
        // create connection
        try { 
            $conn = new mysqli(HOST, DB_USER, DB_PASSWORD, DB_NAME); 
        } catch (mysqli_sql_exception $e) { 
            error_log($e); 
            throw new Exception('ConnectionError');
        }          

        return $conn;
    }
}