<?php 
Class Files{

    // esta funcion subira, encriptara, protegera el archivo que se siuba al servidor.
    public static function uploadFileSiniestro($req,$file){
        // core::preprint($req['bitacora']);exit(); 
            /* $hola="algo de texto con espacios";
            core::preprint(
                array('timerst'=>$req['timerst'],'nuevaEntrada'=>'se cargó archivo de:'.$hola.'.','horasBitacora'=>$req['horas'],'area'=>$req['area'] )
            );*/
        //core::preprint($file);
        //core::preprint(substr($file['importFile']['name'],-3));

        //?crear ruta del archivo
        $ext = explode('.',$file['importFile']['name']);
        $max = count($ext)-1;
        $ext = $ext[$max];
        $_DirBaseFiles="./files/".$req['timerst']."/".$req['tipo']."/";
        $new_nombre = core::getTimeStamp().'.'.$ext; //todo: al parecer ya se solucionó el tema de extension de 4 digitos.
        
        //? crear carpeta si no existe
        if (!file_exists($_DirBaseFiles)){
            mkdir($_DirBaseFiles,0775,true);
            chmod($_DirBaseFiles,0775);
        }

        //? mover archivo
        move_uploaded_file($file['importFile']['tmp_name']  ,   $_DirBaseFiles.$new_nombre);

        //?guardar en la base de datos los dartos del FILE
                //cuenta si existen mas versiones
                $Version='01';
                $sql="select version from siniestros_files where timerst = '".$req['timerst']."' and estatus = 1 and id_config_files = '".$req['tipo']."' and area = '".$req['area']."'  order by version DESC;";
                $query = Database::exeDoIt($sql);
                if ($query[0]->num_rows>=1){
                    $Version=str_pad ( (Model::many_assoc($query[0])[0]['version']+1) , 2, '0',STR_PAD_LEFT);
                }
        

         $sql_2="insert into siniestros_files(timerst,nombre,id_config_files,url,fecha,version,area) values('".$req['timerst']."','".urlencode($file['importFile']['name'])."',".$req['tipo'].",'".$_DirBaseFiles.$new_nombre."','".core::getTimeNow()."',$Version,'".$_REQUEST['area']."')";//!contar versiones del tipo de archivo
         $query = Database::exeDoIt($sql_2);
        //  core::preprint($sql_2,'sql');

        //? guardar historico de siniestros
                $sql="select valor from config_files where id = '".$req['tipo']."' limit 1";
                $query = Database::exeDoIt($sql);
                $nombre_file = Model::many_assoc($query[0])[0]['valor'];
                
        $sql_3='insert into siniestros_historico(movimiento,usuario,historico,fecha,timerst) 
        values("File",'.$_SESSION['id'].',"se cargó archivo de: '.$nombre_file.'","'.core::getTimeNow().'","'.$req['timerst'].'")';
        $query = Database::exeDoIt($sql_3);

        $bitacora='';
        if($req['bitacora']!=''){
            $bitacora= " / ".$req['bitacora'];
        }
        Siniestros::nuevaEntradaBitacora(array('timerst'=>$req['timerst'],'nuevaEntrada'=>'se cargó archivo de: <b>'.$nombre_file.'</b>.'.$bitacora,'horasBitacora'=>$req['horas'],'area'=>$req['area'] ),false);// redirect false

        
        //historico siniestros
        core::insertHistoricoSiniestros('Actualización','Primera Atención revisión: '.$req['area'].' revisión: '.$Version,$req['timerst']);
        header('Location: ?view=siniestro/ver&param='.$req['timerst']);

    }


    //renderiza un iframe para ver los documentos del siniestro desde TODOS LOS INIESTROS
    public static function verIframeDocsSiniestro($timerst,$areaId){
        ?>
        <!-- CSS Files -->
        <link href="./assets/css/bootstrap.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

        <link href="./assets/css/paper-dashboard.css?v=2.0.1" rel="stylesheet" />

         <center>
            <div class="row">
                <div class="col-2">
                <!-- <button type="button" onclick="disparadorFile()" class="btn btn-primary">añadir archivo</button> -->
                </div>
                <div class="col-10">
                <div class="table">
                    <table class="table" id="table-body-docs">
                    <tr>
                        <th>ETAPA</th>
                        <th>CAT1</th>
                        <th>CAT2</th>
                        <th>REV</th>
                        <th>FECHA</th>
                        <!-- <th>ver</th> -->
                    </tr>
                    
                    <?php
                    $files_sn = Siniestros::verArchivosdelSiniestro($timerst,$areaId);
                    if (count($files_sn)>=1){
                        $col="";
                        $render='no';
                        foreach ($files_sn as $k) {
                            switch ($k['nombre']) {
                                case 'primeraAtencion':
                                $k['c1'] = 'PRIMERA ATENCIÓN';
                                $k['c2'] = 'PRIMERA ATENCIÓN';
                                $k['c3'] = 'PRIMERA ATENCIÓN';
                                $render='si';
                                break;
                                case 'informePreliminar':
                                $k['c1'] = 'INFORME PRELIMINAR';
                                $k['c2'] = 'INFORME PRELIMINAR';
                                $k['c3'] = 'INFORME PRELIMINAR';
                                $render='si';
                                break;
                                case 'informeCancelación':
                                $k['c1'] = 'INFORME CANCELACIÓN';
                                $k['c2'] = 'INFORME CANCELACIÓN';
                                $k['c3'] = 'INFORME CANCELACIÓN';
                                $render='si';
                                break;
                            }
                            $col.='<tr> '.
                            '<td style="text-transform:lowercase;" >'.$k['c1'].'</td>'.
                            '<td style="text-transform:lowercase;" >'.$k['c2'].'</td>'.
                            '<td style="text-transform:lowercase;" >'.$k['c3'].'</td>'.
                            '<td style="text-transform:lowercase;" >'.str_pad($k['version'], 2, '0', STR_PAD_LEFT).'</td>'.
                            '<td style="text-transform:lowercase;" >'.$k['fecha'].'</td>';
                            /* if ($render == 'si') {//necesita renderizar documento,
                            $col.='<td style="text-transform:lowercase;" ><button onclick="vierFileF( \''.$k['timerst'].'\'  ,\''.$k['url'].'\',  \''.$k['c1'].'\'  )" class="btn btn-primary" data-toggle="modal" data-target="#modalFileView">ver</button></td>'.
                                '</tr>';
                            }else{
                                //no necesita renderizar, baja el archivo tal cual
                                $col.='<td style="text-transform:lowercase;" ><button onclick="vierFileD( \''.$k['timerst'].'\'  ,\''.$k['url'].'\',  \''.$k['c1'].'\'  )" class="btn btn-primary" data-toggle="modal" data-target="#modalFileView">ver</button></td>'.
                                '</tr>';
                            } */
                        }
                        print $col;
                    }
                    else{//si no hay archivos
                        print "<tr><td colspan='6' class='text-center'>No hay archivos cargados aún.</td></tr>";
                    }
                    /*  core::preprint($files_sn);
                    var_dump($files_sn); */
                    ?>
                    </table>
                </div> <!-- table responsive -->
                </div>
            </div>
        </center>
        <?php
    }
    
}

/************************************
 * ACTIVACION DE LA CLASE PRIMERA ATENCION SEGUN LOS PARAMETROS.
 ************************************/
if (isset($_REQUEST['modo'])){

    switch ($_REQUEST['modo']) {
        case 'upload':
            Files::uploadFileSiniestro($_REQUEST,$_FILES);
            break;
        
        case 'verArchivosdelSiniestro':
            print json_encode(Siniestros::verArchivosdelSiniestro($_REQUEST['timerst'],$_REQUEST['areaId']));
            break;
        case 'verIframeDocsSiniestro':
            Files::verIframeDocsSiniestro($_REQUEST['timerst'],$_REQUEST['areaId']);  //!para admin no disponible
            break;
        
        default:
          print "no tienes acceso.";
            break;
    }
}