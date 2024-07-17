<?php
include '/var/www/html/Supply/PHPClass/DB.php';
include '/var/www/html/Supply/PHPFunctions/var.php';
include '/var/www/html/Supply/PHPFunctions/Function_SMS.php';

/***************************************************************************** Crea PPV ***********************/

//Agrega los PPV
$sPPV = "SELECT * FROM PodData WHERE Status = 'forPPV' ORDER BY idPodData ASC LIMIT 0, 100";
$rPPV = $cnx->query($sPPV)->fetchAll();
foreach ($rPPV as &$rXPPV) {
    $g_idPodDate = $rXPPV['idPodData'];
    $g_dtAdded = $rXPPV['dtAdded'];
    $g_Buyer = $rXPPV['Buyer'];
    $g_Vendor_Number = $rXPPV['Vendor_Number'];
    $g_Vendor_Name = $rXPPV['Vendor_Name'];
    $g_Purch_Order_Number = $rXPPV['Purch_Order_Number'];
    $g_Lne_Nbr = $rXPPV['Lne_Nbr'];
    $g_Class_Code = $rXPPV['Class_Code'];
    $g_Part_Nbr = $rXPPV['Part_Nbr'];
    $g_Description = $rXPPV['Description'];
    $g_Quantity_Ordered = $rXPPV['Quantity_Ordered'];
    $g_Expected_Delivery_Date = $rXPPV['Quantity_Ordered'];
    $g_Balance_Due = $rXPPV['Balance_Due'];
    $g_Currency_List_Unit_Price = $rXPPV['Currency_List_Unit_Price'];
    $g_Extended_Price = $rXPPV['Extended_Price'];
    $g_Requested_Delivery_Date = $rXPPV['Requested_Delivery_Date'];
    $g_Vendor_Promise_Dt = $rXPPV['Vendor_Promise_Dt'];
    $g_Tracking_Nbr = $rXPPV['Tracking_Nbr'];
    $g_Disp_Type = $rXPPV['Disp_Type'];
    $g_Disp_Ref = $rXPPV['Disp_Ref'];
    $g_Mfgr_ID = $rXPPV['Mfgr_ID'];
    $g_Mfgr_Item_Nbr = $rXPPV['Mfgr_Item_Nbr'];
    $g_Purchase_Order_Add_Date = $rXPPV['Purchase_Order_Add_Date'];
    $g_Acctg_Value = $rXPPV['Acctg_Value'];
    $g_Delta_Value = $rXPPV['Delta_Value'];
    $g_ImpactValue = $rXPPV['ImpactValue'];
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
    
    $iPPV = "INSERT INTO PPVs VALUES("
            . "'$ID', '$KEY', '$g_dtAdded', '$g_Buyer', '$g_Vendor_Number', "
            . "'$g_Vendor_Name', '$g_Purch_Order_Number', '$g_Lne_Nbr', '$g_Class_Code', '$g_Part_Nbr', "
            . "'$g_Description', '$g_Quantity_Ordered', '$g_Expected_Delivery_Date', '$g_Balance_Due', '$g_Currency_List_Unit_Price', "
            . "'$g_Extended_Price', '$g_Requested_Delivery_Date', '$g_Vendor_Promise_Dt', '$g_Tracking_Nbr', '$g_Disp_Type', "
            . "'$g_Disp_Ref', '$g_Mfgr_ID', '$g_Mfgr_Item_Nbr', '$g_Purchase_Order_Add_Date', '$g_Acctg_Value', "
            . "'$g_Delta_Value', '$g_ImpactValue', '$g_dtParts', '$g_dtDelta', '$dtAhora', "
            . "'$dtAhora', '$dtAhora', '', '', '', '', 'OpenPPV'"
            . ")";
    $rPP = $cnx->query($iPPV);
    
}

//Agrupa todos los PPV
$sPPV = "SELECT Class_Code, Vendor_Number, Purch_Order_Number, Part_Nbr, Buyer, Currency_List_Unit_Price, "
        . "Acctg_Value, COUNT(idPPV) AS QtyD, SUM(Quantity_Ordered) AS Qty FROM PPVs WHERE Status = 'Open' "
        . "GROUP BY Class_Code, Vendor_Number, Purch_Order_Number, Part_Nbr, Buyer ORDER BY Part_Nbr ASC";
$rPPV = $cnx->query($sPPV)->fetchAll();

//Valida cada existencia
foreach ($rPPV as &$rXPPV) {
    
}


echo "Termine..."

/*
$dnow4 = date('Y-m-d H:i:s', time());
//N unlink($Po_Link);
SMS("6862166100", "Se Termino Procesar forPPV $dnow4", "", "Mario", "forPPV");
*/
?>