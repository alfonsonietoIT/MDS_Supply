#!/usr/bin/php
<?php
error_reporting(1);
$sI = $sII = $sIII = $sIV = ""; 
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
//include ("$VarF");
//include ("$VarC");


//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>Conexion Default
$dbhost = 'localhost';
$dbuser = 'mds_aoi';
$dbpass = '4@JBBNB[_QL[Grnf';
$dbname = 'mds_aoi';
$cnx = new DB($dbhost, $dbuser, $dbpass, $dbname);
//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>Conexion Default
$sqlmode = "SET SESSION sql_mode = ''";
$rsql = $cnx->query($sqlmode);


$logoExcel = "data:image/png;base64,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";

//Folder
$dirt = "/home/AOIControl/";
$back = "/home/AOIControl/Backup/";
$read = "/home/AOIControl/Reading/";
$error = "/home/AOIControl/Error/";
$files = scandir($dirt);

//Copia Archivos
foreach ($files AS &$File) {
    //Solo CSV
    if(substr(strtolower($File), -3) == "csv"){
        //NFile
        $FullF = $dirt . $File;
        $tBackup = $back . $File;
        $tRead = $read . $File;
        echo $File . "\r\n";
        echo "*****COPY Backup $File" . "\r\n";
        copy($FullF, $tBackup);
        echo "*****COPY Backup $File" . "\r\n";
        copy($FullF, $tRead);
        echo "*****DELETE File $File" . "\r\n";
        unlink($FullF);
        
        //Inserta en Files Read PHP
        $iFiles = "INSERT INTO AOIFiles VALUES('0', '0', '$File', '$dtAhora', '$dtAhora', 'Created')";
        $rF = $cnx->query($iFiles);
        
    }
}

//Obtiene lo pendiente de leer
$sRun = "SELECT * FROM AOIFiles WHERE Status = 'Runing'";
$nRun = $cnx->query($sRun)->numRows();
//echo $sRun . "- $nRun";


