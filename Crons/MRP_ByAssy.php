#!/usr/bin/php

<?php
error_reporting(0);
//include('../WD-HGST/ProgressBar.php');
$File = "MRPMasterWork";
include '/var/www/html/Supply/PHPClass/DB.php';
include '/var/www/html/Supply/PHPFunctions/var.php';
include '/var/www/html/Supply/PHPFunctions/Function_SMS.php';


echo "\r\n\r\n***************************** Busca BOM ********************\r\n";
$sPO = "SELECT Item_WO_GL_Nbr, "
        . "SUM(IF(Required_Ship_Dt < '2021-10-31',Bal_Qty,0)) AS OctQty, "
        . "SUM(IF(Required_Ship_Dt BETWEEN '2021-11-01' AND '2021-11-30',Bal_Qty,0)) AS NovQty, "
        . "SUM(IF(Required_Ship_Dt BETWEEN '2021-12-01' AND '2021-12-31',Bal_Qty,0)) AS DecQty "
        . "FROM chapalac_masterwork.OpenPOs WHERE Bal_Qty > '0' "
        . "GROUP BY Item_WO_GL_Nbr ORDER BY Item_WO_GL_Nbr ASC";













$ahorita = date('Y-m-d h:i:s', time());
echo "\r\nINICIE....\r\n$ahorita\r\n\r\n";
//N $log = "";
$gdate = $_GET['date'];
if($gdate == ""){
    $gdate = date('Y-m-d', time());
}

$dtahora = $gdate . " 15:30:00";
$getDATE = date('Ymd', strtotime($gdate));


$qPO = mysql_query($sPO, $cnx);
$nPO = mysql_num_rows($qPO);

$pg = new PHPTerminalProgressBar($nPO, "Progress: [:bar] - :current/:total - :percent% - Elapsed::elapseds - ETA::etas - Rate::rate/s");

