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
$dbuser = 'mds_supply';
$dbpass = '8MrGBSTwreDy0gg9';
$dbname = 'mds_supply';
$cnx = new DB($dbhost, $dbuser, $dbpass, $dbname);
//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>Conexion Default
$sqlmode = "SET SESSION sql_mode = ''";
$rsql = $cnx->query($sqlmode);


$logoExcel = "data:image/png;base64,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";

//Revisa si esta corriendo
$sRun = "SELECT * FROM TempFiles WHERE Status = 'Runing' ORDER BY idFiles ASC";
$nRun = $cnx->query($sRun)->numRows();

if($nRun == 0){
    
    //Verifica
    $sTF = "SELECT * FROM TempFiles WHERE Status = 'Open' ORDER BY idFiles ASC";
    $LTF = $cnx->query($sTF)->fetchAll();

    foreach ($LTF as &$TF) {
        //Data
        $TF_idFiles = $TF['idFiles'];
        $TF_TFile = $TF['TFile'];
        $TF_Link = "/var/www/html/Supply/" . $TF['Link'];
        $TF_idUser = $TF['idUser'];
        $TF_dateReport = $TF['dateReport'];
        $TF_UserCreated = $TF['UserCreated'];
        $TF_Status = $TF['Status'];
        $TF_dtCreated = $TF['dtCreated'];
        $TF_dtProcessed = $TF['dtProcessed'];
        $uTFile = "UPDATE TempFiles SET dtProcessed = '$dtAhora', Status = 'Runing' WHERE idFiles = '$TF_idFiles'";
        $ruTFile = $cnx->query($uTFile);
        //echo $TF_idFiles . " - $TF_TFile\r\n";
        $Row = 0;
        $iTemAnt = "";

        switch ($TF_TFile){
            case "MRPFile":
                $tTable = "TRUNCATE TABLE MRPData";
                $rTT = $cnx->query($tTable);
                break;
            case "PodFile":
                $tTable = "TRUNCATE TABLE PodData";
                $rTT = $cnx->query($tTable);
                break;
            case "PartsFile":
                $tTable = "TRUNCATE TABLE PartData";
                $rTT = $cnx->query($tTable);
                break;
            case "BOMFile":
                $tTable = "TRUNCATE TABLE BOM";
                $rTT = $cnx->query($tTable);
                break;
            case "OverIssue":
                $tTable = "TRUNCATE TABLE OverIssue";
                $rTT = $cnx->query($tTable);
                break;
            case "PODemand":
                $tTable = "TRUNCATE TABLE PODemand";
                $rTT = $cnx->query($tTable);
                break;
            case "InvDetail":
                $tTable = "TRUNCATE TABLE InvDetail";
                $rTT = $cnx->query($tTable);
                break;
            case "WOPlanner":
                $tTable = "TRUNCATE TABLE WOPlanner";
                $rTT = $cnx->query($tTable);
                break;
        }

        if (($Gestor = fopen($TF_Link, "r")) !== FALSE) {

            while (($TFData = fgetcsv($Gestor, 0, ",")) !== FALSE) {
                $numero = count($TFData);
                //echo "Numero: $numero\r\n";
                //print_r($TFData[2]);
                switch ($TF_TFile):
                    case "WOPlanner":
                        //echo "<p> $numero de campos en la línea $Row: <br /></p>\n";
                        $Row++;
                        for ($c=0; $c < $numero; $c++) {
                            $var = "C" . $c;
                            //echo $var . "\r\n";
                            //Lee el archivo
                            $$var = str_replace("\\", "", str_replace("\"", "", str_replace("'", "", $TFData[$c])));
                            $varant = "aC" . $c;

                            //Fechas
                            switch ($c){
                                case 6:
                                case 7:
                                case 8:
                                case 14:
                                case 16:
                                case 17:
                                    if(empty($$var)){
                                        $$var = "2000-01-01";
                                    } else {
                                        $TempVal = $$var;
                                        $$var = date('Y-m-d', strtotime($TempVal));
                                    }
                                    break;
                            }

                            //Time
                            switch ($c){
                                case 18:
                                    if(empty($$var)){
                                        $$var = "00:00:01";
                                    } else {
                                        $TempVal = $$var;
                                        $$var = $TempVal;
                                    }
                                    break;
                            }

                            //Para Precios
                            switch ($c){
                                case 4:
                                case 5:
                                case 11:
                                case 12:
                                    if(empty($$var)){
                                        $$var = 0;
                                    } else {
                                        $TempVal = $$var;
                                        $$var = str_replace("$", "", str_replace(",", "", $TempVal));
                                    }
                                    break;
                            }

                            $$varant = $$var;
                        }

                        //*echo "$C13 - $C14\n";

                        //Solo Price1 y Qty > 0
                        if(!empty($C0) && $C0 != 'Class_Data'){
                            //Busca el mayor valor
                            $iIv = "INSERT INTO WOPlanner VALUE("
                                . "'0', '$C0', '$C1', '$C2', "
                                . "'$C3', '$C4', '$C5', '$C6', '$C7', "
                                . "'$C8', '$C9', '$C10', '$C11', '$C12', "
                                . "'$C13', '$C14', '$C15', '$C16', '$C17', "
                                . "'$C18', '$C19', '$C20', '$C21', '$dateToday', '$dtAhora', 'Open'"
                                . ")";

                            $riIv = $cnx->query($iIv);
                            //echo $Row . "\n\n" . $iIv . "\n\n";

                        }
                        break;
                    case "InvDetail":
                        //echo "<p> $numero de campos en la línea $Row: <br /></p>\n";
                        $Row++;
                        for ($c=0; $c < $numero; $c++) {
                            $var = "C" . $c;
                            //echo $var . "\r\n";
                            //Lee el archivo
                            $$var = str_replace("\\", "", str_replace("\"", "", str_replace("'", "", $TFData[$c])));
                            $varant = "aC" . $c;

                            //Fechas
                            switch ($c){
                                case 19:
                                    if(empty($$var)){
                                        $$var = "2000-01-01";
                                    } else {
                                        $TempVal = $$var;
                                        $$var = date('Y-m-d', strtotime($TempVal));
                                    }
                                    break;
                            }

                            //Para Precios
                            switch ($c){
                                case 7:
                                case 8:
                                case 9:
                                case 10:
                                case 11:
                                case 12:
                                case 13:
                                case 14:
                                case 15:
                                case 16:
                                case 17:
                                case 18:
                                case 20:
                                case 21:
                                case 23:
                                case 24:
                                    if(empty($$var)){
                                        $$var = 0;
                                    } else {
                                        $TempVal = $$var;
                                        $$var = str_replace("$", "", str_replace(",", "", $TempVal));
                                    }
                                    break;
                            }

                            $$varant = $$var;
                        }

                        //*echo "$C13 - $C14\n";

                        //Solo Price1 y Qty > 0
                        if(!empty($C0) && $C0 != 'Class_Data'){
                            //Busca el mayor valor
                            $iIv = "INSERT INTO InvDetail VALUE("
                                . "'0', '$C0', '$C1', '$C2', "
                                . "'$C3', '$C4', '$C5', '$C6', '$C7', "
                                . "'$C8', '$C9', '$C10', '$C11', '$C12', "
                                . "'$C13', '$C14', '$C15', '$C16', '$C17', "
                                . "'$C18', '$C19', '$C20', '$C21', '$C22', "
                                . "'$C23', '$C24', '$dateToday', '$dtAhora', 'Open'"
                                . ")";

                            $riIv = $cnx->query($iIv);
                            //echo $Row . "\n\n" . $iIv . "\n\n";

                        }

                        break;
                    case "MRPFile":
                        //echo "<p> $numero de campos en la línea $Row: <br /></p>\n";
                        $Row++;
                        for ($c=0; $c < $numero; $c++) {
                            $var = "C" . $c;
                            //echo $var . "\r\n";
                            //Lee el archivo
                            $$var = str_replace("\\", "", str_replace("\"", "", str_replace("'", "", $TFData[$c])));
                            $varant = "aC" . $c;

                            //Fechas
                            switch ($c){
                                case 23:
                                case 22:
                                case 16:
                                case 15:
                                case 14:
                                    if(empty($$var)){
                                        $$var = "2000-01-01";
                                    } else {
                                        $TempVal = $$var;
                                        $$var = date('Y-m-d', strtotime($TempVal));
                                    }
                                    break;
                            }

                            //Para Precios
                            switch ($c){
                                case 21:
                                case 17:
                                case 12:
                                case 10:
                                case 6:
                                case 7:
                                    if(empty($$var)){
                                        $$var = 0;
                                    } else {
                                        $TempVal = $$var;
                                        $$var = str_replace(",", "", $TempVal);
                                    }
                                    break;
                            }

                            $$varant = $$var;
                        }

                        //*echo "$C13 - $C14\n";

                        //Solo Price1 y Qty > 0
                        if(!empty($C0) && strlen($C0) < 20 && $C0 != 'Planner Code'){
                            //Busca el mayor valor
                            $iMRP = "INSERT INTO MRPData VALUE("
                                . "'0', '$C0', '$C1', '$C2', "
                                . "'$C3', '$C4', '$C5', '$C6', '$C7', "
                                . "'$C8', '$C9', '$C10', '$C11', '$C12', "
                                . "'$C13', '$C14', '$C15', '$C16', '$C17', "
                                . "'$C18', '$C19', '$C20', '$C21', '$C22', "
                                . "'$C23', '$C24', '$C25', '$dateToday', '$dtAhora', 'Open'"
                                . ")";

                            $riMRP = $cnx->query($iMRP);
                            //echo $Row . "\n\n" . $iMRP . "\n\n";

                        }


                        break;
                    case "PodFile":
                        //echo "<p> $numero de campos en la línea $Row: <br /></p>\n";
                        $Row++;

                        for ($c=0; $c < $numero; $c++) {
                            if($TFData[0] != "Buyer"){
                                $var = "C" . $c;
                                $$var = str_replace("\\", "", str_replace("\"", "", str_replace("'", "", $TFData[$c])));
                                $varant = "aC" . $c;
                                if(($c >= 0 && $c < 8) || ($c > 15 && $c < 21)){
                                    if(empty($$var)){
                                        $$var = "" . $$varant;
                                    }
                                }

                                //Fechas
                                if($c == 9 || $c == 13 || $c == 14 || $c == 20){
                                    if(empty($$var)){
                                        $$var = "2000-01-01";
                                    }
                                }

                                //Numeros
                                if($c == 8 || $c == 10 || $c == 11 || $c == 12){
                                    if(empty($$var)){
                                        $$var = 0;
                                    }
                                }

                                if($c == 12){
                                    $TempExtP = $$var;
                                    $$var = str_replace(",", "", $TempExtP);
                                }

                                //N echo $var . "-" . $$var . "<br />\n";
                                $$varant = $$var;
                            }
                        }

                        //Solo cantidad mayor a 0
                        if($C8 >= 0){
                            //Expected Delivery
                            $C9 = date('Y-m-d', strtotime($C9));
                            //Requested Delivery
                            $C13 = date('Y-m-d', strtotime($C13));
                            //Vendor Promise
                            $C14 = date('Y-m-d', strtotime($C14));
                            //Purchase Order
                            $C20 = date('Y-m-d', strtotime($C20));

                            if(!empty($C15) && substr($C15, 0, 2) == "1Z"){
                                $POCStatus = "Transit";
                            } else {
                                $C15x = strtolower($C15);
                                if(strpos($C15x, "ppv") !== false){
                                    $POCStatus = "PPV";
                                } else {
                                    if(strpos($C15x, "control") !== false){
                                        $POCStatus = "Control";
                                    } else {
                                        if(strpos($C15x, "control") !== false){
                                            $POCStatus = "Control";
                                        } else {
                                            if(strpos($C15x, "confirm") !== false){
                                                $POCStatus = "Confirm";
                                            } else {
                                                if(strpos($C15x, "ncnr") !== false){
                                                    $POCStatus = "NCNR";
                                                } else {
                                                    if(strpos($C15x, "csr") !== false){
                                                        $POCStatus = "CSR";
                                                    } else {
                                                        if(strpos($C15x, "quot") !== false){
                                                            $POCStatus = "Quoting";
                                                        } else {
                                                            if(strpos($C15x, "ship") !== false){
                                                                $POCStatus = "Shipped";
                                                            } else {
                                                                if(strpos($C15x, "obsolet") !== false){
                                                                    $POCStatus = "Obsolete";
                                                                } else {
                                                                    if(strpos($C15x, "payment") !== false){
                                                                        $POCStatus = "Payment";
                                                                    } else {
                                                                        if(strpos($C15x, "price") !== false){
                                                                            $POCStatus = "PPV";
                                                                        } else {
                                                                            $POCStatus = "Open";
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }

                                        }
                                    }
                                }
                            }

                            if($C3 != "226153" && $C3 != "232751"){
                                $iPod = "INSERT INTO PodData VALUE("
                                    . "'0', '$dtAhora', '$C0', '0', '', '$C1', '$C2', "
                                    . "'$C3', '$C4', '$C5', '', '$C6', '$C7', "
                                    . "'$C8', '$C9', '$C10', '$C11', '$C12', "
                                    . "'$C13', '$C14', '$C15', '$C16', '$C17', "
                                    . "'$C18', '$C19', '$C20', '0', '0', '0', '$dtAhora', '$dtAhora', '0', '', '$dtAhora', '', '$POCStatus'"
                                    . ")";
                                /*
                                if($Row < 10){
                                    echo $iPod . "\n\n";

                                }
                                */
                                $riPod = $cnx->query($iPod);

                                //$riPod = $cnx->query($iPod);
                            }

                        }

                        break;
                    case "PartsFile":

                        $Row++;

                        //echo "$Row - $numero - $iTemAnt - $iTem - \n";
                        if($Row > 1){
                            for ($c=0; $c < $numero; $c++) {
                                $var = "C" . $c;
                                $$var = str_replace("\\", "", str_replace("\"", "", str_replace("'", "", $TFData[$c])));
                                $varant = "aC" . $c;

                                if($c == 0){
                                    //echo "1 - $iTemAnt - $iTem\n\n";
                                    $iTem = "" . $$var;
                                    //echo "2 - $iTemAnt - $iTem\n\n";
                                }

                                //Fill in blancs
                                if(($c == 0 || $c == 2 || $c == 5 || ($c > 21 && $c < 28) || $c == 33 || $c == 19) && !empty($iTemAnt) && empty($iTem) && empty($$var)){
                                    //echo "4 - $iTemAnt - $iTem - $varant\n\n";
                                    $$var = "" . $$varant;
                                }

                                //Numeros
                                if($c == 4 || ($c > 5 && $c < 10) || ($c > 12 && $c < 22) || $c == 29 || $c == 31 ){
                                    if(empty($$var)){
                                        $$var = 0;
                                    }
                                }

                                //Fechas
                                if($c == 30 || $c == 32){
                                    if(empty($$var)){
                                        $$var = "2000-01-01";
                                    }
                                }

                                //echo $var . "-" . $$var . "<br />\n";
                                $$varant = $$var;
                                $iTemAnt = $C0;


                            }
                        }



                        //Solo cantidad mayor a 0
                        if($Row > 1){
                            //Last Activity
                            $C30 = date('Y-m-d', strtotime($C30));
                            //Last Rcpt Date
                            $C32 = date('Y-m-d', strtotime($C32));

                            //On_HAnd_Qty_Acctg
                            $C4 = str_replace(",", "", $C4);

                            $cACCTV = $C19;
                            $cPLT = $C18;
                            $cBIN = $C12;

                            if($cBIN == "B"){
                                $gTypePart = "D";
                            } else {
                                if($cACCTV >= 3 || $cPLT >= 180){
                                    $gTypePart = "A";
                                } else {
                                    if(($cACCTV >= .5 && $cACCTV < 3) || ($cPLT >= 90 && $cPLT < 180)){
                                        $gTypePart = "B";
                                    } else {
                                        $gTypePart = "C";
                                    }
                                }
                            }


                            $iPar = "INSERT INTO PartData VALUE("
                                . "'0', '$dtAhora', '$C0', '$C1', '$C2', "
                                . "'$C3', '$C4', '$C5', '$C6', '$C7', "
                                . "'$C8', '$C9', '$C10', '$C11', '$C12', "
                                . "'$C13', '$C14', '$C15', '$C16', '$C17', "
                                . "'$C18', '$C19', '$C20', '$C21', '$C22', "
                                . "'$C23', '$C24', '$C25', '$C26', '$C27', "
                                . "'$C28', '$C29', '$C30', '$C31', '$C32', "
                                . "'$C33', '$C34', '$C35', '$C36', '$C37', "
                                . "'$C38', '$C39', '$C40', "
                                . "'$gTypePart', '0', '', 'Open'"
                                . ")";
                            //echo $iPar . "\n\n";
                            if($C1 != "Grand Total" && $C4 != "------"){
                                $riPart = $cnx->query($iPar);
                            }

                            if($Row < 10){
                                //echo $iPar . "\n\n";
                            }

                        }
                        break;
                    case "BOMFile":
                        //echo "<p> $numero de campos en la línea $Row: <br /></p>\n";
                        $Row++;
                        for ($c=0; $c < $numero; $c++) {
                            $var = "C" . $c;
                            //echo $var . "\r\n";
                            //Lee el archivo
                            $$var = str_replace("\\", "", str_replace("\"", "", str_replace("'", "", $TFData[$c])));
                            $varant = "aC" . $c;

                            //Para Precios
                            switch ($c){
                                case 2:
                                case 3:
                                case 4:
                                case 5:
                                case 6:
                                case 9:
                                case 16:
                                case 17:
                                    //Sin espacios
                                    $TempVal = $$var;
                                    $$var = str_replace(" ", "", $TempVal);
                                    break;
                                case 7:
                                case 8:
                                case 10:
                                case 11:
                                case 12:
                                case 13:
                                case 14:
                                case 15:
                                    if(empty($$var)){
                                        $$var = 0;
                                    } else {
                                        $TempVal = $$var;
                                        $$var = str_replace(",", "", $TempVal);
                                    }
                                    break;
                            }


                            /*
                             * VALOR ANTERIOR
                            if(($c >= 0 && $c < 13) || ($c > 15)){
                                if(empty($$var)){
                                    $$var = "" . $$varant;
                                }
                            }
                             * 
                            if($Row < 10){
                                echo $Row . "***" . $var . "-" . $$var . "\n";
                            }
                             * 
                             * */



                            $$varant = $$var;
                        }

                        //*echo "$C13 - $C14\n";

                        //Solo Price1 y Qty > 0
                        if(strtolower($C4) != "item_nbr" && !empty($C4)){
                            //Busca el mayor valor
                            $iBOM = "INSERT INTO BOM VALUE("
                                . "'0', '$C1', '$C2', '$C3', "
                                . "'$C4', '$C5', '$C6', '$C7', '$C8', "
                                . "'$C9', '$C10', '$C11', '$C12', '$C13', "
                                . "'$C14', '$C15', '$C16', '$C17'"
                                . ")";

                            $riBOM = $cnx->query($iBOM);
                            //echo $iBOM . "\n\n" . $iHQuote . "\n\n";

                        }


                        break;
                    case "BOMFileAnt":
                        //echo "<p> $numero de campos en la línea $Row: <br /></p>\n";
                        $Row++;
                        for ($c=0; $c < $numero; $c++) {
                            $var = "C" . $c;
                            //echo $var . "\r\n";
                            //Lee el archivo
                            $$var = str_replace("\\", "", str_replace("\"", "", str_replace("'", "", $TFData[$c])));
                            $varant = "aC" . $c;

                            //Para Precios
                            switch ($c){
                                case 6:
                                case 7:
                                case 9:
                                case 10:
                                case 11:
                                case 12:
                                case 13:
                                case 14:
                                    if(empty($$var)){
                                        $$var = 0;
                                    } else {
                                        $TempVal = $$var;
                                        $$var = str_replace(",", "", $TempVal);
                                    }
                                    break;
                            }


                            /*
                             * VALOR ANTERIOR
                            if(($c >= 0 && $c < 13) || ($c > 15)){
                                if(empty($$var)){
                                    $$var = "" . $$varant;
                                }
                            }
                             * 
                            if($Row < 10){
                                echo $Row . "***" . $var . "-" . $$var . "\n";
                            }
                             * 
                             * */



                            $$varant = $$var;
                        }

                        //*echo "$C13 - $C14\n";

                        //Solo Price1 y Qty > 0
                        if($C9 > 0){
                            //Busca el mayor valor
                            $iBOM = "INSERT INTO BOM VALUE("
                                . "'0', '$C0', '$C1', '$C2', "
                                . "'$C3', '$C4', '$C5', '$C6', '$C7', "
                                . "'$C8', '$C9', '$C10', '$C11', '$C12', "
                                . "'$C13', '$C14', '$C15', '$C16'"
                                . ")";

                            $riBOM = $cnx->query($iBOM);
                            //echo $Row . "\n\n" . $iHQuote . "\n\n";

                        }


                        break;
                    case "OverIssue":
                        //echo "<p> $numero de campos en la línea $Row: <br /></p>\n";
                        $Row++;
                        for ($c=0; $c < $numero; $c++) {
                            $var = "C" . $c;
                            //echo $var . "\r\n";
                            //Lee el archivo
                            $$var = str_replace("\\", "", str_replace("\"", "", str_replace("'", "", $TFData[$c])));
                            $varant = "aC" . $c;

                            //Para Precios
                            switch ($c){
                                case 2:
                                case 3:
                                case 5:
                                case 6:
                                    if(empty($$var)){
                                        $$var = 0;
                                    } else {
                                        $TempVal = $$var;
                                        $$var = str_replace(",", "", $TempVal);
                                    }
                                    break;
                            }

                            $$varant = $$var;
                        }

                        //*echo "$C13 - $C14\n";

                        //Solo Price1 y Qty > 0
                        if($C6 > 0){
                            //Busca el mayor valor
                            $iOverIssue = "INSERT INTO OverIssue VALUE("
                                . "'0', '$C0', '$C1', '$C2', "
                                . "'$C3', '$C4', '$C5', '$C6', '$C7', "
                                . "'$C8'"
                                . ")";

                            $riOverIssue = $cnx->query($iOverIssue);
                            //echo $Row . "\n\n" . $iHQuote . "\n\n";

                        }


                        break;
                    case "QuotesHistory":
                        //*echo "<p> $numero de campos en la línea $Row: <br /></p>\n";
                        $Row++;
                        for ($c=0; $c < $numero; $c++) {
                            $var = "C" . $c;
                            //Lee el archivo
                            $$var = str_replace("\\", "", str_replace("\"", "", str_replace("'", "", $TFData[$c])));
                            $varant = "aC" . $c;

                            //Para Fechas
                            if($c == 7 || $c == 8){
                                if(empty($$var)){
                                    $$var = "2021-01-01";
                                } else {
                                    $TempDate = $$var;
                                    $$var = date('Y-m-d', strtotime($TempDate));
                                }
                            }

                            //Para Precios
                            if($c > 8 && $c < 27){
                                if(empty($$var)){
                                    $$var = 0;
                                } else {
                                    $TempVal = $$var;
                                    $$var = str_replace(",", "", $TempVal);
                                }
                            }


                            /*
                             * VALOR ANTERIOR
                            if(($c >= 0 && $c < 13) || ($c > 15)){
                                if(empty($$var)){
                                    $$var = "" . $$varant;
                                }
                            }
                             * 
                            if($Row < 10){
                                echo $Row . "***" . $var . "-" . $$var . "\n";
                            }
                             * 
                             * */



                            $$varant = $$var;
                        }

                        //*echo "$C13 - $C14\n";

                        //Solo Price1 y Qty > 0
                        if($C14 > 0 && !empty($C14) && strtolower($C14) != "price1"){
                            //Busca el mayor valor
                            $MaxQty = max($C13, $C15, $C17, $C19, $C21, $C23, $C25);
                            $Prices = array($C14, $C16, $C18, $C20, $C22, $C24, $C26);
                            $MinPrice = min(array_filter($Prices));
                            $TotalEst = $MaxQty * $MinPrice;

                            $iHQuote = "INSERT INTO Quotes VALUE("
                                . "'0', '$C0', '$C1', '$C2', "
                                . "'$C3', '$C4', '$C5', '$C6', '$C7', "
                                . "'$C8', '$C9', '$C10', '$C11', '$C12', "
                                . "'$C13', '$C14', '$C15', '$C16', '$C17', "
                                . "'$C18', '$C19', '$C20', '$C21', '$C22', '$C23', "
                                . "'$C24', '$C25', '$C26', '$C27', '$MinPrice', '$MaxQty', '$TotalEst', "
                                . "'$dtAhora', '$TF_idFiles', '$TF_idUser'"
                                . ")";

                            $riHQuote = $cnx->query($iHQuote);
                            //*echo $Row . "\n\n" . $iHQuote . "\n\n";

                        }


                        break;
                    case "PODemand":
                        //echo "<p> $numero de campos en la línea $Row: <br /></p>\n";
                        $Row++;
                        for ($c=0; $c < $numero; $c++) {
                            $var = "C" . $c;
                            //echo $var . "\r\n";
                            //Lee el archivo
                            $$var = str_replace("\\", "", str_replace("\"", "", str_replace("'", "", $TFData[$c])));
                            $varant = "aC" . $c;

                            //Para Precios y Fechas
                            switch ($c){
                                case 7:
                                case 8:
                                case 9:
                                case 10:
                                case 11:
                                case 12:
                                case 13:
                                case 14:
                                case 15:
                                case 16:
                                case 17:
                                case 18:
                                case 20:
                                case 21:
                                case 23:
                                case 24:
                                    //Enteros
                                    if(empty($$var)){
                                        $$var = 0;
                                    } else {
                                        $TempVal = $$var;
                                        $$var = str_replace("$", "", str_replace(",", "", str_replace(" ", "", $TempVal)));
                                    }
                                    break;
                                case 19:
                                    //Fechas
                                    if(empty($$var)){
                                        $$var = "2000-01-01";
                                    } else {
                                        $TempVal = $$var;
                                        $$var = date('Y-m-d', strtotime($TempVal));
                                    }
                                    break;
                                case 2:
                                    //Commentarios
                                    if(empty($$var)){
                                        $$var = "";
                                    } else {
                                        $TempVal = $$var;
                                        $$var = str_replace("\'", "", str_replace('\"', "", $TempVal));
                                    }
                                    break;
                                default :
                                    break;
                            }

                            $$varant = $$var;
                        }

                        $reqTotal = $porc = 0;


                        if(!empty($C0) && $C0 != "Class_Data" && $C0 != "No se han aplicado filtros"){
                            //Busca el Parts
                            $sPart = "SELECT Vendor_Id, Mfgr_Name FROM PartData WHERE Item_Number = '$C1' ORDER BY Item_Number DESC LIMIT 0, 1";
                            $nPart = $cnx->query($sPart)->numRows();
                            if($nPart == 1){
                                $rPart = $cnx->query($sPart)->fetchArray();
                                $gVID = $rPart['Vendor_Id'];
                                $gVend = $rPart['Mfgr_Name'];
                            } else {
                                $gVID = "";
                                $gVend = "";
                            }

                            $reqTotal = $C11 + $C13 + $C14 + $C15;
                            if($C10 > 0){
                                $porc = (($reqTotal * 100) / $C10);
                            } else {
                                $porc = 0;
                            }


                            $iPOD = "INSERT INTO PODemand VALUE("
                                . "'0', '$C0', '$C1', '$C2', '$C3', '$C4', '$C5', "
                                . "'$C6', '$C7', '$C8', '$C9', '$C10', "
                                . "'$C11', '$C12', '$C13', '$C14', '$C15', "
                                . "'$C16', '$C17', '$C18', '$C19', '$C20', "
                                . "'$C21', '$C22', '$C23', '$C24', '$dtAhora', "
                                . "'', '', '$gVID', '$gVend', '$reqTotal', '$porc'"
                                . ")";
                            //echo $iPOD . "\n\n";
                            $riPOD = $cnx->query($iPOD);
                            //echo "$C0 - $C1 - $C2 - $C3 - $C19 - $C20 - $C21 - $C22 - $C23 - $C24 - $gVID - $gVend\n";
                        }

                        break;
                    default :
                        echo "Not Option";
                        break;
                endswitch;


            }
            fclose($Gestor);
        }

        //Scripts ultimos
        switch ($TF_TFile){
            case "BOMFile":
                //Qty
                $sQtyLines = "SELECT MAX(idBOM) AS qtylines FROM BOM";
                $rQtyLines = $cnx->query($sQtyLines)->fetchArray();
                $QtyLines = $rQtyLines['qtylines'];

                //Envia correo electronico
                //$logoDash = "http://intranet.masterworkelectronics.com/Images/Dashboard50.png";
                $MessPrincipal = "<table width=\'100%\' cellpadding=\'0\' cellspacing=\'0\'>"
                    . "<tr><td width=\'50%\'>"
                    . "<font style=\'font-size:3em;\'><b>$TF_TFile Uploaded</b></font><BR>"
                    . "<font style=\'color:gray;\'>Qty of Lines: $QtyLines</font><BR>"
                    . "<font style=\'color:gray;\'>Updated On: $dtAhora</font>"
                    . "</td><td>&nbsp;</td>"
                    . "<td align=\'center\' width=\'150\'><a href=\'http://mex-mds-001/Supply/Include/reportCSV.php?report=$TF_TFile\' target=\'_blank\'>"
                    . "<img src=\'$logoExcel\'><br>File Download</a>"
                    . "<br><br></td></tr></table>";

                $MessMail = $MessPrincipal;

                $AppInfo = "App: <B>Upload $TF_TFile</B><BR>Site: <a href=\'http://mex-mds-001/Supply/\'>Supply Site</a><BR>Date: <b>$dtAhora</b>";
                $SubjectEmail = "(MDS) Upload $TF_TFile";
                $ToEmail = "alejandro.ochoa@masterworkelectronics.com, alejandra.pena@masterworkelectronics.com, mario.chavez@masterworkelectronics.com";
                //$ToEmail = "mario.chavez@masterworkelectronics.com";
                $FromEmail = "btb@masterworkelectronics.com";

                //Manda Correo
                $iEmail = "INSERT INTO dbEmail VALUES('0', '$AppInfo', '$SubjectEmail', '$ToEmail', '$FromEmail', '$MessMail', '$FromEmail', '$dtAhora', '', 'Open')";
                $rEmail = $cnx->query($iEmail);
                break;
            case "OverIssue":
                //Qty
                $sQtyLines = "SELECT MAX(idOverIssue) AS qtylines FROM OverIssue";
                $rQtyLines = $cnx->query($sQtyLines)->fetchArray();
                $QtyLines = $rQtyLines['qtylines'];

                //Envia correo electronico
                //$logoDash = "http://intranet.masterworkelectronics.com/Images/Dashboard50.png";
                $MessPrincipal = "<table width=\'100%\' cellpadding=\'0\' cellspacing=\'0\'>"
                    . "<tr><td width=\'50%\'>"
                    . "<font style=\'font-size:3em;\'><b>$TF_TFile Uploaded</b></font><BR>"
                    . "<font style=\'color:gray;\'>Qty of Lines: $QtyLines</font><BR>"
                    . "<font style=\'color:gray;\'>Updated On: $dtAhora</font>"
                    . "</td><td>&nbsp;</td>"
                    . "<td align=\'center\' width=\'150\'><a href=\'http://mex-mds-001/Supply/Include/reportCSV.php?report=$TF_TFile\' target=\'_blank\'>"
                    . "<img src=\'$logoExcel\'><br>File Download</a>"
                    . "<br><br></td></tr></table>";

                $MessMail = $MessPrincipal;

                $AppInfo = "App: <B>Upload $TF_TFile</B><BR>Site: <a href=\'http://mex-mds-001/Supply/\'>Supply Site</a><BR>Date: <b>$dtAhora</b>";
                $SubjectEmail = "(MDS) Upload $TF_TFile";
                $ToEmail = "alejandro.ochoa@masterworkelectronics.com, alejandra.pena@masterworkelectronics.com";
                //$ToEmail = "mario.chavez@masterworkelectronics.com";
                $FromEmail = "btb@masterworkelectronics.com";

                //Manda Correo
                $iEmail = "INSERT INTO dbEmail VALUES('0', '$AppInfo', '$SubjectEmail', '$ToEmail', '$FromEmail', '$MessMail', '$FromEmail', '$dtAhora', '', 'Open')";
                $rEmail = $cnx->query($iEmail);
                break;
            case "PartsFile":
                //Qty
                $sQtyLines = "SELECT MAX(idPartData) AS qtylines FROM PartData";
                $rQtyLines = $cnx->query($sQtyLines)->fetchArray();
                $QtyLines = $rQtyLines['qtylines'];

                //Envia correo electronico
                //$logoDash = "http://intranet.masterworkelectronics.com/Images/Dashboard50.png";
                $MessPrincipal = "<table width=\'100%\' cellpadding=\'0\' cellspacing=\'0\'>"
                    . "<tr><td width=\'50%\'>"
                    . "<font style=\'font-size:3em;\'><b>$TF_TFile Uploaded</b></font><BR>"
                    . "<font style=\'color:gray;\'>Qty of Lines: $QtyLines</font><BR>"
                    . "<font style=\'color:gray;\'>Updated On: $dtAhora</font>"
                    . "</td><td>&nbsp;</td>"
                    . "<td align=\'center\' width=\'150\'><a href=\'http://mex-mds-001/Supply/Include/reportCSV.php?report=$TF_TFile\' target=\'_blank\'>"
                    . "<img src=\'$logoExcel\'><br>File Download</a>"
                    . "<br><br></td></tr></table>";

                $MessMail = $MessPrincipal;

                $AppInfo = "App: <B>Upload $TF_TFile</B><BR>Site: <a href=\'http://mex-mds-001/Supply/\'>Supply Site</a><BR>Date: <b>$dtAhora</b>";
                $SubjectEmail = "(MDS) Upload $TF_TFile";
                $ToEmail = "alejandro.ochoa@masterworkelectronics.com, alejandra.pena@masterworkelectronics.com";
                //$ToEmail = "mario.chavez@masterworkelectronics.com";
                $FromEmail = "btb@masterworkelectronics.com";

                //Manda Correo
                $iEmail = "INSERT INTO dbEmail VALUES('0', '$AppInfo', '$SubjectEmail', '$ToEmail', '$FromEmail', '$MessMail', '$FromEmail', '$dtAhora', '', 'Open')";
                $rEmail = $cnx->query($iEmail);
                break;
            case "WOPlanner":
                //Qty
                $sQtyLines = "SELECT MAX(idWOPlanner) AS qtylines FROM WOPlanner";
                $rQtyLines = $cnx->query($sQtyLines)->fetchArray();
                $QtyLines = $rQtyLines['qtylines'];

                //Envia correo electronico
                //$logoDash = "http://intranet.masterworkelectronics.com/Images/Dashboard50.png";
                $MessPrincipal = "<table width=\'100%\' cellpadding=\'0\' cellspacing=\'0\'>"
                    . "<tr><td width=\'50%\'>"
                    . "<font style=\'font-size:3em;\'><b>$TF_TFile Uploaded</b></font><BR>"
                    . "<font style=\'color:gray;\'>Qty of Lines: $QtyLines</font><BR>"
                    . "<font style=\'color:gray;\'>Updated On: $dtAhora</font>"
                    . "</td><td>&nbsp;</td>"
                    . "<td align=\'center\' width=\'150\'><a href=\'http://mex-mds-001/Supply/Include/reportCSV.php?report=$TF_TFile\' target=\'_blank\'>"
                    . "<img src=\'$logoExcel\'><br>File Download</a>"
                    . "<br><br></td></tr></table>";

                $MessMail = $MessPrincipal;

                $AppInfo = "App: <B>Upload $TF_TFile</B><BR>Site: <a href=\'http://mex-mds-001/Supply/\'>Supply Site</a><BR>Date: <b>$dtAhora</b>";
                $SubjectEmail = "(MDS) Upload $TF_TFile";
                //$ToEmail = "mario.chavez@masterworkelectronics.com, andrea@masterworkelectronics.com, alejandra.pena@masterworkelectronics.com";
                $ToEmail = "ITSystems@masterworkelectronics.com";
                $FromEmail = "btb@masterworkelectronics.com";

                //Manda Correo
                $iEmail = "INSERT INTO dbEmail VALUES('0', '$AppInfo', '$SubjectEmail', '$ToEmail', '$FromEmail', '$MessMail', '$FromEmail', '$dtAhora', '', 'Open')";
                $rEmail = $cnx->query($iEmail);
                break;
            case "InvDetail":
                //Qty
                $sQtyLines = "SELECT MAX(idInvDetail) AS qtylines FROM InvDetail";
                $rQtyLines = $cnx->query($sQtyLines)->fetchArray();
                $QtyLines = $rQtyLines['qtylines'];

                //Envia correo electronico
                //$logoDash = "http://intranet.masterworkelectronics.com/Images/Dashboard50.png";
                $MessPrincipal = "<table width=\'100%\' cellpadding=\'0\' cellspacing=\'0\'>"
                    . "<tr><td width=\'50%\'>"
                    . "<font style=\'font-size:3em;\'><b>$TF_TFile Uploaded</b></font><BR>"
                    . "<font style=\'color:gray;\'>Qty of Lines: $QtyLines</font><BR>"
                    . "<font style=\'color:gray;\'>Updated On: $dtAhora</font>"
                    . "</td><td>&nbsp;</td>"
                    . "<td align=\'center\' width=\'150\'><a href=\'http://mex-mds-001/Supply/Include/reportCSV.php?report=$TF_TFile\' target=\'_blank\'>"
                    . "<img src=\'$logoExcel\'><br>File Download</a>"
                    . "<br><br></td></tr></table>";

                $MessMail = $MessPrincipal;

                $AppInfo = "App: <B>Upload $TF_TFile</B><BR>Site: <a href=\'http://mex-mds-001/Supply/\'>Supply Site</a><BR>Date: <b>$dtAhora</b>";
                $SubjectEmail = "(MDS) Upload $TF_TFile";
                $ToEmail = "alejandro.ochoa@masterworkelectronics.com, alejandra.pena@masterworkelectronics.com";
                //$ToEmail = "mario.chavez@masterworkelectronics.com";
                $FromEmail = "btb@masterworkelectronics.com";

                //Manda Correo
                $iEmail = "INSERT INTO dbEmail VALUES('0', '$AppInfo', '$SubjectEmail', '$ToEmail', '$FromEmail', '$MessMail', '$FromEmail', '$dtAhora', '', 'Open')";
                $rEmail = $cnx->query($iEmail);
                break;
            case "MRPFile":
                //Valida Cancel
                $sCancel = "SELECT *  FROM MRPData WHERE Action_Message LIKE 'Cancel' AND Lead_Time_Code LIKE 'P' AND Reference NOT LIKE '9CN%' ORDER BY Item_Nbr ASC, Reference ASC";
                $rCancel = $cnx->query($sCancel)->fetchAll();

                foreach ($rCancel AS &$rC){
                    //Data
                    $gPlanner_Code = $rC['Planner_Code'];
                    $gBuyer = $rC['Buyer'];
                    $gItem_Nbr = $rC['Item_Nbr'];
                    $gPhantom_Code = $rC['Phantom_Code'];
                    $gDescription = $rC['Description'];
                    $gUM = $rC['UM'];
                    $gUnit_Cost = $rC['Unit_Cost'];
                    $gLead_Time = $rC['Lead_Time'];
                    $gAction_Message = $rC['Action_Message'];
                    $gType = $rC['Type'];
                    $gPlan_Seq = $rC['Plan_Seq'];
                    $gReference = $rC['Reference'];
                    $DataR = explode("*", $gReference);
                    $gPO = $DataR[0];
                    $gDataR1 = $DataR[1];
                    $gDataR2 = $DataR[2];
                    $gQty_Required = $rC['Qty_Required'];
                    $gTransit_LT = $rC['Transit_LT'];
                    $gSuggested_Date_To_Order = $rC['Suggested_Date_To_Order'];
                    $gSuggested_Due_Date = $rC['Suggested_Due_Date'];
                    $gOriginal_Due_Date = $rC['Original_Due_Date'];
                    $gOver_Issue = $rC['Over_Issue'];
                    $gClass_Code = $rC['Class_Code'];
                    $gLead_Time_Code = $rC['Lead_Time_Code'];
                    $gPO_Vend_Id = $rC['PO_Vend_Id'];
                    $gLead_Time2 = $rC['Lead_Time2'];
                    $gCPU_Add_Date = $rC['CPU_Add_Date'];
                    $gVen_Promise_Date = $rC['Ven_Promise_Date'];
                    $gTracking_Nbr = $rC['Tracking_Nbr'];
                    $gLong_Part_Nbr = $rC['Long_Part_Nbr'];
                    $gdateCreated = $rC['dateCreated'];
                    $gdtCreated = $rC['dtCreated'];
                    $gStatus = $rC['Status'];

                    //Verifica existe
                    $sEx = "SELECT idMRP FROM MRPCancel WHERE Item_Nbr = '$gItem_Nbr' AND Reference = '$gReference' ORDER BY Reference ASC LIMIT 0, 1";
                    $nEx = $cnx->query($sEx)->numRows();

                    if($nEx == 1){
                        $rEx = $cnx->query($sEx)->fetchArray();
                        $MRP_idMRP = $rEx['idMRP'];
                        $MRP_Status = $rEx['Status'];
                        $MRP_PO = $rEx['PO'];
                        $MRP_Reference = $rEx['Reference'];
                        //Valida status
                        if($MRP_Status == "Closed"){
                            $nStatus = "Open";
                            //Se vuelve a abrir
                            $uCMRP = "UPDATE MRPCancel SET Status = '$nStatus', dateROI = '$dateToday', StatusROI = 'Open' WHERE idMRP = '$MRP_idMRP'";
                            //Agrega Log
                            $iLog = "INSERT INTO MRPLogs VALUES ("
                                    . "'0', '$MRP_idMRP', '$MRP_PO', 'ReOpen', '', "
                                    . "'$dtAhora', '0', 'MDS System', '$dtAhora', 'Open')";
                            $rLog = $cnx->query($iLog);

                        } else {
                            $uCMRP = "UPDATE MRPCancel SET dateROI = '$dateToday', StatusROI = 'Open' WHERE idMRP = '$MRP_idMRP'";
                        }

                        $rCMRP = $cnx->query($uCMRP);

                    } else {
                        //Agrega
                        //ID Cancel
                        $sID = "SELECT MAX(idMRP) AS mid FROM MRPCancel";
                        $rID = $cnx->query($sID)->fetchArray();
                        $gIDCancel = $rID['mid'] + 1;
                        $IDCancel = "CL" . str_pad($gIDCancel, 8, "0", STR_PAD_LEFT);


                        $iNewMRP = "INSERT INTO MRPCancel VALUES ("
                                . "'$gIDCancel', '$IDCancel', '$gPlanner_Code', '$gBuyer', '0', '', "
                                . "'0', '', '$gItem_Nbr', '$gPhantom_Code', '$gDescription', "
                                . "'$gUM', '$gUnit_Cost', '$gLead_Time', '$gAction_Message', '$gType', "
                                . "'$gPlan_Seq', '$gReference', '$gPO', '$gDataR1', '$gDataR2', "
                                . "'$gQty_Required', '$gTransit_LT', '$gSuggested_Date_To_Order', '$gSuggested_Due_Date', '$gOriginal_Due_Date', "
                                . "'$gOver_Issue', '$gClass_Code', '', '$gLead_Time_Code', '$gPO_Vend_Id', '', '$gLead_Time2', "
                                . "'$gCPU_Add_Date', '$gVen_Promise_Date', '$gTracking_Nbr', '$gLong_Part_Nbr', '$gdateCreated', "
                                . "'$gdtCreated', '2000-01-01', '0', '', '2000-01-01', "
                                . "'0', '', 'Open', '$gdateCreated', 'Open'"
                                . ")";
                        //echo $iNewMRP . "\r\n";

                        $riNew = $cnx->query($iNewMRP);

                        $iLog = "INSERT INTO MRPLogs VALUES ("
                                . "'0', '$gIDCancel', '$gPO', 'Created', '', "
                                . "'$dtAhora', '0', 'MDS System', '$dtAhora', 'Open')";
                        $rLog = $cnx->query($iLog);

                    }


                }

                //Actualiza leader y buyer
                //Actualiza los Buyer
                $sDB = "SELECT DISTINCT Buyer FROM MRPCancel ORDER BY Buyer ASC";
                $lDB = $cnx->query($sDB)->fetchAll();

                foreach ($lDB as &$DBuy) {
                    $gBuy = $DBuy['Buyer'];

                    if(!empty($gBuy)){
                        $sBuy1 = "SELECT * FROM Users WHERE IDExtra LIKE '$gBuy' ORDER BY IDExtra ASC LIMIT 0, 1";
                        $nBuy1 = $cnx->query($sBuy1)->numRows();

                        if($nBuy1 == 1){
                            $rBuy = $cnx->query($sBuy1)->fetchArray();
                            $g_IDOwner = $rBuy['IDUser'];
                            $g_Owner = $rBuy['Name'] . " " . $rBuy['FLastName'];
                            $g_IDLeader = $rBuy['idSupervisor'];

                        } else {
                            $bBuyer = $gBuy . ",";
                            //$sBuy2 = "SELECT * FROM Users WHERE IDExtra LIKE '%$bBuyer%' ORDER BY IDExtra ASC LIMIT 0, 1";
                            $sBuy2 = "SELECT * FROM Users WHERE IDExtra LIKE '$bBuyer%' OR IDExtra LIKE ',$bBuyer%' ORDER BY IDExtra ASC LIMIT 0, 1";
                            $nBuy2 = $cnx->query($sBuy2)->numRows();
                            if($nBuy2 == 1){
                                $rBuy2 = $cnx->query($sBuy2)->fetchArray();
                                $g_IDOwner = $rBuy2['IDUser'];
                                $g_Owner = $rBuy2['Name'] . " " . $rBuy2['FLastName'];
                                $g_IDLeader = $rBuy2['idSupervisor'];
                            } else {
                                $bBuyer2 = "," . $gBuy;
                                //$sBuy3 = "SELECT * FROM Users WHERE IDExtra LIKE '%$bBuyer2%' ORDER BY IDExtra ASC LIMIT 0, 1";
                                $sBuy3 = "SELECT * FROM Users WHERE IDExtra LIKE '%$bBuyer2' ORDER BY IDExtra ASC LIMIT 0, 1";
                                $nBuy3 = $cnx->query($sBuy3)->numRows();
                                if($nBuy3 == 1){
                                    $rBuy3 = $cnx->query($sBuy3)->fetchArray();
                                    $g_IDOwner = $rBuy3['IDUser'];
                                    $g_Owner = $rBuy3['Name'] . " " . $rBuy3['FLastName'];
                                    $g_IDLeader = $rBuy3['idSupervisor'];
                                } else {
                                    $g_IDOwner = "3";
                                    $g_Owner = "Andrea Barranco";
                                }


                            }

                        }

                    } else {
                        $g_IDOwner = 3;
                        $g_Owner = "Andrea Barranco";
                        $g_IDLeader = 2;
                    }

                    $sSup = "SELECT * FROM Users WHERE IDUser = '$g_IDLeader' ORDER BY IDUser ASC LIMIT 0, 1";
                    $rSup = $cnx->query($sSup)->fetchArray();
                    $g_Leader = $rSup['Name'] . " " . $rSup['FLastName'];

                    //Actualiza el MRPCancel
                    $uMRPC = "UPDATE MRPCancel SET "
                        . "IDBuyer = '$g_IDOwner', BuyerName = '$g_Owner', "
                        . "IDLeader = '$g_IDLeader', LeaderName = '$g_Leader' "
                        . "WHERE Buyer = '$gBuy'";
                    $rMRPC = $cnx->query($uMRPC);

                }

                //Actualiza customer
                $sDBx = "SELECT DISTINCT Class_Code FROM MRPCancel WHERE Class_Code != '' ORDER BY Class_Code ASC";
                $lDBx = $cnx->query($sDBx)->fetchAll();

                foreach ($lDBx as &$DBuyx) {
                    $gCC = $DBuyx['Class_Code'];
                    $g_Customer = "";

                    if(!empty($gCC)){
                        //OBtiene nombre Customer
                        $sCust = "SELECT CustomerCode, CustomerName FROM Customers WHERE CustomerCode = '$gCC' ORDER BY CustomerCode ASC LIMIT 0, 1";
                        $nCust = $cnx->query($sCust)->numRows();
                        if($nCust == 1){
                            $LCust = $cnx->query($sCust)->fetchArray();
                            $g_Customer = ucwords(strtolower($LCust['CustomerName']));
                        } else {
                            $g_Customer = "";
                        }
                    }

                    //Actualiza el PodData
                    $uPdB = "UPDATE MRPCancel SET Customer = '$g_Customer' WHERE Class_Code = '$gCC'";
                    $rPdB = $cnx->query($uPdB);
                    //echo $uPdB . "<BR>";


                }

                //Actualiza Vendor
                $sVen = "SELECT DISTINCT PO_Vend_Id FROM MRPCancel WHERE PO_Vend_Id != '' ORDER BY PO_Vend_Id ASC";
                $rVen = $cnx->query($sVen)->fetchAll();

                foreach ($rVen as &$rV) {
                    $gVendorID = $rV['PO_Vend_Id'];
                    $gVendor = "";

                    if(!empty($gVendorID)){
                        //OBtiene nombre Customer
                        $svend = "SELECT VendorName FROM VendorCodes WHERE VendorCode = '$gVendorID' ORDER BY VendorName DESC LIMIT 0, 1";
                        $nvend = $cnx->query($svend)->numRows();
                        if($nvend == 1){
                            $Lven = $cnx->query($svend)->fetchArray();
                            $gVendor = $Lven['VendorName'];
                        } else {
                            $gVendor = "";
                        }
                    }

                    //Actualiza el PodData
                    $uV = "UPDATE MRPCancel SET Vendor = '$gVendor' WHERE PO_Vend_Id = '$gVendorID'";
                    $rVx = $cnx->query($uV);
                    //echo $uPdB . "<BR>";


                }

                break;
            case "BOMFile":
                //Agrega el Class Code
                $sCC = "SELECT DISTINCT Parent_Part_Assembly FROM BOM ORDER BY Parent_Part_Assembly ASC";
                $rCC = $cnx->query($sCC)->fetchAll();

                foreach ($rCC AS &$rC){
                    //Datos
                    $Ass = $rC['Parent_Part_Assembly'];

                    //Part Data
                    $sPD = "SELECT Class_Code FROM PartData WHERE Item_Number = '$Ass'";
                    $nPD = $cnx->query($sPD)->numRows();

                    if($nPD == 1){
                        $rPD = $cnx->query($sPD)->fetchArray();
                        $CC = $rPD['Class_Code'];
                        //Actualiza BOM
                        $uBOM = "UPDATE BOM SET Class_Code = '$CC' WHERE Parent_Part_Assembly = '$Ass'";
                        $rBOM = $cnx->query($uBOM);

                    } else {
                        $CC = "";
                    }

                }

                break;
            case "PODemand":
                //Actualiza los Customers
                $sDBx = "SELECT DISTINCT Class_Data FROM PODemand WHERE Class_Data != '' ORDER BY Class_Data ASC";
                $lDBx = $cnx->query($sDBx)->fetchAll();

                foreach ($lDBx as &$DBuyx) {
                    $gCC = $DBuyx['Class_Data'];

                    if(!empty($gCC)){
                        //OBtiene nombre Customer
                        $sCust = "SELECT CustomerCode, CustomerName FROM Customers WHERE CustomerCode = '$gCC' ORDER BY CustomerCode ASC LIMIT 0, 1";
                        $nCust = $cnx->query($sCust)->numRows();
                        if($nCust == 1){
                            $LCust = $cnx->query($sCust)->fetchArray();
                            $g_Customer = ucwords(strtolower($LCust['CustomerName']));
                        } else {
                            $g_Customer = "";
                        }
                    }

                    //Actualiza el PodData
                    $uPdB = "UPDATE PODemand SET Customer = '$g_Customer' WHERE Class_Data = '$gCC'";
                    $rPdB = $cnx->query($uPdB);
                    //echo $uPdB . "<BR>";


                }

                //Actualiza los Buyer
                $sDB = "SELECT DISTINCT BuyerCode FROM PODemand ORDER BY BuyerCode ASC";
                $lDB = $cnx->query($sDB)->fetchAll();

                foreach ($lDB as &$DBuy) {
                    $gBuy = $DBuy['BuyerCode'];

                    if(!empty($gBuy)){
                        $sBuy1 = "SELECT * FROM Users WHERE IDExtra LIKE '$gBuy' ORDER BY IDExtra ASC LIMIT 0, 1";
                        $nBuy1 = $cnx->query($sBuy1)->numRows();

                        if($nBuy1 == 1){
                            $rBuy = $cnx->query($sBuy1)->fetchArray();
                            $g_IDOwner = $rBuy['IDUser'];
                            $g_Owner = $rBuy['Name'] . " " . $rBuy['FLastName'];

                        } else {
                            $bBuyer = $gBuy . ",";
                            //$sBuy2 = "SELECT * FROM Users WHERE IDExtra LIKE '%$bBuyer%' ORDER BY IDExtra ASC LIMIT 0, 1";
                            $sBuy2 = "SELECT * FROM Users WHERE IDExtra LIKE '$bBuyer%' OR IDExtra LIKE ',$bBuyer%' ORDER BY IDExtra ASC LIMIT 0, 1";
                            $nBuy2 = $cnx->query($sBuy2)->numRows();
                            if($nBuy2 == 1){
                                $rBuy2 = $cnx->query($sBuy2)->fetchArray();
                                $g_IDOwner = $rBuy2['IDUser'];
                                $g_Owner = $rBuy2['Name'] . " " . $rBuy2['FLastName'];
                            } else {
                                $bBuyer2 = "," . $gBuy;
                                //$sBuy3 = "SELECT * FROM Users WHERE IDExtra LIKE '%$bBuyer2%' ORDER BY IDExtra ASC LIMIT 0, 1";
                                $sBuy3 = "SELECT * FROM Users WHERE IDExtra LIKE '%$bBuyer2' ORDER BY IDExtra ASC LIMIT 0, 1";
                                $nBuy3 = $cnx->query($sBuy3)->numRows();
                                if($nBuy3 == 1){
                                    $rBuy3 = $cnx->query($sBuy3)->fetchArray();
                                    $g_IDOwner = $rBuy3['IDUser'];
                                    $g_Owner = $rBuy3['Name'] . " " . $rBuy3['FLastName'];
                                } else {
                                    $g_IDOwner = "3";
                                    $g_Owner = "Andrea Barranco";
                                }


                            }

                        }

                    } else {
                        $g_IDOwner = "3";
                        $g_Owner = "Andrea Barranco";
                    }

                    //Actualiza el PodData
                    $uPdB = "UPDATE PODemand SET Owner = '$g_Owner' WHERE BuyerCode = '$gBuy'";
                    $rPdB = $cnx->query($uPdB);

                }

                $sQtyLines = "SELECT MAX(IDPODemand) AS qtylines FROM PODemand";
                $rQtyLines = $cnx->query($sQtyLines)->fetchArray();
                $QtyLines = $rQtyLines['qtylines'];

                //Envia correo electronico
                //$logoDash = "http://intranet.masterworkelectronics.com/Images/Dashboard50.png";
                $MessPrincipal = "<table width=\'100%\' cellpadding=\'0\' cellspacing=\'0\'>"
                    . "<tr><td width=\'50%\'>"
                    . "<font style=\'font-size:3em;\'><b>$TF_TFile Uploaded</b></font><BR>"
                    . "<font style=\'color:gray;\'>Qty of Lines: $QtyLines</font><BR>"
                    . "<font style=\'color:gray;\'>Updated On: $dtAhora</font>"
                    . "</td><td>&nbsp;</td>"
                    . "<td align=\'center\' width=\'150\'><a href=\'http://mex-mds-001/Supply/Include/reportCSV.php?report=$TF_TFile\' target=\'_blank\'>"
                    . "<img src=\'$logoExcel\'><br>File Download</a>"
                    . "<br><br></td></tr></table>";

                $MessMail = $MessPrincipal;

                $AppInfo = "App: <B>Upload $TF_TFile</B><BR>Site: <a href=\'http://mex-mds-001/Supply/\'>Supply Site</a><BR>Date: <b>$dtAhora</b>";
                $SubjectEmail = "(MDS) Upload $TF_TFile";
                $ToEmail = "alejandro.ochoa@masterworkelectronics.com, alejandra.pena@masterworkelectronics.com";
                //$ToEmail = "mario.chavez@masterworkelectronics.com";
                $FromEmail = "btb@masterworkelectronics.com";

                //Manda Correo
                $iEmail = "INSERT INTO dbEmail VALUES('0', '$AppInfo', '$SubjectEmail', '$ToEmail', '$FromEmail', '$MessMail', '$FromEmail', '$dtAhora', '', 'Open')";
                $rEmail = $cnx->query($iEmail);

                break;
            case "PodFile":
                //Actualiza los Buyer
                $sDBx = "SELECT DISTINCT Class_Code FROM PodData WHERE Class_Code != '' ORDER BY Class_Code ASC";
                $lDBx = $cnx->query($sDBx)->fetchAll();

                foreach ($lDBx as &$DBuyx) {
                    $gCC = $DBuyx['Class_Code'];

                    if(!empty($gCC)){
                        //OBtiene nombre Customer
                        $sCust = "SELECT CustomerCode, CustomerName FROM Customers WHERE CustomerCode = '$gCC' ORDER BY CustomerCode ASC LIMIT 0, 1";
                        $nCust = $cnx->query($sCust)->numRows();
                        if($nCust == 1){
                            $LCust = $cnx->query($sCust)->fetchArray();
                            $g_Customer = ucwords(strtolower($LCust['CustomerName']));
                        } else {
                            $g_Customer = "";
                        }
                    }

                    //Actualiza el PodData
                    $uPdB = "UPDATE PodData SET Customer = '$g_Customer' WHERE Class_Code = '$gCC'";
                    $rPdB = $cnx->query($uPdB);
                    //echo $uPdB . "<BR>";

                    if(empty($g_Customer)){
                        //echo "$gCC - $g_Customer<BR>";
                    }

                }


                //Actualiza los Buyer
                $sDB = "SELECT DISTINCT Buyer FROM PodData ORDER BY Buyer ASC";
                $lDB = $cnx->query($sDB)->fetchAll();

                foreach ($lDB as &$DBuy) {
                    $gBuy = $DBuy['Buyer'];

                    if(!empty($gBuy)){
                        $sBuy1 = "SELECT * FROM Users WHERE IDExtra LIKE '$gBuy' ORDER BY IDExtra ASC LIMIT 0, 1";
                        $nBuy1 = $cnx->query($sBuy1)->numRows();

                        if($nBuy1 == 1){
                            $rBuy = $cnx->query($sBuy1)->fetchArray();
                            $g_IDOwner = $rBuy['IDUser'];
                            $g_Owner = $rBuy['Name'] . " " . $rBuy['FLastName'];

                        } else {
                            $bBuyer = $gBuy . ",";
                            $sBuy2 = "SELECT * FROM Users WHERE IDExtra LIKE '$bBuyer%' OR IDExtra LIKE ',$bBuyer%' ORDER BY IDExtra ASC LIMIT 0, 1";
                            $nBuy2 = $cnx->query($sBuy2)->numRows();
                            if($nBuy2 == 1){
                                $rBuy2 = $cnx->query($sBuy2)->fetchArray();
                                $g_IDOwner = $rBuy2['IDUser'];
                                $g_Owner = $rBuy2['Name'] . " " . $rBuy2['FLastName'];
                            } else {
                                $bBuyer2 = "," . $gBuy;
                                $sBuy3 = "SELECT * FROM Users WHERE IDExtra LIKE '%$bBuyer2' ORDER BY IDExtra ASC LIMIT 0, 1";
                                $nBuy3 = $cnx->query($sBuy3)->numRows();
                                if($nBuy3 == 1){
                                    $rBuy3 = $cnx->query($sBuy3)->fetchArray();
                                    $g_IDOwner = $rBuy3['IDUser'];
                                    $g_Owner = $rBuy3['Name'] . " " . $rBuy3['FLastName'];
                                } else {
                                    $g_IDOwner = "3";
                                    $g_Owner = "Andrea Barranco";
                                }


                            }

                        }

                    } else {
                        $g_IDOwner = "3";
                        $g_Owner = "Andrea Barranco";
                    }

                    //Actualiza el PodData
                    $uPdB = "UPDATE PodData SET idOwner = '$g_IDOwner', Owner = '$g_Owner' WHERE Buyer = '$gBuy'";
                    $rPdB = $cnx->query($uPdB);

                }


                $tTable = "TRUNCATE TABLE POControl";
                $rTx = $cnx->query($tTable);

                $tTablex = "TRUNCATE TABLE POControl_Hist";
                $rTx = $cnx->query($tTablex);

                //Crea los casos
                $SumPO = "SELECT Buyer, Class_Code, Part_Nbr, Description, Mfgr_Item_Nbr, Vendor_Name, "
                    . "Purch_Order_Number, Lne_Nbr, Purchase_Order_Add_Date, Status, Tracking_Nbr, "
                    . "SUM(CASE WHEN Vendor_Promise_Dt = '2000-01-01' AND Balance_Due > 0 THEN 1 ELSE 0 END) AS QtyNPromise, "
                    . "SUM(CASE WHEN Vendor_Promise_Dt != '2000-01-01' THEN 1 ELSE 0 END) AS QtyPromise, "
                    . "SUM(CASE WHEN (Vendor_Promise_Dt < NOW() AND Balance_Due > 0 AND Vendor_Promise_Dt != '2000-01-01') THEN 1 ELSE 0 END) AS QtyExpire, "
                    . "COUNT(Part_Nbr) AS QtyDelivery, "
                    . "SUM(Balance_Due) AS SQty FROM PodData "
                    . "WHERE Disp_Type != 'G' AND Class_Code != '' AND Purch_Order_Number NOT LIKE '9CN%' "
                    . "GROUP BY Buyer, Class_Code, Part_Nbr, Description, Mfgr_Item_Nbr, Vendor_Name, "
                    . "Purch_Order_Number, Lne_Nbr, Purchase_Order_Add_Date, Status ORDER BY Purch_Order_Number ASC";
                $rSumPO = $cnx->query($SumPO)->fetchAll();

                foreach ($rSumPO as &$ASumPO) {
                    $S_Buyer = $ASumPO['Buyer'];
                    $S_Class_Code = $ASumPO['Class_Code'];
                    $S_Part_Nbr = $ASumPO['Part_Nbr'];
                    $S_Description = $ASumPO['Description'];
                    $S_Mfgr_Item_Nbr = $ASumPO['Mfgr_Item_Nbr'];
                    $S_Vendor_Name = $ASumPO['Vendor_Name'];
                    $S_Purch_Order_Number = $ASumPO['Purch_Order_Number'];
                    $S_Lne_Nbr = $ASumPO['Lne_Nbr'];
                    $S_Purchase_Order_Add_Date = $ASumPO['Purchase_Order_Add_Date'];
                    $S_Status = $ASumPO['Status'];
                    $S_Tracking_Nbr = $ASumPO['Tracking_Nbr'];
                    $S_QtyNPromise = $ASumPO['QtyNPromise'];
                    $S_QtyPromise = $ASumPO['QtyPromise'];
                    $S_QtyExpire = $ASumPO['QtyExpire'];
                    $S_QtyDelivery = $ASumPO['QtyDelivery'];
                    $S_SQty = $ASumPO['SQty'];

                    //Busca info del DataPod
                    $sPOControl = "SELECT * FROM POControl "
                            . "WHERE Class_Code = '$S_Class_Code' AND Part_Nbr = '$S_Part_Nbr' "
                            . "AND Purch_Order_Number = '$S_Purch_Order_Number' AND Lne_Nbr = '$S_Lne_Nbr' AND Status = '$S_Status'";
                    $nPOC = $cnx->query($sPOControl)->numRows();
                    //caso de numero
                    switch ($nPOC){
                        case 1:
                            $rPOC = $cnx->query($sPOControl)->fetchArray();
                            $POC_idPOC = $rPOC['idPOC'];
                            $POC_Buyer = $rPOC['Buyer'];
                            $POC_Class_Code = $rPOC['Class_Code'];
                            $POC_Part_Nbr = $rPOC['Part_Nbr'];
                            $POC_Description = $rPOC['Description'];
                            $POC_Mfgr_Item_Nbr = $rPOC['Mfgr_Item_Nbr'];
                            $POC_Vendor_Name = $rPOC['Vendor_Name'];
                            $POC_Purch_Order_Number = $rPOC['Purch_Order_Number'];
                            $POC_Lne_Nbr = $rPOC['Lne_Nbr'];
                            $POC_Purchase_Order_Add_Date = $rPOC['Purchase_Order_Add_Date'];
                            $POC_QtyNPromise = $rPOC['QtyNPromise'];
                            $POC_QtyPromise = $rPOC['QtyPromise'];
                            $POC_QtyExpire = $rPOC['QtyExpire'];
                            $POC_QtyDelivery = $rPOC['QtyDelivery'];
                            $POC_SQty = $rPOC['SQty'];
                            //Campos extras
                            $POC_dtCreated = $rPOC['dtCreated'];
                            $POC_dtStarted = $rPOC['dtStarted'];
                            $POC_dtClosed = $rPOC['dtClosed'];
                            $POC_dtLastNote = $rPOC['dtLastNote'];
                            $POC_idUserLastNote = $rPOC['idUserLastNote'];
                            $POC_UserLastNote = $rPOC['UserLastNote'];
                            $POC_LastNote = $rPOC['LastNote'];
                            $POC_IDOwner = $rPOC['IDOwner'];
                            $POC_Owner = $rPOC['Owner'];
                            $POC_Status = $rPOC['Status'];

                            //Si cambia algo
                            if($POC_QtyDelivery != $POC_QtyDelivery || $POC_QtyPromise != $S_QtyPromise || $POC_QtyNPromise != $S_QtyNPromise || $POC_QtyExpire != $S_QtyExpire){
                                //Se actualiza el Sistema
                                if($POC_QtyPromise != $S_QtyPromise){
                                    $chgMess .= "Qty with Promise Change (B-$POC_QtyPromise A-$S_QtyPromise)";
                                }

                                //Se actualiza
                                if($POC_QtyNPromise != $S_QtyNPromise){
                                    $chgMess .= "Qty with No Promise Change (B-$POC_QtyNPromise A-$S_QtyNPromise)";
                                }

                                //Se actualiza
                                if($POC_QtyExpire != $S_QtyExpire){
                                    $chgMess .= "Qty Expire Change (B-$POC_QtyExpire A-$S_QtyExpire)";
                                }

                                //Se actualiza
                                if($POC_QtyDelivery != $S_QtyDelivery){
                                    $chgMess .= "Qty Delivery Change (B-$POC_QtyDelivery A-$S_QtyDelivery)";
                                }

                                //Actualiza el Campo
                                /*
                                $uPOC = "UPDATE POControl SET QtyPromise = '$S_QtyPromise', QtyNPromise = '$S_QtyNPromise', QtyExpired = '$S_QtyExpire' "
                                        . "WHERE idPOC";
                                $rPOC = $cnx->query($uPOC);
                                 * 
                                 */
                                $dPOC = "DELETE FROM POControl WHERE idPOC = '$POC_idPOC'";
                                $sdPOC = $cnx->query($dPOC);

                                //$POC_CustomerName = $Customers[$POC_Class_Code];

                                /*
                                $iPOC = "INSERT INTO POControl VALUES"
                                    . "('$POC_idPOC', '$dateToday', '$POC_Buyer', '$POC_Owner', '$POC_Class_Code', '$POC_CustomerName', '$POC_Part_Nbr', '$POC_Description', "
                                    . "'$POC_Mfgr_Item_Nbr', '$POC_Vendor_Name', '$POC_Purch_Order_Number', '$POC_Lne_Nbr', "
                                    . "'$POC_Purchase_Order_Add_Date', '$S_QtyNPromise', '$S_QtyPromise', '$S_QtyExpire', '$S_QtyDelivery', '$S_SQty', "
                                    . "'$POC_dtCreated', '$POC_dtCreated', '$POC_dtClosed', '$dtAhora', '0', "
                                    . "'MDS', '$POC_LastNote', '$POC_IDOwner', '$POC_Owner', '$POC_Status')";
                                */
                                $iPOC = "INSERT INTO POControl VALUES"
                                    . "('$POC_idPOC', '$TF_dateReport', '$POC_Buyer', '$POC_Owner', '$POC_Class_Code', '$POC_CustomerName', '$POC_Part_Nbr', '$POC_Description', "
                                    . "'$POC_Mfgr_Item_Nbr', '$POC_Vendor_Name', '$POC_Purch_Order_Number', '$POC_Lne_Nbr', "
                                    . "'$POC_Purchase_Order_Add_Date', '$S_QtyNPromise', '$S_QtyPromise', '$S_QtyExpire', '$S_QtyDelivery', '$S_SQty', "
                                    . "'$POC_dtCreated', '$POC_dtCreated', '$POC_dtClosed', '$dtAhora', '0', "
                                    . "'MDS', '$POC_LastNote', '$POC_IDOwner', '$POC_Owner', '$S_Tracking_Nbr', '$POC_Status')";

                                $LPOC = $cnx->query($iPOC); 
                                /*
                                $iPOCh = "INSERT INTO POControl_Hist VALUES"
                                    . "('0', '$dateToday', '$POC_idPOC', '$POC_Buyer', '$POC_Owner', '$POC_Class_Code', '$POC_CustomerName', '$POC_Part_Nbr', '$POC_Description', "
                                    . "'$POC_Mfgr_Item_Nbr', '$POC_Vendor_Name', '$POC_Purch_Order_Number', '$POC_Lne_Nbr', "
                                    . "'$POC_Purchase_Order_Add_Date', '$S_QtyNPromise', '$S_QtyPromise', '$S_QtyExpire', '$S_QtyDelivery', '$S_SQty', "
                                    . "'$POC_dtCreated', '$POC_dtCreated', '$POC_dtClosed', '$dtAhora', '0', "
                                    . "'MDS', '$POC_LastNote', '$POC_IDOwner', '$POC_Owner', '$POC_Status')";
                                */
                                $iPOCh = "INSERT INTO POControl_Hist VALUES"
                                    . "('0', '$TF_dateReport', '$POC_idPOC', '$POC_Buyer', '$POC_Owner', '$POC_Class_Code', '$POC_CustomerName', '$POC_Part_Nbr', '$POC_Description', "
                                    . "'$POC_Mfgr_Item_Nbr', '$POC_Vendor_Name', '$POC_Purch_Order_Number', '$POC_Lne_Nbr', "
                                    . "'$POC_Purchase_Order_Add_Date', '$S_QtyNPromise', '$S_QtyPromise', '$S_QtyExpire', '$S_QtyDelivery', '$S_SQty', "
                                    . "'$POC_dtCreated', '$POC_dtCreated', '$POC_dtClosed', '$dtAhora', '0', "
                                    . "'MDS', '$POC_LastNote', '$POC_IDOwner', '$POC_Owner', '$S_Tracking_Nbr', '$POC_Status')";

                                $LPOCh = $cnx->query($iPOCh);

                                //Agrega notas
                                $iNotes = "INSERT INTO POControl_Notes VALUES('0', 'POC', 'ChangePO', '$POC_idPOC', '$chgMess', '0', 'MDS', '$dtAhora')";
                                $IiNotes = $cnx->query($iNotes);

                            } 

                            break;
                        case 0;
                            //Nombre del Buyer
                            if(!empty($S_Buyer)){
                                $sBuy = "SELECT * FROM Users WHERE IDExtra LIKE '$S_Buyer' ORDER BY IDExtra ASC LIMIT 0, 1";
                                $nBuy = $cnx->query($sBuy)->numRows();

                                if($nBuy == 1){
                                    $rBuy = $cnx->query($sBuy)->fetchArray();
                                    $S_IDOwner = $rBuy['IDUser'];
                                    $S_Owner = $rBuy['Name'] . " " . $rBuy['FLastName'];

                                } else {
                                    $bBuyer = $S_Buyer . ",";
                                    //$sBuy2 = "SELECT * FROM Users WHERE IDExtra LIKE '%$bBuyer%' ORDER BY IDExtra ASC LIMIT 0, 1";
                                    $sBuy2 = "SELECT * FROM Users WHERE IDExtra LIKE '$bBuyer%' OR IDExtra LIKE ',$bBuyer%' ORDER BY IDExtra ASC LIMIT 0, 1";
                                    $nBuy2 = $cnx->query($sBuy2)->numRows();
                                    if($nBuy2 == 1){
                                        $rBuy2 = $cnx->query($sBuy2)->fetchArray();
                                        $S_IDOwner = $rBuy2['IDUser'];
                                        $S_Owner = $rBuy2['Name'] . " " . $rBuy2['FLastName'];
                                    } else {
                                        $bBuyer2 = "," . $S_Buyer;
                                        //$sBuy3 = "SELECT * FROM Users WHERE IDExtra LIKE '%$bBuyer2%' ORDER BY IDExtra ASC LIMIT 0, 1";
                                        $sBuy3 = "SELECT * FROM Users WHERE IDExtra LIKE '%$bBuyer2' ORDER BY IDExtra ASC LIMIT 0, 1";
                                        $nBuy3 = $cnx->query($sBuy3)->numRows();
                                        if($nBuy3 == 1){
                                            $rBuy3 = $cnx->query($sBuy3)->fetchArray();
                                            $S_IDOwner = $rBuy3['IDUser'];
                                            $S_Owner = $rBuy3['Name'] . " " . $rBuy3['FLastName'];
                                        } else {
                                            $S_IDOwner = "3";
                                            $S_Owner = "Andrea Barranco";
                                        }


                                    }

                                }

                            } else {
                                $S_IDOwner = "3";
                                $S_Owner = "Andrea Barranco";
                            }
                            /*
                            //Status
                            if($S_SQty == 0){
                                $S_Status = "Closed";
                            } else {
                                $S_Status = "Created";
                            }
                            */
                            //$S_CustomerName = $Customers[$S_Class_Code];

                            //Inserta el nuevo registro
                            $MaxID = "SELECT MAX(idPOC) AS mid FROM POControl";
                            $rMID = $cnx->query($MaxID)->fetchArray();
                            $IDPOC = $rMID['mid'] + 1;
                            //$TF_dateReport
                            /*
                            $iPOC = "INSERT INTO POControl VALUES"
                                    . "('$IDPOC', '$dateToday', '$S_Buyer', '$S_Owner', '$S_Class_Code', '$S_CustomerName', '$S_Part_Nbr', '$S_Description', "
                                    . "'$S_Mfgr_Item_Nbr', '$S_Vendor_Name', '$S_Purch_Order_Number', '$S_Lne_Nbr', "
                                    . "'$S_Purchase_Order_Add_Date', '$S_QtyNPromise', '$S_QtyPromise', '$S_QtyExpire', '$S_QtyDelivery', '$S_SQty', "
                                    . "'$dtAhora', '$dtAhora', '$dtAhora', '$dtAhora', '0', "
                                    . "'MDS', 'Created', '$S_IDOwner', '$S_Owner', '$S_Status')";
                            */
                            $iPOC = "INSERT INTO POControl VALUES"
                                    . "('$IDPOC', '$TF_dateReport', '$S_Buyer', '$S_Owner', '$S_Class_Code', '$S_CustomerName', '$S_Part_Nbr', '$S_Description', "
                                    . "'$S_Mfgr_Item_Nbr', '$S_Vendor_Name', '$S_Purch_Order_Number', '$S_Lne_Nbr', "
                                    . "'$S_Purchase_Order_Add_Date', '$S_QtyNPromise', '$S_QtyPromise', '$S_QtyExpire', '$S_QtyDelivery', '$S_SQty', "
                                    . "'$dtAhora', '$dtAhora', '$dtAhora', '$dtAhora', '0', "
                                    . "'MDS', 'Created', '$S_IDOwner', '$S_Owner', '$S_Tracking_Nbr', '$S_Status')";
                            $LPOC = $cnx->query($iPOC);
                            /*
                            $iPOCh = "INSERT INTO POControl_Hist VALUES"
                                    . "('0', '$dateToday', '$IDPOC', '$S_Buyer', '$S_Owner', '$S_Class_Code', '$S_CustomerName', '$S_Part_Nbr', '$S_Description', "
                                    . "'$S_Mfgr_Item_Nbr', '$S_Vendor_Name', '$S_Purch_Order_Number', '$S_Lne_Nbr', "
                                    . "'$S_Purchase_Order_Add_Date', '$S_QtyNPromise', '$S_QtyPromise', '$S_QtyExpire', '$S_QtyDelivery', '$S_SQty', "
                                    . "'$dtAhora', '$dtAhora', '$dtAhora', '$dtAhora', '0', "
                                    . "'MDS', 'Created', '$S_IDOwner', '$S_Owner', '$S_Status')";
                            */
                            $iPOCh = "INSERT INTO POControl_Hist VALUES"
                                    . "('0', '$TF_dateReport', '$IDPOC', '$S_Buyer', '$S_Owner', '$S_Class_Code', '$S_CustomerName', '$S_Part_Nbr', '$S_Description', "
                                    . "'$S_Mfgr_Item_Nbr', '$S_Vendor_Name', '$S_Purch_Order_Number', '$S_Lne_Nbr', "
                                    . "'$S_Purchase_Order_Add_Date', '$S_QtyNPromise', '$S_QtyPromise', '$S_QtyExpire', '$S_QtyDelivery', '$S_SQty', "
                                    . "'$dtAhora', '$dtAhora', '$dtAhora', '$dtAhora', '0', "
                                    . "'MDS', 'Created', '$S_IDOwner', '$S_Owner', '$S_Tracking_Nbr', '$S_Status')";

                            $LPOCh = $cnx->query($iPOCh);


                            break;
                        default :
                            //Mayor a 0
                            break;
                    }

                }

                //Customers
                $sCust = "SELECT CustomerCode, CustomerName FROM Customers GROUP BY CustomerCode, CustomerName ORDER BY CustomerCode ASC";
                $LCust = $cnx->query($sCust)->fetchAll();
                $Customers = "";

                //echo $sCust . "\n";
                //print_r($LCust) . "\n";
                foreach ($LCust as &$rCust) {
                    $CC = $rCust['CustomerCode'];
                    $NN = $rCust['CustomerName'];

                    if(!empty($CC)){
                        //Actualiza 
                        $ucc = "UPDATE POControl SET Customer = '$NN' WHERE Customer = '' AND Class_Code = '$CC'";
                        $rucc = $cnx->query($ucc);

                        $uccs = "UPDATE POControl_Hist SET Customer = '$NN' WHERE Customer = '' AND Class_Code = '$CC'";
                        $ruccs = $cnx->query($uccs);

                    }


                }


                //>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>Manda EMAIL
                // **************************************************General
                $logoDash = "http://intranet.masterworkelectronics.com/Images/Dashboard50.png";
                $AppInfo = "App: <B>Supply</B><BR>Site: <a href=\'http://mex-mds-001/Supply/\'>Supply Site</a><BR>Date: <b>$dtAhora</b>";
                $SubjectEmail = "(MDS) Open Purchase Order Summary ($TF_dateReport)";
//                $ToEmail = "bmathur@masterworkelectronics.com, emartinez@masterworkelectronics.com, fernando.ortega@masterworkelectronics.com, "
//                        . "purchasing@masterworkelectronics.com, ialvarez@masterworkelectronics.com, jeff.caldwell@masterworkelectronics.com, "
//                        . "jherran@masterworkelectronics.com, rmontalvo@masterworkelectronics.com, ricardo.ramos@masterworkelectronics.com, "
//                        . "schalunkal@assentresources.com, steve.mceuen@masterworkelectronics.com, tchacon@masterworkelectronics.com, "
//                        . "ted.murphy@masterworkelectronics.com, aurelio.leal@masterworkelectronics.com, andrea@masterworkelectronics.com, "
//                        . "michael.conway@masterworkelectronics.com, ernesto.vanegas@masterworkelectronics.com, mario.chavez@masterworkelectronics.com";
                $ToEmail = "mds.po.status@masterworkelectronics.com";
                //$ToEmail = "mario.chavez@masterworkelectronics.com";

                $FromEmail = "btb@masterworkelectronics.com";
                //Obtiene el summary
                // **************************************************Obtiene PastDue
                /*
                $sPastdue = "SELECT Class_Code, "
                    . "COUNT(idPodData) AS QtyLines, "
                    . "COUNT(IF(DATE_ADD(Expected_Delivery_Date, INTERVAL 4 DAY) < '$dateToday' AND Tracking_Nbr NOT LIKE '%control%' AND Tracking_Nbr NOT LIKE '%CSRPPV%', 1, NULL)) AS PastDueQty, "
                    . "COUNT(IF(Vendor_Promise_Dt = '2000-01-01' AND Balance_Due > 0, 1, NULL)) AS QtyNPromise "
                    . "FROM PodData "
                    . "WHERE Balance_Due > 0 AND Disp_Type != 'G' AND Class_Code != '' AND Purch_Order_Number NOT LIKE '9CN%' "
                    . "GROUP BY Class_Code ORDER BY QtyNPromise DESC";

                 */
                $sPastdue = "SELECT Class_Code, "
                    . "COUNT(idPodData) AS QtyLines, "
                    . "COUNT(IF(DATE_ADD(Expected_Delivery_Date, INTERVAL 4 DAY) < '$TF_dateReport' AND Tracking_Nbr NOT LIKE '%control%' AND Tracking_Nbr NOT LIKE '%CSRPPV%', 1, NULL)) AS PastDueQty, "
                    . "COUNT(IF(Vendor_Promise_Dt = '2000-01-01' AND Balance_Due > 0, 1, NULL)) AS QtyNPromise "
                    . "FROM PodData "
                    . "WHERE Balance_Due > 0 AND Disp_Type != 'G' AND Class_Code != '' AND Purch_Order_Number NOT LIKE '9CN%' "
                    . "GROUP BY Class_Code ORDER BY QtyNPromise DESC";

                $LPastDue = $cnx->query($sPastdue)->fetchAll();

                $MessDashBoard = "<table width=\'100%\' cellpadding=\'0\' cellspacing=\'0\'>"
                        . "<tr><td width=\'50%\'>"
                        . "<font style=\'font-size:3em;\'><b>Open PO Report</b></font><BR>"
                        . "<font style=\'color:gray;\'>Click on the Interactive Icon for more details</font>"
                        . "</td><td>&nbsp;</td>"
                        . "<td align=\'center\' width=\'150\'><a href=\'http://mex-mds-001/Supply/Dashboard.php?KeyI=Tm9Qcm9taXNl&KeyII=&KeyIII=\' target=\'\'>"
                        . "<img src=\'$logoDash\' width=\'50\' title=\'Dashboard\' border=\'0\'><br>Interactive Report</a>"
                        . "<br><br></td></tr></table>";

                $MessPassDue = "<font style=\'font-size:1em;\'><b>Top 10 Open PO, Customer<b></font><BR><b>(Total, Past Due, Unconfirm)</b><BR><BR>";
                $MessPassDue .= "<table width=\'100%\' border=\'1\' cellpadding=\'0\' cellspacing=\'0\'>"
                        . "<tr>"
                        . "<td align=\'center\' bgcolor=\'#c7c7c7\'>Customer</td>"
                        . "<td width=\'13%\' align=\'center\' bgcolor=\'#c7c7c7\'>Total<BR>Lines</td>"
                        . "<td width=\'13%\' align=\'center\' bgcolor=\'#c7c7c7\'>Past Due<BR>Lines</td>"
                        . "<td width=\'13%\' align=\'center\' bgcolor=\'red\'>(%)Past Due Lines</td>"
                        . "<td width=\'13%\' align=\'center\' bgcolor=\'#c7c7c7\'>Unconfirm Lines</td>"
                        . "<td width=\'13%\' align=\'center\' bgcolor=\'blue\'>(%)Unconfirm Lines</td>"
                        . "</tr>";
                $countr = 0;
                $count = 0;
                foreach ($LPastDue as &$RPD) {
                    $countr++;
                    $count++;
                    if($countr == 2){
                        $countr = 0;
                        $colorb = "#e7e7e7";
                    } else {
                        $colorb = "#ffffff";
                    }
                    //Sumary
                    $ClassCode = $RPD['Class_Code'];
                    //Busca el nombre del cliente
                    $sCust = "SELECT CustomerCode, CustomerName FROM Customers WHERE CustomerCode = '$ClassCode' ORDER BY CustomerCode ASC LIMIT 0, 1";
                    $nCust = $cnx->query($sCust)->numRows();
                    if($nCust == 1){
                        $LCust = $cnx->query($sCust)->fetchArray();
                        $Customer = ucwords(strtolower($LCust['CustomerName']));
                    } else {
                        $Customer = "";
                    }

                    $ClassCodeName = "($ClassCode) $Customer";

                    $QtyLines = $RPD['QtyLines'];
                    $PastDueQty = $RPD['PastDueQty'];
                    $PPDue = number_format(($PastDueQty * 100) / $QtyLines, 2) . " %";
                    $QtyUnConfirm = $RPD['QtyNPromise'];
                    $PUnC = number_format(($QtyUnConfirm * 100) / $QtyLines, 2) . " %";
                    $QtyLinesX = number_format($QtyLines, 0);
                    $PastDueQtyX = number_format($PastDueQty, 0);
                    $QtyUnConfirmX = number_format($QtyUnConfirm, 0);

                    if($count < 11){
                        $MessPassDue .= "<tr bgcolor=\'$colorb\'>"
                            . "<td align=\'left\'>$ClassCodeName</td>"
                            . "<td align=\'right\'>$QtyLinesX</td>"
                            . "<td align=\'right\'>$PastDueQtyX</td>"
                            . "<td align=\'right\'><font style=\'color:red;\'>$PPDue</font></td>"
                            . "<td align=\'right\'>$QtyUnConfirmX</td>"
                            . "<td align=\'right\'><font style=\'color:blue;\'>$PUnC</font></td>"
                            . "</tr>";
                    }
                    $CCHistBy = "ByClassCode";
                    $CCdatePO = $dateToday;


                    //Inserta Hyst
                    $iH = "INSERT INTO PodData_Hist VALUES('0', '$CCHistBy', '$CCdatePO', '$ClassCode', '$ClassCodeName', '', '', '', '$CCHigh', '$CCMedium', '$CCLow', '$CCTotal', '$dtAhora')";


                }
                $MessPassDue .= "</table>";

                // **************************************************Obtiene Unconfirm
                //Obtiene el summary
                /*
                $sSum = "SELECT Buyer AS PC_Name, COUNT(idPodData) AS PC_Qty,"
                        . "COUNT(IF(DATEDIFF('$dateToday', Purchase_Order_Add_Date) > '15', 1, NULL)) AS H, "
                        . "COUNT(IF(DATEDIFF('$dateToday', Purchase_Order_Add_Date) BETWEEN '8' AND '15', 1, NULL)) AS M, "
                        . "COUNT(IF(DATEDIFF('$dateToday', Purchase_Order_Add_Date) < '8', 1, NULL)) AS L "
                        . "FROM PodData "
                        . "WHERE Vendor_Promise_Dt = '2000-01-01' AND Balance_Due > 0 AND Disp_Type != 'G' "
                        . "AND Class_Code != '' AND Purch_Order_Number NOT LIKE '9CN%' GROUP BY PC_Name ORDER BY H DESC";
                */
                $sSum = "SELECT Buyer AS PC_Name, COUNT(idPodData) AS PC_Qty,"
                        . "COUNT(IF(DATEDIFF('$TF_dateReport', Purchase_Order_Add_Date) > '30', 1, NULL)) AS HH, "
                        . "COUNT(IF(DATEDIFF('$TF_dateReport', Purchase_Order_Add_Date) BETWEEN '15' AND '30', 1, NULL)) AS H, "
                        . "COUNT(IF(DATEDIFF('$TF_dateReport', Purchase_Order_Add_Date) BETWEEN '8' AND '14', 1, NULL)) AS M, "
                        . "COUNT(IF(DATEDIFF('$TF_dateReport', Purchase_Order_Add_Date) < '8', 1, NULL)) AS L "
                        . "FROM PodData "
                        . "WHERE Vendor_Promise_Dt = '2000-01-01' AND Balance_Due > 0 AND Disp_Type != 'G' "
                        . "AND Class_Code != '' AND Purch_Order_Number NOT LIKE '9CN%' GROUP BY PC_Name ORDER BY H DESC";


                //echo $sSum;
                $LSum = $cnx->query($sSum)->fetchAll();


                $MessOwner = "<BR><BR>Summary by Owner <b>(Unconfirm Delivey Lines)</b><BR><BR>";

                $MessOwner .= "<table width=\'100%\' cellpadding=\'0\' cellspacing=\'0\'>"
                        . "<tr>"
                        . "<td align=\'center\' bgcolor=\'#c7c7c7\'>Name</td>"
                        . "<td width=\'15%\' align=\'center\' bgcolor=\'gray\'>Low Risk<BR>(0-7 Days)</td>"
                        . "<td width=\'15%\' align=\'center\' bgcolor=\'blue\' style=\'color:white;\'>Medium Risk<BR>(8-14 Days)</td>"
                        . "<td width=\'15%\' align=\'center\' bgcolor=\'red\'>High Risk<BR>(> 15-30 Days)</td>"
                        . "<td width=\'15%\' align=\'center\' bgcolor=\'purple\' style=\'color:white;\'>Higher Risk<BR>(> 30 Days)</td>"
                        . "<td width=\'15%\' align=\'center\' bgcolor=\'#c7c7c7\'>Total</td>"
                        . "</tr>";
                $countr = 0;
                $tHH = 0;
                $tH = 0;
                $tM = 0;
                $tL = 0;
                $tT = 0;

                //Elimina hoy
                //$dHist = "DELETE FROM PodData_Hist WHERE datePO = '$dateToday' AND HistBy = 'ByBuyer'";
                $dHist = "DELETE FROM PodData_Hist WHERE datePO = '$TF_dateReport' AND HistBy = 'ByBuyer'";

                $rHist = $cnx->query($dHist);

                foreach ($LSum as &$RSum) {
                    $countr++;
                    if($countr == 2){
                        $countr = 0;
                        $colorb = "#e7e7e7";
                    } else {
                        $colorb = "#ffffff";
                    }
                    //Sumary
                    $S_Buyer = $RSum['PC_Name'];
                    $TotalB = $RSum['PC_Qty'];
                    $HHR = $RSum['HH'];
                    $HR = $RSum['H'];
                    $MR = $RSum['M'];
                    $LR = $RSum['L'];
                    $tH += $HR;
                    $tHH += $HHR;
                    $tM += $MR;
                    $tL += $LR;
                    $tT += $TotalB;

                    if(!empty($S_Buyer)){
                        $sBuy = "SELECT * FROM Users WHERE IDExtra LIKE '$S_Buyer' ORDER BY IDExtra ASC LIMIT 0, 1";
                        $nBuy = $cnx->query($sBuy)->numRows();

                        if($nBuy == 1){
                            $rBuy = $cnx->query($sBuy)->fetchArray();
                            $S_IDOwner = $rBuy['IDUser'];
                            $S_Owner = $rBuy['Name'] . " " . $rBuy['FLastName'];
                            $S_IDSup = $rBuy['idSupervisor'];

                        } else {
                            $bBuyer = $S_Buyer . ",";
                            //$sBuy2 = "SELECT * FROM Users WHERE IDExtra LIKE '%$bBuyer%' ORDER BY IDExtra ASC LIMIT 0, 1";
                            $sBuy2 = "SELECT * FROM Users WHERE IDExtra LIKE '$bBuyer%' OR IDExtra LIKE ',$bBuyer%' ORDER BY IDExtra ASC LIMIT 0, 1";
                            $nBuy2 = $cnx->query($sBuy2)->numRows();
                            if($nBuy2 == 1){
                                $rBuy2 = $cnx->query($sBuy2)->fetchArray();
                                $S_IDOwner = $rBuy2['IDUser'];
                                $S_Owner = $rBuy2['Name'] . " " . $rBuy2['FLastName'];
                                $S_IDSup = $rBuy2['idSupervisor'];

                            } else {
                                $bBuyer2 = "," . $S_Buyer;
                                //$sBuy3 = "SELECT * FROM Users WHERE IDExtra LIKE '%$bBuyer2%' ORDER BY IDExtra ASC LIMIT 0, 1";
                                $sBuy3 = "SELECT * FROM Users WHERE IDExtra LIKE '%$bBuyer2' ORDER BY IDExtra ASC LIMIT 0, 1";
                                $nBuy3 = $cnx->query($sBuy3)->numRows();
                                if($nBuy3 == 1){
                                    $rBuy3 = $cnx->query($sBuy3)->fetchArray();
                                    $S_IDOwner = $rBuy3['IDUser'];
                                    $S_Owner = $rBuy3['Name'] . " " . $rBuy3['FLastName'];
                                    $S_IDSup = $rBuy3['idSupervisor'];
                                } else {
                                    $S_IDOwner = "3";
                                    $S_Owner = "Andrea Barranco";
                                    $S_IDSup = 2;
                                }


                            }

                        }

                    } else {
                        $S_IDOwner = "3";
                        $S_Owner = "Andrea Barranco";
                        $S_IDSup = 2;
                    }
                    $sSup = "SELECT * FROM Users WHERE IDUser = '$S_IDSup' ORDER BY IDUser ASC LIMIT 0, 1";
                    $rSup = $cnx->query($sSup)->fetchArray();
                    $S_Leader = $rSup['Name'] . " " . $rSup['FLastName'];

                    $tName = "($S_Buyer) $S_Owner";

                    $LR = number_format($LR, 0);
                    if($LR > 0){
                        $LRx = "<font style=\'color:gray;\'><b>$LR</font>";
                    } else {
                        $LRx = "<font style=\'color:$colorb;\'>$LR</font>";
                    }

                    $MR = number_format($MR, 0);
                    if($MR > 0){
                        $MRx = "<font style=\'color:blue;\'><b>$MR</font>";
                    } else {
                        $MRx = "<font style=\'color:$colorb;\'>$MR</font>";
                    }

                    $HR = number_format($HR, 0);
                    if($HR > 0){
                        $HRx = "<font style=\'color:red;\'><b>$HR</font>";
                    } else {
                        $HRx = "<font style=\'color:$colorb;\'>$HR</font>";
                    }

                    $HHR = number_format($HHR, 0);
                    if($HHR > 0){
                        $HHRx = "<font style=\'color:purple;\'><b>$HHR</font>";
                    } else {
                        $HHRx = "<font style=\'color:$colorb;\'>$HHR</font>";
                    }
                    
                    $TotalBx = number_format($TotalB, 0);

                    $MessOwner .= "<tr bgcolor=\'$colorb\'>"
                            . "<td align=\'left\'>$tName</td>"
                            . "<td width=\'15%\' align=\'right\'>$LRx</td>"
                            . "<td width=\'15%\' align=\'right\'>$MRx</td>"
                            . "<td width=\'15%\' align=\'right\'>$HRx</td>"
                            . "<td width=\'15%\' align=\'right\'>$HHRx</td>"
                            . "<td width=\'15%\' align=\'right\'><b>$TotalBx<b></td>"
                            . "</tr>";

                    $BHistBy = "ByBuyer";
                    //$BdatePO = $dateToday;
                    $BdatePO = $TF_dateReport;

                    //Inserta Hyst
                    $iH = "INSERT INTO PodData_Hist VALUES('0', '$BHistBy', '$BdatePO', '', '', '$S_Buyer', '$S_Owner', '$S_Leader', '$HR', '$MR', '$LR', '$TotalB', '$dtAhora')";
                    $rH = $cnx->query($iH);

                }

                // **************************************************Obtiene Unconfirm por ClassCode
                //Obtiene el summary
                /*
                $sSumCC = "SELECT Class_Code AS PC_Name, COUNT(idPodData) AS PC_Qty,"
                        . "COUNT(IF(DATEDIFF('$dateToday', Purchase_Order_Add_Date) > '15', 1, NULL)) AS H, "
                        . "COUNT(IF(DATEDIFF('$dateToday', Purchase_Order_Add_Date) BETWEEN '8' AND '15', 1, NULL)) AS M, "
                        . "COUNT(IF(DATEDIFF('$dateToday', Purchase_Order_Add_Date) < '8', 1, NULL)) AS L "
                        . "FROM PodData "
                        . "WHERE Vendor_Promise_Dt = '2000-01-01' AND Balance_Due > 0 AND Disp_Type != 'G' "
                        . "AND Class_Code != '' AND Purch_Order_Number NOT LIKE '9CN%' GROUP BY PC_Name ORDER BY H DESC";
                */
                $sSumCC = "SELECT Class_Code AS PC_Name, COUNT(idPodData) AS PC_Qty,"
                        . "COUNT(IF(DATEDIFF('$TF_dateReport', Purchase_Order_Add_Date) > '15', 1, NULL)) AS H, "
                        . "COUNT(IF(DATEDIFF('$TF_dateReport', Purchase_Order_Add_Date) BETWEEN '8' AND '15', 1, NULL)) AS M, "
                        . "COUNT(IF(DATEDIFF('$TF_dateReport', Purchase_Order_Add_Date) < '8', 1, NULL)) AS L "
                        . "FROM PodData "
                        . "WHERE Vendor_Promise_Dt = '2000-01-01' AND Balance_Due > 0 AND Disp_Type != 'G' "
                        . "AND Class_Code != '' AND Purch_Order_Number NOT LIKE '9CN%' GROUP BY PC_Name ORDER BY H DESC";
                //echo $sSum;
                $LSumCC = $cnx->query($sSumCC)->fetchAll();
                $countrCC = 0;
                //Elimina hoy
                //$dHist = "DELETE FROM PodData_Hist WHERE datePO = '$dateToday' AND HistBy = 'ByClassCode'";
                $dHist = "DELETE FROM PodData_Hist WHERE datePO = '$TF_dateReport' AND HistBy = 'ByClassCode'";
                $rHist = $cnx->query($dHist);

                foreach ($LSumCC as &$RSumCC) {
                    //Sumary
                    $S_CC = $RSumCC['PC_Name'];
                    $TotalCC = $RSumCC['PC_Qty'];
                    $HRCC = $RSumCC['H'];
                    $MRCC = $RSumCC['M'];
                    $LRCC = $RSumCC['L'];

                    $sCustCC = "SELECT CustomerCode, CustomerName FROM Customers WHERE CustomerCode = '$S_CC' ORDER BY CustomerCode ASC LIMIT 0, 1";
                    $nCustCC = $cnx->query($sCustCC)->numRows();
                    if($nCustCC == 1){
                        $LCustCC = $cnx->query($sCustCC)->fetchArray();
                        $CustomerCC = ucwords(strtolower($LCustCC['CustomerName']));
                    } else {
                        $CustomerCC = "";
                    }

                    $BHistBy = "ByClassCode";
                    //$BdatePO = $dateToday;
                    $BdatePO = $TF_dateReport;

                    //Inserta Hyst
                    $iH = "INSERT INTO PodData_Hist VALUES('0', '$BHistBy', '$BdatePO', '$S_CC', '$CustomerCC', '', '', '', '$HRCC', '$MRCC', '$LRCC', '$TotalCC', '$dtAhora')";
                    $rH = $cnx->query($iH);

                }

                $tLx = number_format($tL, 0);
                $tMx = number_format($tM, 0);
                $tHx = number_format($tH, 0);
                $tHHx = number_format($tHH, 0);
                $tTx = number_format($tT, 0);
                

                $MessOwner .= "<tr bgcolor=\'gray\'>"
                    . "<td align=\'left\' ><b>Total</b></td>"
                    . "<td align=\'right\' bgcolor=\'#c7c7c7\'><b>$tLx</b></td>"
                    . "<td align=\'right\' bgcolor=\'blue\'><b>$tMx</b></td>"
                    . "<td align=\'right\' bgcolor=\'red\'><b>$tHx</b></td>"
                    . "<td align=\'right\' bgcolor=\'purple\'><b>$tHHx</b></td>"
                    . "<td align=\'right\' bgcolor=\'gray\'>$tTx</td>"
                    . "</tr>";

                $MessOwner .= "</table>";

                //******************Chart Trend Unconfirm High Risk
                $GTitle = "Unconfirm Trend Line (High Risk)";
                $GSerie = "High Risk"; //High Risk
                $GMaxValue = 0; //Max Value
                $GTrendTitle = "Unconfirm High Risk Trend";

                $dataII = "";
                $dataIII = "";

                //Crea datos de Grafico
                $sTrendData = "SELECT YEAR(datePO) AS Anio, WEEK(datePO) AS Semana, "
                        . "COUNT(DISTINCT(datePO)) AS QtyDays, "
                        . "COUNT(DISTINCT(Buyer)) AS QtyBuyer, "
                        . "SUM(QtyHigh) AS THR, "
                        . "CEILING((SUM(QtyHigh)/COUNT(DISTINCT(Buyer)))/ COUNT(DISTINCT(datePO))) AS Result "
                        . "FROM `PodData_Hist` WHERE HistBy = 'ByBuyer' GROUP BY Anio, Semana ORDER BY Anio ASC, Semana ASC";
                $nTrend = $cnx->query($sTrendData)->numRows();

                if($nTrend > 12){
                    $LTrend = $cnx->query($sTrendData)->fetchAll();
                    $St = $nTrend - 12;
                    $countTR = 0;
                    foreach ($LTrend as &$TR) {
                        $countTR++;
                        //Depende
                        $XTitle = $TR['Anio'] . "w" . $TR['Semana'];
                        $XVal = $TR['Result'];

                        if($countTR > $St){
                            //Cambia el valor
                            if($GMaxValue < $XVal){
                                $GMaxValue = $XVal;
                            }

                            $dataII .= $XTitle . "|";
                            $dataIII .= $XVal . "|";
                        }

                    }
                }

                if(!empty($dataII)){
                    $dataII = substr($dataII, 0, -1);
                    $CdataII = base64_encode($dataII);
                }

                if(!empty($dataIII)){
                    $dataIII = substr($dataIII, 0, -1);
                    $CdataIII = base64_encode($dataIII);
                }

                $dataI = "$GTitle|$GSerie|$GMaxValue|$GTrendTitle|750|300";
                $CdataI = base64_encode($dataI);

                $ChartSCR = "https://www.masterworkelectronics.com/masterworkelectronics.com/api/TrendChart.php?dataI=" . $CdataI 
                        . "&dataII=" . $CdataII . "&dataIII=" . $CdataIII;
                $ChartEx = "<center><img src=\'$ChartSCR\' width=\'750\' style=\'border:1px solid #c7c7c7;\'></center><BR>";


                //******************Chart Trend Unconfirm per customer
                $Customs = array("ZWO", "JAN", "APO", "CLI", "NUM");

                foreach ($Customs AS &$rCust){
                    $Client = $rCust;

                    if($Client == "ZWO"){
                        $WCust = "(ClassCode = 'ZWO' OR ClassCode = 'RAB' OR ClassCode = 'BOS')";
                        $TCliente = "ZWO - RAB - BOS";
                        $cClientes = 3;
                    } else {
                        $WCust = "ClassCode = '$Client'";
                        $TCliente = $Client;
                        $cClientes = 1;
                    }

                    $GTitle = "Unconfirm Trend Line ($TCliente, High Risk)";
                    $GSerie = "High Risk"; //High Risk
                    $GMaxValue = 0; //Max Value
                    $GTrendTitle = "Unconfirm High Risk Trend";

                    $dataII = "";
                    $dataIII = "";

                    //Crea datos de Grafico
                    $sTrendData = "SELECT YEAR(datePO) AS Anio, WEEK(datePO) AS Semana, "
                            . "COUNT(DISTINCT(datePO)) AS QtyDays, "
                            . "SUM(QtyHigh) AS THR, "
                            . "CEILING(SUM(QtyHigh)/COUNT(DISTINCT(datePO))/$cClientes) AS Result "
                            . "FROM PodData_Hist "
                            . "WHERE HistBy = 'ByClassCode' AND "
                            . "$WCust "
                            . "GROUP BY Anio, Semana ORDER BY Anio ASC, Semana ASC";
                    $nTrend= $cnx->query($sTrendData)->numRows();

                    if($nTrend > 12){
                        $LTrend = $cnx->query($sTrendData)->fetchAll();
                        $St = $nTrend - 12;
                        $countTR = 0;
                        foreach ($LTrend as &$TR) {
                            $countTR++;
                            //Depende
                            $XTitle = $TR['Anio'] . "w" . $TR['Semana'];
                            $XVal = $TR['Result'];

                            if($countTR > $St){
                                //Cambia el valor
                                if($GMaxValue < $XVal){
                                    $GMaxValue = $XVal;
                                }

                                $dataII .= $XTitle . "|";
                                $dataIII .= $XVal . "|";
                            }

                        }
                    }

                    if(!empty($dataII)){
                        $dataII = substr($dataII, 0, -1);
                        $CdataII = base64_encode($dataII);
                    }

                    if(!empty($dataIII)){
                        $dataIII = substr($dataIII, 0, -1);
                        $CdataIII = base64_encode($dataIII);
                    }

                    $dataI = "$GTitle|$GSerie|$GMaxValue|$GTrendTitle|320|200";
                    $CdataI = base64_encode($dataI);

                    $ChartSCR = "https://www.masterworkelectronics.com/masterworkelectronics.com/api/TrendChart.php?dataI=" . $CdataI 
                            . "&dataII=" . $CdataII . "&dataIII=" . $CdataIII;
                    $vLink = "Chart_" . $Client;

                    $$vLink = "<img src=\'$ChartSCR\'><BR>";


                }

                $cGraphs = "<BR><table width=\'100%\' cellpadding=\'0\' cellspacing=\'0\'>"
                        . "<tr>"
                        . "<td width=\'50%\' align=\'center\' style=\'padding:0;border:1px solid #c7c7c7;\'>$Chart_ZWO</td>"
                        . "<td width=\'50%\' align=\'center\' style=\'padding:0;border:1px solid #c7c7c7;\'>$Chart_JAN</td>"
                        . "</tr>"
                        . "<tr>"
                        . "<td width=\'50%\' align=\'center\' style=\'padding:0;border:1px solid #c7c7c7;\'>$Chart_APO</td>"
                        . "<td width=\'50%\' align=\'center\' style=\'padding:0;border:1px solid #c7c7c7;\'>$Chart_CLI</td>"
                        . "</tr>"
                        . "<tr>"
                        . "<td width=\'50%\' align=\'center\' style=\'padding:0;border:1px solid #c7c7c7;\'>$Chart_NUM</td>"
                        . "<td width=\'50%\' align=\'center\' style=\'padding:0;border:1px solid #c7c7c7;\'></td>"
                        . "</tr>"
                        . "</table><BR>";


                //******************Chart Trend Unconfirm per Leader
                $Lideres = array("Daniel Legaspi", "Adrian Tarango");
                $clider = 0;
                foreach ($Lideres AS &$rLid){
                    $clider++;
                    $Lider = $rLid;

                    $GTitle = "Unconfirm Trend Line ($Lider, High Risk)";
                    $GSerie = "High Risk"; //High Risk
                    $GMaxValue = 0; //Max Value
                    $GTrendTitle = "Unconfirm High Risk Trend";

                    $dataII = "";
                    $dataIII = "";

                    //Crea datos de Grafico
                    $sTrendData = "SELECT YEAR(datePO) AS Anio, WEEK(datePO) AS Semana, "
                            . "COUNT(DISTINCT(datePO)) AS QtyDays, "
                            . "SUM(QtyHigh) AS THR, "
                            . "CEILING(SUM(QtyHigh)/COUNT(DISTINCT(datePO))) AS Result "
                            . "FROM PodData_Hist "
                            . "WHERE HistBy = 'ByBuyer' AND "
                            . "Leader = '$Lider' "
                            . "GROUP BY Anio, Semana ORDER BY Anio ASC, Semana ASC";
                    $nTrend= $cnx->query($sTrendData)->numRows();

                    if($nTrend > 12){
                        $LTrend = $cnx->query($sTrendData)->fetchAll();
                        $St = $nTrend - 12;
                        $countTR = 0;
                        foreach ($LTrend as &$TR) {
                            $countTR++;
                            //Depende
                            $XTitle = $TR['Anio'] . "w" . $TR['Semana'];
                            $XVal = $TR['Result'];

                            if($countTR > $St){
                                //Cambia el valor
                                if($GMaxValue < $XVal){
                                    $GMaxValue = $XVal;
                                }

                                $dataII .= $XTitle . "|";
                                $dataIII .= $XVal . "|";
                            }

                        }
                    }

                    if(!empty($dataII)){
                        $dataII = substr($dataII, 0, -1);
                        $CdataII = base64_encode($dataII);
                    }

                    if(!empty($dataIII)){
                        $dataIII = substr($dataIII, 0, -1);
                        $CdataIII = base64_encode($dataIII);
                    }

                    $dataI = "$GTitle|$GSerie|$GMaxValue|$GTrendTitle|320|200";
                    $CdataI = base64_encode($dataI);

                    $ChartSCR = "https://www.masterworkelectronics.com/masterworkelectronics.com/api/TrendChart.php?dataI=" . $CdataI 
                            . "&dataII=" . $CdataII . "&dataIII=" . $CdataIII;
                    $vLink = "Chart_" . $clider;

                    $$vLink = "<img src=\'$ChartSCR\'><BR>";


                }

                $cGraphsLid = "<BR><table width=\'100%\' cellpadding=\'0\' cellspacing=\'0\'>"
                        . "<tr>"
                        . "<td colspan=\'2\'>"
                        . "<b>Buyer Leader Trendline (High Risk)</b><BR>"
                        . "</td>"
                        . "</tr>"
                        . "<tr>"
                        . "<td width=\'50%\' align=\'center\' style=\'padding:0;border:1px solid #c7c7c7;\'>$Chart_1</td>"
                        . "<td width=\'50%\' align=\'center\' style=\'padding:0;border:1px solid #c7c7c7;\'>$Chart_2</td>"
                        . "</tr>"
                        . "</table><BR>";



                $MessMail = $MessDashBoard . $ChartEx . $MessPassDue . $cGraphs . $MessOwner . $cGraphsLid;

                //Manda Correo
                $iEmail = "INSERT INTO dbEmail VALUES('0', '$AppInfo', '$SubjectEmail', '$ToEmail', '$FromEmail', '$MessMail', '$FromEmail', '$dtAhora', '', 'Open')";
                $rEmail = $cnx->query($iEmail);

                break;
        }

        $dtClosed = date('Y-m-d H:i:s', time());
        $uTFile2 = "UPDATE TempFiles SET dtClosed = '$dtClosed', Status = 'Updated' WHERE idFiles = '$TF_idFiles'";
        $ruTFile2 = $cnx->query($uTFile2);
        unlink($TF_Link);

    }

}

$cnx->close();


?>
