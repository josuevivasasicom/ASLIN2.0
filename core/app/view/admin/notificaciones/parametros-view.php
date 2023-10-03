<?php
header("Content-type: text/html");
?>
<META HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE">
<!-- inicia modal -->
<div class="content">
    <table id="theTableA" class="display" width="90%">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Reporte</th>
                <th>Siniestro</th>
                <th>Poliza</th>
                <th>Reserva</th>
                <th>Cantidad</th>
                <th>Detalle</th>
                <th>Leída</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>Nombre</th>
                <th>Reporte</th>
                <th>Siniestro</th>
                <th>Poliza</th>
                <th>Reserva</th>
                <th>Cantidad</th>
                <th>Detalle</th>
                <th>Leída</th>
            </tr>
        </tfoot>
    </table>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/select/1.6.2/css/select.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
    <script src="core/app/view/js/jquery.dataTables.min.js"></script>


    <script type="application/javascript">
        $(document).ready(function () {
            $.noConflict();
            $('#theTableA').DataTable({
                order: [],
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.4/i18n/es-MX.json',
                    //cdn.datatables.net/plug-ins/1.13.4/i18n/es-MX.json
                },
                ajax: './?action=siniestro/datos&metodo=mostrar',
                columns: [
                    { "data": "nombre" },
                    { "data": "reporte" },
                    { "data": "siniestro" },
                    { "data": "poliza" },
                    { "data": "reserva" },
                    { "data": "cantidad" },
                    { "data": "detalle" },
                    { "data": "leida" }
                ],
                initComplete: function () {
                    //$('.dataTables_length label').attr('aria-label', 'table length');


                    /*$('label').contents().unwrap();*/

                }
            });

        });

        function actualizar(id) {
            let idActualizar = id;
            $.ajax({
                type: "POST",
                url: './?action=siniestro/datos',
                data:  { metodo: 'editar', id: idActualizar },
                beforeSend:function(){
                    $("#boton_" + id).attr("disabled",true);
                },
                success: function (response) {
                    //var jsonData = JSON.parse(response);

                    // user is logged in successfully in the back-end 
                    // let's redirect 
                    $("#boton_" + id).attr("disabled",false);
                    //if (jsonData.success == "1") {
                    if (response == "1") {
                        //location.href = 'my_profile.php';
                        $("#boton_" + id).html("Si");
                    }
                    else {
                        alert('No se ha podido actulizar la notificación, intente nuevamente');
                    }
                },
                error:function(){
                    $("#boton_" + id).attr("disabled",false);
                    alert('Consulte con el administrador del sistema');
                }
            });

        }
    </script>