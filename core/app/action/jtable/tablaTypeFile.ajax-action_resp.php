<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL & ~E_DEPRECATED);

class TableTypeFile{
      /*=============================================
  MOSTRAR LA TABLA DE TYPEFILE
  =============================================*/
  public function mostrarTabla(){ //SE EJECUTA POR DEFAULT
    $R = $_REQUEST;
    $limitSup = $_REQUEST["jtPageSize"]??25; //registros por página
    $limitInf = $_REQUEST["jtStartIndex"]??0; // número de página * (registros por página)
    $pageView = $R['pageView']??1;
    $orden = 'order by '.($R['jtSorting']??' id ASC ');

    //? cuenta todos los usuarios
    $dataFilesSelect= Config::datosSelectFilesUoload($orden,$limitInf,$limitSup); //datos del input de tipo de archivo
    $query_total= count(Config::datosSelectFilesUoload()); //?devuelve un string con el número

    



    //? Actualiza valores.
    $paginas = round($query_total /  $limitSup);
    $result['TotalRecordCount']= $query_total;
    $result['rowTotal']= $query_total;
    $result['pages']= $paginas;
    $result['jtStartIndex']= $limitInf *  $pageView;
    $result['jtPageSize']=  $limitSup;

  
    //? Trae todos los datos
    //todos
        $datos = $dataFilesSelect;

    $jTableResult = array();
    $jTableResult['Result'] = "OK";
    $jTableResult['data'] = "Lista de todas las categorias de archivos";
    $jTableResult['TotalRecordCount'] = $query_total;
    $jTableResult['Records'] = $datos;
    print json_encode($jTableResult);
  }
}


/*=============================================
ACTIVAR TABLA SEGUN EL POST O GET
=============================================*/ 
$activar = new TableTypeFile();

if(isset($_REQUEST['jtable'])){ //permisos de un usuario ID
  $activar -> mostrarTabla($_REQUEST['jtable']);  //?mostrará permisos de los usuarios que pertenecen a esta area por el id de area
}