
<?php
class newID{

    public static function updateIDCSV($f,$timerstUpdate){
       // es un update al importar folios
        $ns = ''; //$nuevoSiniestro
        $year = date("y");

        ////parse_str($f['data'],$nuevoSiniestro);  aqui no se parsea por que llega completo en array
        $ns = $f;

        //?primera parte -- crear FOLIO segun el proveniente
        //!esto es un stop para el nuevo desde CSV importado. core::preprint($ns,'NSNSNSNSNSNSNSNSNSNSNSNSNSNSNS');exit();
        $folioCreado= Folios::updateFPCSV(explode('_',$ns['proveniente'])[1],$ns,$timerstUpdate); //envia proveniente sin prov_

        if($folioCreado=== false){
            $intento2 = Folios::updateFPCSV(explode('_',$ns['proveniente'])[1],$ns,$timerstUpdate);
            if(!$folioCreado){
                print json_encode(array('msg'=>"error nuevo folio"));
            }
        }
    }

    public static function crearNuevo(){
        $ns = ''; //$nuevoSiniestro
        $year = date("y");

        parse_str($_REQUEST['data'],$nuevoSiniestro); 
        $ns = $nuevoSiniestro;
        $ns['fechaCaptura'] = Core::getTimeNow();
        $ns['descripcionHechos']=urlencode($_REQUEST['textArea']);
        $ns['formaContacto'] = $_REQUEST['formaContacto'];


                                // print_r(($ns));
                                // print json_encode(array ("res"=>"siniestro","siniestro"=>"error.404","obj"=>$ns));
                                // exit();
        //?primera parte -- crear FOLIO segun el proveniente
        // core::preprint($ns,'NS');exit();
        $folioCreado= Folios::crearFolioNuevoProv(explode('_',$ns['proveniente'])[1],$ns); //envia proveniente sin prov_

        if($folioCreado=== false){
            $intento2 = Folios::crearFolioNuevoProv(explode('_',$ns['proveniente'])[1],$ns);
            if(!$folioCreado){
                print json_encode(array('msg'=>"error nuevo folio"));
            }
        }
    }

    public static function crearNuevoCSV($f){
        //core::preprint($f);exit();
        // echo 'crearNuevoCSVcrearNuevoCSVcrearNuevoCSVcrearNuevoCSVcrearNuevoCSV';
        $ns = ''; //$nuevoSiniestro
        $year = date("y");

        ////parse_str($f['data'],$nuevoSiniestro);  aqui no se parsea por que llega completo en array
        $ns = $f;
        // $ns['fechaCaptura'] = Core::getTimeNow();  se toma una fecha que ya existe en la columna 12
        // $ns['descripcionHechos']=urlencode($f['textArea']);  ya existe
        // $ns['formaContacto'] = $f['formaContacto']; ya existe en el array


                                // print_r(($ns));
                                // print json_encode(array ("res"=>"siniestro","siniestro"=>"error.404","obj"=>$ns));
                                // exit();
        //?primera parte -- crear FOLIO segun el proveniente
        //!esto es un stop para el nuevo desde CSV importado. core::preprint($ns,'NSNSNSNSNSNSNSNSNSNSNSNSNSNSNS');exit();
        $folioCreado= Folios::crearFolioNuevoProvCSV(explode('_',$ns['proveniente'])[1],$ns); //envia proveniente sin prov_

        if($folioCreado=== false){
            $intento2 = Folios::crearFolioNuevoProvCSV(explode('_',$ns['proveniente'])[1],$ns);
            if(!$folioCreado){
                print json_encode(array('msg'=>"error nuevo folio"));
            }
        }
    }

}

if(isset($_REQUEST['textArea']) && $_REQUEST['textArea']!=''){
    $newID = new newID();
    $newID->crearNuevo();
}
/* else if (isset($datosCSV['descripcionHechos'])){
    $_REQUEST['data']=$datosCSV;
    $_REQUEST['textArea'] = $datosCSV['descripcionHechos'];

    core::preprint($_REQUEST);exit();
    $newID = new newID();
    $newID->crearNuevo();
} */



