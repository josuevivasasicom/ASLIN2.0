<?php
class SiniestrosAbogado{
	
    public static $clientesTB = "siniestros";


    /**************************************
     * CAMBIAR CALIFICACIONES POR AREA PARA CADA ASIGNACION
     *************************************/
    public static function updateStatusByArea($timerst){
        $sql= "INSERT INTO `cma`.`siniestros_status` (`timerst`, `autor`, `area`, `status`, `folio`) VALUES ('123', '3', '3', '161', '123213');";
    }

    public static function updateCalificacionByArea($timerst){
        $sql= "INSERT INTO `cma`.`siniestros_status` (`timerst`, `autor`, `area`, `status`, `folio`) VALUES ('123', '3', '3', '161', '123213');";
    }

    public static function getStatusByArea($timerst,$areaID){
        $sql= "SELECT (select valor from config_campos where id = status and estado = 'A') status from siniestros_areas where timerst = '$timerst'  and area = '$areaID'  limit 1";
        $query= Database::ExeDoIt($sql,false);
        if ($query[0]->num_rows){
            $datos=Model::many_assoc($query[0])[0]['status'];
            if ($datos!=''){
                return $datos;
                exit();
            }
        }
      
        //en caso de no existir status, el flujo sigue.
            $sql="select (select valor from config_campos where id = status and estado = 'A') status from siniestros where timerst = '$timerst' and estado1='A' limit 1 ";
            $query= Database::ExeDoIt($sql,false);
            return Model::many_assoc($query[0])[0]['status'];
            exit();
    }

    public static function getCalificacionByArea($timerst,$areaID){
        $sql= "SELECT (select valor from config_campos where id = calificacion and estado = 'A') calificacion from siniestros_areas where timerst = '$timerst' and area = '$areaID'  limit 1";
        $query= Database::ExeDoIt($sql,false);
        if ($query[0]->num_rows){
            $datos=Model::many_assoc($query[0])[0]['calificacion'];
            if ($datos!=''){
                return $datos;
                exit();
            }
        }
      
        //en caso de no existir status, el flujo sigue.
            $sql="select (select valor from config_campos where id = calificacion and estado = 'A') calificacion from siniestros where timerst = '$timerst' limit 1 ";
            $query= Database::ExeDoIt($sql,false);
            return Model::many_assoc($query[0])[0]['calificacion'];
            exit();
    }

    
    /**************************************
     * VER TODO de BITACORA
     *************************************/
    public static function verBitacora($timerst,$area){
        $sql="SET lc_time_names = 'es_ES';";
        $query = Database::ExeDoIt($sql);
        $sql="select sb.*,DATE_FORMAT(sb.fecha_creacion, '%a %e %b %Y %H:%i') fecha_creacion_F, if(sb.verificado=0,' ','Verificado') verificado, concat(u.nombre,' ',u.paterno) usuario 
        from siniestros_bitacora sb 
        inner join usuarios u on u.id= sb.usuario
        where timerst ='".$timerst."' and area = (select a.id from areas a where a.area= '$area'  ) ";
        $query = Database::ExeDoIt($sql);
        $data=[];
       if($query[0]->num_rows>=1){
            $data = Model::many_assoc($query[0]);
            // core::preprint(urldecode($data[0]['bitacora']));
            $newData=[];
       }
       
        return $data;
        
    }
    public static function nuevaEntradaBitacora($r,$redirect=true){
        $fechaCreacion = core::getTimeNow();
        $content = urlencode($r['nuevaEntrada']);
        $usuario = $_SESSION['id'];
        $area = $r['area'];
        if(isset($r['idsessionUsuario'])){
            $fechaCreacion= $r['fechaCreacion'];
            $content = $r['nuevaEntrada'];
            $usuario = $r['idsessionUsuario'];
            $area = $r['area'];
        }
        $sql="INSERT INTO siniestros_bitacora (timerst,fecha_creacion,bitacora,horas,usuario,area)
        values ('".$r['timerst']."', '".$fechaCreacion."','".$content."',".$r['horasBitacora'].",".$usuario.",".$area." );";
        $query = Database::ExeDoIt($sql,false);
        if ($query[0]==1 && $redirect)
        header("Refresh:0; url=./?view=siniestro/ver&param=".$r['timerst']);
        // core::preprint($sql);
        // core::preprint($query);
    }
    public static function verificarBitacora($r){
        $sql="UPDATE siniestros_bitacora set verificado = 1 , fecha_verificacion = '".Core::getTimeNow()."' where id=".$r['id']." and timerst='".$r['timerst']."' ";
        $query = Database::ExeDoIt($sql);
        if ($query[0]==1)
        header("Refresh:0; url=./?view=siniestro/ver&param=".$r['timerst']);
        core::preprint($sql);
        core::preprint($query);
    }

