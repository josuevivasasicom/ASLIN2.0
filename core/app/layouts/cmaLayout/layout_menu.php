<?php 
//menu lateral
?>
<div class="sidebar" data-color="black" data-active-color="danger">
    <div class="logo">
    <!-- <a href="#" class="simple-text logo-mini">
        <div class="logo-image-small">
        <img src="./assets/img/logo-small.png">
        </div> 
        <p>CMA</p>
    </a> -->
    <a href="#" class="simple-text logo-normal">
        
        <div class="logo-image-big">
        <img src="./assets/img/logo_large_white.png">
        </div>
    </a>
    </div>

    
    <!-- menu -->
    <div class="sidebar-wrapper">
        <?php
        switch ($_SESSION['rol']) {
            case '1'://superaministrador
                ?>
                <ul class="nav">
                    <li index class="">
                    <a href="./?view=index">
                        <i class="nc-icon nc-bank"></i>
                        <p>Inicio</p>
                    </a>
                    </li>
                    <li nuevo class="">
                    <a href="./?view=siniestro/nuevo">
                        <i class="nc-icon nc-diamond"></i>
                        <p>Nuevo Siniestro</p>
                    </a>
                    </li>
                    <li siniestros class="">
                    <a href=".?view=siniestro/verTodos">
                        <i class="nc-icon nc-bullet-list-67"></i>
                        <p>Siniestros</p>
                    </a>
                    </li>

                    <li areas class="">
                    <a href="./?view=config/areas">
                        <i class="nc-icon  nc-tile-56"></i>
                        <p>Áreas</p>
                    </a>
                    </li>
                
                    <li usuarios>
                    <a href="./?view=config/usuarios">
                        <i class="nc-icon nc-badge"></i>
                        <p>Usuarios</p>
                    </a>
                    </li>

                    <li historico>
                    <a href="./?view=config/historico">
                        <i class="nc-icon nc-paper"></i>
                        <p>Histórico</p>
                    </a>
                    </li>
                    
                    <li parametros>
                    <a href="./?view=config/parametros">
                        <i class="nc-icon nc-settings-gear-65"></i>
                        <p>Parámetros</p>
                    </a>
                    </li>

                    <li direcciones>
                    <a href="./?view=config/libretaDirecciones">
                        <i class="nc-icon nc-settings-gear-65"></i>
                        <p>libreta direcciones</p>
                    </a>
                    </li>
                    <li importSiniestros>
                    <a href="javascript:uploadCSV()">
                        <i class="nc-icon nc-settings-gear-65"></i>
                        <p>Import Siniestros</p>
                    </a>
                    </li>
                    <li importBitacoras>
                    <a href="javascript:uploadCSVBitacoras()">
                        <i class="nc-icon nc-settings-gear-65"></i>
                        <p>Import Bitácotas</p>
                    </a>
                    </li>
                </ul>
                <script>
                    //?funciones de botones de la tabla para cargar siniestros en el sistema desde un CSV
                        function uploadCSV(){
                            /* .then((result) => {
                                // Read more about isConfirmed, isDenied below 
                                if (result.isConfirmed)
                                else if (result.isDenied) 
                            */
                            Swal.fire({
                            confirmButtonColor: '#988763',
                            denyButtonColor: '#988763',
                            cancelButtonColor: '#988763',
                            title: 'Selecciona archivo a importar',
                            input: 'file',
                            inputAttributes: {
                                'accept': 'text/csv',
                                'aria-label': 'Selecciona un archivo CSV de siniestros',
                                'name':'csvImport',
                                'id':'csvImport'
                            }
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    file= document.querySelector("input[type=file][name=csvImport]").files[0];
                                    if (file) {
                                        //para subir imagenes y mostrar la que se acaba de subir
                                        //var reader=new FileReader(); reader.onload=(e)=>{ console.log(e); Swal.fire({ title: 'tu archivo subido', imageUrl: e.target.result, imageAlt: 'se subio el csv', text:e.target})} reader.readAsDataURL(file)
                                        console.log("subiendo archivo por ajax");
                                        let dataForm= new FormData();
                                        dataForm.append('fileCsv',file);


                                        $.ajax({
                                            url: "./?action=siniestro/importSiniestros",
                                            method: "POST",
                                            data:dataForm,
                                            processData:false,
                                            contentType:false,
                                            success: function(respuesta) {
                                                // dataset = JSON.parse(respuesta);
                                                console.log(respuesta);
                                            
                                                console.log("inicializando file upload");
                                            },
                                            error:{ function(e) {
                                                conjsole.log(e);
                                            }

                                            }
                                        }); 
                                    }
                                }
                            });
                        }

                        function uploadCSVBitacoras(){
                            /* .then((result) => {
                                // Read more about isConfirmed, isDenied below 
                                if (result.isConfirmed)
                                else if (result.isDenied) 
                            */
                            Swal.fire({
                            confirmButtonColor: '#988763',
                            denyButtonColor: '#988763',
                            cancelButtonColor: '#988763',
                            title: 'Selecciona CSV de bitácoras a importar',
                            input: 'file',
                            inputAttributes: {
                                'accept': 'text/csv',
                                'aria-label': 'Selecciona un archivo CSV de siniestros',
                                'name':'csvImport',
                                'id':'csvImport'
                            }
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    Swal.showLoading();
                                    file= document.querySelector("input[type=file][name=csvImport]").files[0];
                                    if (file) {
                                        //para subir imagenes y mostrar la que se acaba de subir
                                        //var reader=new FileReader(); reader.onload=(e)=>{ console.log(e); Swal.fire({ title: 'tu archivo subido', imageUrl: e.target.result, imageAlt: 'se subio el csv', text:e.target})} reader.readAsDataURL(file)
                                        console.log("subiendo archivo por ajax");
                                        let dataForm= new FormData();
                                        dataForm.append('fileCsv',file);


                                        $.ajax({
                                            url: "./?action=siniestro/importBitacoras",
                                            method: "POST",
                                            data:dataForm,
                                            processData:false,
                                            contentType:false,
                                            success: function(respuesta) {
                                                // dataset = JSON.parse(respuesta);
                                                console.log(respuesta);
                                            
                                                console.log("inicializando file upload");
                                            },
                                            error:{ function(e) {
                                                conjsole.log(e);
                                            }

                                            }
                                        }); 
                                    }
                                }
                            });
                        }
                </script>
                <?php
            break;
            case '2': //jefe de area
                    ?>
                    <ul class="nav">
                        <li index class="">
                        <a href="./?view=index">
                            <i class="nc-icon nc-bank"></i>
                            <p>Inicio</p>
                        </a>
                        </li>
                      
                        <li siniestros>
                        <a href=".?view=siniestro/verTodos">
                            <i class="nc-icon nc-bullet-list-67"></i>
                            <p>Siniestros</p>
                        </a>
                        </li>

                        <li usuarios>
                        <a href="./?view=config/usuarios">
                            <i class="nc-icon nc-badge"></i>
                            <p>Usuarios</p>
                        </a>
                        </li>

                        <li historico>
                        <a href="./?view=config/historico">
                            <i class="nc-icon nc-paper"></i>
                            <p>Histórico</p>
                        </a>
                        </li>
                        <li direcciones>
                        <a href="./?view=config/libretaDirecciones">
                            <i class="nc-icon nc-settings-gear-65"></i>
                            <p>libreta direcciones</p>
                        </a>
                        </li>
                    </ul>
                    <?php
                
            break;
            case '3': //abogado
                 // cualquier otra area
                 ?>
                 <ul class="nav">
                     <li index class="">
                     <a href="./?view=index">
                         <i class="nc-icon nc-bank"></i>
                         <p>Inicio</p>
                     </a>
                     </li>
                     <li siniestros>
                     <a href=".?view=siniestro/verTodos">
                         <i class="nc-icon nc-bullet-list-67"></i>
                         <p>Siniestros</p>
                     </a>
                     </li>
                     <li direcciones>
                        <a href="./?view=config/libretaDirecciones">
                            <i class="nc-icon nc-settings-gear-65"></i>
                            <p>libreta direcciones</p>
                        </a>
                     </li>
                     
                 </ul>
                 <?php
            break; 
            case '4'://administrador de siniestros
                // cualquier otra area
                    ?>
                        <ul class="nav">
                            <li index class="">
                            <a href="./?view=index">
                                <i class="nc-icon nc-bank"></i>
                                <p>Inicio</p>
                            </a>
                            </li>
                            <li nuevo class="">
                            <a href="./?view=siniestro/nuevo">
                                <i class="nc-icon nc-diamond"></i>
                                <p>Nuevo Siniestro</p>
                            </a>
                            </li>
                            <li siniestros class="">
                            <a href=".?view=siniestro/verTodos">
                                <i class="nc-icon nc-bullet-list-67"></i>
                                <p>Siniestros</p>
                            </a>
                            </li>
                
                            <li historico class="">
                            <a href="./?view=config/historico">
                                <i class="nc-icon nc-paper"></i>
                                <p>Histórico</p>
                            </a>
                            </li>

                            <li parametros>
                            <a href="./?view=config/parametros">
                                <i class="nc-icon nc-settings-gear-65"></i>
                                <p>Parámetros</p>
                            </a>
                            </li>
                            
                            <li direcciones>
                            <a href="./?view=config/libretaDirecciones">
                                <i class="nc-icon nc-settings-gear-65"></i>
                                <p>libreta direcciones</p>
                            </a>
                            </li>
                            
                        </ul>
                <?php
                break;
            
            default://todos los de mas
                ?>
                <ul class="nav">
                    <li siniestros>
                    <a href=".?view=siniestro/verTodos">
                        <i class="nc-icon nc-bullet-list-67"></i>
                        <p>Siniestros</p>
                    </a>
                    </li>
                </ul>
                <?php
            break;
                # code...
                break;
        }
        ?>
    </div>
</div>