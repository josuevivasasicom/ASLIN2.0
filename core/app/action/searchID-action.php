<?php

//esta funcion no esta referenciada
// solo es un action
// que apunta un sql para buscar 

header("Content-type: text/html"); 
header("Expires: Mon, 30 Jan 2022 12:00:00 GMT");  
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");  
header("Cache-Control: no-store, no-cache, must-revalidate");  
header("Cache-Control: post-check=0, pre-check=0", false);  
header("Pragma: no-cache") ;

if (isset($_REQUEST['search']) ){ // buscar por ID

    $letter = explode('-',$_REQUEST['search']);
    if (count($letter)==3){
        if (strlen($letter[2])==2){
            $letter[2]= '20'.$letter[2];
        }
        $sql="select timerst from siniestros where f_numProv = '".$letter[0]."' and f_consecutivo = '".$letter[1]."' and f_year = ".$letter[2]." limit 1";
        $query=Database::ExeDoIt($sql,false);
        // core::preprint($sql);exit();
        if ($query[0]->num_rows==1){
            $data=Model::many_assoc($query[0])[0]['timerst'];
            header("Location: ./?view=siniestro/ver&param=".$data);
        }else{
            header("Location: ./?view=siniestro/error");
        }
        
    }else{
        header("Location: ./?view=siniestro/error");
    }
}

if( isset($_REQUEST['searchNS']) ){  // buscar por nombre del asegurado
    $searchNS = strtolower($_REQUEST['searchNS']);
    // $sa = explode(' ',$searchAsegurado);
    // core::preprint($sa);
    $sql= 'SELECT s.timerst from siniestros s where s.numSiniestro like "%'.$searchNS.'%"';
    $query=Database::ExeDoIt($sql,false);
    if ($query[0]->num_rows==1){// un resultado, se muestra directamente
        $data=Model::many_assoc($query[0])[0]['timerst'];
        header("Location: ./?view=siniestro/ver&param=".$data);
        // core::preprint($sql,'un resultado, se muestra directamente');
    }else if($query[0]->num_rows>=2){
        $data=Model::many_assoc($query[0]);
        /* $param = "";
        foreach ($data as $k) {
            $param .= $k['timerst'].",";
        }
        $param= trim($param,', '); */
        header("Location: ./?view=siniestro/resultadosNS&searchNS=".$searchNS); //hacer nuevamente la consulta en el servidor.
        // core::preprint($sql,'son 2 resultados, se muestra listado de ids'); 
    }
    else{
        echo "error, no se encuentra nungun resultado";
        header("Location: ./?view=siniestro/error");

    }
}
