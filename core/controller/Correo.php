<?php
// @elmm Define las funciones del correo para usar mas facilmente desde cualquier vista o accion sin importar el modulo

// $_phpmailer_autoload = "./extensiones/phpmailer/PHPMailer/PHPMailerAutoload.php";
// $_phpmailer_vendor =   "./extensiones/phpmailer/vendor/autoload.php";


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
class Correo
{

    public static $remitente = "contacto@grupodiemsa.com";
    public static $nombreRemitente = "";
    public static $asicomMail = "";
    public static $diemsaMail = "contacto@grupodiemsa.com";
    public static $msj_test='';

    public function Correo()
    {
        $remitente = self::$remitente;
        $nombreRemitente = self::$nombreRemitente;
        $asicomMail = self::$asicomMail;
        $diemsaMail = self::$diemsaMail;
    }

    //ok
    public static function sendMail_disabled($msg,$email,$subject,$debug=0)
    {
        require_once "./PHPMailer/PHPMailerAutoload.php";
        // require_once "./PHPMailer/vendor/autoload.php";

        $mail = new PHPMailer;
        $mail->SMTPDebug  = $debug;
        $mail->CharSet = 'UTF-8';
        $mail->isMail();
        $mail->setFrom('contacto@grupodiemsa.com', 'GRUPO DIEMSA');
        $mail->addReplyTo('contacto@grupodiemsa.com', 'GRUPO DIEMSA');
        $mail->Subject = $subject;
        //$mail->addAddress("erick.leo.malagon@gmail.com");
        $mail->msgHTML($msg);
        if(!$envio = $mail->Send()){
            echo "ERROR";
        }
        else{
        	echo "EXITO";
        }
    }

     //funcion okoy 
     public static function sendMail($msg,$email,$subject,$debug=0,$file=0,$filename='')
     {
        //  require_once "./PHPMailer/PHPMailerAutoload.php";
       
        
        // require './vendor/phpmailer/phpmailer/src/PHPMailer.php';
        require './vendor/phpmailer/phpmailer/src/Exception.php';
        require './vendor/phpmailer/phpmailer/src/PHPMailer.php';
        require './vendor/phpmailer/phpmailer/src/SMTP.php';


         $mail = new PHPMailer;
         $mail->setLanguage('es', './vendor/phpmailer/phpmailer/language/directory/');
         
         $mail->SMTPDebug = 0;//SMTP::DEBUG_SERVER;     
         $mail->isSMTP();                                               //Send using SMTP
         $mail->Host       = 'smtp.hostinger.com';                     //Set the SMTP server to send through
         $mail->SMTPAuth   = true;                                      //Enable SMTP authentication
         $mail->Username   = 'alertas@claimsmanager.online';            //SMTP username
         $mail->Password   = 'Al2rt1s@';                                //SMTP password
         $mail->SMTPSecure = 'ssl'; //PHPMailer::ENCRYPTION_SMTPS;      //Enable implicit TLS encryption
         $mail->Port       = 465; 

         $mail->CharSet = 'UTF-8';
         $mail->setFrom('alertas@claimsmanager.online', 'Alertas CMA');
         $mail->addReplyTo($_SESSION['email'], $_SESSION['nombre'].' '.$_SESSION['paterno'].' '.$_SESSION['materno']);
        //$mail->addAddress("erick.leo.malagon@gmail.com","erick Malagon"); 
        //$mail->addBCC("erick.leo.malagon@gmail.com","Ing Erick Malagón"); 
        //  $mail->addAddress("raguilar@asicomsystems.com.mx","Roguelio Aguilar");
         $mail->isHTML(true); 
         $mail->Subject = $subject;
         $mail->Body =  $msg;
        //  $mail->addStringAttachment('/files/temp', 'ejemplo.txt');
        if($filename!=''){
            $mail->addStringAttachment($file,$filename);
        }

         if(!$envio = $mail->Send()){
             return "ERROR";
         }
         else{
             return "EXITO";
         }
         //core::preprint($envio);
         /*    Al2rt1s@         alertas@claimsmanager.online
 
                SSL/TLS        Protocolo Hostname  Puerto
                Servidor entrante (IMAP)    imap.hostinger.com      993
                Servidor saliente (SMTP)    smtp.hostinger.com     465
                Servidor entrante (POP)     pop.hostinger.com       995
        */
     }

    //debe enviar a varios emails
    public static function sendMail_varios_abogados($msg,$emails,$subject,$debug=0,$file=0,$filename='')
    {
        // core::preprint($emails[0]['nombre']);exit();
        /* emails[0] => Array
        (
            [email] => direccion.penal@cmabogados.mx
            [nombre] => Lic. Yessica Yordana Romero
        ) */
        //  require_once "./PHPMailer/PHPMailerAutoload.php";
        
        
        // require './vendor/phpmailer/phpmailer/src/PHPMailer.php';
        require './vendor/phpmailer/phpmailer/src/Exception.php';
        require './vendor/phpmailer/phpmailer/src/PHPMailer.php';
        require './vendor/phpmailer/phpmailer/src/SMTP.php';


        $mail = new PHPMailer;
        $mail->setLanguage('es', './vendor/phpmailer/phpmailer/language/directory/');
        
        $mail->SMTPDebug = 0;//SMTP::DEBUG_SERVER;     
        $mail->isSMTP();                                               //Send using SMTP
        $mail->Host       = 'smtp.hostinger.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                      //Enable SMTP authentication
        $mail->Username   = 'alertas@claimsmanager.online';            //SMTP username
        $mail->Password   = 'Al2rt1s@';                                //SMTP password
        $mail->SMTPSecure = 'ssl'; //PHPMailer::ENCRYPTION_SMTPS;      //Enable implicit TLS encryption
        $mail->Port       = 465; 

        $mail->CharSet = 'UTF-8';
        $mail->setFrom('alertas@claimsmanager.online', 'Alertas CMA');
        $mail->addReplyTo($_SESSION['email'], $_SESSION['nombre'].' '.$_SESSION['paterno'].' '.$_SESSION['materno']);
        //?add mails
        // $mail->addCC("erick.leo.malagon@gmail.com","Ing Erick Malagón"); 
        //$mail->addBCC("erick.leo.malagon@gmail.com","Ing Erick Malagón"); 
        //$mail->addBCC("ConsultoriaSoftware@asicomsystems.com.mx"); 

        foreach ($emails as $k) {
            // $mail->addAddress("erick.leo.malagon@gmail.com","erick Malagon"); 
            $mail->addAddress($k['email'],$k['nombre']); 
        }
        // $mail->addAddress("raguilar@asicomsystems.com.mx","Roguelio Aguilar");
        $mail->isHTML(true); 
        $mail->Subject = $subject;
        $mail->Body =  $msg;

        if(!$envio = $mail->Send()){
            return "ERROR";
        }
        else{
            return "EXITO";
        }
        //core::preprint($envio);
        /*    Al2rt1s@         alertas@claimsmanager.online

            SSL/TLS        Protocolo Hostname  Puerto
            Servidor entrante (IMAP)    imap.hostinger.com      993
            Servidor saliente (SMTP)    smtp.hostinger.com     465
            Servidor entrante (POP)     pop.hostinger.com       995
    */
    }