     /**************************************
     * VER TODOS LOS ARCHIVOS DEL SINIESTRO Y SUS VERSIONES
     *************************************/
    public static function verArchivosdelSiniestro($timerst,$areaId){
        $sql="SELECT s.*, s.version, UPPER(c1.valor) c1, UPPER(c2.valor) c2, UPPER(c3.valor) c3 
        FROM `siniestros_files` s
        LEFT JOIN config_files c1 ON c1.id = id_config_files
        LEFT JOIN config_files c2 ON c2.id = c1.parent
        LEFT JOIN config_files c3 ON c3.id = c2.parent
        WHERE s.timerst = '".$timerst."' AND estatus = 1 AND (s.area='$areaId' OR s.area=(SELECT id FROM areas WHERE area='$areaId' LIMIT 1))
        ORDER BY c3.id, c2.id, s.version DESC";
        $query = Database::ExeDoIt($sql,false);
        $data = Model::many_assoc($query[0]);
        return $data;
    }

      /**************************************
     * TRAER DATOS DE INFORME PRELIMINAR
     *************************************/
    public static function guardarInformePreliminar($timerst,$data){ //guarda informe preliminar desde todos los siniestros
        $sql="insert into siniestros_informe_preliminar (timerst,autor,area,folio,informe_preliminar,fecha_creacion)
        values('".$data['timerst']."','".$_SESSION['id']."','".$data['areaID']."','".$data['folio']."','".urlencode($data['InformePreliminar'])."' ,'".Core::getTimeNow()."' )
        ";
        $query = Database::ExeDoIt($sql,false);

        //mostrar file del informe en docs
        $sql = "INSERT INTO siniestros_files (timerst,nombre,id_config_files,`url`,fecha,`version`,area)
        VALUES('".$data['timerst']."','informePreliminar',0,'informePreliminar','".core::getTimeNow()."',1,'".$data['areaID']."') ";
        $query = Database::ExeDoIt($sql);

        //crear entrada bitacora
        Siniestros::nuevaEntradaBitacora(array('timerst'=>$data['timerst'],'nuevaEntrada'=>'Se carga el Informe Preliminar','horasBitacora'=>'1','area'=>$data['areaID'] ));

        //historico siniestros
        core::insertHistoricoSiniestros('update','Informe Preliminar',$data['timerst']);

        if($query) print "informe preliminar guardada OK";
    }
    //ver INFORME PRELIMINAR
    public static function verInformePreliminar($timerst,$area){ //muestra los datos de la primera atencion 
        $sql="select sip.*, 
        (select concat(u.nombre,' ',u.paterno) autor from usuarios u where u.id = sip.autor limit 1) autor,
        (select concat(nombre,' ',apellidoP,' ',apellidoM) from siniestros s where s.timerst=sip.timerst) asegurado
        from siniestros_informe_preliminar sip where
        s.estado1='A' and sip.timerst = '".$timerst."' and sip.area = (select id from areas where area = '".$area."') limit 1;";
        $query = Database::ExeDoIt($sql,false);
        $data = Model::many_assoc($query[0])[0];
        $data['area']= $area;
        return $data;
        //!debe hacerse un URLdecode al retornar los datos para verlos correctamente.
    }



    /**************************************
     * TRAER DATOS DE PRIMERA ATENCIÓN
     *************************************/
    public static function guardarPrimeraAtencion($timerst,$data){ //guarda primera atencion desde todos los siniestros
        $sql="INSERT INTO siniestros_primera_atencion (timerst,autor,area,folio,primera_atencion,fecha_creacion)
        values('".$data['timerst']."','".$_SESSION['id']."','".$data['areaID']."','".$data['folio']."','".urlencode($data['primeraAtencion'])."','".Core::getTimeNow()."' )
        ";
        $query = Database::ExeDoIt($sql);

        //files
        $sql = "INSERT INTO siniestros_files (timerst,nombre,id_config_files,`url`,fecha,`version`,area)
        VALUES('".$data['timerst']."','primeraAtencion',0,'primeraAtencion','".core::getTimeNow()."',1,'".$data['areaID']."') ";
        $query = Database::ExeDoIt($sql);

        //crear entrada bitacora
        include "./core/app/action/siniestro/bitacora-action.php";
        Siniestros::nuevaEntradaBitacora(array('timerst'=>$data['timerst'],'nuevaEntrada'=>'Se carga la primera atención','horasBitacora'=>'1','area'=>$data['areaID']));

        //historico siniestros
        core::insertHistoricoSiniestros('update','Primera Atención',$data['timerst']);

        if($query) print "primera atencion guardada OK";
    }
    //ver primera atención  
    public static function verPrimeraAtencion($timerst,$area){ //muestra los datos de la primera atencion 
        $sql="select spa.*, 
        (select concat(u.nombre,' ',u.paterno) autor from usuarios u where u.id = spa.autor limit 1) autor,
        (select concat(nombre,' ',apellidoP,' ',apellidoM) from siniestros s where s.timerst=spa.timerst) asegurado
         from siniestros_primera_atencion spa where
         s.estado1= 'A' and spa.timerst = '".$timerst."' and spa.area = (select id from areas where area = '".$area."') limit 1;";
        $query = Database::ExeDoIt($sql,false);
        $data = Model::many_assoc($query[0])[0];
        $data['area']= $area;
        // core::preprint($data);exit();
        return $data;
        //!debe hacerse un URLdecode al retornar los datos para verlos correctamente. ***HECHO!!
    }



