<?php
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");

	include_once '../config/core.php';
	include_once '../config/database.php';
	include_once '../objects/almacen.php';
		
	$database = new Database();
	$db = $database->getConnection();

	$almacen = new Almacen($db);
		
	$keywords = isset($_GET["s"]) ? $_GET["s"] : "";
	
	$stmt = $almacen->search($keywords);
	$num = $stmt->rowCount();
		
	if($num>0){
		$almacens_arr=array();
		$almacens_arr["almacen"]=array();
		
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			extract($row);
		
			$almacen_item=array(
				"id_almacen" => $id_almacen,
				"nombre_almacen" => $nombre_almacen,
				"localizacion" => html_entity_decode($localizacion),
				"responsable" => $responsable,
				"tipo" => $tipo
			);
			array_push($almacens_arr["almacen"], $almacen_item);
		}
		http_response_code(200);
		echo json_encode($almacens_arr);
	}else{
		http_response_code(404);
		echo json_encode(array("message" => "El almacen no existe."));
	}
?>