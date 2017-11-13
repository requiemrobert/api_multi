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
   // $sql .= ' WHERE pieza.fec_produccion  BETWEEN CAST("2017-10-01" AS DATE) AND CAST("2017-10-31" AS DATE)';
    $sql .= ' GROUP BY MONTH(CAST(pieza.fec_produccion AS DATE)), pieza.tipo_pieza';  
    $sql .= ' ORDER BY pieza.fec_produccion';
    
    $response_query = $this->get_query($sql);

      if ($response_query) {
          return $this->response_json(200, $response_query, "consulta exitosa");
      }else{
          return $this->response_json(-200, $response_query, "no se pudo realizar la consulta");
      }

  } 

  public function registrar_cliente(array $dataArray){

    
    $sql = 'INSERT INTO CLIENTE ('. $this->fields_query($dataArray) .') VALUES ('. $this->values_query($dataArray) .')';

    $response_query = $this->set_query($sql);


      if ($response_query) {
          return $this->response_json(200, $response_query, "consulta exitosa");
      }else{
          return $this->response_json(-200, $response_query, "usuario o contraseña no son válidos");
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
