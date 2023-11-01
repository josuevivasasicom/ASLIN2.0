<?php
$TotalSiniestros= Siniestros::countTodosSiniestros();
$TotalSiniestrosProcesoCancelacion = Siniestros::countTodosSiniestrosProcesoCancelacion();
$TotalSiniestrosVigentes = Siniestros::countTodosSiniestrosVigentes();
$TotalSiniestrosCancelados = Siniestros::countTodosSiniestrosCancelados();
?>
<div class="content">

    <!--  <div class="row">
          <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats bg-success">
              <div class="card-body">
                <div class="row">
                  <div class="col-5 col-md-4">
                    <div class="icon-big text-center icon-warning">
                      <i class=""><img src="./assets/img/icons/4.png" alt="" srcset=""></i>
                    </div>
                  </div>
                  <div class="col-7 col-md-8">
                    <div class="numbers">
                      <p class="card-category">Todos</p>
                      <p class="card-title"><?=$TotalSiniestros?><p>
                    </div>
                  </div>
                </div>
              </div>
             
            </div>
          </div>
          
        </div> -->




    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-body">
                    <div class="row">
                        <div class="col-5 col-md-4">
                            <div class="icon-big text-center icon-warning">
                                <i class=""><img src="./assets/img/icons/4.png" alt="" srcset=""></i>
                            </div>
                        </div>
                        <div class="col-7 col-md-8">
                            <div class="numbers">
                                <p class="card-category">Todos los ID</p>
                                <p class="card-title"><?=$TotalSiniestros?>
                                <p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-body">
                    <div class="row">
                        <div class="col-5 col-md-4">
                            <div class="icon-big text-center icon-warning">
                                <i class=""><img src="./assets/img/icons/3.png" alt="" srcset=""></i>

                            </div>
                        </div>
                        <div class="col-7 col-md-8">
                            <div class="numbers">
                                <p class="card-category">ID Vigentes</p>
                                <p class="card-title"> <?=$TotalSiniestrosVigentes;?>
                                <p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-body">
                    <div class="row">
                        <div class="col-5 col-md-4 mr-0">
                            <div class="icon-big text-center icon-warning">
                                <i class=""><img src="./assets/img/icons/2.png" alt="" srcset=""></i>

                            </div>
                        </div>
                        <div class="col-7 col-md-8 pl-0">
                            <div class="numbers">
                                <p class="card-category">ID Proceso de Cancelación</p>
                                <p class="card-title"><?=$TotalSiniestrosProcesoCancelacion?>
                                <p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-body">
                    <div class="row">
                        <div class="col-5 col-md-4">
                            <div class="icon-big text-center icon-warning">
                                <i class=""><img src="./assets/img/icons/1.png" alt="" srcset=""></i>
                            </div>
                        </div>
                        <div class="col-7 col-md-8">
                            <div class="numbers">
                                <p class="card-category">ID Cancelados</p>
                                <p class="card-title"><?=$TotalSiniestrosCancelados?>
                                <p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="card-footer"><hr><div class="stats"><i class="fa fa-refresh"></i>actualizar </div></div> -->
            </div>
        </div>
    </div>
    <div class="row">
        <!-- GRAFICA SINIESTROS -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <!-- <h5 class="card-title">Tabla de siniestros</h5> -->
                    <p class="card-category">Tabla de siniestros</p>
                </div>
                <div class="card-body">
                    <canvas id=chartHours width="400" height="100"></canvas>
                </div>
                <hr>
                <!--
              <div class="card-footer">
                   <div class="stats">
                  <i class="fa fa-refresh"></i>
                  actualizar
                </div>
              </div>
              -->
            </div>
        </div>

        <!-- GRAFICA DE USUARIOS -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <!-- <h5 class="card-title">ID</h5> -->
                    <p class="card-category">Usuarios</p>
                </div>
                <div class="card-body">
                    <canvas id="chartUsers"></canvas>
                </div>
                <hr>
                <!-- 
              <div class="card-footer">
                  <div class="legend">
                  <i class="fa fa-circle text-primary"></i> Asesoría
                  <i class="fa fa-circle text-warning"></i> Procedente
                  <i class="fa fa-circle text-danger"></i> Improcedente
                </div> 
              </div>
              -->
            </div>
        </div>

        <!-- GRAFICA DE calificaciones -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <!-- <h5 class="card-title">ID</h5> -->
                    <p class="card-category">Calificaciones</p>
                </div>
                <div class="card-body">
                    <canvas id="chartCalificaciones"></canvas>
                </div>
            </div>
        </div>

        <!-- GRAFICA DE status -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <!-- <h5 class="card-title">ID</h5> -->
                    <p class="card-category">Status</p>
                </div>
                <div class="card-body">
                    <canvas id="chartStatus"></canvas>
                </div>
                <!--<div class="card-footer">
                <div class="legend">
                  <i class="fa fa-circle text-primary"></i> Asesoría
                  <i class="fa fa-circle text-warning"></i> Procedente
                  <i class="fa fa-circle text-danger"></i> Improcedente
                  <i class="fa fa-circle text-gray"></i> Preventivo
                  <i class="fa fa-circle text-gray"></i> Reapertura
                  <i class="fa fa-circle text-gray"></i> Por determinar
                </div>
                <hr>
                <div class="stats">
                  <i class="fa fa-calendar"></i> ID activos
                </div>
              </div> -->
            </div>
        </div>

    </div>

