<?php
$us = UserData::getDataUser();
$folios = Folios::getLastIds($_SESSION['id']);
// core::preprint($folios[0]);

$statusList = Folios::obtenerConfigCampo('status');
$calificacionesList = Folios::obtenerConfigCampo('calificacion');
$cssStyle='';
foreach ($calificacionesList as $key) {
    $cssStyle.= ' .'.strtolower(explode(' ',$key->valor)[0]).'{ background:'.$key->extra.';border-radius: 6px;padding: 3px 8px;} ' ;
}
foreach ($statusList as $key) {
    $cssStyle.= ' .'.strtolower(explode(' ',$key->valor)[0]).'{ background:'.$key->extra.';border-radius: 6px;padding: 3px 8px;} ' ;
}
echo "<!-- VAMOS admin  -->";
print('<style>.notouch{pointer-events:none}'.$cssStyle.'</style>');

?>

<div class="content">
    <div class="row">
        <div class="col-md-4">
            <div class="card card-user">
                <div class="image">
                    <img src="<?=$_SESSION['avatar'];?>" alt="...">
                </div>
                <div class="card-body">
                    <div class="author">
                        <a onclick="filedemo()" href="#">
                            <img class="avatar border-gray" src="<?=$_SESSION['avatar'];?>" alt="...">
                            <h5 class="title"><?=$_SESSION['nombre'].' '.$_SESSION['paterno']?></h5>
                            <h5 class=""><?=$_SESSION['grupo'][0]?></h5>
                        </a>
                        <p class="description">
                            <?=$_SESSION['email']?>
                        </p>
                    </div>
                    <p class="description text-center">
                    <?=$_SESSION['descripcion'][0]?>
                    </p>
                </div>
                <div class="card-footer">
                    <hr>
                    <div class="button-container">
                        <div class="row">
                            <div class="col-lg col-md col-6 ml-auto">
                                <h5>12<br><small>Recién Asignados</small></h5>
                            </div>
                            <div class="col-lg col-md col-6 ml-auto mr-auto">
                                <h5>2<br><small>PA</small></h5>
                            </div>
                            <div class="col-lg mr-auto">
                                <h5>246<br><small>Cancelados</small></h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Últimos IDs asignados</h4>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled team-members">
                        <?php foreach ($folios as $k) {
                            ?>
                            <li>
                                <div class="row">
                                    <div class="col-md-7 col-7">
                                       <?=$k['folio']?>  <span class="text-muted <?=$k['prov']?>"><small><?=$k['prov']?></small></span>
                                        <br>
                                        <span class="text-muted <?=strtolower($k['status'])?>"><small><?=$k['status']?></small></span><br>
                                        <span class=" ">Asignación:<small><?=$k['fechaAsignacion']?></small></span>
                                        
                                    </div>
                                    <div class="col-md-3 col-3 text-right">
                                        <a target="_blank" href=".?view=siniestro/ver&param=<?=$k['timerst']?>">
                                            <btn class="btn btn-sm btn-outline-info btn-round btn-icon" alt="ir a siniestro"><i class="fa fa-link"></i></btn>
                                        </a>
                                    </div>
                                </div>
                                <hr>
                            </li>
                        <?php
                        }
                        ?>
                       
                    </ul>
                </div>
            </div>
        </div>


        <!-- EDIT PERFIL -->
        <div class="col-md-8">
            <div class="card card-user">
                <div class="card-header">
                    <h5 class="card-title">Editar Perfil</h5>
                </div>
                <div class="card-body">
                    <form id="dataUser">
                        <div class="row">
                            <div class="col-md pr-1">
                                <div class="form-group">
                                    <label>Área asignada</label>
                                    <input type="text" class="form-control" disabled="" placeholder="area" value="<?=explode('/',$_SESSION['grupo'][0])[0]?>">
                                </div>
                            </div>
                            <div class="col-md-4 px-1">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="text" class="form-control" placeholder="email" name="email" value="<?=$_SESSION['email']?>">
                                </div>
                            </div>
                            <div class="col-md-4 pl-1">
                                <div class="form-group">
                                    <label for="passwordNew">Password</label>
                                    <input disabled type="password" class="form-control" value="" placeholder="passwordNew">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md pr-1">
                                <div class="form-group">
                                    <label>Nombre</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="nombreLic">Lic. </span>
                                        </div>
                                        <input type="text" class="form-control" name="nombre" placeholder="Nombre" aria-describedby="nombreLic" value="<?=explode('. ',$_SESSION['nombre'])[1]?>">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md px-1">
                                <div class="form-group">
                                    <label>A. Paterno</label>
                                    <input type="text" class="form-control" name="paterno" placeholder="Apellido Paterno" value="<?=$_SESSION['paterno']?>">
                                </div>
                            </div>
                            <div class="col-md pl-1">
                                <div class="form-group">
                                    <label>A. Materno</label>
                                    <input type="text" class="form-control" name="materno" placeholder="Apellido Materno" value="<?=$_SESSION['materno']?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md">
                                <div class="form-group">
                                    <label>Cumpleaños</label>
                                    <input type="date" class="form-control" name="nacimiento" placeholder="Fecha de Cumpleaños" value="<?=$us['fechaNacimiento']?>">
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-group">
                                    <label>Nacionalidad</label>
                                    <input type="text" class="form-control" name="nacionalidad" placeholder="Nacionalidad" value="Mexicana">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 pr-1">
                                <div class="form-group">
                                    <label>Celular</label>
                                    <input type="number" class="form-control" name="celular" placeholder="Número Celular" value="<?=$us['celular']?>">
                                </div>
                            </div>
                            <div class="col-md-4 px-1">
                                <div class="form-group">
                                    <label>Teléfono</label>
                                    <input type="number" class="form-control" name="telefono" placeholder="Número Teléfono" value="<?=$us['telefono']?>">
                                </div>
                            </div>
                            <div class="col-md pl-1">
                                <div class="form-group">
                                    <label>Código Postal</label>
                                    <input type="number" class="form-control" name="cp" placeholder="CP" value="<?=$us['cp']?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md pr-1">
                                <div class="form-group">
                                    <label>Dirección</label>
                                    <input type="text" class="form-control" name="direccion" placeholder="Dirección" value="<?=$us['direccion']?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md pr-1">
                                <div class="form-group">
                                    <label>Cédula</label>
                                    <input type="text" class="form-control" name="cedula" placeholder="Cédula" value="<?=$us['cedula']?>">
                                </div>
                            </div>
                        </div>

                        <!-- <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Sobre mí</label>
                                    <textarea name="aboutme" class="form-control textarea"> <?=$us['celular']?> </textarea>
                                </div>
                            </div>
                        </div> -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Firma Email (imagen de 569x155 px)</label> <br>
                                    <?php 
                                    if(isset($us['firma']) && $us['firma']!=''){
                                        echo "<img onclick='fileFirmaUpload()'  style='cursor:pointer;' src='".$us['firma']."' alt='' width='569px' height='auto'>";
                                    }else{
                                        echo "<span  onclick='fileFirmaUpload()' style='cursor:pointer;' >no hay firma</span>";
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="update ml-auto mr-auto">
                                <input type="hidden" name="tokeni" value="<?=$_SESSION['id'].$_SESSION['id'].$_SESSION['id']?>">
                                <button type="button" id="sendDataUser" class="btn btn-primary btn-round">Actualizar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<style>
    .input-group .input-group-prepend,
    .input-group input,
    .input-group{
        height: 2.8em !important;
    }
</style>

<!-- <script defer src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script> -->
<script defer>
    // function hola(){alert('hola')}
    async function fileFirmaUpload() {
        const { value: file } = await Swal.fire({
        title: 'Selecciona una imagen de firma',
        input: 'file',
        inputAttributes: {
            'accept': 'image/*',
            'aria-label': 'Carga una imagen de firma 150x565px'
        }
        })

        if (file) {
            

            console.log('cargando file de firma y listo para ser enviado al ajax');
            let dataFiles= new FormData();
            dataFiles.append('fileFirma',file);

            //CARGANDO SOBRE AJAX
                $.ajax({
                    url: "./?action=config/firma",
                    method: "POST",
                    data:dataFiles,
                    processData:false,
                    contentType:false,
                    success: function(respuesta) {
                        // dataset = JSON.parse(respuesta);
                        console.log(respuesta);
                        if(respuesta=='Exito firma'){
                            const reader = new FileReader();
                            reader.onload = (e) => {
                                Swal.fire({
                                title: 'Tu firma se ha cargado',
                                imageUrl: e.target.result,
                                imageAlt: 'Imagen Subida'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        // respuesta= JSON.parse(respuesta);
                                        // console.log(respuesta);
                                        window.location.reload();
                                    }
                                })
                            }

                            reader.readAsDataURL(file);
                        }
                        
                    },
                    error:{ function(e) {
                        console.log("algo salió mal");
                        conjsole.log(e);
                    }

                    }
                }); 

        }
    }

    async function filedemo() {
        const { value: file } = await Swal.fire({
        title: 'Selecciona una imagen para Avatar',
        input: 'file',
        inputAttributes: {
            'accept': 'image/*',
            'aria-label': 'Carga una foto de perfil'
        }
        })

        if (file) {
            

            console.log('cargando file y listo para ser enviado al ajax');
            let dataFiles= new FormData();
            dataFiles.append('fileAvatar',file);

            //CARGANDO SOBRE AJAX
                $.ajax({
                    url: "./?action=config/avatar",
                    method: "POST",
                    data:dataFiles,
                    processData:false,
                    contentType:false,
                    success: function(respuesta) {
                        // dataset = JSON.parse(respuesta);
                        console.log(respuesta);
                        if(respuesta=='Exito Avatar'){
                            const reader = new FileReader();
                            reader.onload = (e) => {
                                Swal.fire({
                                title: 'Tu foto se ha cargado',
                                imageUrl: e.target.result,
                                imageAlt: 'Imagen Subida'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        // respuesta= JSON.parse(respuesta);
                                        // console.log(respuesta);
                                        window.location.reload();
                                    }
                                })
                            }

                            reader.readAsDataURL(file);
                        }
                        
                    },
                    error:{ function(e) {
                        console.log("algo salió mal");
                        conjsole.log(e);
                    }

                    }
                }); 

        }
    }

