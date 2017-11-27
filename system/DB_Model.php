<?php 
 // Se incluye el archivo de conexion de base de datos
 include 'core/ConexionDB.php';

 // Se crea la clase que ejecuta llama a las funciones de ejecución para interactuar con la Base de datos
 // Esta clase extiende a la clase db_model en el archivo db_model.php (hereda sus propiedades y metodos)

 class DB_Model extends ConexionDB {
  // Ya que la clase es generica, es importante poseer una variable que permitira identificar con que tabla se trabaja
  public $entity;
  // Almacena la informacion que sera enviada a la Base de datos
  public $data;

  private function get_fields_query($array_field=[]){

    $fields_query='';

    foreach ($array_field as $value) {
        
        $fields_query .= $value . ",";
    }

    return rtrim($fields_query,',');

  }

  public function get_login($dataArray = array()){

    $array_field = $this->get_fields_query(["usuario", "email", "status" ]);
    
    extract($dataArray);

    $sql = "SELECT $array_field FROM usuario WHERE usuario = '$usuario' AND password = '$password'";
   
    $response_query = $this->get_query($sql);

      if ($response_query) {
          return $this->response_json(200, $response_query, "consulta exitosa");
      }else{
          return $this->response_json(-200, $response_query, "usuario o contraseña no son válidos");
      }

  }  

  public function get_menu($dataArray = array()){
    
    extract($dataArray);

    $sql  = " SELECT DISTINCT ";  
    $sql .= " modulo.id_modulo,";
    $sql .= " modulo.descripcion";
    $sql .= " FROM modulo ";
    $sql .= " INNER JOIN autorizacion ON autorizacion.id_modulo_fk = modulo.id_modulo";
    $sql .= " INNER JOIN perfil ON autorizacion.id_perfil_fk = perfil.id_perfil"; 
    $sql .= " INNER JOIN usuario ON usuario.id_perfil_fk = perfil.id_perfil";
    $sql .= " WHERE usuario.`usuario` = '$usuario' AND autorizacion.acceso = $status";
    $sql .= " AND modulo.activo = 1";

    $response_query = $this->get_query($sql); 

    $array_opciones = [];

    foreach ($response_query as $value) {
          
      array_push($array_opciones, $value);
         
    }
  
      if ($response_query) {
          return $this->response_json(200, (array)$array_opciones, "consulta exitosa");
      }else{
          return $this->response_json(-200, NULL, "no se pudo realizar la consulta");
      }

  }

  private function fields_query(array $fields){

    $fields_query = '';

    foreach ($fields as $key => $value) {
        
        $fields_query .= $key . ",";
    }

    return rtrim($fields_query,',');

  }

  private function values_query(array $values){

    $values_query = '';

    foreach ($values as $value) {
        
        $values_query .= '\''. $value .'\''. ",";
    }

    return rtrim($values_query,',');

  }

  public function registro_pieza(array $dataArray){

    $sql = 'INSERT INTO pieza ('. $this->fields_query($dataArray) .') VALUES ('. $this->values_query($dataArray) .')';

    $response_query = $this->set_query($sql);

      if ($response_query) {
          return $this->response_json(200, $response_query, "registro exitoso");
      }else{
          return $this->response_json(-200, $response_query, "no se pudo realizar el registro");
      }

  } 

  public function consultar_piezas(){

    $sql  = 'SELECT pieza.tipo_pieza, COUNT(pieza.tipo_pieza) AS cantidad, pieza.fabricante, pieza.fec_produccion FROM `pieza`';
    $sql .= ' GROUP BY MONTH(CAST(pieza.fec_produccion AS DATE)), pieza.tipo_pieza';  
    $sql .= ' ORDER BY pieza.fec_produccion';
    
    $response_query = $this->get_query($sql);

      if ($response_query) {
          return $this->response_json(200, $response_query, "consulta exitosa");
      }else{
          return $this->response_json(-200, $response_query, "no se pudo realizar la consulta");
      }

  } 

  public function registrar_Cliente(array $dataArray){

    $sql = 'INSERT INTO CLIENTE ('. $this->fields_query($dataArray) .') VALUES ('. $this->values_query($dataArray) .')';

    $response_query = $this->set_query($sql);

      if ($response_query) {
          return $this->response_json(200, $response_query, "Registro exitoso");
      }else{
          return $this->response_json(-200, $response_query, "Documento de identidad ya registrado");
      }

  }  

  public function listar_Clientes(){

    $sql  = " SELECT DISTINCT ";  
    $sql .= " cliente.cod_cliente AS Codigo_Cliente,";
    $sql .= " cliente.nombre AS Nombre,";
    $sql .= " cliente.apellido AS Apellido,";
    $sql .= " cliente.pref_ci_rif AS Prefijo,";
    $sql .= " cliente.ci_rif AS Documento,";
    $sql .= " cliente.telefono AS Telefono,";
    $sql .= " cliente.correo AS Correo,";
    $sql .= " cliente.direccion AS Direccion";
    $sql .= " FROM cliente";

   return json_encode( ['data' => $this->get_query($sql)] );

  } 

  public function buscar_Cliente(array $dataArray){

    extract($dataArray);

    $sql  = " SELECT DISTINCT ";  
    $sql .= " cliente.cod_cliente AS Codigo_Cliente,";
    $sql .= " CONCAT(cliente.nombre, ' ', cliente.apellido) AS nombre_cliente,";
    $sql .= " cliente.pref_ci_rif AS Prefijo";
    $sql .= " FROM cliente";
    $sql .= " WHERE ci_rif='$ci_rif'";

   $response_query = $this->get_query($sql);

      if ($response_query) {
          return $this->response_json(200, $response_query, "Consulta exitosa");
      }else{
          return $this->response_json(-200, $response_query, "Cliente no Registrado");
      }

  } 

  public function consultar_pedidos(){

    $sql  = " SELECT DISTINCT ";  
    $sql .= " pedidos.numero_orden AS Numero_Orden,";
    $sql .= " pedidos.nombre_cliente AS Nombre_Cliente,";
    $sql .= " pedidos.cod_cliente_fk AS Codigo_Cliente,";
    $sql .= " pedidos.tipo_pieza AS Tipo_Pieza,";
    $sql .= " pedidos.cod_pieza AS Codigo_Pieza,";
    $sql .= " pedidos.marca_fabricante AS Marca_Fabricante,";
    $sql .= " pedidos.descripcion AS Descripcion,";
    $sql .= " pedidos.fecha_pedido AS Fecha_Pedido,";
    $sql .= " pedidos.estatus AS Estatus,";
    $sql .= " pedidos.fec_estatus AS Fecha_Estatus";
    $sql .= " FROM pedidos";

   return json_encode( ['data' => $this->get_query($sql)] );

  } 

  public function registrar_pedido(array $dataArray){

    extract($dataArray);

    $insert = 'INSERT INTO pedidos ('. $this->fields_query($dataArray) .', estatus) VALUES ('. $this->values_query($dataArray) .', "pendiente")';

    $numero_orden_fk = $this->set_query_secuence($insert);

    $insert_piesa  = 'INSERT INTO pieza (numero_orden_fk, tipo_pieza, marca_fabricante,  cod_cliente_fk,  estatus )';
    $insert_piesa .= " VALUES ('$numero_orden_fk', '$tipo_pieza', '$marca_fabricante', '$cod_cliente_fk', 'pendiente' )";

    $cod_pieza_sec = $this->set_query_secuence($insert_piesa);

    $update_pedidos = "UPDATE pedidos SET cod_pieza = '$cod_pieza_sec' WHERE numero_orden = '$numero_orden_fk'";

    $response_update_pedidos = $this->set_query($update_pedidos);

      if ($response_update_pedidos) {
          return $this->response_json(200, NULL, "Registro exitoso, numero de Orden: $numero_orden_fk y Codigo de pieza $cod_pieza_sec");
      }else{
          return $this->response_json(-200, NULL, "No se pudo realizar el registro");
      }

  }  

  public function actualizar_estatus_pieza(array $dataArray){

    extract($dataArray);

    $update_pieza  =  'UPDATE pieza SET ';
    $update_pieza .= " estatus = '$estatus',";
    $update_pieza .= " fec_estatus = NOW(),";
    $update_pieza .= " precio_pieza = '$precio_pieza'";
    $update_pieza .= " WHERE cod_pieza = '$codigo_pieza' AND numero_orden_fk = '$numero_orden'";   

    $update_pedidos =  'UPDATE pedidos SET ';
    $update_pedidos .= " estatus = '$estatus',";
    $update_pedidos .= " fec_estatus = NOW(),";
    $update_pedidos .= " descripcion = '$descripcion'";
    $update_pedidos .= " WHERE numero_orden = '$numero_orden'";

    $response_pieza   = $this->set_query($update_pieza);
    $response_pedidos = $this->set_query($update_pedidos);

      if ($response_pieza && $response_pedidos) {
          return $this->response_json(200, NULL, "Actualizacion de datos Exitosa");
      }else{
          return $this->response_json(-200, NULL, "No se pudo registrar");
      }

  } 

  protected function no_response(){

      $this->response_json(-200, NULL, "no es una peticion valida");
  }

  protected function response_json($status, $response, $mensaje) {
    
    header("HTTP/1.1 $status $mensaje");
    header("Content-Type: application/json; charset=UTF-8");

    $response = [ 
                  'rc'      => $status, 
                  'data'    => $response,
                  'mensaje' => $mensaje
                ];

    return json_encode($response, JSON_PRETTY_PRINT);

  }


 }
