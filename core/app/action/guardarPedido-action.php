<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

/* [0] => pedido Object
    (
        [id] => 47
        [titulo] => CHILE ARBOL MOLIDO
        [precio] => 55
        [maximo] => 
        [minimo] => 35
        [peso] => 4
        [subtotal] => 220
    ) */
$pedido = json_decode($_POST["json"]);
$idCliente = $_POST["cliente"]!='Venta General'?$_POST["cliente"]:intval(0);
$folioVenta = isset($_POST["folio"])?$_POST["folio"]:null;
$notaVenta = isset($_POST["nota"])?$_POST["nota"]:null;


$montoTotal = 0; foreach ($pedido as $producto => $values) {
$montoTotal= intval($montoTotal) + (intval($values->peso) * intval($values->precio));}

$time = Core::getTimeNow();
$timeStamp= Core::getTimeStamp($time);

// core::preprint($timeStamp,'timestamp');
// core::preprint($time,'time');

if($folioVenta==null){
    //no trae folio: //* debe guardar nuevo folio
    $sql="insert into venta_tiket(sucursal,vendedor,cliente_id,monto_total,estatus,fecha_creacion,folio)";
    $sql.="values(1,".$_SESSION['id'].",".$idCliente.",".$montoTotal.",'abierto','".$time."','".$timeStamp."')";
    $query = Database::ExeDoIt($sql);
    
    $sql="Select * from venta_tiket where folio = '".$timeStamp."'";
    $query=Database::ExeDoIt($sql);
    $venta_tiket = Model::many_assoc($query[0]);
    //echo json_encode($venta_tiket);
    foreach ($pedido as $producto => $values) {
        $sql="insert into compras (id_venta,cliente_id,producto,title,peso,precio,estatus,fecha)";
        $sql.="values('".$timeStamp."',".$idCliente.",".$values->id.",'".$values->titulo."','".intval($values->peso)."',".intval($values->precio).",'abierto','".$time."')";
        $query = Database::ExeDoIt($sql);
        //core::preprint($sql);exit();
    }
    $data =  [
        'folio'=>$venta_tiket[0]['folio'],
        'nota'=>$venta_tiket[0]['id'],
    ];
    echo  json_encode($data);
    exit(); //termina de insertar nueva compra/venta/nuevo tiket y productos

}
else {
 
   //si trae folio //* guarda el pedido en el folio existente
        /* json: [{"id":"49","titulo":"CHILE CANICA","precio":4,"maximo":null,"minimo":0,"peso":"66","subtotal":264}]
        cliente: Venta General
        folio: 1632587943
        nota: 30 */

    //cambia cliente en todos los productos
    $sql="update compras set cliente_id = ". $idCliente ." where id_venta = '".$folioVenta."' ";
    $query = Database::ExeDoIt($sql);
    core::preprint($sql);

    //cambia cliente y total de la nota de venta
    $sql="update venta_tiket set
    cliente_id = $idCliente,
    monto_total = $montoTotal
    where id = $notaVenta and folio = '".$folioVenta."' ";
    $query = Database::ExeDoIt($sql);

    //core::preprint($sql);

    foreach ($pedido as $producto => $values) {
        $sql="select id from compras where id_venta = ".$folioVenta." and producto = ".$values->id ." and title = '".$values->titulo."';";
        $query = Database::ExeDoIt($sql);
        switch ($query[0]->num_rows) {
            case 0:
            case '0':
            case null:
            case false:
                # no existe... se inserta nuevo producto
                $sql="insert into compras (id_venta,cliente_id,producto,title,peso,precio,estatus,fecha)";
                $sql.="values('".$folioVenta."',".$idCliente.",".$values->id.",'".$values->titulo."','".intval($values->peso)."',".intval($values->precio).",'abierto','".$time."')";
                $query = Database::ExeDoIt($sql);
                core::preprint($sql);

                break;
            case '1':
                # existe un resultado.... se edita elproducto
                $id_producto_editar = Model::unsetOne($query[0]);
                $sql="update compras set 
                cliente_id = $idCliente,
                peso = '".intval($values->peso)."',
                precio = '".intval($values->precio)."'
               where id = ".$id_producto_editar[0].";";
                $query = Database::ExeDoIt($sql);
                core::preprint($sql);
                break;
            default:
                # existen más resultados... //!pendiente!!
                break;
        }
    }
      
}
exit();
        /* $sql="insert into compras (id_venta,cliente_id,producto,peso,precio,estatus,fecha)";
        $sql.="values('".$timeStamp."',".$idCliente.",".$values->id.",'".intval($values->peso)."',".intval($values->precio).",'abierto','".$time."')";
        $query = Database::ExeDoIt($sql); */
        //core::preprint($sql);exit();
    




/* [0] => pedido Object
    (
        [id] => 47
        [titulo] => CHILE ARBOL MOLIDO
        [precio] => 55
        [maximo] => 
        [minimo] => 35
        [peso] => 4
        [subtotal] => 220
    ) */
$sql= "SELECT folio FROM compras WHERE id_venta != '0' ORDER BY id DESC LIMIT 1";

core::preprint($_REQUEST);exit();


class NOAjaxNuevo{

	/*=============================================
	NUEVO USUARIO
	=============================================*/	

	public $json;
	public $cliente;

	public function ajaxNuevoPedido(){

		$json = $this->json;
		$cliente = $this->cliente;

		$ultimoId = ControladorVentas::ctrTraerUltimo();

		$jsonDecode = json_decode($json, true);

		for($i = 0; $i < count($jsonDecode) ; $i++){

			$id = $jsonDecode[$i]["id"];
			$peso = $jsonDecode[$i]["peso"];
			$precio = $jsonDecode[$i]["precio"];
			
			$guardar = ControladorVentas::ctrGuardarCompra($ultimoId["id_venta"], $cliente, $id, $peso, $precio);

		}
		
		echo $guardar;
		//echo $ultimoId["id_venta"];

	}

}

/*=============================================
NUEVO USUARIO
=============================================*/
/* $traerProducto = new AjaxNuevo();
$traerProducto -> json = $_POST["json"];
$traerProducto -> cliente = $_POST["cliente"];
$traerProducto -> ajaxNuevoPedido(); */



