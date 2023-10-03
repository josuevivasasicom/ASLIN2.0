<?php
/**
* Esta funcion contiene el nombre de los identificadores que se usaran como variables de session
* y tambien los setters y getters correspondientes.
**/

class Session{

	public static function setSessionUser($data){
		$set=false;
		if (Core::$userdata['id']==$data->id){ 
			// $_SESSION['data'] = array($data);
			foreach ($data as $key => $value) {$_SESSION[$key] = $value;}
			// foreach ($data as $key => $value) {$_SESSION['data'] = $key =>$value;} tarea
			$_SESSION["password"]="****";
			$set=true;
		}

		return $set;
		/* expira en 1 hora 
		setcookie("id", $id, time()+3600);*/
	}

	public static function setUID($uid){
		$_SESSION['id'] = $uid;
	}

	public static function unsetUID(){
		if(isset($_SESSION['id']))
			unset($_SESSION['id']);
	}

	public static function issetUID(){
		if(isset($_SESSION['id']))
			return true;
		else return false;
	}

	public static function getUID(){
		if(isset($_SESSION['id']))
			return $_SESSION['id'];
		else return false;
	}

}

?>