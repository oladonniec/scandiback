<?php

namespace Configurations\DBConfig;

use \PDO;
use \PDOException;

class Database {

    private $host = 'localhost';
    private $db_name = 'scandiweb';
    private $username = 'root';
    private $password = '';
    public $conn;

    public function __construct()
    {
        $this->conn = null;

    try {
        $this->conn = new PDO('mysql:host='. $this->host . ';dbname='. $this->db_name .';', $this->username, $this->password);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $err) {
        echo 'Connection Error: '. $err->getMessage();
    }
    return $this->conn;
}
}