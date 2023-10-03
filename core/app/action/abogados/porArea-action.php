<?php
$idsAreas = json_decode($_REQUEST['areasId']);
$tp = array();
foreach ($idsAreas as $key => $value) {
        $sql= "SELECT u.id,concat(u.nombre,' ',u.paterno, ' ',u.materno) nombre,gu.idArea,
        (select area from areas where areas.id = '$value' ) area, avatar
                FROM `usuarios` u 
                inner join gruposusuario gu on gu.idUsuario = u.id 
                where gu.IdGrupo= 3 and 
                gu.idArea = '$value' ";
                $query = Database::exeDoIt($sql);

        if( $query[0]->num_rows>=1){
            $data=Model::many_assoc($query[0]);
            foreach ($data as $key) {
                $tmp= array(
                    'id' => $key['id'],
                    'nombre' => $key['nombre'],
                    'idArea' => $key['idArea'],
                    'area' => $key['area'],
                    'avatar' => $key['avatar']
                );
                $tp[]=$tmp;
            }
        }else{
            $sql= "select area from areas where areas.id ='".$value."' "; $query = Database::exeDoIt($sql); $data=Model::many_assoc($query[0])[0];
            
            $tmp= array(
                'id' => 0,
                'nombre' => "no hay abogados ",
                'idArea' => 0,
                'area' =>  $data['area'],
                'avatar' => './assets/img/faces/todos.png'
            );
            $tp[]=$tmp;
        }

}
print json_encode($tp);
?>