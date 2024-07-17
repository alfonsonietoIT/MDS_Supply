#!/usr/bin/php
<?php
include '/var/www/html/Supply/PHPClass/DB.php';
include '/var/www/html/Supply/PHPFunctions/var.php';
include '/var/www/html/Supply/PHPFunctions/Function_SMS.php';

/***************************************************************************** Valida PPV ***********************/
echo "Validando PPV...\r\n";
$qPPV = "SELECT DISTINCT(Part_Nbr) AS nparte FROM PodData WHERE Part_Nbr != '' ORDER BY nparte ASC";
$rowPPV = $cnx->query($qPPV)->fetchAll();
$dtahorita = date('Y-m-d H:i:s', time());

foreach ($rowPPV as &$rparte) {
    $nparte = $rparte['nparte'];
    //N echo $NParte
    //Obtiene el precio del PartData
    $sPrice = "SELECT Acctg_Value AS price FROM PartData WHERE Item_Number = '$nparte' ORDER BY price DESC LIMIT 0, 1";
    $nPrice = $cnx->query($sPrice)->numRows();
    
    if($nPrice > 0){
        $rPrice = $cnx->query($sPrice)->fetchArray();
        $gPrice = $rPrice['price'];
        //echo $sPrice . "\r\n\r\n";

        //Actualiza el PodData
        $uPodPrice = "UPDATE PodData SET Acctg_Value = '$gPrice' WHERE Part_Nbr = '$nparte'";
        $rPodP = $cnx->query($uPodPrice);
        //echo $uPodPrice . "\r\n\r\n";
    }
    
    
}

/***************************************************************************** Valida PPV ***********************/
echo "Actualizado PodData...\r\n";

$qImpact = "UPDATE PodData SET Delta_Value = (Currency_List_Unit_Price - Acctg_Value), "
    . "ImpactValue = ((Currency_List_Unit_Price - Acctg_Value) * Quantity_Ordered), dtDelta = '$dtAhora', PPV = 'forPPV' "
    . "WHERE Currency_List_Unit_Price != Acctg_Value AND Balance_Due > '0' AND Acctg_Value > '0' AND Purchase_Order_Add_Date >= '2022-04-01' AND "
    . "(Class_Code = 'WES' OR Class_Code = 'VEN' OR Class_Code = 'VCS' OR Class_Code = 'TID' OR Class_Code = 'ROY' "
    . "OR Class_Code = 'PWF' OR Class_Code = 'PIC' OR Class_Code = 'MEX' OR Class_Code = 'LAA' OR Class_Code = 'JOH' "
    . "OR Class_Code = 'GWS' OR Class_Code = 'DUN' OR Class_Code = 'DIX' OR Class_Code = 'DEL' OR Class_Code = 'AME')";
$rImp = $cnx->query($qImpact);
//echo $qImpact;


//Busca info
$sPPV = "SELECT Buyer, Vendor_Number, Vendor_Name, Purch_Order_Number, Lne_Nbr, Class_Code, Part_Nbr, Description, Currency_List_Unit_Price, "
        . "Disp_Type, Disp_Ref, Mfgr_ID, Mfgr_Item_Nbr, Purchase_Order_Add_Date, Acctg_Value, Delta_Value, dtParts, dtDelta, "
        . "SUM(ImpactValue) AS Impact, SUM(Balance_Due) AS Balance, SUM(Quantity_Ordered) AS QtyOrdered FROM PodData WHERE PPV = 'forPPV' "
        . "GROUP BY Buyer, Vendor_Number, Vendor_Name, Purch_Order_Number, Lne_Nbr, Class_Code, Part_Nbr, Description, Currency_List_Unit_Price, "
        . "Disp_Type, Disp_Ref, Mfgr_ID, Mfgr_Item_Nbr, Purchase_Order_Add_Date, Acctg_Value, Delta_Value, dtParts, dtDelta "
        . "ORDER BY Purch_Order_Number ASC";


