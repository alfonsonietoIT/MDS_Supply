<?php
$blankDate = "2021-11-01";
//Gel all the questionare
$sPPVQ = "SELECT * FROM PPVQuestionare WHERE idPPV = '$IDPPV' ORDER BY idPPV ASC LIMIT 0, 1";
$nPPVQ = $cnx->query($sPPVQ)->numRows();
if($nPPVQ == 1){
    $rQPPV = $cnx->query($sPPVQ)->fetchArray();
    $Qpp_idPool = $rQPPV['idPool'];
    $Qpp_idPPV = $rQPPV['idPPV'];
    $Qpp_PO = $rQPPV['PO'];
    $Qpp_PartNumber = $rQPPV['PartNumber'];
    $Qpp_Manuf_PartNumber = $rQPPV['Manuf_PartNumber'];
    $Qpp_Description = $rQPPV['Description'];
    $Qpp_Supplier = $rQPPV['Supplier'];
    $Qpp_Assembly = $rQPPV['Assembly'];
    $Qpp_Customer = $rQPPV['Customer'];
    $Qpp_Impact = $rQPPV['Impact'];
    $Qpp_ImpactMonth = $rQPPV['ImpactMonth'];
    $Qpp_ImpactDate = $rQPPV['ImpactDate'];
    $Qpp_Qty = $rQPPV['Qty'];
    $Qpp_DeliveryDate = $rQPPV['DeliveryDate'];
    $Qpp_ETA_NPaid = $rQPPV['ETA_NPaid'];
    $Qpp_ETA_Paid = $rQPPV['ETA_Paid'];
    $Qpp_SoleShortage = $rQPPV['SoleShortage'];
    $Qpp_AVL = $rQPPV['AVL'];
    $Qpp_Alternate = $rQPPV['Alternate'];
    $Qpp_BrokerOption = $rQPPV['BrokerOption'];
    $Qpp_Escalated_Int = $rQPPV['Escalated_Int'];
    $Qpp_Escalated_Cust = $rQPPV['Escalated_Cust'];
    $Qpp_Escalated_Supp = $rQPPV['Escalated_Supp'];
    $Qpp_Owner = $rQPPV['Owner'];
    $Qpp_OwnerName = $rQPPV['OwnerName'];
    $Qpp_Additional = $rQPPV['Additional'];
    $Qpp_OnTime = $rQPPV['OnTime'];
} else {
    $Qpp_idPPV = $IDPPV;
    $Qpp_PO = $pp_Purch_Order_Number;
    $Qpp_PartNumber = $pp_Part_Nbr;
    $Qpp_Manuf_PartNumber = $pp_Mfgr_Item_Nbr;
    $Qpp_Description = $pp_Description;
    $Qpp_Supplier = $pp_Vendor_Name;
    $Qpp_Customer = $pp_Class_Code;
    $Qpp_Impact = "";
    $Qpp_ImpactMonth = "";
    $Qpp_ImpactDate = $blankDate;
    $Qpp_Qty = $pp_Quantity_Ordered;
    $Qpp_DeliveryDate = $blankDate;
    $Qpp_ETA_NPaid = $blankDate;
    $Qpp_ETA_Paid = $blankDate;
    $Qpp_SoleShortage = "";
    $Qpp_AVL = "";
    $Qpp_Alternate = "";
    $Qpp_BrokerOption = "";
    $Qpp_Escalated_Int = "";
    $Qpp_Escalated_Cust = "";
    $Qpp_Escalated_Supp = "";
    $Qpp_Owner = $pp_Buyer;
    $Qpp_OwnerName = "";
    $Qpp_Additional = "";
    $Qpp_OnTime = "";
    //Inserta valores cuestionario
    $iQPPV = "INSERT INTO PPVQuestionare VALUES ("
            . "'0', '$Qpp_idPPV', '$Qpp_PO', '$Qpp_PartNumber', '$Qpp_Manuf_PartNumber', "
            . "'$Qpp_Description', '$Qpp_Supplier', '$Qpp_Assembly', '$Qpp_Customer', '$Qpp_Impact', "
            . "'$Qpp_ImpactMonth', '$Qpp_ImpactDate', '$Qpp_Qty', '$Qpp_DeliveryDate', '$Qpp_ETA_NPaid', "
            . "'$Qpp_ETA_Paid', '$Qpp_SoleShortage', '$Qpp_AVL', '$Qpp_Alternate', '$Qpp_BrokerOption', "
            . "'$Qpp_Escalated_Int', '$Qpp_Escalated_Cust', '$Qpp_Escalated_Supp', '$Qpp_Owner', '$Qpp_OwnerName', "
            . "'$Qpp_Additional', '$Qpp_OnTime')";
    $R_iQPPV = $cnx->query($iQPPV);
    
    
}


