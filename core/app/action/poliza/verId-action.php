<?php

$idsPolizas = json_decode($_REQUEST['data']);
$tp = array();
foreach ($idsPolizas as $key => $value) {
        $sql= "select * from siniestros_polizas where id= $value";
		$query = Database::exeDoIt($sql);
        if(is_numeric($value)==true and $query[0]->num_rows==1){
            $data=Model::many_assoc($query[0])[0];
            $tmp= array(
                'id' => $data['id'],
                'poliza' => $data['poliza'],
                'reserva' => number_format($data['reserva']),
                'deducible' => number_format($data['deducible']),
                'sumaAsegurada'=> number_format($data['sumaAsegurada']),
            );
        }else{
            $tmp= array(
                'id' => $value,
                'poliza' => "no hay datos"
            );
        }

        $tp[]=$tmp;
}
print json_encode($tp);
?>