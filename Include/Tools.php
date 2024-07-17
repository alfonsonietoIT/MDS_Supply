<?php
switch ($sIII){
    case "AssGroup":
        switch ($sIV){
            case "svalidationGroup":
                $TFile = "ValidationGroup";
                $sIVx = substr($sIV, 1);
                //Sube el archivo
                //Archivo
                $nombre_archivo = $_FILES['ufile']['name']; 
		$tipo_archivo = $_FILES['ufile']['type'];
                $size_archivo = $_FILES['ufile']['size'];
		$linkfile = "TempFiles/" . $nombre_archivo; 
                //$getcode = str_replace('"', "", str_replace("'", "", str_replace(" ", "", strtoupper($_POST['gcode']))));
                //$getname = str_replace('"', "", str_replace("'", "", strtoupper($_POST['gname'])));
                
                //$txtValue = $getcode . "|" . $getname;
                $txtValue = "";
                //N echo $nombre_archivo . "- $size_archivo<BR>";
                $extension = strtolower(substr($nombre_archivo, strrpos($nombre_archivo, '.' )+1));
                //Busca si existe Open
                $sOpen = "SELECT idFiles FROM TempFiles WHERE TFile = '$TFile' AND Status = 'Open'";
                $nOpen = $cnx->query($sOpen)->numRows();
                
                if($nOpen < 3){
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
                                    . "'$ID', '$TFile', '$link', '$txtValue', "
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
            case "sUploadGroup":
                $TFile = "ShortGroup";
                $sIVx = substr($sIV, 1);
                //Sube el archivo
                //Archivo
                $nombre_archivo = $_FILES['ufile']['name']; 
		$tipo_archivo = $_FILES['ufile']['type'];
                $size_archivo = $_FILES['ufile']['size'];
		$linkfile = "TempFiles/" . $nombre_archivo; 
                $getcode = str_replace('"', "", str_replace("'", "", str_replace(" ", "", strtoupper($_POST['gcode']))));
                $getname = str_replace('"', "", str_replace("'", "", strtoupper($_POST['gname'])));
                
                $txtValue = $getcode . "|" . $getname;
                
                //N echo $nombre_archivo . "- $size_archivo<BR>";
                $extension = strtolower(substr($nombre_archivo, strrpos($nombre_archivo, '.' )+1));
                //Busca si existe Open
                $sOpen = "SELECT idFiles FROM TempFiles WHERE TFile = '$TFile' AND Status = 'Open'";
                $nOpen = $cnx->query($sOpen)->numRows();
                
                if($nOpen < 3){
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
                                    . "'$ID', '$TFile', '$link', '$txtValue', "
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
            case "validationGroup":
                //Titulo, Size, Info, Alert
                $aGForm = array("Validation Group & BOM", "60%", "", "");
                //Link, Title, target, class, $sI, SII, $sIII, $sIV, token, tokeni, tokenii
                $aLinks = array(
                    array("", "< Back", "", "linkr", "", "$sI", "$sII", "$sIII", "Home", "$gettoken", "", "")
                );
                
                
                //campos: action, label, id, class, tipo, name, value, checked, selected, focus  
                $aFields = array(
                    array("index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=s$sIV&token=$gettoken", "", "formx", "formx", "post", "addfile", " enctype='multipart/form-data' ", "", "", ""),
                    //array("", "Group Code:", "gcode", "text", "text", "gcode", "", "", "required='required'", "1"),
                    //array("", "Group Name:", "gname", "text", "text", "gname", "", "", "required='required'", ""),
                    array("", "Group File (CSV-MSDOS):", "ufile", "text", "file", "ufile", "", "", "required='required'", "")
                );
                echo drawForm($aGForm, $aLinks, $aFields);
                break;
            case "UploadGroup":
                //Titulo, Size, Info, Alert
                $aGForm = array("Upload Group", "60%", "", "");
                //Link, Title, target, class, $sI, SII, $sIII, $sIV, token, tokeni, tokenii
                $aLinks = array(
                    array("", "< Back", "", "linkr", "", "$sI", "$sII", "$sIII", "Home", "$gettoken", "", "")
                );
                
                
                //campos: action, label, id, class, tipo, name, value, checked, selected, focus  
                $aFields = array(
                    array("index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=s$sIV&token=$gettoken", "", "formx", "formx", "post", "addfile", " enctype='multipart/form-data' ", "", "", ""),
                    array("", "Group Code:", "gcode", "text", "text", "gcode", "", "", "required='required'", "1"),
                    array("", "Group Name:", "gname", "text", "text", "gname", "", "", "required='required'", ""),
                    array("", "Group File (CSV-MSDOS):", "ufile", "text", "file", "ufile", "", "", "required='required'", "")
                );
                echo drawForm($aGForm, $aLinks, $aFields);
                break;
            case "DeleteAssy":
                if(empty($gIDGroup)){
                    $gIDGroup = base64_decode($_GET['token']);
                    $gAIDGroup = base64_decode($_GET['tokeni']);
                }
                
                $gettoken = base64_encode($gIDGroup);
                $gettokeni = base64_encode($gAIDGroup);
                
                //Info del Group
                $siAss = "SELECT * FROM AssembliesGroup WHERE idAGroup = '$gAIDGroup'";
                $riA = $cnx->query($siAss)->fetchArray();
                $gAssy = $riA['Assembly'];
                
                
                $dAssy = "DELETE FROM AssembliesGroup WHERE idAGroup = '$gAIDGroup'";
                $rAssy = $cnx->query($dAssy);
                //echo $dAssy . "<BR>";
                
                $sCol = "SELECT * FROM GroupCollection WHERE idGroup = '$gIDGroup'";
                $nCol = $cnx->query($sCol)->numRows();

                if($nCol > 0){
                    if($nCol == 1){
                        $rCol = $cnx->query($sCol)->fetchArray();
                        $gidCol = $rCol['idCollection'];
                        $dAssy = "DELETE FROM AssembliesGroup WHERE idGroup = '$gidCol' AND Assembly = '$gAssy'";
                        $rAssy = $cnx->query($dAssy);
                        //echo $dAssy . "<BR>";
                        //echo $iAssy . "<BR>";

                    } else {
                        $rCol = $cnx->query($sCol)->fetchAll();
                        foreach ($rCol AS &$rC){
                            $gidCol = $rC['idCollection'];
                            $dAssy = "DELETE FROM AssembliesGroup WHERE idGroup = '$gidCol' AND Assembly = '$gAssy'";
                            $rAssy = $cnx->query($dAssy);
                            //echo $dAssy . "<BR>";
                            //echo $iAssy . "<BR>";

                        }
                    }
                }
                
                
                $vAMensaje = "Assemby Deleted Successfully, redirect...";
                //Redirecciona al view
                $vATipo = "Verde";
                $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=vGroup&token=$gettoken";
                $vATime = 1000;
                //N echo $vRedirect;
                echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                
                
                break;
            case "sAddAssembly":
                if(empty($gIDGroup)){
                    $gIDGroup = base64_decode($_GET['token']);
                }
                
                $gettoken = base64_encode($gIDGroup);
                
                //Info del Group
                $sIG = "SELECT * FROM AssGroup WHERE idGroup = '$gIDGroup'";
                $rIG = $cnx->query($sIG)->fetchArray();
                //Name
                $gGroupCode = $rIG['GroupCode'];
                $gGroupName = $rIG['GroupName'];
                $gQtyAss = $rIG['QtyAss'];
                
                
                $gAssy = strtoupper(str_replace(" ", "", $_POST['Assy']));
                
                //Revisa si existe
                $sAGroup = "SELECT * FROM AssembliesGroup WHERE idGroup = '$gIDGroup' AND Assembly = '$gAssy'";
                $nAGroup = $cnx->query($sAGroup)->numRows();
                
                if($nAGroup == 0){
                    //Valida BOM
                    $sBOMA = "SELECT * FROM BOM WHERE Parent_Part_Assembly LIKE '$gAssy' AND Item_Nbr NOT LIKE '' ORDER BY Item_Nbr ASC LIMIT 0, 1";
                    $nBOMA = $cnx->query($sBOMA)->numRows();
                    
                    if($nBOMA == 1){
                        //Inserta el Assy
                        $iAssy = "INSERT INTO AssembliesGroup VALUES('0', '0', '$gIDGroup', '$gAssy', '$dtAhora', '$uIDUser', '$uFullName', 'Active')";
                        $rAssy = $cnx->query($iAssy);
                        //echo $iAssy . "<BR>";
                        //Revisa si existe este group en collection
                        $sCol = "SELECT * FROM GroupCollection WHERE idGroup = '$gIDGroup'";
                        $nCol = $cnx->query($sCol)->numRows();
                        
                        if($nCol > 0){
                            if($nCol == 1){
                                $rCol = $cnx->query($sCol)->fetchArray();
                                $gidCol = $rCol['idCollection'];
                                $iAssy = "INSERT INTO AssembliesGroup VALUES('0', '$gIDGroup', '$gidCol', '$gAssy', '$dtAhora', '$uIDUser', '$uFullName', 'Active')";
                                $rAssy = $cnx->query($iAssy);
                                //echo $iAssy . "<BR>";
                        
                            } else {
                                $rCol = $cnx->query($sCol)->fetchAll();
                                foreach ($rCol AS &$rC){
                                    $gidCol = $rC['idCollection'];
                                    $iAssy = "INSERT INTO AssembliesGroup VALUES('0', '$gIDGroup', '$gidCol', '$gAssy', '$dtAhora', '$uIDUser', '$uFullName', 'Active')";
                                    $rAssy = $cnx->query($iAssy);
                                    //echo $iAssy . "<BR>";
                        
                                }
                            }
                        }
                        
                        
                        $vAMensaje = "Assemby $gAssy added Successfully, redirect...";
                        //Redirecciona al view
                        $vATipo = "Verde";
                        $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=vGroup&token=$gettoken";
                        $vATime = 1000;
                        //N echo $vRedirect;
                        echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                        
                    } else {
                        //No existe BOM
                        $vAMensaje = "Assemby $gAssy not exist on BOM, redirect...";
                        //Redirecciona al view
                        $vATipo = "Rojo";
                        $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=vGroup&token=$gettoken";
                        $vATime = 2000;
                        //N echo $vRedirect;
                        echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                    }
                    
                } else {
                    //existe
                    $vAMensaje = "Assemby $gAssy already exist, redirect...";
                    //Redirecciona al view
                    $vATipo = "Rojo";
                    $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=vGroup&token=$gettoken";
                    $vATime = 2000;
                    //N echo $vRedirect;
                    echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                    
                }
                
                
                break;
            case "AddAssembly":
                if(empty($gIDGroup)){
                    $gIDGroup = base64_decode($_GET['token']);
                }
                
                $gettoken = base64_encode($gIDGroup);
                
                //Info del Group
                $sIG = "SELECT * FROM AssGroup WHERE idGroup = '$gIDGroup'";
                $rIG = $cnx->query($sIG)->fetchArray();
                //Name
                $gGroupCode = $rIG['GroupCode'];
                $gGroupName = $rIG['GroupName'];
                $gQtyAss = $rIG['QtyAss'];
                
                $info = "<font class='Robs'>"
                        . "Group Code: <b>$gGroupCode</b><BR>"
                        . "Group Name: <b>$gGroupName</b><BR>"
                        . "Qty Assemblies: <b>$gQtyAss</b>"
                        . "</font>";
                //subir files
                //Titulo, Size, Info, Alert
                $aGForm = array("Add Assembly", "60%", "$info", "");
                //Link, Title, target, class, $sI, SII, $sIII, $sIV, token, tokeni, tokenii
                $aLinks = array(
                    array("", "< Back", "", "linkr", "", "$sI", "$sII", "$sIII", "vGroup", "$gettoken", "", "")
                );
                
                //campos: action, label, id, class, tipo, name, value, checked, selected, focus  
                $aFields = array(
                    array("index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=s$sIV&token=$gettoken", "", "formx", "formx", "post", "addfile", "", "", "", ""),
                    array("", "Assembly:", "Assy", "text", "text", "Assy", "", "", " required='required' ", "1")
                );
                echo drawForm($aGForm, $aLinks, $aFields);
                break;
            case "vGroup":
                if(empty($gIDGroup)){
                    $gIDGroup = base64_decode($_GET['token']);
                }
                
                $gettoken = base64_encode($gIDGroup);
                
                //Info del Group
                $sIG = "SELECT * FROM AssGroup WHERE idGroup = '$gIDGroup'";
                $rIG = $cnx->query($sIG)->fetchArray();
                //Name
                $gGroupCode = $rIG['GroupCode'];
                $gGroupName = $rIG['GroupName'];
                $gQtyAss = $rIG['QtyAss'];
                
                $info = "<font class='Robs'>"
                        . "Group Code: <b>$gGroupCode</b><BR>"
                        . "Group Name: <b>$gGroupName</b><BR>"
                        . "Qty Assemblies: <b>$gQtyAss</b>"
                        . "</font>";
                
                
                $aGList = array("Assemblies for<BR>$gGroupCode Group", "80%", "", "$info", "0", "PO");
                //Data
                $aLinks = array(
                    array("", "< Back", "", "linkr", "", "$sI", "$sII", "$sIII", "Home", "$gettoken", "", "")
                );

                if($uAccount == "Admin" || $uAccount == "SuperUser"){
                    $aLinks[] = array("", "[+] Add Assembly", "", "linkr", "", "$sI", "$sII", "$sIII", "AddAssembly", "$gettoken", "", "");
                }
                
                
                if(isset($_GET['search'])){
                    if($_GET['search'] == 1){
                        $frase = $_POST['search'];

                        $getqry = "SELECT * "
                            . "FROM POApproval WHERE (VendorName LIKE '$frase' OR PO LIKE '%$frase%' "
                                . ") AND Status = 'Open' ORDER BY POCreated ASC";

                    }

                } else {
                    
                    $getqry = "SELECT * "
                        . "FROM AssembliesGroup WHERE "
                        . "Status = 'Active' AND idGroup = '$gIDGroup'"
                        . "ORDER BY Assembly ASC";
                }

                //echo $getqry;

                $aColumns = array(
                    array("", "tr_class", "tit_col_center", "#", "tit_col_center", "+", "tit_col_center", "Assembly", "tit_col_center", "Group Code", "tit_col_center", "Group", "tit_col_center", "Status")
                );
                $LRows = $cnx->query("$getqry")->fetchAll();
                foreach ($LRows as &$LRowsx) {
                    $count++;
                    $countr++;

                    $getidAGroup = $LRowsx['idAGroup'];
                    $getidGroup = $LRowsx['idGroup'];
                    $getAssembly = $LRowsx['Assembly'];
                    //$getGroupName = $LRowsx['GroupName'];
                    //$getQtyAss = $LRowsx['QtyAss'];
                    $getModifiedOn = $LRowsx['ModifiedOn'];
                    $getStatus = $LRowsx['Status'];
                    

                    if($countr == 2){
                        $bcolor = "#E7E7E7";
                        $countr = 0;
                    } else {
                        $bcolor = "#FFFFFF";
                    }

                    $gettoken = base64_encode($gIDGroup);
                    $gettokeni = base64_encode($getidAGroup);

                    $goptions = "";
                    //N$count = "$count - $uAccount";
                    /*
                    $goptions .= "<a href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=vGroup&token=$gettoken&tokeni=$gettokeni&tokenii=$gettokenii'"
                        . " target='_self' title='Edit $getGroupName'>"
                        . "<img src='Images/Edit.svg' title='Edit $getGroup' width='16' border='0'></a>";
                     * 
                     */
                    
                    //Para superuser
                    if($uAccount == "Admin" || $uAccount == "SuperUser"){
                        $goptions .= "<a href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=DeleteAssy&token=$gettoken&tokeni=$gettokeni&tokenii=$gettokenii'"
                            . " target='_self' title='Delete Assembly'>"
                            . "<img src='Images/Trash.svg' title='Delete Assembly' width='16' border='0'></a>";
                    }
                    
                    $aColumns[] = array("$bcolor", "", "col_center", "$count", "col_center", "$goptions", "col_center", "$getAssembly", "col_center", "$gGroupCode", "col_center", "$gGroupName", "col_center", "$getStatus");


                }

                echo drawList($aGList, $aLinks, $aColumns);
                break;
            case "sAddGroup":
                $gGroupCode = $_POST['GroupCode'];
                $gGroupName = $_POST['GroupName'];
                
                //Revisa si existe
                $sGroup = "SELECT * FROM AssGroup WHERE GroupCode LIKE '$gGroupCode' OR GroupName LIKE '$gGroupName' ORDER BY idGroup ASC LIMIT 0, 1";
                $nGroup = $cnx->query($sGroup)->numRows();
                
                if($nGroup == 0){
                    $sGID = "SELECT MAX(idGroup) AS mid FROM AssGroup";
                    $rGID = $cnx->query($sGID)->fetchArray();
                    $gID = $rGID['mid'] + 1;
                    
                    $gettoken = base64_encode($gID);
                    
                    //No Existe
                    $iGroup = "INSERT INTO AssGroup VALUES('$gID', 'Group', '$gGroupCode', '$gGroupName', '0', '$dtAhora', '$uIDUser', '$uFullName', 'Active')";
                    $rGroup = $cnx->query($iGroup);
                    
                    $vAMensaje = "Group $gGroupCode added successfully...";
                    
                    
                } else {
                    //existe
                    $vAMensaje = "Group $gGroupCode already exist, redirect...";
                    $rGroup = $cnx->query($sGroup)->fetchArray();
                    $gID = $rGroup['idGroup'];
                    $gettoken = base64_encode($gID);
                    
                }
                
                //Redirecciona al view
                $vATipo = "Verde";
                $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=vGroup&token=$gettoken";
                $vATime = 1000;
                //N echo $vRedirect;
                echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                
                break;
            case "AddGroup":
                //subir files
                //Titulo, Size, Info, Alert
                $aGForm = array("Add Group", "60%", "", "");
                //Link, Title, target, class, $sI, SII, $sIII, $sIV, token, tokeni, tokenii
                $aLinks = array(
                    array("", "< Back", "", "linkr", "", "$sI", "$sII", "$sIII", "Home", "$gettoken", "", "")
                );
                
                //campos: action, label, id, class, tipo, name, value, checked, selected, focus  
                $aFields = array(
                    array("index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=s$sIV&token=$gettoken", "", "formx", "formx", "post", "addfile", "", "", "", ""),
                    array("", "Group Code:", "GroupCode", "text", "text", "GroupCode", "", "", " required='required' ", "1"),
                    array("", "<BR>Group Name:", "GroupName", "text", "text", "GroupName", "", "", " required='required' ", "")
                );
                echo drawForm($aGForm, $aLinks, $aFields);
                break;
            case "sAddCGroup":
                if(empty($gIDGroup)){
                    $gIDGroup = base64_decode($_GET['token']);
                }
                
                $gettoken = base64_encode($gIDGroup);
                
                //Info del Group
                $sIG = "SELECT * FROM AssGroup WHERE idGroup = '$gIDGroup'";
                $rIG = $cnx->query($sIG)->fetchArray();
                //Name
                $gGroupCode = $rIG['GroupCode'];
                $gGroupName = $rIG['GroupName'];
                $gQtyAss = $rIG['QtyAss'];
                
                $giGroup = $_POST['GroupCode'];
                
                $sIx = "SELECT * FROM AssGroup WHERE idGroup = '$giGroup'";
                $rI = $cnx->query($sIx)->fetchArray();
                //Name
                $gGCode = $rI['GroupCode'];
                $gGName = $rI['GroupName'];
                
                //Busca si existe
                $sEx = "SELECT * FROM GroupCollection WHERE idCollection = '$gIDGroup' AND idGroup = '$giGroup'";
                $nEx = $cnx->query($sEx)->numRows();
                
                if($nEx == 0){
                    //agrega el codigo
                    $siG = "INSERT INTO GroupCollection VALUES('0', '$gIDGroup', '$giGroup', '$gGCode', '$dtAhora', '$uIDUser', '$uFullName', 'Active')";
                    $riG = $cnx->query($siG);
                    //Agrega los ensambles
                    $sAss = "SELECT DISTINCT Assembly FROM AssembliesGroup WHERE idGroup = '$giGroup'";
                    $rAss = $cnx->query($sAss)->fetchAll();
                    //print_r($rAss);
                    
                    foreach ($rAss AS &$rA){
                        $A_3 = $rA['Assembly'];
                        
                        //Busca si existe
                        $sExx = "SELECT Assembly FROM AssembliesGroup WHERE idInGroup = '$giGroup' AND idGroup = '$gIDGroup' AND Assembly = '$A_3'";
                        $nExx = $cnx->query($sExx)->numRows();
                        //echo $sExx . "<BR>";
                        
                        if($nExx == 0){
                            //echo "$A_0 - $A_1 - $A_2 - $A_3<BR>";
                            $iAssy = "INSERT INTO AssembliesGroup VALUES('0', '$giGroup', '$gIDGroup', '$A_3', '$dtAhora', '$uIDUser', '$uFullName', 'Active')";
                            $rAssy = $cnx->query($iAssy);
                            //echo $iAssy . "<BR>";
                        } else {
                            //echo $A_3 . "Existente<BR>";
                        }
                        
                        
                    }
                    
                    
                    $vATipo = "Verde";
                    $vAMensaje = "Group $gGCode added, redirect...";
                    $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=vCollection&token=$gettoken";
                    $vATime = 1000;
                    //N echo $vRedirect;
                    echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                    
                } else {
                    //Ya existe
                    //Redirecciona al view
                    $vAMensaje = "Group $gGCode already exist, redirect...";
                    //Redirecciona al view
                    $vATipo = "Rojo";
                    $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=vCollection&token=$gettoken";
                    $vATime = 1000;
                    //N echo $vRedirect;
                    echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                }
                
                
                break;
            case "AddCGroup":
                if(empty($gIDGroup)){
                    $gIDGroup = base64_decode($_GET['token']);
                }
                
                $gettoken = base64_encode($gIDGroup);
                
                //Info del Group
                $sIG = "SELECT * FROM AssGroup WHERE idGroup = '$gIDGroup'";
                $rIG = $cnx->query($sIG)->fetchArray();
                //Name
                $gGroupCode = $rIG['GroupCode'];
                $gGroupName = $rIG['GroupName'];
                $gQtyAss = $rIG['QtyAss'];
                
                $info = "<font class='Robs'>"
                        . "Collection Code: <b>$gGroupCode</b><BR>"
                        . "Collection Name: <b>$gGroupName</b><BR>"
                        . "Qty Groups: <b>$gQtyAss</b>"
                        . "</font>";
                //subir files
                //Titulo, Size, Info, Alert
                $aGForm = array("Add Group", "60%", "", "");
                //Link, Title, target, class, $sI, SII, $sIII, $sIV, token, tokeni, tokenii
                $aLinks = array(
                    array("", "< Back", "", "linkr", "", "$sI", "$sII", "$sIII", "vCollection", "$gettoken", "", "")
                );
                
                //Busca los groups
                $vGroups = "";
                $qGr = "SELECT idGroup, GroupCode FROM AssGroup WHERE GType = 'Group' ORDER BY GroupCode ASC";
                $rGr = $cnx->query($qGr)->fetchAll();
                
                foreach ($rGr AS &$rG){
                    $idg = $rG['idGroup'];
                    $gc = $rG['GroupCode'];
                    
                    $vGroups .= "$idg:$gc|";
                }
                //echo $vGroups;
                $vGroups = substr($vGroups, 0, -1);
                //echo $vGroups;
                
                //campos: action, label, id, class, tipo, name, value, checked, selected, focus  
                $aFields = array(
                    array("index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=s$sIV&token=$gettoken", "", "formx", "formx", "post", "addfile", "", "", "", ""),
                    array("", "Group Code:", "GroupCode", "stext", "select", "GroupCode", "$vGroups", "", " required='required' ", "1")
                );
                echo drawForm($aGForm, $aLinks, $aFields);
                break;
            case "DeleteCGroup":
                if(empty($gIDGroup)){
                    $gIDGroup = base64_decode($_GET['token']);
                    $gidAGroup = base64_decode($_GET['tokeni']);
                }
                
                $gettoken = base64_encode($gIDGroup);
                $gettokeni = base64_encode($gidAGroup);
                //Info del Group
                $sIG = "SELECT * FROM AssGroup WHERE idGroup = '$gIDGroup'";
                $rIG = $cnx->query($sIG)->fetchArray();
                //Name
                $gGroupCode = $rIG['GroupCode'];
                $gGroupName = $rIG['GroupName'];
                $gQtyAss = $rIG['QtyAss'];
                
                //Elimina
                $dGroup = "DELETE FROM AssembliesGroup";
                
                
                break;
            case "vCollection":
                if(empty($gIDGroup)){
                    $gIDGroup = base64_decode($_GET['token']);
                    
                }
                
                $gettoken = base64_encode($gIDGroup);
                
                //Info del Group
                $sIG = "SELECT * FROM AssGroup WHERE idGroup = '$gIDGroup'";
                $rIG = $cnx->query($sIG)->fetchArray();
                //Name
                $gGroupCode = $rIG['GroupCode'];
                $gGroupName = $rIG['GroupName'];
                $gQtyAss = $rIG['QtyAss'];
                
                $info = "<font class='Robs'>"
                        . "Collection Code: <b>$gGroupCode</b><BR>"
                        . "Collection Name: <b>$gGroupName</b><BR>"
                        . "Qty Groups: <b>$gQtyAss</b>"
                        . "</font>";
                
                
                $aGList = array("Collection for<BR>$gGroupCode Group", "80%", "", "$info", "0", "PO");
                //Data
                $aLinks = array(
                    array("", "< Back", "", "linkr", "", "$sI", "$sII", "$sIII", "Home", "$gettoken", "", "")
                );

                if($uAccount == "Admin" || $uAccount == "SuperUser"){
                    $aLinks[] = array("", "[+] Add Group", "", "linkr", "", "$sI", "$sII", "$sIII", "AddCGroup", "$gettoken", "", "");
                }
                
                
                if(isset($_GET['search'])){
                    if($_GET['search'] == 1){
                        $frase = $_POST['search'];

                        $getqry = "SELECT * "
                            . "FROM POApproval WHERE (VendorName LIKE '$frase' OR PO LIKE '%$frase%' "
                                . ") AND Status = 'Open' ORDER BY POCreated ASC";

                    }

                } else {
                    
                    $getqry = "SELECT * "
                        . "FROM GroupCollection WHERE "
                        . "Status = 'Active' AND idCollection = '$gIDGroup' "
                        . "ORDER BY CGroup ASC";
                }

                //echo $getqry;

                $aColumns = array(
                    array("", "tr_class", "tit_col_center", "#", "tit_col_center", "+", "tit_col_center", "Group", "tit_col_center", "DemandName", "tit_col_center", "Qty Assembly", "tit_col_center", "Group Code", "tit_col_center", "Group", "tit_col_center", "Status")
                );
                $LRows = $cnx->query("$getqry")->fetchAll();
                foreach ($LRows as &$LRowsx) {
                    $count++;
                    $countr++;

                    $getidAGroup = $LRowsx['idAGroup'];
                    $getidCollection = $LRowsx['idCollection'];
                    $getidGroup = $LRowsx['idGroup'];
                    $getCGroup = $LRowsx['CGroup'];
                    //$getGroupName = $LRowsx['GroupName'];
                    //$getQtyAss = $LRowsx['QtyAss'];
                    $getModifiedOn = $LRowsx['ModifiedOn'];
                    $getStatus = $LRowsx['Status'];
                    
                    //Obtriene cantidad de npartes
                    $snp = "SELECT DISTINCT Assembly FROM AssembliesGroup WHERE idInGroup = '$getidGroup' AND idGroup = '$getidCollection'";
                    //echo $snp . "<BR>";
                    $nAssy = $cnx->query($snp)->numRows();

                    if($countr == 2){
                        $bcolor = "#E7E7E7";
                        $countr = 0;
                    } else {
                        $bcolor = "#FFFFFF";
                    }

                    $gettoken = base64_encode($gIDGroup);
                    $gettokeni = base64_encode($getidAGroup);

                    $goptions = "";
                    //N$count = "$count - $uAccount";
                    /*
                    $goptions .= "<a href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=vGroup&token=$gettoken&tokeni=$gettokeni&tokenii=$gettokenii'"
                        . " target='_self' title='Edit $getGroupName'>"
                        . "<img src='Images/Edit.svg' title='Edit $getGroup' width='16' border='0'></a>";
                     * 
                     */
                    
                    //Para superuser
                    if($uAccount == "Admin" || $uAccount == "SuperUser"){
                        $goptions .= "<a href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=DeleteCGroup&token=$gettoken&tokeni=$gettokeni&tokenii=$gettokenii'"
                            . " target='_self' title='Delete Group'>"
                            . "<img src='Images/Trash.svg' title='Delete Group' width='16' border='0'></a>";
                    }
                    
                    //Demand
                    $gDemandName = $getCGroup . "_Collection";
                    $aColumns[] = array("$bcolor", "", "col_center", "$count", "col_center", "$goptions", "col_center", "$getCGroup", "col_center", "$gDemandName", "col_center", "$nAssy", "col_center", "$gGroupCode", "col_center", "$gGroupName", "col_center", "$getStatus");


                }

                echo drawList($aGList, $aLinks, $aColumns);
                break;
            case "sAddCollection":
                $gCollectionCode = $_POST['CollectionCode'];
                $gCollectionName = $_POST['CollectionName'];
                
                //Revisa si existe
                $sGroup = "SELECT * FROM AssGroup WHERE GroupCode LIKE '$gCollectionCode' OR GroupName LIKE '$gCollectionName' ORDER BY idGroup ASC LIMIT 0, 1";
                $nGroup = $cnx->query($sGroup)->numRows();
                
                if($nGroup == 0){
                    $sGID = "SELECT MAX(idGroup) AS mid FROM AssGroup";
                    $rGID = $cnx->query($sGID)->fetchArray();
                    $gID = $rGID['mid'] + 1;
                    
                    $gettoken = base64_encode($gID);
                    
                    //No Existe
                    $iGroup = "INSERT INTO AssGroup VALUES('$gID', 'Collection', '$gCollectionCode', '$gCollectionName', '0', '$dtAhora', '$uIDUser', '$uFullName', 'Active')";
                    $rGroup = $cnx->query($iGroup);
                    
                    $vAMensaje = "Collection $gCollectionCode added successfully...";
                    
                    
                } else {
                    //existe
                    $vAMensaje = "Collection $gCollectionCode already exist, redirect...";
                    $rGroup = $cnx->query($sGroup)->fetchArray();
                    $gID = $rGroup['idGroup'];
                    $gettoken = base64_encode($gID);
                    
                }
                
                //Redirecciona al view
                $vATipo = "Verde";
                $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=vCollection&token=$gettoken";
                $vATime = 1000;
                //N echo $vRedirect;
                echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                
                break;
            case "AddCollection":
                //subir files
                //Titulo, Size, Info, Alert
                $aGForm = array("Add Collection", "60%", "", "");
                //Link, Title, target, class, $sI, SII, $sIII, $sIV, token, tokeni, tokenii
                $aLinks = array(
                    array("", "< Back", "", "linkr", "", "$sI", "$sII", "$sIII", "Home", "$gettoken", "", "")
                );
                
                //campos: action, label, id, class, tipo, name, value, checked, selected, focus  
                $aFields = array(
                    array("index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=s$sIV&token=$gettoken", "", "formx", "formx", "post", "addfile", "", "", "", ""),
                    array("", "Collection Code:", "CollectionCode", "text", "text", "CollectionCode", "", "", " required='required' ", "1"),
                    array("", "<BR>Collection Name:", "CollectionName", "text", "text", "CollectionName", "", "", " required='required' ", "")
                );
                echo drawForm($aGForm, $aLinks, $aFields);
                break;
            case "DeleteGroup":
                if(empty($gIDGroup)){
                    $gIDGroup = base64_decode($_GET['token']);
                }
                
                $gettoken = base64_encode($gIDGroup);
                
                //Info del Group
                $sIG = "SELECT * FROM AssGroup WHERE idGroup = '$gIDGroup'";
                $rIG = $cnx->query($sIG)->fetchArray();
                //Name
                $gGroupCode = $rIG['GroupCode'];
                $gGroupName = $rIG['GroupName'];
                $gQtyAss = $rIG['QtyAss'];
                
                
                //Elimina el Group
                $dG = "DELETE FROM AssGroup WHERE idGroup = '$gIDGroup'";
                //echo $dG;
                $rG = $cnx->query($dG);
                
                //Elimina el Ensambles Group
                $dA = "DELETE FROM AssembliesGroup WHERE idGroup = '$gIDGroup'";
                //echo $dA;
                $rA = $cnx->query($dA);
                $vAMensaje = "Group Deleted, redirect...";
                $vATipo = "Verde";
                $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=Home&token=$gettoken";
                $vATime = 1000;
                //N echo $vRedirect;
                echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                
                break;
            case "DeleteCollection":
                if(empty($gIDGroup)){
                    $gIDGroup = base64_decode($_GET['token']);
                }
                
                $gettoken = base64_encode($gIDGroup);
                
                //Info del Group
                $sIG = "SELECT * FROM AssGroup WHERE idGroup = '$gIDGroup'";
                $rIG = $cnx->query($sIG)->fetchArray();
                //Name
                $gGroupCode = $rIG['GroupCode'];
                $gGroupName = $rIG['GroupName'];
                $gQtyAss = $rIG['QtyAss'];
                
                
                //Elimina el Group
                $dG = "DELETE FROM AssGroup WHERE idGroup = '$gIDGroup'";
                //echo $dG;
                $rG = $cnx->query($dG);
                
                //Elimina el Ensambles Group
                $dA = "DELETE FROM AssembliesGroup WHERE idGroup = '$gIDGroup'";
                //echo $dA;
                $rA = $cnx->query($dA);
                
                //Elimina el Ensambles Group
                $dX = "DELETE FROM GroupCollection WHERE idCollection = '$gIDGroup'";
                //echo $dX;
                $rAd = $cnx->query($dX);
                
                //$rA = $cnx->query($dA);
                $vAMensaje = "Collection Deleted, redirect...";
                $vATipo = "Verde";
                $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=Home&token=$gettoken";
                $vATime = 1000;
                //N echo $vRedirect;
                echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                
                break;
            case "Home":
                $aGList = array("Assemblies Group", "80%", "", "", "0", "PO");
                //Data
                $aLinks = array(
                    array("", "< Refresh", "", "linkr", "", "$sI", "$sII", "$sIII", "Home", "$gettoken", "", "")
                );

                if($uAccount == "Admin" || $uAccount == "SuperUser"){
                    $aLinks[] = array("", "[>] Validation Group", "", "linkr", "", "$sI", "$sII", "$sIII", "validationGroup", "$gettoken", "", "");
                    $aLinks[] = array("", "[+] Upload Group", "", "linkr", "", "$sI", "$sII", "$sIII", "UploadGroup", "$gettoken", "", "");
                    $aLinks[] = array("", "[+] Add Group", "", "linkr", "", "$sI", "$sII", "$sIII", "AddGroup", "$gettoken", "", "");
                    $aLinks[] = array("", "[+] Add Collection", "", "linkr", "", "$sI", "$sII", "$sIII", "AddCollection", "$gettoken", "", "");
                }
                
                
                if(isset($_GET['search'])){
                    if($_GET['search'] == 1){
                        $frase = $_POST['search'];

                        $getqry = "SELECT * "
                            . "FROM POApproval WHERE (VendorName LIKE '$frase' OR PO LIKE '%$frase%' "
                                . ") AND Status = 'Open' ORDER BY POCreated ASC";

                    }

                } else {
                    
                    $getqry = "SELECT * "
                        . "FROM AssGroup WHERE "
                        . "Status != 'Disabled' "
                        . "ORDER BY GroupName ASC";
                }

                //echo $getqry;

                $aColumns = array(
                    array("", "tr_class", "tit_col_center", "#", "tit_col_center", "+", "tit_col_center", "Group Type", "tit_col_center", "Group Code", "tit_col_center", "Group", "tit_col_center", "Qty Assembly", "tit_col_center", "Status")
                );
                $LRows = $cnx->query("$getqry")->fetchAll();
                foreach ($LRows as &$LRowsx) {
                    $count++;
                    $countr++;

                    $getidGroup = $LRowsx['idGroup'];
                    $getGroupCode = $LRowsx['GroupCode'];
                    $getGType = $LRowsx['GType'];
                    $getGroupName = $LRowsx['GroupName'];
                    $getQtyAss = $LRowsx['QtyAss'];
                    $getModifiedOn = $LRowsx['ModifiedOn'];
                    $getStatus = $LRowsx['Status'];
                    

                    if($countr == 2){
                        $bcolor = "#E7E7E7";
                        $countr = 0;
                    } else {
                        $bcolor = "#FFFFFF";
                    }

                    $gettoken = base64_encode($getidGroup);

                    $goptions = "";
                    //N$count = "$count - $uAccount";
                    
                    $goptions .= "<a href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=v$getGType&token=$gettoken&tokeni=$gettokeni&tokenii=$gettokenii'"
                        . " target='_self' title='Edit $getGroupName'>"
                        . "<img src='Images/Edit.svg' title='Edit $getGroup' width='16' border='0'></a>";
                    
                    //Para superuser
                    if($uAccount == "Admin" || $uAccount == "SuperUser"){
                        $goptions .= "<a href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=Delete$getGType&token=$gettoken&tokeni=$gettokeni&tokenii=$gettokenii'"
                            . " target='_self' title='Delete Group'>"
                            . "<img src='Images/Trash.svg' title='Delete Group' width='16' border='0'></a>";
                    }
                    
                    $aColumns[] = array("$bcolor", "", "col_center", "$count", "col_center", "$goptions", "col_center", "$getGType", "col_center", "$getGroupCode", "col_center", "$getGroupName", "col_center", "$getQtyAss", "col_center", "$getStatus");


                }

                echo drawList($aGList, $aLinks, $aColumns);
                break;
        }
        break;
    case "POUrgency":
        switch ($sIV){
            case "sAddUrgency":
                $getidPOApproval = base64_decode($_GET['token']);
                $getPart = base64_decode($_GET['tokeni']);
                $gettoken = base64_encode($getidPOApproval);
                $gettokeni = base64_encode($getPart);
                $getQ = "SELECT * FROM POApproval WHERE idPOApproval = '$getidPOApproval'";
                $nApp = $cnx->query($getQ)->numRows();
                //echo $getQ . "<BR>";
                
                //echo $getQ;
                
                if($nApp == 1){
                    //Existe
                    $LRows = $cnx->query("$getQ")->fetchArray();
                    $getidPOApproval = $LRows['idPOApproval'];
                    $getClassCode = $LRows['ClassCode'];
                    $getVendorName = $LRows['VendorName'];
                    $getPO = $LRows['PO'];
                    $getStatus = $LRows['Status'];
                    $getQtyDel = $LRows['QtyDel'];
                    $getBuyer = $LRows['Buyer'];
                    $getQtyNParts = $LRows['QtyNParts'];
                    $getQtyParts = $LRows['QtyParts'];
                    $getTotalValue = $LRows['TotalValue'];
                    $getPOCreated = $LRows['POCreated'];
                    $getTotalValueF = "<b>$ " . number_format($getTotalValue, 4) . "</b>";
                    $info = "<font class='Rob'>"
                            . "PO: <b>$getPO</b><br>"
                            . "Part: <b>$getPart</b><br>"
                            . "</font>";
                    
                    $getTracking = strtoupper($_POST['tracking']);
                    
                    $sMU = "SELECT MAX(idUrgency) AS mid FROM POUrgency";
                    $rMU = $cnx->query($sMU)->fetchArray();
                    $gIDUrg = $rMU['mid'] + 1;
                    $gUrgency = "URG" . str_pad($gIDUrg, 8, "0", STR_PAD_LEFT); 
                    
                    //Insert Urgency
                    $iU = "INSERT INTO POUrgency VALUES("
                            . "'$gIDUrg', '$gUrgency', '$getPO', '$getPart', '$getTracking', '$dtAhora', "
                            . "'$uFullName', '$dtAhora', '', '', '$dtAhora', "
                            . "'', '$dtAhora', '', '$dtAhora', '', '$dtAhora', 'Open')";
                    $rU = $cnx->query($iU);
                    
                    //actualiza pod
                    $uPod = "UPDATE PodData SET V_Status = '$gUrgency' WHERE Purch_Order_Number = '$getPO' AND Part_Nbr = '$getPart'";
                    $rP = $cnx->query($uPod);
                    
                    $vATipo = "Verde";
                    $vAMensaje = "PO & Part Urgency Added";
                    $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=POControl&sIV=vOrder&token=$gettoken";
                    $vATime = 1000;
                    //N echo $vRedirect;
                    echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                    
                } else {
                    $vATipo = "Rojo";
                    $vAMensaje = "PO Not exist";
                    $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=POControl&sIV=vOrder&token=$gettoken";
                    $vATime = 1000;
                    //N echo $vRedirect;
                    echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                }
                break;
            case "AddUrgency":
                $getidPOApproval = base64_decode($_GET['token']);
                $getPart = base64_decode($_GET['tokeni']);
                $gettoken = base64_encode($getidPOApproval);
                $gettokeni = base64_encode($getPart);
                $getQ = "SELECT * FROM POApproval WHERE idPOApproval = '$getidPOApproval'";
                $nApp = $cnx->query($getQ)->numRows();
                //echo $getQ . "<BR>";
                
                //echo $getQ;
                
                if($nApp == 1){
                    //Existe
                    $LRows = $cnx->query("$getQ")->fetchArray();
                    $getidPOApproval = $LRows['idPOApproval'];
                    $getClassCode = $LRows['ClassCode'];
                    $getVendorName = $LRows['VendorName'];
                    $getPO = $LRows['PO'];
                    $getStatus = $LRows['Status'];
                    $getQtyDel = $LRows['QtyDel'];
                    $getBuyer = $LRows['Buyer'];
                    $getQtyNParts = $LRows['QtyNParts'];
                    $getQtyParts = $LRows['QtyParts'];
                    $getTotalValue = $LRows['TotalValue'];
                    $getPOCreated = $LRows['POCreated'];
                    $getTotalValueF = "<b>$ " . number_format($getTotalValue, 4) . "</b>";
                    $info = "<font class='Rob'>"
                            . "PO: <b>$getPO</b><br>"
                            . "Part: <b>$getPart</b><br>"
                            . "</font>";
                    
                    //Titulo, Size, Info, Alert
                    $aGForm = array("Add Urgency", "60%", "$info", "");
                    //Link, Title, target, class, $sI, SII, $sIII, $sIV, token, tokeni, tokenii
                    $aLinks = array(
                        array("", "< Back", "", "linkr", "", "$sI", "$sII", "POControl", "vOrder", "$gettoken", "", "")
                    );

                    
                    //campos: action, label, id, class, tipo, name, value, checked, selected, focus  
                    $aFields = array(
                        array("index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=s$sIV&token=$gettoken&tokeni=$gettokeni", "", "formx", "formx", "post", "addfile", "", "", "", ""),
                        array("", "Tracking:", "tracking", "text", "text", "tracking", "", "", " required='required' ", "1")
                    );
                    echo drawForm($aGForm, $aLinks, $aFields);
                    
                    
                } else {
                    $vATipo = "Rojo";
                    $vAMensaje = "PO Not exist";
                    $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=POControl&sIV=vOrder&token=$gettoken";
                    $vATime = 1000;
                    //N echo $vRedirect;
                    echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                }
                
                break;
            case "Home":
                //Obtiene las Parts
                $aGList = array("PO Urgency", "80%", "", "$info", "0", "PO, Part");
                //Data
                $aLinks = array(
                    array("", "< Refresh", "", "linkr", "", "$sI", "$sII", "$sIII", "Home", "$gettoken", "", ""),
                    array("", "[+] Add Urgency", "", "linkr", "", "$sI", "$sII", "$sIII", "AddUrgency", "$gettoken", "", "")
                );


                if(isset($_GET['search'])){
                    if($_GET['search'] == 1){
                        $frase = $_POST['search'];

                        $getqry = "SELECT * "
                            . "FROM POApproval WHERE (VendorName LIKE '$frase' OR PO LIKE '%$frase%' "
                                . ") AND Status = 'Open' ORDER BY POCreated ASC";

                    }

                } else {

                    $getqry = "SELECT * "
                        . "FROM POUrgency WHERE "
                        . "Status != 'Closed' "
                        . "ORDER BY idUrgency DESC";




                }

                //echo $getqry;

                $aColumns = array(
                    array("", "tr_class", "tit_col_center", "#", "tit_col_center", "+", "tit_col_center", "Part", "tit_col_center", "Description", "tit_col_center", "Lne_Nbr", "tit_col_center", "Qty", "tit_col_center", "Price", "tit_col_center", "Acctg_Value", "tit_col_center", "Tracking")
                );
                $LRowsy = $cnx->query($getqry)->fetchAll();
                foreach ($LRowsy as &$LRowsx) {
                    $count++;
                    $countr++;

                    $getVendor_Number = $LRowsx['Vendor_Number'];
                    $getLne_Nbr = $LRowsx['Lne_Nbr'];
                    $getPart_Nbr = $LRowsx['Part_Nbr'];
                    $getDescription = $LRowsx['Description'];
                    $getQuantity_Ordered = $LRowsx['Quantity_Ordered'];
                    $getExpected_Delivery_Date = $LRowsx['Expected_Delivery_Date'];
                    $getBalance_Due = $LRowsx['Balance_Due'];
                    $getCurrency_List_Unit_Price = $LRowsx['Currency_List_Unit_Price'];
                    $getVendor_Promise_Dt = $LRowsx['Vendor_Promise_Dt'];
                    $getAcctg_Value = $LRowsx['Acctg_Value'];
                    $getTracking_Nbr = $LRowsx['Tracking_Nbr'];

                    //$getTotalValue = "<b>$ " . number_format($getTotalValue, 4) . "</b>";


                    if($countr == 2){
                        $bcolor = "#E7E7E7";
                        $countr = 0;
                    } else {
                        $bcolor = "#FFFFFF";
                    }

                    $gettoken = base64_encode($getidPOApproval);

                    $goptions = "";
                    //N$count = "$count - $uAccount";
                    /*
                    $goptions .= "<a href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=vOrder&token=$gettoken&tokeni=$gettokeni&tokenii=$gettokenii'"
                        . " target='_self' title='Edit $getPO'>"
                        . "<img src='Images/Edit.svg' title='Edit $getPO' width='16' border='0'></a>";


                    $goptions .= "<a href='index.php?sI=$sI&sII=PPV&sIII=rDeleteDraft&sIV=Home&token=$gettoken&tokeni=$gettokeni&tokenii=$gettokenii'"
                        . " target='_self' title='Delete $getPPV'>"
                        . "<img src='Images/Trash.svg' title='Delete $getPPV' width='16' border='0'></a>";
                    */

                    $aColumns[] = array("$bcolor", "", "col_center", "$count", "col_center", "$goptions", "col_center", "$getPart_Nbr", "col_left", "$getDescription", "col_left", "$getLne_Nbr", "col_center", "$getQuantity_Ordered", "col_center", "$getCurrency_List_Unit_Price", "col_right", "$getAcctg_Value", "col_right", "$getTracking_Nbr");


                }

                echo drawList($aGList, $aLinks, $aColumns);
                break;
        }
        break;
    case "POControl":
        switch($sIV){
            case "sReject":
                $getidPOApproval = base64_decode($_GET['token']);
                $gettoken = base64_encode($getidPOApproval);
                $getQ = "SELECT * FROM POApproval WHERE idPOApproval = '$getidPOApproval'";
                $nApp = $cnx->query($getQ)->numRows();
                //echo $getQ . "<BR>";
                
                //echo $getQ;
                
                if($nApp == 1){
                    //Existe
                    $LRows = $cnx->query("$getQ")->fetchArray();
                    $getidPOApproval = $LRows['idPOApproval'];
                    $getClassCode = $LRows['ClassCode'];
                    $getVendorName = $LRows['VendorName'];
                    $getPO = $LRows['PO'];
                    $getStatus = $LRows['Status'];
                    $getQtyDel = $LRows['QtyDel'];
                    $getBuyer = $LRows['Buyer'];
                    $getQtyNParts = $LRows['QtyNParts'];
                    $getQtyParts = $LRows['QtyParts'];
                    $getTotalValue = $LRows['TotalValue'];
                    $getPOCreated = $LRows['POCreated'];
                    $getTotalValueF = "<b>$ " . number_format($getTotalValue, 2) . "</b>";
                    
                    $gComments = htmlentities($_POST['comments']);
                    
                    if($getStatus == "Open"){
                        //Busca el PO
                        $sPOL = "SELECT * FROM POLevApproval WHERE idUser = '$uIDUser' AND Status = 'Active'";
                        $nPOL = $cnx->query($sPOL)->numRows();
                        
                        if($nPOL == 1 || $uAccount == "Admin"){
                            //Revisa cantidad de aprovacion
                            $rPOL = $cnx->query($sPOL)->fetchArray();
                            $gMinV = $rPOL['MinVal'];
                            $gMaxV = $rPOL['MaxVal'];
                            
                            if($getTotalValue <= $gMaxV || $uAccount == "Admin"){
                                //Opcion de aprobar
                                $uApp = "UPDATE POApproval SET "
                                        . "iduApproval = '$uIDUser', uApproval = '$uFullName', "
                                        . "uNotes = '$gComments', dtApproval = '$dtAhora', Status = 'Rejected' "
                                        . "WHERE idPOApproval = '$getidPOApproval'";
                                $ruA = $cnx->query($uApp);
                                
                                //Registro historial
                                $iHist = "INSERT INTO POApprovalHist VALUES("
                                        . "'0', '$getidPOApproval', '$getPO', 'Rejected', '$gComments', "
                                        . "'$dtAhora', '$uIDUser', '$uFullName', '$dtAhora', 'Rejected')";
                                $rH = $cnx->query($iHist);
                                
                                $Bcode = "https://www.softwaredevelop.mx/refurbish/barcode/barcode.processor.php?encode=QRCODE&bdata=&qrdata_type=link&qr_link_link=";
                                $getWKey = urlencode("https://www.softwaredevelop.mx/MW/VPO.php?St=" . base64_encode($getidPOApproval));
                                //https://www.softwaredevelop.mx/refurbish/barcode/barcode.processor.php?encode=QRCODE&bdata=&qrdata_type=link&qr_link_link=https://www.softwaredevelopment.mx/
                                
                                $QRCode = $Bcode . $getWKey;
                                $linkCode = $uFullName . "|" . $dtAhora . "|" . $getPO . "|" . $getVendorName . "|<BR>" . base64_encode($getWKey) . "<BR><BR>";
                                
                                //Add Email
                                $logoDash = "https://www.softwaredevelop.mx/masterwork/Images/print.png";
                                $MessPrincipal = "<table width=\'100%\' cellpadding=\'0\' cellspacing=\'0\'>"
                                    . "<tr>"
                                    . "<td colspan=\'2\' width=\'50%\'>"
                                    . "<font style=\'font-size:3em;\'><b>PO ($getPO) - <font style=\'color:red;\'>Rejected</font></b></font><BR>"
                                    . "<font style=\'color:gray;\'>Rejected On: $dtAhora</font>"
                                    . "</td>"
                                    . "<td align=\'center\' width=\'150\'><a href=\'http://mex-mds-001/Supply/\' target=\'\'>"
                                    . "<img src=\'$logoDash\' width=\'50\' title=\'Dashboard\' border=\'0\'><br>Print PO ($getPO)</a>"
                                    . "<br><br></td></tr>"
                                        . "<tr>"
                                        . "<td colspan=\'2\'>"
                                        . "<font style=\'font-size:1em;color:black;\'>"
                                        . "Vendor: <b>$getVendorName</b><br>"
                                        . "Total PO: <b>$getTotalValueF</b><br>"
                                        . "Created On: <b>$getPOCreated</b><br><br>"
                                        . "<b>Comments:</b><br>"
                                        . "$gComments"
                                        . "<br><br>"
                                        . "</td>"
                                        . "<td></td>"
                                        . "</tr>"
                                    . "</table>";

                                $MessMail = $MessPrincipal;

                                $AppInfo = "App: <B>Supply</B><BR>Site: <a href=\'http://mex-mds-001/Supply/\'>Supply Site</a><BR>Date: <b>$dtAhora</b>";
                                $SubjectEmail = "($getPO) Rejected ($dtAhora)";
                                $ToEmail = "rossy.murillo@masterworkelectronics.com, mario.chavez@masterworkelectronics.com, aurelio.leal@masterworkelectronics.com, andrea@masterworkelectronics.com";
                                //$ToEmail = "mario.chavez@masterworkelectronics.com";
                                $FromEmail = "btb@masterworkelectronics.com";

                                //Manda Correo
                                $iEmail = "INSERT INTO dbEmail VALUES('0', '$AppInfo', '$SubjectEmail', '$ToEmail', '$FromEmail', '$MessMail', '$FromEmail', '$dtAhora', '', 'Open')";
                                $rEmail = $cnx->query($iEmail);
                                
                                $vATipo = "Verde";
                                $vAMensaje = "Rejected successfully";
                                $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=Home&token=$gettoken";
                                $vATime = 1000;
                                //N echo $vRedirect;
                                echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                                
                            } else {
                                //Not Autorize
                                $vATipo = "Rojo";
                                $vAMensaje = "User not Autorized";
                                $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=Home&token=$gettoken";
                                $vATime = 1000;
                                //N echo $vRedirect;
                                echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                                
                            }
                            
                        } else {
                            //Not Exist
                            $vATipo = "Rojo";
                            $vAMensaje = "User not active";
                            $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=Home&token=$gettoken";
                            $vATime = 1000;
                            //N echo $vRedirect;
                            echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                        }
                    } else {
                        //No Status
                        $vATipo = "Rojo";
                        $vAMensaje = "Status $getStatus No Valid";
                        $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=vOrder&token=$gettoken";
                        $vATime = 1000;
                        //N echo $vRedirect;
                        echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                    }
                    
                    
                } else {
                    $vATipo = "Rojo";
                    $vAMensaje = "PO Not exist";
                    $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=Home&token=$gettoken";
                    $vATime = 1000;
                    //N echo $vRedirect;
                    echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                    
                }
                break;
            case "Reject":
                $getidPOApproval = base64_decode($_GET['token']);
                $gettoken = base64_encode($getidPOApproval);
                $getQ = "SELECT * FROM POApproval WHERE idPOApproval = '$getidPOApproval'";
                $nApp = $cnx->query($getQ)->numRows();
                //echo $getQ . "<BR>";
                
                //echo $getQ;
                
                if($nApp == 1){
                    //Existe
                    $LRows = $cnx->query("$getQ")->fetchArray();
                    $getidPOApproval = $LRows['idPOApproval'];
                    $getClassCode = $LRows['ClassCode'];
                    $getVendorName = $LRows['VendorName'];
                    $getPO = $LRows['PO'];
                    $getStatus = $LRows['Status'];
                    $getQtyDel = $LRows['QtyDel'];
                    $getBuyer = $LRows['Buyer'];
                    $getQtyNParts = $LRows['QtyNParts'];
                    $getQtyParts = $LRows['QtyParts'];
                    $getTotalValue = $LRows['TotalValue'];
                    $getPOCreated = $LRows['POCreated'];
                    $getTotalValueF = "<b>$ " . number_format($getTotalValue, 2) . "</b>";
                    $info = "<font class='Rob'>"
                            . "PO: <b>$getPO</b><br>"
                            . "Total: <font style='color:red;'><b>$getTotalValueF</b></font>"
                            . "</font>";
                    
                    //Titulo, Size, Info, Alert
                    $aGForm = array("Reject PO", "60%", "$info", "");
                    //Link, Title, target, class, $sI, SII, $sIII, $sIV, token, tokeni, tokenii
                    $aLinks = array(
                        array("", "< Back", "", "linkr", "", "$sI", "$sII", "$sIII", "vOrder", "$gettoken", "", "")
                    );

                    
                    //campos: action, label, id, class, tipo, name, value, checked, selected, focus  
                    $aFields = array(
                        array("index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=s$sIV&token=$gettoken", "", "formx", "formx", "post", "addfile", "", "", "", ""),
                        array("", "Comments:", "comments", "text", "textarea", "comments", "50|4", "", "", "1")
                    );
                    echo drawForm($aGForm, $aLinks, $aFields);
                    
                    
                } else {
                    $vATipo = "Rojo";
                    $vAMensaje = "PO Not exist";
                    $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=Home&token=$gettoken";
                    $vATime = 1000;
                    //N echo $vRedirect;
                    echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                }
                
                break;
            case "sApprove":
                $getidPOApproval = base64_decode($_GET['token']);
                $gettoken = base64_encode($getidPOApproval);
                $getQ = "SELECT * FROM POApproval WHERE idPOApproval = '$getidPOApproval'";
                $nApp = $cnx->query($getQ)->numRows();
                //echo $getQ . "<BR>";
                
                //echo $getQ;
                
                if($nApp == 1){
                    //Existe
                    $LRows = $cnx->query("$getQ")->fetchArray();
                    $getidPOApproval = $LRows['idPOApproval'];
                    $getPO = $LRows['PO'];
                    $getPOCreated = $LRows['POCreated'];
                    $getBuyer = $LRows['Buyer'];
                    $getClassCode = $LRows['ClassCode'];
                    $getCustomer = $LRows['Customer'];
                    $getVendorName = $LRows['VendorName'];
                    $getQtyDel = $LRows['QtyDel'];
                    $getQtyNParts = $LRows['QtyNParts'];
                    $getQtyParts = $LRows['QtyParts'];
                    $getTotalValue = $LRows['TotalValue'];
                    $getTotalValueF = "<b>$ " . number_format($getTotalValue, 2) . "</b>";
                    $getTerms = $LRows['Terms'];
                    $getdtTerms = $LRows['dtTerms'];
                    $getTypeApproval = $LRows['TypeApproval'];
                    $getiduRequested = $LRows['iduRequested'];
                    $getuRequested = $LRows['uRequested'];
                    $getuNotes = $LRows['uNotes'];
                    $getiduApproval = $LRows['iduApproval'];
                    $getuApproval = $LRows['uApproval'];
                    $getuANotes = $LRows['uANotes'];
                    $getdtApproval = $LRows['dtApproval'];
                    $getStatus = $LRows['Status'];
                    $getdtOpen = $LRows['dtOpen'];
                    $getdtClosed = $LRows['dtClosed'];
                    
                    $gComments = htmlentities($_POST['comments']);
                    
                    if($getStatus == "Open" || $getStatus == "Rejected"){
                        //Busca el PO
                        $sPOL = "SELECT * FROM POLevApproval WHERE idUser = '$uIDUser' AND Status = 'Active'";
                        $nPOL = $cnx->query($sPOL)->numRows();
                        
                        if($nPOL == 1 || $uAccount == "Admin"){
                            //Revisa cantidad de aprovacion
                            $rPOL = $cnx->query($sPOL)->fetchArray();
                            $gMinV = $rPOL['MinVal'];
                            $gMaxV = $rPOL['MaxVal'];
                            
                            if($getTotalValue <= $gMaxV || $uAccount == "Admin"){
                                //Opcion de aprobar
                                $Randw = rand();
                                $uApp = "UPDATE POApproval SET "
                                        . "iduApproval = '$uIDUser', uApproval = '$uFullName', "
                                        . "uNotes = '$Randw', uANotes = '$gComments', dtApproval = '$dtAhora', Status = 'Approved' "
                                        . "WHERE idPOApproval = '$getidPOApproval'";
                                $ruA = $cnx->query($uApp);
                                
                                //Registro historial
                                $iHist = "INSERT INTO POApprovalHist VALUES("
                                        . "'0', '$getidPOApproval', '$getPO', 'Approved', '$gComments', "
                                        . "'$dtAhora', '$uIDUser', '$uFullName', '$dtAhora', 'Approved')";
                                $rH = $cnx->query($iHist);
                                
                                $Bcode = "https://www.softwaredevelop.mx/refurbish/barcode/barcode.processor.php?encode=QRCODE&bdata=&qrdata_type=link&qr_link_link=";
                                $getWKey = urlencode("https://www.softwaredevelop.mx/MW/VPO.php?St=" . base64_encode($getidPOApproval . ":" . $Randw));
                                //https://www.softwaredevelop.mx/refurbish/barcode/barcode.processor.php?encode=QRCODE&bdata=&qrdata_type=link&qr_link_link=https://www.softwaredevelopment.mx/
                                
                                //Dato completo de Approval
                                $getiduApproval = $uIDUser;
                                $getuApproval = $uFullName;
                                $getuNotes = $Randw;
                                $getuANotes = $gComments;
                                $getdtApproval = $dtAhora;
                                $getStatus = "Approved";
                                $getdtTerms = $dtAhora;
                                
                                
                                //Inserta Base de datos
                                $iSD = "INSERT INTO POApproval VALUES("
                                        . "'$getidPOApproval', '$Randw', '$getPO', '$getPOCreated', '$getBuyer', "
                                        . "'$getClassCode', '$getCustomer', '$getVendorName', '$getQtyDel', '$getQtyNParts', "
                                        . "'$getQtyParts', '$getTotalValue', '$getTerms', '$getdtTerms', '$getTypeApproval', "
                                        . "'$getiduRequested', '$getuRequested', '$getuNotes', '$getiduApproval', '$getuApproval', "
                                        . "'$getuANotes', '$getdtApproval', '$getStatus', '$getdtOpen', '$getdtClosed'"
                                        . ")";
                                $rSD = $cnxsd->query($iSD);
                                
                                //Inserta Parts
                                $getqry = "SELECT * "
                                    . "FROM PodData WHERE "
                                    . "Purch_Order_Number = '$getPO' "
                                    . "ORDER BY Quantity_Ordered DESC";
                                $LRowsy = $cnx->query($getqry)->fetchAll();
                                foreach ($LRowsy as &$LRowsx) {
                                    $count++;
                                    $countr++;

                                    $getVendor_Number = $LRowsx['Vendor_Number'];
                                    $getLne_Nbr = $LRowsx['Lne_Nbr'];
                                    $getPart_Nbr = $LRowsx['Part_Nbr'];
                                    $getDescription = $LRowsx['Description'];
                                    $getQuantity_Ordered = $LRowsx['Quantity_Ordered'];
                                    $getExpected_Delivery_Date = $LRowsx['Expected_Delivery_Date'];
                                    $getBalance_Due = $LRowsx['Balance_Due'];
                                    $getCurrency_List_Unit_Price = $LRowsx['Currency_List_Unit_Price'];
                                    $getVendor_Promise_Dt = $LRowsx['Vendor_Promise_Dt'];
                                    $getAcctg_Value = $LRowsx['Acctg_Value'];
                                    $getTracking_Nbr = $LRowsx['Tracking_Nbr'];
                                    $getV_Status = $LRowsx['V_Status'];
                                    $getTotal = $getQuantity_Ordered * $getCurrency_List_Unit_Price;
                                    
                                    
                                    //Inserta parts on SD
                                    $iPart = "INSERT INTO Parts VALUES('0', '$getidPOApproval', '$getPO', '$getPart_Nbr', '$getDescription', "
                                            . "'$getQuantity_Ordered', '$getCurrency_List_Unit_Price', '$getVendorName', '$getTotal', '$dateToday', '', '$dtAhora', '$dtAhora', '$dtAhora', '', 'Open')";
                                    
                                    $rPSD = $cnxsd->query($iPart);
                                    
                                }
                                
                                
                                
                                $QRCode = $Bcode . $getWKey;
                                $getPrint = base64_encode($getidPOApproval . ":" . $Randw);
                                $linkCode = $uFullName . "|" . $dtAhora . "|" . $getPO . "|" . $getVendorName . "|<BR>" . base64_encode($getWKey) . "<BR><BR>";
                                
                                //Add Email
                                $logoDash = "https://www.softwaredevelop.mx/masterwork/Images/print.png";
                                $MessPrincipal = "<table width=\'100%\' cellpadding=\'0\' cellspacing=\'0\'>"
                                    . "<tr>"
                                    . "<td colspan=\'2\' width=\'50%\'>"
                                    . "<font style=\'font-size:3em;\'><b>PO ($getPO) - <font style=\'color:yellowgreen;\'>Approved</font></b></font><BR>"
                                    . "<font style=\'color:gray;\'>Approved On: $dtAhora</font>"
                                    . "</td>"
                                    . "<td align=\'center\' width=\'150\'><a href=\'http://mex-mds-001/Supply/Print.php?sI=PO=$getPrint\' target=\'\'>"
                                    . "<img src=\'$logoDash\' width=\'50\' title=\'Dashboard\' border=\'0\'><br>Print PO ($getPO)</a>"
                                    . "<br><br></td></tr>"
                                        . "<tr>"
                                        . "<td colspan=\'2\'>"
                                        . "<font style=\'font-size:1em;color:black;\'>"
                                        . "Vendor: <b>$getVendorName</b><br>"
                                        . "Total PO: <b>$getTotalValueF</b><br>"
                                        . "Created On: <b>$getPOCreated</b><br><br>"
                                        . "<b>Comments:</b><br>"
                                        . "$gComments"
                                        . "<br><br>"
                                        . "</td>"
                                        . "<td></td>"
                                        . "</tr>"
                                    . "<tr>"
                                        . "<td width=\'10%\'>"
                                        . "Validation Code:<br>"
                                        . "<img src=\'$QRCode\'/>"
                                        . "</fon>"
                                        . "</td>"
                                        . "<td colspan=\'2\' valign=\'bottom\'>"
                                        . "$linkCode"
                                        . "</td>"
                                    . "</tr>"
                                    . "</table>";

                                $MessMail = $MessPrincipal;

                                $AppInfo = "App: <B>Supply</B><BR>Site: <a href=\'http://mex-mds-001/Supply/\'>Supply Site</a><BR>Date: <b>$dtAhora</b>";
                                $SubjectEmail = "($getPO) Approved ($dtAhora)";
                                $ToEmail = "rossy.murillo@masterworkelectronics.com, mario.chavez@masterworkelectronics.com, aurelio.leal@masterworkelectronics.com, andrea@masterworkelectronics.com";
                                //$ToEmail = "mario.chavez@masterworkelectronics.com";
                                $FromEmail = "btb@masterworkelectronics.com";

                                //Manda Correo
                                $iEmail = "INSERT INTO dbEmail VALUES('0', '$AppInfo', '$SubjectEmail', '$ToEmail', '$FromEmail', '$MessMail', '$FromEmail', '$dtAhora', '', 'Open')";
                                $rEmail = $cnx->query($iEmail);
                                
                                $vATipo = "Verde";
                                $vAMensaje = "Autorized usccessfully";
                                $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=Home&token=$gettoken";
                                $vATime = 1000;
                                //N echo $vRedirect;
                                echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                                
                            } else {
                                //Not Autorize
                                $vATipo = "Rojo";
                                $vAMensaje = "User not Autorized";
                                $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=Home&token=$gettoken";
                                $vATime = 1000;
                                //N echo $vRedirect;
                                echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                                
                            }
                            
                        } else {
                            //Not Exist
                            $vATipo = "Rojo";
                            $vAMensaje = "User not active";
                            $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=Home&token=$gettoken";
                            $vATime = 1000;
                            //N echo $vRedirect;
                            echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                        }
                    } else {
                        //No Status
                        $vATipo = "Rojo";
                        $vAMensaje = "Status $getStatus No Valid";
                        $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=vOrder&token=$gettoken";
                        $vATime = 1000;
                        //N echo $vRedirect;
                        echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                    }
                    
                    
                } else {
                    $vATipo = "Rojo";
                    $vAMensaje = "PO Not exist";
                    $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=Home&token=$gettoken";
                    $vATime = 1000;
                    //N echo $vRedirect;
                    echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                    
                }
                break;
            case "Approve":
                $getidPOApproval = base64_decode($_GET['token']);
                $gettoken = base64_encode($getidPOApproval);
                $getQ = "SELECT * FROM POApproval WHERE idPOApproval = '$getidPOApproval'";
                $nApp = $cnx->query($getQ)->numRows();
                //echo $getQ . "<BR>";
                
                //echo $getQ;
                
                if($nApp == 1){
                    //Existe
                    $LRows = $cnx->query("$getQ")->fetchArray();
                    $getidPOApproval = $LRows['idPOApproval'];
                    $getClassCode = $LRows['ClassCode'];
                    $getVendorName = $LRows['VendorName'];
                    $getPO = $LRows['PO'];
                    $getStatus = $LRows['Status'];
                    $getQtyDel = $LRows['QtyDel'];
                    $getBuyer = $LRows['Buyer'];
                    $getQtyNParts = $LRows['QtyNParts'];
                    $getQtyParts = $LRows['QtyParts'];
                    $getTotalValue = $LRows['TotalValue'];
                    $getPOCreated = $LRows['POCreated'];
                    $getTotalValueF = "<b>$ " . number_format($getTotalValue, 2) . "</b>";
                    $info = "<font class='Rob'>"
                            . "PO: <b>$getPO</b><br>"
                            . "Total: <font style='color:red;'><b>$getTotalValueF</b></font>"
                            . "</font>";
                    
                    //Titulo, Size, Info, Alert
                    $aGForm = array("Approve PO", "60%", "$info", "");
                    //Link, Title, target, class, $sI, SII, $sIII, $sIV, token, tokeni, tokenii
                    $aLinks = array(
                        array("", "< Back", "", "linkr", "", "$sI", "$sII", "$sIII", "vOrder", "$gettoken", "", "")
                    );

                    
                    //campos: action, label, id, class, tipo, name, value, checked, selected, focus  
                    $aFields = array(
                        array("index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=s$sIV&token=$gettoken", "", "formx", "formx", "post", "addfile", "", "", "", ""),
                        array("", "Comments:", "comments", "text", "textarea", "comments", "50|4", "", "", "1")
                    );
                    echo drawForm($aGForm, $aLinks, $aFields);
                    
                    
                } else {
                    $vATipo = "Rojo";
                    $vAMensaje = "PO Not exist";
                    $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=Home&token=$gettoken";
                    $vATime = 1000;
                    //N echo $vRedirect;
                    echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                }
                
                break;
            case "sAddUser":
                //Obtiene info
                $gidUser = $_POST['owner'];
                $gMax = $_POST['max'];
                $gMin = $_POST['min'];
                
                $sUs = "SELECT * FROM POLevApproval WHERE idUser = '$gidUser'";
                $nUs = $cnx->query($sUs)->numRows();
                
                $sOwnname = "SELECT * FROM Users WHERE IDUser = '$gidUser' ORDER BY IDUser ASC LIMIT 0, 1";
                $rOwnname = $cnx->query($sOwnname)->fetchArray();
                $gName = $rOwnname['Name'] . " " . $rOwnname['FLastName'];
                
                if($nUs == 1){
                    //Se Actualiza
                    $iU = "UPDATE POLevApproval SET MinVal = '$gMin', MaxVal = '$gMax', "
                            . "ModifiedByID = '$uIDUser', ModifiedBy = '$uFullName', ModifiedOn = '$dtAhora' "
                            . "WHERE idUser = '$gidUser'";
                    $rU = $cnx->query($iU);
                    
                } else {
                    //Se agrega
                    $iU = "INSERT INTO POLevApproval VALUES('0', '$gidUser', '$gName', '$gMin', '$gMax', '$uIDUser', '$uFullName', '$dtAhora', 'Active')";
                    $rU = $cnx->query($iU);
                    
                }
                
                $vATipo = "Verde";
                $vAMensaje = "Approval user added";
                $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=LevelSetup&token=$gettoken";
                $vATime = 1000;
                //N echo $vRedirect;
                echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                
                break;
            case "AddUser":
                //subir files
                //Titulo, Size, Info, Alert
                $aGForm = array("Add User Approval", "60%", "", "");
                //Link, Title, target, class, $sI, SII, $sIII, $sIV, token, tokeni, tokenii
                $aLinks = array(
                    array("", "< Back", "", "linkr", "", "$sI", "$sII", "$sIII", "LevelSetup", "$gettoken", "", "")
                );
                
                //Trae todos los usuarios
                $sSup = "SELECT IDUser, CONCAT(FLastName, ' ', MLastName, ', ', Name) AS name FROM Users ORDER BY FLastName ASC";
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
                
                
                //campos: action, label, id, class, tipo, name, value, checked, selected, focus  
                $aFields = array(
                    array("index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=s$sIV&token=$gettoken", "", "formx", "formx", "post", "addfile", "", "", "", ""),
                    array("", "User:", "owner", "stext", "select", "owner", "$valSup", "", "", "1"),
                    array("", "<br><BR>Min Value:", "min", "text", "number", "min", "", "", " required='required' ", ""),
                    array("", "<BR>Max Value:", "max", "text", "number", "max", "", "", " required='required' ", "")
                );
                echo drawForm($aGForm, $aLinks, $aFields);
                break;
            case "LevelSetup":
                $aGList = array("Approval Level Setup", "60%", "", "", "0", "PO");
                //Data
                $aLinks = array(
                    array("", "< Refresh", "", "linkr", "", "$sI", "$sII", "$sIII", "Home", "$gettoken", "", "")
                );

                if($uAccount == "Admin" || $uAccount == "SuperUser"){
                    $aLinks[] = array("", "[+] Add User", "", "linkr", "", "$sI", "$sII", "$sIII", "AddUser", "$gettoken", "", "");
                }
                
                
                if(isset($_GET['search'])){
                    if($_GET['search'] == 1){
                        $frase = $_POST['search'];

                        $getqry = "SELECT * "
                            . "FROM POApproval WHERE (VendorName LIKE '$frase' OR PO LIKE '%$frase%' "
                                . ") AND Status = 'Open' ORDER BY POCreated ASC";

                    }

                } else {
                    
                    $getqry = "SELECT * "
                        . "FROM POLevApproval WHERE "
                        . "Status = 'Active' "
                        . "ORDER BY MaxVal DESC";

                }

                //echo $getqry;

                $aColumns = array(
                    array("", "tr_class", "tit_col_center", "#", "tit_col_center", "+", "tit_col_center", "User", "tit_col_center", "Min Approve", "tit_col_center", "Max Approve", "tit_col_center", "Status")
                );
                $LRows = $cnx->query($getqry)->fetchAll();
                foreach ($LRows as &$LRowsx) {
                    $count++;
                    $countr++;

                    $getidLApp = $LRowsx['idLApp'];
                    $getidUser = $LRowsx['idUser'];
                    $getUserName = $LRowsx['UserName'];
                    $getMinValue = $LRowsx['MinVal'];
                    $getMaxValue = $LRowsx['MaxVal'];
                    $getStatus = $LRowsx['Status'];
                    
                    $getMinValueF = "<b>$ " . number_format($getMinValue, 0) . "</b>";
                    $getMaxValueF = "<b>$ " . number_format($getMaxValue, 0) . "</b>";
                    

                    if($countr == 2){
                        $bcolor = "#E7E7E7";
                        $countr = 0;
                    } else {
                        $bcolor = "#FFFFFF";
                    }

                    $gettoken = base64_encode($getidPOApproval);

                    $goptions = "";
                    //N$count = "$count - $uAccount";
                    /*
                    $goptions .= "<a href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=vOrder&token=$gettoken&tokeni=$gettokeni&tokenii=$gettokenii'"
                        . " target='_self' title='Edit $getPO'>"
                        . "<img src='Images/Edit.svg' title='Edit $getPO' width='16' border='0'></a>";
                    
                    
                    $goptions .= "<a href='index.php?sI=$sI&sII=PPV&sIII=rDeleteDraft&sIV=Home&token=$gettoken&tokeni=$gettokeni&tokenii=$gettokenii'"
                        . " target='_self' title='Delete $getPPV'>"
                        . "<img src='Images/Trash.svg' title='Delete $getPPV' width='16' border='0'></a>";
                    */

                    $aColumns[] = array("$bcolor", "", "col_center", "$count", "col_center", "$goptions", "col_center", "$getUserName", "col_right", "$getMinValueF", "col_right", "$getMaxValueF", "col_center", "$getStatus");


                }

                echo drawList($aGList, $aLinks, $aColumns);
                break;
            case "vOrder":
                $getidPOApproval = base64_decode($_GET['token']);
                $gettoken = base64_encode($getidPOApproval);
                $getQ = "SELECT * FROM POApproval WHERE idPOApproval = '$getidPOApproval'";
                $nApp = $cnx->query($getQ)->numRows();
                //echo $getQ . "<BR>";
                
                if($nApp == 1){
                    //Existe
                    $LRows = $cnx->query("$getQ")->fetchArray();
                    $getidPOApproval = $LRows['idPOApproval'];
                    $getClassCode = $LRows['ClassCode'];
                    $getVendorName = $LRows['VendorName'];
                    $getPO = $LRows['PO'];
                    $getStatus = $LRows['Status'];
                    $getQtyDel = $LRows['QtyDel'];
                    $getBuyer = $LRows['Buyer'];
                    $getQtyNParts = $LRows['QtyNParts'];
                    $getQtyParts = $LRows['QtyParts'];
                    $getTotalValue = $LRows['TotalValue'];
                    $getPOCreated = $LRows['POCreated'];
                    $getTotalValueF = "<b>$ " . number_format($getTotalValue, 4) . "</b>";
                    
                    
                    $info = "<font class='Rob'>"
                            . "PO: <b>$getPO</b><br>"
                            . "Total: <font style='color:red;'><b>$getTotalValueF</b></font>"
                            . "</font>";
                    
                    
                    
                    
                    //Obtiene las Parts
                    $aGList = array("PO for Approval (Parts)", "80%", "", "$info", "0", "PO");
                    //Data
                    $aLinks = array(
                        array("", "< Back", "", "linkr", "", "$sI", "$sII", "$sIII", "Home", "$gettoken", "", ""),
                        array("", "[>] Print", "", "linkr", "", "$sI", "$sII", "$sIII", "Home", "$gettoken", "", "")
                    );
                    
                    
                    //echo "$getStatus - $uAccount";
                    
                    if($getStatus == "Open" || $getStatus == "Rejected"){
                        //Busca el PO
                        $sPOL = "SELECT * FROM POLevApproval WHERE idUser = '$uIDUser' AND Status = 'Active'";
                        $nPOL = $cnx->query($sPOL)->numRows();
                        
                        if($nPOL == 1 || $uAccount == "Admin"){
                            //Revisa cantidad de aprovacion
                            $rPOL = $cnx->query($sPOL)->fetchArray();
                            $gMinV = $rPOL['MinVal'];
                            $gMaxV = $rPOL['MaxVal'];
                            
                            if($getTotalValue <= $gMaxV || $uAccount == "Admin"){
                                //Opcion de aprobar
                                $aLinks[] = array("", "[*] Approve", "", "linkr", "", "$sI", "$sII", "$sIII", "Approve", "$gettoken", "", "");
                                $aLinks[] = array("", "[-] Reject", "", "linkr", "", "$sI", "$sII", "$sIII", "Reject", "$gettoken", "", "");
                            }
                            
                        }
                    }
                    

                    if(isset($_GET['search'])){
                        if($_GET['search'] == 1){
                            $frase = $_POST['search'];

                            $getqry = "SELECT * "
                                . "FROM POApproval WHERE (VendorName LIKE '$frase' OR PO LIKE '%$frase%' "
                                    . ") AND Status = 'Open' ORDER BY POCreated ASC";

                        }

                    } else {

                        $getqry = "SELECT * "
                            . "FROM PodData WHERE "
                            . "Purch_Order_Number = '$getPO' "
                            . "ORDER BY Quantity_Ordered DESC";




                    }

                    //echo $getqry;

                    $aColumns = array(
                        array("", "tr_class", "tit_col_center", "#", "tit_col_center", "+", "tit_col_center", "Part", "tit_col_center", "Description", "tit_col_center", "Lne_Nbr", "tit_col_center", "Qty", "tit_col_center", "Price", "tit_col_center", "Acctg_Value", "tit_col_center", "Tracking")
                    );
                    $LRowsy = $cnx->query($getqry)->fetchAll();
                    foreach ($LRowsy as &$LRowsx) {
                        $count++;
                        $countr++;

                        $getVendor_Number = $LRowsx['Vendor_Number'];
                        $getLne_Nbr = $LRowsx['Lne_Nbr'];
                        $getPart_Nbr = $LRowsx['Part_Nbr'];
                        $getDescription = $LRowsx['Description'];
                        $getQuantity_Ordered = $LRowsx['Quantity_Ordered'];
                        $getExpected_Delivery_Date = $LRowsx['Expected_Delivery_Date'];
                        $getBalance_Due = $LRowsx['Balance_Due'];
                        $getCurrency_List_Unit_Price = $LRowsx['Currency_List_Unit_Price'];
                        $getVendor_Promise_Dt = $LRowsx['Vendor_Promise_Dt'];
                        $getAcctg_Value = $LRowsx['Acctg_Value'];
                        $getTracking_Nbr = $LRowsx['Tracking_Nbr'];
                        $getV_Status = $LRowsx['V_Status'];

                        //$getTotalValue = "<b>$ " . number_format($getTotalValue, 4) . "</b>";


                        if($countr == 2){
                            $bcolor = "#E7E7E7";
                            $countr = 0;
                        } else {
                            $bcolor = "#FFFFFF";
                        }

                        $gettoken = base64_encode($getidPOApproval);
                        $gettokeni = base64_encode($getPart_Nbr);
                        

                        $goptions = "";
                        //N$count = "$count - $uAccount";
                        
                        if(empty($getV_Status)){
                            //Link Urgency
                            $goptions .= "<a href='index.php?sI=$sI&sII=$sII&sIII=POUrgency&sIV=AddUrgency&token=$gettoken&tokeni=$gettokeni&tokenii=$gettokenii'"
                                . " target='_self' title='Add Priority $getPart_Nbr'>"
                                . "<img src='Images/Add.svg' title='Add Priority $getPart_Nbr' width='16' border='0'></a>";
                        } else {
                            //Show urgency
                            $goptions .= "<a href='index.php?sI=$sI&sII=$sII&sIII=POUrgency&sIV=vUrgency&token=$gettoken&tokeni=$gettokeni&tokenii=$gettokenii'"
                                . " target='_self' title='View Priority $getPart_Nbr'>"
                                . "<img src='Images/Priority.svg' title='View Priority $getPart_Nbr' width='16' border='0'></a>";
                        }
                        
                        /*
                        $goptions .= "<a href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=vOrder&token=$gettoken&tokeni=$gettokeni&tokenii=$gettokenii'"
                            . " target='_self' title='Edit $getPO'>"
                            . "<img src='Images/Edit.svg' title='Edit $getPO' width='16' border='0'></a>";

                        
                        $goptions .= "<a href='index.php?sI=$sI&sII=PPV&sIII=rDeleteDraft&sIV=Home&token=$gettoken&tokeni=$gettokeni&tokenii=$gettokenii'"
                            . " target='_self' title='Delete $getPPV'>"
                            . "<img src='Images/Trash.svg' title='Delete $getPPV' width='16' border='0'></a>";
                        */

                        $aColumns[] = array("$bcolor", "", "col_center", "$count", "col_center", "$goptions", "col_center", "$getPart_Nbr", "col_left", "$getDescription", "col_left", "$getLne_Nbr", "col_center", "$getQuantity_Ordered", "col_center", "$getCurrency_List_Unit_Price", "col_right", "$getAcctg_Value", "col_right", "$getTracking_Nbr");


                    }

                    echo drawList($aGList, $aLinks, $aColumns);
                    
                    
                } else {
                    //No existe
                }
                
                break;
            case "Script":
                //Busca los PO //237361
                //Crea los casos
                /*
                $SumPO = "SELECT Buyer, Class_Code, Part_Nbr, Description, Mfgr_Item_Nbr, Vendor_Name, "
                    . "Purch_Order_Number, Lne_Nbr, Purchase_Order_Add_Date, Status, Tracking_Nbr, "
                    . "SUM(CASE WHEN Vendor_Promise_Dt = '2000-01-01' AND Balance_Due > 0 THEN 1 ELSE 0 END) AS QtyNPromise, "
                    . "SUM(CASE WHEN Vendor_Promise_Dt != '2000-01-01' THEN 1 ELSE 0 END) AS QtyPromise, "
                    . "SUM(CASE WHEN (Vendor_Promise_Dt < NOW() AND Balance_Due > 0 AND Vendor_Promise_Dt != '2000-01-01') THEN 1 ELSE 0 END) AS QtyExpire, "
                    . "COUNT(Part_Nbr) AS QtyDelivery, "
                    . "SUM(Balance_Due) AS SQty FROM PodData "
                    . "WHERE Purch_Order_Number > '237360' AND Disp_Type != 'G' AND Class_Code != '' AND Purch_Order_Number NOT LIKE '9CN%' "
                    . "GROUP BY Buyer, Class_Code, Part_Nbr, Description, Mfgr_Item_Nbr, Vendor_Name, "
                    . "Purch_Order_Number, Lne_Nbr, Purchase_Order_Add_Date, Status ORDER BY Purch_Order_Number ASC";
                */
                $SumPO = "SELECT Buyer, Class_Code, Vendor_Name, Purch_Order_Number, Purchase_Order_Add_Date, "
                    . "COUNT(Part_Nbr) AS QtyDelivery, COUNT(DISTINCT Part_Nbr) AS QtyNParts, "
                    . "SUM(Quantity_Ordered) AS SQty, SUM(Quantity_Ordered * Currency_List_Unit_Price) AS SValue "
                    . "FROM PodData WHERE Purch_Order_Number > '237360' AND Disp_Type != 'G' AND "
                    . "Class_Code != '' AND Purch_Order_Number NOT LIKE '9CN%' "
                    . "GROUP BY Vendor_Name, Purch_Order_Number, Purchase_Order_Add_Date, Status ORDER BY Purch_Order_Number ASC";
                
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
                    //$S_CustomerName = $Customers[$S_Class_Code];

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
                            . "'$idPOA', '$S_Purch_Order_Number', '$S_Purchase_Order_Add_Date', "
                            . "'$S_Buyer', '$S_Class_Code', '$S_Vendor_Name', '$S_QtyDelivery', "
                            . "'$S_QtyNParts', '$S_SQty', '$S_SValue', '', '$S_IDOwner', "
                            . "'$S_Owner', '', '0', '', '', '', 'Open', '$dtAhora', '$dtAhora')";
                    $LPOC = $cnx->query($iPOC);
                    
                    
                }
                
                break;
            case "sPayMethod":
                $getidPOApproval = base64_decode($_GET['token']);
                $gettoken = base64_encode($getidPOApproval);
                $getQ = "SELECT * FROM POApproval WHERE idPOApproval = '$getidPOApproval'";
                $nApp = $cnx->query($getQ)->numRows();
                //echo $getQ . "<BR>";
                
                //echo $getQ;
                
                if($nApp == 1){
                    //Existe
                    $LRows = $cnx->query("$getQ")->fetchArray();
                    $getidPOApproval = $LRows['idPOApproval'];
                    $getClassCode = $LRows['ClassCode'];
                    $getVendorName = $LRows['VendorName'];
                    $getPO = $LRows['PO'];
                    $getStatus = $LRows['Status'];
                    $getQtyDel = $LRows['QtyDel'];
                    $getBuyer = $LRows['Buyer'];
                    $getQtyNParts = $LRows['QtyNParts'];
                    $getQtyParts = $LRows['QtyParts'];
                    $getTotalValue = $LRows['TotalValue'];
                    $getPOCreated = $LRows['POCreated'];
                    $getTotalValueF = "<b>$ " . number_format($getTotalValue, 4) . "</b>";
                    
                    $getPay = $_POST['pay'];
                    $uApp = "UPDATE POApproval SET "
                            . "Terms = '$getPay', dtTerms = '$dtAhora' "
                            . "WHERE idPOApproval = '$getidPOApproval'";
                    $ruA = $cnx->query($uApp);

                    //Registro historial
                    $iHist = "INSERT INTO POApprovalHist VALUES("
                            . "'0', '$getidPOApproval', '$getPO', 'Terms', '$getPay', "
                            . "'$dtAhora', '$uIDUser', '$uFullName', '$dtAhora', 'Terms')";
                    $rH = $cnx->query($iHist);
                    
                    $vATipo = "Verde";
                    $vAMensaje = "Terms added successfully";
                    $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=Home&token=$gettoken";
                    $vATime = 1000;
                    //N echo $vRedirect;
                    echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                    
                } else {
                    $vATipo = "Rojo";
                    $vAMensaje = "PO Not exist";
                    $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=Home&token=$gettoken";
                    $vATime = 1000;
                    //N echo $vRedirect;
                    echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                }
                break;
            case "PayMethod":
                $getidPOApproval = base64_decode($_GET['token']);
                $gettoken = base64_encode($getidPOApproval);
                $getQ = "SELECT * FROM POApproval WHERE idPOApproval = '$getidPOApproval'";
                $nApp = $cnx->query($getQ)->numRows();
                //echo $getQ . "<BR>";
                
                //echo $getQ;
                
                if($nApp == 1){
                    //Existe
                    $LRows = $cnx->query("$getQ")->fetchArray();
                    $getidPOApproval = $LRows['idPOApproval'];
                    $getClassCode = $LRows['ClassCode'];
                    $getVendorName = $LRows['VendorName'];
                    $getPO = $LRows['PO'];
                    $getStatus = $LRows['Status'];
                    $getQtyDel = $LRows['QtyDel'];
                    $getBuyer = $LRows['Buyer'];
                    $getQtyNParts = $LRows['QtyNParts'];
                    $getQtyParts = $LRows['QtyParts'];
                    $getTotalValue = $LRows['TotalValue'];
                    $getPOCreated = $LRows['POCreated'];
                    $getTotalValueF = "<b>$ " . number_format($getTotalValue, 4) . "</b>";
                    $info = "<font class='Rob'>"
                            . "PO: <b>$getPO</b><br>"
                            . "Total: <font style='color:red;'><b>$getTotalValueF</b></font>"
                            . "</font>";
                    
                    //Titulo, Size, Info, Alert
                    $aGForm = array("Payment Method PO", "60%", "$info", "");
                    //Link, Title, target, class, $sI, SII, $sIII, $sIV, token, tokeni, tokenii
                    $aLinks = array(
                        array("", "< Back", "", "linkr", "", "$sI", "$sII", "$sIII", "vOrder", "$gettoken", "", "")
                    );

                    
                    //campos: action, label, id, class, tipo, name, value, checked, selected, focus  
                    $aFields = array(
                        array("index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=s$sIV&token=$gettoken", "", "formx", "formx", "post", "addfile", "", "", "", ""),
                        array("", "Pay Method:", "pay", "stext", "select", "pay", "Terms|Prepayment|Credit Card", "", "", "1")
                    );
                    echo drawForm($aGForm, $aLinks, $aFields);
                    
                    
                } else {
                    $vATipo = "Rojo";
                    $vAMensaje = "PO Not exist";
                    $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=Home&token=$gettoken";
                    $vATime = 1000;
                    //N echo $vRedirect;
                    echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                }
                
                break;
            case "Home":
                $aGList = array("PO for Approval", "80%", "", "", "1", "PO");
                //Data
                $aLinks = array(
                    array("", "< Refresh", "", "linkr", "", "$sI", "$sII", "$sIII", "Home", "$gettoken", "", "")
                );

                if($uAccount == "Admin" || $uAccount == "SuperUser"){
                    $aLinks[] = array("", "[*] Level Setup", "", "linkr", "", "$sI", "$sII", "$sIII", "LevelSetup", "$gettoken", "", "");
                }
                
                
                if(isset($_GET['search'])){
                    if($_GET['search'] == 1){
                        $frase = $_POST['search'];

                        $getqry = "SELECT * "
                            . "FROM POApproval WHERE (VendorName LIKE '$frase' OR PO LIKE '%$frase%' "
                                . ") AND Status = 'Open' ORDER BY POCreated ASC";

                    }

                } else {
                    
                    $getqry = "SELECT * "
                        . "FROM POApproval WHERE "
                        . "Status != 'Approved' "
                        . "ORDER BY POCreated ASC";
                }

                //echo $getqry;

                $aColumns = array(
                    array("", "tr_class", "tit_col_center", "#", "tit_col_center", "+", "tit_col_center", "PO Created", "tit_col_center", "PO", "tit_col_center", "Buyer", "tit_col_center", "ClassCode", "tit_col_center", "Vendor", "tit_col_center", "QtyDel", "tit_col_center", "Qty PN", "tit_col_center", "Qty Parts", "tit_col_center", "Total",  "tit_col_center", "Status")
                );
                $LRows = $cnx->query("$getqry")->fetchAll();
                foreach ($LRows as &$LRowsx) {
                    $count++;
                    $countr++;

                    $getidPOApproval = $LRowsx['idPOApproval'];
                    $getClassCode = $LRowsx['ClassCode'];
                    $getVendorName = $LRowsx['VendorName'];
                    $getPO = $LRowsx['PO'];
                    $getStatus = $LRowsx['Status'];
                    $getQtyDel = $LRowsx['QtyDel'];
                    $getBuyer = $LRowsx['Buyer'];
                    $getQtyNParts = $LRowsx['QtyNParts'];
                    $getQtyParts = $LRowsx['QtyParts'];
                    $getTotalValue = $LRowsx['TotalValue'];
                    $getPOCreated = $LRowsx['POCreated'];
                    $getTerms = $LRowsx['Terms'];
                    
                    $getTotalValue = "<b>$ " . number_format($getTotalValue, 2) . "</b>";
                    

                    if($countr == 2){
                        $bcolor = "#E7E7E7";
                        $countr = 0;
                    } else {
                        $bcolor = "#FFFFFF";
                    }

                    $gettoken = base64_encode($getidPOApproval);

                    $goptions = "";
                    //N$count = "$count - $uAccount";

                    $goptions .= "<a href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=vOrder&token=$gettoken&tokeni=$gettokeni&tokenii=$gettokenii'"
                        . " target='_self' title='Edit $getPO'>"
                        . "<img src='Images/Edit.svg' title='Edit $getPO' width='16' border='0'></a>";
                    
                    if(empty($getTerms)){
                        $goptions .= "<a href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=PayMethod&token=$gettoken&tokeni=$gettokeni&tokenii=$gettokenii'"
                            . " target='_self' title='Payment Method $getPO'>"
                            . "<img src='Images/Money.svg' title='Payment Method $getPO' width='16' border='0'></a>";
                    } else {
                        //Depents
                        switch ($getTerms){
                            case "Terms":
                                $goptions .= "<font class='Robss' style='color:green;'> <b>T</b> </font>";
                                break;
                            case "Prepayment":
                                $goptions .= "<font class='Robss' style='color:red;'> <b>P</b> </font>";
                                break;
                            case "Credit Card":
                                $goptions .= "<font class='Robss' style='color:blue;'> <b>C</b> </font>";
                                break;
                            default :
                                break;
                        }
                    }
                    
                    
                    /*
                    $goptions .= "<a href='index.php?sI=$sI&sII=PPV&sIII=rDeleteDraft&sIV=Home&token=$gettoken&tokeni=$gettokeni&tokenii=$gettokenii'"
                        . " target='_self' title='Delete $getPPV'>"
                        . "<img src='Images/Trash.svg' title='Delete $getPPV' width='16' border='0'></a>";
                    */

                    $aColumns[] = array("$bcolor", "", "col_center", "$count", "col_center", "$goptions", "col_center", "$getPOCreated", "col_center", "$getPO", "col_center", "$getBuyer", "col_center", "$getClassCode", "col_left", "$getVendorName", "col_center", "$getQtyDel", "col_center", "$getQtyNParts", "col_right", "$getQtyParts", "col_right", "$getTotalValue", "col_right", "$getStatus");


                }

                echo drawList($aGList, $aLinks, $aColumns);
                break;
        }
}