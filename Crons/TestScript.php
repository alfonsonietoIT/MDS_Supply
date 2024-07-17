#!/usr/bin/php
<?php
error_reporting(1);
$sI = $sII = $sIII = $sIV = ""; 
//Funciones
include '/var/www/html/Supply/PHPClass/DB.php';
include '/var/www/html/Supply/PHPFunctions/var.php';
include '/var/www/html/Supply/PHPFunctions/Function_SMS.php';
$test = "CustomerPodData";

switch ($test){
    case "CustomerPodData":
        //Actualiza los Buyer
        $sDB = "SELECT DISTINCT Class_Code FROM PodData WHERE Class_Code != '' ORDER BY Class_Code ASC";
        $lDB = $cnx->query($sDB)->fetchAll();

        foreach ($lDB as &$DBuy) {
            $gCC = $DBuy['Class_Code'];

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
        break;
    case "OwnerPodData":
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
                    $sBuy2 = "SELECT * FROM Users WHERE IDExtra LIKE '%$bBuyer%' ORDER BY IDExtra ASC LIMIT 0, 1";
                    $nBuy2 = $cnx->query($sBuy2)->numRows();
                    if($nBuy2 == 1){
                        $rBuy2 = $cnx->query($sBuy2)->fetchArray();
                        $g_IDOwner = $rBuy2['IDUser'];
                        $g_Owner = $rBuy2['Name'] . " " . $rBuy2['FLastName'];
                    } else {
                        $bBuyer2 = "," . $gBuy;
                        $sBuy3 = "SELECT * FROM Users WHERE IDExtra LIKE '%$bBuyer2%' ORDER BY IDExtra ASC LIMIT 0, 1";
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
            //echo $uPdB . "<BR>";

        }
        break;
    case "OwnerPPV":
        //Obtiene los POs
        $sPO = "SELECT DISTINCT Purch_Order_Number FROM PPVs ORDER BY Purch_Order_Number ASC";
        $LPO = $cnx->query($sPO)->fetchAll();
        
        foreach ($LPO as &$rPO) {
            $PO = $rPO['Purch_Order_Number'];
            //Revisa el Buyer
            $sBuy = "SELECT Buyer FROM PodData WHERE Purch_Order_Number ORDER BY Buyer ASC LIMIT 0, 1";
            $qBuy = $cnx->query($sBuy)->fetchArray();
            $S_Buyer = $qBuy['Buyer'];
            echo $sBuy . "";
            
            if(!empty($S_Buyer)){
                $sBuy = "SELECT * FROM Users WHERE IDExtra LIKE '$S_Buyer' ORDER BY IDExtra ASC LIMIT 0, 1";
                $nBuy = $cnx->query($sBuy)->numRows();

                if($nBuy == 1){
                    $rBuy = $cnx->query($sBuy)->fetchArray();
                    $S_IDOwner = $rBuy['IDUser'];
                    $S_Owner = $rBuy['Name'] . " " . $rBuy['FLastName'];

                } else {
                    $bBuyer = $S_Buyer . ",";
                    $sBuy2 = "SELECT * FROM Users WHERE IDExtra LIKE '%$bBuyer%' ORDER BY IDExtra ASC LIMIT 0, 1";
                    $nBuy2 = $cnx->query($sBuy2)->numRows();
                    if($nBuy2 == 1){
                        $rBuy2 = $cnx->query($sBuy2)->fetchArray();
                        $S_IDOwner = $rBuy2['IDUser'];
                        $S_Owner = $rBuy2['Name'] . " " . $rBuy2['FLastName'];
                    } else {
                        $bBuyer2 = "," . $S_Buyer;
                        $sBuy3 = "SELECT * FROM Users WHERE IDExtra LIKE '%$bBuyer2%' ORDER BY IDExtra ASC LIMIT 0, 1";
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
            
            //Actualiza PPVs
            $uPPV = "UPDATE PPVs SET idUOwner = '$S_IDOwner' WHERE Purch_Order_Number = '$PO'";
            echo $uPPV;
            //$rPPV = $cnx->query($uPPV);
            
        }
        
        echo "Termine";
        
        break;
    case "PODControl":
        //Crea los casos
        $SumPO = "SELECT Buyer, Class_Code, Part_Nbr, Description, Mfgr_Item_Nbr, Vendor_Name, "
            . "Purch_Order_Number, Lne_Nbr, Purchase_Order_Add_Date, "
            . "SUM(CASE WHEN Vendor_Promise_Dt = '2000-01-01' THEN 1 ELSE 0 END) AS QtyNPromise, "
            . "SUM(CASE WHEN Vendor_Promise_Dt != '2000-01-01' THEN 1 ELSE 0 END) AS QtyPromise, "
            . "SUM(CASE WHEN (Vendor_Promise_Dt < NOW() AND Balance_Due > 0 AND Vendor_Promise_Dt != '2000-01-01') THEN 1 ELSE 0 END) AS QtyExpire, "
            . "COUNT(Part_Nbr) AS QtyDelivery, "
            . "SUM(Balance_Due) AS SQty FROM PodData "
            . "WHERE Class_Code != '' AND Purch_Order_Number NOT LIKE '9CN%' "
            . "GROUP BY Buyer, Class_Code, Part_Nbr, Description, Mfgr_Item_Nbr, Vendor_Name, "
            . "Purch_Order_Number, Lne_Nbr, Purchase_Order_Add_Date ORDER BY Purch_Order_Number ASC LIMIT 0, 10";
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
            $S_QtyNPromise = $ASumPO['QtyNPromise'];
            $S_QtyPromise = $ASumPO['QtyPromise'];
            $S_QtyExpire = $ASumPO['QtyExpire'];
            $S_QtyDelivery = $ASumPO['QtyDelivery'];
            $S_SQty = $ASumPO['SQty'];

            //Busca info del DataPod
            $sPOControl = "SELECT * FROM POControl "
                    . "WHERE Class_Code = '$S_Class_Code' AND Part_Nbr = '$S_Part_Nbr' "
                    . "AND Purch_Order_Number = '$S_Purch_Order_Number' AND Lne_Nbr = '$S_Lne_Nbr'";
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

                        $iPOC = "INSERT INTO POControl VALUES"
                            . "('$POC_idPOC', '$POC_Buyer', '$POC_Owner', '$POC_Class_Code', '$POC_Part_Nbr', '$POC_Description', "
                            . "'$POC_Mfgr_Item_Nbr', '$POC_Vendor_Name', '$POC_Purch_Order_Number', '$POC_Lne_Nbr', "
                            . "'$POC_Purchase_Order_Add_Date', '$S_QtyNPromise', '$S_QtyPromise', '$S_QtyExpire', '$S_QtyDelivery', '$S_SQty', "
                            . "'$POC_dtCreated', '$POC_dtCreated', '$POC_dtClosed', '$dtAhora', '0', "
                            . "'MDS', '$POC_LastNote', '$POC_IDOwner', '$POC_Owner', '$POC_Status')";
                        $LPOC = $cnx->query($iPOC); 

                        $iPOCh = "INSERT INTO POControl_Hist VALUES"
                            . "('0', '$POC_idPOC', '$POC_Buyer', '$POC_Owner', '$POC_Class_Code', '$POC_Part_Nbr', '$POC_Description', "
                            . "'$POC_Mfgr_Item_Nbr', '$POC_Vendor_Name', '$POC_Purch_Order_Number', '$POC_Lne_Nbr', "
                            . "'$POC_Purchase_Order_Add_Date', '$S_QtyNPromise', '$S_QtyPromise', '$S_QtyExpire', '$S_QtyDelivery', '$S_SQty', "
                            . "'$POC_dtCreated', '$POC_dtCreated', '$POC_dtClosed', '$dtAhora', '0', "
                            . "'MDS', '$POC_LastNote', '$POC_IDOwner', '$POC_Owner', '$POC_Status')";
                        $LPOCh = $cnx->query($iPOCh);

                        //Agrega notas
                        $iNotes = "INSERT INTO POC_Notes VALUES('0', 'POC', 'ChangePO', '$POC_idPOC', '$chgMess', '0', 'MDS', '$dtAhora')";
                        $IiNotes = $cnx->query($iNotes);

                    } 

                    break;
                case 0;
                    //Nombre del Buyer
                    if(!empty($S_Buyer)){
                        $sBuy = "SELECT * FROM Users WHERE IDExtra LIKE '%$S_Buyer'%";
                        $nBuy = $cnx->query($sBuy)->numRows();

                        if($nBuy == 1){
                            $rBuy = $cnx->query($sBuy)->fetchArray();
                            $S_IDOwner = $rBuy['IDUser'];
                            $S_Owner = $rBuy['Name'] . " " . $rBuy['FLastName'];

                        } else {
                            $S_IDOwner = "3";
                            $S_Owner = "Andrea Barranco";
                        }

                    } else {
                        $S_IDOwner = "3";
                        $S_Owner = "Andrea Barranco";
                    }

                    //Status
                    if($S_SQty == 0){
                        $S_Status = "Closed";
                    } else {
                        echo "OK";
                    }

                    //Inserta el nuevo registro
                    $MaxID = "SELECT MAX(idPOC) AS mid FROM POControl";
                    $rMID = $cnx->query($MaxID)->fetchArray();
                    $IDPOC = $rMID['mid'] + 1;
                    $iPOC = "INSERT INTO POControl VALUES"
                            . "('$IDPOC', '$S_Buyer', '$S_Owner', '$S_Class_Code', '$S_Part_Nbr', '$S_Description', "
                            . "'$S_Mfgr_Item_Nbr', '$S_Vendor_Name', '$S_Purch_Order_Number', '$S_Lne_Nbr', "
                            . "'$S_Purchase_Order_Add_Date', '$S_QtyNPromise', '$S_QtyPromise', '$S_QtyExpire', '$S_QtyDelivery', '$S_SQty', "
                            . "'$dtAhora', '$dtAhora', '$dtAhora', '$dtAhora', '0', "
                            . "'MDS', 'Created', '$S_IDOwner', '$S_Owner', '$S_Status')";
                    $LPOC = $cnx->query($iPOC);

                    $iPOCh = "INSERT INTO POControl_Hist VALUES"
                            . "('0', '$IDPOC', '$S_Buyer', '$S_Owner', '$S_Class_Code', '$S_Part_Nbr', '$S_Description', "
                            . "'$S_Mfgr_Item_Nbr', '$S_Vendor_Name', '$S_Purch_Order_Number', '$S_Lne_Nbr', "
                            . "'$S_Purchase_Order_Add_Date', '$S_QtyNPromise', '$S_QtyPromise', '$S_QtyExpire', '$S_QtyDelivery', '$S_SQty', "
                            . "'$dtAhora', '$dtAhora', '$dtAhora', '$dtAhora', '0', "
                            . "'MDS', 'Created', '$S_IDOwner', '$S_Owner', '$S_Status')";
                    $LPOCh = $cnx->query($iPOCh);


                    break;
                default :
                    //Mayor a 0
                    break;
            }

        }
        break;
}




?>
