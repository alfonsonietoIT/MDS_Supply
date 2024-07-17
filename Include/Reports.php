<?php
//Depende
switch ($sIII){
    case "AddReport":
        switch ($sIV){
            case "sReportFile":
                $TFile = $_POST['type'];
                $getIDR = base64_decode($_GET['token']);
                $gettoken = base64_encode($getIDR);
                //$sIVx = substr($sIV, 1);
                //Sube el archivo
                //Archivo
                $nombre_archivo = $_FILES['ufile']['name']; 
		$tipo_archivo = $_FILES['ufile']['type'];
                $size_archivo = $_FILES['ufile']['size'];
		$linkfile = "ReportFiles/" . $nombre_archivo; 
                //N echo $nombre_archivo . "- $size_archivo<BR>";
                $extension = strtolower(substr($nombre_archivo, strrpos($nombre_archivo, '.' )+1));
                //Busca si existe Open
                $sOpen = "SELECT idFiles FROM Files WHERE App = '$TFile' AND Status = 'Open'";
                $nOpen = $cnx->query($sOpen)->numRows();
                
                if($nOpen == 0){
                    //N echo "EXT: $extension";
                    if($extension == "csv"){
                        //Sube el archivo
                        if (move_uploaded_file($_FILES['ufile']['tmp_name'], $linkfile)){
                            $smid = "SELECT MAX(idFiles) AS mid FROM Files";
                            $rmid = $cnx->query("$smid")->fetchArray();
                            $ID = $rmid['mid'] + 1;
                            $filex = "Rep_" . $getIDR . "_" . $ID . "." . $extension;
                            $link = "ReportFiles/" . $filex;

                            copy($linkfile, $link);
                            unlink($linkfile);
                            //Actualiza el archivo
                            $siFile = "INSERT INTO Files VALUES("
                                    . "'$ID', '$TFile', '$getIDR', '$link', '$TFile', "
                                    . "'$uIDUser', '$uFullName', 'Open', '$dtAhora'"
                                    . ")";
                            $iFile = $cnx->query("$siFile");

                            $vATipo = "Verde";
                            $vAMensaje = "Report Created Successfully ...!";
                            $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=RevRequirements&token=$gettoken";
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
                        $vAMensaje = "$TFile format invalid...!";
                        $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=RevRequirements&token=$gettoken";
                        $vATime = 3000;
                        //for redirect echo $vRedirect;
                        echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                    }
                } else {
                    $vATipo = "Rojo";
                    $vAMensaje = "$TFile already exist...!";
                    $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=Home&sIV=Home&token=$gettoken";
                    $vATime = 3000;
                    //for redirect echo $vRedirect;
                    echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                }
                break;
            case "RevRequirements":
                //Reporte ID
                $getIDR = base64_decode($_GET['token']);
                $gettoken = base64_encode($getIDR);
                //Obtiene informacion del reporte
                $sIReport = "SELECT * FROM Reports WHERE idReport = '$getIDR'";
                $rIReport = $cnx->query($sIReport)->fetchArray();
                //Info del reporte
                $getTypeReport = $rIReport['TypeReport'];
                $getReportTable = $rIReport['ReportTable'];
                $getdtRequested = $rIReport['dtRequested'];
                $getdtRequirements = $rIReport['dtRequirements'];
                $getStarted = $rIReport['Started'];
                $getProcess = $rIReport['Process'];
                $getEnded = $rIReport['Ended'];
                $getStatus = $rIReport['Status'];
                
                
                switch ($getTypeReport){
                    case "MRPExpedite":
                        $file1 = $getTypeReport;
                        //Valida requerimientos
                        $sFiles = "SELECT * FROM Files WHERE App = '$file1' AND idApp = '$getIDR' AND status = 'Open'";
                        $nFiles = $cnx->query($sFiles)->numRows();
                        //echo "$nFiles - $sFiles<BR>";
                        if($nFiles == 1){
                            //Complete
                            
                            if($getStatus == "Created"){
                                //Actualiza el status
                                $uStat = "UPDATE Reports SET Status = 'Waiting', dtRequirements = '$dtAhora', Process = 'Waiting' WHERE idReport = '$getIDR'";
                                $rStat = $cnx->query($uStat);
                            }
                            
                            
                            
                            $vATipo = "Verde";
                            $vAMensaje = "Report Ready for Run ...!";
                            $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=Home&sIV=Home&token=$gettoken";
                            $vATime = 1000;
                            //N echo $vRedirect;
                            echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                            
                        } else {
                            //Incomplete
                            //subir files
                            //Titulo, Size, Info, Alert
                            $aGForm = array("Add File $getTypeReport", "60%", "", "");
                            //Link, Title, target, class, $sI, SII, $sIII, $sIV, token, tokeni, tokenii
                            $aLinks = array(
                                array("", "< Back", "", "linkr", "", "$sI", "$sII", "Home", "Home", "", "", "")
                            );

                            $info = "";

                            //campos: action, label, id, class, tipo, name, value, checked, selected, focus  
                            $aFields = array(
                                array("index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=sReportFile&token=$gettoken", "", "formx", "formx", "post", "addfile", " enctype='multipart/form-data' ", "", "", ""),
                                array("", "Report File", "type", "stext", "select", "type", "MRPExpedite", "", "", "1"),
                                array("", "<br><BR>Parts Requirements (CSV-MSDOS):", "ufile", "text", "file", "ufile", "", "", "", "")
                            );
                            echo drawForm($aGForm, $aLinks, $aFields);
                        }
                        
                        
                        break;
                }
                
                
                break;
            case "sAddReport":
                $TFile = $_POST['type'];
                $TableRep = str_replace(" ", "", $TFile);
                $sIVx = substr($sIV, 1);
                
                //Revisa si existe alguno abierto
                $sRep = "SELECT * FROM Reports WHERE TypeReport = '$TFile' AND Status = 'Open'";
                $nRep = $cnx->query($sRep)->numRows();
                
                if($nRep == 0){
                    //Report
                    $smir = "SELECT MAX(idReport) AS mir FROM Reports";
                    $rmir = $cnx->query("$smir")->fetchArray();
                    $IDR = $rmir['mir'] + 1;
                    $gettoken = base64_encode($IDR);
                    //Inserta el archivo
                    $Report = "INSERT INTO Reports VALUES('$IDR', '$TFile', '$TableRep', '$dtAhora', '$dtEmpty', '$dtEmpty', 'Created', '$dtEmpty', '$uIDUser', '$uFullName', 'Created')";
                    $iReport = $cnx->query("$Report");
                    
                    $vATipo = "Verde";
                    $vAMensaje = "Report Created Successfully ...!";
                    $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=RevRequirements&token=$gettoken";
                    $vATime = 1000;
                    //N echo $vRedirect;
                    echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                    
                } else {
                    //Report Open
                    $vATipo = "Rojo";
                    $vAMensaje = "$TFile already exist...!";
                    $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=$sIVx&token=$gettoken";
                    $vATime = 3000;
                    //for redirect echo $vRedirect;
                    echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                    
                }
                
                break;
            case "AddReport":
                //subir files
                //Titulo, Size, Info, Alert
                $aGForm = array("Add Report", "60%", "", "");
                //Link, Title, target, class, $sI, SII, $sIII, $sIV, token, tokeni, tokenii
                $aLinks = array(
                    array("", "< Back", "", "linkr", "", "$sI", "$sII", "Home", "Home", "", "", "")
                );
                
                
                //campos: action, label, id, class, tipo, name, value, checked, selected, focus  
                $aFields = array(
                    array("index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=s$sIV&token=$gettoken", "", "formx", "formx", "post", "addfile", " enctype='multipart/form-data' ", "", "", ""),
                    //*array("", "$TFile (CSV-MSDOS):", "ufile", "text", "file", "ufile", "", "", "", "1")
                    array("", "Report Type", "type", "stext", "select", "type", "MRPExpedite", "", "", "1")
                    //array("", "<br><BR>Parts Requirements (CSV-MSDOS):", "ufile", "text", "file", "ufile", "", "", "", "")
                );
                echo drawForm($aGForm, $aLinks, $aFields);
                break;
        }
        break;
    case "Home":
        switch ($sIV){
            case "Home":
                
                $aLinks = array(
                    array("", "[+] Add Report", "", "linkr", "", "$sI", "$sII", "AddReport", "AddReport", "", "", ""),
                );
                
                $aGList = array("Reports", "80%", "", "", "1", "Report Name");
                        
                if(isset($_GET['search'])){
                    if($_GET['search'] == 1){
                        $frase = $_POST['search'];

                        $lfrase = "%$frase%";
                        $LQry = "SELECT * FROM PPVs WHERE "
                                . "(Part_Nbr LIKE '%$frase%' OR Purch_Order_Number LIKE '$frase' OR keyPPV LIKE '$frase' OR Buyer = '$frase') AND"
                                . " Status != 'Closed' ORDER BY idPPV ASC";
                        //N $LRows = $cnx->query('SELECT MobileNumber AS IDUser, MobileNumber AS Celular, CONCAT(FLastName, \', \', Name) AS Nombre FROM Users WHERE (MobileNumber LIKE ? OR Name LIKE ? OR FLastName LIKE ? OR MLastName LIKE ?) AND IDUser != ? ORDER BY FLastName ASC', $lfrase, $lfrase, $lfrase, $lfrase, '1')->fetchAll();
                    }

                } else {
                    $LQry = "SELECT * FROM Reports ORDER BY dtRequested DESC LIMIT 0, 30";
                }
                
                
                
                $aColumns = array(
                    array("", "tr_class", "tit_col_center", "#", "tit_col_center", "+", "tit_col_center", "Report Type", "tit_col_center", "dtRequested", "tit_col_center", "dtStarted", "tit_col_center", "Process", "tit_col_center", "dtEnded", "tit_col_center", "Status")
                );
                $LRows = $cnx->query("$LQry")->fetchAll();
                foreach ($LRows as &$LRowsx) {
                    $count++;
                    $countr++;

                    $getidReport = $LRowsx['idReport'];
                    $getTypeReport = $LRowsx['TypeReport'];
                    $getReportTable = $LRowsx['ReportTable'];
                    $getdtRequested = $LRowsx['dtRequested'];
                    $getdtRequirements = $LRowsx['dtRequirements'];
                    $getStarted = $LRowsx['Started'];
                    $getProcess = $LRowsx['Process'];
                    $getEnded = $LRowsx['Ended'];
                    $getStatus = $LRowsx['Status'];
                    
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
                    
                    $gettoken = base64_encode($getidReport);
                    
                    $goptions = "";
                    //N$count = "$count - $uAccount";
                    
                    $goptions .= "<a href='index.php?sI=$sI&sII=$sII&sIII=AddReport&sIV=RevRequirements&token=$gettoken&tokeni=$gettokeni&tokenii=$gettokenii'"
                        . " target='_self' title='Edit $getPPV'>"
                        . "<img src='Images/Edit.svg' title='Edit $getPPV' width='16' border='0'></a>";
                    
                    
                    $aColumns[] = array("$bcolor", "", "col_center", "$count", "col_center", "$goptions", "col_center", "$getTypeReport", "col_center", "$getdtRequested", "col_center", "$getStarted", "col_center", "$getProcess", "col_center", "$getEnded", "col_center", "$getStatus");
                    
                    
                }
                
                echo drawList($aGList, $aLinks, $aColumns);
                
                break;
            default :
                echo "Error Default $sIII - $sIV";
                break;
        }
        break;
    default:
        break;
}
?>