<?php
$v = "%3Cp%3E%3Cstrong%3E2022-05-13+04%3A13%3A08%3C%2Fstrong%3E%3C%2Fp%3E%0A%0A%3Cp%3E%3Cstrong%3EDescripci%26oacute%3Bn+de+los+hechos%3A%26nbsp%3B%3C%2Fstrong%3E%3Cbr+%2F%3E%0A%3Cbig%3ELic.+Luis+Alberto+Mart%26iacute%3Bnez+Garc%26iacute%3Ba+%26nbsp%3B+%26nbsp%3B+%26nbsp%3B+%26nbsp%3B%2F+%26nbsp%3B%26nbsp%3B%26nbsp%3B%26nbsp%3B+Lic.+Mario+Aguilar+Guajardo.%3C%2Fbig%3E%3C%2Fp%3E%0A%0A%3Cp%3E...%3C%2Fp%3E%0A%0A%3Cp%3EAgradeciendo+su+atenci%26oacute%3Bn%2C+me+reitero+a+sus+%26oacute%3Brdenes+para+cualquier+duda+o+aclaraci%26oacute%3Bn.%3Cbr+%2F%3E%0A%3Cbr+%2F%3E%0AA+T+E+N+T+A+ME+N+T+E%3Cbr+%2F%3E%0ALic.+Lic.+Mar%26iacute%3Ba+Teresa%3C%2Fp%3E%0A";
core::preprint($v);
$temp = urldecode($v);
core::preprint($temp,'sin urlencode');
$temp = iconv('UTF-8', 'ASCII//TRANSLIT', $temp);
core::preprint($temp,'sin utf8');
$temp = strip_tags($temp);
core::preprint($temp,'sin striptagsHTML');
$temp = htmlspecialchars_decode($temp);
$temp = html_entity_decode($temp);

core::preprint($temp,'sin htmlspecialchars_decode');
$array[$cnt][$key] = $temp;




                        exit();

$d = Siniestros::getStatusByArea('1652433546.6882',2);

core::preprint($d);exit();

$sql="SELECT S.timerst FROM siniestros S WHERE S.timerst 
NOT IN (

    SELECT  s.timerst

        FROM siniestros as s  
          
          inner JOIN  siniestros_areas sa on s.timerst = sa.timerst 
          
          GROUP BY s.timerst order BY s.id DESC 
)";
$query= Database::ExeDoIt($sql);
$data = Model::many_assoc($query[0]);
core::preprint($data);
exit();
//!NO EJECUTAR NUNCA, enlaza siniestros al area de siniestros
/* foreach ($da4ta as $key) {
    core::preprint($key['timerst']);
    $sql="Insert into siniestros_areas(area,timerst,estatus,fecha_creacion) values(3,'".$key['timerst']."',1,'".Core::getTimeNow()."')";
    $query = Database::ExeDoIt($sql);
} */
exit();


$opciones = [ 'cost' => 12 ];
$hash = password_hash('asicom', PASSWORD_BCRYPT, $opciones);
print_r($hash);
core::preprint($hash,'hash');

core::preprint($_SESSION,'alksdhkjsadhkjasd');
exit();

core::preprint(UserData::getPerfil(),'unica funcion');


$dime = explode('/',$_SESSION['grupo'][0])[1];
core::preprint($dime);

core::preprint($_SESSION);exit();
//Thank you for signing up for ".$hotel."!
$link__pdf="";

$opciones = [ 'cost' => 12 ];
			$hash = password_hash('asicom', PASSWORD_BCRYPT, $opciones);
			print_r($hash);
            core::preprint($hash,'hash');

core::preprint($_SESSION,'session');




$abogados=Folios::obtenerAbogados();

foreach ($abogados as $key => $value) {
  print "<span value='".$value->nombre."'>".strtoupper($value->nombre)."</span>";
}

core::preprint($abogados);


exit();






                    $sql2 = "select a.area,g.grupo from gruposusuario gu left join areas a on gu.idArea=a.id inner join grupo g on gu.idGrupo =g.id where gu.idUsuario = ". $_SESSION['id'];
                    $query2 = Database::exeDoIt($sql2);
                    $areasUserSql=Model::many_assoc($query2[0]);
                    
                    $areasTemp=[];
                    foreach ($areasUserSql as $key => $value) {
                        $areasTemp[]=$value['area']."/".$value['grupo'];
                        
                    }
                    //$_SESSION['grupo']= $areasTemp;

                    //core::preprint($areasTemp,'areasTemp');
                    core::preprint($_SESSION,'sesion');
                    exit();



                    $sql3="select g.grupo from gruposusuario gu left join grupo g on gu.idGrupo=g.id where gu.idUsuario = ". $_SESSION['id'];
                    $query3 = Database::exeDoIt($sql3);
                    $gruposUserSql=Model::many_assoc($query3[0]);
                    $grupoTemp=[];
                    foreach ($gruposUserSql as $key => $value) {
                        $grupoTemp[]=$value['grupo'];
                    }
                    //$_SESSION['grupo']= $grupoTemp;

                    

echo "nada aqui";
echo "ya esta en modo prod";
echo "nada aqui";
/*  Pruebas::send_result_test_prueba('CRT7561') */;


core::preprint(Core::getTimeStamp(),'timeStamp');
core::preprint(Core::getTimeStamp('2021-09-24 17:27:45'),'timeStamp2');


$sql="select id from compras where id_venta = '1632587776'  and producto = 49 and title like 'chile';";
$sql="select * from compras where id_venta = '1632587776' and title = '%chile%';";
$query = Database::ExeDoIt($sql);
core::preprint($query);
core::preprint($query[0]->num_rows);

if($query[0]->num_rows>1)
echo "es mayor";



?>