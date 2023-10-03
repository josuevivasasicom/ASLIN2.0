<?php 

class editarSiniestro{

     public static function editarStatus($data){
        $sql = "update siniestros set status = ".$data['status']." where timerst = '". $data['timerst'] ."'";
        $query = Database::ExeDoIt($sql);
    }

     public static function editarCalificacion($data){
        $sql = "update siniestros set calificacion = ".$data['calificacion']." where timerst = '". $data['timerst'] ."'";
        $query = Database::ExeDoIt($sql);
    }

	//por super admin, y administradores
    public static function editarSiniestroA($req){
		parse_str($req['data'],$data); ///parsea el formulario
		//polizas

		// core::preprint($data['numPoliza']);exit();
		$polizasString = '[';
				if( is_string( $data['numPoliza'] ) ){
					// $data['numPoliza'] = json_encode([$data['numPoliza']]);
					$data['numPoliza'] = [$data['numPoliza']];
					//core::preprint($data['numPoliza'] ,'($data[numPoliza]');
				}
				foreach ($data['numPoliza'] as $key => $value) {
					$sql="select poliza from siniestros_polizas where id=$value";
					$query = Database::exeDoIt($sql,false);
					if(isset($query[0]->num_rows) && $query[0]->num_rows==1 && is_numeric($value)==true){
						//la poliza existe 
						$polizasString .= $value.','; // concatena *idpoliza (existente),*   // [ 4,6, ... sin cerrar corchete
					}else{
						//no existe el id de la poliza, entonces se crea la poliza.
						$sql="insert into siniestros_polizas(poliza,reserva,deducible,sumaAsegurada) values('$value',0,0,0)";
						$query = Database::exeDoIt($sql);
						//recupera id de poliza . //! lastinsertID no sirve en hostinger
						$sql="select id from siniestros_polizas where poliza = '$value' limit 1";
						$query = Database::exeDoIt($sql);
						$idPoliza = Model::unsetOne($query[0])['id'];
						$polizasString .= '"'.$idPoliza.'",';  // concatena *idpoliza, (recien creado)*   // [ 4,6, ... sin cerrar corchete
					}
				}//fn de foreach data['numPoliza']
				$polizasString=  rtrim($polizasString, ",");
				$polizasString .= ']'; // cerrar corchete
		//$numpolizas = json_encode($data['numPoliza']); // conveirte polizas a string
		$numpolizas = $polizasString;

        //??????????????? insert para siniestro nuevo
				$sql="UPDATE siniestros set 					
					`nombre` = '".$data['nombre']."' , 
					`apellidoP` = '".$data['apellidoP']."' , 
					`apellidoM` = '".$data['apellidoM']."' , 
					`institucion` = '".$data['institucion']."' , 
					`cel` = '".$data['cel']."' , 
					`casa` = '".$data['casa']."' , 
					`oficina` = '".$data['oficina']."' , 
					`fechaReporte` = '".$data['fechaReporte']."' , 
					`estado` = '".$data['estado']."' , 
					`ciudad` = '".$data['ciudad']."' , 
					`mail` = '".$data['mail']."' , 
					`formaContacto` = '".$data['formaContacto']."' , 
					`numReporte` = '".$data['numReporte']."' , 
					`numPoliza` = '".$numpolizas."' , 
					`numSiniestro` = '".$data['numSiniestro']."' , 
					`vigencia1` = '".$data['fechaVigencia1']."' , 
					`vigencia2` = '".$data['fechaVigencia2']."' , 
					`status` = '".$data['status']."' , 
					`calificacion` = '".$data['calificacion']."' , 
					`autoridad` = '".$data['autoridad']."' ,
					`fechaAsignacion` = '".$data['fechaAsignacion']."' ,
					`tipoIntervencion` = '".$data['tipoIntervencion']."' ,
					`tercero` = '".$data['tercero']."' ,
					`nicho` = '".$data['nicho']."' ,
					`materia` = '".$data['materia']."' ,
					`expediente` = '".$data['expediente']."' 
					WHERE timerst = '".$data['timerst']."'";
				$query = Database::exeDoIt($sql,false);

				core::insertHistoricoSiniestros('Actualizado','Información Actualizada.',$data['timerst'] );//?historico

				print 'ok';exit();
				/* if ($query)
				header('Location: ./?view=siniestro/ver&param='.$data['timerst']); */

    }

