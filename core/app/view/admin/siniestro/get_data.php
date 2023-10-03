<?php

$files_sn = Siniestros::verArchivosdelSiniestro($sn['timerst'], $_AreaID);

if (count($files_sn) >= 1) {
    $col = "";
    $render = 'no';
    foreach ($files_sn as $k) {
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
        $col .= '<tr> ';
        if ($render == 'si') { //check para generar link, si es formato gmx no lo genera.
            $nomAreaFile = $_area;
            if ($_area == 'ServidoresPúblicos')
                $nomAreaFile = 'Servidores Publicos'; //quitar acento
            // $col.='<td> </td>';/**************************************g*********************************************************************************************]/

            // ./?action=pdf/viewFileF&timerst=1656410865.3246&doc=primeraAtencion&areaNombre=Civil&v=01  iframe ok
            //$col.='<td><input class="form-input" type="checkbox" value="'.'https://'.'claimsmanager.online/?action=pdf/viewFileF&timerst='.$sn['timerst'].'&doc='.$k['nombre'].'&areaNombre='.$nomAreaFile.'&v='.$k['version'].'" data-name="'.$k['nombre'].' - rev '.$k['version'].'" id="check_'.$k['id'].'"> </td>';
            $col .= '<td><input class="form-input" type="checkbox" value="' . 'https://' . 'claimsmanager.online/?action=pdf/viewFileF&timerst=' . $sn['timerst'] . '&doc=' . $k['nombre'] . '&areaNombre=' . $nomAreaFile . '&v=' . str_pad($k['version'], 2, '0', STR_PAD_LEFT) . '" data-name="' . $k['c1'] . ' - rev ' . str_pad($k['version'], 2, '0', STR_PAD_LEFT) . '" id="check_' . $k['id'] . '"> </td>';
        } else {
            //$col.='<td> <input class="form-input" type="checkbox" value="'.$k['url'].'" data-name="'.$k['nombre'].' - rev '.$k['version'] .'" id="check_'.$k['id'].'"> </td>';
            $col .= '<td> <input class="form-input" type="checkbox" value="' . $k['url'] . '" data-name="' . $k['c1'] . ' - rev ' . str_pad($k['version'], 2, '0', STR_PAD_LEFT) . '" id="check_' . $k['id'] . '"> </td>';
        }
        $col .=
            '<td style="text-transform:capitalize !important; text-align:left;" >' . $k['c3'] . '</td>' .
            '<td style="text-transform:capitalize !important; text-align:left;" >' . $k['c2'] . '</td>' .
            '<td style="text-transform:capitalize !important; text-align:left;" >' . $k['c1'] . '</td>' .
            '<td style="text-transform:capitalize !important;" >' . str_pad($k['version'], 2, '0', STR_PAD_LEFT) . '</td>' .
            '<td style="text-transform:capitalize !important; text-align:left;">' . $k['fecha'] . '</td>';
        if ($render == 'si') { //necesita renderizar documento,
            $col .= '<td style="text-transform:lowercase;" ><button onclick="vierFileF(true, \'' . $_AREA . '\'  , \'' . $sn['timerst'] . '\'  ,\'' . $k['nombre'] . '\',  \'' . $k['c1'] . '\' , \'' . $k['id'] . '\' , \'' . str_pad($k['version'], 2, '0', STR_PAD_LEFT) . '\'  , \'' . $k['c1'] . '\' ,\'' . $k['c2'] . '\' ,\'' . $k['c3'] . '\'  )" class="btn btn-small btn-outline-primary" data-toggle="modal" data-target="#modalFileView"><i class="fa fa-eye" aria-hidden="true"></i> </button></td>' .
                '</tr>';
        } else {
            //no necesita renderizar, baja el archivo tal cual
            $col .= '<td style="text-transform:lowercase;" ><button onclick="vierFileF(false, \'' . $_AREA . '\'  , \'' . $sn['timerst'] . '\'  ,\'' . $k['url'] . '\',  \'' . $k['c1'] . '\' , \'' . $k['id'] . '\' , \'' . str_pad($k['version'], 2, '0', STR_PAD_LEFT) . '\'  , \'' . $k['c1'] . '\' ,\'' . $k['c2'] . '\' ,\'' . $k['c3'] . '\' )" class="btn btn-small btn-outline-primary" data-toggle="modal" data-target="#modalFileView"><i class="fa fa-eye" aria-hidden="true"></i> </button></td>' .
                '</tr>';
        }
    }
    $rs = $col;
} else { //si no hay archivos
    print "<tr><td colspan='6' class='text-center'>No hay archivos cargados aún.</td></tr>";
}

echo json_encode([
    'data' => $rs,
]);
// core::preprint($files_sn);
/*  
                             var_dump($files_sn); */