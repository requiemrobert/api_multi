<?php
include 'DB_Model.php';
/**
* 
*/

class InterfaceLayer extends DB_Model 
{
	
	public function __construct()
	{
		parent::__construct();
	}

	public function route($dataArray){
       	   
   
		  switch ($dataArray['rc']):
		      case 'get_login':

		        echo $this->get_login($dataArray['data']);
		            
		      break;

		      case 'get_menu':
		      	
		        echo $this->get_menu($dataArray['data']);
		            
		      break;

		      case 'registro_pieza':

		        echo $this->registro_pieza($dataArray['data']);
		            
		      break;

		      case 'registrar_Cliente':

		        echo $this->registrar_Cliente($dataArray['data']);
		            
		      break;

		      case 'listar_Clientes':

		        echo $this->listar_Clientes();
		            
		      break;

		      case 'buscar_Cliente':

		        echo $this->buscar_Cliente($dataArray['data']);
		            
		      break;

		      case 'registrar_pedido':

		        echo $this->registrar_pedido($dataArray['data']);
		            
		      break;

		      case 'consultar_pedidos':

		        echo $this->consultar_pedidos();
		            
		      break;

		      case 'consultar_piezas':

		        echo $this->consultar_piezas();
		            
		      break;

		      case 'actualizar_estatus_pieza':

		        echo $this->actualizar_estatus_pieza($dataArray['data']);
		            
		      break;

		      case 'indicadores_piezas_mes':

		        echo $this->indicadores_piezas_mes();
		            
		      break;

		      case 'total_pedidos_piezas':

		        echo $this->total_pedidos_piezas();
		            
		      break;

		      case 'ping':

		        echo $this->ping($dataArray['data']);
		            
		      break;
		      
		      default:
		          
		        echo "No response del WS!!!";//$this->no_response();

		      break;
	      endswitch;

    }	


}