    /**************************************
     * TRAER DATOS DE INFORME DE CANCELACIÓN
     *************************************/
    public static function guardarInformeCancelacion($timerst,$data){ //guarda informe de cancelacion desde todos los siniestros
        $sql="INSERT INTO siniestros_informe_cancelacion (timerst,autor,area,folio,informe_cancelacion,fecha_creacion)
        values('".$data['timerst']."','".$_SESSION['id']."','".$data['areaID']."','".$data['folio']."','".urlencode($data['informeCancelacion'])."' ,'".Core::getTimeNow()."' )
        ";
        $query = Database::ExeDoIt($sql);

        //files
        $sql = "INSERT INTO siniestros_files (timerst,nombre,id_config_files,`url`,fecha,`version`,area)
        VALUES('".$data['timerst']."','informeCancelación',0,'informeCancelación','".core::getTimeNow()."',1,'".$data['areaID']."') ";
        $query = Database::ExeDoIt($sql);

        //crear entrada bitacora
        include "./core/app/action/siniestro/bitacora-action.php";
        Siniestros::nuevaEntradaBitacora(array('timerst'=>$data['timerst'],'nuevaEntrada'=>'Se carga la informe de Cancelación','horasBitacora'=>'1','area'=>$data['areaID'] ));

        //historico siniestros
        core::insertHistoricoSiniestros('update','Informe Cancelación',$data['timerst']);

        if($query) print "Informe Cancelación guardada OK";
    }
    //ver informe de Cancelacion
    public static function verInformeCancelacion($timerst,$area){ //muestra los datos de la primera atencion 
        $sql="select sic.*, 
        (select concat(u.nombre,' ',u.paterno) autor from usuarios u where u.id = sic.autor limit 1) autor,
        (select concat(nombre,' ',apellidoP,' ',apellidoM) from siniestros s where s.timerst=sic.timerst) asegurado
        from siniestros_informe_cancelacion sic where
        s.estado1='A' and sic.timerst = '".$timerst."' and sic.area = (select id from areas where area = '".$area."')  limit 1;";
        $query = Database::ExeDoIt($sql,false);
        $data = Model::many_assoc($query[0])[0];
        $data['area']= $area;
        return $data;
        //!debe hacerse un URLdecode al retornar los datos para verlos correctamente. ***HECHO!!
    }




