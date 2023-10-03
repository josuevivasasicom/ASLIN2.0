<?php
class SiniestrosAbogadosssss{
	
    public static $tabla = "siniestros";
    
    /**************************************
     * VER TODO de BITACORA
     *************************************/
    public static function verBitacora($timerst,$area){
        $sql="select sb.*,if(sb.verificado=0,' ','Verificado') verificado, concat(u.nombre,' ',u.paterno) usuario 
        from siniestros_bitacora sb 
        inner join usuarios u on u.id= sb.usuario
        where timerst ='".$timerst."' and area = (select a.id from areas a where a.area= '$area'  ) ";
        $query = Database::ExeDoIt($sql);
        $data = Model::many_assoc($query[0]);
        return $data;
        
    }
    public static function nuevaEntradaBitacora($r){
        $sql="INSERT INTO siniestros_bitacora (timerst,fecha_creacion,bitacora,horas,usuario,area)
        values ('".$r['timerst']."', '".core::getTimeNow()."','".$r['nuevaEntrada']."',".$r['horasBitacora'].",".$_SESSION['id'].",".$r['area']." );";
        $query = Database::ExeDoIt($sql);
        if ($query[0]==1)
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
       $sql = "SELECT s.*, s.version, UPPER(c1.valor) c1, UPPER(c2.valor) c2, UPPER(c3.valor) c3 
       FROM `siniestros_files` s
       LEFT JOIN config_files c1 ON c1.id = id_config_files
       LEFT JOIN config_files c2 ON c2.id = c1.parent
       LEFT JOIN config_files c3 ON c3.id = c2.parent
       WHERE s.timerst = '".$timerst."' AND (s.area='$areaId' OR s.area=(SELECT id FROM areas WHERE area='$areaId' LIMIT 1)) 
       ORDER BY c3.id, c2.id, s.version DESC";

        // $sql="SELECT s.*,lpad(s.version,2,'0') version,UPPER(c1.valor) c1,UPPER(c2.valor) c2,UPPER(c3.valor) c3 FROM `siniestros_files` s
        // LEFT JOIN config_files c1 on c1.id = id_config_files
        // LEFT JOIN config_files c2 on c2.id = c1.parent
        // LEFT JOIN config_files c3 on c3.id = c2.parent
        // where s.timerst = '".$timerst."' and (s.area=$areaId or s.area=(select id from areas where area='$areaId' limit 1 ) ) order by c3.id,c2.id,s.version DESC";


        $query = Database::ExeDoIt($sql);
        $data = Model::many_assoc($query[0]);
        return $data;
    }

      /**************************************
     * TRAER DATOS DE INFORME PRELIMINAR
     *************************************/
    public static function guardarInformePreliminar($timerst,$data){ //guarda informe preliminar desde todos los siniestros
        $sql="insert into siniestros_informe_preliminar (timerst,autor,area,folio,informe_preliminar)
        values('".$data['timerst']."','".$_SESSION['id']."','1','".$data['folio']."','".urlencode($data['InformePreliminar'])."' )
        ";
        $query = Database::ExeDoIt($sql);

        //mostrar file del informe en docs
        $sql = "INSERT INTO siniestros_files (timerst,nombre,id_config_files,`url`,fecha,`version`)
        VALUES('".$data['timerst']."','informePreliminar',0,'informePreliminar','".core::getTimeNow()."',1) ";
        $query = Database::ExeDoIt($sql);

        //crear entrada bitacora
        Siniestros::nuevaEntradaBitacora(array('timerst'=>$data['timerst'],'nuevaEntrada'=>'Se carga el Informe Preliminar','horasBitacora'=>'1'));

        //historico siniestros
        core::insertHistoricoSiniestros('update','Informe Preliminar',$data['timerst']);

        if($query) print "informe preliminar guardada OK";
    }
    //ver INFORME PRELIMINAR
    public static function verInformePreliminar($timerst,$area){ //muestra los datos de la primera atencion 
        $sql="select * from siniestros_informe_preliminar where timerst = '".$timerst."' and area = (select id from areas where area = '".$area."') limit 1;";
        $query = Database::ExeDoIt($sql,false);
        $data = Model::many_assoc($query[0])[0];
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

        $sql = "INSERT INTO siniestros_files (timerst,nombre,id_config_files,`url`,fecha,`version`,area)
        VALUES('".$data['timerst']."','primeraAtencion',0,'primeraAtencion','".core::getTimeNow()."',1,'".$data['areaID']."') ";
        $query = Database::ExeDoIt($sql);

        //crear entrada bitacora
        include "./core/app/action/siniestro/bitacora-action.php";
        Siniestros::nuevaEntradaBitacora(array('timerst'=>$data['timerst'],'nuevaEntrada'=>'Se carga la primera atención','horasBitacora'=>'1'));

        //historico siniestros
        core::insertHistoricoSiniestros('update','Primera Atención',$data['timerst']);

        if($query) print "primera atencion guardada OK";
    }
    //ver primera atención  
    public static function verPrimeraAtencion($timerst,$area){ //muestra los datos de la primera atencion 
        $sql="select * from siniestros_primera_atencion where timerst = '".$timerst."' and area = (select id from areas where area = '".$area."') limit 1;";
        $query = Database::ExeDoIt($sql);
        $data = Model::many_assoc($query[0])[0];
        return $data;
        //!debe hacerse un URLdecode al retornar los datos para verlos correctamente. ***HECHO!!
    }



