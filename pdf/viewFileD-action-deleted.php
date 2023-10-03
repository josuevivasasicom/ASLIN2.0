<?php
//?? ESTE ARCHIVO DEVE VER SI ES PDF, RENDERIZAR EL ARCHIVO PARA VERLO. PERO SI ES OTRA EXTENSION DEBE DESCARGARLO
//?? ***************************************************************************************************************
class viewFileD{
    public static function renderFile($timerst,$doc){
        //revisar la extension del archivo.
        $sql='select * from siniestros_files where timerst = "'.$timerst.'" AND estatus = 1 and url = "'.$doc.'";';

        //si es PDF o imagen. mostrarlo en MODAL

        //si es cualquier otro formato, DESCARGARLO

    }

}

if (isset($_REQUEST['timerst']) &&  isset($_REQUEST['doc']) ){
    $vf = new viewFileD();
    $vf::renderFile($_REQUEST['timerst'],$_REQUEST['doc']);
}else{
    echo "No tienes permiso";
    exit();
}