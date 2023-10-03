<?php

class InformeCancelacion{
    //pone la plantilla con los datos del siniestro 
    public static function guardarInformeCancelacion($timerst,$data){
        Siniestros::guardarInformeCancelacion($timerst,$data);
    }

    //carga todo el contenido de la plantilla solo lectura.
    public static function verInformeCancelacion($timerst){
        Siniestros::verInformeCancelacion($timerst);
    }

}


/************************************
 * ACTIVACION DE LA CLASE INFORME PRELIMINARSEGUN LOS PARAMETROS.
 ************************************/

//si existe timers va a colocar la plantilla nueva DEL INFORME PRELIMINAR
if(isset($_REQUEST['guardar']) and $_REQUEST['guardar']!=''){
    InformeCancelacion::guardarInformeCancelacion($_REQUEST['guardar'],$_REQUEST['data']);
}
else
//si no existe y solo trae VER con su respectivo timerst entonces solo carga el contenido para verlo en solo lectura.
if(isset($_REQUEST['ver']) and $_REQUEST['ver']!=''){
    InformeCancelacion::verInformeCancelacion($_REQUEST['ver']);
}

