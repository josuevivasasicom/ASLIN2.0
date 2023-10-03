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

  public function mostrarTablaEtapaUno(){ //SE EJECUTA POR DEFAULT
    $R = $_REQUEST;
    $limitSup = $_REQUEST["jtPageSize"]??25; //registros por página
    $limitInf = $_REQUEST["jtStartIndex"]??0; // número de página * (registros por página)
    $pageView = $R['pageView']??1;
    $orden = 'order by '.($R['jtSorting']??' id ASC ');

    //? cuenta todos los usuarios
    $dataFilesSelect= Config::datosSelectFilesUoloadEtapa($orden,$limitInf,$limitSup); //datos del input de tipo de archivo
    $query_total= count(Config::datosSelectFilesUoloadEtapa()); //?devuelve un string con el número

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
  public function mostrarTablaEtapaDos(){ //SE EJECUTA POR DEFAULT
    $R = $_REQUEST;
    $limitSup = $_REQUEST["jtPageSize"]??25; //registros por página
    $limitInf = $_REQUEST["jtStartIndex"]??0; // número de página * (registros por página)
    $pageView = $R['pageView']??1;
    $orden = 'order by '.($R['jtSorting']??' id ASC ');

    //? cuenta todos los usuarios
    $dataFilesSelect= Config::datosSelectFilesUoloadEtapaDos($orden,$limitInf,$limitSup); //datos del input de tipo de archivo
    $query_total= count(Config::datosSelectFilesUoloadEtapaDos()); //?devuelve un string con el número

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

  public function mostrarTablaDos(){ //SE EJECUTA POR DEFAULT
    $R = $_REQUEST;
    $limitSup = $_REQUEST["jtPageSize"]??25; //registros por página
    $limitInf = $_REQUEST["jtStartIndex"]??0; // número de página * (registros por página)
    $pageView = $R['pageView']??1;
    $orden = 'order by '.($R['jtSorting']??' id ASC ');

    //? cuenta todos los usuarios
    $dataFilesSelect= Config::datosSelectFilesUoloadDos($orden,$limitInf,$limitSup); //datos del input de tipo de archivo

    $result['jtStartIndex']= $limitInf *  $pageView;
    $result['jtPageSize']=  $limitSup;

  
    //? Trae todos los datos
    //todos
    $datos = $dataFilesSelect;

    $jTableResult = array();
    $jTableResult['Result'] = "OK";
    $jTableResult['data'] = "Lpista de todadsdsdsss las categorias de archivos";

    $jTableResult['Records'] = $datos;
    print json_encode($datos);
  }



  public function mostrarTablaDosEtapa(){ //SE EJECUTA POR DEFAULT
    $R = $_REQUEST;
    $limitSup = $_REQUEST["jtPageSize"]??25; //registros por página
    $limitInf = $_REQUEST["jtStartIndex"]??0; // número de página * (registros por página)
    $pageView = $R['pageView']??1;
    $orden = 'order by '.($R['jtSorting']??' id ASC ');

    //? cuenta todos los usuarios
    $dataFilesSelect= Config::datosSelectFilesUoloadDosEtapa($orden,$limitInf,$limitSup); //datos del input de tipo de archivo

    $result['jtStartIndex']= $limitInf *  $pageView;
    $result['jtPageSize']=  $limitSup;

  
    //? Trae todos los datos
    //todos
    $datos = $dataFilesSelect;

    $jTableResult = array();
    $jTableResult['Result'] = "OK";
    $jTableResult['data'] = "Lpista de todadsdsdsss las categorias de archivos";

    $jTableResult['Records'] = $datos;
    print json_encode($datos);
  }
}


/*=============================================
ACTIVAR TABLA SEGUN EL POST O GET
=============================================*/ 
$activar = new TableTypeFile();

if(isset($_REQUEST['jtable'])){ //permisos de un usuario ID
  $activar -> mostrarTabla($_REQUEST['jtable']);  //?mostrará permisos de los usuarios que pertenecen a esta area por el id de area
}
if(isset($_REQUEST['jtabletapa1'])){ //permisos de un usuario ID
  $activar -> mostrarTablaEtapaUno($_REQUEST['jtabletapa1']);  //?mostrará permisos de los usuarios que pertenecen a esta area por el id de area
}

if(isset($_REQUEST['jtabletapa2'])){ //permisos de un usuario ID
  $activar -> mostrarTablaEtapaDos($_REQUEST['jtabletapa2']);  //?mostrará permisos de los usuarios que pertenecen a esta area por el id de area
}

if(isset($_REQUEST['jtabledos'])){ //permisos de un usuario ID
  $activar -> mostrarTablaDos($_REQUEST['jtabledos']);  //?mostrará permisos de los usuarios que pertenecen a esta area por el id de area
}

if(isset($_REQUEST['jtabledosetapa2'])){ //permisos de un usuario ID
  $activar -> mostrarTablaDosEtapa($_REQUEST['jtabledosetapa2']);  //?mostrará permisos de los usuarios que pertenecen a esta area por el id de area
}