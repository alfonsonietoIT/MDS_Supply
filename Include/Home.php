<?php
switch ($sIII){
    case "Hold":
        switch ($sIV){
            case "sAddMessage":
                if(empty($getidWarehouse)){
                    $getControl = base64_decode($_GET['token']);
                    $getidWarehouse = base64_decode($_GET['tokeni']);
                }
                $gettoken = base64_encode($getControl);
                $gettokeni = base64_encode($getidWarehouse);
                
                $sIn = "SELECT * FROM WarehouseHold WHERE idWarehouse = '$getidWarehouse' AND Status = 'Hold' ORDER BY MWPartNumber ASC";
                $LRowsx = $cnxw->query($sIn)->fetchArray();
                $getidWHold  = $LRowsx['idWHold'];
                $getidWarehouse = $LRowsx['idWarehouse'];
                $getWKey = $LRowsx['WKey'];
                $getReason = $LRowsx['Reason'];
                $getPart = $LRowsx['MWPartNumber'];
                $getPO = $LRowsx['MWPO'];
                $getReasonComments = $LRowsx['Comments'];
                $getHoldOn = $LRowsx['dtHold'];
                $getHoldBy = $LRowsx['Owner'];
                $getControl = $LRowsx['NControl'];
                $getBuyer = $LRowsx['BuyerName'];
                $getStatus = $LRowsx['Status'];
                $getQty = $LRowsx['Qty'];
                $getVal = $LRowsx['Acctg_Value'];
                
                
                $TMessage = $_POST['comment'];
                
                //N echo "EXT: $extension";
                if(!empty($TMessage)){
                    //Sube el archivo
                    $smid = "SELECT MAX(idMessages) AS mid FROM Messages";
                    $rmid = $cnxw->query("$smid")->fetchArray();
                    $ID = $rmid['mid'] + 1;
                    //Actualiza el archivo
                    $siFile = "INSERT INTO Messages VALUES("
                            . "'$ID', 'Hold', '$getidWarehouse', '', '$TMessage', "
                            . "'$uIDUser', '$uFullName', 'Open', '$dtAhora'"
                            . ")";
                    $iFile = $cnxw->query("$siFile");


                    $vATipo = "Verde";
                    $vAMensaje = "Message Added Successfully ...!";
                    $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=MessageHold&token=$gettoken&tokeni=$gettokeni";
                    $vATime = 1000;
                    //N echo $vRedirect;
                    echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);

                } else {
                    $vATipo = "Rojo";
                    $vAMensaje = "$TMessage format invalid...!";
                    $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=AddMessage&token=$gettoken&tokeni=$gettokeni";
                    $vATime = 3000;
                    //for redirect echo $vRedirect;
                    echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                }
                
                
                break;
            case "AddMessage":
                if(empty($getidWarehouse)){
                    $getControl = base64_decode($_GET['token']);
                    $getidWarehouse = base64_decode($_GET['tokeni']);
                }
                $gettoken = base64_encode($getControl);
                $gettokeni = base64_encode($getidWarehouse);
                
                $sIn = "SELECT * FROM WarehouseHold WHERE idWarehouse = '$getidWarehouse' AND Status = 'Hold' ORDER BY MWPartNumber ASC";
                $LRowsx = $cnxw->query($sIn)->fetchArray();
                $getidWHold  = $LRowsx['idWHold'];
                $getidWarehouse = $LRowsx['idWarehouse'];
                $getWKey = $LRowsx['WKey'];
                $getReason = $LRowsx['Reason'];
                $getPart = $LRowsx['MWPartNumber'];
                $getPO = $LRowsx['MWPO'];
                $getReasonComments = $LRowsx['Comments'];
                $getHoldOn = $LRowsx['dtHold'];
                $getHoldBy = $LRowsx['Owner'];
                $getControl = $LRowsx['NControl'];
                $getBuyer = $LRowsx['BuyerName'];
                $getStatus = $LRowsx['Status'];
                $getQty = $LRowsx['Qty'];
                $getVal = $LRowsx['Acctg_Value'];
                
                $info = "<font class='Robss'>"
                    . "<font class='Robs' style='color:blue;'><B>$getWKey</B></font><br>"
                    . "<font class='Robs' style='color:red;'><B>$getPart</B></font><br>"
                    . "PO: <B>$getPO</B></font>";
                
                $aGForm = array("Add File on Hold", "60%", "$info", "");
                //Link, Title, target, class, $sI, SII, $sIII, $sIV, token, tokeni, tokenii
                $aLinks = array(
                    array("", "< Back", "", "linkr", "", "$sI", "$sII", "$sIII", "MessageHold", "$gettoken", "$gettokeni", "")
                );

                $info = "";

                //campos: action, label, id, class, tipo, name, value, checked, selected, focus  
                $aFields = array(
                    array("index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=sAddMessage&token=$gettoken&tokeni=$gettokeni", "", "formx", "formx", "post", "addfile", " enctype='multipart/form-data' ", "", "", ""),
                    array("", "Comments:", "comment", "text", "textarea", "comment", "80|5", "", " required='required' ", "1")
                );
                echo drawForm($aGForm, $aLinks, $aFields);
                
                break;
            case "sAddFile":
                if(empty($getidWarehouse)){
                    $getControl = base64_decode($_GET['token']);
                    $getidWarehouse = base64_decode($_GET['tokeni']);
                }
                $gettoken = base64_encode($getControl);
                $gettokeni = base64_encode($getidWarehouse);
                
                $sIn = "SELECT * FROM WarehouseHold WHERE idWarehouse = '$getidWarehouse' AND Status = 'Hold' ORDER BY MWPartNumber ASC";
                $LRowsx = $cnxw->query($sIn)->fetchArray();
                $getidWHold  = $LRowsx['idWHold'];
                $getidWarehouse = $LRowsx['idWarehouse'];
                $getWKey = $LRowsx['WKey'];
                $getReason = $LRowsx['Reason'];
                $getPart = $LRowsx['MWPartNumber'];
                $getPO = $LRowsx['MWPO'];
                $getReasonComments = $LRowsx['Comments'];
                $getHoldOn = $LRowsx['dtHold'];
                $getHoldBy = $LRowsx['Owner'];
                $getControl = $LRowsx['NControl'];
                $getBuyer = $LRowsx['BuyerName'];
                $getStatus = $LRowsx['Status'];
                $getQty = $LRowsx['Qty'];
                $getVal = $LRowsx['Acctg_Value'];
                
                
                $TFile = $_POST['title'];
                //$sIVx = substr($sIV, 1);
                //Sube el archivo
                //Archivo
                $nombre_archivo = $_FILES['ufile']['name']; 
		$tipo_archivo = $_FILES['ufile']['type'];
                $size_archivo = $_FILES['ufile']['size'];
		$linkfile = "/var/www/html/Warehouse/ReportFiles/" . $nombre_archivo; 
                //N echo $nombre_archivo . "- $size_archivo<BR>";
                $extension = strtolower(substr($nombre_archivo, strrpos($nombre_archivo, '.' )+1));
                //Busca si existe Open
                
                //N echo "EXT: $extension";
                if(!empty($extension)){
                    //Sube el archivo
                    if (move_uploaded_file($_FILES['ufile']['tmp_name'], $linkfile)){
                        $smid = "SELECT MAX(idFiles) AS mid FROM Files";
                        $rmid = $cnxw->query("$smid")->fetchArray();
                        $ID = $rmid['mid'] + 1;
                        $filex = "Hold_" . $getidWarehouse . "_" . $ID . "." . $extension;
                        $link = "/var/www/html/Warehouse/ReportFiles/" . $filex;
                        $linkS = "ReportFiles/" . $filex;
                        
                        copy($linkfile, $link);
                        unlink($linkfile);
                        //Actualiza el archivo
                        $siFile = "INSERT INTO Files VALUES("
                                . "'$ID', 'Hold', '$getidWarehouse', '$linkS', '$TFile', "
                                . "'$uIDUser', '$uFullName', 'Open', '$dtAhora'"
                                . ")";
                        $iFile = $cnxw->query("$siFile");

                        
                        $vATipo = "Verde";
                        $vAMensaje = "File Added Successfully ...!";
                        $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=MessageHold&token=$gettoken&tokeni=$gettokeni";
                        $vATime = 1000;
                        //N echo $vRedirect;
                        echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);

                    } else {
                        $vATipo = "Rojo";
                        $vAMensaje = "File Transfer error...!";
                        $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=AddFile&token=$gettoken&tokeni=$gettokeni";
                        $vATime = 3000;
                        echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                    }

                } else {
                    $vATipo = "Rojo";
                    $vAMensaje = "$TFile format invalid...!";
                    $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=AddFile&token=$gettoken&tokeni=$gettokeni";
                    $vATime = 3000;
                    //for redirect echo $vRedirect;
                    echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                }
                
                
                break;
            case "AddFile":
                if(empty($getidWarehouse)){
                    $getControl = base64_decode($_GET['token']);
                    $getidWarehouse = base64_decode($_GET['tokeni']);
                }
                $gettoken = base64_encode($getControl);
                $gettokeni = base64_encode($getidWarehouse);
                
                $sIn = "SELECT * FROM WarehouseHold WHERE idWarehouse = '$getidWarehouse' AND Status = 'Hold' ORDER BY MWPartNumber ASC";
                $LRowsx = $cnxw->query($sIn)->fetchArray();
                $getidWHold  = $LRowsx['idWHold'];
                $getidWarehouse = $LRowsx['idWarehouse'];
                $getWKey = $LRowsx['WKey'];
                $getReason = $LRowsx['Reason'];
                $getPart = $LRowsx['MWPartNumber'];
                $getPO = $LRowsx['MWPO'];
                $getReasonComments = $LRowsx['Comments'];
                $getHoldOn = $LRowsx['dtHold'];
                $getHoldBy = $LRowsx['Owner'];
                $getControl = $LRowsx['NControl'];
                $getBuyer = $LRowsx['BuyerName'];
                $getStatus = $LRowsx['Status'];
                $getQty = $LRowsx['Qty'];
                $getVal = $LRowsx['Acctg_Value'];
                
                $info = "<font class='Robss'>"
                    . "<font class='Robs' style='color:blue;'><B>$getWKey</B></font><br>"
                    . "<font class='Robs' style='color:red;'><B>$getPart</B></font><br>"
                    . "PO: <B>$getPO</B></font>";
                
                $aGForm = array("Add File on Hold", "60%", "$info", "");
                //Link, Title, target, class, $sI, SII, $sIII, $sIV, token, tokeni, tokenii
                $aLinks = array(
                    array("", "< Back", "", "linkr", "", "$sI", "$sII", "$sIII", "MessageHold", "$gettoken", "$gettokeni", "")
                );

                $info = "";

                //campos: action, label, id, class, tipo, name, value, checked, selected, focus  
                $aFields = array(
                    array("index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=sAddFile&token=$gettoken&tokeni=$gettokeni", "", "formx", "formx", "post", "addfile", " enctype='multipart/form-data' ", "", "", ""),
                    array("", "File Title:", "title", "text", "text", "title", "", "", "", "1"),
                    array("", "File:", "ufile", "text", "file", "ufile", "", "", "", "")
                );
                echo drawForm($aGForm, $aLinks, $aFields);
                
                break;
            case "MessageHold":
                if(empty($getidWarehouse)){
                    $getControl = base64_decode($_GET['token']);
                    $getidWarehouse = base64_decode($_GET['tokeni']);
                }
                $gettoken = base64_encode($getControl);
                $gettokeni = base64_encode($getidWarehouse);
                
                $sIn = "SELECT * FROM WarehouseHold WHERE idWarehouse = '$getidWarehouse' AND Status = 'Hold' ORDER BY MWPartNumber ASC";
                $LRowsx = $cnxw->query($sIn)->fetchArray();
                $getidWHold  = $LRowsx['idWHold'];
                $getidWarehouse = $LRowsx['idWarehouse'];
                $getWKey = $LRowsx['WKey'];
                $getReason = $LRowsx['Reason'];
                $getPart = $LRowsx['MWPartNumber'];
                $getPO = $LRowsx['MWPO'];
                $getReasonComments = $LRowsx['Comments'];
                $getHoldOn = $LRowsx['dtHold'];
                $getHoldBy = $LRowsx['Owner'];
                $getControl = $LRowsx['NControl'];
                $getBuyer = $LRowsx['BuyerName'];
                $getStatus = $LRowsx['Status'];
                $getQty = $LRowsx['Qty'];
                $getVal = $LRowsx['Acctg_Value'];
                
                
                if(isset($_GET['search'])){
                    if($_GET['search'] == 1){
                        $frase = $_POST['search'];

                        $getqry = "SELECT IdPPV, Priority, PPVName, Project, "
                            . "DATE(dtCreated) AS dtCreated, UserCreated, Status, PPVType "
                            . "FROM PPVs WHERE (Project LIKE '$frase' OR PPVName LIKE '%$frase%' "
                                . "OR IdPPV = '$frase' OR PPVType LIKE '$frase') AND Status = 'DraftPPV' ORDER BY dtCreated ASC";

                    }

                } else {
                    
                    $LQry = "SELECT * "
                        . "FROM Messages WHERE "
                        . "idApp = '$getidWarehouse' AND App = 'Hold'"
                        . "ORDER BY datetime DESC";




                }

                $aLinks = array(
                    array("", "[<] Back", "", "linkr", "", "$sI", "$sII", "Home", "Home", "", "", ""),
                    //array("Include/reportCSV.php?report=Hold&sea=$cfrase", "[_] Download", "_blank", "linkr", "", "", "", "Download", "", "", "", ""),
                    array("", "[+] Add Message", "", "linkr", "", "$sI", "$sII", "$sIII", "AddMessage", "$gettoken", "$gettokeni", ""),
                    array("", "[+] Add File", "", "linkr", "", "$sI", "$sII", "$sIII", "AddFile", "$gettoken", "$gettokeni", "")
                );
                
                $aColumns = array(
                    array("", "tr_class", "tit_col_center", "#", "tit_col_center", "+", "tit_col_center", "User", "tit_col_center", "Datetime", "tit_col_center", "Message")
                );
                
                $gTVal = 0;
                //echo $LQry;
                
                $LRows = $cnxw->query("$LQry")->fetchAll();
                foreach ($LRows as &$LRowsx) {
                    $count++;
                    $countr++;

                    $getidMessages  = $LRowsx['idMessages'];
                    $getNUser  = $LRowsx['NUser'];
                    $getdatetime  = $LRowsx['datetime'];
                    $getMessText  = $LRowsx['MessText'];
                    
                    
                    if($countr == 2){
                        $bcolor = "#E7E7E7";
                        $countr = 0;
                    } else {
                        $bcolor = "#FFFFFF";
                    }
                    
                    $gettoken = base64_encode($getControl);
                    $gettokeni = base64_encode($getidWarehouse);
                    
                    $goptions = "";
                    //N$count = "$count - $uAccount";
                    /*
                    $goptions .= "<a href='index.php?sI=$sI&sII=$sII&sIII=Hold&sIV=MessageHold&token=$gettoken&tokeni=$gettokeni&tokenii=$gettokenii'"
                        . " target='_self' title='Add Message'>"
                        . "<img src='Images/viewchat.svg' title='Add Message' width='16' border='0'></a> ";*/
                    //
                    $aColumns[] = array("$bcolor", "", "col_center", "$count", "col_center", "$goptions", "col_center", "$getNUser", "col_center", "$getdatetime", "col_center", "$getMessText");
                    
                    
                }
                
                $info = "<font class='Robss'>"
                    . "<font class='Robs' style='color:blue;'><B>$getWKey</B></font><br>"
                    . "<font class='Robs' style='color:red;'><B>$getPart</B></font><br>"
                    . "PO: <B>$getPO</B></font>";
                
                $aGList = array("Hold Parts", "80%", "$info", "", "0", "PartNumber, Control, Buyer, Reason");
                
                
                echo drawList($aGList, $aLinks, $aColumns);
                break;
        }
        break;
    case "Home":
        //Depende usuario
        switch ($uAccount){
            case "Admin":
            case "SuperUser":
                
                //Hold
                
                $aGList = array("Hold Material", "80%", "", "", "0", "PO, PartNumber");
                //Data
                
                if(isset($_GET['search'])){
                    if($_GET['search'] == 1){
                        $frase = $_POST['search'];

                        $LQry = "SELECT * "
                        . "FROM WarehouseHold WHERE "
                        . "Status = 'Hold' AND (WKey LIKE '%$frase' OR MWPartNumber LIKE '$frase%' OR MWCustomer LIKE '%$frase%') "
                        . "ORDER BY dtReceived ASC";

                    }

                } else {
                    
                    $LQry = "SELECT * "
                        . "FROM WarehouseHold WHERE "
                        . "Status = 'Hold' AND IDBuyer = '$uIDUser' "
                        . "ORDER BY dtReceived ASC";




                }

                $aLinks = array(
                    //array("", "[<] Back", "", "linkr", "", "$sI", "$sII", "Home", "Home", "", "", ""),
                    //array("Include/reportCSV.php?report=Hold&sea=$cfrase", "[_] Download", "_blank", "linkr", "", "", "", "Download", "", "", "", ""),
                    //array("", "[+] Add Hold Part", "", "linkr", "", "$sI", "$sII", "$sIII", "AddHoldPart", "$gettoken", "", "")
                );
                
                $aColumns = array(
                    array("", "tr_class", "tit_col_center", "#", "tit_col_center", "+", "tit_col_center", "Files", "tit_col_center", "idHold", "tit_col_center", "Control", "tit_col_center", "PO", "tit_col_center", "Part", "tit_col_center", "Qty",  "tit_col_center", "Value", "tit_col_center", "Reason", "tit_col_center", "Comments", "tit_col_center", "HoldBy", "tit_col_center", "Datetime")
                );
                
                $gTVal = 0;
                //echo $LQry;
                
                $LRows = $cnxw->query("$LQry")->fetchAll();
                foreach ($LRows as &$LRowsx) {
                    $count++;
                    $countr++;

                    $getidWHold  = $LRowsx['idWHold'];
                    $getidWarehouse = $LRowsx['idWarehouse'];
                    $getWKey = $LRowsx['WKey'];
                    $getReason = $LRowsx['Reason'];
                    $getPart = $LRowsx['MWPartNumber'];
                    $getPO = $LRowsx['MWPO'];
                    $getReasonComments = $LRowsx['Comments'];
                    $getHoldOn = $LRowsx['dtHold'];
                    $getHoldBy = $LRowsx['Owner'];
                    $getControl = $LRowsx['NControl'];
                    $getBuyer = $LRowsx['BuyerName'];
                    $getStatus = $LRowsx['Status'];
                    $getQty = $LRowsx['Qty'];
                    $getVal = $LRowsx['Acctg_Value'];
                    $getValx = $getQty*$getVal;
                    $gTVal += $getValx;
                    
                    if($getVal > 0){
                        $getValor = "$ " . number_format($getValx, 2);
                    } else {
                        $getValor = ""; 
                    }
                    
                    $getQty = number_format($getQty, 0);
                    
                    if($countr == 2){
                        $bcolor = "#E7E7E7";
                        $countr = 0;
                    } else {
                        $bcolor = "#FFFFFF";
                    }
                    
                    $gettoken = base64_encode($getControl);
                    $gettokeni = base64_encode($getidWarehouse);
                    
                    $goptions = "";
                    //N$count = "$count - $uAccount";
                    $goptions .= "<a href='index.php?sI=$sI&sII=$sII&sIII=Hold&sIV=MessageHold&token=$gettoken&tokeni=$gettokeni&tokenii=$gettokenii'"
                        . " target='_self' title='Add Message'>"
                        . "<img src='Images/viewchat.svg' title='Add Message' width='16' border='0'></a> ";
                    //
                    $getAttachments = "";
                    //Busca files
                    $sFiles = "SELECT * FROM Files WHERE App = 'Hold' AND idApp = '$getidWarehouse'";
                    $nFiles = $cnxw->query($sFiles)->numRows();
                    
                    if($nFiles > 0){
                        $rFiles = $cnx->query($sFiles)->fetchAll();
                        
                        foreach ($rFiles AS &$rF){
                            $gLinkF = "../Warehouse/" . $rF['FLink'];
                            $gFTitle = $rF['FTitle'];
                            $getAttachments .= "<a href='$gLinkF'"
                                . " target='_blank' title='$gFTitle'>"
                                . "<img src='Images/files.svg' title='$gFTitle' width='16' border='0'></a> ";
                        }
                        
                    }
                    /*
                    $getAttachments .= "<a href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=AddFileHold&token=$gettoken&tokeni=$gettokeni&tokenii=$gettokenii'"
                                . " target='_self' title='Add File'>"
                                . "<img src='Images/Upload.svg' title='Add File' width='16' border='0'></a> ";
                    */
                    
                    $getBuyerX = $EditOwn . $getBuyer;
                    
                    $aColumns[] = array("$bcolor", "", "col_center", "$count", "col_center", "$goptions", "col_center", "$getAttachments", "col_center", "$getWKey", "col_center", "$getControl", "col_center", "$getPO", "col_center", "$getPart", "col_right", "$getQty", "col_right", "$getValor", "col_center", "$getReason", "col_center", "$getReasonComments", "col_center", "$getHoldBy", "col_center", "$getHoldOn");
                    
                    
                }
                
                $gTotal = number_format($gTVal, 2);
                $info = "<font class='Robs'>Total value: <font style='color:red'><b>$ $gTotal</b></font></font>";
                
                $aGList = array("Hold Parts", "80%", "$info", "", "1", "PartNumber");
                
                
                echo drawList($aGList, $aLinks, $aColumns);
                
                
                /*
                
                $aGList = array("Draft PPV Team Buyers", "80%", "", "", "0", "PO, PartNumber");
                //Data
                
                if(isset($_GET['search'])){
                    if($_GET['search'] == 1){
                        $frase = $_POST['search'];

                        $getqry = "SELECT IdPPV, Priority, PPVName, Project, "
                            . "DATE(dtCreated) AS dtCreated, UserCreated, Status, PPVType "
                            . "FROM PPVs WHERE (Project LIKE '$frase' OR PPVName LIKE '%$frase%' "
                                . "OR IdPPV = '$frase' OR PPVType LIKE '$frase') AND Status = 'DraftPPV' ORDER BY dtCreated ASC";

                    }

                } else {
                    
                    $getqry = "SELECT * "
                        . "FROM PPVs WHERE "
                        . "Status = 'DraftPPV' "
                        . "ORDER BY dtAdded ASC";




                }

                //echo $getqry;

                $aColumns = array(
                    array("", "tr_class", "tit_col_center", "#", "tit_col_center", "+", "tit_col_center", "BCode", "tit_col_center", "PPV", "tit_col_center", "NParte", "tit_col_center", "$orderpo PO", "tit_col_center", "ClassCode", "tit_col_center", "Vendor", "tit_col_center", "$orderimp Impact", "tit_col_center", "$orderst Status")
                );
                $LRows = $cnx->query("$getqry")->fetchAll();
                foreach ($LRows as &$LRowsx) {
                    $count++;
                    $countr++;

                    $getidPPV = $LRowsx['idPPV'];
                    $getPPV = $LRowsx['keyPPV'];
                    $getNParte = $LRowsx['Part_Nbr'];
                    $getPO = $LRowsx['Purch_Order_Number'];
                    $getStatus = $LRowsx['Status'];
                    $getImpact = $LRowsx['ImpactValue'];
                    $getBCode = $LRowsx['Buyer'];
                    $getClassCode = $LRowsx['Class_Code'];
                    $getVendor = $LRowsx['Vendor_Name'];


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

                    $goptions .= "<a href='index.php?sI=$sI&sII=PPV&sIII=EditPPV&sIV=vEdit&token=$gettoken&tokeni=$gettokeni&tokenii=$gettokenii'"
                        . " target='_self' title='Edit $getPPV'>"
                        . "<img src='Images/Edit.svg' title='Edit $getPPV' width='16' border='0'></a>";
                    
                    $goptions .= "<a href='index.php?sI=$sI&sII=PPV&sIII=rDeleteDraft&sIV=Home&token=$gettoken&tokeni=$gettokeni&tokenii=$gettokenii'"
                        . " target='_self' title='Delete $getPPV'>"
                        . "<img src='Images/Trash.svg' title='Delete $getPPV' width='16' border='0'></a>";


                    $aColumns[] = array("$bcolor", "", "col_center", "$count", "col_center", "$goptions", "col_center", "$getBCode", "col_center", "$getPPV", "col_center", "$getNParte", "col_center", "$getPO", "col_center", "$getClassCode", "col_center", "$getVendor", "$cImpact", "$getImpact", "col_center", "$getStatus");


                }

                echo drawList($aGList, $aLinks, $aColumns);
                */
                
                break;
            case "Buyer":
                //Hold
                
                $aGList = array("Hold Material", "80%", "", "", "0", "PO, PartNumber");
                //Data
                
                if(isset($_GET['search'])){
                    if($_GET['search'] == 1){
                        $frase = $_POST['search'];

                        $LQry = "SELECT * "
                        . "FROM WarehouseHold WHERE "
                        . "Status = 'Hold' AND IDBuyer = '$uIDUser' AND (idWarehouse = '$frase' OR MWPartNumber LIKE '$frase%' OR MWCustomer LIKE '%$frase%') "
                        . "ORDER BY dtReceived ASC";

                    }

                } else {
                    
                    $LQry = "SELECT * "
                        . "FROM WarehouseHold WHERE "
                        . "Status = 'Hold' AND IDBuyer = '$uIDUser' "
                        . "ORDER BY dtReceived ASC";




                }

                $aLinks = array(
                    //array("", "[<] Back", "", "linkr", "", "$sI", "$sII", "Home", "Home", "", "", ""),
                    //array("Include/reportCSV.php?report=Hold&sea=$cfrase", "[_] Download", "_blank", "linkr", "", "", "", "Download", "", "", "", ""),
                    //array("", "[+] Add Hold Part", "", "linkr", "", "$sI", "$sII", "$sIII", "AddHoldPart", "$gettoken", "", "")
                );
                
                $aColumns = array(
                    array("", "tr_class", "tit_col_center", "#", "tit_col_center", "+", "tit_col_center", "Files", "tit_col_center", "idHold", "tit_col_center", "Control", "tit_col_center", "PO", "tit_col_center", "Part", "tit_col_center", "Qty",  "tit_col_center", "Value", "tit_col_center", "Reason", "tit_col_center", "Comments", "tit_col_center", "HoldBy", "tit_col_center", "Datetime")
                );
                
                $gTVal = 0;
                //echo $LQry;
                
                $LRows = $cnxw->query("$LQry")->fetchAll();
                foreach ($LRows as &$LRowsx) {
                    $count++;
                    $countr++;

                    $getidWHold  = $LRowsx['idWHold'];
                    $getidWarehouse = $LRowsx['idWarehouse'];
                    $getWKey = $LRowsx['WKey'];
                    $getReason = $LRowsx['Reason'];
                    $getPart = $LRowsx['MWPartNumber'];
                    $getPO = $LRowsx['MWPO'];
                    $getReasonComments = $LRowsx['Comments'];
                    $getHoldOn = $LRowsx['dtHold'];
                    $getHoldBy = $LRowsx['Owner'];
                    $getControl = $LRowsx['NControl'];
                    $getBuyer = $LRowsx['BuyerName'];
                    $getStatus = $LRowsx['Status'];
                    $getQty = $LRowsx['Qty'];
                    $getVal = $LRowsx['Acctg_Value'];
                    $getValx = $getQty*$getVal;
                    $gTVal += $getValx;
                    
                    if($getVal > 0){
                        $getValor = "$ " . number_format($getValx, 2);
                    } else {
                        $getValor = ""; 
                    }
                    
                    $getQty = number_format($getQty, 0);
                    
                    if($countr == 2){
                        $bcolor = "#E7E7E7";
                        $countr = 0;
                    } else {
                        $bcolor = "#FFFFFF";
                    }
                    
                    $gettoken = base64_encode($getControl);
                    $gettokeni = base64_encode($getidWarehouse);
                    
                    $goptions = "";
                    //N$count = "$count - $uAccount";
                    $goptions .= "<a href='index.php?sI=$sI&sII=$sII&sIII=Hold&sIV=MessageHold&token=$gettoken&tokeni=$gettokeni&tokenii=$gettokenii'"
                        . " target='_self' title='Add Message'>"
                        . "<img src='Images/viewchat.svg' title='Add Message' width='16' border='0'></a> ";
                    //
                    $getAttachments = "";
                    //Busca files
                    $sFiles = "SELECT * FROM Files WHERE App = 'Hold' AND idApp = '$getidWarehouse'";
                    $nFiles = $cnxw->query($sFiles)->numRows();
                    
                    if($nFiles > 0){
                        $rFiles = $cnx->query($sFiles)->fetchAll();
                        
                        foreach ($rFiles AS &$rF){
                            $gLinkF = "../Warehouse/" . $rF['FLink'];
                            $gFTitle = $rF['FTitle'];
                            $getAttachments .= "<a href='$gLinkF'"
                                . " target='_blank' title='$gFTitle'>"
                                . "<img src='Images/files.svg' title='$gFTitle' width='16' border='0'></a> ";
                        }
                        
                    }
                    /*
                    $getAttachments .= "<a href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=AddFileHold&token=$gettoken&tokeni=$gettokeni&tokenii=$gettokenii'"
                                . " target='_self' title='Add File'>"
                                . "<img src='Images/Upload.svg' title='Add File' width='16' border='0'></a> ";
                    */
                    
                    $getBuyerX = $EditOwn . $getBuyer;
                    
                    $aColumns[] = array("$bcolor", "", "col_center", "$count", "col_center", "$goptions", "col_center", "$getAttachments", "col_center", "$getWKey", "col_center", "$getControl", "col_center", "$getPO", "col_center", "$getPart", "col_right", "$getQty", "col_right", "$getValor", "col_center", "$getReason", "col_center", "$getReasonComments", "col_center", "$getHoldBy", "col_center", "$getHoldOn");
                    
                    
                }
                
                $gTotal = number_format($gTVal, 2);
                $info = "<font class='Robs'>Total value: <font style='color:red'><b>$ $gTotal</b></font></font>";
                
                $aGList = array("Hold Parts", "80%", "$info", "", "0", "PartNumber, Control, Buyer, Reason");
                
                
                echo drawList($aGList, $aLinks, $aColumns);
                //Termina Hold
                
                
                $aGList = array("Draft PPV Team Buyers", "80%", "", "", "0", "PO, PartNumber");
                //Data
                
                if(isset($_GET['search'])){
                    if($_GET['search'] == 1){
                        $frase = $_POST['search'];

                        $getqry = "SELECT IdPPV, Priority, PPVName, Project, "
                            . "DATE(dtCreated) AS dtCreated, UserCreated, Status, PPVType "
                            . "FROM PPVs WHERE (Project LIKE '$frase' OR PPVName LIKE '%$frase%' "
                                . "OR IdPPV = '$frase' OR PPVType LIKE '$frase') AND Status = 'DraftPPV' ORDER BY dtCreated ASC";

                    }

                } else {
                    
                    $getqry = "SELECT * "
                        . "FROM PPVs WHERE "
                        . "Status = 'DraftPPV' AND idUOwner = '$uIDUser' "
                        . "ORDER BY dtAdded ASC";




                }

                //echo $getqry;

                $aColumns = array(
                    array("", "tr_class", "tit_col_center", "#", "tit_col_center", "+", "tit_col_center", "BCode", "tit_col_center", "PPV", "tit_col_center", "NParte", "tit_col_center", "$orderpo PO", "tit_col_center", "ClassCode", "tit_col_center", "Vendor", "tit_col_center", "$orderimp Impact", "tit_col_center", "$orderst Status")
                );
                $LRows = $cnx->query("$getqry")->fetchAll();
                foreach ($LRows as &$LRowsx) {
                    $count++;
                    $countr++;

                    $getidPPV = $LRowsx['idPPV'];
                    $getPPV = $LRowsx['keyPPV'];
                    $getNParte = $LRowsx['Part_Nbr'];
                    $getPO = $LRowsx['Purch_Order_Number'];
                    $getStatus = $LRowsx['Status'];
                    $getImpact = $LRowsx['ImpactValue'];
                    $getBCode = $LRowsx['Buyer'];
                    $getClassCode = $LRowsx['Class_Code'];
                    $getVendor = $LRowsx['Vendor_Name'];


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
                    
                    $goptions .= "<a href='index.php?sI=$sI&sII=PPV&sIII=EditPPV&sIV=vEdit&token=$gettoken&tokeni=$gettokeni&tokenii=$gettokenii'"
                        . " target='_self' title='Edit $getPPV'>"
                        . "<img src='Images/Edit.svg' title='Edit $getPPV' width='16' border='0'></a>";
                    $goptions .= "<a href='index.php?sI=$sI&sII=PPV&sIII=DeleteDraft&sIV=Home&token=$gettoken&tokeni=$gettokeni&tokenii=$gettokenii'"
                        . " target='_self' title='Delete $getPPV'>"
                        . "<img src='Images/Trash.svg' title='Delete $getPPV' width='16' border='0'></a>";


                    $aColumns[] = array("$bcolor", "", "col_center", "$count", "col_center", "$goptions", "col_center", "$getBCode", "col_center", "$getPPV", "col_center", "$getNParte", "col_center", "$getPO", "col_center", "$getClassCode", "col_center", "$getVendor", "$cImpact", "$getImpact", "col_center", "$getStatus");


                }

                echo drawList($aGList, $aLinks, $aColumns);
                break;
            case "Purchasing Leader":
                $aGList = array("Pendings PPV Team Buyers", "80%", "", "", "0", "PO, PartNumber");
                //Data
                $sData = "SELECT IDUser, IDExtra FROM Users WHERE idSupervisor = '$uIDUser' AND Account = 'Buyer'";
                $lData = $cnx->query($sData)->fetchAll();
                
                $Bys = "";
                $byer = "";
                
                foreach ($lData as &$rData) {
                    //User
                    $byx = $rData['IDUser'];
                    $bye = strtoupper($rData['IDExtra']);
                    
                    $byer = explode(",", $bye);
                    
                    foreach ($byer AS &$dbyer){
                        if(substr($dbyer, 0, 1) == "B"){
                            $Bys .= " Buyer = '$dbyer' OR ";
                        }
                    }
                    
                    
                    
                }
                
                if(!empty($Bys)){
                    $Bys = substr($Bys, 0, -4);
                }
                
                if(isset($_GET['search'])){
                    if($_GET['search'] == 1){
                        $frase = $_POST['search'];

                        $getqry = "SELECT IdPPV, Priority, PPVName, Project, "
                            . "DATE(dtCreated) AS dtCreated, UserCreated, Status, PPVType "
                            . "FROM PPVs WHERE (Project LIKE '$frase' OR PPVName LIKE '%$frase%' "
                                . "OR IdPPV = '$frase' OR PPVType LIKE '$frase') AND Status != 'Closed' AND Status != 'DraftPPV' ORDER BY dtCreated ASC";

                    }

                } else {
                    
                    $getqry = "SELECT * "
                        . "FROM PPVs WHERE "
                        . "$Bys "
                        . "ORDER BY Buyer ASC, dtAdded ASC";




                }

                //echo $getqry;

                $aColumns = array(
                    array("", "tr_class", "tit_col_center", "#", "tit_col_center", "+", "tit_col_center", "BCode", "tit_col_center", "PPV", "tit_col_center", "NParte", "tit_col_center", "$orderpo PO", "tit_col_center", "ClassCode", "tit_col_center", "Vendor", "tit_col_center", "$orderimp Impact", "tit_col_center", "$orderst Status")
                );
                $LRows = $cnx->query("$getqry")->fetchAll();
                foreach ($LRows as &$LRowsx) {
                    $count++;
                    $countr++;

                    $getidPPV = $LRowsx['idPPV'];
                    $getPPV = $LRowsx['keyPPV'];
                    $getNParte = $LRowsx['Part_Nbr'];
                    $getPO = $LRowsx['Purch_Order_Number'];
                    $getStatus = $LRowsx['Status'];
                    $getImpact = $LRowsx['ImpactValue'];
                    $getBCode = $LRowsx['Buyer'];
                    $getClassCode = $LRowsx['Class_Code'];
                    $getVendor = $LRowsx['Vendor_Name'];


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

                    $goptions .= "<a href='index.php?sI=$sI&sII=PPV&sIII=EditPPV&sIV=vEdit&token=$gettoken&tokeni=$gettokeni&tokenii=$gettokenii'"
                        . " target='_self' title='Edit $getPPV'>"
                        . "<img src='Images/Edit.svg' title='Edit $getPPV' width='16' border='0'></a>";


                    $aColumns[] = array("$bcolor", "", "col_center", "$count", "col_center", "$goptions", "col_center", "$getBCode", "col_center", "$getPPV", "col_center", "$getNParte", "col_center", "$getPO", "col_center", "$getClassCode", "col_center", "$getVendor", "$cImpact", "$getImpact", "col_center", "$getStatus");


                }

                echo drawList($aGList, $aLinks, $aColumns);
                break;
        }
        
        /*
        $LID = 6;
        $IDOption = "IdNotificacion";
        //Obrtiene usuarios
        if(isset($_GET['search'])){
            if($_GET['search'] == 1){
                $frase = $_POST['search'];
                //$lfrase = "$frase";
                $star = "SELECT IdTask, IdTask AS IDTarea, GPriority AS P, TaskName AS Tarea, Project AS Proyecto, "
                        . "DATE(dtCreated) AS Fecha, UserCreated AS Creador, Status, TypeTask "
                        . "FROM Tasks WHERE (Project LIKE '$frase' OR TaskName LIKE '%$frase%' "
                        . "OR IDTask = '$frase' OR TypeTask LIKE '$frase') AND Status != 'Closed' ORDER BY dtCreated ASC";
                $LRows = $cnx->query("$star")->fetchAll();
            }
            
        } else {
            $star = "SELECT IdNotificacion, N_Title AS Proyecto, N_Notes AS Notificacion, App, IDApp, "
                    . "DATE(dtCreated) AS Fecha "
                    . "FROM Notificacion WHERE Status != 'Closed' AND IDUser = '$uIDUser' ORDER BY dtCreated ASC";
            $LRows = $cnx->query("$star")->fetchAll();
        }
        
        //Depende cuenta
        $ALinks[] = array('s_icon', '20', 'Images/search.svg', "index.php?sI=$sI&sII=Notify&sIII=Readed&sIV=Home", '_self', 'Cerrar Notificacion');
        //$ALinks[] = array('s_icon', '20', 'Images/Trash.svg', "index.php?sI=$sI&sII=$sII&sIII=EditTask&sIV=vDelete", '_self', 'Eliminar Cliente');
        //$ALinks[] = array('s_icon', '20', 'Images/Messages.svg', "index.php?sI=$sI&sII=$sII&sIII=Messages&sIV=Home", '_self', 'Ver Ordenes');
        
        //$FLink = "index.php?sI=$sI&sII=$sII&sIII=sUser&sIV=$sIV";
        echo Lista($LID, $LRows, $IDOption, $ALinks);
        */
        
        /*
        $aGList = array("Alerts", "80%", "", "", "0", "PO, PartNumber");
        
        //Obrtiene usuarios
        if(isset($_GET['search'])){
            if($_GET['search'] == 1){
                $frase = $_POST['search'];
                //$lfrase = "$frase";
                $star = "SELECT IdTask, IdTask AS IDTarea, GPriority AS P, TaskName AS Tarea, Project AS Proyecto, "
                        . "DATE(dtCreated) AS Fecha, UserCreated AS Creador, Status, TypeTask "
                        . "FROM Tasks WHERE (Project LIKE '$frase' OR TaskName LIKE '%$frase%' "
                        . "OR IDTask = '$frase' OR TypeTask LIKE '$frase') AND Status != 'Closed' ORDER BY dtCreated ASC";
                //$LRows = $cnx->query("$star")->fetchAll();
            }
            
        } else {
            $star = "SELECT IdNotificacion, N_Title AS Proyecto, N_Notes AS Notificacion, App, IDApp, "
                    . "DATE(dtCreated) AS Fecha "
                    . "FROM Notificacion WHERE Status != 'Closed' AND IDUser = '$uIDUser' ORDER BY dtCreated ASC";
            //$LRows = $cnx->query("$star")->fetchAll();
        }
        
        $aColumns = array(
            array("", "tr_class", "tit_col_center", "#", "tit_col_center", "+", "tit_col_center", "Project", "tit_col_center", "Alert", "tit_col_center", "App", "tit_col_center", "IDApp", "tit_col_center", "Date")
        );
        $LRows = $cnx->query($star)->fetchAll();
        foreach ($LRows as &$LRowsx) {
            $count++;
            $countr++;

            $getIdNotificacion = $LRowsx['IdNotificacion'];
            $getProyecto = $LRowsx['Proyecto'];
            $getNotificacion = $LRowsx['Notificacion'];
            $getApp = $LRowsx['App'];
            $getIDApp = $LRowsx['IDApp'];
            $getFecha = $LRowsx['Fecha'];

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

            
            $goptions .= "<a href='index.php?sI=$sI&sII=PPV&sIII=EditPPV&sIV=vEdit&token=$gettoken&tokeni=$gettokeni&tokenii=$gettokenii'"
                . " target='_self' title='Edit $getPPV'>"
                . "<img src='Images/Edit.svg' title='Edit $getPPV' width='16' border='0'></a>";
            

            $aColumns[] = array("$bcolor", "", "col_center", "$count", "col_center", "$goptions", "col_center", "$getProyecto", "col_center", "$getNotificacion", "col_center", "$getApp", "col_center", "$getIDApp", "col_center", "$getFecha");


        }

        echo drawList($aGList, $aLinks, $aColumns);
        
        echo "<BR><BR>";
        
        $aGList = array("Pendings PO Confirmation", "80%", "", "", "1", "PO, PartNumber");
        if(isset($_GET['search'])){
            if($_GET['search'] == 1){
                $frase = $_POST['search'];
                
                $getqry = "SELECT IdPPV, Priority, PPVName, Project, "
                    . "DATE(dtCreated) AS dtCreated, UserCreated, Status, PPVType "
                    . "FROM PPVs WHERE (Project LIKE '$frase' OR PPVName LIKE '%$frase%' "
                        . "OR IdPPV = '$frase' OR PPVType LIKE '$frase') AND Status != 'Closed' ORDER BY dtCreated ASC";
                
            }
            
        } else {
            //Depende cuenta
            switch ($uAccount){
                case "Buyer":
                    $getqry = "SELECT * "
                        . "FROM POControl WHERE idUOwner= '$uIDUser' AND Status != 'Closed' ORDER BY dtCreated ASC";
                    break;
                case "Sourcing Manager";
                    $getqry = "SELECT * "
                        . "FROM PPVs WHERE "
                        . "idUOwner= '$uIDUser' OR "
                        . "Status = 'Permanent' ORDER BY dtAdded ASC";
                    break;
                case "Purchasing Manager":
                    $getqry = "SELECT * "
                        . "FROM PPVs WHERE "
                        . "idUOwner= '$uIDUser' AND "
                        . "(Status = 'MasterWorkCost') "
                        . "ORDER BY dtAdded ASC";
                    break;
                case "Purchasing Leader":
                    $getqry = "SELECT * "
                        . "FROM PPVs WHERE "
                        . "idUOwner= '$uIDUser' AND "
                        . "(Status = 'RevCoverCost' OR Status = 'EndCustomerCost') "
                        . "ORDER BY dtAdded ASC";
                    break;
                default :
                    $getqry = "SELECT * "
                        . "FROM POControl WHERE Status != 'Closed' ORDER BY dtCreated ASC LIMIT 0, 10";
                    break;
            }
            
            
            
            
        }
        
        echo $getqry;
        
        $aColumns = array(
            array("", "tr_class", "tit_col_center", "#", "tit_col_center", "+", "tit_col_center", 
                "PO", "tit_col_center", "PPV", "tit_col_center", "NParte", "tit_col_center", "PO", "tit_col_center", "Impact", "tit_col_center", "Status")
        );
        $LRows = $cnx->query("$getqry")->fetchAll();
        foreach ($LRows as &$LRowsx) {
            $count++;
            $countr++;

            $getidPPV = $LRowsx['idPPV'];
            $getPPV = $LRowsx['keyPPV'];
            $getNParte = $LRowsx['Part_Nbr'];
            $getPO = $LRowsx['Purch_Order_Number'];
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

            $goptions .= "<a href='index.php?sI=$sI&sII=PPV&sIII=EditPPV&sIV=vEdit&token=$gettoken&tokeni=$gettokeni&tokenii=$gettokenii'"
                . " target='_self' title='Edit $getPPV'>"
                . "<img src='Images/Edit.svg' title='Edit $getPPV' width='16' border='0'></a>";


            $aColumns[] = array("$bcolor", "", "col_center", "$count", "col_center", "$goptions", "col_center", "$getBCode", "col_center", "$getPPV", "col_center", "$getNParte", "col_center", "$getPO", "$cImpact", "$getImpact", "col_center", "$getStatus");


        }

        echo drawList($aGList, $aLinks, $aColumns);

        echo "<BR><BR>";
        */
        
        
        
        /*
        $aGList = array("Pendings PPV", "80%", "", "", "0", "PO, PartNumber");
        if(isset($_GET['search'])){
            if($_GET['search'] == 1){
                $frase = $_POST['search'];
                
                $getqry = "SELECT IdPPV, Priority, PPVName, Project, "
                    . "DATE(dtCreated) AS dtCreated, UserCreated, Status, PPVType "
                    . "FROM PPVs WHERE (Project LIKE '$frase' OR PPVName LIKE '%$frase%' "
                        . "OR IdPPV = '$frase' OR PPVType LIKE '$frase') AND Status != 'Closed' AND Status != 'DraftPPV' ORDER BY dtCreated ASC";
                
            }
            
        } else {
            //Depende cuenta
            switch ($uAccount){
                case "Admin":
                    $getqry = "SELECT * "
                        . "FROM PPVs WHERE Status != 'Closed' AND Status != 'DraftPPV' ORDER BY dtAdded ASC";
                    break;
                case "Buyer":
                    $cext = explode(",", $uIDExtra);
                    $Buyx = "";
                    
                    foreach ($cext AS &$xt){
                        $dxt = $xt;
                        $Buyx .= "Buyer = '$dxt' OR ";
                    }
                    
                    if(!empty($Buyx)){
                        $Buyx = substr($Buyx, 0, -3);
                    }
                    
                    $getqry = "SELECT * "
                        . "FROM PPVs WHERE ($Buyx OR idUOwner= '$uIDUser') AND Status != 'Closed' AND Status != 'DraftPPV' ORDER BY dtAdded ASC";
                    break;
                case "Sourcing Manager";
                    $getqry = "SELECT * "
                        . "FROM PPVs WHERE "
                        . "idUOwner= '$uIDUser' OR "
                        . "Status = 'Permanent' AND Status != 'DraftPPV' ORDER BY dtAdded ASC";
                    break;
                case "Purchasing Manager":
                    $getqry = "SELECT * "
                        . "FROM PPVs WHERE "
                        . "idUOwner= '$uIDUser' AND "
                        . "(Status = 'MasterWorkCost') AND Status != 'DraftPPV' "
                        . "ORDER BY dtAdded ASC";
                    break;
                case "Purchasing Leader":
                    $getqry = "SELECT * "
                        . "FROM PPVs WHERE "
                        . "idUOwner= '$uIDUser' AND "
                        . "(Status = 'RevCoverCost' OR Status = 'EndCustomerCost') AND Status != 'DraftPPV' "
                        . "ORDER BY dtAdded ASC";
                    break;
                default :
                    $getqry = "SELECT * "
                        . "FROM PPVs WHERE idUOwner= '$uIDUser' AND Status != 'Closed' AND Status != 'DraftPPV' ORDER BY dtAdded ASC";
                    break;
            }
            
            
            
            
        }
        
        //echo $getqry;
        
        $aColumns = array(
            array("", "tr_class", "tit_col_center", "#", "tit_col_center", "+", "tit_col_center", "BCode", "tit_col_center", "PPV", "tit_col_center", "NParte", "tit_col_center", "$orderpo PO", "tit_col_center", "ClassCode", "tit_col_center", "Vendor", "tit_col_center", "$orderimp Impact", "tit_col_center", "$orderst Status")
        );
        $LRows = $cnx->query("$getqry")->fetchAll();
        foreach ($LRows as &$LRowsx) {
            $count++;
            $countr++;

            $getidPPV = $LRowsx['idPPV'];
            $getPPV = $LRowsx['keyPPV'];
            $getNParte = $LRowsx['Part_Nbr'];
            $getPO = $LRowsx['Purch_Order_Number'];
            $getStatus = $LRowsx['Status'];
            $getImpact = $LRowsx['ImpactValue'];
            $getBCode = $LRowsx['Buyer'];
            $getClassCode = $LRowsx['Class_Code'];
            $getVendor = $LRowsx['Vendor_Name'];
                    

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

            $goptions .= "<a href='index.php?sI=$sI&sII=PPV&sIII=EditPPV&sIV=vEdit&token=$gettoken&tokeni=$gettokeni&tokenii=$gettokenii'"
                . " target='_self' title='Edit $getPPV'>"
                . "<img src='Images/Edit.svg' title='Edit $getPPV' width='16' border='0'></a>";


            $aColumns[] = array("$bcolor", "", "col_center", "$count", "col_center", "$goptions", "col_center", "$getBCode", "col_center", "$getPPV", "col_center", "$getNParte", "col_center", "$getPO", "col_center", "$getClassCode", "col_center", "$getVendor", "$cImpact", "$getImpact", "col_center", "$getStatus");


        }

        echo drawList($aGList, $aLinks, $aColumns);
        */
        
        
        break;
}
?>