echo "Creando PPV...\r\n";
//Agrega los PPV
//$sPPV = "SELECT * FROM PodData WHERE PPV = 'forPPV' ORDER BY idPodData ASC";
$rPPV = $cnx->query($sPPV)->fetchAll();
foreach ($rPPV as &$rXPPV) {
    //$g_idPodData = $rXPPV['idPodData'];
    $g_dtAdded = $rXPPV['dtAdded'];
    $g_Buyer = $rXPPV['Buyer'];
    $g_Vendor_Number = $rXPPV['Vendor_Number'];
    $g_Vendor_Name = $rXPPV['Vendor_Name'];
    $g_Purch_Order_Number = $rXPPV['Purch_Order_Number'];
    $g_Lne_Nbr = $rXPPV['Lne_Nbr'];
    $g_Class_Code = $rXPPV['Class_Code'];
    $g_Part_Nbr = $rXPPV['Part_Nbr'];
    $g_Description = $rXPPV['Description'];
    //$g_Quantity_Ordered = $rXPPV['Quantity_Ordered'];
    $g_Quantity_Ordered = $rXPPV['QtyOrdered'];
    //$g_Expected_Delivery_Date = $rXPPV['Quantity_Ordered'];
    $g_Expected_Delivery_Date = "2000-01-01";
    //$g_Balance_Due = $rXPPV['Balance_Due'];
    $g_Balance_Due = $rXPPV['Balance'];
    $g_Currency_List_Unit_Price = $rXPPV['Currency_List_Unit_Price'];
    //$g_Extended_Price = $rXPPV['Extended_Price'];
    $g_Extended_Price = $g_Quantity_Ordered * $g_Currency_List_Unit_Price;
    //$g_Requested_Delivery_Date = $rXPPV['Requested_Delivery_Date'];
    $g_Requested_Delivery_Date = "2000-01-01";
    //$g_Vendor_Promise_Dt = $rXPPV['Vendor_Promise_Dt'];
    $g_Vendor_Promise_Dt = "2000-01-01";
    //$g_Tracking_Nbr = $rXPPV['Tracking_Nbr'];
    $g_Tracking_Nbr = "";
    $g_Disp_Type = $rXPPV['Disp_Type'];
    $g_Disp_Ref = $rXPPV['Disp_Ref'];
    $g_Mfgr_ID = $rXPPV['Mfgr_ID'];
    $g_Mfgr_Item_Nbr = $rXPPV['Mfgr_Item_Nbr'];
    $g_Purchase_Order_Add_Date = $rXPPV['Purchase_Order_Add_Date'];
    $g_Acctg_Value = $rXPPV['Acctg_Value'];
    $g_Delta_Value = $rXPPV['Delta_Value'];
    //$g_ImpactValue = $rXPPV['ImpactValue'];
    $g_ImpactValue = $rXPPV['Impact'];
    $g_dtParts = $rXPPV['dtParts'];
    $g_dtDelta = $rXPPV['dtDelta'];
    $g_Status = $rXPPV['Status'];
    
    /*
     * N$g_keyPPV = $g_idPodDate . "_" . $g_Purch_Order_Number . "_" . $g_Lne_Nbr
     *       . "_" . $g_Part_Nbr . "_" . $g_Quantity_Ordered;
     * 
     */
    
    $sMID = "SELECT MAX(idPPV) AS mid FROM PPVs";
    $rMID = $cnx->query($sMID)->fetchArray();
    $ID = $rMID['mid'] + 1;
    $KEY = "PPV" . str_pad($ID, 8, "0", STR_PAD_LEFT);
    
    $S_Buyer = $g_Buyer;
    
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
    
    
    $iPPV = "INSERT INTO PPVs VALUES("
            . "'$ID', '$KEY', '$dtAhora', '$g_Buyer', '$g_Vendor_Number', "
            . "'$g_Vendor_Name', '$g_Purch_Order_Number', '$g_Lne_Nbr', '$g_Class_Code', '$g_Part_Nbr', "
            . "'$g_Description', '$g_Quantity_Ordered', '$g_Expected_Delivery_Date', '$g_Balance_Due', '$g_Currency_List_Unit_Price', "
            . "'$g_Extended_Price', '$g_Requested_Delivery_Date', '$g_Vendor_Promise_Dt', '$g_Tracking_Nbr', '$g_Disp_Type', "
            . "'$g_Disp_Ref', '$g_Mfgr_ID', '$g_Mfgr_Item_Nbr', '$g_Purchase_Order_Add_Date', '$g_Acctg_Value', "
            . "'$g_Delta_Value', '$g_ImpactValue', '$g_dtParts', '$g_dtDelta', '$dtAhora', "
            . "'$dtAhora', '$dtAhora', '$S_IDOwner', '', '', '', 'OpenPPV'"
            . ")";
    $rPP = $cnx->query($iPPV);
    
    //Actualiza el PodData
    //$uPod = "UPDATE PodData SET ID_PPV = '$ID', PPV = '$KEY', Status = 'OpenPPV' WHERE idPodData = '$g_idPodData'";
    $uPod = "UPDATE PodData SET ID_PPV = '$ID', PPV = '$KEY', V_Status = 'OpenPPV' WHERE Purch_Order_Number = '$g_Purch_Order_Number' AND Part_Nbr = '$g_Part_Nbr' AND Balance_Due > '0'";
    $ruPod = $cnx->query($uPod);
    
    
}

$dtahorita2 = date('Y-m-d H:i:s', time());
$logoDash = "http://intranet.masterworkelectronics.com/Images/Dashboard50.png";
$MessPrincipal = "<table width=\'100%\' cellpadding=\'0\' cellspacing=\'0\'>"
    . "<tr><td width=\'50%\'>"
    . "<font style=\'font-size:3em;\'><b>Production Plan Ready</b></font><BR>"
    . "<font style=\'color:gray;\'>Started: $dtahorita Finished: $dtahorita2</font>"
    . "</td><td>&nbsp;</td>"
    . "<td align=\'center\' width=\'150\'><a href=\'http://mex-mds-001/Supply/Dynamic.php?sI=ProductionPlan\' target=\'\'>"
    . "<img src=\'$logoDash\' width=\'50\' title=\'Dashboard\' border=\'0\'><br>View Production Plan</a>"
    . "<br><br></td></tr></table>";

$MessMail = $MessPrincipal;

$AppInfo = "App: <B>Supply</B><BR>Site: <a href=\'http://mex-mds-001/Supply/Dynamic.php?sI=ProductionPlan\'>Supply Site</a><BR>Date: <b>$dtAhora</b>";
$SubjectEmail = "(MDS) PPV Ready ($dtahorita2)";
$ToEmail = "mario.chavez@masterworkelectronics.com";
//$ToEmail = "mario.chavez@masterworkelectronics.com";
$FromEmail = "btb@masterworkelectronics.com";

//Manda Correo
$iEmail = "INSERT INTO dbEmail VALUES('0', '$AppInfo', '$SubjectEmail', '$ToEmail', '$FromEmail', '$MessMail', '$FromEmail', '$dtAhora', '', 'Open')";
$rEmail = $cnx->query($iEmail);


//echo "$dtahorita2 \r\n Termine";

echo "Termine";

?>