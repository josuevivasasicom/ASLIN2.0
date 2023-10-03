<?php

/* (
    [fileCsv] => Array
        (
            [name] => download.png
            [type] => image/png
            [tmp_name] => /Applications/XAMPP/xamppfiles/temp/php8PznLP
            [error] => 0
            [size] => 5440
        )

)



*   timerst array de nuevo siniestro que se usara para funcion de insertar uno nuevo sin recorrer los respectivos subarrays
Array
(
    [nombre] => erick
    [apellidoP] => erick
    [apellidoM] => erick
    [fechaCaptura] => 2022-01-25 17:01:37
    [proveniente] => prov_gmx
    [institucion] => CENTRO DE INVESTIGACIÓN CIENTÍFICA V DE EDUCACIÓN SUPERIOR DE ENSENADA, BAJA CALIFORNIA. SERVICIOS DE AGUAS DE LA CIUDAD DE MÉXICO.
    [cel] => 123456
    [casa] => 123456
    [oficina] => 123456
    [fechaReporte] => 2022-01-25 17:01:37
    [estado] => Baja California Sur
    [ciudad] => 2
    [mail] => erick@erick.com
    [formaContacto] => 123456
    [descripcionHechos] => Descripción de hechos
    [numReporte] => 123
    [numSiniestro] => 345345345345
    [fechaVigencia1] => 2022-01-25 17:01:37
    [fechaVigencia2] => 2022-01-25 17:01:37
    [numPoliza] => Array
        (
            [0] => 1
            [1] => new978897-987 99
        )

    [status] => verificado
    [calificacion] => Procedente
    [autoridad] => COMISIÓN ESTATAL DE DERECHOS HUMANOS.
    [area] => Array
        (
            [0] => 1
            [1] => 2
        )

    [abogados] => Array
        (
            [0] => 1
        )

)
*/

// core::preprint($_REQUEST,'request');
// core::preprint($_FILES,'files');
$arhivo= $_FILES['fileCsv'];



