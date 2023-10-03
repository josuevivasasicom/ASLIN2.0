<?php

class TablaEstatus{

  /*=============================================
  MOSTRAR TABLA DE ESTATUS EN TABLA JTABLE
  =============================================*/
  public function mostrarJtableEstatus(){ //SE EJECUTA POR jtable param
    $R = $_REQUEST;
    $limitSup = $_REQUEST["jtPageSize"]??25; //registros por página
    $limitInf = $_REQUEST["jtStartIndex"]??0; // número de página * (registros por página)
    $pageView = $R['pageView']??1;
    $orden = 'order by '.($R['jtSorting']??' id ASC ');

    //? Trae todos los estatus
      $estatusList = Config::getAllEstatus($orden,$limitInf,$limitSup);

    //? cuenta todos los Estatus
    $query_total= Config::countEstatusTodos();

    //? Actualiza valores.
    $paginas = round($query_total /  $limitSup);
    $result['TotalRecordCount']= $query_total;
    $result['rowTotal']= $query_total;
    $result['pages']= $paginas;
    $result['jtStartIndex']= $limitInf *  $pageView;
    $result['jtPageSize']=  $limitSup;


    $jTableResult = array();
    $jTableResult['Result'] = "OK";
    $jTableResult['data'] = "Lista de los Estatus en tabla";
    $jTableResult['TotalRecordCount'] = $query_total;
    $jTableResult['Records'] = $estatusList;
    print json_encode($jTableResult);
  }
}




/*=============================================
ACTIVAR TABLA SEGUN EL POST O GET
=============================================*/ 
$activar = new TablaEstatus();
if(isset($_REQUEST['jtable'])){
  $activar -> mostrarJtableEstatus(); //mostrra la tabla de estatus
}else{ // mostrará todos los usuarios
  echo "error, sin acceso";
}