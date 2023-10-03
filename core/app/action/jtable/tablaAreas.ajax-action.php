<?php

class TablaVentas{

  /*=============================================
  MOSTRAR LA TABLA DE USUARIOS
  =============================================*/

  public function mostrarTabla(){ //SE EJECUTA POR DEFAULT
    $R = $_REQUEST;
    $limitSup = $_REQUEST["jtPageSize"]??25; //registros por página
    $limitInf = $_REQUEST["jtStartIndex"]??0; // número de página * (registros por página)
    $pageView = $R['pageView']??1;
    $orden = 'order by '.($R['id']??' folio ASC ');

    //? cuenta todas las areas
    $query_total= UserData::countAreas(); //?devuelve un string con el número

    //? Actualiza valores.
    $paginas = round($query_total /  $limitSup);
    $result['TotalRecordCount']= $query_total;
    $result['rowTotal']= $query_total;
    $result['pages']= $paginas;
    $result['jtStartIndex']= $limitInf *  $pageView;
    $result['jtPageSize']=  $limitSup;

  
    //? Trae todas las areas
    //todos
		/* $stmt = Conexion::conectar()->prepare("SELECT * FROM venta_tiket where monto_adeudo <> '' ".$orden." limit ".$limitInf.",". $limitSup);
		$stmt -> execute();
		$datosTiket = $stmt -> fetchAll(PDO::FETCH_CLASS); */
        $areasJtableData = UserData::getAreas();

        //obtener datos de usuario y validar qeu se genere la tabla desde JS

    $jTableResult = array();
    $jTableResult['Result'] = "OK";
    $jTableResult['data'] = "Lista de todas las areas ";
    $jTableResult['TotalRecordCount'] = $query_total;
    $jTableResult['Records'] = $areasJtableData;
    print json_encode($jTableResult);
  }

  /*=============================================
  MOSTRAR RESULTADOS POR PERMISOS DE USUARIOS
  =============================================*/
  public function tablaPermisosUser($idUser){	
    $R = $_REQUEST;
    $limitSup = $_REQUEST["jtPageSize"]??25; //registros por página
    $limitInf = $_REQUEST["jtStartIndex"]??0; // número de página * (registros por página)
    $pageView = $R['pageView']??1;
    $orden = 'order by '.($R['jtSorting']??' id ASC ');

    //? Cuenta todas las ventas abiertas.
		$query_total = UserData::totalPermisos($idUser);
    
    //? Actualiza valores.
    $paginas = round($query_total /  $limitSup);
    $result['TotalRecordCount']= $query_total;
    $result['rowTotal']= $query_total;
    $result['pages']= $paginas;
    $result['jtStartIndex']= $limitInf *  $pageView ;
    $result['jtPageSize']=  $limitSup;

		$datosTiket = UserData::getPermisosUsuario($idUser);

    $jTableResult = array();
    $jTableResult['Result'] = "OK";
    $jTableResult['data'] = "Lista de pagos del tiket";
    $jTableResult['TotalRecordCount'] = $query_total;
    $jTableResult['Records'] = $datosTiket;
    print json_encode($jTableResult);
  }
  



