<?php 

include 'system/interface_layer.php';

// Permite la conexion desde cualquier origen
header("Access-Control-Allow-Origin: *");

//header("Content-Type: application/JSON");
// Permite la ejecucion de los metodos
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");   

 $bodyRequest = file_get_contents("php://input");

 $dataArray = json_decode($bodyRequest, true);

 $interface_layer = new InterfaceLayer();
  
 $interface_layer->route($dataArray);
  
  


