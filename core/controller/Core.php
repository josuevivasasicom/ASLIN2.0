<?php
// Core.php
// @elmm obtiene las configuraciones, muestra y carga los contenidos necesarios.
class Core {
	public static $theme = "";
	public static $root = "";
	public static $rol = "";


	// public static $userid = null; //se define en action=login
	// public static $user = null; //se define en action=login
	public static $userdata = []; //se define en action=login
	public static $debug_sql = false;

	public static function getKeyPass(){
		$DesdeLetra = "A";
		$HastaLetra = "Z";
		$DesdeNumero = 1;
		$HastaNumero = 9;
		$lAlter = chr(rand(ord($DesdeLetra), ord($HastaLetra))) . chr(rand(ord($DesdeLetra), ord($HastaLetra)));
		$numAlter = rand($DesdeNumero, $HastaNumero) . rand($DesdeNumero, $HastaNumero);
		return $lAlter . $numAlter;
		//regresa un valor como AZ45
	}

	public static function getPowerLevel(){
		if (isset($_SESSION['rol']) and $_SESSION['rol']!=''){
			switch ($_SESSION['rol']) {
				case '1': // administrador
				case '4': // administrador de siniestros
					return 'admin'; 
					break;
				case '2':// jefe de área
					return 'jefe';
					break;
				case '3': //abogado
					return 'abogado';
				default:
					return 'usuario';
					break;
			}
		}else{
			return 'no usuario';
		}
		
	}

	public static function fecha_ed($fecha){
		//* [start] => Mon Aug 30 2021 08:15:00 GMT-0500 (hora de verano central)
		$fechaStart= explode(' ',$fecha); 
		$___dia_seleccionado = $fechaStart[2];
		$___mes_seleccionado = $fechaStart[1];
		$___año_seleccionado = $fechaStart[3];
		$___hora_seleccionado = $fechaStart[4];
		switch ($___mes_seleccionado) {
			case 'Jan':
				$___mes_seleccionado = '01';
				break;
			case 'Feb':
				$___mes_seleccionado = '02';
				break;
			case 'Mar':
				$___mes_seleccionado = '03';
				break;
			case 'Apr':
				$___mes_seleccionado = '04';
				break;
			case 'May':
				$___mes_seleccionado = '05';
				break;
			case 'Jun':
				$___mes_seleccionado = '06';
				break;
			case 'Jul':
				$___mes_seleccionado = '07';
				break;
			case 'Aug':
				$___mes_seleccionado = '08';
				break;
			case 'Sep':
				$___mes_seleccionado = '09';
				break;
			case 'Oct':
				$___mes_seleccionado = '10';
				break;
			case 'Nov':
				$___mes_seleccionado = '11';
				break;
			case 'Dec':
				$___mes_seleccionado = '12';
				break;
		}
		$data = [$___dia_seleccionado,$___mes_seleccionado,$___año_seleccionado,$___hora_seleccionado];
		return $data;
	}

	public static function getMicrotime($time=0){
		date_default_timezone_set("America/Mexico_City");
		if($time==0){
			$timestamp = microtime(true);
		}else{
			$timestamp = microtime(true);
			if($time==$timestamp){
				usleep(2222);
				$timestamp = microtime(true);
			}
		}

		if($time==$timestamp){
			self::getMicrotime($time);
		}
		return $timestamp;
	}

	public static function getTimeStamp($time=0){
		date_default_timezone_set("America/Mexico_City");
		if($time==0){$time=self::getTimeNow();}
		$date = new DateTime($time);
		$timestamp = $date->getTimestamp();
		return $timestamp;
	}

	public static function getTimeNow(){
		date_default_timezone_set("America/Mexico_City");
		setlocale(LC_ALL,"ES");
		$_hora_ = date("Y-m-d H:i:s"); 
		return $_hora_;
		//$HOY = date("Y-m-d");
        //sumo 1 día
        //echo "<br>";
        //$fecha_limite = date("Y-m-d",strtotime($HOY."+ 5 days"));
	}
	// $end = date("Y-m-d H:i:s",strtotime($start."+ 2 minute")); 

	public static function getTimeNowString($date='',$time=false){
		date_default_timezone_set("America/Mexico_City");
		setlocale(LC_ALL,"ES");

		if($date==''){
			return strftime("%A %d de %B del %Y");
		}
		else{// en casi de tener una fecha para convertir de numero a texto
			$string = $date; ///? sample "24/11/2014";
			//$dateN = DateTime::createFromFormat("d/m/Y", $string);

			/* $date = new DateTime($time);
			$timestamp = $date->getTimestamp();
			return $timestamp;

			return $timestamp; */

			setlocale(LC_TIME, "spanish");
			$mi_fecha = '2018/04/16';
			$mi_fecha = str_replace("/", "-", $mi_fecha);			
			$Nueva_Fecha = date("d-m-Y", strtotime($mi_fecha));				
			$Nueva_Fecha = date("d-m-Y", strtotime($date));	
			
			$Mes_Anyo = strftime("%A, %d de %B de %Y", strtotime($Nueva_Fecha));
			if ($time){
				$h = explode(' ',$date)[1];
				$Mes_Anyo = strftime("%A, %d de %B de %Y", strtotime($Nueva_Fecha));      // %#I %Hh %Mm %Ss
			}			
			
			//devuelve: lunes, 16 de abril de 2018 
			return $Mes_Anyo.' '.$h;


		}
	}
	
