<?php

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);
if ($_SESSION["rol"] == 4){ 
    //Siniestros::getTodasNotificacionesSiniestros();
    $activo = Siniestros::mostrarTodasNotificacionesSiniestrosActivos();
}
//nav
    ?>
    <style>
        .navbar .navbar-nav .notification {
    position: absolute;
    background-color: #fb404b;
    text-align: center;
    border-radius: 10px;
    min-width: 15px;
    padding: 0 5px;
    height: 15px;
    font-size: 12px;
    color: #fff;
    font-weight: 700;
    line-height: 15px;
    top: 10px;
    left: 0px;
}
        </style>
     <nav class="navbar navbar-expand-lg navbar-absolute fixed-top navbar-transparent">
        <div class="container-fluid  pr-md-0">
            <div class="navbar-wrapper">
            <div class="navbar-toggle">
                <button type="button" class="navbar-toggler">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
                </button>
            </div>
            <a class="navbar-brand"> </a>
            </div>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navigation">
            <div>
                <div class="input-group no-border">
                    <input name="buscarAsegurado" id="buscarAsegurado"  type="text" class="form-control2" placeholder="Buscar Asegurado..." style="background-color: #fff !important;border: medium none;">
                    <div onclick="buscarAsegurado()" class="input-group-append" style="cursor:pointer">
                        <div class="input-group-text px-1">
                        <i class="nc-icon nc-zoom-split"></i>
                        </div>
                    </div>
                </div>
            </div>
            <span style="color:transparent"> .</span>
            <div>
                <div class="input-group no-border">
                    <input style="max-width: 100px;" name="buscarID" id="buscarID" pattern="[^'\x]+" type="text" class="form-control2" placeholder="Buscar ID..." style="background-color: #fff !important;border: medium none;">
                    <div onclick="buscarid()" class="input-group-append" style="cursor:pointer">
                        <div class="input-group-text px-1">
                        <i class="nc-icon nc-zoom-split"></i>
                        </div>
                    </div>
                </div>
            </div>
            <span style="color:transparent"> .</span>
            <div>
                <div class="input-group no-border">
                    <input style="max-width: 100px;" name="buscarNS" id="buscarNS" pattern="[^'\x]+" type="text" class="form-control2" placeholder="Buscar NS..." style="background-color: #fff !important;border: medium none;">
                    <div onclick="buscarNS()" class="input-group-append" style="cursor:pointer">
                        <div class="input-group-text px-1">
                        <i class="nc-icon nc-zoom-split"></i>
                        </div>
                    </div>
                </div>
            </div>
            <ul class="navbar-nav">
                <!-- notificaciones -->
                <?php if ($_SESSION["rol"] == 4){ ?>
                <li class="nav-item btn-rotate dropdown">
                <a class="nav-link" href="./?view=notificaciones/parametros" style="font-size:30px;">
                    <i class="nc-icon nc-bell-55"></i>
                    <?php if ($activo[0]["total"] > 0){
                        if ($activo[0]["total"] > 9){
                            $total = "9+";
                        }else{
                            $total = $activo[0]["total"];
                        }
                        echo '<span class="notification">' . $total . '</span>';
                    }
                    ?>
                    <span class="d-lg-none d-md-block">Notificaciones</span>
                </a>
                </li>

                <!--<li class="nav-item btn-rotate dropdown">
                <a class="nav-link dropdown-toggle" href="./?view=notificaciones/parametros" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="nc-icon nc-bell-55"></i>
                    <p>
                    <span class="d-lg-none d-md-block">Alertas</span>
                    </p>
                </a>
                <--<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="./?view=notificaciones/parametros">Visor</a>
                    
                </div>
                </li>-->
<?php } ?>
                <!-- usuario -->
                <li class="nav-item btn-rotate dropdown">
                <a class="nav-link dropdown-toggle p-0 d-flex align-items-center" href="#s" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <!-- <i class="nc-icon nc-single-02"></i> -->
                                    <div class="avatar " style="width: 42px;display: inline-block;margin-right: 12px;">
                                      <img src="<?php echo $foto = isset($_SESSION['avatar']) && $_SESSION['avatar'] ? $_SESSION['avatar'] : './avatares/userDefault/1680310002.png';?>" alt="Circle Image" class="img-circle img-no-padding img-responsive">
                                  </div>
                                 
                                  <p class="text-capitalize">
                                      <small> <span class="d-md-block text-right text-primary"><?=UserData::getPerfil()[1];?></span> </small>
                                      <?=UserData::getPerfil()[0];?> <br>
                                      <small> <span class="d-md-block text-right text-primary"><?=$_SESSION['nombre'].' '.$_SESSION['paterno']?></span> </small>
                                </p>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="./?action=salir">Salir</a>
                    <a class="dropdown-item" href="./?view=config/config">Configuración</a>
                </div>
                </li>
            </ul>
            </div>
        </div>
    </nav>
