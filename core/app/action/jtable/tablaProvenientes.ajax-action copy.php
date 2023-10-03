<?php

class TablaProvenientes{

  /*=============================================
  MOSTRAR LA TABLA DE PROVENIENTES LISTADO
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
  MOSTRAR TABLA DE PROVENIENTES EN TABLA JTABLE
  =============================================*/
  public function mostrarJtableProvenientes(){ //SE EJECUTA POR jtable param
    $R = $_REQUEST;
    $limitSup = $_REQUEST["jtPageSize"]??25; //registros por página
    $limitInf = $_REQUEST["jtStartIndex"]??0; // número de página * (registros por página)
    $pageView = $R['pageView']??1;
    $orden = 'order by '.($R['jtSorting']??' id ASC ');

    //? Trae todos los provenientes
      $provenientes = Folios::obtenerProvenientes($orden,$limitInf,$limitSup);
      $name_tables = [];

      foreach ($provenientes as $key => $value) {
        $name_tables[] = array('tabla'=>$value,'proveniente'=>explode('_',$value)[1],);
      }

    //? cuenta todos los provenientes
    $query_total= count($provenientes);

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
    $jTableResult['data'] = "Lista de los provenientes en tabla";
    $jTableResult['TotalRecordCount'] = $query_total;
    $jTableResult['Records'] = $name_tables;
    print json_encode($jTableResult);
  }
  



  /*=============================================
  MOSTRAR RESULTADOS POR BUSQUEDA DE USUARIOS
  =============================================*/
  public function tablaOTRA($tiket){	
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

}




/*=============================================
ACTIVAR TABLA SEGUN EL POST O GET
=============================================*/ 
$activar = new TablaProvenientes();
if(isset($_REQUEST['jtable'])){
  $activar -> mostrarJtableProvenientes($_REQUEST['jtable']); //mostrra la tabla de provenientes
}else{ // mostrará todos los usuarios
  $activar -> mostrarTabla();
}