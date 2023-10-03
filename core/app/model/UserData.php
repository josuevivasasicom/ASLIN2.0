<?php
class UserData {
	public static $tablename = "empleados";

	public function Userdata(){
		$this->id = "";
		$this->rol = "";
	}

	public static function getDataUser(){
		$sql="select * from usuarios where id = ".$_SESSION['id'] . " limit 1";
		$query= Database::ExeDoIt($sql,false);
		$data= Model::many_assoc($query[0])[0];
		return $data;
	}

	// ************************************ inicio DEMO DE SENTENCIAS
	public static function EJEMPLO1(){
		$base = new Database();
		$con = $base->connect();
		$sql = "SELECT * FROM pruebas WHERE id_usuario = " . $_SESSION['id'] ."ORDER BY id DESC";
		$query = $con->query($sql);
		//$data=Model::many($query[0],new UserData());
		return $query->fetch_array();
	}
	public static function EJEMPLO2(){
		$sql= "select count(id) from usuarios where 1";
		$query = Database::exeDoIt($sql);
		$data=Model::many_assoc($query[0])[0];
		return $data;
	}
	// ************************************ fin DEMO DE SENTENCIAS

	// compraba si el usuario es admin o jefe de area
	public static function isAdmin(){
		$power = 0; // revisa si el usuario tiene derechos de admin o jefe de área
		foreach ($_SESSION['grupo'] as $key) {
			$v = explode('/',$key)[1];
			if ($v=='Admin' || $v=='Jefe de Área' ){ //!debe resisar si es de la misma area
				return $power=1; // cambia el power
			}
		}
	}

	// compraba si el usuario es Abogado o jefe de area
	public static function isAbogado(){
		$power = 0; // revisa si el usuario tiene derechos de Abogado o jefe de área
		foreach ($_SESSION['grupo'] as $key) {
			$v = explode('/',$key)[1];
			if ($v=='Abogado' ){ //!debe resisar si es de la misma area
				return $power=1; // cambia el power
			}
		}
	}

	public static function getPerfil(){
		foreach ($_SESSION['grupo'] as $key) { //revisa si es admin o jefe de area
			$v = explode('/',$key)[1];
			if ($v=='Administrador Siniestros' ){ 
				return array($v,explode('/',$key)[0]); 
				exit();
			}
		}

		foreach ($_SESSION['grupo'] as $key) { //revisa si es admin o jefe de area
			$v = explode('/',$key)[1];
			if ($v=='Admin' || $v=='Jefe de Área' ){ 
				return array($v,explode('/',$key)[0]); 
				exit();
			}
		}
		foreach ($_SESSION['grupo'] as $key) { // si no es jefe de area ni admin, revisa si es abogado.
			$v = explode('/',$key)[1];
			if ($v=='Abogado' ){ 
				return array($v,explode('/',$key)[0]); 
				exit();
			}
		}
		return array(explode('/',$key)[1],explode('/',$key)[0]); // si no es abogadi ni jefe, retorna su valor.
	}
	
	
	// correos de todos los abogados del obj
	public static function get_email_user($data){
		$sql="select email,id from usuarios where id=$data limit 1"; //obligando que sea solo 1
		$query= Database::ExeDoIt($sql);
		$data= Model::unsetOne($query[0]);
		return $data;
	}

	//dataset para graficas del index de usuarios
	public static function datosGraficasIndexUsuarios(){
        //? grafica del dashboard index
        //retorna el array de json`s con los datos de cada proveniente para contar todos los siniestros y generar las graficas.
        $sql= "SELECT count(g.IdGrupo) cantidad,g.IdGrupo,
			(
				select grupo from grupo gg
				where gg.id = g.IdGrupo limit 1
			) grupo
			FROM `gruposusuario` g GROUP by g.IdGrupo;";
		$query = Database::exeDoIt($sql);

		$grupUsers=Model::many_assoc($query[0]);

		
		$labels = [];
        $cantidades = [];
        foreach ($grupUsers as $datoU) {
            //armar el json que se entrega al js
            //$labels[]= ($datoU['grupo']));
			$labels[]=  mb_convert_case($datoU['grupo'], MB_CASE_UPPER, "UTF-8");
                // 'data'=> [10, 11, 15, 10, 3, 14, 15, 11, 6, 0]

    
			$cantidades[]= strtoupper($datoU['cantidad']);
                // 'data'=> [10, 11, 15, 10, 3, 14, 15, 11, 6, 0]
			$data=[$labels,$cantidades];
        }
        print json_encode($data);
    }

