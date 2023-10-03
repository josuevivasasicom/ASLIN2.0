<?php

switch ($_SESSION['rol']) {
    case '3': // administrador de siniestros
    case '1': //admin general
        include "index/admin-view.php";
        break;
    case '2': // jefe de area
        include "index/jefe-view.php";
        break;
    case '1': // abogado
        include "index/abogado-view.php";
        break;
    default:
       header('Location: ./?view=siniestros'); //redirecciona a siniestros
        break;
}

//fabricando vistas segun los roles