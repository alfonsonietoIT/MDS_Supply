<?php
//Depende
switch ($sIII){
    case "AddQuoteFile":
        switch ($sIV){
            case "sAddQuoteHistory":
                $sIVx = substr($sIV, 1);
                $TFile = "QuotesHistory";
                //Sube el archivo
                //Archivo
                $nombre_archivo = $_FILES['ufile']['name']; 
		$tipo_archivo = $_FILES['ufile']['type'];
                $size_archivo = $_FILES['ufile']['size'];
		$linkfile = "TempFiles/" . $nombre_archivo; 
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
                                    . "'$uIDUser', '$uFullName', 'Open', '$dateToday', '$dtAhora', '$dtAhora', '$dtAhora'"
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
            case "AddQuoteHistory":
                //Titulo, Size, Info, Alert
                $aGForm = array("Add MPN List", "60%", "", "");
                //Link, Title, target, class, $sI, SII, $sIII, $sIV, token, tokeni, tokenii
                $aLinks = array(
                    array("", "< Back", "", "linkr", "", "$sI", "$sII", "Home", "Home", "", "", "")
                );

                $info = "";

                //campos: action, label, id, class, tipo, name, value, checked, selected, focus  
                $aFields = array(
                    array("index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=s$sIV&token=$gettoken", "", "formx", "formx", "post", "addfile", " enctype='multipart/form-data' ", "", "", ""),
                    array("", "<br><BR>Quotes History (CSV-MSDOS):", "ufile", "text", "file", "ufile", "", "", "", "")
                );
                echo drawForm($aGForm, $aLinks, $aFields);
                break;
            case "Home":
                $aLinks = array(
                    array("", "[+] Add Report Request", "", "linkr", "", "$sI", "$sII", "$sIII", "AddQuoteHistory", "", "", ""),
                    array("", "[<] Back", "", "linkr", "", "$sI", "$sII", "Home", "Home", "", "", ""),
                );
                
                $aGList = array("Quotes History List", "60%", "", "", "0", "MPN, SUPPLIER, MANUFACTURER");
                        
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
                    $LQry = "SELECT * FROM TempFiles WHERE TFile = 'QuotesHistory' ORDER BY dtCreated DESC LIMIT 0, 10";
                }
                
                
                
                $aColumns = array(
                    array("", "tr_class", "tit_col_center", "#", "tit_col_center", "+", "tit_col_center", "dtRequested", 
                        "tit_col_center", "dtCompleted", "tit_col_center", "RequiredBy", "tit_col_center", "Status")
                );
                $LRows = $cnx->query("$LQry")->fetchAll();
                foreach ($LRows as &$LRowsx) {
                    $count++;
                    $countr++;
                    
                    $getidQuotes_Reports = $LRowsx['idQuotes_Reports'];
                    $getdtRequested = $LRowsx['dtCreated'];
                    $getdtStarted = $LRowsx['dtStarted'];
                    $getdtCompleted = $LRowsx['dtProcessed'];
                    $getidUser = $LRowsx['idUser'];
                    $getNUser = $LRowsx['UserCreated'];
                    $getStatus = $LRowsx['Status'];
                    $getLink = $LRowsx['Link'];
                    
                    if($getdtStarted == $dtEmpty){
                        $getdtStarted = "ND";
                    }
                    
                    if($getdtCompleted == $dtEmpty){
                        $getdtCompleted = "ND";
                    }
                    
                    $P_Acctg_Value = "";
                    $P_Ven_Price = "";
                    $P_Last_Price = "";
                    $P_Mfgr_Name = "";
                    $P_Vendor_Id = "";
                    
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
                    
                    $gettoken = base64_encode($getidQuotes_Reports);
                    
                    $goptions = "";
                    //N$count = "$count - $uAccount";
                    
                    switch ($getStatus){
                        case "Open":
                        case "Rejected":
                            $goptions .= "<a href='$getLink' target='_blank' title='View File'>"
                                . "<img src='Images/View.svg' title='View File' width='16' border='0'></a>";
                            
                            $goptions .= "<a href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=Delete&token=$gettoken&tokeni=$gettokeni&tokenii=$gettokenii'"
                                . " target='_self' title='Delete $getidQuotes_Reports'>"
                                . "<img src='Images/Trash.svg' title='Delete $getidQuotes_Reports' width='16' border='0'></a>";
                            break;
                        case "Ready":
                            $goptions .= "<a href='Include/reportCSV.php?report=QuotesReport&token=$gettoken' target='_blank' title='View File'>"
                                . "<img src='Images/xls.svg' title='View File' width='16' border='0'></a>";
                            break;
                    }
                    
                    
                    
                    $aColumns[] = array("$bcolor", "", "col_center", "$count", "col_center", "$goptions", "col_center", "$getdtRequested", 
                        "col_center", "$getdtCompleted", "col_center", "$getNUser",  "col_center", "$getStatus");
                    
                    
                }
                
                echo drawList($aGList, $aLinks, $aColumns);
                break;
        }
        break;
    case "Reports":
        switch ($sIV){
            case "sAddReportRequest":
                $sIVx = substr($sIV, 1);
                //Sube el archivo
                //Archivo
                $nombre_archivo = $_FILES['ufile']['name']; 
		$tipo_archivo = $_FILES['ufile']['type'];
                $size_archivo = $_FILES['ufile']['size'];
		$linkfile = "ReportFiles/" . $nombre_archivo; 
                //N echo $nombre_archivo . "- $size_archivo<BR>";
                $extension = strtolower(substr($nombre_archivo, strrpos($nombre_archivo, '.' )+1));
                //Busca si existe Open
                if($extension == "csv"){
                    //Sube el archivo
                    if (move_uploaded_file($_FILES['ufile']['tmp_name'], $linkfile)){
                        $smid = "SELECT MAX(idQuotes_Reports) AS mid FROM Quotes_Reports";
                        $rmid = $cnx->query("$smid")->fetchArray();
                        $ID = $rmid['mid'] + 1;
                        $filex = "QuoteRep_" . $ID . "." . $extension;
                        $link = "ReportFiles/" . $filex;

                        copy($linkfile, $link);
                        unlink($linkfile);
                        //Actualiza el archivo
                        $siFile = "INSERT INTO Quotes_Reports VALUES("
                                . "'$ID', '$link', '$dtAhora', '$dtEmpty', '$dtEmpty', "
                                . "'$uIDUser', '$uFullName', 'Open'"
                                . ")";
                        $iFile = $cnx->query("$siFile");

                        $vATipo = "Verde";
                        $vAMensaje = "Quote Report Created Successfully ...!";
                        $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=Home&token=$gettoken";
                        $vATime = 1000;
                        //N echo $vRedirect;
                        echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);

                    } else {
                        $vATipo = "Rojo";
                        $vAMensaje = "File Transfer error...!";
                        $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=Home&sIV=Home&token=$gettoken";
                        $vATime = 3000;
                        echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                    }

                } else {
                    $vATipo = "Rojo";
                    $vAMensaje = "File format invalid...!";
                    $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=$sIVx&token=$gettoken";
                    $vATime = 3000;
                    //for redirect echo $vRedirect;
                    echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                }
                
                
                break;
            case "AddReportRequest":
                //Titulo, Size, Info, Alert
                $aGForm = array("Add MPN List", "60%", "", "");
                //Link, Title, target, class, $sI, SII, $sIII, $sIV, token, tokeni, tokenii
                $aLinks = array(
                    array("", "< Back", "", "linkr", "", "$sI", "$sII", "Home", "Home", "", "", "")
                );

                $info = "";

                //campos: action, label, id, class, tipo, name, value, checked, selected, focus  
                $aFields = array(
                    array("index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=s$sIV&token=$gettoken", "", "formx", "formx", "post", "addfile", " enctype='multipart/form-data' ", "", "", ""),
                    array("", "<br><BR>MPN Parts List (CSV-MSDOS):", "ufile", "text", "file", "ufile", "", "", "", "")
                );
                echo drawForm($aGForm, $aLinks, $aFields);
                break;
            case "Home":
                $aLinks = array(
                    array("", "[+] Report Request", "", "linkr", "", "$sI", "$sII", "$sIII", "AddReportRequest", "", "", ""),
                    array("", "[<] Back", "", "linkr", "", "$sI", "$sII", "Home", "Home", "", "", ""),
                );
                
                $aGList = array("Reports Request List", "60%", "", "", "0", "MPN, SUPPLIER, MANUFACTURER");
                        
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
                    $LQry = "SELECT * FROM Quotes_Reports ORDER BY dtRequested DESC LIMIT 0, 100";
                }
                
                
                
                $aColumns = array(
                    array("", "tr_class", "tit_col_center", "#", "tit_col_center", "+", "tit_col_center", "dtRequested", "tit_col_center", "dtStarted", 
                        "tit_col_center", "dtCompleted", "tit_col_center", "RequiredBy", "tit_col_center", "Status")
                );
                $LRows = $cnx->query("$LQry")->fetchAll();
                foreach ($LRows as &$LRowsx) {
                    $count++;
                    $countr++;
                    
                    $getidQuotes_Reports = $LRowsx['idQuotes_Reports'];
                    $getdtRequested = $LRowsx['dtRequested'];
                    $getdtStarted = $LRowsx['dtStarted'];
                    $getdtCompleted = $LRowsx['dtCompleted'];
                    $getidUser = $LRowsx['idUser'];
                    $getNUser = $LRowsx['NUser'];
                    $getStatus = $LRowsx['Status'];
                    $getLink = $LRowsx['Link'];
                    
                    if($getdtStarted == $dtEmpty){
                        $getdtStarted = "ND";
                    }
                    
                    if($getdtCompleted == $dtEmpty){
                        $getdtCompleted = "ND";
                    }
                    
                    $P_Acctg_Value = "";
                    $P_Ven_Price = "";
                    $P_Last_Price = "";
                    $P_Mfgr_Name = "";
                    $P_Vendor_Id = "";
                    
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
                    
                    $gettoken = base64_encode($getidQuotes_Reports);
                    
                    $goptions = "";
                    //N$count = "$count - $uAccount";
                    
                    switch ($getStatus){
                        case "Open":
                        case "Rejected":
                            $goptions .= "<a href='$getLink' target='_blank' title='View File'>"
                                . "<img src='Images/View.svg' title='View File' width='16' border='0'></a>";
                            
                            $goptions .= "<a href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=Delete&token=$gettoken&tokeni=$gettokeni&tokenii=$gettokenii'"
                                . " target='_self' title='Delete $getidQuotes_Reports'>"
                                . "<img src='Images/Trash.svg' title='Delete $getidQuotes_Reports' width='16' border='0'></a>";
                            break;
                        case "Ready":
                            $goptions .= "<a href='Include/reportCSV.php?report=QuotesReport&token=$gettoken' target='_blank' title='View File'>"
                                . "<img src='Images/xls.svg' title='View File' width='16' border='0'></a>";
                            break;
                    }
                    
                    
                    
                    $aColumns[] = array("$bcolor", "", "col_center", "$count", "col_center", "$goptions", "col_center", "$getdtRequested", "col_center", "$getdtStarted", 
                        "col_center", "$getdtCompleted", "col_center", "$getNUser",  "col_center", "$getStatus");
                    
                    
                }
                
                echo drawList($aGList, $aLinks, $aColumns);
                break;
        }
        break;
    case "Home":
        switch ($sIV){
            case "Home":
                $aLinks = array(
                    array("", "[>] Quotes File", "", "linkr", "", "$sI", "$sII", "AddQuoteFile", "Home", "", "", ""),
                    array("", "[&#9954;] Reports", "", "linkr", "", "$sI", "$sII", "Reports", "Home", "", "", ""),
                );
                
                $aGList = array("Quotes List", "80%", "", "", "1", "MPN, SUPPLIER, MANUFACTURER");
                        
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
                    $LQry = "SELECT * FROM Quotes ORDER BY COMPLETED_ON DESC LIMIT 0, 10";
                }
                
                
                
                $aColumns = array(
                    array("", "tr_class", "tit_col_center", "#", "tit_col_center", "+", "tit_col_center", "CPN", "tit_col_center", "MPN", 
                        "tit_col_center", "QUOTED_MPN", "tit_col_center", "SUPPLIER_NAME", "tit_col_center", "MANUFACTURER_NAME", "tit_col_center", "COMPLETED_ON", 
                        "tit_col_center", "CUSTOMER", "tit_col_center", "MIN_PRICE", "tit_col_center", "MAX_QTY",
                        "tit_col_center_yellow", "ACCTG_VALUE", "tit_col_center_yellow", "VEN_PRICE", "tit_col_center_yellow", "LAST_PRICE", "tit_col_center_yellow", "MFGR_NAME", "tit_col_center_yellow", "VENDOR_ID")
                );
                $LRows = $cnx->query("$LQry")->fetchAll();
                foreach ($LRows as &$LRowsx) {
                    $count++;
                    $countr++;
                    
                    $getidQuotes = $LRowsx['idQuotes'];
                    $getCPN = $LRowsx['CPN'];
                    $getMPN = $LRowsx['MPN'];
                    $getQUOTED_MPN = $LRowsx['QUOTED_MPN'];
                    $getMANUFACTURER_NAME = $LRowsx['MANUFACTURER_NAME'];
                    $getSUPPLIER_NAME = $LRowsx['SUPPLIER_NAME'];
                    $getCOMPLETED_ON = $LRowsx['COMPLETED_ON'];
                    $getCUSTOMER = $LRowsx['CUSTOMER'];
                    $getMIN_PRICE = $LRowsx['MIN_PRICE'];
                    $getMAX_QTY = $LRowsx['MAX_QTY'];
                    
                    $P_Acctg_Value = "";
                    $P_Ven_Price = "";
                    $P_Last_Price = "";
                    $P_Mfgr_Name = "";
                    $P_Vendor_Id = "";
                    
                    //Obtiene data del customer part
                    $sPart = "SELECT * FROM PartData WHERE Mfgr_Item_Nbr = '$getMPN' ORDER BY Mfgr_Item_Nbr ASC LIMIT 0, 1";
                    $nPart = $cnx->query($sPart)->numRows();
                    
                    if($nPart == 1){
                        $rPart = $cnx->query($sPart)->fetchArray();
                        $P_Acctg_Value = $rPart['Acctg_Value'];
                        $P_Ven_Price = $rPart['Ven_Price'];
                        $P_Last_Price = $rPart['Last_Price'];
                        $P_Mfgr_Name = $rPart['Mfgr_Name'];
                        $P_Vendor_Id = $rPart['Vendor_Id'];
                        
                    } else {
                        if(!empty($getQUOTED_MPN)){
                            $sPart = "SELECT * FROM PartData WHERE Mfgr_Item_Nbr = '$getQUOTED_MPN' ORDER BY Mfgr_Item_Nbr LIMIT 0, 1";
                            $nPart = $cnx->query($sPart)->numRows();
                            if($nPart == 1){
                                $rPart = $cnx->query($sPart)->fetchArray();
                                $P_Acctg_Value = $rPart['Acctg_Value'];
                                $P_Ven_Price = $rPart['Ven_Price'];
                                $P_Last_Price = $rPart['Last_Price'];
                                $P_Mfgr_Name = $rPart['Mfgr_Name'];
                                $P_Vendor_Id = $rPart['Vendor_Id'];

                            }
                            
                            
                        }
                        
                    }
                    
                    
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
                    
                    
                    $goptions .= "<a href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=View&token=$gettoken&tokeni=$gettokeni&tokenii=$gettokenii'"
                        . " target='_self' title='View $getMPN'>"
                        . "<img src='Images/View.svg' title='View $getMPN' width='16' border='0'></a>";
                    
                    
                    $aColumns[] = array("$bcolor", "", "col_center", "$count", "col_center", "$goptions", "col_center", "$getCPN", "col_center", "$getMPN", 
                        "col_center", "$getQUOTED_MPN", "col_center", "$getSUPPLIER_NAME",  "col_center", "$getMANUFACTURER_NAME", 
                        "col_center", "$getCOMPLETED_ON", "col_center", "$getCUSTOMER", "col_center", "$getMIN_PRICE", "col_center", "$getMAX_QTY",
                        "col_center", "$P_Acctg_Value", "col_center", "$P_Ven_Price", "col_center", "$P_Last_Price", "col_center", "$P_Mfgr_Name", "col_center", "$P_Vendor_Id");
                    
                    
                }
                
                echo drawList($aGList, $aLinks, $aColumns);
                break;
        }
}
?>