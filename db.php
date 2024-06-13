<?php
class Database {
    private $host = "srv863.hstgr.io";
    private $db_name = "u484426513_multimedios022";
    private $username = "u484426513_multimedios022";
    private $password = "zD~>EilCGd1";
    public $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            $connectionInfo = array("Database"=>$this->db_name, "UID"=>$this->username, "PWD"=>$this->password);
            $this->conn = new PDO("sqlsrv:Server=" . $this->host . ";", $connectionInfo);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>