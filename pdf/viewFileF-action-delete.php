<?php
//?? ESTE ARCHIVO REVISA QUE SEA UN FORMATO ESTABLECIDO, TRAE LA INFORMACION Y DIBUJA EL PDF PARA VERLO, O PARA DESCARGARLO SEGUN EL METODO
//?? ***************************************************************************************************************

date_default_timezone_set("America/Mexico_City");


use Spipu\Html2Pdf\Html2Pdf;
ob_start();
                $contenido = Siniestros::verPrimeraAtencion($_REQUEST['timerst']);
                include "formato/primeraAtencion.php";
$html = ob_get_clean();

$html2pdf = new Html2Pdf('P','A4','es','true','UTF-8');
$html2pdf->writeHTML($html);
    $html2pdf->pdf->SetDisplayMode('fullpage');
    //$html2pdf->pdf->SetProtection(array('print', 'copy'), '12345', null, 0, null);
    $html2pdf->output("nombre.pdf");



exit();
class viewFileF{

    public static function renderFile($timerst,$doc){
        //revisar la extension del archivo.
        $sql='select * from siniestros_files where timerst = "'.$timerst.'" AND estatus = 1 and url = "'.$doc.'" limit 1;';
        $query = Database::ExeDoIt($sql);
        $data = Model::many_assoc($query[0])[0];
        //// core::preprint($data);

        if($data['id_config_files']==0){//? es un formato prestablecido , debe renderizar el pdf
            self::renderPDF($data);//*funcion para renderizar el PDF
        }
        else{
            $file = $data['url'];
            $ext=substr($data['url'],-3);
            if ($ext =='JPG' || $ext =='jpg' || $ext =='jpeg'|| $ext =='JPEG' || $ext =='PNG'|| $ext =='png'){ //detectar extension
                print '<img src="'.$file.'" style="width:100%"> ';
            }
            elseif ($ext =='pdf' || $ext =='PDF' ){
                print "<embed src='".$file."' type='application/pdf' width='100%' height='100%' />";
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



if (isset($_REQUEST['timerst']) &&  isset($_REQUEST['doc']) ){
    $vf = new viewFileF();
    $vf::renderFile($_REQUEST['timerst'],$_REQUEST['doc']);
}else{
    echo "No tienes permiso";
    exit();
}

exit();