    //funcion okoy para FILES PREVIEW
    public static function sendMailFiles($msg,$email,$subject,$debug=0,$file=0,$filename='')
    {
        //  require_once "./PHPMailer/PHPMailerAutoload.php";
        
        
        // require './vendor/phpmailer/phpmailer/src/PHPMailer.php';
        require './vendor/phpmailer/phpmailer/src/Exception.php';
        require './vendor/phpmailer/phpmailer/src/PHPMailer.php';
        require './vendor/phpmailer/phpmailer/src/SMTP.php';


        $mail = new PHPMailer;
        $mail->setLanguage('es', './vendor/phpmailer/phpmailer/language/directory/');
        
        $mail->SMTPDebug = 0;//SMTP::DEBUG_SERVER;     
        $mail->isSMTP();                                               //Send using SMTP
        $mail->Host       = 'smtp.hostinger.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                      //Enable SMTP authentication
        $mail->Username   = 'alertas@claimsmanager.online';            //SMTP username
        $mail->Password   = 'Al2rt1s@';                                //SMTP password
        $mail->SMTPSecure = 'ssl'; //PHPMailer::ENCRYPTION_SMTPS;      //Enable implicit TLS encryption
        $mail->Port       = 465; 

        $mail->CharSet = 'UTF-8';
        $mail->setFrom('alertas@claimsmanager.online', $_SESSION['nombre'].' '.$_SESSION['paterno'].' '.$_SESSION['materno']);
        $mail->addReplyTo($_SESSION['email'], $_SESSION['nombre'].' '.$_SESSION['paterno'].' '.$_SESSION['materno']);
        //$mail->addBCC("erick.leo.malagon@gmail.com"); 
        //$mail->addBCC("ConsultoriaSoftware@asicomsystems.com.mx"); 
        // core::preprint($email['send'],'------------------------$email[send]');
        // core::preprint($email['cc']);
        // core::preprint($email['cco'],'cco array');
        foreach ($email['send'] as $k){
            if(isset($k['email']))
            $mail->addAddress($k['email']);
            if(isset($k[0]))
            $mail->addAddress($k[0] );

        }
        // core::preprint("_________________________________________________________________________________________");

        foreach ($email['cc'] as $k){
            // core::preprint($k,'concopia');
            if(isset($k['email']))
            $mail->addCC($k['email']);
            if(isset($k[0]))
            $mail->addCC($k[0]);
        }
        //$mail->addBCC("ConsultoriaSoftware@asicomsystems.com.mx"); 

        foreach ($email['cco'] as $k){
            if(isset($k['email']))
            $mail->addBCC($k['email']);
            if(isset($k[0]))
            $mail->addBCC($k[0] );
        }

        // $mail->addAddress("raguilar@asicomsystems.com.mx","Roguelio Aguilar");
        $mail->isHTML(true); 
        $mail->Subject = $subject;
        $mail->Body =  $msg;
        //  $mail->addStringAttachment('/files/temp', 'ejemplo.txt');
        if($filename!=''){
            $mail->addStringAttachment($file,$filename);
        }

        if(!$envio = $mail->Send()){
            return "ERROR";
        }
        else{
            return "EXITO";
        }
        //core::preprint($envio);
        /*    Al2rt1s@         alertas@claimsmanager.online

            SSL/TLS        Protocolo Hostname  Puerto
            Servidor entrante (IMAP)    imap.hostinger.com      993
            Servidor saliente (SMTP)    smtp.hostinger.com     465
            Servidor entrante (POP)     pop.hostinger.com       995
        */
    }


