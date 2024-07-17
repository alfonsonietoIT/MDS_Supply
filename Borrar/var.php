<?php
$sI = $_GET['sI'];
$sII = $_GET['sII'];
$sIII = $_GET['sIII'];
$sIV = $_GET['sIV'];


//Access DB Airgain
$dbhosta = 'localhost';
$dbusera = 'mds_airgain';
$dbpassa = 'SGl3a5CbTHhu@evu';
$dbnamea = 'mds_airgain';
$cnxa = new DB($dbhosta, $dbusera, $dbpassa, $dbnamea);

//Access DB Supply
$dbhosti = 'localhost';
$dbuseri = 'mds_invoicing';
$dbpassi = '1!(R2ETgSM-wg5zu';
$dbnamei = 'mds_invoicing';
$cnxi = new DB($dbhosti, $dbuseri, $dbpassi, $dbnamei);


//Access DB Supply
$dbhosts = 'localhost';
$dbusers = 'mds_supply';
$dbpasss = '8MrGBSTwreDy0gg9';
$dbnames = 'mds_supply';
$cnxs = new DB($dbhosts, $dbusers, $dbpasss, $dbnames);

//Access DB Test Supply
$dbhostts = 'localhost';
$dbuserts = 'test_supply';
$dbpassts = 'Vg2]cw1WA6dw)mm9';
$dbnamets = 'test_supply';
$cnxts = new DB($dbhostts, $dbuserts, $dbpassts, $dbnamets);

//Access DB Warehouse
$dbhostw = 'localhost';
$dbuserw = 'mds_warehouse';
$dbpassw = 'WXNUG)eEHw44cr71';
$dbnamew = 'mds_warehouse';
$cnxw = new DB($dbhostw, $dbuserw, $dbpassw, $dbnamew);

//Access DB BigData
$dbhostb = 'localhost';
$dbuserb = 'mds_aoi';
$dbpassb = '4@JBBNB[_QL[Grnf';
$dbnameb = 'mds_aoi';
$cnxb = new DB($dbhostb, $dbuserb, $dbpassb, $dbnameb);

if(empty($sI)){
    $sI = "Login";
    $sII = "";
    $sIII = "";
    $sIV = "";
}

//Get License
$License = "a38dfe23fe1d32a6bb8f396ae1777878";

if(!isset($_COOKIE[$License])) {
    $Lic_expire = "2023-12-31";
    setcookie("$License", "$Lic_expire", time() + (86400 * 1), "/");
    setcookie("$License" . "_cdt", time() + (86400 * 1), time() + (86400 * 1), "/");
    
    if(strtotime($Lic_expire) >= time()){
        //echo "Cookie named '" . $License . "' is not set!<BR>";
        //echo "Cookie named '" . $License . "_cdt" . "' is not set!<B>";
        //echo "No existia y guardo OK<BR>";
        $sec = "1";
        
    } else {
        //echo "Cookie named '" . $License . "' is not set!";
        //echo "Cookie named '" . $License . "_cdt" . "' is not set!";
        $sec = "50";
    }
    
    $page = $_SERVER['PHP_SELF'];
    header("Refresh: $sec; url=$page");
    
} else {
    //Existe la cookie
    $CookieLocDate = $_COOKIE["a38dfe23fe1d32a6bb8f396ae1777878_cdt"];
    $ExpiredLicense = $_COOKIE[$License];
    
    if(strtotime(date('Y-m-d', time())) >= $CookieLocDate){
        //echo "Conect to SMS 2<BR><BR>";
        //Si la cookie esta vencida
        $Lic_expire = "2023-12-31";
        setcookie("$License", "$Lic_expire", time() + (86400 * 1), "/");
        setcookie("$License" . "_cdt", time() + (86400 * 1), time() + (86400 * 1), "/");

        if(strtotime($Lic_expire) >= time()){
            //echo "Cookie named '" . $License . "' is renew!<BR>";
            //echo "Cookie named '" . $License . "_cdt" . "' is renew!<B>";
            //echo "No existia y guardo OK<BR>";
            $sec = "1";
        

        } else {
            //echo "Cookie named '" . $License . "' is not set!";
            //echo "Cookie named '" . $License . "_cdt" . "' is not set!";
            $sec = "30";
        
        }

        $page = $_SERVER['PHP_SELF'];
        header("Refresh: $sec; url=$page");
        
    } else {
	    
        //Activa
        if(strtotime($ExpiredLicense) >= strtotime(date('Y-m-d', time()))){
	    $Lic_expireCookie = $ExpiredLicense;
	    //echo "XXXX";

        } else {
            $Lic_expireCookie = $ExpiredLicense;
            $page = $_SERVER['PHP_SELF'];
            $sec = "10";
            header("Refresh: $sec; url=$page");
	}

	//echo "YYYY<BR>";
	//$page = $_SERVER['PHP_SELF'];
        //$sec = "150";
        //header("Refresh: $sec; url=$page");

    }
    
    
    
    
}

if(strtotime($Lic_expireCookie) > time()){
    //echo "$sI|$sII|$sIII|$sIV<br>";
    //echo "Expired on: $Lic_expireCookie";
    //setcookie("$License", "$Lic_expire", time() + (86400 * 30), "/");
    //$ExpiredLicense = "";
    $folderFunct = "UEhQRnVuY3Rpb25z/";
    $Func_1 = $folderFunct . "Function_Alerta.php";
    $Func_2 = $folderFunct . "Function_Form.php";
    $Func_3 = $folderFunct . "Func_Form.php";
    $Func_4 = $folderFunct . "Function_List.php";
    $Func_5 = $folderFunct . "Func_List.php";
    $Func_6 = $folderFunct . "Function_Link.php";
    $Func_7 = $folderFunct . "Function_Notificacion.php";
    $Func_8 = $folderFunct . "Function_SMS.php";
    $Func_9 = $folderFunct . "Func_Chart.php";
    $Func_10 = $folderFunct . "DrawCharts.php";
    $nf = 0;
    while ($nf < 10){
        $nf++;
        $varf = "Func_" . $nf;

        $functx = $$varf;
        //echo $functx . "<BR>";
        include("$functx");
    }
} else {
    if(empty($Lic_cellphone)){
        $Lic_cellphone = "6861812074";
    }
    //echo "Call Phone: $Lic_cellphone";
    $ExpiredLicense = "<div style='background-color:yellow;border:1px black solid;'>"
            . "<font class='Koh'>"
            . "Expired License:<BR>"
            . "<b>Call Phone : $Lic_cellphone</b>"
            . "</font>"
            . "</div>";
}

