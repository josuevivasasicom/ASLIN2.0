<?php
class cambiarParametro{

    // STATUS===================================================
    public static function cambiaStatusByArea($data){
        //?esta funcion cambia el estatus segun el area
        //!debe hacer un algoritmo para validar status del siniestro y el de las otras areas
        $sql = "UPDATE siniestros_areas set `status` = '".$data['isStatus'] ."' where timerst='".$data['timerst']."' and area = ".$data['idArea']." ";
            if ($data['idArea'] == 'principal')
            $sql = "UPDATE siniestros set `status` = '".$data['isStatus'] ."' where timerst='".$data['timerst']."'";
        $query= Database::ExeDoIt($sql,false);
        if($query[0]){
            $area = core::getAreaNombre($data['idArea']);

            $statusString = Folios::obtenerConfigCampoByid($data['isStatus']);

			core::insertHistoricoSiniestros('Actualizado','Se cambio Status a '.$statusString.' by '.$area,$data['timerst'] );//?historico
            print_r("Status cambiado");
            return true;
        }
        return false;
    }


    // CALIFICACION===================================================
    public static function cambiaCalificacionByArea($data){
        //?esta funcion cambia la calificacion segun el area
        //!debe hacer un algoritmo para validar status del siniestro y el de las otras areas
        $sql = "UPDATE siniestros_areas set calificacion = '".$data['isCalificacion'] ."' where timerst='".$data['timerst']."' and area = ".$data['idArea']." ";
            if ($data['idArea'] == 'principal')
            $sql = "UPDATE siniestros set calificacion = '".$data['isCalificacion'] ."' where timerst='".$data['timerst']."'";
        $query= Database::ExeDoIt($sql);
        if($query[0]){
			$area = core::getAreaNombre($data['idArea']);
			core::insertHistoricoSiniestros('Actualizado','Se cambio Calificación por '.$area,$data['timerst'] );//?historico
            print_r("Calificacion cambiada");
            return true;
        }
        
        return false;
    }

    // INSTITUCION======================================================
    public static function cambiaInstitucion($data){
        if ($data['institucion']=='' || empty($data['institucion']) || is_null($data['institucion'])){
            echo "Debes seleccionar un valor valido";
            exit();
        }
        $nuevaInstitucion = $data['institucion'];
        $sqlInt='UPDATE siniestros set institucion ='.$data['institucion'].' where timerst="'.$data['timerst'].'"'; // si el parametro es número
        if (!is_numeric($data['institucion'])){
            //busca institucion por string
            $sql="select id from config_campos where campo ='institucion' and valor ='".trim($data['institucion'])."' limit 1";
            $query= Database::ExeDoIt($sql);
            if (!$query[0]->num_rows){//si no existe la opcion, se agrega
                $sql='INSERT into config_campos (campo,valor,activo) values("institucion","'.trim($data['institucion']).'", 1)'; // si el parametro no es numero, es una nueva opcion que se debe registrar
                $query= Database::ExeDoIt($sql);

                //vuelve a buscar para ob tener el id insertado
                $sql="select id from config_campos where campo ='institucion' and valor ='".trim($data['institucion'])."' limit 1";
                $query= Database::ExeDoIt($sql);
            }
            
            //si existe la opcion, obtiene el id
            $idInst = Model::many_assoc($query[0])[0]['id'];

            $sqlInt='UPDATE siniestros set institucion ='.$idInst.' where timerst="'.$data['timerst'].'"'; // si el parametro es string, se obtiene el id y se inserta

        
        }else{//obtener el nombre de la institucion para el historico
            $sql="select valor from config_campos where campo ='institucion' and id ='".trim($data['institucion'])."' limit 1";
            $query= Database::ExeDoIt($sql);
            $nuevaInstitucion = Model::many_assoc($query[0])[0]['valor'];
        }

        /* var_dump( is_string($data['institucion'] ));
        core::preprint($nuevaInstitucion,'nueva institucion');
        core::preprint($data['institucion'],'nueva $data[institucion]'); */
        
        $query= Database::ExeDoIt($sqlInt,false);//? ejecuta el sqlInt para insertar institucion
        // core::preprint($query[]);
        if($query[0]==1){
            core::insertHistoricoSiniestros('Actualizado','Se cambio Institución por '.trim($nuevaInstitucion) ,$data['timerst'] );//?historico
            print 'Se cambió Institución';
            exit();
        }
        print 'Algo salió mal';
    }

