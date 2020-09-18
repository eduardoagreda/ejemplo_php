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

	$producto->id_producto = $data->id_producto;

	if($producto->delete()){
		http_response_code(200);
		echo json_encode(array("message" => "El producto se ha eliminado."));
	}else{
		http_response_code(503);
		echo json_encode(array("message" => "No se ha podido eliminar el producto."));
	}
?>