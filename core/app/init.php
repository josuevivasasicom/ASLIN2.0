<?php
if(isset($_SESSION["userid"])){ 
    // Core::$user = UserData::getNameById($_SESSION["userid"]); 
}

/// en caso de que el parametro action este definido evitamos que se muestre
/// el layout por defecto y ejecutamos el action sin mostrar nada de vista
// echo "<pre>"  . print_r($_GET) . "</pre>";
if(isset($_GET["action"])){
	Route::action($_GET["action"]);
}else{
	// Bootload::load("default");
	LoadLayout::_loadLayout("index");
}

?>