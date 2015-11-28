<?php
 require_once("class_bd.php");
 class Materia
 {
     private $codigo_materia; 
     private $descripcion; 
     private $unidad_curricular;
     private $grado_escolar;
     private $estatus_materia;
     private $fecha_desactivacion; 
     private $error;
     private $mysql; 
	 
   public function __construct(){
     $this->descripcion=null;
     $this->codigo_materia=null;
     $this->unidad_curricular=null;
     $this->grado_escolar=null;
     $this->error=null;
	 $this->mysql=new Conexion();
   }
   
 public function __destruct(){}

 public function Transaccion($value){
	 if($value=='iniciando') return $this->mysql->Incializar_Transaccion();
	 if($value=='cancelado') return $this->mysql->Cancelar_Transaccion();
	 if($value=='finalizado') return $this->mysql->Finalizar_Transaccion();
	 }

   public function codigo_materia(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->codigo_materia;
     
	 if($Num_Parametro>0){
	   $this->codigo_materia=func_get_arg(0);
	 }
   }

   public function descripcion(){
   $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->descripcion;
     
	 if($Num_Parametro>0){
	   $this->descripcion=func_get_arg(0);
	 }
   }

   public function unidad_curricular(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->unidad_curricular;
     
	 if($Num_Parametro>0){
	   $this->unidad_curricular=func_get_arg(0);
	 }
   }
   
   public function grado_escolar(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->grado_escolar;
     
	 if($Num_Parametro>0){
	   $this->grado_escolar=func_get_arg(0);
	 }
   }
   
   
   public function estatus_materia(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->estatus_materia;
     
	 if($Num_Parametro>0){
	   $this->estatus_materia=func_get_arg(0);
	 }
   }

   public function fecha_desactivacion(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->fecha_desactivacion;
     
	 if($Num_Parametro>0){
	   $this->fecha_desactivacion=func_get_arg(0);
	 }
   }
   
   public function error(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->error;
     
	 if($Num_Parametro>0){
	   $this->error=func_get_arg(0);
	 }
   }

   public function Registrar(){
    $sql="insert into tmateria (codigo_materia,descripcion,unidad_curricular,grado_escolar) values ('$this->codigo_materia','$this->descripcion','$this->unidad_curricular','$this->grado_escolar');";
    if($this->mysql->Ejecutar($sql)!=null)
	return true;
	else{
		$this->error($this->mysql->Error());
		return false;
	}
   }
   
     public function Activar(){
    $sql="update tmateria set fecha_desactivacion=NULL where (codigo_materia='$this->codigo_materia');";
    if($this->mysql->Ejecutar($sql)!=null)
	return true;
	else{
		$this->error($this->mysql->Error());
		return false;
	}
   }
    public function Desactivar(){
    $sql="update tmateria set fecha_desactivacion=CURDATE() where (codigo_materia='$this->codigo_materia');";
    if($this->mysql->Ejecutar($sql)!=null)
	return true;
	else{
		$this->error($this->mysql->Error());
		return false;
	}
   }
   
    public function Actualizar($oldcodigo){
    $sql="update tmateria set codigo_materia='$this->codigo_materia',descripcion='$this->descripcion',unidad_curricular='$this->unidad_curricular',grado_escolar='$this->grado_escolar' where (codigo_materia='$oldcodigo');";
    if($this->mysql->Ejecutar($sql)!=null)
	return true;
	else{
		$this->error($this->mysql->Error());
		return false;
	}
   }
   
   public function Consultar(){
    $sql="select *,(CASE WHEN fecha_desactivacion IS NULL THEN  'Activo' ELSE 'Desactivado' END) AS estatus_materia from tmateria where codigo_materia='$this->codigo_materia'";
	$query=$this->mysql->Ejecutar($sql);
    if($this->mysql->Total_Filas($query)!=0){
	$tmateria=$this->mysql->Respuesta($query);
	$this->codigo_materia($tmateria['codigo_materia']);
	$this->descripcion($tmateria['descripcion']);
	$this->unidad_curricular($tmateria['unidad_curricular']);
	$this->grado_escolar($tmateria['grado_escolar']);
	$this->estatus_materia($tmateria['estatus_materia']);
	$this->fecha_desactivacion($tmateria['fecha_desactivacion']);
	return true;
	}
	else{
		$this->error($this->mysql->Error());
		return false;
	}
   }
   public function Comprobar(){
    $sql="select * from tmateria where codigo_materia='$this->codigo_materia'";
	$query=$this->mysql->Ejecutar($sql);
    if($this->mysql->Total_Filas($query)!=0){
	$tmateria=$this->mysql->Respuesta($query);
	$this->codigo_materia($tmateria['codigo_materia']);
	$this->descripcion($tmateria['descripcion']);
	$this->unidad_curricular($tmateria['unidad_curricular']);
	$this->grado_escolar($tmateria['grado_escolar']);
	$this->fecha_desactivacion($tmateria['fecha_desactivacion']);
    $this->error("El registro ya existe !");
	return true;
	}
	else{
		$this->error($this->mysql->Error());
		return false;
	}
   }
}
?>