<center>
    <br><br>
    <div style="width: 95%;border: 1px solid black;">
        <div style="height: 5px;background-color: <?php echo $cSt;?>;">
        </div>
        <table width="100%">
            <tr>
                <td valign="top">
                    <?php
                    include("Forms/PPVQuestionare.php");
                    ?>
                </td>
                <td colspan="6" align="center">
                    <font class="Bahss">SUMMARY:<br></font>
                    <font class="Koh">
                    Part Number: <b><?php echo $pp_Part_Nbr;?></b>&nbsp;&nbsp;
                    <?php
                    //Color impacto
                    if($pp_ImpactValue > 0){
                        $ColorImp = "red";
                    } else {
                        $ColorImp = "green";
                    }
                    ?>
                    Impact: <font style="color:<?php echo $ColorImp;?>"><b><?php echo "$ " . number_format($pp_ImpactValue, 4);?><b></font>
                    </font>
                </td>
                <td align="center" colspan="2">
                    <font class="Bahss">STATUS:<br></font>
                    <font class="Koh" style="color:<?php echo $cSt;?>;"><?php echo $pp_Status;?></font>
                </td>
                <td align="center" width="10%">
                    <div style="background-color: gainsboro;border:1px solid black;padding: 2px 5px 2px 5px;">
                        <font class="Bahss">
                            PPV:
                        </font>
                    </div>
                    <div style="background-color: white;border:1px solid black;padding: 2px 5px 2px 5px;">
                        <font class="Kohss">
                            <?php echo $pp_keyPPV;?>
                        </font>
                    </div>
                </td>
            </tr>
            <tr>
                <td align="right" width="10%" style="background-color: #e7e7e7;">
                    <font class="Bahss">Owner:<br></font>
                </td>
                <td align="center" colspan="2" style="background-color: #005769;border:1px solid black;">
                    <font class="Kohss" style="color:white;"><B><?php echo $pp_OwnerName;?></B></font>
                </td>
                <td align="right" width="10%" style="background-color: #e7e7e7;">
                    <font class="Bahss">Qty Ordered:<br></font>
                </td>
                <td align="center" style="background-color: skyblue;border:1px solid black;">
                    <font class="Kohss" style="color:black;"><B><?php echo $pp_Quantity_Ordered;?></B></font>
                </td>
                <td align="right" width="10%" style="background-color: #e7e7e7;">
                    <font class="Bahss">Current Price:<br></font>
                </td>
                <td align="center" style="background-color: skyblue;border:1px solid black;">
                    <font class="Kohss" style="color:black;"><B><?php echo "$ " . number_format($pp_Currency_List_Unit_Price, 4);?></B></font>
                </td>
                <td align="right" width="10%" style="background-color: #e7e7e7;">
                    <font class="Bahss">Acctg_Value:<br></font>
                </td>
                <td align="right" width="10%" style="background-color: red;border:1px solid black;">
                    <font class="Kohss" style="color:white;"><b><?php echo "$ " . number_format($pp_Acctg_Value, 4);?></b></font>
                </td>
                <td align="right" colspan="1" style="color:white;border:1px solid black;background-color: <?php echo $ColorImp . ";";?>">
                    <font class="Kohss" style="color:white;">
                    <?php 
                    //Depende 
                    $Impact_Percentage = number_format((($pp_Currency_List_Unit_Price * 100) / ($pp_Acctg_Value)), 2);
                    
                    echo "(%) Impact: <b>" .$Impact_Percentage . "</b> %";?>
                    </font>
                </td>
            </tr>
            <tr>
                <td align="right" width="10%" style="background-color: #e7e7e7;">
                    <font class="Bahss">PO:<br></font>
                </td>
                <td align="center" width="10%" style="background-color: white;border:1px solid black;">
                    <font class="Kohss"><?php echo $pp_Purch_Order_Number;?><br></font>
                </td>
                <td align="right" width="10%" style="background-color: #e7e7e7;">
                    <font class="Bahss">Part Numbers:<br></font>
                </td>
                <td align="center" width="10%" style="background-color: white;border:1px solid black;">
                    <font class="Kohss"><?php echo $pp_Part_Nbr;?><br></font>
                </td>
                <td align="right" width="10%" style="background-color: #e7e7e7;">
                    <font class="Bahss">Vendor Name:<br></font>
                </td>
                <td align="center" colspan="2" width="20%" style="background-color: white;border:1px solid black;">
                    <font class="Kohss"><?php echo $pp_Vendor_Name;?><br></font>
                </td>
                <td align="right" width="10%" style="background-color: #e7e7e7;">
                    <font class="Bahss">Buyer:<br></font>
                </td>
                <td align="center" colspan="2" width="20%" style="background-color: white;border:1px solid black;">
                    <font class="Kohss"><B><?php echo $pp_BuyerName;?></b><br></font>
                </td>
            </tr>
            <tr>
                <td align="center" valign="top" colspan="5" width="50%">
                    <font class="Bahs">Deliveries:<br></font>
                    <?php
                    //Approvals
                    //Titulo, Size, Info, Alert, Search, DataSearch
                    $aGList1 = array("", "100%", "", "", "0", "xxxx");
                    
                    $LQry1 = "SELECT * FROM PodData WHERE Purch_Order_Number = '$pp_Purch_Order_Number' AND Part_Nbr = '$pp_Part_Nbr' AND Balance_Due > '0' ORDER BY idPodData ASC";
                    

                    $aColumns1 = array(
                        array("", "tr_class", "tit_col_center", "#", "tit_col_center", "Vendor", "tit_col_center", "QtyOrdered", "tit_col_center", "ExpetedDate", "tit_col_center", "BalanceDue", "tit_col_center", "ReqDelDate")
                    );
                    $LRows1 = $cnx->query("$LQry1")->fetchAll();
                    foreach ($LRows1 as &$LRowsx1) {
                        $count++;
                        $countr++;

                        $get_Vendor_Number1 = $LRowsx1['Vendor_Number'];
                        $get_QtyO1 = $LRowsx1['Quantity_Ordered'];
                        $get_EDDate1 = $LRowsx1['Expected_Delivery_Date'];
                        $get_BDue1 = $LRowsx1['Balance_Due'];
                        $get_RDDate1 = $LRowsx1['Requested_Delivery_Date'];
                        
                        if($get_RDDate1 == "2000-01-01"){
                            $get_RDDate1 = "";
                        }

                        if($countr == 2){
                            $bcolor = "#E7E7E7";
                            $countr = 0;
                        } else {
                            $bcolor = "#FFFFFF";
                        }

                        //N $gettoken = base64_encode($getidFile);

                        $goptions = "";

                        $aColumns1[] = array("$bcolor", "", "col_center", "$count", "col_center", "$get_Vendor_Number1", "col_center", "$get_QtyO1", "col_center", "$get_EDDate1", "col_center", "$get_BDue1", "col_center", "$get_RDDate1");


                    }

                    echo drawList($aGList1, $aLinks1, $aColumns1);
                    ?>
                    <BR><font class="Bahs">Approvals:<br></font>
                    <?php
                    //Approvals
                    //Titulo, Size, Info, Alert, Search, DataSearch
                    $aGList = array("", "100%", "", "", "0", "xxx");
                    
                    $LQry = "SELECT * FROM PPVApproval WHERE idPPV = '$IDPPV' ORDER BY dtOpen ASC";
                    

                    $aColumns = array(
                        array("", "tr_class", "tit_col_center", "#", "tit_col_center", "Type", "tit_col_center", "RequestedBy", "tit_col_center", "ResponseBy", "tit_col_center", "Result", "tit_col_center", "Status")
                    );
                    $LRows = $cnx->query("$LQry")->fetchAll();
                    foreach ($LRows as &$LRowsx) {
                        $count++;
                        $countr++;

                        $get_TypeApproval = $LRowsx['TypeApproval'];
                        $get_uRequested = $LRowsx['uRequested'];
                        $get_uApproval = $LRowsx['uApproval'];
                        $get_Approval = $LRowsx['Approval'];
                        $get_Status = $LRowsx['Status'];

                        if($countr == 2){
                            $bcolor = "#E7E7E7";
                            $countr = 0;
                        } else {
                            $bcolor = "#FFFFFF";
                        }

                        //N $gettoken = base64_encode($getidFile);

                        $goptions = "";

                        $aColumns[] = array("$bcolor", "", "col_center", "$count", "col_center", "$get_TypeApproval", "col_center", "$get_uRequested", "col_center", "$get_uApproval", "col_center", "$get_Approval", "col_center", "$get_Status");


                    }

                    echo drawList($aGList, $aLinks, $aColumns);
                    
                    
                    ?>
                </td>
                <td align="center" valign="top" colspan="2">
                    <font class="Bahs">Quotes:<br></font>
                    <?php
                    //*echo $sQNotes . " - $nQNotes";
                    
                    if($nQNotes == 1){
                        $rQNotes = $cnx->query($sQNotes)->fetchArray();
                        //*print_r($rQNotes);
                        $QNotes = nl2br($rQNotes['DetailLog']);
                        //*echo "Aqui";
                        echo "<div style='text-align:justify;border:1px solid #f7f7f7;'>"
                            . "<font class='Kohss'>$QNotes</font>"
                            . "</div>";
                    }
                    
                    //N print_r($LFiles);
                    foreach ($LQuotes AS &$gQuote){
                        //Datos
                        $f_idFiles = $gQuote['idFiles'];
                        $f_FLink = $gQuote['FLink'];
                        $f_FTitle = $gQuote['FTitle'];
                        $f_ext = explode(".", $f_FLink);
                        $extension = $f_ext[1];
                        
                        switch ($extension):
                            case "xlsx":
                            case "xls":
                            case "csv":
                                $f_icon = "xls.svg";
                                break;
                            case "doc":
                            case "docx":
                                $f_icon = "doc.svg";
                                break;
                            case "jpg":
                            case "jpeg":
                            case "png":
                            case "bmp":
                            case "tif":
                                $f_icon = "img.svg";
                                break;
                            case "pdf":
                                $f_icon = "pdf.svg";
                                break;
                            case "ppt":
                            case "pptx":
                                $f_icon = "ppt.svg";
                                break;
                            case "txt":
                                $f_icon = "txt.svg";
                                break;
                            case "zip":
                                $f_icon = "zip.svg";
                                break;
                            default :
                                $f_icon = "files.svg";
                                break;
                        endswitch;
                        
                        ?>
                    <div style="display:inline-block;padding: 2px 10px 2px 10px;border:1px solid #f6f6f6;">
                        <a href="<?php echo $f_FLink;?>"  title="<?php echo $f_FTitle;?>" target="_blank"><img src="<?php echo "Images/$f_icon";?>" width="40" title="<?php echo $f_FTitle;?>"></a><br>
                        <font class="Kohsss"><?php echo $f_FTitle;?></font>
                    </div>
                    <?php    
                    }
                    
                    ?>
                </td>
                <td align="center" valign="top" >
                    <font class="Bahs">PO:<br></font>
                    <?php 
                    //N print_r($LFiles);
                    foreach ($LPOs AS &$gPO){
                        //Datos
                        $f_idFilesP = $gPO['idFiles'];
                        $f_FLinkP = $gPO['FLink'];
                        $f_FTitleP = $gPO['FTitle'];
                        $f_extP = explode(".", $f_FLinkP);
                        $extensionP = $f_extP[1];
                        
                        switch ($extensionP):
                            case "xlsx":
                            case "xls":
                            case "csv":
                                $f_iconP = "xls.svg";
                                break;
                            case "doc":
                            case "docx":
                                $f_iconP = "doc.svg";
                                break;
                            case "jpg":
                            case "jpeg":
                            case "png":
                            case "bmp":
                            case "tif":
                                $f_iconP = "img.svg";
                                break;
                            case "pdf":
                                $f_iconP = "pdf.svg";
                                break;
                            case "ppt":
                            case "pptx":
                                $f_iconP = "ppt.svg";
                                break;
                            case "txt":
                                $f_iconP = "txt.svg";
                                break;
                            case "zip":
                                $f_iconP = "zip.svg";
                                break;
                            default :
                                $f_iconP = "files.svg";
                                break;
                        endswitch;
                        
                        ?>
                    <div style="display:inline-block;padding: 2px 10px 2px 10px;border:1px solid #f6f6f6;">
                        <a href="<?php echo $f_FLinkP;?>"  title="<?php echo $f_FTitleP;?>" target="_blank"><img src="<?php echo "Images/$f_iconP";?>" width="40" title="<?php echo $f_FTitleP;?>"></a><br>
                        <font class="Kohsss"><?php echo $f_FTitleP;?></font>
                    </div>
                    <?php    
                    }
                    
                    ?>
                </td>
                <td align="right" valign="top" colspan="2">
                    <font class="Bahs">Actions:<br></font><br>
                    <?php echo $links_op;?>
                </td>
            </tr>
            <tr>
                <td align="right" width="10%" style="background-color: #e7e7e7;">
                    <font class="Bahss">Added On:<br></font>
                </td>
                <td align="center" width="10%" style="background-color: white;border:1px solid black;">
                    <font class="Kohss">
                        <?php
                        if($pp_dtAdded != "0000-00-00 00:00:00"){
                            echo $pp_dtAdded;
                        } else {
                            echo "ND";
                        }
                        
                        ?><br>
                    </font>
                </td>
                <td align="right" width="10%" style="background-color: #e7e7e7;">
                    <font class="Bahss">Started On:<br></font>
                </td>
                <td align="center" width="10%" style="background-color: white;border:1px solid black;">
                    <font class="Kohss">
                        <?php 
                        if($T_dtStart != "0000-00-00 00:00:00"){
                            echo $T_dtStart;
                        } else {
                            echo "ND";
                        }
                        ?><br>
                    </font>
                </td>
                <td align="right" width="10%" style="background-color: Turquoise;">
                    <font class="Bahss">SO Number:<br></font>
                </td>
                <td align="center" width="10%" style="background-color: white;border:1px solid black;">
                    <font class="Kohss">
                        <?php 
                        echo $PP_SO;
                        ?>
                    </font>
                </td>
                <td align="right" width="10%" style="background-color: OliveDrab;">
                    <font class="Bahss" style="color:white;">Invoice Number:<br></font>
                </td>
                <td align="center" width="10%" style="background-color: white;border:1px solid black;">
                    <font class="Kohss">
                        <?php 
                        echo $pp_Invoice;
                        ?>
                    </font>
                </td>
                <td align="right" width="10%" style="background-color: LimeGreen;">
                    <font class="Bahss">Closed On:<br></font>
                </td>
                <td align="center" width="10%" style="background-color: white;border:1px solid black;">
                    <font class="Kohss">
                        <?php 
                        if($pp_dtClosed != "0000-00-00 00:00:00"){
                            echo $pp_dtClosed;
                        } else {
                            echo "ND";
                        }
                        ?><br>
                    </font>
                </td>
            </tr>
            <tr>
                <td colspan="5" valign="top" align="center" style="border-right:1px solid #c7c7c7;">
                    <font class="Bahs">Mensajes:<br></font>
                    <div style="text-align:right;">
                        <?php
                        //Depende usuario
                        if($uIDUser == $T_idUserCreated OR $uIDUser == $T_IdUserAssigned OR $uAccount == "Admin" OR $uAccount == "SuperUser"){
                            //Menu mensajes
                            ?>
                            <a href="index.php?sI=<?php echo $sI;?>&sII=<?php echo $sII;?>&sIII=<?php echo $sIII;?>&sIV=AddNote&token=<?php echo $gettoken;?>" class="linklr" target="_self">Add Note</a>
                        <?php
                        }
                        ?>
                    </div>
                    <section class="discussion">
                        <?php
                        //Mensajes Logs...
                        //print_r($LMess);
                        foreach ($LMess as &$vM) {
                            //Data
                            //N print_r($vM);
                            $Ms_datetime = $vM['datetime'];
                            $Ms_Message = $vM['Message'];
                            $Ms_TypeLog = $vM['TypeLog'];
                            $Ms_UserCreated = $vM['UserCreated'];
                            $Ms_DetailLog = $vM['DetailLog'];
                            
                            switch ($Ms_Message):
                                case 2:
                                    $Ms_class = "bubble recipient first";
                                    break;
                                case 1:
                                    $Ms_class = "bubble sender first";
                                    break;
                                default:
                                    $Ms_class = "bubble general first";
                                    break;
                            endswitch;
                            
                            ?>
                        <div class="<?php echo $Ms_class;?>">
                            <font class="Kohsss"><?php echo $Ms_datetime;?><br></font>
                            <font class="Bahs"><?php echo $Ms_UserCreated;?><br></font>
                            <?php echo nl2br($Ms_DetailLog);?>
                        </div>
                            <?php
                        }
                        ?>
                        <!-- Descripcion
                        <div class="bubble sender first">
                            <font class="Kohsss"><?php echo $T_L_datetime;?><br></font>
                            <font class="Bahs"><?php echo $T_L_UserCreated;?><br></font>
                            <?php echo nl2br($T_L_Descripcion);?>
                        </div>  -->
                    </section>
                    <!--
                    <section class="discussion">
	
                        <div class="bubble sender first">Hello</div>
                        <div class="bubble sender last">This is a CSS demo of the Messenger chat bubbles, that merge when stacked together.</div>

                        <div class="bubble recipient first">Oh that's cool!</div>
                        <div class="bubble recipient last">Did you use JavaScript to perform that kind of effect?</div>

                        <div class="bubble sender first">No, that's full CSS3!</div>
                        <div class="bubble sender middle">(Take a look to the 'JS' section of this Pen... it's empty! 😃</div>
                        <div class="bubble sender last">And it's also really lightweight!</div>

                        <div class="bubble recipient">Dope!</div>

                        <div class="bubble sender first">Yeah, but I still didn't succeed to get rid of these stupid .first and .last classes.</div>
                        <div class="bubble sender middle">The only solution I see is using JS, or a &lt;div&gt; to group elements together, but I don't want to ...</div>
                        <div class="bubble sender last">I think it's more transparent and easier to group .bubble elements in the same parent.</div>

                    </section>-->
                </td>
                <td colspan="5" valign="top" align="center">
                    <font class="Bahs">History:<br></font>
                    <?php
                    //Approvals
                    //Titulo, Size, Info, Alert, Search, DataSearch
                    $aGList2 = array("", "100%", "", "", "0", "xxx");
                    
                    $LQry2 = "SELECT * FROM PPVLogs WHERE idPPV = '$IDPPV' ORDER BY datetime DESC";
                    $countr2 =$count2 = 0;
                    $aColumns2 = array(
                        array("", "tr_class", "tit_col_center", "uAdded", "tit_col_center", "Type", "tit_col_center", "DateTime")
                    );
                    $LRows2 = $cnx->query("$LQry2")->fetchAll();
                    foreach ($LRows2 as &$LRowsx2) {
                        $count2++;
                        $countr2++;

                        $get_UserCreated = $LRowsx2['UserCreated'];
                        $get_TypeLog = $LRowsx2['TypeLog'];
                        $get_datetime = $LRowsx2['datetime'];

                        if($countr2 == 2){
                            $bcolor = "#E7E7E7";
                            $countr2 = 0;
                        } else {
                            $bcolor = "#FFFFFF";
                        }

                        //N $gettoken = base64_encode($getidFile);

                        $goptions = "";

                        $aColumns2[] = array("$bcolor", "", "col_center", "$get_UserCreated", "col_center", "$get_TypeLog", "col_center", "$get_datetime");


                    }

                    echo drawList($aGList2, $aLinks2, $aColumns2);
                    
                    
                    ?>
                </td>
            </tr>
        </table>
        <br><br>
        <div style="height: 5px;background-color: <?php echo $cSt;?>;">
        </div>
    </div>
</center>