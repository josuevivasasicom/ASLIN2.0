<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

$valor = $_REQUEST["valor"];
$sql = "SELECT * FROM productos WHERE nombre like '%".$valor."%' ";
$base = new Database();
$con= $base->connect();
$query = $con->query($sql);
$valores= Model::many_assoc($query);
echo json_encode($valores);