    /**************************************
     * TRAER DATOS DE INFORME DE CANCELACIÓN
     *************************************/
    public static function guardarInformeCancelacion($timerst,$data){ //guarda informe de cancelacion desde todos los siniestros
        $sql="INSERT INTO siniestros_informe_cancelacion (timerst,autor,area,folio,informe_cancelacion)
        values('".$data['timerst']."','".$_SESSION['id']."','1','".$data['folio']."','".urlencode($data['informeCancelacion'])."' )
        ";
        $query = Database::ExeDoIt($sql);

        $sql = "INSERT INTO siniestros_files (timerst,nombre,id_config_files,`url`,fecha,`version`)
        VALUES('".$data['timerst']."','informeCancelación',0,'informeCancelación','".core::getTimeNow()."',1) ";
        $query = Database::ExeDoIt($sql);

        //crear entrada bitacora
        include "./core/app/action/siniestro/bitacora-action.php";
        Siniestros::nuevaEntradaBitacora(array('timerst'=>$data['timerst'],'nuevaEntrada'=>'Se carga la informe de Cancelación','horasBitacora'=>'1'));

        //historico siniestros
        core::insertHistoricoSiniestros('update','Informe Cancelación',$data['timerst']);

        if($query) print "Informe Cancelación guardada OK";
    }
    //ver informe de Cancelacion
    public static function verInformeCancelacion($timerst,$area){ //muestra los datos de la primera atencion 
        $a = is_numeric($area)==true?$area:" (select id from areas where area = '".$area."') ";
        $sql="select * from siniestros_informe_cancelacion where timerst = '".$timerst."' and area = ".$a."  limit 1;";
        $query = Database::ExeDoIt($sql,false);
        $data = Model::many_assoc($query[0])[0];
        // core::preprint($data);
        return $data;
        //!debe hacerse un URLdecode al retornar los datos para verlos correctamente. ***HECHO!!
    }