//Cambia dato
if($Qpp_ImpactDate == "2000-01-01"){
    $Qpp_ImpactDate = "";
}

if($Qpp_DeliveryDate == "2000-01-01"){
    $Qpp_DeliveryDate = "";
}

if($Qpp_DeliveryDate == "2000-01-01"){
    $Qpp_DeliveryDate = "";
}

if($Qpp_ETA_NPaid == "2000-01-01"){
    $Qpp_ETA_NPaid = "";
}

if($Qpp_ETA_Paid == "2000-01-01"){
    $Qpp_ETA_Paid = "";
}

//* echo $nPPVQ;
$linkedit = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=EditQuestionare&token=$gettoken";

?>

<a href="#popup" class="linkB">Questionare</a>
<div id="popup" class="overlay">
    <div id="popupBody">
        <font class="Bah">
        <a href="<?php echo $linkedit;?>" title="Edit Questinare <?php echo $pp_keyPPV;?>"><img src="Images/Edit.svg" width="25"></a>
        <B>PPV Questionare - <?php echo $pp_keyPPV;?></b></font>
        <a id="cerrar" href="#">&times;</a>
        <div class="popupContent">
            <table width="100%" cellspacing="0">
                <tr>
                    <td width="50%" valign="top" style="background-color:#f7f7f7;text-align:justify;border-top: 1px gray solid;border-right:1px gray solid;">
                        <font class="Kohsss">
                        <b>Part Number:</b>
                        </font>
                    </td>
                    <td width="50%" valign="top" style="background-color:white;text-align:justify;">
                        <font class="Kohsss">
                        <b><?php echo $Qpp_PartNumber;?></b>
                        </font>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="height:3px;background-color: #f7f7f7;">

                    </td>
                </tr>
                <tr>
                    <td width="50%" valign="top" style="background-color:#f7f7f7;text-align:justify;border-top: 1px gray solid;border-right:1px gray solid;">
                        <font class="Kohsss">
                        <b>Manufacturing Part Number:</b>
                        </font>
                    </td>
                    <td width="50%" valign="top" style="background-color:white;text-align:justify;">
                        <font class="Kohsss">
                        <b><?php echo $Qpp_Manuf_PartNumber;?></b>
                        </font>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="height:3px;background-color: #f7f7f7;">

                    </td>
                </tr>
                <tr>
                    <td width="50%" valign="top" style="background-color:#f7f7f7;text-align:justify;border-top: 1px gray solid;border-right:1px gray solid;">
                        <font class="Kohsss">
                        <b>Description:</b>
                        </font>
                    </td>
                    <td width="50%" valign="top" style="background-color:white;text-align:justify;">
                        <font class="Kohsss">
                        <b><?php echo $Qpp_Description;?></b>
                        </font>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="height:3px;background-color: #f7f7f7;">

                    </td>
                </tr>
                <tr>
                    <td width="50%" valign="top" style="background-color:#f7f7f7;text-align:justify;border-top: 1px gray solid;border-right:1px gray solid;">
                        <font class="Kohsss">
                        <b>Supplier:</b>
                        </font>
                    </td>
                    <td width="50%" valign="top" style="background-color:white;text-align:justify;">
                        <font class="Kohsss">
                        <b><?php echo $Qpp_Supplier;?></b>
                        </font>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="height:3px;background-color: #f7f7f7;">

                    </td>
                </tr>
                <tr>
                    <td width="50%" valign="top" style="background-color:#f7f7f7;text-align:justify;border-top: 1px gray solid;border-right:1px gray solid;">
                        <font class="Kohsss">
                        <b>Assembly:</b>
                        </font>
                    </td>
                    <td width="50%" valign="top" style="background-color:white;text-align:justify;">
                        <font class="Kohsss">
                        <b><?php echo $Qpp_Assembly;?></b>
                        </font>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="height:3px;background-color: #f7f7f7;">

                    </td>
                </tr>
                <tr>
                    <td width="50%" valign="top" style="background-color:#f7f7f7;text-align:justify;border-top: 1px gray solid;border-right:1px gray solid;">
                        <font class="Kohsss">
                        <b>Customer Class Code:</b>
                        </font>
                    </td>
                    <td width="50%" valign="top" style="background-color:white;text-align:justify;">
                        <font class="Kohsss">
                        <b><?php echo $Qpp_Customer;?></b>
                        </font>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="height:3px;background-color: #f7f7f7;">

                    </td>
                </tr>
                <tr>
                    <td width="50%" valign="top" style="background-color:#f7f7f7;text-align:justify;border-top: 1px gray solid;border-right:1px gray solid;">
                        <font class="Kohsss">
                        <b>Impact $ of revenue if NOT Approved:</b>
                        </font>
                    </td>
                    <td width="50%" valign="top" style="background-color:white;text-align:justify;">
                        <font class="Kohsss">
                        <b><?php echo $Qpp_Impact;?></b>
                        </font>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="height:3px;background-color: #f7f7f7;">

                    </td>
                </tr>
                <tr>
                    <td width="50%" valign="top" style="background-color:#f7f7f7;text-align:justify;border-top: 1px gray solid;border-right:1px gray solid;">
                        <font class="Kohsss">
                        <b>Impact Month:</b>
                        </font>
                    </td>
                    <td width="50%" valign="top" style="background-color:white;text-align:justify;">
                        <font class="Kohsss">
                        <b><?php echo $Qpp_ImpactMonth;?></b>
                        </font>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="height:3px;background-color: #f7f7f7;">

                    </td>
                </tr>
                <tr>
                    <td width="50%" valign="top" style="background-color:#f7f7f7;text-align:justify;border-top: 1px gray solid;border-right:1px gray solid;">
                        <font class="Kohsss">
                        <b>Impact Date (when Im Short):</b>
                        </font>
                    </td>
                    <td width="50%" valign="top" style="background-color:white;text-align:justify;">
                        <font class="Kohsss">
                        <b><?php echo $Qpp_ImpactDate;?></b>
                        </font>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="height:3px;background-color: #f7f7f7;">

                    </td>
                </tr>
                <tr>
                    <td width="50%" valign="top" style="background-color:#f7f7f7;text-align:justify;border-top: 1px gray solid;border-right:1px gray solid;">
                        <font class="Kohsss">
                        <b>Qty Needed:</b>
                        </font>
                    </td>
                    <td width="50%" valign="top" style="background-color:white;text-align:justify;">
                        <font class="Kohsss">
                        <b><?php echo number_format($Qpp_Qty, 0);?></b>
                        </font>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="height:3px;background-color: #f7f7f7;">

                    </td>
                </tr>
                <tr>
                    <td width="50%" valign="top" style="background-color:#f7f7f7;text-align:justify;border-top: 1px gray solid;border-right:1px gray solid;">
                        <font class="Kohsss">
                        <b>Delivery Date Needed (date based on ROI):</b>
                        </font>
                    </td>
                    <td width="50%" valign="top" style="background-color:white;text-align:justify;">
                        <font class="Kohsss">
                        <b><?php echo $Qpp_DeliveryDate;?></b>
                        </font>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="height:3px;background-color: #f7f7f7;">

                    </td>
                </tr>
                <tr>
                    <td width="50%" valign="top" style="background-color:#f7f7f7;text-align:justify;border-top: 1px gray solid;border-right:1px gray solid;">
                        <font class="Kohsss">
                        <b>ETA (if not paid when will arrive):</b>
                        </font>
                    </td>
                    <td width="50%" valign="top" style="background-color:white;text-align:justify;">
                        <font class="Kohsss">
                        <b><?php echo $Qpp_ETA_NPaid;?></b>
                        </font>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="height:3px;background-color: #f7f7f7;">

                    </td>
                </tr>
                <tr>
                    <td width="50%" valign="top" style="background-color:#f7f7f7;text-align:justify;border-top: 1px gray solid;border-right:1px gray solid;">
                        <font class="Kohsss">
                        <b>ETA (if Paid when will arrive):</b>
                        </font>
                    </td>
                    <td width="50%" valign="top" style="background-color:white;text-align:justify;">
                        <font class="Kohsss">
                        <b><?php echo $Qpp_ETA_Paid;?></b>
                        </font>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="height:3px;background-color: #f7f7f7;">

                    </td>
                </tr>
                <tr>
                    <td width="50%" valign="top" style="background-color:#f7f7f7;text-align:justify;border-top: 1px gray solid;border-right:1px gray solid;">
                        <font class="Kohsss">
                        <b>Sole Shortage (Y/N):</b>
                        </font>
                    </td>
                    <td width="50%" valign="top" style="background-color:white;text-align:justify;">
                        <font class="Kohsss">
                        <b><?php echo $Qpp_SoleShortage;?></b>
                        </font>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="height:3px;background-color: #f7f7f7;">

                    </td>
                </tr>
                <tr>
                    <td width="50%" valign="top" style="background-color:#f7f7f7;text-align:justify;border-top: 1px gray solid;border-right:1px gray solid;">
                        <font class="Kohsss">
                        <b>How Many AVL?:</b>
                        </font>
                    </td>
                    <td width="50%" valign="top" style="background-color:white;text-align:justify;">
                        <font class="Kohsss">
                        <b><?php echo $Qpp_AVL;?></b>
                        </font>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="height:3px;background-color: #f7f7f7;">

                    </td>
                </tr>
                <tr>
                    <td width="50%" valign="top" style="background-color:#f7f7f7;text-align:justify;border-top: 1px gray solid;border-right:1px gray solid;">
                        <font class="Kohsss">
                        <b>Alternate Options to propose (Y/N + Which one):</b>
                        </font>
                    </td>
                    <td width="50%" valign="top" style="background-color:white;text-align:justify;">
                        <font class="Kohsss">
                        <b><?php echo $Qpp_Alternate;?></b>
                        </font>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="height:3px;background-color: #f7f7f7;">

                    </td>
                </tr>
                <tr>
                    <td width="50%" valign="top" style="background-color:#f7f7f7;text-align:justify;border-top: 1px gray solid;border-right:1px gray solid;">
                        <font class="Kohsss">
                        <b>Is this PPV a Broker Option (Y/N):</b>
                        </font>
                    </td>
                    <td width="50%" valign="top" style="background-color:white;text-align:justify;">
                        <font class="Kohsss">
                        <b><?php echo $Qpp_BrokerOption;?></b>
                        </font>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="height:3px;background-color: #f7f7f7;">

                    </td>
                </tr>
                <tr>
                    <td width="50%" valign="top" style="background-color:#f7f7f7;text-align:justify;border-top: 1px gray solid;border-right:1px gray solid;">
                        <font class="Kohsss">
                        <b>Escalated Internally (Y/N - With who):</b>
                        </font>
                    </td>
                    <td width="50%" valign="top" style="background-color:white;text-align:justify;">
                        <font class="Kohsss">
                        <b><?php echo $Qpp_Escalated_Int;?></b>
                        </font>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="height:3px;background-color: #f7f7f7;">

                    </td>
                </tr>
                <tr>
                    <td width="50%" valign="top" style="background-color:#f7f7f7;text-align:justify;border-top: 1px gray solid;border-right:1px gray solid;">
                        <font class="Kohsss">
                        <b>Escalated Customer (Y/N - With Who):</b>
                        </font>
                    </td>
                    <td width="50%" valign="top" style="background-color:white;text-align:justify;">
                        <font class="Kohsss">
                        <b><?php echo $Qpp_Escalated_Cust;?></b>
                        </font>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="height:3px;background-color: #f7f7f7;">

                    </td>
                </tr>
                <tr>
                    <td width="50%" valign="top" style="background-color:#f7f7f7;text-align:justify;border-top: 1px gray solid;border-right:1px gray solid;">
                        <font class="Kohsss">
                        <b>Escalated Within Supplier (Y/N - With Who):</b>
                        </font>
                    </td>
                    <td width="50%" valign="top" style="background-color:white;text-align:justify;">
                        <font class="Kohsss">
                        <b><?php echo $Qpp_Escalated_Supp;?></b>
                        </font>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="height:3px;background-color: #f7f7f7;">

                    </td>
                </tr>
                <tr>
                    <td width="50%" valign="top" style="background-color:#f7f7f7;text-align:justify;border-top: 1px gray solid;border-right:1px gray solid;">
                        <font class="Kohsss">
                        <b>Owner:</b>
                        </font>
                    </td>
                    <td width="50%" valign="top" style="background-color:white;text-align:justify;">
                        <font class="Kohsss">
                        <b><?php echo $Qpp_Owner;?></b>
                        </font>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="height:3px;background-color: #f7f7f7;">

                    </td>
                </tr>
                <tr>
                    <td width="50%" valign="top" style="background-color:#f7f7f7;text-align:justify;border-top: 1px gray solid;border-right:1px gray solid;">
                        <font class="Kohsss">
                        <b>Additional background information you would like to add:</b>
                        </font>
                    </td>
                    <td width="50%" valign="top" style="background-color:white;text-align:justify;">
                        <font class="Kohsss">
                        <b><?php echo $Qpp_Additional;?></b>
                        </font>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="height:3px;background-color: #f7f7f7;">

                    </td>
                </tr>
                <tr>
                    <td width="50%" valign="top" style="background-color:#f7f7f7;text-align:justify;border-top: 1px gray solid;border-right:1px gray solid;">
                        <font class="Kohsss">
                        <b>Is this PPV a One time thing or a Permanent PPV:</b>
                        </font>
                    </td>
                    <td width="50%" valign="top" style="background-color:white;text-align:justify;">
                        <font class="Kohsss">
                        <b><?php echo $Qpp_OnTime;?></b>
                        </font>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="height:3px;background-color: #f7f7f7;">

                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