	//TABLA SINIESTROS
	public static function countAllUserOfSiniestro($timerst){// utilizado para jtabla siniestros/usuarios
		$sql= "select count(id) totalUsuarios from siniestros_usuarios where timerst = '".$timerst."'";
		$query = Database::exeDoIt($sql,false);
		$data=Model::many_assoc($query[0])[0];
		return $data['totalUsuarios'];

	}
	public static function getAllUserOfSiniestro($timerst){// utilizado para jtabla siniestros/usuarios
		// $sql= "select a.area,g.grupo from gruposusuario gu left join areas a on gu.idArea=a.id inner join grupo g on gu.idGrupo =g.id where gu.idUsuario = ". $_SESSION['id']";
		$sql= "SELECT su.usuario,if(su.estatus=1,'Activo','Deshabilitado'),u.id idUser,u.nombre,u.paterno,u.materno,u.email,if(su.estatus=1,'activo','Deshabilitado') estatus,u.fechaNacimiento,u.celular,u.direccion,u.cedula 
					,(select area from areas where id = gu.idArea) area
					FROM siniestros_usuarios su
					INNER JOIN usuarios u ON su.usuario = u.id
					INNER JOIN gruposusuario gu ON gu.idUsuario = u.id

				WHERE su.timerst ='".$timerst."' GROUP BY su.usuario";
		$query = Database::exeDoIt($sql,false);
		$data=Model::many_assoc($query[0]);
		return $data;
	}






	// TABLA todos USUARIO
	public static function CountUser(){// utilizado para jtabla config/usuarios
		$sql= "select count(id) totalUsuarios from usuarios where 1";
		$query = Database::exeDoIt($sql);
		$data=Model::many_assoc($query[0])[0];
		return $data['totalUsuarios'];

	}
	public static function getAllUsers(){// utilizado para jtabla config/usuarios
		// $sql= "select a.area,g.grupo from gruposusuario gu left join areas a on gu.idArea=a.id inner join grupo g on gu.idGrupo =g.id where gu.idUsuario = ". $_SESSION['id']";
		$sql= "select u.id idUser,u.nombre,u.paterno,u.materno,u.email,if(u.estatus=1,'activo','Deshabilitado') estatus,u.fechaNacimiento,u.celular,u.direccion,u.cedula from usuarios u where 1;";
		$query = Database::exeDoIt($sql);
		$data=Model::many_assoc($query[0]);
		return $data;
	}
	



	
	// TABLA PERMISOS USUARIO
	public static function totalPermisos($idUser){// utilizado para jtabla config/usuarios&permisosUser
		$sql= "select count(id) totalPermisos from gruposusuario where idUsuario = ".$idUser;
		$query = Database::exeDoIt($sql);
		$data=Model::many_assoc($query[0])[0];
		return $data['totalPermisos'];

	}
	public static function getPermisosUsuario($idUser){// utilizado para jtabla config/usuarios
		// $sql= "select a.area,g.grupo from gruposusuario gu left join areas a on gu.idArea=a.id inner join grupo g on gu.idGrupo =g.id where gu.idUsuario = ". $_SESSION['id']";
		$sql= "select a.area,g.grupo,
					u.nombre,u.paterno,u.materno,u.email,u.estatus,u.fechaNacimiento,u.celular,u.direccion,u.cedula
					from gruposusuario gu 
				left join areas a on gu.idArea=a.id 
				inner join grupo g on gu.idGrupo =g.id 
				inner join usuarios u on u.id = gu.idUsuario where u.id = ".$idUser;
		$query = Database::exeDoIt($sql);
		$data=Model::many_assoc($query[0]);
		return $data;
	}





	// TABLA AREAS
	public static function countAreas(){// utilizado para jtabla config/areas
		$sql= "select count(id) totalAreas from areas where 1";
		$query = Database::exeDoIt($sql);
		$data=Model::many_assoc($query[0])[0];
		return $data['totalAreas'];

	}
	public static function getAreas(){// utilizado para jtabla config/areas
		$sql= "select * from areas where 1";
		$query = Database::exeDoIt($sql);
		$data=Model::many_assoc($query[0]);
		return $data;
	}




	// TABLA PERMISOS USUARIO POR AREAS **(desde las areas se ven los usuarios asignados en esa area.)
	public static function totalPermisosAreasUsers($idArea){// utilizado para jtabla config/usuarios&permisosUsers
		$sql= "select count(id) totalPermisos from gruposusuario where idArea = ".$idArea;
		$query = Database::exeDoIt($sql);
		$data=Model::many_assoc($query[0])[0];
		return $data['totalPermisos'];

	}
	public static function getPermisosAreasUsers($idArea){// tilizado para jtabla config/usuarios&permisosUsers
		// $sql= "select a.area,g.grupo from gruposusuario gu left join areas a on gu.idArea=a.id inner join grupo g on gu.idGrupo =g.id where gu.idUsuario = ". $_SESSION['id']";
		$sql= "select a.area,g.grupo,
					u.nombre,u.paterno,u.materno,u.email,u.estatus,u.fechaNacimiento,u.celular,u.direccion,u.cedula
					from gruposusuario gu 
				left join areas a on gu.idArea=a.id 
				inner join grupo g on gu.idGrupo =g.id 
				inner join usuarios u on u.id = gu.idUsuario where gu.idArea = ".$idArea;
		$query = Database::exeDoIt($sql);
		$data=Model::many_assoc($query[0]);
		return $data;
	}