window.addEventListener('DOMContentLoaded',()=>{
    $("#sendDataUser").on("click",()=>{
        var formSerialize = $("form#dataUser").serialize();
        $.ajax({
            url:  "./?action=usuario/user",// se envia todo el formulario a la action
            method: "POST",
            type: "POST",
            data: {
                'data': formSerialize
            },
            success: function(resp) {
                console.log(resp)
                Swal.fire({
                    icon: 'success',
                    width: 700,
                    title: 'Cambios Guardados',
                    text: 'Los cambios se guardaron correctamente.',
                    /*  html: 'Folio Siniestro:<a href="./?view=siniestro/ver&param=' +
                        respuesta.siniestro + '" > <b>' + respuesta.folio +
                        '</b></b>; con clave del sistema <a href="./?view=siniestro/ver&param=' +
                        respuesta.siniestro + '" > <u>' + respuesta.siniestro +
                        '</u></a>. creado.  <br> ¿Quieres ir a todos los siniestros o crear nuevo siniestro?', */
                    // showDenyButton: true,
                    // showCancelButton: true,

                    confirmButtonText: 'OK',
                    // denyButtonText: `Ir a todos`,
                    // cancelButtonText: 'Crear Nuevo',

                    confirmButtonColor: 'var(--color-blanco)',
                    denyButtonColor: 'var(--color-blanco)',
                    cancelButtonColor: 'var(--color-blanco)',

                    allowOutsideClick: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.reload();

                    }
                });
                
            }
        });//fin ajax

    });
 
});