	public static function sendVarToJs($varPhp,$varJs){
		echo "<script>
		        var $varJs = ". $varPhp .
		 	"/*variable varJs*/
			 </script>";
	}

	public static function sendStringToJs($varPhp,$varJs){
		echo '<script> var '.$varJs.' = "' . $varPhp . '" /*variable varJs*/ </script>';
	}
    
	public static function alert($text){
		$alert="<div id='recuperar-lightbox' class='lightbox-basic zoom-anim-dialog mfp-hide' style='border:none,padding: none;width: 100%;'>
			<div class='alert alert-error' style='position:relative'>
            <strong>Error!</strong> $text </div></div>";
	}

	public static function redir($url){
		echo "<script>window.location='".$url."';</script>";
	}

	public static function preprint($param, $name='parametro: ',$exit=false){
		echo "<pre> in $name <br>";
		print_r( $param );
		echo ":out</pre><br>";
		if($exit) exit();
	}

	/**
	 * @Param new debe traer un array con los nombres de las columnas en las tablas, y su valor.
	 */
	public static function seleccionaUnoParaComparar($tabla,$identificador,$new){
		//esta funcion debe comparar un new valor con un old valor y los recorre para saber cual es el cambio UTIL PARA /HISTORICO POR CAMBIOS
		$resultado = [];
		$sql= "select * from $tabla where id = $identificador";
		$query = Database::exeDoIt($sql);
		if($query[0]->num_rows==1){
			$data=Model::many_assoc($query[0])[0];
			foreach ($new as $key => $val) {
				if (isset($data[$key])){ //compara si existe la clave en ambos arrays
					//compara si son iguales
					if(    trim(strtolower($data[$key]))    !=    trim(strtolower($new[$key]))    ){
						$resultado[] = array(
							'campo'=> $key,
							'anterior'=> $data[$key],
							'nuevo'=> $val
						);
					}else{
						$resultado[] = array(
							'campo'=> $key,
							'anterior'=> $data[$key],
							'nuevo'=> null
						);
					}
				}else{// la clave no existe en el data anterior
					//!esto jamas debe pasar
					$resultado[] = array(
						'campo'=> $key,
						'anterior'=> 'no existe',
						'nuevo'=> $val
					);
				}
			}
			return $resultado; //retorna el resultado de la comparativa
		}
		else{
			echo 'hay mas resultados de los esperados #core158' ;
		}
	}


	public static function insertHistorico($movimiento,$historico,$entidad){
		//guarda un historico de movimientos 
		$usuario = $_SESSION['id'];
		$sql ="insert into historico(movimiento,usuario,historico,fecha_modificacion,entidad)
		    values ('$movimiento',$usuario,'".urlencode($historico)."','".core::getTimeNow()."','".$entidad."')";
		// core::preprint($sql,'update historial');exit();

		$query = Database::exeDoIt($sql);
		if($query) return true;
	}

	/**
	 * insertHistoricoSiniestros function
	 *
	 * @param string  $movimiento es el tipo de movimiento del siniestro CRUD
	 * @param string  $historico  cadena de texto con los cambios
	 * @param string  $timerst  identificador tiempo unico
	 * @return void true o null si se ejecuta correctamente
	 */
	public static function insertHistoricoSiniestros($movimiento,$historico,$timerst){ 
		//guarda un historico de movimientos 
		$usuario = $_SESSION['id'];
		$sql ="insert into siniestros_historico(movimiento,usuario,historico,fecha,timerst)
		    values ('$movimiento',$usuario,'".urlencode($historico)."','".core::getTimeNow()."','".$timerst."')";
		// core::preprint($sql,'update historial de siniestros');
		$query = Database::exeDoIt($sql);
		if($query) return true;
	}

	public static function getAreaNombre($idArea){
		if($idArea=='principal'){
			return 'ID';
		}
		$sql ="select area from areas where id = ".$idArea." limit 1;";
		$query = Database::exeDoIt($sql);
		$dat = Model::many_assoc($query[0])[0]['area'];
		if($query) return $dat;
		return 'no existe área';
	}

	public static function compruebaVacios($data){
		//comprueba que nungun valor este vacio.
		foreach ($data as $key=>$val) {
			if ($val=='')//si algun campo esta vacio, retorna false
			return false;
		  }
		return true;
	}


	public static function camposEditar($valoresComparados){
		//devuelve string de los valores a editar para historico y updateSQL
		$CamposEditar='';
		$camposHistorico='';
		foreach ($valoresComparados as $key) { // campo, nuevo, anterior
		  if($key['nuevo']!=''){
			$CamposEditar .= " ".$key['campo']." = '".$key['nuevo']."', ";
			$camposHistorico.= " ".$key['campo']." -> anterior: '".$key['anterior']."' ; nuevo: '".$key['nuevo']."' |";
		  }
		}
		$CamposEditar = rtrim($CamposEditar,', ');
		return [$CamposEditar,$camposHistorico];
	}

}



?>