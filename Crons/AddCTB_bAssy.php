#!/usr/bin/php
<?php
include '/var/www/html/Supply/PHPClass/DB.php';
include '/var/www/html/Supply/PHPFunctions/var.php';
include '/var/www/html/Supply/PHPFunctions/Function_SMS.php';

$cCust = 0;
$dtahorita = date('Y-m-d H:i:s', time());
//echo "$dtahorita \r\n Cantidad Clientes: $nCustomer **************************************\r\n";

//Array Fridays
$nweeks = 53;
$nextFriday = date('Y-m-d', strtotime('next friday'));
$ArrFriday[] = $nextFriday;
$cweeks = 1;
while ($cweeks < $nweeks){
    $cweeks++;
    $nextFriday = date('Y-m-d', strtotime('next friday', strtotime($nextFriday)));
    $ArrFriday[] = $nextFriday;
}

//print_r($ArrFriday);
//Obtiene los Asst
$sAXXXX = "SELECT DISTINCT Assembly FROM ProdPlanGroup ORDER BY Assembly ASC";
$rAXXXX = $cnx->query($sAXXXX)->fetchAll();

foreach ($rAXXXX AS &$rAX){
    $ArrAsy[] = $rAX['Assembly'];
}

//print_r($ArrAsy);

//$ArrAsy = array("32-010109-20|01");
$Assemblies = base64_encode(serialize($ArrAsy));

$ExtraBOM = "(";
foreach ($ArrAsy as &$Assy) {
    $gAssy = $Assy;
    $ExtraBOM .= " Parent_Part_Assembly = '$gAssy' OR ";
}

if(!empty($ExtraBOM)){
    $ExtraBOM = substr($ExtraBOM, 0, - 3) . ")";
}


$RANDx = rand();
//TemporalProductionPlan
$iPP = "INSERT INTO ConsultPP VALUES('0', '$RANDx', '$dtAhora', 'DIGIAss', 'DIGI', '53', '$Assemblies')";
//echo $iPP . "\r\n";
$rPP = $cnx->query($iPP);

$sPart = "SELECT Item_Nbr, Lead_Time, "
        . "GROUP_CONCAT(DISTINCT CONCAT(Parent_Part_Assembly,':',Qty_Assy) ORDER BY Parent_Part_Assembly ASC SEPARATOR '>') AS Ass "
        . "FROM BOM WHERE $ExtraBOM GROUP BY Item_Nbr, Lead_Time ORDER BY Item_Nbr ASC";
