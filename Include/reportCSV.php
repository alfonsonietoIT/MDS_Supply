<?php
include '../PHPClass/DB.php';
include '../PHPFunctions/var.php';

$csv_output = "";
$report = $_GET['report'];

switch($report){
    case "InvDetail":
        //$gPart = $_GET['part'];
        $file = "InvDetail";
        $rown = 1;
        //Obtiene las columnas
        $scol = "SHOW COLUMNS FROM InvDetail";
        $ncol = $cnx->query($scol)->numRows();
        $LCol = $cnx->query($scol)->fetchAll();
        
        foreach ($LCol as &$LColx) {
            $colv = $LColx['Field'];
            $csv_output .= "$colv" . ",";
        }
        
        if($csv_output != ""){
            $csv_output = substr($csv_output, 0, -1) . "\n";
        }
        //SELECT * FROM J01 ORDER BY SERVICE_ORDER_ID DESC
        //$cdata = "SELECT *, DATEDIFF('$dtAhora', Purchase_Order_Add_Date) AS TAT FROM POControl WHERE QtyExpire > '0' $Extra ORDER BY dtCreated ASC";
        $cdata = "SELECT * FROM InvDetail "
                . " ORDER BY ID ASC";
        //$csv_output .= $cdata . "\n";
        //$csv_output = str_replace("|", "$", $csv_output);
        $i = $ncol;
        //$csv_output = "$cdata\n";
        $LRows = $cnx->query($cdata)->fetchAll();
        foreach ($LRows as &$LRowsx) {
            $g_1 = $LRowsx['idInvDetail'];
            $g_2 = $LRowsx['Class_Data'];
            $g_3 = $LRowsx['ID'];
            $g_4 = $LRowsx['Description'];
            $g_5 = $LRowsx['Comm_Code'];
            $g_6 = $LRowsx['Engr_Status'];
            $g_7 = $LRowsx['Inv_Type'];
            $g_8 = $LRowsx['Ltc'];
            $g_9 = $LRowsx['Sales_Qty'];
            $g_10 = $LRowsx['Post_3Yr_Sales_Qty'];
            $g_11 = $LRowsx['Sum_of_RemFcst_Qty'];
            $g_12 = $LRowsx['Reqmnt_Qty'];
            $g_13 = $LRowsx['Qty_On_Hand'];
            $g_14 = $LRowsx['Qty_Mrb'];
            $g_15 = $LRowsx['Qty_Rii'];
            $g_16 = $LRowsx['Excess_Wip'];
            $g_17 = $LRowsx['Open_PO_Qty'];
            $g_18 = $LRowsx['Open_PO_Qty_CFM'];
            $g_19 = $LRowsx['Open_WO_Qty'];
            $g_20 = $LRowsx['Sum_of_Plan_Qty'];
            $g_21 = $LRowsx['Last_Recpt_Date'];
            $g_22 = $LRowsx['Net_Excess'];
            $g_23 = $LRowsx['Rem_Qty_Wip'];
            $g_24 = $LRowsx['Buyer_Code'];
            $g_25 = $LRowsx['Accounting_Value'];
            $g_26 = $LRowsx['Excess'];
            $g_27 = $LRowsx['AddedOn'];
            $g_28 = $LRowsx['dtAdded'];
            $g_29 = $LRowsx['Status'];
            
            for ($j=0;$j<$i;$j++){
                $jx = $j+1;
                $var = "g_" . $jx;
                $val = $$var;
                $buffer = "\"" . str_replace(array(",", "\r", "\n", "\t"), '', $val) . "\"";
                $csv_output .= strtoupper($buffer) . ",";
            }

            $csv_output .= "\n";
        }
        break;
    case "HoldMaterial":
        //Vendor_Promise_Dt < NOW() AND Balance_Due > 0 AND Vendor_Promise_Dt != '2000-01-01'
        $gIDOwner = base64_decode($_GET['KeyII']);
        $gCustomer = base64_decode($_GET['KeyIII']);
        $gVendor = base64_decode($_GET['KeyIV']);
        $gRisk = base64_decode($_GET['KeyV']);
        $gStatus = base64_decode($_GET['KeyVI']);
        $gDays = base64_decode($_GET['KeyVII']);
        $file = "HoldMaterial";
        //$csv_output .= "$gIDOwner - $gCustomer - $gVendor - $gRisk - $gStatus - $gDays\r\n";
        
        //Owner
        if(!empty($gIDOwner)){
            $Extra .= " AND IDBuyer = '$gIDOwner' ";
        }
        
        //Customer
        if(!empty($gCustomer)){
            $Extra .= " AND MWCustomer = '$gCustomer' ";
        }
        
        //Vendor
        if(!empty($gVendor)){
            $Extra .= " AND VendorName = '$gVendor' ";
        }
        
        //Risk
        if(!empty($gRisk)){
            switch($gRisk){
                case "LOW":
                    $Extra .= " AND DATEDIFF('$dtAhora', dtHold) < '8'";
                    break;
                case "MEDIUM":
                    $Extra .= " AND DATEDIFF('$dtAhora', dtHold) BETWEEN '8' AND '30'";
                    break;
                case "HIGH":
                    $Extra .= " AND DATEDIFF('$dtAhora', dtHold) > '30'";
                    break;
            }
        }
        
        //Status
        if(!empty($gStatus)){
            $Extra .= " AND Status = '$gStatus' ";
        }
        
        //Day
        if(!empty($gDays)){
            $Extra .= " AND DATEDIFF('$dtAhora', dtHold) = '$gDays' ";
        }
        
        
        $rown = 1;
        //Obtiene las columnas
        $scol = "SHOW COLUMNS FROM WarehouseHold";
        $ncol = $cnxw->query($scol)->numRows();
        $LCol = $cnxw->query($scol)->fetchAll();
        
        foreach ($LCol as &$LColx) {
            $colv = $LColx['Field'];
            $csv_output .= "$colv" . ",";
        }
        
        $csv_output .= "TAT" . ",";
        
        if($csv_output != ""){
            $csv_output = substr($csv_output, 0, -1) . "\n";
        }
        //SELECT * FROM J01 ORDER BY SERVICE_ORDER_ID DESC
        //$cdata = "SELECT *, DATEDIFF('$dtAhora', Purchase_Order_Add_Date) AS TAT FROM POControl WHERE QtyExpire > '0' $Extra ORDER BY dtCreated ASC";
        $cdata = "SELECT *, DATEDIFF('$dateToday', dtHold) AS TAT FROM WarehouseHold "
                . "WHERE Balance > 0 AND Status = 'Hold' $Extra ORDER BY dtHold ASC";
        //$csv_output .= $cdata . "\n";
        //$csv_output = str_replace("|", "$", $csv_output);
        $i = $ncol + 1;
        //$csv_output = "$cdata\n";
        $LRows = $cnxw->query($cdata)->fetchAll();
        foreach ($LRows as &$LRowsx) {
            $g_1 = $LRowsx['idWarehouse'];
            $g_2 = $LRowsx['WKey'];
            $g_3 = $LRowsx['NControl'];
            $g_4 = $LRowsx['NPacking'];
            $g_5 = $LRowsx['Tracking'];
            $g_6 = $LRowsx['MWPO'];
            $g_7 = $LRowsx['MWPartNumber'];
            $g_8 = $LRowsx['MWPartDescription'];
            $g_9 = $LRowsx['MWClassCode'];
            $g_10 = $LRowsx['MWCustomer'];
            $g_11 = $LRowsx['VendorCode'];
            $g_12 = $LRowsx['VendorName'];
            $g_13 = $LRowsx['MnfPartNumber'];
            $g_14 = $LRowsx['MnfDescription'];
            $g_15 = $LRowsx['Acctg_Value'];
            $g_16 = $LRowsx['Qty'];
            $g_17 = $LRowsx['Balance'];
            $g_18 = $LRowsx['Carton'];
            $g_19 = $LRowsx['Pallet'];
            $g_20 = $LRowsx['Location'];
            $g_21 = $LRowsx['ROI'];
            $g_22 = $LRowsx['dtPrealert'];
            $g_23 = $LRowsx['dtReceived'];
            $g_24 = $LRowsx['dtModification'];
            $g_25 = $LRowsx['IDBuyer'];
            $g_26 = $LRowsx['Buyer'];
            $g_27 = $LRowsx['BuyerName'];
            $g_28 = $LRowsx['Status'];
            $g_29 = $LRowsx['IDOwner'];
            $g_30 = $LRowsx['Owner'];
            $g_31 = $LRowsx['Reason'];
            $g_32 = $LRowsx['dtHold'];
            $g_33 = $LRowsx['Comments'];
            $g_34 = $LRowsx['dtRelease'];
            $g_35 = $LRowsx['CommentsRel'];
            $g_36 = $LRowsx['uRelease'];
            $g_37 = $LRowsx['uRelName'];
            $g_38 = $LRowsx['TAT'];
            
            for ($j=0;$j<$i;$j++){
                $jx = $j+1;
                $var = "g_" . $jx;
                $val = $$var;
                $buffer = "\"" . str_replace(array(",", "\r", "\n", "\t"), '', $val) . "\"";
                $csv_output .= strtoupper($buffer) . ",";
            }

            $csv_output .= "\n";
        }
        
        break;
    case "BOM":
        $file = "BOM";
        $rown = 1;
        //Obtiene las columnas
        $scol = "SHOW COLUMNS FROM BOM";
        $ncol = $cnx->query($scol)->numRows();
        $LCol = $cnx->query($scol)->fetchAll();
        
        foreach ($LCol as &$LColx) {
            $colv = $LColx['Field'];
            $csv_output .= "$colv" . ",";
        }
        
        if($csv_output != ""){
            $csv_output = substr($csv_output, 0, -1) . "\n";
        }
        //SELECT * FROM J01 ORDER BY SERVICE_ORDER_ID DESC
        //$cdata = "SELECT *, DATEDIFF('$dtAhora', Purchase_Order_Add_Date) AS TAT FROM POControl WHERE QtyExpire > '0' $Extra ORDER BY dtCreated ASC";
        $cdata = "SELECT * FROM BOM"
                . " ORDER BY idBOM ASC";
        //$csv_output .= $cdata . "\n";
        //$csv_output = str_replace("|", "$", $csv_output);
        $i = $ncol;
        //$csv_output = "$cdata\n";
        $LRows = $cnx->query($cdata)->fetchAll();
        foreach ($LRows as &$LRowsx) {
            $g_1 = $LRowsx['idBOM'];
            $g_2 = $LRowsx['CSR'];
            $g_3 = $LRowsx['Class_Code'];
            $g_4 = $LRowsx['Customer_Code'];
            $g_5 = $LRowsx['Item_Nbr'];
            $g_6 = $LRowsx['Parent_Part_Assembly'];
            $g_7 = $LRowsx['Lead_Time_Code'];
            $g_8 = $LRowsx['Lead_Time'];
            $g_9 = $LRowsx['Qty_Assy'];
            $g_10 = $LRowsx['UM'];
            $g_11 = $LRowsx['Acctg_Value'];
            $g_12 = $LRowsx['Current_Value'];
            $g_13 = $LRowsx['Last_Actual'];
            $g_14 = $LRowsx['Average_Actual_Value'];
            $g_15 = $LRowsx['Standard_Value'];
            $g_16 = $LRowsx['Simulated_Value'];
            $g_17 = $LRowsx['Inv_Type'];
            $g_18 = $LRowsx['MOA'];
            
            for ($j=0;$j<$i;$j++){
                $jx = $j+1;
                $var = "g_" . $jx;
                $val = $$var;
                $buffer = "\"" . str_replace(array(",", "\r", "\n", "\t"), '', $val) . "\"";
                $csv_output .= strtoupper($buffer) . ",";
            }

            $csv_output .= "\n";
        }
        
        break;
    case "vBOM":
        $gPart = $_GET['part'];
        $file = "($gPart)BOM";
        $rown = 1;
        //Obtiene las columnas
        $scol = "SHOW COLUMNS FROM BOM";
        $ncol = $cnx->query($scol)->numRows();
        $LCol = $cnx->query($scol)->fetchAll();
        
        foreach ($LCol as &$LColx) {
            $colv = $LColx['Field'];
            $csv_output .= "$colv" . ",";
        }
        
        if($csv_output != ""){
            $csv_output = substr($csv_output, 0, -1) . "\n";
        }
        //SELECT * FROM J01 ORDER BY SERVICE_ORDER_ID DESC
        //$cdata = "SELECT *, DATEDIFF('$dtAhora', Purchase_Order_Add_Date) AS TAT FROM POControl WHERE QtyExpire > '0' $Extra ORDER BY dtCreated ASC";
        $cdata = "SELECT * FROM BOM "
                . "WHERE Parent_Part_Assembly LIKE '$gPart' "
                . " ORDER BY Item_Nbr ASC";
        //$csv_output .= $cdata . "\n";
        //$csv_output = str_replace("|", "$", $csv_output);
        $i = $ncol;
        //$csv_output = "$cdata\n";
        $LRows = $cnx->query($cdata)->fetchAll();
        foreach ($LRows as &$LRowsx) {
            $g_1 = $LRowsx['idBOM'];
            $g_2 = $LRowsx['CSR'];
            $g_3 = $LRowsx['Class_Code'];
            $g_4 = $LRowsx['Customer_Code'];
            $g_5 = $LRowsx['Item_Nbr'];
            $g_6 = $LRowsx['Parent_Part_Assembly'];
            $g_7 = $LRowsx['Lead_Time_Code'];
            $g_8 = $LRowsx['Lead_Time'];
            $g_9 = $LRowsx['Qty_Assy'];
            $g_10 = $LRowsx['UM'];
            $g_11 = $LRowsx['Acctg_Value'];
            $g_12 = $LRowsx['Current_Value'];
            $g_13 = $LRowsx['Last_Actual'];
            $g_14 = $LRowsx['Average_Actual_Value'];
            $g_15 = $LRowsx['Standard_Value'];
            $g_16 = $LRowsx['Simulated_Value'];
            $g_17 = $LRowsx['Inv_Type'];
            $g_18 = $LRowsx['MOA'];
            
            for ($j=0;$j<$i;$j++){
                $jx = $j+1;
                $var = "g_" . $jx;
                $val = $$var;
                $buffer = "\"" . str_replace(array(",", "\r", "\n", "\t"), '', $val) . "\"";
                $csv_output .= strtoupper($buffer) . ",";
            }

            $csv_output .= "\n";
        }
        
        break;
    case "ActPODemand":
        //Vendor_Promise_Dt < NOW() AND Balance_Due > 0 AND Vendor_Promise_Dt != '2000-01-01'
        $gOwner = base64_decode($_GET['KeyII']);
        $gCustomer = base64_decode($_GET['KeyIII']);
        $gVendor = base64_decode($_GET['KeyIV']);
        $gRisk = base64_decode($_GET['KeyV']);
        $gStatus = base64_decode($_GET['KeyVI']);
        $gDays = base64_decode($_GET['KeyVII']);
        $file = "ActivePODemand";
        //$csv_output .= "$gIDOwner - $gCustomer - $gVendor - $gRisk - $gStatus - $gDays\r\n";
        
        //Owner
        if(!empty($gOwner)){
            $Extra .= " AND Owner = '$gOwner' ";
        }
        
        //Customer
        if(!empty($gCustomer)){
            $Extra .= " AND Customer LIKE '$gCustomer' ";
        }
        
        //Vendor
        if(!empty($gVendor)){
            $Extra .= " AND VendorID = '$gVendor' ";
        }
        
        //Risk
        if(!empty($gRisk)){
            switch($gRisk){
                case "ME8":
                    $Extra .= " AND DATEDIFF(Vendor_Promise_Dt, '$dtAhora') < '8'";
                    break;
                case "ME15":
                    $Extra .= " AND DATEDIFF(Vendor_Promise_Dt, '$dtAhora') BETWEEN '8' AND '14'";
                    break;
                case "ME22":
                    $Extra .= " AND DATEDIFF(Vendor_Promise_Dt, '$dtAhora') BETWEEN '15' AND '21'";
                    break;
                case "ME31":
                    $Extra .= " AND DATEDIFF(Vendor_Promise_Dt, '$dtAhora') BETWEEN '22' AND '30'";
                    break;
                case "ME61":
                    $Extra .= " AND DATEDIFF(Vendor_Promise_Dt, '$dtAhora') BETWEEN '31' AND '60'";
                    break;
                case "ME91":
                    $Extra .= " AND DATEDIFF(Vendor_Promise_Dt, '$dtAhora') BETWEEN '61' AND '90'";
                    break;
                case "MAS90":
                    $Extra .= " AND DATEDIFF(Vendor_Promise_Dt, '$dtAhora') > '90'";
                    break;
            }
        }
        
        //Status
        if(!empty($gStatus)){
            $Extra .= " AND Status = '$gStatus' ";
        }
        
        //Day
        if(!empty($gDays)){
            $Extra .= " AND DATEDIFF(Vendor_Promise_Dt, '$dtAhora') = '$gDays' ";
        }
        
        
        $rown = 1;
        
        //Obtiene las columnas
        $scol = "SHOW COLUMNS FROM PODemand";
        $ncol = $cnx->query($scol)->numRows();
        $ncol += 1;
        /*
        $LCol = $cnx->query($scol)->fetchAll();
        
        foreach ($LCol as &$LColx) {
            $colv = $LColx['Field'];
            $csv_output .= "$colv" . ",";
        }
        */
        $csv_output .= "IDPODemand,Class_Data,Owner,VendorID,VendorName,"
                . "Part,Description,ReqmntQty,NetExcess,NetExcess(%),Comm_Code,Engr_Status,Inv_Type,"
                . "Ltc,SalesQty,Post3Yr_Sales_Qty,QtyOnHand,QtyMrb,QtyRii,ExcessWip,"
                . "OpenPOQty,OpenPOQtyCFM,OpenWOQty,SumadePlan_Qty,Last_RecptDate,"
                . "Rem_Qty_Wip,BuyerCode,AccountingValue,Excess,Updated,"
                . "Customer,TotalOH,pDemand\n";
        
        //SELECT * FROM J01 ORDER BY SERVICE_ORDER_ID DESC
        //$cdata = "SELECT *, DATEDIFF('$dtAhora', Purchase_Order_Add_Date) AS TAT FROM POControl WHERE QtyExpire > '0' $Extra ORDER BY dtCreated ASC";
        $cdata = "SELECT IDPODemand,Class_Data,Owner,VendorID,VendorName,"
                . "Part,Description,ReqmntQty,NetExcess,(pDemand - 100) AS NetExcessPor,Comm_Code,Engr_Status,Inv_Type,"
                . "Ltc,SalesQty,Post3Yr_Sales_Qty,QtyOnHand,QtyMrb,QtyRii,ExcessWip,"
                . "OpenPOQty,OpenPOQtyCFM,OpenWOQty,SumadePlan_Qty,Last_RecptDate,"
                . "Rem_Qty_Wip,BuyerCode,AccountingValue,Excess,Updated,"
                . "Customer,TotalOH,pDemand "
                . "FROM PODemand "
                . "WHERE NetExcess < '0' AND Inv_Type = 'PP' AND Comm_Code != 'PKG' AND Comm_Code != 'LBL' AND ReqmntQty > '0' AND Engr_Status = 'A' AND pDemand < '80' "
                . "$Extra;";
        //$csv_output .= $cdata . "\n";
        //$csv_output = str_replace("|", "$", $csv_output);
        $i = $ncol + 1;
        //$csv_output = "$cdata\n";
        $LRows = $cnx->query($cdata)->fetchAll();
        foreach ($LRows as &$LRowsx) {
            $g_1 = $LRowsx['IDPODemand'];
            $g_2 = $LRowsx['Class_Data'];
            $g_3 = $LRowsx['Owner'];
            $g_4 = $LRowsx['VendorID'];
            $g_5 = $LRowsx['VendorName'];
            $g_6 = $LRowsx['Part'];
            $g_7 = $LRowsx['Description'];
            $g_8 = $LRowsx['ReqmntQty'];
            $g_9 = $LRowsx['NetExcess'];
            $g_10 = $LRowsx['NetExcessPor'];
            $g_11 = $LRowsx['Comm_Code'];
            $g_12 = $LRowsx['Engr_Status'];
            $g_13 = $LRowsx['Inv_Type'];
            $g_14 = $LRowsx['Ltc'];
            $g_15 = $LRowsx['SalesQty'];
            $g_16 = $LRowsx['Post3Yr_Sales_Qty'];
            $g_17 = $LRowsx['QtyOnHand'];
            $g_18 = $LRowsx['QtyMrb'];
            $g_19 = $LRowsx['QtyRii'];
            $g_20 = $LRowsx['ExcessWip'];
            $g_21 = $LRowsx['OpenPOQty'];
            $g_22 = $LRowsx['OpenPOQtyCFM'];
            $g_23 = $LRowsx['OpenWOQty'];
            $g_24 = $LRowsx['SumadePlan_Qty'];
            $g_25 = $LRowsx['Last_RecptDate'];
            $g_26 = $LRowsx['Rem_Qty_Wip'];
            $g_27 = $LRowsx['BuyerCode'];
            $g_28 = $LRowsx['AccountingValue'];
            $g_29 = $LRowsx['Excess'];
            $g_30 = $LRowsx['Updated'];
            $g_31 = $LRowsx['Customer'];
            $g_32 = $LRowsx['TotalOH'];
            $g_33 = $LRowsx['pDemand'];
            
            for ($j=0;$j<$i;$j++){
                $jx = $j+1;
                $var = "g_" . $jx;
                $val = $$var;
                $buffer = "\"" . str_replace(array(",", "\r", "\n", "\t"), '', $val) . "\"";
                $csv_output .= strtoupper($buffer) . ",";
            }

            $csv_output .= "\n";
        }
        break;
    case "CTB_ProductionPlan53":
        $ppSer = $_POST['ppSer'];
        $ppDates = $_POST['ppDates'];
        //echo $Name . "<BR>";
        $DecVariable = base64_decode($ppSer);
        $ArrAssy = unserialize($DecVariable);
        $DecDates = base64_decode($ppDates);
        $ArrDates = unserialize($DecDates);
        
        //print_r($ArrDates);
        //print_r($ArrAssy);
        $file = "ProductionPlan";
        
        $csv_output .= "Count,";
        $csv_output .= "Assembly,";
        $csv_output .= "Description,";
        $csv_output .= "Price,";
        $csv_output .= "Revenue,";
        
        foreach ($ArrDates AS &$Viernes){
            $Lunes = date('M-d', strtotime('-4 days', strtotime($Viernes)));
            $csv_output .= $Lunes . ",";
        }
        
        $csv_output = substr($csv_output, 0, -1) . "\n";
        
        foreach ($ArrAssy AS &$Data){
            $C0 = $Data[0];
            $C1 = $Data[1];
            $C2 = $Data[2];
            $C3 = str_replace(",", "", $Data[3]);
            $C4 = str_replace(",", "", $Data[110]);
            $C5 = $Data[5];
            $C6 = $Data[7];
            $C7 = $Data[9];
            $C8 = $Data[11];
            $C9 = $Data[13];
            $C10 = $Data[15];
            $C11 = $Data[17];
            $C12 = $Data[19];
            $C13 = $Data[21];
            $C14 = $Data[23];
            $C15 = $Data[25];
            $C16 = $Data[27];
            $C17 = $Data[29];
            $C18 = $Data[31];
            $C19 = $Data[33];
            $C20 = $Data[35];
            $C21 = $Data[37];
            $C22 = $Data[39];
            $C23 = $Data[41];
            $C24 = $Data[43];
            $C25 = $Data[45];
            $C26 = $Data[47];
            $C27 = $Data[49];
            $C28 = $Data[51];
            $C29 = $Data[53];
            $C30 = $Data[55];
            $C31 = $Data[57];
            $C32 = $Data[59];
            $C33 = $Data[61];
            $C34 = $Data[63];
            $C35 = $Data[65];
            $C36 = $Data[67];
            $C37 = $Data[69];
            $C38 = $Data[71];
            $C39 = $Data[73];
            $C40 = $Data[75];
            $C41 = $Data[77];
            $C42 = $Data[79];
            $C43 = $Data[81];
            $C44 = $Data[83];
            $C45 = $Data[85];
            $C46 = $Data[87];
            $C47 = $Data[89];
            $C48 = $Data[91];
            $C49 = $Data[93];
            $C50 = $Data[95];
            $C51 = $Data[97];
            $C52 = $Data[99];
            $C53 = $Data[101];
            $C54 = $Data[103];
            $C55 = $Data[105];
            $C56 = $Data[107];
            $C57 = $Data[109];
            
            $csv_output .= "$C0,$C1,\"$C2\",$C3,$C4,$C5,$C6,$C7,$C8,$C9,$C10,$C11,$C12,$C13,$C14,$C15,$C16,$C17,$C18,$C19,$C20,$C21,$C22,$C23,$C24,$C25,$C26,$C27,$C28,$C29,$C30,$C31,$C32,$C33,$C34,$C35,$C36,$C37,$C38,$C39,$C40,$C41,$C42,$C43,$C44,$C45,$C46,$C47,$C48,$C49,$C50,$C51,$C52,$C53,$C54,$C55,$C56,$C57\n";
            
        }
        
        break;
    case "CTB_ImpactProductionPlan53":
        $ppSer = $_POST['ppISer'];
        $ppDates = $_POST['ppDates'];
        //echo $Name . "<BR>";
        $DecVariable = base64_decode($ppSer);
        $ArrAssy = unserialize($DecVariable);
        $DecDates = base64_decode($ppDates);
        $ArrDates = unserialize($DecDates);
        
        //print_r($ArrDates);
        //print_r($ArrAssy);
        $file = "PartsProductionPlan";
        //Item	Description	Mfgr	Mfgr PN	MW OH	OvI	LT w
        $csv_output .= "Count,";
        $csv_output .= "Type,";
        $csv_output .= "Item,";
        $csv_output .= "Description,";
        $csv_output .= "Mfgr,";
        $csv_output .= "Mfgr PN,";
        $csv_output .= "MW OH,";
        $csv_output .= "OvI,";
        $csv_output .= "PO Expired,";
        $csv_output .= "Consigned,";
        $csv_output .= "LT w,";
        
        foreach ($ArrDates AS &$Viernes){
            $Lunes = date('M-d', strtotime('-4 days', strtotime($Viernes)));
            $csv_output .= $Lunes . ",";
        }
        
        $csv_output = substr($csv_output, 0, -1) . "\n";
        $crow = 0;
        foreach ($ArrAssy AS &$Data){
            $crow++;
            $C0 = $Data[0];
            $C1 = $Data[1];
            $C2 = $Data[2];
            $C3 = $Data[3];
            $C4 = $Data[4];
            $C5 = $Data[5];
            $C6 = $Data[6];
            $C7 = $Data[7];
            $C8 = $Data[8];
            $C9 = $Data[9];
            $C10 = $Data[10];
            $C11 = $Data[11];
            $C12 = $Data[12];
            $C13 = $Data[13];
            $C14 = $Data[14];
            $C15 = $Data[15];
            $C16 = $Data[16];
            $C17 = $Data[17];
            $C18 = $Data[18];
            $C19 = $Data[19];
            $C20 = $Data[20];
            $C21 = $Data[21];
            $C22 = $Data[22];
            $C23 = $Data[23];
            $C24 = $Data[24];
            $C25 = $Data[25];
            $C26 = $Data[26];
            $C27 = $Data[27];
            $C28 = $Data[28];
            $C29 = $Data[29];
            $C30 = $Data[30];
            $C31 = $Data[31];
            $C32 = $Data[32];
            $C33 = $Data[33];
            $C34 = $Data[34];
            $C35 = $Data[35];
            $C36 = $Data[36];
            $C37 = $Data[37];
            $C38 = $Data[38];
            $C39 = $Data[39];
            $C40 = $Data[40];
            $C41 = $Data[41];
            $C42 = $Data[42];
            $C43 = $Data[43];
            $C44 = $Data[44];
            $C45 = $Data[45];
            $C46 = $Data[46];
            $C47 = $Data[47];
            $C48 = $Data[48];
            $C49 = $Data[49];
            $C50 = $Data[50];
            $C51 = $Data[51];
            $C52 = $Data[52];
            $C53 = $Data[53];
            $C54 = $Data[54];
            $C55 = $Data[55];
            $C56 = $Data[56];
            $C57 = $Data[57];
            $C58 = $Data[58];
            $C59 = $Data[59];
            $C60 = $Data[60];
            $C61 = $Data[61];
            $C62 = $Data[62];
            $C63 = $Data[63];
            $C64 = $Data[64];
            $C65 = $Data[65];
            $C66 = $Data[66];
            
            $conf = explode("|", $C62);
            $cconf = 0;
            foreach ($conf AS &$QConf){
                $cconf++;
                $varco = "Conf" . $cconf;
                $$varco = $QConf;
                
            }
            
            $demand = explode("|", $C63);
            $cd = 0;
            foreach ($demand AS &$QDe){
                $cd++;
                $varde = "Dem" . $cd;
                $$varde = $QDe;
                
            }
            
            $uC = explode("|", $C66);
            $cuc = 0;
            foreach ($uC AS &$QuC){
                $cuc++;
                $varuc = "uC" . $cuc;
                $$varuc = $QuC;
                
            }
            
            $C01 = "Confirmed Purchase Orders";
            $C001 = "Demand";
            $C0001 = "Shortage w/conf PO";
            $csv_output .= "$crow,$C01,$C2,$C3,$C4,$C5,$C6,$C7,$C64,$C65,$C8,$Conf1,$Conf2,$Conf3,$Conf4,$Conf5,$Conf6,$Conf7,$Conf8,$Conf9,$Conf10,$Conf11,$Conf12,$Conf13,$Conf14,$Conf15,$Conf16,$Conf17,$Conf18,$Conf19,$Conf20,$Conf21,$Conf22,$Conf23,$Conf24,$Conf25,$Conf26,$Conf27,$Conf28,$Conf29,$Conf30,$Conf31,$Conf32,$Conf33,$Conf34,$Conf35,$Conf36,$Conf37,$Conf38,$Conf39,$Conf40,$Conf41,$Conf42,$Conf43,$Conf44,$Conf45,$Conf46,$Conf47,$Conf48,$Conf49,$Conf50,$Conf51,$Conf52,$Conf53\n";
            $csv_output .= "$crow,$C0001,$C2,$C3,$C4,$C5,$C6,$C7,$C64,$C65,$C8,$uC1,$uC2,$uC3,$uC4,$uC5,$uC6,$uC7,$uC8,$uC9,$uC10,$uC11,$uC12,$uC13,$uC14,$uC15,$uC16,$uC17,$uC18,$uC19,$uC20,$uC21,$uC22,$uC23,$uC24,$uC25,$uC26,$uC27,$uC28,$uC29,$uC30,$uC31,$uC32,$uC33,$uC34,$uC35,$uC36,$uC37,$uC38,$uC39,$uC40,$uC41,$uC42,$uC43,$uC44,$uC45,$uC46,$uC47,$uC48,$uC49,$uC50,$uC51,$uC52,$uC53\n";
            $csv_output .= "$crow,$C001,$C2,$C3,$C4,$C5,$C6,$C7,$C64,$C65,$C8,$Dem1,$Dem2,$Dem3,$Dem4,$Dem5,$Dem6,$Dem7,$Dem8,$Dem9,$Dem10,$Dem11,$Dem12,$Dem13,$Dem14,$Dem15,$Dem16,$Dem17,$Dem18,$Dem19,$Dem20,$Dem21,$Dem22,$Dem23,$Dem24,$Dem25,$Dem26,$Dem27,$Dem28,$Dem29,$Dem30,$Dem31,$Dem32,$Dem33,$Dem34,$Dem35,$Dem36,$Dem37,$Dem38,$Dem39,$Dem40,$Dem41,$Dem42,$Dem43,$Dem44,$Dem45,$Dem46,$Dem47,$Dem48,$Dem49,$Dem50,$Dem51,$Dem52,$Dem53\n";
            $csv_output .= "$crow,$C1,$C2,$C3,$C4,$C5,$C6,$C7,$C64,$C65,$C8,$C9,$C10,$C11,$C12,$C13,$C14,$C15,$C16,$C17,$C18,$C19,$C20,$C21,$C22,$C23,$C24,$C25,$C26,$C27,$C28,$C29,$C30,$C31,$C32,$C33,$C34,$C35,$C36,$C37,$C38,$C39,$C40,$C41,$C42,$C43,$C44,$C45,$C46,$C47,$C48,$C49,$C50,$C51,$C52,$C53,$C54,$C55,$C56,$C57,$C58,$C59,$C60,$C61\n";
            
        }
        
        break;
    case "CTB_ImpactProductionPlan16":
        //error_reporting(0);
        
        $ppSer = $_POST['ppISer'];
        $ppDates = $_POST['ppDates'];
        $ppAss = $_POST['ppAss'];
        $gClassCode = base64_decode($_GET['token']);
        
        $gi = "SELECT * FROM AssGroup WHERE GroupCode = '$gClassCode'";
        $ni = $cnx->query($gi)->numRows();
        if($ni == 1){
            //Obtiene info
            $ri = $cnx->query($gi)->fetchArray();
            $gIDGroup = $ri['idGroup'];
            $gGtype = $ri['GType'];
            
            
            if($gGtype == "Collection"){
                //obtiene los grupos
                $sGr = "SELECT * FROM GroupCollection WHERE idCollection = '$gIDGroup'";
                $nGr = $cnx->query($sGr)->numRows();
                
                if($nGr > 0){
                    $grups = "(";
                    $rGr = $cnx->query($sGr)->fetchAll();
                    foreach ($rGr AS $rG){
                        $gCCgroup = $rG['CGroup'];
                        $gCCIDGroup = $rG['idGroup'];
                        $grups .= "idGroup = '$gCCIDGroup' OR ";
                        
                    }
                    
                    $grups = substr($grups, 0, -4) . ")";
                    
                }
                
            }
            
        }
        
        //echo $Name . "<BR>";
        $DecVariable = base64_decode($ppSer);
        $ArrAssy = unserialize($DecVariable);
        $DecDates = base64_decode($ppDates);
        $ArrDates = unserialize($DecDates);
        $DecAssies = base64_decode($ppAss);
        $ArrAssies = unserialize($DecAssies);
        //print_r($ArrAssies);
        //print_r($ArrDates);
        //print_r($ArrAssy);
        $file = "$gClassCode-PartsProductionPlan16";
        $csv_output = "\n";
        $csv_output .= ",,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,Total,";
        //$csv_output .= "$gi,,\r\n";
        //$csv_output .= "$sgr,,\r\n";
        $cAssies = 0;
        foreach ($ArrAssies AS &$Ass){
            $cAssies++;
            //$cAss = $Ass[1];
            $tAss = $Ass[36];
            $csv_output .= $tAss . ",";
        }
        
        $csv_output = substr($csv_output, 0, -1) . "\n";
        //Item	Description	Mfgr	Mfgr PN	MW OH	OvI	LT w
        $csv_output .= "Count,";
        $csv_output .= "Type,";
        $csv_output .= "Group,";
        $csv_output .= "Item,";
        $csv_output .= "CC,";
        $csv_output .= "Commodity,";
        $csv_output .= "L.T.,";
        $csv_output .= "Description,";
        $csv_output .= "Primary Vendor,";
        $csv_output .= "Mfgr,";
        $csv_output .= "Mfgr PN,";
        $csv_output .= "MW OH,";
        $csv_output .= "Production Floor WIP,";
        $csv_output .= "Consigned,";
        $csv_output .= "PO Past Due,";
        $csv_output .= "Count of Reds first QTR,";
        $csv_output .= "Flag Quarter,";
        $csv_output .= "PPV Amount,";
        $csv_output .= "PPV Qty,";
        $csv_output .= "EngrStatus,";
        $csv_output .= "Comments This Week,";
        $csv_output .= "Total Stock + Consign,";
        //$csv_output .= "LT w,";
        
        foreach ($ArrDates AS &$Viernes){
            $Lunes = date('M-d', strtotime('-4 days', strtotime($Viernes)));
            $csv_output .= $Lunes . ",";
        }
        //$csv_output .= "AssiesCad,";
        
        $csv_output .= "Priorities Demand,";
        $csv_output .= "SO + Forecast Demand,";
        $csv_output .= "First 28 Wks Supply POs,";
        $csv_output .= "Total Supply POs Placed,";
        
        
        $cAs = 0;
        foreach ($ArrAssies AS &$Ass){
            $cAs++;
            $cAss = $Ass[1];
            $$cAss = $cAs;
            $tAss = $Ass[36];
            $csv_output .= $cAss . ",";
        }
        
        
        
        /*
        $csv_output .= "12 wks POs,";
        $csv_output .= "12 wks demand,";
        $csv_output .= "Total 12 wks shortage,";
        $csv_output .= "Available in the market,";
        $csv_output .= "Units Price,";
        $csv_output .= "PPV,";
        $csv_output .= "Total on PO,";
        $csv_output .= "Total Demand,";
        $csv_output .= "Coverage,";
        $csv_output .= "Coverage %,";
        $csv_output .= "Comment,";*/
        $csv_output = substr($csv_output, 0, -1) . "\n";
        //echo $csv_output;
        $crow = 0;
        //echo "<pre>";
        //print_r($ArrAssy);
        //echo "</pre>";
        
        foreach ($ArrAssy AS &$Data){
            $crow++;
            $C0 = $Data[0];
            $C1 = $Data[1];
            $C2 = $Data[2];
            $C3 = $Data[3];
            $C4 = $Data[4];
            $C5 = $Data[5];
            $C6 = $Data[6];
            $C7 = $Data[7];
            $C8 = $Data[8];
            $C9 = $Data[9];
            $C10 = $Data[10];
            $C11 = $Data[11];
            $C12 = $Data[12];
            $C13 = $Data[13];
            $C14 = $Data[14];
            $C15 = $Data[15];
            $C16 = $Data[16];
            $C17 = $Data[17];
            $C18 = $Data[18];
            $C19 = $Data[19];
            $C20 = $Data[20];
            $C21 = $Data[21];
            $C22 = $Data[22];
            $C23 = $Data[23];
            $C24 = $Data[24];
            $C25 = $Data[25];
            $C26 = $Data[26];
            $C27 = $Data[27];
            $C28 = $Data[28];
            $C29 = $Data[29];
            $Co = $Data[30];
            $PriVend = $Data[31];
            $CCx = $Data[32];
            //echo $C0 . "<BR>";
            //echo $C25;
            
            $conf = explode("|", $C25);
            
            $cconf = 0;

            foreach ($conf AS &$QConf){
                $cconf++;
                $varco = "Conf" . $cconf;
                $$varco = $QConf;

            }
            
            
            $demand = explode("|", $C26);
            $cd = 0;
            foreach ($demand AS &$QDe){
                $cd++;
                $varde = "Dem" . $cd;
                $$varde = $QDe;
                
            }
            
            $nA = 0;
            //Assies
            while ($nA < $cAssies){
                $nA++;
                $vAss = "Ax" . $nA;
                $$vAss = 0;
                
            }
            
            $dAss = explode(">", $C28);
            $cGroup = "(";
            foreach ($dAss AS &$dAsss){
                $dAssss = explode(":", $dAsss);
                $AssX = $dAssss[0];
                $AssXY = $dAssss[1];
                $colA = $$AssX;
                $varColA = "Ax" . $colA;
                $$varColA = $AssXY;
                
                //Obtiene a que group
                $cGroup .= "Assembly LIKE '$AssX' OR ";
                
            }
            
            $cGroup = substr($cGroup, 0, -4) . ") ";
            
            $nA2 = 0;
            $C30 = "";
            //Assies
            while ($nA2 < $cAssies){
                $nA2++;
                $vAssx = "Ax" . $nA2;
                $C30 .= $$vAssx . ",";
                
            }
            
            if(!empty($C30)){
                $C30 = substr($C30, 0, -1);
            }
            
            $TStock = $C6 + $C7 + $Co;
            $C01 = "Confirmed Purchase Orders";
            $C001 = "Demand";
            $C0001 = "Shortage";
            $Weeks12POs = 0;
            $Weeks12POs = $Conf1 + $Conf2 + $Conf3 + $Conf4 + $Conf5 + $Conf6 + $Conf7 + $Conf8 + $Conf9 + $Conf10 + $Conf11 + $Conf12 + $Conf13 + $Conf14 + $Conf15 + $Conf16;
            $TotalPOPeriod = $Weeks12POs;
            $Weeks12Demand = 0;
            $Weeks12Demand = $Dem1 + $Dem2 + $Dem3 + $Dem4 + $Dem5 + $Dem6 + $Dem7 + $Dem8 + $Dem9 + $Dem10 + $Dem11 + $Dem12 + $Dem13 + $Dem14 + $Dem15 + $Dem16;
            $tDemPeriod = $Weeks12Demand;
            $TShortage = ($TStock + $Weeks12POs) - $Weeks12Demand;
            $s = 0;
            //Shortage
            while ($s < 16){
                $sa = $s;
                $s++;
                $vS = "Sh" . $s;
                $dVa = "Dem" . $s;
                $vSa = "Sh" . $sa;
                
                
                if($s == 1){
                    $da = $$dVa;
                    $$vS = $TStock - $da;
                } else {
                    //Calcula
                    $va = $$vSa;
                    $da = $$dVa;
                    $$vS = $va - $da;
                    
                }
                
                
            }
            
            
            if($nGr > 0){
                //Group
                $sidG = "SELECT DISTINCT idGroup FROM AssembliesGroup WHERE $cGroup AND $grups ORDER BY idGroup ASC";
                $ridG = $cnx->query($sidG)->fetchAll();
                //echo $sidG;

                $Groups = "";
                foreach ($ridG AS &$idG){
                    $idGroup = $idG['idGroup'];
                    //Obtiene los Groups
                    $sGrop = "SELECT GroupName FROM AssGroup WHERE idGroup = '$idGroup'";
                    $rGrop = $cnx->query($sGrop)->fetchArray();
                    $gGroup = $rGrop['GroupName'];
                    $Groups .= $gGroup . "|";
                }

                $Groups = substr($Groups, 0, -1);
            } else {
                $Groups = $gClassCode;
            }
            
            
            //Obtiene lo requerido
            $sReqDem = "SELECT SUM(Reqmnt_Qty) AS TDemandReq, SUM(Open_PO_Qty) AS TPOReq FROM InvDetail WHERE ID = '$C2' ORDER BY ID ASC LIMIT 0, 1";
            $sReqDem = "SELECT SUM(ReqmntQty) AS TDemandReq, SUM(OpenPOQty) AS TPOReq FROM PODemand WHERE Part = '$C2' ORDER BY Part ASC LIMIT 0, 1";
            //echo $sReqDem . "<BR>";
            $rReqDem = $cnx->query($sReqDem)->fetchArray();
            $tDemPlacedX = $rReqDem['TDemandReq'];
            $TotalPOPlacedX = $rReqDem['TPOReq'];
            
            if($tDemPlacedX > 0){
                $tDemPlaced = $tDemPlacedX;
            } else {
                $tDemPlaced = 0;
            }
            
            if($TotalPOPlacedX > 0){
                $TotalPOPlaced = $TotalPOPlacedX;
            } else {
                $TotalPOPlaced = 0;
            }
            
            //Cuenta las negativos
            $nC = 8;
            $vConteoNeg = 0;
            while($nC < 20){
                $nC++;
                $varC = "C" . $nC;
                
                if($$varC < 0){
                    $vConteoNeg++;
                }
                
            }
            
            //AllPO CONFIRM
            $sPOs = "SELECT * FROM PodData WHERE Part_Nbr LIKE '$C2' AND Balance_Due > '0' AND Vendor_Promise_Dt > '2000-01-01' ORDER BY Vendor_Promise_Dt ASC";
            $rPOs = $cnx->query($sPOs)->fetchAll();
            
            $gComm = "";
            
            foreach ($rPOs AS &$rP){
                //Data 
                $Ax_PO = $rP['Purch_Order_Number'];
                $Ax_Vendor = str_replace('"', "", str_replace("'", "", str_replace(",", "", $rP['Vendor_Name'])));
                $Ax_Balance = $rP['Balance_Due'];
                $Ax_Track = str_replace('"', "", str_replace("'", "", str_replace(",", "", $rP['Tracking_Nbr'])));
                $Ax_VendorP = $rP['Vendor_Promise_Dt'];
                $Ax_VendorNumber = $rP['Vendor_Number'];
                
                if(strtotime($Ax_VendorP) > strtotime('2000-01-01')){
                    $Ax_Status = "Confirmed";
                    $Ax_ETA = "ETA[$Ax_VendorP] ";
                } else {
                    $Ax_Status = "Not Confirmed";
                    $Ax_ETA = "";
                }
                
                $gComm .= "Tracking[$Ax_Track] PO[$Ax_PO] Qty[$Ax_Balance] Supplier[$Ax_VendorNumber:$Ax_Vendor] $Ax_ETA Stat[$Ax_Status] // ";
            }
            
            if(!empty($gComm)){
                $gComm = "***CONFIRM***" . substr($gComm, 0, -4);
            }
            
            //AllPO UNCONFIRM
            $sPOsu = "SELECT * FROM PodData WHERE Part_Nbr LIKE '$C2' AND Balance_Due > '0' AND Vendor_Promise_Dt = '2000-01-01' ORDER BY Expected_Delivery_Date ASC";
            $rPOsu = $cnx->query($sPOsu)->fetchAll();
            
            $gCommu = "";
            
            foreach ($rPOsu AS &$rPu){
                //Data 
                $Ax_PO = $rPu['Purch_Order_Number'];
                $Ax_Vendor = str_replace('"', "", str_replace("'", "", str_replace(",", "", $rPu['Vendor_Name'])));
                $Ax_Balance = $rPu['Balance_Due'];
                $Ax_Track = str_replace('"', "", str_replace("'", "", str_replace(",", "", $rPu['Tracking_Nbr'])));
                $Ax_VendorP = $rPu['Vendor_Promise_Dt'];
                $Ax_VendorNumber = $rPu['Vendor_Number'];
                
                if(strtotime($Ax_VendorP) > strtotime('2000-01-01')){
                    $Ax_Status = "Confirmed";
                    $Ax_ETA = "ETA[$Ax_VendorP] ";
                } else {
                    $Ax_Status = "Not Confirmed";
                    $Ax_ETA = "";
                }
                
                $gCommu .= "Tracking[$Ax_Track] PO[$Ax_PO] Qty[$Ax_Balance] Supplier[$Ax_VendorNumber:$Ax_Vendor] $Ax_ETA Stat[$Ax_Status] // ";
            }
            
            if(!empty($gCommu)){
                $gComm .= "***UNCONFIRM***" . substr($gCommu, 0, -4);
            }
            
            $Conf1X = $Conf1 + $C27;
            
            $csv_output .= "$crow,$C01,$Groups,$C2,$CCx,,$C8,$C3,$PriVend,$C4,$C5,$C6,$C7,$Co,$C27,$vConteoNeg,,,,$C29,$gComm,$TStock,$Conf1X,$Conf2,$Conf3,$Conf4,$Conf5,$Conf6,$Conf7,$Conf8,$Conf9,$Conf10,$Conf11,$Conf12,$Conf13,$Conf14,$Conf15,$Conf16,$tDemPeriod,$tDemPlaced,$TotalPOPeriod,$TotalPOPlaced,$C30\n"; //,$Weeks12POs,$Weeks12Demand,$TShortage
            $csv_output .= "$crow,$C001,$Groups,$C2,$CCx,,$C8,$C3,$PriVend,$C4,$C5,$C6,$C7,$Co,$C27,$vConteoNeg,,,,$C29,,$TStock,$Dem1,$Dem2,$Dem3,$Dem4,$Dem5,$Dem6,$Dem7,$Dem8,$Dem9,$Dem10,$Dem11,$Dem12,$Dem13,$Dem14,$Dem15,$Dem16,$tDemPeriod,$tDemPlaced,$TotalPOPeriod,$TotalPOPlaced,$C30\n";//,$Weeks12POs,$Weeks12Demand,$TShortage
            //$csv_output .= "$crow,$C0001,$Groups,$C2,,$C8,$C3,$C4,$C5,$C6,$C7,$Co,$C27,$vConteoNeg,,,,$C29,$gComm,$TStock,$Sh1,$Sh2,$Sh3,$Sh4,$Sh5,$Sh6,$Sh7,$Sh8,$Sh9,$Sh10,$Sh11,$Sh12,$Sh13,$Sh14,$Sh15,$Sh16,$tDemPeriod,$tDemPlaced,$TotalPOPeriod,$TotalPOPlaced,$C30\n";//,$Weeks12POs,$Weeks12Demand,$TShortage
            $csv_output .= "$crow,$C1,$Groups,$C2,$CCx,,$C8,$C3,$PriVend,$C4,$C5,$C6,$C7,$Co,$C27,$vConteoNeg,,,,$C29,,$TStock,$C9,$C10,$C11,$C12,$C13,$C14,$C15,$C16,$C17,$C18,$C19,$C20,$C21,$C22,$C23,$C24,$tDemPeriod,$tDemPlaced,$TotalPOPeriod,$TotalPOPlaced,$C30\n";//,$Weeks12POs,$Weeks12Demand,$TShortage
            //echo $csv_output;
        }
        
        break;
    case "CTB_ImpactProductionPlan":
        $ppSer = $_POST['ppISer'];
        $ppDates = $_POST['ppDates'];
        $ppAss = $_POST['ppAss'];
        //echo $Name . "<BR>";
        $DecVariable = base64_decode($ppSer);
        $ArrAssy = unserialize($DecVariable);
        $DecDates = base64_decode($ppDates);
        $ArrDates = unserialize($DecDates);
        $DecAssies = base64_decode($ppAss);
        $ArrAssies = unserialize($DecAssies);
        
        //print_r($ArrDates);
        //print_r($ArrAssy);
        $file = "PartsProductionPlan";
        
        $csv_output = ",,,,,,,,,,,,,,,,,,,,,Total,";
        $cAssies = 0;
        foreach ($ArrAssies AS &$Ass){
            $cAssies++;
            //$cAss = $Ass[1];
            $tAss = $Ass[28];
            $csv_output .= $tAss . ",";
        }
        
        $csv_output = substr($csv_output, 0, -1) . "\n";
        //Item	Description	Mfgr	Mfgr PN	MW OH	OvI	LT w
        $csv_output .= "Count,";
        $csv_output .= "Type,";
        $csv_output .= "Item,";
        $csv_output .= "Description,";
        $csv_output .= "Mfgr,";
        $csv_output .= "Mfgr PN,";
        $csv_output .= "MW OH,";
        $csv_output .= "OvI,";
        $csv_output .= "PO Past Due,";
        $csv_output .= "EngrStatus,";
        //$csv_output .= "LT w,";
        
        foreach ($ArrDates AS &$Viernes){
            $Lunes = date('M-d', strtotime('-4 days', strtotime($Viernes)));
            $csv_output .= $Lunes . ",";
        }
        //$csv_output .= "AssiesCad,";
        
        $cAs = 0;
        foreach ($ArrAssies AS &$Ass){
            $cAs++;
            $cAss = $Ass[1];
            $$cAss = $cAs;
            $tAss = $Ass[28];
            $csv_output .= $cAss . ",";
        }
        
        
        $csv_output = substr($csv_output, 0, -1) . "\n";
        $crow = 0;
        foreach ($ArrAssy AS &$Data){
            $crow++;
            $C0 = $Data[0];
            $C1 = $Data[1];
            $C2 = $Data[2];
            $C3 = $Data[3];
            $C4 = $Data[4];
            $C5 = $Data[5];
            $C6 = $Data[6];
            $C7 = $Data[7];
            $C8 = $Data[8];
            $C9 = $Data[9];
            $C10 = $Data[10];
            $C11 = $Data[11];
            $C12 = $Data[12];
            $C13 = $Data[13];
            $C14 = $Data[14];
            $C15 = $Data[15];
            $C16 = $Data[16];
            $C17 = $Data[17];
            $C18 = $Data[18];
            $C19 = $Data[19];
            $C20 = $Data[20];
            $C21 = $Data[21];
            $C22 = $Data[22];
            $C23 = $Data[23];
            $C24 = $Data[24];
            $C26 = $Data[25];
            
            $conf = explode("|", $C21);
            $cconf = 0;
            foreach ($conf AS &$QConf){
                $cconf++;
                $varco = "Conf" . $cconf;
                $$varco = $QConf;
                
            }
            
            $demand = explode("|", $C22);
            $cd = 0;
            foreach ($demand AS &$QDe){
                $cd++;
                $varde = "Dem" . $cd;
                $$varde = $QDe;
                
            }
            $nA = 0;
            //Assies
            while ($nA < $cAssies){
                $nA++;
                $vAss = "Ax" . $nA;
                $$vAss = 0;
            }
            
            $dAss = explode(">", $C24);
            foreach ($dAss AS &$dAsss){
                $dAssss = explode(":", $dAsss);
                $AssX = $dAssss[0];
                $AssXY = $dAssss[1];
                $colA = $$AssX;
                $varColA = "Ax" . $colA;
                $$varColA = $AssXY;
                
            }
            
            $nA2 = 0;
            $C25 = "";
            //Assies
            while ($nA2 < $cAssies){
                $nA2++;
                $vAssx = "Ax" . $nA2;
                $C25 .= $$vAssx . ",";
                
            }
            
            if(!empty($C25)){
                $C25 = substr($C25, 0, -1);
            }
            
            
            $C01 = "Confirmed Purchase Orders";
            $C001 = "Demand";
            $csv_output .= "$crow,$C01,$C2,$C3,$C4,$C5,$C6,$C7,$C23,$C26,$Conf1,$Conf2,$Conf3,$Conf4,$Conf5,$Conf6,$Conf7,$Conf8,$Conf9,$Conf10,$Conf11,$Conf12,$C25\n";
            $csv_output .= "$crow,$C001,$C2,$C3,$C4,$C5,$C6,$C7,$C23,$C26,$Dem1,$Dem2,$Dem3,$Dem4,$Dem5,$Dem6,$Dem7,$Dem8,$Dem9,$Dem10,$Dem11,$Dem12,$C25\n";
            $csv_output .= "$crow,$C1,$C2,$C3,$C4,$C5,$C6,$C7,$C23,$C26,$C9,$C10,$C11,$C12,$C13,$C14,$C15,$C16,$C17,$C18,$C19,$C20,$C25\n";
            
        }
        
        break;
    case "CTB_ProductionPlan16":
        $ppSer = $_POST['ppSer'];
        $ppDates = $_POST['ppDates'];
        //echo $Name . "<BR>";
        $DecVariable = base64_decode($ppSer);
        $ArrAssy = unserialize($DecVariable);
        $DecDates = base64_decode($ppDates);
        $ArrDates = unserialize($DecDates);
        
        $gClassCode = base64_decode($_GET['token']);
        
        $gi = "SELECT * FROM AssGroup WHERE GroupCode = '$gClassCode'";
        $ni = $cnx->query($gi)->numRows();
        if($ni == 1){
            //Obtiene info
            $ri = $cnx->query($gi)->fetchArray();
            $gIDGroup = $ri['idGroup'];
            $gGtype = $ri['GType'];
            
            
            if($gGtype == "Collection"){
                //obtiene los grupos
                $sGr = "SELECT * FROM GroupCollection WHERE idCollection = '$gIDGroup'";
                $nGr = $cnx->query($sGr)->numRows();
                
                if($nGr > 0){
                    $grups = "(";
                    $rGr = $cnx->query($sGr)->fetchAll();
                    foreach ($rGr AS $rG){
                        $gCCgroup = $rG['CGroup'];
                        $gCCIDGroup = $rG['idGroup'];
                        $grups .= "idGroup = '$gCCIDGroup' OR ";
                        
                    }
                    
                    $grups = substr($grups, 0, -4) . ")";
                    
                }
                
            }
            
        }
        
        
        //print_r($ArrDates);
        //print_r($ArrAssy);
        $file = "ProductionPlan";
        
        $csv_output .= "Count,";
        $csv_output .= "Group,";
        $csv_output .= "Assembly,";
        $csv_output .= "Description,";
        $csv_output .= "Price,";
        $csv_output .= "Revenue,";
        
        foreach ($ArrDates AS &$Viernes){
            $Lunes = date('M-d', strtotime('-4 days', strtotime($Viernes)));
            $csv_output .= $Lunes . ",";
        }
        $csv_output .= "Total,";
        
        
        $csv_output = substr($csv_output, 0, -1) . "\n";
        
        foreach ($ArrAssy AS &$Data){
            $C0 = $Data[0];
            $C1 = $Data[1];
            $C2 = $Data[2];
            $C3 = str_replace(",", "", $Data[3]);
            $C4 = str_replace(",", "", $Data[37]);
            $C5 = $Data[5];
            $C6 = $Data[7];
            $C7 = $Data[9];
            $C8 = $Data[11];
            $C9 = $Data[13];
            $C10 = $Data[15];
            $C11 = $Data[17];
            $C12 = $Data[19];
            $C13 = $Data[21];
            $C14 = $Data[23];
            $C15 = $Data[25];
            $C16 = $Data[27];
            $C17 = $Data[29];
            $C18 = $Data[31];
            $C19 = $Data[33];
            $C20 = $Data[35];
            $C21 = $Data[36];
            
            if($nGr > 0){
                //Group
                $sidG = "SELECT DISTINCT idGroup FROM AssembliesGroup WHERE Assembly = '$C1' AND $grups ORDER BY idGroup ASC";
                $ridG = $cnx->query($sidG)->fetchAll();
                //echo $sidG;

                $Groups = "";
                foreach ($ridG AS &$idG){
                    $idGroup = $idG['idGroup'];
                    //Obtiene los Groups
                    $sGrop = "SELECT GroupName FROM AssGroup WHERE idGroup = '$idGroup'";
                    $rGrop = $cnx->query($sGrop)->fetchArray();
                    $gGroup = $rGrop['GroupName'];
                    $Groups .= $gGroup . "|";
                }

                $Groups = substr($Groups, 0, -1);
            } else {
                $Groups = $gClassCode;
            }
            
            $csv_output .= "$C0,$Groups,$C1,\"$C2\",$C3,$C4,$C5,$C6,$C7,$C8,$C9,$C10,$C11,$C12,$C13,$C14,$C15,$C16,$C17,$C18,$C19,$C20,$C21\n";
            
        }
        
        break;
    case "CTB_ProductionPlan":
        $ppSer = $_POST['ppSer'];
        $ppDates = $_POST['ppDates'];
        //echo $Name . "<BR>";
        $DecVariable = base64_decode($ppSer);
        $ArrAssy = unserialize($DecVariable);
        $DecDates = base64_decode($ppDates);
        $ArrDates = unserialize($DecDates);
        
        //print_r($ArrDates);
        //print_r($ArrAssy);
        $file = "ProductionPlan";
        
        $csv_output .= "Count,";
        $csv_output .= "Assembly,";
        $csv_output .= "Description,";
        $csv_output .= "Price,";
        $csv_output .= "Revenue,";
        
        foreach ($ArrDates AS &$Viernes){
            $Lunes = date('M-d', strtotime('-4 days', strtotime($Viernes)));
            $csv_output .= $Lunes . ",";
        }
        $csv_output .= "Total,";
        
        
        $csv_output = substr($csv_output, 0, -1) . "\n";
        
        foreach ($ArrAssy AS &$Data){
            $C0 = $Data[0];
            $C1 = $Data[1];
            $C2 = $Data[2];
            $C3 = str_replace(",", "", $Data[3]);
            $C4 = str_replace(",", "", $Data[29]);
            $C5 = $Data[5];
            $C6 = $Data[7];
            $C7 = $Data[9];
            $C8 = $Data[11];
            $C9 = $Data[13];
            $C10 = $Data[15];
            $C11 = $Data[17];
            $C12 = $Data[19];
            $C13 = $Data[21];
            $C14 = $Data[23];
            $C15 = $Data[25];
            $C16 = $Data[27];
            $C17 = $Data[28];
            
            $csv_output .= "$C0,$C1,\"$C2\",$C3,$C4,$C5,$C6,$C7,$C8,$C9,$C10,$C11,$C12,$C13,$C14,$C15,$C16,$C17\n";
            
        }
        
        break;
    case "PNPOControlDetail":
        $gKey = $_GET['Key'];
        $file = "($gKey)POControl";
        $rown = 1;
        //Obtiene las columnas
        $scol = "SHOW COLUMNS FROM PodData";
        $ncol = $cnx->query($scol)->numRows();
        $LCol = $cnx->query($scol)->fetchAll();
        
        foreach ($LCol as &$LColx) {
            $colv = $LColx['Field'];
            $csv_output .= "$colv" . ",";
        }
        
        $csv_output .= "TAT" . ",";
        
        if($csv_output != ""){
            $csv_output = substr($csv_output, 0, -1) . "\n";
        }
        //SELECT * FROM J01 ORDER BY SERVICE_ORDER_ID DESC
        //$cdata = "SELECT *, DATEDIFF('$dtAhora', Purchase_Order_Add_Date) AS TAT FROM POControl WHERE QtyExpire > '0' $Extra ORDER BY dtCreated ASC";
        $cdata = "SELECT *, DATEDIFF(Purchase_Order_Add_Date, '$dateToday') AS TAT FROM PodData "
                . "WHERE Balance_Due > '0' AND Disp_Type != 'G' AND Class_Code != '' AND Purch_Order_Number NOT LIKE '9CN%' "
                . "AND (Part_Nbr LIKE '$gKey%')";
        //$csv_output .= $cdata . "\n";
        //$csv_output = str_replace("|", "$", $csv_output);
        $i = $ncol + 1;
        //$csv_output = "$cdata\n";
        $LRows = $cnx->query($cdata)->fetchAll();
        foreach ($LRows as &$LRowsx) {
            $g_1 = $LRowsx['idPodData'];
            $g_2 = $LRowsx['dtAdded'];
            $g_3 = $LRowsx['Buyer'];
            $g_4 = $LRowsx['IDOwner'];
            $g_5 = $LRowsx['Owner'];
            $g_6 = $LRowsx['Vendor_Number'];
            $g_7 = $LRowsx['Vendor_Name'];
            $g_8 = $LRowsx['Purch_Order_Number'];
            $g_9 = $LRowsx['Lne_Nbr'];
            $g_10 = $LRowsx['Class_Code'];
            $g_11 = $LRowsx['Customer'];
            $g_12 = $LRowsx['Part_Nbr'];
            $g_13 = $LRowsx['Description'];
            $g_14 = $LRowsx['Quantity_Ordered'];
            $g_15 = $LRowsx['Expected_Delivery_Date'];
            $g_16 = $LRowsx['Balance_Due'];
            $g_17 = $LRowsx['Currency_List_Unit_Price'];
            $g_18 = $LRowsx['Extended_Price'];
            $g_19 = $LRowsx['Requested_Delivery_Date'];
            $g_20 = $LRowsx['Vendor_Promise_Dt'];
            $g_21 = $LRowsx['Tracking_Nbr'];
            $g_22 = $LRowsx['Disp_Type'];
            $g_23 = $LRowsx['Disp_Ref'];
            $g_24 = $LRowsx['Mfgr_ID'];
            $g_25 = $LRowsx['Mfgr_Item_Nbr'];
            $g_26 = $LRowsx['Purchase_Order_Add_Date'];
            $g_27 = $LRowsx['Acctg_Value'];
            $g_28 = $LRowsx['Delta_Value'];
            $g_29 = $LRowsx['ImpactValue'];
            $g_30 = $LRowsx['dtParts'];
            $g_31 = $LRowsx['dtDelta'];
            $g_32 = $LRowsx['ID_PPV'];
            $g_33 = $LRowsx['PPV'];
            $g_34 = $LRowsx['V_PromiseDate'];
            $g_35 = $LRowsx['V_Status'];
            $g_36 = $LRowsx['Status'];
            $g_37 = $LRowsx['TAT'];
            
            for ($j=0;$j<$i;$j++){
                $jx = $j+1;
                $var = "g_" . $jx;
                $val = $$var;
                $buffer = "\"" . str_replace(array(",", "\r", "\n", "\t"), '', $val) . "\"";
                $csv_output .= strtoupper($buffer) . ",";
            }

            $csv_output .= "\n";
        }
        
        
        break;
    case "GenPOControlDetail":
        //Vendor_Promise_Dt < NOW() AND Balance_Due > 0 AND Vendor_Promise_Dt != '2000-01-01'
        $gIDOwner = base64_decode($_GET['KeyII']);
        $gCustomer = base64_decode($_GET['KeyIII']);
        $gVendor = base64_decode($_GET['KeyIV']);
        $gRisk = base64_decode($_GET['KeyV']);
        $gStatus = base64_decode($_GET['KeyVI']);
        $gDays = base64_decode($_GET['KeyVII']);
        $file = "GeneralPOControl";
        //$csv_output .= "$gIDOwner - $gCustomer - $gVendor - $gRisk - $gStatus - $gDays\r\n";
        
        //Owner
        if(!empty($gIDOwner)){
            $Extra .= " AND IDOwner = '$gIDOwner' ";
        }
        
        //Customer
        if(!empty($gCustomer)){
            $Extra .= " AND Customer LIKE '$gCustomer' ";
        }
        
        //Vendor
        if(!empty($gVendor)){
            $Extra .= " AND Vendor_Name = '$gVendor' ";
        }
        
        //Risk
        if(!empty($gRisk)){
            switch($gRisk){
                case "ME8":
                    $Extra .= " AND DATEDIFF(Vendor_Promise_Dt, '$dtAhora') < '8'";
                    break;
                case "ME15":
                    $Extra .= " AND DATEDIFF(Vendor_Promise_Dt, '$dtAhora') BETWEEN '8' AND '14'";
                    break;
                case "ME22":
                    $Extra .= " AND DATEDIFF(Vendor_Promise_Dt, '$dtAhora') BETWEEN '15' AND '21'";
                    break;
                case "ME31":
                    $Extra .= " AND DATEDIFF(Vendor_Promise_Dt, '$dtAhora') BETWEEN '22' AND '30'";
                    break;
                case "ME61":
                    $Extra .= " AND DATEDIFF(Vendor_Promise_Dt, '$dtAhora') BETWEEN '31' AND '60'";
                    break;
                case "ME91":
                    $Extra .= " AND DATEDIFF(Vendor_Promise_Dt, '$dtAhora') BETWEEN '61' AND '90'";
                    break;
                case "MAS90":
                    $Extra .= " AND DATEDIFF(Vendor_Promise_Dt, '$dtAhora') > '90'";
                    break;
            }
        }
        
        //Status
        if(!empty($gStatus)){
            $Extra .= " AND Status = '$gStatus' ";
        }
        
        //Day
        if(!empty($gDays)){
            $Extra .= " AND DATEDIFF(Vendor_Promise_Dt, '$dtAhora') = '$gDays' ";
        }
        
        
        $rown = 1;
        //Obtiene las columnas
        $scol = "SHOW COLUMNS FROM PodData";
        $ncol = $cnx->query($scol)->numRows();
        $LCol = $cnx->query($scol)->fetchAll();
        
        foreach ($LCol as &$LColx) {
            $colv = $LColx['Field'];
            $csv_output .= "$colv" . ",";
        }
        
        $csv_output .= "TAT" . ",";
        
        if($csv_output != ""){
            $csv_output = substr($csv_output, 0, -1) . "\n";
        }
        //SELECT * FROM J01 ORDER BY SERVICE_ORDER_ID DESC
        //$cdata = "SELECT *, DATEDIFF('$dtAhora', Purchase_Order_Add_Date) AS TAT FROM POControl WHERE QtyExpire > '0' $Extra ORDER BY dtCreated ASC";
        //Exception made for ticket #7528
        $cdata = "SELECT *, DATEDIFF(Vendor_Promise_Dt, '$dateToday') AS TAT FROM PodData "
                . "WHERE Balance_Due > 0 "
                . "AND Disp_Type != 'G' AND Class_Code != '' AND Purch_Order_Number NOT LIKE '9CN%' "
                . "$Extra";
                //. "AND Purch_Order_Number != '249209';";
        //$csv_output .= $cdata . "\n";
        //$csv_output = str_replace("|", "$", $csv_output);
        $i = $ncol + 1;
        //$csv_output = "$cdata\n";
        $LRows = $cnx->query($cdata)->fetchAll();
        foreach ($LRows as &$LRowsx) {
            $g_1 = $LRowsx['idPodData'];
            $g_2 = $LRowsx['dtAdded'];
            $g_3 = $LRowsx['Buyer'];
            $g_4 = $LRowsx['IDOwner'];
            $g_5 = $LRowsx['Owner'];
            $g_6 = $LRowsx['Vendor_Number'];
            $g_7 = $LRowsx['Vendor_Name'];
            $g_8 = $LRowsx['Purch_Order_Number'];
            $g_9 = $LRowsx['Lne_Nbr'];
            $g_10 = $LRowsx['Class_Code'];
            $g_11 = $LRowsx['Customer'];
            $g_12 = $LRowsx['Part_Nbr'];
            $g_13 = $LRowsx['Description'];
            $g_14 = $LRowsx['Quantity_Ordered'];
            $g_15 = $LRowsx['Expected_Delivery_Date'];
            $g_16 = $LRowsx['Balance_Due'];
            $g_17 = $LRowsx['Currency_List_Unit_Price'];
            $g_18 = $LRowsx['Extended_Price'];
            $g_19 = $LRowsx['Requested_Delivery_Date'];
            $g_20 = $LRowsx['Vendor_Promise_Dt'];
            $g_21 = $LRowsx['Tracking_Nbr'];
            $g_22 = $LRowsx['Disp_Type'];
            $g_23 = $LRowsx['Disp_Ref'];
            $g_24 = $LRowsx['Mfgr_ID'];
            $g_25 = $LRowsx['Mfgr_Item_Nbr'];
            $g_26 = $LRowsx['Purchase_Order_Add_Date'];
            $g_27 = $LRowsx['Acctg_Value'];
            $g_28 = $LRowsx['Delta_Value'];
            $g_29 = $LRowsx['ImpactValue'];
            $g_30 = $LRowsx['dtParts'];
            $g_31 = $LRowsx['dtDelta'];
            $g_32 = $LRowsx['ID_PPV'];
            $g_33 = $LRowsx['PPV'];
            $g_34 = $LRowsx['V_PromiseDate'];
            $g_35 = $LRowsx['V_Status'];
            $g_36 = $LRowsx['Status'];
            $g_37 = $LRowsx['TAT'];
            
            for ($j=0;$j<$i;$j++){
                $jx = $j+1;
                $var = "g_" . $jx;
                $val = $$var;
                $buffer = "\"" . str_replace(array(",", "\r", "\n", "\t"), '', $val) . "\"";
                $csv_output .= strtoupper($buffer) . ",";
            }

            $csv_output .= "\n";
        }
        
        break;
    case "ActPOControlDetail":
        //Vendor_Promise_Dt < NOW() AND Balance_Due > 0 AND Vendor_Promise_Dt != '2000-01-01'
        $gIDOwner = base64_decode($_GET['KeyII']);
        $gCustomer = base64_decode($_GET['KeyIII']);
        $gVendor = base64_decode($_GET['KeyIV']);
        $gRisk = base64_decode($_GET['KeyV']);
        $gStatus = base64_decode($_GET['KeyVI']);
        $gDays = base64_decode($_GET['KeyVII']);
        $file = "ActivePOControl";
        //$csv_output .= "$gIDOwner - $gCustomer - $gVendor - $gRisk - $gStatus - $gDays\r\n";
        
        //Owner
        if(!empty($gIDOwner)){
            $Extra .= " AND IDOwner = '$gIDOwner' ";
        }
        
        //Customer
        if(!empty($gCustomer)){
            $Extra .= " AND Customer LIKE '$gCustomer' ";
        }
        
        //Vendor
        if(!empty($gVendor)){
            $Extra .= " AND Vendor_Name = '$gVendor' ";
        }
        
        //Risk
        if(!empty($gRisk)){
            switch($gRisk){
                case "ME8":
                    $Extra .= " AND DATEDIFF(Vendor_Promise_Dt, '$dtAhora') < '8'";
                    break;
                case "ME15":
                    $Extra .= " AND DATEDIFF(Vendor_Promise_Dt, '$dtAhora') BETWEEN '8' AND '14'";
                    break;
                case "ME22":
                    $Extra .= " AND DATEDIFF(Vendor_Promise_Dt, '$dtAhora') BETWEEN '15' AND '21'";
                    break;
                case "ME31":
                    $Extra .= " AND DATEDIFF(Vendor_Promise_Dt, '$dtAhora') BETWEEN '22' AND '30'";
                    break;
                case "ME61":
                    $Extra .= " AND DATEDIFF(Vendor_Promise_Dt, '$dtAhora') BETWEEN '31' AND '60'";
                    break;
                case "ME91":
                    $Extra .= " AND DATEDIFF(Vendor_Promise_Dt, '$dtAhora') BETWEEN '61' AND '90'";
                    break;
                case "MAS90":
                    $Extra .= " AND DATEDIFF(Vendor_Promise_Dt, '$dtAhora') > '90'";
                    break;
            }
        }
        
        //Status
        if(!empty($gStatus)){
            $Extra .= " AND Status = '$gStatus' ";
        }
        
        //Day
        if(!empty($gDays)){
            $Extra .= " AND DATEDIFF(Vendor_Promise_Dt, '$dtAhora') = '$gDays' ";
        }
        
        
        $rown = 1;
        //Obtiene las columnas
        $scol = "SHOW COLUMNS FROM PodData";
        $ncol = $cnx->query($scol)->numRows();
        $LCol = $cnx->query($scol)->fetchAll();
        
        foreach ($LCol as &$LColx) {
            $colv = $LColx['Field'];
            $csv_output .= "$colv" . ",";
        }
        
        $csv_output .= "TAT" . ",";
        
        if($csv_output != ""){
            $csv_output = substr($csv_output, 0, -1) . "\n";
        }
        //SELECT * FROM J01 ORDER BY SERVICE_ORDER_ID DESC
        //$cdata = "SELECT *, DATEDIFF('$dtAhora', Purchase_Order_Add_Date) AS TAT FROM POControl WHERE QtyExpire > '0' $Extra ORDER BY dtCreated ASC";
        $cdata = "SELECT *, DATEDIFF(Vendor_Promise_Dt, '$dateToday') AS TAT FROM PodData "
                . "WHERE Vendor_Promise_Dt >= '$dateToday' AND Balance_Due > 0 "
                . "AND Disp_Type != 'G' AND Class_Code != '' AND Purch_Order_Number NOT LIKE '9CN%' "
                . "$Extra;";
        //$csv_output .= $cdata . "\n";
        //$csv_output = str_replace("|", "$", $csv_output);
        $i = $ncol + 1;
        //$csv_output = "$cdata\n";
        $LRows = $cnx->query($cdata)->fetchAll();
        foreach ($LRows as &$LRowsx) {
            $g_1 = $LRowsx['idPodData'];
            $g_2 = $LRowsx['dtAdded'];
            $g_3 = $LRowsx['Buyer'];
            $g_4 = $LRowsx['IDOwner'];
            $g_5 = $LRowsx['Owner'];
            $g_6 = $LRowsx['Vendor_Number'];
            $g_7 = $LRowsx['Vendor_Name'];
            $g_8 = $LRowsx['Purch_Order_Number'];
            $g_9 = $LRowsx['Lne_Nbr'];
            $g_10 = $LRowsx['Class_Code'];
            $g_11 = $LRowsx['Customer'];
            $g_12 = $LRowsx['Part_Nbr'];
            $g_13 = $LRowsx['Description'];
            $g_14 = $LRowsx['Quantity_Ordered'];
            $g_15 = $LRowsx['Expected_Delivery_Date'];
            $g_16 = $LRowsx['Balance_Due'];
            $g_17 = $LRowsx['Currency_List_Unit_Price'];
            $g_18 = $LRowsx['Extended_Price'];
            $g_19 = $LRowsx['Requested_Delivery_Date'];
            $g_20 = $LRowsx['Vendor_Promise_Dt'];
            $g_21 = $LRowsx['Tracking_Nbr'];
            $g_22 = $LRowsx['Disp_Type'];
            $g_23 = $LRowsx['Disp_Ref'];
            $g_24 = $LRowsx['Mfgr_ID'];
            $g_25 = $LRowsx['Mfgr_Item_Nbr'];
            $g_26 = $LRowsx['Purchase_Order_Add_Date'];
            $g_27 = $LRowsx['Acctg_Value'];
            $g_28 = $LRowsx['Delta_Value'];
            $g_29 = $LRowsx['ImpactValue'];
            $g_30 = $LRowsx['dtParts'];
            $g_31 = $LRowsx['dtDelta'];
            $g_32 = $LRowsx['ID_PPV'];
            $g_33 = $LRowsx['PPV'];
            $g_34 = $LRowsx['V_PromiseDate'];
            $g_35 = $LRowsx['V_Status'];
            $g_36 = $LRowsx['Status'];
            $g_37 = $LRowsx['TAT'];
            
            for ($j=0;$j<$i;$j++){
                $jx = $j+1;
                $var = "g_" . $jx;
                $val = $$var;
                $buffer = "\"" . str_replace(array(",", "\r", "\n", "\t"), '', $val) . "\"";
                $csv_output .= strtoupper($buffer) . ",";
            }

            $csv_output .= "\n";
        }
        
        break;
    case "DDPOControlDetail":
        //Vendor_Promise_Dt < NOW() AND Balance_Due > 0 AND Vendor_Promise_Dt != '2000-01-01'
        $gIDOwner = base64_decode($_GET['KeyII']);
        $gCustomer = base64_decode($_GET['KeyIII']);
        $gVendor = base64_decode($_GET['KeyIV']);
        $gRisk = base64_decode($_GET['KeyV']);
        $gStatus = base64_decode($_GET['KeyVI']);
        $gDays = base64_decode($_GET['KeyVII']);
        $file = "DDPOControlDetail";
        //$csv_output .= "$gIDOwner - $gCustomer - $gVendor - $gRisk - $gStatus - $gDays\r\n";
        
        //Owner
        if(!empty($gIDOwner)){
            $Extra .= " AND IDOwner = '$gIDOwner' ";
        }
        
        //Customer
        if(!empty($gCustomer)){
            $Extra .= " AND Customer = '$gCustomer' ";
        }
        
        //Vendor
        if(!empty($gVendor)){
            $Extra .= " AND Vendor_Name = '$gVendor' ";
        }
        
        //Risk
        if(!empty($gRisk)){
            switch($gRisk){
                case "LOW":
                    $Extra .= " AND DATEDIFF('$dtAhora', Purchase_Order_Add_Date) < '8'";
                    break;
                case "MEDIUM":
                    $Extra .= " AND DATEDIFF('$dtAhora', Purchase_Order_Add_Date) BETWEEN '8' AND '15'";
                    break;
                case "HIGH":
                    $Extra .= " AND DATEDIFF('$dtAhora', Purchase_Order_Add_Date) > '15'";
                    break;
            }
        }
        
        //Status
        if(!empty($gStatus)){
            $Extra .= " AND Status = '$gStatus' ";
        }
        
        //Day
        if(!empty($gDays)){
            $Extra .= " AND DATEDIFF('$dtAhora', Purchase_Order_Add_Date) = '$gDays' ";
        }
        
        
        $rown = 1;
        //Obtiene las columnas
        $scol = "SHOW COLUMNS FROM PodData";
        $ncol = $cnx->query($scol)->numRows();
        $LCol = $cnx->query($scol)->fetchAll();
        
        foreach ($LCol as &$LColx) {
            $colv = $LColx['Field'];
            $csv_output .= "$colv" . ",";
        }
        
        $csv_output .= "TAT" . ",";
        
        if($csv_output != ""){
            $csv_output = substr($csv_output, 0, -1) . "\n";
        }
        //SELECT * FROM J01 ORDER BY SERVICE_ORDER_ID DESC
        //$cdata = "SELECT *, DATEDIFF('$dtAhora', Purchase_Order_Add_Date) AS TAT FROM POControl WHERE QtyExpire > '0' $Extra ORDER BY dtCreated ASC";
        $cdata = "SELECT *, DATEDIFF('$dateToday', Purchase_Order_Add_Date) AS TAT FROM PodData "
                . "WHERE Vendor_Promise_Dt < '$dateToday' AND Balance_Due > 0 AND Vendor_Promise_Dt != '2000-01-01' "
                . "AND Disp_Type != 'G' AND Class_Code != '' AND Purch_Order_Number NOT LIKE '9CN%';";
        //$csv_output .= $cdata . "\n";
        //$csv_output = str_replace("|", "$", $csv_output);
        $i = $ncol + 1;
        //$csv_output = "$cdata\n";
        $LRows = $cnx->query($cdata)->fetchAll();
        foreach ($LRows as &$LRowsx) {
            $g_1 = $LRowsx['idPodData'];
            $g_2 = $LRowsx['dtAdded'];
            $g_3 = $LRowsx['Buyer'];
            $g_4 = $LRowsx['IDOwner'];
            $g_5 = $LRowsx['Owner'];
            $g_6 = $LRowsx['Vendor_Number'];
            $g_7 = $LRowsx['Vendor_Name'];
            $g_8 = $LRowsx['Purch_Order_Number'];
            $g_9 = $LRowsx['Lne_Nbr'];
            $g_10 = $LRowsx['Class_Code'];
            $g_11 = $LRowsx['Customer'];
            $g_12 = $LRowsx['Part_Nbr'];
            $g_13 = $LRowsx['Description'];
            $g_14 = $LRowsx['Quantity_Ordered'];
            $g_15 = $LRowsx['Expected_Delivery_Date'];
            $g_16 = $LRowsx['Balance_Due'];
            $g_17 = $LRowsx['Currency_List_Unit_Price'];
            $g_18 = $LRowsx['Extended_Price'];
            $g_19 = $LRowsx['Requested_Delivery_Date'];
            $g_20 = $LRowsx['Vendor_Promise_Dt'];
            $g_21 = $LRowsx['Tracking_Nbr'];
            $g_22 = $LRowsx['Disp_Type'];
            $g_23 = $LRowsx['Disp_Ref'];
            $g_24 = $LRowsx['Mfgr_ID'];
            $g_25 = $LRowsx['Mfgr_Item_Nbr'];
            $g_26 = $LRowsx['Purchase_Order_Add_Date'];
            $g_27 = $LRowsx['Acctg_Value'];
            $g_28 = $LRowsx['Delta_Value'];
            $g_29 = $LRowsx['ImpactValue'];
            $g_30 = $LRowsx['dtParts'];
            $g_31 = $LRowsx['dtDelta'];
            $g_32 = $LRowsx['ID_PPV'];
            $g_33 = $LRowsx['PPV'];
            $g_34 = $LRowsx['V_PromiseDate'];
            $g_35 = $LRowsx['V_Status'];
            $g_36 = $LRowsx['Status'];
            $g_37 = $LRowsx['TAT'];
            
            for ($j=0;$j<$i;$j++){
                $jx = $j+1;
                $var = "g_" . $jx;
                $val = $$var;
                $buffer = "\"" . str_replace(array(",", "\r", "\n", "\t"), '', $val) . "\"";
                $csv_output .= strtoupper($buffer) . ",";
            }

            $csv_output .= "\n";
        }
        
        break;
    case "DDPOControl":
        $gIDOwner = base64_decode($_GET['KeyII']);
        $gCustomer = base64_decode($_GET['KeyIII']);
        $gVendor = base64_decode($_GET['KeyIV']);
        $gRisk = base64_decode($_GET['KeyV']);
        $gStatus = base64_decode($_GET['KeyVI']);
        $gDays = base64_decode($_GET['KeyVII']);
        $file = "DDPOControl";
        //$csv_output .= "$gIDOwner - $gCustomer - $gVendor - $gRisk - $gStatus - $gDays\r\n";
        
        //Owner
        if(!empty($gIDOwner)){
            $Extra .= " AND IDOwner = '$gIDOwner' ";
        }
        
        //Customer
        if(!empty($gCustomer)){
            $Extra .= " AND Customer = '$gCustomer' ";
        }
        
        //Vendor
        if(!empty($gVendor)){
            $Extra .= " AND Vendor_Name = '$gVendor' ";
        }
        
        //Risk
        if(!empty($gRisk)){
            switch($gRisk){
                case "LOW":
                    $Extra .= " AND DATEDIFF('$dtAhora', Purchase_Order_Add_Date) < '8'";
                    break;
                case "MEDIUM":
                    $Extra .= " AND DATEDIFF('$dtAhora', Purchase_Order_Add_Date) BETWEEN '8' AND '15'";
                    break;
                case "HIGH":
                    $Extra .= " AND DATEDIFF('$dtAhora', Purchase_Order_Add_Date) > '15'";
                    break;
            }
        }
        
        //Status
        if(!empty($gStatus)){
            $Extra .= " AND Status = '$gStatus' ";
        }
        
        //Day
        if(!empty($gDays)){
            $Extra .= " AND DATEDIFF('$dtAhora', Purchase_Order_Add_Date) = '$gDays' ";
        }
        
        
        $rown = 1;
        //Obtiene las columnas
        $scol = "SHOW COLUMNS FROM POControl";
        $ncol = $cnx->query($scol)->numRows();
        $LCol = $cnx->query($scol)->fetchAll();
        
        foreach ($LCol as &$LColx) {
            $colv = $LColx['Field'];
            $csv_output .= "$colv" . ",";
        }
        
        $csv_output .= "TAT" . ",";
        
        if($csv_output != ""){
            $csv_output = substr($csv_output, 0, -1) . "\n";
        }
        //SELECT * FROM J01 ORDER BY SERVICE_ORDER_ID DESC
        $cdata = "SELECT *, DATEDIFF('$dtAhora', Purchase_Order_Add_Date) AS TAT FROM POControl WHERE QtyExpire > '0' $Extra ORDER BY dtCreated ASC";
        //$csv_output .= $cdata . "\n";
        //$csv_output = str_replace("|", "$", $csv_output);
        $i = $ncol + 1;
        //$csv_output = "$cdata\n";
        $LRows = $cnx->query($cdata)->fetchAll();
        foreach ($LRows as &$LRowsx) {
            $g_1 = $LRowsx['idPOC'];
            $g_2 = $LRowsx['dateAdded'];
            $g_3 = $LRowsx['Buyer'];
            $g_4 = $LRowsx['NBuyer'];
            $g_5 = $LRowsx['Class_Code'];
            $g_6 = $LRowsx['Customer'];
            $g_7 = $LRowsx['Part_Nbr'];
            $g_8 = $LRowsx['Description'];
            $g_9 = $LRowsx['Mfgr_Item_Nbr'];
            $g_10 = $LRowsx['Vendor_Name'];
            $g_11 = $LRowsx['Purch_Order_Number'];
            $g_12 = $LRowsx['Lne_Nbr'];
            $g_13 = $LRowsx['Purchase_Order_Add_Date'];
            $g_14 = $LRowsx['QtyNPromise'];
            $g_15 = $LRowsx['QtyPromise'];
            $g_16 = $LRowsx['QtyExpire'];
            $g_17 = $LRowsx['QtyDelivery'];
            $g_18 = $LRowsx['SQty'];
            $g_19 = $LRowsx['dtCreated'];
            $g_20 = $LRowsx['dtStarted'];
            $g_21 = $LRowsx['dtClosed'];
            $g_22 = $LRowsx['dtLastNote'];
            $g_23 = $LRowsx['idUserLastNote'];
            $g_24 = $LRowsx['UserLastNote'];
            $g_25 = $LRowsx['LastNote'];
            $g_26 = $LRowsx['IDOwner'];
            $g_27 = $LRowsx['Owner'];
            $g_28 = $LRowsx['Tracking_Nbr'];
            $g_29 = $LRowsx['Status'];
            $g_30 = $LRowsx['TAT'];
            
            for ($j=0;$j<$i;$j++){
                $jx = $j+1;
                $var = "g_" . $jx;
                $val = $$var;
                $buffer = "\"" . str_replace(array(",", "\r", "\n", "\t"), '', $val) . "\"";
                $csv_output .= strtoupper($buffer) . ",";
            }

            $csv_output .= "\n";
        }
        
        break;
    case "UCPOControl":
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
        $gIDOwner = base64_decode($_GET['KeyII']);
        $gCustomer = base64_decode($_GET['KeyIII']);
        $gVendor = base64_decode($_GET['KeyIV']);
        $gRisk = base64_decode($_GET['KeyV']);
        $gStatus = base64_decode($_GET['KeyVI']);
        $gDays = base64_decode($_GET['KeyVII']);
        $file = "POControl";
        //$csv_output .= "$gIDOwner - $gCustomer - $gVendor - $gRisk - $gStatus - $gDays\r\n";
        
        //Owner
        if(!empty($gIDOwner)){
            $Extra .= " AND IDOwner = '$gIDOwner' ";
        }
        
        //Customer
        if(!empty($gCustomer)){
            $Extra .= " AND Customer = '$gCustomer' ";
        }
        
        //Vendor
        if(!empty($gVendor)){
            $Extra .= " AND Vendor_Name = '$gVendor' ";
        }
        
        //Risk
        if(!empty($gRisk)){
            switch($gRisk){
                case "LOW":
                    $Extra .= " AND DATEDIFF('$dtAhora', Purchase_Order_Add_Date) < '8'";
                    break;
                case "MEDIUM":
                    $Extra .= " AND DATEDIFF('$dtAhora', Purchase_Order_Add_Date) BETWEEN '8' AND '15'";
                    break;
                case "HIGH":
                    $Extra .= " AND DATEDIFF('$dtAhora', Purchase_Order_Add_Date) > '15'";
                    break;
            }
        }
        
        //Status
        if(!empty($gStatus)){
            $Extra .= " AND Status = '$gStatus' ";
        }
        
        //Day
        if(!empty($gDays)){
            $Extra .= " AND DATEDIFF('$dtAhora', Purchase_Order_Add_Date) = '$gDays' ";
        }
        
        
        $rown = 1;
        //Obtiene las columnas
        $scol = "SHOW COLUMNS FROM PodData";
        $ncol = $cnx->query($scol)->numRows();
        $LCol = $cnx->query($scol)->fetchAll();
        
        foreach ($LCol as &$LColx) {
            $colv = $LColx['Field'];
            $csv_output .= "$colv" . ",";
        }
        
        $csv_output .= "TAT" . ",";
        
        if($csv_output != ""){
            $csv_output = substr($csv_output, 0, -1) . "\n";
        }
        //SELECT * FROM J01 ORDER BY SERVICE_ORDER_ID DESC
        //$cdata = "SELECT *, DATEDIFF('$dtAhora', Purchase_Order_Add_Date) AS TAT FROM POControl WHERE QtyNPromise > '0' $Extra ORDER BY dtCreated ASC";
        $cdata = "SELECT *, DATEDIFF('$dtAhora', Purchase_Order_Add_Date) AS TAT FROM PodData "
                . "WHERE Vendor_Promise_Dt = '2000-01-01' AND Balance_Due > 0 AND Disp_Type != 'G' AND Class_Code != '' AND Purch_Order_Number NOT LIKE '9CN%' $Extra"
                . "ORDER BY Purch_Order_Number ASC";
        //$csv_output .= $cdata . "\n";
        //$csv_output = str_replace("|", "$", $csv_output);
        $i = $ncol + 1;
        //$csv_output = "$cdata\n";
        $LRows = $cnx->query($cdata)->fetchAll();
        foreach ($LRows as &$LRowsx) {
            $g_1 = $LRowsx['idPodData'];
            $g_2 = $LRowsx['dtAdded'];
            $g_3 = $LRowsx['Buyer'];
            $g_4 = $LRowsx['IDOwner'];
            $g_5 = $LRowsx['Owner'];
            $g_6 = $LRowsx['Vendor_Number'];
            $g_7 = $LRowsx['Vendor_Name'];
            $g_8 = $LRowsx['Purch_Order_Number'];
            $g_9 = $LRowsx['Lne_Nbr'];
            $g_10 = $LRowsx['Class_Code'];
            $g_11 = $LRowsx['Customer'];
            $g_12 = $LRowsx['Part_Nbr'];
            $g_13 = $LRowsx['Description'];
            $g_14 = $LRowsx['Quantity_Ordered'];
            $g_15 = $LRowsx['Expected_Delivery_Date'];
            $g_16 = $LRowsx['Balance_Due'];
            $g_17 = $LRowsx['Currency_List_Unit_Price'];
            $g_18 = $LRowsx['Extended_Price'];
            $g_19 = $LRowsx['Requested_Delivery_Date'];
            $g_20 = $LRowsx['Vendor_Promise_Dt'];
            $g_21 = $LRowsx['Tracking_Nbr'];
            $g_22 = $LRowsx['Disp_Type'];
            $g_23 = $LRowsx['Disp_Ref'];
            $g_24 = $LRowsx['Mfgr_ID'];
            $g_25 = $LRowsx['Mfgr_Item_Nbr'];
            $g_26 = $LRowsx['Purchase_Order_Add_Date'];
            $g_27 = $LRowsx['Acctg_Value'];
            $g_28 = $LRowsx['Delta_Value'];
            $g_29 = $LRowsx['ImpactValue'];
            $g_30 = $LRowsx['dtParts'];
            $g_31 = $LRowsx['dtDelta'];
            $g_32 = $LRowsx['ID_PPV'];
            $g_33 = $LRowsx['PPV'];
            $g_34 = $LRowsx['V_PromiseDate'];
            $g_35 = $LRowsx['V_Status'];
            $g_36 = $LRowsx['Status'];
            $g_37 = $LRowsx['TAT'];
            
            
            for ($j=0;$j<$i;$j++){
                $jx = $j+1;
                $var = "g_" . $jx;
                $val = $$var;
                $buffer = "\"" . str_replace(array(",", "\r", "\n", "\t"), '', $val) . "\"";
                $csv_output .= strtoupper($buffer) . ",";
            }

            $csv_output .= "\n";
        }
        
        
        break;
    case "UCPOControlAnt":
        $gIDOwner = base64_decode($_GET['KeyII']);
        $gCustomer = base64_decode($_GET['KeyIII']);
        $gVendor = base64_decode($_GET['KeyIV']);
        $gRisk = base64_decode($_GET['KeyV']);
        $gStatus = base64_decode($_GET['KeyVI']);
        $gDays = base64_decode($_GET['KeyVII']);
        $file = "POControl";
        //$csv_output .= "$gIDOwner - $gCustomer - $gVendor - $gRisk - $gStatus - $gDays\r\n";
        
        //Owner
        if(!empty($gIDOwner)){
            $Extra .= " AND IDOwner = '$gIDOwner' ";
        }
        
        //Customer
        if(!empty($gCustomer)){
            $Extra .= " AND Customer = '$gCustomer' ";
        }
        
        //Vendor
        if(!empty($gVendor)){
            $Extra .= " AND Vendor_Name = '$gVendor' ";
        }
        
        //Risk
        if(!empty($gRisk)){
            switch($gRisk){
                case "LOW":
                    $Extra .= " AND DATEDIFF('$dtAhora', Purchase_Order_Add_Date) < '8'";
                    break;
                case "MEDIUM":
                    $Extra .= " AND DATEDIFF('$dtAhora', Purchase_Order_Add_Date) BETWEEN '8' AND '15'";
                    break;
                case "HIGH":
                    $Extra .= " AND DATEDIFF('$dtAhora', Purchase_Order_Add_Date) > '15'";
                    break;
            }
        }
        
        //Status
        if(!empty($gStatus)){
            $Extra .= " AND Status = '$gStatus' ";
        }
        
        //Day
        if(!empty($gDays)){
            $Extra .= " AND DATEDIFF('$dtAhora', Purchase_Order_Add_Date) = '$gDays' ";
        }
        
        
        $rown = 1;
        //Obtiene las columnas
        $scol = "SHOW COLUMNS FROM POControl";
        $ncol = $cnx->query($scol)->numRows();
        $LCol = $cnx->query($scol)->fetchAll();
        
        foreach ($LCol as &$LColx) {
            $colv = $LColx['Field'];
            $csv_output .= "$colv" . ",";
        }
        
        $csv_output .= "TAT" . ",";
        
        if($csv_output != ""){
            $csv_output = substr($csv_output, 0, -1) . "\n";
        }
        //SELECT * FROM J01 ORDER BY SERVICE_ORDER_ID DESC
        $cdata = "SELECT *, DATEDIFF('$dtAhora', Purchase_Order_Add_Date) AS TAT FROM POControl WHERE QtyNPromise > '0' $Extra ORDER BY dtCreated ASC";
        //$csv_output .= $cdata . "\n";
        //$csv_output = str_replace("|", "$", $csv_output);
        $i = $ncol + 1;
        //$csv_output = "$cdata\n";
        $LRows = $cnx->query($cdata)->fetchAll();
        foreach ($LRows as &$LRowsx) {
            $g_1 = $LRowsx['idPOC'];
            $g_2 = $LRowsx['dateAdded'];
            $g_3 = $LRowsx['Buyer'];
            $g_4 = $LRowsx['NBuyer'];
            $g_5 = $LRowsx['Class_Code'];
            $g_6 = $LRowsx['Customer'];
            $g_7 = $LRowsx['Part_Nbr'];
            $g_8 = $LRowsx['Description'];
            $g_9 = $LRowsx['Mfgr_Item_Nbr'];
            $g_10 = $LRowsx['Vendor_Name'];
            $g_11 = $LRowsx['Purch_Order_Number'];
            $g_12 = $LRowsx['Lne_Nbr'];
            $g_13 = $LRowsx['Purchase_Order_Add_Date'];
            $g_14 = $LRowsx['QtyNPromise'];
            $g_15 = $LRowsx['QtyPromise'];
            $g_16 = $LRowsx['QtyExpire'];
            $g_17 = $LRowsx['QtyDelivery'];
            $g_18 = $LRowsx['SQty'];
            $g_19 = $LRowsx['dtCreated'];
            $g_20 = $LRowsx['dtStarted'];
            $g_21 = $LRowsx['dtClosed'];
            $g_22 = $LRowsx['dtLastNote'];
            $g_23 = $LRowsx['idUserLastNote'];
            $g_24 = $LRowsx['UserLastNote'];
            $g_25 = $LRowsx['LastNote'];
            $g_26 = $LRowsx['IDOwner'];
            $g_27 = $LRowsx['Owner'];
            $g_28 = $LRowsx['Tracking_Nbr'];
            $g_29 = $LRowsx['Status'];
            $g_30 = $LRowsx['TAT'];
            
            for ($j=0;$j<$i;$j++){
                $jx = $j+1;
                $var = "g_" . $jx;
                $val = $$var;
                $buffer = "\"" . str_replace(array(",", "\r", "\n", "\t"), '', $val) . "\"";
                $csv_output .= strtoupper($buffer) . ",";
            }

            $csv_output .= "\n";
        }
        
        break;
    case "POControl":
        //Owner
        $gD1 = base64_decode($_GET['D1']);
        //Reporte
        $gD2 = base64_decode($_GET['D2']);
        //Risk
        $gD3 = base64_decode($_GET['D3']);
        //Vendor
        $gD4= base64_decode($_GET['D4']);
        //echo "D1:$gD1-D2:$gD2-D3:$gD3-D4:$gD4\n";
        //Owner
        
        if(!empty($gD2)){
            switch ($gD2){
                case "OwnDays":
                    $cdata = "SELECT *, DATEDIFF('$dtAhora', Purchase_Order_Add_Date) AS TAT FROM POControl WHERE IDOwner = '$gD1' AND QtyNPromise > '0' AND "
                        . "DATEDIFF('$dtAhora', Purchase_Order_Add_Date) = '$gD3' ORDER BY dtCreated ASC";
                    break;
                case "Days":
                    $cdata = "SELECT *, DATEDIFF('$dtAhora', Purchase_Order_Add_Date) AS TAT FROM POControl WHERE QtyNPromise > '0' AND "
                        . "DATEDIFF('$dtAhora', Purchase_Order_Add_Date) = '$gD3' ORDER BY dtCreated ASC";
                    break;
                case "CustomerDays":
                    $cdata = "SELECT *, DATEDIFF('$dtAhora', Purchase_Order_Add_Date) AS TAT FROM POControl WHERE QtyNPromise > '0' AND "
                        . "DATEDIFF('$dtAhora', Purchase_Order_Add_Date) = '$gD3' AND Customer = '$gD4' ORDER BY dtCreated ASC";
                    break;
                case "VendorDays":
                    $cdata = "SELECT *, DATEDIFF('$dtAhora', Purchase_Order_Add_Date) AS TAT FROM POControl WHERE QtyNPromise > '0' AND "
                        . "DATEDIFF('$dtAhora', Purchase_Order_Add_Date) = '$gD3' AND Vendor_Name = '$gD4' ORDER BY dtCreated ASC";
                    break;
                case "byOwnerRisk":
                    switch($gD3){
                        case "LOW":
                            $dateDiff = "DATEDIFF('$dtAhora', Purchase_Order_Add_Date) < '8'";
                            break;
                        case "MEDIUM":
                            $dateDiff = "DATEDIFF('$dtAhora', Purchase_Order_Add_Date) BETWEEN '8' AND '15'";
                            break;
                        case "HIGH":
                            $dateDiff = "DATEDIFF('$dtAhora', Purchase_Order_Add_Date) > '15'";
                            break;
                    }
                    //echo "$gD3\r\n";
                    $cdata = "SELECT *, DATEDIFF('$dtAhora', Purchase_Order_Add_Date) AS TAT FROM POControl WHERE QtyNPromise > '0' AND IDOwner = '$gD1' AND $dateDiff ORDER BY dtCreated ASC";
                    break;
                case "byOwner":
                    $cdata = "SELECT *, DATEDIFF('$dtAhora', Purchase_Order_Add_Date) AS TAT FROM POControl WHERE QtyNPromise > '0' AND IDOwner = '$gD1' ORDER BY dtCreated ASC";
                    break;
                case "byCustomerRisk":
                    switch($gD3){
                        case "LOW":
                            $dateDiff = "DATEDIFF('$dtAhora', Purchase_Order_Add_Date) < '8'";
                            break;
                        case "MEDIUM":
                            $dateDiff = "DATEDIFF('$dtAhora', Purchase_Order_Add_Date) BETWEEN '8' AND '15'";
                            break;
                        case "HIGH":
                            $dateDiff = "DATEDIFF('$dtAhora', Purchase_Order_Add_Date) > '15'";
                            break;
                    }
                    
                    $cdata = "SELECT *, DATEDIFF('$dtAhora', Purchase_Order_Add_Date) AS TAT FROM POControl WHERE Customer = '$gD4' AND QtyNPromise > '0' AND $dateDiff ORDER BY dtCreated ASC";
                    break;
                case "byVendorRisk":
                    switch($gD3){
                        case "LOW":
                            $dateDiff = "DATEDIFF('$dtAhora', Purchase_Order_Add_Date) < '8'";
                            break;
                        case "MEDIUM":
                            $dateDiff = "DATEDIFF('$dtAhora', Purchase_Order_Add_Date) BETWEEN '8' AND '15'";
                            break;
                        case "HIGH":
                            $dateDiff = "DATEDIFF('$dtAhora', Purchase_Order_Add_Date) > '15'";
                            break;
                    }
                    
                    $cdata = "SELECT *, DATEDIFF('$dtAhora', Purchase_Order_Add_Date) AS TAT FROM POControl WHERE Vendor_Name = '$gD4' AND QtyNPromise > '0' AND $dateDiff ORDER BY dtCreated ASC";
                    break;
                case "byRisk":
                    switch($gD3){
                        case "LOW":
                            $dateDiff = "DATEDIFF('$dtAhora', Purchase_Order_Add_Date) < '8'";
                            break;
                        case "MEDIUM":
                            $dateDiff = "DATEDIFF('$dtAhora', Purchase_Order_Add_Date) BETWEEN '8' AND '15'";
                            break;
                        case "HIGH":
                            $dateDiff = "DATEDIFF('$dtAhora', Purchase_Order_Add_Date) > '15'";
                            break;
                    }
                    
                    $cdata = "SELECT *, DATEDIFF('$dtAhora', Purchase_Order_Add_Date) AS TAT FROM POControl WHERE QtyNPromise > '0' AND $dateDiff ORDER BY dtCreated ASC";
                    break;
                case "byVendor":
                    $cdata = "SELECT *, DATEDIFF('$dtAhora', Purchase_Order_Add_Date) AS TAT FROM POControl WHERE QtyNPromise > '0' AND Vendor_Name = '$gD3' ORDER BY dtCreated ASC";
                    break;
                case "byCustomer":
                    $cdata = "SELECT *, DATEDIFF('$dtAhora', Purchase_Order_Add_Date) AS TAT FROM POControl WHERE QtyNPromise > '0' AND Customer = '$gD3' ORDER BY dtCreated ASC";
                    break;
                case "All":
                    $cdata = "SELECT *, DATEDIFF('$dtAhora', Purchase_Order_Add_Date) AS TAT FROM POControl WHERE QtyNPromise > '0' ORDER BY dtCreated ASC";
                    break;
                default:
                    $cdata = "SELECT *, DATEDIFF('$dtAhora', Purchase_Order_Add_Date) AS TAT FROM POControl WHERE IDOwner = '$gD1' AND QtyNPromise > '0' ORDER BY dtCreated ASC";
                    break;
            }
        } else {
            $cdata = "SELECT *, DATEDIFF('$dtAhora', Purchase_Order_Add_Date) AS TAT FROM POControl WHERE IDOwner = '$gD2' AND QtyNPromise > '0' ORDER BY dtCreated ASC";
        }
        $gD1x = str_replace(" ", "", str_replace(",", "", str_replace(".", "", $gD1)));
        //echo $cdata . "\n";
        $file = "POControl_$gD2" . "_" . $gD1x;
        
        $rown = 1;
        //Obtiene las columnas
        $scol = "SHOW COLUMNS FROM POControl";
        $ncol = $cnx->query($scol)->numRows();
        $LCol = $cnx->query($scol)->fetchAll();
        
        foreach ($LCol as &$LColx) {
            $colv = $LColx['Field'];
            $csv_output .= "$colv" . ",";
        }
        
        $csv_output .= "TAT" . ",";
        
        if($csv_output != ""){
            $csv_output = substr($csv_output, 0, -1) . "\n";
        }
        //SELECT * FROM J01 ORDER BY SERVICE_ORDER_ID DESC
        
        //$csv_output .= $cdata . "\n";
        //$csv_output = str_replace("|", "$", $csv_output);
        $i = $ncol + 1;
        //$csv_output = "$cdata\n";
        $LRows = $cnx->query($cdata)->fetchAll();
        foreach ($LRows as &$LRowsx) {
            $g_1 = $LRowsx['idPOC'];
            $g_2 = $LRowsx['dateAdded'];
            $g_3 = $LRowsx['Buyer'];
            $g_4 = $LRowsx['NBuyer'];
            $g_5 = $LRowsx['Class_Code'];
            $g_6 = $LRowsx['Customer'];
            $g_7 = $LRowsx['Part_Nbr'];
            $g_8 = $LRowsx['Description'];
            $g_9 = $LRowsx['Mfgr_Item_Nbr'];
            $g_10 = $LRowsx['Vendor_Name'];
            $g_11 = $LRowsx['Purch_Order_Number'];
            $g_12 = $LRowsx['Lne_Nbr'];
            $g_13 = $LRowsx['Purchase_Order_Add_Date'];
            $g_14 = $LRowsx['QtyNPromise'];
            $g_15 = $LRowsx['QtyPromise'];
            $g_16 = $LRowsx['QtyExpire'];
            $g_17 = $LRowsx['QtyDelivery'];
            $g_18 = $LRowsx['SQty'];
            $g_19 = $LRowsx['dtCreated'];
            $g_20 = $LRowsx['dtStarted'];
            $g_21 = $LRowsx['dtClosed'];
            $g_22 = $LRowsx['dtLastNote'];
            $g_23 = $LRowsx['idUserLastNote'];
            $g_24 = $LRowsx['UserLastNote'];
            $g_25 = $LRowsx['LastNote'];
            $g_26 = $LRowsx['IDOwner'];
            $g_27 = $LRowsx['Owner'];
            $g_28 = $LRowsx['Status'];
            $g_29 = $LRowsx['TAT'];
            
            for ($j=0;$j<$i;$j++){
                $jx = $j+1;
                $var = "g_" . $jx;
                $val = $$var;
                $buffer = "\"" . str_replace(array(",", "\r", "\n", "\t"), '', $val) . "\"";
                $csv_output .= strtoupper($buffer) . ",";
            }

            $csv_output .= "\n";
        }
        
        
        
        break;
    case "QuotesReport":
        $gID = base64_decode($_GET['token']);
        $file = "QuotesReport_$gID";
        
        $rown = 1;
        //Obtiene las columnas
        $scol = "SHOW COLUMNS FROM Quotes_iReports";
        $ncol = $cnx->query($scol)->numRows();
        $LCol = $cnx->query($scol)->fetchAll();
        
        foreach ($LCol as &$LColx) {
            $colv = $LColx['Field'];
            $csv_output .= "$colv" . ",";
        }
        
        
        if($csv_output != ""){
            $csv_output = substr($csv_output, 0, -2) . "\n";
        }
        //SELECT * FROM J01 ORDER BY SERVICE_ORDER_ID DESC
        $cdata = "SELECT * FROM Quotes_iReports WHERE idQuotes = '$gID' ORDER BY MPN ASC, COMPLETED_ON DESC";
        //$csv_output = str_replace("|", "$", $csv_output);
        $i = $ncol;
        //$csv_output = "$cdata\n";
        $LRows = $cnx->query($cdata)->fetchAll();
        foreach ($LRows as &$LRowsx) {
            $g_1 = $LRowsx['id_iReports'];
            $g_2 = $LRowsx['idQuotes'];
            $g_3 = $LRowsx['idReport'];
            $g_4 = $LRowsx['CPN'];
            $g_5 = $LRowsx['MPN'];
            $g_6 = $LRowsx['QUOTED_MPN'];
            $g_7 = $LRowsx['MANUFACTURER_NAME'];
            $g_8 = $LRowsx['RFQ'];
            $g_9 = $LRowsx['RFQ_NAME'];
            $g_10 = $LRowsx['SUPPLIER_NAME'];
            $g_11 = $LRowsx['SUBMITTED_ON'];
            $g_12 = $LRowsx['COMPLETED_ON'];
            $g_13 = $LRowsx['MIN'];
            $g_14 = $LRowsx['MULT'];
            $g_15 = $LRowsx['LEAD_TIME'];
            $g_16 = $LRowsx['STOCK'];
            $g_17 = $LRowsx['QTY1'];
            $g_18 = $LRowsx['PRICE1'];
            $g_19 = $LRowsx['QTY2'];
            $g_20 = $LRowsx['PRICE2'];
            $g_21 = $LRowsx['QTY3'];
            $g_22 = $LRowsx['PRICE3'];
            $g_23 = $LRowsx['QTY4'];
            $g_24 = $LRowsx['PRICE4'];
            $g_25 = $LRowsx['QTY5'];
            $g_26 = $LRowsx['PRICE5'];
            $g_27 = $LRowsx['QTY6'];
            $g_28 = $LRowsx['PRICE6'];
            $g_29 = $LRowsx['QTY7'];
            $g_30 = $LRowsx['PRICE7'];
            $g_31 = $LRowsx['CUSTOMER'];
            $g_32 = $LRowsx['MIN_PRICE'];
            $g_33 = $LRowsx['MAX_QTY'];
            $g_34 = $LRowsx['TOTAL_ESTIMATED'];
            $g_35 = $LRowsx['Acctg_Value'];
            $g_36 = $LRowsx['Ven_Price'];
            $g_37 = $LRowsx['Last_Price'];
            $g_38 = $LRowsx['Mfgr_Name'];
            $g_39 = $LRowsx['Vendor_Id'];
            
            for ($j=0;$j<$i;$j++){
                $jx = $j+1;
                $var = "g_" . $jx;
                $val = $$var;
                $buffer = "\"" . str_replace(array(",", "\r", "\n", "\t"), '', $val) . "\"";
                $csv_output .= strtoupper($buffer) . ",";
            }

            $csv_output .= "\n";
        }
        
        break;
    case "inprocessxorden";
        $orden = $_GET['orden'];
        $file = $orden . "_INProcess";

        $cdata = "SELECT * FROM ginfprosystem WHERE orden = '$orden' ORDER BY status DESC, serial ASC";
        
        $csv_output .= "Serial|11S|Orden|FechaMan|Pais|Cliente|OEM|NParte|Modelo|Producto|Memoria|Color|SKU|FechaRec|Datetime|CustomerFail|Modifico|Owner|Station|Failure|TFailure|DEfect|Location|Symptom|Comentarios|Plocation|Status|\n";
        //Le reste uno para obtener los dias en house
        $csv_output = str_replace("|", "$", $csv_output);
        //echo $cdata;
        $i = 27;
        
        


$qdata = mysql_query($cdata, $cnx);

while ($rowr = mysql_fetch_row($qdata))
	{
	for ($j=0;$j<$i;$j++)
		{
                $buffer = str_replace(array("\r", "\n", "\t"), '', $rowr[$j]);
                
		$csv_output .= strtoupper($buffer) . "|$";
		}
	
	$csv_output .= "\n";
	}
        
        break;
}



 
$filename = $file."_".date("d-m-Y_H-i",time());
 
header("Content-type: application/vnd.ms-excel");
header("Content-disposition: csv" . date("Y-m-d") . ".csv");
header( "Content-disposition: filename=".$filename.".csv");
 
print $csv_output;
 
exit;
?>