<?php

class DownloadExcelSiniestros{
   /*=============================================
  DescargarExcel
  =============================================*/
  public function descargarExcelBitacorasSn($timerst){ //

    
    $sql="SET lc_time_names = 'es_ES';";
        $query = Database::ExeDoIt($sql);
        $sql="select sb.usuario usuarioID, sb.*,DATE_FORMAT(sb.fecha_actividad, '%e %b %Y') fecha_actividad_F, DATE_FORMAT(sb.fecha_creacion, '%e %b %Y %H:%i') fecha_creacion_F, if(sb.verificado=0,' ','Verificado') verificado, concat(u.nombre,' ',u.paterno, ' ', u.materno ) usuario, concat(uA.nombre,' ',uA.paterno) usuario_alter 
        from siniestros_bitacora sb 
        inner join usuarios u on u.id= sb.usuario
        left join usuarios uA on uA.id= sb.usuario_alter
        where timerst ='".$timerst."' order by sb.fecha_creacion desc";
        $query = Database::ExeDoIt($sql,false);
        $data=[];
        if($query[0]->num_rows>=1){
            $data = Model::many_assoc($query[0]);
            // core::preprint($data);
            foreach ($data as $k => $v) {
                // core::preprint($v['bitacora'],'bitacora ');
                // core::preprint($k,'k ',true);
                $data[$k]['bitacora'] = urldecode($v['bitacora']);
            }
            $newData=[];
        }
        // core::preprint($data);
        // exit();
        $bitacoras =  $data;
        

    $jTableResult = array();
    $jTableResult['Result'] = "OK";
    $jTableResult['data'] = "Lista para descargar bitacoras por id en excel";
    $jTableResult['Records'] = $bitacoras;
    print json_encode($jTableResult);
  }

}

/*=============================================
ACTIVAR TABLA SEGUN EL POST O GET
=============================================*/ 
$activar = new DownloadExcelSiniestros();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(1);

$timerst = $_REQUEST['timerst'];

$activar->descargarExcelBitacorasSn($timerst);