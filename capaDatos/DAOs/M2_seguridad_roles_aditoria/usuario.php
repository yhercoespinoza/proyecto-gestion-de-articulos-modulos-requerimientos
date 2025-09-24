<?php
class Conexion {
    private $host = "localhost";
    private $dbname = "bd_articulos";
    private $user = "root";
    private $pass = "";
    private $conn;

    public function __construct() {
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->dbname}";
           
            $this->conn = new PDO($dsn, $this->user, $this->pass);
      
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $this->conn->exec("set names utf8");
            
        } catch (PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
            die();
        }
    }

    public function getConexion() {
        return $this->conn;
    }
}
?>
