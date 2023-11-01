<?php 
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);


if(isset($_REQUEST['recoveryMail']) and $_REQUEST['recoveryMail']==''){
  header("Location: index.php?error=errorrecoveryMail");
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
  <link href="./assets/css/bootstrap.min.css?v=<?php echo date('YmdHis');?>" rel="stylesheet" />
  <link href="./assets/css/paper-dashboard.css?v=<?php echo date('YmdHis');?>" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="./assets/demo/demo.css?v=<?php echo date('YmdHis');?>" rel="stylesheet" />
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
  </style>
</head>


<body recoveryMail>
<div class="section section-image section-login" data-src="./assets/img/bg/1.jpg" style="background-size:cover; background-image: url('./assets/img/bg/1.1.jpg'); height:100vh">
      <div class="container p-1">
        <div class="row">
          <div class="col-lg-4 col-md-6 mx-auto">
            <!-- LOGIN -->
            <div class="card card-register p-3" style="margin-top:10vh">
             <img src="/cma/assets/img/logo_large_white.png" class="p-md-3" alt="">
              <!-- <h3 class="title mx-auto">CMA</h3> -->

           
              <div class="alert alert-info">
                  <button onclick="closeA()" type="button" aria-hidden="true" class="close">×</button>
                  <span><b>Escribe la clave KEY que ha sido enviada a tu correo electronico! - </b><br> y escribe tu nuevo password.</span>
              </div>

              
              
              <form class="register-form error" action="./?action=recovery" method="POST" enctype="multipart/form-data">
                <label>Email</label>
                <div class="input-group form-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text" disabled>
                      <i class="nc-icon nc-email-85"></i>
                    </span>
                  </div>
                  <input name="email" type="email" class="form-control" value="<?=$_REQUEST['recoveryMail']?>" placeholder="Email" style="opacity: .6;pointer-events: none;">
                </div>
                <label>key que se envió por mail</label>
                <div class="input-group form-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="nc-icon nc-key-25"></i>
                    </span>
                  </div>
                  <input onkeyup="javascript:this.value=this.value.toUpperCase();" id="key" name="key" type="text" value="" maxlength="4" class="form-control" placeholder="KEY">
                </div>
                <label>Nuevo Password</label>
                <div class="input-group form-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="nc-icon nc-key-25"></i>
                    </span>
                  </div>
                  <input id="pass" name="pass" type="password" value="" class="form-control" placeholder="nuevo Password">
                </div>
                <input id="timerst" name="timerst" type="hidden" value="<?=$_REQUEST['timerstkey']?>" class="form-control">
                <button class="btn btn-danger btn-block btn-round">Enviar</button>
              </form>
              <?php 
              
              if (isset($_REQUEST['info']) && $_REQUEST['info']!=''){
                ?>
                <script>
                  function closeA(){
                    document.querySelector(".alert.alert-info").style.opacity=0;
                    document.querySelector(".alert.alert-info").style.display='none';
                  }
                  // document.querySelector("[name=email]").classList.add("error");
                  // document.querySelector("[name=pass]").classList.add("error");
                  document.querySelector(".alert.alert-info").style.opacity=1;
                  document.querySelector(".alert.alert-info").style.display='block';
                  // document.querySelector(".alert.alert-danger").classList.add("visible");
                  
                </script>
                <?php
              }
              ?>
              <div class="forgot">
                <a href="#"  onclick="logIn()" class="btn btn-link btn-secondary">LOG IN</a>
              </div>
            </div>

            <!-- PASSWORD -->
            <div class="card card-password p-3 d-none" style="margin-top:25vh">
             <img src="assets/img/logo_large_white.png" class="p-md-3" alt="">
              <div class="alert alert-danger">
                  <button onclick="closeA()" type="button" aria-hidden="true" class="close">×</button>
                  <span><b> El usuario no existe</b> <br> intentalo nuevamente.</span>
              </div>
              <form class="recovery-password"  enctype="multipart/form-data">
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
    let email = document.querySelector('[name=Remail]').value;
    axios.post('./?action=recoveryPass&mail='+email, {method:'solicitud',  email : email })
    .then(function (response) {
      console.log("Axios OK");
      console.log(response);
    })
    .catch(function (error) {
      console.log(error);
    });
  }
</script>