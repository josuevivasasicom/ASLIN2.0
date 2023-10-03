<?php
/* (
    [action] => recovery
    [email] => erick.leo.malagon@gmail.com
    [key] => AE33
    [pass] => asicom
    [timerst] => aa954312564
) */
// core::preprint($_REQUEST,'$_REQUEST');

if($_REQUEST['email']=='' || $_REQUEST['key']=='' || $_REQUEST['pass']==''){
    header("Location: index.php");
    exit();
}

$r= $_REQUEST;
$sql = "select upr.id keyId, u.id, upr.usuario, u.email 
from usuarios_pas_recovery as upr 
inner join usuarios u on u.id = upr.usuario 
where upr.activo=1 and upr.timerstkey = '".$r['timerst']."' and upr.key = '".$r['key']."'  and u.email = '".$r['email']."' limit 1";
$query = Database::ExeDoIt($sql,false);

if($query[0]->num_rows>=1){
    $u = $query[0]->fetch_assoc();
    //la solicitud para cambiar el password es correcta.
    if ( true == UserData::userRecoveryPasswordChange($u['id'],$_REQUEST['pass'],$u['keyId']) ){
        header("location: ./index.php?recoveryOK=ok");
        print "solicitud corecta";
        exit();
    };
    print "OPS Algo salió mal";
}else{
    print "ACCESO DENEGADO, este link solo se puede usar una vez.   <a href=./?> << REGRESAR</a>";
}