     /**************************************
     //INFORMACION DE SINIESTRO PARA VER DATOS //??desde siniestros/verSiniestro por Timerst
     *************************************/
    public static function verSiniestroTimerst($timerst){
        $sql="SET lc_time_names = 'es_ES';"; $query = Database::ExeDoIt($sql); // esencial para poner en español

        $sql= "SELECT s.*,DATE_FORMAT(s.vigencia1, '%d-%b-%y %H:%i') vigencia1_F,DATE_FORMAT(s.vigencia2, '%d-%b-%y %H:%i') vigencia2_F,             DATE_FORMAT(s.fechaReporte, '%a %e %b %Y %H:%i') fechaReporte_F,       DATE_FORMAT(s.fechaCaptura, '%a %e %b %Y %H:%i') fechaCaptura_F,       DATE_FORMAT(s.fechaAsignacion, '%a %e %b %Y %H:%i') fechaAsignacion_F ,cc.valor calificacion, cs.valor `status`, lower(i.valor) institucion ,lower(a.valor) autoridad , concat(s.f_numProv,'-',LPAD(s.f_consecutivo,3,'0'),'-',SUBSTRING(s.f_year, 3)) folio from siniestros s 
        LEFT JOIN config_campos i on i.id = s.institucion and i.estado = 'A'
        LEFT JOIN config_campos a on a.id = s.autoridad and a.estado = 'A'
        LEFT JOIN config_campos cs on cs.id = s.status and cs.estado = 'A'
        LEFT JOIN config_campos cc on cc.id = s.calificacion and cc.estado = 'A'
        where s.estado1= 'A' and s.timerst ='".$timerst."' limit 1";
		$query = Database::exeDoIt($sql);
        if ($query[0]->num_rows==1){
            $data=Model::many_assoc($query[0])[0];
            return $data;
        }
        else{
            //en caso de existir mas siniestros con el mismo folio, devuelve error
            return json_encode(
                array(
                    'query'=>$query,
                    'sql'=>$sql,
                    'timerst'=>$timerst,
                    'MSG'=>'Existen mas registros con el mismo folio, esto jamas debe pasar, si ves este mensaje contacta al soporte de ASICOM'
                )
            );
        }
    }
    // INFORMACION DE ID CON FECHAS ESTANDARES UTC
    public static function verSiniestroTimerstEDITAR($timerst){
        //$sql="SET lc_time_names = 'es_ES';"; $query = Database::ExeDoIt($sql); // esencial para poner en español

        $sql= "SELECT cc.valor calificacion, cs.valor `status`, lower(i.valor) institucion ,lower(a.valor) autoridad , concat(s.f_numProv,'-',LPAD(s.f_consecutivo,3,'0'),'-',SUBSTRING(s.f_year, 3)) folio, s.* from siniestros s 
        LEFT JOIN config_campos i on i.id = s.institucion and i.estado = 'A'
        LEFT JOIN config_campos a on a.id = s.autoridad and a.estado = 'A'
        LEFT JOIN config_campos cs on cs.id = s.status and cs.estado = 'A'
        LEFT JOIN config_campos cc on cc.id = s.calificacion and cc.estado = 'A'
        where s.estado1= 'A' and s.timerst ='".$timerst."' limit 1";
		$query = Database::exeDoIt($sql,false);
        if ($query[0]->num_rows==1){
            $data=Model::many_assoc($query[0])[0];
            return $data;
        }
        else{
            //en caso de existir mas siniestros con el mismo folio, devuelve error
            return json_encode(
                array(
                    'query'=>$query,
                    'sql'=>$sql,
                    'timerst'=>$timerst,
                    'MSG'=>'Existen mas registros con el mismo folio, esto jamas debe pasar, si ves este mensaje contacta al soporte de ASICOM'
                )
            );
        }
    }

    public static function BK_verSiniestroTimerst($timerst){
        $sql= "SELECT s.*,cc.valor calificacion, cs.valor `status`, lower(i.valor) institucion ,lower(a.valor) autoridad , concat(s.f_numProv,'-',LPAD(s.f_consecutivo,3,'0'),'-',SUBSTRING(s.f_year, 3)) folio,p.primera_atencion ,ip.informe_preliminar from siniestros s 
        LEFT JOIN siniestros_primera_atencion p on p.timerst = s.timerst 
        LEFT JOIN siniestros_informe_preliminar ip on ip.timerst = s.timerst
        LEFT JOIN config_campos i on i.id = s.institucion and i.estado = 'A'
        LEFT JOIN config_campos a on a.id = s.autoridad and a.estado = 'A'
        LEFT JOIN config_campos cs on cs.id = s.status and cs.estado = 'A'
        LEFT JOIN config_campos cc on cc.id = s.calificacion and cc.estado = 'A'
        where s.timerst ='".$timerst."' limit 1";
        core::preprint($sql);
        exit();
		$query = Database::exeDoIt($sql);
        if ($query[0]->num_rows==1){
            $data=Model::many_assoc($query[0])[0];
            return $data;
        }
        else{
            //en caso de existir mas siniestros con el mismo folio, devuelve error
            return json_encode(
                array(
                    'query'=>$query,
                    'sql'=>$sql,
                    'timerst'=>$timerst,
                    'MSG'=>'Existen mas registros con el mismo folio, esto jamas debe pasar, si ves este mensaje contacta al soporte de ASICOM'
                )
            );
        }
    }
    



    /**************************************
     * TABLA DE SINIESTROS/AREAS asignadas al siniestro timerst
     *************************************/
	public static function countAllareasOfSiniestro($timerst){// utilizado para jtabla siniestros/areas
		$sql= "select count(id) totalAreas from siniestros_areas where timerst = '".$timerst."'";
		$query = Database::exeDoIt($sql);
		$data=Model::many_assoc($query[0])[0];
		return $data['totalAreas'];

	}
	public static function getAllAreasOfSiniestro($timerst){// utilizado para jtabla siniestros/areas
		// $sql= "select a.area,g.grupo from gruposusuario gu left join areas a on gu.idArea=a.id inner join grupo g on gu.idGrupo =g.id where gu.idUsuario = ". $_SESSION['id']";
		$sql= "SELECT *,if(sa.estatus=1,'Activa','Deshabilitada') estatus,sa.id id_asignacion
					FROM siniestros_areas sa
					INNER JOIN areas a
					ON sa.area = a.id
				WHERE sa.timerst ='".$timerst."'";
		$query = Database::exeDoIt($sql);
		$data=Model::many_assoc($query[0]);
		return $data;
	}

