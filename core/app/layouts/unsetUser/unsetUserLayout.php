<?php 
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);

if(isset($_REQUEST['recoveryMail']) and $_REQUEST['recoveryMail']!=''){
  include "recoveryMail.php";
  exit();
}
?>

<!-- Copyright Creative Tim  -->
<!-- Implements by ASICOM GRAPHICS -->
<!-- CMA 2022 -->
<!DOCTYPE html>
<html lang="ES">
<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="./assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="./assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>CMA.mx - Abogados</title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
  <!-- CSS Files -->
  <link href="./assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="./assets/css/paper-dashboard.css?v=2.0.1" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="./assets/demo/demo.css" rel="stylesheet" />
  <style>
    .has-error .form-control, .form-control.error {
      background-color: #FFC0A4;
      color: #EB5E28;
      border-color: #EB5E28;
    }
    .alert{ display:none;}
    .alert.alert-danger{
      position: sticky;
      transition: all ease-in-out .3s ;
      opacity: 0;
    }
    .visible{
      opacity: 1 !important;
    }
    .card img{
      pointer-events: none;
    }
    .disabled{
      pointer-events: none;
      cursor: not-allowed;
      opacity: 0.5;
    }
    .imgLog{
      position: absolute;
      z-index: 1;
      width: 200px;
      padding: 0%;
      margin: 0 auto;
      opacity: initial;
      left: calc(50% - 150px);
      right: calc(50% - 150px);
      display:none;
      pointer-events: none;
    }
  </style>
</head>


<body>
<div class="section section-image section-login" data-src="./assets/img/bg/1.jpg" style="background-size:cover; background-image: url('./assets/img/bg/1.1.jpg'); height:100vh">
      <div class="container p-1">
        <div class="row">
          <div class="col-lg-4 col-md-6 mx-auto">
            <!-- LOGIN -->
            <div class="card card-register p-3" style="margin-top:15vh">
             <img src="assets/img/logo_large_white.png" class="p-md-3" alt="">
              <!-- <h3 class="title mx-auto">CMA</h3> -->

           
              <div class="alert alert-danger">
                  <button onclick="closeA()" type="button" aria-hidden="true" class="close">×</button>
                  <span><b> Contraseña Incorrecta! - </b><br> intentalo nuevamente.</span>
              </div>

              <div class="alert alert-info">
                  <button onclick="closeA()" type="button" aria-hidden="true" class="close">×</button>
                  <span><b> Se restablecio la contraseña </b></span>
              </div>

              
              
              <form id="fomLogin" class="register-form error" action="./?action=login" method="POST" enctype="multipart/form-data" autocomplete="off">
                <!-- <img src="https://c.tenor.com/qBxzh-6k2bEAAAAC/loader.gif" class="imgLog" style="position:absolut"> -->
                <div class="imgLog" style="width: 200px; height: 200px;">
                  <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: auto; background: rgb(241 242 243 / 0%); display: block;" width="200px" height="200px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
                      <g transform="translate(20 50)">
                      <circle cx="0" cy="0" r="6" fill="#fc4309">
                        <animateTransform attributeName="transform" type="scale" begin="-0.375s" calcMode="spline" keySplines="0.3 0 0.7 1;0.3 0 0.7 1" values="0;1;0" keyTimes="0;0.5;1" dur="1s" repeatCount="indefinite"></animateTransform>
                      </circle>
                      </g><g transform="translate(40 50)">
                      <circle cx="0" cy="0" r="6" fill="#ff765c">
                        <animateTransform attributeName="transform" type="scale" begin="-0.25s" calcMode="spline" keySplines="0.3 0 0.7 1;0.3 0 0.7 1" values="0;1;0" keyTimes="0;0.5;1" dur="1s" repeatCount="indefinite"></animateTransform>
                      </circle>
                      </g><g transform="translate(60 50)">
                      <circle cx="0" cy="0" r="6" fill="#ffb646">
                        <animateTransform attributeName="transform" type="scale" begin="-0.125s" calcMode="spline" keySplines="0.3 0 0.7 1;0.3 0 0.7 1" values="0;1;0" keyTimes="0;0.5;1" dur="1s" repeatCount="indefinite"></animateTransform>
                      </circle>
                      </g><g transform="translate(80 50)">
                      <circle cx="0" cy="0" r="6" fill="#ff9900">
                        <animateTransform attributeName="transform" type="scale" begin="0s" calcMode="spline" keySplines="0.3 0 0.7 1;0.3 0 0.7 1" values="0;1;0" keyTimes="0;0.5;1" dur="1s" repeatCount="indefinite"></animateTransform>
                      </circle>
                      </g>
                  </svg>
                </div>
                <label>Email</label>
                <div class="input-group form-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text" style="padding-right: 7px;">
                      <i class="nc-icon nc-email-85"></i>
                    </span>
                  </div>
                  <input autocomplete="nope" name="email" type="email" class="form-control" placeholder="Email">
                </div>
                <label>Password</label>
                <div class="input-group form-group">
                  <div class="input-group-prepend">
                    <span id="spanAction" onclick="revealPAss()" class="input-group-text" style="cursor:pointer;padding-right: 7px;">
                      <i class="nc-icon nc-key-25"></i>
                    </span>
                  </div>
                  <input autocomplete="off" id="pass" name="pass" type="password" class="form-control" placeholder="Password">
                </div>
                <button onclick="cargando()" class="btn btn-warning btn-block btn-round">Entrar</button>
              </form>
              <?php 
              ini_set('display_errors', 0);
              ini_set('display_startup_errors', 0);
              error_reporting(0);
              if (isset($_REQUEST['error']) && $_REQUEST['error']!=''){
                ?>
                <script>
                  function closeA(){
                    document.querySelector(".alert.alert-danger").style.opacity=0;
                    document.querySelector(".alert.alert-danger").style.display='none';
                  }
                  document.querySelector("[name=email]").classList.add("error");
                  document.querySelector("[name=pass]").classList.add("error");
                  document.querySelector(".alert.alert-danger").style.opacity=1;
                  document.querySelector(".alert.alert-danger").style.display='block';
                  // document.querySelector(".alert.alert-danger").classList.add("visible");
                  
                </script>
                <?php
              }elseif(isset($_REQUEST['recoveryOK']) && $_REQUEST['recoveryOK']!=''){
                ?>
                  <script>
                    function closeA(){
                      document.querySelector(".alert.alert-info").style.opacity=0;
                      document.querySelector(".alert.alert-info").style.display='none';
                    }
                    document.querySelector(".alert.alert-info").style.opacity=1;
                    document.querySelector(".alert.alert-info").style.display='block';
                    // document.querySelector(".alert.alert-danger").classList.add("visible");
                  </script>
                <?php
              }
              ?>
              <div class="forgot d-none">
                <!-- <a href="#"  onclick="OnchangePass()" class="btn btn-link btn-warning">olvidaste tu password?</a> -->
              </div>
            </div>

            <!-- PASSWORD -->
            <div class="d-none card card-password p-3 d-none" style="margin-top:25vh">
             <img src="assets/img/logo_large_white.png" class="p-md-3" alt="">
              <div class="alert alert-danger">
                  <button onclick="closeA()" type="button" aria-hidden="true" class="close">×</button>
                  <span><b> El usuario no existe</b> <br> intentalo nuevamente.</span>
              </div>
              <form class="recovery-password" >
                <label>Email</label>
                <div class="input-group form-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="nc-icon nc-email-85"></i>
                    </span>
                  </div>
                  <input name="Remail" type="email" class="form-control" placeholder="Email">
                </div>
                
                <button onclick="sendCheckPassRecovery()" class="btn btn-warning btn-block btn-round">Enviar</button>
              </form>
              <?php 
              ini_set('display_errors', 0);
              ini_set('display_startup_errors', 0);
              error_reporting(0);
              if (isset($_REQUEST['error']) && $_REQUEST['error']!=''){
                ?>
                <script>
                  function closeA(){
                    document.querySelector(".alert.alert-danger").style.opacity=0;
                    document.querySelector(".alert.alert-danger").style.display='none';
                  }
                  document.querySelector("[name=email]").classList.add("error");
                  document.querySelector("[name=pass]").classList.add("error");
                  document.querySelector(".alert.alert-danger").style.opacity=1;
                  // document.querySelector(".alert.alert-danger").classList.add("visible");
                  
                </script>
                <?php
              }
              ?>
              <div class="forgot">
                <a href="#"  onclick="logIn()" class="btn btn-link btn-warning">LogIn?</a>
              </div>
            </div>
            <div class="col text-center">
              <a href="#" class="btn btn-outline-warning btn-round btn-lg" target="_blank">Ver Siniestro</a>
            </div>
          </div>
        </div>
      </div>
    </div>
