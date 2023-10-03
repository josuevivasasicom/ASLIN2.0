<?php
class  Asignacion{

    /************************************
     * AREA Y ABOGADO    -->  NUAVA ASIGNACION O RELACION DE ENTIDADES
     ************************************/
    public static function nuevaAsignacion($idAreas,$idAbogados,$timerst){
        //asignar areas
        $jefes=[];
        foreach ($idAreas as $k) {
            $sql ="insert into siniestros_areas(timerst,area,estatus,fecha_creacion) values('".$timerst."',$k,1,'".core::getTimeNow()."')";
            //// PAUDADO 
            Database::ExeDoIt($sql);

            //obtener jefe de las areas
            //?si el area es contabilidad  agrega al contador
            $sql="SELECT idUsuario from gruposusuario where idArea =".$k." and (IdGrupo =2 or IdGrupo = 6) ";
            $ajef = Model::many_assoc(Database::ExeDoIt($sql)[0]);
            foreach ( $ajef as $k) {
                array_push($jefes, $k['idUsuario']);
            }
        }

        //combinar jefes y abogados.
        if (isset($idAbogados) ){
            foreach ($idAbogados as $k) {
                array_push($jefes, $k);
            }
        }

        //asignar abogados
        foreach ($jefes as $k) {
            $sql="INSERT INTO siniestros_usuarios(timerst,usuario,estatus,fecha_creacion) values('".$timerst."', $k , 1,'".core::getTimeNow()."')";
            Database::ExeDoIt($sql);
        }

        //notificar por email
        $emails = [];
        foreach ($jefes as $a) {
            $sql= "SELECT email,concat (nombre,' ',paterno) nombre,id from usuarios where id = $a";
            $query = Database::ExeDoIt($sql);
            $emails = Model::many_assoc($query[0]);
        }        
        $mails = Correo::send_notify_assign_id($timerst,$emails,$idAreas);

        if ($mails)
        print('asignacionesOK');

    }

    public static function nuevoAbogadoAsignado($idAbogados,$timerst){
        //asignar abogados
        foreach ($idAbogados as $k) {
            $sql="INSERT INTO siniestros_usuarios(timerst,usuario,estatus,fecha_creacion) values('".$timerst."', $k , 1,'".core::getTimeNow()."')";
            Database::ExeDoIt($sql);
        }

        //mails
        $emails =[];
        foreach ($idAbogados as $a) {
            $sql= "SELECT email,concat (nombre,' ',paterno) nombre,id from usuarios where id = $a";
            $query = Database::ExeDoIt($sql);
            $emails = Model::many_assoc($query[0]);
        }

        $correo = Correo::send_notify_assign_id($timerst,$emails);

        if ($correo)
        print('asignacionesOK');

    }


    /************************************
     * AREA    -->  ASIGNAR O DESASIGNAR UN AREA DE UN SINIESTRO O ID
     ************************************/
    static public function habilitarArea($modo,$id,$status){
        $sql = "UPDATE siniestros_areas set estatus= ".$status." where id =".$id;
        $query = Database::ExeDoIt($sql);
        if ($query[0]==1){ 

            //si es inactiva, deshabilita y si es activa habiloita abogados.
            // 1 seleccionar id del area, del id de la asignacion
            // 2 traerme todos los usuarios relacionados al siniestro, que sean del area cambiante
            $sql="select area,timerst from siniestros_areas where id = ". $id ." limit 1";
            $query = Database::ExeDoIt($sql,false);
            $data = Model::many_assoc($query[0])[0];//area y timerst que se deshabilita-habilita

            $sql2= "SELECT su.id,su.usuario,gu.idArea from siniestros_usuarios su
            INNER JOIN gruposusuario gu ON gu.idUsuario = su.usuario
            where timerst = '".$data['timerst']."' AND gu.idArea ='".$data['area']."'";
            $query2 = Database::ExeDoIt($sql2,false);
            $data2= Model::many_assoc($query2[0]);

            foreach ($data2 as $k) {
                $sql3="UPDATE siniestros_usuarios set estatus = $status where id = ".$k['id'];
                $query3 = Database::ExeDoIt($sql3,false,false);
            }

            /* foreach ($variable as $i) {
                # cambia status de todos los abogados tambien
                self::habilitarAbogado($modo,$i,$status);
            } */


            print "el área se cambio correctamente";
         }
    }


     /************************************
     * ABOGADO   ---> ASIGNAR O DESASIGNAR UN ABOGADO/USUARIO DE UN SINIESTRO O ID
     ************************************/
    static public function habilitarAbogado($modo,$id,$status,$print=1){
        $sql0 = "UPDATE siniestros_usuarios set estatus= ".$status." where id =".$id;
        $query0 = Database::ExeDoIt($sql0,false);

        //revisar si el area del abogado esta inactiva, y se activa el usuario, el area debe activarse (sin sus demas abogados.)
        if($status == 1 ){//?si se va activar el usuario, revisa el estatus del area
            $sql= "SELECT s.timerst,s.usuario,g.idArea from siniestros_usuarios s 
            inner JOIN gruposusuario g ON g.idUsuario = s.usuario
            WHERE s.id = $id  LIMIT 1";
            $query = Database::ExeDoIt($sql,false);
            $datos = Model::many_assoc($query[0])[0];

            //seleccionar el area
            $sqla="SELECT estatus,id from siniestros_areas where timerst = '".$datos['timerst']."' and area = ".$datos['idArea']." limit 1";
            $query = Database::ExeDoIt($sqla,false);
            $data = Model::many_assoc($query[0])[0];
            if($data['estatus']==0){ //? si el estatus del area es 0, cambialo a 1, por que se habilitara tambin el usuario
                $sql="UPDATE siniestros_areas SET estatus=1 where id = ".$data['id'];
                $query = Database::ExeDoIt($sql,false,false);
            }

        }

        if ($query0[0]==1 && $print!=0){ print "el abogado se cambio correctamente"; }
    }
}


/*
* INICIA CLASE
************************************/
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(1);

//si recibe modo, es que va a crear nueva asignacion
if ($_REQUEST['modo']=='asignarNuevo'){
    Asignacion::nuevaAsignacion($_REQUEST['idArea'],$_REQUEST['idAbogado'],$_REQUEST['timerst']);  //si es neuva asignacion , asigna abogado y area segun el timerst
    exit();
} else if($_REQUEST['modo']=='nuevoAbogadoAsignado'){
    Asignacion::nuevoAbogadoAsignado($_REQUEST['idAbogado'],$_REQUEST['timerst']);  // asigna abogado segun el timerst
    exit();
}

if ($_REQUEST['modo']=='desactivar'){
    $status=0;
} else if ($_REQUEST['modo']=='habilitar'){
    $status=1;
}

//si recibe parametro entidad, va a habiliytar o deshabilitar cualquier entidad.

switch ($_REQUEST['entidad']) {
    case 'area':
        Asignacion::habilitarArea($_REQUEST['modo'],$_REQUEST['idAsignacion'],$status);
        break;

    case 'abogado':
        Asignacion::habilitarAbogado($_REQUEST['modo'],$_REQUEST['idAsignacion'],$status);
        break;

    default:
        print "No tienes permiso";
        break;
}