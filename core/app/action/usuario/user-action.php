<?php
// core::preprint($_REQUEST);
parse_str($_REQUEST['data'],$dataUs); 
$du = $dataUs;

// core::preprint($du,'data user');

//? tokeni validation
$tokeni= $du['tokeni'];

function tokeni($tokeni){
    $t = strlen($tokeni)/3; //largo  1
    $tok = substr($tokeni,0,$t);
   return $tok;
}
if($T=tokeni($tokeni)==$_SESSION['id']){
    edity($du);
}else{
    header("location: ./?view=index");
    
}


function edity($du){
    $sql='update usuarios set 
    email = "'.$du["email"].'", 
    nombre = "Lic. '.$du["nombre"].'",
    paterno = "'.$du["paterno"].'",
    materno = "'.$du["materno"].'",
    fechaNacimiento = "'.$du["nacimiento"].'",
    nacionalidad = "'.$du["nacionalidad"].'",
    celular = "'.$du["celular"].'",
    telefono = "'.$du["telefono"].'" ,
    cp = "'.$du["cp"].'" ,
    direccion = "'.$du["direccion"].'" ,
    cedula = "'.$du["cedula"].'" ,
    fechaModificacion = "'.Core::getTimeNow().'"';

    // if($du['avatar']!=''){
    //     $sql.= ' , avatar = "'.$du['avatar'].'" ';
    // }

    $sql.= ' where id = '.$_SESSION['id'];

    $query = Database::ExeDoIt($sql,false);
    if ($query[0]==1){

            // $_SESSION['id']= $du['id']; por seguridad no se edita
            $_SESSION['email']= $du['email'];
            $_SESSION['nombre']= "Lic. ". $du['nombre'];
            $_SESSION['paterno']= $du['paterno'];
            $_SESSION['materno']= $du['materno'];
            // $_SESSION['avatar']= $du['avatar'];

        print "saved DataUser OK";
        exit();
    }else{
        //!error
        core::preprint($sql);
    }


}