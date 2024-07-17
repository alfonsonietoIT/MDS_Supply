#!/usr/bin/php
<?php
include '/var/www/html/Supply/PHPClass/DB.php';
include '/var/www/html/Supply/PHPFunctions/var.php';
include '/var/www/html/Supply/PHPFunctions/Function_SMS.php';



/* !!!! CUSTOM FUNCTION MODIFIED BY LEONEL VALLE !!!! */
/* !!!! RUN IN CASE OF BPO REQUIRED !!!!! */


/********************************* Valida Customer ***********************/
$sCustomer = "SELECT idGroup AS IDCC, GroupName AS Customer, GroupCode AS Class_Code FROM AssGroup WHERE GroupCode = 'ALLC' ORDER BY GroupCode ASC";
//$sCustomer = "SELECT idGroup AS IDCC, GroupName AS Customer, GroupCode AS Class_Code FROM AssGroup WHERE idGroup = '30' ORDER BY idGroup ASC"; //idGroup = '30'

$nCustomer = $cnx->query($sCustomer)->numRows();
$cCust = 0;
$dtahorita = date('Y-m-d H:i:s', time());
//echo "$dtahorita \r\n Cantidad Clientes: $nCustomer **************************************\r\n";


$OHLocations = "AND (";

$sLocOH = "SELECT DISTINCT Location FROM OnHandLocations WHERE CTB = 'YES'";
$rLocOH = $cnx->query($sLocOH)->fetchAll();

foreach($rLocOH AS &$rL){
    $Loc = $rL['Location'];
    $OHLocations .= "Location = '$Loc' OR ";
}

$OHLocations = substr($OHLocations, 0, -4) . ")";

