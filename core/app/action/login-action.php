<?php
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);
if(isset($_POST['email'])){
    $email = $_POST['email'];
    $pass = $_POST['pass'];

    $base = new Database();
    $con = $base->connect();
    $sql = "select pass,id,email,nombre,paterno,materno,rol,seccion,avatar,firma from usuarios where email= '". $email ."' AND estatus='1' ";
    $query = $con->query($sql);  
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               
    $resultado = mysqli_num_rows($query);
                //$opciones = [ 'cost' => 12 ];
                //$hash = password_hash($pass, PASSWORD_BCRYPT, $opciones);
                //print_r( $hash);
    
    if ($resultado==1){
        //existe el usuario
        $hash= $query->fetch_assoc();
        if (password_verify($pass, $hash['pass'])) {
            $_SESSION['id']= $hash['id'];
            $_SESSION['email']= $hash['email'];
            $_SESSION['nombre']= $hash['nombre'];
            $_SESSION['paterno']= $hash['paterno'];
            $_SESSION['materno']= $hash['materno'];
            $_SESSION['avatar']= $hash['avatar'];
            $_SESSION['firma']= $hash['firma'];
            // $_SESSION['seccion']= $hash['seccion'];
            $_SESSION['rol']= $hash['rol'];
                $_SESSION['grupo']= [];
               
                $sql2 = "select a.area,g.grupo,gu.idArea, a.descripcion from gruposusuario gu left join areas a on gu.idArea=a.id inner join grupo g on gu.idGrupo =g.id where gu.idUsuario = ". $_SESSION['id'];
                $query2 = Database::exeDoIt($sql2);
                $areasUserSql=Model::many_assoc($query2[0]);
                
                $areasTemp=[];
                foreach ($areasUserSql as $key => $value) {
                    $areasTemp[]=$value['area']."/".$value['grupo']."/".$value['idArea'];
                    $descripcionTemp[] = $value['descripcion'];
                }
                $_SESSION['grupo']= $areasTemp;
                $_SESSION['descripcion'] = $descripcionTemp;
            print 'successLogin';
            header('location: ./?view=index');
            // core::preprint($_SESSION);exit();
        } else {
            print 'password incorrecto';
            header('location: ./?view=index&error=password incorrecto');
            exit();
        }
    }else{
        print "el usuario no existe!";
            header('location: ./?view=index&error=el usuario no existe!');
        exit();
    }
}else if (isset($_SESSION['id']) ){
    //core::preprint($_SESSION);
    header("Location: ./?view=index");
}else{
    header("Location: /index.php");
}

?>