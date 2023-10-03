
<?php
class Folios {
	public static $tablename = "folios";

	public function Folios(){
		$this->id = "";
	}

	public static function getLastIds($idUs){
		$sql="select 
		s.*,
		concat(s.f_numProv,'-',LPAD(s.f_consecutivo,3,'0'), '-',SUBSTRING(f_year, 3)) folio, 
		css.valor `status`,
		(SUBSTRING(UPPER(s.proveniente),6)) as prov
		from siniestros s
		INNER JOIN siniestros_usuarios su on s.timerst = su.timerst
		INNER JOIN config_campos css on s.status= css.id
		where su.usuario = $idUs 	GROUP BY s.id  order by  s.id DESC limit 5;
		";
		$query = Database::exeDoIt($sql);
		$data=Model::many_assoc($query[0],new Folios());
		return $data;

	}

	public static function obtenerPolizas(){
	$sql="select poliza,id from siniestros_polizas"; //! 
		$query = Database::exeDoIt($sql);
		$data=Model::many($query[0],new Folios());
		return $data;
	}

	public static function obtenerConfigCampoByid($entidad){
		$sql="select valor from config_campos where id = '".$entidad."' and activo = 1 ";
		$query = Database::exeDoIt($sql);
		$data=Model::many_assoc($query[0])[0]['valor'];
		return $data;
	}

	public static function obtenerConfigCampo($entidad){
		//regresa el nombre de los provenientes ...basandose en las tablas creadas

		$sql="select id,valor,extra from config_campos where campo = '".$entidad."' and activo = 1 ";
		$query = Database::exeDoIt($sql);
		$data=Model::many($query[0],new Folios());
		//se recorre el arreglo para ponerlo en uno nuevo solo con los nombres
		
		return $data;
	}

	
	public static function obtenerAbogados($area=[]){
		//regresa el de los abogados todos por defecto

		//debe seleccionar el uusuario segun el tipo de grupo abogado o jefe de area y pintarlo en el multiselect!! pueden seleccionarse multiples abodagosjjsjsjsj
		$abogs=[];
		$sql="select u.id,CONCAT(u.nombre,' ',u.paterno,' ',u.materno) nombre,u.email, gu.IdGrupo , (select area from areas where id= gu.idArea) area from usuarios u inner join gruposusuario gu on u.id = gu.idUsuario where (gu.IdGrupo = 3 or gu.IdGrupo = 6) and u.estatus = 1"; //! 3 siempre es ABOGADOS
		if($area!=[]){
			foreach ($area as $k) {
				$sql="select u.id,CONCAT(u.nombre,' ',u.paterno,' ',u.materno) nombre,u.email, gu.IdGrupo , (select area from areas where id= gu.idArea) area, avatar from usuarios u inner join gruposusuario gu on u.id = gu.idUsuario where (gu.IdGrupo = 3 or gu.IdGrupo = 6)  and u.estatus = 1"; //! 3 siempre es ABOGADOS
				$sql.=" and gu.idArea=".$k['id']; //! 3 siempre es ABOGADOS
				$query = Database::exeDoIt($sql,false);
				$data=Model::many($query[0],new Folios());
				foreach ($data as $key) {
					array_push($abogs, $key);
				}
			}
			return $abogs;
		}else{
			$query = Database::exeDoIt($sql);
			$data=Model::many($query[0],new Folios());
			return $data;
		}
	}

	public static function obtenerUsuarios($area='*'){

		//regresa todos los usuarios sin importar areas ni perfiles.

		//debe seleccionar el uusuario segun el tipo de grupo abogado o jefe de area y pintarlo en el multiselect!! pueden seleccionarse multiples abodagosjjsjsjsj

		$sql="select u.id,CONCAT(u.nombre,' ',u.paterno,' ',u.materno) nombre,u.email from usuarios u where 1;"; //! todos los usuarios
		$query = Database::exeDoIt($sql);
		$data=Model::many($query[0],new Folios());
		//se recorre el arreglo para ponerlo en uno nuevo solo con los nombres
		/* $name_tables = [];
		foreach ($data as $key) {
			# estos son las tablas
			foreach ($key as $key => $value) {
				$name_tables[]=$value;
			}
		} */
		return $data;


	}

	public static function obtenerAreas(){
		//regresa el de las areas existentes en las tablas
		$sql="select area,id from areas where activo=1 ";
		$query = Database::exeDoIt($sql);
		$data=Model::many($query[0],new Folios());
		//se recorre el arreglo para ponerlo en uno nuevo solo con los nombres
		return $data;
	}

	public static function obtenerStatus(){
		//regresa valores de los estatus para colocarlos en filtros de sinieestros
		$sql="SELECT valor,id  FROM config_campos WHERE campo ='status' and activo=1 ";
		$query = Database::exeDoIt($sql);
		$data=Model::many($query[0],new Folios());
		//se recorre el arreglo para ponerlo en uno nuevo solo con los nombres
		return $data;
	}

	public static function obtenerCalificaciones(){
		//regresa valores de calificaciones para colocarlos en filtros de sinieestros
		$sql="SELECT valor,id  FROM config_campos WHERE campo ='calificacion' and activo=1 ";
		$query = Database::exeDoIt($sql);
		$data=Model::many($query[0],new Folios());
		//se recorre el arreglo para ponerlo en uno nuevo solo con los nombres
		return $data;
	}


