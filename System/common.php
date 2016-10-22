<?php
/**
 * @author Fer De La Cruz
 */
 
class Common {
//Genera el contenido cambiante, donde $f es la variable que contiene el nombre del controlador que va a cargar
	function content($f){	
		if(isset($f)){
			$this->$f();
		}		
	}
}
?>