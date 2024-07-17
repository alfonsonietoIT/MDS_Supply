#!/usr/bin/php
<?php
include '/var/www/html/Supply/PHPClass/DB.php';
include '/var/www/html/Supply/PHPFunctions/var.php';
include '/var/www/html/Supply/PHPFunctions/Function_SMS.php';

//Obtiene la ultima po
$sMPO = "SELECT MAX(PO) AS mpo FROM POApproval";
$rP = $cnx->query($sMPO)->fetchArray();
$gMPO = $rP['mpo'];

$SumPO = "SELECT Buyer, Customer, Class_Code, Vendor_Name, Purch_Order_Number, Purchase_Order_Add_Date, "
    . "COUNT(Part_Nbr) AS QtyDelivery, COUNT(DISTINCT Part_Nbr) AS QtyNParts, "
    . "SUM(Quantity_Ordered) AS SQty, SUM(Quantity_Ordered * Currency_List_Unit_Price) AS SValue "
    . "FROM PodData WHERE Purch_Order_Number > '$gMPO' AND Disp_Type != 'G' AND "
    . "Class_Code != '' AND Purch_Order_Number NOT LIKE '9CN%' "
    . "GROUP BY Vendor_Name, Purch_Order_Number, Purchase_Order_Add_Date, Status ORDER BY Purch_Order_Number ASC";
echo $SumPO;
$rSumPO = $cnx->query($SumPO)->fetchAll();

foreach ($rSumPO as &$ASumPO) {
    $S_Buyer = $ASumPO['Buyer'];
    $S_Class_Code = $ASumPO['Class_Code'];
    //$S_Part_Nbr = $ASumPO['Part_Nbr'];
    //$S_Description = $ASumPO['Description'];
    //$S_Mfgr_Item_Nbr = $ASumPO['Mfgr_Item_Nbr'];
    $S_Vendor_Name = $ASumPO['Vendor_Name'];
    $S_Purch_Order_Number = $ASumPO['Purch_Order_Number'];
    //$S_Lne_Nbr = $ASumPO['Lne_Nbr'];
    $S_Purchase_Order_Add_Date = $ASumPO['Purchase_Order_Add_Date'];
    //$S_Status = $ASumPO['Status'];
    //$S_Tracking_Nbr = $ASumPO['Tracking_Nbr'];
    //$S_QtyNPromise = $ASumPO['QtyNPromise'];
    //$S_QtyPromise = $ASumPO['QtyPromise'];
    //$S_QtyExpire = $ASumPO['QtyExpire'];
    $S_QtyDelivery = $ASumPO['QtyDelivery'];
    $S_QtyNParts = $ASumPO['QtyNParts'];
    $S_SQty = $ASumPO['SQty'];
    $S_SValue = $ASumPO['SValue'];
    $S_CustomerName = $ASumPO['Customer'];

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
    /*
    //Status
    if($S_SQty == 0){
        $S_Status = "Closed";
    } else {
        $S_Status = "Created";
    }
    */
    

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

    $iPOC = "INSERT INTO POTools VALUES"
            . "('$IDPOC', '$TF_dateReport', '$S_Buyer', '$S_Owner', '$S_Class_Code', '$S_CustomerName', '$S_Part_Nbr', '$S_Description', "
            . "'$S_Mfgr_Item_Nbr', '$S_Vendor_Name', '$S_Purch_Order_Number', '$S_Lne_Nbr', "
            . "'$S_Purchase_Order_Add_Date', '$S_QtyNPromise', '$S_QtyPromise', '$S_QtyExpire', '$S_QtyDelivery', '$S_SQty', "
            . "'$dtAhora', '$dtAhora', '$dtAhora', '$dtAhora', '0', "
            . "'MDS', 'Created', '$S_IDOwner', '$S_Owner', '$S_Tracking_Nbr', '$S_Status')";
     * 
     */

    $iPOC = "INSERT INTO POApproval VALUES("
            . "'0', '$S_Purch_Order_Number', '$S_Purchase_Order_Add_Date', "
            . "'$S_Buyer', '$S_Class_Code', '$S_CustomerName', '$S_Vendor_Name', '$S_QtyDelivery', "
            . "'$S_QtyNParts', '$S_SQty', '$S_SValue', '', '$dtAhora', '', '$S_IDOwner', "
            . "'$S_Owner', '', '0', '', '', '', 'Open', '$dtAhora', '$dtAhora')";
    $LPOC = $cnx->query($iPOC);
}


echo "Termine";

?>