	public static function obtenerProvenientes(){
		//usado para los select2
		//regresa el nombre de los provenientes ...basandose en las tablas creadas

		$sql="select id,proveniente,descripcion from config_prov where estatus=1";
		$query = Database::exeDoIt($sql);
		$data=Model::many($query[0],new Folios());
		//se recorre el arreglo para ponerlo en uno nuevo solo con los nombres
		$name_tables = [];
		foreach ($data as $key) {
			# estos son las tablas
			
				$name_tables[]=array('id'=>$key->id,'proveniente'=>$key->proveniente,'descripcion'=>$key->descripcion);
		}
		
		return $name_tables;

	}

	public static function _obtenerAbogados(){
		//usado para los select2
		//regresa el nombre de los abogados ...basandose en las tablas creadas

		$sql="Select concat(u.nombre, ' ', u.paterno, ' ', u.materno) as nombreCompleto, u.email, u.cedula, u.celular, gu.esAbogado from gruposusuario gu
		INNER JOIN usuarios u ON gu.idUsuario = u.id
		where IdGrupo = 3 and gu.esAbogado = 'S'";
		$query = Database::exeDoIt($sql);
		
		$data=Model::many($query[0],new Folios());
		//se recorre el arreglo para ponerlo en uno nuevo solo con los nombres
		$name_tables = [];

		// foreach ($data as $key) {
		// 	# estos son las tablas
			
		// 		$name_tables[]=array('id'=>$key->id,'abogado'=>$key->proveniente,'descripcion'=>$key->descripcion);
		// }
		
		return $name_tables;

	}

	