function armarArray($f){


    //?AREAS
    if($f[29]== 'Administrativa'){$f[29]="Servidores Públicos";}
    $f['tempArea']= $f[29]; //guarda nombre del area escrita en el csv antes de procesarla por id
    $sql= 'select id from areas where area= "'.trim($f[29]).'"';
    $query = Database::ExeDoIt($sql,false);
    $a1= Model::many_assoc($query[0])[0]['id'];
    $f[29]= [$a1]; // 3 es el id del area de siniestros

    core::preprint($f,'original');
    //?usuarios abogados
    $sql2= 'SELECT id FROM usuarios WHERE CONCAT(nombre," ",paterno," ",materno) = "' . $f[36]. '"';
    $query = Database::ExeDoIt($sql2,false);
    // core::preprint($query);
    if($query[0]->num_rows >=1){
        $a2= Model::many_assoc($query[0])[0]['id'];
        $f[36]= [$a2]; // 3 es el id de lic, maria teresa, jefa del area de siniestros.
    }
    else{
        $f[36]= [100]; // si el usuario no existe, le asigna uno generico. esto para evitar crear nuevos usuarios que estarían en desuso
    }

    //?autoridad
    //?autoridad
    //?autoridad
    //?autoridad
    $sql = "select id from config_campos where campo='autoridad' and valor = lower('" .mb_strtolower($f[27],'UTF-8'). "') limit 1";
    $query = Database::ExeDoIt($sql,true);
    if ($query[0]->num_rows >=1){
        $auto= Model::many_assoc($query[0])[0]['id'];
    }else{
        $sql = "insert into config_campos (campo,valor,activo,extra)
        values('autoridad','" .mb_strtoupper($f[27],'UTF-8'). "',1,'')";
        $query= Database::ExeDoIt($sql);
        $auto=0;
        if ($query){
            $sql = "select id from config_campos where campo='autoridad' and valor = lower('" .mb_strtolower($f[27],'UTF-8'). "') limit 1";
            $query = Database::ExeDoIt($sql);
            if ($query[0]->num_rows >=1){
                $auto= Model::many_assoc($query[0])[0]['id'];
            }
        }
    }
    $autoridad= $auto;

    //?institucion
    //?institucion
    //?institucion
    //?institucion
    $sql = "select id from config_campos where campo='institucion' and valor = lower('" .mb_strtolower($f[8],'UTF-8'). "') limit 1";
    $query = Database::ExeDoIt($sql,false,false);

    if ($query[0]->num_rows>=1){
        $I= Model::many_assoc($query[0])[0]['id'];
    }else 
    if(substr(mb_strtolower($f[8],'UTF-8'),0,6) == 'asesor'   ){
        $I= '161';//asesoria
    }
    else{
        $sql = "insert into config_campos (campo,valor,activo,extra)
        values('institucion','" .mb_strtoupper($f[8],'UTF-8'). "',1,'')";
        $query= Database::ExeDoIt($sql);
        $I=0;
        if ($query){
            $sql = "select id from config_campos where campo='institucion' and valor = lower('" .mb_strtolower($f[8],'UTF-8'). "') limit 1";
            $query = Database::ExeDoIt($sql);
            if ($query[0]->num_rows >=1){
                $I= Model::many_assoc($query[0])[0]['id'];
            }
        }
    }
    $institucion= $I;

    //?status
    //?status
    //?status

    switch ( strtolower($f[25]) ) {
        case 'c':
            $f[25]='cancelado';
            break;
            case 'v':
            $f[25]='vigente';
            break;
            case 'p':
            $f[25]='proceso de cancelación';
            break;
        default:
            $f[25]='proceso de cancelación';
            break;
    }
    $sql = "select id from config_campos where campo='status' and valor = lower('" .$f[25]. "')";
    $query = Database::ExeDoIt($sql);
    if ($query[0]->num_rows >=1){
        $s= Model::many_assoc($query[0])[0]['id'];
    }else{
        $sql = "insert into config_campos (campo,valor,activo,extra)
        values('status','" .$f[25]. "',1,'')";
        $query= Database::ExeDoIt($sql);
        $s=0;
        if ($query){
            $sql = "select id from config_campos where campo='status' and valor = lower('" .$f[25]. "')";
            $query = Database::ExeDoIt($sql);
            if ($query[0]->num_rows >=1){ 
                $c= Model::many_assoc($query[0])[0]['id'];
            }
        }
    }
    $status= $s;


    //?Calificacion
    //?Calificacion
    //?Calificacion
    $sql = "select id from config_campos where campo='calificacion' and valor = lower('" .strtolower($f[26]). "')";
    $query = Database::ExeDoIt($sql);
    if ($query[0]->num_rows >=1){
        $c= Model::many_assoc($query[0])[0]['id'];
    }else 
    if($f[26]=='' ){ //calificacion
        $f[26]=='166';//por determinar
        $c= '166';
        $find = array_search(3, $f[36]);
        if($find>=1){
            array_push($f[36],3); // añade al usuario 3 al array de usuarios si no esta asignado//? asigna a lic tere a los que estan por determinar
        }
    }
    else{
        $sql = "insert into config_campos (campo,valor,activo,extra)
        values('calificacion','" .strtolower($f[26]). "',1,'')";
        $query= Database::ExeDoIt($sql);
        $c=0;
        if ($query){
            $sql = "select id from config_campos where campo='calificacion' and valor = lower('" .strtolower($f[26]). "')";
            $query = Database::ExeDoIt($sql);
            if ($query[0]->num_rows >=1){
                $c= Model::many_assoc($query[0])[0]['id'];
            }
        }
    }
    $calificacion = $c;
    

    // ajustando fechas
    $f[28] = str_replace('/','-',$f[28]);

    $datos= array(
        'tempArea'=> $f['tempArea'],
        '_folio' => $f[0],
        '_fa' => $f[12],
        '_fcreacion' => $f[43],


        'proveniente' => "prov_".strtolower($f[6]),  //? prov_cma
        'fechaAsignacion' => date("Y-m-d H:i:s", strtotime($f[28]." ") ) ,
        'nombre' => $f[1],     ///? chavez
        'apellidoP' => $f[2],   ///? ocaña
        'apellidoM' => $f[3],    ///? Erick
        //!!!!revisar qeu si sea fecha de captura 
        'fechaCaptura_1' => $f[41]." ".$f[43],   ///? 2022-04-30 13:08:37 
        'fechaCaptura' =>  date("Y-m-d H:i:s", strtotime($f[41]." ".$f[43]) )  ,   ///? 2022-04-30 13:08:37 
        //!revisar empresa si es igual que institución
        'institucion' => $institucion,  ///? 116
        'cel' =>  $f[9],       ///? 5556958451
        'casa' =>  $f[10],       ///? 234234234234324
        'oficina' =>  $f[11],       ///? 565654545121
        'fechaReporte_1' =>   $f[12],       ///? 2022-01-25 17:01:37
        'fechaReporte' =>  date("Y-m-d H:i:s", strtotime( $f[12])),       ///? 2022-01-25 17:01:37
        'estado' =>  $f[14],       ///? Baja California
        'ciudad' => $f[15],       ///? Mexicali
        'mail' => $f[16],      ///? mail@gmail.com
        'formaContacto' =>  $f[17],      ///? correo
        'descripcionHechos' =>  urlencode($f[19]) ,       ///? %3Cp%3E%3Cstrong%3E2022-04-30+13%3A08%3A37%3C%2Fstrong%3E%3C%2Fp%3E%0A%0A%3Cp%3E%3Cstrong%3EDescripci%26oacute%3Bn+de+los+hechos%3A%26nbsp%3B%3C%2Fstrong%3E%3Cbr+%2F%3E%0A%3Cbig%3ELic.+Luis+Alberto+Mart%26iacute%3Bnez+Garc%26iacute%3Ba+%26nbsp%3B+%26nbsp%3B+%26nbsp%3B+%26nbsp%3B%2F+%26nbsp%3B%26nbsp%3B%26nbsp%3B%26nbsp%3B+Lic.+Mario+Aguilar+Guajardo.%3C%2Fbig%3E%3C%2Fp%3E%0A%0A%3Cp%3E...%3C%2Fp%3E%0A%0A%3Cp%3EAgradeciendo+su+atenci%26oacute%3Bn%2C+me+reitero+a+sus+%26oacute%3Brdenes+para+cualquier+duda+o+aclaraci%26oacute%3Bn.Agradeciendo+su+atenci%26oacute%3Bn%2C+me+reitero+a+sus+%26oacute%3Brdenes+para+cualquier+duda+o+aclaraci%26oacute%3Bn.Agradeciendo+su+atenci%26oacute%3Bn%2C+me+reitero+a+sus+%26oacute%3Brdenes+para+cualquier+duda+o+aclaraci%26oacute%3Bn.Agradeciendo+su+atenci%26oacute%3Bn%2C+me+reitero+a+sus+%26oacute%3Brdenes+para+cualquier+duda+o+aclaraci%26oacute%3Bn.Agradeciendo+su+atenci%26oacute%3Bn%2C+me+reitero+a+sus+%26oacute%3Brdenes+para+cualquier+duda+o+aclaraci%26oacute%3Bn.Agradeciendo+su+atenci%26oacute%3Bn%2C+me+reitero+a+sus+%26oacute%3Brdenes+para+cualquier+duda+o+aclaraci%26oacute%3Bn.Agradeciendo+su+atenci%26oacute%3Bn%2C+me+reitero+a+sus+%26oacute%3Brdenes+para+cualquier+duda+o+aclaraci%26oacute%3Bn.Agradeciendo+su+atenci%26oacute%3Bn%2C+me+reitero+a+sus+%26oacute%3Brdenes+para+cualquier+duda+o+aclaraci%26oacute%3Bn.Agradeciendo+su+atenci%26oacute%3Bn%2C+me+reitero+a+sus+%26oacute%3Brdenes+para+cualquier+duda+o+aclaraci%26oacute%3Bn.Agradeciendo+su+atenci%26oacute%3Bn%2C+me+reitero+a+sus+%26oacute%3Brdenes+para+cualquier+duda+o+aclaraci%26oacute%3Bn.Agradeciendo+su+atenci%26oacute%3Bn%2C+me+reitero+a+sus+%26oacute%3Brdenes+para+cualquier+duda+o+aclaraci%26oacute%3Bn.Agradeciendo+su+atenci%26oacute%3Bn%2C+me+reitero+a+sus+%26oacute%3Brdenes+para+cualquier+duda+o+aclaraci%26oacute%3Bn.Agradeciendo+su+atenci%26oacute%3Bn%2C+me+reitero+a+sus+%26oacute%3Brdenes+para+cualquier+duda+o+aclaraci%26oacute%3Bn.Agradeciendo+su+atenci%26oacute%3Bn%2C+me+reitero+a+sus+%26oacute%3Brdenes+para+cualquier+duda+o+aclaraci%26oacute%3Bn.Agradeciendo+su+atenci%26oacute%3Bn%2C+me+reitero+a+sus+%26oacute%3Brdenes+para+cualquier+duda+o+aclaraci%26oacute%3Bn.Agradeciendo+su+atenci%26oacute%3Bn%2C+me+reitero+a+sus+%26oacute%3Brdenes+para+cualquier+duda+o+aclaraci%26oacute%3Bn.Agradeciendo+su+atenci%26oacute%3Bn%2C+me+reitero+a+sus+%26oacute%3Brdenes+para+cualquier+duda+o+aclaraci%26oacute%3Bn.Agradeciendo+su+atenci%26oacute%3Bn%2C+me+reitero+a+sus+%26oacute%3Brdenes+para+cualquier+duda+o+aclaraci%26oacute%3Bn.Agradeciendo+su+atenci%26oacute%3Bn%2C+me+reitero+a+sus+%26oacute%3Brdenes+para+cualquier+duda+o+aclaraci%26oacute%3Bn.Agradeciendo+su+atenci%26oacute%3Bn%2C+me+reitero+a+sus+%26oacute%3Brdenes+para+cualquier+duda+o+aclaraci%26oacute%3Bn.Agradeciendo+su+atenci%26oacute%3Bn%2C+me+reitero+a+sus+%26oacute%3Brdenes+para+cualquier+duda+o+aclaraci%26oacute%3Bn.Agradeciendo+su+atenci%26oacute%3Bn%2C+me+reitero+a+sus+%26oacute%3Brdenes+para+cualquier+duda+o+aclaraci%26oacute%3Bn.Agradeciendo+su+atenci%26oacute%3Bn%2C+me+reitero+a+sus+%26oacute%3Brdenes+para+cualquier+duda+o+aclaraci%26oacute%3Bn.Agradeciendo+su+atenci%26oacute%3Bn%2C+me+reitero+a+sus+%26oacute%3Brdenes+para+cualquier+duda+o+aclaraci%26oacute%3Bn.Agradeciendo+su+atenci%26oacute%3Bn%2C+me+reitero+a+sus+%26oacute%3Brdenes+para+cualquier+duda+o+aclaraci%26oacute%3Bn.Agradeciendo+su+atenci%26oacute%3Bn%2C+me+reitero+a+sus+%26oacute%3Brdenes+para+cualquier+duda+o+aclaraci%26oacute%3Bn.Agradeciendo+su+atenci%26oacute%3Bn%2C+me+reitero+a+sus+%26oacute%3Brdenes+para+cualquier+duda+o+aclaraci%26oacute%3Bn.Agradeciendo+su+atenci%26oacute%3Bn%2C+me+reitero+a+sus+%26oacute%3Brdenes+para+cualquier+duda+o+aclaraci%26oacute%3Bn.Agradeciendo+su+atenci%26oacute%3Bn%2C+me+reitero+a+sus+%26oacute%3Brdenes+para+cualquier+duda+o+aclaraci%26oacute%3Bn.Agradeciendo+su+atenci%26oacute%3Bn%2C+me+reitero+a+sus+%26oacute%3Brdenes+para+cualquier+duda+o+aclaraci%26oacute%3Bn.Agradeciendo+su+atenci%26oacute%3Bn%2C+me+reitero+a+sus+%26oacute%3Brdenes+para+cualquier+duda+o+aclaraci%26oacute%3Bn.Agradeciendo+su+atenci%26oacute%3Bn%2C+me+reitero+a+sus+%26oacute%3Brdenes+para+cualquier+duda+o+aclaraci%26oacute%3Bn.Agradeciendo+su+atenci%26oacute%3Bn%2C+me+reitero+a+sus+%26oacute%3Brdenes+para+cualquier+duda+o+aclaraci%26oacute%3Bn.Agradeciendo+su+atenci%26oacute%3Bn%2C+me+reitero+a+sus+%26oacute%3Brdenes+para+cualquier+duda+o+aclaraci%26oacute%3Bn.Agradeciendo+su+atenci%26oacute%3Bn%2C+me+reitero+a+sus+%26oacute%3Brdenes+para+cualquier+duda+o+aclaraci%26oacute%3Bn.Agradeciendo+su+atenci%26oacute%3Bn%2C+me+reitero+a+sus+%26oacute%3Brdenes+para+cualquier+duda+o+aclaraci%26oacute%3Bn.Agradeciendo+su+atenci%26oacute%3Bn%2C+me+reitero+a+sus+%26oacute%3Brdenes+para+cualquier+duda+o+aclaraci%26oacute%3Bn.Agradeciendo+su+atenci%26oacute%3Bn%2C+me+reitero+a+sus+%26oacute%3Brdenes+para+cualquier+duda+o+aclaraci%26oacute%3Bn.Agradeciendo+su+atenci%26oacute%3Bn%2C+me+reitero+a+sus+%26oacute%3Brdenes+para+cualquier+duda+o+aclaraci%26oacute%3Bn.Agradeciendo+su+atenci%26oacute%3Bn%2C+me+reitero+a+sus+%26oacute%3Brdenes+para+cualquier+duda+o+aclaraci%26oacute%3Bn.%3Cbr+%2F%3E%0A%3Cbr+%2F%3E%0AA+T+E+N+T+A+ME+N+T+E%3Cbr+%2F%3E%0ALic.+Erick%3C%2Fp%3E%0A
        'numReporte' =>  $f[20],       ///? 234324
        'numSiniestro' =>  $f[21],       ///? 234234
        'fechaVigencia1' => date("Y-m-d H:i:s", strtotime($f[22])),       ///? 2022-04-30 13:08:56
        'fechaVigencia2' => date("Y-m-d H:i:s", strtotime($f[23])),       ///? 2022-04-30 13:08:57
        'numPoliza' => [trim($f[24])],        //array 
        'status' => $status ,       //?166
        'calificacion' =>$calificacion,         //?161
        'autoridad' => $autoridad, //?58 
        'area' => $f[29], //es un array que se declara arriba
        'abogados' => $f[36]  //es un array que se declara arriba
    );
    core::preprint($datos);
    /* 
    core::preprint($f,'f');exit(); */

        return $datos;
               
    /* array de $f
        (
            [0] => ﻿ID_CMA
            [1] => Nombre
            [2] => ApellidoP
            [3] => ApellidoM
            [4] => FechaReporte
            [5] => HoraReporte
            [6] => ProvieneDe
            [7] => ID_Siniestro
            [8] => Empresa
            [9] => Cel
            [10] => Casa
            [11] => Oficina
            [12] => FechaReporte2
            [13] => AnioReporte
            [14] => Estado
            [15] => Ciudad
            [16] => Mail
            [17] => FormaContacto
            [18] => ID_CMA_Consecutivo
            [19] => DescrHechos
            [20] => NoReporte
            [21] => NoSiniestro
            [22] => VigenciaIncio
            [23] => VigenciaFin
            [24] => NoPoliza
            [25] => Status
            [26] => Calificacion
            [27] => Autoridad
            [28] => FechaAsignacion
            [29] => Areas::Area
            [30] => SiniestroAreas::ID_Area
            [31] => Empleados::Foto
            [32] => Empleados::Nombre
            [33] => Areas 2::Area
            [34] => HoraAsignacion
            [35] => SiniestroEmpleados 4::ID_Empleado
            [36] => Empleados 7::Nombre
            [37] => Empleados 7::ID_Area
            [38] => Empleados 7::ID_Area
            [39] => Creador
            [40] => Modificador
            [41] => Creado_El
            [42] => Modificado_El
            [43] => Creado_Hra
            [44] => Modificado_Hra

        )
    */
}
/* 
$ejemplo= array(
    '_folio' => "102-236-06",
    '_fa' => "",
    'proveniente' => "prov_gmx",
    'fechaAsignacion' => "2022-04-30 13:08:37",
    'nombre' => "NOGUEDA BAÑOS NICOLAS",
    'apellidoP' => "",
    'apellidoM' => "",
    'fechaCaptura' => "09/01/2019 11:48:20 AM",
    'institucion' => "",
    'cel' => "",
    'casa' => "",
    'oficina' => "",
    'fechaReporte' => "",
    'estado' => "CIUDAD DE MEXICO",
    'ciudad' => "",
    'mail' => "",
    'formaContacto' => "Correo",
    'descripcionHechos' => "El Asunto lo va a tramitar un despacho particular denominado Grupo Juridico Integral 'El Angel', en donde solo participaremos en la elaboracion de la demanda de nulidad que se presentara ante el TFJFA.",
    'numReporte' => "",
    'numSiniestro' => "200604655",
    'fechaVigencia1' => "",
    'fechaVigencia2' => "",
    'numPoliza' => "[ MPSDS 420 0796]",
    'status' => "C",
    'calificacion' => "Procedente",
    'autoridad' => "OIC AREA DE RESPONSABILIDADES  EN EL ISSSTE",
    'area' => "[3,6]",
    'abogados' => "[3,0]",
);
$arrAreas = json_decode($ejemplo['area']);
array_push($arrAreas,2222);
$ejemplo['area']=json_encode($arrAreas);
core::preprint($ejemplo);
exit(); 
*/

