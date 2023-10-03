<?php
header("Content-type: text/html"); 
?>
<META HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE">

<div class="content">

        <!-- tabla histórico Siniestros -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                <div class="card-header">
                    <!-- <h4 class="card-title"> Histórico de Siniestros</h4> -->
                    <span>Actividad relacionada con todos los siniestros.</span>
                </div>
                <div class="card-body">
                <div id="tablaHistoricoSiniestros" class="mt-1"></div>
                </div>
                </div>
            </div>
        </div>


         <!-- tabla histórico -->
         <div class="row">
            <div class="col-md-12">
                <div class="card">
                <div class="card-header">
                    <!-- <h4 class="card-title"> Histórico Actividades</h4> -->
                    <span>Actividad relacionada con parametros, configuraciones y usuarios.</span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <div id="tablaHistorico" class="mt-1"></div>
                    </div>
                </div>
                </div>
            </div>
        </div>
        

</div>


<script type="text/javascript" defer>
    window.onload=function (){
        

        //activar jtable historigo
        var botonazo = "";
        $('#tablaHistorico').jtable({
            title: 'Histórico actividades',
            messages:{
                noDataAvailable: 'No hay registros!',
                addNewRecord: 'añadir',
                editRecord: 'edit',
            },
            edit: true,
            StartIndex: 1,
            paging: true, //Enable paging
            pageSize: 10,
            pageSizes: [5, 10, 100],
            sorting: true, //Enable sorting
            defaultSorting: 'id DESC',
            openChildAsAccordion: true,
            toolbar_no: {
                items: [{
                    tooltip: 'Exportar a Excel',
                    icon: 'https://www.jtable.org/Content/images/Misc/excel.png',
                    text: 'Excel',
                    click: function() {
                        downloadAsExcel(res.Records, 'historico_general');
                    },
                }]
            },
            actions: {
                listAction: './?action=jtable/tablaHistorico.ajax&jtable=jtable',
                //createAction: '/GettingStarted/CreatePerson',
                //updateAction: '?action=jtable/tablaUsuarios.ajax&editar',
                // deleteAction: '/GettingStarted/DeletePerson'
            },
            fields: {
                id: {
                    title: 'ID',
                    key: true,
                    list: true,
                    width: '3%'
                },
                movimiento: {
                    title: 'movimiento',
                    width: '10%'
                },
                entidad: {
                    title: 'Entidad',
                    width: '10%'
                },
                usuarioN: {
                    title: 'usuario',
                    width: '10%'
                },
                fecha_modificacion: {
                    title: 'Fecha',
                    width: '7%'
                },
                historico: {
                    title: 'historico',
                    width: '7%'
                },
                
            }
        });
        $('#tablaHistorico').jtable('load');

        //activar jtable instituciones
        $('#tablaHistoricoSiniestros').jtable({
            title: 'Movimientos de Siniestros',
            messages:{
                noDataAvailable: 'No hay registros!',
                addNewRecord: 'añadir',
                editRecord: 'edit',
            },
            edit: true,
            StartIndex: 1,
            paging: true, //Enable paging
            pageSize: 10,
            pageSizes: [5, 10, 100],
            sorting: true, //Enable sorting
            defaultSorting: 'id DESC',
            openChildAsAccordion: true,
            toolbar_no: {
                items: [{
                    tooltip: 'Exportar a Excel',
                    icon: 'https://www.jtable.org/Content/images/Misc/excel.png',
                    text: 'Excel',
                    click: function() {
                        downloadAsExcel(res.Records, 'usuarios_cma_');
                    },
                }]
            },
            actions: {
                listAction: './?action=jtable/tablaHistoricoSiniestros.ajax&jtable=jtable',
                //createAction: '/GettingStarted/CreatePerson',
                //updateAction: '?action=jtable/tablaUsuarios.ajax&editar',
                // deleteAction: '/GettingStarted/DeletePerson'
            },
            fields: {
                id: {
                    title: 'ID',
                    key: true,
                    list: true,
                    width: '3%'
                },
                folio: {
                    title: 'Folio',
                    width: '7%'
                },
                movimiento: {
                    title: 'Movimiento',
                    width: '10%'
                },
                usuarioN: {
                    title: 'Usuario',
                    width: '10%'
                },
                fecha: {
                    title: 'Fecha',
                    width: '7%'
                },
                historico: {
                    title: 'Historico',
                    width: '7%'
                },
                
                
            }
        });
        $('#tablaHistoricoSiniestros').jtable('load');


      

    };

    function swalertOk(title,text){
        Swal.fire({
        title: title,
        text: text,
        icon: 'info',
        confirmButtonText: 'Continuar'
        })
    }

</script>


<style defer>
    .swal2-file, .swal2-input, .swal2-textarea {
    font-size: 0.925em !important;
}
</style>
<!-- <script defer src='./assets/js/plugins/spectrum/spectrum.js'></script> -->


<!-- /*     backgroundColor: "#f17eff"
borderColor: "#f17e5d"
descripcion: "Cortes Mena Abogados"
estatus: "Activo"
id: "101"
proveniente: "cma" */ -->