/* function changeAvatar(){
        Swal.fire({
        confirmButtonColor: 'var(--color-blanco)',
        denyButtonColor: 'var(--color-blanco)',
        cancelButtonColor: 'var(--color-blanco)',
        title: 'Elige una imagen para Avatar',
        input: 'image',
        inputAttributes: {
                'accept': 'img/*',
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
} */





function changeAvatarPPPPPPPPP(){
        
        Swal.fire({
        confirmButtonColor: 'var(--color-blanco)',
        denyButtonColor: 'var(--color-blanco)',
        cancelButtonColor: 'var(--color-blanco)',
        title: 'Remplazar imagen de perfil',
        input: 'file',
        inputAttributes: {
            'accept': 'img/*',
            'aria-label': 'Selecciona una imagen',
            'name':'imgAvatar',
            'id':'imgAvatar'
        }
        }).then((result) => {
            if (result.isConfirmed) {
                console.log(imgAvatar);
                file= document.querySelector("input[type=file][name=imgAvatar]").files[0];
                if (file) {
                    //para subir imagenes y mostrar la que se acaba de subir
                    //var reader=new FileReader(); reader.onload=(e)=>{ console.log(e); Swal.fire({ title: 'tu archivo subido', imageUrl: e.target.result, imageAlt: 'se subio el csv', text:e.target})} reader.readAsDataURL(file)
                    console.log("subiendo archivo por ajax");
                    let dataForm= new FormData();
                    dataForm.append('fileImg',file);


                    $.ajax({
                        url: "./?action=config/avatar",
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