    public static function getAllAbogadosOnSiniestro($timerst){ //obtiene todos  los abogados asignados al siniestro 
        $sql="SELECT su.usuario,concat(u.nombre,' ',u.paterno) nombre, (select area from areas where id = gu.idArea) area, (select grupo from grupo where id= u.rol) grupo, su.estatus, su.id id_asignacion
        from siniestros_usuarios su
        left join  usuarios u on u.id = su.usuario
        left join  gruposusuario gu on gu.idUsuario = su.usuario
        where su.timerst = '".$timerst."' GROUP BY su.usuario "; //!agrupados por usuarios para evitar repetidos
        $query = Database::exeDoIt($sql);
		$data=Model::many_assoc($query[0]);
		return $data;
    }

    //*************************** */ GRAFICAS
    public static function datosGraficasIndex(){
        //? grafica del dashboard index
        //retorna el array de json`s con los datos de cada proveniente para contar todos los siniestros y generar las graficas.
        $sql= "select id,tabla,proveniente,descripcion,borderColor,backgroundColor from config_prov  where estatus=1";
		$query = Database::exeDoIt($sql);
		$provs=Model::many_assoc($query[0]);
        $data = [];
        foreach ($provs as $prov) {
            
            //armar dataCount de cantidad de siniestros por proveniente  2022-01-25 
            $HOY = date("Y-m");
            $dataCount=  array();
            for ($i=0; $i < 10 ; $i++) {
                $fecha_ini = date("Y-m-d",strtotime($HOY."-1"."- ".$i." month"));
                    $month       = $fecha_ini;
                    $aux         = date('Y-m-d', strtotime("{$month} + 1 month"));
                    $last_day    = date('Y-m-d', strtotime("{$aux} - 1 day"));
                $fecha_fin       = date("Y-m-d",strtotime($last_day." "));

                $areaIDuser = explode('/', $_SESSION['grupo'][0])[2];

                $sql= "select count(s.id) contador from siniestros s
                LEFT JOIN siniestros_areas sa on s.timerst = sa.timerst 
                where sa.area = ".$areaIDuser." and s.estado1 = 'A'
                and f_numProv = ".$prov['id']." and fechaCaptura BETWEEN '".$fecha_ini."' and '".$fecha_fin."' ";
                $query = Database::exeDoIt($sql,false);
                $count=Model::unsetOne($query[0],$sql)['contador'];
                if($query[0]->num_rows!=0 &&  $count!=0){
                    // $count= $count[0]['contador'];
                    $dataCount[] =  $count;
                }else{
                    $dataCount[] = 0;
                }
            }
            //armar el json que se entrega al js
            $data[]= array(
                'label'=> strtoupper($prov['proveniente']),
                'borderColor'=> $prov['borderColor'],
                'backgroundColor'=> $prov['backgroundColor'],
                'pointRadius'=> 1,
                'pointHoverRadius'=> 10,
                'borderWidth'=> 3,
                'data'=>array_reverse($dataCount),
                // 'data'=> [10, 11, 15, 10, 3, 14, 15, 11, 6, 0]
            );
        }
        print json_encode($data);
    }
    public static function datosGraficasIndexID(){
        //? grafica del dashboard index
        //retorna el array de json`s con los datos de cada proveniente para contar todos los siniestros y generar las graficas.
        $sql= "select id,tabla,proveniente,descripcion,borderColor,backgroundColor from config_prov  where estatus=1";
		$query = Database::exeDoIt($sql);
		$provs=Model::many_assoc($query[0]);
        $data = [];
        foreach ($provs as $prov) {
            
            //armar dataCount de cantidad de siniestros por proveniente  2022-01-25 
            $HOY = date("Y-m");
            $dataCount=  array();
            for ($i=0; $i < 10 ; $i++) {
                $fecha_ini = date("Y-m-d",strtotime($HOY."-1"."- ".$i." month"));
                    $month       = $fecha_ini;
                    $aux         = date('Y-m-d', strtotime("{$month} + 1 month"));
                    $last_day    = date('Y-m-d', strtotime("{$aux} - 1 day"));
                $fecha_fin       = date("Y-m-d",strtotime($last_day." "));

                $areaIDuser = explode('/', $_SESSION['grupo'][0])[2];

                $sql= "select count(s.id) contador from siniestros s
                LEFT JOIN siniestros_areas sa on s.timerst = sa.timerst 
                where sa.area = ".$areaIDuser." 
                and f_numProv = ".$prov['id']." and fechaCaptura BETWEEN '".$fecha_ini."' and '".$fecha_fin."' ";
                $query = Database::exeDoIt($sql,false);
                $count=Model::unsetOne($query[0],$sql)['contador'];
                if($query[0]->num_rows!=0 &&  $count!=0){
                    // $count= $count[0]['contador'];
                    $dataCount[] =  $count;
                }else{
                    $dataCount[] = 0;
                }
            }
            //armar el json que se entrega al js
            $data[]= array(
                'label'=> strtoupper($prov['proveniente']),
                'borderColor'=> $prov['borderColor'],
                'backgroundColor'=> $prov['backgroundColor'],
                'pointRadius'=> 1,
                'pointHoverRadius'=> 10,
                'borderWidth'=> 3,
                'data'=>array_reverse($dataCount),
                // 'data'=> [10, 11, 15, 10, 3, 14, 15, 11, 6, 0]
            );
        }
        print json_encode($data);

        $sql= "SELECT count(g.IdGrupo) cantidad,g.IdGrupo,
        (
            select grupo from grupo gg
            where gg.id = g.IdGrupo limit 1
        ) grupo
        FROM `gruposusuario` g GROUP by g.IdGrupo;";
        $query = Database::exeDoIt($sql);
        $grupUsers=Model::many_assoc($query[0]);
        $labels = [];
        $cantidades = [];
        foreach ($grupUsers as $datoU) {
            //armar el json que se entrega al js
            $labels[]= strtoupper($datoU['grupo']);
                // 'data'=> [10, 11, 15, 10, 3, 14, 15, 11, 6, 0]

            $cantidades[]= strtoupper($datoU['cantidad']);
                // 'data'=> [10, 11, 15, 10, 3, 14, 15, 11, 6, 0]
            $data=[$labels,$cantidades];
        }
        print json_encode($data);


    }
    public static function datosGraficasIndexCalificaciones(){
        //? grafica del dashboard index calificaciones
        //retorna el array de json`s con los datos de cada proveniente para contar todos los siniestros y generar las graficas.
        $sql= "SELECT count(s.id)cantidad, (select valor from config_campos where id = s.calificacion )calificacion FROM `siniestros` s where s.estado1='A' GROUP by calificacion;";
		$query = Database::exeDoIt($sql);
		$calificaciones=Model::many_assoc($query[0]);
        $labels = [];
        $cantidades = [];
        foreach ($calificaciones as $d) {
            //armar el json que se entrega al js
            $labels[]=  strtoupper($d['calificacion']);
            $cantidades[]=  strtoupper($d['cantidad']);
                // 'data'=> [10, 11, 15, 10, 3, 14, 15, 11, 6, 0]
        }
        $data=[$labels,$cantidades];
        print json_encode($data);
    }
    public static function datosGraficasIndexStatus(){
        //? grafica del dashboard index status
        //retorna el array de json`s con los datos de cada proveniente para contar todos los siniestros y generar las graficas.
        $sql= "SELECT count(s.id)cantidad, (select valor from config_campos a where a.id = s.status and a.estado = 'A' )`status` FROM `siniestros` s where s.estado1='A' GROUP by status;";
		$query = Database::exeDoIt($sql);
		$status=Model::many_assoc($query[0]);
        $labels = [];
        $cantidades = [];
        foreach ($status as $d) {
            //armar el json que se entrega al js
            $labels[]=  strtoupper($d['status']);
            $cantidades[]=  strtoupper($d['cantidad']);
                // 'data'=> [10, 11, 15, 10, 3, 14, 15, 11, 6, 0]
        }
        $data=[$labels,$cantidades];
        print json_encode($data);
    }
    
