function validar_formulario(param){
//para validar en caso q no return false
console.log(param);
permitido=true;
valor=document.getElementById('descripcion').value;
valor2=document.getElementById('codigo_opcion').value;
valor3=document.getElementById('orden').value;
valor4=document.getElementById('icono').value;
if(devuelve_boton(param)=="Registrar" || devuelve_boton(param)=="Modificar"){
	if(valor.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
	alert('Ingrese el nombre de la Opción')
	permitido=false;
	}
	if(valor3==0){
		alert('Debe seleccionar una acción')
		permitido=false;
	}	
	if(valor4==0){
		alert('Debe seleccionar un icono')
		permitido=false;
	}
}
	
if(devuelve_boton(param)=="Desactivar"){
	
      if(valor2.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
alert('consultar antes desactivar')
permitido=false;
return false;
}	
	
	if(!confirm("¿Esta seguro que desea desactivar este registro?"))
	 return false
}

document.getElementById("operacion").value=devuelve_boton(param);
if(permitido==true)
	document.getElementById("form").submit();
}
