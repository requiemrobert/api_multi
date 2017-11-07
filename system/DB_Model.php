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

    $array_field = $this->get_fields_query(["status", "user_name", "email"]);
    
    $sql = "SELECT $array_field FROM usuario WHERE user_name = ? AND password = ?";

    $response_query = $this->execute_query_login($dataArray, $sql);
      
      if ($response_query) {
          return $this->response_json(200, $response_query, "consulta exitosa");
      }else{
          return $this->response_json(-200, $response_query, "usuario o contraseña no son válidos");
      }

  }  

  public function get_menu($dataArray = array()){

    $array_field = $this->get_fields_query(["modulo.descripcion"]);
    
    extract($dataArray);

    $sql = '';

    $sql .= " SELECT DISTINCT ";  
    $sql .= " modulo_padre.descripcion AS padre_descripcion,";
    $sql .= " modulo_hijo.descripcion AS hijo_descripcion";
    $sql .= " FROM modulo AS modulo_padre";
    $sql .= " INNER JOIN modulo AS modulo_hijo ON modulo_padre.id_modulo = modulo_hijo.id_modulo_fk,";
    $sql .= " usuario";
    $sql .= " INNER JOIN perfil ON usuario.id_perfil_fk = perfil.id_perfil"; 
    $sql .= " INNER JOIN autorizacion ON autorizacion.id_perfil_fk = perfil.id_perfil";
    $sql .= " INNER JOIN modulo ON autorizacion.id_modulo_fk = modulo.id_modulo"; 
    $sql .= " WHERE usuario.`user_name` = '$user_name' AND autorizacion.acceso = $status";
    $sql .= " order by  padre_descripcion";

    $response_query = $this->get_query($sql); 

    $array_opciones = [];

    foreach ($response_query as $key => $value) {
            
          $array_opciones[$key] = [ $value['padre_descripcion'] => $value['hijo_descripcion'] ] ;

    }

    $opciones_padres = [];

    $opciones_hijos = [];

    $opcion_padre='';
    $opcion_padre_aux='';

    $padre_hijo =[];

    foreach ($array_opciones as $key => $value) {

        if($opcion_padre == array_keys($value)[0] or empty($opcion_padre)){

          array_push($opciones_hijos, array_values($value)[0]);

        }else{

          $opciones_padres[array_keys($value)[0]] = $opciones_hijos;

          $padre_hijo[$opcion_padre] = $opciones_padres[array_keys($value)[0]];

          $opciones_hijos = [];

          array_push($opciones_hijos, array_values($value)[0]);

          $opcion_padre_aux = array_keys($value)[0];
          
        }

        $opcion_padre = array_keys($value)[0];
    } 

    $opciones_padres[array_keys($value)[0]] = $opciones_hijos;
    $padre_hijo[$opcion_padre_aux] = $opciones_padres[array_keys($value)[0]];

      if ($response_query) {
          return $this->response_json(200, $padre_hijo, "consulta exitosa");
      }else{
          return $this->response_json(-200, $padre_hijo, "no se pudo realizar la consulta");
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


  public function registrar_cliente(array $dataArray){

    
    $sql = 'INSERT INTO CLIENTE ('. $this->fields_query($dataArray) .') VALUES ('. $this->values_query($dataArray) .')';

    $response_query = $this->set_query($sql);
      
      print_r($response_query);

      exit();
      if ($response_query) {
          return $this->response_json(200, $response_query, "consulta exitosa");
      }else{
          return $this->response_json(-200, $response_query, "usuario o contraseña no son válidos");
      }

  }  



  protected function no_response(){

      $this->response_json(-200, false, "no es una peticion valida");
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
