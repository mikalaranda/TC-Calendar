<?php
class Database
{
    var $conn = null;
    var $config = array(
        'username' => 'dechen_tc',
        'password' => 'tccalendar',
        'hostname' => 'dennischen.com',
        'database' => 'dechen_tccalendar'
    );

    function __construct() {
        $this->connect();
    }

    function connect() {
        if (is_null($this->conn)) {
            $db = $this->config;
            $this->conn = mysqli_connect($db['hostname'], $db['username'], $db['password']);
            if(!$this->conn) {
                die("Cannot connect to database server"); 
            }
            if(!mysqli_select_db($this->conn,$db['database'])) {
                die("Cannot select database");
            }
        }
        return $this->conn;
    }
}