	//por tituales de area / jefes
	public static function editarSiniestroJefe($req){
		parse_str($req['data'],$data); ///parsea el formulario

		ini_set('display_errors', 0);
		ini_set('display_startup_errors', 0);
		error_reporting(0);

		//polizas
		$polizasString = '[';
				if( is_string( $data['numPoliza'] ) ){
					// $data['numPoliza'] = json_encode([$data['numPoliza']]);
					$data['numPoliza'] = [$data['numPoliza']];
					//core::preprint($data['numPoliza'] ,'($data[numPoliza]');
				}
				foreach ($data['numPoliza'] as $key => $value) {
					$sql="select poliza from siniestros_polizas where id=$value";
					$query = Database::exeDoIt($sql,false);
					if($query[0]->num_rows==1 && is_numeric($value)==true){
						//la poliza existe 
						$polizasString .= $value.','; // concatena *idpoliza (existente),*   // [ 4,6, ... sin cerrar corchete
					}else{
						//no existe el id de la poliza, entonces se crea la poliza.
						$sql="insert into siniestros_polizas(poliza,reserva,deducible,sumaAsegurada) values('$value',0,0,0)";
						$query = Database::exeDoIt($sql);
						//recupera id de poliza . //! lastinsertID no sirve en hostinger
						$sql="select id from siniestros_polizas where poliza = '$value' limit 1";
						$query = Database::exeDoIt($sql);
						$idPoliza = Model::unsetOne($query[0])['id'];
						$polizasString .= '"'.$idPoliza.'",';  // concatena *idpoliza, (recien creado)*   // [ 4,6, ... sin cerrar corchete
					}
				}//fn de foreach data['numPoliza']
				$polizasString=  rtrim($polizasString, ",");
				$polizasString .= ']'; // cerrar corchete

		//$numpolizas = json_encode($data['numPoliza']); // conveirte polizas a string
		$numpolizas = $polizasString;

        //??????????????? insert para siniestro nuevo
				$sql="UPDATE siniestros set 					
					`nombre` = '".$data['nombre']."' , 
					`apellidoP` = '".$data['apellidoP']."' , 
					`apellidoM` = '".$data['apellidoM']."' , 
					`institucion` = '".$data['institucion']."' , 
					`cel` = '".$data['cel']."' , 
					`casa` = '".$data['casa']."' , 
					`oficina` = '".$data['oficina']."' , 
					`estado` = '".$data['estado']."' , 
					`ciudad` = '".$data['ciudad']."' , 
					`mail` = '".$data['mail']."' , 
					`formaContacto` = '".$data['formaContacto']."' , 
					`numPoliza` = '".$numpolizas."' , 
					`numSiniestro` = '".$data['numSiniestro']."' , 
					`vigencia1` = '".$data['fechaVigencia1']."' , 
					`vigencia2` = '".$data['fechaVigencia2']."' , 
					`autoridad` = '".$data['autoridad']."' ,
					WHERE timerst = '".$data['timerst']."'";
				$query = Database::exeDoIt($sql,false,true);

				core::insertHistoricoSiniestros('Actualizado','Información Actualizada.',$data['timerst'] );//?historico

				print 'ok';exit();
				/* if ($query)
				header('Location: ./?view=siniestro/ver&param='.$data['timerst']); */

    }




}

$edit = new editarSiniestro();

if(isset($_REQUEST['p']) && $_REQUEST['p']=='jefe'){
	$edit->editarSiniestroJefe($_REQUEST);
	exit();
}

if (!isset($_REQUEST['status']) and !isset($_REQUEST['calificacion']) ){ // si no trae status ni calificacion, es de la vista editar, lo edita.
	$edit->editarSiniestroA($_REQUEST);

}

exit();





///no se usan, se utiliza ahora cambiar parametros por status y calificacion by area or by id

if (isset($_REQUEST['status']) and !isset($_REQUEST['calificacion']) ){// si solo existe status
    $edit->editarStatus($_REQUEST);
}
if
(!isset($_REQUEST['status']) and isset($_REQUEST['calificacion']) ){ // si solo existe calificacion
    $edit->editarCalificacion($_REQUEST);
}
