<?php

class tablaAbogados{

  /*=============================================
  MOSTRAR LA TABLA DE AOGADOS LISTADO
  =============================================*/
  public function mostrarTabla(){ //SE EJECUTA POR DEFAULT
    $R = $_REQUEST;
    $limitSup = $_REQUEST["jtPageSize"]??25; //registros por página
    $limitInf = $_REQUEST["jtStartIndex"]??0; // número de página * (registros por página)
    $pageView = $R['pageView']??1;
    $orden = 'order by '.($R['jtSorting']??' id ASC ');

    $filtro=$orden." limit ".$limitInf.",". $limitSup;

    //? Trae todos los usuarios
    $datosTiket = Folios::_obtenerAbogados();
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
  MOSTRAR TABLA DE PROVENIENTES EN TABLA JTABLE
  =============================================*/
  public function mostrarJtableAbogados(){ //SE EJECUTA POR jtable param
    $R = $_REQUEST;     
    $R['jtSorting'] = ' u.id ASC';
    $limitSup = $_REQUEST["jtPageSize"]??25; //registros por página
    $limitInf = $_REQUEST["jtStartIndex"]??0; // número de página * (registros por página)
    $pageView = $R['pageView']??1;
    $ordenAbog = 'order by '.($R['jtSorting']??' id ASC');


    //? Trae todos los provenientes
    $abogados = Config::getAllAbogados($ordenAbog,$limitInf,$limitSup);
    

    //? cuenta todos los provenientes
    $query_total= Config::countAbogadosTodos();

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
    $jTableResult['data'] = "Lista de los abogados en tabla";
    $jTableResult['TotalRecordCount'] = $query_total;
    $jTableResult['Records'] = $abogados['dataAbog'];
    $jTableResult['Areas'] = $abogados['dataArea'];

    print json_encode($jTableResult);
  }
  
}




/*=============================================
ACTIVAR TABLA SEGUN EL POST O GET
=============================================*/ 
$activar = new tablaAbogados();
if(isset($_REQUEST['jtable'])){
  $activar -> mostrarJtableAbogados($_REQUEST['jtable']); //mostrra la tabla de abogados
}
// else{ // mostrará todos los usuarios
//   $activar->mostrarTabla();
// }