</div>

<script type="text/javascript" defer>
window.onload = function() {
    // Javascript method's body can be found in assets/assets-for-demo/js/demo.js
    prep_chartsPage();
}
//graficas de index!
dataset = [];

function prep_chartsPage() {
    console.log("inicializando ajax siniestros");
    $.ajax({
        url: "./?action=charts/index_todosSiniestros",
        method: "POST",
        data: {},
        cache: false,
        success: function(respuesta) {
            x = respuesta;
            dataset = JSON.parse(respuesta);
            initChartsPages(dataset);
            console.log("inicializando initChartsPages siniestros");
        }
    });

    console.log("inicializando ajax usuarios");
    $.ajax({
        url: "./?action=charts/index_todosUsuarios",
        method: "POST",
        data: {},
        cache: false,
        success: function(respuesta) {
            x = respuesta;
            dataset = JSON.parse(respuesta);
            initChartsCircleUsers(dataset);
            console.log("inicializando initChartsPages usuarios");
        }
    });

    console.log("inicializando ajax calificaciones");
    $.ajax({
        url: "./?action=charts/index_calificaciones",
        method: "POST",
        data: {},
        cache: false,
        success: function(respuesta) {
            x = respuesta;
            dataset = JSON.parse(respuesta);
            initChartsCircleCalificaciones(dataset);
            console.log("inicializando initChartsPages calificaciones");
        }
    });

    console.log("inicializando ajax Status");
    $.ajax({
        url: "./?action=charts/index_status",
        method: "POST",
        data: {},
        cache: false,
        success: function(respuesta) {
            x = respuesta;

            dataset = JSON.parse(respuesta);
            initChartsCircleStatus(dataset);
            console.log("inicializando initChartsPages Status");
        }
    });




}

//funcion grafica de siniestros
function initChartsPages(dataset) {

    //?? ******************** contruccion de labels de meses para la grafica 1
    const monthNames = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre",
        "Octubre", "Noviembre", "Diciembre"
    ];
    getLongMonthName = function(date) {
        return monthNames[date.getMonth()];
    }
    let label = [];
    let cont = new Date().getMonth() + 1;
    for (let index = 0; index < 9; index++) {
        let mes = getLongMonthName(new Date('-' + cont + ''));
        label.push(mes);
        if (cont == 1) { //comprueba si es menor a 1
            cont = 12; // de enero a diciembre
        } else {
            cont = (cont - 1); //el mes anterior
        }
    }
    label = label.reverse();
    //?? FIN ******************** contruccion de labels de meses para la grafica 1


    chartColor = "#FFFFFF";
    ctx = document.getElementById('chartHours').getContext("2d");
    myChart = new Chart(ctx, {
        type: 'line',
        data: {
            // labels: ["junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre", "enero", "febrero", "marzo"],
            labels: label,
            datasets: dataset
        },
        options: {
            legend: {
                display: true
            },

            tooltips: {
                enabled: true
            },

            scales: {
                yAxes: [{

                    ticks: {
                        fontColor: "#9f9f9f",
                        beginAtZero: false,
                        maxTicksLimit: 5,
                        //padding: 20
                    },
                    gridLines: {
                        drawBorder: true,
                        zeroLineColor: "#ccc",
                        color: 'rgba(255,255,255,0.05)'
                    }

                }],

                xAxes: [{
                    barPercentage: 1.6,
                    gridLines: {
                        drawBorder: false,
                        color: 'rgba(255,255,255,0.1)',
                        zeroLineColor: "transparent",
                        display: false,
                    },
                    ticks: {
                        padding: 20,
                        fontColor: "#9f9f9f"
                    }
                }]
            },
        }
    });
}

