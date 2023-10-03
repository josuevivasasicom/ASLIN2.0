<?php

class DownloadExcelSiniestros{
   /*=============================================
  DescargarExcel
  =============================================*/
  public function descargarExcelAdmin($prov,$status,$area,$asignados,$abogados,$calificacion){ //
    $R = $_REQUEST;
    $limitSup = $_REQUEST["jtPageSize"]??25; //registros por página
    $limitInf = $_REQUEST["jtStartIndex"]??0; // número de página * (registros por página)
    $pageView = $R['pageView']??1;
    $orden = 'order by '.($R['jtSorting']??' id ASC ');

    //? cuenta todos los siniestros
    $query_total=  Siniestros::countTodosSiniestros($prov,$status,$area,$calificacion,$asignados); //?devuelve un string con el número

    //? Actualiza valores.
    $paginas = round($query_total /  $limitSup);
    $result['TotalRecordCount']= $query_total;
    $result['rowTotal']= $query_total;
    $result['pages']= $paginas;
    $result['jtStartIndex']= $limitInf *  $pageView;
    $result['jtPageSize']=  $limitSup;

  
    //? Trae todos los siniestros
    //todos
        $datosSiniestros = Siniestros::getTodosSiniestrosDownloadExcel($orden,$limitInf,$limitSup,$prov,$status,$area,$calificacion,$asignados);

        //obtener datos de usuario y validar qeu se genere la tabla desde JS

    $jTableResult = array();
    $jTableResult['Result'] = "OK";
    $jTableResult['data'] = "Lista para descargar excel";
    $jTableResult['TotalRecordCount'] = $query_total;
    $jTableResult['Records'] = $datosSiniestros;
    print json_encode($jTableResult);
  }

   /*=============================================
  DescargarExcel formato GMX
  =============================================*/
  public function descargarExcelgmx($prov,$status,$area,$asignados,$abogados,$calificacion){ //
    $R = $_REQUEST;
    $limitSup = $_REQUEST["jtPageSize"]??25; //registros por página
    $limitInf = $_REQUEST["jtStartIndex"]??0; // número de página * (registros por página)
    $pageView = $R['pageView']??1;
    $orden = 'order by '.($R['jtSorting']??' s.id DESC ');

    //? cuenta todos los siniestros
    $query_total=  Siniestros::countTodosSiniestros($prov,$status,$area,$calificacion,$asignados); //?devuelve un string con el número

    //? Actualiza valores.
    $paginas = round($query_total /  $limitSup);
    $result['TotalRecordCount']= $query_total;
    $result['rowTotal']= $query_total;
    $result['pages']= $paginas;
    $result['jtStartIndex']= $limitInf *  $pageView;
    $result['jtPageSize']=  $limitSup;

  
    //? Trae todos los siniestros
    //todos
        $datosSiniestros = Siniestros::getTodosSiniestrosDownloadExcelGMX($orden,$limitInf,$limitSup,$prov,$status,$area,$calificacion,$asignados);

        //obtener datos de usuario y validar qeu se genere la tabla desde JS

    $jTableResult = array();
    $jTableResult['Result'] = "OK";
    $jTableResult['data'] = "Lista para descargar excel";
    $jTableResult['TotalRecordCount'] = $query_total;
    $jTableResult['Records'] = $datosSiniestros;
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

$format = $_REQUEST['downloadExcel'];
parse_str($_REQUEST['params'],$r);
  $area='';
  if(isset($r['area'])){ $area=$r['area'];}//si existe area, lo pone, si no, lo manda vacio.

  $provSelected='';
  if($r['provSelected']!='undefined'){ $provSelected=$r['provSelected'];}//si existe provSelected, lo pone, si no, lo manda vacio.

  $statusSelected='';
  if($r['statusSelected']!='undefined'){ $statusSelected=$r['statusSelected'];}//si existe statusSelected, lo pone, si no, lo manda vacio.

  $calificacionSelected='';
  if($r['calificacionSelected']!='undefined'){ $calificacionSelected=$r['calificacionSelected'];}//si existe calificacionSelected, lo pone, si no, lo manda vacio.

  $asignados='';
  if($r['asignados']!='undefined'){ $asignados=$r['asignados'];}//si asignados, lo pone, si no, lo manda vacio.

          //----------------------
          //---------------------- si será para descargar EXCEL
          // mostrará todos los siniestros
          // $format = $r['downloadExcel']; //ya se define arriba en el request.
          switch ($format) {
            case 'admin':
              $activar->descargarExcelAdmin($provSelected, $statusSelected,$area,$asignados,$abogados=[],$calificacionSelected);
              break;
            case 'gmx':
              $activar->descargarExcelgmx($provSelected, $statusSelected,$area,$asignados,$abogados=[],$calificacionSelected);
              break;
            default:
              echo "seleccion aun formato.";
              break;
          }



// http://localhost/casadelchile/ajax/tablaVentasAbiertas.ajax.jtable.php?jtStartIndex=0&jtPageSize=10&jtSorting=fecha%20ASC
// http://localhost/casadelchile/ajax/tablaVentasAbiertas.ajax.jtable.php?jtStartIndex=0&jtPageSize=10&jtSorting=folio%20ASC

