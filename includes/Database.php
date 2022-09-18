<?php
const HOST = 'localhost';
const USER = 'root';
const PASS = '';
const DB = 'demo_oops_banking';

class DB
{
    public $connection = '';
    function __construct() {
        // Create connection
        $conn = new mysqli(HOST, USER, PASS, DB);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        else{
            $this->setConnection($conn);
        }
    }

    /**
     * @return mysqli|string
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * @param mysqli|string $connection
     */
    public function setConnection($connection)
    {
        $this->connection = $connection;
    }

}
