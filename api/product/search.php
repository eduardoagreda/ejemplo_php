<?php
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");

	include_once '../config/database.php';
	include_once '../objects/producto.php';
		
	$database = new Database();
	$db = $database->getConnection();

	$producto = new producto($db);
		
	$keywords = isset($_GET["s"]) ? $_GET["s"] : "";
	
	$stmt = $producto->search($keywords);
	$num = $stmt->rowCount();
		
	if($num>0){
		$productos_arr=array();
		$productos_arr["producto"]=array();
		
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			extract($row);
		
			$producto_item=array(
				"id_producto" => $id_producto,
				"sku" => $sku,
				"descripcion" => html_entity_decode($descripcion),
				"marca" => $marca,
				"color" => $color,
				"precio" => $precio
			);
			array_push($productos_arr["producto"], $producto_item);
		}
		http_response_code(200);
		echo json_encode($productos_arr);
	}else{
		http_response_code(404);
		echo json_encode(array("message" => "El producto no existe."));
	}
?>