      /* ***************************[ CORREO CREACIÓN DE ID ]*********************************** */
    //REVIEW ....
    //@param 
    //folio
    //timerst
    //fechaAsignacion
    //fechaCreacion
    // [area]
    //abogados []
    public static function send_notify_new_id($data)
    {
        // core::preprint($data);exit();
        /*         Array
        (
            [timerst] => 1652433546.6882
            [folio] => 101-050-22
            [fechaCreacion] => 2022-05-13 04:19:06
            [fechaAsignacion] => 2022-05-13 04:14:02
            [abogados] => Array
                (
                    [0] => fernanda@cmabogados.mx
                    [1] => direccion.penal@cmabogados.mx
                    [2] => siniestros@cmabogados.mx
                )

            [areas] => Array
                (
                    [0] => Penal
                    [1] => Siniestros
                )

        ) */
        $msg = '
        <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
                <title>CMA Mail</title><meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;"><meta charset="utf-8" />
                <style type="text/css">body{ width: 100%; background-color: #3a3c3a; margin: 0; padding: 0; -webkit-font-smoothing: antialiased; mso-margin-top-alt: 0px; mso-margin-bottom-alt: 0px; mso-padding-alt: 0px 0px 0px 0px;} p, h1, h2, h3, h4{ margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0;} span.preheader{ display: none; font-size: 1px;} html{ width: 100%;} table{ font-size: 12px; border: 0;} .menu-space{ padding-right: 25px;} table{ mso-table-lspace: 0pt; mso-table-rspace: 0pt;} img{ -ms-interpolation-mode: bicubic; border: none;} a, a:hover{ text-decoration: none; color: #FFF;} p{ text-align: left;} @media only screen and (max-width:640px){ body{ width: auto!important;} body[yahoo] table[class=main]{ width: 440px !important;} body[yahoo] table[class=two-left]{ width: 420px !important; margin: 0px auto;} body[yahoo] table[class=full]{ width: 100% !important; margin: 0px auto;} body[yahoo] table[class=alaine]{ text-align: center;} body[yahoo] table[class=menu-space]{ padding-right: 0px;} body[yahoo] table[class=banner]{ width: 438px !important;} body[yahoo] table[class=menu]{ width: 438px !important; margin: 0px auto; border-bottom: #e1e0e2 solid 1px;} body[yahoo] table[class=date]{ width: 438px !important; margin: 0px auto; text-align: center;} body[yahoo] table[class=two-left-inner]{ width: 400px !important; margin: 0px auto;} body[yahoo] table[class=menu-icon]{ display: block;} body[yahoo] table[class=two-left-menu]{ text-align: center;} p{ text-align: center;}} @media only screen and (max-width:479px){ body{ width: auto!important;} body[yahoo] table[class=main]{ width: 310px !important;} body[yahoo] table[class=two-left]{ width: 300px !important; margin: 0px auto;} body[yahoo] table[class=full]{ width: 100% !important; margin: 0px auto;} body[yahoo] table[class=alaine]{ text-align: center;} body[yahoo] table[class=menu-space]{ padding-right: 0px;} body[yahoo] table[class=banner]{ width: 308px !important;} body[yahoo] table[class=menu]{ width: 308px !important; margin: 0px auto; border-bottom: #e1e0e2 solid 1px;} body[yahoo] table[class=date]{ width: 308px !important; margin: 0px auto; text-align: center;} body[yahoo] table[class=two-left-inner]{ width: 280px !important; margin: 0px auto;} body[yahoo] table[class=menu-icon]{ display: none;} body[yahoo] table[class=two-left-menu]{ width: 310px !important; margin: 0px auto;} p{ text-align: center;}} </style>

            </head>

            <body yahoo="fix" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

                <!--Main Table Start-->

                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#3a3c3a" style="background:#3a3c3a;">
                    <tbody>
                        <tr>
                            <td align="center" valign="top">

                                <!--Logo part Start-->

                                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                                    <tbody>
                                        <tr>
                                            <td align="center" valign="top">
                                                <table width="700" border="0" align="center" cellpadding="0" cellspacing="0" class="main">
                                                    <tbody>
                                                        <tr>
                                                            <td align="left" valign="top" bgcolor="#9f8827a3" style="background:#9f8827a3;">
                                                                <table width="630" border="0" align="center" cellpadding="0" cellspacing="0" class="two-left">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td height="35" align="left" valign="top" style="line-height:35px;">&nbsp;</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td align="left" valign="top">


                                                                                <table width="135" border="0" align="left" cellpadding="0" cellspacing="0" class="two-left">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td align="center" valign="top">
                                                                                                <table width="135" border="0" cellspacing="0" cellpadding="0">
                                                                                                    <tbody>
                                                                                                        
                                                                                                    </tbody>
                                                                                                </table>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td height="35" align="left" valign="top" style="line-height:35px;">&nbsp;</td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>

                                                                                <table width="405" border="0" align="right" cellpadding="0" cellspacing="0" class="two-left">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td align="left" valign="top">


                                                                                                <table width="105" border="0" align="left" cellpadding="0" cellspacing="0" class="two-left">
                                                                                                    <tbody>
                                                                                                        <tr>
                                                                                                            <td align="center" valign="top">
                                                                                                                <a href="#"><img src="https://claimsmanager.online/assets/img/logo_large_white.png" width="200" height="22" alt="" style="width: 200px;height: auto;"></a>
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td height="20" align="left" valign="top" style="line-height:20px;">&nbsp;</td>
                                                                                                        </tr>
                                                                                                    </tbody>
                                                                                                </table>

                                                                                                <table border="0" align="right" cellpadding="0" cellspacing="0" class="two-left">
                                                                                                    <tbody>
                                                                                                        <tr>
                                                                                                            <td align="center" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; font-weight:bold; text-transform:uppercase; color:#FFF; padding-top:4px;">
                                                                                                                <a href="https://claimsmanager.online" target="_blank" style="text-decoration:none; color:#FFF;">Ir a sitio</a>
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td height="35" align="left" valign="top" style="line-height:35px;">&nbsp;</td>
                                                                                                        </tr>
                                                                                                    </tbody>
                                                                                                </table>


                                                                                            </td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>


                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <!--Logo part End-->


                                <!--Banner part Start-->

                                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                                    <tbody>
                                        <tr>
                                            <td align="center" valign="top">
                                                <table width="700" border="0" align="center" cellpadding="0" cellspacing="0" class="main">
                                                    <tbody>
                                                        <tr>
                                                            <td align="left" valign="top" bgcolor="#ae9a49" style="background:#ae9a49;">

                                                                <table width="320" border="0" align="right" cellpadding="0" cellspacing="0" class="full">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td align="center" valign="top"></td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>

                                                                <table width="350" border="0" cellspacing="0" cellpadding="0" class="full">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td height="335" align="left" valign="bottom">
                                                                                <table width="280" border="0" align="center" cellpadding="0" cellspacing="0">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td align="left" valign="top">
                                                                                                <table width="105" border="0" align="left" cellpadding="0" cellspacing="0">
                                                                                                    <tbody>
                                                                                                        <tr>
                                                                                                            <td width="95" align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; font-weight:bold; text-transform:uppercase; color:#FFF;"><a href="https://claimsmanager.online/?view=siniestro/ver&param='. $data['timerst'] .'" target="_blank" style="text-decoration:none; color:#FFF;">Ir al ID </a></td>
                                                                                                            <td width="10" align="center" valign="middle"><img src="https://claimsmanager.online/assets/img/icons/read-more.png" width="10" height="10" alt="" style="display:block;"></td>
                                                                                                        </tr>
                                                                                                    </tbody>
                                                                                                </table>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:36px; font-weight:bold; text-transform:uppercase; color:#FFF; line-height:48px; padding-top:16px;">Se acaba de crear el ID '. $data['folio'] .'</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td height="50" align="left" valign="top" style="line-height:50px;">&nbsp;</td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>



                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <!--Banner part End-->


                                <!--Welcome part Start-->

                                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                                    <tbody>
                                        <tr>
                                            <td align="center" valign="top">
                                                <table width="700" border="0" align="center" cellpadding="0" cellspacing="0" class="main">
                                                    <tbody>
                                                        <tr>
                                                            <td align="left" valign="top" bgcolor="#9f8827a3" style="background:#9f8827a3;">
                                                                <table width="530" border="0" align="center" cellpadding="0" cellspacing="0" class="two-left">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td height="95" align="left" valign="top" style="line-height:95px;">&nbsp;</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td align="center" valign="top">
                                                                                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td align="center" valign="top">
                                                                                                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                                                                                                    <tbody>
                                                                                                        <tr>
                                                                                                            <td align="center" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:18px; font-weight:bold; text-transform:uppercase; color:#FFF;">Se ha asignado al área de </td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td align="center" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:50px; font-weight:bold; text-transform:uppercase; color:#FFF; padding:10px 0px 15px 0px;">
                                                                                                            ';
                                                                                                            foreach ($data['areas'] as $k) {
                                                                                                                $msg.= $k . '<br>';
                                                                                                                // Siniestros
                                                                                                            }
                                                                                                            $msg.='
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                    </tbody>
                                                                                                </table>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td align="center" valign="top" style="font-family:Verdana, Geneva, sans-serif; font-size:16px; font-weight:normal;color:#FFF; line-height:36px; padding-bottom:15px;">
                                                                                                fecha de creación:
                                                                                                '. $data['fechaCreacion'] .'
                                                                                                    <br>fecha de asignacion:
                                                                                                '. $data['fechaAsignacion'] .'
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td align="center" valign="top">
                                                                                                <table width="185" border="0" align="center" cellpadding="0" cellspacing="0">
                                                                                                    <tbody>
                                                                                                        <tr>
                                                                                                            <td align="center" valign="top">&nbsp;</td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td height="45" align="center" valign="middle" style=" border:#ffffff solid 2px; font-family:Arial, Helvetica, sans-serif; font-size:18px; font-weight:bold; text-transform:uppercase; color:#FFF;">
                                                                                                                <a href="https://claimsmanager.online/?view=siniestro/ver&param='. $data['timerst'] .'" target="_blank" style="cursor:pointer;text-decoration:none; color:#FFF;">Ver ID</a>
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                    </tbody>
                                                                                                </table>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td height="95" align="left" valign="top" style="line-height:95px;">&nbsp;</td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <!--Welcome part End-->

                                <!--contact-image Start-->

                                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                                    <tbody>
                                        <tr>
                                            <td align="center" valign="top">
                                            <table width="700" border="0" align="center" cellpadding="0" cellspacing="0" class="main">
                                                <tbody>
                                                    <tr>
                                                        <td align="left" valign="top" bgcolor="#FFFFFF" style="background:#FFF;overflow:hidden;background-image: url(http://claimsmanager.online/assets/img/bg/1.1.jpg)">
                                                        <img width="580" src="https://claimsmanager.online/'.$_SESSION['firma'].'" style="position: absolute;left: 0;right: 0;margin: auto;margin-top: 13px;">
                                                        </td>

                                                    </tr>
                                                </tbody>
                                            </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <!--contact-image End-->


                                <!--copyright Start-->

                                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                                    <tbody>
                                        <tr>
                                            <td align="center" valign="top">
                                                <table width="700" border="0" align="center" cellpadding="0" cellspacing="0" class="main">
                                                    <tbody>
                                                        <tr>
                                                            <td align="left" valign="top" bgcolor="#ae9a49" style="background:#ae9a49;">
                                                                <table width="580" border="0" align="center" cellpadding="0" cellspacing="0" class="two-left">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td height="60" align="left" valign="middle" style="font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:normal;color:#FFF;">Copyright © 2022 smart mail. información confidencial. power by asicomgraphics.mx</td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <!--copyright End-->


                            </td>
                        </tr>
                    </tbody>
                </table>

                <!--Main Table End-->



            </body>
            
        </html>';

        $email = $data['abogados'];
        $subject = 'Se ha creado el ID '.$data['folio'];
        // require_once "./core/controller/Correo.php";
        return $send = Correo::sendMail_varios_abogados($msg,$email,$subject,$debug=0);

    }


    
     /* ***************************[ CORREO ENVIAR FORMATO DESDE ID VIEW ]*********************************** */
     // action         ->
     // method         ->
     // textMail            ->TEXTO DEL CORREO
     // [sendMails] =>  'send_4'
    // ccMails => 
    // ccoMails => 
    // save_send => false
    // save_cc => false
    // save_cco => false
    // idfile => 5
    // linkpdf => https://www.claimsmanager.online/?action=pdf/viewFileF&timerst=1652433546.6882&doc=./files/1652433546.6882/39/1654707540.csv&v=01&areaNombre=Penal&v=01
    // c1 => denuncia.
    // c2 => investigación inicial
    // c3 => acusatorio
    public static function send_format($data)
    {
        // core::preprint($data,'data del correo:send_format',false);
        
        $msg = '
        <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
                <title>CMA Mail</title><meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;"><meta charset="utf-8" />
                <style type="text/css">body{ width: 100%; background-color: #3a3c3a; margin: 0; padding: 0; -webkit-font-smoothing: antialiased; mso-margin-top-alt: 0px; mso-margin-bottom-alt: 0px; mso-padding-alt: 0px 0px 0px 0px;} p, h1, h2, h3, h4{ margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0;} span.preheader{ display: none; font-size: 1px;} html{ width: 100%;} table{ font-size: 12px; border: 0;} .menu-space{ padding-right: 25px;} table{ mso-table-lspace: 0pt; mso-table-rspace: 0pt;} img{ -ms-interpolation-mode: bicubic; border: none;} a, a:hover{ text-decoration: none; color: #FFF;} p{ text-align: left;} @media only screen and (max-width:640px){ body{ width: auto!important;} body[yahoo] table[class=main]{ width: 440px !important;} body[yahoo] table[class=two-left]{ width: 420px !important; margin: 0px auto;} body[yahoo] table[class=full]{ width: 100% !important; margin: 0px auto;} body[yahoo] table[class=alaine]{ text-align: center;} body[yahoo] table[class=menu-space]{ padding-right: 0px;} body[yahoo] table[class=banner]{ width: 438px !important;} body[yahoo] table[class=menu]{ width: 438px !important; margin: 0px auto; border-bottom: #e1e0e2 solid 1px;} body[yahoo] table[class=date]{ width: 438px !important; margin: 0px auto; text-align: center;} body[yahoo] table[class=two-left-inner]{ width: 400px !important; margin: 0px auto;} body[yahoo] table[class=menu-icon]{ display: block;} body[yahoo] table[class=two-left-menu]{ text-align: center;} p{ text-align: center;}} @media only screen and (max-width:479px){ body{ width: auto!important;} body[yahoo] table[class=main]{ width: 310px !important;} body[yahoo] table[class=two-left]{ width: 300px !important; margin: 0px auto;} body[yahoo] table[class=full]{ width: 100% !important; margin: 0px auto;} body[yahoo] table[class=alaine]{ text-align: center;} body[yahoo] table[class=menu-space]{ padding-right: 0px;} body[yahoo] table[class=banner]{ width: 308px !important;} body[yahoo] table[class=menu]{ width: 308px !important; margin: 0px auto; border-bottom: #e1e0e2 solid 1px;} body[yahoo] table[class=date]{ width: 308px !important; margin: 0px auto; text-align: center;} body[yahoo] table[class=two-left-inner]{ width: 280px !important; margin: 0px auto;} body[yahoo] table[class=menu-icon]{ display: none;} body[yahoo] table[class=two-left-menu]{ width: 310px !important; margin: 0px auto;} p{ text-align: center;}} </style>

            </head>

            <body yahoo="fix" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

                <!--Main Table Start-->

                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#3a3c3a" style="background:#3a3c3a;">
                    <tbody>
                        <tr>
                            <td align="center" valign="top">

                                <!--Logo part Start-->

                                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                                    <tbody>
                                        <tr>
                                            <td align="center" valign="top">
                                                <table width="700" border="0" align="center" cellpadding="0" cellspacing="0" class="main">
                                                    <tbody>
                                                        <tr>
                                                            <td align="left" valign="top" bgcolor="#9f8827a3" style="background:#9f8827a3;">
                                                                <table width="630" border="0" align="center" cellpadding="0" cellspacing="0" class="two-left">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td height="35" align="left" valign="top" style="line-height:35px;">&nbsp;</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td align="left" valign="top">


                                                                                <table width="135" border="0" align="left" cellpadding="0" cellspacing="0" class="two-left">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td align="center" valign="top">
                                                                                                <table width="135" border="0" cellspacing="0" cellpadding="0">
                                                                                                    <tbody>
                                                                                                         
                                                                                                    </tbody>
                                                                                                </table>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td height="35" align="left" valign="top" style="line-height:35px;">&nbsp;</td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>

                                                                                <table width="405" border="0" align="right" cellpadding="0" cellspacing="0" class="two-left">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td align="left" valign="top">


                                                                                                <table width="105" border="0" align="left" cellpadding="0" cellspacing="0" class="two-left">
                                                                                                    <tbody>
                                                                                                        <tr>
                                                                                                            <td align="center" valign="top">
                                                                                                                <a href="#"><img src="https://claimsmanager.online/assets/img/logo_large_white.png" width="200" height="22" alt="" style="width: 200px;height: auto;"></a>
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td height="20" align="left" valign="top" style="line-height:20px;">&nbsp;</td>
                                                                                                        </tr>
                                                                                                    </tbody>
                                                                                                </table>

                                                                                                <table border="0" align="right" cellpadding="0" cellspacing="0" class="two-left">
                                                                                                    <tbody>
                                                                                                        <tr>
                                                                                                            <td align="center" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; font-weight:bold; text-transform:uppercase; color:#FFF; padding-top:4px;">
                                                                                                                <a href="https://claimsmanager.online" target="_blank" style="text-decoration:none; color:#FFF;">Ir a sitio</a>
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td height="35" align="left" valign="top" style="line-height:35px;">&nbsp;</td>
                                                                                                        </tr>
                                                                                                    </tbody>
                                                                                                </table>


                                                                                            </td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>


                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <!--Logo part End-->


                                <!--Banner part Start-->

                                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                                    <tbody>
                                        <tr>
                                            <td align="center" valign="top">
                                                <table width="700" border="0" align="center" cellpadding="0" cellspacing="0" class="main">
                                                    <tbody>
                                                        <tr>
                                                            <td align="left" valign="top" bgcolor="#ae9a49" style="background:#ae9a49;">

                                                                <table width="320" border="0" align="right" cellpadding="0" cellspacing="0" class="full">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td align="center" valign="top"><img src="https://claimsmanager.online/assets/img/icons/file.png" width="320" height="435" alt="" style="display:block;width:100% !important; height:auto !important;"></td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>

                                                                <table width="350" border="0" cellspacing="0" cellpadding="0" class="full">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td height="235" align="left" valign="bottom">
                                                                                <table width="280" border="0" align="center" cellpadding="0" cellspacing="0">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td align="left" valign="top">
                                                                                                <table width="105" border="0" align="left" cellpadding="0" cellspacing="0">
                                                                                                    <tbody>
                                                                                                        <tr>
                                                                                                            <td width="95" align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; font-weight:bold; text-transform:uppercase; color:#FFF;"><a href="'. $data['linkpdf'] .'" target="_blank" style="text-decoration:none; color:#FFF;">Descargar</a></td>
                                                                                                            <td width="10" align="center" valign="middle"><img src="https://claimsmanager.online/assets/img/icons/read-more.png" width="10" height="10" alt="" style="display:block;"></td>
                                                                                                        </tr>
                                                                                                    </tbody>
                                                                                                </table>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:36px; font-weight:bold; text-transform:uppercase; color:#FFF; line-height:48px; padding-top:16px;">Te envían un archivo</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td height="50" align="left" valign="top" style="line-height:50px;">&nbsp;</td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>



                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <!--Banner part End-->


                                <!--Welcome part Start-->

                                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                                    <tbody>
                                        <tr>
                                            <td align="center" valign="top">
                                                <table width="700" border="0" align="center" cellpadding="0" cellspacing="0" class="main">
                                                    <tbody>
                                                        <tr>
                                                            <td align="left" valign="top" bgcolor="#9f8827a3" style="background:#9f8827a3;">
                                                                <table width="530" border="0" align="center" cellpadding="0" cellspacing="0" class="two-left">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td height="95" align="left" valign="top" style="line-height:95px;">&nbsp;</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td align="center" valign="top">
                                                                                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td align="center" valign="top">
                                                                                                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                                                                                                    <tbody>
                                                                                                        <tr>
                                                                                                            <td align="center" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:16px; font-weight:bold; text-transform:uppercase; color:#FFF;">'.$data['c1'].' <br>'.$data['c2'].'<br>'.$data['c3'].' </td>
                                                                                                        </tr>
                                                                                                    </tbody>
                                                                                                </table>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td align="center" valign="top" style="font-family:Verdana, Geneva, sans-serif; font-size:16px; font-weight:normal;color:#FFF; line-height:36px; padding-bottom:15px;">
                                                                                                '. $data['textMail'] .'
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td align="center" valign="top">
                                                                                            El documento se encuentra adjunto en este correo.
                                                                                            </td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td height="95" align="left" valign="top" style="line-height:95px;">&nbsp;</td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <!--Welcome part End-->

                                <!--contact-image Start-->

                                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                                    <tbody>
                                        <tr>
                                            <td align="center" valign="top">
                                            <table width="700" border="0" align="center" cellpadding="0" cellspacing="0" class="main">
                                                <tbody>
                                                    <tr>
                                                        <td align="center" valign="top" bgcolor="#FFFFFF" style="background:#FFF;overflow:hidden;background-image: url(http://claimsmanager.online/assets/img/bg/1.1.jpg)">
                                                        <img width="580" src="https://claimsmanager.online/'.$_SESSION['firma'].'" style="position: absolute;left: 0;right: 0;margin: auto;margin-top: 13px;">
                                                        </td>

                                                    </tr>
                                                </tbody>
                                            </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <!--contact-image End-->


                                <!--copyright Start-->

                                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                                    <tbody>
                                        <tr>
                                            <td align="center" valign="top">
                                                <table width="700" border="0" align="center" cellpadding="0" cellspacing="0" class="main">
                                                    <tbody>
                                                        <tr>
                                                            <td align="left" valign="top" bgcolor="#ae9a49" style="background:#ae9a49;">
                                                                <table width="580" border="0" align="center" cellpadding="0" cellspacing="0" class="two-left">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td height="60" align="left" valign="middle" style="font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:normal;color:#FFF;">Copyright © 2022 smart mail. información confidencial. power by asicomgraphics.mx</td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <!--copyright End-->


                            </td>
                        </tr>
                    </tbody>
                </table>

                <!--Main Table End-->



            </body>
            
        </html>';

        if (isset($data['linkfile'])){  // si este existe, el link es de un archivo verdadero.
            // $filename = $data['c1']."-".$data['c3'].".pdf";
            // $pdfdoc = $data['linkfile'];

            $ext=explode('.',$data['link']);
            $max = count($ext);
            
            $filename = $data['c1']."-".$data['c3'].'.'.$ext[$max-1];
            $pdfdoc = file_get_contents(urldecode($data['link']));
            $pdfdoc = str_replace("%3Cstrong%3ES%2FN%3C%2Fstrong%3E", "%26nbsp%3B%26nbsp%3B%26nbsp%3B%26nbsp%3B%3Cstrong%3ES%2FN%3C%2Fstrong%3E",$pdfdoc );
            $pdfdoc = str_replace("%3Cstrong%3ES%2FN%3C%2Fstrong%3E", "%26nbsp%3B%26nbsp%3B%26nbsp%3B%26nbsp%3B%3Cstrong%3ES%2FN%3C%2Fstrong%3E", $pdfdoc);
            $pdfdoc = str_replace("%0A%3Cp%3E%26nbsp%3B%3C%2Fp%3E%0A%0A%3Cp%3E%26nbsp%3B%3C%2Fp%3E%0A%0A%3Cp%3E%26nbsp%3B%3C%2Fp%3E%0A%0A%3Cp%3E%26nbsp%3B%3C%2Fp%3E%0A%0A%3Cp%3E%26nbsp%3B%3C%2Fp%3E%0A%0A%3Cp%3E%26nbsp%3B%3C%2Fp%3E%0A","", $pdfdoc);
            $pdfdoc = str_replace("%0A%3Cp%3E%26nbsp%3B%3C%2Fp%3E%0A%0A%3Cp+style%3D%22text-align%3Acenter%22%3E%26nbsp%3B%3C%2Fp%3E%0A%0A%3Cp%3E%26nbsp%3B%3C%2Fp%3E%0A%0A%3Cp%3E%26nbsp%3B%3C%2Fp%3E%0A%0A%3Cp%3E%26nbsp%3B%3C%2Fp%3E%0A%0A%3Cp%3E%26nbsp%3B%3C%2Fp%3E%0A","", $pdfdoc);
            $pdfdoc = str_replace("%0A%3Cp%3E%26nbsp%3B%3C%2Fp%3E%0A%0A%3Cp%3E%26nbsp%3B%3C%2Fp%3E%0A%0A%3Cp+style%3D%22text-align%3Acenter%22%3E%26nbsp%3B%3C%2Fp%3E%0A%0A%3Cp+style%3D%22text-align%3Acenter%22%3E%26nbsp%3B%3C%2Fp%3E%0A%0A%3Cp+style%3D%22text-align%3Acenter%22%3E%26nbsp%3B%3C%2Fp%3E%0A%0A%3Cp+style%3D%22text-align%3Acenter%22%3E%26nbsp%3B%3C%2Fp%3E%0A","", $pdfdoc);
            $pdfdoc = str_replace("%0A%3Cp+style%3D%22text-align%3Ajustify%22%3E%26nbsp%3B%3C%2Fp%3E%0A%0A%3Cp+style%3D%22text-align%3Ajustify%22%3E%26nbsp%3B%3C%2Fp%3E%0A%0A%3Cp+style%3D%22text-align%3Ajustify%22%3E%26nbsp%3B%3C%2Fp%3E%0A%0A%3Cp+style%3D%22text-align%3Ajustify%22%3E%26nbsp%3B%3C%2Fp%3E%0A%0A%3Cp+style%3D%22text-align%3Ajustify%22%3E%26nbsp%3B%3C%2Fp%3E%0A%0A%3Cp+style%3D%22text-align%3Ajustify%22%3E%26nbsp%3B%3C%2Fp%3E%0A","", $pdfdoc);
            $pdfdoc = str_replace("%3Cp%3E%26nbsp%3B%3C%2Fp%3E%0A%0A%3Cp%2Bstyle%3D%22text-align%3Acenter%22%3E%26nbsp%3B%3C%2Fp%3E%0A%0A%3Cp%3E%26nbsp%3B%3C%2Fp%3E","", $pdfdoc);
            //echo "aqui";
            
        }
        else { // si no , el link es de un render pdf (formato a renderizar)
            include "./pdf/sendFileF-mail.php";///termina en  $html2pdf->output($_REQUEST['doc']."-".$_REQUEST['areaNombre'].".pdf");
            $filename = $data['c1']."-".$data['c3'].".pdf";
            //echo $filename;
            $pdfdoc = $html2pdf->Output('', 'S');

        }

        // core::preprint($pdfdoc,'',true);
        $email = $data['listSenders'];
        //$subject = 'Se envía un archivo de  ->'.$data['areaNombre'].' - '.$data['folio'].' : '.$data['c1'].'/'.$data['c3'];
       
        $subject = $data['asunto'];

        // core::preprint($pdfdoc);exit();

        return $send = Correo::sendMailFiles($msg,$email,$subject,$debug=0,$pdfdoc,$filename);
        // echo "ok;";

    }




    /* ***************************[ ACTIVAR ASIGNACION Y/O ASIGNAR AREA. ]*********************************** */
    //** ESTE MAIL VA PARA TODOS LOS ABOGADOS CUANDO SU AREA ES ASIGNADA, O CUANDO SE LE ASIGNO AL ABOGADO.
    public static function send_notify_assign_id($timerst,$emails,$idAreas=[])
    {

       /*  core::preprint($timerst,'timer');
        core::preprint($emails,'mails');
        core::preprint($idAreas,'areasd'); */

        //si el :idAreas es 0, entonces no hay area, y es asignacion de abogado, se debe sacar el ID y nombre del area para mail.
        $areas=[];
        if($idAreas==[]){
            foreach ($emails as $k) {
                $sql = "SELECT a.area from gruposusuario gu 
                INNER JOIN areas a ON a.id = gu.idArea
                where idUsuario = ".$k['id'];
                $query = Database::ExeDoIt($sql,false);
                $areas = Model::many_assoc($query[0]);
            }
        }
        else if (isset($idAreas[0]) && is_numeric($idAreas[0])){
            //si es numerico, quiere decir que ya trae ids de las areas
            foreach ($idAreas as $k) {
                $sql = "SELECT a.area from areas a 
                where a.id = $k";
                $query = Database::ExeDoIt($sql,false);
                $areas = Model::many_assoc($query[0]);
            }
        }

        //obtener el folio del timerst
        $sql="select concat(s.f_numProv,'-',LPAD(s.f_consecutivo,3,'0'), '-',SUBSTRING(s.f_year, 3)) folio from siniestros s where s.timerst= '$timerst' limit 1";
        $query=Database::ExeDoIt($sql,false);
        $folio = Model::many_assoc($query[0])[0]['folio'];
        // core::preprint($data);exit();
           
        $msg = '
        <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
                <title>CMA Mail</title><meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;"><meta charset="utf-8" />
                <style type="text/css">body{ width: 100%; background-color: #3a3c3a; margin: 0; padding: 0; -webkit-font-smoothing: antialiased; mso-margin-top-alt: 0px; mso-margin-bottom-alt: 0px; mso-padding-alt: 0px 0px 0px 0px;} p, h1, h2, h3, h4{ margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0;} span.preheader{ display: none; font-size: 1px;} html{ width: 100%;} table{ font-size: 12px; border: 0;} .menu-space{ padding-right: 25px;} table{ mso-table-lspace: 0pt; mso-table-rspace: 0pt;} img{ -ms-interpolation-mode: bicubic; border: none;} a, a:hover{ text-decoration: none; color: #FFF;} p{ text-align: left;} @media only screen and (max-width:640px){ body{ width: auto!important;} body[yahoo] table[class=main]{ width: 440px !important;} body[yahoo] table[class=two-left]{ width: 420px !important; margin: 0px auto;} body[yahoo] table[class=full]{ width: 100% !important; margin: 0px auto;} body[yahoo] table[class=alaine]{ text-align: center;} body[yahoo] table[class=menu-space]{ padding-right: 0px;} body[yahoo] table[class=banner]{ width: 438px !important;} body[yahoo] table[class=menu]{ width: 438px !important; margin: 0px auto; border-bottom: #e1e0e2 solid 1px;} body[yahoo] table[class=date]{ width: 438px !important; margin: 0px auto; text-align: center;} body[yahoo] table[class=two-left-inner]{ width: 400px !important; margin: 0px auto;} body[yahoo] table[class=menu-icon]{ display: block;} body[yahoo] table[class=two-left-menu]{ text-align: center;} p{ text-align: center;}} @media only screen and (max-width:479px){ body{ width: auto!important;} body[yahoo] table[class=main]{ width: 310px !important;} body[yahoo] table[class=two-left]{ width: 300px !important; margin: 0px auto;} body[yahoo] table[class=full]{ width: 100% !important; margin: 0px auto;} body[yahoo] table[class=alaine]{ text-align: center;} body[yahoo] table[class=menu-space]{ padding-right: 0px;} body[yahoo] table[class=banner]{ width: 308px !important;} body[yahoo] table[class=menu]{ width: 308px !important; margin: 0px auto; border-bottom: #e1e0e2 solid 1px;} body[yahoo] table[class=date]{ width: 308px !important; margin: 0px auto; text-align: center;} body[yahoo] table[class=two-left-inner]{ width: 280px !important; margin: 0px auto;} body[yahoo] table[class=menu-icon]{ display: none;} body[yahoo] table[class=two-left-menu]{ width: 310px !important; margin: 0px auto;} p{ text-align: center;}} </style>

            </head>

            <body yahoo="fix" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

                <!--Main Table Start-->

                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#3a3c3a" style="background:#3a3c3a;">
                    <tbody>
                        <tr>
                            <td align="center" valign="top">

                                <!--Logo part Start-->

                                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                                    <tbody>
                                        <tr>
                                            <td align="center" valign="top">
                                                <table width="700" border="0" align="center" cellpadding="0" cellspacing="0" class="main">
                                                    <tbody>
                                                        <tr>
                                                            <td align="left" valign="top" bgcolor="#9f8827a3" style="background:#9f8827a3;">
                                                                <table width="630" border="0" align="center" cellpadding="0" cellspacing="0" class="two-left">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td height="35" align="left" valign="top" style="line-height:35px;">&nbsp;</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td align="left" valign="top">


                                                                                <table width="135" border="0" align="left" cellpadding="0" cellspacing="0" class="two-left">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td align="center" valign="top">
                                                                                                <table width="135" border="0" cellspacing="0" cellpadding="0">
                                                                                                    <tbody>
                                                                                                          
                                                                                                    </tbody>
                                                                                                </table>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td height="35" align="left" valign="top" style="line-height:35px;">&nbsp;</td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>

                                                                                <table width="405" border="0" align="right" cellpadding="0" cellspacing="0" class="two-left">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td align="left" valign="top">


                                                                                                <table width="105" border="0" align="left" cellpadding="0" cellspacing="0" class="two-left">
                                                                                                    <tbody>
                                                                                                        <tr>
                                                                                                            <td align="center" valign="top">
                                                                                                                <a href="#"><img src="https://claimsmanager.online/assets/img/logo_large_white.png" width="200" height="22" alt="" style="width: 200px;height: auto;"></a>
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td height="20" align="left" valign="top" style="line-height:20px;">&nbsp;</td>
                                                                                                        </tr>
                                                                                                    </tbody>
                                                                                                </table>

                                                                                                <table border="0" align="right" cellpadding="0" cellspacing="0" class="two-left">
                                                                                                    <tbody>
                                                                                                        <tr>
                                                                                                            <td align="center" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; font-weight:bold; text-transform:uppercase; color:#FFF; padding-top:4px;">
                                                                                                                <a href="https://claimsmanager.online" target="_blank" style="text-decoration:none; color:#FFF;">Ir a sitio</a>
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td height="35" align="left" valign="top" style="line-height:35px;">&nbsp;</td>
                                                                                                        </tr>
                                                                                                    </tbody>
                                                                                                </table>


                                                                                            </td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>


                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <!--Logo part End-->


                                <!--Banner part Start-->

                                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                                    <tbody>
                                        <tr>
                                            <td align="center" valign="top">
                                                <table width="700" border="0" align="center" cellpadding="0" cellspacing="0" class="main">
                                                    <tbody>
                                                        <tr>
                                                            <td align="left" valign="top" bgcolor="#ae9a49" style="background:#ae9a49;">

                                                                <table width="320" border="0" align="right" cellpadding="0" cellspacing="0" class="full">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td align="center" valign="top"></td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>

                                                                <table width="350" border="0" cellspacing="0" cellpadding="0" class="full">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td height="335" align="left" valign="bottom">
                                                                                <table width="280" border="0" align="center" cellpadding="0" cellspacing="0">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td align="left" valign="top">
                                                                                                <table width="105" border="0" align="left" cellpadding="0" cellspacing="0">
                                                                                                    <tbody>
                                                                                                        <tr>
                                                                                                            <td width="95" align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; font-weight:bold; text-transform:uppercase; color:#FFF;"><a href="https://claimsmanager.online/?view=siniestro/ver&param='. $timerst .'" target="_blank" style="text-decoration:none; color:#FFF;">Ir al ID </a></td>
                                                                                                            <td width="10" align="center" valign="middle"><img src="https://claimsmanager.online/assets/img/icons/read-more.png" width="10" height="10" alt="" style="display:block;"></td>
                                                                                                        </tr>
                                                                                                    </tbody>
                                                                                                </table>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:36px; font-weight:bold; text-transform:uppercase; color:#FFF; line-height:48px; padding-top:16px;">Se acaba de asignar el ID '. $folio .'</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td height="50" align="left" valign="top" style="line-height:50px;">&nbsp;</td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>



                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <!--Banner part End-->


                                <!--Welcome part Start-->

                                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                                    <tbody>
                                        <tr>
                                            <td align="center" valign="top">
                                                <table width="700" border="0" align="center" cellpadding="0" cellspacing="0" class="main">
                                                    <tbody>
                                                        <tr>
                                                            <td align="left" valign="top" bgcolor="#9f8827a3" style="background:#9f8827a3;">
                                                                <table width="530" border="0" align="center" cellpadding="0" cellspacing="0" class="two-left">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td height="95" align="left" valign="top" style="line-height:95px;">&nbsp;</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td align="center" valign="top">
                                                                                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td align="center" valign="top">
                                                                                                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                                                                                                    <tbody>
                                                                                                        <tr>
                                                                                                            <td align="center" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:18px; font-weight:bold; text-transform:uppercase; color:#FFF;">Se ha asignado al área de </td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td align="center" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:50px; font-weight:bold; text-transform:uppercase; color:#FFF; padding:10px 0px 15px 0px;">
                                                                                                            ';
                                                                                                            foreach ($areas as $a) {
                                                                                                                $msg.= $a['area']. '<br>';
                                                                                                                // Siniestros
                                                                                                            }
                                                                                                            $msg.='
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                    </tbody>
                                                                                                </table>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td align="center" valign="top" style="font-family:Verdana, Geneva, sans-serif; font-size:16px; font-weight:normal;color:#FFF; line-height:36px; padding-bottom:15px;">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td align="center" valign="top">
                                                                                                <table width="185" border="0" align="center" cellpadding="0" cellspacing="0">
                                                                                                    <tbody>
                                                                                                        <tr>
                                                                                                            <td align="center" valign="top">&nbsp;</td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td height="45" align="center" valign="middle" style=" border:#ffffff solid 2px; font-family:Arial, Helvetica, sans-serif; font-size:18px; font-weight:bold; text-transform:uppercase; color:#FFF;">
                                                                                                                <a href="https://claimsmanager.online/?view=siniestro/ver&param='. $timerst .'" target="_blank" style="cursor:pointer;text-decoration:none; color:#FFF;">Ver ID</a>
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                    </tbody>
                                                                                                </table>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td height="95" align="left" valign="top" style="line-height:95px;">&nbsp;</td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <!--Welcome part End-->

                                <!--contact-image Start-->

                                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                                    <tbody>
                                        <tr>
                                            <td align="center" valign="top">
                                            <table width="700" border="0" align="center" cellpadding="0" cellspacing="0" class="main">
                                                <tbody>
                                                <tr>
                                                    <td align="left" valign="top" bgcolor="#FFFFFF" style="background:#FFF;overflow:hidden;background-image: url(http://claimsmanager.online/assets/img/bg/1.1.jpg)">

                                                </tr>
                                                </tbody>
                                            </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <!--contact-image End-->

                                <!--copyright Start-->

                                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                                    <tbody>
                                        <tr>
                                            <td align="center" valign="top">
                                                <table width="700" border="0" align="center" cellpadding="0" cellspacing="0" class="main">
                                                    <tbody>
                                                        <tr>
                                                            <td align="left" valign="top" bgcolor="#ae9a49" style="background:#ae9a49;">
                                                                <table width="580" border="0" align="center" cellpadding="0" cellspacing="0" class="two-left">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td height="60" align="left" valign="middle" style="font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:normal;color:#FFF;">Copyright © 2022 smart mail. información confidencial. power by asicomgraphics.mx</td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <!--copyright End-->


                            </td>
                        </tr>
                    </tbody>
                </table>

                <!--Main Table End-->



            </body>
            
        </html>';

        $subject = 'Se ha asignado el ID '.$folio;
        // require_once "./core/controller/Correo.php";
        return $send = Correo::sendMail_varios_abogados($msg,$emails,$subject,$debug=0);

    }
    


    /* ***************************[ INHABILITAR ASIGNACION DE ABOGADO]*********************************** */
    

    /* ***************************[ INHABILITAR ASIGNACION DE AREA ]*********************************** */



    /* ***************************[ CORREO DE RECUPERACION DE PASSWORD]*********************************** */
    public static function send_recovery_password($email,$nombre,$fecha,$key,$timerst){
        $msg = '
        <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
                <title>CMA Mail</title><meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;"><meta charset="utf-8" />
                <style type="text/css">body{ width: 100%; background-color: #3a3c3a; margin: 0; padding: 0; -webkit-font-smoothing: antialiased; mso-margin-top-alt: 0px; mso-margin-bottom-alt: 0px; mso-padding-alt: 0px 0px 0px 0px;} p, h1, h2, h3, h4{ margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0;} span.preheader{ display: none; font-size: 1px;} html{ width: 100%;} table{ font-size: 12px; border: 0;} .menu-space{ padding-right: 25px;} table{ mso-table-lspace: 0pt; mso-table-rspace: 0pt;} img{ -ms-interpolation-mode: bicubic; border: none;} a, a:hover{ text-decoration: none; color: #FFF;} p{ text-align: left;} @media only screen and (max-width:640px){ body{ width: auto!important;} body[yahoo] table[class=main]{ width: 440px !important;} body[yahoo] table[class=two-left]{ width: 420px !important; margin: 0px auto;} body[yahoo] table[class=full]{ width: 100% !important; margin: 0px auto;} body[yahoo] table[class=alaine]{ text-align: center;} body[yahoo] table[class=menu-space]{ padding-right: 0px;} body[yahoo] table[class=banner]{ width: 438px !important;} body[yahoo] table[class=menu]{ width: 438px !important; margin: 0px auto; border-bottom: #e1e0e2 solid 1px;} body[yahoo] table[class=date]{ width: 438px !important; margin: 0px auto; text-align: center;} body[yahoo] table[class=two-left-inner]{ width: 400px !important; margin: 0px auto;} body[yahoo] table[class=menu-icon]{ display: block;} body[yahoo] table[class=two-left-menu]{ text-align: center;} p{ text-align: center;}} @media only screen and (max-width:479px){ body{ width: auto!important;} body[yahoo] table[class=main]{ width: 310px !important;} body[yahoo] table[class=two-left]{ width: 300px !important; margin: 0px auto;} body[yahoo] table[class=full]{ width: 100% !important; margin: 0px auto;} body[yahoo] table[class=alaine]{ text-align: center;} body[yahoo] table[class=menu-space]{ padding-right: 0px;} body[yahoo] table[class=banner]{ width: 308px !important;} body[yahoo] table[class=menu]{ width: 308px !important; margin: 0px auto; border-bottom: #e1e0e2 solid 1px;} body[yahoo] table[class=date]{ width: 308px !important; margin: 0px auto; text-align: center;} body[yahoo] table[class=two-left-inner]{ width: 280px !important; margin: 0px auto;} body[yahoo] table[class=menu-icon]{ display: none;} body[yahoo] table[class=two-left-menu]{ width: 310px !important; margin: 0px auto;} p{ text-align: center;}} </style>

            </head>

            <body yahoo="fix" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

                <!--Main Table Start-->

                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#3a3c3a" style="background:#3a3c3a;">
                    <tbody>
                        <tr>
                            <td align="center" valign="top">

                                <!--Logo part Start-->

                                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                                    <tbody>
                                        <tr>
                                            <td align="center" valign="top">
                                                <table width="700" border="0" align="center" cellpadding="0" cellspacing="0" class="main">
                                                    <tbody>
                                                        <tr>
                                                            <td align="left" valign="top" bgcolor="#9f8827a3" style="background:#9f8827a3;">
                                                                <table width="630" border="0" align="center" cellpadding="0" cellspacing="0" class="two-left">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td height="35" align="left" valign="top" style="line-height:35px;">&nbsp;</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td align="left" valign="top">


                                                                                <table width="135" border="0" align="left" cellpadding="0" cellspacing="0" class="two-left">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td align="center" valign="top">
                                                                                                <table width="135" border="0" cellspacing="0" cellpadding="0">
                                                                                                    <tbody>
                                                                                                        
                                                                                                    </tbody>
                                                                                                </table>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td height="35" align="left" valign="top" style="line-height:35px;">&nbsp;</td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>

                                                                                <table width="405" border="0" align="right" cellpadding="0" cellspacing="0" class="two-left">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td align="left" valign="top">


                                                                                                <table width="105" border="0" align="left" cellpadding="0" cellspacing="0" class="two-left">
                                                                                                    <tbody>
                                                                                                        <tr>
                                                                                                            <td align="center" valign="top">
                                                                                                                <a href="#"><img src="https://claimsmanager.online/assets/img/logo_large_white.png" width="200" height="22" alt="" style="width: 200px;height: auto;"></a>
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td height="20" align="left" valign="top" style="line-height:20px;">&nbsp;</td>
                                                                                                        </tr>
                                                                                                    </tbody>
                                                                                                </table>

                                                                                                <table border="0" align="right" cellpadding="0" cellspacing="0" class="two-left">
                                                                                                    <tbody>
                                                                                                        <tr>
                                                                                                            <td align="center" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; font-weight:bold; text-transform:uppercase; color:#FFF; padding-top:4px;">
                                                                                                                <a href="https://claimsmanager.online" target="_blank" style="text-decoration:none; color:#FFF;">Ir a sitio</a>
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td height="35" align="left" valign="top" style="line-height:35px;">&nbsp;</td>
                                                                                                        </tr>
                                                                                                    </tbody>
                                                                                                </table>


                                                                                            </td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>


                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <!--Logo part End-->


                                <!--Banner part Start-->

                                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                                    <tbody>
                                        <tr>
                                            <td align="center" valign="top">
                                                <table width="700" border="0" align="center" cellpadding="0" cellspacing="0" class="main">
                                                    <tbody>
                                                        <tr>
                                                            <td align="left" valign="top" bgcolor="#ae9a49" style="background:#ae9a49;">

                                                                
                                                                <table width="280" border="0" align="right" cellpadding="0" cellspacing="0" class="full">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td align="center" valign="top"><img src="https://claimsmanager.online/assets/img/icons/pass.png" width="280" height="auto" alt="" style="display:block;width:100% !important; height:auto !important;"></td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>

                                                                <table width="350" border="0" cellspacing="0" cellpadding="0" class="full">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td height="250" align="left" valign="bottom">
                                                                                <table width="280" border="0" align="center" cellpadding="0" cellspacing="0">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td align="left" valign="top">
                                                                                                <table width="105" border="0" align="left" cellpadding="0" cellspacing="0">
                                                                                                    <tbody>
                                                                                                        <tr>
                                                                                                            <td width="95" align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; font-weight:bold; text-transform:uppercase; color:#FFF;"><a href="http://localhost/cma/index.php?recoveryMail=' . $email . '&timerstkey='. $timerst .'" target="_blank" style="text-decoration:none; color:#FFF;">Cambiar Password</a></td>
                                                                                                            <td width="10" align="center" valign="middle"><img src="https://claimsmanager.online/assets/img/icons/read_more.png" width="10" height="10" alt="" style="display:block;"></td>
                                                                                                        </tr>
                                                                                                    </tbody>
                                                                                                </table>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:36px; font-weight:bold; text-transform:uppercase; color:#FFF; line-height:48px; padding-top:16px;">Recuperar Password </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td height="50" align="left" valign="top" style="line-height:1.1em;">Por motivos de seguridad, no podemos proporcionar la contraseña anterior, por lo que debe generarse un nuevo password a través de este email.</td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>



                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <!--Banner part End-->


                                <!--Welcome part Start-->

                                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                                    <tbody>
                                        <tr>
                                            <td align="center" valign="top">
                                                <table width="700" border="0" align="center" cellpadding="0" cellspacing="0" class="main">
                                                    <tbody>
                                                        <tr>
                                                            <td align="left" valign="top" bgcolor="#9f8827a3" style="background:#9f8827a3;">
                                                                <table width="530" border="0" align="center" cellpadding="0" cellspacing="0" class="two-left">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td height="95" align="left" valign="top" style="line-height:95px;">&nbsp;</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td align="center" valign="top">
                                                                                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td align="center" valign="top">
                                                                                                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                                                                                                    <tbody>
                                                                                                        <tr>
                                                                                                            <td height="50" align="left" valign="top" style="color:#FFF;font-family:Arial, Helvetica, sans-serif; font-size:28px; font-weight:bold;line-height:1.1em;color:white;">Copia este Key en la página para restablecer la contraseña.</td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td align="center" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:50px; font-weight:bold; color:#FFF; padding:10px 0px 15px 0px;">
                                                                                                                
                                                                                                            '.$key.'
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                    </tbody>
                                                                                                </table>
                                                                                            </td>
                                                                                        </tr>
                                                                                        
                                                                                        <tr>
                                                                                            <td align="center" valign="top">
                                                                                                <table width="185" border="0" align="center" cellpadding="0" cellspacing="0">
                                                                                                    <tbody>
                                                                                                        <tr>
                                                                                                            <td align="center" valign="top">&nbsp;</td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td height="45" align="center" valign="middle" style=" border:#ffffff solid 2px; font-family:Arial, Helvetica, sans-serif; font-size:18px; font-weight:bold; text-transform:uppercase; color:#FFF;">
                                                                                                                <a href="http://localhost/cma/index.php?recoveryMail=' . $email . '&timerstkey='. $timerst .'" target="_blank" style="cursor:pointer;text-decoration:none; color:#FFF;">Cambiar Password</a>
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                    </tbody>
                                                                                                </table>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td height="95" align="left" valign="top" style="line-height:95px;">&nbsp;</td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <!--Welcome part End-->

                                <!--contact-image Start-->

                                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                                    <tbody>
                                        <tr>
                                            <td align="center" valign="top">
                                            <table width="700" border="0" align="center" cellpadding="0" cellspacing="0" class="main">
                                                <tbody>
                                                    <tr>
                                                        <td align="left" valign="top" bgcolor="#FFFFFF" style="background:#FFF;overflow:hidden;background-image: url(http://claimsmanager.online/assets/img/bg/1.1.jpg)">
                                                        <img width="580" src="https://claimsmanager.online/'.$_SESSION['firma'].'" style="position: absolute;left: 0;right: 0;margin: auto;margin-top: 13px;">
                                                        </td>

                                                    </tr>
                                                </tbody>
                                            </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <!--contact-image End-->


                                <!--copyright Start-->

                                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                                    <tbody>
                                        <tr>
                                            <td align="center" valign="top">
                                                <table width="700" border="0" align="center" cellpadding="0" cellspacing="0" class="main">
                                                    <tbody>
                                                        <tr>
                                                            <td align="left" valign="top" bgcolor="#ae9a49" style="background:#ae9a49;">
                                                                <table width="580" border="0" align="center" cellpadding="0" cellspacing="0" class="two-left">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td height="60" align="left" valign="middle" style="font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:normal;color:#FFF;">Copyright © 2022 smart mail. información confidencial. power by asicomgraphics.mx</td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <!--copyright End-->


                            </td>
                        </tr>
                    </tbody>
                </table>

                <!--Main Table End-->



            </body>
            
        </html>';

        $emailT[0]['email']=$email;
        $emailT[0]['nombre']=$nombre;

        $subject = $nombre.'  Cambia la contraseña de tu cuenta CMAbogados.';
        // require_once "./core/controller/Correo.php";
        return $send = Correo::sendMail_varios_abogados($msg,$emailT,$subject,$debug=0);

    }

    
}