if (($archivo = fopen($arhivo['tmp_name'], "r")) !== FALSE) { ////[tmp_name] => C:\xampp\tmp\phpAD1C.tmp
    include "core/app/action/siniestro/nuevo-action.php";

    //?$f es la fila del archivo csv
    $filaArray=[];
    $count=0;
    $puntero='';
     while (($f = fgetcsv($archivo, 1500, ",")) !== FALSE ) {
        // echo "conexion <BR>";

        if($count==0){$count++; continue;} //? se salta la cabecera del CSV
        $count++;
        //core::preprint($f);

        /* $r=[];
        foreach ($f as $k=>$v) {
           $r[]= utf8_encode($v);
        }
        $f=$r; */

        // core::preprint($f);exit();

        if($f[0]!=''){ //si la fila 0 es diferente de vacio, 
            if ($filaArray==[]){// si el filaarray esta vacio, es primer inserccion y armará el array
                $puntero = $f[0];
                core::preprint($f,"fila directo del file");
                $filaArray = armarArray($f);
                /* core::preprint($filaArray);
                core::preprint($f);exit(); */
                    continue;
                // echo "armando array 1ra vez<br>";
                //core::preprint($filaArray,'filaarray ultimo');
            }else{//si no esta vacio, es por que trae datos del id sin insertar

                //! interrumpe el upload core::preprint($filaArray);exit();
                //revisar si el id ya existe ... si existe hace update, si no, hace insert
                $s = explode('-',$filaArray['_folio']);
                $sql="select timerst from siniestros where f_numProv ='".$s[0]."' and f_consecutivo = '".$s[1]."' and f_year = '20".$s[2]."' limit 1";
                $query = Database::ExeDoIt($sql);
                
                if($query[0]->num_rows==1 ){ // si existe entonces debe ser update
                    $timerstUpdate = Model::many_assoc($query[0])[0];
                    newID::updateIDCSV($filaArray,$timerstUpdate); //?inserta el array con todos los datos recabados.
                
                    $filaArray =[];  //? limpia el array global
                    $filaArray = armarArray($f); //?  carga el array
                    core::preprint($count,'<br>$count++;<br>');
                    core::preprint( $sql= "<BR>UPDATE '".$f[43]."' <BR>",'SQL<br>');
    
                    continue;
                }
                
                newID::crearNuevoCSV($filaArray); //?inserta el array con todos los datos recabados.
                
                $filaArray =[];  //? limpia el array global
                $filaArray = armarArray($f); //?  carga el array
                core::preprint($count,'<br>$count++;<br>');
                core::preprint( $sql= "<BR>insert into new  '".$f[43]."' <BR>",'SQL<br>');

                continue;
                //exit();//!interrumpe el segundo item del FILE CSV
            }
            // core::preprint($filaArray);
        }else{
            // echo "esta vacia el folio<br>";
            
            if ($f[29]!=''){ //si existe area en la celda 29
                // echo "llenando areas<br>";
                $tempA= rtrim($filaArray['tempArea'],"[]");
                $sp = explode(',',$tempA);

                foreach ($sp as $key) {
                    if ( $key!=$f[29]){ // si el area escrita es diferente a la nueva
                        $arrAreas = $filaArray['area'];
                        if(is_string($filaArray['area'])) $arrAreas = json_decode($filaArray['area']);
                        // aqui se debe sacar el id
                                $sql= 'select id from areas where area= "'.trim($f[29]).'"';
                                $query = Database::ExeDoIt($sql,false);
                                $a1= Model::many_assoc($query[0])[0]['id'];
                        array_push($arrAreas,$a1);    // array_push($filaArray['area'],$f[29]);
                        $filaArray['area']=$arrAreas;
                        $filaArray['tempArea']=$filaArray['tempArea'].','.$f[29];
                    }
                }
                //core::preprint($filaArray,'/si existe area en la celda 29');
            }
            if ($f[36]!=''){ //si existe abogado en la celda 36
                // echo "llenando abogados<br>";
                $arrAbos= $filaArray['abogados'];
                if (is_string($filaArray['abogados'])) $arrAbos= json_decode($filaArray['abogados']);
                array_push($arrAbos,$f[36]);
                $filaArray['abogados'] = $arrAbos;
            }
            
            continue; // pasa por los dos if
        }


        // columnas
        //! revisar las columnas del archivo contra las columnas de la base de datos!!!
        // ? ID_CMA,Nombre,ApellidoP,ApellidoM,FechaReporte,HoraReporte,ProvieneDe,ID_Siniestro,Empresa,Cel,Casa,Oficina,FechaReporte
        //? ID_CMA,	Nombre,	ApellidoP,	ApellidoM,	FechaReporte,	HoraReporte,	ProvieneDe,	ID_Siniestro,	Empresa,	Cel,	Casa,	Oficina,	FechaReporte2,	AnioReporte,	Estado,	Ciudad,	Mail,	FormaContacto,	ID_CMA_Consecutivo,	DescrHechos,	NoReporte,	NoSiniestro,	VigenciaIncio,	VigenciaFin,	NoPoliza,	Status,	Calificacion,	Autoridad,	FechaAsignacion,	Areas::Area,	SiniestroAreas::ID_Area,	Empleados::Foto	Empleados::Nombre	Areas 2::Area	HoraAsignacion	SiniestroEmpleados 4::ID_Empleado	Empleados 7::Nombre	Empleados 7::ID_Area	Empleados 7::ID_Area	Creador	Modificador	Creado_El	Modificado_El	Creado_Hra	Modificado_Hra
        
        //////$sql = "INSERT into DEMO VALUES ('$data[0]','$data[1]','$data[2]','$data[3]','$data[4]','$data[5]','$data[6]','$data[7]','$data[8]','$data[9]','0000-00-00 00:00:00','$data[10]')";
        echo $sql= "<p>se sale del array</p>";
    } 
    echo "<p>Se cargaron los datos CSV <a href='../.php'>OK</a></p>";
    
    fclose($archivo);
}else{
    echo "Hubo problemas #5456. Favor de intentarlo nuevamente";
}