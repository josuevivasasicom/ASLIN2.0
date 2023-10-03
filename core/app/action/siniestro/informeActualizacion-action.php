<?php

class InformeActualizacion{
    //pone la plantilla con los datos del siniestro 
    public static function guardarinformeActualizacion($timerst,$data){
        Siniestros::guardarInformeActualizacion($timerst,$data);
    }

    //carga todo el contenido de la plantilla solo lectura.
    public static function verinformeActualizacion($timerst,$area){
        Siniestros::verInformeActualizacion($timerst,$area);
    }

}


/************************************
 * ACTIVACION DE LA CLASE PRIMERA ATENCION SEGUN LOS PARAMETROS.
 ************************************/

//si existe timers va a colocar la plantilla nueva
if(isset($_REQUEST['guardar']) and $_REQUEST['guardar']!=''){
    InformeActualizacion::guardarinformeActualizacion($_REQUEST['guardar'],$_REQUEST['data']);
}
else
//si no existe y solo trae VER con su respectivo timerst entonces solo carga el contenido para verlo en solo lectura.
if(isset($_REQUEST['ver']) and $_REQUEST['ver']!=''){
    InformeActualizacion::verinformeActualizacion($_REQUEST['ver'],$area);
}