    //*************************** */ GRAFICAS

    //? INI contadores de siniestros ------------------------------------------------
    public static function countTodosSiniestrosCancelados($prov=''){// utilizado para jtabla siniestros
        //$sql= "select count(s.id) siniestros from siniestros s
        $sql= "select COUNT(DISTINCT s.timerst) siniestros from siniestros s
        LEFT JOIN siniestros_usuarios su on s.timerst = su.timerst
        where status = '169'"; // 	168 en estatus es igual a CANCELADOS tenia 175
        $sql.=' and su.usuario = '.$_SESSION['id'];
		if($prov!=''){
            $sql.=" and f_numProv = (select id from config_prov where proveniente = '".$prov."' limit 1)";
        }
		$query = Database::exeDoIt($sql,false);
		$data=Model::many_assoc($query[0])[0];
		return $data['siniestros'];
	}
    public static function countTodosSiniestrosVigentes($prov=''){// utilizado para jtabla siniestros
        //$sql= "select count(s.id) siniestros from siniestros s
        $sql= "select COUNT(DISTINCT s.timerst) siniestros from siniestros s
        LEFT JOIN siniestros_usuarios su on s.timerst = su.timerst
        where status = '167'  and s.estado1='A' "; // 	166 en estatus es igual a VIGENTE tenia 169
        $sql.=' and su.usuario = '.$_SESSION['id'];
		if($prov!=''){
            $sql.="  and f_numProv = (select id from config_prov where proveniente = '".$prov."' limit 1)";
        }
        //echo $sql;
        //die();
		$query = Database::exeDoIt($sql);
		$data=Model::many_assoc($query[0])[0];
		return $data['siniestros'];
	}
    public static function countTodosSiniestrosProcesoCancelacion($prov=''){// utilizado para jtabla siniestros
        //$sql= "select count(s.id) siniestros from siniestros s
        $sql= "select COUNT(DISTINCT s.timerst) siniestros from siniestros s
        LEFT JOIN siniestros_usuarios su on s.timerst = su.timerst 
        where status = '175'  and s.estado1='A' "; // 	168 en estatus es igual a PROCESO CANCELACIÓN tenia 167
        $sql.=' and su.usuario = '.$_SESSION['id'];
		if($prov!=''){
            $sql.=" and f_numProv = (select id from config_prov where proveniente = '".$prov."' limit 1)";
        }
		$query = Database::exeDoIt($sql,false);
		$data=Model::many_assoc($query[0])[0];
		return $data['siniestros'];
	}

