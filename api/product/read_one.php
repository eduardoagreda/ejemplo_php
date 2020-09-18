<?php
	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Headers: access");
	header("Access-Control-Allow-Methods: GET");
	header("Access-Control-Allow-Credentials: true");
	header('Content-Type: application/json');
		
	include_once '../config/database.php';
	include_once '../objects/producto.php';
		
	$database = new Database();
	$db = $database->getConnection();

	$producto = new Producto($db);

	$producto->id_producto = isset($_GET['id_producto']) ? $_GET['id_producto'] : die();
		
	$producto->readOne();
		
	if($producto->sku!=null) {
		$producto_arr = array(
			"id_producto" =>  $producto->id_producto,
			"sku" => $producto->sku,
			"descripcion" => $producto->descripcion,
			"marca" => $producto->marca,
			"color" => $producto->color,
			"precio" => $producto->precio
		);
		http_response_code(200);
		echo json_encode($producto_arr);
	}else{
		http_response_code(404);
		echo json_encode(array("message" => "El producto no existe."));
	}
?>