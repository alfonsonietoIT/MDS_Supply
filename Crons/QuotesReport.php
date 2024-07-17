#!/usr/bin/php
<?php
include '/var/www/html/Supply/PHPClass/DB.php';
include '/var/www/html/Supply/PHPFunctions/var.php';
include '/var/www/html/Supply/PHPFunctions/Function_SMS.php';

/***************************************************************************** Crea PPV ***********************/
$nCount = 0;
//Agrega los PPV
$sQR = "SELECT * FROM Quotes_Reports WHERE Status = 'Open' ORDER BY dtRequested ASC LIMIT 0, 1";

$rQR = $cnx->query($sQR)->fetchAll();
foreach ($rQR as &$rQRx) {
    $nCount++;
    $g_idQuotes_Reports = $rQRx['idQuotes_Reports'];
    $g_Link = $rQRx['Link'];
    $g_dtRequested = $rQRx['dtRequested'];
    $g_dtStarted = $rQRx['dtStarted'];
    $g_dtCompleted = $rQRx['dtCompleted'];
    $g_idUser = $rQRx['idUser'];
    $g_NUser = $rQRx['NUser'];
    $g_Status = $rQRx['Status'];
    $QR_Link = "/var/www/html/Supply/" . $g_Link;
    
    
    //Actualiza el status
    $uQr = "UPDATE Quotes_Reports SET dtStarted = '$dtAhora', status = 'Started' WHERE idQuotes_Reports = '$g_idQuotes_Reports'";
    //echo $uQr . " - $QR_Link<BR>";
    //echo $uQr . "<BR><BR>";
    $iQr = $cnx->query($uQr);
    $Row = 1;
    if (($Gestor = fopen($QR_Link, "r")) !== FALSE) {

        while (($PoData = fgetcsv($Gestor, 1000, ",")) !== FALSE) {
            $numero = count($PoData);
            //N echo "<p> $numero de campos en la línea $Row: <br /></p>\n";
            $Row++;
            for ($c=0; $c < $numero; $c++) {
                $var = "C" . $c;
                $$var = str_replace("\\", "", str_replace("\"", "", str_replace("'", "", $PoData[$c])));
                $varant = "aC" . $c;
                if(($c >= 0 && $c < 8) || ($c > 15)){
                    if(empty($$var)){
                        $$var = "" . $$varant;
                    }
                }
                //Necho $var . "-" . $$var . "<br />\n";
                $$varant = $$var;
                
                /*
                if($PoData[0] != "Buyer"){
                    $var = "C" . $c;
                    $$var = str_replace("\\", "", str_replace("\"", "", str_replace("'", "", $PoData[$c])));
                    $varant = "aC" . $c;
                    if(($c >= 0 && $c < 8) || ($c > 15)){
                        if(empty($$var)){
                            $$var = "" . $$varant;
                        }
                    }
                    //N echo $var . "-" . $$var . "<br />\n";
                    $$varant = $$var;
                }
                */

            }



            //Solo cantidad mayor a 0
            if(!empty($C0)){
                //Busca el file
                $LQry = "SELECT * FROM Quotes WHERE "
                    . "MPN LIKE '$C0' ORDER BY COMPLETED_ON DESC";
                $LRows = $cnx->query($LQry)->fetchAll();
                foreach ($LRows as &$LRowsx) {
                    $count++;
                    $countr++;
                    $nPart = $nParty = 0;
                    //print_r($LRowsx);
                    
                    //echo "$count-<BR><BR>";
                    
                    $g_1 = $LRowsx['idQuotes'];
                    $g_2 = $LRowsx['CPN'];
                    $g_3 = $LRowsx['MPN'];
                    $g_4 = $LRowsx['QUOTED_MPN'];
                    $g_5 = $LRowsx['MANUFACTURER_NAME'];
                    $g_6 = $LRowsx['RFQ'];
                    $g_7 = $LRowsx['RFQ_NAME'];
                    $g_8 = $LRowsx['SUPPLIER_NAME'];
                    $g_9 = $LRowsx['SUBMITTED_ON'];
                    $g_10 = $LRowsx['COMPLETED_ON'];
                    $g_11 = $LRowsx['MIN'];
                    $g_12 = $LRowsx['MULT'];
                    $g_13 = $LRowsx['LEAD_TIME'];
                    $g_14 = $LRowsx['STOCK'];
                    $g_15 = $LRowsx['QTY1'];
                    $g_16 = $LRowsx['PRICE1'];
                    $g_17 = $LRowsx['QTY2'];
                    $g_18 = $LRowsx['PRICE2'];
                    $g_19 = $LRowsx['QTY3'];
                    $g_20 = $LRowsx['PRICE3'];
                    $g_21 = $LRowsx['QTY4'];
                    $g_22 = $LRowsx['PRICE4'];
                    $g_23 = $LRowsx['QTY5'];
                    $g_24 = $LRowsx['PRICE5'];
                    $g_25 = $LRowsx['QTY6'];
                    $g_26 = $LRowsx['PRICE6'];
                    $g_27 = $LRowsx['QTY7'];
                    $g_28 = $LRowsx['PRICE7'];
                    $g_29 = $LRowsx['CUSTOMER'];
                    $g_30 = $LRowsx['MIN_PRICE'];
                    $g_31 = $LRowsx['MAX_QTY'];
                    $g_32 = $LRowsx['TOTAL_ESTIMATED'];
                    
                    $P_Acctg_Value = "";
                    $P_Ven_Price = "";
                    $P_Last_Price = "";
                    $P_Mfgr_Name = "";
                    $P_Vendor_Id = "";
                    $P_Last_Rcpt_Date = "2000-01-01";
                    //Solo si es diferente a vacio
                    if(!empty($g_3)){
                        //Obtiene data del customer part
                        $sParty = "SELECT * FROM PartData WHERE Mfgr_Item_Nbr = '$g_3' ORDER BY Last_Rcpt_Date DESC";
                        $nParty = $cnx->query($sParty)->numRows();
                        //echo "$nParty-Y<BR>";

                        if($nParty > 0){
                            $rPartz = $cnx->query($sParty)->fetchAll();

                            foreach ($rPartz as &$rParty) {
                                $P_Acctg_Value = $rParty['Acctg_Value'];
                                $P_Ven_Price = $rParty['Ven_Price'];
                                $P_Last_Price = $rParty['Last_Price'];
                                $P_Mfgr_Name = $rParty['Mfgr_Name'];
                                $P_Vendor_Id = $rParty['Vendor_Id'];
                                $P_Last_Rcpt_Date = $rParty['Last_Rcpt_Date'];

                                $iRp = "INSERT INTO Quotes_iReports VALUES(null, '$g_idQuotes_Reports', "
                                    . "'$g_1', '$g_2', '$g_3', '$g_4', '$g_5', '$g_6', '$g_7', '$g_8', '$g_9', '$g_10', "
                                    . "'$g_11', '$g_12', '$g_13', '$g_14', '$g_15', '$g_16', '$g_17', '$g_18', '$g_19', '$g_20', "
                                    . "'$g_21', '$g_22', '$g_23', '$g_24', '$g_25', '$g_26', '$g_27', '$g_28', '$g_29', '$g_30', "
                                    . "'$g_31', '$g_32', '$P_Acctg_Value', '$P_Ven_Price', '$P_Last_Price', '$P_Mfgr_Name', '$P_Vendor_Id', "
                                    . "'$P_Last_Rcpt_Date')";
                                //echo $iRp . "-1<BR><BR>";
                                //echo "$nCount / $nQR<BR>";
                                $sxRp = $cnx->query($iRp);
                            }
                        }
                    }
                    
                    
                    //Solo si es diferente a vacio
                    if(!empty($g_4)){
                        $sPart = "SELECT * FROM PartData WHERE Mfgr_Item_Nbr = '$g_4' ORDER BY Last_Rcpt_Date DESC";
                        $nPart = $cnx->query($sPart)->numRows();
                        //echo "$nPart-<BR>";

                        if($nPart > 0){
                            $rPart = $cnx->query($sPart)->fetchAll();
                            //echo "$nPart-X<BR>";
                            foreach ($rPart as &$rPartx) {
                                $P_Acctg_Value = $rPartx['Acctg_Value'];
                                $P_Ven_Price = $rPartx['Ven_Price'];
                                $P_Last_Price = $rPartx['Last_Price'];
                                $P_Mfgr_Name = $rPartx['Mfgr_Name'];
                                $P_Vendor_Id = $rPartx['Vendor_Id'];
                                $P_Last_Rcpt_Date = $rPartx['Last_Rcpt_Date'];

                                $iRp = "INSERT INTO Quotes_iReports VALUES(null, '$g_idQuotes_Reports', "
                                    . "'$g_1', '$g_2', '$g_3', '$g_4', '$g_5', '$g_6', '$g_7', '$g_8', '$g_9', '$g_10', "
                                    . "'$g_11', '$g_12', '$g_13', '$g_14', '$g_15', '$g_16', '$g_17', '$g_18', '$g_19', '$g_20', "
                                    . "'$g_21', '$g_22', '$g_23', '$g_24', '$g_25', '$g_26', '$g_27', '$g_28', '$g_29', '$g_30', "
                                    . "'$g_31', '$g_32', '$P_Acctg_Value', '$P_Ven_Price', '$P_Last_Price', '$P_Mfgr_Name', '$P_Vendor_Id', "
                                    . "'$P_Last_Rcpt_Date')";
                                //echo $iRp . "-2<BR><BR>";
                                //echo "$nCount / $nQR<BR>";
                                $sxRp = $cnx->query($iRp);
                            }

                        }
                    }
                    
                    
                    
                }
                

            }


        }
        fclose($Gestor);
    }
    
    $dtAhoraA = date('Y-m-d H:i:s', time());
    $uQr = "UPDATE Quotes_Reports SET dtCompleted = '$dtAhoraA', status = 'Ready' WHERE idQuotes_Reports = '$g_idQuotes_Reports'";
    //echo $uQr . "<BR><BR>";
    $iQr = $cnx->query($uQr);
    
    unlink($QR_Link);
}


echo "Termine..."

/*
$dnow4 = date('Y-m-d H:i:s', time());
//N unlink($Po_Link);
SMS("6862166100", "Se Termino Procesar forPPV $dnow4", "", "Mario", "forPPV");
*/
?>