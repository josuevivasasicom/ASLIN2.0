<?php
header("Content-type: text/html"); 
header("Expires: Mon, 1 Jan 2000 12:00:00 GMT");  
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");  
header("Cache-Control: no-store, no-cache, must-revalidate");  
header("Cache-Control: post-check=0, pre-check=0", false);  
header("Pragma: no-cache")

?>
<META HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE">
<div class="content">
        <div class="row">
        <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title"> Usuarios</h4>
              </div>
              <div class="card-body">
              <div id="tablaTodosUsuarios" class="mt-4"></div>
                <!-- <script src="vistas/plugins/jtable2.4/localization/jquery.jtable.es.js" type="text/javascript"></script> -->
                <script type="text/javascript" defer>
                  /* $(document).ready(function() {
                      $('.js-example-basic-single').select2();
                  }); */
                // $(document).ready(function() {

                window.onload=function (){

                  var botonazo = "";
                    $('#tablaTodosUsuarios').jtable({
                        title: 'Lista de Todos los Usuarios',
                        messages:{
                            noDataAvailable: 'No hay usuarios!',
                            addNewRecord: 'borrar',
                            editRecord: 'quitar Usuario',
                        },
                        edit: true,
                        StartIndex: 1,
                        paging: true, //Enable paging
                        pageSize: 10,
                        pageSizes: [5, 10, 100],
                        sorting: true, //Enable sorting
                        defaultSorting: 'id DESC',

                        //selecting: true, //Enable selecting
                        //multiselect: true, //Allow multiple selecting
                        //selectingCheckboxes: true, //Show checkboxes on first column
                        //selectOnRowClick: false, //Enable this to only select using checkboxes

                        //openChildAsAccordion: true,
                        openChildAsAccordion: true,
                        toolbar: {
                            items: [{
                                tooltip: 'Exportar a Excel',
                                icon: 'https://asicomgraphics.mx/demos/dxlegal/descargar.png',
                                text: 'Excel',
                                click: function() {
                                    downloadAsExcel(res.Records, 'usuarios_cma_');
                                },
                            }]
                        },
                        actions: {
                            listAction: '?action=jtable/tablaUsuarios.ajax',
                            //createAction: '/GettingStarted/CreatePerson',
                            //updateAction: '?action=jtable/tablaUsuarios.ajax&editar',
                            // deleteAction: '/GettingStarted/DeletePerson'
                        },
                        fields: {
                            //CHILD TABLE ""muestra los permisos de cada usuario""
                                permisos: {
                                title: 'Permisos',
                                style: 'jtable-command-column yata',
                                width: '3%',
                                sorting: false,
                                edit: false,
                                create: false,
                                display: function(dataUser) {
                                    //Create an image that will be used to open child table
                                    // var $img = $('<img src="/Content/images/Misc/phone.png" title="Edit phone numbers" />');
                                    var $img = $(
                                         '<center><span class="jtable-page-number-first jtable-page-number-disabled"><img class="nc-icon nc-layout-11" style="font-size: 1.5em;" src="./assets/img/permiso.png"></span></center>'
                                         //'<center><btn class="btn btn-sm btn-outline-danger btn-round btn-icon"><i class="nc-icon nc-layout-11" style="font-size: 1.5em;"></i></btn></center>'
                                        );

                                    //Open child table 
                                    $img.click(function() {

                                        $('#tablaTodosUsuarios').jtable('openChildTable',
                                            $img.closest('tr'), {
                                                title: ' - Permisos de : ' + dataUser.record.nombre+' '+dataUser.record.paterno+' '+dataUser.record.materno,
                                                paging: false, //Enable paging
                                                pageSize: 10,
                                                pageSizes: [10, 15, 50],
                                                sorting: false, //Enable sorting
                                                defaultSorting: 'id ASC',
                                                actions: {
                                                    listAction: '?action=jtable/tablaUsuarios.ajax&permisosUserId=' + dataUser.record.idUser,
                                                },
                                                toolbar: {
                                                    items: [{
                                                        tooltip: 'Añadir Permisos',
                                                        icon: 'https://icons555.com/images/icons-black/image_icon_unlock_pic_512x512.png',
                                                        text: 'Desbloquear Permisos',
                                                        click: function() {
                                                            swalertPermisosUsuario(dataUser.record.idUser);
                                                        },
                                                    }]
                                                },
                                                fields: {
                                                    id: {
                                                        type: 'hidden',
                                                        defaultValue: dataUser.record.idUser
                                                    },
                                                    id: {
                                                        key: true,
                                                        create: false,
                                                        edit: false,
                                                        list: false,
                                                        title: 'referencia'
                                                    },
                                                    area: {
                                                        title: 'Área',
                                                        width: '30%',
                                                        /* options: {
                                                            '1': 'Home phone',
                                                            '2': 'Office phone',
                                                            '3': 'Cell phone'
                                                        } */
                                                    },
                                                    grupo: {
                                                        title: 'Grupo',
                                                        width: '30%'
                                                    },
                                                   
                                                }
                                            },
                                            function(data) { //opened handler
                                                data.childTable.jtable('load');
                                            });
                                    });
                                    //Return image to show
                                    return $img;
                                }
                            },

                            /* Pagos: {
                                title: 'Pagos',
                                style: 'jtable-command-column yata',
                                width: '1%',
                                sorting: false,
                                edit: false,
                                create: false,
                                display: function(dataTiket) {
                                    //Create an image that will be used to open child table
                                    // var $img = $('<img src="/Content/images/Misc/phone.png" title="Edit phone numbers" />');
                                    var $img = $(
                                        '<i class="fas fa-file-invoice-dollar" style="font-size: 1.5em;"></i>'
                                        );

                                    //Open child table  PAGOS del TIKET
                                    $img.click(function() {

                                        $('#tablaTodosUsuarios').jtable('openChildTable',
                                            $img.closest('tr'), {
                                                title: 'Pagos para el tiket : ' + dataTiket.record.folio +' - folio: ' + dataTiket.record.id + ' - ' + dataTiket.record.cliente,
                                                paging: true, //Enable paging
                                                pageSize: 10,
                                                pageSizes: [5, 10, 50],
                                                sorting: true, //Enable sorting
                                                defaultSorting: 'id ASC',
                                                actions: {
                                                    listAction: 'ajax/ventas/pagosTiket.ajax.jtable.php?tiket=' + dataTiket.record.folio,
                                                },
                                                fields: {
                                                    id: {
                                                        title: 'id',
                                                        key: true,
                                                        defaultValue: dataTiket.record.id+'-'+dataTiket.record.folio_unico,
                                                        keyValue: dataTiket.record.id+'-'+dataTiket.record.folio_unico
                                                    },
                                                    folio_unico: {
                                                        title: 'Folio Único',
                                                    },
                                                    metodoPago: {
                                                        title: 'Metodo Pago'
                                                    },
                                                    cantidad: {
                                                        title: 'Cantidad',
                                                        width: '5%'
                                                    },
                                                    pagoExhibicion: {
                                                        title: 'Exhibición Pago',
                                                        width: '1%'
                                                    },
                                                    usuario: {
                                                        title: 'Usuario',
                                                        width: '5%',

                                                    },
                                                    fechaPago: {
                                                        title: 'Fecha Pago',
                                                        width: '5%'
                                                    },
                                                }
                                            },
                                            function(data) { //opened handler
                                                data.childTable.jtable('load');
                                            });
                                    });
                                    //Return image to show
                                    return $img;
                                }
                            },
                             */

                            //CHILD TABLE ""DATOS DEL TIKET DE LA VENTA""

                            idUser: {
                                title: 'id',
                                key: true,
                                list: true,
                                width: '3%'
                            },
                            nombre: {
                                title: 'Nombre',
                                width: '10%'
                            },
                            paterno: {
                                title: 'A. Paterno',
                                width: '10%'
                            },
                            materno: {
                                title: 'A. Materno',
                                width: '10%'
                            },
                            estatus: {
                                title: 'estatus',
                                width: '7%'
                            },
                            fechaNacimiento: {
                                title: 'Fecha Nacimiento',
                                width: '10%'
                            },
                            celular: {
                                title: 'Celular',
                            },
                            direccion: {
                                title: 'Dirección',
                            },
                            cedula: {
                                title: 'Cedula',
                            },
                            
                        }
                    });
                    $('#tablaTodosUsuarios').jtable('load');


                };

                function swalertPermisosUsuario(idUsuario){
                  Swal.fire({
                  title: 'Selecciona un Area',
                  input: 'select',
                  inputOptions: {
                    'Fruits': {
                      apples: 'Apples',
                      bananas: 'Bananas',
                      grapes: 'Grapes',
                      oranges: 'Oranges'
                    },
                    'Vegetables': {
                      potato: 'Potato',
                      broccoli: 'Broccoli',
                      carrot: 'Carrot'
                    },
                    'icecream': 'Ice cream'
                  },
                  inputPlaceholder: 'Selecciona Área',
                  showCancelButton: true,
                  inputValidator: (value) => {
                    return new Promise((resolve) => {
                      if (value === 'oranges') {
                        resolve()
                      } else {
                        resolve('El Área ya esta asignada :\)')
                      }
                    })
                  }
                });
                }
                  
                  
                </script>
              </div>
            </div>
        </div>


          <div class="col-md-12">
            <!-- <div class="card">
              <div class="card-header">
                <h4 class="card-title"> Usuarios</h4>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table">
                    <thead class=" text-primary">
                      <th>
                        Name
                      </th>
                      <th>
                        Country
                      </th>
                      <th>
                        City
                      </th>
                      <th class="text-right">
                        Salary
                      </th>
                    </thead>
                    <tbody>
                      <tr>
                        <td>
                          Dakota Rice
                        </td>
                        <td>
                          Niger
                        </td>
                        <td>
                          Oud-Turnhout
                        </td>
                        <td class="text-right">
                          $36,738
                        </td>
                      </tr>
                      <tr>
                        <td>
                          Minerva Hooper
                        </td>
                        <td>
                          Curaçao
                        </td>
                        <td>
                          Sinaai-Waas
                        </td>
                        <td class="text-right">
                          $23,789
                        </td>
                      </tr>
                      <tr>
                        <td>
                          Sage Rodriguez
                        </td>
                        <td>
                          Netherlands
                        </td>
                        <td>
                          Baileux
                        </td>
                        <td class="text-right">
                          $56,142
                        </td>
                      </tr>
                      <tr>
                        <td>
                          Philip Chaney
                        </td>
                        <td>
                          Korea, South
                        </td>
                        <td>
                          Overland Park
                        </td>
                        <td class="text-right">
                          $38,735
                        </td>
                      </tr>
                      <tr>
                        <td>
                          Doris Greene
                        </td>
                        <td>
                          Malawi
                        </td>
                        <td>
                          Feldkirchen in Kärnten
                        </td>
                        <td class="text-right">
                          $63,542
                        </td>
                      </tr>
                      <tr>
                        <td>
                          Mason Porter
                        </td>
                        <td>
                          Chile
                        </td>
                        <td>
                          Gloucester
                        </td>
                        <td class="text-right">
                          $78,615
                        </td>
                      </tr>
                      <tr>
                        <td>
                          Jon Porter
                        </td>
                        <td>
                          Portugal
                        </td>
                        <td>
                          Gloucester
                        </td>
                        <td class="text-right">
                          $98,615
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
             -->
          </div>
          <div class="col-md-12">
            
          </div>
        </div>
      </div>