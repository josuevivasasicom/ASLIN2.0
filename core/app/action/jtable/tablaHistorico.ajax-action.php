<?php

class TablaHistorico{

  /*=============================================
  MOSTRAR LA TABLA DE HISTORICO GENERAL
  =============================================*/
  public function mostrarTabla(){ //SE EJECUTA POR DEFAULT
    $R = $_REQUEST;
    $limitSup = $_REQUEST["jtPageSize"]??25; //registros por página
    $limitInf = $_REQUEST["jtStartIndex"]??0; // número de página * (registros por página)
    $pageView = $R['pageView']??1;
    $orden = 'order by '.($R['jtSorting']??' id ASC ');

    $filtro=$orden." limit ".$limitInf.",". $limitSup;

    //? Trae todos los historicos
    $datosHistorico = "select h.*,concat(u.nombre,' ',u.paterno,' ',u.materno) usuarioN from historico h
    inner join usuarios u 
    on h.usuario = u.id ".$filtro;
    $query= Database::ExeDoIt($datosHistorico);
    $datosHistorico = Model::many_assoc($query[0]);
    foreach ($datosHistorico as $key => $value) {
      $datosHistorico[$key]['historico']= urldecode( $datosHistorico[$key]['historico']);
    }
    
    //? cuenta todos los historicos
    $query_total = "select count(id) totalHistorico from historico ";
    
    $query= Database::ExeDoIt($query_total);
    $query_total = Model::many_assoc($query[0]);
    $query_total= $query_total[0]['totalHistorico'];

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
    $jTableResult['data'] = "Lista de historico general";
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
  $activar -> mostrarTabla($_REQUEST['jtable']); //mostrra la tabla de historico general
}else{ 
  echo "Error de permisos;";
}