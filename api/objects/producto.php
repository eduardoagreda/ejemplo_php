<?php

  class Producto {

    private $conn;
    private $table_name = "catalogo_producto";

    public $id_producto;
    public $sku;
    public $descripcion;
    public $marca;
    public $color;
    public $precio;

    public function __construct($db){
      $this->conn = $db;
    }

    function read(){
      $query = "SELECT * FROM ".$this->table_name;
      
      $stmt = $this->conn->prepare($query);
      $stmt->execute();
    
      return $stmt;
    }

    function create(){
      $query = "INSERT INTO " .$this->table_name." SET sku=:sku, descripcion=:descripcion, marca=:marca, color=:color, precio=:precio";
      $stmt = $this->conn->prepare($query);

      $this->sku=htmlspecialchars(strip_tags($this->sku));
      $this->descripcion=htmlspecialchars(strip_tags($this->descripcion));
      $this->marca=htmlspecialchars(strip_tags($this->marca));
      $this->color=htmlspecialchars(strip_tags($this->color));
      $this->precio=htmlspecialchars(strip_tags($this->precio));

      $stmt->bindParam(":sku", $this->sku);
      $stmt->bindParam(":descripcion", $this->descripcion);
      $stmt->bindParam(":marca", $this->marca);
      $stmt->bindParam(":color", $this->color);
      $stmt->bindParam(":precio", $this->precio);

      if($stmt->execute()){
        return true;
      }
      return false;
    }

    function readOne(){
      $query = "SELECT * FROM ".$this->table_name." WHERE id_producto= ? LIMIT 0,1";
    
      $stmt = $this->conn->prepare( $query );
    
      $stmt->bindParam(1, $this->id_producto);
      $stmt->execute();
    
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
  
      $this->sku = $row['sku'];
      $this->descripcion = $row['descripcion'];
      $this->marca = $row['marca'];
      $this->color = $row['color'];
      $this->precio = $row['precio'];
    }

    function update(){
      $query = "UPDATE ".$this->table_name." SET sku = :sku, descripcion = :descripcion, marca = :marca, color = :color, precio = :precio WHERE id_producto = :id_producto";
      $stmt = $this->conn->prepare($query);

      $this->sku=htmlspecialchars(strip_tags($this->sku));
      $this->descripcion=htmlspecialchars(strip_tags($this->descripcion));
      $this->marca=htmlspecialchars(strip_tags($this->marca));
      $this->color=htmlspecialchars(strip_tags($this->color));
      $this->precio=htmlspecialchars(strip_tags($this->precio));
      $this->id_producto=htmlspecialchars(strip_tags($this->id_producto));
    
      $stmt->bindParam(':sku', $this->sku);
      $stmt->bindParam(':descripcion', $this->descripcion);
      $stmt->bindParam(':marca', $this->marca);
      $stmt->bindParam(':color', $this->color);
      $stmt->bindParam(':precio', $this->precio);
      $stmt->bindParam(':id_producto', $this->id_producto);
    
      if($stmt->execute()){
          return true;
      }
    
      return false;
    }

    function delete(){
      $query = "DELETE FROM ".$this->table_name." WHERE id_producto = ?";

      $stmt = $this->conn->prepare($query);
  
      $this->id_producto=htmlspecialchars(strip_tags($this->id_producto));
      
      $stmt->bindParam(1, $this->id_producto);

      if($stmt->execute()){
        return true;
      }
      return false;
    }

    function search($keywords){
      $query = "SELECT * FROM ".$this->table_name." WHERE marca LIKE ? OR descripcion LIKE ? OR sku LIKE ? ORDER BY id_producto ASC";
      
      $stmt = $this->conn->prepare($query);

      $keywords = htmlspecialchars(strip_tags($keywords));
      $keywords = "%{$keywords}%";

      $stmt->bindParam(1, $keywords);
      $stmt->bindParam(2, $keywords);
      $stmt->bindParam(3, $keywords);

      $stmt->execute();
      return $stmt;
    }
  }
?>