    // AUTORIDAD
    public static function cambiaAutoridad($data){
        if ($data['autoridad']=='' || empty($data['autoridad']) || is_null($data['autoridad'])){
            echo "Debes seleccionar un valor valido";
            exit();
        }
        $nuevaAutoridad = $data['autoridad'];
        $sqlInt='UPDATE siniestros set autoridad ='.$data['autoridad'].' where timerst="'.$data['timerst'].'"'; // si el parametro es número
        if (!is_numeric($data['autoridad'])){
            //busca autoridad por string
            $sql="select id from config_campos where campo ='autoridad' and valor ='".trim($data['autoridad'])."' limit 1";
            $query= Database::ExeDoIt($sql);
            if (!$query[0]->num_rows){//si no existe la opcion, se agrega
                $sql='INSERT into config_campos (campo,valor,activo) values("autoridad","'.trim($data['autoridad']).'", 1)'; // si el parametro no es numero, es una nueva opcion que se debe registrar
                $query= Database::ExeDoIt($sql);

                //vuelve a buscar para ob tener el id insertado
                $sql="select id from config_campos where campo ='autoridad' and valor ='".trim($data['autoridad'])."' limit 1";
                $query= Database::ExeDoIt($sql);
            }
            
            //si existe la opcion, obtiene el id
            $idInst = Model::many_assoc($query[0])[0]['id'];

            $sqlInt='UPDATE siniestros set autoridad ='.$idInst.' where timerst="'.$data['timerst'].'"'; // si el parametro es string, se obtiene el id y se inserta

        
        }else{//obtener el nombre de la autoridad para el historico
            $sql="select valor from config_campos where campo ='autoridad' and id ='".trim($data['autoridad'])."' limit 1";
            $query= Database::ExeDoIt($sql);
            $nuevaAutoridad = Model::many_assoc($query[0])[0]['valor'];
        }

        /* var_dump( is_string($data['autoridad'] ));
        core::preprint($nuevaAutoridad,'nueva autoridad');
        core::preprint($data['autoridad'],'nueva $data[autoridad]'); */
        
        $query= Database::ExeDoIt($sqlInt,false);//? ejecuta el sqlInt para insertar autoridad
        // core::preprint($query[]);
        if($query[0]==1){
            core::insertHistoricoSiniestros('Actualizado','Se cambio Autoridad por '.trim($nuevaAutoridad) ,$data['timerst'] );//?historico
            print 'Se cambió Autoridad';
            exit();
        }
        print 'Algo salió mal';
    }

    //cambiaNombre
    public static function cambiaNombre($data){
        
        $nombre = $data['nombre'];
        $paterno = $data['paterno'];
        $materno = $data['materno'];
        $timer = $data['timerst'];
        $sqlNom='UPDATE siniestros set nombre ="'.$nombre.'", apellidoP="'.$paterno.'", apellidoM="'.$materno.'"where timerst="'.$timer.'"';
       
        $query= Database::ExeDoIt($sqlNom);
        
        if($query[0]==1){
            core::insertHistoricoSiniestros('Actualizado','Se cambio Nombre Asegurado por '.trim($nombre.' '.$paterno.' '.$materno) ,$timer );//?historico
            print 'Se cambió el nombre';
            exit();
        }
        print 'Algo salió mal';
    }

}




//?INIT de la clase
$param = $_REQUEST['modo'];

switch ($param) {
    case 'status':
        cambiarParametro::cambiaStatusByArea($_REQUEST);
        break;

    case 'calificacion':
        cambiarParametro::cambiaCalificacionByArea($_REQUEST);
        break;
    case 'institucion':
        cambiarParametro::cambiaInstitucion($_REQUEST);
        break;
    case 'autoridad':
        cambiarParametro::cambiaAutoridad($_REQUEST);
        break;
    case 'nombre':
        cambiarParametro::cambiaNombre($_REQUEST);
        break;
    default:
        # code...
        break;
}