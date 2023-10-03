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
    $orden = 'order by '.($R['jtSorting']??' folio ASC ');

    //? cuenta todos los usuarios
    $query_total= UserData::CountUser(); //?devuelve un string con el número

    //? Actualiza valores.
    $paginas = round($query_total /  $limitSup);
    $result['TotalRecordCount']= $query_total;
    $result['rowTotal']= $query_total;
    $result['pages']= $paginas;
    $result['jtStartIndex']= $limitInf *  $pageView;
    $result['jtPageSize']=  $limitSup;

  
    //? Trae todos los usuarios
    //todos
		/* $stmt = Conexion::conectar()->prepare("SELECT * FROM venta_tiket where monto_adeudo <> '' ".$orden." limit ".$limitInf.",". $limitSup);
		$stmt -> execute();
		$datosTiket = $stmt -> fetchAll(PDO::FETCH_CLASS); */
        $datosTiket = UserData::getAllUsers();

        //obtener datos de usuario y validar qeu se genere la tabla desde JS

    $jTableResult = array();
    $jTableResult['Result'] = "OK";
    $jTableResult['data'] = "Lista de todos los usuarios";
    $jTableResult['TotalRecordCount'] = $query_total;
    $jTableResult['Records'] = $datosTiket;
    print json_encode($jTableResult);
  }

  /*=============================================
  MOSTRAR RESULTADOS POR PERMISOS DE USUARIOS desde AREAS/usuarios
  =============================================*/
  public function tablaPermisosUsers($idArea){	
    $R = $_REQUEST;
    $limitSup = $_REQUEST["jtPageSize"]??25; //registros por página
    $limitInf = $_REQUEST["jtStartIndex"]??0; // número de página * (registros por página)
    $pageView = $R['pageView']??1;
    $orden = 'order by '.($R['jtSorting']??' id ASC ');

    //? Cuenta todas las ventas abiertas.
		$query_total = UserData::totalPermisosAreasUsers($idArea);
    
    //? Actualiza valores.
    $paginas = round($query_total /  $limitSup);
    $result['TotalRecordCount']= $query_total;
    $result['rowTotal']= $query_total;
    $result['pages']= $paginas;
    $result['jtStartIndex']= $limitInf *  $pageView ;
    $result['jtPageSize']=  $limitSup;

		$datosTiket = UserData::getPermisosAreasUsers($idArea);

    $jTableResult = array();
    $jTableResult['Result'] = "OK";
    $jTableResult['data'] = "ListaUsuarios por area";
    $jTableResult['TotalRecordCount'] = $query_total;
    $jTableResult['Records'] = $datosTiket;
    print json_encode($jTableResult);
  }


    /*=============================================
  MOSTRAR RESULTADOS POR USUARIOS con sus permisos desde config/USUARIOS
  =============================================*/
  public function tablaPermisosUsersId($idUser){	
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
    $jTableResult['data'] = "ListaUsuarios por area";
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
  MOSTRAR USUARIOS ASIGNADOS DEL SIMNIESTRO POR TIMERST
  =============================================*/

  public function usuariosDelSiniestro($timerst){ //SE EJECUTA EN LA TABLA SINIESTROS / USUARIOS
    $R = $_REQUEST;
    $limitSup = $_REQUEST["jtPageSize"]??25; //registros por página
    $limitInf = $_REQUEST["jtStartIndex"]??0; // número de página * (registros por página)
    $pageView = $R['pageView']??1;
    $orden = 'order by '.($R['jtSorting']??' area ASC ');

    //? cuenta todos los usuarios
    $query_total= UserData::countAllUserOfSiniestro($timerst); //?devuelve un string con el número

    //? Actualiza valores.
    $paginas = round($query_total /  $limitSup);
    $result['TotalRecordCount']= $query_total;
    $result['rowTotal']= $query_total;
    $result['pages']= $paginas;
    $result['jtStartIndex']= $limitInf *  $pageView;
    $result['jtPageSize']=  $limitSup;

  
    //? Trae todos los usuarios
    //todos
		/* $stmt = Conexion::conectar()->prepare("SELECT * FROM venta_tiket where monto_adeudo <> '' ".$orden." limit ".$limitInf.",". $limitSup);
		$stmt -> execute();
		$datosTiket = $stmt -> fetchAll(PDO::FETCH_CLASS); */
        $datosTiket = UserData::getAllUserOfSiniestro($timerst);

        //obtener datos de usuario y validar qeu se genere la tabla desde JS

    $jTableResult = array();
    $jTableResult['Result'] = "OK";
    $jTableResult['data'] = "Lista de todos los usuarios";
    $jTableResult['TotalRecordCount'] = $query_total;
    $jTableResult['Records'] = $datosTiket;
    print json_encode($jTableResult);
  }

}

/*=============================================
ACTIVAR TABLA SEGUN EL POST O GET
=============================================*/ 
$activar = new TablaVentas();

if(isset($_REQUEST['permisosUsers'])){ //permisos de un usuario ID
  $activar -> tablaPermisosUsers($_REQUEST['permisosUsers']);  //?mostrará permisos de los usuarios que pertenecen a esta area por el id de area
}else 
if(isset($_REQUEST['permisosUserId'])){ //permisos de un usuario ID
  $activar -> tablaPermisosUsersId($_REQUEST['permisosUserId']); //?mostrará permisos de los usuarios por el ID del usuario
}
else
if(isset($_REQUEST['delSiniestro'])){// ver usuarios asignados al siniestro
  $activar-> usuariosDelSiniestro($_REQUEST['delSiniestro']); //? mostrara los usuarios asignados a este siniestro
}

else{ // mostrará todos los usuarios  
  $activar -> mostrarTabla();
}

// http://localhost/casadelchile/ajax/tablaVentasAbiertas.ajax.jtable.php?jtStartIndex=0&jtPageSize=10&jtSorting=fecha%20ASC
// http://localhost/casadelchile/ajax/tablaVentasAbiertas.ajax.jtable.php?jtStartIndex=0&jtPageSize=10&jtSorting=folio%20ASC

