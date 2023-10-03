<?php

$power = UserData::isAdmin();

// GENERA EL BOTON ADMIN y TITULAR DE AREA
if ($k['verificado'] == 'Verificado') {                                //es admin y este item ya esta verificado
    $col.='<td style="text-transform:lowercase;" >
        '.$k['verificado'].' <small style="font-weight:500;" class="text-primary">'.$k['fecha_verificacion'].'</small>
     </td>';
}else if ($k['verificado'] == ' ' && $power==1) {                                   //es admin y mostrara el boton de verificar, 
    $col.='<td style="text-transform:lowercase;" >
    <button onclick="disparadorVerificar( \''.$sn['timerst'].'\'  ,\''.$k['id'].'\' )" class="btn btn-outline-primary btn-sm mb-1" >  <i class="nc-icon nc-check-2"></i> </button>
    <button data-toggle="modal" data-target="#modalNuevaEntradaBitacora" onclick="disparadorEditarBitacora( \''.$_AreaID.'\',\''.$sn['timerst'].'\'  ,\''.$k['id'].'\' ,\''.$_area.'\' )" class="btn btn-primary btn-sm" >  <i class="nc-icon nc-ruler-pencil"></i>  </button> 
    </td>';
}

// es titular o jefe de area y su area no esta asignada




