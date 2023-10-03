<?php
echo "Empieza...";
$adic = "lalo";
//switch ($server = 'claims') {
$server = 'claims';
switch ($server) {

    case 'localhost:8080':
        ////$this->user="alternativo";$this->pass="2r3ckl24n2l";$this->host="localhost";$this->ddbb="u157777947_alternativa";
        $con = new mysqli("localhost:3306", "root", "rosa001206", "u934929740_cma");
        // var_dump($con);
        // die();
        break;
    case 'localhost':
        if ($adic == "lalo") {
            $con = new mysqli("localhost", "root", "", "u934929740_cma");
        } else {
            $con = new mysqli("localhost", "root", "rosa001206", "u934929740_cma");
        }
        $con->set_charset("utf8");

        break;

    default:
        ////$this->user="alternativo";$this->pass="2r3ckl24n2l";$this->host="localhost";$this->ddbb="u157777947_alternativa";
        $con = new mysqli("localhost", "u934929740_cma_us", "eT5]kWoNh", "u934929740_cma");
        $con->set_charset("utf8");
        break;
}

function many_assoc($query)
{
    $cnt = 0;
    $array = [];
    /* echo "<pre>";
    print_r($query);
    echo "<pre>"; */

    while ($r = $query->fetch_assoc()) {
        $array[$cnt] = [];
        $cnt2 = 1;
        foreach ($r as $key => $v) {
            if ($cnt2 > 0) {
                $array[$cnt][$key] = $v;
            }
            $cnt2++;
        }
        $cnt++;
    }
    return $array;
}

$sql = "select distinct concat(s.nombre,' ',s.apellidoP,' ',s.apellidoM) as nombre from siniestros s
        where estado1 = 'A'";

$query = array($con->query($sql)); //!REPARAR ESTA CONSULTA SQL
$data = many_assoc($query[0]);
$x = 0;
$nombre = [];
$reporte = [];
$siniestro = [];
$poliza = [];
$cantidad = [];
$detalle = [];
$leida = [];
foreach ($data as $dato) {
    $sql2 = "SELECT distinct concat(s.nombre,' ',s.apellidoP,' ',s.apellidoM) nombre, s.timerst, s.activo, concat(f_numProv,'-',LPAD(f_consecutivo,3,'0'),'-',SUBSTRING(f_year, 3)) folio, 
        numReporte,NumPoliza,numSiniestro,css.valor `status` 
        FROM siniestros as s 
        inner JOIN siniestros_areas sa on s.timerst = sa.timerst 
        LEFT JOIN siniestros_usuarios su on s.timerst = su.timerst 
        LEFT JOIN siniestros_primera_atencion as pa on s.timerst = pa.timerst 
        LEFT JOIN siniestros_informe_preliminar as ip on s.timerst = ip.timerst 
        LEFT JOIN siniestros_informe_cancelacion as ic on s.timerst = ic.timerst 
        LEFT JOIN config_campos c on s.institucion = c.id and c.estado = 'A' 
        LEFT JOIN config_campos cc on s.autoridad = cc.id and cc.estado = 'A' 
        LEFT JOIN config_campos cs on s.calificacion= cs.id and cs.estado = 'A' 
        LEFT JOIN config_campos css on s.status= css.id and css.estado = 'A' 
        WHERE 1 and s.estado1='A'
        and s.status != 169
        and concat(s.nombre,' ',s.apellidoP,' ',s.apellidoM) = '" . $dato["nombre"] . "'
    group by nombre, timerst";

    $query = array($con->query($sql2)); //!REPARAR ESTA CONSULTA SQL
    //echo $sql; die();
    // core::preprint($_status,'status');exit();
    $data2 = many_assoc($query[0]);
    //echo "*" . count($data2) . "*<br>";
    if (count($data2) > 1) {
        $detalle[$x] = "";
        foreach ($data2 as $dato2) {
            if (strcmp($dato2["status"], "cancelado") == 0) {
                continue;
            } else {
            $nombre[$x] = $dato2["nombre"];
            $reporte[$x] = '';
            $siniestro[$x] = '';
            $poliza[$x] = '';
            $reserva[$x] = "";
            $cantidad[$x] = count($data2);
            $detalle[$x] .= "Folio: " . $dato2["folio"] . " - " . "Estado: " . $dato2["status"] . "<br>";
            $leida[$x] = "N";
            }

        }
        //echo "$x <br>";
        $x++;


    } else {
        continue;
    }
}

