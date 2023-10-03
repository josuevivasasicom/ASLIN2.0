<?php
class editDescripcion{
    public static function editarDescripcionByTimerst(){
        $id = $_REQUEST['timerst'];
        $nueva_descripcion = $_REQUEST['texarea'];
        $folio = $_REQUEST['folio'];

        $sql="select descripcionHechos,created_by_user,created_by_area,fechaCaptura from siniestros where timerst='".$id."' limit 1";
        $query = Database::ExeDoIt($sql,false);
        $dat = Model::many_assoc($query[0])[0];
        $vieja_descrip = $dat['descripcionHechos'];
        $vieja_descrip_us = $dat['created_by_user'];
        $vieja_descrip_area = $dat['created_by_area'];
        $vieja_descrip_created = $dat['fechaCaptura'];

        /* core::preprint($vieja_descrip,'vieja_descrip');
        core::preprint($nueva_descripcion,'nueva_descripcion');
        exit(); */

        //echo 'comparando....<br>'; //mp hay cambios
        if ($vieja_descrip == urlencode($nueva_descripcion) ){
            echo 'no se cambia nada por que ya existe.'; //mp hay cambios
            // exit();
        }
        //verificar que si la vieja descripcion existe ya en la tabla de versiones
            $sql2="select rev from siniestros_descripcion_hechos where timerst='".$id."' and descripcion_hechos = '".($vieja_descrip)."'";
            $query2 = Database::ExeDoIt($sql2,false);
            /* core::preprint($query2[0]->num_rows);
            exit(); */
            if ($query2[0]->num_rows){ // la vieja descripcion ya tiene versión
                //?buscará el ultimo escrito para sumarle una version mas.
                        $sql2="select rev from siniestros_descripcion_hechos where timerst='".$id."' order by rev desc limit 1";
                        $query2 = Database::ExeDoIt($sql2,false);
                        if ($query2[0]->num_rows){
                            $ultima_rev = Model::many_assoc($query2[0])[0]['rev'];
                            $ultima_rev = $ultima_rev+1;
                            
                            //?insertando la vieja descripcion a la tabla de versiones y la nueva en el siniestro principal.
                            $sql="INSERT INTO  siniestros_descripcion_hechos(timerst,autor,area,folio,fecha_creacion,rev,descripcion_hechos)
                                    values('$id','".$_SESSION['id']."','".explode('/',$_SESSION['grupo'][0])[2]."', '$folio', '".Core::getTimeNow()."',$ultima_rev, '".urlencode($nueva_descripcion)."')";
                            $query = Database::ExeDoIt($sql);

                            //?se inserta el nuevo campo descripcion en el principal siniestro.
                            $sql="UPDATE siniestros set descripcionHechos = '".urlencode($nueva_descripcion)."' where timerst = '$id'; ";
                            $query= Database::ExeDoIt($sql);

                            // historico de siniestro
					        core::insertHistoricoSiniestros('Actualizado','Se cambió descripción de hechos version: '.$ultima_rev,$id);//?historico

                            echo "Exito1";
                            exit();

                        }else{
                            $ultima_rev = 1;
                            echo "error1 algo salió muy mal.";
                            exit();
                        }


            }
            else{// si no existe , quiere decir que se va a crear la segunda versión
               
                        //'".$vieja_descrip."';
                        $ultima_rev = 1;
                        //? almacena la primer version
                        $sql="INSERT INTO  siniestros_descripcion_hechos(timerst,autor,area,folio,fecha_creacion,rev,descripcion_hechos)
                                values('$id','$vieja_descrip_us','$vieja_descrip_area', '$folio', '".$vieja_descrip_created."',1, '".($vieja_descrip)."')";
                        $query = Database::ExeDoIt($sql);

                        $ultima_rev++;
                        

                        //?insertando la nueva descripcion a la tabla de versiones 
                        $sql="INSERT INTO  siniestros_descripcion_hechos(timerst,autor,area,folio,fecha_creacion,rev,descripcion_hechos)
                                values('$id','".$_SESSION['id']."','".explode('/',$_SESSION['grupo'][0])[2]."', '$folio', '".Core::getTimeNow()."',$ultima_rev, '".urlencode($nueva_descripcion)."')";
                        $query = Database::ExeDoIt($sql);

                        // y la nueva en el siniestro principal.

                        //?se inserta el nuevo campo descripcion en el principal siniestro.
                        $sql="UPDATE siniestros set descripcionHechos = '".urlencode($nueva_descripcion)."' where timerst = '$id'; ";
                        $query= Database::ExeDoIt($sql);

                        // historico de siniestro
					    core::insertHistoricoSiniestros('Actualizado','Se cambió descripción de hechos version: '.$ultima_rev,$id);//?historico

                        core::preprint($sql2);
                        
                        echo "Exito2";

               exit();
            }

    }
}


/* core::preprint($_REQUEST);
exit(); */
if($_REQUEST['timerst']!='' and $_REQUEST['texarea']!=''){
    editDescripcion::editarDescripcionByTimerst(); // inicializan funcion de la  clase
}