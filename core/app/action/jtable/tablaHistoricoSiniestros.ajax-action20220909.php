<?php

class TablaHistorico{

  /*=============================================
  MOSTRAR LA TABLA DE HISTORICO SINIESTROS
  =============================================*/
  public function mostrarTabla(){ //SE EJECUTA POR DEFAULT
    $R = $_REQUEST;
    $limitSup = $_REQUEST["jtPageSize"]??25; //registros por página
    $limitInf = $_REQUEST["jtStartIndex"]??0; // número de página * (registros por página)
    $pageView = $R['pageView']??1;
    $orden = 'order by '.($R['jtSorting']??' fechaN DESC ');

    $filtro = $orden." limit ".$limitInf.",". $limitSup;

    //? Trae todos los historicos
    $datosHistorico = "select  fecha as fechaN, concat(s.f_numProv,'-',LPAD(s.f_consecutivo,3,'0'),'-', SUBSTRING_INDEX(f_year,'0',-1) ) folio,h.*,DATE_FORMAT(h.fecha, '%e %b %Y %H:%i') fecha,concat(u.nombre,' ',u.paterno,' ',u.materno) usuarioN from siniestros_historico h
    inner join usuarios u 
    on h.usuario = u.id 
    
    left join siniestros s 
    on h.timerst = s.timerst ".$filtro;
    
    $query= Database::ExeDoIt($datosHistorico);
    $datosHistorico = Model::many_assoc($query[0]);
     foreach ($datosHistorico as $key => $value) {
      $datosHistorico[$key]['historico']= urldecode( $datosHistorico[$key]['historico']);
    }
    
    //? cuenta todos los historicos
    $query_total = "select count(id) siniestrosHistorico from siniestros_historico ";
    
    $query= Database::ExeDoIt($query_total);
    $query_total = Model::many_assoc($query[0]);
    $query_total= $query_total[0]['siniestrosHistorico'];

    //? Actualiza valores.
    $paginas = round($query_total /  $limitSup);
    $result['TotalRecordCount']= $query_total;
    $result['rowTotal']= $query_total;
    $result['pages']= $paginas;
    $result['jtStartIndex']= $limitInf *  $pageView;
    $result['jtPageSize']=  $limitSup;

        //obtener datos de usuario y validar qeu se genere la tabla desde JS

    $jTableResult = array();
    $jTableResult['Result'] = "OK";
    $jTableResult['data'] = "Lista de historico de los siniestros";
    $jTableResult['TotalRecordCount'] = $query_total;
    $jTableResult['Records'] = $datosHistorico;
    print json_encode($jTableResult);
  }

  public function mostrarTablaByTimerst($timerst){ //SE EJECUTA POR ByTimerst en request
    $R = $_REQUEST;
    $limitSup = $_REQUEST["jtPageSize"]??25; //registros por página
    $limitInf = $_REQUEST["jtStartIndex"]??0; // número de página * (registros por página)
    $pageView = $R['pageView']??1;
    $orden = ' order by '.($R['jtSorting']??' fechaN DESC ');

    $filtro = $orden." limit ".$limitInf.",". $limitSup;

    //? Trae todos los historicos
    $s = "SET lc_time_names = 'es_ES';"; Database::ExeDoIt($s);
    $datosHistorico = "select fecha as fechaN, concat(s.f_numProv,'-',LPAD(s.f_consecutivo,3,'0'),'-', SUBSTRING_INDEX(f_year,'0',-1) ) folio,h.*,DATE_FORMAT(h.fecha, '%e %b %Y %H:%i') fecha,concat(u.nombre,' ',u.paterno,' ',u.materno) usuarioN from siniestros_historico h
    inner join usuarios u 
    on h.usuario = u.id 
    
    left join siniestros s 
    on h.timerst = s.timerst 
    where h.timerst = '".$timerst."' ".$filtro;
    
    $query= Database::ExeDoIt($datosHistorico,false);
    $datosHistorico = Model::many_assoc($query[0]);
     foreach ($datosHistorico as $key => $value) {
      $datosHistorico[$key]['historico']= urldecode( $datosHistorico[$key]['historico']);
    }
    
    //? cuenta todos los historicos
    $query_total = "select count(h.id) siniestrosHistorico from siniestros_historico h where h.timerst = '".$timerst."'";
    
    $query= Database::ExeDoIt($query_total,false);
    $query_total = Model::many_assoc($query[0]);
    $query_total= $query_total[0]['siniestrosHistorico'];

    //? Actualiza valores.
    $paginas = round($query_total /  $limitSup);
    $result['TotalRecordCount']= $query_total;
    $result['rowTotal']= $query_total;
    $result['pages']= $paginas;
    $result['jtStartIndex']= $limitInf *  $pageView;
    $result['jtPageSize']=  $limitSup;

        //obtener datos de usuario y validar qeu se genere la tabla desde JS

    $jTableResult = array();
    $jTableResult['Result'] = "OK";
    $jTableResult['data'] = "Lista de historico de los siniestros mostrarTablaByTimerst()";
    $jTableResult['TotalRecordCount'] = $query_total;
    $jTableResult['Records'] = $datosHistorico;
    print json_encode($jTableResult);
  }

}




/*=============================================
ACTIVAR TABLA SEGUN EL POST O GET
=============================================*/ 
$activar = new TablaHistorico();


if(isset($_REQUEST['jtable'])){
  $activar -> mostrarTabla($_REQUEST['jtable']); //mostrra la tabla de historico siniestros
}


else if(isset($_REQUEST['by_id'])){
  $activar -> mostrarTablaByTimerst($_REQUEST['by_id']); //mostrra la tabla de historico siniestros por su id timerst
}


else{ 
  echo "Error de permisos;";
}