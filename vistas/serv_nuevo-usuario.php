<?php
if(isset($_SESSION['datos']['nombre_usuario'])){ 
 $disabledRC='disabled';
 $disabledMD='';
 $estatus=null;
}else {
 $disabledRC='';
 $disabledMD='disabled';
}
$servicios='nuevousuario';
if(isset($_SESSION['datos'])){
  @$codigo_perfil=$_SESSION['datos']['perfil'];
  @$estatus=$_SESSION['datos']['estatus_usuario'];
  @$cedula=$_SESSION['datos']['nombre_usuario'];
}
else{
  @$descripcion=null;
  @$codigo_perfil=null;
  @$cedula=null;
  @$estatus=null;
}
?>
<br><br>
<?php if(!isset($_GET['l'])){?>
<script type="text/javascript" src="../js/uds_usuario-nuevo.js"></script>
<form id="form" name="form" action="../controladores/cont_cambiar_clave.php" method="post" enctype="multipart/form-data">
  <section>
    <fieldset>
      <legend>Nuevo Usuario</legend>
      <div id="contenedorFormulario">
        <label>N&uacute;mero de C&eacute;dula de la Persona</label>
        <input name="cedula" id="cedula" value="<?= $cedula;?>" size="10"  type="text" placeholder="Ingrese el N&uacute;mero de C&eacute;dula" class="campoTexto" required /> 
        <label>Perfil de Usuario</label>
        <select name="rol" id="perfil" placeholder="Seleccione un Perfil" class="campoTexto" required>
          <?php 
          include_once("../clases/class_html.php");
          $html=new Html();
          $id="codigo_perfil";
          $descripcion="descripcion";
          $sql="select * from tperfil where fecha_desactivacion is null";

          if(is_null($codigo_perfil))
            $Seleccionado='null';
          else 
            $Seleccionado=$codigo_perfil;
          $html->Generar_Opciones($sql,$id,$descripcion,$Seleccionado); 

          ?>
        </select>
        <strong class="obligatorio">Los campos resaltados en rojo son obligatorios</strong>
      </div>   
      <br>
      <?php echo '<p class="'.$estatus.'" id="estatus_registro">'.$estatus.'</p>'; ?>
      <?php
      imprimir_boton($disabledRC,$disabledMD,$estatus,$servicios);
      ?>   
    </fieldset> 
  </form>
  <br />
</section>
<?php }else{

  require_once("../clases/class_perfil.php");
  $perfil=new Perfil();
  $perfil->codigo_perfil(@$_SESSION['user_codigo_perfil']);
  $servicios_permitidos=$perfil->IMPRIMIR_SERVICIOS_USUARIO();
  $servicio_solicitado=strtolower(preg_replace('/(serv_)|(\.php)/','',basename(__FILE__)));             	

  ?>
  <a href="./?nuevousuario" ><img src="../images/cerrar.png" alt="Cerrar" style="width:40px;heigth:40px;float:right;"></a>
  <?php
  if(isset($_POST['act'])){
   include_once("../controladores/cont_activar_caducidad_de_clave.php"); 
   echo "<script>alert('Sus datos han sido guardado con exito')</script>";     	
 }    
 ?>
 <br /><br />
 <form action="?nuevousuario&l" method="POST" name="form" >  
  <input type="hidden" name="act" value="1" />  
  <table class="table table-striped table-bordered table-condensed">
   <tr> 
     <td>Activar Caducidad</td>
     <td>Nombre Usuario </td>
     <td>Perfil de usuario</td>
     <td>Estatus</td>
   </tr>
   <?php

           //Conexi�n a la base de datos 
   require_once("../clases/class_bd.php");
   $mysql=new Conexion();

//Sentencia sql (sin limit) 
   $_pagi_sql = "SELECT u.activar_caducidad,u.nombre_usuario,tp.descripcion,
   CASE 
   WHEN (u.fecha_desactivacion IS NULL) THEN 'Activo'
   WHEN (u.fecha_desactivacion IS NOT NULL) THEN 'Desactivado'
   ELSE 'otro/desconocido'
   END
   as estado FROM tusuario u inner join tperfil tp on tp.codigo_perfil=u.codigo_perfil order by nombre_usuario"; 
//cantidad de resultados por p�gina (opcional, por defecto 20) 
   $_pagi_cuantos = 10; 
//Cadena que separa los enlaces num�ricos en la barra de navegaci�n entre p�ginas.
   $_pagi_separador = " ";
//Cantidad de enlaces a los n�meros de p�gina que se mostrar�n como m�ximo en la barra de navegaci�n.
   $_pagi_nav_num_enlaces=5;
//Incluimos el script de paginaci�n. �ste ya ejecuta la consulta autom�ticamente 
   @include("../librerias/paginador/paginator.inc.php"); 


//Leemos y escribimos los registros de la p�gina actual 
   while($row = mysql_fetch_array($_pagi_result)){ 
    if($row['activar_caducidad']=='1')
      $val='checked';
    else 
      $val='';
    echo "<tr>
    <td style='width:20%;text-align:center;'><input $val type='checkbox' name='nc[]' id='nc' value='".$row['nombre_usuario']."'/></td>
    <td align='left'>".$row['nombre_usuario']."</td>
    <td align='left'>".$row['descripcion']."</td>
    <td align='left' class='".$row['estado']."'>".$row['estado']."</td>
    </tr>"; 
  } 

//Incluimos la barra de navegaci�n 

  ?>
</table>
<input type="submit" value="Guardar"/>
</form>
<div class="pagination">
 <ul>
   <?php echo"<li>".$_pagi_navegacion."</li>";?>
 </ul>
</div>
<?php }?>