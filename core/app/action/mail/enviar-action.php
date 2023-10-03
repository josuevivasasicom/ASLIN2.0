<?php 
/* 
 in REQ de enviar formato 
Array
(
    [action] => mail/enviar
    [method] => formato
    [textMail] => texto del correo 

    [sendMails] =>  'send_4','send_2','send_3'
    [ccMails] =>  'cc_5','cc_6'
    [ccoMails] =>  'cco_7'

    [addsend] => Array
        (
            [0] => hola1@gmail.com
        )
    [addcc] => Array
        (
            [0] => hola2@gmail.com
        )
    [addcco] => Array
        (
            [0] => hola3@gmail.com
        )
    [save_send] => false
    [save_cc] => true
    [save_cco] => false

    [idfile] => 22
    [linkpdf] => https://www.claimsmanager.online/?action=pdf/viewFileF&timerst=1654960235.5588&doc=./files/1654960235.5588/40/1655108016.csv&areaNombre=Servidores Públicos&v=01
    [c1] => entrevista del imputado.
    [c2] => investigación inicial
    [c3] => acusatorio
    [timerst] => 1654960235.5588
    [areaNombre] => Servidores Públicos
    [v] => 01
    [version] => 01
    [folio] => 102-024-22
    [link] => ./files/1654960235.5588/40/1655108016.csv
    [linkfile] => /files/1654960235.5588/40/1655108016.csv
)
*/

class mailEnviar{

    //funcion enviar formato desde un solo archivo seleccionado.
    public static function enviarFormato($req){ // paso 3, ejecuta data para enviar data por mail
        
        //?PREPRA LINK FILE ATTACHMENT
        $fileurl = null;
        switch ($_SERVER["HTTP_HOST"]){
			case 'localhost:8080':
            case 'localhost':
                $fileurl = "localhost/cma";
				break;
            case 'claimsmanager.online':
                $fileurl = "claimsmanager.online";
				break;
		}
        if (   substr($req['link'],0,8) == './files/'){// si el nombre del link comienza con .files... es un archivo en el servidor.
                // echo "si es link";
                //todo: corregido.
                $req['linkfile'] = substr($req['link'],1); //genera el link verdadero del archivo con su respectiva extension
        }

        // core::preprint($req);exit();

        //? PREPARA LISTA DE EMAILS
        $listSenders = self::dameEmail($req['sendMails'],$req['ccMails'],$req['ccoMails']);//lista de nombres y correos a enviar
        //send,cc,cco

        // core::preprint($listSenders,'listSenders de dameemails checkbox');



        /* 
        [addsend] => Array ( [0] => hola1@gmail.com )
        [addcc] => Array ( [0] => hola2@gmail.com)
        [addcco] => Array ( [0] => hola3@gmail.com )
        [save_send] => false
        [save_cc] => true
        [save_cco] => false */

        //guardando lis emals de los inputs
        if ($req['save_send'] && isset($req['addsend'])){
            foreach ($req['addsend'] as $k) {
                $sql= "insert into libretadirecciones (nombre,email,general) values(' ','$k',1)";
                $query=Database::ExeDoIt($sql);
            }
        }
        if ($req['save_cc'] && isset($req['addcc'])){
            foreach ($req['addcc'] as $k) {
                $sql= "insert into libretadirecciones (nombre,email,general) values(' ','$k',1)";
                $query=Database::ExeDoIt($sql);
            }
        }
        if ($req['save_cco'] && isset($req['addcco'])){
            foreach ($req['addcco'] as $k) {
                $sql= "insert into libretadirecciones (nombre,email,general) values(' ','$k',1)";
                $query=Database::ExeDoIt($sql);
            }
        }

        //agregando la lista de los checkbosx con la lista de los inputs
        if(isset($req['addsend'])){
            foreach ($req['addsend'] as $k) {
                array_push($listSenders['send'],array($k,' '));//email-nombre
                # code...
            }
        }
        if(isset($req['addcc'])){
            foreach ($req['addcc'] as $k) {
                array_push($listSenders['cc'],array($k,' '));//email-nombre
                # code...
            }
        }
        if(isset($req['addcco'])){
            foreach ($req['addcco'] as $k) {
                array_push($listSenders['cco'],array($k,' '));//email-nombre
                # code...
            }
        }

        // core::preprint($listSenders,"listSenders desde formato",true); ///informacion oculta
        // core::preprint($req,"REQ de enviar formato",true); ///informacion oculta
        // exit();

        $req['listSenders'] =  $listSenders;

        print ($mailEnviado = Correo::send_format($req));
        //debyuelve EXITO si se envio mail y ERROR si no se envia
        // core::preprint($_REQUEST,'',true);

    }

    static function dameEmail($send,$cc,$cco){
        //devuelve lista de correos con nombres de los seleccionados
        // [sendMails] =>  'send_4','send_2','send_3'
        // [ccMails] =>  'cc_5','cc_6'
        // [ccoMails] =>  'cco_7'

        // Quita opcion de nombre y guarda en variable
        $listSend = [];
        $send = explode(',',$send);
        foreach ($send as  $k) {
            $k = explode('send_',$k);// send_4
            $k = trim($k[1],"' ");
            $sql = "select email,nombre from libretadirecciones where id = ".$k." limit 1";
            $query = Database::ExeDoIt($sql,false,true);
            $listSend[] = Model::many_assoc($query[0])[0];
        }
        //core::preprint($listSend,'ok1');

        //CON COPIA
        $listCc = [];
        if(strstr($cc,',')){
            $cc = explode(',',$cc);
            foreach ($cc as  $k) {
                $k = explode('cc_',$k);// cc_4
                $k = trim($k[1],"' ");
                $sql = "select email,nombre from libretadirecciones where id = ".$k." limit 1";
                $query = Database::ExeDoIt($sql);
                $listCc[] = Model::many_assoc($query[0])[0];
            }
        }
        else{//si es solo uno
            $k = explode('cc_',$k);// cc_4
            $k = trim($k[0],"' ");
            $sql = "select email,nombre from libretadirecciones where id = ".$k." limit 1";
            $query = Database::ExeDoIt($sql);
            $listCc[] = Model::many_assoc($query[0])[0];
        }

        //CON COPIA OCULTA
        $listCco = [];
        if(strstr($cco,',')){
            $cco = explode(',',$cco);
            foreach ($cco as  $k) {
                $k = explode('cco_',$k);// cco_4
                $k = trim($k[1],"' ");
                $sql = "select email,nombre from libretadirecciones where id = ".$k." limit 1";
                $query = Database::ExeDoIt($sql);
                $listCco[] = Model::many_assoc($query[0])[0];
            }
        }else{//si es solo uno
                $k = explode('cco_',$k);// cc_4
                $k = trim($k[0],"' ");
                $sql = "select email,nombre from libretadirecciones where id = ".$k." limit 1";
                $query = Database::ExeDoIt($sql);
                $listCco[] = Model::many_assoc($query[0])[0];
        }

        return array("send"=>$listSend,"cc"=>$listCc,"cco"=>$listCco);
        //devuelve listados de los correos seleccionados por checkbox
    }

}

switch ($_REQUEST['method']) {
    case 'formato':
        mailEnviar::enviarFormato($_REQUEST); //paso 2 para enviar data
        break;
    
    default:
        # code...
        break;
}



?>