<?php
/**
 * @author Fer De La Cruz
 */
 
class Connection{
	public $connection;
	public $affectedRows = 0;

///////////////// ******** ---- 	 connect		------ ************ //////////////////
	// Genera la conexion a la base de datos
		// Como parametros puede recibir:
		
	private function connect(){
		include ('../../System/configuracion.php');
		
		if(!$this->connection = mysqli_connect($servidor, $usuariobd, $clavebd, $bd)){
			return "Error al tratar de conectar: ".mysqli_connect_error;
		}
		
		$this->connection->set_charset('utf8');// Previniendo errores con SetCharset
	}
	
///////////////// ******** ---- 	 FIN connect		------ ************ //////////////////

///////////////// ******** ---- 	 close		------ ************ //////////////////
	// Cierra la conexion a la base de datos
		// Como parametros puede recibir:
	
		private function close(){
			$this->connection->close();
		}
		
///////////////// ******** ---- 	 FIN close		------ ************ //////////////////

///////////////// ******** ---- 	 query		------ ************ //////////////////
	// Ejecuta una consulta a la DB
		// Como parametros puede recibir:
			// $query -> consulta a ejecutar
		
		public function query($query){
			$con = $this->connect();
			$result = $this->connection->query($query) or die("Error en la consulta".$this->connection->error."Error:".$query);

			$this->close();
			return $result;
		}
		
///////////////// ******** ---- 	 FIN query		------ ************ //////////////////
	
///////////////// ******** ---- 	 queryArray		------ ************ //////////////////
	// Ejecuta una consulta a la DB y regresa los datos en un array
		// Como parametros puede recibir:
			// $sql-> consulta a ejecutar
			// $relational -> si es relacional o no
			
		public function queryArray($sql, $relational = true){
			try{
				if (empty($sql)){
					throw new Exception("empty SQL");
				}
				
				$this->sql = $sql;
				$this->connect();

				$result = $this->connection->query($sql) or die("Error en la consulta.".$this->connection->error."Error:".$sql);

				$this->affectedRows = mysqli_num_rows($result);

				$fields = array();
				
				while ($finfo = mysqli_fetch_field($result)) {
					$fields[] = $finfo->name;
				}

				$rows = array();

				if	($relational) {
					while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
						$rows[] = $row;
					}
				}else {
					while ($row = mysqli_fetch_array($result, MYSQL_ASSOC)) {
						foreach ($row as $key => $value){
							$rows[$key][] = $value;
						}
					}
				}
				
				$this->close();
				
				return array("status" => true, "total" =>  $this->affectedRows, "fields" => $fields, "rows" => $rows);

			}catch(Exception $e){
				$this->close();
				return array("status" => false, "msg" => $e->getMessage());
			}
		}

///////////////// ******** ---- 	 FIN queryArray		------ ************ //////////////////
		
	
///////////////// ******** ---- 	 dataTransact		------ ************ //////////////////
	// Metodo para generar transaccion con la DB
		// Como parametros puede recibir:
			// $data-> datos
			
		public function dataTransact($data){
			$this->connect();
			$this->connection->autocommit(false);
			
			if($this->connection->query('BEGIN;')){
				if($this->connection->multi_query($data)){
					do {
						/* almacenar primer juego de resultados */
						if ($result = $this->connection->store_result()) {
							while ($row = $result->fetch_row()) {
								echo $row[0];
							}
							$result->free();
						}

					} while ($this->connection->more_results() && $this->connection->next_result());

					$this->connection->commit();
					$this->connection->close();
					return true;
				}else{
					$error = $this->connection->error;
					$this->connection->rollback();
					$this->connection->close();
					return $error;
				}		
			}else{
				$error = $this->connection->error;
				$this->connection->rollback();
				$this->connection->close();
				return $error;
			}
		}
		
///////////////// ******** ---- 	 FIN dataTransact		------ ************ //////////////////


///////////////// ******** ---- 	 transact		------ ************ //////////////////
	// Crea una transaccion
		// Como parametros puede recibir:
			// $query-> consulta a ejecutar

		public function transact($query){
			$this->connect();
			$this->connection->autocommit(false);
			
			if($this->connection->query('BEGIN;')){
				if($this->connection->multi_query($query)){
					$this->connection->commit();
					$this->connection->close();
					return true;
				}else{
					$error = $this->connection->error;
					$this->connection->rollback();
					$this->connection->close();
					return false;
				}		
			}else{
				$error = $this->connection->error;
				$this->connection->rollback();
				$this->connection->close();
				return false;
			}
		}
		
///////////////// ******** ---- 	 FIN transact		------ ************ //////////////////
		
///////////////// ******** ---- 	escapar		------ ************ //////////////////
// Escapa las cadenas de caracteres para evitar posible ataques a la base de datos o el sistema
	// Como parametros puede recibir:
		// data -> cadena a validar
		
		function escapar($data){
			/* Referencia: http://stackoverflow.com/questions/1336776/xss-filtering-function-in-php */
 			/* Referencia: http://www.forosdelweb.com/f18/funcion-para-evitar-xss-sql-injection-958648 */
			
			$this->connect();
		
		// Elimina entidades;
			$data = urldecode($data);
			$data = str_replace(array('&amp;','&lt;','&gt;'), array('&amp;amp;','&amp;lt;','&amp;gt;'), $data);
			$data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
			$data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
			$data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');
			
		// Elimina etiquetas XMLns
			$data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);

		// Elimina javascript
			$data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
			$data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
			$data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);

		// IE
			$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
			$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
			$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);

		// Elimina etiquetas de los elementos
			$data = str_ireplace("<","",$data);
			$data = str_ireplace(">","",$data);
			$data = str_ireplace("/","",$data);
			$data = str_ireplace("\\","",$data);
			
			do{
			// Elimina mas etiquetas
				$old_data = $data;
				$data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
			}while ($old_data !== $data);

		// Elimina palabras reservadas:
       		$palabras1 = array(
           		'javascript', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink', 'link',
          	 	'style', 'script', 'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer',
           		'layer', 'bgsound', 'title', 'base'
       		);
	       	$palabras2 = array(
	           	'onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate',
	           	'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste',
	           	'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange',
	           	'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut',
	           	'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate',
	           	'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop',
	           	'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout',
	           	'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture',
	           	'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover',
	           	'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange',
	           	'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter',
	           	'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange',
	           	'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload', 'alert(', ');', 'function'
	       	);
       		$palabrasreservadas = array_merge($palabras1, $palabras2);
			foreach($palabrasreservadas as $pr){
				$data = str_replace($pr,"  ",$data);
			}
			
			$data = strip_tags($data);
			$data = mysqli_real_escape_string($this->connection, $data);
			
			$this->close();
			
			return $data;
		}
	
///////////////// ******** ---- 	FIN escapar		------ ************ //////////////////

///////////////// ******** ---- 	 encriptar		------ ************ //////////////////
// Encripta una cadena y la devuelve encriptada
	// Como parametros puede recibir:
		// $cadena-> cadena a encriptar

		function encriptar($cadena){
			$string = base64_encode('Tu_punto_de_venta_'.$cadena);
			$string = '$Tu%punto*de+venta'.$string;
			$string .= base64_encode($cadena);
			$cadena = $string;
			
			$salt = md5($cadena);
			$cadena = crypt($cadena, $salt);
			
			$cadena = $string.$cadena;
			
			return $cadena;
		}
		
///////////////// ******** ---- 	 FIN encriptar		------ ************ //////////////////
	}
?>