<?php
class Siniestros{
	
    public static $clientesTB = "siniestros";

    public static function getNumPolizaValores($timerst){ //?busca los ids asignados a polizas y los amarra con el timerst o folio ID del siniestro por siniestro,
        //obtener numeros de polisas
        $sql="select numPoliza from siniestros where timerst = '".$timerst."'";
        $query = Database::ExeDoIt($sql,false);
        $pols = Model::many_assoc( $query[0])[0]['numPoliza'];
        $pols= trim($pols,"][");
        if(strpos($pols,',')>=1){
            $pols = explode(',',$pols);
        }else{
            $pols = array($pols);
        }
        $polizasReales=[];//representa las polizas que estan enlazadas por id a siniestros y tienen cantidades por timerst en siniestros_polizas

        //valida polisas y cantidades por timerst
        foreach ($pols as $pol) {
           $sql="select * from siniestros_polizas where id = ".$pol." limit 1";
           $query= Database::ExeDoIt($sql,false);
           $data=Model::many_assoc($query[0])[0];

           if ($data['timerst']=='' ){
                //si timerst esta vacio es que no esta enlazada a ningun id, se debe enlazar.
                $sql=" UPDATE siniestros_polizas set timerst ='".$timerst."' where id=".$data['id'];
                $query= Database::ExeDoIt($sql);
                //empata los datos insertdos con la consulkta anterior
                $data['timerst']=$timerst;
                array_push($polizasReales,$data);
           }else if($data['timerst']!='' && $data['timerst']==$timerst){
                //Si el timerst no esta vacio, y es igual que el timerst actual
                array_push($polizasReales,$data); //?AGRUPANDO DATOS REALES
           }
           else if($data['timerst']!='' && $data['timerst']!=$timerst){
                //si el timerst no esta vacio y es diferente del actual timerst (le pertenece a otro ID , se debe generar uno propio)
                $sql = "insert into siniestros_polizas (timerst,poliza) 
                values('".$timerst."', '". $data['poliza']."')";
                $query=Database::ExeDoIt($sql);
                
                $sql="select * from siniestros_polizas where timerst= '".$timerst."' and poliza = '". $data['poliza']."' limit 1 ";
                $query= Database::ExeDoIt($sql);
                $newdata = Model::many_assoc($query[0])[0];
                array_push($polizasReales,$newdata);
           }
           //termina el for de recorrer todos los ids asignados al siniestro y validarlos
           //devuelve el array
           return $polizasReales;
        }
    }
    

    //OBTIENE NUMEROS DE POLIZAS
    public static function getNumPoliza($timerst,$idPolizas){
        $pols = json_decode($idPolizas);
        // core::preprint($pols);
        $idPoliza=[];
        foreach($pols as $id){
            $sql="select * from siniestros_polizas where id = '$id' limit 1";
            $query = Database::exeDoIt($sql);
            $idPoliza[] = Model::unsetOne($query[0]);
        }
        // core::preprint($idPoliza);
        return $idPoliza;
    }




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
        $sql= "SELECT (select valor from config_campos where id = status) status from siniestros_areas where timerst = '$timerst'  and area = '$areaID'  limit 1";
        $query= Database::ExeDoIt($sql,false);
        if ($query[0]->num_rows){
            $datos=Model::many_assoc($query[0])[0]['status'];
            if ($datos!=''){
                return $datos;
                exit();
            }
        }
      
