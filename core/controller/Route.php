<?php
// @elmm Un action corresponde a una rutina de un modulo sin VIEW
// @elmm Un view corresponde a una vista
/**
* @function action
* @elmm la funcion action ejecuta una rutina correspondiente a un modulo
**/	

class Route {

	public static $urlV= "core/app/view/";
	public static $urlA= "core/app/action/";
/************************************************************************
 ******************************* action *********************************
************************************************************************/
	public static function action($action){
		// Module::$module;
		
		if(isset($_GET['action'])){
			$level= core::getPowerLevel();
			if(Route::isValid('action')){
				include self::$urlA.$_GET['action']."-action.php";  ///url action
			}else{
				Route::Error("<b> ". self::$urlA.$_GET['action']."-action.php;;;; <br> 404 No se tiene acceso.</b> action <b>".$_GET['action']."</b> !! - <a href='index.php' target='_blank'>regresar</a>");
			}
		}else{
			// include self::$urlA.$action."-action.php";  ///url action
			Route::Error("<b>404 No se tiene acceso.</b> action <b>".$_GET['action']."</b> !! - <a href='index.php' target='_blank'>regresar</a>");
		}
	}

	/**
	* @function isValid
	* @elmm valida la existencia de una vista o accion
	**/	
	public static function isValid($val){
		$level= core::getPowerLevel().'/';
		$valid=false;
		if ($val == 'action') $level='';
		/////core::preprint( "core/app/".$val."/".$level.$_GET[$val]."-".$val.".php"  );exit;
		if(file_exists($file = "core/app/".$val."/".$level.$_GET[$val]."-".$val.".php")){
			$valid = true;
		}
		return $valid;
	}

	public static function Error($message){
		print $message;
	}

	public function execute($action,$params){
		$fullpath =  self::$urlA.$action."-action.php";  ///url action
		if(file_exists($fullpath)){
			include $fullpath;
		}else{
			assert("wtf");
		}
	}

/************************************************************************
 ******************************* view ***********************************
************************************************************************/

	public static function view($view){  
		$level= core::getPowerLevel();
		if(isset($_GET['view']) && isset( $_SESSION["id"])){ //si view esta definido y es usuario logeado
			if(Route::isValid('view')){
				include self::$urlV.$level.'/'.$_GET['view']."-view.php";
			}else{
				Route::Error("<b> ".self::$urlV.$level.'/'.$_GET['view']."-view.php <br>404 No se encontró una vista.</b>  <b>".$_GET['view']."</b> !! - 'view/'.$level  <a href='#' target='_blank'>regresar</a>");
			}
		}else{
			// include "core/app/view/index-view.php";
			// <?php Route::view("index");
			// echo "hola";
			header("Location: ./?view=index");

		}


	}
}