$sql_a = "select distinct numReporte from siniestros s
        where estado1 = 'A'";
$query_a = array($con->query($sql_a)); //!REPARAR ESTA CONSULTA SQL
$data_a = many_assoc($query_a[0]);
//$x=0;
//echo "**************************$x**************************<br>";
foreach ($data_a as $dato_a) {


    $sql_b = "SELECT distinct concat(s.nombre,' ',s.apellidoP,' ',s.apellidoM) nombre, s.timerst, s.activo, concat(f_numProv,'-',LPAD(f_consecutivo,3,'0'),'-',SUBSTRING(f_year, 3)) folio, 
        numReporte,NumPoliza,numSiniestro,css.valor `status` 
        FROM siniestros as s 
        inner JOIN siniestros_areas sa on s.timerst = sa.timerst 
        LEFT JOIN siniestros_usuarios su on s.timerst = su.timerst 
        LEFT JOIN siniestros_primera_atencion as pa on s.timerst = pa.timerst 
        LEFT JOIN siniestros_informe_preliminar as ip on s.timerst = ip.timerst 
        LEFT JOIN siniestros_informe_cancelacion as ic on s.timerst = ic.timerst 
        LEFT JOIN config_campos c on s.institucion = c.id and c.estado = 'A' 
        LEFT JOIN config_campos cc on s.autoridad = cc.id and cc.estado = 'A' 
        LEFT JOIN config_campos cs on s.calificacion= cs.id and cs.estado = 'A' 
        LEFT JOIN config_campos css on s.status= css.id and css.estado = 'A' 
        WHERE 1 and s.estado1='A'
        and s.status != 169
        and numReporte = '" . $dato_a["numReporte"] . "'
    group by numReporte, timerst";

    $query_b = array($con->query($sql_b)); //!REPARAR ESTA CONSULTA SQL
    //echo $sql; die();
    // core::preprint($_status,'status');exit();
    $data_b = many_assoc($query_b[0]);

    if (count($data_b) > 1) {
        $detalle[$x] = "";
        foreach ($data_b as $dato_b) {
            if (strcmp($dato_b["status"], "cancelado") == 0) {
                continue;
            } else {
            $nombre[$x] = '';
            $reporte[$x] = $dato_b["numReporte"];
            $siniestro[$x] = '';
            $poliza[$x] = '';
            $reserva[$x] = "";
            $cantidad[$x] = count($data_b);
            $detalle[$x] .= "Folio: " . $dato_b["folio"] . " - " . "Estado: " . $dato_b["status"] . "<br>";
            $leida[$x] = "N";
            }
        }

        //echo "$x <br>";
        $x++;
    } else {
        continue;
    }



}

$sql_c = "select distinct numSiniestro from siniestros s
        where estado1 = 'A'";
$query_c = array($con->query($sql_c)); //!REPARAR ESTA CONSULTA SQL
$data_c = many_assoc($query_c[0]);
//$x=0;
//echo "**************************$x**************************<br>";
foreach ($data_c as $dato_c) {


    $sql_d = "SELECT distinct concat(s.nombre,' ',s.apellidoP,' ',s.apellidoM) nombre, s.timerst, s.activo, concat(f_numProv,'-',LPAD(f_consecutivo,3,'0'),'-',SUBSTRING(f_year, 3)) folio, 
        numReporte,NumPoliza,numSiniestro,css.valor `status` 
        FROM siniestros as s 
        inner JOIN siniestros_areas sa on s.timerst = sa.timerst 
        LEFT JOIN siniestros_usuarios su on s.timerst = su.timerst 
        LEFT JOIN siniestros_primera_atencion as pa on s.timerst = pa.timerst 
        LEFT JOIN siniestros_informe_preliminar as ip on s.timerst = ip.timerst 
        LEFT JOIN siniestros_informe_cancelacion as ic on s.timerst = ic.timerst 
        LEFT JOIN config_campos c on s.institucion = c.id and c.estado = 'A' 
        LEFT JOIN config_campos cc on s.autoridad = cc.id and cc.estado = 'A' 
        LEFT JOIN config_campos cs on s.calificacion= cs.id and cs.estado = 'A' 
        LEFT JOIN config_campos css on s.status= css.id and css.estado = 'A' 
        WHERE 1 and s.estado1='A'
        and s.status != 169
        and numSiniestro = '" . $dato_c["numSiniestro"] . "'
    group by numSiniestro, timerst";

    $query_d = array($con->query($sql_d)); //!REPARAR ESTA CONSULTA SQL
    //echo $sql; die();
    // core::preprint($_status,'status');exit();
    $data_d = many_assoc($query_d[0]);

    if (count($data_d) > 1) {
        $detalle[$x] = "";
        foreach ($data_d as $dato_d) {
            if (strcmp($dato_d["status"], "cancelado") == 0) {
                continue;
            } else {
            $nombre[$x] = '';
            $reporte[$x] = '';
            $siniestro[$x] = $dato_d["numSiniestro"];
            $poliza[$x] = '';
            $reserva[$x] = "";
            $cantidad[$x] = count($data_d);
            $detalle[$x] .= "Folio: " . $dato_d["folio"] . " - " . "Estado: " . $dato_d["status"] . "<br>";
            $leida[$x] = "N";
            }
        }

        //echo "$x <br>";
        $x++;
    } else {
        continue;
    }
}

