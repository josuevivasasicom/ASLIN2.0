<?php
$arhivo= $_FILES['fileCsv'];
$contador=0;


function armarArray_bitacora($f){
    //?      Actividad	Hrs	Creador	Creado_El Creado_Hra	Siniestros::ID_Siniestro	Siniestros::ID_CMA	fechaBitacora       verificado      ID_Siniestro	ID_Bitacora
    //      Se ac....	2   pulido  2019-01-10 11:56:22     258                        102-272-17             2019-01-10           si             258             52
    /* 
    [0] => La Lic. Jerlene Hessel Carrillo realiza un Análisis Costo Beneficio del caso, para su cierre definitivo, al cual se le otorgó el visto bueno, y dicho Escrito fue enviado a GMX Seguros para su pronta respuesta.
    [1] => 2
    [2] => pulido
    [3] => 2019-06-11 11:18
    [4] => vacio
    [5] => 102-236-06
    [6] => 2019-05-08
    [7] => Si
    [8] => Administrativa
    [9] => Administrativa
    [10] => 
    [11] => 
    [12] => Lic. Angélica Lorena Pulido Álvarez<br> */

   //* values ('".$r['timerst']."', '".core::getTimeNow()."','".$r['nuevaEntrada']."',".$r['horasBitacora'].",".$_SESSION['id'].",".$r['area']." );";

   //?TIMERST  se obtiene directo del folio del ID
   core::preprint($f);
   $folio=explode('-',$f[5]);
   $sql = "SELECT timerst FROM siniestros s WHERE s.f_numProv = '".$folio[0]."' AND s.f_consecutivo = '".$folio[1]."' AND s.f_year = '20".$folio[2]."' limit 1";
   $query = Database::ExeDoIt($sql,true);
//    core::preprint($query[0]);

//    exit();
   if(isset($query[0]) && $query[0]->num_rows>=1){
       $timerstFolio = Model::many_assoc($query[0])[0]['timerst'];
   }else{
    echo 'no existe el folio '. $f[5];
   }
   $f[3] = date("Y-m-d H:i:s", strtotime($f[3]." ") );
   $creadoFecha = isset($f[3])?$f[3]:core::getTimeNow();
   $fechaActividad = date("Y-m-d", strtotime($f[6]." ") );
   $nuevaEntrada =  urlencode($f[0]);
   $horasBitacora =  $f[1];
   $idsessionUsuario=0; // se llena en la sigueinte rutina.
   $areaUs=3;
   
   //? SESSIONID y AREA del usuario 
   //?usuarios abogados
   $sql2= 'SELECT id FROM usuarios WHERE paterno like "%'.trim($f[2]). '%" limit 1';
   $query = Database::ExeDoIt($sql2,false);
   
   if($query[0]->num_rows >=1){
       $u2= Model::many_assoc($query[0])[0]['id'];
       $idsessionUsuario = $u2;

       //?ASIGNACION DE AREA segun el id del usuario
       $sql= 'SELECT idArea from gruposusuario WHERE idUsuario = '.$idsessionUsuario.'';
       $query = Database::ExeDoIt($sql,false);
       $a1= Model::many_assoc($query[0])[0]['idArea'];
       $areaUs= $a1; // 3 es el id del area de siniestros
    //    if($areaUs==1){
    //        $areaUs= 3; // 3 es el id del area de siniestros
    //    }  
    
    //    core::preprint($query,'query');

    //    core::preprint($a1,'sdfdsfdsf');exit();
   }
   else{
        $idsessionUsuario = 0; // si el usuario no existe, le asigna uno generico. esto para evitar crear nuevos usuarios que estarían en desuso
        $areaUs= 3;
   }
   core::preprint($idsessionUsuario,'idsessionUsuario');
   core::preprint($areaUs,'areaUs');
   
    
   //* values ('".$r['timerst']."', '".core::getTimeNow()."','".$r['nuevaEntrada']."',".$r['horasBitacora'].",".$_SESSION['id'].",".$r['area']." );";

    $datos= array(
        'timerst'=> $timerstFolio,
        'fechaCreacion'=> $creadoFecha,
        'fechaActividad' => $fechaActividad,
        'nuevaEntrada' => $nuevaEntrada,
        'horasBitacora' => $horasBitacora,
        'idsessionUsuario' => $idsessionUsuario,
        'area' => $areaUs,
    );
        return $datos;
}

// core::preprint($contador,'Contador de filas....');


if (($archivo = fopen($arhivo['tmp_name'], "r")) !== FALSE) { ////[tmp_name] => C:\xampp\tmp\phpAD1C.tmp
    $count=0;
    $puntero='0';
    //?$f es la fila del archivo csv
    //!$action = Siniestros::nuevaEntradaBitacora($datos,false);  // funcion para guardar bitacora.
     while (($f = fgetcsv($archivo, 1500, ",")) !== FALSE ) {

        if($count==0){$count++; continue;} //? se salta la cabecera del CSV
        $count++;

        // if ($contador==10){exit();}
        //core::preprint($f);

        /* $r=[];
        foreach ($f as $k=>$v) {
           $r[]= utf8_encode($v);
        }
        $f=$r; */

        // core::preprint($f);exit();

        /* if($f[5]!=''){ //si f5 tiene contenido, es primer registro del folio
            core::preprint($f[5],'Contador antes de armar $f[5]....');
            $puntero=$f[5];
           $bitacora  =  armarArray_bitacora($f,$contador);
            //! interrumpe el upload del csv de bitacoras   // core::preprint($bitacora,'bitacora');exit();
        }
        else{//si f5 es vacio, es el segundo registro del folio "puntero"
            core::preprint($count,'Contador de segunda opcion....');
            $f[5]=$puntero;
            $bitacora  =  armarArray_bitacora($f,$contador);
            //! interrumpe el upload del csv de bitacoras   // core::preprint($bitacora,'bitacora');exit();
        } */

        core::preprint($count,'Contador de segunda opcion....');
        //$f[5]=$puntero; siempre trae contenido
        $bitacora  =  armarArray_bitacora($f);
        //! interrumpe el upload del csv de bitacoras   // core::preprint($bitacora,'bitacora');exit();


        $contador++;
        Siniestros::nuevaEntradaBitacora($bitacora,false);
        continue;
                echo $sql= "<p >esto no deberia pasar.</p>";

    } 
    echo "<p>Se cargaron los datos CSV <a href='../.php'>OK</a></p>";
    
    fclose($archivo);
}else{
    echo "Hubo problemas #5456. Favor de intentarlo nuevamente";
}