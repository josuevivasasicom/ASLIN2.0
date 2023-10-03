<?php

class Datos
{

    //CREAR UNA NUEVA ENTRADA EN LA BOTACORA
    public static function traer($r)
    {
        //$r["metodo"];
        $array = array();
        $object = new stdClass();
        //print_r($r);
        /*$param1 = $sn['timerst'];
        $param2 =  $area;*/
        $param1 = $r["param1"];
        $param2 = $r["param2"];
        $sn['timerst'] = $param1;
        $files_sn = Siniestros::verArchivosdelSiniestro($param1, $param2);
        if (count($files_sn) >= 1) {
            $col = "";
            $render = 'no';
            foreach ($files_sn as $k) {
                $instancia_procedimiento = "";
                $etapa = "";
                $nombre_documento = "";
                $version = "";
                $fecha = "";
                $ver = "";
                switch ($k['nombre']) {
                    case 'primeraAtención':
                    case 'primeraAtencion':
                        $k['c3'] = 'DOCUMENTOS GMX';
                        $k['c2'] = 'Documentos';
                        $k['c1'] = 'Primera Atención';
                        $render = 'si';
                        break;
                    case 'informePreliminar':
                        $k['c3'] = 'DOCUMENTOS GMX';
                        $k['c2'] = 'Documentos';
                        $k['c1'] = 'Informe Preliminar';
                        $render = 'si';
                        break;
                    case 'informeActualización':
                    case 'informeActualizacion':
                        $k['c3'] = 'DOCUMENTOS GMX';
                        $k['c2'] = 'Documentos';
                        $k['c1'] = 'Informe Actualización';
                        $render = 'si';
                        break;
                    case 'informeCancelación':
                    case 'informeCancelacion':
                        $k['c3'] = 'DOCUMENTOS GMX';
                        $k['c2'] = 'Documentos';
                        $k['c1'] = 'Informe Cancelación';
                        $render = 'si';
                        break;
                    default:
                        $render = 'neeeel';
                        break;
                }
                if ($render == 'si') { //check para generar link, si es formato gmx no lo genera.
                    $nomAreaFile = $r["param3"];
                    if ($r["param3"] == 'ServidoresPúblicos')
                        $nomAreaFile = 'Servidores Publicos'; //quitar acento
                    // $col.='<td> </td>';/**************************************g*********************************************************************************************]/

                    // ./?action=pdf/viewFileF&timerst=1656410865.3246&doc=primeraAtencion&areaNombre=Civil&v=01  iframe ok
                    //$col.='<td><input class="form-input" type="checkbox" value="'.'https://'.'claimsmanager.online/?action=pdf/viewFileF&timerst='.$sn['timerst'].'&doc='.$k['nombre'].'&areaNombre='.$nomAreaFile.'&v='.$k['version'].'" data-name="'.$k['nombre'].' - rev '.$k['version'].'" id="check_'.$k['id'].'"> </td>';
                    $blanco = '<input class="form-input" type="checkbox" value="' . 'https://' . 'claimsmanager.online/?action=pdf/viewFileF&timerst=' . $sn['timerst'] . '&doc=' . $k['nombre'] . '&areaNombre=' . $nomAreaFile . '&v=' . str_pad($k['version'], 2, '0', STR_PAD_LEFT) . '" data-name="' . $k['c1'] . ' - rev ' . str_pad($k['version'], 2, '0', STR_PAD_LEFT) . '" id="check_' . $k['id'] . '">';
                } else {
                    //$col.='<td> <input class="form-input" type="checkbox" value="'.$k['url'].'" data-name="'.$k['nombre'].' - rev '.$k['version'] .'" id="check_'.$k['id'].'"> </td>';
                    $blanco = '<input class="form-input" type="checkbox" value="' . $k['url'] . '" data-name="' . $k['c1'] . ' - rev ' . str_pad($k['version'], 2, '0', STR_PAD_LEFT) . '" id="check_' . $k['id'] . '">';
                }

                $instancia_procedimiento = $k['c3'];
                $etapa = $k['c2'];
                $nombre_documento = $k['c1'];
                $version = str_pad($k['version'], 2, '0', STR_PAD_LEFT);
                $fecha = $k['fecha'];
                if ($render == 'si') { //necesita renderizar documento,
                    $ver = '<button onclick="vierFileF(true, \'' . $r["param3"] . '\'  , \'' . $sn['timerst'] . '\'  ,\'' . $k['nombre'] . '\',  \'' . $k['c1'] . '\' , \'' . $k['id'] . '\' , \'' . str_pad($k['version'], 2, '0', STR_PAD_LEFT) . '\'  , \'' . $k['c1'] . '\' ,\'' . $k['c2'] . '\' ,\'' . $k['c3'] . '\'  )" class="btn btn-small btn-outline-primary" data-toggle="modal" data-target="#modalFileView"><i class="fa fa-eye" aria-hidden="true"></i> </button> <button onclick="delFileF('.$k['id'].', '.$sn['timerst'].', \''.$k['nombre'].'\')" class="btn btn-small btn-outline-danger" data-toggle="modal" data-target="#modalFileDel"><i class="fa fa-trash" aria-hidden="true"></i> </button>';
                } else {
                    //no necesita renderizar, baja el archivo tal cual
                    $ver = '<button onclick="vierFileF(false, \'' . $r["param3"] . '\'  , \'' . $sn['timerst'] . '\'  ,\'' . $k['url'] . '\',  \'' . $k['c1'] . '\' , \'' . $k['id'] . '\' , \'' . str_pad($k['version'], 2, '0', STR_PAD_LEFT) . '\'  , \'' . $k['c1'] . '\' ,\'' . $k['c2'] . '\' ,\'' . $k['c3'] . '\' )" class="btn btn-small btn-outline-primary" data-toggle="modal" data-target="#modalFileView"><i class="fa fa-eye" aria-hidden="true"></i> </button> <button onclick="delFileF('.$k['id'].', '.$sn['timerst'].', \''.$k['nombre'].'\')" class="btn btn-small btn-outline-danger" data-toggle="modal" data-target="#modalFileDel"><i class="fa fa-trash" aria-hidden="true"></i> </button>';
                }

                $arrayg = array(
                    "blanco" => $blanco,
                    "instancia_procedimiento" => $instancia_procedimiento,
                    "etapa" => $etapa,
                    "nombre_documento" => $nombre_documento,
                    "version" => $version,
                    "fecha" => $fecha,
                    "ver" => $ver
                );
                array_push($array, $arrayg);
            }
        } else { //si no hay archivos
            $arrayg = array(
                "instancia_procedimiento" => "",
                "etapa" => "",
                "nombre_documento" => "No hay archivos cargados aún.",
                "version" => "",
                "fecha" => "",
                "ver" => ""
            );
        }


        $object->data = $array;
        echo json_encode($object);
        /*echo json_encode([
            'data' => 'Etapa' : 1
        ]);;*/
    }