while($rPO = mysql_fetch_array($qPO)){
    //Carga el plan
    $Assy = $rPO['Item_WO_GL_Nbr'];
    $ReqOct = $rPO['OctQty'];
    $ReqNov = $rPO['NovQty'];
    $ReqDec = $rPO['DecQty'];
    //Obtiene el KIT WIP en piso
    $sOnKitMat = "SELECT SUM(Qty_On_Hand) AS QtyKit FROM InvFG WHERE ID = '$Assy'";
    $qOnKitMat = mysql_query($sOnKitMat, $cnx);
    //* $nOnKitMat = mysql_num_rows($qOnKitMat);
    $rOnKit = mysql_fetch_array($qOnKitMat);
    $KitMat = $rOnKit['QtyKit'];
    if(empty($KitMat)):$KitMat=0;endif;
    
    //*echo "$KitMat -" . $sOnKitMat . "\r\n";
    
    if($ReqOct == ""){
        $ReqOct = 0;
    }
    
    if($ReqNov == ""){
        $ReqNov = 0;
    }
    
    if($ReqDec == ""){
        $ReqDec = 0;
    }
    
    //Revisa OnHand Assy
    $sOHAWIP = "SELECT SUM(Qty_Remaining) AS QtyAssy FROM WOPlanner WHERE Item_Number = '$Assy' AND Kit_Release_Date <= '$gdate'";
    $qOHAWIP = mysql_query($sOHAWIP, $cnx);
    //* $nOHAWIP = mysql_num_rows($qOHAWIP);
    $rOHAWIP = mysql_fetch_array($qOHAWIP);
    $AssyWIP = $rOHAWIP['QtyAssy'];
    if(empty($AssyWIP)):$AssyWIP=0;endif;
    
    //Total OH
    $TOH = $AssyWIP + $KitMat;
    $N =0;
    if($TOH > 0){
        //Solo si es igual o mayor a oct
        if($TOH >= $ReqOct){
            //Solo si es Igual
            if($TOH == $ReqOct){
                //Hay onhand menor a Oct
                $OHOct = $TOH;
                $BalOct = $ReqOct - $TOH;
                $OHNov = 0;
                $BalNov = $ReqNov;
                $OHDec = 0;
                $BalDec = $ReqDec;
                $N = 1;
            } else {
                //Es mayor a Oct
                $OHOct = $ReqOct;
                $BalOH = $TOH - $ReqOct;
                $BalOct = 0;
                //Solo si Nov es mayor a 0
                if($ReqNov > 0){
                    //Revisa la cantidad
                    if($BalOH >= $ReqNov){
                        //Mucho WIP
                        $OHNov = $ReqNov;
                        $BalNov = 0;
                        $RemainOH = $BalOH - $ReqNov;
                        
                        if($RemainOH > 0){
                            //Revisa si es mayor nov
                            if($ReqDec > 0){
                                //Consume Diciembre
                                if($RemainOH >= $ReqDec){
                                    $OHDec = $ReqDec;
                                    $BalDec = 0;
                                    $RemainOH = $RemainOH - $ReqDec;
                                    $N = 11;
                                    
                                } else {
                                    $OHDec = $RemainOH;
                                    $BalDec = $ReqDec - $RemainOH;
                                    $RemainOH = 0;
                                    $N = 10;
                                }
                                
                            } else {
                                $OHDec = 0;
                                $BalDec = $ReqDec;
                                $N = 9;
                            }
                            
                        } else {
                            $RemainOH = 0;
                            $OHDec = 0;
                            $BalDec = $ReqDec;
                            $N = 8;
                        }
                        
                    } else {
                        //Menos WIP
                        $BalNov = $ReqNov - $BalOH;
                        $OHNov = $BalOH;
                        $BalOH = 0;
                        $OHNov = 0;
                        $BalNov = $ReqNov;
                        $N = 7;
                    }
                    
                    
                } else {
                    //Nov no requiere
                    $OHNov = 0;
                    $BalNov = $ReqNov;
                    
                    if($ReqDec > 0){
                        //Consume Diciembre
                        if($BalOH >= $ReqDec){
                            $OHDec = $ReqDec;
                            $BalDec = 0;
                            $RemainOH = $BalOH - $ReqDec;
                            $N = 6;

                        } else {
                            $OHDec = $BalOH;
                            $BalDec = $ReqDec - $BalOH;
                            $RemainOH = 0;
                            $N = 5;
                        }
                    } else {
                        $OHDec = 0;
                        $BalDec = $ReqDec;
                        $RemainOH = $BalOH;
                        $N = 4;
                    }
                    
                }
                
            }
            
            
        } else {
            //Hay onhand menor a Oct
            $OHOct = $TOH;
            $BalOct = $ReqOct - $TOH;
            $OHNov = 0;
            $BalNov = $ReqNov;
            $OHDec = 0;
            $BalDec = $ReqDec;
            $RemainOH = 0;
            $N = 3;
        }
        
    } else {
        //No Hay Onhand
        $OHOct = $TOH;
        $BalOct = $ReqOct;
        $OHNov = 0;
        $BalNov = $ReqNov;
        $OHDec = 0;
        $BalDec = $ReqDec;
        $RemainOH = 0;
        $N = 2;
        
    }
    
    $AcumOctNov = $BalOct + $BalNov;
    $AcumOctDec = $AcumOctNov + $BalDec;
    $iPlan = "INSERT INTO PlanByAssy VALUES('0', '$Assy', '$ReqOct', '$KitMat', '$AssyWIP', '$OHOct', '$BalOct', '0', '$BalOct', '$ReqNov', '$OHNov', '$BalNov', '$AcumOctNov', '0', '$AcumOctNov', '$ReqDec', '$OHDec', '$BalDec', '$AcumOctDec', '0', '$AcumOctDec', '$RemainOH', NOW(), 'Created')";
    mysql_query($iPlan, $cnx);
    $pg->tick();
}

echo "\r\n\r\n***************************** Busca PARTS ********************\r\n";

//################################################################OCTUBRE
$sOct = "SELECT idPlanByAssy, Assy, RemainOct, BalNov, RemainNov, BalDec, RemainDec FROM PlanByAssy "
        . "ORDER BY RemainOct DESC";
