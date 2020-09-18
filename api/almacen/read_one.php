<?php
	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Headers: access");
	header("Access-Control-Allow-Methods: GET");
	header("Access-Control-Allow-Credentials: true");
	header('Content-Type: application/json');
		
	include_once '../config/database.php';
	include_once '../objects/almacen.php';
		
	$database = new Database();
	$db = $database->getConnection();

	$almacen = new Almacen($db);

	$almacen->id_almacen = isset($_GET['id_almacen']) ? $_GET['id_almacen'] : die();
		
	$almacen->readOne();
		
	if($almacen->nombre_almacen!=null) {
		$almacen_arr = array(
			"id_almacen" =>  $almacen->id_almacen,
			"nombre_almacen" => $almacen->nombre_almacen,
			"localizacion" => $almacen->localizacion,
			"responsable" => $almacen->responsable,
			"tipo" => $almacen->tipo,
		);
		http_response_code(200);
		echo json_encode($almacen_arr);
	}else{
		http_response_code(404);
		echo json_encode(array("message" => "El almacen no existe."));
	}
?>