        //en caso de no existir status, el flujo sigue.
            $sql="select (select valor from config_campos where id = status) status from siniestros where timerst = '$timerst' limit 1 ";
            $query= Database::ExeDoIt($sql,false);
            return Model::many_assoc($query[0])[0]['status'];
            exit();
    }

    public static function getCalificacionByArea($timerst,$areaID){
        $sql= "SELECT (select valor from config_campos where id = calificacion) calificacion from siniestros_areas where timerst = '$timerst'  and area = '$areaID'  limit 1";
        $query= Database::ExeDoIt($sql,false);
        if ($query[0]->num_rows){
            $datos=Model::many_assoc($query[0])[0]['calificacion'];
            if ($datos!=''){
                return $datos;
                exit();
            }
        }
      
        //en caso de no existir status, el flujo sigue.
            $sql="select (select valor from config_campos where id = calificacion) calificacion from siniestros where timerst = '$timerst' limit 1 ";
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
        $sql="select sb.usuario usuarioID, sb.*,DATE_FORMAT(sb.fecha_actividad, '%e %b %Y') fecha_actividad_F, DATE_FORMAT(sb.fecha_creacion, '%e %b %Y %H:%i') fecha_creacion_F, if(sb.verificado=0,' ','Verificado') verificado, concat(u.nombre,' ',u.paterno, ' ', u.materno ) usuario, concat(uA.nombre,' ',uA.paterno) usuario_alter 
        from siniestros_bitacora sb 
        inner join usuarios u on u.id= sb.usuario
        left join usuarios uA on uA.id= sb.usuario_alter
        where timerst ='".$timerst."' and area = (select a.id from areas a where a.area= '$area'  ) order by sb.fecha_creacion desc";
        $query = Database::ExeDoIt($sql,false);
        $data=[];
        if($query[0]->num_rows>=1){
            $data = Model::many_assoc($query[0]);
            // core::preprint($data);
            foreach ($data as $k => $v) {
                // core::preprint($v['bitacora'],'bitacora ');
                // core::preprint($k,'k ',true);
                $data[$k]['bitacora'] = urldecode($v['bitacora']);
            }
            $newData=[];
        }
        // core::preprint($data);
        // exit();
        return $data;
        
    }
    public static function nuevaEntradaBitacora($r,$redirect=true){
        $fechaCreacion = core::getTimeNow();
        $content = urlencode($r['nuevaEntrada']);
        $usuario = $_SESSION['id'];
        $area = $r['area'];
        $fechaActividad = $r['fechaActividad'];
        if(isset($r['idsessionUsuario'])){
            $fechaCreacion= $r['fechaCreacion'];
            $content = $r['nuevaEntrada'];
            $usuario = $r['idsessionUsuario'];
            $area = $r['area'];
            $fechaActividad = $r['fechaActividad'];
        }

        $sql="INSERT INTO siniestros_bitacora (timerst,fecha_creacion,bitacora,horas,usuario,area,fecha_actividad)
        values ('".$r['timerst']."', '".$fechaCreacion."','".$content."',".$r['horasBitacora'].",".$usuario.",".$area.",'".$fechaActividad."' );";
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
    public static function editarBitacora($r){
        $r['nuevaEntrada'] = urlencode($r['nuevaEntrada']);
        $sql='UPDATE siniestros_bitacora set usuario_alter='.$_SESSION['id'].',horas="'.$r['horasBitacora'].'" ,fecha_modificacion ="'.Core::getTimeNow().'", bitacora="'.$r['nuevaEntrada'].'" , fecha_actividad= "'.$r['fechaActividad'].'" where id = '.$r['idBitacora']. ' and timerst="'.$r['timerst'].'"';
        $query = Database::ExeDoIt($sql);
        if ($query[0]==1){
            header("Refresh:0; url=./?view=siniestro/ver&param=".$r['timerst']);
        }
        core::preprint($sql);
        core::preprint($query);

    }

     /**************************************
     * VER TODOS LOS ARCHIVOS DEL SINIESTRO Y SUS VERSIONES                 [PESTAÑA DOCUMENTACIÓN]
     *************************************/
    public static function verArchivosdelSiniestro($timerst,$areaId){
        
        
        $sql="SELECT s.*, s.id as id, lpad(s.version,2,'0') version,LOWER(c1.valor) c1,LOWER(c2.valor) c2,LOWER(c3.valor) c3 FROM `siniestros_files` s
        LEFT JOIN config_files c1 on c1.id = id_config_files
        LEFT JOIN config_files c2 on c2.id = c1.parent
        LEFT JOIN config_files c3 on c3.id = c2.parent
        where s.timerst = '".$timerst."' and (s.area='$areaId' or s.area=(select id from areas where area='$areaId' limit 1 ) ) 
        and version = (select max(version) from `siniestros_files` as s1
        where s1.timerst = '".$timerst."' and s.nombre = s1.nombre ) order by fecha desc";




/* SELECT s.*,lpad(s.version,2,'0') version,LOWER(c1.valor) c1,LOWER(c2.valor) c2,LOWER(c3.valor) c3 FROM `siniestros_files` s
        LEFT JOIN config_files c1 on c1.id = id_config_files
        LEFT JOIN config_files c2 on c2.id = c1.parent
        LEFT JOIN config_files c3 on c3.id = c2.parent
        where s.timerst = '".$timerst."' and (s.area='$areaId' or s.area=(select id from areas where area='$areaId' limit 1 ) ) order by fecha DESC */

        //
        $query = Database::ExeDoIt($sql,false);
        $data = Model::many_assoc($query[0]);
        // $data['info']= $sql;
        return $data;
    }

    /**************************************
     * TRAER DATOS DE PRIMERA ATENCIÓN
     *************************************/
    public static function guardarPrimeraAtencion($timerst,$data,$edit=false){ //guarda primera atencion desde todos los siniestros
        
        //obtener version de formato.
        $sqlv= "select version from siniestros_files where timerst='".$data['timerst']."' and nombre='primeraAtencion'  and area='".$data['areaID']."' order by id desc limit 1;";
        $query = Database::ExeDoIt($sqlv);
        $version= '1';
        if($query[0]->num_rows){
            $version= Model::many_assoc($query[0])[0]['version'];
            $version = $version+1;
        }
        
        $sql="INSERT INTO siniestros_primera_atencion (timerst,autor,area,folio,primera_atencion,fecha_creacion,rev)
        values('".$data['timerst']."','".$_SESSION['id']."','".$data['areaID']."','".$data['folio']."','".urlencode($data['primeraAtencion'])."','".Core::getTimeNow()."', $version)
        ";
        $query = Database::ExeDoIt($sql);

        
        
        //insertar para mostrar file del informe en docs
        $sql = "INSERT INTO siniestros_files (timerst,nombre,id_config_files,`url`,fecha,`version`,area)
        VALUES('".$data['timerst']."','primeraAtencion',0,'Documentos GMX','".core::getTimeNow()."',$version,'".$data['areaID']."') ";
        $query = Database::ExeDoIt($sql);

        //crear entrada bitacora
        include "./core/app/action/siniestro/bitacora-action.php";
        core::preprint($data);
        Siniestros::nuevaEntradaBitacora(array('fechaActividad'=>$data['fechaActividad'],'timerst'=>$data['timerst'],'nuevaEntrada'=>'Se carga la Primera Atención revisión: '.$version.' / '.$data['bitacora'],'horasBitacora'=>$data['horas'],'area'=>$data['areaID']));

        //historico siniestros
        core::insertHistoricoSiniestros('Actualización','Primera Atención revisión: '.$data['areaID'].' revisión: '.$version,$data['timerst']);

        if($query) print "primera atencion guardada OK";
    }
    //ver primera atención  
    public static function verPrimeraAtencion($timerst,$area,$version=''){ //muestra los datos de la primera atencion 
        if($version!=''){$version= ' and spa.rev='.$version;}
        $sql="select spa.*, 
        (select concat(u.nombre,' ',u.paterno) autor from usuarios u where u.id = spa.autor limit 1) autor,
        (select concat(nombre,' ',apellidoP,' ',apellidoM) from siniestros s where s.timerst=spa.timerst) asegurado
         from siniestros_primera_atencion spa where spa.timerst = '".$timerst."' and spa.area = (select id from areas where area = '".$area."') $version  order by id desc limit 1";
        $query = Database::ExeDoIt($sql,false);
        $data = Model::many_assoc($query[0])[0];
        $data['area']= $area;
        // core::preprint($data);exit();
        return $data;
        //!debe hacerse un URLdecode al retornar los datos para verlos correctamente. ***HECHO!!
    }

          /**************************************
     * TRAER DATOS DE INFORME PRELIMINAR
     *************************************/
    public static function guardarInformePreliminar($timerst,$data){ //guarda informe preliminar desde todos los siniestros
        
        // core::preprint($data,'data preliminar');exit();
         //obtener versión de formato.
         $sqlv= "SELECT version from siniestros_files where timerst='".$data['timerst']."' and nombre='informePreliminar'  and area='".$data['areaID']."' order by id desc limit 1;";
         $query = Database::ExeDoIt($sqlv);
         $version= '1';
         if($query[0]->num_rows){
             $version= Model::many_assoc($query[0])[0]['version'];
             $version = $version+1;
         }
         
         //INSERTAR EL REGISTRO DEL FORMATO EN SU TABLA
        $sql="INSERT INTO siniestros_informe_preliminar (timerst,autor,area,folio,informe_preliminar,fecha_creacion,rev)
        values('".$data['timerst']."','".$_SESSION['id']."','".$data['areaID']."','".$data['folio']."','".urlencode($data['informePreliminar'])."' ,'".Core::getTimeNow()."' ,$version )
        ";
        $query = Database::ExeDoIt($sql,false);

       

        //!disabled por segunda parte de preliminar //insertar para mostrar file del informe en docs
        // $sql = "INSERT INTO siniestros_files (timerst,nombre,id_config_files,`url`,fecha,`version`,area)
        // VALUES('".$data['timerst']."','informePreliminar',0,'Documentos GMX','".core::getTimeNow()."',$version,'".$data['areaID']."') ";
        // $query = Database::ExeDoIt($sql);

        //!dsabled por segunda parte de preliminar  //crear entrada bitacora
        // include "./core/app/action/siniestro/bitacora-action.php";
        // Siniestros::nuevaEntradaBitacora(array('timerst'=>$data['timerst'],'nuevaEntrada'=>'Se inicia el Informe Preliminar revisión: '.$version.' / '.$data['bitacora'],'horasBitacora'=>$data['horas'],'area'=>$data['areaID']));

        //historico siniestros
        core::insertHistoricoSiniestros('Actualización','Inicia Informe Preliminar '.$data['areaID'].' revisión: '.$version,$data['timerst']);

        if($query) print "informe preliminar guardada OK";
    }

    public static function segundaPartePreliminar($dataForm){ //guarda informe preliminar desde todos los siniestros
        parse_str($dataForm['data']['form'],$datosForm); 
        $data = $datosForm;
        $info = $dataForm['data'];
        
        // core::preprint($data,'data preliminar');
        // core::preprint($info,'info preliminar');exit();
         //obtener versión de formato.
         $sqlv= "SELECT version from siniestros_files where timerst='".$info['timerst']."' and nombre='informePreliminar'  and area='".$info['areaID']."' order by id desc limit 1;";
         $query = Database::ExeDoIt($sqlv);
         $version= '1';
         if($query[0]->num_rows){
             $version= Model::many_assoc($query[0])[0]['version'];
             $version = $version+1;
         }
         
         //INSERTAR EL REGISTRO DEL FORMATO EN SU TABLA
        $sql="INSERT INTO siniestros_informe_preliminar_form (
            timerst,
            autor,
            area,
            folio,
            fecha_creacion,
            rev,
            noPoliza,
            asegurado,
            fechaOcurrido,
            tercero,
            causa,
            lugar,
            ciudad,
            agente,
            practica,
            vigenciaInicio,
            vigenciaFin,
            fechaReporte,
            fechaAsignacion,
            fecha1raAtencion,
            autoridad,
            noExpediente,
            etapa,
            hechos,
            causaProxima,
            reclamacion,
            fundamento,
            sumAsegurada,
            estimacion,
            importeReclamado,
            reservaRecomendada,
            observaciones,
            ramo,
            subramo
            )
        values(
            '".$info['timerst']."',
            '".$_SESSION['id']."',
            '".$info['areaID']."',
            '".$info['folio']."',
            '".Core::getTimeNow()."' ,
            $version,
            '".$data['noPoliza']."',
            '".$data['asegurado']."',
            '".$data['fechaOcurrido']."',
            '".$data['tercero']."',
            '".$data['causa']."',
            '".$data['lugar']."',
            '".$data['ciudad']."',
            '".$data['agente']."',
            '".$data['practica']."',
            '".$data['vigenciaInicio']."',
            '".$data['vigenciaFin']."',
            '".$data['fechaReporte'].' '.$data['horaReporte']."',
            '".$data['fechaAsignacion'].' '.$data['horaAsignacion']."',
            '".$data['fecha1raAtencion'].' '.$data['hora1raAtencion']."',
            '".$data['autoridad']."',
            '".$data['noExpediente']."',
            '".$data['etapa']."',
            '".urlencode($info['preliminarHechos'])."' ,
            '".$data['causaProxima']."',
            '".$data['reclamacion']."',
            '".$data['fundamento']."',
            '".$data['sumAsegurada']."',
            '".$data['estimacion']."',
            '".$data['importeReclamado']."',
            '".$data['reservaRecomendada']."',
            '".urlencode($info['preliminarObservaciones'])."',
            '".$data['ramo']."',
            '".$data['subramo']."'

            )
        ";
        $query = Database::ExeDoIt($sql);

        core::preprint($query);
        core::preprint($sql);

        if ($query[0]){ // si se guiarda correctamente el formulario, continua con lo de mas.
            
            //crear4 entrada en listado de documentos
            $sql = "INSERT INTO siniestros_files (timerst,nombre,id_config_files,`url`,fecha,`version`,area)
            VALUES('".$info['timerst']."','informePreliminar',0,'Documentos GMX','".core::getTimeNow()."',$version,'".$info['areaID']."') ";
            $query = Database::ExeDoIt($sql);
    
             //crear entrada bitacora
            include "./core/app/action/siniestro/bitacora-action.php";
            Siniestros::nuevaEntradaBitacora(array('timerst'=>$info['timerst'],'nuevaEntrada'=>'Se inicia el Informe Preliminar revisión: '.$version.' / ','horasBitacora'=>1,'area'=>$info['areaID']));
    
            //historico siniestros
            core::insertHistoricoSiniestros('Actualización','Informe Preliminar '.$info['areaID'].' revisión: '.$version,$info['timerst']);
    
            if($query) print "informe preliminar guardada OK";

        }else{
            echo "error";

        }
    }

       

       /*  Array
(
    [noPoliza] => 1-66-7010904-3-0 / 
    [asegurado] => RICARDO JAIME ROMERO
    [fechaOcurrido] => 2022-07-07
    [tercero] => tercero
    [causa] => causa
    [lugar] => lugar
    [ciudad] => ciudad
    [agente] => agente
    [practica] => practivca
    [vigenciaInicio] => 2022-07-08
    [vigenciaFin] => 2022-07-22
    [fechaReporte] => 2022-07-01
    [fechaAsignacion] => 2022-07-09
    [fecha1raAtencion] => 2022-07-13
    [autoridad] => CONAMED
    [noExpediente] => expediente
    [etapa] => etapa
    [preliminarHechos] =>  
    [causaProxima] => causa 
    [reclamacion] => reclamacion
    [fundamento] => fundamento
    [sumAsegurada] => suma
    [estimacion] => estimacion
    [importeReclamado] => importe
    [reservaRecomendada] => reserva
    [preliminarObservaciones] => Observaciones:  
)
:out

 in info preliminar 
Array
(
    [preliminarHechos] => 
hola mundo



    [preliminarObservaciones] => 
Observaciones:



    [timerst] => 1656930147.371
    [folio] => 102-068-22
    [areaID] => 2
    [form] => noPoliza=1-66-7010904-3-0%20%2F%20&asegurado=RICARDO%20JAIME%20ROMERO&fechaOcurrido=2022-07-07&tercero=tercero&causa=causa&lugar=lugar&ciudad=ciudad&agente=agente&practica=practivca&vigenciaInicio=2022-07-08&vigenciaFin=2022-07-22&fechaReporte=2022-07-01&fechaAsignacion=2022-07-09&fecha1raAtencion=2022-07-13&autoridad=CONAMED&noExpediente=expediente&etapa=etapa&preliminarHechos=%20&causaProxima=causa%20&reclamacion=reclamacion&fundamento=fundamento&sumAsegurada=suma&estimacion=estimacion&importeReclamado=importe&reservaRecomendada=reserva&preliminarObservaciones=Observaciones%3A%20%20
) */

    //ver INFORME PRELIMINAR
    public static function verInformePreliminar($timerst,$area,$version=''){ //muestra los datos de la primera atencion 
        if($version!=''){$version= ' and sip.rev='.$version; }
        $sql="select sip.*, 
        (select concat(u.nombre,' ',u.paterno,' ',u.materno) autor from usuarios u where u.id = sip.autor limit 1) autor,
        (select concat(nombre,' ',apellidoP,' ',apellidoM) from siniestros s where s.timerst='".$timerst."' limit 1) asegurado,
        (select sin.numSiniestro from siniestros sin where sin.timerst='".$timerst."' limit 1) numSiniestro,
        (select sa.calificacion from siniestros_areas sa where sa.timerst= '".$timerst."' and sa.area= (select id from areas where area = '".$area."' limit 1) limit 1) calificacion
        from siniestros_informe_preliminar sip where sip.timerst = '".$timerst."' and sip.area = (select id from areas where area = '".$area."' limit 1) $version order by id desc limit 1;";
        $query = Database::ExeDoIt($sql,false);
        $data = Model::many_assoc($query[0])[0];/*********** */

        //recuperando segunda parte
        $ver2=' and f.rev='.$data['rev'];/*********** */
        $sql2= "select * from siniestros_informe_preliminar_form f 
        where f.timerst ='$timerst' and f.area = 
        (select id from areas where area = '".$area."') 
        $ver2 order by f.id desc limit 1;";
        $query2 = Database::ExeDoIt($sql2);
        // core::preprint($sql2);
        // core::preprint($query2);
        if( isset($query2[0]->num_rows) && $query2[0]->num_rows>=1){
            $segundaParte = Model::many_assoc($query2[0])[0];
            $data['segundaParte']= $segundaParte;
        }

        if( $data['calificacion'] == ''){/*********** */
            $sql="select sa.calificacion from siniestros sa where sa.timerst= '".$timerst."' limit 1";
            $query = Database::ExeDoIt($sql,false);
            $cal = Model::many_assoc($query[0])[0]['calificacion'];
            switch ($cal) {
                case 291:
                     $data['calificacion'] = 'canc. admva.';
                    break;
                case 169:
                     $data['calificacion'] = 'Por determinar';
                    break;
                case 165:
                     $data['calificacion'] = 'Reapertura';
                    break;
                case 164:
                     $data['calificacion'] = 'Preventivo';
                    break;
                case 163:
                     $data['calificacion'] = 'Improcedente';
                    break;
                case 162:
                     $data['calificacion'] = 'Procedente';
                    break;
                case 161:
                     $data['calificacion'] = 'Asesoría';
                    break;
                default:
                     $data['calificacion'] = '';
                    break;
            }

            // $data['calificacion']= $cal;
        }



        $data['area']= $area;
        return $data;
        //!debe hacerse un URLdecode al retornar los datos para verlos correctamente.
    }

    
    /**************************************
     * TRAER DATOS DE INFORME ACTUALIZACION
     *************************************/
    
    public static function guardarInformeActualizacion($timerst,$data,$edit=false){ //guarda primera atencion desde todos los siniestros
        
        //obtener version de formato.
        $sqlv= "select version from siniestros_files where timerst='".$data['timerst']."' and nombre='informeActualizacion'  and area='".$data['areaID']."' order by id desc limit 1;";
        $query = Database::ExeDoIt($sqlv);
        $version= '1';
        if($query[0]->num_rows){
            $version= Model::many_assoc($query[0])[0]['version'];
            $version = $version+1;
        }
        
        $sql="INSERT INTO siniestros_informe_actualizacion (timerst,autor,area,folio,informe_actualizacion,fecha_creacion,rev)
        values('".$data['timerst']."','".$_SESSION['id']."','".$data['areaID']."','".$data['folio']."','".urlencode($data['informeActualizacion'])."','".Core::getTimeNow()."', $version )";
        $query = Database::ExeDoIt($sql,false);

        //insertar para mostrar file del informe en docs
        $sql = "INSERT INTO siniestros_files (timerst,nombre,id_config_files,`url`,fecha,`version`,area) 
        VALUES('".$data['timerst']."','informeActualizacion',0,'Documentos GMX','".core::getTimeNow()."',$version,'".$data['areaID']."') ";
        $query = Database::ExeDoIt($sql,false);

        //crear entrada bitacora
        include "./core/app/action/siniestro/bitacora-action.php";
        Siniestros::nuevaEntradaBitacora(array('fechaActividad'=>$data['fechaActividad'],'timerst'=>$data['timerst'],'nuevaEntrada'=>'Se carga la Informe de Actualización revisión: '.$version.' / '.$data['bitacora'],'horasBitacora'=>$data['horas'],'area'=>$data['areaID']));

        //historico siniestros
        core::insertHistoricoSiniestros('Actualización','Informe Actualización '.$data['areaID'].' revisión: '.$version,$data['timerst']);

        if($query) print "informe actualizacion guardada OK";
    }
    //ver informe actualización 
    public static function verInformeActualizacion($timerst,$area,$version=''){ //muestra los datos de la primera atencion 
        if($version!=''){$version= ' and sia.rev='.$version;}
        $sql="select sia.*, 
        (select concat(u.nombre,' ',u.paterno) autor from usuarios u where u.id = sia.autor limit 1) autor,
        (select concat(nombre,' ',apellidoP,' ',apellidoM) from siniestros s where s.timerst=sia.timerst) asegurado
         from siniestros_informe_actualizacion sia where sia.timerst = '".$timerst."' and sia.area = (select id from areas where area = '".$area."') $version order by id desc limit 1";
        $query = Database::ExeDoIt($sql,false,true);
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

        //obtener version de formato.
        $sqlv= "select version from siniestros_files where timerst='".$data['timerst']."' and nombre='informeCancelacion'  and area='".$data['areaID']."' order by id desc limit 1;";
        $query = Database::ExeDoIt($sqlv);
        $version= '1';
        if($query[0]->num_rows){
            $version= Model::many_assoc($query[0])[0]['version'];
            $version = $version+1;
        }
        
        $sql="INSERT INTO siniestros_informe_cancelacion (timerst,autor,area,folio,informe_cancelacion,fecha_creacion,rev)
        values('".$data['timerst']."','".$_SESSION['id']."','".$data['areaID']."','".$data['folio']."','".urlencode($data['informeCancelacion'])."' ,'".Core::getTimeNow()."',$version )";
        $query = Database::ExeDoIt($sql);


        //insertar para mostrar file del informe en docs
        $sql = "INSERT INTO siniestros_files (timerst,nombre,id_config_files,`url`,fecha,`version`,area)
        VALUES('".$data['timerst']."','informeCancelacion',0,'Documentos GMX','".core::getTimeNow()."',$version,'".$data['areaID']."') ";
        $query = Database::ExeDoIt($sql);

        //crear entrada bitacora
        include "./core/app/action/siniestro/bitacora-action.php";
        Siniestros::nuevaEntradaBitacora(array('fechaActividad'=>$data['fechaActividad'],'timerst'=>$data['timerst'],'nuevaEntrada'=>'Se carga la Informe de Cancelación revisión: '.$version.' / '.$data['bitacora'],'horasBitacora'=>$data['horas'],'area'=>$data['areaID'] ));

        //historico siniestros
        core::insertHistoricoSiniestros('Actualización','Informe Cancelación '.$data['areaID'].' revisión: '.$version,$data['timerst']);

        if($query) print "Informe Cancelación guardada OK";
    }
    //ver informe de Cancelacion
    public static function verInformeCancelacion($timerst,$area,$version=''){ //muestra los datos de la primera atencion 
        if($version!=''){$version= ' and sic.rev='.$version;}
        $sql="select sic.*, 
        (select concat(u.nombre,' ',u.paterno) autor from usuarios u where u.id = sic.autor limit 1) autor,
        (select concat(nombre,' ',apellidoP,' ',apellidoM) from siniestros s where s.timerst=sic.timerst) asegurado
        from siniestros_informe_cancelacion sic where sic.timerst = '".$timerst."' and sic.area = (select id from areas where area = '".$area."') $version order by id desc limit 1;";
        $query = Database::ExeDoIt($sql,false);
        $data = Model::many_assoc($query[0])[0];
        $data['area']= $area;
        return $data;
        //!debe hacerse un URLdecode al retornar los datos para verlos correctamente. ***HECHO!!
    }




     /**************************************
     //INFORMACION DE SINIESTRO PARA VER DATOS //??desde siniestros/verSiniestro por Timerst
     *************************************/
    
    public static function verSiniestroTimerstCaratula($timerst){
        $sql="SET lc_time_names = 'es_ES';"; $query = Database::ExeDoIt($sql); // esencial para poner en español

        $sql= "SELECT s.*,
        DATE_FORMAT(s.vigencia1, '%d-%b-%y %H:%i') vigencia1_F,DATE_FORMAT(s.vigencia2, '%d-%b-%y %H:%i') vigencia2_F, DATE_FORMAT(s.fechaReporte, '%d %b %Y %H:%i') fechaReporte_F, DATE_FORMAT(s.fechaCaptura, '%d %b %Y %H:%i') fechaCaptura_F,       DATE_FORMAT(s.fechaAsignacion, '%d %b %Y %H:%i') fechaAsignacion_F,
        DATE_FORMAT(s.vigencia1, '%d-%b-%y') vigencia1_F2, DATE_FORMAT(s.vigencia2, '%d-%b-%y') vigencia2_F2, DATE_FORMAT(s.fechaReporte, '%d %b %Y') fechaReporte_F2, DATE_FORMAT(s.fechaCaptura, '%d %b %Y') fechaCaptura_F2, DATE_FORMAT(s.fechaAsignacion, '%d %b %Y') fechaAsignacion_F2,
        cc.valor calificacion, cs.valor `status`, (i.valor) institucion ,(a.valor) autoridad , concat(s.f_numProv,'-',LPAD(s.f_consecutivo,3,'0'),'-',SUBSTRING(s.f_year, 3)) folio 
        from siniestros s 
        LEFT JOIN config_campos i on i.id = s.institucion
        LEFT JOIN config_campos a on a.id = s.autoridad
        LEFT JOIN config_campos cs on cs.id = s.status
        LEFT JOIN config_campos cc on cc.id = s.calificacion
        where s.timerst ='".$timerst."' limit 1";
		$query = Database::exeDoIt($sql);
        if ($query[0]->num_rows==1){
            $data=Model::many_assoc($query[0])[0];

            $sq = self::getNumPoliza($timerst,$data['numPoliza']);

            $data['poliza'] = $sq;
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

    public static function verSiniestroTimerst($timerst){
        $sql="SET lc_time_names = 'es_ES';"; $query = Database::ExeDoIt($sql); // esencial para poner en español

        $sql= "SELECT s.*,
        DATE_FORMAT(s.vigencia1, '%d-%b-%y %H:%i') vigencia1_F,DATE_FORMAT(s.vigencia2, '%d-%b-%y %H:%i') vigencia2_F, DATE_FORMAT(s.fechaReporte, '%d %b %Y %H:%i') fechaReporte_F, DATE_FORMAT(s.fechaCaptura, '%d %b %Y %H:%i') fechaCaptura_F,       DATE_FORMAT(s.fechaAsignacion, '%d %b %Y %H:%i') fechaAsignacion_F,
        DATE_FORMAT(s.vigencia1, '%d-%b-%y') vigencia1_F2, DATE_FORMAT(s.vigencia2, '%d-%b-%y') vigencia2_F2, DATE_FORMAT(s.fechaReporte, '%d %b %Y') fechaReporte_F2, DATE_FORMAT(s.fechaCaptura, '%d %b %Y') fechaCaptura_F2, DATE_FORMAT(s.fechaAsignacion, '%d %b %Y') fechaAsignacion_F2,
        cc.valor calificacion, cs.valor `status`, (i.valor) institucion ,(a.valor) autoridad , concat(s.f_numProv,'-',LPAD(s.f_consecutivo,3,'0'),'-',SUBSTRING(s.f_year, 3)) folio 
        from siniestros s 
        LEFT JOIN config_campos i on i.id = s.institucion
        LEFT JOIN config_campos a on a.id = s.autoridad
        LEFT JOIN config_campos cs on cs.id = s.status
        LEFT JOIN config_campos cc on cc.id = s.calificacion
        where s.timerst ='".$timerst."' limit 1";
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
        $sql= "SELECT count(s.id)cantidad, (select valor from config_campos where id = s.calificacion and estado = 'A') calificacion  FROM `siniestros` s WHERE estado1='A' GROUP by calificacion ";
		$query = Database::exeDoIt($sql);
		$calificaciones=Model::many_assoc($query[0]);
        $labels = [];
        $cantidades = [];
        foreach ($calificaciones as $d) {
            //armar el json que se entrega al js
            $labels[]=  strtoupper(utf8_encode($d['calificacion']));
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
            $labels[]=  strtoupper(utf8_encode($d['status']));
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
        $sql.=" and status = '175'"; // 	166 en estatus es igual a CANCELADOS
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
		$query = Database::exeDoIt($sql,false);
		$data=Model::many_assoc($query[0])[0];
		return $data['siniestros'];
	}
    public static function countTodosSiniestros($prov='',$statusS='',$area='',$calificacion='',$asignados='false', $abogados=0){// utilizado para jtabla siniestros  //?OPTIMIZADO PARA VARIOS USUARIOS
        $sql='';
        if($area!=''){
            $sqlarea = " sa.area ='".$area."' and ";
        }else{
            $sqlarea = "  ";
        }
        $sqlasignados='';
        if($asignados== 'true' ){
            $sqlasignados =' and su.usuario = '.$_SESSION['id'];
        }else {
            if($abogados!=0){
                $abd = $abogados;
                $sqlasignados =' and su.usuario = '.$abogados;
            }
        }
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
            and s.status = '$statusS' ". $sqlcalifica . ' ' .$sqlasignados;
        }else if($prov=='' and $statusS==''){
            $sql.= "select  COUNT(DISTINCT s.timerst) siniestros from siniestros s
            inner JOIN siniestros_areas sa on s.timerst = sa.timerst
            LEFT JOIN siniestros_usuarios su on s.timerst = su.timerst
            where ". $sqlarea ." 1 ". $sqlcalifica . ' ' .$sqlasignados;
        }else if(($prov=='' and $statusS!='') or ($prov!='' and $statusS=='') ){
            $sql.= "select  COUNT(DISTINCT s.timerst) siniestros from siniestros s
            inner JOIN siniestros_areas sa on s.timerst = sa.timerst
            LEFT JOIN siniestros_usuarios su on s.timerst = su.timerst
            where ". $sqlarea;
            if($prov!='')   $sql.= " s.f_numProv = (select id from config_prov where proveniente = '".$prov."' ) and";
            if($statusS!='')$sql.= " s.status = '$statusS' and ";
            $sql.= " 1 ". $sqlcalifica . ' ' .$sqlasignados;
        }

		$query = Database::exeDoIt($sql,false);
		$data=Model::many_assoc($query[0])[0];
		return $data['siniestros'];
	}
    public static function countBusquedaTodosSiniestros($prov='',$statusS='',$area='',$calificacion='',$asignados='false',$asegurado){// utilizado para jtabla siniestros  //?OPTIMIZADO PARA VARIOS USUARIOS
        $sql='';
        if($area!=''){
            $sqlarea = " and sa.area ='".$area."'  ";
        }else{
            $sqlarea = "  ";
        }
        $sqlasignados='';
        if($asignados== 'true' ){
            $sqlasignados =' and su.usuario = '.$_SESSION['id'];
        }
        if ($calificacion!=''){
            $sqlcalifica= ' and s.calificacion = '.$calificacion .' ';
        }else{$sqlcalifica=' '; }
		if($prov!='' and $statusS!=''){
            // $sql= "select count(s.id) siniestros from siniestros s
            $sql= "select  COUNT(DISTINCT s.timerst) siniestros from siniestros s
            inner JOIN siniestros_areas sa on s.timerst = sa.timerst
            LEFT JOIN siniestros_usuarios su on s.timerst = su.timerst
            where concat(s.nombre,' ',s.apellidoP,' ',s.apellidoM) like  '%".$asegurado."%' ". $sqlarea." 
            and s.f_numProv = (select id from config_prov where proveniente = '".$prov."' )
            and s.status = '$statusS' ". $sqlcalifica . ' ' .$sqlasignados;
        }else if($prov=='' and $statusS==''){
            $sql.= "select  COUNT(DISTINCT s.timerst) siniestros from siniestros s
            inner JOIN siniestros_areas sa on s.timerst = sa.timerst
            LEFT JOIN siniestros_usuarios su on s.timerst = su.timerst
            where concat(s.nombre,' ',s.apellidoP,' ',s.apellidoM) like  '%".$asegurado."%' ". $sqlarea .' '. $sqlcalifica . ' ' .$sqlasignados;
        }else if(($prov=='' and $statusS!='') or ($prov!='' and $statusS=='') ){
            $sql.= "select  COUNT(DISTINCT s.timerst) siniestros from siniestros s
            inner JOIN siniestros_areas sa on s.timerst = sa.timerst
            LEFT JOIN siniestros_usuarios su on s.timerst = su.timerst
            where concat(s.nombre,' ',s.apellidoP,' ',s.apellidoM) like  '%".$asegurado."%' ";
            $sql .=  $sqlarea;
            if($prov!='')   $sql.= " and s.f_numProv = (select id from config_prov where proveniente = '".$prov."' ) and";
            if($statusS!='')$sql.= " and s.status = '$statusS' and ";
            $sql.= " 1 ". $sqlcalifica . ' ' .$sqlasignados;
        }

		$query = Database::exeDoIt($sql,false);
		$data=Model::many_assoc($query[0])[0];
		return $data['siniestros'];
	}
    public static function getBusquedaTodosSiniestros($orden,$limitInf,$limitSup,$_prov='',$_status='',$area, $calificacion='', $asignados=false,$asegurado){// utilizado para jtabla siniestros admin
        $sql="SELECT s.id,concat(s.nombre,' ',s.apellidoP,' ',s.apellidoM) nombre, s.timerst, s.activo, concat(f_numProv,'-',LPAD(f_consecutivo,3,'0'),'-',SUBSTRING(f_year, 3)) folio, SUBSTRING(UPPER(proveniente),6) proveniente, c.valor as institucion, cel,casa,oficina, fechaReporte,estado,ciudad,mail,formaContacto,descripcionHechos,numReporte,NumPoliza,numSiniestro,vigencia1,vigencia2,cs.valor calificacion,cc.valor autoridad,css.valor `status` ,fechaAsignacion,if(pa.primera_atencion<>'','si','no') as primera_atencion, if(ip.informe_preliminar<>'','si','no') as informe_preliminar,if(ic.informe_cancelacion<>'','si','no') as informe_cancelacion, fechaCaptura 
        ,su.usuario idUserAsign , su.estatus statusUserAsign
        FROM siniestros as s ";//siniestros
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

        $sql.= " and concat(s.nombre,' ',s.apellidoP,' ',s.apellidoM) like  '%".$asegurado."%' ";

        if($_prov!=''  ){ // con prov
            $sql.=" and s.f_numProv = (select prov.id from config_prov prov where proveniente= '".$_prov."' limit 1) ";
        }
        if($_status!=''){ // con status
            $sql.=" and s.status = ".$_status;
        }
        if($asignados== 'true' ){
            $sql.=' and  su.usuario = '.$_SESSION['id'];
        }
        if($calificacion!= '' ){
            $sql.=' and  s.calificacion = '.$calificacion;
        }
        //GROUP BY s.timerst
        $sql.=' GROUP BY s.timerst '. $orden." limit ".$limitInf.",". $limitSup . "  ";
        $query = Database::ExeDoIt($sql,false);//!REPARAR ESTA CONSULTA SQL
        // core::preprint($_status,'status');exit();
        $data = Model::many_assoc($query[0]);
        return $data;
    }
    public static function countBusquedaNumSiniestros($prov='',$statusS='',$area='',$calificacion='',$asignados='false',$NS){// utilizado para jtabla siniestros  //?OPTIMIZADO PARA VARIOS USUARIOS
        $sql='';
        if($area!=''){
            $sqlarea = " and sa.area ='".$area."'  ";
        }else{
            $sqlarea = "  ";
        }
        $sqlasignados='';
        if($asignados== 'true' ){
            $sqlasignados =' and su.usuario = '.$_SESSION['id'];
        }
        if ($calificacion!=''){
            $sqlcalifica= ' and s.calificacion = '.$calificacion .' ';
        }else{$sqlcalifica=' '; }
		if($prov!='' and $statusS!=''){
            // $sql= "select count(s.id) siniestros from siniestros s
            $sql= "select  COUNT(DISTINCT s.timerst) siniestros from siniestros s
            inner JOIN siniestros_areas sa on s.timerst = sa.timerst
            LEFT JOIN siniestros_usuarios su on s.timerst = su.timerst
            where numSiniestro like  '%".$NS."%' ". $sqlarea." 
            and s.f_numProv = (select id from config_prov where proveniente = '".$prov."' )
            and s.status = '$statusS' ". $sqlcalifica . ' ' .$sqlasignados;
        }else if($prov=='' and $statusS==''){
            $sql.= "select  COUNT(DISTINCT s.timerst) siniestros from siniestros s
            inner JOIN siniestros_areas sa on s.timerst = sa.timerst
            LEFT JOIN siniestros_usuarios su on s.timerst = su.timerst
            where numSiniestro like  '%".$NS."%' ". $sqlarea .' '. $sqlcalifica . ' ' .$sqlasignados;
        }else if(($prov=='' and $statusS!='') or ($prov!='' and $statusS=='') ){
            $sql.= "select  COUNT(DISTINCT s.timerst) siniestros from siniestros s
            inner JOIN siniestros_areas sa on s.timerst = sa.timerst
            LEFT JOIN siniestros_usuarios su on s.timerst = su.timerst
            where numSiniestro like  '%".$NS."%' ";
            $sql .=  $sqlarea;
            if($prov!='')   $sql.= " and s.f_numProv = (select id from config_prov where proveniente = '".$prov."' ) and";
            if($statusS!='')$sql.= " and s.status = '$statusS' and ";
            $sql.= " 1 ". $sqlcalifica . ' ' .$sqlasignados;
        }

		$query = Database::exeDoIt($sql,false);
		$data=Model::many_assoc($query[0])[0];
		return $data['siniestros'];
	}
    public static function getBusquedaNumSiniestros($orden,$limitInf,$limitSup,$_prov='',$_status='',$area, $calificacion='', $asignados=false,$NS){// utilizado para jtabla siniestros admin
        $sql="SELECT s.id,concat(s.nombre,' ',s.apellidoP,' ',s.apellidoM) nombre, s.timerst, s.activo, concat(f_numProv,'-',LPAD(f_consecutivo,3,'0'),'-',SUBSTRING(f_year, 3)) folio, SUBSTRING(UPPER(proveniente),6) proveniente, c.valor as institucion, cel,casa,oficina, fechaReporte,estado,ciudad,mail,formaContacto,descripcionHechos,numReporte,NumPoliza,numSiniestro,vigencia1,vigencia2,cs.valor calificacion,cc.valor autoridad,css.valor `status` ,fechaAsignacion,if(pa.primera_atencion<>'','si','no') as primera_atencion, if(ip.informe_preliminar<>'','si','no') as informe_preliminar,if(ic.informe_cancelacion<>'','si','no') as informe_cancelacion, fechaCaptura 
        ,su.usuario idUserAsign , su.estatus statusUserAsign
        FROM siniestros as s ";//siniestros
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

        $sql.= " and numSiniestro like  '%".$NS."%' ";

        if($_prov!=''  ){ // con prov
            $sql.=" and s.f_numProv = (select prov.id from config_prov prov where proveniente= '".$_prov."' limit 1) ";
        }
        if($_status!=''){ // con status
            $sql.=" and s.status = ".$_status;
        }
        if($asignados== 'true' ){
            $sql.=' and  su.usuario = '.$_SESSION['id'];
        }
        if($calificacion!= '' ){
            $sql.=' and  s.calificacion = '.$calificacion;
        }
        //GROUP BY s.timerst
        $sql.=' GROUP BY s.timerst '. $orden." limit ".$limitInf.",". $limitSup . "  ";
        $query = Database::ExeDoIt($sql,false);//!REPARAR ESTA CONSULTA SQL
        // core::preprint($_status,'status');exit();
        $data = Model::many_assoc($query[0]);
        return $data;
    }

    public $temporal_no_existe_relacion=
    "SELECT S.timerst FROM siniestros S WHERE S.timerst 
    NOT IN (
    
        SELECT  s.timerst
    
            FROM siniestros as s  
              
              inner JOIN  siniestros_areas sa on s.timerst = sa.timerst 
              
              GROUP BY s.timerst order BY s.id DESC 
    )";
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

    public static function getTodosSiniestros($orden,$limitInf,$limitSup,$_prov='',$_status='',$area, $calificacion='', $asignados=false, $abogados){// utilizado para jtabla siniestros admin
        $sql="SELECT s.id,concat(s.nombre,' ',s.apellidoP,' ',s.apellidoM) nombre, s.timerst, s.activo, concat(f_numProv,'-',LPAD(f_consecutivo,3,'0'),'-',SUBSTRING(f_year, 3)) folio, SUBSTRING(UPPER(proveniente),6) proveniente, c.valor as institucion, cel,casa,oficina, fechaReporte, s.estado as estado,ciudad,mail,formaContacto,descripcionHechos,numReporte,NumPoliza,numSiniestro,vigencia1,vigencia2,cs.valor calificacion,cc.valor autoridad,css.valor `status` ,fechaAsignacion,if(pa.primera_atencion<>'','si','no') as primera_atencion, if(ip.informe_preliminar<>'','si','no') as informe_preliminar,if(ic.informe_cancelacion<>'','si','no') as informe_cancelacion, fechaCaptura 
        ,su.usuario idUserAsign , su.estatus statusUserAsign
        FROM siniestros as s ";//siniestros
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
        if($_prov!=''  ){ // con prov
            $sql.=" and s.f_numProv = (select prov.id from config_prov prov where proveniente= '".$_prov."' limit 1) ";
        }
        if($_status!=''){ // con status
            $sql.=" and s.status = ".$_status;
        }
        if($asignados== 'true' ){
            $sql.=' and  su.usuario = '.$_SESSION['id'];
        } else {
            if($abogados!=0){
                $abd = $abogados;
                $sql.=' and  su.usuario = '.$abogados;
            }
        }

        if($calificacion!= '' ){
            $sql.=' and  s.calificacion = '.$calificacion;
        }
        //GROUP BY s.timerst
        $sql.=' GROUP BY s.timerst '. $orden." limit ".$limitInf.",". $limitSup . "  ";
        $query = Database::ExeDoIt($sql,false);//!REPARAR ESTA CONSULTA SQL
        //echo $sql; die();
        // core::preprint($_status,'status');exit();
        $data = Model::many_assoc($query[0]);
        return $data;
    }

    public static function getTodosSiniestrosOLD($orden,$limitInf,$limitSup,$_prov='',$_status='',$area, $calificacion='', $asignados=false){// utilizado para jtabla siniestros admin
        $sql="SELECT s.id,concat(s.nombre,' ',s.apellidoP,' ',s.apellidoM) nombre, s.timerst, s.activo, concat(f_numProv,'-',LPAD(f_consecutivo,3,'0'),'-',SUBSTRING(f_year, 3)) folio, SUBSTRING(UPPER(proveniente),6) proveniente, c.valor as institucion, cel,casa,oficina, fechaReporte,estado,ciudad,mail,formaContacto,descripcionHechos,numReporte,NumPoliza,numSiniestro,vigencia1,vigencia2,cs.valor calificacion,cc.valor autoridad,css.valor `status` ,fechaAsignacion,if(pa.primera_atencion<>'','si','no') as primera_atencion, if(ip.informe_preliminar<>'','si','no') as informe_preliminar,if(ic.informe_cancelacion<>'','si','no') as informe_cancelacion, fechaCaptura 
        ,su.usuario idUserAsign , su.estatus statusUserAsign
        FROM siniestros as s ";//siniestros
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
        $sql.=' GROUP BY s.timerst '. $orden." limit ".$limitInf.",". $limitSup . "  ";
        $query = Database::ExeDoIt($sql,false);//!REPARAR ESTA CONSULTA SQL
        // core::preprint($_status,'status');exit();
        $data = Model::many_assoc($query[0]);
        return $data;
    }

    /**************************************
     ** FORMATOS DESCARGAR EXCEL by sql query -> jsontoXLSX
     *************************************/


    ///DESCARGAR EXCEL admin
    public static function getTodosSiniestrosDownloadExcel($orden,$limitInf,$limitSup,$_prov='',$_status='',$area, $calificacion='', $asignados=false){// utilizado para jtabla siniestros admin
        $sql="SELECT s.id Num,concat(s.nombre,' ',s.apellidoP,' ',s.apellidoM) nombre, s.timerst, s.activo, concat(f_numProv,'-',LPAD(f_consecutivo,3,'0'),'-',SUBSTRING(f_year, 3)) id, SUBSTRING(UPPER(proveniente),6) proveniente, c.valor as institucion, cel,casa,oficina, fechaReporte,estado,ciudad,mail,formaContacto,descripcionHechos,numReporte,sp.poliza NumPoliza,numSiniestro,vigencia1,vigencia2,cs.valor calificacion,cc.valor autoridad,css.valor `status` ,fechaAsignacion,if(pa.primera_atencion<>'','si','no') as primera_atencion, if(ip.informe_preliminar<>'','si','no') as informe_preliminar,if(ic.informe_cancelacion<>'','si','no') as informe_cancelacion, fechaCaptura 
        ,su.usuario idUserAsign , su.estatus statusUserAsign
        FROM siniestros as s ";//siniestros
        $sql.= " inner JOIN siniestros_areas sa on s.timerst = sa.timerst";
        $sql.= " LEFT JOIN siniestros_usuarios su on s.timerst = su.timerst";
        $sql.= " LEFT JOIN siniestros_primera_atencion as pa on s.timerst = pa.timerst ";
        $sql.= " LEFT JOIN siniestros_informe_preliminar as ip on s.timerst = ip.timerst ";
        $sql.= " LEFT JOIN siniestros_informe_cancelacion as ic on s.timerst = ic.timerst ";
        $sql.= " LEFT JOIN config_campos c on s.institucion = c.id ";
        $sql.= " LEFT JOIN config_campos cc on s.autoridad = cc.id ";
        $sql.= " LEFT JOIN config_campos cs on s.calificacion= cs.id ";
        $sql.= " LEFT JOIN config_campos css on s.status= css.id ";
        $sql.= " LEFT JOIN siniestros_polizas sp on s.status= sp.id ";
        $sql.= " WHERE ";
        if($area==''){
            $sql.= "  1 ";
        }else{
            $sql.= " sa.area = ".$area;
        }
        if($_prov!=''  ){ // con prov
            $sql.=" and s.f_numProv = (select prov.id from config_prov prov where proveniente= '".$_prov."' limit 1) ";
        }
        if($_status!=''){ // con status
            $sql.=" and s.status = ".$_status;
        }
        if($asignados== 'true' ){
            $sql.=' and  su.usuario = '.$_SESSION['id'];
        }
        if($calificacion!= '' ){
            $sql.=' and  s.calificacion = '.$calificacion;
        }
        //GROUP BY s.timerst
        $sql.=' GROUP BY s.timerst '. $orden."   ";  //limit ".$limitInf.",". $limitSup . "
        $query = Database::ExeDoIt($sql,false);//!REPARAR ESTA CONSULTA SQL
        // core::preprint($_status,'status');exit();
        $data = Model::many_assoc_excel($query[0]);
        return $data;
    }

    // DESCARGAR EXCEL gmx
    public static function getTodosSiniestrosDownloadExcelGMX($orden,$limitInf,$limitSup,$_prov='',$_status='',$area, $calificacion='', $asignados=false){// utilizado para jtabla siniestros admin
        $sql="SELECT 
        concat(f_numProv,'-',LPAD(f_consecutivo,3,'0'),'-',SUBSTRING(f_year, 3)) ID, s.id 'N°.' , numSiniestro SINIESTRO, numReporte,
        concat(s.nombre,' ',s.apellidoP,' ',s.apellidoM) ASEGURADO, tercero TERCERO, s.nicho NICHO, s.fechaReporte AS 'FECHA DE SINIESTRO', s.fechaAsignacion AS 'FECHA ASIGNACIÓN', s.descripcionHechos,
        s.estado 'ENTIDAD FEDERATIVA', s.tipoIntervencion 'TIPO DE INTERVENCIÓN', s.materia MATERIA, cc.valor AUTORIDAD, s.expediente EXPEDIENTE, 
        CONCAT('https://claimsmanager.online/?view=siniestro/ver&param=', s.timerst) LINK,
        SUBSTRING(UPPER(proveniente),6) proveniente, 
        c.valor as institucion, vigencia1,vigencia2,cs.valor calificacion, css.valor `status`
        FROM siniestros as s ";//siniestros
        $sql.= " inner JOIN siniestros_areas sa on s.timerst = sa.timerst";
        $sql.= " LEFT JOIN siniestros_usuarios su on s.timerst = su.timerst";
        $sql.= " LEFT JOIN siniestros_primera_atencion as pa on s.timerst = pa.timerst ";
        $sql.= " LEFT JOIN siniestros_informe_preliminar as ip on s.timerst = ip.timerst ";
        $sql.= " LEFT JOIN siniestros_informe_cancelacion as ic on s.timerst = ic.timerst ";
        $sql.= " LEFT JOIN siniestros_polizas as sp on s.numPoliza = ic.id ";
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
        if($_prov!=''  ){ // con prov
            $sql.=" and s.f_numProv = (select prov.id from config_prov prov where proveniente= '".$_prov."' limit 1) ";
        }
        if($_status!=''){ // con status
            $sql.=" and s.status = ".$_status;
        }
        if($asignados== 'true' ){
            $sql.=' and  su.usuario = '.$_SESSION['id'];
        }
        if($calificacion!= '' ){
            $sql.=' and  s.calificacion = '.$calificacion;
        }
        //GROUP BY s.timerst
        $sql.=' GROUP BY s.timerst '. $orden."   "; //limit ".$limitInf.",". $limitSup . "
        $query = Database::ExeDoIt($sql,false);//!REPARAR ESTA CONSULTA SQL
        // core::preprint($_status,'status');exit();
        $data = Model::many_assoc_excel($query[0]);

        //RESCATAR NUM POLIZAS
        /* $pols = json_decode($idPolizas);
        core::preprint($pols);
        $idPoliza=[];
        foreach($pols as $id){
            $sql="select * from siniestros_polizas where id = '$id' limit 1";
            $query = Database::exeDoIt($sql);
            $idPoliza[] = Model::unsetOne($query[0]);
        } 
        return $idPoliza;
        */
        // core::preprint($idPoliza);





        return $data;
    }
    


}