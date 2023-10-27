<?php
class Database {
	public static $db;
	public static $con;
	function Database(){
		$adic = "josue";
		switch ($_SERVER["HTTP_HOST"]){
			
			case 'localhost:8080':
				$this->user="root";$this->pass="";$this->host="localhost:3306";$this->ddbb="u934929740_cma";
				break;
			case 'localhost':
				if ($adic == "josue"){		
					$this->user="root";$this->pass="";$this->host="localhost";$this->ddbb="u934929740_cma";
				}else{
					$this->user="root";$this->pass="";$this->host="localhost";$this->ddbb="u934929740_cma";
				}
				
				
			default:
				// $this->user="u568487839_cma_us";$this->pass="2r3ckL24n2l";$this->host="localhost";$this->ddbb="u568487839_cma";
				$this->user="u934929740_cma_us";$this->pass="eT5]kWoNh";$this->host="localhost:3306";$this->ddbb="u934929740_cma";
				break;
		}
	}

	function connect(){
		$adic = "josue";
		switch ($_SERVER["HTTP_HOST"]){
			
			case 'localhost:8080':
				////$this->user="alternativo";$this->pass="2r3ckl24n2l";$this->host="localhost";$this->ddbb="u157777947_alternativa";
				$con = new mysqli("localhost:3306","root","","u934929740_cma");
				// var_dump($con);
				// die();
				break;
				case 'localhost':
					if ($adic == "josue"){
						$con = new mysqli("localhost","root","","u934929740_cma");
					}else{
						$con = new mysqli("localhost","root","","u934929740_cma");
					}
					$con -> set_charset("utf8");
				
					break;
						
			default:
				////$this->user="alternativo";$this->pass="2r3ckl24n2l";$this->host="localhost";$this->ddbb="u157777947_alternativa";
				$con = new mysqli("localhost","u934929740_cma_us","eT5]kWoNh","u934929740_cma");
				$con -> set_charset("utf8");
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
    
    public static function ExeDoIt($sql,$debug=false,$exit=false){
		if($debug){
			echo "<pre> debug--> <br>";
			print_r($sql);
			echo "<---- debug </pre>";
			if($exit) exit();
		}
		$con = Database::getCon();

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
