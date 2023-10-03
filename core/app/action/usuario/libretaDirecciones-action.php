<?php 
class LibretaDirecciones {
    
    //? ret0orna todos los mails que son por default del listado general.
    public static function getMailsGeneralDefault(){
        $sql="SELECT * from libretadirecciones where general = 1";
        $query= Database::ExeDoIt($sql);
        $data = Model::many_assoc($query[0]);
        return $data;
    }

    //? Trae toda la libreta del usuario mas los defaults
    public static function getLibretaByUser($req,$callback=0){
        //$defaultsMAils = self::getMailsGeneralDefault();

        $sql = "SELECT ld.id,ld.nombre,ld.email,ld.empresa,ld.id idlist,(if(rlu.`default` IS NULL,ld.important,rlu.default) ) important
        FROM libretadirecciones ld 
        LEFT JOIN relacion_libreta_usuarios rlu on ld.id = rlu.id_libreta 
        WHERE  ld.`general` = 1 OR (rlu.id_usuario = ".$_SESSION['id']." and ld.general = 1) group by ld.email  order by ld.id ";
        $query = Database::ExeDoIt($sql,false);
        $data= Model::many_assoc($query[0]);
        if($callback!=0){
            return $data;
            exit();
        }
        print json_encode($data);
    }

    //?traer datos para tabla
    public static function getTABLALibretaByUser(){
        $R = $_REQUEST;
        $limitSup = $_REQUEST["jtPageSize"]??25; //registros por página
        $limitInf = $_REQUEST["jtStartIndex"]??0; // número de página * (registros por página)
        $pageView = $R['pageView']??1;
        $orden = 'order by '.($R['jtSorting']??' id ASC ');
    
        //? cuenta todos
        $sql = "SELECT count(ld.email) total
        FROM libretadirecciones ld 
        LEFT JOIN relacion_libreta_usuarios rlu on ld.id = rlu.id_libreta 
        WHERE  ld.`general` = 1 OR (rlu.id_usuario = ".$_SESSION['id']." and ld.general = 1) group by ld.email ";
        $query = Database::ExeDoIt($sql,false);
        $query_total = count(Model::many_assoc($query[0]));  //?devuelve un string con el número

        //? trae todos
        $sql = "SELECT ld.id,ld.nombre,if(ld.telefono=0,'ninguno',ld.telefono) telefono,ld.email,ld.empresa,ld.id idlist,(if(rlu.`default` IS NULL,ld.important,rlu.default) ) important
        FROM libretadirecciones ld 
        LEFT JOIN relacion_libreta_usuarios rlu on ld.id = rlu.id_libreta 
        WHERE  ld.`general` = 1 OR rlu.id_usuario = ".$_SESSION['id']." group by ld.email  $orden limit $limitInf,$limitSup ";
        $query = Database::ExeDoIt($sql,false);
        $todos= Model::many_assoc($query[0]);

        //? Actualiza valores.
        $paginas = round($query_total /  $limitSup);
        $result['TotalRecordCount']= $query_total;
        $result['rowTotal']= $query_total;
        $result['pages']= $paginas;
        $result['jtStartIndex']= $limitInf *  $pageView;
        $result['jtPageSize']=  $limitSup;
    
      
        //? Trae todos los siniestros
        //todos
            $libretadirecciones = $todos; //todos los contactos
    
            //obtener datos 
    
        $jTableResult = array();
        $jTableResult['Result'] = "OK";
        $jTableResult['data'] = "Lista de todos los contactos";
        $jTableResult['TotalRecordCount'] = $query_total;
        $jTableResult['Records'] = $libretadirecciones;
        print json_encode($jTableResult);
    }

    //? editar contacto de lista global y ponderar importancia en lista relacionada por usuario 
    public static function editContact($r){
        $sql="update libretadirecciones set nombre='".$r['nombre']."'  , empresa='".$r['empresa']."'  , telefono='".$r['telefono']."'  where id =".$r['id'];
        $query=Database::ExeDoIt($sql);
        if($r){
            $sql="select id from relacion_libreta_usuarios rlu where rlu.id_usuario=".$_SESSION['id']." and rlu.id_libreta =".$r['id']." limit 1";
            $query=Database::ExeDoIt($sql,true);
            if(isset($query[0]) && $query[0]->num_rows==1){ // si es 1 quiere decir que existe realacion
                $idRelacion = Model::many_assoc($query[0])[0]['id'];
                
                $sql= "update relacion_libreta_usuarios set `default` ='".$r['important']."' where id = ".$idRelacion;
                $query=Database::ExeDoIt($sql,true);
                print "ok";
                exit();
            }else{ // quiere decir que no existe la relacion y debe ser creada
                $sql= "insert into relacion_libreta_usuarios(`default`,id_usuario,id_libreta)
                values(".$r['important'].",".$_SESSION['id'].",".$r['id'].")";
                $query = Database::ExeDoIt($sql,true);
                print "ok";
                exit();
            }

        }
    }

}

if(!isset($_REQUEST['method']) ){
exit();
}

switch ($_REQUEST['method']) {
    case 'byuserid/ver':
        # ver toda la libreta por usuario
        LibretaDirecciones::getLibretaByUser($_REQUEST);
        break;

    case 'byuserid/ver/tabla':
        # ver toda la libreta por usuario
        LibretaDirecciones::getTABLALibretaByUser($_REQUEST);
        break;

    case 'editContacList':
        #editar contacto de lista general y ponderarlo en lista relacionada por id del sesseion o usuario activo
        LibretaDirecciones::editContact($_REQUEST);
        break;

    default:
        # code...
        break;
}