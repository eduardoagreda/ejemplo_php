<?php
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");

	include_once '../config/database.php';
	include_once '../objects/existencia.php';

	$database = new Database();
	$db = $database->getConnection();

	$existencia = new Existencia($db);

	$stmt = $existencia->read();
	$num = $stmt->rowCount();

	if($num > 0){

		$existencia_arr = array();
		$existencia_arr['existencias'] = array();

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			
			extract($row);
			
			$existencia_item = array(
				"id_existencias" => $id_existencias,
				"almacen" => ["id_almacen"=>$id_almacen, "nombre_almacen"=>$nombre_almacen, "localizacion"=>$localizacion, "responsable"=>$responsable, "tipo"=>$tipo],
        "producto" => ["id_producto" => $id_producto, "sku"=>$sku, "descripcion" => $descripcion,"marca"=>$marca, "color" => $color, "precio" =>$precio],
        "existencias" => $existencias
			);
			array_push($existencia_arr['existencias'], $existencia_item);
		}
		http_response_code(200);
		echo json_encode($existencia_arr);
	}else{
    http_response_code(404);
    echo json_encode(array("message" => "No products found."));
	}
?>