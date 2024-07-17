<?php
$sI = $_GET['sI'];
$sII = $_GET['sII'];
$sIII = $_GET['sIII'];
$sIV = $_GET['sIV'];

//Access DB
$dbhost = 'localhost';
$dbuser = 'mds_supply';
$dbpass = '8MrGBSTwreDy0gg9';
$dbname = 'mds_supply';
$cnx = new DB($dbhost, $dbuser, $dbpass, $dbname);

//Access DB
$dbhostw = 'localhost';
$dbuserw = 'mds_warehouse';
$dbpassw = 'WXNUG)eEHw44cr71';
$dbnamew = 'mds_warehouse';
$cnxw = new DB($dbhostw, $dbuserw, $dbpassw, $dbnamew);


//Dates Var
date_default_timezone_set('America/Los_Angeles');
$dateToday = date('Y-m-d', time());
$dtAhora = date('Y-m-d H:i:s', time());
$dtEmpty = "2000-01-01 00:00:01";

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
    
    
}

//Home
if($sI == ""){
    $sI = "Login";
    $sII = "";
    $sIII = "";
    $sIV = "";
}


//ECHOS
//echo "$sI|$sII|$sIII|$sIV<br>";
//echo "$dateToday<br>$dtAhora";



?>