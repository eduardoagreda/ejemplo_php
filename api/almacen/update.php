<?php
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

	include_once '../config/database.php';
	include_once '../objects/almancen.php';

	$database = new Database();
	$db = $database->getConnection();

	$almancen = new Almancen($db);
	$data = json_decode(file_get_contents("php://input"));

	$almancen->id_almancen = $data->id_almancen;
	$almancen->nombre_almacen = $data->nombre_almacen;
	$almancen->localizacion = $data->localizacion;
	$almancen->responsable = $data->responsable;
	$almancen->tipo = $data->tipo;

	if($almancen->update()){
		http_response_code(200);
		echo json_encode(array("message" => "El almancen se ha actualizado."));
	}else{
		http_response_code(503);
		echo json_encode(array("message" => "No se ha podido actualizar el almancen."));
	}
?>