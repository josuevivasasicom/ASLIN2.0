<?php

switch ($_SESSION['rol']) {
    case '4': // administrador de siniestros
    case '1': //admin general
        include "verTodos/admin-view.php";
        break;
    case '2': // jefe de area
        include "verTodos/jefe-view.php";
        break;
    case '3': // abogado
        include "verTodos/abogado-view.php";
        break;
    default: //cualquiera
        include "verTodos/abogado-view.php";
        break;
}

