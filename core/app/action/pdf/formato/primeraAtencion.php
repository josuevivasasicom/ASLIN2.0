<html>
    <head>
        <style>
            /** Define the margins of your page **/
            @page {
                margin: 100px 25px;
            }

            header {
                position: fixed;
                top: -60px;
                left: 0px;
                right: 0px;
                height: 50px;

                /** Extra personal styles **/
                background-color: #03a9f4;
                color: white;
                text-align: center;
                line-height: 35px;
            }

            footer {
                position: fixed; 
                bottom: -60px; 
                left: 0px; 
                right: 0px;
                height: 50px; 

                /** Extra personal styles **/
                background-color: #03a9f4;
                color: white;
                text-align: center;
                line-height: 35px;
            }
            .logo{
                position: relative;
                width: 300px;
                height: auto;
            }

        </style>
    </head>
    <body>
        <!-- Define header and footer blocks before your content -->
        <div class="header">
          hola mundo
          <br>
          <!-- <img src ="./logoCMA_white.png" class='logo' alt='imagen de logo'> 3<br> -->
	        <img src="logoCMA_white.png" style="width: 100%; height: 100%; position: absolute;">
        </div >
<?php echo $contenido;?>
        <div class="footer">
            Copyright &copy; <?php echo date("Y");?> 
        </div class="footer">

        <!-- Wrap the content of your PDF inside a div class="main" tag -->
        <div class="main">
            <p style="page-break-after: always;">
                Content Page 1
            </p>
            <p style="page-break-after: never;">
                Content Page 2
            </p>
        </div >
    </body>
</html>