    //$prov,$status,$area,$asignados,$calificacion
    public static function countTodosSiniestros($prov='',$statusS='',$area='',$asignados='false',$calificacion=''){// utilizado para jtabla siniestros  //?OPTIMIZADO PARA VARIOS USUARIOS
        $sql='';
        if($area!=''){
            $sqlarea = " sa.area ='".$area."' and ";
        }else{
            $sqlarea = "  ";
        }

        $sqlasignados =' and su.usuario = '.$_SESSION['id'];

        if ($calificacion!=''){
            $sqlcalifica= ' and s.calificacion = '.$calificacion .' ';
        }else{$sqlcalifica=' '; }
		if($prov!='' and $statusS!=''){
            // $sql= "select count(s.id) siniestros from siniestros s
            $sql= "select  COUNT(DISTINCT s.timerst) siniestros from siniestros s
            inner JOIN siniestros_areas sa on s.timerst = sa.timerst
            LEFT JOIN siniestros_usuarios su on s.timerst = su.timerst
            where ". $sqlarea ." 
            s.f_numProv = (select id from config_prov where proveniente = '".$prov."' )
            and s.estado1 = 'A' and s.status = '$statusS' ". $sqlcalifica . ' ' .$sqlasignados;
        }else if($prov=='' and $statusS==''){
            $sql.= "select  COUNT(DISTINCT s.timerst) siniestros from siniestros s
            inner JOIN siniestros_areas sa on s.timerst = sa.timerst
            LEFT JOIN siniestros_usuarios su on s.timerst = su.timerst
            where   ". $sqlarea ." s.estado1 = 'A' ". $sqlcalifica . ' ' .$sqlasignados;
        }else if(($prov=='' and $statusS!='') or ($prov!='' and $statusS=='') ){
            $sql.= "select  COUNT(DISTINCT s.timerst) siniestros from siniestros s
            inner JOIN siniestros_areas sa on s.timerst = sa.timerst
            LEFT JOIN siniestros_usuarios su on s.timerst = su.timerst
            where ". $sqlarea . " s.estado1='A' and ";
            if($prov!='')   $sql.= " s.f_numProv = (select id from config_prov where proveniente = '".$prov."' ) and";
            if($statusS!='')$sql.= " s.status = '$statusS' and ";
            $sql.= " 1 ". $sqlcalifica . ' ' .$sqlasignados;
        }

		$query = Database::exeDoIt($sql,false);
		$data=Model::many_assoc($query[0])[0];
		return $data['siniestros'];
	}

    public $temporal_no_existe_relacion=
    "SELECT S.timerst FROM siniestros S WHERE S.timerst 
    NOT IN (
    
        SELECT  s.timerst
    
            FROM siniestros as s  
              
              inner JOIN  siniestros_areas sa on s.timerst = sa.timerst 
              
              GROUP BY s.timerst order BY s.id DESC 
    )  and S.estado1='A' ";
    //? FIN contadores de siniestros ------------------------------------------------

