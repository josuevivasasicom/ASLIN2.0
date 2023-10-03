<?php
class Database {
	public static $db;
	public static $con;
	function Database(){
		$adic = "lalo";
		switch ($_SERVER["HTTP_HOST"]){
			
			case 'localhost':
				if ($adic == "lalo"){
					
					$this->user="root";$this->pass="";$this->host="localhost";$this->ddbb="u934929740_cma";
				}else{
					$this->user="alternativo";$this->pass="";$this->host="localhost";$this->ddbb="u157777947_alternativa";
				}
				
				break;
			default:
				$this->user="alternativo";$this->pass="2r3ckl24n2l";$this->host="localhost";$this->ddbb="u157777947_alternativa";
				break;
		}
	}

	function connect(){
		switch ($_SERVER["HTTP_HOST"]){
			case 'localhost:8080':
				////$this->user="alternativo";$this->pass="Er3ckl24n2l";$this->host="localhost";$this->ddbb="u157777947_alternativa";
				$con = new mysqli("localhost","root","","u157777947_alternativa");
				break;
			case 'hoteles.demo':
				$con = new mysqli("localhost","root","","u157777947_hoteles");
				break;
			case 'grupodiemsa.com':
				////$this->user="alternativo";$this->pass="2r3ckl24n2l";$this->host="localhost";$this->ddbb="u157777947_alternativa";
				$con = new mysqli("localhost","u157777947_hoteles","vN4c3#gK0?","u157777947_hoteles");
				break;
			case 'www.grupodiemsa.com':
				////$this->user="alternativo";$this->pass="2r3ckl24n2l";$this->host="localhost";$this->ddbb="u157777947_alternativa";
				$con = new mysqli("localhost","u157777947_hoteles","vN4c3#gK0?","u157777947_hoteles");
				break;
			default:
				////$this->user="alternativo";$this->pass="2r3ckl24n2l";$this->host="localhost";$this->ddbb="u157777947_alternativa";
				$con = new mysqli("localhost","user","N4c3#gK0?","db");
				break;
		}
		return $con;
	}

	public static function getCon(){
		if(self::$con==null && self::$db==null){
			self::$db = new Database();
			self::$con = self::$db->connect();
		}
		return self::$con;
    }
    
    public static function ExeDoIt($sql){
		$con = Database::getCon();
		if(Core::$debug_sql){
			// echo "<pre> debug";
			// print_r($sql);
			// echo "</pre>";
			// exit();
		}
			// echo "<pre> good";
			// print_r($sql);
			// echo "<br>";
			// print_r($con->query($sql));
			// echo "</pre>";
			// exit();
		// print_r(array($con->query($sql),$con->insert_id)); exit();
		// if ($mysqli->error) return $mysqli->error;
	
		return array($con->query($sql),$con->insert_id);
	}
	
}
?>
