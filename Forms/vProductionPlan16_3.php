<?php
switch ($sII){
    case "LoadDemand":
        if(empty($gKeyI)){
            $gKeyI = base64_decode($_GET['KeyI']);
            
            if(empty($gKeyI)){
                $gKeyI = $_POST['Key'];
            }
        }
        
        //Info Key
        $sKeyInfo = "SELECT * FROM ConsultPP WHERE ConsultName = '$gKeyI'";
        $rKey = $cnx->query($sKeyInfo)->fetchArray();
        $gCustomer = $rKey['Customer'];
        $gDTConsult = $rKey['DTConsult'];
        $gClassCode = $rKey['ClassCode'];
        $gAssyPN = $rKey['Assembly'];
        $gettoken = base64_encode($gCustomer);
        $gettokeni = base64_encode($gClassCode);
        $gettokenii = base64_encode($gAssyPN);
        $getKeyI = base64_encode($gKeyI);
        
        $Name = $_POST['demand'];
        $getKeyII = base64_encode($Name);
        
  

        //print_r($ArrVar);
        $vATipo = "Verde";
        $vAMensaje = "Redirect Site...!";
        $vRedirect = "Dynamic.php?sI=$sI&sII=vProductionPlan&sIII=getDemand&sIV=Home&token=$gettoken&tokeni=$gettokeni&tokenii=$gettokenii&KeyI=$getKeyI&KeyII=$getKeyII&KeyIII=1";
        $vATime = 100;
        echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
        
        break;
    case "SaveDemand":
        if(empty($gKeyI)){
            $gKeyI = base64_decode($_GET['KeyI']);
            
            if(empty($gKeyI)){
                $gKeyI = $_POST['Key'];
            }
        }
        
        //Info Key
        $sKeyInfo = "SELECT * FROM ConsultPP WHERE ConsultName = '$gKeyI'";
        $rKey = $cnx->query($sKeyInfo)->fetchArray();
        $gCustomer = $rKey['Customer'];
        $gDTConsult = $rKey['DTConsult'];
        $gClassCode = $rKey['ClassCode'];
        $gAssyPN = $rKey['Assembly'];
        $gettoken = base64_encode($gCustomer);
        $gettokeni = base64_encode($gClassCode);
        $gettokenii = base64_encode($gAssyPN);
        $getKeyI = base64_encode($gKeyI);
        
        
        
        
        $Name = $_POST['nameDemand'];
        $Variables = $_POST['variable'];
        //echo $Name . "<BR>";
        $DecVariable = base64_decode($Variables);
        $ArrVar = unserialize($DecVariable);
        $getKeyII = base64_encode($Name);
        
        //$nweeks = 13;
        $nweeks = 17;
        $nextFriday = date('Y-m-d', strtotime('next friday'));
        //*echo $nextFriday;
        $ArrFriday[1] = $nextFriday;
        $cweeks = 2;
        while ($cweeks < $nweeks){
            $cweeks++;
            if($cweeks > 13){
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
        
        $DName = "DELETE FROM DemandSaved WHERE Name = '$Name'";
        $rDName = $cnx->query($DName);
        
        foreach ($ArrVar AS &$ArVar){
            $gDataV = explode(">", $ArVar[0]);
            $gPart_N = $gDataV[0];
            $gWeek = $gDataV[1];
            $gVal = $ArVar[1];
            $gDateVal = $ArrFriday[$gWeek];
            
            $iDeS = "INSERT INTO DemandSaved VALUES('0', '$Name', '$dateToday', '$gPart_N', '$gWeek', '$gDateVal', '$gVal', '$dtAhora', '$gKeyI', '$gClassCode', '$gCustomer')";
            $rDes = $cnx->query($iDeS);
            //print_r($ArVar);
            //echo "$iDeS<BR>";
            //echo "<BR><BR>";
        }
        //print_r($ArrVar);
        $vATipo = "Verde";
        $vAMensaje = "Redirect Site...!";
        $vRedirect = "Dynamic.php?sI=$sI&sII=vProductionPlan&sIII=getDemand&sIV=Home&token=$gettoken&tokeni=$gettokeni&tokenii=$gettokenii&KeyI=$getKeyI&KeyII=$getKeyII&KeyIII=1";
        $vATime = 100;
        echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
        
        
        break;
    case "vProductionPlan":
        if(empty($gKeyIII)){
            $gKeyIII = $_GET['KeyIII'];
        }
        //echo $gKeyIII . "<BR><BR>";
        if(empty($gKeyI)){
            $gKeyI = base64_decode($_GET['KeyI']);
            
            if(empty($gKeyI)){
                $gKeyI = $_POST['Key'];
            }
        }
        
        //Info Key
        $sKeyInfo = "SELECT * FROM ConsultPP WHERE ConsultName = '$gKeyI'";
        $rKey = $cnx->query($sKeyInfo)->fetchArray();
        $gCustomer = $rKey['Customer'];
        $gDTConsult = $rKey['DTConsult'];
        $gClassCode = $rKey['ClassCode'];
        $gAssyPN = $rKey['Assembly'];
        $gettoken = base64_encode($gCustomer);
        $gettokeni = base64_encode($gClassCode);
        $gettokenii = base64_encode($gAssyPN);
        $getKeyI = base64_encode($gKeyI);
        $getKeyII = base64_encode($gKeyII);
        
        //Array Fridays
        $nweeks = 16;
        $nextFriday = date('Y-m-d', strtotime('next friday', strtotime($gDTConsult)));
        //*echo $nextFriday;
        $ArrFriday[] = $nextFriday;
        $cweeks = 1;
        while ($cweeks < $nweeks){
            $cweeks++;
            if($cweeks > 13){
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
        
        
        //echo "<pre>";
        //print_r($ArrFriday);
        //echo "</pre>";
        
        
        if($sIII == "IPLDs"){
            // OBTIENE EL $rDAssy
            $loadKey = 1;
            $nCollx = 0;
            
            //echo "$ultimo<BR>";
            $sCollx = "SELECT idGroup FROM AssGroup WHERE GroupCode = '$gClassCode' AND GType = 'Collection'";
            $nCollx = $cnx->query($sCollx)->numRows();
            //echo $sCollx . " - $nCollx<BR>";
            
            if($nCollx == 1){
                
                //Carga los grupos
                $rCollx = $cnx->query($sCollx)->fetchArray();
                $gidGroup = $rCollx['idGroup'];
                /*
                $sGrups = "SELECT CGroup FROM GroupCollection WHERE idCollection = '$gidCollet'";
                //echo $sGrups . "<BR>";
                $rGrups = $cnx->query($sGrups)->fetchAll();
                
                $cad = "(";
                foreach ($rGrups AS &$rG){
                    $gCGroup = $rG['CGroup'];
                    $gCGroupX = $gCGroup . "_Collection";
                    $cad .= "Name LIKE '$gCGroupX' OR ";
                }
                
                
                $cad = substr($cad, 0, -4) . ")";
                
                $sInfDemand = "SELECT DateSaved, PartNumber, DFriday, WNumber, SUM(Demand) AS DemandX FROM DemandSaved WHERE $cad GROUP BY DateSaved, PartNumber, DFriday, WNumber, Demand";
                //echo $sInfDemand . "<BR>";
                $rInfDemand = $cnx->query($sInfDemand)->fetchAll();
                foreach ($rInfDemand AS &$rInfD){
                    $StDate = $rInfD['DateSaved'];
                    $InfD_PN = $rInfD['PartNumber'];
                    $InfD_F = $rInfD['DFriday'];
                    $InfD_W = $rInfD['WNumber'];
                    $InfD_Val = $rInfD['DemandX'];
                    $namefd = $InfD_PN . ">" . $InfD_W;
                    $ArrDemand[$namefd] = $InfD_Val;
                }
                */
                
                if($gKeyIII == 1){
                    $sDAssy = "SELECT DISTINCT Assembly AS PartNumber FROM AssembliesGroup WHERE idGroup = '$gidGroup'";
                    //echo $sDAssy;
                    $rDAssy = $cnx->query($sDAssy)->fetchAll();
                    //print_r($rDAssy);
                }
                
                
            } else {
                //Busca Grupo
                $sCollx = "SELECT idGroup FROM AssGroup WHERE GroupCode = '$gClassCode'";
                $nCollx = $cnx->query($sCollx)->numRows();
                
                if($nCollx == 1){
                    $rCollx = $cnx->query($sCollx)->fetchArray();
                    $gidGroup = $rCollx['idGroup'];
                    if($gKeyIII == 1){
                        $sDAssy = "SELECT DISTINCT Assembly AS PartNumber FROM AssembliesGroup WHERE idGroup = '$gidGroup'";
                        //echo $sDAssy;
                        $rDAssy = $cnx->query($sDAssy)->fetchAll();
                        //print_r($rDAssy);
                    }
                    
                } else {
                    if($gKeyIII == 1){
                        $sDAssy = "SELECT DISTINCT Parent_Part_Assembly AS PartNumber FROM BOM WHERE Class_Code = '$gClassCode'";
                        //echo $sDAssy . "<BR>";
                        $rDAssy = $cnx->query($sDAssy)->fetchAll();
                        //print_r($rDAssy);
                    }
                }
                
                
                
                
            }
            
        }
        
        
        //print_r($rDAssy);
        //print_r($ArrDemand);
        
        
        //*********************************CALCULA EL PLANM
        $ExtraBOM = "(";
        
        if($gKeyIII == 1){
            $Demand_1 = "<b>(On Demand)</b>";
            $AssActive = " AND (";
            $AssActive2 = " AND (";

            foreach ($rDAssy AS &$rDas){
                //print_r($rDas);
                $AssActive .= "Parent_Part_Assembly = '" . $rDas['PartNumber'] . "' OR ";
                $AssActive2 .= "Assembly = '" . $rDas['PartNumber'] . "' OR ";
            }

            
            $AssActive = substr($AssActive, 0, -4) . ")";
            $AssActive2 = substr($AssActive2, 0, -4) . ")";
            //Inv_Type != 'PP' AND Inv_Type != 'CP' AND 
            $sAssy = "SELECT DISTINCT Parent_Part_Assembly FROM BOM WHERE Class_Code LIKE '$gClassCode' $AssActive ORDER BY Parent_Part_Assembly ASC";
            //echo $sAssy;
            
            $nAssies = $cnx->query($sAssy)->numRows();
            if($nAssies == 0){
                //Busca Grupo
                $sidGroup = "SELECT idGroup FROM AssGroup WHERE GroupCode = '$gClassCode'";
                $ridGroup = $cnx->query($sidGroup)->fetchArray();
                $gIDGroup = $ridGroup['idGroup'];
                $sAssy = "SELECT DISTINCT Assembly AS Parent_Part_Assembly FROM AssembliesGroup WHERE idGroup LIKE '$gIDGroup' $AssActive2 ORDER BY Assembly ASC";
                
            }
            
        } else {
            //Inv_Type != 'PP' AND Inv_Type != 'CP' AND 
            $sAssy = "SELECT DISTINCT Parent_Part_Assembly FROM BOM WHERE Class_Code LIKE '$gClassCode' ORDER BY Parent_Part_Assembly ASC";
            $nAssies = $cnx->query($sAssy)->numRows();
            if($nAssies == 0){
                //Busca Grupo
                $sidGroup = "SELECT idGroup FROM AssGroup WHERE GroupCode = '$gClassCode'";
                $ridGroup = $cnx->query($sidGroup)->fetchArray();
                $gIDGroup = $ridGroup['idGroup'];
                $sAssy = "SELECT DISTINCT Assembly AS Parent_Part_Assembly FROM AssembliesGroup WHERE idGroup LIKE '$gIDGroup' ORDER BY Assembly ASC";
                
            }
            
        }
        //echo $sAssy;
        
        //Obtiene los diferentes ensambles
        $rAssy = $cnx->query($sAssy)->fetchAll();
        $countr = 0;
        $countrx = 0;
        $TTotalRevenue = 0;
        foreach ($rAssy AS &$rA){
            $gTotal = 0;
            $countr++;
            $countrx++;
            $gAssy = $rA['Parent_Part_Assembly'];
            $ExtraBOM .= " Parent_Part_Assembly = '$gAssy' OR ";
            $gBOMArr = $gAssy;
            //Crea Array BOM
            if($sIII == "IPLDs"){
                $sBOMA = "SELECT Item_Nbr, Qty_Assy FROM BOM WHERE Parent_Part_Assembly = '$gAssy'";
                $rBOMA = $cnx->query($sBOMA)->fetchAll();
                //echo $sBOMA . "<BR>";
                
                foreach ($rBOMA as &$rBA) {
                    $Part_BOA = $rBA['Item_Nbr'];
                    $QtyA_BOA = $rBA['Qty_Assy'];
                    
                    //*$ArrBOM[] = array($gAssy, $Part_BOA, $QtyA_BOA);
                    $ArrBOM[]= array($gAssy, $Part_BOA, $QtyA_BOA);
                }
                
            }
            
            $sDesc = "SELECT Acctg_Value, Description FROM PartData WHERE Item_Number = '$gAssy' ORDER BY Description DESC LIMIT 0, 1";
            $nDesc = $cnx->query($sDesc)->numRows();
            
            //echo $sDesc . "<BR>";
            
            if($nDesc == 1){
                $rD = $cnx->query($sDesc)->fetchArray();
                $gAssyDesc = $rD['Description'];
                $gAssyPriceX = $rD['Acctg_Value'];
                $gAssyPrice = number_format($rD['Acctg_Value'], 4);
            } else {
                $gAssyDesc = "";
                $gAssyPriceX = $gAssyPrice = 0.0000;
            }
            
            //Obtiene precio
            $sPrice = "SELECT * FROM AssyPrice WHERE Assy = '$gAssy' ORDER BY Assy ASC LIMIT 0, 1";
            $nPrice = $cnx->query($sPrice)->numRows();
            
            if($nPrice == 1){
                $rPrice = $cnx->query($sPrice)->fetchArray();
                $gAssyPriceX = $rPrice['Price'];
                $gAssyPrice = number_format($gAssyPriceX, 4);
            } else {
                $gAssyPriceX = $gAssyPrice = 0.0000;
            }
            
            $ArrPr[$gAssy] = $gAssyPriceX;
            
            //echo $gAssy . "<BR>";
            if($countr == 2){
                $rowColor = "#e7e7e7";
                $countr = 0;
            } else {
                $rowColor = "white";
            }
            
            $ArrAssy[$countrx] = array($countrx, $gAssy, $gAssyDesc, $gAssyPrice);
            /*
            $TR_Assy .= "<tr onmouseout=\"this.bgColor='$rowColor'\" onmouseover=\"this.bgColor='#E0ECF8'\" bgcolor='$rowColor'>"
                    . "<td style='font-family:Roboto;font-size:.8em;text-align: center;'>"
                    . "$countrx"
                    . "</td>"
                    . "<td style='font-family:Roboto;font-size:.8em;text-align: center;'>"
                    . "$gAssy"
                    . "</td>"
                    . "<td style='font-family:Roboto;font-size:.8em;text-align: justify;'>"
                    . "$gAssyDesc"
                    . "</td>"
                    . "<td style='font-family:Roboto;font-size:.8em;text-align: right;'>"
                    . "$ $gAssyPrice"
                    . "</td>";
             * 
             */
            
            $wf = 0;
            $colsInput = "";
            $tRevenue = 0;
            //print_r($ArrFriday);
            $tWeeks = 0;

            foreach ($ArrFriday as &$Frid2) {
                $wf++;
                $namef = $gAssy . ">" . $wf;
                //echo $namef . "<br>";

                if($sIII == "PostDemand" || $sIII == "getDemand" || $sIII == "IPLDs"){
                    
                    if(isset($ArrDemand[$namef])){
                        $valX = $ArrDemand[$namef];
                    } else {
                        //POST Values
                        if(isset($_POST[$namef])){
                            $valX = $_POST[$namef];
                        } else {
                            $valX = 0;
                        }

                    }

                    if($sIII == "IPLDs"){
                        $valX = 1;
                    }

                    if($valX > 0){
                        $ArrSave[] = array($namef, $valX);
                        //Aumenta el requerimiento por parte
                        //$ArrDemanda[] = array($gAssy, $wf, $valX);
                        //Trae la parte
                        //print_r($ArrBOM);
                        foreach ($ArrBOM as &$BOMData) {
                            if($BOMData[0] == $gAssy){
                                $PartBOMD = $BOMData[1];
                                $QPartBOMD = $BOMData[2];
                                
                                if($PartBOMD == "1270-0023-0000|01"){
                                    //print_r($BOMData);
                                }
                                
                                
                                $gTotal = $QPartBOMD * $valX;
                                $ArrParrDemand[] = array($gAssy, $wf, $valX, $PartBOMD, $QPartBOMD, $gTotal);

                                if(isset($ArrPartD[$PartBOMD][$wf])){

                                    $Used = "USED - " . $ArrPartD[$PartBOMD][$wf];
                                    $ArrPartD[$PartBOMD][$wf] = $ArrPartD[$PartBOMD][$wf] + $gTotal;
                                    $print = $Used . " * $gAssy ******* $PartBOMD - $QPartBOMD - $valX -" . $ArrPartD[$PartBOMD] . "<BR>";
                                    if($PartBOMD == "1270-0023-0000|01"){
                                        //echo $print;
                                    }
                                } else {
                                    $ArrPartD[$PartBOMD][$wf] = $gTotal;
                                    $print = "Nuevo * $gAssy ******* $PartBOMD - $QPartBOMD - $valX - $gTotal<BR>";
                                    if($PartBOMD == "1270-0023-0000|01"){
                                        //echo $print;
                                    }
                                }


                            } else {
                                
                            }

                        }


                    }

                } else {
                    $valX = 0;
                }

                $varRW = "RW" . $wf;
                $$varRW += ($valX * $gAssyPriceX);

                $tRevenue += ($valX * $gAssyPriceX);
                //$TTotalRevenue += $tRevenue;
                array_push($ArrAssy[$countrx], $namef, $valX);
                $tWeeks += $valX;

                $colsInput .= "<td style='font-family:Roboto;font-size:.6em;text-align: center;'>"
                        . "<input name='$namef' value='$valX' type='number' style='width:5em;font-family:Roboto;font-size:1.2em;'>"
                        . "</td>";

            }
            
            //echo $tWeeks . "<BR>";
            $tRevenueF = number_format($tRevenue, 0);
            //echo "$ " . $tRevenueF;
            $TR_Assy .= "<td colspan='4' style='font-family:Roboto;font-size:.8em;text-align: right;'>"
                    . "$$ $tRevenueF"
                    . "</td>";
            $TR_Assy .= $colsInput;
            $TR_Assy .= "</tr>";
            array_push($ArrAssy[$countrx], $tWeeks);
            array_push($ArrAssy[$countrx], $tRevenueF);
                    
        }
        
        
        
        
        $LinkAction = "Dynamic.php?sI=$sI&sII=vProductionPlan&sIII=PostDemand&sIV=Home&token=$gettoken&tokeni=$gettokeni&tokenii=$gettokenii&KeyI=$getKeyI&KeyII=$getKeyII&KeyIII=$loadKey";
        
        //*echo $gCustomer . "-" . $gClassCode;
        //Buscar Guardados
        $SSaved = "SELECT Name, DateSaved FROM DemandSaved WHERE ClassCode = '$gClassCode' GROUP BY Name, DateSaved ORDER BY DateSaved DESC, Name ASC LIMIT 0, 30";
        //echo $SSaved;
        $nSaved = $cnx->query($SSaved)->numRows();
        //echo "Reg:" . $nSaved;
        
        $nColl = 0;
        //Revisa si es Collection
        $sColl = "SELECT idGroup FROM AssGroup WHERE GroupCode = '$gClassCode' AND GType = 'Collection'";
        $nColl = $cnx->query($sColl)->numRows();
        //echo $nColl;
        
        if($nColl == 1){
            $nSaved = $nSaved+1;
        }
        
        
        
        ?>

<div style="width:100%;font-family: 'Roboto';font-size:1em;text-align: center;font-weight: 100;">
    <font class="Rob">IPLDs Report</font>
    <p style="font-family: 'Roboto';font-size:1.5em;text-align: center;font-weight: 100;">
        Customer: <strong><?php echo $gCustomer . " ($gClassCode)";?></strong><br>
        <font class="Robss">Key: <b><?php echo $gKeyI;?></b></font>
    </p>
    
    <form action="<?php echo $LinkAction;?>" target="_self" method="post">
    <table style="width: 100%;">
        <?php
        
        
        //print_r($ArrSave);
        //print_r($ArrPartD);
        //print_r($ArrAssy);
        if(!empty($ExtraBOM)){
            $ExtraBOM = substr($ExtraBOM, 0, - 3) . ")";
        }
        
        
        
        $TTotalRevenue = $RW1 + $RW2 + $RW3 + $RW4 + $RW5 + $RW6 + $RW7 + $RW8 + $RW9 + $RW10 + $RW11 + $RW12 + $RW13 + $RW14 + $RW15 + $RW16;
        $TTotalRevenuef = "$ " . number_format($TTotalRevenue, 0);
        $tRW1 = number_format($RW1, 0);
        $tRW2 = number_format($RW2, 0);
        $tRW3 = number_format($RW3, 0);
        $tRW4 = number_format($RW4, 0);
        $tRW5 = number_format($RW5, 0);
        $tRW6 = number_format($RW6, 0);
        $tRW7 = number_format($RW7, 0);
        $tRW8 = number_format($RW8, 0);
        $tRW9 = number_format($RW9, 0);
        $tRW10 = number_format($RW10, 0);
        $tRW11 = number_format($RW11, 0);
        $tRW12 = number_format($RW12, 0);
        $tRW13 = number_format($RW13, 0);
        $tRW14 = number_format($RW14, 0);
        $tRW15 = number_format($RW15, 0);
        $tRW16 = number_format($RW16, 0);
        
        
        //Solo si es diferente a 0
        if($gKeyIII > 0){
            $sPart = "SELECT * "
                . "FROM TempProductionPlan16 WHERE Engr_Status != 'I' AND Token = '$gKeyI' "
                . "ORDER BY PartNumber ASC";
            //echo $sPart;
            $rPart = $cnx->query($sPart)->fetchAll();
            $countr2 = 0;
            $countP = 0;

            foreach ($rPart AS &$rP){
                $countr2++;
                $countP++;
                $T_idTemp = $rP['idTemp'];
                $T_Assemblies = $rP['Assemblies'];
                $T_QtyAssemblies = $rP[''];
                $T_Token = $rP['Token'];
                $T_DTConsult = $rP['DTConsult'];
                $T_PartNumber = $rP['PartNumber'];
                $T_Description = $rP['Description'];
                $T_Mfgr = $rP['Mfgr'];
                $T_MfgrPN = $rP['MfgrPN'];
                $T_WipO = $rP['WipO'];
                $T_OnHand = $rP['OnHand'];
                $T_OverIssue = floor($rP['OverIssue'] * .8);
                $T_Consigned = $rP['Consigned'];
                $T_QtyExpired = $rP['QExpired'];
                $T_LeadTime = $rP['LeadTime'];

                $T_LeadTime = round($T_LeadTime / 7);
                //$T_LeadTime = "";
                $T_w1 = $rP['w1'];
                $T_w2 = $rP['w2'];
                $T_w3 = $rP['w3'];
                $T_w4 = $rP['w4'];
                $T_w5 = $rP['w5'];
                $T_w6 = $rP['w6'];
                $T_w7 = $rP['w7'];
                $T_w8 = $rP['w8'];
                $T_w9 = $rP['w9'];
                $T_w10 = $rP['w10'];
                $T_w11 = $rP['w11'];
                $T_w12 = $rP['w12'];
                $T_w13 = $rP['w13'];
                $T_w14 = $rP['w14'];
                $T_w15 = $rP['w15'];
                $T_w16 = $rP['w16'];
                $T_UnConfirm = $rP['UnConfirm'];
                $T_Expired = $rP['Expired'];
                $T_Confirm = $rP['Confirm'];
                $T_Engr = $rP['Engr_Status'];
                $T_BCode = $rP['BCode'];
                $T_In_Ty = $rP['In_Ty'];
                $Notes = $TNote = "";
                $AsssX = explode(">", $T_Assemblies);
                if($T_PartNumber == "CTK-50F360-04|01"){
                    //echo $T_Assemblies;
                    //print_r($AsssX);
                    //echo "<BR>";
                }
                
                
                foreach ($AsssX AS &$Asss){
                    $NTX = explode(":", $Asss);
                    $QtyNot = number_format($NTX[1], 4);
                    
                    
                    
                    if($gKeyIII == 10){
                        if(strpos($AssActive, $NTX[0]) !== false){
                            $TNote .= "<tr><td style='font-family:Roboto;font-size:.8em;text-align: center;'>$NTX[0]</td>"
                                . "<td style='font-family:Roboto;font-size:.8em;text-align: center;'>$QtyNot</td></tr>";
                        }
                    } else {
                        $TNote .= "<tr><td style='font-family:Roboto;font-size:.8em;text-align: center;'>$NTX[0]</td>"
                            . "<td style='font-family:Roboto;font-size:.8em;text-align: center;'>$QtyNot</td></tr>";
                    }
                    
                    if($T_PartNumber == "CTK-50F360-04|01"){
                        //echo "KeyIII - $gKeyIII<BR>";
                        //$TNote .= "As: " . $NTX[0] . " Qty: " . $QtyNot . "<BR>";
                    }
                    //$TNote .= "As: " . $NTX[0] . " Qty: " . $QtyNot . "\r\n";
                }
                if($countP == 1){
                //print_r($ArrPartD);
                }

                //$Notes = "<img src='Images/View.svg' width='16' alt='$TNote' title='$TNote'>";
                $Movements = "";
                $qtyDemand = $qtyConf = "";

                $cDay = 0;
                $demand = $OHPart = 0;
                $colsdates = "";
                $Delta = 0;
                $NConfirm = "";
                $tDemand = 0;
                //$Movements = "<tr>";
                $B_w1=$B_w2=$B_w3=$B_w4=$B_w5=$B_w6=$B_w7=$B_w8=$B_w9=$B_w10=$B_w11=$B_w12=0;
                
                //Nueva Demanda
                $qtyDemandN = "";
                $dw1 = $dw2 = $dw3 = $dw4 = $dw5 = $dw6 = $dw7 = $dw8 = $dw9 = $dw10 = $dw11 = $dw12 = $dw13 = $dw14 = $dw15 = $dw16 = 0;
                
                //echo "$ultimo<BR>";
                $sIPLDS = "SELECT * FROM IPLDs WHERE Item_Number = '$T_PartNumber' ORDER BY WK0 DESC LIMIT 0, 1";
                $nIPLDS = $cnx->query($sIPLDS)->numRows();

                if($nIPLDS == 1){
                    $cw = 0;
                    $rIPLDS = $cnx->query($sIPLDS)->fetchArray();
                    while($cw < 16){
                        $cw++;
                        switch ($cw){
                            case 1:
                                $dw1 = $rIPLDS['WK0'];
                                break;
                            case 2:
                                $dw2 = $rIPLDS['WK1'];
                                break;
                            case 3:
                                $dw3 = $rIPLDS['WK2'];
                                break;
                            case 4:
                                $dw4 = $rIPLDS['WK3'];
                                break;
                            case 5:
                                $dw5 = $rIPLDS['WK4'];
                                break;
                            case 6:
                                $dw6 = $rIPLDS['WK5'];
                                break;
                            case 7:
                                $dw7 = $rIPLDS['WK6'];
                                break;
                            case 8:
                                $dw8 = $rIPLDS['WK7'];
                                break;
                            case 9:
                                $dw9 = $rIPLDS['WK8'];
                                break;
                            case 10:
                                $dw10 = $rIPLDS['WK9'];
                                break;
                            case 11:
                                $dw11 = $rIPLDS['WK10'];
                                break;
                            case 12:
                                $dw12 = $rIPLDS['WK11'];
                                break;
                            case 13:
                                //$dw13 = $rIPLDS['WK12'];
                                $dw13 = $rIPLDS['WK12'] + $rIPLDS['WK13'] + $rIPLDS['WK14'] + $rIPLDS['WK15'];
                                break;
                            case 14:
                                $dw14 = $rIPLDS['WK16'] + $rIPLDS['WK17'] + $rIPLDS['WK18'] + $rIPLDS['WK19'];
                                break;
                            case 15:
                                $dw15 = $rIPLDS['WK20'] + $rIPLDS['WK21'] + $rIPLDS['WK22'] + $rIPLDS['WK23'];
                                break;
                            case 16:
                                $dw16 = $rIPLDS['WK24'] + $rIPLDS['WK25'] + $rIPLDS['WK26'];
                                break;
                        }
                        
                        
                    }
                    
                    $qtyDemandN = "$dw1|$dw2|$dw3|$dw4|$dw5|$dw6|$dw7|$dw8|$dw9|$dw10|$dw11|$dw12|$dw13|$dw14|$dw15|$dw16";
                    
                } else {
                    $qtyDemandN = "$dw1|$dw2|$dw3|$dw4|$dw5|$dw6|$dw7|$dw8|$dw9|$dw10|$dw11|$dw12|$dw13|$dw14|$dw15|$dw16";
                }
                
                
                foreach ($ArrFriday as &$ViernesOPO) {
                    $ViernesPOP = date('M-d', strtotime($ViernesOPO));
                    $cDay++;
                    $vWee = "T_w" . $cDay;
                    $dWee = "D_w" . $cDay;
                    $BWee = "B_w" . $cDay;
                    $dem = "dw" . $cDay;

                    $valor = $$vWee;
                    $OHPart = $Delta;

                    if(isset($ArrPartD[$T_PartNumber][$cDay])){
                        $demand = $ArrPartD[$T_PartNumber][$cDay];
                        //$valor = $valor - $ArrPartD[$T_PartNumber][$cDay];
                        //$valor = $OHPart - $ArrPartD[$T_PartNumber][$cDay];
                        //$Delta = $Delta - $ArrPartD[$T_PartNumber][$cDay];
                        $x = $ArrPartD[$T_PartNumber][$cDay];
                    } else {
                        $demand = 0;
                    }

                    $qtyDemand .= "$demand|";
                    
                    $demand = $$dem;
                    
                    
                    if($valor > 0 && $OHPart < 0){
                        $OHPart = $valor;
                    } else {
                        $OHPart = ($OHPart + $valor);
                    }
                    
                    

                    if($cDay == 1){
                        $OHPart = $OHPart + $T_OnHand + $T_OverIssue + $T_Consigned + $T_QtyExpired;
                        $fExp = number_format($T_QtyExpired, 0);
                        $fOH = number_format($T_OnHand, 0);
                        $fOV = number_format($T_OverIssue, 0);
                        $fCo = number_format($T_Consigned, 0);
                    } else {
                        $fExp = $fCo = $fOH = $fOV = 0;
                    }
                    
                    $qtyConf .= "$valor|";
                    
                    

                    if($Delta < 0 && $OHPart > 0){
                        $Delta = ($OHPart - $demand) + $Delta;
                    } else {
                        $Delta = $OHPart - $demand;
                    }

                    

                    if($OHPart < 0){
                        $OHPart = 0;
                    }

                    if($Delta > 0){
                        $colW = "background-color:yellowgreen;";
                        $colT = "color:black;";
                        
                    } else {
                        if($Delta == 0){
                            $colW = "";
                            $colT = "color:" . $rowColor2 . ";";
                        } else {
                            $colW = "background-color:red;";
                            $colT = "color:white;";
                        }
                    }


                    $valorF = number_format($valor, 0); //. " - $x"
                    $DeltaF = number_format($Delta, 0); //. " - $x"
                    $OHPartF = number_format($OHPart, 0);
                    $demandF = number_format($demand, 0);
                    $tDemand += $demand;
                    $Extracss = $colW . $colT;
                    
                    $$dWee = $Delta;

                    //Label y Ribon
                    if($T_BCode == "B" || $T_In_Ty == "SA" || $T_Engr == "L" || $T_Mfgr == "NAZDAR COMPANY" || $T_PartNumber == "18-001029-01|01" || $T_PartNumber == "27-010109-20|01" || $T_PartNumber == "DIG-001R|01" || empty($T_MfgrPN) || strpos(strtolower($T_Description), "label") !== false || strpos(strtolower($T_Description), "ribbon") !== false){
                            $$BWee = 1000;
                    } else {
                        if($Delta < 0){
                            $$BWee = -1;
                        } else {
                            $$BWee = 1;
                        }
                    }



                }
                
                //Consulta la demanda en Total
                $sPTD = "SELECT Reqmnt_Qty FROM InvDetail WHERE ID = '$T_PartNumber' ORDER BY Reqmnt_Qty DESC LIMIT 0, 1";
                $nPTD = $cnx->query($sPTD)->numRows();
                
                if($nPTD == 1){
                    $rPTD = $cnx->query($sPTD)->fetchArray();
                    $tPD = $rPTD['Reqmnt_Qty'];
                } else {
                    $tPD = 0;
                }
                
                if(!empty($qtyConf)){
                    $qtyConf = substr($qtyConf, 0, -1);
                }
                
                if(!empty($qtyDemand)){
                    $qtyDemand = substr($qtyDemand, 0, -1);
                }
                
                //echo $qtyConf . "<BR>";

                $TAlternative = "";
                
                //Busca alternativos
                $sAlt = "SELECT Mfgr_Name, Prim_Ven, Mfgr_Item_Nbr, Vendor_Id FROM PartData WHERE Item_Number = '$T_PartNumber' AND Prim_Ven = 'P' GROUP BY Mfgr_Name, Prim_Ven, Mfgr_Item_Nbr ORDER BY Prim_Ven ASC LIMIT 0, 1";
                $nAlt = $cnx->query($sAlt)->NumRows();
                $PPartN = "";
                if($nAlt == 1){
                    $rA = $cnx->query($sAlt)->fetchArray();
                    $Alter = $rA['Mfgr_Name'];
                    $AlterP = $rA['Prim_Ven'];
                    $AlterMGP = $rA['Mfgr_Item_Nbr'];
                    $AlterVendorID = $rA['Vendor_Id'];
                    $PPartN = $AlterVendorID;
                } else {
                    $PPartN = "";
                }
                
                $sCC = "SELECT DISTINCT Class_Code FROM PartData WHERE Item_Number = '$T_PartNumber'";
                $nCC = $cnx->query($sCC)->numRows();
                
                if($nCC > 0){
                    if($nCC == 1){
                        $rCC = $cnx->query($sCC)->fetchArray();
                        $aCC = $rCC['Class_Code'];
                    } else {
                        $rCC = $cnx->query($sCC)->fetchAll();
                        $aCC = "";
                        foreach ($rCC AS &$rCx){
                            $aCC .= $rCx['Class_Code'] . "|";
                        }
                        
                        $aCC = substr($aCC, 0, -1);
                        
                        
                    }
                } else {
                    $aCC = "";
                }
                
                
                $ArrNConfirm = $T_UnConfirm;
                $ArrConfirm = $T_Confirm;
                $ArrExpired = $T_Expired;
                $OrdenArr = 0;
                
                if($tDemand == 0){
                    $OrdenArr = 100000000000;
                } else {
                    $OrdenArr = ($B_w1 * 17) + ($B_w2 * 16) + ($B_w3 * 15) + ($B_w4 * 14) + ($B_w5 * 13) + ($B_w6 * 12) + ($B_w7 * 11) + ($B_w8 * 10) + ($B_w9 * 9) + ($B_w10 * 8) + ($B_w11 * 7) + ($B_w12 * 6) + ($B_w13 * 5) + ($B_w14 * 4) + ($B_w15 * 3) + ($B_w16 * 2);
                
                }
                
                if($T_PartNumber == "130-067|01"){
                    //echo $tDemand . " - $OrdenArr<BR>";
                }
                
                if($OrdenArr == 0){
                    if($tDemand <= 0){
                        $OrdenArr = 100000000000;
                    } else {
                        $OrdenArr = 100000000;
                    }
                }
                
                if($T_PartNumber == "130-067|01"){
                    //echo $tDemand . " - $OrdenArr<BR>";
                }
                
                
                //echo "$T_PartNumber - $qtyDemandN<BR>";
                //echo "$T_PartNumber - $qtyDemand<BR><BR>";
                
                //$OrdenArr = 1;
                //$Movements = "</tr>"
                $ArrayDatos[] = array($T_PartNumber, $T_Description, $TNote, $Movements, $TAlternative, $T_Mfgr, $T_MfgrPN, $T_OnHand, $T_OverIssue, $T_LeadTime, $D_w1, $D_w2, $D_w3, $D_w4, $D_w5, $D_w6, $D_w7, $D_w8, $D_w9, $D_w10, $D_w11, $D_w12, $D_w13, $D_w14, $D_w15, $D_w16, $OrdenArr, $ArrNConfirm, $ArrExpired, $T_QtyExpired, $ArrConfirm, $T_Assemblies, $qtyConf, $qtyDemandN, $T_Engr, $T_Consigned, $T_WipO, $PPartN, $aCC);
                //$D_w1 = 0;


            }
            $countr3 = 0;
            $countr4 = 0;
            //print_r($ArrayDatos);
            
            //*****************************************************IMPRIME LOS ENSAMBLES
            //echo $TR_Assy;
            
            

            // a partir de PHP 5.5.0 puede usar array_column() en lugar del código anterior
            $OrdenA  = array_column($ArrayDatos, 26);
            $WeekA = array_column($ArrayDatos, 10);
            $Week2 = array_column($ArrayDatos, 11);
            $Week3 = array_column($ArrayDatos, 12);
            $Week4 = array_column($ArrayDatos, 13);
            $Week5 = array_column($ArrayDatos, 14);
            $Week6 = array_column($ArrayDatos, 15);
            $Week7 = array_column($ArrayDatos, 16);
            $Week8 = array_column($ArrayDatos, 17);
            $Week9 = array_column($ArrayDatos, 18);
            $Week10 = array_column($ArrayDatos, 19);
            $Week11 = array_column($ArrayDatos, 20);
            $Week12 = array_column($ArrayDatos, 21);
            $Week13 = array_column($ArrayDatos, 22);
            $Week14 = array_column($ArrayDatos, 23);
            $Week15 = array_column($ArrayDatos, 24);
            $Week16 = array_column($ArrayDatos, 25);


            // Ordenar los datos con volumen descendiente, edición ascendiente
            // Agregar $datos como el último parámetro, para ordenar por la clave común
            array_multisort($OrdenA, SORT_ASC, $ArrayDatos);

            $countrows = 0;
            foreach ($ArrayDatos AS &$AD){
                $countrows++;
                $countr3++;
                $countr4++;
                $ArrV = $countr4 . "S";
                $ArrParts[$ArrV] = array($ArrV);
                $A_PartNumber = $AD[0];
                $A_Description = $AD[1];
                $A_Note = $AD[2];
                $A_Movements = $AD[3];
                $A_Alternative = $AD[4];
                $A_Mfgr = $AD[5];
                $A_MfgrPN = $AD[6];
                $A_OnHand = $AD[7];
                $A_OverIssue = $AD[8];
                $A_LeadTime = $AD[9];
                $A_w1 = $AD[10];
                $A_w2 = $AD[11];
                $A_w3 = $AD[12];
                $A_w4 = $AD[13];
                $A_w5 = $AD[14];
                $A_w6 = $AD[15];
                $A_w7 = $AD[16];
                $A_w8 = $AD[17];
                $A_w9 = $AD[18];
                $A_w10 = $AD[19];
                $A_w11 = $AD[20];
                $A_w12 = $AD[21];
                $A_w13 = $AD[22];
                $A_w14 = $AD[23];
                $A_w15 = $AD[24];
                $A_w16 = $AD[25];
                $A_Orden = $AD[26];
                $A_NConfirm = $AD[27];
                $A_Expired = $AD[28];
                $A_QExpired = $AD[29];
                $A_Confirm = $AD[30];
                $A_TAssy = $AD[31];
                $A_QtyConf = $AD[32];
                $A_Demand = $AD[33];
                $A_Engr = $AD[34];
                $A_ConsignedX = $AD[35];
                $A_WipO = $AD[36];
                $A_PriVendor = $AD[37];
                $A_CC = $AD[38];
                $A_DescriptionY = "\"$A_Description\"";
                $A_MfgrY = "\"$A_Mfgr\"";
                $A_MfgrPNY = "\"$A_MfgrPN\"";
                array_push($ArrParts[$ArrV], 'Shortage w/conf PO', $A_PartNumber, $A_DescriptionY, $A_MfgrY, $A_MfgrPNY, $A_OnHand, $A_OverIssue, $A_LeadTime, $A_w1, $A_w2, $A_w3, $A_w4, $A_w5, $A_w6, $A_w7, $A_w8, $A_w9, $A_w10, $A_w11, $A_w12, $A_w13, $A_w14, $A_w15, $A_w16, $A_QtyConf,$A_Demand,$A_QExpired,$A_TAssy,$A_Engr,$A_ConsignedX,$A_PriVendor,$A_CC);
                //echo $A_NConfirm;
                 
            }

            //*print_r($ArrayDatos);
        }
        //print_r($ArrColorAssy);
        //print_r($ArrParts);
        //*****************************************************IMPRIME LOS ASSY
        $countrAss = 0;
        $countAss = 0;
        foreach ($ArrAssy as &$Assies) {
            $countrAss++;
            $countAss++;
            if($countrAss == 2){
                $rowColor = "#e7e7e7";
                $countrAss = 0;
            } else {
                $rowColor = "white";
            }
            
            $Ensxxx = $Assies[1];
            
            
            
        }
        //echo $TR_AssyArr;
        //*****************************************************IMPRIME LOS REVENUE
        //echo $TR_Table;
        //*****************************************************IMPRIME LOS DATOS
        //echo $TR_Data;
        echo "<center><BR><div style='width:50%;color:black;background-color:yellowgreen;padding:20px;font-size:20;text-align=center;'>Termine...:)</div></center>";
        //print_r($ArrColorAssy);
      //  $testthisplease = $_GET['KeyI'];
       // echo("<script>console.log('PHP a: " . $testthisplease . "');</script>");
        ?>
    </table>
    </form>
    <?php
    
    
    
    $gettokenx = base64_encode($gClassCode);
    /*    
    //***************************** DESCARGAR PLAN PRODUCCION
    if(!empty($ArrSave)){
        $LinkDPP = "Include/reportCSV.php?report=CTB_ProductionPlan16&token=$gettokenx";

        $b64StrPP = base64_encode(serialize($ArrAssy));
        $b64StrDates = base64_encode(serialize($ArrFriday));
        ?>
        <div style="position:absolute;right:200px;top:5px;width:100;text-align: right;vertical-align: middle;">
            <form action="<?php echo $LinkDPP; ?>" name="form_dpp" target="_blank" method="post">
                <textarea name="ppSer" cols="20" rows="1" hidden="hidden"><?php echo $b64StrPP;?></textarea><br>
                <textarea name="ppDates" cols="20" rows="1" hidden="hidden"><?php echo $b64StrDates;?></textarea><br>
                <input type="submit" value="[+] Download Production Plan >">
            </form>
        </div>
        <?php
        //echo "Link Guardar";
    }
    */
    
    //***************************** DESCARGAR IMPACTO PLAN PRODUCCION
    if(!empty($ArrSave)){
        $LinkDPP = "Include/reportCSV.php?report=CTB_ImpactProductionPlan16&token=$gettokenx";

        $b64StrIPP = base64_encode(serialize($ArrParts));
        $b64StrPP = base64_encode(serialize($ArrAssy));
        $b64StrIDates = base64_encode(serialize($ArrFriday));
        ?>
    <center>
        <div>
            <form action="<?php echo $LinkDPP; ?>" name="form_dpp" target="_blank" method="post">
                <textarea name="ppISer" cols="20" rows="1" hidden="hidden"><?php echo $b64StrIPP;?></textarea><br>
                <textarea name="ppDates" cols="20" rows="1" hidden="hidden"><?php echo $b64StrIDates;?></textarea>
                <textarea name="ppAss" cols="20" rows="1" hidden="hidden"><?php echo $b64StrPP;?></textarea><br>
                <input type="submit" value="[+] Download Parts Production Plan >" style="padding:5px;font-size:15px;font-family:verdana;">
            </form>
        </div>
    </center>
        <?php
        //echo "Link Guardar";
    }
    ?>
</div>
        <?php
        
        
        break;
    case "vProductionPlanReal":
        if(empty($gCustomer)){
            $gCustomer = base64_decode($_GET['token']);
            $gClassCode = base64_decode($_GET['tokeni']);
        }
        
        $gettoken = base64_encode($gCustomer);
        $gettokeni = base64_encode($gClassCode);
        
        //Array Fridays
        $nweeks = 10;
        $nextFriday = date('Y-m-d', strtotime('next friday'));
        //echo $nextFriday;
        $ArrFriday[] = $nextFriday;
        $cweeks = 1;
        while ($cweeks < $nweeks){
            $cweeks++;
            $nextFriday = date('Y-m-d', strtotime('next friday', strtotime($nextFriday)));
            $ArrFriday[] = $nextFriday;
        }
        
        //print_r($ArrFriday);
        //*echo $gCustomer . "-" . $gClassCode;
        ?>
<div style="width:100%;font-family: 'Roboto';font-size:1em;text-align: center;font-weight: 100;">
    <p style="font-family: 'Roboto';font-size:1.5em;text-align: center;font-weight: 100;">
    Customer: <strong><?php echo $gCustomer . " ($gClassCode)";?></strong>
    </p><BR><BR>
    <table style="width: 100%;">
        <caption style="font-family: 'Roboto';font-size:1em;"></caption>
        <tr>
            <th scope="col"></th>
            <th scope="col"></th>
            <th scope="col"></th>
            <th scope="col"></th>
            <th scope="col"></th>
            <th scope="col"></th>
            <th scope="col"></th>
            <th scope="col"></th>
            <th scope="col"></th>
            <th scope="col"></th>
            <th scope="col"></th>
            <th scope="col"></th>
            <th scope="col"></th>
            <th scope="col"></th>
            <th scope="col"></th>
            <th scope="col"></th>
            <th scope="col"></th>
        </tr>
        <tr>
            <td colspan="3" style="font-family: 'Roboto';font-size:1em;text-align: center;background-color: gray;">
                Assemblies:
            </td>
            <td colspan="4" style="font-family: 'Roboto';font-size:1em;"></td>
            <?php
                foreach ($ArrFriday as &$Frid) {
                    $Viernes = date('M-d', strtotime($Frid));
                    ?>
            <td style="font-family: 'Roboto';font-size:.8em;text-align: center;background-color: gray;"><?php echo $Viernes;?></td>
            <?php
                }
            ?>
        </tr>
        <?php
        $ExtraBOM = "(";
        //Obtiene los diferentes ensambles
        $sAssy = "SELECT DISTINCT Parent_Part_Assembly FROM BOM WHERE Class_Code LIKE '$gClassCode' ORDER BY Parent_Part_Assembly ASC";
        $rAssy = $cnx->query($sAssy)->fetchAll();
        $countr = 0;
        foreach ($rAssy AS &$rA){
            $countr++;
            $gAssy = $rA['Parent_Part_Assembly'];
            $ExtraBOM .= " Parent_Part_Assembly = '$gAssy' OR ";
            
            //*echo $gAssy . "<BR>";
            if($countr == 2){
                $rowColor = "#e7e7e7";
                $countr = 0;
            } else {
                $rowColor = "white";
            }
            
            $ArrAssy[] = $gAssy;
            
            ?>
        <tr onmouseout="this.bgColor='<?php echo $rowColor;?>'" onmouseover="this.bgColor='#E0ECF8'" bgcolor="<?php echo $rowColor;?>">
            <td colspan="3" style="font-family: 'Roboto';font-size:.8em;text-align: justify;">
                <?php echo $gAssy;?>
            </td>
            <td colspan="4" style="font-family: 'Roboto';font-size:.8em;">Y</td>
                <?php
                foreach ($ArrFriday as &$Frid2) {
                    ?>
            <td style="font-family: 'Roboto';font-size:.8em;text-align: center;">
                <input value="<?php echo $valX;?>" type="number" style="width: 4em;">
            </td>
            <?php
                }
            ?>
        </tr>
        <?php
            
        }
        
        if(!empty($ExtraBOM)){
            $ExtraBOM = substr($ExtraBOM, 0, - 3) . ")";
        }
        //echo $ExtraBOM;
        //print_r($ArrAssy);
        ?>
        <tr>
            <td style="font-family: 'Roboto';font-size:.8em;text-align: center;background-color: gray;">
                Item
            </td>
            <td style="font-family: 'Roboto';font-size:.8em;text-align: center;background-color: gray;">
                Description
            </td>
            <td style="font-family: 'Roboto';font-size:.8em;text-align: center;background-color: gray;">
                Mfgr
            </td>
            <td style="font-family: 'Roboto';font-size:.8em;text-align: center;background-color: gray;">
                Mfgr PN
            </td>
            <td style="font-family: 'Roboto';font-size:.8em;text-align: center;background-color: gray;">
                MW OH
            </td>
            <td style="font-family: 'Roboto';font-size:.8em;text-align: center;background-color: gray;">
                OvI
            </td>
            <td style="font-family: 'Roboto';font-size:.8em;text-align: center;background-color: gray;">
                LT w
            </td>
            <?php
            foreach ($ArrFriday as &$Frid) {
                $Viernes = date('M-d', strtotime($Frid));
                ?>
            <td style="font-family: 'Roboto';font-size:.8em;text-align: center;background-color: gray;"><?php echo $Viernes;?></td>
            <?php
                }
            ?>
        </tr>
        <?php
        $sPart = "SELECT Item_Nbr, Lead_Time FROM BOM WHERE $ExtraBOM GROUP BY Item_Nbr, Lead_Time ORDER BY Item_Nbr ASC";
        $rPart = $cnx->query($sPart)->fetchAll();
        //echo $sPart;
        $countr2 = 0;
        $countP = 0;
        foreach ($rPart AS &$rP){
            $countr2++;
            $countP++;
            $Item = $rP['Item_Nbr'];
            $LeadTime = $rP['Lead_Time'];
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
            
            
            
            if($countr2 == 2){
                $rowColor2 = "#e7e7e7";
                $countr2 = 0;
            } else {
                $rowColor2 = "white";
            }
            ?>
        <tr onmouseout="this.bgColor='<?php echo $rowColor2;?>'" onmouseover="this.bgColor='#E0ECF8'" bgcolor="<?php echo $rowColor2;?>">
            <td style="font-family: 'Roboto';font-size:.8em;text-align: center;">
                <?php echo $Item;?>
            </td>
            <td style="font-family: 'Roboto';font-size:.8em;text-align: center;">
                <?php echo $gDescI;?>
            </td>
            <td style="font-family: 'Roboto';font-size:.8em;text-align: center;">
                <?php echo $gMfgr;?>
            </td>
            <td style="font-family: 'Roboto';font-size:.8em;text-align: center;">
                <?php echo $gMfgrNP;?>
            </td>
            <td style="font-family: 'Roboto';font-size:.8em;text-align: center;">
                MW OH
            </td>
            <td style="font-family: 'Roboto';font-size:.8em;text-align: center;">
                OvI
            </td>
            <td style="font-family: 'Roboto';font-size:.8em;text-align: center;">
                <?php echo $LeadTime;?>
            </td>
            <?php
            $curDate = $dateToday;
            foreach ($ArrFriday as &$ViernesOPO) {
                //$ViernesOPO = date('M-d', strtotime($Frid));
                //Obtiene el Plan de OPen PO
                $sQtyPlan = "SELECT SUM(Balance_Due) AS QtyBalance FROM PodData "
                        . "WHERE Part_Nbr = '$Item' AND Vendor_Promise_Dt > '2000-01-01' "
                        . "AND Vendor_Promise_Dt BETWEEN '$curDate' AND '$ViernesOPO'";
                $nQtyPlan = $cnx->query($sQtyPlan)->numRows();
                $curDate = date('Y-m-d', strtotime('+1 days', strtotime($ViernesOPO)));
                if($countP == 1){
                    echo $sQtyPlan . "<BR>";
                }
                $rQty = $cnx->query($sQtyPlan)->fetchArray();
                $QtyFri = $rQty['QtyBalance'];
                
                if(empty($QtyFri)){
                    $QtyFri = 0;
                }
                
                ?>
            <td style="font-family: 'Roboto';font-size:.8em;text-align: center;"><?php echo $QtyFri;?></td>
            <?php
                }
            ?>
        </tr>
        <?php            
        }
        
        ?>
    </table>
</div>
        <?php
        
        
        break;
    case "vCustomer":
        if(empty($gKeyIII)){
            $gKeyIII = $_GET['KeyIII'];
        }
        
        if(empty($gCustomer)){
            $gCustomer = base64_decode($_GET['token']);
            
            if(empty($gCustomer)){
                $gCustomer = $_POST['Customer'];
            }
        }
        $gettoken = base64_encode($gCustomer);
        
        //Valida si existe preload
        $sPreload = "SELECT * FROM ConsultPP WHERE Customer = '$gCustomer' AND Assembly = '16' ORDER BY DTConsult DESC LIMIT 0, 1";
        $nPreload = $cnx->query($sPreload)->numRows();
        
        if($nPreload == 1){
            $rPreload = $cnx->query($sPreload)->fetchArray();
            $getKeyI = base64_encode($rPreload['ConsultName']);
            
            $vATipo = "Verde";
            $vAMensaje = "Redirect Site...!";
            $vRedirect = "Dynamic.php?sI=$sI&sII=vProductionPlan&sIII=$sIII&sIV=Home&token=$gettoken&tokeni=$gettokeni&tokenii=$gettokenii&KeyI=$getKeyI&KeyII=$getKeyII&KeyIII=$gKeyIII";
            $vATime = 100;
            echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
        } else {

            //echo $gCustomer . "-" . $gClassCode;
            $vATipo = "Verde";
            $vAMensaje = "No Preload Information, Redirect Site...!";
            $vRedirect = "Dynamic.php?sI=$sI&sII=vProductionPlan";
            $vATime = 100;
            echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);

        }
        
        
        break;
    case "vCustomerX":
        if(empty($gCustomer)){
            $gCustomer = base64_decode($_GET['token']);
            
            if(empty($gCustomer)){
                $gCustomer = $_POST['Customer'];
            }
        }
        
        $gettoken = base64_encode($gCustomer);
        
        //echo $gCustomer . "-" . $gClassCode;
        $vATipo = "Verde";
        $vAMensaje = "Redirecting Site...!";
        $vRedirect = "Dynamic.php?sI=$sI&sII=vCustomer&sIII=$sIII&sIV=Home&token=$gettoken&tokeni=$gettokeni&tokenii=$gettokenii&KeyI=$getKeyI&KeyII=$getKeyII&KeyIII=0";
        $vATime = 200;
        echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
        
        break;
    case "vCustomerY":
        $gCustomer = $_POST['Customer'];
        //Selecciona el Cliente
        $aGForm = array("<br><br><font style='font-size:14px;'>Production Plan Preloaded</font><br>", "60%", "", "");
        //Link, Title, target, class, $sI, SII, $sIII, $sIV, token, tokeni, tokenii
        $aLinks = array(
            //array("", "< Back", "", "linkr", "", "$sI", "$sII", "Home", "Home", "", "", "")
        );

        $sCust = "SELECT * FROM ConsultPP WHERE Assembly = '16' AND ClassCode = '$gCustomer' ORDER BY DTConsult DESC LIMIT 0, 30";
        $lCust = $cnx->query($sCust)->fetchAll();

        $Customers = "";

        foreach ($lCust AS &$rCust){
            $KeyDTConsult = str_replace(":", ",", $rCust['DTConsult']);
            $KeyConsult = $rCust['ConsultName'];
            $KeyCustomer = $rCust['Customer'];

            $Customers .= $KeyConsult . ":" . "$KeyCustomer - $KeyDTConsult|";
        }

        if(!empty($Customers)){
            $Customers = substr($Customers, 0, -1);
        }
        $sIII = "IPLDs";

        //campos: action, label, id, class, tipo, name, value, checked, selected, focus  
        $aFields = array(
            array("Dynamic.php?sI=$sI&sII=vProductionPlan&sIII=$sIII&sIV=$sIV&token=$gettoken&tokeni=$gettokeni&token=$gettokeni&KeyIII=1", "", "formx", "formx", "post", "addfile", "", "", "", ""),
            array("", "Created:", "Key", "stext", "select", "Key", "$Customers", "", " size='50' ", "1")
        );
        echo drawForm($aGForm, $aLinks, $aFields);
        break;
    default:
        
        //Selecciona el Cliente
        $aGForm = array("<br><br><font style='font-size:14px;'>Production Plan By Customer</font><br>", "60%", "", "");
        //Link, Title, target, class, $sI, SII, $sIII, $sIV, token, tokeni, tokenii
        $aLinks = array(
            //array("", "< Back", "", "linkr", "", "$sI", "$sII", "Home", "Home", "", "", "")
        );

        $sCust = "SELECT ClassCode, Customer FROM ConsultPP WHERE Customer != '' GROUP BY ClassCode, Customer ORDER BY Customer ASC";
        $lCust = $cnx->query($sCust)->fetchAll();

        $Customers = "";

        foreach ($lCust AS &$rCust){
            $gCC = $rCust['ClassCode'];
            $gCust = $rCust['Customer'];
            $Customers .= "$gCC:$gCust|";
        }

        if(!empty($Customers)){
            $Customers = substr($Customers, 0, -1);
        }

        //campos: action, label, id, class, tipo, name, value, checked, selected, focus  
        $aFields = array(
            array("Dynamic.php?sI=$sI&sII=vCustomerY&sIII=$sIII&sIV=$sIV&token=$gettoken&tokeni=$gettokeni&token=$gettokeni", "", "formx", "formx", "post", "addfile", "", "", "", ""),
            array("", "Customer:", "Customer", "stext", "select", "Customer", "$Customers", "", "", "1")
        );
        echo drawForm($aGForm, $aLinks, $aFields);


        break;
}