//echo $OHLocations;
//$nCustomer = 0;
if($nCustomer > 0){
    $rCustomer = $cnx->query($sCustomer)->fetchAll();
    foreach ($rCustomer AS &$rCx){
        $cCust++;
        $gIDCC = $rCx['IDCC'];
        $gCustomer = $rCx['Customer'];
        $gClassCode = $rCx['Class_Code'];
        $RANDx = rand();
        //TemporalProductionPlan
        $iPP = "INSERT INTO ConsultPP VALUES('0', '$RANDx', '$dtAhora', '$gClassCode', '$gCustomer', '16', '')";
        //echo $iPP . "\r\n";
        $rPP = $cnx->query($iPP);
        //Array Fridays
        $nweeks = 16;
        $nextFriday = date('Y-m-d', strtotime('next friday'));
        $ArrFriday[] = $nextFriday;
        $cweeks = 1;
        while ($cweeks < $nweeks){
            $cweeks++;
            if($cweeks > 12){
                //Siguientes 4 Fridays
                $nextFriday1 = date('Y-m-d', strtotime('next friday', strtotime($nextFriday)));
                $nextFriday2 = date('Y-m-d', strtotime('next friday', strtotime($nextFriday1)));
                $nextFriday3 = date('Y-m-d', strtotime('next friday', strtotime($nextFriday2)));
                $nextFriday4 = date('Y-m-d', strtotime('next friday', strtotime($nextFriday3)));
                $nextFriday = $nextFriday4;
                $ArrFriday[] = $nextFriday;
                
            } else {
                $nextFriday = date('Y-m-d', strtotime('next friday', strtotime($nextFriday)));
                $ArrFriday[] = $nextFriday;
            }
            
            
        }
        
        //print_r($ArrFriday);
        
        $ExtraBOM = "(";
        //Obtiene los diferentes ensambles
        $sAssy = "SELECT DISTINCT Assembly FROM AssembliesGroup WHERE idGroup = '$gIDCC' ORDER BY Assembly ASC";
        $nAssy = $cnx->query($sAssy)->numRows();
        
        if($nAssy > 0){
            $rAssy = $cnx->query($sAssy)->fetchAll();
            $countr = 0;
            //echo $sAssy . "\r\n";
            $wp1 = $wp2 = $wp3 = $wp4 = $wp5 = $wp6 = $wp7 = $wp8 = $wp9 = $wp10 = $wp11 = $wp12 = $wp13 = $wp14 = $wp15 = $wp16 = 0;

            foreach ($rAssy AS &$rA){
                $countr++;
                $gAssy = $rA['Assembly'];
                $ExtraBOM .= " Parent_Part_Assembly = '$gAssy' OR ";
                //$ArrAssy[] = $gAssy;
            }

            if(!empty($ExtraBOM)){
                $ExtraBOM = substr($ExtraBOM, 0, - 3) . ")";
            }

            //$sPart = "SELECT Item_Nbr, Lead_Time, "
                        //. "GROUP_CONCAT(DISTINCT CONCAT(Parent_Part_Assembly,':',Qty_Assy) ORDER BY Parent_Part_Assembly ASC SEPARATOR '>') AS Ass "
                        //. "FROM BOM WHERE $ExtraBOM GROUP BY Item_Nbr, Lead_Time ORDER BY Item_Nbr ASC"; *AQUI
            $sPart = "SELECT Item_Nbr, "
                        . "GROUP_CONCAT(DISTINCT CONCAT(Parent_Part_Assembly,':',Qty_Assy) ORDER BY Parent_Part_Assembly ASC SEPARATOR '>') AS Ass "
                        . "FROM BOM WHERE Inv_Type != 'SA' AND Inv_Type != 'NS' AND Inv_Type != 'FG' AND MOA != 'M' AND $ExtraBOM GROUP BY Item_Nbr ORDER BY Item_Nbr ASC";
            //echo $sPart;
            $rPart = $cnx->query($sPart)->fetchAll();
            $countr2 = 0;
            $countP = 0;
            foreach ($rPart AS &$rP){
                $countr2++;
                $countP++;

                $Item = $rP['Item_Nbr'];
                //$LeadTime = $rP['Lead_Time'];
                //$LeadTime = 0;
                $Ass = $rP['Ass'];
                $ArrNAss = explode(">", $Ass);
                $NAss = sizeof($ArrNAss);
                $QtyParts = 0;
                //Data from parts
                $sPartInf = "SELECT * FROM PartData WHERE Item_Number = '$Item' AND Prim_Ven = 'P' ORDER BY Prim_Ven ASC LIMIT 0, 1";
                $nPartInf = $cnx->query($sPartInf)->numRows();

                if($nPartInf == 1){
                    $rPartInf = $cnx->query($sPartInf)->fetchArray();
                    $gDescI = $rPartInf['Description'];
                    $gMfgr = $rPartInf['Mfgr_Name'];
                    $gMfgrNP = $rPartInf['Mfgr_Item_Nbr'];
                    $gAcctg = $rPartInf['Acctg_Value'];
                    $EngStr = $rPartInf['Engr_Status'];
                    $In_Ty = $rPartInf['In_Ty'];
                    $BCode = $rPartInf['Bin_Code'];
                    $LeadTime = $rPartInf['PLT'];
                } else {
                    
                    $sPartInf = "SELECT * FROM PartData WHERE Item_Number = '$Item' AND Engr_Status != '' ORDER BY Prim_Ven ASC LIMIT 0, 1";
                    $nPartInf = $cnx->query($sPartInf)->numRows();

                    if($nPartInf == 1){
                        $rPartInf = $cnx->query($sPartInf)->fetchArray();
                        $gDescI = $rPartInf['Description'];
                        $gMfgr = $rPartInf['Mfgr_Name'];
                        $gMfgrNP = $rPartInf['Mfgr_Item_Nbr'];
                        $gAcctg = $rPartInf['Acctg_Value'];
                        $EngStr = $rPartInf['Engr_Status'];
                        $In_Ty = $rPartInf['In_Ty'];
                        $BCode = $rPartInf['Bin_Code'];
                        $LeadTime = $rPartInf['PLT'];
                    } else {
                        $gDescI = "";
                        $gMfgr = "";
                        $gMfgrNP = "";
                        $gAcctg = "";
                        $EngStr = "";
                        $In_Ty = "";
                        $BCode = "";
                        $LeadTime = 0;
                    }
                    
                    
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
                /*$sQtyOH = "SELECT SUM(On_Hand_Quantity_By_Loc) AS QtyOH FROM PartData "
                        . "WHERE Item_Number = '$Item' AND (Location = '')";
                */
                
                
                
                $sQtyOH = "SELECT SUM(On_Hand_Quantity_By_Loc) AS QtyOH FROM PartData "
                        . "WHERE Item_Number = '$Item' $OHLocations";
                //$nQtyConsignado = $cnx->query($sQtyConsignado)->numRows();
                $rQtyOH = $cnx->query($sQtyOH)->fetchArray();
                $gOH = $rQtyOH['QtyOH'];
                
                if(empty($gOH)){
                    $gOH = 0;
                }
                
                /*
                //Add RecINSP
                $sQtyOHI = "SELECT SUM(On_Hand_Quantity_By_Loc) AS QtyINSP FROM PartData "
                        . "WHERE Item_Number = '$Item' AND Location = 'INSP'";
                //$nQtyConsignado = $cnx->query($sQtyConsignado)->numRows();
                $rQtyOHI = $cnx->query($sQtyOHI)->fetchArray();
                $gOHI = $rQtyOHI['QtyINSP'];
                
                $gOH += $gOHI;
                
                if(empty($gOH)){
                    $gOH = 0;
                }
                */
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
                    //$ViernesOPO = date('M-d', strtotime($Frid));
                    
                    //Obtiene el Plan Arribos de OPen PO
                    $sQtyPlan = "SELECT SUM(Balance_Due) AS QtyBalance FROM PodData "
                            . "WHERE Part_Nbr = '$Item' AND Vendor_Promise_Dt > '2000-01-01' "
                            . "AND Vendor_Promise_Dt BETWEEN '$curDate' AND '$ViernesOPO'";
                    //$nQtyPlan = $cnx->query($sQtyPlan)->numRows();
                    $rQty = $cnx->query($sQtyPlan)->fetchArray();
                    $QtyFri = $rQty['QtyBalance'];
                    
                    //echo $sQtyPlan . "\r\n";

                    if(empty($QtyFri)){
                        $QtyFri = 0;
                    }

                    $$vW = $QtyFri;
                    $curDate = date('Y-m-d', strtotime('+1 days', strtotime($ViernesOPO)));
                }

                //Suma el W1
                //$w1 = $w1 + $gOH + $gOv + $gCo;
                $wdp1 = $w1;
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
                $wdp12 = $wdp11 + $w12;
                $wdp13 = $wdp12 + $w13;
                $wdp14 = $wdp13 + $w14;
                $wdp15 = $wdp14 + $w15;
                $wdp16 = $wdp15 + $w16;

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
                
                $sConf = "SELECT * FROM PodData WHERE Part_Nbr = '$Item' AND Vendor_Promise_Dt >= '$dateToday' AND Vendor_Promise_Dt != '2000-01-01' "
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
                
                //obtiene elWWIPO
                $sWIPO = "SELECT SUM(TotalIssued) AS TWIPO FROM WIPOrders WHERE Part = '$Item' AND TotalIssued > '0' AND Fg = 'A'";
                $nWIPO = $cnx->query($sWIPO)->numRows();
                
                if($nWIPO == 1){
                    $rWIPO = $cnx->query($sWIPO)->fetchArray();
                    $gWipO = $rWIPO['TWIPO'];
                } else {
                    $gWipO = 0;
                }
                
                $iTemp = "INSERT INTO TempProductionPlan16 VALUES("
                        . "'0', '$Ass', '$NAss', '$RANDx', '$dtAhora', '$Item', '$gDescI', '$gMfgr', '$gMfgrNP', '$gWipO', '$gOH', '$gOv', '$gCo', '$tExpired', '$LeadTime', "
                        . "'$EngStr', '$In_Ty', '$BCode', "
                        . "'$w1', '$wp1', '$wdp1', "
                        . "'$w2', '$wp2', '$wdp2', "
                        . "'$w3', '$wp3', '$wdp3', "
                        . "'$w4', '$wp4', '$wdp4', "
                        . "'$w5', '$wp5', '$wdp5', "
                        . "'$w6', '$wp6', '$wdp6', "
                        . "'$w7', '$wp7', '$wdp7', "
                        . "'$w8', '$wp8', '$wdp8', "
                        . "'$w9', '$wp9', '$wdp9', "
                        . "'$w10', '$wp10',  '$wdp10', "
                        . "'$w11', '$wp11', '$wdp11', "
                        . "'$w12', '$wp12', '$wdp12', "
                        . "'$w13', '$wp13', '$wdp13', "
                        . "'$w14', '$wp14', '$wdp14', "
                        . "'$w15', '$wp15', '$wdp15', "
                        . "'$w16', '$wp16', '$wdp16', "
                        . "'$NConfirm', '$NExpired', '$NConf')";
                $rTemp = $cnx->query($iTemp);
                //echo $iTemp . "\r\n\r\n";
            }

        //echo $cCust . " - " . $gCustomer . "**************************OK\r\n"; 
        }
        
    }
    
    
    
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

$AppInfo = "App: <B>Supply</B><BR>Site: <a href=\'http://mex-mds-001/Supply/Dynamic.php?sI=ProductionPlan16\'>Supply Site</a><BR>Date: <b>$dtAhora</b>";
$SubjectEmail = "(MDS) Production Plan Ready 16 ($dtahorita2)";
$ToEmail = "ITSystems@masterworkelectronics.com";
//$ToEmail = "mario.chavez@masterworkelectronics.com";
$FromEmail = "btb@masterworkelectronics.com";

//Manda Correo
$iEmail = "INSERT INTO dbEmail VALUES('0', '$AppInfo', '$SubjectEmail', '$ToEmail', '$FromEmail', '$MessMail', '$FromEmail', '$dtAhora', '', 'Open')";
//$rEmail = $cnx->query($iEmail);


//echo "$dtahorita2 \r\n Termine";

?>