/*

if($nRun == 0){
    //Se trae todos los pendiente de leer
    $sFiles = "SELECT * FROM AOIFiles WHERE status = 'Created'";
    $rFiles = $cnx->query($sFiles)->fetchAll();
    
    foreach($rFiles AS &$rFx){
        //Data
        $idFile = $rFx['idAOIFiles'];
        $Filex = $rFx['File'];
        
        //Actualiza Base
        $uFile = "UPDATE AOIFiles SET Status = 'Runin' WHERE idAOIFiles = '$idFile'";
        $ruF = $cnx->query($uFile);
        
        $linkFile = $read . $Filex;
        echo "Reading> " . $linkFile . "\r\n";
        $IDTest = $AddedDet = $AddedRes = $fDet = $AddedTest = 0;
        $Fila = 1;
        $Encode = $Version = "";
        //Lee Archivo
        if (($Gestor = fopen($linkFile, "r")) !== FALSE) {
            //Aumenta la fila
            
            while (($TFData = fgetcsv($Gestor, 0, ",")) !== FALSE) {
                
                switch ($Fila){
                    case 1:
                        //print_r($TFData);
                        for ($c=0; $c < 2; $c++) {
                            $var = "C" . $c;
                            $$var = str_replace("\\", "", str_replace("\"", "", str_replace("'", "", $TFData[$c])));
                        }
                        
                        $Version = preg_replace("/[^a-zA-Z0-9.]+/", "", $C0);
                        $Encode = $C1;
                        //echo "$Fila - $iVersion - $Version - $Encode\r\n";
                        
                        break;
                    case 3:
                        $cols = count($TFData);
                        //print_r($TFData);
                        for ($c=0; $c < $cols; $c++) {
                            $var = "C" . $c;
                            $$var = str_replace("\\", "", str_replace("\"", "", str_replace("'", "", $TFData[$c])));
                        }
                        
                        //echo "$cols - *$Version*\r\n";
                        
                        switch ($Version){
                            case "V3.09":
                            case "V3.08":
                                $sMid = "SELECT MAX(IDTest) AS mid FROM AOITest";
                                $rMid = $cnx->query($sMid)->fetchArray();
                                $IDTest = $rMid['mid'] + 1;


                                //Lee Fila 3
                                $iTest = "INSERT INTO AOITest VALUES("
                                        . "'$IDTest', '$Version', '$Encode', '$C0', '$C1', '', '$C2', '', '$C3', "
                                        . "'$C4', '$C5', '$C6', '$C7', '$C8', '0', "
                                        . "'$C9', '', '', '$C10', '$C11', '$C12', '$C13', "
                                        . "'$C14', '$C15', '$C16', '$C17', '$C18', "
                                        . "'$C19', '$C20', '$C21', '$C22', '$C23', "
                                        . "'$C24', '$C25', '$C26', '$C27', '$C28', "
                                        . "'$C29', '$C30', '$C31', '$C32', '$C33', "
                                        . "'$C34', '$C35', '$C36', '$C37', '$dateToday'"
                                        . ")";
                                //echo $iTest . "\r\n";
                                $riT = $cnx->query($iTest);
                                $AddedTest += $riT->affectedRows();
                                //echo "Affected Rows:" . $riT->affectedRows() . "\r\n";
                                //echo $iTest . "\r\n";
                                //$AddedTest = 1;
                                break;
                            case "V2.04":
                                $sMid = "SELECT MAX(IDTest) AS mid FROM AOITest";
                                $rMid = $cnx->query($sMid)->fetchArray();
                                $IDTest = $rMid['mid'] + 1;


                                //Lee Fila 3
                                $iTest = "INSERT INTO AOITest VALUES("
                                        . "'$IDTest', '$Version', '$Encode', '$C0', '$C1', '$C2', '$C3', '$C4', '$C5', "
                                        . "'$C6', '$C7', '$C8', '$C9', '0', '$C10', "
                                        . "'$C11', '$C12', '$C13', '$C14', '$C15', '$C16', '$C17', "
                                        . "'$C18', '$C19', '$C20', '$C21', '2001-01-01 00:00:01', '0', "
                                        . "'', '2001-01-01 00:00:01', '', '$C22', '$C23', "
                                        . "'$C24', '0', '0', '', '', "
                                        . "'', '', '0', '0', '0', "
                                        . "'0', '0', '', '$dateToday'"
                                        . ")";
                                //echo $iTest . "\r\n";
                                $riT = $cnx->query($iTest);
                                $AddedTest += $riT->affectedRows();
                                //echo "Affected Rows:" . $riT->affectedRows() . "\r\n";
                                //echo $iTest . "\r\n";
                                //$AddedTest = 1;
                                break;
                            default :
                                //echo "Default\r\n";
                                break;
                        }
                        break;
                    default:
                        //Fila 4
                        if($AddedTest == 1){
                            
                            switch ($Version){
                                case "V3.09":
                                case "V3.08":
                                    if($Fila > 4){
                                        //Despues de 4
                                        //Agrega
                                        $cols = count($TFData);

                                        //print_r($TFData);
                                        for ($c=0; $c < $cols; $c++) {
                                            $var = "C" . $c;
                                            $$var = str_replace("\\", "", str_replace("\"", "", str_replace("'", "", $TFData[$c])));
                                        }

                                        $fdetail = $C0;

                                        if($fdetail == "RefNo"){
                                            $fDet = $Fila;
                                        }

                                        //Valores de Results
                                        if($Fila < $fDet || $fDet == 0){
                                            //Aqui Results
                                            //echo $C0 . "\r\n";
                                            $iRes = "INSERT INTO AOITest_Results VALUES("
                                                    . "'0', '$IDTest', '$C0', '$C1', '$C2', "
                                                    . "'$C3', '$C4', '$C5', '$C6', '$C7')";
                                            //echo $iRes . "\r\n";
                                            $riR = $cnx->query($iRes);
                                            $AddedRes += $riR->affectedRows();

                                        }

                                        if($Fila > $fDet){
                                            //Aqui Detail
                                            if($fDet > 0 && $AddedRes > 0){
                                                //echo $C2 . "\r\n";
                                                $iDetail = "INSERT INTO AOITest_DetailV3 VALUES("
                                                        . "'0', '$IDTest', '$C0', '$C1', '$C2', "
                                                        . "'$C3', '$C4', '$C5', '$C6', '$C7', "
                                                        . "'$C8', '$C9', '$C10', '$C11', '$C12', "
                                                        . "'$C13', '$C14', '$C15', '$C16', '$C17', "
                                                        . "'$C18', '$C19', '$C20', '$C21', '$C22', "
                                                        . "'$C23', '$C24', '$C25', '$C26', '$C27', "
                                                        . "'$C28', '$C29', '$C30', '$C31', '$C32', "
                                                        . "'$C33', '$C34', '$C35', '$C36', '$C37', "
                                                        . "'$C38', '$C39'"
                                                        . ")";
                                                //echo $iDetail . "\r\n";
                                                $riD = $cnx->query($iDetail);
                                                $AddedDet += $riD->affectedRows();
                                                
                                            }

                                        }



                                    }
                                    break;
                                case "V2.04":
                                    if($Fila > 4){
                                        //Despues de 4
                                        //Agrega
                                        $cols = count($TFData);

                                        //print_r($TFData);
                                        for ($c=0; $c < $cols; $c++) {
                                            $var = "C" . $c;
                                            $$var = str_replace("\\", "", str_replace("\"", "", str_replace("'", "", $TFData[$c])));
                                        }

                                        $fdetail = $C0;

                                        if($fdetail == "StepNo"){
                                            $fDet = $Fila;
                                        }

                                        //Valores de Results
                                        if($Fila < $fDet || $fDet == 0){
                                            //Aqui Results
                                            //echo $C0 . "\r\n";
                                            $iRes = "INSERT INTO AOITest_Results VALUES("
                                                    . "'0', '$IDTest', '$C0', '$C1', '$C2', "
                                                    . "'$C3', '$C4', '$C5', '$C6', '$C7')";
                                            //echo $iRes . "\r\n";
                                            $riR = $cnx->query($iRes);
                                            $AddedRes += $riR->affectedRows();

                                        }

                                        if($Fila > $fDet){
                                            //Aqui Detail
                                            if($fDet > 0 && $AddedRes > 0){
                                                //echo $C2 . "\r\n";
                                                $iDetail = "INSERT INTO AOITest_DetailV2 VALUES("
                                                        . "'0', '$IDTest', '$C0', '$C1', '$C2', "
                                                        . "'$C3', '$C4', '$C5', '$C6', '$C7', "
                                                        . "'$C8', '$C9', '$C10', '$C11', '$C12', "
                                                        . "'$C13', '$C14', '$C15', '$C16', '$C17', "
                                                        . "'$C18', '$C19', '$C20', '$C21', '$C22', "
                                                        . "'$C23', '$C24', '$C25', '$C26', '$C27', "
                                                        . "'$C28', '$C29', '$C30', '$C31', '$C32', "
                                                        . "'$C33', '$C34', '$C35', '$C36', '$C37', "
                                                        . "'$C38', '$C39', '$C40', '$C41', '$C42', "
                                                        . "'$C43', '$C44', '$C45', '$C46'"
                                                        . ")";
                                                //echo $iDetail . "\r\n";
                                                $riD = $cnx->query($iDetail);
                                                $AddedDet += $riD->affectedRows();
                                                
                                            }

                                        }



                                    }
                                    break;
                            }
                            
                            
                            
                        }
                        break;
                }
                
                $Fila++;
                
                
                
            }
            
            fclose($Gestor);
        }
        
        if($AddedTest > 0 && $AddedRes > 0 && $AddedDet > 0){
            $dtahorita = date('Y-m-d H:i:s', time());
            //Actualiza file
            $uFilex = "UPDATE AOIFiles SET IDTest = '$IDTest', ReadOn = '$dtahorita', Status = 'Uploaded' WHERE idAOIFiles = '$idFile'";
            $ruFx = $cnx->query($uFilex);
            unlink($linkFile);
        } else {
            $uFilex = "UPDATE AOIFiles SET ReadOn = '$dtahorita', Status = 'Error' WHERE idAOIFiles = '$idFile'";
            $ruFx = $cnx->query($uFilex);
            $tError = $error . $Filex;
            copy($linkFile, $tError);
            unlink($linkFile);
        }
        
        
    }
    
    
}
*/

$cnx->close();

