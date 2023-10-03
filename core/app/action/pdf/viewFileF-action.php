<?php
//?? ESTE ARCHIVO REVISA QUE SEA UN FORMATO ESTABLECIDO, TRAE LA INFORMACION Y DIBUJA EL PDF PARA VERLO, O PARA DESCARGARLO SEGUN EL METODO
//?? ***************************************************************************************************************

date_default_timezone_set("America/Mexico_City");

class viewFileF{

    public static function renderFile($timerst,$doc,$areaNombre,$version){
        //revisar la extension del archivo.
        $sql='select * from siniestros_files where timerst = "'.$timerst.'" and url = "'.$doc.'" and estatus = 1 and version ='.$version.' limit 1;';
        $sql='select * from siniestros_files where timerst = "'.$timerst.'" and (url = "'.$doc.'" or nombre = "'.$doc.'") and estatus = 1 and version ='.$version.' limit 1';
        $query = Database::ExeDoIt($sql,false);
        $data = Model::many_assoc($query[0])[0];
        //// core::preprint($data);
        //var_dump($data);
        //die();

        if($data['id_config_files']==0){//? es un formato prestablecido , debe renderizar el pdf
            
            //self::renderPDF($data);//*funcion para renderizar el PDF
            //?se va al pdf de raiz
            header("Location: ./pdf/viewFileF-direct.php?timerst=".$timerst."&doc=".$doc."&areaNombre=".$areaNombre.'&v='.$version);
        }
        else{
            //ESTO RENDERIZA EL PDF A VER O EL ARCHIVO DE UPLOAD
            $file = $data['url'];
            $ext=substr($data['url'],-3);
            //die();
            
            if ($ext =='JPG' || $ext =='jpg' || $ext =='jpeg'|| $ext =='JPEG' || $ext =='PNG'|| $ext =='png'){ //detectar extension
                print '<img src="'.$file.'" style="width:100%"> ';
            }
            else if ($ext =='pdf' || $ext =='PDF' ){
                print "<embed src='".$file."' type='application/pdf' width='100%' height='100%' />";
            }
            else{
                //core::preprint($data);
                print "<h2>El archivo no tiene vista previa, debes descargarlo para poder visualizarlo</h2>";
                print "<img class='image-fluid img-fluid' src='assets/img/icons/buscandoFile.jpg'>";
                // <button type="button" class="btn btn-primary">Descargar</button>
                print "<br> <a class='btn btn-primary' href='".$file."' download='".$data['nombre']."'>Descargar Archivo ".$data['nombre']."</a>";

            }
        }
        //si es PDF o imagen. mostrarlo en MODAL

        //si es cualquier otro formato, DESCARGARLO
    }
    public static function renderPDF($data){//debe renderizar el pdf desde la base de datos
       
        /* *******************
        *  FUNCIONES NATIVAS PARA LA LIBRERIA DEL PDF
        *********************** */

        //$contenido = Siniestros::verPrimeraAtencion($_REQUEST['timerst']);

        // instanciar y usar la clase dompdf 
        ob_start();
        $dompdf = new  Dompdf ();

        $options = new Options();
        $options->set('defaultFont', 'Courier');
        $dompdf = new Dompdf($options);
        
        switch ($data['url']) {
            case 'primeraAtencion':
                $contenido = Siniestros::verPrimeraAtencion($_REQUEST['timerst']);
                include "formato/primeraAtencion.php";
                break;
            case 'informePreliminar':
                $contenido = Siniestros::verPrimeraAtencion($_REQUEST['timerst']);
                include "formato/primeraAtencion.php";
                break;
            case 'informeCancelacion':
                $contenido = Siniestros::verPrimeraAtencion($_REQUEST['timerst']);
                include "formato/primeraAtencion.php";
                break;
            default:
                # code...
                break;
        }
      
        // $html = ob_get_clean();
        $dompdf -> loadHtml ( ob_get_clean() );

        // (Opcional) Configure el tamaño y la orientación del papel 
        $dompdf -> setPaper ( 'letter' , 'portail' );

        // Renderiza el HTML como PDF 
        $dompdf -> render ();

        // Envía el PDF generado al navegador VIEW
        $dompdf -> stream("doc.pdf", ['Attachment' => false]);
        exit(0);

    }
    

}


/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(1);*/


if (isset($_REQUEST['timerst']) &&  isset($_REQUEST['doc']) ){
    $a= isset($_REQUEST['areaNombre'])==true?$_REQUEST['areaNombre']:$_REQUEST['areaId'];
    $vf = new viewFileF();
    $vf::renderFile($_REQUEST['timerst'],$_REQUEST['doc'],$a,$_REQUEST['v']);
}else{
    echo "No tienes permiso";
    exit();
}

exit();