function arrayColores(longitud) {

    var colores = ['#25497D', '#D9884F', '#D05C5B', '#C82E67', '#742C65', '#362A64', '#e7a5ff', '#5988ff', '#ff6959',
        '#ff91cd', '#91ecff', '#ef8157', '#d0adff', '#b9ec66', '#e7a5ff', '#5988ff'
    ];

    let colorsFilterlongitud = colores.filter((element, index) => index > parseInt(longitud));

    return colores;

}

//funcion grafica de usuarios
function initChartsCircleUsers(dataset) {

    let longitudMas = dataset[0].length - 1;
    let datasetArray = dataset[0];
    let Dlabels = datasetArray.filter((element, index) => index > 0);
    let dataTamano = dataset[1];
    let Ddatas = dataTamano.filter((element, index) => index > 0);

    ctx = document.getElementById('chartUsers').getContext("2d");

    myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            // labels: [1, 2, 3],
            labels: Dlabels,
            datasets: [{
                label: "users",
                pointRadius: 2,
                pointHoverRadius: 0,
                backgroundColor: arrayColores(longitudMas),
                
                // data: [342, 480, 530, 120]
                data: Ddatas
            }]
        },

        options: {

            legend: {
                display: true
            },
            pieceLabel: {
                render: 'percentage',
                fontColor: ['white'],
                precision: 2
            },
            tooltips: {
                enabled: true
            },
            scales: {
                yAxes: [{
                    ticks: {
                        display: false
                    },
                    gridLines: {
                        drawBorder: true,
                        zeroLineColor: "transparent",
                        color: 'rgba(255,255,255,0.05)'
                    }

                }],
                xAxes: [{
                    barPercentage: 1.6,
                    gridLines: {
                        drawBorder: false,
                        color: 'rgba(255,255,255,0.1)',
                        zeroLineColor: "transparent"
                    },
                    ticks: {
                        display: false,
                    }
                }]
            },
        }
    });

}

// function grafica de calificaciones
function initChartsCircleCalificaciones(dataset) {
    let datasetArray = dataset[0];
    //Para restar un elemento del array ya que desde el servicio json viene con elemnto vacio
    let longitudMas = dataset[0].length - 1;
    let Dlabels = datasetArray.filter((element, index) => index > 0);
    let dataTamano = dataset[1];
    let Ddatas = dataTamano.filter((element, index) => index > 0);

    ctx = document.getElementById('chartCalificaciones').getContext("2d");

    myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: Dlabels,
            datasets: [{
                label: "calificaciones",
                pointRadius: 0,
                pointHoverRadius: 0,
                backgroundColor: arrayColores(longitudMas),
                borderWidth: 0,
                data: Ddatas
            }]
        },
        options: {
            legend: {
                display: true
            },
            pieceLabel: {
                render: 'percentage',
                fontColor: ['white'],
                precision: 2
            },
            tooltips: {
                enabled: true
            },
            scales: {
                yAxes: [{
                    ticks: {
                        display: false
                    },
                    gridLines: {
                        drawBorder: false,
                        zeroLineColor: "transparent",
                        color: 'rgba(255,255,255,0.05)'
                    }
                }],
                xAxes: [{
                    barPercentage: 1.6,
                    gridLines: {
                        drawBorder: false,
                        color: 'rgba(255,255,255,0.1)',
                        zeroLineColor: "transparent"
                    },
                    ticks: {
                        display: false,
                    }
                }]
            },
        }
    });
}

//funcion grafica de estatus
function initChartsCircleStatus(dataset) {
    let longitudMas = dataset[0].length - 1;
    let datasetArray = dataset[0];
    let Dlabels = datasetArray.filter((element, index) => index >= 0);

    let dataTamano = dataset[1];
    let Ddatas = dataTamano.filter((element, index) => index >= 0);
    ctx = document.getElementById('chartStatus').getContext("2d");

    myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: Dlabels,
            datasets: [{
                label: "Status",
                pointRadius: 0,
                pointHoverRadius: 0,
                backgroundColor: arrayColores(longitudMas),
                borderWidth: 0,
                data: Ddatas
            }]
        },
        options: {
            legend: {
                display: true
            },
            pieceLabel: {
                render: 'percentage',
                fontColor: ['white'],
                precision: 2
            },
            tooltips: {
                enabled: true
            },
            scales: {
                yAxes: [{
                    ticks: {
                        display: false
                    },
                    gridLines: {
                        drawBorder: false,
                        zeroLineColor: "transparent",
                        color: 'rgba(255,255,255,0.05)'
                    }
                }],
                xAxes: [{
                    barPercentage: 1.6,
                    gridLines: {
                        drawBorder: false,
                        color: 'rgba(255,255,255,0.9)',
                        zeroLineColor: "transparent"
                    },
                    ticks: {
                        display: false,
                    }
                }]
            },
        }
    });
}
</script>