     /**************************************
     //INFORMACION DE SINIESTRO PARA VER DATOS //??desde siniestros/verSiniestro por Timerst
     *************************************/
    public static function verSiniestroTimerst($timerst){
        $sql= "SELECT s.*,cc.valor calificacion, cs.valor `status`, lower(i.valor) institucion ,lower(a.valor) autoridad , concat(s.f_numProv,'-',LPAD(s.f_consecutivo,3,'0'),'-',SUBSTRING(s.f_year, 3)) folio , su.estatus statusAsignUs from siniestros s 
        LEFT JOIN siniestros_usuarios su on su.timerst = s.timerst
        LEFT JOIN config_campos i on i.id = s.institucion
        LEFT JOIN config_campos a on a.id = s.autoridad
        LEFT JOIN config_campos cs on cs.id = s.status
        LEFT JOIN config_campos cc on cc.id = s.calificacion
        where s.timerst ='".$timerst."' limit 1";
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
        LEFT JOIN config_campos i on i.id = s.institucion
        LEFT JOIN config_campos a on a.id = s.autoridad
        LEFT JOIN config_campos cs on cs.id = s.status
        LEFT JOIN config_campos cc on cc.id = s.calificacion
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

                $sql= "select count(id) contador from ".$prov['tabla']." where create_at BETWEEN '".$fecha_ini."' and '".$fecha_fin."' ";
                $query = Database::exeDoIt($sql);
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
    public static function datosGraficasIndexCalificaciones(){
        //? grafica del dashboard index calificaciones
        //retorna el array de json`s con los datos de cada proveniente para contar todos los siniestros y generar las graficas.
        $sql= "SELECT count(s.id)cantidad, (select valor from config_campos where id = s.calificacion )calificacion FROM `siniestros` s GROUP by calificacion;";
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
        $sql= "SELECT count(s.id)cantidad, (select valor from config_campos where id = s.status )`status` FROM `siniestros` s GROUP by status;";
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
        $sql= "select count(id) siniestros from siniestros where 1";
        $sql.=" and status = '175'"; // 	168 en estatus es igual a CANCELADOS
		if($prov!=''){
            $sql.=" and f_numProv = (select id from config_prov where proveniente = '".$prov."' limit 1)";
        }
		$query = Database::exeDoIt($sql);
		$data=Model::many_assoc($query[0])[0];
		return $data['siniestros'];
	}
    public static function countTodosSiniestrosVigentes($prov=''){// utilizado para jtabla siniestros
        $sql= "select count(id) siniestros from siniestros where 1";
        $sql.=" and status = '169'"; // 	166 en estatus es igual a VIGENTE
		if($prov!=''){
            $sql.=" and f_numProv = (select id from config_prov where proveniente = '".$prov."' limit 1)";
        }
		$query = Database::exeDoIt($sql);
		$data=Model::many_assoc($query[0])[0];
		return $data['siniestros'];
	}
    public static function countTodosSiniestrosProcesoCancelacion($prov=''){// utilizado para jtabla siniestros
        $sql= "select count(id) siniestros from siniestros where 1";
        $sql.=" and status = '167'"; // 	168 en estatus es igual a PROCESO CANCELACIÓN
		if($prov!=''){
            $sql.=" and f_numProv = (select id from config_prov where proveniente = '".$prov."' limit 1)";
        }
		$query = Database::exeDoIt($sql);
		$data=Model::many_assoc($query[0])[0];
		return $data['siniestros'];
	}
    public static function countTodosSiniestros($prov='',$statusS='',$area='',$asignados=false){// utilizado para jtabla siniestros  //?OPTIMIZADO PARA VARIOS USUARIOS
        $sql='';
        if($area!=''){
            $sqlarea = " sa.area ='".$area."' and ";
        }else{
            $sqlarea = "  ";
        }

        if($asignados== 'true' ){
            $sqlasignados =' and su.usuario = '.$_SESSION['id'];
        }
		if($prov!='' and $statusS!=''){
            // $sql= "select count(s.id) siniestros from siniestros s
            $sql= "select  COUNT(DISTINCT s.timerst) siniestros from siniestros s
            inner JOIN siniestros_areas sa on s.timerst = sa.timerst
            LEFT JOIN siniestros_usuarios su on s.timerst = su.timerst
            where ". $sqlarea ." 
            s.f_numProv = (select id from config_prov where proveniente = '".$prov."' )
            and status = '$statusS' ". $sqlasignados;
        }else if($prov=='' and $statusS==''){
            $sql.= "select  COUNT(DISTINCT s.timerst) siniestros from siniestros s
            inner JOIN siniestros_areas sa on s.timerst = sa.timerst
            LEFT JOIN siniestros_usuarios su on s.timerst = su.timerst
            where ". $sqlarea ." 1 ". $sqlasignados;
        }else if(($prov=='' and $statusS!='') or ($prov!='' and $statusS=='') ){
            $sql.= "select  COUNT(DISTINCT s.timerst) siniestros from siniestros s
            inner JOIN siniestros_areas sa on s.timerst = sa.timerst
            LEFT JOIN siniestros_usuarios su on s.timerst = su.timerst
            where ". $sqlarea;
            if($prov!='')   $sql.= " s.f_numProv = (select id from config_prov where proveniente = '".$prov."' ) and";
            if($statusS!='')$sql.= " status = '$statusS' and ";
            $sql.= " 1 ". $sqlasignados;
        }

		$query = Database::exeDoIt($sql,false);
		$data=Model::many_assoc($query[0])[0];
		return $data['siniestros'];
	}
    //? FIN contadores de siniestros ------------------------------------------------


    public static function getTodosSiniestros($orden,$limitInf,$limitSup,$_prov='',$_status='',$area,$asignados=false){// utilizado para jtabla siniestros para abogadops
        $sqlasignados='';
        if($asignados== 'true' ){
            $sqlasignados =' and su.usuario = '.$_SESSION['id'];
        }

        $sql="SELECT s.id,concat(s.nombre,' ',s.apellidoP,' ',s.apellidoM) nombre, s.timerst, s.activo, concat(f_numProv,'-',LPAD(f_consecutivo,3,'0'),'-',SUBSTRING(f_year, 3)) folio, SUBSTRING(UPPER(proveniente),6) proveniente, c.valor as institucion, cel,casa,oficina, fechaReporte,estado,ciudad,mail,formaContacto,descripcionHechos,numReporte,NumPoliza,numSiniestro,vigencia1,vigencia2,cs.valor calificacion,cc.valor autoridad,css.valor `status` ,fechaAsignacion,if(pa.primera_atencion<>'','si','no') as primera_atencion, if(ip.informe_preliminar<>'','si','no') as informe_preliminar,if(ic.informe_cancelacion<>'','si','no') as informe_cancelacion, fechaCaptura, su.usuario idUserAsign , su.estatus statusUserAsign ";
        $sql.=" FROM ". self::$tabla ." as s ";//siniestros
        $sql.= " inner JOIN siniestros_areas sa on s.timerst = sa.timerst";
        $sql.= " LEFT JOIN siniestros_usuarios su on s.timerst = su.timerst";
            $aa= '';
            if($area!=''){  $aa= ' AND pa.area = '. $area; }
        $sql.= " LEFT JOIN siniestros_primera_atencion as pa on s.timerst = pa.timerst ".$aa;
        $sql.= " LEFT JOIN siniestros_informe_preliminar as ip on s.timerst = ip.timerst ".$aa;
        $sql.= " LEFT JOIN siniestros_informe_cancelacion as ic on s.timerst = ic.timerst ".$aa;
        $sql.= " INNER JOIN config_campos c on s.institucion = c.id ";
        $sql.= " INNER JOIN config_campos cc on s.autoridad = cc.id ";
        $sql.= " INNER JOIN config_campos cs on s.calificacion= cs.id ";
        $sql.= " INNER JOIN config_campos css on s.status = css.id ";
        $sql.= " WHERE ";
        if($area==''){
            $sql.= "  1 ";
        }else{
            $sql.= " sa.area = ".$area;
        }
        if($asignados== 'true' ){
            $sql.=' and  su.usuario = '.$_SESSION['id'];
        }
        if($_prov!='' && $_prov!='undefined' && $_status!='' ){ // con status y prov
            $sql.=" and s.f_numProv = (select prov.id from config_prov prov where proveniente= '".$_prov."' limit 1)  and   s.status = ".$_status;
        }
        elseif($_prov=='' && $_status==''){
            //esto pasa solo si esta limpia de filtros
        }
        else if($_prov=='' && $_status!=''){ // con status
            $sql.=" and s.status = ".$_status;
        }
        else if(($_prov!='' || $_prov!='undefined') && $_status=='' ){ //con prov
            $sql.=" and s.f_numProv = (select prov.id from config_prov prov where proveniente= '".$_prov."' limit 1)";
        }
        else{
            $sql.=" and s.f_numProv = (select prov.id from config_prov prov where proveniente= '".$_prov."' limit 1)  and   s.status = ".$_status;
            core::preprint($_prov,'prov no se cumple anda');
            core::preprint($_status,'status no se cumple anda');exit();
        }
        
        //GROUP BY s.timerst
        $sql.=' GROUP BY s.timerst '. $orden." limit ".$limitInf.",". $limitSup . "  ";
        $query =Database::ExeDoIt($sql,false);
        // core::preprint($_status,'status');exit();
        $data = Model::many_assoc($query[0]);
        $GLOBALS['sql1']= $sql;
        return $data;
    }


}