$sql_e = "select distinct NumPoliza from siniestros s
            where estado1 = 'A'";
$query_e = array($con->query($sql_e)); //!REPARAR ESTA CONSULTA SQL
$data_e = many_assoc($query_e[0]);
//$x=0;
//echo "**************************$x**************************<br>";
foreach ($data_e as $dato_e) {


    $sql_f = "SELECT distinct concat(s.nombre,' ',s.apellidoP,' ',s.apellidoM) nombre, s.timerst, s.activo, concat(f_numProv,'-',LPAD(f_consecutivo,3,'0'),'-',SUBSTRING(f_year, 3)) folio, 
        numReporte,NumPoliza,numSiniestro,css.valor `status` 
        FROM siniestros as s 
        inner JOIN siniestros_areas sa on s.timerst = sa.timerst 
        LEFT JOIN siniestros_usuarios su on s.timerst = su.timerst 
        LEFT JOIN siniestros_primera_atencion as pa on s.timerst = pa.timerst 
        LEFT JOIN siniestros_informe_preliminar as ip on s.timerst = ip.timerst 
        LEFT JOIN siniestros_informe_cancelacion as ic on s.timerst = ic.timerst 
        LEFT JOIN config_campos c on s.institucion = c.id and c.estado = 'A' 
        LEFT JOIN config_campos cc on s.autoridad = cc.id and cc.estado = 'A' 
        LEFT JOIN config_campos cs on s.calificacion= cs.id and cs.estado = 'A' 
        LEFT JOIN config_campos css on s.status= css.id and css.estado = 'A' 
        WHERE 1 and s.estado1='A'
        and s.status != 169
        and NumPoliza = '" . $dato_e["NumPoliza"] . "'
    group by NumPoliza, timerst";

    $query_f = array($con->query($sql_f)); //!REPARAR ESTA CONSULTA SQL
    //echo $sql; die();
    // core::preprint($_status,'status');exit();
    $data_f = many_assoc($query_f[0]);

    if (count($data_f) > 1) {


        $detalle[$x] = "";
        foreach ($data_f as $dato_f) {
            $int = (int) filter_var($dato_f["NumPoliza"], FILTER_SANITIZE_NUMBER_INT);
            if (is_numeric($int)) {
                $sql_f_a = "SELECT id, timerst, poliza, reserva, deducible, coaseguro, sumaAsegurada 
                FROM siniestros_polizas 
                where id = '" . $int . "'
                ";

                $query_f_a = array($con->query($sql_f_a)); //!REPARAR ESTA CONSULTA SQL
                //echo $sql; die();
                // core::preprint($_status,'status');exit();
                $data_f_a = many_assoc($query_f_a[0]);
                $poliza_real = $data_f_a[0]["poliza"];
                if (strcmp($dato_f["status"], "cancelado") == 0) {
                    continue;
                } else {
                    $nombre[$x] = '';
                    $reporte[$x] = '';
                    $siniestro[$x] = '';
                    //$poliza[$x] = $dato_f["NumPoliza"];
                    $poliza[$x] = $poliza_real;
                    $reserva[$x] = "";
                    $cantidad[$x] = count($data_f);
                    $detalle[$x] .= "Folio: " . $dato_f["folio"] . " - " . "Estado: " . $dato_f["status"] . "<br>";
                    $leida[$x] = "N";

                }

            } else {
                continue;
            }
        }
        //echo "$x <br>";
        $x++;
    } else {
        continue;
    }
}

