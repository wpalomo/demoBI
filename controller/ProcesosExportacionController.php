<?php

class ProcesosExportacionController extends ControladorBase{

	public function __construct() {
		parent::__construct();
	}



	public function index(){
	
		//Creamos el objeto usuario
	    $exportacion=new ProcesosExportacionModel();
					//Conseguimos todos los usuarios
     	$resultSet=$exportacion->getAll("id_procesos_exportacion");
				
		$resultEdit = "";

		
		session_start();

	
		if (isset(  $_SESSION['nombre_usuarios']) )
		{

			$nombre_controladores = "ProcesosExportacion";
			$id_rol= $_SESSION['id_rol'];
			$resultPer = $exportacion->getPermisosVer("   controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
			
			if (!empty($resultPer))
			{
				if (isset ($_GET["id_procesos_exportacion"])   )
				{

					$nombre_controladores = "ProcesosExportacion";
					$id_rol= $_SESSION['id_rol'];
					$resultPer = $exportacion->getPermisosEditar("   controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
						
					if (!empty($resultPer))
					{
					
					    $_id_procesos_exportacion = $_GET["id_procesos_exportacion"];
						
						$columnas = " procesos_exportacion.id_procesos_exportacion, 
                                      procesos_exportacion.cantidad_imagenes_procesos_exportacion, 
                                      procesos_exportacion.cantidad_indices_procesos_exportacion, 
                                      procesos_exportacion.creado, 
                                      procesos_exportacion.modificado ";
						$tablas   = "public.procesos_exportacion";
						$where    = "id_procesos_exportacion = '$_id_procesos_exportacion' "; 
						$id       = "id_procesos_exportacion";
							
						$resultEdit = $exportacion->getCondiciones($columnas ,$tablas ,$where, $id);

					}
					else
					{
						$this->view("Error",array(
								"resultado"=>"No tiene Permisos de Editar Procesos Exportacion"
					
						));
					
					
					}
					
				}
		
				
				$this->view("ProcesosExportacion",array(
						"resultSet"=>$resultSet, "resultEdit" =>$resultEdit
			
				));
		
				
				
			}
			else
			{
				$this->view("Error",array(
						"resultado"=>"No tiene Permisos de Acceso a Procesos Exportacion"
				
				));
				
				exit();	
			}
				
		}
	else{
       	
       	$this->redirect("Usuarios","sesion_caducada");
       	
       }
	
	}
	
	public function InsertaProcesosExportacion(){
			
		session_start();
		$exportacion=new ProcesosExportacionModel();

		$nombre_controladores = "ProcesosExportacion";
		$id_rol= $_SESSION['id_rol'];
		$resultPer = $exportacion->getPermisosEditar("   controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
			
		if (!empty($resultPer))
		{
		
		
		
			$resultado = null;
			$exportacion=new ProcesosExportacionModel();
		
			if (isset ($_POST["cantidad_imagenes_procesos_exportacion"])   )
			{
			    $_id_procesos_exportacion =  $_POST["id_procesos_exportacion"];
			    $_cantidad_imagenes_procesos_exportacion = $_POST["cantidad_imagenes_procesos_exportacion"];
			    $_cantidad_indices_procesos_exportacion= $_POST["cantidad_indices_procesos_exportacion"];
				
			    if($_id_procesos_exportacion> 0){
					
					$columnas = " cantidad_imagenes_procesos_exportacion = '$_cantidad_imagenes_procesos_exportacion',
                                  cantidad_indices_procesos_exportacion = '$_cantidad_indices_procesos_exportacion'";
					$tabla = "procesos_exportacion";
					$where = "id_procesos_exportacion = '$_id_procesos_exportacion'";
					$resultado=$exportacion->UpdateBy($columnas, $tabla, $where);
					
				}else{
					
					$funcion = "ins_procesos_exportacion";
					$parametros = " '$_cantidad_imagenes_procesos_exportacion', '$_cantidad_indices_procesos_exportacion'";
					$exportacion->setFuncion($funcion);
					$exportacion->setParametros($parametros);
					$resultado=$exportacion->Insert();
				}
				
				
				
		
			}
			$this->redirect("ProcesosExportacion", "index");

		}
		else
		{
			$this->view("Error",array(
					"resultado"=>"No tiene Permisos de Insertar Procesos Exportacion"
		
			));
		
		
		}
		
	}
	
	public function borrarId()
	{

		session_start();
		$exportacion=new ProcesosExportacionModel();
		$nombre_controladores = "ProcesosExportacion";
		$id_rol= $_SESSION['id_procesos_exportacion'];
		$resultPer = $exportacion->getPermisosEditar("   controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
			
		if (!empty($resultPer))
		{
			if(isset($_GET["id_procesos_exportacion"]))
			{
			    $_id_procesos_exportacion=(int)$_GET["id_procesos_exportacion"];
				
			    $exportacion->deleteBy("id_procesos_exportacion",$_id_procesos_exportacion);
				
				
			}
			
			$this->redirect("ProcesosExportacion", "index");
			
			
		}
		else
		{
			$this->view("Error",array(
				"resultado"=>"No tiene Permisos de Borrar Roles"
			
			));
		}
				
	}
	
	

	
	
	
}
?>