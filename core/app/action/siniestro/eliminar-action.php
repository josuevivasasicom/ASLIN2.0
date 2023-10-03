<?php

    //include_once('../../model/Siniestros.php');
    class eliminarSiniestro{
        public static function eliminar(){
                $R = $_REQUEST;
                $id = $R['id'];
                $timerst = $R['timerst'];

                echo Siniestros::eliminarArchivo($id , $timerst);
            
        }
    }

    if(!isset($_REQUEST['method']) ){
        exit();
        }
        
        switch ($_REQUEST['method']) {
            case 'eliminarfile/ver':                
                # ver toda la libreta por usuario
                eliminarSiniestro::eliminar($_REQUEST);
                break;       
        
            default:
                # code...
                break;
        }

?>