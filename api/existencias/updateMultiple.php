<?php
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

	include_once '../config/database.php';
	include_once '../objects/existencia.php';

	$database = new Database();
	$db = $database->getConnection();

	$existencia = new Existencia($db);
	$data = json_decode(file_get_contents("php://input"));

	$existencia->id_existencias = $data->id_existencias;
	$existencia->id_producto = $data->id_producto;
	$existencia->id_almacen = $data->id_almacen;
	$existencia->existencias = $data->existencias;

	if($existencia->updateMultiple()){
		http_response_code(200);
		echo json_encode(array("message" => "El existencia se ha actualizado."));
	}else{
		http_response_code(503);
		echo json_encode(array("message" => "No se ha podido actualizar el existencia."));
	}
?>