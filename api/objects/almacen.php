<?php
	class Almacen{		
		private $conn;
    private $table_name = "catalogo_almacen";

		public $id_almacen;
		public $nombre_almacen;
		public $localizacion;
		public $responsable;
		public $tipo;

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
      $query = "INSERT INTO " .$this->table_name." SET nombre_almacen=:nombre_almacen, localizacion=:localizacion, responsable=:responsable, tipo=:tipo";
      $stmt = $this->conn->prepare($query);

      $this->nombre_almacen=htmlspecialchars(strip_tags($this->nombre_almacen));
      $this->localizacion=htmlspecialchars(strip_tags($this->localizacion));
      $this->responsable=htmlspecialchars(strip_tags($this->responsable));
      $this->tipo=htmlspecialchars(strip_tags($this->tipo));

      $stmt->bindParam(":nombre_almacen", $this->nombre_almacen);
      $stmt->bindParam(":localizacion", $this->localizacion);
      $stmt->bindParam(":responsable", $this->responsable);
      $stmt->bindParam(":tipo", $this->tipo);

      if($stmt->execute()){
        return true;
      }
      return false;
    }

    function readOne(){
      $query = "SELECT * FROM ".$this->table_name." WHERE id_almacen= ? LIMIT 0,1";
    
      $stmt = $this->conn->prepare( $query );
    
      $stmt->bindParam(1, $this->id_almacen);
      $stmt->execute();
    
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
  
      $this->nombre_almacen = $row['nombre_almacen'];
      $this->localizacion = $row['localizacion'];
      $this->responsable = $row['responsable'];
      $this->tipo = $row['tipo'];
    }

    function update(){
      $query = "UPDATE ".$this->table_name." SET nombre_almacen = :nombre_almacen, localizacion = :localizacion, responsable = :responsable, tipo = :tipo WHERE id_almacen = :id_almacen";
      $stmt = $this->conn->prepare($query);

      $this->nombre_almacen=htmlspecialchars(strip_tags($this->nombre_almacen));
      $this->localizacion=htmlspecialchars(strip_tags($this->localizacion));
      $this->responsable=htmlspecialchars(strip_tags($this->responsable));
      $this->tipo=htmlspecialchars(strip_tags($this->tipo));
      $this->id_almacen=htmlspecialchars(strip_tags($this->id_almacen));
    
      $stmt->bindParam(':nombre_almacen', $this->nombre_almacen);
      $stmt->bindParam(':localizacion', $this->localizacion);
      $stmt->bindParam(':responsable', $this->responsable);
      $stmt->bindParam(':tipo', $this->tipo);
      $stmt->bindParam(':id_almacen', $this->id_almacen);
    
      if($stmt->execute()){
          return true;
      }
    
      return false;
    }

    function delete(){
      $query = "DELETE FROM ".$this->table_name." WHERE id_almacen = ?";

      $stmt = $this->conn->prepare($query);
  
      $this->id_almacen=htmlspecialchars(strip_tags($this->id_almacen));
      
      $stmt->bindParam(1, $this->id_almacen);

      if($stmt->execute()){
        return true;
      }
      return false;
    }

    function search($keywords){
      $query = "SELECT * FROM ".$this->table_name." WHERE responsable LIKE ? OR localizacion LIKE ? OR nombre_almacen LIKE ? OR tipo LIKE ? ORDER BY id_almacen ASC";
      
      $stmt = $this->conn->prepare($query);

      $keywords = htmlspecialchars(strip_tags($keywords));
      $keywords = "%{$keywords}%";

      $stmt->bindParam(1, $keywords);
      $stmt->bindParam(2, $keywords);
			$stmt->bindParam(3, $keywords);
			$stmt->bindParam(4, $keywords);

      $stmt->execute();
      return $stmt;
    }
  }
?>