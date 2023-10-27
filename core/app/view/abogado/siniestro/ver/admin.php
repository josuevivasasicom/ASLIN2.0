<?php

$power = UserData::isAdmin();

// GENERA EL BOTON ADMIN y TITULAR DE AREA
if ($k['verificado'] == 'Verificado') {                                //es admin y este item ya esta verificado
    $col.='<td style="text-transform:lowercase;" >
        '.$k['verificado'].' <small style="font-weight:500;" class="text-primary">'.$k['fecha_verificacion'].'</small>
     </td>';
}else if ($k['verificado'] != 'Verificado' && $k['usuarioID']==$_SESSION['id']) {                                   //es admin y mostrara el boton de verificar, 
    $col.='<td style="text-transform:lowercase;" >
    <button data-toggle="modal" data-target="#modalNuevaEntradaBitacora" onclick="disparadorEditarBitacora( \''.$_AreaID.'\',\''.$sn['timerst'].'\'  ,\''.$k['id'].'\' ,\''.$_area.'\' )" class="btn btn-primary btn-sm" >  <i><img src="https://asicomgraphics.mx/demos/dxlegal/editar.png"></i>  </button> 
    </td>';
}
else{
    $col.='<td style="text-transform:lowercase;" >  
    </td>';
}

// es titular o jefe de area y su area no esta asignada




