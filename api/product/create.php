<?php
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
		
	include_once '../config/database.php';
	include_once '../objects/producto.php';
		
	$database = new Database();
	$db = $database->getConnection();
		
	$producto = new Producto($db);
		
	$data = json_decode(file_get_contents("php://input"));
		
	if(
		!empty($data->sku) &&
		!empty($data->descripcion) &&
		!empty($data->marca) &&
		!empty($data->color) &&
		!empty($data->precio)
	){
		$producto->sku = $data->sku;
		$producto->descripcion = $data->descripcion;
		$producto->marca = $data->marca;
		$producto->color = $data->color;
		$producto->precio = $data->precio;
		
		if($producto->create()){
			http_response_code(201);
			echo json_encode(array("message" => "Producto creado."));
		}
		else{
			http_response_code(503);
			echo json_encode(array("message" => "No se puede crear el producto."));
		}
	}
	else{
		http_response_code(400);
		echo json_encode(array("message" => "No se puede crear el producto. Los datos están incompletos."));
	}
?>