$sql_g = "SELECT id, timerst, poliza, reserva, deducible, coaseguro, sumaAsegurada 
            FROM siniestros_polizas where reserva > 3000000 or reserva > sumaAsegurada;";
$query_g = array($con->query($sql_g)); //!REPARAR ESTA CONSULTA SQL
$data_g = many_assoc($query_g[0]);
//$x=0;
//echo "**************************$x**************************<br>";
foreach ($data_g as $dato_g) {
    $sql_h = "SELECT distinct concat(s.nombre,' ',s.apellidoP,' ',s.apellidoM) nombre, s.timerst, s.activo, concat(f_numProv,'-',LPAD(f_consecutivo,3,'0'),'-',SUBSTRING(f_year, 3)) folio, 
        numReporte,NumPoliza,numSiniestro,css.valor `status` 
        FROM siniestros as s 
        inner JOIN siniestros_areas sa on s.timerst = sa.timerst 
        LEFT JOIN siniestros_usuarios su on s.timerst = su.timerst 
        LEFT JOIN siniestros_primera_atencion as pa on s.timerst = pa.timerst 
        LEFT JOIN siniestros_informe_preliminar as ip on s.timerst = ip.timerst 
        LEFT JOIN siniestros_informe_cancelacion as ic on s.timerst = ic.timerst 
        LEFT JOIN config_campos c on s.institucion = c.id and c.estado = 'A' 
        LEFT JOIN config_campos cc on s.autoridad = cc.id and cc.estado = 'A' 
        LEFT JOIN config_campos cs on s.calificacion= cs.id and cs.estado = 'A' 
        LEFT JOIN config_campos css on s.status= css.id and css.estado = 'A' 
        WHERE 1 and s.estado1='A'
        and s.status != 169
        and NumPoliza = '[" . $dato_g["id"] . "]'
    group by NumPoliza, timerst";

    $query_h = array($con->query($sql_h)); //!REPARAR ESTA CONSULTA SQL
    //echo $sql; die();
    // core::preprint($_status,'status');exit();
    $data_h = many_assoc($query_h[0]);

    if (count($data_h) > 1) {
        $detalle[$x] = "";
        foreach ($data_h as $dato_h) {
            if (strcmp($dato_h["status"], "cancelado") == 0) {
                continue;
            } else {
            $nombre[$x] = '';
            $reporte[$x] = '';
            $siniestro[$x] = '';
            $poliza[$x] = "";
            $reserva[$x] = "Reserva: " . number_format($dato_g["reserva"], 2, ".", ",") . " - Suma Aseg: " . number_format($dato_g["sumaAsegurada"], 2, ".", ",");
            $cantidad[$x] = count($data_h);
            $detalle[$x] .= "Folio: " . $dato_h["folio"] . " - " . "Estado: " . $dato_h["status"] . "<br>";
            $leida[$x] = "N";
            }
        }

        //echo "$x <br>";
        $x++;
    } else {
        continue;
    }

}
/*return
    array(
        'nombre' => $nombre,
        'reporte' => $reporte,
        'siniestro' => $siniestro,
        'poliza' => $poliza,
        'reserva' => $reserva,
        'cantidad' => $cantidad,
        'detalle' => $detalle,
        'leida' => $leida
    );*/

for ($z = 0; $z < count($nombre); $z++) {
    $sql_z = "SELECT id_notificaciones, nombre, reporte, siniestro, poliza, cantidad, detalle, leida, 
            estado, fecha_efectiva, fecha_actualizacion, fecha_registro FROM notificaciones
            where estado = 'A'
            and nombre = '$nombre[$z]'
            and reporte = '$reporte[$z]'
            and siniestro = '$siniestro[$z]'
            and poliza = '$poliza[$z]'
            and cantidad = '$cantidad[$z]'
            and detalle = '$detalle[$z]'";
    $query_z = array($con->query($sql_z)); //!REPARAR ESTA CONSULTA SQL
    $data_z = many_assoc($query_z[0]);
    if (count($data_z) == 0) {
        $sql_z = "INSERT IGNORE INTO `notificaciones` (`nombre`, `reporte`, `siniestro`, `reserva`, `poliza`, `cantidad`, 
                `detalle`) VALUES ('$nombre[$z]', '$reporte[$z]', '$siniestro[$z]', '$reserva[$z]', '$poliza[$z]', 
            '$cantidad[$z]', '$detalle[$z]')";
        $con->query($sql_z);
        echo "insertado<br>";
    } else {
        echo "ignorado<br>";
    }
}
?>