    public static function mostrar()
    {
        $array = array();
        $object = new stdClass();
        $arreglo = Siniestros::mostrarTodasNotificacionesSiniestros();
        if (isset($arreglo) && count($arreglo) >= 1) {
            for ($x = 0; $x < count($arreglo); $x++) {
                if ($arreglo[$x]["leida"] == "N") {
                    $boton = '<span id="boton_' . $arreglo[$x]["id_notificaciones"] . '"><button onclick="actualizar(' . $arreglo[$x]["id_notificaciones"] . ')">No</button></span>';
                } else {
                    $boton = '<span>Sí</span>';
                }
                $arrayg = array(
                    "nombre" => $arreglo[$x]["nombre"],
                    "reporte" => $arreglo[$x]["reporte"],
                    "siniestro" => $arreglo[$x]["siniestro"],
                    "poliza" => $arreglo[$x]["poliza"],
                    "reserva" => $arreglo[$x]["reserva"],
                    "cantidad" => $arreglo[$x]["cantidad"],
                    "detalle" => $arreglo[$x]["detalle"],
                    "leida" => $boton
                );
                array_push($array, $arrayg);
            }


        }
        $object->data = $array;
        echo json_encode($object);
    }

    public static function editar($r)
    {
        $respuesta = Siniestros::actualizarNotificacionSiniestro($r["id"]);
        echo $respuesta;
    }

    public static function insertar()
    {
        Siniestros::getTodasNotificacionesSiniestros();
    }

}


/************************************
 * ACTIVACION DE LA CLASE PRIMERA ATENCION SEGUN LOS PARAMETROS.
 ************************************/
if (isset($_REQUEST['metodo'])) {
    switch ($_REQUEST['metodo']) {
        case 'traer':
            Datos::traer($_REQUEST);
            break;
        case 'mostrar':
            Datos::mostrar();
            break;
        case 'editar':
            Datos::editar($_REQUEST);
            break;
        default:
            print "no tienes acceso.";
            break;
    }
}