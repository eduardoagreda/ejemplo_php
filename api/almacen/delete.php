<?php
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

	include_once '../config/database.php';
	include_once '../objects/almacen.php';

	$database = new Database();
	$db = $database->getConnection();

	$almacen = new Almacen($db);
	$data = json_decode(file_get_contents("php://input"));

	$almacen->id_almacen = $data->id_almacen;

	if($almacen->delete()){
		http_response_code(200);
		echo json_encode(array("message" => "El almacen se ha eliminado."));
	}else{
		http_response_code(503);
		echo json_encode(array("message" => "No se ha podido eliminar el almacen."));
	}
?>