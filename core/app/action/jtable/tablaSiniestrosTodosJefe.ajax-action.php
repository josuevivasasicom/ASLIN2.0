<?php

class TablaSiniestros{
   /*=============================================
  DescargarExcel
  =============================================*/


  /*=============================================
  MOSTRAR LA TABLA DE siniestros sin parametros, trae TODOOOOSSSS
  =============================================*/
  public function mostrarTabla(){ //SE EJECUTA POR DEFAULT
    $R = $_REQUEST;
    $limitSup = $_REQUEST["jtPageSize"]??25; //registros por página
    $limitInf = $_REQUEST["jtStartIndex"]??0; // número de página * (registros por página)
    $pageView = $R['pageView']??1;
    $orden = 'order by '.($R['jtSorting']??' id ASC ');

    //? cuenta todos los siniestros
    $query_total= Siniestros::countTodosSiniestros('','','',false); //?devuelve un string con el número

    //? Actualiza valores.
    $paginas = round($query_total /  $limitSup);
    $result['TotalRecordCount']= $query_total;
    $result['rowTotal']= $query_total;
    $result['pages']= $paginas;
    $result['jtStartIndex']= $limitInf *  $pageView;
    $result['jtPageSize']=  $limitSup;

  
    //? Trae todos los siniestros
    //todos
        $datosSiniestros = Siniestros::getTodosSiniestros($orden,$limitInf,$limitSup,'','','');

        //obtener datos de usuario y validar qeu se genere la tabla desde JS

    $jTableResult = array();
    $jTableResult['Result'] = "OK";
    $jTableResult['data'] = "Lista de todos los siniestros de todos los provenientes  1er mostrarTabla";
    $jTableResult['TotalRecordCount'] = $query_total;
    $jTableResult['Records'] = $datosSiniestros;
    print json_encode($jTableResult);
  }

  /*=============================================
  MOSTRAR LA TABLA DE siniestros con parametro provSelected  , solo trae los del proveniente seleccionado
  =============================================*/
  public function mostrarTablaSiniestrosProv($prov,$status,$area,$asignados,$abogados,$calificacion){ //SE EJECUTA POR DEFAULT
    $R = $_REQUEST;
    $limitSup = $_REQUEST["jtPageSize"]??25; //registros por página
    $limitInf = $_REQUEST["jtStartIndex"]??0; // número de página * (registros por página)
    $pageView = $R['pageView']??1;
    $orden = 'order by '.($R['jtSorting']??' id ASC ');

    //? cuenta todos los siniestros
    $query_total= Siniestros::countTodosSiniestros($prov,$status,$area,$calificacion,$asignados,$abogados); //?devuelve un string con el número

    //? Actualiza valores.
    $paginas = round($query_total /  $limitSup);
    $result['TotalRecordCount']= $query_total;
    $result['rowTotal']= $query_total;
    $result['pages']= $paginas;
    $result['jtStartIndex']= $limitInf *  $pageView;
    $result['jtPageSize']=  $limitSup;

  
    //? Trae todos los siniestros
    //todos
    $datosSiniestros = Siniestros::getTodosSiniestros($orden,$limitInf,$limitSup,$prov,$status,$area,$calificacion,$asignados,$abogados);

        //obtener datos de usuario y validar qeu se genere la tabla desde JS

    $jTableResult = array();
    $jTableResult['Result'] = "OK";
    $jTableResult['data'] = "Lista de todos los siniestros de todos los provenientes FILTROS admin mostrarTablaSiniestrosProv";
    $jTableResult['TotalRecordCount'] = $query_total;
    $jTableResult['Records'] = $datosSiniestros;
    print json_encode($jTableResult);
  }



}

/*=============================================
ACTIVAR TABLA SEGUN EL POST O GET
=============================================*/ 
$activar = new TablaSiniestros();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(1);




if( 
   ( isset($_REQUEST['provSelected']) || isset($_REQUEST['statusSelected']) || isset($_REQUEST['area']) || isset($_REQUEST['asignados']) || isset($_REQUEST['calificacionSelected']) ) &&
   ( $_REQUEST['provSelected']!='' || $_REQUEST['statusSelected']!='' ||  $_REQUEST['area']!='' || $_REQUEST['asignados']!='' || $_REQUEST['calificacionSelected']!='')
){ //permisos de un usuario ID
  $area='';
  if(isset($_REQUEST['area'])){ $area=$_REQUEST['area'];}//si existe area, lo pone, si no, lo manda vacio.

  $provSelected='';
  if($_REQUEST['provSelected']!='undefined'){ $provSelected=$_REQUEST['provSelected'];}//si existe provSelected, lo pone, si no, lo manda vacio.

  $statusSelected='';
  if($_REQUEST['statusSelected']!='undefined'){ $statusSelected=$_REQUEST['statusSelected'];}//si existe statusSelected, lo pone, si no, lo manda vacio.

  $calificacionSelected='';
  if($_REQUEST['calificacionSelected']!='undefined'){ $calificacionSelected=$_REQUEST['calificacionSelected'];}//si existe calificacionSelected, lo pone, si no, lo manda vacio.

  $asignados='';
  if($_REQUEST['asignados']!='undefined'){ $asignados=$_REQUEST['asignados'];}//si asignados, lo pone, si no, lo manda vacio.

          //----------------------
          //---------------------- si será para descargar EXCEL
          if (isset($_REQUEST['downloadExcel'])){
            $activar->descargarExcel($provSelected, $statusSelected,$area,$asignados,$abogados=[],$calificacionSelected);
          }
  $aboSelected='';
  if($_REQUEST['aboSelected']!='undefined'){ $aboSelected = $_REQUEST['aboSelected'];}
  $activar -> mostrarTablaSiniestrosProv($provSelected, $statusSelected,$area,$asignados,$aboSelected,$calificacionSelected);
}else{ // mostrará todos los siniestros

  $aboSelected='';
  if($_REQUEST['aboSelected']!='undefined'){ $aboSelected = $_REQUEST['aboSelected'];}
  $activar -> mostrarTablaSiniestrosProv($provSelected, $statusSelected,$area,$asignados,$aboSelected,$calificacionSelected);
    // $activar -> mostrarTabla();
}

// http://localhost/casadelchile/ajax/tablaVentasAbiertas.ajax.jtable.php?jtStartIndex=0&jtPageSize=10&jtSorting=fecha%20ASC
// http://localhost/casadelchile/ajax/tablaVentasAbiertas.ajax.jtable.php?jtStartIndex=0&jtPageSize=10&jtSorting=folio%20ASC

