<?php

class TablaSiniestrosAbogados{

  /*=============================================
  MOSTRAR LA TABLA DE siniestros sin parametros, trae TODOOOOSSSS segmentados por areas del abo0gado
  =============================================*/
  public function mostrarTabla($area,$asignados){ //SE EJECUTA POR DEFAULT
    $R = $_REQUEST;
    $limitSup = $_REQUEST["jtPageSize"]??25; //registros por página
    $limitInf = $_REQUEST["jtStartIndex"]??0; // número de página * (registros por página)
    $pageView = $R['pageView']??1;
    $orden = 'order by '.($R['jtSorting']??' id ASC ');

    //? cuenta todos los siniestros
    $query_total= SiniestrosAbogado::countTodosSiniestros('','',$area,$asignados); //?devuelve un string con el número

    //? Actualiza valores.
    $paginas = round($query_total /  $limitSup);
    $result['TotalRecordCount']= $query_total;
    $result['rowTotal']= $query_total;
    $result['pages']= $paginas;
    $result['jtStartIndex']= $limitInf *  $pageView;
    $result['jtPageSize']=  $limitSup;

  
    //? Trae todos los siniestros
    //todos
    $GLOBALS['sql1']= '';
        $datosSiniestros = SiniestrosAbogado::getTodosSiniestros($orden,$limitInf,$limitSup,'','',$area,$asignados);

        //obtener datos de usuario y validar qeu se genere la tabla desde JS

    $jTableResult = array();
    $jTableResult['Result'] = "OK";
    $jTableResult['sql'] =  $GLOBALS['sql1'];
    $jTableResult['data'] = "Lista de todos los siniestros de todos los provenientes de solo el area del abogado mostrarTabla().";
    $jTableResult['TotalRecordCount'] = $query_total;
    $jTableResult['Records'] = $datosSiniestros;
    print json_encode($jTableResult);
  }

  /*=============================================
  MOSTRAR LA TABLA DE siniestros con parametro provSelected  , solo trae los del proveniente seleccionado
  =============================================*/
  public function mostrarTablaSiniestrosProv($prov,$status,$area,$asignados){ //SE EJECUTA POR DEFAULT
    $R = $_REQUEST;
    $limitSup = $_REQUEST["jtPageSize"]??25; //registros por página
    $limitInf = $_REQUEST["jtStartIndex"]??0; // número de página * (registros por página)
    $pageView = $R['pageView']??1;
    $orden = 'order by '.($R['jtSorting']??' id ASC ');

    //? cuenta todos los siniestros
    $query_total= SiniestrosAbogado::countTodosSiniestros($prov,$status,$area,$asignados); //?devuelve un string con el número

    //? Actualiza valores.
    $paginas = round($query_total /  $limitSup);
    $result['TotalRecordCount']= $query_total;
    $result['rowTotal']= $query_total;
    $result['pages']= $paginas;
    $result['jtStartIndex']= $limitInf *  $pageView;
    $result['jtPageSize']=  $limitSup;

  
    //? Trae todos los siniestros
    //todos
    $GLOBALS['sql1']= '';
        $datosSiniestros = SiniestrosAbogado::getTodosSiniestros($orden,$limitInf,$limitSup,$prov,$status,$area,$asignados);

        //obtener datos de usuario y validar qeu se genere la tabla desde JS

    $jTableResult = array();
    $jTableResult['Result'] = "OK";
    $jTableResult['sql'] =  $GLOBALS['sql1'];
    $jTableResult['data'] = "Lista de todos los siniestros de todos los provenientes FILTROS abogado TablaSiniestrosAbogados mostrarTablaSiniestrosProv()";
    $jTableResult['TotalRecordCount'] = $query_total;
    $jTableResult['Records'] = $datosSiniestros;
    print json_encode($jTableResult);
  }



}

/*=============================================
ACTIVAR TABLA SEGUN EL POST O GET
=============================================*/ 
// core::preprint($_REQUEST);exit();
$activar = new TablaSiniestrosAbogados();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(1);
if( 
   isset($_REQUEST['provSelected']) || isset($_REQUEST['statusSelected']) || isset($_REQUEST['asignados'] ) &&
   ( $_REQUEST['provSelected']!=''  || $_REQUEST['statusSelected']!='' || $_REQUEST['asignados']!='' )
){ //permisos de un usuario ID
  $activar -> mostrarTablaSiniestrosProv($_REQUEST['provSelected'], $_REQUEST['statusSelected'], $_REQUEST['area'],$_REQUEST['asignados']);//tabla con filtros
}else{ // mostrará todos los siniestros
  $activar -> mostrarTabla($_REQUEST['area'],$_REQUEST['asignados']); //tabla sin filtros pero por area
}

// http://localhost/casadelchile/ajax/tablaVentasAbiertas.ajax.jtable.php?jtStartIndex=0&jtPageSize=10&jtSorting=fecha%20ASC
// http://localhost/casadelchile/ajax/tablaVentasAbiertas.ajax.jtable.php?jtStartIndex=0&jtPageSize=10&jtSorting=folio%20ASC

