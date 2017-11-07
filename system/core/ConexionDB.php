<?php
  // Incluimos el archivo de configuración el cual posee las credenciales de conexión
  include 'db_config.php';

  class foo_mysqli extends mysqli {
     
    private $db_host;
    private $db_user;
    private $db_pass;
    private $db_name;
    private $persistent;

    public function __construct($db_host, $db_user, $db_pass, $db_name, $persistent = true)
    {
        $this->db_host = $db_host;
        $this->db_user = $db_user;
        $this->db_pass = $db_pass;
        $this->db_name = $db_name;
        $this->persistent = $persistent;

        parent::init();
        parent::options(MYSQLI_OPT_CONNECT_TIMEOUT, 1);
        @parent::real_connect(($this->persistent ? 'p:' : '') . $this->db_host, $this->db_user, $this->db_pass, $this->db_name);

        if ($this->connect_errno)
            die("All DB servers down!\n");
    }

    public function ping()
    {
        @parent::query('SELECT LAST_INSERT_ID()');

        if ($this->errno == 2006)
            $this->__construct($this->db_host, $this->db_user, $this->db_pass, $this->db_name, $this->persistent);
    }



  }


  // Se crea la clase de conexión y ejecución de consultas
  class ConexionDB {

    // Variable de conexion
    public $conn;

    // La función constructora crea y abre la conexión al momento de instanciar esta clase
    function __construct() {
      // Los parametros de la funcion mysqli() son las constantes previamente declaradas en el archivo config.php
      try {

          /* Comprobar la conexión */
         
          $this->conn = new foo_mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
           
          if ($this->conn->connect_errno) {
              //printf("Falló la conexión: %s\n", $this->conn->connect_error);
              //$this->conn->ping(); 
              exit();
          }

      } catch (mysqli_sql_exception $e){
          //Si no se puede realizar la conexión
          http_response_code(500);
          echo "catch";
          exit;
      }

    }

    /**
     * obtiene un array de resultados
     * Solo se usara para las consultas de tipo SELECT
     * @param string $sql query tipo select
     * @return Array con los registros obtenidos de la base de datos
     */
    function execute_query_login($dataArray, $sql = '') {

      extract($dataArray);

      $stmt = $this->conn->prepare($sql);

      $stmt->bind_param("ss" , $user_name, $password);

      $stmt->execute();

      $result = $stmt->get_result();
      $response_query = $result->fetch_all(MYSQLI_ASSOC);

      $stmt->close();

      return $response_query;

    }

    function get_query($sql) {

      // Lee la cadena SQL recibida y ejecuta la consulta
      $stmt = $this->conn->prepare($sql);

      $stmt->execute();

      $result = $stmt->get_result();

      $rows = $result->fetch_all(MYSQLI_ASSOC);

      $stmt->close();

      // Retorna el resultado obtenido
      return $rows;
    }

    // Funcion para hacer cambios dentro de la base de datos
    // Solo se usara para las consultas de tipo INSERT, UPDATE Y DELETE
    function set_query(string $sql) {
      // Lee la cadena SQL recibida y ejecuta la consulta
      $result = $this->conn->query($sql);

      // Retorna el resultado
      return $result;

    }

    // La función destructora cierra la conexión previamente abierta en el constructor
    function __destruct() {

      /* comprobar si el servidor sigue funcionando */
      if (mysqli_ping($this->conn)) {
          $this->conn->close();
      } else {
          printf ("Error: %s\n", mysqli_error($this->conn));
      }
     
    }

  }
