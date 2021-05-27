<?php


class DBController {
    protected $db;
    function __construct() {
        $this->db = $this->connectDB();
    }
    function __destruct() {
		    $this->db = null;
    }
    private function connectDB() {
        require_once '../settings.php';
        $dbInfo = $settings['pdo']['dsn'];
        $conn = new PDO($dbInfo);

        return $conn;
    }
}
?>