</body>
<script src="./assets/js/core/jquery.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>

  function changePass(){
    exit();
    event.preventDefault();
    document.querySelector('.card-register').classList.add('d-none');
    document.querySelector('.card-password').classList.add('d-block');

    document.querySelector('.card-register').classList.remove('d-block');
    document.querySelector('.card-password').classList.remove('d-none');
  }

  function logIn(){
    document.querySelector('.card-register').classList.remove('d-none');
    document.querySelector('.card-password').classList.remove('d-block');

    document.querySelector('.card-register').classList.add('d-block');
    document.querySelector('.card-password').classList.add('d-none');
  }

  
  function sendCheckPassRecovery(){
    //funcion del boton para recuperar password
    let email = document.querySelector('[name=Remail]').value;
    axios.post('./?action=recoveryPass&mail='+email, {method:'solicitud',  email : email })
    .then(function (response) {
      DATOSAXIOS = response;
      if('Error!' != response.data )
       if(response.data.split('=')[0]=='recoveryMail')
       location.search= response.data;
       console.log("ERROR2");
       console.log(response);
    })
    .catch(function (error) {
      console.log('ERRORRRRRRTRR');
      console.log(error);
    });
  }


  function cargando(){
    document.querySelector("[name=email]").classList.remove("error");
    document.querySelector("[name=pass]").classList.remove("error");
    document.querySelector("[name=email]").classList.add("disabled");    
    document.querySelector("[name=pass]").classList.add("disabled");
    document.querySelector(".btn.btn-warning.btn-block.btn-round").classList.add("disabled");
   
    document.querySelector(".imgLog").style.display='block';
    
    document.querySelector(".alert.alert-info").style.opacity=0;
    document.querySelector(".alert.alert-info").style.display='none';


  }

  function revealPAss(){
    $("#pass").prop('type','text');
    $("#spanAction").prop("onclick",'hiddePass()');
  }

  function hiddePass(){
    $("#pass").prop('type','password');
    $("#spanAction").prop("onclick",'revealPAss()');
  }

  window.onload=function (){
    setTimeout(() => {
      $('input').val('');
    }, 100);
  }
  var DATOSAXIOS = '';
</script>