    //recupera todas las versiones anteriores de Descripcion de los hechos.
    public static function getVersionesDescripcionHechos($timerst){
        $sql = "SELECT sd.*,  (SELECT  concat(nombre,' ',paterno,' ',materno)  from usuarios where sd.autor = id LIMIT 1) autor,
            (SELECT AREA FROM areas WHERE id = sd.area LIMIT 1)  area
            from siniestros_descripcion_hechos sd where sd.timerst = '".$timerst."'";
        $query = Database::ExeDoIt($sql);
        if($query[0]->num_rows != 0 ){
            $data = Model::many_assoc($query[0]);
            return $data;
        }
        return 0;
    }


    public static function getTodosSiniestros($orden,$limitInf,$limitSup,$_prov='',$_status='',$area, $asignados=false, $calificacion=''){// utilizado para jtabla siniestros admin
        $sql="SELECT s.id,concat(s.nombre,' ',s.apellidoP,' ',s.apellidoM) nombre, s.timerst, s.activo, concat(f_numProv,'-',LPAD(f_consecutivo,3,'0'),'-',SUBSTRING(f_year, 3)) folio, SUBSTRING(UPPER(proveniente),6) proveniente, c.valor as institucion, cel,casa,oficina, fechaReporte,estado,ciudad,mail,formaContacto,descripcionHechos,numReporte,NumPoliza,numSiniestro,vigencia1,vigencia2, ";
        $sql.=" cs.valor calificacion,cc.valor autoridad,css.valor `status` ,";
        $sql.=" fechaAsignacion,if(pa.primera_atencion<>'','si','no') as primera_atencion, if(ip.informe_preliminar<>'','si','no') as informe_preliminar,if(ic.informe_cancelacion<>'','si','no') as informe_cancelacion, fechaCaptura ,";
        $sql.=" su.usuario idUserAsign , su.estatus statusUserAsign";
        $sql.=" FROM siniestros as s ";//siniestros
        $sql.= " inner JOIN siniestros_areas sa on s.timerst = sa.timerst";
        $sql.= " LEFT JOIN siniestros_usuarios su on s.timerst = su.timerst";
        $sql.= " LEFT JOIN siniestros_primera_atencion as pa on s.timerst = pa.timerst ";
        $sql.= " LEFT JOIN siniestros_informe_preliminar as ip on s.timerst = ip.timerst ";
        $sql.= " LEFT JOIN siniestros_informe_cancelacion as ic on s.timerst = ic.timerst ";
        $sql.= " LEFT JOIN config_campos c on s.institucion = c.id ";
        $sql.= " LEFT JOIN config_campos cc on s.autoridad = cc.id ";
        $sql.= " LEFT JOIN config_campos cs on s.calificacion= cs.id ";
        $sql.= " LEFT JOIN config_campos css on s.status= css.id ";
        $sql.= " WHERE ";
        if($area==''){
            $sql.= "  1 ";
        }else{
            $sql.= " sa.area = ".$area;
        }
        if($_prov!='' && $_status!='' ){ // con status y prov
            $sql.=" and s.f_numProv = (select prov.id from config_prov prov where proveniente= '".$_prov."' limit 1)  and   s.status = ".$_status;
        }
        elseif($_prov=='' && $_status==''){
            //esto pasa solo si esta limpia de filtros
        }
        else if($_prov=='' && $_status!=''){ // con status
            $sql.=" and s.status = ".$_status;
        }
        else if($_prov!='' && $_status=='' ){ //con prov
            $sql.=" and s.f_numProv = (select prov.id from config_prov prov where proveniente= '".$_prov."' limit 1)";
        }
        else{
            $sql.=" and s.f_numProv = (select prov.id from config_prov prov where proveniente= '".$_prov."' limit 1)  and   s.status = ".$_status;
            core::preprint($_prov,'prov no se cumple anda');
            core::preprint($_status,'status no se cumple anda');exit();
        }
        if($asignados== 'true' ){
            $sql.=' and  su.usuario = '.$_SESSION['id'];
        }
        if($calificacion!= '' ){
            $sql.=' and  s.calificacion = '.$calificacion;
        }
        //GROUP BY s.timerst
        $sql.='  and s.estado1="A" AND sa.estatus NOT IN (0)  GROUP BY s.timerst '. $orden." limit ".$limitInf.",". $limitSup . "  ";
        $query = Database::ExeDoIt($sql,false);//!REPARAR ESTA CONSULTA SQL
        $GLOBALS['sql1'] = $sql;
        // core::preprint($_status,'status');exit();
        $data = Model::many_assoc($query[0]);
        return $data;
    }


}