//echo $sPart;
$rPart = $cnx->query($sPart)->fetchAll();
$countr2 = 0;
$countP = 0;
foreach ($rPart AS &$rP){
    $countr2++;
    $countP++;
    $vUc = "";
    //$wp1 = $wp2 = $wp3 = $wp4 = $wp5 = $wp6 = $wp7 = $wp8 = $wp9 = $wp10 = $wp11 = $wp12 = 0;
    $nw = 0;
    while($nw < 53){
        $nw++;
        $vwx = "wp" . $nw;
        $$vwx = 0;
    }
    
    $Item = $rP['Item_Nbr'];
    $LeadTime = $rP['Lead_Time'];
    $Ass = $rP['Ass'];
    $ArrNAss = explode(">", $Ass);
    $NAss = sizeof($ArrNAss);
    $QtyParts = 0;
    //Data from parts
    $sPartInf = "SELECT * FROM PartData WHERE Item_Number = '$Item' ORDER BY Item_Number ASC LIMIT 0, 1";
    $nPartInf = $cnx->query($sPartInf)->numRows();

    if($nPartInf == 1){
        $rPartInf = $cnx->query($sPartInf)->fetchArray();
        $gDescI = $rPartInf['Description'];
        $gMfgr = $rPartInf['Mfgr_Name'];
        $gMfgrNP = $rPartInf['Mfgr_Item_Nbr'];
        $gAcctg = $rPartInf['Acctg_Value'];
    } else {
        $gDescI = "";
        $gMfgr = "";
        $gMfgrNP = "";
        $gAcctg = "";
    }

    $gCo = $gOH = $gOv = 0;
    //Consignado
    //Obtiene el Consignado de OPen PO
    $sQtyConsignado = "SELECT SUM(Balance_Due) AS QtyBalance FROM PodData "
            . "WHERE Part_Nbr = '$Item' AND Purch_Order_Number LIKE '9C%'";
    //$nQtyConsignado = $cnx->query($sQtyConsignado)->numRows();
    $rQtyConsignado = $cnx->query($sQtyConsignado)->fetchArray();
    $gCo = $rQtyConsignado['QtyBalance'];

    if(empty($gCo)){
        $gCo = 0;
    }

    //On Hand
    //Obtiene el OnHand Parts
    $sQtyOH = "SELECT SUM(Qty_On_Hand) AS QtyOH FROM PartData "
            . "WHERE Item_Number = '$Item'";
    //$nQtyConsignado = $cnx->query($sQtyConsignado)->numRows();
    $rQtyOH = $cnx->query($sQtyOH)->fetchArray();
    $gOH = $rQtyOH['QtyOH'];

    if(empty($gOH)){
        $gOH = 0;
    }

    //Over Issue
    //Obtiene el Over Issue
    $sQtyOV = "SELECT SUM(OverIssued) AS QtyOV FROM OverIssue "
            . "WHERE Item = '$Item'";
    //$nQtyConsignado = $cnx->query($sQtyConsignado)->numRows();
    $rQtyOV = $cnx->query($sQtyOV)->fetchArray();
    $gOv = $rQtyOV['QtyOV'];

    if(empty($gOv)){
        $gOv = 0;
    }


    $curDate = $dateToday;
    $CW = 0;
    foreach ($ArrFriday as &$ViernesOPO) {
        $CW++;
        $vW = "w" . $CW;
        $QtyUn = 0;
        //$ViernesOPO = date('M-d', strtotime($Frid));

        //Obtiene el Plan Arribos de OPen PO
        $sQtyPlan = "SELECT SUM(Balance_Due) AS QtyBalance FROM PodData "
                . "WHERE Part_Nbr = '$Item' AND Vendor_Promise_Dt > '2000-01-01' "
                . "AND Vendor_Promise_Dt BETWEEN '$curDate' AND '$ViernesOPO'";
        //$nQtyPlan = $cnx->query($sQtyPlan)->numRows();
        $rQty = $cnx->query($sQtyPlan)->fetchArray();
        $QtyFri = $rQty['QtyBalance'];

        if(empty($QtyFri)){
            $QtyFri = 0;
        }
        
        //Obtiene el Plan Arribos de OPen PO
        $sQtyUn = "SELECT SUM(Balance_Due) AS QtyBalance FROM PodData "
                . "WHERE Part_Nbr = '$Item' AND Vendor_Promise_Dt = '2000-01-01' "
                . "AND Balance_Due > '0' AND Disp_Type != 'G' AND Purch_Order_Number NOT LIKE '9CN%' "
                . "AND Expected_Delivery_Date BETWEEN '$curDate' AND '$ViernesOPO'";
        //$nQtyPlan = $cnx->query($sQtyPlan)->numRows();
        $rQtyUn = $cnx->query($sQtyUn)->fetchArray();
        $QtyUn = $rQtyUn['QtyBalance'];

        if(empty($QtyUn)){
            $QtyUn = 0;
        }
        
        $vUc .= $QtyUn . "|";

        $$vW = $QtyFri;
        $curDate = date('Y-m-d', strtotime('+1 days', strtotime($ViernesOPO)));
    }

    $vUc = substr($vUc, 0, -1);
    
    //Suma el W1
    //$w1 = $w1 + $gOH + $gOv + $gCo;
    $wdp1 = $w1;
    $wdpX = 1;
    while ($wdpX < 53){
        $varXAw = "wdp" . $wdpX;
        $wdpX++;
        $varwX = "w" . $wdpX;
        $varXw = "wdp" . $wdpX;
        $$varXw = $$varXAw + $$varwX;
        
    }
    /*
    $wdp2 = $wdp1 + $w2;
    $wdp3 = $wdp2 + $w3;
    $wdp4 = $wdp3 + $w4;
    $wdp5 = $wdp4 + $w5;
    $wdp6 = $wdp5 + $w6;
    $wdp7 = $wdp6 + $w7;
    $wdp8 = $wdp7 + $w8;
    $wdp9 = $wdp8 + $w9;
    $wdp10 = $wdp9 + $w10;
    $wdp11 = $wdp10 + $w11;
    $wdp12 = $wdp11 + $w12;*/

    $sUnc = "SELECT * FROM PodData WHERE Part_Nbr = '$Item' AND Vendor_Promise_Dt = '2000-01-01' "
            . "AND Balance_Due > '0' AND Disp_Type != 'G' AND Purch_Order_Number NOT LIKE '9CN%' ORDER BY Expected_Delivery_Date ASC";
    $nUnc = $cnx->query($sUnc)->numRows();

    $NConfirm = "";
    if($nUnc > 0){
        //echo $sUnc . "<BR>";
        $rUnc = $cnx->query($sUnc)->fetchAll();

        foreach ($rUnc AS &$rU){

            $UnVendor = $rU['Vendor_Name'];
            $UnPO = $rU['Purch_Order_Number'];
            $UnBuyer = $rU['Owner'];
            $UnOpenDt = date('M d, Y', strtotime($rU['Expected_Delivery_Date']));
            $UnBalance = number_format($rU['Balance_Due'], 0);
            $UnDDays = floor((strtotime($dateToday) - strtotime($rU['Purchase_Order_Add_Date'])) / (60*60*24));
            $NConfirm .= "$UnBuyer:$UnPO:$UnVendor:$UnOpenDt:$UnBalance:$UnDDays|";

        }

        $NConfirm = substr($NConfirm, 0, -1);

    } else {
        $NConfirm = "";
    }

    $sExp = "SELECT * FROM PodData WHERE Part_Nbr = '$Item' AND Vendor_Promise_Dt < '$dateToday' AND Vendor_Promise_Dt != '2000-01-01' "
            . "AND Balance_Due > '0' AND Disp_Type != 'G' AND Purch_Order_Number NOT LIKE '9CN%' ORDER BY Vendor_Promise_Dt ASC";
    $nExp = $cnx->query($sExp)->numRows();

    $NExpired = "";
    $tExpired = 0;
    if($nExp > 0){
        //echo $sUnc . "<BR>";
        $rExp = $cnx->query($sExp)->fetchAll();

        foreach ($rExp AS &$rE){

            $UnVendor = $rE['Vendor_Name'];
            $UnPO = $rE['Purch_Order_Number'];
            $UnBuyer = $rE['Owner'];
            $UnOpenDt = date('M d, Y', strtotime($rE['Vendor_Promise_Dt']));
            $UnBalance = number_format($rE['Balance_Due'], 0);
            $UnDDays = floor((strtotime($dateToday) - strtotime($rE['Purchase_Order_Add_Date'])) / (60*60*24));
            $NExpired .= "$UnBuyer:$UnPO:$UnVendor:$UnOpenDt:$UnBalance:$UnDDays|";
            $tExpired += $rE['Balance_Due'];

        }

        $NExpired = substr($NExpired, 0, -1);

    } else {
        $NExpired = "";
    }

    $sConf = "SELECT * FROM PodData WHERE Part_Nbr = '$Item' AND Vendor_Promise_Dt > '$dateToday' AND Vendor_Promise_Dt != '2000-01-01' "
            . "AND Balance_Due > '0' AND Disp_Type != 'G' AND Purch_Order_Number NOT LIKE '9CN%' ORDER BY Vendor_Promise_Dt ASC";
    $nConf = $cnx->query($sConf)->numRows();

    $NConf = "";

    if($nConf > 0){
        //echo $sUnc . "<BR>";
        $rConf = $cnx->query($sConf)->fetchAll();

        foreach ($rConf AS &$rConf){

            $UnVendor = $rConf['Vendor_Name'];
            $UnPO = $rConf['Purch_Order_Number'];
            $UnBuyer = $rConf['Owner'];
            $UnOpenDt = date('M d, Y', strtotime($rConf['Vendor_Promise_Dt']));
            $UnBalance = number_format($rConf['Balance_Due'], 0);
            $UnDDays = floor((strtotime($dateToday) - strtotime($rConf['Purchase_Order_Add_Date'])) / (60*60*24));
            $NConf .= "$UnBuyer:$UnPO:$UnVendor:$UnOpenDt:$UnBalance:$UnDDays|";


        }

        $NConf = substr($NConf, 0, -1);

    } else {
        $NConf = "";
    }

    $iTemp = "INSERT INTO TempProductionPlan53 VALUES("
            . "'0', '$Ass', '$NAss', '$RANDx', '$dtAhora', '$Item', '$gDescI', '$gMfgr', '$gMfgrNP', '$gOH', '$gOv', '$gCo', '$tExpired', '$LeadTime', "
            . "'$w1', '$wp1', '$wdp1', "
            . "'$w2', '$wp2', '$wdp2', "
            . "'$w3', '$wp3', '$wdp3', "
            . "'$w4', '$wp4', '$wdp4', "
            . "'$w5', '$wp5', '$wdp5', "
            . "'$w6', '$wp6', '$wdp6', "
            . "'$w7', '$wp7', '$wdp7', "
            . "'$w8', '$wp8', '$wdp8', "
            . "'$w9', '$wp9', '$wdp9', "
            . "'$w10', '$wp10', '$wdp10', "
            . "'$w11', '$wp11', '$wdp11', "
            . "'$w12', '$wp12', '$wdp12', "
            . "'$w13', '$wp13', '$wdp13', "
            . "'$w14', '$wp14', '$wdp14', "
            . "'$w15', '$wp15', '$wdp15', "
            . "'$w16', '$wp16', '$wdp16', "
            . "'$w17', '$wp17', '$wdp17', "
            . "'$w18', '$wp18', '$wdp18', "
            . "'$w19', '$wp19', '$wdp19', "
            . "'$w20', '$wp20', '$wdp20', "
            . "'$w21', '$wp21', '$wdp21', "
            . "'$w22', '$wp22', '$wdp22', "
            . "'$w23', '$wp23', '$wdp23', "
            . "'$w24', '$wp24', '$wdp24', "
            . "'$w25', '$wp25', '$wdp25', "
            . "'$w26', '$wp26', '$wdp26', "
            . "'$w27', '$wp27', '$wdp27', "
            . "'$w28', '$wp28', '$wdp28', "
            . "'$w29', '$wp29', '$wdp29', "
            . "'$w30', '$wp30', '$wdp30', "
            . "'$w31', '$wp31', '$wdp31', "
            . "'$w32', '$wp32', '$wdp32', "
            . "'$w33', '$wp33', '$wdp33', "
            . "'$w34', '$wp34', '$wdp34', "
            . "'$w35', '$wp35', '$wdp35', "
            . "'$w36', '$wp36', '$wdp36', "
            . "'$w37', '$wp37', '$wdp37', "
            . "'$w38', '$wp38', '$wdp38', "
            . "'$w39', '$wp39', '$wdp39', "
            . "'$w40', '$wp40', '$wdp40', "
            . "'$w41', '$wp41', '$wdp41', "
            . "'$w42', '$wp42', '$wdp42', "
            . "'$w43', '$wp43', '$wdp43', "
            . "'$w44', '$wp44', '$wdp44', "
            . "'$w45', '$wp45', '$wdp45', "
            . "'$w46', '$wp46', '$wdp46', "
            . "'$w47', '$wp47', '$wdp47', "
            . "'$w48', '$wp48', '$wdp48', "
            . "'$w49', '$wp49', '$wdp49', "
            . "'$w50', '$wp50', '$wdp50', "
            . "'$w51', '$wp51', '$wdp51', "
            . "'$w52', '$wp52', '$wdp52', "
            . "'$w53', '$wp53', '$wdp53', "
            . "'$NConfirm', '$NExpired', '$NConf', '$vUc')";
    $rTemp = $cnx->query($iTemp);
    //echo $iTemp . "<br><BR>";
}

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
$SubjectEmail = "(MDS) Production Plan Ready Assy ($dtahorita2)";
$ToEmail = "mario.chavez@masterworkelectronics.com";
//$ToEmail = "mario.chavez@masterworkelectronics.com";
$FromEmail = "btb@masterworkelectronics.com";

//Manda Correo
$iEmail = "INSERT INTO dbEmail VALUES('0', '$AppInfo', '$SubjectEmail', '$ToEmail', '$FromEmail', '$MessMail', '$FromEmail', '$dtAhora', '', 'Open')";
$rEmail = $cnx->query($iEmail);

$dtahorita2 = date('Y-m-d H:i:s', time());
echo "$dtahorita2 \r\n Termine";

?>