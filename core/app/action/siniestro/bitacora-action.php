<?php
class Bitacora{

    //CREAR UNA NUEVA ENTRADA EN LA BOTACORA
    public static function NuevaEntrada($r){
       Siniestros::nuevaEntradaBitacora($r);
    }
    
    // VERIFICAR UNA ENTRADA BITACORA
    public static function verificar($r){
        Siniestros::verificarBitacora($r);
    }

    // VERIFICAR UNA ENTRADA BITACORA
    public static function editarBitacora($r){
        Siniestros::editarBitacora($r);
    }
    
}


/************************************
 * ACTIVACION DE LA CLASE PRIMERA ATENCION SEGUN LOS PARAMETROS.
 ************************************/
if (isset($_REQUEST['metodo'])){

    switch ($_REQUEST['metodo']) {
        case 'nuevo':
            Bitacora::NuevaEntrada($_REQUEST);
            break;
        case 'verificar':
            Bitacora::verificar($_REQUEST);
            break;
        case 'editar':
            Bitacora::editarBitacora($_REQUEST);
            break;
        default:
          print "no tienes acceso.";
            break;
    }
}