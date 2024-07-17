<?php
switch ($sIII){
    case "AddPPV":
        switch($sIV){
            case "sAdd":
                $gClassCode = strtoupper($_POST['classcode']);
                $gPN = strtoupper($_POST['partnumber']);
                $gQtyD = $_POST['qtyd'];
                $gQty = $_POST['qty'];
                $gPrice = $_POST['price'];
                $gCode = strtoupper($_POST['code']);
                $gPO = strtoupper($_POST['po']);
                //$gAcctg = strtoupper($_POST['acctg']);
                //$gAcctg = 0;
                
                //Valida el numero de parte
                $sPrice = "SELECT Acctg_Value, Description FROM PartData WHERE Item_Number = '$gPN' ORDER BY Acctg_Value DESC LIMIT 0, 1";
                $nPrice = $cnx->query($sPrice)->numRows();
                //echo $sPrice . "<BR>";
                //echo "$gClassCode - $gAcctg - $gPN - $gQty - $gPrice - $gCode - $nPrice<BR>";
                
                
                if(!empty($gClassCode) && !empty($gPN) && $gQty > 0 && $gPrice > 0 && !empty($gCode) && strlen($gCode) == 6 && $nPrice == 1){
                    //Valida si existe
                    $sEx = "SELECT * FROM PPV WHERE ClassCode = '$gClassCode' AND PartNumber = '$gPN' AND Qty = '$gQty' "
                        . "AND VendorPrice = '$gPrice' AND VendorCode = '$gCode' AND (Status != 'Closed' OR PO = '') "
                        . "ORDER BY dtCreated DESC LIMIT 0, 1";
                    $nEx = $cnx->query($sEx)->numRows();
                    
                    //Obtiene precio
                    $APrice = $cnx->query($sPrice)->fetchArray();
                    $gAcctg = $APrice['Acctg_Value'];
                    $gDescr = $APrice['Description'];
                    
                    if($nEx == 0){
                        //Agrega el PPV
                        $sMax = "SELECT MAX(idPPV) AS mid FROM PPV";
                        $rMax = $cnx->query($sMax)->fetchArray();
                        $idPPV = $rMax['mid'] + 1;
                        $keyPPV = "PPV" . str_pad($idPPV, 8, "0", STR_PAD_LEFT);
                        //verifica si existe OPEN PO
                        $sOPO = "SELECT * FROM PPVs WHERE Vendor_Number = '$gCode' AND Part_Nbr = '$gPN' AND "
                                . "Currency_List_Unit_Price = '$gPrice' "
                                . "AND Class_Code = '$gClassCode' ORDER BY idPPV DESC LIMIT 0, 1";
                        $nOPO = $cnx->query($sOPO)->numRows();
                        //echo $sOPO . "- $nOPO";
                        if($nOPO == 1){
                            $rXPPV = $cnx->query($sOPO)->fetchArray();
                            $pp_idPPV = $rXPPV['idPPV'];
                            $pp_keyPPV = $rXPPV['keyPPV'];
                            $pp_dtAdded = $rXPPV['dtAdded'];
                            $pp_Buyer = $rXPPV['Buyer'];
                            $pp_Vendor_Number = $rXPPV['Vendor_Number'];
                            $pp_Vendor_Name = $rXPPV['Vendor_Name'];
                            $pp_Purch_Order_Number = $rXPPV['Purch_Order_Number'];
                            $pp_Lne_Nbr = $rXPPV['Lne_Nbr'];
                            $pp_Class_Code = $rXPPV['Class_Code'];
                            $pp_Part_Nbr = $rXPPV['Part_Nbr'];
                            $pp_Description = $rXPPV['Description'];
                            $pp_Quantity_Ordered = $rXPPV['Quantity_Ordered'];
                            $pp_Expected_Delivery_Date = $rXPPV['Quantity_Ordered'];
                            $pp_Balance_Due = $rXPPV['Balance_Due'];
                            $pp_Currency_List_Unit_Price = $rXPPV['Currency_List_Unit_Price'];
                            $pp_Extended_Price = $rXPPV['Extended_Price'];
                            $pp_Requested_Delivery_Date = $rXPPV['Requested_Delivery_Date'];
                            $pp_Vendor_Promise_Dt = $rXPPV['Vendor_Promise_Dt'];
                            $pp_Tracking_Nbr = $rXPPV['Tracking_Nbr'];
                            $pp_Disp_Type = $rXPPV['Disp_Type'];
                            $pp_Disp_Ref = $rXPPV['Disp_Ref'];
                            $pp_Mfgr_ID = $rXPPV['Mfgr_ID'];
                            $pp_Mfgr_Item_Nbr = $rXPPV['Mfgr_Item_Nbr'];
                            $pp_Purchase_Order_Add_Date = $rXPPV['Purchase_Order_Add_Date'];
                            $pp_Acctg_Value = $rXPPV['Acctg_Value'];
                            $pp_Delta_Value = $rXPPV['Delta_Value'];
                            $pp_ImpactValue = $rXPPV['ImpactValue'];
                            $pp_dtParts = $rXPPV['dtParts'];
                            $pp_dtDelta = $rXPPV['dtDelta'];
                            $pp_dtCreate = $rXPPV['dtCreate'];
                            $pp_dtReqClosed = $rXPPV['dtReqClosed'];
                            $pp_dtClosed = $rXPPV['dtClosed'];
                            $pp_idUOwner = $rXPPV['idUOwner'];
                            $pp_PO = $rXPPV['PO'];
                            $pp_SO = $rXPPV['SO'];
                            $pp_Invoice = $rXPPV['Invoice'];
                            $pp_Status = $rXPPV['Status'];
                            $Buyer = $pp_Buyer . ",";

                            //Buyer Name
                            $sBuyname = "SELECT * FROM Users WHERE IDExtra LIKE '$Buyer%' OR IDExtra LIKE '$pp_Buyer' ORDER BY IDExtra ASC LIMIT 0, 1";
                            //echo $sBuyname;
                            $rBuyname = $cnx->query($sBuyname)->fetchArray();
                            $pp_BuyerName = $rBuyname['Name'] . " " . $rBuyname['FLastName'];
                            
                            
                        } else {
                            //echo "Aqui";
                            
                            $sMID = "SELECT MAX(idPPV) AS mid FROM PPVs";
                            $rMID = $cnx->query($sMID)->fetchArray();
                            $ID = $rMID['mid'] + 1;
                            $KEY = "PPV" . str_pad($ID, 8, "0", STR_PAD_LEFT);
                            

                            $Bx = explode(",", $uIDExtra);
                            $cB = 0;
                            foreach ($Bx AS &$By){
                                if($cB == 0 && substr($By, 0, 1) == "B"){
                                    $cB++;
                                    $g_Buyer = $By;
                                }
                            }

                            $g_Vendor_Number = $gCode;
                            //Nombre Vendor
                            if(!empty($g_Vendor_Number)){
                                $sVendN = "SELECT Mfgr_Name FROM PartData WHERE Vendor_Id = '$g_Vendor_Number' AND Item_Number = '$gPN' ORDER BY Mfgr_Name DESC LIMIT 0, 1";
                                $nVendN = $cnx->query($sVendN)->numRows();
                                
                                if($nVendN == 1){
                                    $rVendN = $cnx->query($sVendN)->fetchArray();
                                    $g_Vendor_Name = $rVendN['Mfgr_Name'];
                                } else {
                                    $g_Vendor_Name = "";
                                }
                                
                            }
                            
                            echo $sVendN;
                            
                            $g_Purch_Order_Number = $gPO;
                            $g_Lne_Nbr = "";
                            $g_Class_Code = $gClassCode;
                            $g_Part_Nbr = $gPN;
                            $g_Description = $gDescr;
                            $g_Quantity_Ordered = $gQty;
                            $g_Expected_Delivery_Date = "2000-01-01";
                            $g_Balance_Due = $g_Quantity_Ordered;
                            $g_Currency_List_Unit_Price = $gPrice;
                            $g_Extended_Price = $g_Currency_List_Unit_Price * $g_Quantity_Ordered;
                            $g_Requested_Delivery_Date = "2000-01-01";
                            $g_Vendor_Promise_Dt = "2000-01-01";
                            $g_Tracking_Nbr = "";
                            $g_Disp_Type = "";
                            $g_Disp_Ref = "";
                            $g_Mfgr_ID = "";
                            $g_Mfgr_Item_Nbr = "";
                            $g_Purchase_Order_Add_Date = "2000-01-01";
                            $g_Acctg_Value = $gAcctg;
                            $g_Delta_Value = $g_Currency_List_Unit_Price - $g_Acctg_Value;
                            $g_ImpactValue = $g_Quantity_Ordered * $g_Delta_Value;
                            $g_dtParts = $dtAhora;
                            $g_dtDelta = $dtAhora;
                            $S_IDOwner = $uIDUser;

                            $iPPV = "INSERT INTO PPVs VALUES("
                                    . "'$ID', '$KEY', '$dtAhora', '$g_Buyer', '$g_Vendor_Number', "
                                    . "'$g_Vendor_Name', '$g_Purch_Order_Number', '$g_Lne_Nbr', '$g_Class_Code', '$g_Part_Nbr', "
                                    . "'$g_Description', '$g_Quantity_Ordered', '$g_Expected_Delivery_Date', '$g_Balance_Due', '$g_Currency_List_Unit_Price', "
                                    . "'$g_Extended_Price', '$g_Requested_Delivery_Date', '$g_Vendor_Promise_Dt', '$g_Tracking_Nbr', '$g_Disp_Type', "
                                    . "'$g_Disp_Ref', '$g_Mfgr_ID', '$g_Mfgr_Item_Nbr', '$g_Purchase_Order_Add_Date', '$g_Acctg_Value', "
                                    . "'$g_Delta_Value', '$g_ImpactValue', '$g_dtParts', '$g_dtDelta', '$dtAhora', "
                                    . "'$dtAhora', '$dtAhora', '$S_IDOwner', '', '', '', 'DraftPPV'"
                                    . ")";
                            $rPP = $cnx->query($iPPV);
                            //echo $iPPV;
                            
                        }
                        
                        
                        
                        /*
                        $iPPV = "INSERT INTO PPV VALUES('$idPPV', '$keyPPV', '$gPO', '$gQtyD', '$gPN', '$gClassCode', "
                                . "'$gQty', '$gCode', '$gVendor', '$gPrice', '$gAcctg', '$gDelta', '$gImpact', '$uIDUser', '$uFullName', '$dtAhora', 'Open')";
                        $rPPV = $cnx->query($iPPV);
                        */
                        $vATipo = "Verde";
                        $vAMensaje = "PPV added succesfully";
                        $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=Home&sIV=Home&token=$gettoken";
                        $vATime = 30000;
                        //N echo $vRedirect;
                        echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                    } else {
                        //PPV Number
                        $rEx = $cnx->qry($sEx)->fetchArray();
                        //Error ya existe
                        //No existe
                        $vATipo = "Rojo";
                        $vAMensaje = "PPV combination already exist";
                        $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=Home&token=$gettoken";
                        $vATime = 3000;
                        //N echo $vRedirect;
                        echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                    }
                    
                    
                } else {
                    //error Alert
                    //No existe
                    $vATipo = "Rojo";
                    $vAMensaje = "Invalid values";
                    $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=Home&token=$gettoken";
                    $vATime = 3000;
                    //N echo $vRedirect;
                    echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                    
                }
                
                break;
            case "Home":
                //Solo buyer
                if($uAccount == "Buyer" || $uAccount == "SuperUser" || $uAccount == "Admin"){
                    //subir files
                    //Titulo, Size, Info, Alert
                    $aGForm = array("Add PPV", "60%", "", "");
                    //Link, Title, target, class, $sI, SII, $sIII, $sIV, token, tokeni, tokenii
                    $aLinks = array(
                        array("", "< Back", "", "linkr", "", "$sI", "$sII", "Home", "Home", "", "", "")
                    );

                    //campos: action, label, id, class, tipo, name, value, checked, selected, focus  
                    $aFields = array(
                        array("index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=sAdd&token=$gettoken", "", "formx", "formx", "post", "addfile", "", "", "", ""),
                        array("", "Class Code:", "classcode", "text", "text", "classcode", "", "", "", "1"),
                        array("", "<BR>Part Number", "partnumber", "text", "text", "partnumber", "", "", "", ""),
                        array("", "<BR>Total Deliveries:", "qtyd", "text", "number", "qtyd", "", "", "", ""),
                        array("", "<BR>Total Qty:", "qty", "text", "number", "qty", "", "", "", ""),
                        array("", "<BR>PO:", "po", "text", "number", "po", "", "", "", ""),
                        array("", "<BR>Vendor Code:", "code", "text", "text", "code", "", "", "", ""),
                        array("", "<BR>Vendor Price:", "price", "text", "number", "price", "", "", "", ""),
                        //array("", "<BR>Acctg Value:", "acctg", "text", "number", "acctg", "", "", "", "")
                    );
                    echo drawForm($aGForm, $aLinks, $aFields);
                } else {
                    $vATipo = "Rojo";
                    $vAMensaje = "Buyer Account is required ...!";
                    $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=Home&sIV=Home&token=$gettoken";
                    $vATime = 1000;
                    //N echo $vRedirect;
                    echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);

                }
                break;
        }
        break;
    case "EditApproval":
        switch ($sIV){
            case "sAdd":
                $gUser = $_POST['user'];
                $gfrom = $_POST['from'];
                $gto = $_POST['to'];
                
                $sOwnname = "SELECT * FROM Users WHERE IDUser = '$gUser' ORDER BY IDUser ASC LIMIT 0, 1";
                $rOwnname = $cnx->query($sOwnname)->fetchArray();
                $gName = $rOwnname['Name'] . " " . $rOwnname['FLastName'];
                
                //Obtiene
                $sM = "SELECT MAX(idPPVLevel) AS mid FROM PPVsLevel";
                $rM = $cnx->query($sM)->fetchArray();
                $id = $rM['mid'] + 1;
                //echo $sM . "<BR>";
                
                
                $iLevl = "INSERT INTO PPVsLevel VALUES('$id', '$gUser', '$gName', '$gfrom', '$gto')";
                $rLevl = $cnx->query($iLevl);
                //echo $iLevl;
                $vATipo = "Verde";
                $vAMensaje = "Added Successfully ...!";
                $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=Home&token=$gettoken";
                $vATime = 100000;
                //N echo $vRedirect;
                echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                
                break;
            case "Add":
                //subir files
                //Titulo, Size, Info, Alert
                $aGForm = array("Add Approval Masterwork Cost", "60%", "", "");
                //Link, Title, target, class, $sI, SII, $sIII, $sIV, token, tokeni, tokenii
                $aLinks = array(
                    array("", "< Back", "", "linkr", "", "$sI", "$sII", "$sIII", "Home", "", "", "")
                );
                
                //Trae todos los usuarios
                $sSup = "SELECT IDUser, CONCAT(FLastName, ' ', MLastName, ', ', Name) AS name FROM Users ORDER BY FLastName ASC";
                $rSup = $cnx->query($sSup)->fetchAll();

                foreach ($rSup as &$RSupX) {
                    //print_r($RSupX);
                    $valopt = $RSupX['IDUser'];
                    $OptX = $RSupX['name'];
                    $users .= "$valopt:$OptX|";
                }

                if(!empty($users)){
                    $users = substr($users, 0, -1);
                }
                
                
                //campos: action, label, id, class, tipo, name, value, checked, selected, focus  
                $aFields = array(
                    array("index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=s$sIV&token=$gettoken", "", "formx", "formx", "post", "addfile", "", "", "", ""),
                    array("", "User:", "user", "stext", "select", "user", "$users", "", "", "1"),
                    array("", "<BR><BR>From ($):", "from", "text", "number", "from", "", "", "", ""),
                    array("", "<BR><BR>To ($):", "to", "text", "number", "to", "", "", "", "")
                );
                echo drawForm($aGForm, $aLinks, $aFields);
                break;
            case "Home":
                $aLinks = array(
                    array("", "[+] Add Approval", "", "linkr", "", "$sI", "$sII", "$sIII", "Add", "", "", ""),
                    //array("", "[&#9954;] Dashboard", "", "linkr", "", "$sI", "$sII", "Dashboard", "Home", "", "", ""),
                );
                
                $aGList = array("Approval List", "50%", "", "", "0", "MPN, SUPPLIER, MANUFACTURER");
                        
                if(isset($_GET['search'])){
                    if($_GET['search'] == 1){
                        $frase = $_POST['search'];

                        $lfrase = "%$frase%";
                        $LQry = "SELECT * FROM Quotes WHERE "
                                . "CPN LIKE '%$frase%' OR MPN LIKE '%$frase%' OR QUOTED_MPN LIKE '%$frase%' OR MANUFACTURER_NAME LIKE '%$frase%' OR SUPPLIER_NAME = '%$frase%' "
                                . " ORDER BY COMPLETED_ON DESC";
                        //N $LRows = $cnx->query('SELECT MobileNumber AS IDUser, MobileNumber AS Celular, CONCAT(FLastName, \', \', Name) AS Nombre FROM Users WHERE (MobileNumber LIKE ? OR Name LIKE ? OR FLastName LIKE ? OR MLastName LIKE ?) AND IDUser != ? ORDER BY FLastName ASC', $lfrase, $lfrase, $lfrase, $lfrase, '1')->fetchAll();
                    }

                } else {
                    $LQry = "SELECT * FROM PPVsLevel ORDER BY ToL ASC";
                }
                
                
                
                $aColumns = array(
                    array("", "tr_class", "tit_col_center", "#", "tit_col_center", "+", "tit_col_center", "User", "tit_col_center", "From", "tit_col_center", "To")
                );
                $LRows = $cnx->query("$LQry")->fetchAll();
                foreach ($LRows as &$LRowsx) {
                    $count++;
                    $countr++;
                    
                    $get_idPPVLevel = $LRowsx['idPPVLevel'];
                    $get_idUser = $LRowsx['idUser'];
                    $get_Name = $LRowsx['Name'];
                    $get_FromL = $LRowsx['FromL'];
                    $get_ToL = $LRowsx['ToL'];
                    
                     
                    if($getImpact < 0){
                        $cImpact = "col_center_green";
                    } else {
                        $cImpact = "col_center_red";
                    }
                    
                    if($countr == 2){
                        $bcolor = "#E7E7E7";
                        $countr = 0;
                    } else {
                        $bcolor = "#FFFFFF";
                    }
                    
                    $gettoken = base64_encode($getidQuotes);
                    
                    $goptions = "";
                    //N$count = "$count - $uAccount";
                    
                    
                    $aColumns[] = array("$bcolor", "", "col_center", "$count", "col_center", "$options", "col_center", "$get_Name", "col_center", "$get_FromL", 
                        "col_center", "$get_ToL");
                    
                    
                }
                
                echo drawList($aGList, $aLinks, $aColumns);
                break;
        }
        break;
    case "rDeleteDraft":
        $IDPPV = base64_decode($_GET['token']);
        $gettoken = base64_encode($IDPPV);
        
        $sPPV = "SELECT * FROM PPVs WHERE idPPV = '$IDPPV'";
        $rXPPV = $cnx->query($sPPV)->fetchArray();
        $pp_idPPV = $rXPPV['idPPV'];
        $pp_keyPPV = $rXPPV['keyPPV'];
        $pp_dtAdded = $rXPPV['dtAdded'];
        $pp_Buyer = $rXPPV['Buyer'];
        $pp_Vendor_Number = $rXPPV['Vendor_Number'];
        $pp_Vendor_Name = $rXPPV['Vendor_Name'];
        $pp_Purch_Order_Number = $rXPPV['Purch_Order_Number'];
        $pp_Lne_Nbr = $rXPPV['Lne_Nbr'];
        $pp_Class_Code = $rXPPV['Class_Code'];
        $pp_Part_Nbr = $rXPPV['Part_Nbr'];
        $pp_Description = $rXPPV['Description'];
        $pp_Quantity_Ordered = $rXPPV['Quantity_Ordered'];
        $pp_Expected_Delivery_Date = $rXPPV['Quantity_Ordered'];
        $pp_Balance_Due = $rXPPV['Balance_Due'];
        $pp_Currency_List_Unit_Price = $rXPPV['Currency_List_Unit_Price'];
        $pp_Extended_Price = $rXPPV['Extended_Price'];
        $pp_Requested_Delivery_Date = $rXPPV['Requested_Delivery_Date'];
        $pp_Vendor_Promise_Dt = $rXPPV['Vendor_Promise_Dt'];
        $pp_Tracking_Nbr = $rXPPV['Tracking_Nbr'];
        $pp_Disp_Type = $rXPPV['Disp_Type'];
        $pp_Disp_Ref = $rXPPV['Disp_Ref'];
        $pp_Mfgr_ID = $rXPPV['Mfgr_ID'];
        $pp_Mfgr_Item_Nbr = $rXPPV['Mfgr_Item_Nbr'];
        $pp_Purchase_Order_Add_Date = $rXPPV['Purchase_Order_Add_Date'];
        $pp_Acctg_Value = $rXPPV['Acctg_Value'];
        $pp_Delta_Value = $rXPPV['Delta_Value'];
        $pp_ImpactValue = $rXPPV['ImpactValue'];
        $pp_dtParts = $rXPPV['dtParts'];
        $pp_dtDelta = $rXPPV['dtDelta'];
        $pp_dtCreate = $rXPPV['dtCreate'];
        $pp_dtReqClosed = $rXPPV['dtReqClosed'];
        $pp_dtClosed = $rXPPV['dtClosed'];
        $pp_idUOwner = $rXPPV['idUOwner'];
        $pp_PO = $rXPPV['PO'];
        $pp_SO = $rXPPV['SO'];
        $pp_Invoice = $rXPPV['Invoice'];
        $pp_Status = $rXPPV['Status'];
        $Buyer = $pp_Buyer . ",";
        $linkd = "index.php?sI=$sI&sII=PPV&sIII=DeleteDraft&sIV=Home&token=$gettoken&tokeni=$gettokeni&tokenii=$gettokenii";
        
        ?>
        <center>
            <br><br>
        <div style="width: 500px;background-color: red;padding:10px;">
            <font class="Robs" style="color:white;">
            Delete Confirmation:<BR>
            PPV: <b><?php echo $pp_keyPPV;?></b>  
            </font><br>
            <font class="Robss" style="color:white;">
            Part: <b><?php echo $pp_Part_Nbr;?></b> 
            PO: <b><?php echo $pp_Purch_Order_Number;?></b>
            </font><br><br>
            <a href="<?php echo $linkd;?>"><img src="Images/Trash.svg" width="50" title="Delete Confirmation"></a>
            <br><br>
        </div>
        </center>   
        <?php
        break;
    case "DeleteDraft":
        $IDPPV = base64_decode($_GET['token']);
        
        $DPPV = "DELETE FROM PPVs WHERE idPPV = '$IDPPV'";
        $dDPPV = $cnx->query($DPPV);
        //*echo $DPPV;
        
        $vATipo = "Verde";
        $vAMensaje = "PPV Deleted Successfully ...!";
        $vRedirect = "index.php?sI=$sI&sII=Home&sIII=Home&sIV=Home";
        $vATime = 1000;
        //N echo $vRedirect;
        echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
        
        break;
    case "EditPPV":
        //Info PPV
        $IDPPV = base64_decode($_GET['token']);
        $gettoken = base64_encode($IDPPV);
        
        $sPPV = "SELECT * FROM PPVs WHERE idPPV = '$IDPPV'";
        $rXPPV = $cnx->query($sPPV)->fetchArray();
        $pp_idPPV = $rXPPV['idPPV'];
        $pp_keyPPV = $rXPPV['keyPPV'];
        $pp_dtAdded = $rXPPV['dtAdded'];
        $pp_Buyer = $rXPPV['Buyer'];
        $pp_Vendor_Number = $rXPPV['Vendor_Number'];
        $pp_Vendor_Name = $rXPPV['Vendor_Name'];
        $pp_Purch_Order_Number = $rXPPV['Purch_Order_Number'];
        $pp_Lne_Nbr = $rXPPV['Lne_Nbr'];
        $pp_Class_Code = $rXPPV['Class_Code'];
        $pp_Part_Nbr = $rXPPV['Part_Nbr'];
        $pp_Description = $rXPPV['Description'];
        $pp_Quantity_Ordered = $rXPPV['Quantity_Ordered'];
        $pp_Expected_Delivery_Date = $rXPPV['Quantity_Ordered'];
        $pp_Balance_Due = $rXPPV['Balance_Due'];
        $pp_Currency_List_Unit_Price = $rXPPV['Currency_List_Unit_Price'];
        $pp_Extended_Price = $rXPPV['Extended_Price'];
        $pp_Requested_Delivery_Date = $rXPPV['Requested_Delivery_Date'];
        $pp_Vendor_Promise_Dt = $rXPPV['Vendor_Promise_Dt'];
        $pp_Tracking_Nbr = $rXPPV['Tracking_Nbr'];
        $pp_Disp_Type = $rXPPV['Disp_Type'];
        $pp_Disp_Ref = $rXPPV['Disp_Ref'];
        $pp_Mfgr_ID = $rXPPV['Mfgr_ID'];
        $pp_Mfgr_Item_Nbr = $rXPPV['Mfgr_Item_Nbr'];
        $pp_Purchase_Order_Add_Date = $rXPPV['Purchase_Order_Add_Date'];
        $pp_Acctg_Value = $rXPPV['Acctg_Value'];
        $pp_Delta_Value = $rXPPV['Delta_Value'];
        $pp_ImpactValue = $rXPPV['ImpactValue'];
        $pp_dtParts = $rXPPV['dtParts'];
        $pp_dtDelta = $rXPPV['dtDelta'];
        $pp_dtCreate = $rXPPV['dtCreate'];
        $pp_dtReqClosed = $rXPPV['dtReqClosed'];
        $pp_dtClosed = $rXPPV['dtClosed'];
        $pp_idUOwner = $rXPPV['idUOwner'];
        $pp_PO = $rXPPV['PO'];
        $pp_SO = $rXPPV['SO'];
        $pp_Invoice = $rXPPV['Invoice'];
        $pp_Status = $rXPPV['Status'];
        $Buyer = $pp_Buyer . ",";
        
        //Buyer Name
        $sBuyname = "SELECT * FROM Users WHERE IDExtra LIKE '$Buyer%' OR IDExtra LIKE '$pp_Buyer' ORDER BY IDExtra ASC LIMIT 0, 1";
        //echo $sBuyname . "<BR>";
        $rBuyname = $cnx->query($sBuyname)->fetchArray();
        $pp_BuyerName = $rBuyname['Name'] . " " . $rBuyname['FLastName'];
        //echo "AquiName:" . $pp_BuyerName . "<BR>";
        //Nombre del owner
        if(empty($pp_idUOwner) OR $pp_idUOwner == 0){
            $pp_OwnerName = $pp_BuyerName;
            //echo "Aqui1";
        } else {
            //Busca el Owner
            //Buyer Name
            $sOwnname = "SELECT * FROM Users WHERE IDUser = '$pp_idUOwner' ORDER BY IDUser ASC LIMIT 0, 1";
            $rOwnname = $cnx->query($sOwnname)->fetchArray();
            $pp_OwnerName = $rOwnname['Name'] . " " . $rOwnname['FLastName'];
            //echo $sOwnname . "<BR>";
            //echo "Aqui2";
        }
        
        //echo $pp_OwnerName;
        
        
        //Revisa cotizaciones actuales
        $sQt = "SELECT * FROM Files WHERE (App = 'PPV_Q') AND idApp = '$IDPPV'";
        $nQt = $cnx->query($sQt)->numRows();
        
        //Revisa PO actuales
        $sPO = "SELECT * FROM Files WHERE (App = 'PPV_PO') AND idApp = '$IDPPV'";
        $nPO = $cnx->query($sPO)->numRows();
        
        
        
        if($nQt > 0){
            //Cotizaciones
            $LQuotes = $cnx->query($sQt)->fetchAll();
        }
        
        if($nPO > 0){
            //Cotizaciones
            $LPOs = $cnx->query($sPO)->fetchAll();
        }
        switch ($sIV){
            case "sAddPODraft":
                $P_PO = $_POST['po'];
                $P_notes = $_POST['notes'];
                //Inserta Notes
                $LogM = "Draft PO Notes:\n$P_notes";
                //Inserta Log
                $sDesc = "INSERT INTO PPVLogs VALUES('0', '$IDPPV', '1', 'Draft PO', "
                        . "'$LogM', '$uIDUser', '$uFullName', '$uIDUser', '$uFullName', '$dtAhora')";
                //N echo $sDesc . "<BR>";
                $isDesc = $cnx->query("$sDesc");
                
                //Actualiza el PPv
                $uPPV = "UPDATE PPVs SET status = 'Open', idUOwner = '$uIDUser' WHERE idPPV = '$IDPPV'";
                $ruPPV = $cnx->query($uPPV);
                
                $vATipo = "Verde";
                $vAMensaje = "Draft PO Successfully ...!";
                $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=vEdit&token=$gettoken";
                $vATime = 1000;
                //N echo $vRedirect;
                echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                break;
            case "AddPODraft":
                //subir files
                //Titulo, Size, Info, Alert
                $aGForm = array("PO for PPV Draft", "60%", "", "");
                //Link, Title, target, class, $sI, SII, $sIII, $sIV, token, tokeni, tokenii
                $aLinks = array(
                    array("", "< Back", "", "linkr", "", "$sI", "$sII", "$sIII", "vEdit", "$gettoken", "", "")
                );
                /*
                //Trae todos los usuarios
                $sSup = "SELECT IDUser, CONCAT(FLastName, ' ', MLastName, ', ', Name) AS name FROM Users WHERE Account = 'CSR' ORDER BY FLastName ASC";
                $rSup = $cnx->query($sSup)->fetchAll();

                foreach ($rSup as &$RSupX) {
                    //print_r($RSupX);
                    $valopt = $RSupX['IDUser'];
                    $OptX = $RSupX['name'];
                    $valSup .= "$valopt:$OptX|";
                }

                if(!empty($valSup)){
                    $valSup = substr($valSup, 0, -1);
                }
                */
                
                //campos: action, label, id, class, tipo, name, value, checked, selected, focus  
                $aFields = array(
                    array("index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=s$sIV&token=$gettoken", "", "formx", "formx", "post", "addfile", "", "", "", ""),
                    array("", "PO:", "po", "text", "number", "po", "", "", "", "1"),
                    array("", "<BR>Notes:", "notes", "atext", "textarea", "notes", "80|4", "", "", "")
                );
                echo drawForm($aGForm, $aLinks, $aFields);
                break;
            case "sAddNoCustPO":
                $P_notes = $_POST['notes'];
                //Inserta Notes
                $LogM = "No Customer PO Notes:\n$P_notes";
                $uCSRManager = 19;
                //Inserta Log
                $sDesc = "INSERT INTO PPVLogs VALUES('0', '$IDPPV', '1', 'No Customer PO', "
                        . "'$LogM', '$uIDUser', '$uFullName', '$P_owner', '$uCSRManager', '$dtAhora')";
                //N echo $sDesc . "<BR>";
                $isDesc = $cnx->query("$sDesc");
                
                //Actualiza el PPv
                $uPPV = "UPDATE PPVs SET status = 'NoCustomerPO', idUOwner = '$uCSRManager' WHERE idPPV = '$IDPPV'";
                $ruPPV = $cnx->query($uPPV);
                
                $vATipo = "Verde";
                $vAMensaje = "No Customer PO Successfully ...!";
                $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=vEdit&token=$gettoken";
                $vATime = 1000;
                //N echo $vRedirect;
                echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                break;
            case "AddNoCustPO":
                //subir files
                //Titulo, Size, Info, Alert
                $aGForm = array("No Customer PO Notes", "60%", "", "");
                //Link, Title, target, class, $sI, SII, $sIII, $sIV, token, tokeni, tokenii
                $aLinks = array(
                    array("", "< Back", "", "linkr", "", "$sI", "$sII", "$sIII", "vEdit", "$gettoken", "", "")
                );
                /*
                //Trae todos los usuarios
                $sSup = "SELECT IDUser, CONCAT(FLastName, ' ', MLastName, ', ', Name) AS name FROM Users WHERE Account = 'CSR' ORDER BY FLastName ASC";
                $rSup = $cnx->query($sSup)->fetchAll();

                foreach ($rSup as &$RSupX) {
                    //print_r($RSupX);
                    $valopt = $RSupX['IDUser'];
                    $OptX = $RSupX['name'];
                    $valSup .= "$valopt:$OptX|";
                }

                if(!empty($valSup)){
                    $valSup = substr($valSup, 0, -1);
                }
                */
                
                //campos: action, label, id, class, tipo, name, value, checked, selected, focus  
                $aFields = array(
                    array("index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=s$sIV&token=$gettoken", "", "formx", "formx", "post", "addfile", "", "", "", ""),
                    //array("", "CSR:", "owner", "stext", "select", "owner", "$valSup", "", "", ""),
                    array("", "<BR>Notes:", "notes", "atext", "textarea", "notes", "80|4", "", "", "1")
                );
                echo drawForm($aGForm, $aLinks, $aFields);
                //N sleep(50);
                break;
            case "Requote":
                //Depends ClassCode
                $sCSR = "SELECT IDUser FROM Users WHERE IDExtra LIKE '%$pp_Class_Code%'";
                $nCSR = $cnx->query($sCSR)->numRows();
                //echo $sCSR;
                
                if($nCSR == 1):
                    $rCSR = $cnx->query($sCSR)->fetchArray();
                    $gidUOwner = $rCSR['IDUser'];
                    //Existe el CSR
                    //Inserta Notes
                    //Inserta Notes
                    $LogM = "Requote";
                    //Inserta Log
                    $sDesc = "INSERT INTO PPVLogs VALUES('0', '$IDPPV', '1', 'Requote', "
                            . "'$LogM', '$uIDUser', '$uFullName', '$gidUOwner', '$uOwn', '$dtAhora')";
                    //N echo $sDesc . "<BR>";
                    $isDesc = $cnx->query("$sDesc");

                    //Actualiza el PPv
                    $uPPV = "UPDATE PPVs SET status = 'Requote', idUOwner = '$gidUOwner' WHERE idPPV = '$IDPPV'";
                    $ruPPV = $cnx->query($uPPV);

                    $vATipo = "Verde";
                    $vAMensaje = "Requote Successfully ...!";
                    $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=vEdit&token=$gettoken";
                    $vATime = 1000;
                    //N echo $vRedirect;
                    echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                    
                else:
                    if($nCSR > 1):
                        //Existe mas de 1
                        $vATipo = "Rojo";
                        $vAMensaje = "Class Code more than one assigned($pp_Class_Code)";
                        $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=vEdit&token=$gettoken";
                        $vATime = 3000;
                        //N echo $vRedirect;
                        echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                    else:
                        //No existe
                        $vATipo = "Rojo";
                        $vAMensaje = "Class Code not assigned($pp_Class_Code)";
                        $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=vEdit&token=$gettoken";
                        $vATime = 3000;
                        //N echo $vRedirect;
                        echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                    endif;
                endif;
                
                
                break;
            case "PaidPermanent":
                //Depends ClassCode
                $sCSR = "SELECT IDUser FROM Users WHERE IDExtra LIKE '%$pp_Class_Code%'";
                $nCSR = $cnx->query($sCSR)->numRows();
                //echo $sCSR;
                
                if($nCSR == 1):
                    $rCSR = $cnx->query($sCSR)->fetchArray();
                    $gidUOwner = $rCSR['IDUser'];
                    //Existe el CSR
                    //Inserta Notes
                    $LogM = "PaidPermanent";
                    //Inserta Log
                    $sDesc = "INSERT INTO PPVLogs VALUES('0', '$IDPPV', '1', 'Paid Permanent', "
                            . "'$LogM', '$uIDUser', '$uFullName', '$P_owner', '$uOwn', '$dtAhora')";
                    //N echo $sDesc . "<BR>";
                    $isDesc = $cnx->query("$sDesc");

                    //Actualiza el PPv
                    $uPPV = "UPDATE PPVs SET status = 'PaidPermanent', idUOwner = '$gidUOwner'  WHERE idPPV = '$IDPPV'";
                    $ruPPV = $cnx->query($uPPV);

                    $vATipo = "Verde";
                    $vAMensaje = "Paid Permanent Successfully ($gidUOwner)...!";
                    $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=vEdit&token=$gettoken";
                    $vATime = 1000;
                    //N echo $vRedirect;
                    echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                    
                else:
                    if($nCSR > 1):
                        //Existe mas de 1
                        $vATipo = "Rojo";
                        $vAMensaje = "Class Code more than one assigned($pp_Class_Code)";
                        $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=vEdit&token=$gettoken";
                        $vATime = 3000;
                        //N echo $vRedirect;
                        echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                    else:
                        //No existe
                        $vATipo = "Rojo";
                        $vAMensaje = "Class Code not assigned($pp_Class_Code)";
                        $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=vEdit&token=$gettoken";
                        $vATime = 3000;
                        //N echo $vRedirect;
                        echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                    endif;
                endif;
                break;
            case "sRejPermanent":
                $P_notes = $_POST['notes'];
                //Inserta Notes
                $LogM = "Reject Permanent Notes:\n$P_notes";
                //Inserta Log
                $sDesc = "INSERT INTO PPVLogs VALUES('0', '$IDPPV', '1', 'Reject Permanent', "
                        . "'$LogM', '$uIDUser', '$uFullName', '$P_owner', '$uOwn', '$dtAhora')";
                //N echo $sDesc . "<BR>";
                $isDesc = $cnx->query("$sDesc");
                
                //Actualiza el PPv
                $uPPV = "UPDATE PPVs SET status = 'RejectPermanent', idUOwner = '' WHERE idPPV = '$IDPPV'";
                $ruPPV = $cnx->query($uPPV);
                
                $vATipo = "Verde";
                $vAMensaje = "Reject Permanent Successfully ...!";
                $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=vEdit&token=$gettoken";
                $vATime = 1000;
                //N echo $vRedirect;
                echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                
                break;
            case "RejPermanent":
                //subir files
                //Titulo, Size, Info, Alert
                $aGForm = array("Reject Permanent", "60%", "", "");
                //Link, Title, target, class, $sI, SII, $sIII, $sIV, token, tokeni, tokenii
                $aLinks = array(
                    array("", "< Back", "", "linkr", "", "$sI", "$sII", "$sIII", "vEdit", "$gettoken", "", "")
                );
                
                //campos: action, label, id, class, tipo, name, value, checked, selected, focus  
                $aFields = array(
                    array("index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=s$sIV&token=$gettoken", "", "formx", "formx", "post", "addfile", "", "", "", ""),
                    array("", "<BR>Notes:", "notes", "atext", "textarea", "notes", "80|4", "", "", "")
                );
                echo drawForm($aGForm, $aLinks, $aFields);
                //N sleep(50);
                break;
            case "sAppPermanent":
                //Depends ClassCode
                $sCSR = "SELECT IDUser FROM Users WHERE IDExtra LIKE '%$pp_Class_Code%'";
                $nCSR = $cnx->query($sCSR)->numRows();
                //echo $sCSR;
                
                if($nCSR == 1):
                    $rCSR = $cnx->query($sCSR)->fetchArray();
                    $gidUOwner = $rCSR['IDUser'];
                    //Existe el CSR
                    //Inserta Notes
                    $P_notes = $_POST['notes'];
                    //$P_owner = $_POST['owner'];
                    //Inserta Notes
                    $LogM = "Approve Permanent Notes:\n$P_notes";
                    //Inserta Log
                    $sDesc = "INSERT INTO PPVLogs VALUES('0', '$IDPPV', '1', 'Approve Permanent', "
                            . "'$LogM', '$uIDUser', '$uFullName', '$gidUOwner', '$uOwn', '$dtAhora')";
                    //N echo $sDesc . "<BR>";
                    $isDesc = $cnx->query("$sDesc");

                    //Actualiza el PPv
                    $uPPV = "UPDATE PPVs SET status = 'ApprovePermanent', idUOwner = '$gidUOwner' WHERE idPPV = '$IDPPV'";
                    $ruPPV = $cnx->query($uPPV);

                    $vATipo = "Verde";
                    $vAMensaje = "Approve Permanent Successfully ...!";
                    $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=vEdit&token=$gettoken";
                    $vATime = 1000;
                    //N echo $vRedirect;
                    echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                    
                else:
                    if($nCSR > 1):
                        //Existe mas de 1
                        $vATipo = "Rojo";
                        $vAMensaje = "Class Code more than one assigned($pp_Class_Code)";
                        $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=vEdit&token=$gettoken";
                        $vATime = 3000;
                        //N echo $vRedirect;
                        echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                    else:
                        //No existe
                        $vATipo = "Rojo";
                        $vAMensaje = "Class Code not assigned($pp_Class_Code)";
                        $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=vEdit&token=$gettoken";
                        $vATime = 3000;
                        //N echo $vRedirect;
                        echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                    endif;
                endif;
                break;
            case "AppPermanent":
                //subir files
                //Titulo, Size, Info, Alert
                $aGForm = array("Approve Permanent", "60%", "", "");
                //Link, Title, target, class, $sI, SII, $sIII, $sIV, token, tokeni, tokenii
                $aLinks = array(
                    array("", "< Back", "", "linkr", "", "$sI", "$sII", "$sIII", "vEdit", "$gettoken", "", "")
                );
                /*
                //Trae todos los usuarios
                $sSup = "SELECT IDUser, CONCAT(FLastName, ' ', MLastName, ', ', Name) AS name FROM Users WHERE Account = 'CSR' ORDER BY FLastName ASC";
                $rSup = $cnx->query($sSup)->fetchAll();

                foreach ($rSup as &$RSupX) {
                    //print_r($RSupX);
                    $valopt = $RSupX['IDUser'];
                    $OptX = $RSupX['name'];
                    $valSup .= "$valopt:$OptX|";
                }

                if(!empty($valSup)){
                    $valSup = substr($valSup, 0, -1);
                }
                */
                
                //campos: action, label, id, class, tipo, name, value, checked, selected, focus  
                $aFields = array(
                    array("index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=s$sIV&token=$gettoken", "", "formx", "formx", "post", "addfile", "", "", "", ""),
                    //array("", "CSR:", "owner", "stext", "select", "owner", "$valSup", "", "", ""),
                    array("", "<BR>Notes:", "notes", "atext", "textarea", "notes", "80|4", "", "", "1")
                );
                echo drawForm($aGForm, $aLinks, $aFields);
                //N sleep(50);
                break;
            case "PaymentConfirmation":
                //Inserta Notes
                $LogM = "PaymentConfirmation";
                //Inserta Log
                $sDesc = "INSERT INTO PPVLogs VALUES('0', '$IDPPV', '1', 'Payment Confirmation', "
                        . "'$LogM', '$uIDUser', '$uFullName', '$P_owner', '$uOwn', '$dtAhora')";
                //N echo $sDesc . "<BR>";
                $isDesc = $cnx->query("$sDesc");
                
                //Actualiza el PPv
                $uPPV = "UPDATE PPVs SET status = 'Closed', dtClosed = '$dtAhora' WHERE idPPV = '$IDPPV'";
                $ruPPV = $cnx->query($uPPV);
                
                $vATipo = "Verde";
                $vAMensaje = "Payment Confirmation Successfully ...!";
                $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=vEdit&token=$gettoken";
                $vATime = 1000;
                //N echo $vRedirect;
                echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                
                break;
            case "sAddInvoice":
                $P_invoicenumber = strtoupper($_POST['invoicenumber']);
                //Inserta Notes
                $LogM = "Add Invoice ($P_invoicenumber)\n$P_notes";
                //Inserta Log
                $sDesc = "INSERT INTO PPVLogs VALUES('0', '$IDPPV', '1', 'Add Invoice Number', "
                        . "'$LogM', '$uIDUser', '$uFullName', '$P_owner', '$uOwn', '$dtAhora')";
                //N echo $sDesc . "<BR>";
                $isDesc = $cnx->query("$sDesc");
                
                //Actualiza el PPv
                $uPPV = "UPDATE PPVs SET status = 'WaitingPayment', idUOwner = '', Invoice = '$P_invoicenumber' WHERE idPPV = '$IDPPV'";
                $ruPPV = $cnx->query($uPPV);
                
                $vATipo = "Verde";
                $vAMensaje = "Invoice Number Added Successfully ...!";
                $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=vEdit&token=$gettoken";
                $vATime = 1000;
                //N echo $vRedirect;
                echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                
                break;
            case "AddInvoice":
                //subir files
                //Titulo, Size, Info, Alert
                $aGForm = array("Add Invoice Number", "60%", "", "");
                //Link, Title, target, class, $sI, SII, $sIII, $sIV, token, tokeni, tokenii
                $aLinks = array(
                    array("", "< Back", "", "linkr", "", "$sI", "$sII", "$sIII", "vEdit", "$gettoken", "", "")
                );
                
                
                //campos: action, label, id, class, tipo, name, value, checked, selected, focus  
                $aFields = array(
                    array("index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=s$sIV&token=$gettoken", "", "formx", "formx", "post", "addfile", "", "", "", ""),
                    array("", "<BR>Invoice Number:", "invoicenumber", "text", "text", "invoicenumber", "", "", "", "1")
                );
                echo drawForm($aGForm, $aLinks, $aFields);
                break;
            case "sAddSONumber":
                $P_sonumber = strtoupper($_POST['sonumber']);
                //Inserta Notes
                $LogM = "Add SO ($P_sonumber)\n$P_notes";
                //Inserta Log
                $sDesc = "INSERT INTO PPVLogs VALUES('0', '$IDPPV', '1', 'Add SO Number', "
                        . "'$LogM', '$uIDUser', '$uFullName', '$P_owner', '$uOwn', '$dtAhora')";
                //N echo $sDesc . "<BR>";
                $isDesc = $cnx->query("$sDesc");
                
                //Actualiza el PPv
                $uPPV = "UPDATE PPVs SET status = 'WaitingInvoice', idUOwner = '', SO = '$P_sonumber' WHERE idPPV = '$IDPPV'";
                $ruPPV = $cnx->query($uPPV);
                
                $vATipo = "Verde";
                $vAMensaje = "SO Number Added Successfully ...!";
                $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=vEdit&token=$gettoken";
                $vATime = 1000;
                //N echo $vRedirect;
                echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                
                break;
            case "AddSONumber":
                //subir files
                //Titulo, Size, Info, Alert
                $aGForm = array("Add SO Number", "60%", "", "");
                //Link, Title, target, class, $sI, SII, $sIII, $sIV, token, tokeni, tokenii
                $aLinks = array(
                    array("", "< Back", "", "linkr", "", "$sI", "$sII", "$sIII", "vEdit", "$gettoken", "", "")
                );
                
                
                //campos: action, label, id, class, tipo, name, value, checked, selected, focus  
                $aFields = array(
                    array("index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=s$sIV&token=$gettoken", "", "formx", "formx", "post", "addfile", "", "", "", ""),
                    array("", "<BR>SO Number:", "sonumber", "text", "text", "sonumber", "", "", "", "1")
                );
                echo drawForm($aGForm, $aLinks, $aFields);
                break;
            case "sEditQuestionare":
                //Datos
                $P_Assembly = $_POST['Assembly'];
                $P_Impact = $_POST['Impact'];
                $P_ImpactMonth = $_POST['ImpactMonth'];
                $P_ImpactDate = $_POST['ImpactDate'];
                $P_DeliveryDate = $_POST['DeliveryDate'];
                $P_ETA_NPaid = $_POST['ETA_NPaid'];
                $P_ETA_Paid = $_POST['ETA_Paid'];
                $P_SoleShortage = $_POST['SoleShortage'];
                $P_AVL = $_POST['AVL'];
                $P_Alternate = $_POST['Alternate'];
                $P_BrokerOption = $_POST['BrokerOption'];
                $P_Escalated_Int = $_POST['Escalated_Int'];
                $P_Escalated_Cust = $_POST['Escalated_Cust'];
                $P_Escalated_Supp = $_POST['Escalated_Supp'];
                $P_Additional = $_POST['Additional'];
                $P_OnTime = $_POST['OnTime'];
                
                //Actualiza questionare
                $uQust = "UPDATE PPVQuestionare SET "
                        . "Assembly = '$P_Assembly', Impact = '$P_Impact', "
                        . "ImpactMonth = '$P_ImpactMonth', ImpactDate = '$P_ImpactDate', "
                        . "DeliveryDate = '$P_DeliveryDate', ETA_NPaid = '$P_ETA_NPaid', "
                        . "ETA_Paid = '$P_ETA_Paid', SoleShortage = '$P_SoleShortage', "
                        . "AVL = '$P_AVL', Alternate = '$P_Alternate', "
                        . "BrokerOption = '$P_BrokerOption', Escalated_Int = '$P_Escalated_Int', "
                        . "Escalated_Cust = '$P_Escalated_Cust', Escalated_Supp = '$P_Escalated_Supp', "
                        . "Additional = '$P_Additional', OnTime = '$P_OnTime' "
                        . "WHERE idPPV = '$IDPPV'";
                $rQust = $cnx->query($uQust);
                
                //Inserta Notes
                $LogM = "Update PPV Questionare";
                //Inserta Log
                $sDesc = "INSERT INTO PPVLogs VALUES('0', '$IDPPV', '1', 'Update Questionare', "
                        . "'$LogM', '$uIDUser', '$uFullName', '$uIDOwn', '$uOwn', '$dtAhora')";
                //N echo $sDesc . "<BR>";
                $isDesc = $cnx->query("$sDesc");
                
                $vATipo = "Verde";
                $vAMensaje = "Updated questionare Successfully ...!";
                $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=vEdit&token=$gettoken";
                $vATime = 1000;
                //N echo $vRedirect;
                echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                
                break;
            case "EditQuestionare":
                $sPPVQ = "SELECT * FROM PPVQuestionare WHERE idPPV = '$IDPPV' ORDER BY idPPV ASC LIMIT 0, 1";
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
                //subir files
                //Titulo, Size, Info, Alert
                $aGForm = array("Edit Questionare - $pp_keyPPV", "60%", "", "");
                //Link, Title, target, class, $sI, SII, $sIII, $sIV, token, tokeni, tokenii
                $aLinks = array(
                    array("", "< Back", "", "linkr", "", "$sI", "$sII", "$sIII", "vEdit", "$gettoken", "", "")
                );
                
                
                //campos: action, label, id, class, tipo, name, value, checked, selected, focus  
                $aFields = array(
                    array("index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=s$sIV&token=$gettoken", "", "formx", "formx", "post", "addfile", "", "", "", ""),
                    array("", "Assembly:", "Assembly", "text", "text", "Assembly", "$Qpp_Assembly", "", "", "1"),
                    array("", "<BR>Impact $ of revenue if NOT Approved:", "Impact", "text", "number", "Impact", "$Qpp_Impact", "", "", ""),
                    array("", "<BR>Impact Month:", "ImpactMonth", "text", "text", "ImpactMonth", "$Qpp_ImpactMonth", "", "", ""),
                    array("", "<BR>Impact Date (when Im Short):", "ImpactDate", "text", "date", "ImpactDate", "$Qpp_ImpactDate", "", "", ""),
                    array("", "<BR>Delivery Date Needed (date based on ROI):", "DeliveryDate", "text", "date", "DeliveryDate", "$Qpp_DeliveryDate", "", "", ""),
                    array("", "<BR>ETA (if not paid when will arrive):", "ETA_NPaid", "text", "date", "ETA_NPaid", "$Qpp_ETA_NPaid", "", "", ""),
                    array("", "<BR>ETA (if Paid when will arrive):", "ETA_Paid", "text", "date", "ETA_Paid", "$Qpp_ETA_Paid", "", "", ""),
                    array("", "<BR>Sole Shortage (Y/N):", "SoleShortage", "stext", "select", "SoleShortage", "|Yes|No", "", "$Qpp_SoleShortage", ""),
                    array("", "<BR><BR>How Many AVL?:", "AVL", "text", "number", "AVL", "$Qpp_AVL", "", "", ""),
                    array("", "<BR>Alternate Options to propose (Y/N + Which one):", "Alternate", "text", "text", "Alternate", "$Qpp_Alternate", "", "", ""),
                    array("", "<BR>is this PPV a Broker Option (Y/N):", "BrokerOption", "stext", "select", "BrokerOption", "|Yes|No", "", "$Qpp_BrokerOption", ""),
                    array("", "<BR>Escalated Internally (Y/N - With who):", "Escalated_Int", "text", "text", "Escalated_Int", "$Qpp_Escalated_Int", "", "", ""),
                    array("", "<BR>Escalated Customer (Y/N - With Who):", "Escalated_Cust", "text", "text", "Escalated_Cust", "$Qpp_Escalated_Cust", "", "", ""),
                    array("", "<BR>Escalated Within Supplier (Y/N - With Who):", "Escalated_Supp", "text", "text", "Escalated_Supp", "$Qpp_Escalated_Supp", "", "", ""),
                    array("", "<BR>Additional background information you would like to add:", "Additional", "text", "text", "Additional", "$Qpp_Escalated_Supp", "", "", ""),
                    array("", "<BR>Is this PPV a One time thing or a Permanent PPV:", "OnTime", "stext", "select", "OnTime", "|Yes|No", "", "$Qpp_OnTime", "")
                );
                echo drawForm($aGForm, $aLinks, $aFields);
                
                break;
            case "vEdit":
                $eForm = "EditPPV";
                include("Include/eForms.php");
                break;
            case "sEndCustomerCost":
                //Depends ClassCode
                $sCSR = "SELECT IDUser FROM Users WHERE IDExtra LIKE '%$pp_Class_Code%'";
                $nCSR = $cnx->query($sCSR)->numRows();
                //echo $sCSR;
                
                if($nCSR == 1):
                    $rCSR = $cnx->query($sCSR)->fetchArray();
                    $gidUOwner = $rCSR['IDUser'];
                    //Existe el CSR
                    //Inserta Notes
                    $P_notes = $_POST['notes'];
                    //$P_owner = $_POST['owner'];
                    //Inserta Notes
                    $LogM = "End Customer Cost Notes:\n$P_notes";
                    //Inserta Log
                    $sDesc = "INSERT INTO PPVLogs VALUES('0', '$IDPPV', '1', 'End Customer Cost', "
                            . "'$LogM', '$uIDUser', '$uFullName', '$gidUOwner', '$uOwn', '$dtAhora')";
                    //N echo $sDesc . "<BR>";
                    $isDesc = $cnx->query("$sDesc");

                    //Actualiza el PPv
                    $uPPV = "UPDATE PPVs SET status = 'EndCustomerCost', idUOwner = '$gidUOwner' WHERE idPPV = '$IDPPV'";
                    $ruPPV = $cnx->query($uPPV);

                    $vATipo = "Verde";
                    $vAMensaje = "End Customer Cost Added Successfully ...!";
                    $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=vEdit&token=$gettoken";
                    $vATime = 1000;
                    //N echo $vRedirect;
                    echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                    
                else:
                    if($nCSR > 1):
                        //Existe mas de 1
                        $vATipo = "Rojo";
                        $vAMensaje = "Class Code more than one assigned($pp_Class_Code)";
                        $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=vEdit&token=$gettoken";
                        $vATime = 3000;
                        //N echo $vRedirect;
                        echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                    else:
                        //No existe
                        $vATipo = "Rojo";
                        $vAMensaje = "Class Code not assigned($pp_Class_Code)";
                        $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=vEdit&token=$gettoken";
                        $vATime = 3000;
                        //N echo $vRedirect;
                        echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                    endif;
                endif;
                break;
            case "EndCustomerCost":
                //subir files
                //Titulo, Size, Info, Alert
                $aGForm = array("End Customer Cost Notes", "60%", "", "");
                //Link, Title, target, class, $sI, SII, $sIII, $sIV, token, tokeni, tokenii
                $aLinks = array(
                    array("", "< Back", "", "linkr", "", "$sI", "$sII", "$sIII", "vEdit", "$gettoken", "", "")
                );
                /*
                //Trae todos los usuarios
                $sSup = "SELECT IDUser, CONCAT(FLastName, ' ', MLastName, ', ', Name) AS name FROM Users WHERE Account = 'CSR' ORDER BY FLastName ASC";
                $rSup = $cnx->query($sSup)->fetchAll();

                foreach ($rSup as &$RSupX) {
                    //print_r($RSupX);
                    $valopt = $RSupX['IDUser'];
                    $OptX = $RSupX['name'];
                    $valSup .= "$valopt:$OptX|";
                }

                if(!empty($valSup)){
                    $valSup = substr($valSup, 0, -1);
                }
                */
                
                //campos: action, label, id, class, tipo, name, value, checked, selected, focus  
                $aFields = array(
                    array("index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=s$sIV&token=$gettoken", "", "formx", "formx", "post", "addfile", "", "", "", ""),
                    //array("", "CSR:", "owner", "stext", "select", "owner", "$valSup", "", "", ""),
                    array("", "<BR>Notes:", "notes", "atext", "textarea", "notes", "80|4", "", "", "1")
                );
                echo drawForm($aGForm, $aLinks, $aFields);
                //N sleep(50);
                break;
            case "sMWCApprove":
                $P_notes = $_POST['notes'];
                //Inserta Notes
                $LogM = "Masterwork Cost Approved:\n$P_notes";
                //Inserta Log
                $sDesc = "INSERT INTO PPVLogs VALUES('0', '$IDPPV', '2', 'Approved (Masterwork Cost)', "
                        . "'$LogM', '$uIDUser', '$uFullName', '$uIDOwn', '$uOwn', '$dtAhora')";
                //N echo $sDesc . "<BR>";
                $isDesc = $cnx->query("$sDesc");
                //Inserta autorizacion
                $iApproval = "UPDATE PPVApproval SET"
                        . " Status = 'Closed', dtClosed = '$dtAhora',"
                        . " iduApproval = '$uIDUser', uApproval = '$uFullName', uANotes = '$P_notes', Approval = 'Approved'"
                        . " WHERE idPPV = '$IDPPV' AND Status = 'Open' AND TypeApproval = 'MWCostApproval'";
                $riApp = $cnx->query($iApproval);
                
                //Actualiza el PPv
                $uPPV = "UPDATE PPVs SET status = 'Closed', dtClosed = '$dtAhora' WHERE idPPV = '$IDPPV'";
                $ruPPV = $cnx->query($uPPV);
                
                $vATipo = "Verde";
                $vAMensaje = "Approved Successfully ...!";
                $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=vEdit&token=$gettoken";
                $vATime = 1000;
                //N echo $vRedirect;
                echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                
                break;
            case "MWCApprove":
                //subir files
                //Titulo, Size, Info, Alert
                $aGForm = array("Approve (Masterwork Cost)", "60%", "", "");
                //Link, Title, target, class, $sI, SII, $sIII, $sIV, token, tokeni, tokenii
                $aLinks = array(
                    array("", "< Back", "", "linkr", "", "$sI", "$sII", "$sIII", "vEdit", "$gettoken", "", "")
                );
                
                
                //campos: action, label, id, class, tipo, name, value, checked, selected, focus  
                $aFields = array(
                    array("index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=s$sIV&token=$gettoken", "", "formx", "formx", "post", "addfile", "", "", "", ""),
                    array("", "Notes:", "notes", "atext", "textarea", "notes", "80|4", "", "", "1")
                );
                echo drawForm($aGForm, $aLinks, $aFields);
                //N sleep(50);
                break;
            case "sMasterWorkCost":
                $P_notes = $_POST['notes'];
                //Inserta Notes
                $LogM = "Masterwork Cost Notes:\n$P_notes";
                //Inserta Log
                $sDesc = "INSERT INTO PPVLogs VALUES('0', '$IDPPV', '1', 'Masterwork Cost', "
                        . "'$LogM', '$uIDUser', '$uFullName', '$uIDOwn', '$uOwn', '$dtAhora')";
                //N echo $sDesc . "<BR>";
                $isDesc = $cnx->query("$sDesc");
                
                $uIDPM = 2;
                
                //Actualiza el PPv
                $uPPV = "UPDATE PPVs SET status = 'MasterWorkCost', idUOwner = '$uIDPM' WHERE idPPV = '$IDPPV'";
                $ruPPV = $cnx->query($uPPV);
                
                //Inserta autorizacion
                $iApproval = "INSERT INTO PPVApproval VALUES('0', '$IDPPV', 'MWCostApproval', '$uIDUser', "
                        . "'$uFullName', '$P_notes', '', '', '', '', 'Open', '$dtAhora', '$dtAhora')";
                $riApp = $cnx->query($iApproval);
                
                $vATipo = "Verde";
                $vAMensaje = "Review Cover Added Successfully ...!";
                $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=vEdit&token=$gettoken";
                $vATime = 1000;
                //N echo $vRedirect;
                echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                
                break;
            case "MasterWorkCost":
                //subir files
                //Titulo, Size, Info, Alert
                $aGForm = array("Masterwork Cost Notes", "60%", "", "");
                //Link, Title, target, class, $sI, SII, $sIII, $sIV, token, tokeni, tokenii
                $aLinks = array(
                    array("", "< Back", "", "linkr", "", "$sI", "$sII", "$sIII", "vEdit", "$gettoken", "", "")
                );
                
                
                //campos: action, label, id, class, tipo, name, value, checked, selected, focus  
                $aFields = array(
                    array("index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=s$sIV&token=$gettoken", "", "formx", "formx", "post", "addfile", "", "", "", ""),
                    array("", "Notes:", "notes", "atext", "textarea", "notes", "80|4", "", "", "1")
                );
                echo drawForm($aGForm, $aLinks, $aFields);
                //N sleep(50);
                break;
            case "sRevCoverCost":
                $P_notes = $_POST['notes'];
                //Inserta Notes
                $LogM = "Review Cover Cost Notes:\n$P_notes";
                //Inserta Log
                $sDesc = "INSERT INTO PPVLogs VALUES('0', '$IDPPV', '1', 'Review Cover Cost', "
                        . "'$LogM', '$uIDUser', '$uFullName', '$uIDOwn', '$uOwn', '$dtAhora')";
                //N echo $sDesc . "<BR>";
                $isDesc = $cnx->query("$sDesc");
                
                //Trae usuario supervisor
                
                
                //Actualiza el PPv
                $uPPV = "UPDATE PPVs SET status = 'RevCoverCost', idUOwner = '$uidSupervisor'  WHERE idPPV = '$IDPPV'";
                $ruPPV = $cnx->query($uPPV);
                
                $vATipo = "Verde";
                $vAMensaje = "Review Cover Added Successfully ...!";
                $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=vEdit&token=$gettoken";
                $vATime = 1000;
                //N echo $vRedirect;
                echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                
                break;
            case "RevCoverCost":
                //subir files
                //Titulo, Size, Info, Alert
                $aGForm = array("Review Cover Cost Notes", "60%", "", "");
                //Link, Title, target, class, $sI, SII, $sIII, $sIV, token, tokeni, tokenii
                $aLinks = array(
                    array("", "< Back", "", "linkr", "", "$sI", "$sII", "$sIII", "vEdit", "$gettoken", "", "")
                );
                
                
                //campos: action, label, id, class, tipo, name, value, checked, selected, focus  
                $aFields = array(
                    array("index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=s$sIV&token=$gettoken", "", "formx", "formx", "post", "addfile", "", "", "", ""),
                    array("", "Notes:", "notes", "atext", "textarea", "notes", "80|4", "", "", "1")
                );
                echo drawForm($aGForm, $aLinks, $aFields);
                //N sleep(50);
                break;
            case "sPermanent":
                $P_notes = $_POST['notes'];
                //Inserta Notes
                $LogM = "Permanent Notes:\n$P_notes";
                //Inserta Log
                $sDesc = "INSERT INTO PPVLogs VALUES('0', '$IDPPV', '0', 'Permanent', "
                        . "'$LogM', '$uIDUser', '$uFullName', '$uIDOwn', '$uOwn', '$dtAhora')";
                //N echo $sDesc . "<BR>";
                $isDesc = $cnx->query("$sDesc");
                
                //A yadira
                $SMUser = 25;
                
                //Actualiza el PPv
                $uPPV = "UPDATE PPVs SET status = 'Permanent', idUOwner = '$SMUser' WHERE idPPV = '$IDPPV'";
                $ruPPV = $cnx->query($uPPV);
                
                $vATipo = "Verde";
                $vAMensaje = "Permanent Added Successfully ...!";
                $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=vEdit&token=$gettoken";
                $vATime = 1000;
                //N echo $vRedirect;
                echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                
                break;
            case "Permanent":
                //subir files
                //Titulo, Size, Info, Alert
                $aGForm = array("Reason Permanent Notes", "60%", "", "");
                //Link, Title, target, class, $sI, SII, $sIII, $sIV, token, tokeni, tokenii
                $aLinks = array(
                    array("", "< Back", "", "linkr", "", "$sI", "$sII", "$sIII", "vEdit", "$gettoken", "", "")
                );
                
                
                //campos: action, label, id, class, tipo, name, value, checked, selected, focus  
                $aFields = array(
                    array("index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=s$sIV&token=$gettoken", "", "formx", "formx", "post", "addfile", "", "", "", ""),
                    array("", "Notes:", "notes", "atext", "textarea", "notes", "80|4", "", "", "1")
                );
                echo drawForm($aGForm, $aLinks, $aFields);
                //N sleep(50);
                break;
            case "sOneTime":
                $P_notes = $_POST['notes'];
                //Inserta Notes
                $LogM = "One Time Notes:\n$P_notes";
                //Inserta Log
                $sDesc = "INSERT INTO PPVLogs VALUES('0', '$IDPPV', '0', 'One Time', "
                        . "'$LogM', '$uIDUser', '$uFullName', '$uIDOwn', '$uOwn', '$dtAhora')";
                //N echo $sDesc . "<BR>";
                $isDesc = $cnx->query("$sDesc");
                
                //Actualiza el PPv
                // Anterior $uPPV = "UPDATE PPVs SET status = 'OneTime' WHERE idPPV = '$IDPPV'";RevCoverCost
                $uPPV = "UPDATE PPVs SET status = 'RevCoverCost', idUOwner = '$uidSupervisor' WHERE idPPV = '$IDPPV'";
                $ruPPV = $cnx->query($uPPV);
                $vATipo = "Verde";
                $vAMensaje = "OnTime Added Successfully ...!";
                $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=vEdit&token=$gettoken";
                $vATime = 1000;
                //N echo $vRedirect;
                echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                
                break;
            case "OneTime":
                //subir files
                //Titulo, Size, Info, Alert
                $aGForm = array("Reason One Time Notes", "60%", "", "");
                //Link, Title, target, class, $sI, SII, $sIII, $sIV, token, tokeni, tokenii
                $aLinks = array(
                    array("", "< Back", "", "linkr", "", "$sI", "$sII", "$sIII", "vEdit", "$gettoken", "", "")
                );
                
                
                //campos: action, label, id, class, tipo, name, value, checked, selected, focus  
                $aFields = array(
                    array("index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=s$sIV&token=$gettoken", "", "formx", "formx", "post", "addfile", "", "", "", ""),
                    array("", "Notes:", "notes", "atext", "textarea", "notes", "80|4", "", "", "1")
                );
                echo drawForm($aGForm, $aLinks, $aFields);
                //N sleep(50);
                break;
            case "sNQReject":
                $P_notes = $_POST['notes'];
                //Inserta Notes
                $LogM = "No Quotes Rejected:\n$P_notes";
                //Inserta Log
                $sDesc = "INSERT INTO PPVLogs VALUES('0', '$IDPPV', '2', 'Rejected (No Quotes)', "
                        . "'$LogM', '$uIDUser', '$uFullName', '$uIDOwn', '$uOwn', '$dtAhora')";
                //N echo $sDesc . "<BR>";
                $isDesc = $cnx->query("$sDesc");
                //Inserta autorizacion
                $iApproval = "UPDATE PPVApproval SET"
                        . " Status = 'Closed', dtClosed = '$dtAhora',"
                        . " iduApproval = '$uIDUser', uApproval = '$uFullName', uANotes = '$P_notes', Approval = 'Rejected'"
                        . " WHERE idPPV = '$IDPPV' AND Status = 'Open' AND TypeApproval = 'NQApproval'";
                $riApp = $cnx->query($iApproval);
                
                //Actualiza el PPv
                $uPPV = "UPDATE PPVs SET status = 'NQRejected' WHERE idPPV = '$IDPPV'";
                $ruPPV = $cnx->query($uPPV);
                
                $vATipo = "Verde";
                $vAMensaje = "Rejected Successfully ...!";
                $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=vEdit&token=$gettoken";
                $vATime = 1000;
                //N echo $vRedirect;
                echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                
                break;
            case "NQReject":
                //subir files
                //Titulo, Size, Info, Alert
                $aGForm = array("Reject (No Quotes)", "60%", "", "");
                //Link, Title, target, class, $sI, SII, $sIII, $sIV, token, tokeni, tokenii
                $aLinks = array(
                    array("", "< Back", "", "linkr", "", "$sI", "$sII", "$sIII", "vEdit", "$gettoken", "", "")
                );
                
                
                //campos: action, label, id, class, tipo, name, value, checked, selected, focus  
                $aFields = array(
                    array("index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=s$sIV&token=$gettoken", "", "formx", "formx", "post", "addfile", "", "", "", ""),
                    array("", "Notes:", "notes", "atext", "textarea", "notes", "80|4", "", "", "1")
                );
                echo drawForm($aGForm, $aLinks, $aFields);
                //N sleep(50);
                break;
            case "sNQApprove":
                $P_notes = $_POST['notes'];
                //Inserta Notes
                $LogM = "No Quotes Approved:\n$P_notes";
                //Inserta Log
                $sDesc = "INSERT INTO PPVLogs VALUES('0', '$IDPPV', '2', 'Approved (No Quotes)', "
                        . "'$LogM', '$uIDUser', '$uFullName', '$uIDOwn', '$uOwn', '$dtAhora')";
                //N echo $sDesc . "<BR>";
                $isDesc = $cnx->query("$sDesc");
                //Inserta autorizacion
                $iApproval = "UPDATE PPVApproval SET"
                        . " Status = 'Closed', dtClosed = '$dtAhora',"
                        . " iduApproval = '$uIDUser', uApproval = '$uFullName', uANotes = '$P_notes', Approval = 'Approved'"
                        . " WHERE idPPV = '$IDPPV' AND Status = 'Open' AND TypeApproval = 'NQApproval'";
                $riApp = $cnx->query($iApproval);
                
                //Actualiza el PPv
                $uPPV = "UPDATE PPVs SET status = 'NQApproved' WHERE idPPV = '$IDPPV'";
                $ruPPV = $cnx->query($uPPV);
                
                $vATipo = "Verde";
                $vAMensaje = "Approved Successfully ...!";
                $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=vEdit&token=$gettoken";
                $vATime = 1000;
                //N echo $vRedirect;
                echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                
                break;
            case "NQApprove":
                //subir files
                //Titulo, Size, Info, Alert
                $aGForm = array("Approve (No Quotes)", "60%", "", "");
                //Link, Title, target, class, $sI, SII, $sIII, $sIV, token, tokeni, tokenii
                $aLinks = array(
                    array("", "< Back", "", "linkr", "", "$sI", "$sII", "$sIII", "vEdit", "$gettoken", "", "")
                );
                
                
                //campos: action, label, id, class, tipo, name, value, checked, selected, focus  
                $aFields = array(
                    array("index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=s$sIV&token=$gettoken", "", "formx", "formx", "post", "addfile", "", "", "", ""),
                    array("", "Notes:", "notes", "atext", "textarea", "notes", "80|4", "", "", "1")
                );
                echo drawForm($aGForm, $aLinks, $aFields);
                //N sleep(50);
                break;
            case "ReqApprQuote":
                $LogM = "No Quotes Approval Request";
                //Inserta Log
                $sDesc = "INSERT INTO PPVLogs VALUES('0', '$IDPPV', '1', 'Request Approval (No Quotes)', "
                        . "'$LogM', '$uIDUser', '$uFullName', '$uIDOwn', '$uOwn', '$dtAhora')";
                //N echo $sDesc . "<BR>";
                $isDesc = $cnx->query("$sDesc");
                //Inserta autorizacion
                $iApproval = "INSERT INTO PPVApproval VALUES('0', '$IDPPV', 'NQApproval', '$uIDUser', "
                        . "'$uFullName', 'No Quotes Approval Request', '', '', '', '', 'Open', '$dtAhora', '$dtAhora')";
                $riApp = $cnx->query($iApproval);
                
                //Actualiza el PPv
                $uPPV = "UPDATE PPVs SET dtCreate = '$dtAhora', status = 'NQApproval', idUOwner = '$uidSupervisor' WHERE idPPV = '$IDPPV'";
                $ruPPV = $cnx->query($uPPV);
                
                $vATipo = "Verde";
                $vAMensaje = "No Quotes Appoval Request Successfully ...!";
                $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=vEdit&token=$gettoken";
                $vATime = 1000;
                //N echo $vRedirect;
                echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                break;
            case "sReqApprQuote_Ant":
                $P_notes = $_POST['notes'];
                //Inserta Notes
                $LogM = "No Quotes Approval Request:\n$P_notes";
                //Inserta Log
                $sDesc = "INSERT INTO PPVLogs VALUES('0', '$IDPPV', '1', 'Request Approval (No Quotes)', "
                        . "'$LogM', '$uIDUser', '$uFullName', '$uIDOwn', '$uOwn', '$dtAhora')";
                //N echo $sDesc . "<BR>";
                $isDesc = $cnx->query("$sDesc");
                //Inserta autorizacion
                $iApproval = "INSERT INTO PPVApproval VALUES('0', '$IDPPV', 'NQApproval', '$uIDUser', "
                        . "'$uFullName', '$P_notes', '', '', '', '', 'Open', '$dtAhora', '$dtAhora')";
                $riApp = $cnx->query($iApproval);
                
                //Actualiza el PPv
                $uPPV = "UPDATE PPVs SET dtCreate = '$dtAhora', status = 'NQApproval' WHERE idPPV = '$IDPPV'";
                $ruPPV = $cnx->query($uPPV);
                
                $vATipo = "Verde";
                $vAMensaje = "No Quotes Appoval Request Successfully ...!";
                $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=vEdit&token=$gettoken";
                $vATime = 1000;
                //N echo $vRedirect;
                echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                
                break;
            case "ReqApprQuote_Ant":
                //subir files
                //Titulo, Size, Info, Alert
                $aGForm = array("Request Approval (No Quotes)", "60%", "", "");
                //Link, Title, target, class, $sI, SII, $sIII, $sIV, token, tokeni, tokenii
                $aLinks = array(
                    array("", "< Back", "", "linkr", "", "$sI", "$sII", "$sIII", "vEdit", "$gettoken", "", "")
                );
                
                
                //campos: action, label, id, class, tipo, name, value, checked, selected, focus  
                $aFields = array(
                    array("index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=s$sIV&token=$gettoken", "", "formx", "formx", "post", "addfile", "", "", "", ""),
                    array("", "Notes:", "notes", "atext", "textarea", "notes", "80|4", "", "", "1")
                );
                echo drawForm($aGForm, $aLinks, $aFields);
                break;
            case "sAddPO":
                //Archivo
                $nombre_archivo = $_FILES['upo']['name']; 
		$tipo_archivo = $_FILES['upo']['type'];
		$linkfile = "PPVFiles/" . $nombre_archivo; 
                $gTitFile = $_POST['po'];
                
                $extension = strtolower(substr($nombre_archivo, strrpos($nombre_archivo, '.' )+1));
                
                //N echo $extension . "<br>" . $linkfile;
                
                if($gTitFile != ""){
                    //Sube el archivo
                    if (move_uploaded_file($_FILES['upo']['tmp_name'], $linkfile)){
                        $smid = "SELECT MAX(idFiles) AS mid FROM Files";
                        $rmid = $cnx->query("$smid")->fetchArray();
                        $ID = $rmid['mid'] + 1;
                        $filex = "PPV_" . $IDPPV . "_" . $ID . "." . $extension;
                        $link = "PPVFiles/" . $filex;
                        
                        copy($linkfile, $link);
                        unlink($linkfile);
                        //Actualiza el archivo
                        $siFile = "INSERT INTO Files VALUES("
                                . "'$ID', 'PPV_PO', '$IDPPV', '$link', '$gTitFile', "
                                . "'$uIDUser', '$uFullName', 'Active', '$dtAhora'"
                                . ")";
                        $iFile = $cnx->query("$siFile");
                        
                        $LogM = "PO Added ($ID - $gTitFile)";
                        //Inserta Log
                        $sDesc = "INSERT INTO PPVLogs VALUES('0', '$IDPPV', '0', 'PO Added', "
                                . "'$LogM', '$uIDUser', '$uFullName', '$uIDOwn', '$uOwn', '$dtAhora')";
                        //N echo $sDesc . "<BR>";
                        $isDesc = $cnx->query("$sDesc");
                        
                        $vATipo = "Verde";
                        $vAMensaje = "PO Added Successfully ...!";
                        $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=vEdit&token=$gettoken";
                        $vATime = 1000;
                        //N echo $vRedirect;
                        echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                        
                    } else {
                        $vATipo = "Rojo";
                        $vAMensaje = "Upload Error...!";
                        $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=vEdit&token=$gettoken";
                        $vATime = 1000;
                        //N echo $vRedirect;
                        echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                    }
                
                } else {
                    $vATipo = "Rojo";
                    $vAMensaje = "PO value invalid...!";
                    $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=vEdit&token=$gettoken";
                    $vATime = 1000;
                    //N echo $vRedirect;
                    echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                }
                break;
            case "AddPO":
                //Titulo, Size, Info, Alert
                $aGForm = array("Add $TFile", "60%", "", "");
                //Link, Title, target, class, $sI, SII, $sIII, $sIV, token, tokeni, tokenii
                $aLinks = array(
                    array("", "< Back", "", "linkr", "", "$sI", "$sII", "$sIII", "vEdit", "$gettoken", "", "")
                );
                
                
                //campos: action, label, id, class, tipo, name, value, checked, selected, focus  
                $aFields = array(
                    array("index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=s$sIV&token=$gettoken", "", "formx", "formx", "post", "addfile", " enctype='multipart/form-data' ", "", "", ""),
                    array("", "PO Number:", "po", "text", "text", "po", "", "", "", "1"),
                    array("", "PO File:", "upo", "text", "file", "upo", "", "", "", "")
                );
                echo drawForm($aGForm, $aLinks, $aFields);
                break;
            case "sAddQuote":
                //Archivo
                $nombre_archivo = $_FILES['ufile']['name']; 
		$tipo_archivo = $_FILES['ufile']['type'];
		$linkfile = "PPVFiles/" . $nombre_archivo; 
                $gTitFile = $_POST['title'];
                
                $extension = strtolower(substr($nombre_archivo, strrpos($nombre_archivo, '.' )+1));
                
                //N echo $extension . "<br>" . $linkfile;
                
                if($gTitFile != ""){
                    //Sube el archivo
                    if (move_uploaded_file($_FILES['ufile']['tmp_name'], $linkfile)){
                        $smid = "SELECT MAX(idFiles) AS mid FROM Files";
                        $rmid = $cnx->query("$smid")->fetchArray();
                        $ID = $rmid['mid'] + 1;
                        $filex = "PPV_" . $IDPPV . "_" . $ID . "." . $extension;
                        $link = "PPVFiles/" . $filex;
                        
                        copy($linkfile, $link);
                        unlink($linkfile);
                        //Actualiza el archivo
                        $siFile = "INSERT INTO Files VALUES("
                                . "'$ID', 'PPV_Q', '$IDPPV', '$link', '$gTitFile', "
                                . "'$uIDUser', '$uFullName', 'Active', '$dtAhora'"
                                . ")";
                        $iFile = $cnx->query("$siFile");
                        
                        $LogM = "Quote Added ($ID - $gTitFile)";
                        //Inserta Log
                        $sDesc = "INSERT INTO PPVLogs VALUES('0', '$IDPPV', '0', 'Quote Added', "
                                . "'$LogM', '$uIDUser', '$uFullName', '$uIDOwn', '$uOwn', '$dtAhora')";
                        //N echo $sDesc . "<BR>";
                        $isDesc = $cnx->query("$sDesc");
                        
                        $vATipo = "Verde";
                        $vAMensaje = "Quote Added Successfully ...!";
                        $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=vEdit&token=$gettoken";
                        $vATime = 1000;
                        //N echo $vRedirect;
                        echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                        
                    } else {
                        $vATipo = "Rojo";
                        $vAMensaje = "Upload Error...!";
                        $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=vEdit&token=$gettoken";
                        $vATime = 1000;
                        //N echo $vRedirect;
                        echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                    }
                
                } else {
                    $vATipo = "Rojo";
                    $vAMensaje = "Title value invalid...!";
                    $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=vEdit&token=$gettoken";
                    $vATime = 1000;
                    //N echo $vRedirect;
                    echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                }
                break;
            case "AddQuote":
                ?>
                <main>
                <center>
                <?php
                //SQL*SELECT IDUser AS valor, CONCAT(FLastName, MLastName, ", ", Name) AS opcion FROM Users ORDER BY FLastName ASC
                $FID = 15;
                $FLink = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=sAddQuote&token=$gettoken";
                echo Formato($FID, $FLink, $X, $vATime);
                ?>
                </center>
                </main>  
                <?php
                break;
            case "sAddQuoteNotes":
                $P_notes = $_POST['notes'];
                
                if(!empty($P_notes)){
                    $LogM = "$P_notes)";
                    //Inserta Log
                    $sDesc = "INSERT INTO PPVLogs VALUES('0', '$IDPPV', '0', 'Quote Notes Added', "
                            . "'$LogM', '$uIDUser', '$uFullName', '$uIDOwn', '$uOwn', '$dtAhora')";
                    //N echo $sDesc . "<BR>";
                    $isDesc = $cnx->query("$sDesc");

                    $vATipo = "Verde";
                    $vAMensaje = "Quote Added Successfully ...!";
                    $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=vEdit&token=$gettoken";
                    $vATime = 1000;
                    //N echo $vRedirect;
                    echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                    
                } else {
                    $vATipo = "Rojo";
                    $vAMensaje = "Quote Notes could not empty value ...!";
                    $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=vEdit&token=$gettoken";
                    $vATime = 1000;
                    //N echo $vRedirect;
                    echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                }
                
                //Inserta Notes
                $LogM = "Note Added:\n$P_notes";
                //Inserta Log
                $sDesc = "INSERT INTO PPVLogs VALUES('0', '$IDPPV', '3', 'Note Added', "
                        . "'$LogM', '$uIDUser', '$uFullName', '$uIDOwn', '$uOwn', '$dtAhora')";
                //N echo $sDesc . "<BR>";
                $isDesc = $cnx->query("$sDesc");
                
                
                
                break;
            case "AddQuoteNotes":
                //subir files
                //Titulo, Size, Info, Alert
                $aGForm = array("Add Quote Notes", "60%", "", "");
                //Link, Title, target, class, $sI, SII, $sIII, $sIV, token, tokeni, tokenii
                $aLinks = array(
                    array("", "< Back", "", "linkr", "", "$sI", "$sII", "$sIII", "vEdit", "$gettoken", "", "")
                );
                
                
                //campos: action, label, id, class, tipo, name, value, checked, selected, focus  
                $aFields = array(
                    array("index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=s$sIV&token=$gettoken", "", "formx", "formx", "post", "addfile", "", "", "", ""),
                    array("", "Quote Notes:", "notes", "atext", "textarea", "notes", "80|4", "", "", "1")
                );
                echo drawForm($aGForm, $aLinks, $aFields);
                //N sleep(50);
                break;
            case "sNoQuotes":
                $P_nqnotes = $_POST['notes'];
                
                if(!empty($P_nqnotes)){
                    $LogM = "$P_nqnotes)";
                    //Inserta Log
                    $sDesc = "INSERT INTO PPVLogs VALUES('0', '$IDPPV', '0', 'Quote Notes Added', "
                            . "'$LogM', '$uIDUser', '$uFullName', '$uIDOwn', '$uOwn', '$dtAhora')";
                    //N echo $sDesc . "<BR>";
                    $isDesc = $cnx->query("$sDesc");

                    //Actualiza el PPv
                    $uPPV = "UPDATE PPVs SET status = 'NQApproved' WHERE idPPV = '$IDPPV'";
                    $ruPPV = $cnx->query($uPPV);
                    
                    $vATipo = "Verde";
                    $vAMensaje = "No Quotes Added Successfully ...!";
                    $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=vEdit&token=$gettoken";
                    $vATime = 1000;
                    //N echo $vRedirect;
                    echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                    
                } else {
                    $vATipo = "Rojo";
                    $vAMensaje = "No Quote Notes could not empty value ...!";
                    $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=vEdit&token=$gettoken";
                    $vATime = 1000;
                    //N echo $vRedirect;
                    echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                }
                
                //Inserta Notes
                $LogM = "Note Added:\n$P_notes";
                //Inserta Log
                $sDesc = "INSERT INTO PPVLogs VALUES('0', '$IDPPV', '3', 'No Quotes Note Added', "
                        . "'$LogM', '$uIDUser', '$uFullName', '$uIDOwn', '$uOwn', '$dtAhora')";
                //N echo $sDesc . "<BR>";
                $isDesc = $cnx->query("$sDesc");
                
                
                
                break;
            case "NoQuotes":
                //subir files
                //Titulo, Size, Info, Alert
                $aGForm = array("No Quote Notes", "60%", "", "");
                //Link, Title, target, class, $sI, SII, $sIII, $sIV, token, tokeni, tokenii
                $aLinks = array(
                    array("", "< Back", "", "linkr", "", "$sI", "$sII", "$sIII", "vEdit", "$gettoken", "", "")
                );
                
                
                //campos: action, label, id, class, tipo, name, value, checked, selected, focus  
                $aFields = array(
                    array("index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=s$sIV&token=$gettoken", "", "formx", "formx", "post", "addfile", "", "", "", ""),
                    array("", "No Quotes Notes:", "notes", "atext", "textarea", "notes", "80|4", "", "", "1")
                );
                echo drawForm($aGForm, $aLinks, $aFields);
                //N sleep(50);
                break;
            case "sAddNote":
                $P_notes = $_POST['notes'];
                //Inserta Notes
                $LogM = "Note Added:\n$P_notes";
                //Inserta Log
                $sDesc = "INSERT INTO PPVLogs VALUES('0', '$IDPPV', '3', 'Note Added', "
                        . "'$LogM', '$uIDUser', '$uFullName', '$uIDOwn', '$uOwn', '$dtAhora')";
                //N echo $sDesc . "<BR>";
                $isDesc = $cnx->query("$sDesc");
                
                $vATipo = "Verde";
                $vAMensaje = "Note Added Successfully ...!";
                $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=vEdit&token=$gettoken";
                $vATime = 1000;
                //N echo $vRedirect;
                echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                
                break;
            case "AddNote":
                //subir files
                //Titulo, Size, Info, Alert
                $aGForm = array("Add Note", "60%", "", "");
                //Link, Title, target, class, $sI, SII, $sIII, $sIV, token, tokeni, tokenii
                $aLinks = array(
                    array("", "< Back", "", "linkr", "", "$sI", "$sII", "$sIII", "vEdit", "$gettoken", "", "")
                );
                
                
                //campos: action, label, id, class, tipo, name, value, checked, selected, focus  
                $aFields = array(
                    array("index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=s$sIV&token=$gettoken", "", "formx", "formx", "post", "addfile", "", "", "", ""),
                    array("", "Notes:", "notes", "atext", "textarea", "notes", "80|4", "", "", "1")
                );
                echo drawForm($aGForm, $aLinks, $aFields);
                //N sleep(50);
                break;
            default :
                echo "ERROR DEFAUL EditPPV";
                break;
        }
        break;
    case "Files":
        switch ($sIV){
            case "DeleteFile":
                $gIDFile = base64_decode($_GET['token']);
                
                $sFile = "SELECT * FROM TempFiles WHERE idFiles = '$gIDFile'";
                $rFile = $cnx->query($sFile)->fetchArray();
                $FLink = $rFile['Link'];
                $FTFile = $rFile['TFile'];
                
                $uFile = "UPDATE TempFiles SET Status = 'Deleted' WHERE idFiles = '$gIDFile'";
                $ruFile = $cnx->query($uFile);
                
                unlink($FLink);
                
                $vATipo = "Verde";
                $vAMensaje = "$FTFile deleted...!";
                $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=Home&token=$gettoken";
                $vATime = 1000;
                echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                
                break;
            case "sAddMRP":
            case "sAddOverIssue":
            case "sAddBOM":
            case "sAddPod":
            case "sAddParts":
            case "sAddPODemand":
            case "sAddInvD":
            case "sAddWOPlanner":

                $TFile = base64_decode($_GET['token']);
                $gettoken = base64_encode($TFile);
                $sIVx = substr($sIV, 1);
                //Sube el archivo
                //Archivo
                $nombre_archivo = $_FILES['ufile']['name']; 
		$tipo_archivo = $_FILES['ufile']['type'];
                $size_archivo = $_FILES['ufile']['size'];
		$linkfile = "TempFiles/" . $nombre_archivo; 
                $getfecha = $_POST['fecha'];
                
                //N echo $nombre_archivo . "- $size_archivo<BR>";
                $extension = strtolower(substr($nombre_archivo, strrpos($nombre_archivo, '.' )+1));
                //Busca si existe Open
                $sOpen = "SELECT idFiles FROM TempFiles WHERE TFile = '$TFile' AND Status = 'Open'";
                $nOpen = $cnx->query($sOpen)->numRows();
                
                if($nOpen == 0){
                    //N echo "EXT: $extension";
                    if($extension == "csv"){
                        //Sube el archivo
                        if (move_uploaded_file($_FILES['ufile']['tmp_name'], $linkfile)){
                            $smid = "SELECT MAX(idFiles) AS mid FROM TempFiles";
                            $rmid = $cnx->query("$smid")->fetchArray();
                            $ID = $rmid['mid'] + 1;
                            $filex = "$sIVx-" . $ID . "." . $extension;
                            $link = "TempFiles/" . $filex;

                            copy($linkfile, $link);
                            unlink($linkfile);
                            //Actualiza el archivo
                            $siFile = "INSERT INTO TempFiles VALUES("
                                    . "'$ID', '$TFile', '$link', '', "
                                    . "'$uIDUser', '$uFullName', 'Open', '$getfecha', '$dtAhora', '$dtAhora', '$dtAhora'"
                                    . ")";
                            $iFile = $cnx->query("$siFile");

                            $vATipo = "Verde";
                            $vAMensaje = "$TFile uploaded...!";
                            $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=Home&token=$gettoken";
                            $vATime = 1000;
                            echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);

                        } else {
                            $vATipo = "Rojo";
                            $vAMensaje = "File Transfer error...!";
                            $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=$sIVx&token=$gettoken";
                            $vATime = 3000;
                            echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                        }

                    } else {
                        $vATipo = "Rojo";
                        $vAMensaje = "$TFile format invalid...!";
                        $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=$sIVx&token=$gettoken";
                        $vATime = 3000;
                        //for redirect echo $vRedirect;
                        echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                    }
                } else {
                    $vATipo = "Rojo";
                    $vAMensaje = "$TFile already exist...!";
                    $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=$sIVx&token=$gettoken";
                    $vATime = 3000;
                    //for redirect echo $vRedirect;
                    echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                }
                
                break;
            case "AddMRP":
            case "AddOverIssue":
            case "AddBOM":
            case "AddPod":
            case "AddParts":
            case "AddPODemand":
            case "AddInvD":
            case "AddWOPlanner":
                
                switch ($sIV){
                    case "AddOverIssue":
                        $TFile = "OverIssue";
                        break;
                    case "AddBOM":
                        $TFile = "BOMFile";
                        break;
                    case "AddMRP":
                        $TFile = "MRPFile";
                        break;
                    case "AddPod":
                        $TFile = "PodFile";
                        break;
                    case "AddParts":
                        $TFile = "PartsFile";
                        break;
                    case "AddPODemand":
                        $TFile = "PODemand";
                        break;
                    case "AddInvD":
                        $TFile = "InvDetail";
                        break;
                    case "AddWOPlanner":
                        $TFile = "WOPlanner";
                        break;
                }
                
                echo $sIV . "<BR>";
                
                $gettoken = base64_encode($TFile);
                
                //subir files
                //Titulo, Size, Info, Alert
                $aGForm = array("Add $TFile", "60%", "", "");
                //Link, Title, target, class, $sI, SII, $sIII, $sIV, token, tokeni, tokenii
                $aLinks = array(
                    array("", "< Back", "", "linkr", "", "$sI", "$sII", "$sIII", "Home", "", "", "")
                );
                
                if($sIV == "AddBOM"){
                    //echo "OK";
                    $aLinks[] = array("Include/reportCSV.php?report=BOM", "[*] Download BOM", "", "linkr", "", "$sI", "$sII", "$sIII", "Home", "", "", "");
                }
                
                //campos: action, label, id, class, tipo, name, value, checked, selected, focus  
                $aFields = array(
                    array("index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=s$sIV&token=$gettoken", "", "formx", "formx", "post", "addfile", " enctype='multipart/form-data' ", "", "", ""),
                    array("", "$TFile (CSV-MSDOS):", "ufile", "text", "file", "ufile", "", "", "", "1"),
                    array("", "Date Report:", "fecha", "text", "date", "fecha", "$dateToday", "", "", "")
                );
                echo drawForm($aGForm, $aLinks, $aFields);
                
                break;
            case "Home":
                //Titulo, Size, Info, Alert, Search, DataSearch
                $aGList = array("PPV Files Control", "60%", "", "", "0", "xxx");
                
                $aLinks = array(
                    array("", "[+] Open Pod", "", "linkr", "", "$sI", "$sII", "Files", "AddPod", "", "", ""),
                    array("", "[+] Parts", "", "linkr", "", "$sI", "$sII", "Files", "AddParts", "", "", ""),
                    array("", "[+] OverIssue", "", "linkr", "", "$sI", "$sII", "Files", "AddOverIssue", "", "", ""),
                    array("", "[+] PO Demand", "", "linkr", "", "$sI", "$sII", "Files", "AddPODemand", "", "", ""),
                    array("", "[+] MRP", "", "linkr", "", "$sI", "$sII", "Files", "AddMRP", "", "", ""),
                    array("", "[+] Inv Detail", "", "linkr", "", "$sI", "$sII", "Files", "AddInvD", "", "", ""),
                    array("", "[+] WO Planner", "", "linkr", "", "$sI", "$sII", "Files", "AddWOPlanner", "", "", ""),
                    array("", "[+] BOM", "", "linkr", "", "$sI", "$sII", "Files", "AddBOM", "", "", "")
                );
                
                if(isset($_GET['search'])){
                    if($_GET['search'] == 1){
                        $frase = $_POST['search'];
                        $lfrase = "%$frase%";
                        $LRows = $cnx->query('SELECT MobileNumber AS IDUser, MobileNumber AS Celular, CONCAT(FLastName, \', \', Name) AS Nombre FROM Users WHERE (MobileNumber LIKE ? OR Name LIKE ? OR FLastName LIKE ? OR MLastName LIKE ?) AND IDUser != ? ORDER BY FLastName ASC', $lfrase, $lfrase, $lfrase, $lfrase, '1')->fetchAll();
                    }

                } else {
                    $LQry = "SELECT * FROM TempFiles WHERE Status = 'Open' OR Status = 'Updated' OR Status = 'Runing' ORDER BY dtCreated DESC LIMIT 0, 30";
                }
                
                $aColumns = array(
                    array("", "tr_class", "tit_col_center", "#", "tit_col_center", "+", "tit_col_center", "File", "tit_col_center", "User", "tit_col_center", "Date", "tit_col_center", "Status")
                );
                $LRows = $cnx->query("$LQry")->fetchAll();
                foreach ($LRows as &$LRowsx) {
                    $count++;
                    $countr++;

                    $getidFile = $LRowsx['idFiles'];
                    $getFile = $LRowsx['TFile'];
                    $getLink = $LRowsx['Link'];
                    $getUser = $LRowsx['UserCreated'];
                    $getStatus = $LRowsx['Status'];
                    $getdtCreated = $LRowsx['dtCreated'];
                    $getdtProcessed = $LRowsx['dtProcessed'];
                    
                    if($countr == 2){
                        $bcolor = "#E7E7E7";
                        $countr = 0;
                    } else {
                        $bcolor = "#FFFFFF";
                    }
                    
                    $gettoken = base64_encode($getidFile);
                    
                    $goptions = "";
                    
                    //Depende Status
                    switch ($getStatus){
                        case "Open":
                            //Delete
                            $goptions .= "<a href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=DeleteFile&token=$gettoken&tokeni=$gettokeni&tokenii=$gettokenii'"
                                . " target='_self' title='Eliminar $getFile'>"
                                . "<img src='Images/Trash.svg' title='Eliminar $getFile' width='16' border='0'></a>";
                            //Download
                            $goptions .= "<a href='$getLink'"
                                . " target='_blank' title='Download $getFile'>"
                                . "<img src='Images/xls.svg' title='Download $getFile' width='16' border='0'></a>";
                            break;
                        case "Updated":
                            //Download
                            $goptions .= "<a href='$getLink'"
                                . " target='_blank' title='Download $getFile'>"
                                . "<img src='Images/xls.svg' title='Download $getFile' width='16' border='0'></a>";
                            break;
                        case "Runing":
                            //Solo si ya tiene una hora corriendo
                            $dtP1h = date('Y-m-d H:i:s', strtotime('+1 hours', strtotime($getdtProcessed)));
                            echo "<BR><BR><BR>" . $getdtProcessed . "<BR>" . $dtP1h . "<BR>";
                            
                            if(strtotime($dtAhora) > strtotime($dtP1h)){
                                echo "<BR>Borrar";
                                //Delete
                                $goptions .= "<a href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=DeleteFile&token=$gettoken&tokeni=$gettokeni&tokenii=$gettokenii'"
                                    . " target='_self' title='Eliminar $getFile'>"
                                    . "<img src='Images/Trash.svg' title='Eliminar $getFile' width='16' border='0'></a>";
                            } else {
                                echo "<BR>Actual";
                            }
                            
                            
                            break;
                        default :
                            break;
                    }
                    
                    
                    $aColumns[] = array("$bcolor", "", "col_center", "$count", "col_center", "$goptions", "col_center", "$getFile", "col_center", "$getUser", "col_center", "$getdtCreated", "col_center", "$getStatus");
                    
                    
                }
                
                echo drawList($aGList, $aLinks, $aColumns);
                
                break;
            default :
                break;
        }
        
        break;
    case "Home":
        switch ($sIV){
            case "Home":
            case "Closed":
                $gOrden = $_GET['order'];
                $aLinks = array(
                    array("", "Files", "", "linkr", "", "$sI", "$sII", "Files", "Home", "", "", ""),
                );
                
                switch ($sIV){
                    case "Home":
                        //Titulo, Size, Info, Alert, Search, DataSearch
                        $aGList = array("Pendings PPV", "80%", "", "", "1", "PO, PartNumber");
                        
                        if(isset($_GET['search'])){
                            if($_GET['search'] == 1){
                                $frase = $_POST['search'];
                                
                                $lfrase = "%$frase%";
                                $LQry = "SELECT * FROM PPVs WHERE "
                                        . "(Part_Nbr LIKE '%$frase%' OR Purch_Order_Number LIKE '$frase' OR keyPPV LIKE '$frase' OR Buyer = '$frase') AND"
                                        . " Status != 'Closed' AND Status != 'DraftPPV' ORDER BY idPPV ASC";
                                //N $LRows = $cnx->query('SELECT MobileNumber AS IDUser, MobileNumber AS Celular, CONCAT(FLastName, \', \', Name) AS Nombre FROM Users WHERE (MobileNumber LIKE ? OR Name LIKE ? OR FLastName LIKE ? OR MLastName LIKE ?) AND IDUser != ? ORDER BY FLastName ASC', $lfrase, $lfrase, $lfrase, $lfrase, '1')->fetchAll();
                            }

                        } else {
                            $LQry = "SELECT * FROM PPVs WHERE Status != 'Closed' AND Status != 'DraftPPV' ORDER BY idPPV ASC";
                        }
                        break;
                    case "Closed":
                        //Titulo, Size, Info, Alert, Search, DataSearch
                        $aGList = array("Closed PPV", "80%", "", "", "1", "PO, PartNumber");
                
                        if(isset($_GET['search'])){
                            if($_GET['search'] == 1){
                                $frase = $_POST['search'];
                                $lfrase = "%$frase%";
                                $LQry = "SELECT * FROM PPVs WHERE "
                                        . "(Part_Nbr LIKE '$frase' OR Purch_Order_Number LIKE '$frase' OR keyPPV LIKE '$frase') AND"
                                        . " Status = 'Closed' AND Status != 'DraftPPV' ORDER BY idPPV ASC";
                                //N $LRows = $cnx->query('SELECT MobileNumber AS IDUser, MobileNumber AS Celular, CONCAT(FLastName, \', \', Name) AS Nombre FROM Users WHERE (MobileNumber LIKE ? OR Name LIKE ? OR FLastName LIKE ? OR MLastName LIKE ?) AND IDUser != ? ORDER BY FLastName ASC', $lfrase, $lfrase, $lfrase, $lfrase, '1')->fetchAll();
                            }

                        } else {
                            $LQry = "SELECT * FROM PPVs WHERE Status = 'Closed' AND Status != 'DraftPPV' ORDER BY idPPV ASC";
                        }
                        break;
                }
                if(!empty($gOrden)){
                    
                } else {
                    $orderst = "<a href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=$sIV&token=$gettoken&tokeni=$gettokeni&tokenii=$gettokenii&order=Status_DESC' title='Status Order'><img src='Images/Sort.svg' border='0' width='16'></a>";
                    $orderimp = "<a href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=$sIV&token=$gettoken&tokeni=$gettokeni&tokenii=$gettokenii&order=Impact_DESC' title='Impact Order'><img src='Images/Sort.svg' border='0' width='16'></a>";
                    $orderbcode = "<a href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=$sIV&token=$gettoken&tokeni=$gettokeni&tokenii=$gettokenii&order=Status_DESC' title='Status Order'><img src='Images/Sort.svg' border='0' width='16'></a>";
                    $orderpo = "<a href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=$sIV&token=$gettoken&tokeni=$gettokeni&tokenii=$gettokenii&order=PO_DESC' title='PO Order'><img src='Images/Sort.svg' border='0' width='16'></a>";
                
                }
                
                $aColumns = array(
                    array("", "tr_class", "tit_col_center", "#", "tit_col_center", "+", "tit_col_center", "BCode", "tit_col_center", "PPV", "tit_col_center", "NParte", "tit_col_center", "$orderpo PO", "tit_col_center", "ClassCode", "tit_col_center", "Vendor", "tit_col_center", "$orderimp Impact", "tit_col_center", "$orderst Status")
                );
                $LRows = $cnx->query("$LQry")->fetchAll();
                foreach ($LRows as &$LRowsx) {
                    $count++;
                    $countr++;

                    $getidPPV = $LRowsx['idPPV'];
                    $getPPV = $LRowsx['keyPPV'];
                    $getNParte = $LRowsx['Part_Nbr'];
                    $getPO = $LRowsx['Purch_Order_Number'];
                    $getClassCode = $LRowsx['Class_Code'];
                    $getVendor = $LRowsx['Vendor_Name'];
                    $getStatus = $LRowsx['Status'];
                    $getImpact = $LRowsx['ImpactValue'];
                    $getBCode = $LRowsx['Buyer'];
                    
                    if($getImpact < 0){
                        $cImpact = "col_center_green";
                    } else {
                        $cImpact = "col_center_red";
                    }
                    
                    if($countr == 2){
                        $bcolor = "#E7E7E7";
                        $countr = 0;
                    } else {
                        $bcolor = "#FFFFFF";
                    }
                    
                    $gettoken = base64_encode($getidPPV);
                    
                    $goptions = "";
                    //N$count = "$count - $uAccount";
                    
                    $goptions .= "<a href='index.php?sI=$sI&sII=$sII&sIII=EditPPV&sIV=vEdit&token=$gettoken&tokeni=$gettokeni&tokenii=$gettokenii'"
                        . " target='_self' title='Edit $getPPV'>"
                        . "<img src='Images/Edit.svg' title='Edit $getPPV' width='16' border='0'></a>";
                    
                    
                    $aColumns[] = array("$bcolor", "", "col_center", "$count", "col_center", "$goptions", "col_center", "$getBCode", "col_center", "$getPPV", "col_center", "$getNParte", "col_center", "$getPO", "col_center", "$getClassCode", "col_center", "$getVendor", "$cImpact", "$getImpact", "col_center", "$getStatus");
                    
                    
                }
                
                echo drawList($aGList, $aLinks, $aColumns);
                
                break;
        }
        break;
    default :
        break;
}