	public static function crearProveniente($prov,$completo){
		//debe obtener provenientes de la tabla de PROV y crear nueva tabla debe agregar el registro 
		//creará una tabla llamada prov_NOMBRE donde nombre hace referencia a las siglas del proveniente
		$prov = strtolower($prov);
		$sql="CREATE TABLE IF NOT EXISTS `prov_".$prov."` (
			`id` INT(4) NOT NULL AUTO_INCREMENT,
			`timerst` varchar(35) COLLATE utf8mb4_spanish2_ci NOT NULL COMMENT 'folio timestamp unico',
			`consecutivo` int(6) NOT NULL COMMENT 'consecutivo por id por año',
			`anualidad` int(4) NOT NULL COMMENT 'fecha solo el año del folio',
			`create_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'fecha de creación',
			UNIQUE KEY `timerst` (`timerst`),
			PRIMARY KEY (`id`)
		  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci COMMENT='primer tabla de folios para ".$prov."';";
		  $query = Database::exeDoIt($sql);
		  if($query){
			  // si se creó la tabla correctamente, procede a crear el primer registro en ceros
				$sql="INSERT INTO `prov_".$prov."` (`timerst`, `consecutivo`, `anualidad`, `create_at`) VALUES ('0', '0', '2022', current_timestamp()) ";
				$query = Database::exeDoIt($sql);
			  	return true;
			}
		  else{return false;}
	}

	//crear folio desde el formulario de nuevo ID
	public static function crearFolioNuevoProv($prov,$datos=[]){
		/**
	 * @param prov:string siglas de un proveedor sin * prov_ *
	 * @param datos:string array de los datos del siniestro.
	 */
			ini_set('display_errors', 0);
			ini_set('display_startup_errors', 0);
			// error_reporting(E_ALL & ~E_DEPRECATED);

		$year = date("Y");

		$HOY=core::getTimeNow();
		$fa= '';

		// core::preprint($datos);exit();

		if(!isset($datos['_folio'])){ //si no existe $datos['_folio'] , es nuevo folio, si si existe es uno cargado de CSV
			$sql="select timerst,consecutivo from `prov_".$prov."` where anualidad = $year order by create_at desc limit 1;";
			$query = Database::exeDoIt($sql);
			if($query[0]->num_rows==1){ //? si el resultado de la consulta es igual a 1 registro del año por lo menos.
				$data = Model::unsetOne($query[0]);
				$new_timerst 		= core::getMicrotime($data['timerst']); //nuevo timerst mayor que el ultimo en la tabla
				$new_consecutivo 	= $data['consecutivo']+1;  //nuevo numero consecutivo
			}else{
				//se entiende wque si no hay resukltado por año es por que no existe el cero o el año ha cambiado. y se necesita crear nuevo folio
				$sql="select timerst,consecutivo from `prov_".$prov."` order by create_at desc limit 1;";
				$query = Database::exeDoIt($sql);
				$data = Model::unsetOne($query[0]);
				$new_timerst 		= core::getMicrotime(0); //nuevo timerst mayor que el ultimo en la tabla
				$new_consecutivo 	= 1;  //nuevo numero consecutivo

			}
		}else{ // el $datos['_folio'] existe, entonces es cargado de CSV
			$tempFolio = explode('-',$datos['_folio']);
			$f_numProv = $tempFolio[0];
			$new_consecutivo =  $tempFolio[1];
			$year = '20'.$tempFolio[2];
			$HOY=$datos['_fcreacion'];
			$fa=$datos['_fa'];

			$new_timerst 		= core::getMicrotime(0); 
		}
		
		// DEMO
		
		///???? espacoio para probar codigo
		
		// DEMO


			//?insertar el nuevo registro en TB prov
			$strSQL="INSERT INTO `prov_".$prov."`(`timerst`,`consecutivo`,`anualidad`) values('$new_timerst',$new_consecutivo,$year);";
			$querySQL = Database::exeDoIt($strSQL,false);

			if($querySQL){
				////??????????????? crear array de polizas
				$polizasString = '[';
				if( is_string( $datos['numPoliza'] ) ){
					// $datos['numPoliza'] = json_encode([$datos['numPoliza']]);
					$datos['numPoliza'] = [$datos['numPoliza']];
					//core::preprint($datos['numPoliza'] ,'($datos[numPoliza]');
				}
				foreach ($datos['numPoliza'] as $key => $value) {
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
				}//fn de foreach datos['numPoliza']
				$polizasString=  rtrim($polizasString, ",");
				$polizasString .= ']'; // cerrar corchete
				

				////??????????????? crear array de abogados y estados de asignacion.
				$mail_dirs_abogados=[];
				if(isset($datos['abogados'])){
					$sql="INSERT INTO `siniestros_usuarios`(`timerst`,`usuario`,`estatus`,fecha_creacion)  values";
					if( is_string( $datos['abogados'] ) ){
						$datos['abogados'] = array( $datos['abogados'] );
						//core::preprint($datos['abogados'] ,'($datos[abogados]');
					}

					foreach ($datos['abogados'] as $key => $value) {
						$sql .="  ('$new_timerst',$value,1, '".$HOY."'), ";
						
							//? Rescata el email del abogado asignado  para enviar mail
							$msql="select email,concat(nombre,' ',paterno) nombre from usuarios where id = ".$value;
							$mquery = Database::exeDoIt($msql,false);
							$mail_dirs_abogados[] = Model::many_assoc($mquery[0])[0];
					}
					$sql = rtrim($sql,' ,').';';//quita la coma del final y agrega ; 
					$query = Database::exeDoIt($sql);

				}

				////??????????????? crear array de areas y estados de asignacion.
				$mail_areas=[];
				foreach ($datos['area'] as $key=>$value){
					$sql="INSERT INTO `siniestros_areas`(`timerst`,`area`,`estatus`,fecha_creacion) values('$new_timerst',$value,1,'".$HOY."');";
					$query=Database::exeDoIt($sql);

					//solo asignara el jefe del area si existe 1, si existen 2 jefes de area, asignara al primer segun el orden del ID
					$sql="INSERT INTO `siniestros_usuarios`(`timerst`,`usuario`,`estatus`,fecha_creacion) 
					values ('$new_timerst',(select idUsuario from gruposusuario where idArea = $value and IdGrupo=2 limit 1  ),1, '".$HOY."') ";
					$query=Database::exeDoIt($sql);

					//? Rescata emails de jefes de areas mail_dirs_abogados
					$sql="select email,concat(nombre,' ',paterno) nombre from usuarios where id = (select idUsuario from gruposusuario where idArea = $value and IdGrupo=2 limit 1  )" ;
					$query = Database::exeDoIt($sql,false);
					$mail_dirs_abogados[] = Model::many_assoc($query[0])[0];

					//? Rescata nombres de areas para enviar en el mail
					$sql="select area from areas where id =".$value;
					$query=Database::exeDoIt($sql);
					$mail_areas[] = Model::many_assoc($query[0])[0]['area'];
				}
				
				//??????????????? numero de proveedor
				if(!isset($f_numProv)){
					$f_numProv = "select id from config_prov where tabla ='prov_".$prov."' limit 1";
					$query = Database::ExeDoIt($f_numProv);
					$f_numProv = Model::many_assoc($query[0])[0]['id'];//! numero de proveedor OK
					//core::preprint($f_numProv,'f_numProv')
				}

				///????????????  autoridad
					$idAuto = $datos['autoridad'];
					if (!is_numeric($datos['autoridad'])){
						//busca autoridad por string
						$sql="select id from config_campos where campo ='autoridad' and valor ='".trim($datos['autoridad'])."' limit 1";
						$query= Database::ExeDoIt($sql);
						if (!$query[0]->num_rows){//si no existe la opcion, se agrega
							$sql='INSERT into config_campos (campo,valor,activo) values("autoridad","'.trim($datos['autoridad']).'", 1)'; // si el parametro no es numero, es una nueva opcion que se debe registrar
							$query= Database::ExeDoIt($sql);
			
							//vuelve a buscar para ob tener el id insertado
							$sql="select id from config_campos where campo ='autoridad' and valor ='".trim($datos['autoridad'])."' limit 1";
							$query= Database::ExeDoIt($sql);
						}
						//si existe la opcion, obtiene el id
						$idAuto = Model::many_assoc($query[0])[0]['id']; ///selecciona el id si o si de la autoridad
					} 

				//??????????????????institucion 
					$idInstitucion = $datos['institucion'];
					if (!is_numeric($datos['institucion'])){
						//busca institucion por string
						$sql="select id from config_campos where campo ='institucion' and valor ='".trim($datos['institucion'])."' limit 1";
						$query= Database::ExeDoIt($sql);
						if (!$query[0]->num_rows){//si no existe la opcion, se agrega
							$sql='INSERT into config_campos (campo,valor,activo) values("institucion","'.trim($datos['institucion']).'", 1)'; // si el parametro no es numero, es una nueva opcion que se debe registrar
							$query= Database::ExeDoIt($sql);
			
							//vuelve a buscar para ob tener el id insertado
							$sql="select id from config_campos where campo ='institucion' and valor ='".trim($datos['institucion'])."' limit 1";
							$query= Database::ExeDoIt($sql);
						}
						//si existe la opcion, obtiene el id
						$idInstitucion = Model::many_assoc($query[0])[0]['id'];			
					}

				//campos vacios
				// $datos['tipoIntervencion']='';
				// $datos['tercero']=''; 
				// $datos['nicho']=''; 
				// $datos['materia']=''; 
				// $datos['expediente']=''; 
					

				//??????????????? insert para siniestro nuevo
				$sql="INSERT INTO `siniestros`(
					
					`timerst`, 
					`activo`, 
					`f_numProv`, 
					`f_consecutivo`, 
					`f_year`, 
					`nombre`, 
					`apellidoP`, 
					`apellidoM`, 
					`fechaCaptura`, 
					`proveniente`, 
					`institucion`, 
					`cel`, 
					`casa`, 
					`oficina`, 
					`fechaReporte`, 
					`estado`, 
					`ciudad`, 
					`mail`, 
					`formaContacto`, 
					`descripcionHechos`, 
					`numReporte`, 
					`numPoliza`, 
					`numSiniestro`, 
					`vigencia1`, 
					`vigencia2`, 
					`status`, 
					`calificacion`, 
					`autoridad`,
					`fechaAsignacion`,
					`tipoIntervencion`,
					`tercero`,
					`nicho`,
					`materia`,
					`expediente`

				)
				VALUES(
					'".$new_timerst."',
					1,
					'".$f_numProv."', 
					'".$new_consecutivo."', 
					'". $year ."',
					'".$datos['nombre']."',
					'".$datos['apellidoP']."',
					'".$datos['apellidoM']."',
					'".$datos['fechaCaptura']."',
					'".$datos['proveniente']."',
					'".$idInstitucion."',
					'".$datos['cel']."',
					'".$datos['casa']."',
					'".$datos['oficina']."',
					'".$datos['fechaReporte']."',
					'".$datos['estado']."',
					'".$datos['ciudad']."',
					'".$datos['mail']."',
					'".$datos['formaContacto']."',
					'".$datos['descripcionHechos']."',
					'".$datos['numReporte']."',
					'".$polizasString."',
					'".$datos['numSiniestro']."',
					'".$datos['fechaVigencia1']."',
					'".$datos['fechaVigencia2']."',
					'".$datos['status']."',
					'".$datos['calificacion']."',
					'".$idAuto."', 
					'".$datos['fechaAsignacion']."',
					'".$datos['tipoIntervencion']."',
					'".$datos['tercero']."', 
					'".$datos['nicho']."', 
					'".$datos['materia']."', 
					'".$datos['expediente']."' 
				);";
				$query = Database::exeDoIt($sql,false);
				//core::preprint($sql,'insert de siniiestro nuevo');

				if ($query){ //se insertaron todos los datos correctamente y sus relaciones.

					
					
					core::insertHistoricoSiniestros('Insert','Nuevo Siniestro Creado',$new_timerst);//?historico
					
					$new_consecutivo = str_pad($new_consecutivo,  3, "0",STR_PAD_LEFT); //agrega ceros al consecutivo.
					$fl= $f_numProv.'-'.$new_consecutivo.'-'.explode(20,$year)[1]; //arma el folio de nuevo
					
					//?agregando datos para folio de los emails
					$datos['folio']= $fl;
					///Mails::send_mail_new_id($datos);//ya trae la informacion del siniestro, ya trae lso id de los usuarios y de areas, se envian para generar formatos y destinatarios de correos
					
					//?añade un registro a siniestros descripcion
					//se cancela la escritura de la primer edicion al cargar la segunda edicion, se respalda la primera y asi consecutivamente.
					/* $sql="INSERT INTO  siniestros_descripcion_hechos(timerst,autor,area,folio,fecha_creacion,rev,descripcion_hechos)
                                    values('$new_timerst','".$_SESSION['id']."','".explode('/',$_SESSION['grupo'][0])[2]."', '".$fl."', '".Core::getTimeNow()."',1, '".$datos['descripcionHechos']."')";
                            $query = Database::ExeDoIt($sql); */

					//se envia mail
					$mail = Correo::send_notify_new_id( array("timerst"=>$new_timerst,"folio"=>$fl,"fechaCreacion"=>$datos['fechaCaptura'],"fechaAsignacion"=>$datos['fechaAsignacion'],"abogados"=>$mail_dirs_abogados,"areas"=>$mail_areas));
					/* Array
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

					if($mail == 'EXITO'){
						print json_encode(array ("res"=>"siniestro","siniestro"=>"$new_timerst","folio"=>$fl));
					}else{
						print json_encode(array ("res"=>"siniestro","siniestro"=>"$new_timerst","folio"=>$fl.' Error al enviar email'));
					}

				}

			}
			else{
				//devuelve falso y se debe volver a ejecutar la funcion newFolioProv
				return false;
			}

		
		


	} //fin de funcion crearFolioNuevoProv

	//folios creados a partir del CSV
	public static function crearFolioNuevoProvCSV($prov,$datos=[]){
		/**
	 * @param prov:string siglas de un proveedor sin * prov_ *
	 * @param datos:string array de los datos del siniestro.
	 */
			ini_set('display_errors', 1);
			ini_set('display_startup_errors', 1);
			error_reporting(E_ALL & ~E_DEPRECATED);

		$year = date("Y");

		$HOY=core::getTimeNow();
		$fa= '';

		if(!isset($datos['_folio'])){ //si no existe $datos['_folio'] , es nuevo folio, si si existe es uno cargado de CSV
			$sql="select timerst,consecutivo from `prov_".$prov."` where anualidad = $year order by create_at desc limit 1;";
			$query = Database::exeDoIt($sql);
			if($query[0]->num_rows==1){ //? si el resultado de la consulta es igual a 1 registro del año por lo menos.
				$data = Model::unsetOne($query[0]);
				$new_timerst 		= core::getMicrotime($data['timerst']); //nuevo timerst mayor que el ultimo en la tabla
				$new_consecutivo 	= $data['consecutivo']+1;  //nuevo numero consecutivo
			}else{
				//se entiende wque si no hay resukltado por año es por que no existe el cero o el año ha cambiado. y se necesita crear nuevo folio
				$sql="select timerst,consecutivo from `prov_".$prov."` order by create_at desc limit 1;";
				$query = Database::exeDoIt($sql);
				$data = Model::unsetOne($query[0]);
				$new_timerst 		= core::getMicrotime(0); //nuevo timerst mayor que el ultimo en la tabla
				$new_consecutivo 	= 1;  //nuevo numero consecutivo

			}
		}else{ // el $datos['_folio'] existe, entonces es cargado de CSV
			$tempFolio = explode('-',$datos['_folio']);
			$f_numProv = $tempFolio[0];
			$new_consecutivo =  $tempFolio[1];
			$year = '20'.$tempFolio[2];
			$HOY=$datos['_fcreacion'];
			$fa=$datos['_fa'];

			$new_timerst 		= core::getMicrotime(0); 
		}
		
		// DEMO
		
		///???? espacoio para probar codigo
		
		// DEMO


			//?insertar el nuevo registro en TB prov
			$strSQL="INSERT INTO `prov_".$prov."`(`timerst`,`consecutivo`,`anualidad`) values('$new_timerst',$new_consecutivo,$year);";
			$querySQL = Database::exeDoIt($strSQL,false);

			if($querySQL){
				////??????????????? crear array de polizas
				$polizasString = '[';
				if( is_string( $datos['numPoliza'] ) ){
					// $datos['numPoliza'] = json_encode([$datos['numPoliza']]);
					$datos['numPoliza'] = [$datos['numPoliza']];
					//core::preprint($datos['numPoliza'] ,'($datos[numPoliza]');
				}
				foreach ($datos['numPoliza'] as $key => $value) {
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
				}//fn de foreach datos['numPoliza']
				$polizasString=  rtrim($polizasString, ",");
				$polizasString .= ']'; // cerrar corchete
				

				////??????????????? crear array de abogados y estados de asignacion.
				if(isset($datos['abogados'])){
					$sql="INSERT INTO `siniestros_usuarios`(`timerst`,`usuario`,`estatus`,fecha_creacion)  values";
					if( is_string( $datos['abogados'] ) ){
						$datos['abogados'] = array( $datos['abogados'] );
						//core::preprint($datos['abogados'] ,'($datos[abogados]');
					}

					foreach ($datos['abogados'] as $key => $value) {
						$sql .="  ('$new_timerst',$value,1, '".$HOY."'), ";
						$query = Database::exeDoIt($sql,false);
					}
					$sql = rtrim($sql,' ,').';';
					$query = Database::exeDoIt($sql);
				}

				////??????????????? crear array de areas y estados de asignacion.
				foreach ($datos['area'] as $key=>$value){
					$sql="INSERT INTO `siniestros_areas`(`timerst`,`area`,`estatus`,fecha_creacion) values('$new_timerst',$value,1,'".$HOY."');";
					$query=Database::exeDoIt($sql);

					$sql="INSERT INTO `siniestros_usuarios`(`timerst`,`usuario`,`estatus`,fecha_creacion) 
					values ('$new_timerst',(select idUsuario from gruposusuario where idArea = $value and IdGrupo=2 limit 1  ),1, '".$HOY."') ";
					$query=Database::exeDoIt($sql);
					//solo asignara el jefe del area si existe 1, si existen 2 jefes de area, asignara al primer segun el orden del ID
				}
				
				//??????????????? numero de proveedor
				if(!isset($f_numProv)){
					$f_numProv = "select id from config_prov where tabla ='prov_".$prov."' limit 1";
					$query = Database::ExeDoIt($f_numProv);
					$f_numProv = Model::many_assoc($query[0])[0]['id'];//! numero de proveedor OK
					//core::preprint($f_numProv,'f_numProv')
				}

					///????????????  autoridad
					$idAuto = $datos['autoridad'];
					if (!is_numeric($datos['autoridad'])){
						//print("erick leonel");exit();
						//busca autoridad por string
						$datos['autoridad'] = strtoupper($datos['autoridad']);
						$sql="select id from config_campos where campo ='autoridad' and valor ='".trim($datos['autoridad'])."' limit 1";
						$query= Database::ExeDoIt($sql,true);
						//exit();
						if (!$query[0]->num_rows){//si no existe la opcion, se agrega
							$sql='INSERT into config_campos (campo,valor,activo) values("autoridad","'.trim($datos['autoridad']).'", 1)'; // si el parametro no es numero, es una nueva opcion que se debe registrar
							$query= Database::ExeDoIt($sql);
			
							//vuelve a buscar para ob tener el id insertado
							$sql="select id from config_campos where campo ='autoridad' and valor ='".trim($datos['autoridad'])."' limit 1";
							$query= Database::ExeDoIt($sql);
						}
						//si existe la opcion, obtiene el id
						$idAuto = Model::many_assoc($query[0])[0]['id']; ///selecciona el id si o si de la autoridad
					} 

					//??????????????????institucion 
					$idInstitucion = $datos['institucion'];
					if (!is_numeric($datos['institucion'])){
						//busca institucion por string
						$sql="select id from config_campos where campo ='institucion' and valor ='".trim($datos['institucion'])."' limit 1";
						$query= Database::ExeDoIt($sql);
						if (!$query[0]->num_rows){//si no existe la opcion, se agrega
							$sql='INSERT into config_campos (campo,valor,activo) values("institucion","'.trim($datos['institucion']).'", 1)'; // si el parametro no es numero, es una nueva opcion que se debe registrar
							$query= Database::ExeDoIt($sql);
			
							//vuelve a buscar para ob tener el id insertado
							$sql="select id from config_campos where campo ='institucion' and valor ='".trim($datos['institucion'])."' limit 1";
							$query= Database::ExeDoIt($sql);
						}
						//si existe la opcion, obtiene el id
						$idInstitucion = Model::many_assoc($query[0])[0]['id'];			
					}

					//campos vacios
					$datos['tipoIntervencion']='';
					$datos['tercero']=''; 
					$datos['nicho']=''; 
					$datos['materia']=''; 
					$datos['expediente']=''; 

				//core::preprint($datos,"DATOS");exit();
				//??????????????? insert para siniestro nuevo
				$sql="INSERT INTO `siniestros`(
					
					`timerst`, 
					`activo`, 
					`f_numProv`, 
					`f_consecutivo`, 
					`f_year`, 
					`nombre`, 
					`apellidoP`, 
					`apellidoM`, 
					`fechaCaptura`, 
					`proveniente`, 
					`institucion`, 
					`cel`, 
					`casa`, 
					`oficina`, 
					`fechaReporte`, 
					`estado`, 
					`ciudad`, 
					`mail`, 
					`formaContacto`, 
					`descripcionHechos`, 
					`numReporte`, 
					`numPoliza`, 
					`numSiniestro`, 
					`vigencia1`, 
					`vigencia2`, 
					`status`, 
					`calificacion`, 
					`autoridad`,
					`fechaAsignacion`,
					`fa`,
					`tipoIntervencion`,
					`tercero`,
					`nicho`,
					`materia`,
					`expediente`
					
				)
				VALUES(
					'".$new_timerst."',
					1,
					'".$f_numProv."', 
					'".$new_consecutivo."', 
					'". $year ."',
					'".$datos['nombre']."',
					'".$datos['apellidoP']."',
					'".$datos['apellidoM']."',
					'".$datos['_fcreacion']."',
					'".$datos['proveniente']."',
					'".$idInstitucion."',
					'".$datos['cel']."',
					'".$datos['casa']."',
					'".$datos['oficina']."',
					'".$datos['fechaReporte']."',
					'".$datos['estado']."',
					'".$datos['ciudad']."',
					'".$datos['mail']."',
					'".$datos['formaContacto']."',
					'".$datos['descripcionHechos']."',
					'".$datos['numReporte']."',
					'".$polizasString."',
					'".$datos['numSiniestro']."',
					'".$datos['fechaVigencia1']."',
					'".$datos['fechaVigencia2']."',
					".$datos['status'].",
					".$datos['calificacion'].",
					'".$idAuto."', 
					'".$datos['fechaAsignacion']."',
					'".$fa."',
					'".$datos['tipoIntervencion']."',
					'".$datos['tercero']."', 
					'".$datos['nicho']."', 
					'".$datos['materia']."', 
					'".$datos['expediente']."' 
				);";
				$query = Database::exeDoIt($sql,false);
				//exit();
				//core::preprint($sql,'insert de siniiestro nuevo');

				if ($query){ //se insertaron todos los datos correctamente y sus relaciones.

					core::insertHistoricoSiniestros('Creación','Nuevo Siniestro Creado',$new_timerst);//?historico

					$new_consecutivo = str_pad($new_consecutivo,  3, "0",STR_PAD_LEFT); //agrega ceros al consecutivo.
					$fl= $f_numProv.'-'.$new_consecutivo.'-'.explode(20,$year)[1]; //arma el folio de nuevo

					//?agregando datos para folio de los emails
					$datos['folio']= $fl;
					///Mails::send_mail_new_id($datos);//ya trae la informacion del siniestro, ya trae lso id de los usuarios y de areas, se envian para generar formatos y destinatarios de correos

					print json_encode(array ("res"=>"siniestro","siniestro"=>"$new_timerst","folio"=>$fl));
				}
				else{//si falla, escribe en el log
					print json_encode(array ("res"=>"no se escribio ","siniestro"=>"$new_timerst","folio"=>$datos,"sql"=>$sql));
				}

			}
			else{
				//devuelve falso y se debe volver a ejecutar la funcion newFolioProv
				return false;
			}

		
		


	} //fin de funcion crearFolioNuevoProv

	
	//folio actualizado mediante UPDATE a partir del CSV
	public static function updateFPCSV($prov,$datos=[],$timerstUpdate){
		/**
	 * @param prov:string siglas de un proveedor sin * prov_ *
	 * @param datos:string array de los datos del siniestro.
	 */
			ini_set('display_errors', 1);
			ini_set('display_startup_errors', 1);
			error_reporting(E_ALL & ~E_DEPRECATED);


			$tempFolio = explode('-',$datos['_folio']);
			$f_numProv = $tempFolio[0];
			$new_consecutivo =  $tempFolio[1];
			$year = '20'.$tempFolio[2];
			$HOY=$datos['_fcreacion'];
			$fa=$datos['_fa'];
			$new_timerst 		= $timerstUpdate;
		
		// DEMO
		///???? espacoio para probar codigo
		// DEMO


			//?insertar el nuevo registro en TB prov ya no es necesario. solo editara siniestros TB
			//$strSQL="INSERT INTO `prov_".$prov."`(`timerst`,`consecutivo`,`anualidad`) values('$new_timerst',$new_consecutivo,$year);";
			//$querySQL = Database::exeDoIt($strSQL,false);

			
				////??????????????? crear array de polizas
				$polizasString = '[';
				if( is_string( $datos['numPoliza'] ) ){
					// $datos['numPoliza'] = json_encode([$datos['numPoliza']]);
					$datos['numPoliza'] = [$datos['numPoliza']];
					//core::preprint($datos['numPoliza'] ,'($datos[numPoliza]');
				}
				foreach ($datos['numPoliza'] as $key => $value) {
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
				}//fn de foreach datos['numPoliza']
				$polizasString=  rtrim($polizasString, ",");
				$polizasString .= ']'; // cerrar corchete
				

				////??????????????? crear array de abogados y estados de asignacion.
				if(isset($datos['abogados'])){
					$sql = "select * from siniestros_usuarios where timerst = X and usuario = Y limit 1";
					$query= Database::ExeDoIt($sql[0]);
					if($query[0]->num_rows ==1){ //REVISA SI EXISTE ASIGNACION DEL USUARIO

					}
					else{

					}

					$sql="INSERT INTO `siniestros_usuarios`(`timerst`,`usuario`,`estatus`,fecha_creacion)  values";
					if( is_string( $datos['abogados'] ) ){
						$datos['abogados'] = array( $datos['abogados'] );
						//core::preprint($datos['abogados'] ,'($datos[abogados]');
					}

					foreach ($datos['abogados'] as $key => $value) {
						$sql = "select * from siniestros_usuarios where timerst = X and usuario = $value limit 1";
						$query= Database::ExeDoIt($sql);
						if($query[0]->num_rows ==1){ //REVISA SI EXISTE ASIGNACION DEL USUARIO
							continue;
						}else{
							$sql .="  ('$timerstUpdate',$value,1, '".$HOY."'), ";
						}
					}
					$sql = rtrim($sql,' ,').';';
					$query = Database::exeDoIt($sql); // ejecuta el sql de todos los inserts de usuarios a siniestros_usuarios
				}

				////??????????????? crear array de areas y estados de asignacion.
				foreach ($datos['area'] as $key=>$value){
					$sql="INSERT INTO `siniestros_areas`(`timerst`,`area`,`estatus`,fecha_creacion) values('$new_timerst',$value,1,'".$HOY."');";
					$query=Database::exeDoIt($sql);

					$sql="INSERT INTO `siniestros_usuarios`(`timerst`,`usuario`,`estatus`,fecha_creacion) 
					values ('$new_timerst',(select idUsuario from gruposusuario where idArea = $value and IdGrupo=2 limit 1  ),1, '".$HOY."') ";
					$query=Database::exeDoIt($sql);
					//solo asignara el jefe del area si existe 1, si existen 2 jefes de area, asignara al primer segun el orden del ID
				}
				
				//??????????????? numero de proveedor
				if(!isset($f_numProv)){
					$f_numProv = "select id from config_prov where tabla ='prov_".$prov."' limit 1";
					$query = Database::ExeDoIt($f_numProv);
					$f_numProv = Model::many_assoc($query[0])[0]['id'];//! numero de proveedor OK
					//core::preprint($f_numProv,'f_numProv')
				}

					///????????????  autoridad
					$idAuto = $datos['autoridad'];
					if (!is_numeric($datos['autoridad'])){
						//print("erick leonel");exit();
						//busca autoridad por string
						$datos['autoridad'] = strtoupper($datos['autoridad']);
						$sql="select id from config_campos where campo ='autoridad' and valor ='".trim($datos['autoridad'])."' limit 1";
						$query= Database::ExeDoIt($sql,true);
						//exit();
						if (!$query[0]->num_rows){//si no existe la opcion, se agrega
							$sql='INSERT into config_campos (campo,valor,activo) values("autoridad","'.trim($datos['autoridad']).'", 1)'; // si el parametro no es numero, es una nueva opcion que se debe registrar
							$query= Database::ExeDoIt($sql);
			
							//vuelve a buscar para ob tener el id insertado
							$sql="select id from config_campos where campo ='autoridad' and valor ='".trim($datos['autoridad'])."' limit 1";
							$query= Database::ExeDoIt($sql);
						}
						//si existe la opcion, obtiene el id
						$idAuto = Model::many_assoc($query[0])[0]['id']; ///selecciona el id si o si de la autoridad
					} 

					//??????????????????institucion 
					$idInstitucion = $datos['institucion'];
					if (!is_numeric($datos['institucion'])){
						//busca institucion por string
						$sql="select id from config_campos where campo ='institucion' and valor ='".trim($datos['institucion'])."' limit 1";
						$query= Database::ExeDoIt($sql);
						if (!$query[0]->num_rows){//si no existe la opcion, se agrega
							$sql='INSERT into config_campos (campo,valor,activo) values("institucion","'.trim($datos['institucion']).'", 1)'; // si el parametro no es numero, es una nueva opcion que se debe registrar
							$query= Database::ExeDoIt($sql);
			
							//vuelve a buscar para ob tener el id insertado
							$sql="select id from config_campos where campo ='institucion' and valor ='".trim($datos['institucion'])."' limit 1";
							$query= Database::ExeDoIt($sql);
						}
						//si existe la opcion, obtiene el id
						$idInstitucion = Model::many_assoc($query[0])[0]['id'];			
					}

					//campos vacios
					$datos['tipoIntervencion']='';
					$datos['tercero']=''; 
					$datos['nicho']=''; 
					$datos['materia']=''; 
					$datos['expediente']=''; 

				//core::preprint($datos,"DATOS");exit();
				//??????????????? insert para siniestro nuevo
				$sql="UPDATE `siniestros` set 
					`activo`  =   1,
					`nombre`  =   '".$datos['nombre']."',
					`apellidoP`  =   '".$datos['apellidoP']."',
					`apellidoM`  =   '".$datos['apellidoM']."',
					`fechaCaptura`  =   '".$datos['_fcreacion']."',
					`proveniente`  =   '".$datos['proveniente']."',
					`institucion`  =   '".$idInstitucion."',
					`cel`  =   '".$datos['cel']."',
					`casa`  =   '".$datos['casa']."',
					`oficina`  =   '".$datos['oficina']."',
					`fechaReporte`  =   '".$datos['fechaReporte']."',
					`estado`  =   '".$datos['estado']."',
					`ciudad`  =   '".$datos['ciudad']."',
					`mail`  =   '".$datos['mail']."',
					`formaContacto`  =   '".$datos['formaContacto']."',
					`descripcionHechos`  =   '".$datos['descripcionHechos']."',
					`numReporte`  =   '".$datos['numReporte']."',
					`numPoliza`  =   '".$polizasString."',
					`numSiniestro`  =   '".$datos['numSiniestro']."',
					`vigencia1`  =   '".$datos['fechaVigencia1']."',
					`vigencia2`  =   '".$datos['fechaVigencia2']."',
					`status`  =   ".$datos['status'].",
					`calificacion`  =   ".$datos['calificacion'].",
					`autoridad` =   '".$idAuto."', 
					`fechaAsignacion` =   '".$datos['fechaAsignacion']."',
					`fa` =   '".$fa."',
					`tipoIntervencion` =   '".$datos['tipoIntervencion']."',
					`tercero` =   '".$datos['tercero']."', 
					`nicho` =   '".$datos['nicho']."', 
					`materia` =   '".$datos['materia']."', 
					`expediente`					 =   '".$datos['expediente']."' 
				;";
				$query = Database::exeDoIt($sql,true);
				//exit();
				//core::preprint($sql,'insert de siniiestro nuevo');

				if ($query){ //se insertaron todos los datos correctamente y sus relaciones.

					core::insertHistoricoSiniestros('Actualización','Siniestro import',$new_timerst);//?historico

					$new_consecutivo = str_pad($new_consecutivo,  3, "0",STR_PAD_LEFT); //agrega ceros al consecutivo.
					$fl= $f_numProv.'-'.$new_consecutivo.'-'.explode(20,$year)[1]; //arma el folio de nuevo

					//?agregando datos para folio de los emails
					$datos['folio']= $fl;
					///Mails::send_mail_new_id($datos);//ya trae la informacion del siniestro, ya trae lso id de los usuarios y de areas, se envian para generar formatos y destinatarios de correos

					print json_encode(array ("res"=>"siniestro","siniestro"=>"$new_timerst","folio"=>$fl));
				}
				else{//si falla, escribe en el log
					print json_encode(array ("res"=>"no se escribio ","siniestro"=>"$new_timerst","folio"=>$datos,"sql"=>$sql));
				}

			

	} //fin de funcion


}//fin de calse

?>