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

	public static function getTimeNow(){
		date_default_timezone_set("America/Mexico_City");
		$_hora_ = date("Y-m-d H:i:s"); 
		return $_hora_;
	}
	// $end = date("Y-m-d H:i:s",strtotime($start."+ 2 minute")); 
	
	public static function sendVarToJs($varPhp,$varJs){
		echo "<script>
				//variable varJs
		        var $varJs = ". $varPhp .
		 	"</script>";
	}
    
	public static function alert($text){
		$alert="<div id='recuperar-lightbox' class='lightbox-basic zoom-anim-dialog mfp-hide' style='border:none,padding: none;width: 100%;'>
			<div class='alert alert-error' style='position:relative'>
            <strong>Error!</strong> $text </div></div>";
	}

	public static function redir($url){
		echo "<script>window.location='".$url."';</script>";
	}

	public static function preprint($param, $name='parametro: '){
		echo "<pre> in $name <br>";
		print_r( $param );
		echo ":out</pre><br>";
	}

	

}



?>