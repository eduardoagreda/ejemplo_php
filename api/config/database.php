<?php  
class Database {

  private $server = "localhost";
  private $db = "ejercicio";
  private $user = "root";
  private $pass = "password";

  public $conn;

  public function getConnection(){
    $this->conn = null;

    try {
      $this->conn = new PDO('mysql:host='.$this->server.';dbname='.$this->db,$this->user, $this->pass);
      $this->conn->exec("set name utf8");
    } catch (PDOException $exception) {
      echo "Connection error: " . $exception->getMessage();
    }
    return $this->conn;
  }
}
?>