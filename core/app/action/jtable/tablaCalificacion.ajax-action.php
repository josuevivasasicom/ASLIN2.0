<?php

class TablaCalificacion{

  /*=============================================
  MOSTRAR TABLA DE CALIFICACION EN TABLA JTABLE
  =============================================*/
  public function mostrarJtableCalificacion(){ //SE EJECUTA POR jtable param
    $R = $_REQUEST;
    $limitSup = $_REQUEST["jtPageSize"]??25; //registros por página
    $limitInf = $_REQUEST["jtStartIndex"]??0; // número de página * (registros por página)
    $pageView = $R['pageView']??1;
    $orden = 'order by '.($R['jtSorting']??' id ASC ');

    //? Trae todos los estatus
      $estatusList = Config::getAllCalificacion($orden,$limitInf,$limitSup);

    //? cuenta todos los Estatus
    $query_total= Config::countCalificacionTodos();

    //? Actualiza valores.
    $paginas = round($query_total /  $limitSup);
    $result['TotalRecordCount']= $query_total;
    $result['rowTotal']= $query_total;
    $result['pages']= $paginas;
    $result['jtStartIndex']= $limitInf *  $pageView;
    $result['jtPageSize']=  $limitSup;


    $jTableResult = array();
    $jTableResult['Result'] = "OK";
    $jTableResult['data'] = "Lista de los CALIFICACION en tabla";
    $jTableResult['TotalRecordCount'] = $query_total;
    $jTableResult['Records'] = $estatusList;
    print json_encode($jTableResult);
  }
}




/*=============================================
ACTIVAR TABLA SEGUN EL POST O GET
=============================================*/ 
$activar = new TablaCalificacion();
if(isset($_REQUEST['jtable'])){
  $activar -> mostrarJtableCalificacion(); //mostrra la tabla de calificacion
}else{ // mostrará todos los usuarios
  echo "error, sin acceso";
}