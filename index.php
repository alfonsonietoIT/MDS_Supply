<?php
session_start();
//Database
/*
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
*/

set_include_path('/home/MDSMaster/bWRzc3lz');
$vF = "VUVoUVJuVnVZM1JwYjI1ei92YXIucGhw";
$vD = "VUVoUVEyeGhjM00vREIucGhw";
$vC = "VUVoUVEyeGhjM00vRHJhd0NoYXJ0cy5waHA=";
date_default_timezone_set('America/Los_Angeles');
$dateToday = date('Y-m-d', time());
$dtAhora = date('Y-m-d H:i:s', time());
$dtEmpty = "2000-01-01 00:00:01";

$VarF = base64_decode($vF);
$VarD = base64_decode($vD);
$VarC = base64_decode($vC);
include ("$VarD");
include ("$VarF");
include ("$VarC");

//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>Conexion Default
$dbhost = 'localhost';
$dbuser = 'mds_supply';
$dbpass = '8MrGBSTwreDy0gg9';
$dbname = 'mds_supply';
$cnx = new DB($dbhost, $dbuser, $dbpass, $dbname);
//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>Conexion Default
$sqlmode = "SET SESSION sql_mode = ''";
$rsql = $cnx->query($sqlmode);

//Variables from DB
$SiteInfoA = $cnx->query('SELECT * FROM SiteInfo')->fetchAll();
//echo $account['FLastName'];
//print_r($SiteInfoA);

foreach ($SiteInfoA AS &$SiteInfo){
    //Valores
    $gVariableSite = $SiteInfo['Variable'];
    $txtV = "txt" . $gVariableSite;
    $intV = "int" . $gVariableSite;
    $dateV = "date" . $gVariableSite;
    $$intV = $SiteInfo['intValue'];
    $$txtV = $SiteInfo['txtValue'];
    $$dateV = $SiteInfo['dateValue'];
    
    //echo $gVariableSite;
}

switch ($sI){
    default:
        echo "";
        break;
    case "vLogin":
        $cuser = $_SESSION['puser'];	
	$cpass = $_SESSION['ppass'];
        //print_r($_SESSION);
        //echo "$cuser - $cpass<br>";
        $vUser = $cnx->query('SELECT * FROM Users WHERE CodUser = ? AND CodPass = ?', "$cuser", "$cpass")->fetchArray();
        //print_r($vUser);
        $uIDUser = $vUser['IDUser'];
        $uUser = $vUser['User'];
        $uMobileNumber = $vUser['MobileNumber'];
        $uEmail = $vUser['Email'];
        $uFLastName = $vUser['FLastName'];
        $uMLastName = $vUser['MLastName'];
        $uName = $vUser['Name'];
        $uBday = $vUser['Bday'];
        $uActive = $vUser['Active'];
        $uidSupervisor = $vUser['idSupervisor'];
        $uAccount = $vUser['Account'];
        $uIDExtra = $vUser['IDExtra'];
        $uFullName = "$uFLastName $uMLastName, $uName";
        break;
    case "Login":
        switch ($sII){
            case "vLogin":
                //echo "Aqui";
                //Obtienen variables
                $puserx = strtolower($_POST['user']);
                $puser = md5($puserx);
                $ppass = md5($_POST['password']);

                //echo "$ppass - $puser<BR>";

                $vUser = $cnx->query('SELECT * FROM Users WHERE (CodUser = ? OR MobileNumber = ?) AND CodPass = ?', "$puser", "$puserx", "$ppass")->fetchArray();
                $gActive = $vUser['Active'];
                //echo "Active: " . $vUser['Active'];
                //print_r($vUser);
                //echo "vUser: " . $vUser->numRows() . "<BR>";

                if($gActive == 1):
                    //Active
                    //Array datos
                    $_SESSION['puser'] = $puser;
                    $_SESSION['ppass'] = $ppass;
                else:
                    //No Active
                    $_SESSION['puser'] = "tantan";
                    $_SESSION['ppass'] = "tantan";
                    session_destroy();
                endif;

                break;
            default :
                session_destroy();
                break;
        }

        break;
}
//Login Validation



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
        <script src="https://www.google.com/recaptcha/api.js?render=6LcM8fMaAAAAAGjHrndIbcx2zbKlmGFbn5jWQpN1"></script>
    </head>
    <body>
        <?php
        //Depende $sI
        switch ($sI){
            case "Login":
                include 'Include/Login.php';
                break;
            case "vLogin":
                //echo "Activo:" . $uActive;
                //Valida acceso todo el tiempo
                if($uActive == 1){
                    
                    //Menus
                    include 'Include/MenusInternos.php';
                    //Login
                    include 'Include/vLogin.php';
                } else {
                    session_destroy();
                    $vATipo = "Rojo";
                    $vAMensaje = "Acceso Incorrecto";
                    $vRedirect = "index.php";
                    $vATime = 1000;
                    //echo $vRedirect;
                    echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                }
                
                
                break;
        }
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
$cnxw->close();
?>
