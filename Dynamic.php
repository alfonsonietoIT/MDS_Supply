<?php
//Database
include 'PHPClass/DB.php';
include 'PHPFunctions/var.php';
include 'PHPFunctions/Function_Alerta.php';
include 'PHPFunctions/Function_Form.php';
include 'PHPFunctions/Func_Form.php';
include 'PHPFunctions/Function_List.php';
include 'PHPFunctions/Func_List.php';
include 'PHPFunctions/Function_Link.php';
include 'PHPFunctions/Function_Notificacion.php';
include 'PHPFunctions/Function_SMS.php';
include 'PHPFunctions/Func_Chart.php';
include 'PHPClass/DrawCharts.php';

$ki = base64_decode($_GET['KeyI']);
$kii = base64_decode($_GET['KeyII']);
$kiii = base64_decode($_GET['KeyIII']);
$kiv = base64_decode($_GET['KeyIV']);
//echo "variable: $ki";
$homeLink = "Dynamic.php?sI=" . $_GET['sI'];


?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title><?php echo $sI;?> <?php echo $txtCompany;?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php
        if(strtotime($dateExpiredDate) < strtotime($dateToday)):
            ?>
        <meta http-equiv="refresh" content="7; url='https://www.softwaredevelopment.mx'" />
        <?php
        endif;
        ?>
        <!--<link href="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <script src="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.js"></script>
        <link rel="preconnect" href="https://fonts.gstatic.com"> 
        <link href="https://fonts.googleapis.com/css2?family=Bahianita&family=KoHo:wght@200&family=Padauk&family=Shadows+Into+Light&display=swap" rel="stylesheet">-->
        <link type="text/css" rel="stylesheet" href="CSS/GeneralMDS.css">
        <link rel="apple-touch-icon" sizes="57x57" href="/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="/apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192"  href="/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
        <link rel="manifest" href="/manifest.json">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">
        <script type="application/javascript" src="JS/General.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
        <script src="https://www.google.com/recaptcha/api.js?render=6LcM8fMaAAAAAGjHrndIbcx2zbKlmGFbn5jWQpN1"></script>
        <script type="text/javascript">
        $(window).load(function() {
            $(".loader").fadeOut("slow");
        });
        </script>
    </head>
    <body>
        <div class="loader"></div>
        
        <?php
        //Depende $sI
        include 'Include/vDynamic.php';
        ?>
    <script>
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', function() {
            navigator.serviceWorker.register('sw.js').then(function(registration) {
            // Registration was successful
            console.log('ServiceWorker registration successful with scope: ', registration.scope);
            }).catch(function(err) {
            // registration failed :(
            console.log('ServiceWorker registration failed: ', err);
            });
        });
    }    
    
    
    </script>
    </body>
</html>
<?php
$cnx->close();
?>
