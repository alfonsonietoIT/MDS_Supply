<?php
//Depende
switch ($sIII){
    case "AddQuoteFile":
        switch ($sIV){
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
                    $LQry = "SELECT * FROM Quotes_History ORDER BY dtRequested DESC LIMIT 0, 10";
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
    case "ReqCTB":
        //echo "$sIV";
        
        switch ($sIV){
            case "vReqCTB":
                //Obtiene informacion
                $gClassCode = strtoupper($_POST['classcode']);
                $gAssy = strtoupper($_POST['assy']);
                $Assys = "";
                $ClassCode = "";
                
                if(!empty($gClassCode) || !empty($gAssy)){
                    //Busca inforamacion
                    if(!empty($gAssy)){
                        $Assys = explode(",", $gAssy);
                        
                        foreach ($Assys as &$As) {
                            //Assembly
                            $sqlA = " ";
                            
                        }
                    }
                    
                    //Query
                    if(!empty($gClassCode)){
                        $ClassCode = $gClassCode;
                    }
                    
                    
                    
                } else {
                    //Los 2 vacios
                    $vATipo = "Rojo";
                    $vAMensaje = "Invalid values...!";
                    $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=$sIVx&token=$gettoken";
                    $vATime = 3000;
                    //for redirect echo $vRedirect;
                    echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                }
                
                
                break;
            case "Home":
                //Titulo, Size, Info, Alert
                $aGForm = array("Add CTB Request", "60%", "", "");
                //Link, Title, target, class, $sI, SII, $sIII, $sIV, token, tokeni, tokenii
                $aLinks = array(
                    array("", "< Back", "", "linkr", "", "$sI", "$sII", "Home", "Home", "", "", "")
                );

                $info = "";

                //campos: action, label, id, class, tipo, name, value, checked, selected, focus  
                $aFields = array(
                    array("index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=vReqCTB&token=$gettoken", "", "formx", "formx", "post", "addfile", " enctype='multipart/form-data' ", "", "", ""),
                    array("", "<br><BR>Class Code:", "classcode", "text", "text", "classcode", "", "", "", "1"),
                    array("", "<br><BR>Assembly PN:", "assy", "text", "text", "assy", "", "", "", "")
                );
                echo drawForm($aGForm, $aLinks, $aFields);
                break;
        }
        break;
    case "Home":
        switch ($sIV){
            case "Home":
                $aLinks = array(
                    array("", "[>] CTB", "", "linkr", "", "$sI", "$sII", "ReqCTB", "Home", "", "", ""),
                    array("", "[>] MRP File", "", "linkr", "", "$sI", "$sII", "AddMRPFile", "Home", "", "", ""),
                    array("", "[&#9954;] Dashboard", "", "linkr", "", "$sI", "$sII", "Dashboard", "Home", "", "", ""),
                );
                
                $aGList = array("MRP List", "80%", "", "", "1", "MPN, SUPPLIER, MANUFACTURER");
                        
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
                    $LQry = "SELECT * FROM Req ORDER BY NPart ASC LIMIT 0, 30";
                }
                
                
                
                $aColumns = array(
                    array("", "tr_class", "tit_col_center", "#", "tit_col_center", "+", "tit_col_center", "#Part", "tit_col_center", "AcctgValue", 
                        "tit_col_center", "ClassCode", "tit_col_center", "Vendor", "tit_col_center", "Nov", "tit_col_center", "Dec", 
                        "tit_col_center", "Jan", "tit_col_center", "Feb", "tit_col_center", "DNov",
                        "tit_col_center", "DDec", "tit_col_center", "DJan", "tit_col_center", "DFeb", "tit_col_center", "Status", "tit_col_center", "dtClosed")
                );
                $LRows = $cnx->query("$LQry")->fetchAll();
                foreach ($LRows as &$LRowsx) {
                    $count++;
                    $countr++;
                    
                    $get_id = $LRowsx['id'];
                    $get_NPart = $LRowsx['NPart'];
                    $get_AcctgValue = $LRowsx['AcctgValue'];
                    $get_ClassCode = $LRowsx['ClassCode'];
                    $get_Vendor = $LRowsx['Vendor'];
                    $get_Nov = $LRowsx['Nov'];
                    $get_Dec = $LRowsx['Dec'];
                    $get_Jan = $LRowsx['Jan'];
                    $get_Feb = $LRowsx['Feb'];
                    $get_DNov = $LRowsx['DNov'];
                    $get_DDec = $LRowsx['DDec'];
                    $get_DJan = $LRowsx['DJan'];
                    $get_DFeb = $LRowsx['DFeb'];
                    $get_Status = $LRowsx['Status'];
                    $get_dtClosed = $LRowsx['dtClosed'];
                    
                    
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
                    
                    
                    $aColumns[] = array("$bcolor", "", "col_center", "$count", "col_center", "$goptions", "col_center", "$get_NPart", 
                        "col_center", "$get_AcctgValue", "col_center", "$get_ClassCode",  "col_center", "$get_Vendor", 
                        "col_center", "$get_Nov", "col_center", "$get_Dec", "col_center", "$get_Jan", "col_center", "$get_Feb",
                        "col_center", "$get_DNov", "col_center", "$get_DDec", "col_center", "$get_DJan", "col_center", "$get_DFeb", "col_center", "$get_Status", "col_center", "$get_dtClosed");
                    
                    
                }
                
                echo drawList($aGList, $aLinks, $aColumns);
                break;
        }
}
?>