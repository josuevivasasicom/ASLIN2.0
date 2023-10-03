<?php

class TablaInstituciones{

  /*=============================================
  MOSTRAR LA TABLA DE INSTITUCIONES LISTADO
  =============================================*/
  public function mostrarTabla(){ //SE EJECUTA POR DEFAULT
    $R = $_REQUEST;
    $limitSup = $_REQUEST["jtPageSize"]??25; //registros por página
    $limitInf = $_REQUEST["jtStartIndex"]??0; // número de página * (registros por página)
    $pageView = $R['pageView']??1;
    $orden = 'order by '.($R['jtSorting']??' id ASC ');

    $filtro=$orden." limit ".$limitInf.",". $limitSup;

    //? Trae todos los usuarios
    $datosTiket = Folios::obtenerProvenientes($filtro);
    //? cuenta todos los usuarios
    $query_total= count($datosTiket);

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
    $jTableResult['data'] = "Lista de todos los usuarios";
    $jTableResult['TotalRecordCount'] = $query_total;
    $jTableResult['Records'] = $datosTiket;
    print json_encode($jTableResult);
  }

  /*=============================================
  MOSTRAR TABLA DE INSTITUCIONES EN TABLA JTABLE
  =============================================*/
  public function mostrarJtableInstituciones(){ //SE EJECUTA POR jtable param
    $R = $_REQUEST;
    $limitSup = $_REQUEST["jtPageSize"]??25; //registros por página
    $limitInf = $_REQUEST["jtStartIndex"]??0; // número de página * (registros por página)
    $pageView = $R['pageView']??1;
    $orden = 'order by '.($R['jtSorting']??' id ASC ');

    //? Trae todos los instituciones
      $instituciones = Config::getAllInstituciones($orden,$limitInf,$limitSup);

    //? cuenta todos los Instituciones
    $query_total= Config::countInstitucionesTodos();

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
    $jTableResult['data'] = "Lista de los Instituciones en tabla";
    $jTableResult['TotalRecordCount'] = $query_total;
    $jTableResult['Records'] = $instituciones;
    print json_encode($jTableResult);
  }
  

}




/*=============================================
ACTIVAR TABLA SEGUN EL POST O GET
=============================================*/ 
$activar = new TablaInstituciones();
if(isset($_REQUEST['jtable'])){
  $activar -> mostrarJtableInstituciones(); //mostrra la tabla de Instituciones
}else{ // mostrará todos los usuarios
  $activar -> mostrarTabla();
}