/*   timerst
 in NS 
Array
(
    [proveniente] => prov_cma
    [fechaAsignacion] => 2022-04-30 13:08:37
    [nombre] => Erick
    [apellidoP] => ocaña
    [apellidoM] => chavez
    [institucion] => 116
    [cel] => 5556958451
    [casa] => 234234234234324
    [oficina] => 565654545121
    [fechaReporte] => 2022-01-25 17:01:37
    [estado] => Baja California
    [ciudad] => Mexicali
    [mail] => mail@gmail.com
    [formaContacto] => correo
    [descripcionHechos] => %3Cp%3E%3Cstrong%3E2022-04-30+13%3A08%3A37%3C%2Fstrong%3E%3C%2Fp%3E%0A%0A%3Cp%3E%3Cstrong%3EDescripci%26oacute%3Bn+de+los+hechos%3A%26nbsp%3B%3C%2Fstrong%3E%3Cbr+%2F%3E%0A%3Cbig%3ELic.+Luis+Alberto+Mart%26iacute%3Bnez+Garc%26iacute%3Ba+%26nbsp%3B+%26nbsp%3B+%26nbsp%3B+%26nbsp%3B%2F+%26nbsp%3B%26nbsp%3B%26nbsp%3B%26nbsp%3B+Lic.+Mario+Aguilar+Guajardo.%3C%2Fbig%3E%3C%2Fp%3E%0A%0A%3Cp%3E...%3C%2Fp%3E%0A%0A%3Cp%3EAgradeciendo+su+atenci%26oacute%3Bn%2C+me+reitero+a+sus+%26oacute%3Brdenes+para+cualquier+duda+o+aclaraci%26oacute%3Bn.Agradeciendo+su+atenci%26oacute%3Bn%2C+me+reitero+a+sus+%26oacute%3Brdenes+para+cualquier+duda+o+aclaraci%26oacute%3Bn.Agradeciendo+su+atenci%26oacute%3Bn%2C+me+reitero+a+sus+%26oacute%3Brdenes+para+cualquier+duda+o+aclaraci%26oacute%3Bn.Agradeciendo+su+atenci%26oacute%3Bn%2C+me+reitero+a+sus+%26oacute%3Brdenes+para+cualquier+duda+o+aclaraci%26oacute%3Bn.Agradeciendo+su+atenci%26oacute%3Bn%2C+me+reitero+a+sus+%26oacute%3Brdenes+para+cualquier+duda+o+aclaraci%26oacute%3Bn.Agradeciendo+su+atenci%26oacute%3Bn%2C+me+reitero+a+sus+%26oacute%3Brdenes+para+cualquier+duda+o+aclaraci%26oacute%3Bn.Agradeciendo+su+atenci%26oacute%3Bn%2C+me+reitero+a+sus+%26oacute%3Brdenes+para+cualquier+duda+o+aclaraci%26oacute%3Bn.Agradeciendo+su+atenci%26oacute%3Bn%2C+me+reitero+a+sus+%26oacute%3Brdenes+para+cualquier+duda+o+aclaraci%26oacute%3Bn.Agradeciendo+su+atenci%26oacute%3Bn%2C+me+reitero+a+sus+%26oacute%3Brdenes+para+cualquier+duda+o+aclaraci%26oacute%3Bn.Agradeciendo+su+atenci%26oacute%3Bn%2C+me+reitero+a+sus+%26oacute%3Brdenes+para+cualquier+duda+o+aclaraci%26oacute%3Bn.Agradeciendo+su+atenci%26oacute%3Bn%2C+me+reitero+a+sus+%26oacute%3Brdenes+para+cualquier+duda+o+aclaraci%26oacute%3Bn.Agradeciendo+su+atenci%26oacute%3Bn%2C+me+reitero+a+sus+%26oacute%3Brdenes+para+cualquier+duda+o+aclaraci%26oacute%3Bn.Agradeciendo+su+atenci%26oacute%3Bn%2C+me+reitero+a+sus+%26oacute%3Brdenes+para+cualquier+duda+o+aclaraci%26oacute%3Bn.Agradeciendo+su+atenci%26oacute%3Bn%2C+me+reitero+a+sus+%26oacute%3Brdenes+para+cualquier+duda+o+aclaraci%26oacute%3Bn.Agradeciendo+su+atenci%26oacute%3Bn%2C+me+reitero+a+sus+%26oacute%3Brdenes+para+cualquier+duda+o+aclaraci%26oacute%3Bn.Agradeciendo+su+atenci%26oacute%3Bn%2C+me+reitero+a+sus+%26oacute%3Brdenes+para+cualquier+duda+o+aclaraci%26oacute%3Bn.Agradeciendo+su+atenci%26oacute%3Bn%2C+me+reitero+a+sus+%26oacute%3Brdenes+para+cualquier+duda+o+aclaraci%26oacute%3Bn.Agradeciendo+su+atenci%26oacute%3Bn%2C+me+reitero+a+sus+%26oacute%3Brdenes+para+cualquier+duda+o+aclaraci%26oacute%3Bn.Agradeciendo+su+atenci%26oacute%3Bn%2C+me+reitero+a+sus+%26oacute%3Brdenes+para+cualquier+duda+o+aclaraci%26oacute%3Bn.Agradeciendo+su+atenci%26oacute%3Bn%2C+me+reitero+a+sus+%26oacute%3Brdenes+para+cualquier+duda+o+aclaraci%26oacute%3Bn.Agradeciendo+su+atenci%26oacute%3Bn%2C+me+reitero+a+sus+%26oacute%3Brdenes+para+cualquier+duda+o+aclaraci%26oacute%3Bn.Agradeciendo+su+atenci%26oacute%3Bn%2C+me+reitero+a+sus+%26oacute%3Brdenes+para+cualquier+duda+o+aclaraci%26oacute%3Bn.Agradeciendo+su+atenci%26oacute%3Bn%2C+me+reitero+a+sus+%26oacute%3Brdenes+para+cualquier+duda+o+aclaraci%26oacute%3Bn.Agradeciendo+su+atenci%26oacute%3Bn%2C+me+reitero+a+sus+%26oacute%3Brdenes+para+cualquier+duda+o+aclaraci%26oacute%3Bn.Agradeciendo+su+atenci%26oacute%3Bn%2C+me+reitero+a+sus+%26oacute%3Brdenes+para+cualquier+duda+o+aclaraci%26oacute%3Bn.Agradeciendo+su+atenci%26oacute%3Bn%2C+me+reitero+a+sus+%26oacute%3Brdenes+para+cualquier+duda+o+aclaraci%26oacute%3Bn.Agradeciendo+su+atenci%26oacute%3Bn%2C+me+reitero+a+sus+%26oacute%3Brdenes+para+cualquier+duda+o+aclaraci%26oacute%3Bn.Agradeciendo+su+atenci%26oacute%3Bn%2C+me+reitero+a+sus+%26oacute%3Brdenes+para+cualquier+duda+o+aclaraci%26oacute%3Bn.Agradeciendo+su+atenci%26oacute%3Bn%2C+me+reitero+a+sus+%26oacute%3Brdenes+para+cualquier+duda+o+aclaraci%26oacute%3Bn.Agradeciendo+su+atenci%26oacute%3Bn%2C+me+reitero+a+sus+%26oacute%3Brdenes+para+cualquier+duda+o+aclaraci%26oacute%3Bn.Agradeciendo+su+atenci%26oacute%3Bn%2C+me+reitero+a+sus+%26oacute%3Brdenes+para+cualquier+duda+o+aclaraci%26oacute%3Bn.Agradeciendo+su+atenci%26oacute%3Bn%2C+me+reitero+a+sus+%26oacute%3Brdenes+para+cualquier+duda+o+aclaraci%26oacute%3Bn.Agradeciendo+su+atenci%26oacute%3Bn%2C+me+reitero+a+sus+%26oacute%3Brdenes+para+cualquier+duda+o+aclaraci%26oacute%3Bn.Agradeciendo+su+atenci%26oacute%3Bn%2C+me+reitero+a+sus+%26oacute%3Brdenes+para+cualquier+duda+o+aclaraci%26oacute%3Bn.Agradeciendo+su+atenci%26oacute%3Bn%2C+me+reitero+a+sus+%26oacute%3Brdenes+para+cualquier+duda+o+aclaraci%26oacute%3Bn.Agradeciendo+su+atenci%26oacute%3Bn%2C+me+reitero+a+sus+%26oacute%3Brdenes+para+cualquier+duda+o+aclaraci%26oacute%3Bn.Agradeciendo+su+atenci%26oacute%3Bn%2C+me+reitero+a+sus+%26oacute%3Brdenes+para+cualquier+duda+o+aclaraci%26oacute%3Bn.Agradeciendo+su+atenci%26oacute%3Bn%2C+me+reitero+a+sus+%26oacute%3Brdenes+para+cualquier+duda+o+aclaraci%26oacute%3Bn.Agradeciendo+su+atenci%26oacute%3Bn%2C+me+reitero+a+sus+%26oacute%3Brdenes+para+cualquier+duda+o+aclaraci%26oacute%3Bn.Agradeciendo+su+atenci%26oacute%3Bn%2C+me+reitero+a+sus+%26oacute%3Brdenes+para+cualquier+duda+o+aclaraci%26oacute%3Bn.%3Cbr+%2F%3E%0A%3Cbr+%2F%3E%0AA+T+E+N+T+A+ME+N+T+E%3Cbr+%2F%3E%0ALic.+Erick%3C%2Fp%3E%0A
    [numReporte] => 234324
    [numSiniestro] => 234234
    [fechaVigencia1] => 2022-04-30 13:08:56
    [fechaVigencia2] => 2022-04-30 13:08:57
    [numPoliza] => Array
        (
            [0] => 2
        )

    [status] => 166
    [calificacion] => 161
    [autoridad] => 58
    [area] => Array
        (
            [0] => 2
            [1] => 3
        )

    [abogados] => Array
        (
            [0] => 4
        )

    [fechaCaptura] => 2022-04-30 13:09:21
)
*/

