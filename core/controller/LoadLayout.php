<?php
// @elmm Define el layout a cargar segun este logueado o no.
class LoadLayout {

    public function LoadLayout(){

    }

	public static function _LoadLayout(){
        if(Session::issetUID()==true){
            //! agregar aqui lineas para cargar plantillas de usuario o de administrador.
            include "core/app/layouts/cmaLayout/layoutUser.php";
        }else{    
            include "core/app/layouts/unsetUser/unsetUserLayout.php";
            
        }

        // if(Core::$root==""){
        //     include "core/app/layouts/layout.php";
        // }else if(Core::$root=="admin/"){
        //     include "core/app/".Core::$theme."/layouts/layout.php";
		// }
	}

}

?>