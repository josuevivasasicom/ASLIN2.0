<?php
//nav
    ?>
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
                    <input name="buscarAsegurado" id="buscarAsegurado"  type="text" class="form-control" placeholder="Buscar Asegurado..." style="background-color: rgba(222, 222, 222, 0.3) !important;border: medium none;">
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
                    <input style="max-width: 100px;" name="buscarID" id="buscarID" pattern="[^'\x]+" type="text" class="form-control" placeholder="Buscar ID..." style="background-color: rgba(222, 222, 222, 0.3) !important;border: medium none;">
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
                    <input style="max-width: 100px;" name="buscarNS" id="buscarNS" pattern="[^'\x]+" type="text" class="form-control" placeholder="Buscar NS..." style="background-color: rgba(222, 222, 222, 0.3) !important;border: medium none;">
                    <div onclick="buscarNS()" class="input-group-append" style="cursor:pointer">
                        <div class="input-group-text px-1">
                        <i class="nc-icon nc-zoom-split"></i>
                        </div>
                    </div>
                </div>
            </div>
            <ul class="navbar-nav">
                <!-- notificaciones -->
                <li class="nav-item btn-rotate dropdown">
                <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="nc-icon nc-bell-55"></i>
                    <p>
                    <span class="d-lg-none d-md-block">Alertas</span>
                    </p>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="#">Nuevo Siniestro #234</a>
                    <a class="dropdown-item" href="#">Primera atención #238</a>
                    <a class="dropdown-item" href="#">Se cambió a Penal #225</a>
                </div>
                </li>

                <!-- usuario -->
                <li class="nav-item btn-rotate dropdown">
                <a class="nav-link dropdown-toggle p-0 d-flex align-items-center" href="#s" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <!-- <i class="nc-icon nc-single-02"></i> -->
                                    <div class="avatar " style="width: 42px;display: inline-block;margin-right: 12px;">
                                      <img src="<?=$_SESSION['avatar'];?>" alt="Circle Image" class="img-circle img-no-padding img-responsive">
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
