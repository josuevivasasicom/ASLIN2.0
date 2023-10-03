<?php
// @elmm Define las funciones del correo para usar mas facilmente desde cualquier vista o accion sin importar el modulo

$_phpmailer_autoload = "./extensiones/phpmailer/PHPMailer/PHPMailerAutoload.php";
$_phpmailer_vendor =   "./extensiones/phpmailer/vendor/autoload.php";


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
    public static function sendMail($msg,$email,$subject,$debug=0)
    {
        require_once "./extensiones/phpmailer/PHPMailer/PHPMailerAutoload.php";
        require_once "./extensiones/phpmailer/vendor/autoload.php";

        $mail = new PHPMailer;
        $mail->SMTPDebug  = $debug;
        $mail->CharSet = 'UTF-8';
        $mail->isMail();
        $mail->setFrom('contacto@grupodiemsa.com', 'GRUPO DIEMSA');
        $mail->addReplyTo('contacto@grupodiemsa.com', 'GRUPO DIEMSA');
        $mail->Subject = $subject;
        $mail->addAddress($email);
        $mail->msgHTML($msg);
        if(!$envio = $mail->Send()){
            echo "ERROR";
        }
        else{
        	echo "EXITO";
        }
        //core::preprint($envio);
    }


      /* ***************************[ CORREO DE CONFIRMACION DE CITA ]*********************************** */
    //REVIEW ....
    //@param $_siglas_test  Son las siglas del hotel del que pertenece la prueba (trim al TEST)
    public static function send_confirm_schedule($data)
    {
        $subject = "Schedule COVID test!";
        $Hotel = substr($data['prueba'], 0, 3);
		$hotel_num = array_search($Hotel,Hoteles::$hoteles_corto);
        $Hotel_completo = Hoteles::$hoteles_nombres[$hotel_num];
        $hotel_link = Hoteles::$hoteles[$hotel_num];


        $tipoTest='';
        if ( $data['tipo_test'] == "Prueba PCR") {
            $tipoTest = "PCR Test";
        } else {
            $tipoTest = "Antigen Test ";
        }
        // core::preprint($data);exit();
        $msg= '
                <div style="margin:0 auto;width:95%;max-width:700px;background:#fff;color:#333333; position:relative; font-family:sans-serif; padding:0px">
                <div style="position:relative; margin:auto; width:100%; background: #89c9fa; padding-bottom:20px;padding-top:20px">
                    <center>
                        <img src="https://grupodiemsa.com/centrodeventas/vistas/img/plantilla/logo.png"
                            style="width: 35%; height: auto; display: inline-block; margin-top: 15px;">
                    </center>
                </div>
                <center>
                    <img src="https://grupodiemsa.com/hoteles/images/mail/mailbien.png"
                        style="width: 150px; height: auto; display: inline-block; margin-top: 15px;">
                    <h1 style="font-weight:300;"><b>Appointment Confirmation</b></h1>
                    <h1 style="font-weight:300;"><b>'.$data['paciente'].'</b></h1>
                    <h1 style="font-weight:300;"><b>'.$data['fechaCita'].'</b></h1>
                </center>
                <hr style="border:1px solid #101010; width:85%;margin-bottom:5px;">
                    <br><br>

                    <h3 style="font-weight:100; color: #323232">Patient: '.$data['paciente'].'</h3>
                    <br>
                    <h3 style="font-weight:100; color: #323232">Test Number: '.$data['prueba'].'</h3>
					<br>
					<h3 style="font-weight:100; color: #323232">Test Type: '.$tipoTest.'</h3>
					<br>
                    <h3 style="font-weight:100; color: #323232">Date: '.$data['fechaCita'].'</h3>
					<br>
                    <h3 style="font-weight:100; color: #323232">Place: '.$data['hotel'].'</h3>
					<br>
                    <center>
                        <br>
                        <h3 style="font-weight:100; color: #323232">If there is any change or correction of data, the schedule is Monday to Saturday from 9:00 a.m. to 6:00 p.m.</h3>
                        <br>
                    </center>
                <hr style="border:1px solid #101010; width:85%;margin-bottom:5px;">

                <div style="width:100%;height:auto;padding:5px;margin-top:25px;text-align:justify;text-justify:inter-word;">
                    <h4 style="font-weight:100; color: #999">
                        <b>NOTICE:</b> ONCE YOU REGISTER YOU MUST ADD EACH TEST REQUESTED BY PERSON ENTERING CORRECT DATA FOR THE SENDING OF YOUR REPORT (<b>FULL NAME, DATE OF BIRTH, PASSPORT NUMBER</b>).
                        <br>
                        Without your registration we will not be able to send the report on time.
                        <br>
                        <br>
                        IF YOU HAVE NOT RECEIVED YOUR REPORT:
                        <br>
                        IN ANTIGEN TESTING YOU HAVE UP TO 12 HOURS AFTER YOU HAVE TAKEN THE TEST TO REQUEST IT.
                        <br>
                        IN PCR TEST YOU HAVE 24 TO 36 HOURS AFTER HAVING PERFORMED THE TEST TO REQUEST IT.
                        <br>
                        <br>
                        IT IS IMPORTANT THAT BEFORE YOUR DEPARTURE FROM THE HOTEL YOU REVIEW AND HAVE YOUR DOCUMENT READY IN ADVANCE TO AVOID SETTLEMENTS AND IN CASE OF REQUIRING ANY MODIFICATION TO YOUR REPORT, WE HAVE TIME.
                        <br>
                        <br>
                        IN CASE OF ANY CHANGE OR CORRECTION, YOU MUST REQUEST IT FROM MONDAY TO FRIDAY FROM 9 AM TO 6:00 PM AND SATURDAYS FROM 9:00 AM TO 2:00 PM, WE DO NOT WORK ON SUNDAYS.
                    </h4>
                    ';
                    if(explode(" ", $Hotel_completo)[0]  == 'Catalonia'){ //argumento solo para Catalonia
                    $msg.='<h4 style="font-weight:100; color: #333">
                        <br>
                        To Whom It May Concern:
                        <br><br>
                        I hereby declare to assume full responsibility for showing up for the scheduled appointment. In case of no show or delay on my part, I will have to make a new appointment according to the availability and I agree to cover the cost of the test.
                        <br><br>
                        I hereby relieve and forever discharge and agree to exonerate CATALONIA HOTELS & RESORTS (SABELDOS, S.A. DE C.V.) and all of their affiliated companies from any and all action.
                    </h4>
                        <br>';
                    }
                $msg.='
                </div>
                <center>
                <div style="position:relative; margin:auto; width:100%; background: #89c9fa; padding-bottom:20px;padding-top:20px">
                        <a href="https://grupodiemsa.com/hoteles/'.$hotel_link.'" target="_blanck" style="text-decoration:none">
                            <div style="font-weight:100;width:150px;padding:15px;color:#fff;background:#3a7aab;border-radius:12px;border:1px solid #466882;">
                                <b>Access here</b>
                            </div></a>
                </div>
                <img src="https://grupodiemsa.com/centrodeventas/vistas/img/plantilla/logo.png"
                style="width: 35%; height: auto; display: inline-block; margin-top: 15px;opacity:0.6">
                </center>
                <h5 style="color:#999">Please ignore this message if you did not create an account.</h5>
        </div>';
   
        //core::preprint($msg);
        // exit();
        //core::preprint($data['email']);
        //exit();

        //?envia correo
        Correo::sendMail($msg,$data['email'],$subject);

    }







    /* ***************************[ CORREO DE RESULTADOS ]*********************************** */
    //REVIEW ....
    //@param $_siglas_test  Son las siglas del hotel del que pertenece la prueba (trim al TEST)
    public static function send_result_test($data)
    {
        $subject = "Check the result of your COVID test!";
        $Hotel = substr($data['prueba'], 0, 3);
		$hotel_num = array_search($Hotel,Hoteles::$hoteles_corto);
        $Hotel_completo = Hoteles::$hoteles_nombres[$hotel_num];
        $hotel_link = Hoteles::$hoteles[$hotel_num];


        $tipoTest='';
        if ( $data['tipoTest'] == "Prueba PCR") {
            $tipoTest = "pcr";
        } else {
            $tipoTest = "anti";
        }
        // core::preprint($data);exit();
        // <br> <h1>'. date('l jS \of F Y h:i:s A').'</h1>

        $msg= '
                <div style="margin:0 auto;width:95%;max-width:700px;background:#fff;color:#333333; position:relative; font-family:sans-serif; padding:0px">
                <div style="position:relative; margin:auto; width:100%; background: #89c9fa; padding-bottom:20px;padding-top:20px">
                    <center>
                        <img src="https://grupodiemsa.com/centrodeventas/vistas/img/plantilla/logo.png"
                            style="width: 35%; height: auto; display: inline-block; margin-top: 15px;">
                    </center>
                </div>
                <center>
                    <img src="https://grupodiemsa.com/hoteles/images/mail/'.$data['estatus'].'.png"
                        style="width: 150px; height: auto; display: inline-block; margin-top: 15px;">
                    <h1 style="font-weight:300;">Welcome <b>'.$data['nombre'].' '. $data['paterno'] .'!</b></h1>
                    <h3 style="font-weight:100;">You can now check the result of your COVID test<</h3>
                    <br> <h1>This is to inform you about the result of your COVID test held on </h1>
                    <br> <h1>'. date('l jS \of F Y').'</h1>
                   
                </center>
                <hr style="border:1px solid #101010; width:85%;margin-bottom:5px;">
                    <br><br>

                    <h3 style="font-weight:100; color: #303030">Patient: '.$data['paciente'].'</h3>
                    <br>
					<h3 style="font-weight:100; color: #303030">Result: '.$data['estatus'].'</h3>
					<br>
                    <center>
                        <a href="https://www.grupodiemsa.com/hoteles/extensiones/pdf/descargar.php?codigo='.$data['prueba'].'&tipo='.$tipoTest.'&hotel='.$Hotel.'" target="_blanck" style="text-decoration:none">
                            <div style="font-weight:100;width:150px;padding:15px;color:#fff;background:#3a7aab;border-radius:12px;border:1px solid #466882;">
                                <b>Click here to check your result</b>
                            </div>
                        </a>
                        <br>
                        <h3 style="font-weight:100; color: #323232">Once that you open the document, please check your personal information –name, birthdate, and passport number. Corrections are made from Monday to Saturday from 9:00 am to 6:00 pm.</h3>
                        <br>
                    </center>
                <hr style="border:1px solid #101010; width:85%;margin-bottom:5px;">

                <div style="width:100%;height:auto;padding:5px;margin-top:25px;text-align:justify;text-justify:inter-word;">
                    <h4 style="font-weight:100; color: #999">
                        <b>NOTICE:</b> ONCE YOU REGISTER YOU MUST ADD EACH TEST REQUESTED BY PERSON ENTERING CORRECT DATA FOR THE SENDING OF YOUR REPORT (<b>FULL NAME, DATE OF BIRTH, PASSPORT NUMBER</b>).
                        <br>
                        Without your registration we will not be able to send the report on time.
                        <br>
                        <br>
                        IF YOU HAVE NOT RECEIVED YOUR REPORT:
                        <br>
                        IN ANTIGEN TESTING YOU HAVE UP TO 12 HOURS AFTER YOU HAVE TAKEN THE TEST TO REQUEST IT.
                        <br>
                        IN PCR TEST YOU HAVE 24 TO 36 HOURS AFTER HAVING PERFORMED THE TEST TO REQUEST IT.
                        <br>
                        <br>
                        IT IS IMPORTANT THAT BEFORE YOUR DEPARTURE FROM THE HOTEL YOU REVIEW AND HAVE YOUR DOCUMENT READY IN ADVANCE TO AVOID SETTLEMENTS AND IN CASE OF REQUIRING ANY MODIFICATION TO YOUR REPORT, WE HAVE TIME.
                        <br>
                        <br>
                        IN CASE OF ANY CHANGE OR CORRECTION, YOU MUST REQUEST IT FROM MONDAY TO FRIDAY FROM 9 AM TO 6:00 PM AND SATURDAYS FROM 9:00 AM TO 2:00 PM, WE DO NOT WORK ON SUNDAYS.
                    </h4>
                    ';
                    if(explode(" ", $Hotel_completo)[0]  == 'Catalonia'){ //argumento solo para Catalonia
                    $msg.='<h4 style="font-weight:100; color: #333">
                        <br>
                        To Whom It May Concern:
                        <br><br>
                        I hereby declare to assume full responsibility for showing up for the scheduled appointment. In case of no show or delay on my part, I will have to make a new appointment according to the availability and I agree to cover the cost of the test.
                        <br><br>
                        I hereby relieve and forever discharge and agree to exonerate CATALONIA HOTELS & RESORTS (SABELDOS, S.A. DE C.V.) and all of their affiliated companies from any and all action.
                    </h4>
                        <br>';
                    }
                $msg.='
                </div>
                <center>
                <div style="position:relative; margin:auto; width:100%; background: #89c9fa; padding-bottom:20px;padding-top:20px">
                        <a href="https://grupodiemsa.com/hoteles/'.$hotel_link.'" target="_blanck" style="text-decoration:none">
                            <div style="font-weight:100;width:150px;padding:15px;color:#fff;background:#3a7aab;border-radius:12px;border:1px solid #466882;">
                                <b>Access here</b>
                            </div></a>
                </div>
                <img src="https://grupodiemsa.com/centrodeventas/vistas/img/plantilla/logo.png"
                style="width: 35%; height: auto; display: inline-block; margin-top: 15px;opacity:0.6">
                </center>
                <h5 style="color:#999">Please ignore this message if you did not create an account.</h5>
        </div>';
   
        // core::preprint($msg);
        // exit();
        //core::preprint($data['email']);
        //exit();

        //?envia correo
        Correo::sendMail($msg,$data['email'],$subject);

    }







    /* ***************************[ CORREO DE PRUEBA REGISTRADA POR EL USUARIO ]*********************************** */
    //ok - probar al nuevo folio y al update
    public static function send_register_test($data)
    {
        $subject = "Your registration is almost complete!";
       

        $msg ='
                <div style="margin:0 auto;width:95%;max-width:700px;background:#fff;color:#333333; position:relative; font-family:sans-serif; padding:0px">
                <div style="position:relative; margin:auto; width:100%; background: #89c9fa; padding-bottom:20px;padding-top:20px">
                    <center>
                        <img src="https://grupodiemsa.com/centrodeventas/vistas/img/plantilla/logo.png"
                            style="width: 35%; height: auto; display: inline-block; margin-top: 15px;">
                    </center>
                </div>
                <center>
                    <img src="https://grupodiemsa.com/hoteles/images/mail/registerTest.png"
                        style="width: 150px; height: auto; display: inline-block; margin-top: 15px;">
                    <h3 style="font-weight:300;"><b>Almost for finish '.$data['nombre'].'!</b></h3>
                    <h1 style="font-weight:100;">You have to pay the test!</h1>
                </center>
                <hr style="border:1px solid #101010; width:85%;margin-bottom:5px;">
                <br><br>
                </center>
                <div style="width:100%;height:auto;padding:5px;margin-top:25px;text-align:justify;text-justify:inter-word;">
                    <center>
                        <p>
                        Enter the platform and click on <br><b>“Pay and schedule your test online"</b></br>
                        </p>
                    </center>
                   
                </div>
                <center>
                <div style="position:relative; margin:auto; width:100%; background: #89c9fa; padding-bottom:20px;padding-top:20px">
                    <img src="https://grupodiemsa.com/centrodeventas/vistas/img/plantilla/logo.png"
                    style="width: 35%; height: auto; display: inline-block; margin-top: 15px;opacity:0.6">
                </div>
                </center>
                <h5 style="color:#999">Please ignore this message if you did not create an account.</h5>
        </div>';
   
        //core::preprint($msg);
        //core::preprint($data['email']);
        //exit();
        //?envia correo
        Correo::sendMail($msg,$data['email'],$subject);

    }







    /* ***************************[ CORREO DE BIENVENIDA - USUARIO REGISTRADO ]*********************************** */
    //ok //OK
    public static function send_register_user($data)
    {
        $email=$data['correo'];
        $subject= 'Thanks for your registration for '.$data['hotel'];
        $msg= '
                <div style="margin:0 auto;width:95%;max-width:700px;background:#fff;color:#333333; position:relative; font-family:sans-serif; padding:0px">
                <div style="position:relative; margin:auto; width:100%; background: #89c9fa; padding-bottom:20px;padding-top:20px">
                    <center>
                        <img src="https://grupodiemsa.com/centrodeventas/vistas/img/plantilla/logo.png"
                            style="width: 50%; height: auto; display: inline-block; margin-top: 15px;">
                    </center>
                </div>
                <center>
                    <img src="https://grupodiemsa.com/hoteles/images/mail/success.png"
                        style="width: 150px; height: auto; display: inline-block; margin-top: 15px;">
                    <h1 style="font-weight:300;"><b>Welcome '.$data['nombre'].' '. $data['paterno'] .'!</b></h1>
                    <h3 style="font-weight:100;">Thanks for your registration.</h3>
                    <br> <h1>'.$data['hotel'].'</h1>
                </center>
                <hr style="border:1px solid #101010; width:85%;margin-bottom:5px;">
                <br><br>
                </center>
                <div style="width:100%;height:auto;padding:5px;margin-top:25px;text-align:justify;text-justify:inter-word;">
                    <center>
                        <a href="https://grupodiemsa.com/hoteles/'.$data['hotel_link'].'" target="_blanck" style="text-decoration:none">
                            <div style="font-weight:100;width:150px;padding:15px;color:#fff;background:#3a7aab;border-radius:12px;border:1px solid #466882;">
                                <b>You may access your account here</b>
                            </div>
                        </a>
                        <h1 style="font-weight:100;color:#333 ;text-decoration:none;"><b>User: '.$data['correo'].'</b></h1>
                        <hr style="border:1px solid #333; width:85%;margin-bottom:5px;">
                        <br><br>
                    </center>
                    <h4 style="font-weight:100; color: #999">
                        <b>NOTICE:</b> Please register all the persons to be tested and the specific test you need (PCR or Antigen). Bear in mind that it is vital to write your personal information accurately since it is the same that will appear on your results (<b> NAME,BIRTH DATE AND PASSPORT NUMBER</b>).
                        <br>
                        When you schedule the test, consider that PCR tests take from 24 to 36 hours to get the results, the Antigen test is delivered about 12 hours after the sample was taken
                        <br>
                        <br>
                        Once that you receive the results, we strongly advise you to check that your personal information is correct to prevent problems at your departure. Should you require any correction, please contact our call center immediately during our customer service hours.
                        <br>
                        <br>
                        IT IS IMPORTANT THAT BEFORE YOUR DEPARTURE FROM THE HOTEL YOU REVIEW AND HAVE YOUR DOCUMENT READY IN ADVANCE TO AVOID SETTLEMENTS AND IN CASE OF REQUIRING ANY MODIFICATION TO YOUR REPORT, WE HAVE TIME.
                        <br>
                        <br>
                        IN CASE OF ANY CHANGE OR CORRECTION, YOU MUST REQUEST IT FROM MONDAY TO FRIDAY FROM 9 AM TO 6:00 PM AND SATURDAYS FROM 9:00 AM TO 2:00 PM, WE DO NOT WORK ON SUNDAYS.
                    </h4>
                    '; 
                    if(explode(" ", $data['hotel'])[0]  == 'Catalonia'){ //argumento solo para Catalonia
                    $msg.='<h4 style="font-weight:100; color: #333">
                        <br>
                        To Whom It May Concern:
                        <br><br>
                        I hereby declare to assume full responsibility for showing up for the scheduled appointment. In case of no show or delay on my part, I will have to make a new appointment according to the availability and I agree to cover the cost of the test.
                        <br><br>
                        I hereby relieve and forever discharge and agree to exonerate CATALONIA HOTELS & RESORTS (SABELDOS, S.A. DE C.V.) and all of their affiliated companies from any and all action.
                    </h4>
                        <br>';
                    }
                $msg.='
                </div>
                <center>
                <div style="position:relative; margin:auto; width:100%; background: #89c9fa; padding-bottom:20px;padding-top:20px">
                        <div style="color:#fff;padding:10px;"><h2>Register Your Test Now</h2></div>
                        <a href="https://grupodiemsa.com/hoteles/'.$data['hotel_link'].'" target="_blanck" style="text-decoration:none">
                            <div style="font-weight:100;width:150px;padding:15px;color:#fff;background:#3a7aab;border-radius:12px;border:1px solid #466882;">
                                <b>Access here</b>
                            </div></a>
                </div>
                <img src="https://grupodiemsa.com/centrodeventas/vistas/img/plantilla/logo.png"
                style="width: 35%; height: auto; display: inline-block; margin-top: 15px;opacity:0.6">
                </center>
                <h5 style="color:#999">Please ignore this message if you did not create an account.</h5>
        </div>';
        
        //print $msg;
        Correo::sendMail($msg,$email,$subject);
    }

    








    //no se usa
    public static function __sendMail__($data)
    {
        require_once $_phpmailer_autoload;
        require_once $_phpmailer_vendor;

        $valorHotel = substr('CRMEWQE', 0, 3);

        $tipoTest;

        if ( "Prueba PCR" == "Prueba PCR") {

            $tipoTest = "pcr";
        } else {
            $tipoTest = "anti";
        }
        //$respuesta = [$codigoResultado, $resultadoResultado, $fechaResultado, $nacimientoResultado, $habitacionResultado, $tipoTestResultado, $nacionalidadResultado, $origenResultado, $destinoResultado, $pasaporteResultado, $vueloResultado, $observacionesResultado, $pacienteResultado, $hotelResultado, $idUsuarioPruebaResultado];
        $mensaje ='';?>
                <div style="width:100%; background:#eee; position:relative; font-family:sans-serif; padding-bottom:40px">
                    <div style="position:relative; margin:auto; width:600px; background: #89c9fa; padding:20px">
                        <center>
                            <img src="https://grupodiemsa.com/centrodeventas/vistas/img/plantilla/logo.png"
                                style="width: 20%; height: auto; display: inline-block; margin-top: 25px;">
                        </center>
                        <center>
                            <h3 style="font-weight:100; color: #ffffff">You can now check the result of your COVID test</h3>
                            <h3 style="font-weight:100; color: #ffffff">We have assigned a result to your COVID test with the following
                                data</h3>
                            <br>
                            <hr style="border:1px solid #ffffff; width:80%;margin-bottom:5px;"><br><br>
                        </center>
                        <div style="width: 100%; height: auto; margin-top: 25px;">
                            <center>
                                <h3 style="font-weight:100; color: #ffffff">Patient: ' . $pacienteResultado . '</h3><br>
                                <h3 style="font-weight:100; color: #ffffff">Result: ' . $resultadoResultado . '</h3><br><a
                                    
                                    <h3 style="font-weight:100; color: #ffffff">Check your result by clicking here!</h3>
                                </a><br>
                                <h3 style="font-weight:100; color: #ffffff">If there is any change or correction of data, the schedule
                                    is Monday to Saturday from 9:00 a.m. to 6:00 p.m.</h3><br><br>
                            </center>
                        </div>
                        <br>
                    </div>
                </div>
        <?php
        $mail = new PHPMailer;
        $mail->SMTPDebug  = 2;
        $mail->CharSet = 'UTF-8';
        $mail->isMail();
        $mail->setFrom('contacto@grupodiemsa.com', 'GRUPO DIEMSA');
        $mail->addReplyTo('contacto@grupodiemsa.com', 'GRUPO DIEMSA');
        $mail->Subject = "Check the result of your COVID test!";
        //$mail->addAddress('erick.leo.malagon@gmail.com');
        $mail->msgHTML("hola mail");
        if(!$envio = $mail->Send()){
            echo "ERROR";
        }
        else{
        	echo "EXITO";
        }

        core::preprint($envio);
    }

    
}