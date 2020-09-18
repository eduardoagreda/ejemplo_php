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
		
	if(
		!empty($data->nombre_almacen) &&
		!empty($data->localizacion) &&
		!empty($data->responsable) &&
		!empty($data->tipo)
	){
		$almacen->nombre_almacen = $data->nombre_almacen;
		$almacen->localizacion = $data->localizacion;
		$almacen->responsable = $data->responsable;
		$almacen->tipo = $data->tipo;
		
		if($almacen->create()){
			http_response_code(201);
			echo json_encode(array("message" => "almacen creado."));
		}
		else{
			http_response_code(503);
			echo json_encode(array("message" => "No se puede crear el almacen."));
		}
	}
	else{
		http_response_code(400);
		echo json_encode(array("message" => "No se puede crear el almacen. Los datos están incompletos."));
	}
?>