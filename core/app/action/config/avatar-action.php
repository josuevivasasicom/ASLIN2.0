<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(1);

class avatar{

    public static function cargarAvatar(){
        $img = $_FILES['fileAvatar'];

        //Creando dirección de imagen
        $_DirBaseFiles="./avatares/user".$_SESSION['id']."/";
        $new_nombre = core::getTimeStamp().'.'.explode('/',$img['type'])[1]; //!agregar extencion del archivo

         //? crear carpeta si no existe
         if (!file_exists($_DirBaseFiles)){
            mkdir($_DirBaseFiles,0774,true);
        }

        move_uploaded_file($img['tmp_name']  ,   $_DirBaseFiles.$new_nombre);

        $sql="update usuarios set avatar = '".$_DirBaseFiles.$new_nombre."' , fechaModificacion='".core::getTimeNow()."' where id =". $_SESSION['id'];
        $query = Database::exeDoIt($sql,false);
        if($query[0]){
            $_SESSION['avatar'] = $_DirBaseFiles.$new_nombre;
            // core::insertHistorico();
            print "Exito Avatar";
        }else{
            core::preprint($_REQUEST,'$_REQUEST');
            core::preprint($_FILES,'$_FILES');
            exit();
        }




    }


}

/*=============================================
ACTIVAR TABLA SEGUN EL POST O GET
=============================================*/ 
$activar = new avatar();
$activar->cargarAvatar();