$qOct = mysql_query($sOct, $cnx);
$nOct = mysql_num_rows($qOct);
$pgB = new PHPTerminalProgressBar($nOct, "Progress: [:bar] - :current/:total - :percent% - Elapsed::elapseds - ETA::etas - Rate::rate/s");
$count = 0;
//*echo $sOct . "\r\n";
while ($rOct = mysql_fetch_array($qOct)){
    $count++;
    $gidAssy = $rOct['idPlanByAssy'];
    $gAssy = $rOct['Assy'];
    $gROct = $rOct['RemainOct'];
    $gBNov = $rOct['BalNov'];
    //*$gAcNov = $rOct['AcumOct_Nov'];
    $gRNov = $rOct['RemainNov'];
    $gBDec = $rOct['BalDec'];
    //*$gAcDec = $rOct['AcumOct_Dec'];
    $gRDec = $rOct['RemainDec'];
    //*echo "$count - $gidAssy - $gROct\r\n";
    //Ahora el BOM
    if($gROct > 0){
        //Busca BOM
        //Obtiene el BOM
        $sBOM = "SELECT * FROM BOM2 WHERE Parent_Part_Assembly = '$gAssy' ORDER BY Qty_Assy DESC"; //  OR Item_Nbr = '$g_Item_WO_GL_Nbr'
        $qBOM = mysql_query($sBOM, $cnx);
        $nBOM = mysql_num_rows($qBOM);
        //*echo "$sBOM\r\n";
        if($nBOM > 0){
            while ($rBOM = mysql_fetch_array($qBOM)){
                //Obtiene el BOM
                $B_Item_Nbr = $rBOM['Item_Nbr'];
                $B_Qty_Assy = $rBOM['Qty_Assy'];
                //Partes Requeridas
                
                
                //Busca inventario
                $sBal = "SELECT OHOct, UsedOct, BalOct FROM PlannedOH WHERE Part_Nbr = '$B_Item_Nbr'";
                $qBal = mysql_query($sBal, $cnx);
                $nBal = mysql_num_rows($qBal);
                //*echo $sBal . "\r\n";
                
                if($nBal == 1){
                    //Busca
                    $rBal = mysql_fetch_array($qBal);
                    $gOHOct = $rBal['OHOct'];
                    $gUsedOct = $rBal['UsedOct'];
                    $gBalOct = $rBal['BalOct'];
                    
                    $maxOH = round($gBalOct / $B_Qty_Assy, 0);
                    //*echo "Datos: $gOHOct - $gUsedOct - $gBalOct - $B_Qty_Assy - $maxOH\r\n";
                    
                } else {
                    $gOHOct = 0;
                    $gUsedOct = 0;
                    $gBalOct = 0;
                    $maxOH = 0;
                }
                
                
                
                
                $iTemp = "INSERT INTO TempParts VALUES('0', '$gidAssy', "
                        . "'$gAssy', 'Oct', '$gROct', '$B_Item_Nbr', '$B_Qty_Assy', "
                        . "'$gOHOct', '$gUsedOct', '$gBalOct', '$maxOH')";
                mysql_query($iTemp, $cnx);
                //$aPart[] = array($g_idSOPlanner, $B_Item_Nbr, $B_Qty_Assy, $rQty, $OnHand, $MaxCTB);
                //N echo "$g_idSOPlanner - $B_Item_Nbr - $rQty\r\n";
                //*echo $iTemp . "\r\n";
                
            }
            
            $status = "OKBOM";
            $uPlanByAssy = "UPDATE PlanByAssy SET Status = '$status' "
                    . "WHERE idPlanByAssy = '$gidAssy'";
            mysql_query($uPlanByAssy, $cnx);
            
        } else {
            $status = "NOBOM";
            $uPlanByAssy = "UPDATE PlanByAssy SET Status = '$status' "
                    . "WHERE idPlanByAssy = '$gidAssy'";
            mysql_query($uPlanByAssy, $cnx);
        }
        
        //Revisa cual es el maximo
        $sMin = "SELECT MIN(maxKit) AS mKit FROM TempParts WHERE Mes = 'Oct' AND idAssy = '$gidAssy'";
        $qMin = mysql_query($sMin, $cnx);
        $rMin = mysql_fetch_array($qMin);
        $MinAssOct = $rMin['mKit'];
        
        //*echo "Orig: " . $MinAssOct . "\r\n";
        if($MinAssOct > 0){
            //Depende la cantidad
            if($MinAssOct >= $gROct){
                //Mayor a lo requerido
                $MinAssOct = $gROct;
                
            }
            //*echo "Orig2: " . $MinAssOct . "\r\n";
            
            //Asignar partes para ensamble
            $sPU = "SELECT * FROM TempParts WHERE Mes = 'Oct' AND idAssy = '$gidAssy'";
            $qPU = mysql_query($sPU, $cnx);
            while ($rPU = mysql_fetch_array($qPU)){
                //Depende lo usado
                $gBalMes = $rPU['BalMes'];
                $gQtyxU = $rPU['QtyPart'];
                $gParte = $rPU['Part'];
                $UsedPart = $gQtyxU * $MinAssOct;
                //Actualiza QtyPartes
                $sBalA = "SELECT OHOct, UsedOct, BalOct, BalNov, BalDec, OHAftDec FROM PlannedOH WHERE Part_Nbr = '$gParte'";
                $qBalA = mysql_query($sBalA, $cnx);
                $nBalA = mysql_num_rows($qBalA);
                if($nBalA == 1){
                    //Busca
                    $rBalA = mysql_fetch_array($qBalA);
                    $gOHOctA = $rBalA['OHOct'];
                    $gUsedOctA = $rBalA['UsedOct'];
                    $gBalOctA = $rBalA['BalOct'];
                    $gBalNovA = $rBalA['BalNov'];
                    $gBalDecA = $rBalA['BalDec'];
                    $gBalAftDA = $rBalA['OHAftDec'];
                    
                    $nUsedPart = $gUsedOctA + $UsedPart;
                    $nBalOctPart = $gBalOctA - $UsedPart;
                    $nBalNovPart = $gBalNovA - $UsedPart;
                    $nBalDecPart = $gBalDecA - $UsedPart;
                    $nBalAftDec = $gBalAftDA - $UsedPart;
                    
                    //Actualiza Balance
                    $uPlanOH = "UPDATE PlannedOH SET UsedOct = '$nUsedPart', BalOct = '$nBalOctPart', "
                            . "BalNov = '$nBalNovPart', BalDec = '$nBalDecPart', OHAftDec = '$nBalAftDec' "
                            . "WHERE Part_Nbr = '$gParte'";
                    mysql_query($uPlanOH, $cnx);
                    //*echo $uPlanOH . "\r\n\r\n";
                }
                
                
                
            }
            
            $CTBOct = $MinAssOct;
            $RemainOct = $gROct - $CTBOct;
            $gRNov = $gBNov + $RemainOct;
            $gRDec = $gBDec + $gRNov;
            $RemainNov = $gRNov;
            $RemainDec = $gRDec;
            //$RemainDec = $gRDec - $CTBOct;
            ///$gRNov = $RemainNov;
            //$RemainDec = $gRDec;
            //$gAcNov = $RemainOct + $
            //Actualiza el plan CTB
            $uCTB = "UPDATE PlanByAssy SET CTBOct = '$CTBOct', RemainOct = '$RemainOct', "
                    . "RemainNov = '$RemainNov', RemainDec='$RemainDec' WHERE "
                    . "idPlanByAssy = '$gidAssy'";
            mysql_query($uCTB, $cnx);
            //*echo "Oct: " . $uCTB . "\r\n";
            
        } else {
            //*echo "Oct: NP\r\n";
            $nBalOctPart = $nUsedPart = $gBalMes = $gQtyxU = $gParte = $UsedPart = 0;
        }
        
        
            
    }
    
    //*********************************************************************NOVIEMBRE
    if($gRNov > 0){
        
        //Busca BOM
        //Obtiene el BOM
        $sBOM_N = "SELECT * FROM BOM2 WHERE Parent_Part_Assembly = '$gAssy' ORDER BY Qty_Assy DESC"; //  OR Item_Nbr = '$g_Item_WO_GL_Nbr'
        $qBOM_N = mysql_query($sBOM_N, $cnx);
        $nBOM_N = mysql_num_rows($qBOM_N);
        //N echo "$sBOM\r\n";
        if($nBOM_N > 0){
            while ($rBOM_N = mysql_fetch_array($qBOM_N)){
                //Obtiene el BOM
                $B_Item_Nbr_N = $rBOM_N['Item_Nbr'];
                $B_Qty_Assy_N = $rBOM_N['Qty_Assy'];
                //Partes Requeridas
                
                
                //Busca inventario
                $sBal_N = "SELECT OHNov, UsedNov, BalNov FROM PlannedOH WHERE Part_Nbr = '$B_Item_Nbr_N'";
                $qBal_N = mysql_query($sBal_N, $cnx);
                $nBal_N = mysql_num_rows($qBal_N);
                if($nBal_N == 1){
                    //Busca
                    $rBal_N = mysql_fetch_array($qBal_N);
                    $gOHNov = $rBal_N['OHNov'];
                    $gUsedNov = $rBal_N['UsedNov'];
                    $gBalNov = $rBal_N['BalNov'];
                    
                    $maxOH = round($gBalNov / $B_Qty_Assy_N, 0);
                    
                } else {
                    $gOHNov = 0;
                    $gUsedNov = 0;
                    $gBalNov = 0;
                    $maxOH = 0;
                }
                
                $iTemp = "INSERT INTO TempParts VALUES('0', '$gidAssy', "
                        . "'$gAssy', 'Nov', '$gRNov', '$B_Item_Nbr_N', '$B_Qty_Assy_N', "
                        . "'$gOHNov', '$gUsedNov', '$gBalNov', '$maxOH')";
                mysql_query($iTemp, $cnx);
                //$aPart[] = array($g_idSOPlanner, $B_Item_Nbr, $B_Qty_Assy, $rQty, $OnHand, $MaxCTB);
                //N echo "$g_idSOPlanner - $B_Item_Nbr - $rQty\r\n";
                //*echo $iTemp . "\r\n";
                
            }
            
            $status = "OKBOM";
            $uPlanByAssy = "UPDATE PlanByAssy SET Status = '$status' "
                    . "WHERE idPlanByAssy = '$gidAssy'";
            //*mysql_query($uPlanByAssy, $cnx);
            
        } else {
            $status = "NOBOM";
            $uPlanByAssy = "UPDATE PlanByAssy SET Status = '$status' "
                    . "WHERE idPlanByAssy = '$gidAssy'";
            //*mysql_query($uPlanByAssy, $cnx);
        }
        
        //Revisa cual es el maximo
        $sMin_N = "SELECT MIN(maxKit) AS mKit FROM TempParts WHERE Mes = 'Nov' AND idAssy = '$gidAssy'";
        $qMin_N = mysql_query($sMin_N, $cnx);
        $rMin_N = mysql_fetch_array($qMin_N);
        $MinAssNov = $rMin_N['mKit'];
        
        if($MinAssNov > 0){
            
            //Depende la cantidad
            if($MinAssNov >= $gRNov){
                //Mayor a lo requerido
                $MinAssNov = $gRNov;
                
            }
            
            //Asignar partes para ensamble
            $sPU_N = "SELECT * FROM TempParts WHERE Mes = 'Nov' AND idAssy = '$gidAssy'";
            $qPU_N = mysql_query($sPU_N, $cnx);
            while ($rPU_N = mysql_fetch_array($qPU_N)){
                //Depende lo usado
                $gBalMes = $rPU_N['BalMes'];
                $gQtyxU_N = $rPU_N['QtyPart'];
                $gParte_N = $rPU_N['Part'];
                $UsedPart_N = $gQtyxU_N * $MinAssNov;
                //Actualiza QtyPartes
                $sBalA_N = "SELECT OHNov, UsedNov, BalNov, BalDec, OHAftDec FROM PlannedOH WHERE Part_Nbr = '$gParte_N'";
                $qBalA_N = mysql_query($sBalA_N, $cnx);
                $nBalA_N = mysql_num_rows($qBalA_N);
                if($nBalA_N == 1){
                    //Busca
                    $rBalA_N = mysql_fetch_array($qBalA_N);
                    $gOHNovA = $rBalA_N['OHNov'];
                    $gUsedNovA = $rBalA_N['UsedNov'];
                    $gBalOctA = $rBalA_N['BalNov'];
                    $gBalDecA = $rBalA_N['BalDec'];
                    $gBalAftDA = $rBalA_N['OHAftDec'];
                    
                    $nUsedPart_N = $gUsedNovA + $UsedPart_N;
                    $nBalNovPart = $gBalOctA - $UsedPart_N;
                    $nBalDecPart = $gBalDecA - $UsedPart_N;
                    $nBalAftDec = $gBalAftDA - $UsedPart_N;
                    
                    //Actualiza Balance
                    $uPlanOH_N = "UPDATE PlannedOH SET UsedNov = '$nUsedPart_N', BalNov = '$nBalNovPart', "
                            . "BalDec = '$nBalDecPart', OHAftDec = '$nBalAftDec' "
                            . "WHERE Part_Nbr = '$gParte_N'";
                    mysql_query($uPlanOH_N, $cnx);
                    
                    
                }
                
                
                
            }
            
            $CTBNov = $MinAssNov;
            //*$RemainOct = $gROct - $CTBOct;
            $RemainNov = $gRNov - $CTBNov;
            $gRDec = $gBDec + $RemainNov;
            $RemainDec = $gRDec;
            //$RemainDec = $gRDec - $CTBNov;
            //gRNov = $RemainNov;
            //$gRDec = $RemainDec;
            //Actualiza el plan CTB
            $uCTB_N = "UPDATE PlanByAssy SET CTBNov = '$CTBNov', RemainNov = '$RemainNov', "
                    . "RemainDec='$RemainDec' WHERE "
                    . "idPlanByAssy = '$gidAssy'";
            mysql_query($uCTB_N, $cnx);
            //*echo "Nov: " .  $uCTB_N . "\r\n";
            
        } else {
            $nBalOctPart = $nUsedPart = $gBalMes_N = $gQtyxU_N = $gParte_N = $UsedPart_N = 0;
        }
        
        
        
    }
    
    
    //*********************************************************************DICIEMBRE
    if($gRDec > 0){
        
        //Busca BOM
        //Obtiene el BOM
        $sBOM_D = "SELECT * FROM BOM2 WHERE Parent_Part_Assembly = '$gAssy' ORDER BY Qty_Assy DESC"; //  OR Item_Nbr = '$g_Item_WO_GL_Nbr'
        $qBOM_D = mysql_query($sBOM_D, $cnx);
        $nBOM_D = mysql_num_rows($qBOM_D);
        //N echo "$sBOM\r\n";
        if($nBOM_D > 0){
            while ($rBOM_D = mysql_fetch_array($qBOM_D)){
                //Obtiene el BOM
                $B_Item_Nbr_D = $rBOM_D['Item_Nbr'];
                $B_Qty_Assy_D = $rBOM_D['Qty_Assy'];
                //Partes Requeridas
                
                
                //Busca inventario
                $sBal_D = "SELECT OHDec, UsedDec, BalDec FROM PlannedOH WHERE Part_Nbr = '$B_Item_Nbr_D'";
                $qBal_D = mysql_query($sBal_D, $cnx);
                $nBal_D = mysql_num_rows($qBal_D);
                //*echo "QONJ: " . $sBal_D . "\r\n";
                if($nBal_D == 1){
                    //Busca
                    $rBal_D = mysql_fetch_array($qBal_D);
                    $gOHDec = $rBal_D['OHDec'];
                    $gUsedDec = $rBal_D['UsedDec'];
                    $gBalDec = $rBal_D['BalDec'];
                    
                    $maxOH = round($gBalDec / $B_Qty_Assy_D, 0);
                    
                } else {
                    $gOHDec = 0;
                    $gUsedDec = 0;
                    $gBalDec = 0;
                    $maxOH = 0;
                }
                
                $iTemp = "INSERT INTO TempParts VALUES('0', '$gidAssy', "
                        . "'$gAssy', 'Dec', '$gRNov', '$B_Item_Nbr_D', '$B_Qty_Assy_D', "
                        . "'$gOHDec', '$gUsedDec', '$gBalDec', '$maxOH')";
                mysql_query($iTemp, $cnx);
                //$aPart[] = array($g_idSOPlanner, $B_Item_Nbr, $B_Qty_Assy, $rQty, $OnHand, $MaxCTB);
                //N echo "$g_idSOPlanner - $B_Item_Nbr - $rQty\r\n";
                //*echo "DEC: " . $iTemp . "\r\n";
                
            }
            
            $status = "OKBOM";
            $uPlanByAssy = "UPDATE PlanByAssy SET Status = '$status' "
                    . "WHERE idPlanByAssy = '$gidAssy'";
            //*mysql_query($uPlanByAssy, $cnx);
            
        } else {
            $status = "NOBOM";
            $uPlanByAssy = "UPDATE PlanByAssy SET Status = '$status' "
                    . "WHERE idPlanByAssy = '$gidAssy'";
            //*mysql_query($uPlanByAssy, $cnx);
        }
        
        //Revisa cual es el maximo
        $sMin_D = "SELECT MIN(maxKit) AS mKit FROM TempParts WHERE Mes = 'Dec' AND idAssy = '$gidAssy'";
        $qMin_D = mysql_query($sMin_D, $cnx);
        $rMin_N = mysql_fetch_array($qMin_D);
        $MinAssDec = $rMin_N['mKit'];
        
        if($MinAssDec > 0){
            
            //Depende la cantidad
            if($MinAssDec >= $gRDec){
                //Mayor a lo requerido
                $MinAssDec = $gRDec;
                
            }
            
            //Asignar partes para ensamble
            $sPU_D = "SELECT * FROM TempParts WHERE Mes = 'Dec' AND idAssy = '$gidAssy'";
            $qPU_D = mysql_query($sPU_D, $cnx);
            while ($rPU_D = mysql_fetch_array($qPU_D)){
                //Depende lo usado
                $gBalMes = $rPU_D['BalMes'];
                $gQtyxU_D = $rPU_D['QtyPart'];
                $gParte_D = $rPU_D['Part'];
                $UsedPart_D = $gQtyxU_D * $MinAssDec;
                //Actualiza QtyPartes
                $sBalA_D = "SELECT OHDec, UsedDec, BalDec, OHAftDec FROM PlannedOH WHERE Part_Nbr = '$gParte_D'";
                $qBalA_D = mysql_query($sBalA_D, $cnx);
                $nBalA_D = mysql_num_rows($qBalA_D);
                if($nBalA_D == 1){
                    //Busca
                    $rBalA_D = mysql_fetch_array($qBalA_D);
                    $gOHDecA = $rBalA_D['OHDec'];
                    $gUsedDecA = $rBalA_D['UsedDec'];
                    $gBalDecA = $rBalA_D['BalDec'];
                    $gBalAftDA = $rBalA_N['OHAftDec'];
                    
                    $nUsedPart_D = $gUsedDecA + $UsedPart_D;
                    $nBalDecPart = $gBalDecA - $UsedPart_D;
                    $nBalAftDec = $gBalAftDA - $UsedPart_N;
                    //Actualiza Balance
                    $uPlanOH_D = "UPDATE PlannedOH SET UsedNov = '$nUsedPart_D', BalNov = '$nBalDecPart' "
                            . "WHERE Part_Nbr = '$gParte_D'";
                    mysql_query($uPlanOH_D, $cnx);
                    
                }
                
                
                
            }
            
            $CTBDec = $MinAssDec;
            //*$RemainOct = $gROct - $CTBOct;
            //*$RemainNov = $gRNov - $CTBNov;
            $RemainDec = $gRDec - $CTBDec;
            //*$gRNov = $RemainNov;
            $gRDec = $RemainDec;
            //Actualiza el plan CTB
            $uCTB_D = "UPDATE PlanByAssy SET CTBDec = '$CTBDec', "
                    . "RemainDec='$RemainDec' WHERE "
                    . "idPlanByAssy = '$gidAssy'";
            mysql_query($uCTB_D, $cnx);
            //*echo  "Dec: " . $uCTB_D . "\r\n";
            
        } else {
            $nBalOctPart = $nUsedPart = $gBalMes_N = $gQtyxU_D = $gParte_D = $UsedPart_D = 0;
        }
        
        
        
    }
    
    $pgB->tick();
}

//N $pgbom->tick();

$ahorita = date('Y-m-d h:i:s', time());
echo "\r\n\r\nTERMINE....\r\n$ahorita\r\n";
//echo "\r\n$countx\r\n";
//Desconecta la base datos
//echo $log;
mysql_close($cnx);

?>
