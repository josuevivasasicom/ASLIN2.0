<?php
class Config {
	public static $tablename = "config";

	public function Config(){
		$this->id = "";
	}

	// ************************************ inicio DEMO DE SENTENCIAS
	public static function EJEMPLO1(){
		$base = new Database();
		$con = $base->connect();
		$sql = "SELECT * FROM pruebas WHERE id_usuario = " . $_SESSION['id'] ."ORDER BY id DESC";
		$query = $con->query($sql);
		//$data=Model::many($query[0],new Config());
		return $query->fetch_array();
	}
	public static function EJEMPLO2(){
		$sql= "select count(id) from usuarios where 1";
		$query = Database::exeDoIt($sql);
		$data=Model::many_assoc($query[0])[0];
		return $data;
	}
	// ************************************ fin DEMO DE SENTENCIAS

	//todo carga el select popr categorias de como se ve el seleccionador de ficheros para subir al ID FOLIO SINIESTRO// tambien la tabla en config
	public static function datosSelectFilesUoload($orden='',$limitInf='',$limitSup=''){
		//?Select del array para mostrar todos los select en uno solo sin filtrar!
		$sql="SELECT c1.id,c1.valor,c2.valor c2, c3.valor c3 FROM `config_files` c1 LEFT JOIN config_files c2 on c1.parent=c2.id LEFT JOIN config_files c3 on c2.parent=c3.id WHERE c1.nivel=3";
		if ($orden!=''){
			$sql.="  ".$orden." limit ".$limitInf.",". $limitSup;
		}
		$query = Database::ExeDoIt($sql);
		$data = Model::many_assoc($query[0]);
		return $data;
	}

	//todo TABLA provenientes para jtable
	public static function countProvenientesTodos(){// utilizado para jtabla config/provenientes
		$sql= "select count(id) countProv from config_prov where estatus=1";
		$query = Database::exeDoIt($sql);
		$data=Model::many_assoc($query[0])[0];
		return $data['countProv'];
	}
	public static function getAllProvenientes($orden,$limitInf,$limitSup){// utilizado para jtabla config/usuarios
		// $sql= "select a.area,g.grupo from gruposusuario gu left join areas a on gu.idArea=a.id inner join grupo g on gu.idGrupo =g.id where gu.idUsuario = ". $_SESSION['id']";
		$sql= "select id,descripcion,proveniente,borderColor,backgroundColor,if(estatus=1,'Activo','Deshabilitado') as estatus
		 from config_prov cf where 1 ".
		$orden." limit ".$limitInf.",". $limitSup;
		$query = Database::exeDoIt($sql);
		$data=Model::many_assoc($query[0]);
		return $data;
	}

	//todo TABLA Instituciones para jtable
	public static function countInstitucionesTodos(){// utilizado para jtabla config/Instituciones
		$sql= "select count(id) countInsti from config_campos where campo='institucion' and activo = 1";
		$query = Database::exeDoIt($sql);
		$data=Model::many_assoc($query[0])[0];
		return $data['countInsti'];
	}
	public static function getAllInstituciones($orden,$limitInf,$limitSup){// utilizado para jtabla config/usuarios
		// $sql= "select a.area,g.grupo from gruposusuario gu left join areas a on gu.idArea=a.id inner join grupo g on gu.idGrupo =g.id where gu.idUsuario = ". $_SESSION['id']";
		$sql= "select id,valor,if(activo=1,'Activo','Deshabilitado') as activo
		 from config_campos cf where campo='institucion' ".
		$orden." limit ".$limitInf.",". $limitSup;
		$query = Database::exeDoIt($sql);
		$data=Model::many_assoc($query[0]);
		return $data;
	}

	//todo TABLA Autoridades para jtable
	public static function countAutoridadesTodos(){// utilizado para jtabla config/Autoridades
		$sql= "select count(id) countInsti from config_campos where campo='autoridad'";
		$query = Database::exeDoIt($sql);
		$data=Model::many_assoc($query[0])[0];
		return $data['countInsti'];
	}
	public static function getAllAutoridades($orden,$limitInf,$limitSup){// utilizado para jtabla config/usuarios
		// $sql= "select a.area,g.grupo from gruposusuario gu left join areas a on gu.idArea=a.id inner join grupo g on gu.idGrupo =g.id where gu.idUsuario = ". $_SESSION['id']";
		$sql= "select id,valor,if(activo=1,'Activo','Deshabilitado') as activo
		 from config_campos cf where campo='autoridad' ".
		$orden." limit ".$limitInf.",". $limitSup;
		$query = Database::exeDoIt($sql);
		$data=Model::many_assoc($query[0]);
		return $data;
	}

	//todo TABLA Estatus en jtable , valores del select2 
	public static function countEstatusTodos(){// utilizado para jtabla config/Estatus
		$sql= "select count(id) countEstatus from config_campos where campo='status'";
		$query = Database::exeDoIt($sql);
		$data=Model::many_assoc($query[0])[0];
		return $data['countEstatus'];
	}
	public static function getAllEstatus($orden,$limitInf,$limitSup){// utilizado para jtabla config/estatus
		$sql= "select id,valor,if(activo=1,'Activo','Deshabilitado') as activo
		 from config_campos cf where campo='status' ".
		$orden." limit ".$limitInf.",". $limitSup;
		$query = Database::exeDoIt($sql);
		$data=Model::many_assoc($query[0]);
		return $data;
	}

		//todo TABLA Calificación en jtable , valores del select2 
		public static function countCalificacionTodos(){// utilizado para jtabla config/Estatus
			$sql= "select count(id) countEstatus from config_campos where campo='calificacion'";
			$query = Database::exeDoIt($sql);
			$data=Model::many_assoc($query[0])[0];
			return $data['countEstatus'];
		}
		public static function getAllCalificacion($orden,$limitInf,$limitSup){// utilizado para jtabla config/estatus
			$sql= "select id,valor,if(activo=1,'Activo','Deshabilitado') as activo
			 from config_campos cf where campo='calificacion' ".
			$orden." limit ".$limitInf.",". $limitSup;
			$query = Database::exeDoIt($sql);
			$data=Model::many_assoc($query[0]);
			return $data;
		}


}

?>