<?php $ruta = $_SERVER["HTTP_HOST"];?>
<!-- Copyright Creative Tim  -->
<!-- Implements by ASICOM GRAPHICS -->
<!-- CMA 2022 -->
<!DOCTYPE html>
<html lang="ES">
<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="./assets/img/apple-icon.png">
  <link rel="icon" type="image/svg" href="./assets/img/favicon.svg">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>CMA - Bienvenido</title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
  <!-- CSS Files -->
  <link href="./assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="./assets/css/paper-dashboard.css?v=2.1" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="./assets/demo/demo.css" rel="stylesheet" />
  <script src="https://cdn.ckeditor.com/4.17.1/standard/ckeditor.js"></script>

  <!-- <! - Formato de hora -> -->
<link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
<!-- <! - archivo jQuery. Asegúrese de introducir antes de bootstrap.min.js -> -->
<script src="https://cdn.bootcss.com/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdn.bootcss.com/moment.js/2.18.1/moment-with-locales.min.js"></script>
<!--datetimepicker-->
<link href="https://cdn.bootcss.com/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css"
      rel="stylesheet">
<script src="https://cdn.bootcss.com/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
  
  
</head>
<body class="">

<!--?? contenido de la vista -->
<div class="wrapper">

      <!-- menu lateral -->
    <?php include_once "layout_menu.php"?>

    <div class="main-panel" style="height: 100vh;">

      <!-- Navbar -->
      <?php include_once "layout_nav.php"; ?>

      <!-- Route View -->
      <?php Route::view($_GET['view']); ?>

      <!-- ejemplo de contenido view CLEAN
        <div class="content">
        <div class="row">
          <div class="col-md-12">
            <h3 class="description">Your content here</h3>
          </div>
        </div>
      </div> 
    -->
      <footer class="footer" style="position: absolute; bottom: 0; width: -webkit-fill-available;">
        <div class="container-fluid">
          <div class="row">
            <nav class="footer-nav">
              <ul>
                <li><a href="https://cma.mx" target="_blank">cma.mx</a></li>
              </ul>
            </nav>
            <div class="credits ml-auto">
              <span class="copyright">
                © 2022 <i class="fa fa-heart heart"></i>power by <a href="asicomgraphics.mx">asicomgraphics</a>
              </span>
            </div>
          </div>
        </div>
      </footer>
    </div>
  </div>

<!--?? contenido de la vista -->


 <!--   Core JS Files   -->
 <script src="./assets/js/core/jquery.min.js"></script>
  <!-- <script src="./assets/js/core/popper.min.js"></script> -->
  <script src="./assets/js/core/bootstrap.min.js"></script>
  <script src="./assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <!--  Google Maps Plugin    -->
  <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
  <!-- Chart JS -->
  <script src="./assets/js/plugins/chartjs.min.js"></script>
  <!--  Notifications Plugin    -->
  <script src="./assets/js/plugins/bootstrap-notify.js"></script>
  <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="./assets/js/paper-dashboard.min.js?v=2.1" type="text/javascript"></script>
	
  



  <!-- select2 -->
  <link href="./assets/js/plugins/select2/select2-min.css" rel="stylesheet" /> 
  <script src="./assets/js/plugins/select2/select2.min.js"></script>
</body>

</html>


<body>