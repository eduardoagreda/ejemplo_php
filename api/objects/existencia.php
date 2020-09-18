<?php
	class Existencia {
    private $conn;
    private $table_name = "registro_existencias";
    private $table_name_2 = "catalogo_almacen";

    public $id_existencias;
    public $id_producto;
    public $id_almacen;
    public $existencias;
    public $tipo;

    public function __construct($db){
      $this->conn = $db;
		}
		
		function read(){
      $query = "SELECT * FROM ".$this->table_name. " AS Exi INNER JOIN catalogo_almacen AS Alm ON Exi.id_almacen = Alm.id_almacen ".
               "INNER JOIN catalogo_producto AS Prod ON Exi.id_producto = Prod.id_producto";
      
      $stmt = $this->conn->prepare($query);
      $stmt->execute();
    
      return $stmt;
    }
    
    function create(){
      $query = "INSERT INTO " .$this->table_name." SET id_producto=:id_producto, id_almacen=:id_almacen, existencias=:existencias";
      $stmt = $this->conn->prepare($query);

      $this->id_producto=htmlspecialchars(strip_tags($this->id_producto));
      $this->id_almacen=htmlspecialchars(strip_tags($this->id_almacen));
      $this->existencias=htmlspecialchars(strip_tags($this->existencias));

      $stmt->bindParam(":id_producto", $this->id_producto);
      $stmt->bindParam(":id_almacen", $this->id_almacen);
      $stmt->bindParam(":existencias", $this->existencias);

      if($stmt->execute()){
        return true;
      }
      return false;
    }

    function readOne(){
      $query = "SELECT * FROM ".$this->table_name.
      " AS Exi INNER JOIN catalogo_almacen AS Alm ON Exi.id_almacen = Alm.id_almacen ".
      "INNER JOIN catalogo_producto AS Prod ON Exi.id_producto = Prod.id_producto WHERE Exi.id_existencias = ? LIMIT 0,1";
    
      $stmt = $this->conn->prepare( $query );
    
      $stmt->bindParam(1, $this->id_existencias);
      $stmt->execute();
    
      return $stmt;
    }

    function readMultiple(){
      $query = "SELECT * FROM ".$this->table_name." AS Exi ". 
        "INNER JOIN catalogo_almacen AS Alm ON Exi.id_almacen = Alm.id_almacen ".
        "INNER JOIN catalogo_producto AS Prod ON Exi.id_producto = Prod.id_producto ".
        "WHERE Exi.id_almacen = :id_almacen AND Exi.id_producto = :id_producto";
      $stmt = $this->conn->prepare($query);

      $this->id_almacen=htmlspecialchars(strip_tags($this->id_almacen));
      $this->id_producto=htmlspecialchars(strip_tags($this->id_producto));
    
      $stmt->bindParam(':id_almacen', $this->id_almacen);
      $stmt->bindParam(':id_producto', $this->id_producto);
    
      $stmt->execute();

      return $stmt;
    }

    function update(){
      $query = "UPDATE ".$this->table_name." SET existencias = :existencias WHERE id_existencias = :id_existencias";
      $stmt = $this->conn->prepare($query);

      $this->existencias=htmlspecialchars(strip_tags($this->existencias));
      $this->id_existencias=htmlspecialchars(strip_tags($this->id_existencias));
    
      $stmt->bindParam(':existencias', $this->existencias);
      $stmt->bindParam(':id_existencias', $this->id_existencias);
    
      if($stmt->execute()){
          return true;
      }
    
      return false;
    }
    
    function updateMultiple(){
      $query = "UPDATE ".$this->table_name." AS Exi ". 
        "INNER JOIN catalogo_almacen AS Alm ON Exi.id_almacen = Alm.id_almacen ".
        "INNER JOIN catalogo_producto AS Prod ON Exi.id_producto = Prod.id_producto ".
        "SET Exi.existencias = :existencias ".
        "WHERE Exi.id_producto = :id_producto AND Exi.id_almacen = :id_almacen";
      $stmt = $this->conn->prepare($query);

      $this->existencias=htmlspecialchars(strip_tags($this->existencias));
      $this->id_producto=htmlspecialchars(strip_tags($this->id_producto));
      $this->id_almacen=htmlspecialchars(strip_tags($this->id_almacen));
    
      $stmt->bindParam(':existencias', $this->existencias);
      $stmt->bindParam(':id_producto', $this->id_producto);
      $stmt->bindParam(':id_almacen', $this->id_almacen);
    
      if($stmt->execute()){
          return true;
      }
    
      return false;
    }


    function readTypeAlmacen($keywords){
      $query = "SELECT * FROM ".$this->table_name. " AS Exi INNER JOIN catalogo_almacen AS Alm ON Exi.id_almacen = Alm.id_almacen ".
               "INNER JOIN catalogo_producto AS Prod ON Exi.id_producto = Prod.id_producto WHERE Alm.tipo LIKE ?".
               " ORDER BY Exi.id_existencias ASC";

      $stmt = $this->conn->prepare($query);
      $keywords = htmlspecialchars(strip_tags($keywords));
      $keywords = "%{$keywords}%";
      
      $stmt->bindParam(1, $keywords);
      $stmt->execute();
    
      return $stmt;
    }

    function delete(){
      $query = "DELETE FROM ".$this->table_name." WHERE id_existencias = ?";

      $stmt = $this->conn->prepare($query);
  
      $this->id_existencias=htmlspecialchars(strip_tags($this->id_existencias));
      
      $stmt->bindParam(1, $this->id_existencias);

      if($stmt->execute()){
        return true;
      }
      return false;
    }

    function search($keywords){
      $query = "SELECT * FROM ".$this->table_name." WHERE id_almacen LIKE ? OR id_producto LIKE ? ORDER BY id_existencias ASC";
      
      $stmt = $this->conn->prepare($query);

      $keywords = htmlspecialchars(strip_tags($keywords));
      $keywords = "%{$keywords}%";

      $stmt->bindParam(1, $keywords);
      $stmt->bindParam(2, $keywords);

      $stmt->execute();
      return $stmt;
    }
	}
?>