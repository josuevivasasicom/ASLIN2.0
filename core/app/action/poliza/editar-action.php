<?php

class editPoliza{
    public static function editarPoliza($r){
        //Editar la poliza por el id del listado de siniestro_polizas
        $timerst = trim($r['timerst'],' ');
        $id = trim($r['id'],' ');
        $poliza = trim($r['poliza'],' ');

        $deducible = str_replace(',','',  trim($r['deducible'],' $ , ') );
        $reserva = str_replace(',','', trim($r['reserva'],' $ , '));
        $coaseguro = str_replace(',','', trim($r['coaseguro'],' $ , '));
        $sumaAsegurada = str_replace(',','', trim($r['sumaAsegurada'],' $ , '));


        $sql="UPDATE siniestros_polizas set deducible = '$deducible', reserva='$reserva', coaseguro='$coaseguro', sumaAsegurada='$sumaAsegurada' where id = '$id'";
        $query= Database::ExeDoIt($sql,false);

        //inserta historico siniestro

        core::insertHistoricoSiniestros('Actualización',"Se ajustaron valores de la póliza, $poliza",$timerst);

        print "ok";
    }

}

if (isset($_REQUEST['method']) && $_REQUEST['method'] == 'porID/unico'){
    editPoliza::editarPoliza($_REQUEST);
}