	public static function EJEMPLOgetPermisosAllUsuarios(){// utilizado para jtabla config/usuarios
		// $sql= "select a.area,g.grupo from gruposusuario gu left join areas a on gu.idArea=a.id inner join grupo g on gu.idGrupo =g.id where gu.idUsuario = ". $_SESSION['id']";
		$sql= "select a.area,g.grupo,
					u.nombre,u.paterno,u.materno,u.email,u.estatus,u.fechaNacimiento,u.celular,u.direccion,u.cedula
					from gruposusuario gu 
				left join areas a on gu.idArea=a.id 
				inner join grupo g on gu.idGrupo =g.id 
				inner join usuarios u on u.id = gu.idUsuario where 1"; //todos los usuarios y susu grupos
		$query = Database::exeDoIt($sql);
		$data=Model::many_assoc($query[0]);
		return $data;
	}
	

	public static function getUserName($nombre){
		$nombre= explode(" ",$nombre);
		$sql= "select * from usuarios where like nombre '%".$nombre[1]."%' or paterno like '".$nombre[1]."' ";
		$query = Database::exeDoIt($sql);
		$data=Model::many($query[0],new UserData());
		return $data;
	}

	public static function getUserEmail($email){
		$sql= "select * from usuarios where like email = '%".$email."%' ";
	}

	public static function UserRecoveryPassword($mail,$phone,$hotel,$link){
		$sql = "select nombre,email,id from ".self::$tablename." where email='".$mail."' and telefono = '".$phone."' and hotel= '".$hotel."' ";
		$query = Database::exeDoIt($sql);

		
		if( $query[0]->num_rows==1){  //usuario existe en este hotel y con ese correy y telefono
			$data =  Model::unsetOne($query[0]);
			//core::preprint($data);
			return $data;
		}
		else{
			return false;
		}
	}

	public static function userExist($mail,$hotel,$link){
		$sql = "select nombre,email from ".self::$tablename." where email='".$mail."' and hotel ='".$hotel."'";
		// echo $sql; exit();
		$query = Database::exeDoIt($sql);
		//$data=Model::one($query[0],new UserData());
		//core::preprint($query[0]->num_rows);
		//exit();
		if( $query[0]->num_rows==1){  //isset($data->email)){
			//echo "si existe";
			//var_dump($data->email);
			return true;
			//die();
			//header("Location:./?hotel=".$link."&existe=".$mail."&noregistrado");
			//exit();
		}
		else{
			//echo "no existe";
			//var_dump($data->email);
			return false;
		}
	}

	public static function registroUsuario($data){
		$ahora = core::getTimeNow();

		//core::preprint($data);

		$sql = "select nombre,email from ".self::$tablename." where email='".$data['email']."' and hotel ='".$data['hotel']."'";
		//echo $sql; exit();
		$query = Database::exeDoIt($sql);
		if( $query[0]->num_rows==0){ 
			$pass= self::pass_hash($data['password']);

			$sql="insert into ".self::$tablename."
			(nombre,paterno,materno,email,password,telefono,hotel,fecha,rol,active,created_at,
			fecha_nacimiento,nacionalidad,pasaporte,habitacion)
				values
			('".$data['nombre']."','".$data['paterno']."','".$data['materno']."','".$data['email']."','".$pass."','".$data['telefono']."','".strtoupper($data['hotel'])."','".$ahora."','1',1,'".$ahora."',
			'','','','')";
			//core::preprint($sql);
			//  exit();
			$query = Database::exeDoIt($sql);
			if(!$query){header("Location:./?hotel=".$data['rhotel']."&newUserNO=".$data['email']);}
				
				//$hotel_num = array_search($data['rhotel'],Hoteles::$hoteles);
			$datas = array(
				'nombre'=> $data['nombre'],
				'paterno'=> $data['paterno'],
				'correo'=> $data['email'],
				'hotel_link'=> $data['rhotel'], //CAtaloniaRoyalTulum
				//'hotel'=> Hoteles::$hoteles_nombres[$hotel_num] //full name hotel Catalonia Royal Tulum
			 ); 
			Correo::send_register_user($datas);
			header("Location:./?hotel=".$data['rhotel']."&newUser=".$data['email']);
		}
		else{
			header("Location:./?hotel=".$data['rhotel']."&existe=".$data['email']);
		}
		//Core::preprint(self::userExist($data['email'],$data['hotel'],$data['rhotel']), "userExist");
	}

	public static function userRecoveryPasswordChange($id,$secret,$keyId){
		$sql = "update  usuarios set pass = '".self::pass_hash($secret)."' 
		where id=".$id;
		$query = Database::exeDoIt($sql,false);
		if( $query[0] == 1 ){  //isset($data->email)){
			$sql = "update  usuarios_pas_recovery set activo = 0 where id = ".$keyId;
			$query = Database::exeDoIt($sql,false);
			return true;
		}
		else{
			return false;
		}
	}

	
	
	public static function pass_check($pass,$hash){
		//// invoque var_dump(password_verify($pass, $usuario['password']));
		//? password está definida!!
		if (password_verify($pass, $hash)) {
			return true;
		} else {
			return false;
		}
	}
	 
	public static function pass_hash($pass){
		$opciones = [ 'cost' => 12 ];
		$hash = password_hash($pass, PASSWORD_BCRYPT, $opciones);
		return $hash;
	}
}

?>