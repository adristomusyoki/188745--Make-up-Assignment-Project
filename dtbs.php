<?php
class Database {
    private static $instance = null;
    private $conn;

    private function __construct() {
        require_once __DIR__ . '/../constant.php';
        $this->conn = new mysqli(HOST_NAME, DB_USER, DB_PASSWORD, DB_NAME);
        if ($this->conn->connect_error) {
            die("DB Connect Error: " . $this->conn->connect_error);
        }
    }

    public static function getConnection() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance->conn;
    }
}
?>
