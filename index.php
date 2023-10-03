<?php 
/**
 * @author ELMM ASICOM
 */
date_default_timezone_set("America/Mexico_City");
define("ROOT", dirname(__FILE__));


switch ($_SERVER["HTTP_HOST"]){
    case 'asicom.systems':
        $debug= false;
        break;
    default:
        $debug= true;
        break;
}
$debug=true;
if($debug){
    // log_errors('on');
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL & ~E_DEPRECATED);
}else{
    // log_errors('off');
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    error_reporting(0);
}

include "core/autoload.php";


ob_start();
session_start();
// Core::$rol="";

// si quieres que se muestre las consultas SQL debes decomentar la siguiente linea
// Core::$debug_sql = true;

$lb = new Lb();
$lb->start();

$mode= "prod"; //style see to config theme

?>
