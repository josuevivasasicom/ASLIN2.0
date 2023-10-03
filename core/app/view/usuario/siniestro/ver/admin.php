<?php

$power = UserData::isAdmin();

// GENERA EL BOTON ADMIN y TITULAR DE AREA
if ($k['verificado'] == 'Verificado' && $power==1) {                                //es admin y este item ya esta verificado
    $col.='<td style="text-transform:lowercase;" > O.K.</td>';
}else if ($k['verificado'] == ' ' && $power==1) {                                   //es admin y mostrara el boton de verificar, 
    $col.='<td style="text-transform:lowercase;" ><button onclick="disparadorVerificar( \''.$sn['timerst'].'\'  ,\''.$k['id'].'\' )" class="btn btn-primary btn-sm" >  <i class="nc-icon nc-check-2"></i>  </button></td>';
}

// es titular o jefe de area y su area no esta asignada