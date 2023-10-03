<?php

class InformePreliminar{
    //pone la plantilla con los datos del siniestro 
    public static function guardarInformePreliminar($timerst,$data){
        Siniestros::guardarInformePreliminar($timerst,$data);
    }

    public static function segundaPartePreliminar($data){
        Siniestros::segundaPartePreliminar($data);
    }

    //carga todo el contenido de la plantilla solo lectura.
    public static function verInformePreliminar($timerst,$area){
        Siniestros::verInformePreliminar($timerst,$area);
    }

    
    public static function remplacepreliminar($timerst,$area){
        
            //obtener versión de formato.
            $sqlv= "SELECT version from siniestros_files where timerst='".$data['timerst']."' and nombre='informePreliminar' and estatus = 1  and area='".$data['areaID']."' order by id desc limit 1;";
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
   
          
   
           //insertar para mostrar file del informe en docs
           $sql = "INSERT INTO siniestros_files (timerst,nombre,id_config_files,`url`,fecha,`version`,area)
           VALUES('".$data['timerst']."','informePreliminar',0,'Documentos GMX','".core::getTimeNow()."',$version,'".$data['areaID']."') ";
           $query = Database::ExeDoIt($sql);
   
           //crear entrada bitacora
           include "./core/app/action/siniestro/bitacora-action.php";
           Siniestros::nuevaEntradaBitacora(array('timerst'=>$data['timerst'],'nuevaEntrada'=>'Se carga el Informe Preliminar revisión: '.$version.' / '.$data['bitacora'],'horasBitacora'=>$data['horas'],'area'=>$data['areaID']));
   
           //historico siniestros
           core::insertHistoricoSiniestros('Actualización','Informe Preliminar '.$data['areaID'].' revisión: '.$version,$data['timerst']);
   
           if($query) print "informe preliminar guardada OK";
    }

    //esta funcion debe traer los datos del ultimo preliminar cargdo para rellenar el formulario de editar preliminar segunda parte.
    public static function rellenaForm($r){
        $sql="select * from siniestros_informe_preliminar_form where timerst='".$r['timerst']."' and area = '".$r['area']."' and folio = '".$r['folio']."' order by rev DESC LIMIT 1";
        $query = Database::ExeDoIt($sql,false);
        $sqlP = "select pa.fecha_creacion fecha from siniestros_primera_atencion pa where pa.timerst='1657216859.9512' order pa.rev desc limit 1";
        $queryP = Database::ExeDoIt($sqlP);

        if ($query[0]->num_rows==1){
            $data = Model::many_assoc($query[0])[0];
            $data['hechos'] = urldecode($data['hechos']);
            $data['observaciones'] = urldecode($data['observaciones']);
            if (isset($queryP[0]->num_rows) && $queryP[0]->num_rows==1){ // si query existe comprueba si tambien exciste el queryP
                $dataP = Model::many_assoc($queryP[0])[0];
                $data['fecha1raAtencionSN'] = urldecode($dataP['fecha']);
            }
        $r= json_encode(array('modo'=>'preliminar form','data'=>$data));
        }else{
        $r= json_encode(array('modo'=>'primer formato','data'=>[]));
        }
        print $r;
        //retorna el preliminar en modo json.
    }
}// end class


/************************************
 * ACTIVACION DE LA CLASE INFORME PRELIMINARSEGUN LOS PARAMETROS.
 ************************************/

//si existe timers va a colocar la plantilla nueva DEL INFORME PRELIMINAR
if(isset($_REQUEST['guardar']) and $_REQUEST['guardar']!=''){
    InformePreliminar::guardarInformePreliminar($_REQUEST['guardar'],$_REQUEST['data']);
}
else
//si no existe y solo trae VER con su respectivo timerst entonces solo carga el contenido para verlo en solo lectura.
if(isset($_REQUEST['ver']) and $_REQUEST['ver']!=''){
    InformePreliminar::verInformePreliminar($_REQUEST['ver'],$area);
}
else // este es si se llena la segunda parte del informe preliminar
if(isset($_REQUEST['segundaParte']) and $_REQUEST['segundaParte']=='informePreliminar'){
    
    InformePreliminar::segundaPartePreliminar($_REQUEST);
}
else
if(isset($_REQUEST['rellenaForm']) and $_REQUEST['rellenaForm']=='informePreliminar'){
    InformePreliminar::rellenaForm($_REQUEST);
}
else

if(isset($_REQUEST['remplace']) and $_REQUEST['remplace']!=''){
    InformePreliminar::remplacepreliminar($_REQUEST['remplace'],$area);
}

