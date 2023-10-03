<?php
//? PRIMER ACCION PARA RECUPERAR, VERIFICA INFORMACION Y ENVIA EL EMAIL PARA CONFIRMACION DE PASSWORD
//core::preprint($_REQUEST,'sdf');
if (!isset($_REQUEST['mail'])){
    //error
    print ("Error!");exit();
    // header("Location: ./index.php");
}
$mail = $_REQUEST['mail'];

$sql = "select email,id,nombre from usuarios where email ='".$mail."' limit 1";
$query = Database::ExeDoIt($sql,false);
if($query[0]->num_rows>=1){
    //el usuario existe, se procede con el codigo para restablecer password
    $u = $query[0]->fetch_assoc();
    $timer = core::getMicrotime();
    $fecha = core::getTimeNow();
    $key= core::getKeyPass();
    // core::preprint($u['id']);
    $sql="insert into usuarios_pas_recovery (usuario,fecha,`key`,activo,timerstkey) 
    values(".$u['id'].",'".$fecha."','".$key."',1,'".$timer."')";
    $query = Database::ExeDoIt($sql,false);
    if ($query[0]==1){

        //!FUNCION PARA ENVIAR EMAIL
        $send = Correo::send_recovery_password($u['email'],$u['nombre'],$fecha,$key,$timer);
        if($send == 'EXITO' )
        print("recoveryMail=".$mail."&timerstkey=$timer");
        // redirect by axios on index.php
        // header("Location: ./?recoveryMail=$mail&timerstkey=$timer#");
    }else{
        print "Error! 2";exit();
    }
}else{
    print ("Error! 404");exit();
}