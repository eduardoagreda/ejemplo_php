<?php
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");

	include_once '../config/database.php';
	include_once '../objects/producto.php';

	$database = new Database();
	$db = $database->getConnection();

	$producto = new Producto($db);

	$stmt = $producto->read();
	$num = $stmt->rowCount();

	if($num > 0){

		$producto_arr = array();
		$producto_arr['productos'] = array();

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			
			extract($row);
			
			$producto_item = array(
				"id_producto" => $id_producto,
				"sku" => $sku,
    		"descripcion" => html_entity_decode($descripcion),
    		"marca" => $marca,
    		"color" => $color,
    		"precio" => $precio
			);
			array_push($producto_arr['productos'], $producto_item);
		}
		http_response_code(200);
		echo json_encode($producto_arr);
	}else{
    http_response_code(404);
    echo json_encode(array("message" => "No products found."));
	}
?>