  /*=============================================
  MOSTRAR RESULTADOS POR BUSQUEDA DE USUARIOS
  =============================================*/
  public function tablaBusqueda($tiket){	
    $R = $_REQUEST;
    $limitSup = $_REQUEST["jtPageSize"]??25; //registros por página
    $limitInf = $_REQUEST["jtStartIndex"]??0; // número de página * (registros por página)
    $pageView = $R['pageView']??1;
    $orden = 'order by '.($R['jtSorting']??' id ASC ');

    //? Cuenta todas las ventas abiertas.
    $stmt_total= Conexion::conectar()->prepare("select count(folio_unico) totalPagos from tiket_pagos WHERE folio_unico = '".$tiket."' ");
    $stmt_total-> execute();
		$query_total = $stmt_total -> fetchAll(PDO::FETCH_CLASS)[0]->totalPagos;
    
    //? Actualiza valores.
    $paginas = round($query_total /  $limitSup);
    $result['TotalRecordCount']= $query_total;
    $result['rowTotal']= $query_total;
    $result['pages']= $paginas;
    $result['jtStartIndex']= $limitInf *  $pageView ;
    $result['jtPageSize']=  $limitSup;

  
    //? Trae todas las ventas abiertas y filtra por controles.
    //validado es el parametro que se actualiza con el corte de caja
		$stmt = Conexion::conectar()->prepare("SELECT * FROM tiket_pagos WHERE folio_unico = '".$tiket."' ".$orden." limit ".$limitInf.",". $limitSup);
		$stmt -> execute();
		$datosTiket = $stmt -> fetchAll(PDO::FETCH_CLASS);


    foreach ($datosTiket as $key => $value) {
      //?agrega costo por concepto kg*precio
      $costo = substr($value->precio,0,1);
          if($costo!='-'){
              $value->costoUnit = $value->precio * $value->peso;
          }else{
          //la cantidad es negativa
              $value->costoUnit = $value->precio * $value->peso;
          }

    }

    $jTableResult = array();
    $jTableResult['Result'] = "OK";
    $jTableResult['data'] = "Lista de pagos del tiket";
    $jTableResult['TotalRecordCount'] = $query_total;
    $jTableResult['Records'] = $datosTiket;
    print json_encode($jTableResult);
  }

  
  /*=============================================
  MOSTRAR LA TABLA DE AREAS ASIGNADAS A UN SINIESTRO POR TIMERST
  =============================================*/
  public function areasPorSiniestro($timerst){ //SE EJECUTA siniestros/areas-asignadas
    $R = $_REQUEST;
    $limitSup = $_REQUEST["jtPageSize"]??25; //registros por página
    $limitInf = $_REQUEST["jtStartIndex"]??0; // número de página * (registros por página)
    $pageView = $R['pageView']??1;
    $orden = 'order by '.($R['jtSorting']??' id ASC ');

    //? cuenta las areas asignadas al siniestro
    $query_total= Siniestros::countAllareasOfSiniestro($timerst); //?devuelve un string con el número

    //? Actualiza valores.
    $paginas = round($query_total /  $limitSup);
    $result['TotalRecordCount']= $query_total;
    $result['rowTotal']= $query_total;
    $result['pages']= $paginas;
    $result['jtStartIndex']= $limitInf *  $pageView;
    $result['jtPageSize']=  $limitSup;

  
    //? Traetodas las areas asignadas al siniestro
    //todos
		/* $stmt = Conexion::conectar()->prepare("SELECT * FROM venta_tiket where monto_adeudo <> '' ".$orden." limit ".$limitInf.",". $limitSup);
		$stmt -> execute();
		$datosTiket = $stmt -> fetchAll(PDO::FETCH_CLASS); */
        $datosTiket = Siniestros::getAllAreasOfSiniestro($timerst);

        //obtener datos de usuario y validar qeu se genere la tabla desde JS

    $jTableResult = array();
    $jTableResult['Result'] = "OK";
    $jTableResult['data'] = "Lista de todas las areas asignadas al siniestros";
    $jTableResult['TotalRecordCount'] = $query_total;
    $jTableResult['Records'] = $datosTiket;
    print json_encode($jTableResult);
  }


}

/*=============================================
ACTIVAR TABLA SEGUN EL POST O GET
=============================================*/ 
$activar = new TablaVentas();
if(isset($_REQUEST['permisosUser'])){ //permisos de un usuario ID
  $activar -> tablaPermisosUser($_REQUEST['permisosUser']);
}
else if(isset($_REQUEST['porSiniestro'])){ //areas por siniestro timerst ID
  $activar -> areasPorSiniestro($_REQUEST['porSiniestro']);
}
else{ // mostrará todos los usuarios
  $activar -> mostrarTabla();
}

// http://localhost/casadelchile/ajax/tablaVentasAbiertas.ajax.jtable.php?jtStartIndex=0&jtPageSize=10&jtSorting=fecha%20ASC
// http://localhost/casadelchile/ajax/tablaVentasAbiertas.ajax.jtable.php?jtStartIndex=0&jtPageSize=10&jtSorting=folio%20ASC

