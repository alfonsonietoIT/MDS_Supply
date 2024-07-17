<?php
//Data del Graph
$gKeyI = base64_decode($_GET['KeyI']);
$gKeyII = base64_decode($_GET['KeyII']);
$gKeyIII = base64_decode($_GET['KeyIII']);
$gKeyIV = base64_decode($_GET['KeyIV']);
$gKeyV = base64_decode($_GET['KeyV']);
$gKeyVI = base64_decode($_GET['KeyVI']);
$gKeyVII = base64_decode($_GET['KeyVII']);
//echo "$gKeyI - $gKeyII - $gKeyIII";

if(!empty($gKeyI)){
    switch ($gKeyI):
        case "DashInventory":
            $cKey = base64_encode($gKeyI);
            //Dependes
            $gIDOwner = $gKeyII;
            $gCustomer = $gKeyIII;
            $gVendor = $gKeyIV;
            $gRisk = $gKeyV;
            $gStatus = $gKeyVI;
            $gDays = $gKeyVII;
            
            //*********************************************************Titulo
            if(!empty($gIDOwner)){
                $cIDOwner = base64_encode($gIDOwner);
                //Obtiene el nombre del owner
                $sInfoU = "SELECT * FROM Users WHERE IDUser = '$gIDOwner'";
                $rInfoU = $cnx->query($sInfoU)->fetchArray();
                $gOwner = $rInfoU['Name'] . " " . $rInfoU['FLastName'];
                $gTOwner = " Owner: <b>$gOwner</b> ";
                $Extra .= " AND IDBuyer = '$gIDOwner' ";
                
                //echo $sInfoU;
            } else {
                $gTOwner = "";
            }
            
            if(!empty($gCustomer)){
                $cCustomer = base64_encode($gCustomer);
                $gTCustomer = " Customer: <b>$gCustomer</b> ";
                $Extra .= " AND Customer = '$gCustomer' ";
            } else {
                $gTCustomer = "";
            }
            
            if(!empty($gVendor)){
                $cVendor = base64_encode($gVendor);
                $gTVendor = " Vendor: <b>$gVendor</b> ";
                $Extra .= " AND Vendor = '$gVendor' ";
            } else {
                $gTVendor = "";
            }
            
            if(!empty($gRisk)){
                $cRisk = base64_encode($gRisk);
                
                
                switch($gRisk){
                    case "LOW":
                        $Extra .= " AND DATEDIFF('$dtAhora', dateCreated) < '8'";
                        $gTitRisk = "Less than 8 days";
                        break;
                    case "MEDIUM":
                        $Extra .= " AND DATEDIFF('$dtAhora', dateCreated) BETWEEN '8' AND '30'";
                        $gTitRisk = "8 to 30 days";
                        break;
                    case "HIGH":
                        $Extra .= " AND DATEDIFF('$dtAhora', dateCreated) > '30'";
                        $gTitRisk = "More than 30 days";
                        break;
                }
                
                $gTRisk = " Risk: <font style='color:red;'><b>$gTitRisk</b></font> ";
                
            } else {
                $gTRisk = "";
            }
            
            if(!empty($gStatus)){
                $Extra .= " AND Status = '$gStatus' ";
                $cStatus = base64_encode($gStatus);
                $gTStatus = " Status: <font style='color:blue;'><b>$gStatus</b></font> ";
            } else {
                $gTStatus = "";
            }
            
            
            //General Graphic
            $TitleDashboard = "Inventory 2022 Dashboard";
            $SubtitleDashboard = "<font style='color:green;'>Progress</font>";
            $SubtitleDashboardDetail = "$gTOwner $gTCustomer $gTVendor $gTStatus $gTRisk";
            //********************************************************* Grafica Owner
            $GTypeOwner = "PieChartLink";
            $GTitleOwner = "By Owner Chart";
            $GDivOwner = "ownerChart";
            $ArrINFOOwner['SubtitleName'] = "Owner";
            $ArrINFOOwner['SubtitleQty'] = "Qty";
            $ArrINFOOwner['LoadDriver'] = 1;
            if(empty($gIDOwner)){
                $pLinkOwner = "Dashboard.php?KeyI=" . base64_encode("CancelPO") . "&KeyII=";
                //$pLinkOwner = "Include/reportCSV.php?report=GenPOControlDetail&KeyII=$cIDOwner";
                $GSQLOwner = "SELECT BuyerName AS PC_Name, COUNT(DISTINCT idMRP) AS PC_Qty, "
                    . "CONCAT('$pLinkOwner', "
                    . " TO_BASE64(IDBuyer), '&KeyIII=$cCustomer&KeyIV=$cVendor&KeyV=$cRisk&KeyVI=$cStatus&KeyVII=$cDays') AS PC_Link FROM MRPCancel "
                    . "WHERE Status != 'Canceled' "
                    . "$Extra GROUP BY PC_Name ORDER BY PC_Qty DESC";
            
            } else {
                
                /*
                 * SELECT POControl.Owner, PodData.Buyer AS Buyer, COUNT(DISTINCT PodData.idPodData) AS Qty FROM PodData, POControl WHERE PodData.Purch_Order_Number = POControl.Purch_Order_Number AND PodData.Balance_Due > '0' AND PodData.Vendor_Promise_Dt > '2022-01-18' AND PodData.Disp_Type != 'G' AND PodData.Class_Code != '' AND PodData.Purch_Order_Number NOT LIKE '9CN%'  GROUP BY POControl.Owner;
                 */
                $pLinkOwner = "Include/reportCSV.php?report=CancelPO&KeyII=$cIDOwner";
                
                $GSQLOwner = "SELECT BuyerName AS PC_Name, COUNT(DISTINCT idMRP) AS PC_Qty, "
                    . "CONCAT('$pLinkOwner', "
                    . " '&KeyIII=$cCustomer&KeyIV=$cVendor&KeyV=$cRisk&KeyVI=$cStatus&KeyVII=$cDays') AS PC_Link FROM MRPCancel "
                    . "WHERE Status != 'Canceled' "
                    . "$Extra GROUP BY PC_Name ORDER BY PC_Qty DESC";
            
            }
            
            //echo $GSQLOwner;
            
            //Crea el Dashboard
            echo GraphDraw($GTypeOwner, $GTitleOwner, $GDivOwner, $ArrINFOOwner, $GSQLOwner);
            
            //echo "Aqui";
            //********************************************************* Grafica Vendor
            $GTypeVendor = "PieChartLink";
            $GTitleVendor = "By Vendor Chart";
            $GDivVendor = "vendorChart";
            $ArrINFOVendor['SubtitleName'] = "Vendor";
            $ArrINFOVendor['SubtitleQty'] = "Qty";
            $ArrINFOVendor['LoadDriver'] = 0;
            
            if(empty($gVendor)){
                //$pLinkVendor = "Include/reportCSV.php?report=GenPOControlDetail&KeyIV=$cVendor";
                $pLinkVendor = "Dashboard.php?KeyI=" . base64_encode("CancelPO") . "&KeyIV=";
                $GSQLVendor = "SELECT Vendor AS PC_Name, COUNT(DISTINCT idMRP) AS PC_Qty, "
                    . "CONCAT('$pLinkVendor', "
                    . " TO_BASE64(Vendor), '&KeyIII=$cCustomer&KeyII=$cIDOwner&KeyV=$cRisk&KeyVI=$cStatus&KeyVII=$cDays') AS PC_Link FROM MRPCancel "
                    . "WHERE Status != 'Canceled' "
                    . "$Extra GROUP BY PC_Name ORDER BY PC_Qty DESC";
            } else {
                $pLinkVendor = "Include/reportCSV.php?report=CancelPO&KeyIV=$cVendor";
                $GSQLVendor = "SELECT Vendor AS PC_Name, COUNT(DISTINCT idMRP) AS PC_Qty, "
                    . "CONCAT('$pLinkVendor', "
                    . " '&KeyIII=$cCustomer&KeyII=$cIDOwner&KeyV=$cRisk&KeyVI=$cStatus&KeyVII=$cDays') AS PC_Link FROM MRPCancel "
                    . "WHERE Status != 'Canceled' "
                    . "$Extra GROUP BY PC_Name ORDER BY PC_Qty DESC";
            }
            //echo $GSQLVendor;
            
            //Crea el Dashboard
            //echo GraphDraw($GTypeVendor, $GTitleVendor, $GDivVendor, $ArrINFOVendor, $GSQLVendor);
            //echo "Aqui2";
            
            //********************************************************* Grafica Customer
            $GTypeCustomer = "PieChartLink";
            $GTitleCustomer = "By CustomerChart";
            $GDivCustomer = "customerChart";
            $ArrINFOCustomer['SubtitleName'] = "Customer";
            $ArrINFOCustomer['SubtitleQty'] = "Qty";
            $ArrINFOCustomer['LoadDriver'] = 0;
            
            if(empty($gCustomer)){
                $pLinkCustomer = "Dashboard.php?KeyI=" . base64_encode("DashInventory") . "&KeyIII=";
                //$pLinkCustomer = "Include/reportCSV.php?report=GenPOControlDetail&KeyIII=$cCustomer";
                $GSQLCustomer = "SELECT Customer AS PC_Name, COUNT(DISTINCT idMRP) AS PC_Qty, "
                    . "CONCAT('$pLinkCustomer', "
                    . " TO_BASE64(Customer), '&KeyIV=$cVendor&KeyII=$cIDOwner&KeyV=$cRisk&KeyVI=$cStatus&KeyVII=$cDays') AS PC_Link FROM MRPCancel "
                    . "WHERE Status != 'Canceled' "
                    . "$Extra GROUP BY PC_Name ORDER BY PC_Qty DESC";
            } else {
                $pLinkCustomer = "Include/reportCSV.php?report=CancelPO&KeyIII=$cCustomer";
                $GSQLCustomer = "SELECT Customer AS PC_Name, COUNT(DISTINCT idMRP) AS PC_Qty, "
                    . "CONCAT('$pLinkCustomer', "
                    . " '&KeyIV=$cVendor&KeyII=$cIDOwner&KeyV=$cRisk&KeyVI=$cStatus&KeyVII=$cDays') AS PC_Link FROM MRPCancel "
                    . "WHERE Status != 'Canceled' "
                    . "$Extra GROUP BY PC_Name ORDER BY PC_Qty DESC";
            }
            
            //Crea el Dashboard
            //echo GraphDraw($GTypeCustomer, $GTitleCustomer, $GDivCustomer, $ArrINFOCustomer, $GSQLCustomer);
            echo "Aqui3";
            
            //********************************************************* Grafica Conteo
            $GTypeCont = "PieChartLink";
            $GTitleCont = "Total Progress";
            $GDivCont = "customerChart";
            $ArrINFOCont['SubtitleName'] = "Progress";
            $ArrINFOCont['SubtitleQty'] = "Qty";
            $ArrINFOCont['LoadDriver'] = 0;
            
            $gValid = "";
            
            if(empty($gValid)){
                $pLinkCont = "Dashboard.php?KeyI=" . base64_encode("DashInventory") . "&KeyIII=";
                //$pLinkCustomer = "Include/reportCSV.php?report=GenPOControlDetail&KeyIII=$cCustomer";
                $GSQLCont = "SELECT DateCounted AS PC_Name, COUNT(DISTINCT TagID) AS PC_Qty, "
                    . "CONCAT('$pLinkCont', "
                    . " TO_BASE64(DateCounted), '&KeyIV=$cVendor&KeyII=$cIDOwner&KeyV=$cRisk&KeyVI=$cStatus&KeyVII=$cDays') AS PC_Link FROM DashInventory "
                    . "$Extra GROUP BY PC_Name ORDER BY PC_Qty DESC";
            } else {
                $pLinkCont = "Include/reportCSV.php?report=CancelPO&KeyIII=$cCustomer";
                $GSQLCont = "SELECT Customer AS PC_Name, COUNT(DISTINCT idMRP) AS PC_Qty, "
                    . "CONCAT('$pLinkCont', "
                    . " '&KeyIV=$cVendor&KeyII=$cIDOwner&KeyV=$cRisk&KeyVI=$cStatus&KeyVII=$cDays') AS PC_Link FROM MRPCancel "
                    . "WHERE Status != 'Canceled' "
                    . "$Extra GROUP BY PC_Name ORDER BY PC_Qty DESC";
                
            }
            
            echo $GSQLCont;
            
            //Crea el Dashboard
            echo GraphDraw($GTypeCont, $GTitleCont, $GDivCont, $ArrINFOCont, $GSQLCont);
            
            echo "Aqui4";
            
            //echo $GSQLRisk;
            //********************************************************* Grafica Status
            $GTypeStatus = "PieChartLink";
            $GTitleStatus = "By Status Chart";
            $GDivStatus = "statusChart";
            $ArrINFOCustomer['SubtitleName'] = "Status";
            $ArrINFOCustomer['SubtitleQty'] = "Qty";
            $ArrINFOCustomer['LoadDriver'] = 0;
            
            if(empty($gStatus)){
                $pLinkStatus = "Dashboard.php?KeyI=" . base64_encode("Valid") . "&KeyVI=";
                $pLinkStatus = "Include/reportCSV.php?report=GenPOControlDetail&KeyVI=$cStatus";
                $GSQLStatus = "SELECT Status AS PC_Name, COUNT(DISTINCT idPodData) AS PC_Qty, "
                    . "CONCAT('$pLinkStatus', "
                    . " TO_BASE64(Status), '&KeyIII=$cCustomer&KeyIV=$cVendor&KeyII=$cIDOwner&KeyV=$cRisk&KeyVII=$cDays') AS PC_Link FROM PodData "
                    . "WHERE Balance_Due > '0' AND Disp_Type != 'G' AND PodData.Class_Code != '' AND Purch_Order_Number NOT LIKE '9CN%' "
                    . "$Extra GROUP BY PC_Name ORDER BY PC_Qty DESC";
            } else {
                $pLinkStatus = "Include/reportCSV.php?report=ActPOControlDetail&KeyIII=$cCustomer";
                $GSQLStatus = "SELECT Status AS PC_Name, COUNT(DISTINCT idPodData) AS PC_Qty, "
                    . "CONCAT('$pLinkStatus', "
                    . " '&KeyIV=$cVendor&KeyII=$cIDOwner&KeyV=$cRisk&KeyVI=$cStatus&KeyVII=$cDays') AS PC_Link FROM PodData "
                    . "WHERE Balance_Due > '0' AND Vendor_Promise_Dt >= '$dateToday' AND Disp_Type != 'G' AND PodData.Class_Code != '' AND Purch_Order_Number NOT LIKE '9CN%' "
                    . "$Extra GROUP BY PC_Name ORDER BY PC_Qty DESC";
            }
            
            //Crea el Dashboard
            //echo GraphDraw($GTypeStatus, $GTitleStatus, $GDivStatus, $ArrINFOStatus, $GSQLStatus);
            
            
            //********************************************************* Tabla
            //Obtiene fecha del ultimo POD
            $SPOD = "SELECT dtAdded FROM PodData ORDER BY dtAdded DESC LIMIT 0, 1";
            $rPOD = $cnx->query($SPOD)->fetchArray();
            $dtPOD = $rPOD['dtAdded'];
            
            $FGraph = "<div style='padding:3px;position:fixed;top:70px;left:180px;text-align:left;'>"
                    . "<form action='Include/reportCSV.php?' target='_blank' method='get'>"
                    . "<font class='Robss' style='color:red;'>Open PO by Part Number<BR></font>"
                    . "<input class='text' type='text' id='Key' name='Key' holder='Part Number'>"
                    . "<input class='text' type='hidden' id='report' name='report' value='PNPOControlDetail'>"
                    . "</form>"
                    . "</div>";
            
            $FGraph = "";
            
            $FGraph .= "<table width='100%'>";
            $FGraph .= "<tr>"
                    . "<td width='25%' align='left'><font class='Exs'></font></td>"
                    . "<td colspan='2' align='center'><font class='Ex'>$TitleDashboard</font></td>"
                    . "<td width='25%' align='right'><font class='Robsss'><b>Updated on:</b><br></font><font class='Robss'>$dtPOD</font></td>"
                    . "</tr>"
                    . "<tr>"
                    . "<td width='25%' align='left'><font class='Exs'></font></td>"
                    . "<td colspan='2' align='center'><font class='Robs'>$SubtitleDashboard</font><BR>"
                    . "<font class='Robss'>$SubtitleDashboardDetail</font>"
                    . "</td>"
                    . "<td width='25%' align='right'><font class='Robsss'>"
                    . "<a href='Include/reportCSV.php?report=HoldMaterial&KeyI=$cKeyI&KeyII=$cIDOwner&KeyIII=$cCustomer&KeyIV=$cVendor&KeyV=$cRisk&KeyVI=$cStatus&KeyVII=$cDays' target='_blank'><img src='Images/xls.svg' width='30'></a>"
                    . "</td>"
                    . "</tr>"
                    . "<tr><td colspan='4' height='40'></td></tr>";
            $FGraph .= "<tr>"
                    . "<td colspan='2' width='50%' align='center'><font class='Exss'>$GTitleOwner</font><br><div id='$GDivOwner' style='height:400px;'></div></td>"
                    . "</td>"
                    . "<td colspan='2' width='50%' align='center'><font class='Exss'>$GTitleVendor</font><br><div id='$GDivVendor' style='height:400px;'></div></td>"
                    . "</tr>";
            $FGraph .= "<tr><td width='100%' colspan='4' align='center'><table width='100%'>";
            $FGraph .= "<tr>"
                    . "<td align='center' width='33%'><font class='Exss'>$GTitleCustomer</font><br><div id='$GDivCustomer' style='height:400px;'></div></td>"
                    . "</td>"
                    . "<td align='center' width='34%'><font class='Exss'>$GTitleCont</font><br><div id='$GDivCont' style='height:400px;'></div></td>"
                    . "<td align='center' width='33%'><font class='Exss'>$GTitleStatus</font><br><div id='$GDivStatus' style='height:400px;'></div></td>"
                    . "</tr>";
            $FGraph .= "</table></td></tr>";
            $FGraph .= "</table>";
            $FGraph .= "<script lang='javascript/text'>"
                    . "function resetear(){ document.location.reload(); }"
                    . "setTimeout(resetear, 50000);"
                    . "</script>";
            break;
        case "CancelPO":
            $cKey = base64_encode($gKeyI);
            //Dependes
            $gIDOwner = $gKeyII;
            $gCustomer = $gKeyIII;
            $gVendor = $gKeyIV;
            $gRisk = $gKeyV;
            $gStatus = $gKeyVI;
            $gDays = $gKeyVII;
            
            //*********************************************************Titulo
            if(!empty($gIDOwner)){
                $cIDOwner = base64_encode($gIDOwner);
                //Obtiene el nombre del owner
                $sInfoU = "SELECT * FROM Users WHERE IDUser = '$gIDOwner'";
                $rInfoU = $cnx->query($sInfoU)->fetchArray();
                $gOwner = $rInfoU['Name'] . " " . $rInfoU['FLastName'];
                $gTOwner = " Owner: <b>$gOwner</b> ";
                $Extra .= " AND IDBuyer = '$gIDOwner' ";
                
                //echo $sInfoU;
            } else {
                $gTOwner = "";
            }
            
            if(!empty($gCustomer)){
                $cCustomer = base64_encode($gCustomer);
                $gTCustomer = " Customer: <b>$gCustomer</b> ";
                $Extra .= " AND Customer = '$gCustomer' ";
            } else {
                $gTCustomer = "";
            }
            
            if(!empty($gVendor)){
                $cVendor = base64_encode($gVendor);
                $gTVendor = " Vendor: <b>$gVendor</b> ";
                $Extra .= " AND Vendor = '$gVendor' ";
            } else {
                $gTVendor = "";
            }
            
            if(!empty($gRisk)){
                $cRisk = base64_encode($gRisk);
                
                
                switch($gRisk){
                    case "LOW":
                        $Extra .= " AND DATEDIFF('$dtAhora', dateCreated) < '8'";
                        $gTitRisk = "Less than 8 days";
                        break;
                    case "MEDIUM":
                        $Extra .= " AND DATEDIFF('$dtAhora', dateCreated) BETWEEN '8' AND '30'";
                        $gTitRisk = "8 to 30 days";
                        break;
                    case "HIGH":
                        $Extra .= " AND DATEDIFF('$dtAhora', dateCreated) > '30'";
                        $gTitRisk = "More than 30 days";
                        break;
                }
                
                $gTRisk = " Risk: <font style='color:red;'><b>$gTitRisk</b></font> ";
                
            } else {
                $gTRisk = "";
            }
            
            if(!empty($gStatus)){
                $Extra .= " AND Status = '$gStatus' ";
                $cStatus = base64_encode($gStatus);
                $gTStatus = " Status: <font style='color:blue;'><b>$gStatus</b></font> ";
            } else {
                $gTStatus = "";
            }
            
            
            //General Graphic
            $TitleDashboard = "Cancel POs Dashboard";
            $SubtitleDashboard = "<font style='color:green;'>General</font> Impact";
            $SubtitleDashboardDetail = "$gTOwner $gTCustomer $gTVendor $gTStatus $gTRisk";
            //********************************************************* Grafica Owner
            $GTypeOwner = "PieChartLink";
            $GTitleOwner = "By Owner Chart";
            $GDivOwner = "ownerChart";
            $ArrINFOOwner['SubtitleName'] = "Owner";
            $ArrINFOOwner['SubtitleQty'] = "Qty";
            $ArrINFOOwner['LoadDriver'] = 1;
            if(empty($gIDOwner)){
                $pLinkOwner = "Dashboard.php?KeyI=" . base64_encode("CancelPO") . "&KeyII=";
                //$pLinkOwner = "Include/reportCSV.php?report=GenPOControlDetail&KeyII=$cIDOwner";
                $GSQLOwner = "SELECT BuyerName AS PC_Name, COUNT(DISTINCT idMRP) AS PC_Qty, "
                    . "CONCAT('$pLinkOwner', "
                    . " TO_BASE64(IDBuyer), '&KeyIII=$cCustomer&KeyIV=$cVendor&KeyV=$cRisk&KeyVI=$cStatus&KeyVII=$cDays') AS PC_Link FROM MRPCancel "
                    . "WHERE Status != 'Canceled' "
                    . "$Extra GROUP BY PC_Name ORDER BY PC_Qty DESC";
            
            } else {
                
                /*
                 * SELECT POControl.Owner, PodData.Buyer AS Buyer, COUNT(DISTINCT PodData.idPodData) AS Qty FROM PodData, POControl WHERE PodData.Purch_Order_Number = POControl.Purch_Order_Number AND PodData.Balance_Due > '0' AND PodData.Vendor_Promise_Dt > '2022-01-18' AND PodData.Disp_Type != 'G' AND PodData.Class_Code != '' AND PodData.Purch_Order_Number NOT LIKE '9CN%'  GROUP BY POControl.Owner;
                 */
                $pLinkOwner = "Include/reportCSV.php?report=CancelPO&KeyII=$cIDOwner";
                
                $GSQLOwner = "SELECT BuyerName AS PC_Name, COUNT(DISTINCT idMRP) AS PC_Qty, "
                    . "CONCAT('$pLinkOwner', "
                    . " '&KeyIII=$cCustomer&KeyIV=$cVendor&KeyV=$cRisk&KeyVI=$cStatus&KeyVII=$cDays') AS PC_Link FROM MRPCancel "
                    . "WHERE Status != 'Canceled' "
                    . "$Extra GROUP BY PC_Name ORDER BY PC_Qty DESC";
            
            }
            
            //echo $GSQLOwner;
            
            //Crea el Dashboard
            echo GraphDraw($GTypeOwner, $GTitleOwner, $GDivOwner, $ArrINFOOwner, $GSQLOwner);
            
            //echo "Aqui";
            //********************************************************* Grafica Vendor
            $GTypeVendor = "PieChartLink";
            $GTitleVendor = "By Vendor Chart";
            $GDivVendor = "vendorChart";
            $ArrINFOVendor['SubtitleName'] = "Vendor";
            $ArrINFOVendor['SubtitleQty'] = "Qty";
            $ArrINFOVendor['LoadDriver'] = 0;
            
            if(empty($gVendor)){
                //$pLinkVendor = "Include/reportCSV.php?report=GenPOControlDetail&KeyIV=$cVendor";
                $pLinkVendor = "Dashboard.php?KeyI=" . base64_encode("CancelPO") . "&KeyIV=";
                $GSQLVendor = "SELECT Vendor AS PC_Name, COUNT(DISTINCT idMRP) AS PC_Qty, "
                    . "CONCAT('$pLinkVendor', "
                    . " TO_BASE64(Vendor), '&KeyIII=$cCustomer&KeyII=$cIDOwner&KeyV=$cRisk&KeyVI=$cStatus&KeyVII=$cDays') AS PC_Link FROM MRPCancel "
                    . "WHERE Status != 'Canceled' "
                    . "$Extra GROUP BY PC_Name ORDER BY PC_Qty DESC";
            } else {
                $pLinkVendor = "Include/reportCSV.php?report=CancelPO&KeyIV=$cVendor";
                $GSQLVendor = "SELECT Vendor AS PC_Name, COUNT(DISTINCT idMRP) AS PC_Qty, "
                    . "CONCAT('$pLinkVendor', "
                    . " '&KeyIII=$cCustomer&KeyII=$cIDOwner&KeyV=$cRisk&KeyVI=$cStatus&KeyVII=$cDays') AS PC_Link FROM MRPCancel "
                    . "WHERE Status != 'Canceled' "
                    . "$Extra GROUP BY PC_Name ORDER BY PC_Qty DESC";
            }
            //echo $GSQLVendor;
            
            //Crea el Dashboard
            echo GraphDraw($GTypeVendor, $GTitleVendor, $GDivVendor, $ArrINFOVendor, $GSQLVendor);
            //echo "Aqui2";
            
            //********************************************************* Grafica Customer
            $GTypeCustomer = "PieChartLink";
            $GTitleCustomer = "By CustomerChart";
            $GDivCustomer = "customerChart";
            $ArrINFOCustomer['SubtitleName'] = "Customer";
            $ArrINFOCustomer['SubtitleQty'] = "Qty";
            $ArrINFOCustomer['LoadDriver'] = 0;
            
            if(empty($gCustomer)){
                $pLinkCustomer = "Dashboard.php?KeyI=" . base64_encode("CancelPO") . "&KeyIII=";
                //$pLinkCustomer = "Include/reportCSV.php?report=GenPOControlDetail&KeyIII=$cCustomer";
                $GSQLCustomer = "SELECT Customer AS PC_Name, COUNT(DISTINCT idMRP) AS PC_Qty, "
                    . "CONCAT('$pLinkCustomer', "
                    . " TO_BASE64(Customer), '&KeyIV=$cVendor&KeyII=$cIDOwner&KeyV=$cRisk&KeyVI=$cStatus&KeyVII=$cDays') AS PC_Link FROM MRPCancel "
                    . "WHERE Status != 'Canceled' "
                    . "$Extra GROUP BY PC_Name ORDER BY PC_Qty DESC";
            } else {
                $pLinkCustomer = "Include/reportCSV.php?report=CancelPO&KeyIII=$cCustomer";
                $GSQLCustomer = "SELECT Customer AS PC_Name, COUNT(DISTINCT idMRP) AS PC_Qty, "
                    . "CONCAT('$pLinkCustomer', "
                    . " '&KeyIV=$cVendor&KeyII=$cIDOwner&KeyV=$cRisk&KeyVI=$cStatus&KeyVII=$cDays') AS PC_Link FROM MRPCancel "
                    . "WHERE Status != 'Canceled' "
                    . "$Extra GROUP BY PC_Name ORDER BY PC_Qty DESC";
            }
            
            //Crea el Dashboard
            echo GraphDraw($GTypeCustomer, $GTitleCustomer, $GDivCustomer, $ArrINFOCustomer, $GSQLCustomer);
            //echo "Aqui3";
            
            //********************************************************* Grafica Risk
            if(empty($gRisk)){
                $GTypeRisk = "PieChartLink";
                $GTitleRisk = "By Risk Chart";
                $GDivRisk = "LevelChart";
                $ArrINFORisk['SubtitleName'] = "Risk";
                $ArrINFORisk['SubtitleQty'] = "Qty";
                $ArrINFORisk['LoadDriver'] = 1;
                $ArrINFORisk['Colors'] = "colors:['red', 'orange', '#3366cc']";
                //Obtiene todos los campos
                //LOW
                $clevel = 0;
                $AvgLevels = "";
                while ($clevel < 3){
                    $clevel++;
                    $TLevel = 0;
                    $TQty = 0;
                    switch ($clevel){
                        case 1:
                            $qr = "> 30";
                            break;
                        case 2:
                            $qr = "BETWEEN '8' AND '30'";
                            break;
                        case 3:
                            $qr = "BETWEEN '0' AND '7'";
                            break;
                    }
                    $sAvg = "SELECT DATEDIFF('$dtAhora', dateCreated) AS NDays, COUNT(idMRP) AS QNP "
                        . "FROM MRPCancel WHERE Status != 'Canceled' $Extra "
                        . "AND DATEDIFF('$dtAhora', dateCreated) $qr "
                        . "GROUP BY NDays";
                    //echo $sAvg . "<BR><BR>";
                    $nAvg = $cnx->query($sAvg)->numRows();
                    if($nAvg > 0){
                        $LAvg = $cnx->query($sAvg)->fetchAll();
                        foreach ($LAvg as &$rAvg) {
                            $gNDays = $rAvg['NDays'];
                            $gQNP = $rAvg['QNP'];
                            $TLevel += $gQNP;
                            $TQty += ($gNDays * $gQNP);
                        }
                        $Avg = round($TQty/$TLevel);
                        $AvgLevels .= "AVG:$Avg|";
                    } else {
                        //$AvgLevels .= "0|";
                    }

                }
                //echo $AvgLevels;

                $AvgLevels = substr($AvgLevels, 0, -1);
                $ArrINFORisk['ExtraData'] = $AvgLevels;

                $pLinkRisk = "Dashboard.php?KeyI=" . base64_encode("CancelPO") . "&KeyV=";
                $GSQLRisk = "SELECT "
                    . "CASE "
                    . "WHEN DATEDIFF('$dtAhora', dateCreated) < 8 THEN 'LOW RISK - Less than 8 days' "
                    . "WHEN DATEDIFF('$dtAhora', dateCreated) < 31 THEN 'MEDIUM RISK - 8 to 30 days' "
                    . "ELSE 'HIGH RISK - More than 30 days' "
                    . "END AS PC_Name, COUNT(idMRP) AS PC_Qty, "
                    . "CONCAT('$pLinkRisk', " 
                     . " TO_BASE64("
                    . "CASE "
                    . "WHEN DATEDIFF('$dtAhora', dateCreated) < 8 THEN 'LOW' "
                    . "WHEN DATEDIFF('$dtAhora', dateCreated) < 31 THEN 'MEDIUM' "
                    . "ELSE 'HIGH'"
                    . "END"
                    . "), '&KeyIV=$cVendor&KeyII=$cIDOwner&KeyIII=$cCustomer&KeyVI=$cStatus&KeyVII=$cDays') AS PC_Link "
                    . "FROM MRPCancel WHERE Status != 'Canceled' $Extra GROUP BY PC_Name "
                    . "ORDER BY FIELD(PC_Name, 'HIGH RISK - More than 30 days', 'MEDIUM RISK - 8 to 30 days', 'LOW RISK - Less than 8 days')";

                //Para el color
                $SQLcol = $GSQLRisk;
                $rCol = $cnx->query($SQLcol)->fetchAll();
                $cadC = "";
                $conc = 0;
                foreach ($rCol as &$Color) {
                    $conc++;
                    if($conc == 1){
                        $cadC .= "colors:[";
                    }
                    $NameC = $Color['PC_Name'];
                    switch ($NameC){
                        case "HIGH RISK - More than 30 days":
                            $cadC .= "'red', ";
                            break;
                        case "MEDIUM RISK - 8 to 30 days":
                            $cadC .= "'orange', ";
                            break;
                        case "LOW RISK - Less than 8 days":
                            $cadC .= "'#3366cc', ";
                            break;
                    }

                }

                if(!empty($cadC)){
                    $cadC = substr($cadC, 0, -2) . "]";
                }
                //echo $cadC;
                $ArrINFORisk['Colors'] = $cadC;

                //echo $GSQLRisk;
                //$GSQL01 = "SELECT Buyer AS PC_Name, COUNT(keyPPV) AS PC_Qty FROM PPVs GROUP BY Buyer ORDER BY PC_Qty DESC";
                //Crea el Dashboard
                echo GraphDraw($GTypeRisk, $GTitleRisk, $GDivRisk, $ArrINFORisk, $GSQLRisk);
            } else {
                switch($gRisk){
                    case "LOW":
                        $Extra .= " AND DATEDIFF('$dtAhora', dtHold) < '8'";
                        break;
                    case "MEDIUM":
                        $Extra .= " AND DATEDIFF('$dtAhora', dtHold) BETWEEN '8' AND '30'";
                        break;
                    case "HIGH":
                        $Extra .= " AND DATEDIFF('$dtAhora', dtHold) > '30'";
                        break;
                }

                $GTypeRisk = "PieChartLink";
                $GTitleRisk = "By Qty of Days Chart";
                $GDivRisk = "levelChart";
                $ArrINFORisk['SubtitleName'] = "Days";
                $ArrINFORisk['Units'] = "Days";
                $ArrINFORisk['SubtitleQty'] = "Qty";
                $ArrINFORisk['LoadDriver'] = 0;

                $pLinkRisk = "Include/reportCSV.php?report=HoldMaterial&KeyVII=";
                //$pLink = base64_encode("DetailPOCCustomerRisk");
                //$D2x = base64_encode("CustomerDays");
                $GSQLRisk = "SELECT "
                        . "DATEDIFF('$dtAhora', dateCreated) AS PC_Name, COUNT(idMRP) AS PC_Qty, "
                        . "CONCAT('$pLinkRisk', "
                        . "TO_BASE64(DATEDIFF('$dtAhora', dateCreated)), '&KeyIV=$cVendor&KeyII=$cIDOwner&KeyIII=$cCustomer&KeyVI=$cStatus&KeyV=$cRisk') AS PC_Link "
                        . "FROM MRPCancel WHERE Status != 'Canceled' $Extra GROUP BY PC_Name ORDER BY PC_Name DESC";
                ///echo $GSQLRisk;
                //Crea el Dashboard
                echo GraphDraw($GTypeRisk, $GTitleRisk, $GDivRisk, $ArrINFORisk, $GSQLRisk);
            }
            
            //echo "Aqui4";
            
            //echo $GSQLRisk;
            //********************************************************* Grafica Status
            $GTypeStatus = "PieChartLink";
            $GTitleStatus = "By Status Chart";
            $GDivStatus = "statusChart";
            $ArrINFOCustomer['SubtitleName'] = "Status";
            $ArrINFOCustomer['SubtitleQty'] = "Qty";
            $ArrINFOCustomer['LoadDriver'] = 0;
            
            if(empty($gStatus)){
                $pLinkStatus = "Dashboard.php?KeyI=" . base64_encode("Valid") . "&KeyVI=";
                $pLinkStatus = "Include/reportCSV.php?report=GenPOControlDetail&KeyVI=$cStatus";
                $GSQLStatus = "SELECT Status AS PC_Name, COUNT(DISTINCT idPodData) AS PC_Qty, "
                    . "CONCAT('$pLinkStatus', "
                    . " TO_BASE64(Status), '&KeyIII=$cCustomer&KeyIV=$cVendor&KeyII=$cIDOwner&KeyV=$cRisk&KeyVII=$cDays') AS PC_Link FROM PodData "
                    . "WHERE Balance_Due > '0' AND Disp_Type != 'G' AND PodData.Class_Code != '' AND Purch_Order_Number NOT LIKE '9CN%' "
                    . "$Extra GROUP BY PC_Name ORDER BY PC_Qty DESC";
            } else {
                $pLinkStatus = "Include/reportCSV.php?report=ActPOControlDetail&KeyIII=$cCustomer";
                $GSQLStatus = "SELECT Status AS PC_Name, COUNT(DISTINCT idPodData) AS PC_Qty, "
                    . "CONCAT('$pLinkStatus', "
                    . " '&KeyIV=$cVendor&KeyII=$cIDOwner&KeyV=$cRisk&KeyVI=$cStatus&KeyVII=$cDays') AS PC_Link FROM PodData "
                    . "WHERE Balance_Due > '0' AND Vendor_Promise_Dt >= '$dateToday' AND Disp_Type != 'G' AND PodData.Class_Code != '' AND Purch_Order_Number NOT LIKE '9CN%' "
                    . "$Extra GROUP BY PC_Name ORDER BY PC_Qty DESC";
            }
            
            //Crea el Dashboard
            //echo GraphDraw($GTypeStatus, $GTitleStatus, $GDivStatus, $ArrINFOStatus, $GSQLStatus);
            
            
            //********************************************************* Tabla
            //Obtiene fecha del ultimo POD
            $SPOD = "SELECT dtAdded FROM PodData ORDER BY dtAdded DESC LIMIT 0, 1";
            $rPOD = $cnx->query($SPOD)->fetchArray();
            $dtPOD = $rPOD['dtAdded'];
            
            $FGraph = "<div style='padding:3px;position:fixed;top:70px;left:180px;text-align:left;'>"
                    . "<form action='Include/reportCSV.php?' target='_blank' method='get'>"
                    . "<font class='Robss' style='color:red;'>Open PO by Part Number<BR></font>"
                    . "<input class='text' type='text' id='Key' name='Key' holder='Part Number'>"
                    . "<input class='text' type='hidden' id='report' name='report' value='PNPOControlDetail'>"
                    . "</form>"
                    . "</div>";
            
            $FGraph = "";
            
            $FGraph .= "<table width='100%'>";
            $FGraph .= "<tr>"
                    . "<td width='25%' align='left'><font class='Exs'></font></td>"
                    . "<td colspan='2' align='center'><font class='Ex'>$TitleDashboard</font></td>"
                    . "<td width='25%' align='right'><font class='Robsss'><b>Updated on:</b><br></font><font class='Robss'>$dtPOD</font></td>"
                    . "</tr>"
                    . "<tr>"
                    . "<td width='25%' align='left'><font class='Exs'></font></td>"
                    . "<td colspan='2' align='center'><font class='Robs'>$SubtitleDashboard</font><BR>"
                    . "<font class='Robss'>$SubtitleDashboardDetail</font>"
                    . "</td>"
                    . "<td width='25%' align='right'><font class='Robsss'>"
                    . "<a href='Include/reportCSV.php?report=HoldMaterial&KeyI=$cKeyI&KeyII=$cIDOwner&KeyIII=$cCustomer&KeyIV=$cVendor&KeyV=$cRisk&KeyVI=$cStatus&KeyVII=$cDays' target='_blank'><img src='Images/xls.svg' width='30'></a>"
                    . "</td>"
                    . "</tr>"
                    . "<tr><td colspan='4' height='40'></td></tr>";
            $FGraph .= "<tr>"
                    . "<td colspan='2' width='50%' align='center'><font class='Exss'>$GTitleOwner</font><br><div id='$GDivOwner' style='height:400px;'></div></td>"
                    . "</td>"
                    . "<td colspan='2' width='50%' align='center'><font class='Exss'>$GTitleVendor</font><br><div id='$GDivVendor' style='height:400px;'></div></td>"
                    . "</tr>";
            $FGraph .= "<tr><td width='100%' colspan='4' align='center'><table width='100%'>";
            $FGraph .= "<tr>"
                    . "<td align='center' width='33%'><font class='Exss'>$GTitleCustomer</font><br><div id='$GDivCustomer' style='height:400px;'></div></td>"
                    . "</td>"
                    . "<td align='center' width='34%'><font class='Exss'>$GTitleRisk</font><br><div id='$GDivRisk' style='height:400px;'></div></td>"
                    . "<td align='center' width='33%'><font class='Exss'>$GTitleStatus</font><br><div id='$GDivStatus' style='height:400px;'></div></td>"
                    . "</tr>";
            $FGraph .= "</table></td></tr>";
            $FGraph .= "</table>";
            $FGraph .= "<script lang='javascript/text'>"
                    . "function resetear(){ document.location.reload(); }"
                    . "setTimeout(resetear, 50000);"
                    . "</script>";
            break;
        case "HoldMaterial":
            $cKey = base64_encode($gKeyI);
            //Dependes
            $gIDOwner = $gKeyII;
            $gCustomer = $gKeyIII;
            $gVendor = $gKeyIV;
            $gRisk = $gKeyV;
            $gStatus = $gKeyVI;
            $gDays = $gKeyVII;
            
            //*********************************************************Titulo
            if(!empty($gIDOwner)){
                $cIDOwner = base64_encode($gIDOwner);
                //Obtiene el nombre del owner
                $sInfoU = "SELECT * FROM Users WHERE IDUser = '$gIDOwner'";
                $rInfoU = $cnx->query($sInfoU)->fetchArray();
                $gOwner = $rInfoU['Name'] . " " . $rInfoU['FLastName'];
                $gTOwner = " Owner: <b>$gOwner</b> ";
                $Extra .= " AND IDBuyer = '$gIDOwner' ";
                
                //echo $sInfoU;
            } else {
                $gTOwner = "";
            }
            
            if(!empty($gCustomer)){
                $cCustomer = base64_encode($gCustomer);
                $gTCustomer = " Customer: <b>$gCustomer</b> ";
                $Extra .= " AND MWCustomer = '$gCustomer' ";
            } else {
                $gTCustomer = "";
            }
            
            if(!empty($gVendor)){
                $cVendor = base64_encode($gVendor);
                $gTVendor = " Vendor: <b>$gVendor</b> ";
                $Extra .= " AND VendorName = '$gVendor' ";
            } else {
                $gTVendor = "";
            }
            
            if(!empty($gRisk)){
                $cRisk = base64_encode($gRisk);
                
                
                switch($gRisk){
                    case "LOW":
                        $Extra .= " AND DATEDIFF('$dtAhora', dtHold) < '8'";
                        $gTitRisk = "Less than 8 days";
                        break;
                    case "MEDIUM":
                        $Extra .= " AND DATEDIFF('$dtAhora', dtHold) BETWEEN '8' AND '30'";
                        $gTitRisk = "8 to 30 days";
                        break;
                    case "HIGH":
                        $Extra .= " AND DATEDIFF('$dtAhora', dtHold) > '30'";
                        $gTitRisk = "More than 30 days";
                        break;
                }
                
                $gTRisk = " Risk: <font style='color:red;'><b>$gTitRisk</b></font> ";
                
            } else {
                $gTRisk = "";
            }
            
            if(!empty($gStatus)){
                $Extra .= " AND Status = '$gStatus' ";
                $cStatus = base64_encode($gStatus);
                $gTStatus = " Status: <font style='color:blue;'><b>$gStatus</b></font> ";
            } else {
                $gTStatus = "";
            }
            
            
            //General Graphic
            $TitleDashboard = "Material On Hold Dashboard";
            $SubtitleDashboard = "<font style='color:green;'>General</font> Impact";
            $SubtitleDashboardDetail = "$gTOwner $gTCustomer $gTVendor $gTStatus $gTRisk";
            //********************************************************* Grafica Owner
            $GTypeOwner = "PieChartLink";
            $GTitleOwner = "By Owner Chart";
            $GDivOwner = "ownerChart";
            $ArrINFOOwner['SubtitleName'] = "Owner";
            $ArrINFOOwner['SubtitleQty'] = "Qty";
            $ArrINFOOwner['LoadDriver'] = 1;
            if(empty($gIDOwner)){
                $pLinkOwner = "Dashboard.php?KeyI=" . base64_encode("HoldMaterial") . "&KeyII=";
                //$pLinkOwner = "Include/reportCSV.php?report=GenPOControlDetail&KeyII=$cIDOwner";
                $GSQLOwner = "W|SELECT BuyerName AS PC_Name, COUNT(DISTINCT idWarehouse) AS PC_Qty, "
                    . "CONCAT('$pLinkOwner', "
                    . " TO_BASE64(IDBuyer), '&KeyIII=$cCustomer&KeyIV=$cVendor&KeyV=$cRisk&KeyVI=$cStatus&KeyVII=$cDays') AS PC_Link FROM WarehouseHold "
                    . "WHERE Balance > '0' AND Status = 'Hold' "
                    . "$Extra GROUP BY PC_Name ORDER BY PC_Qty DESC";
            
            } else {
                
                /*
                 * SELECT POControl.Owner, PodData.Buyer AS Buyer, COUNT(DISTINCT PodData.idPodData) AS Qty FROM PodData, POControl WHERE PodData.Purch_Order_Number = POControl.Purch_Order_Number AND PodData.Balance_Due > '0' AND PodData.Vendor_Promise_Dt > '2022-01-18' AND PodData.Disp_Type != 'G' AND PodData.Class_Code != '' AND PodData.Purch_Order_Number NOT LIKE '9CN%'  GROUP BY POControl.Owner;
                 */
                $pLinkOwner = "Include/reportCSV.php?report=HoldMaterial&KeyII=$cIDOwner";
                
                $GSQLOwner = "W|SELECT BuyerName AS PC_Name, COUNT(DISTINCT idWarehouse) AS PC_Qty, "
                    . "CONCAT('$pLinkOwner', "
                    . " '&KeyIII=$cCustomer&KeyIV=$cVendor&KeyV=$cRisk&KeyVI=$cStatus&KeyVII=$cDays') AS PC_Link FROM WarehouseHold "
                    . "WHERE Balance > '0' AND Status = 'Hold' "
                    . "$Extra GROUP BY PC_Name ORDER BY PC_Qty DESC";
            
            }
            
            //echo $GSQLOwner;
            
            //Crea el Dashboard
            echo GraphDraw($GTypeOwner, $GTitleOwner, $GDivOwner, $ArrINFOOwner, $GSQLOwner);
            
            //echo "Aqui";
            //********************************************************* Grafica Vendor
            $GTypeVendor = "PieChartLink";
            $GTitleVendor = "By Vendor Chart";
            $GDivVendor = "vendorChart";
            $ArrINFOVendor['SubtitleName'] = "Vendor";
            $ArrINFOVendor['SubtitleQty'] = "Qty";
            $ArrINFOVendor['LoadDriver'] = 0;
            
            if(empty($gVendor)){
                //$pLinkVendor = "Include/reportCSV.php?report=GenPOControlDetail&KeyIV=$cVendor";
                $pLinkVendor = "Dashboard.php?KeyI=" . base64_encode("HoldMaterial") . "&KeyIV=";
                $GSQLVendor = "W|SELECT VendorName AS PC_Name, COUNT(DISTINCT idWarehouse) AS PC_Qty, "
                    . "CONCAT('$pLinkVendor', "
                    . " TO_BASE64(VendorName), '&KeyIII=$cCustomer&KeyII=$cIDOwner&KeyV=$cRisk&KeyVI=$cStatus&KeyVII=$cDays') AS PC_Link FROM WarehouseHold "
                    . "WHERE Balance > '0' AND Status = 'Hold' "
                    . "$Extra GROUP BY PC_Name ORDER BY PC_Qty DESC";
            } else {
                $pLinkVendor = "Include/reportCSV.php?report=HoldMaterial&KeyIV=$cVendor";
                $GSQLVendor = "W|SELECT VendorName AS PC_Name, COUNT(DISTINCT idWarehouse) AS PC_Qty, "
                    . "CONCAT('$pLinkVendor', "
                    . " '&KeyIII=$cCustomer&KeyII=$cIDOwner&KeyV=$cRisk&KeyVI=$cStatus&KeyVII=$cDays') AS PC_Link FROM WarehouseHold "
                    . "WHERE VendorName LIKE '$gVendor' AND Balance > '0' AND Status = 'Hold' "
                    . "$Extra GROUP BY PC_Name ORDER BY PC_Qty DESC";
            }
            
            //Crea el Dashboard
            echo GraphDraw($GTypeVendor, $GTitleVendor, $GDivVendor, $ArrINFOVendor, $GSQLVendor);
            
            //********************************************************* Grafica Customer
            $GTypeCustomer = "PieChartLink";
            $GTitleCustomer = "By CustomerChart";
            $GDivCustomer = "customerChart";
            $ArrINFOCustomer['SubtitleName'] = "Customer";
            $ArrINFOCustomer['SubtitleQty'] = "Qty";
            $ArrINFOCustomer['LoadDriver'] = 0;
            
            if(empty($gCustomer)){
                $pLinkCustomer = "Dashboard.php?KeyI=" . base64_encode("HoldMaterial") . "&KeyIII=";
                //$pLinkCustomer = "Include/reportCSV.php?report=GenPOControlDetail&KeyIII=$cCustomer";
                $GSQLCustomer = "W|SELECT MWCustomer AS PC_Name, COUNT(DISTINCT idWarehouse) AS PC_Qty, "
                    . "CONCAT('$pLinkCustomer', "
                    . " TO_BASE64(MWCustomer), '&KeyIV=$cVendor&KeyII=$cIDOwner&KeyV=$cRisk&KeyVI=$cStatus&KeyVII=$cDays') AS PC_Link FROM WarehouseHold "
                    . "WHERE Balance > '0' AND Status = 'Hold' "
                    . "$Extra GROUP BY PC_Name ORDER BY PC_Qty DESC";
            } else {
                $pLinkCustomer = "Include/reportCSV.php?report=HoldMaterial&KeyIII=$cCustomer";
                $GSQLCustomer = "W|SELECT MWCustomer AS PC_Name, COUNT(DISTINCT idWarehouse) AS PC_Qty, "
                    . "CONCAT('$pLinkCustomer', "
                    . " '&KeyIV=$cVendor&KeyII=$cIDOwner&KeyV=$cRisk&KeyVI=$cStatus&KeyVII=$cDays') AS PC_Link FROM WarehouseHold "
                    . "WHERE MWCustomer LIKE '$gCustomer' AND Balance > '0' AND Status = 'Hold' "
                    . "$Extra GROUP BY PC_Name ORDER BY PC_Qty DESC";
            }
            
            //Crea el Dashboard
            echo GraphDraw($GTypeCustomer, $GTitleCustomer, $GDivCustomer, $ArrINFOCustomer, $GSQLCustomer);
            
            //********************************************************* Grafica Risk
            if(empty($gRisk)){
                $GTypeRisk = "PieChartLink";
                $GTitleRisk = "By Risk Chart";
                $GDivRisk = "LevelChart";
                $ArrINFORisk['SubtitleName'] = "Risk";
                $ArrINFORisk['SubtitleQty'] = "Qty";
                $ArrINFORisk['LoadDriver'] = 1;
                $ArrINFORisk['Colors'] = "colors:['red', 'orange', '#3366cc']";
                //Obtiene todos los campos
                //LOW
                $clevel = 0;
                $AvgLevels = "";
                while ($clevel < 3){
                    $clevel++;
                    $TLevel = 0;
                    $TQty = 0;
                    switch ($clevel){
                        case 1:
                            $qr = "> 30";
                            break;
                        case 2:
                            $qr = "BETWEEN '8' AND '30'";
                            break;
                        case 3:
                            $qr = "BETWEEN '0' AND '7'";
                            break;
                    }
                    $sAvg = "SELECT DATEDIFF('$dtAhora', dtHold) AS NDays, COUNT(idWarehouse) AS QNP "
                        . "FROM WarehouseHold WHERE Balance > '0' AND Status = 'Hold' $Extra "
                        . "AND DATEDIFF('$dtAhora', dtHold) $qr "
                        . "GROUP BY NDays";
                    //echo $sAvg . "<BR><BR>";
                    $nAvg = $cnxw->query($sAvg)->numRows();
                    if($nAvg > 0){
                        $LAvg = $cnxw->query($sAvg)->fetchAll();
                        foreach ($LAvg as &$rAvg) {
                            $gNDays = $rAvg['NDays'];
                            $gQNP = $rAvg['QNP'];
                            $TLevel += $gQNP;
                            $TQty += ($gNDays * $gQNP);
                        }
                        $Avg = round($TQty/$TLevel);
                        $AvgLevels .= "AVG:$Avg|";
                    } else {
                        //$AvgLevels .= "0|";
                    }

                }
                //echo $AvgLevels;

                $AvgLevels = substr($AvgLevels, 0, -1);
                $ArrINFORisk['ExtraData'] = $AvgLevels;

                $pLinkRisk = "Dashboard.php?KeyI=" . base64_encode("HoldMaterial") . "&KeyV=";
                $GSQLRisk = "W|SELECT "
                    . "CASE "
                    . "WHEN DATEDIFF('$dtAhora', dtHold) < 8 THEN 'LOW RISK - Less than 8 days' "
                    . "WHEN DATEDIFF('$dtAhora', dtHold) < 31 THEN 'MEDIUM RISK - 8 to 30 days' "
                    . "ELSE 'HIGH RISK - More than 30 days' "
                    . "END AS PC_Name, COUNT(idWarehouse) AS PC_Qty, "
                    . "CONCAT('$pLinkRisk', " 
                     . " TO_BASE64("
                    . "CASE "
                    . "WHEN DATEDIFF('$dtAhora', dtHold) < 8 THEN 'LOW' "
                    . "WHEN DATEDIFF('$dtAhora', dtHold) < 31 THEN 'MEDIUM' "
                    . "ELSE 'HIGH'"
                    . "END"
                    . "), '&KeyIV=$cVendor&KeyII=$cIDOwner&KeyIII=$cCustomer&KeyVI=$cStatus&KeyVII=$cDays') AS PC_Link "
                    . "FROM WarehouseHold WHERE Balance > '0' AND Status = 'Hold' $Extra GROUP BY PC_Name "
                    . "ORDER BY FIELD(PC_Name, 'HIGH RISK - More than 30 days', 'MEDIUM RISK - 8 to 30 days', 'LOW RISK - Less than 8 days')";

                //Para el color
                $SQLcol = substr($GSQLRisk, 2);
                $rCol = $cnxw->query($SQLcol)->fetchAll();
                $cadC = "";
                $conc = 0;
                foreach ($rCol as &$Color) {
                    $conc++;
                    if($conc == 1){
                        $cadC .= "colors:[";
                    }
                    $NameC = $Color['PC_Name'];
                    switch ($NameC){
                        case "HIGH RISK - More than 30 days":
                            $cadC .= "'red', ";
                            break;
                        case "MEDIUM RISK - 8 to 30 days":
                            $cadC .= "'orange', ";
                            break;
                        case "LOW RISK - Less than 8 days":
                            $cadC .= "'#3366cc', ";
                            break;
                    }

                }

                if(!empty($cadC)){
                    $cadC = substr($cadC, 0, -2) . "]";
                }
                //echo $cadC;
                $ArrINFORisk['Colors'] = $cadC;

                //echo $GSQLRisk;
                //$GSQL01 = "SELECT Buyer AS PC_Name, COUNT(keyPPV) AS PC_Qty FROM PPVs GROUP BY Buyer ORDER BY PC_Qty DESC";
                //Crea el Dashboard
                echo GraphDraw($GTypeRisk, $GTitleRisk, $GDivRisk, $ArrINFORisk, $GSQLRisk);
            } else {
                switch($gRisk){
                    case "LOW":
                        $Extra .= " AND DATEDIFF('$dtAhora', dtHold) < '8'";
                        break;
                    case "MEDIUM":
                        $Extra .= " AND DATEDIFF('$dtAhora', dtHold) BETWEEN '8' AND '30'";
                        break;
                    case "HIGH":
                        $Extra .= " AND DATEDIFF('$dtAhora', dtHold) > '30'";
                        break;
                }

                $GTypeRisk = "PieChartLink";
                $GTitleRisk = "By Qty of Days Chart";
                $GDivRisk = "levelChart";
                $ArrINFORisk['SubtitleName'] = "Days";
                $ArrINFORisk['Units'] = "Days";
                $ArrINFORisk['SubtitleQty'] = "Qty";
                $ArrINFORisk['LoadDriver'] = 0;

                $pLinkRisk = "Include/reportCSV.php?report=HoldMaterial&KeyVII=";
                //$pLink = base64_encode("DetailPOCCustomerRisk");
                //$D2x = base64_encode("CustomerDays");
                $GSQLRisk = "W|SELECT "
                        . "DATEDIFF('$dtAhora', dtHold) AS PC_Name, COUNT(idWarehouse) AS PC_Qty, "
                        . "CONCAT('$pLinkRisk', "
                        . "TO_BASE64(DATEDIFF('$dtAhora', dtHold)), '&KeyIV=$cVendor&KeyII=$cIDOwner&KeyIII=$cCustomer&KeyVI=$cStatus&KeyV=$cRisk') AS PC_Link "
                        . "FROM WarehouseHold WHERE Balance > '0' AND Status = 'Hold' $Extra GROUP BY PC_Name ORDER BY PC_Name DESC";
                ///echo $GSQLRisk;
                //Crea el Dashboard
                echo GraphDraw($GTypeRisk, $GTitleRisk, $GDivRisk, $ArrINFORisk, $GSQLRisk);
            }
            
            
            //echo $GSQLRisk;
            //********************************************************* Grafica Status
            $GTypeStatus = "PieChartLink";
            $GTitleStatus = "By Status Chart";
            $GDivStatus = "statusChart";
            $ArrINFOCustomer['SubtitleName'] = "Status";
            $ArrINFOCustomer['SubtitleQty'] = "Qty";
            $ArrINFOCustomer['LoadDriver'] = 0;
            
            if(empty($gStatus)){
                $pLinkStatus = "Dashboard.php?KeyI=" . base64_encode("Valid") . "&KeyVI=";
                $pLinkStatus = "Include/reportCSV.php?report=GenPOControlDetail&KeyVI=$cStatus";
                $GSQLStatus = "SELECT Status AS PC_Name, COUNT(DISTINCT idPodData) AS PC_Qty, "
                    . "CONCAT('$pLinkStatus', "
                    . " TO_BASE64(Status), '&KeyIII=$cCustomer&KeyIV=$cVendor&KeyII=$cIDOwner&KeyV=$cRisk&KeyVII=$cDays') AS PC_Link FROM PodData "
                    . "WHERE Balance_Due > '0' AND Disp_Type != 'G' AND PodData.Class_Code != '' AND Purch_Order_Number NOT LIKE '9CN%' "
                    . "$Extra GROUP BY PC_Name ORDER BY PC_Qty DESC";
            } else {
                $pLinkStatus = "Include/reportCSV.php?report=ActPOControlDetail&KeyIII=$cCustomer";
                $GSQLStatus = "SELECT Status AS PC_Name, COUNT(DISTINCT idPodData) AS PC_Qty, "
                    . "CONCAT('$pLinkStatus', "
                    . " '&KeyIV=$cVendor&KeyII=$cIDOwner&KeyV=$cRisk&KeyVI=$cStatus&KeyVII=$cDays') AS PC_Link FROM PodData "
                    . "WHERE Balance_Due > '0' AND Vendor_Promise_Dt >= '$dateToday' AND Disp_Type != 'G' AND PodData.Class_Code != '' AND Purch_Order_Number NOT LIKE '9CN%' "
                    . "$Extra GROUP BY PC_Name ORDER BY PC_Qty DESC";
            }
            
            //Crea el Dashboard
            //echo GraphDraw($GTypeStatus, $GTitleStatus, $GDivStatus, $ArrINFOStatus, $GSQLStatus);
            
            
            //********************************************************* Tabla
            //Obtiene fecha del ultimo POD
            $SPOD = "SELECT dtAdded FROM PodData ORDER BY dtAdded DESC LIMIT 0, 1";
            $rPOD = $cnx->query($SPOD)->fetchArray();
            $dtPOD = $rPOD['dtAdded'];
            
            $FGraph = "<div style='padding:3px;position:fixed;top:70px;left:180px;text-align:left;'>"
                    . "<form action='Include/reportCSV.php?' target='_blank' method='get'>"
                    . "<font class='Robss' style='color:red;'>Open PO by Part Number<BR></font>"
                    . "<input class='text' type='text' id='Key' name='Key' holder='Part Number'>"
                    . "<input class='text' type='hidden' id='report' name='report' value='PNPOControlDetail'>"
                    . "</form>"
                    . "</div>";
            
            $FGraph = "";
            
            $FGraph .= "<table width='100%'>";
            $FGraph .= "<tr>"
                    . "<td width='25%' align='left'><font class='Exs'></font></td>"
                    . "<td colspan='2' align='center'><font class='Ex'>$TitleDashboard</font></td>"
                    . "<td width='25%' align='right'><font class='Robsss'><b>Updated on:</b><br></font><font class='Robss'>$dtPOD</font></td>"
                    . "</tr>"
                    . "<tr>"
                    . "<td width='25%' align='left'><font class='Exs'></font></td>"
                    . "<td colspan='2' align='center'><font class='Robs'>$SubtitleDashboard</font><BR>"
                    . "<font class='Robss'>$SubtitleDashboardDetail</font>"
                    . "</td>"
                    . "<td width='25%' align='right'><font class='Robsss'>"
                    . "<a href='Include/reportCSV.php?report=HoldMaterial&KeyI=$cKeyI&KeyII=$cIDOwner&KeyIII=$cCustomer&KeyIV=$cVendor&KeyV=$cRisk&KeyVI=$cStatus&KeyVII=$cDays' target='_blank'><img src='Images/xls.svg' width='30'></a>"
                    . "</td>"
                    . "</tr>"
                    . "<tr><td colspan='4' height='40'></td></tr>";
            $FGraph .= "<tr>"
                    . "<td colspan='2' width='50%' align='center'><font class='Exss'>$GTitleOwner</font><br><div id='$GDivOwner' style='height:400px;'></div></td>"
                    . "</td>"
                    . "<td colspan='2' width='50%' align='center'><font class='Exss'>$GTitleVendor</font><br><div id='$GDivVendor' style='height:400px;'></div></td>"
                    . "</tr>";
            $FGraph .= "<tr><td width='100%' colspan='4' align='center'><table width='100%'>";
            $FGraph .= "<tr>"
                    . "<td align='center' width='33%'><font class='Exss'>$GTitleCustomer</font><br><div id='$GDivCustomer' style='height:400px;'></div></td>"
                    . "</td>"
                    . "<td align='center' width='34%'><font class='Exss'>$GTitleRisk</font><br><div id='$GDivRisk' style='height:400px;'></div></td>"
                    . "<td align='center' width='33%'><font class='Exss'>$GTitleStatus</font><br><div id='$GDivStatus' style='height:400px;'></div></td>"
                    . "</tr>";
            $FGraph .= "</table></td></tr>";
            $FGraph .= "</table>";
            $FGraph .= "<script lang='javascript/text'>"
                    . "function resetear(){ document.location.reload(); }"
                    . "setTimeout(resetear, 50000);"
                    . "</script>";
            break;
        case "PODemand":
            $cKey = base64_encode($gKeyI);
            //Dependes
            $gOwner = $gKeyII;
            $gCustomer = $gKeyIII;
            $gVendor = $gKeyIV;
            $gRisk = $gKeyV;
            $gStatus = $gKeyVI;
            $gDays = $gKeyVII;
            
            //*********************************************************Titulo
            if(!empty($gOwner)){
                $cIDOwner = base64_encode($gOwner);
                //Obtiene el nombre del owner
                //$sInfoU = "SELECT * FROM Users WHERE IDUser = '$gIDOwner'";
                //$rInfoU = $cnx->query($sInfoU)->fetchArray();
                //$gOwner = $rInfoU['Name'] . " " . $rInfoU['FLastName'];
                $gTOwner = " Owner: <b>$gOwner</b> ";
                $Extra .= " AND Owner = '$gOwner' ";
            } else {
                $gTOwner = "";
            }
            
            if(!empty($gCustomer)){
                $cCustomer = base64_encode($gCustomer);
                $gTCustomer = " Customer: <b>$gCustomer</b> ";
                $Extra .= " AND Customer = '$gCustomer' ";
            } else {
                $gTCustomer = "";
            }
            
            if(!empty($gVendor)){
                $cVendor = base64_encode($gVendor);
                $gTVendor = " Vendor: <b>$gVendor</b> ";
                $Extra .= " AND VendorID = '$gVendor' ";
            } else {
                $gTVendor = "";
            }
            
            if(!empty($gRisk)){
                $cRisk = base64_encode($gRisk);
                
                
                switch($gRisk){
                    case "ME8":
                        $Extra .= " AND DATEDIFF(Vendor_Promise_Dt, '$dtAhora') < '8'";
                        $gTitRisk = "Less than 8 days";
                        break;
                    case "ME15":
                        $Extra .= " AND DATEDIFF(Vendor_Promise_Dt, '$dtAhora') BETWEEN '8' AND '14'";
                        $gTitRisk = "8 to 14 days";
                        break;
                    case "ME22":
                        $Extra .= " AND DATEDIFF(Vendor_Promise_Dt, '$dtAhora') BETWEEN '15' AND '21'";
                        $gTitRisk = "15 to 21 days";
                        break;
                    case "ME31":
                        $Extra .= " AND DATEDIFF(Vendor_Promise_Dt, '$dtAhora') BETWEEN '22' AND '30'";
                        $gTitRisk = "22 to 30 days";
                        break;
                    case "ME61":
                        $Extra .= " AND DATEDIFF(Vendor_Promise_Dt, '$dtAhora') BETWEEN '31' AND '60'";
                        $gTitRisk = "31 to 60 days";
                        break;
                    case "ME91":
                        $Extra .= " AND DATEDIFF(Vendor_Promise_Dt, '$dtAhora') BETWEEN '61' AND '90'";
                        $gTitRisk = "60 to 90 days";
                        break;
                    case "MAS90":
                        $Extra .= " AND DATEDIFF(Vendor_Promise_Dt, '$dtAhora') > '90'";
                        $gTitRisk = "More than 90 days";
                        break;
                }
                
                $gTRisk = " Risk: <font style='color:red;'><b>$gTitRisk</b></font> ";
                
            } else {
                $gTRisk = "";
            }
            
            if(!empty($gStatus)){
                $Extra .= " AND Status = '$gStatus' ";
                $cStatus = base64_encode($gStatus);
                $gTStatus = " Status: <font style='color:blue;'><b>$gStatus</b></font> ";
            } else {
                $gTStatus = "";
            }
            
            //General Graphic
            $TitleDashboard = "Supply Chain PO Demand Dashboard";
            $SubtitleDashboard = "<font style='color:red;'>Less 80%</font> Demand Impact by Part";
            $SubtitleDashboardDetail = "$gTOwner $gTCustomer $gTVendor $gTStatus $gTRisk";
            //********************************************************* Grafica Owner
            $GTypeOwner = "PieChartLink";
            $GTitleOwner = "By Owner Chart";
            $GDivOwner = "ownerChart";
            $ArrINFOOwner['SubtitleName'] = "Owner";
            $ArrINFOOwner['SubtitleQty'] = "Qty";
            $ArrINFOOwner['LoadDriver'] = 1;
            if(empty($gOwner)){
                $pLinkOwner = "Dashboard.php?KeyI=" . base64_encode("PODemand") . "&KeyII=";
                //$pLinkOwner = "Include/reportCSV.php?report=GenPOControlDetail&KeyII=$cIDOwner";
                $GSQLOwner = "SELECT Owner AS PC_Name, COUNT(DISTINCT Part) AS PC_Qty, "
                    . "CONCAT('$pLinkOwner', "
                    . " TO_BASE64(Owner), '&KeyIII=$cCustomer&KeyIV=$cVendor&KeyV=$cRisk&KeyVI=$cStatus&KeyVII=$cDays') AS PC_Link FROM PODemand "
                    . "WHERE NetExcess < '0' AND Inv_Type = 'PP' AND Comm_Code != 'PKG' AND Comm_Code != 'LBL' AND ReqmntQty > '0' AND Engr_Status = 'A' AND pDemand < '80' "
                    . "$Extra GROUP BY PC_Name ORDER BY PC_Qty DESC";
            
            } else {
                
                /*
                 * SELECT POControl.Owner, PodData.Buyer AS Buyer, COUNT(DISTINCT PodData.idPodData) AS Qty FROM PodData, POControl WHERE PodData.Purch_Order_Number = POControl.Purch_Order_Number AND PodData.Balance_Due > '0' AND PodData.Vendor_Promise_Dt > '2022-01-18' AND PodData.Disp_Type != 'G' AND PodData.Class_Code != '' AND PodData.Purch_Order_Number NOT LIKE '9CN%'  GROUP BY POControl.Owner;
                 */
                $pLinkOwner = "Include/reportCSV.php?report=ActPODemand&KeyII=$cIDOwner";
                $GSQLOwner = "SELECT Owner AS PC_Name, COUNT(DISTINCT Part) AS PC_Qty, "
                    . "CONCAT('$pLinkOwner', "
                    . " '&KeyIII=$cCustomer&KeyIV=$cVendor&KeyV=$cRisk&KeyVI=$cStatus&KeyVII=$cDays') AS PC_Link FROM PODemand "
                    . "WHERE NetExcess < '0' AND Inv_Type = 'PP' AND Comm_Code != 'PKG' AND Comm_Code != 'LBL' AND ReqmntQty > '0' AND Engr_Status = 'A' AND pDemand < '80' "
                    . "$Extra GROUP BY PC_Name ORDER BY PC_Qty DESC";
            
            }
            
            //echo $GSQLOwner;
            
            //Crea el Dashboard
            echo GraphDraw($GTypeOwner, $GTitleOwner, $GDivOwner, $ArrINFOOwner, $GSQLOwner);
            
            
            //********************************************************* Grafica Vendor
            $GTypeVendor = "PieChartLink";
            $GTitleVendor = "By Vendor Chart";
            $GDivVendor = "vendorChart";
            $ArrINFOVendor['SubtitleName'] = "Vendor";
            $ArrINFOVendor['SubtitleQty'] = "Qty";
            $ArrINFOVendor['LoadDriver'] = 0;
            
            if(empty($gVendor)){
                $pLinkVendor = "Dashboard.php?KeyI=" . base64_encode("PODemand") . "&KeyIV=";
                //$pLinkVendor = "Include/reportCSV.php?report=GenPOControlDetail&KeyIV=$cVendor";
                $GSQLVendor = "SELECT VendorID AS PC_Name, COUNT(DISTINCT Part) AS PC_Qty, "
                    . "CONCAT('$pLinkVendor', "
                    . " TO_BASE64(VendorID), '&KeyIII=$cCustomer&KeyII=$cIDOwner&KeyV=$cRisk&KeyVI=$cStatus&KeyVII=$cDays') AS PC_Link FROM PODemand "
                    . "WHERE NetExcess < '0' AND Inv_Type = 'PP' AND Comm_Code != 'PKG' AND Comm_Code != 'LBL' AND ReqmntQty > '0' AND Engr_Status = 'A' AND pDemand < '80' "
                    . "$Extra GROUP BY PC_Name ORDER BY PC_Qty DESC";
            } else {
                $pLinkVendor = "Include/reportCSV.php?report=ActPODemand&KeyIV=$cVendor";
                //$Extra = "";
                $GSQLVendor = "SELECT VendorID AS PC_Name, COUNT(DISTINCT Part) AS PC_Qty, "
                    . "CONCAT('$pLinkVendor', "
                    . " '&KeyIII=$cCustomer&KeyII=$cIDOwner&KeyV=$cRisk&KeyVI=$cStatus&KeyVII=$cDays') AS PC_Link FROM PODemand "
                    . "WHERE NetExcess < '0' AND Inv_Type = 'PP' AND Comm_Code != 'PKG' AND Comm_Code != 'LBL' AND ReqmntQty > '0' AND Engr_Status = 'A' AND pDemand < '80' "
                    . "$Extra GROUP BY PC_Name ORDER BY PC_Qty DESC";
            }
            
            //echo $GSQLVendor;
            //Crea el Dashboard
            echo GraphDraw($GTypeVendor, $GTitleVendor, $GDivVendor, $ArrINFOVendor, $GSQLVendor);
            
            //********************************************************* Grafica Customer
            $GTypeCustomer = "PieChartLink";
            $GTitleCustomer = "By CustomerChart";
            $GDivCustomer = "customerChart";
            $ArrINFOCustomer['SubtitleName'] = "Customer";
            $ArrINFOCustomer['SubtitleQty'] = "Qty";
            $ArrINFOCustomer['LoadDriver'] = 0;
            
            if(empty($gCustomer)){
                $pLinkCustomer = "Dashboard.php?KeyI=" . base64_encode("PODemand") . "&KeyIII=";
                //$pLinkCustomer = "Include/reportCSV.php?report=GenPOControlDetail&KeyIII=$cCustomer";
                $GSQLCustomer = "SELECT Customer AS PC_Name, COUNT(DISTINCT Part) AS PC_Qty, "
                    . "CONCAT('$pLinkCustomer', "
                    . " TO_BASE64(Customer), '&KeyIV=$cVendor&KeyII=$cIDOwner&KeyV=$cRisk&KeyVI=$cStatus&KeyVII=$cDays') AS PC_Link FROM PODemand "
                    . "WHERE NetExcess < '0' AND Inv_Type = 'PP' AND Comm_Code != 'PKG' AND Comm_Code != 'LBL' AND ReqmntQty > '0' AND Engr_Status = 'A' AND pDemand < '80' "
                    . "$Extra GROUP BY PC_Name ORDER BY PC_Qty DESC";
            } else {
                $pLinkCustomer = "Include/reportCSV.php?report=ActPODemand&KeyIII=$cCustomer";
                $GSQLCustomer = "SELECT Customer AS PC_Name, COUNT(DISTINCT Part) AS PC_Qty, "
                    . "CONCAT('$pLinkCustomer', "
                    . " '&KeyIV=$cVendor&KeyII=$cIDOwner&KeyV=$cRisk&KeyVI=$cStatus&KeyVII=$cDays') AS PC_Link FROM PODemand "
                    . "WHERE NetExcess < '0' AND Inv_Type = 'PP' AND Comm_Code != 'PKG' AND Comm_Code != 'LBL' AND ReqmntQty > '0' AND Engr_Status = 'A' AND pDemand < '80' "
                    . "$Extra GROUP BY PC_Name ORDER BY PC_Qty DESC";
            }
            
            //Crea el Dashboard
            echo GraphDraw($GTypeCustomer, $GTitleCustomer, $GDivCustomer, $ArrINFOCustomer, $GSQLCustomer);
            
            //********************************************************* Grafica Risk
            if(empty($gRisk)){
                $GTypeRisk = "PieChartLink";
                $GTitleRisk = "By Type of Impact";
                $GDivRisk = "LevelChart";
                $ArrINFORisk['SubtitleName'] = "Impact";
                $ArrINFORisk['SubtitleQty'] = "Qty";
                $ArrINFORisk['LoadDriver'] = 0;
                $ArrINFORisk['Colors'] = "colors:['red', 'orange', '#3366cc']";
                //Obtiene todos los campos
                //LOW
                /*
                $clevel = 0;
                $AvgLevels = "";
                while ($clevel < 7){
                    $clevel++;
                    $TLevel = 0;
                    $TQty = 0;
                    switch ($clevel){
                        case 1:
                            $qr = "< 8";
                            break;
                        case 2:
                            $qr = "BETWEEN '8' AND '14'";
                            break;
                        case 3:
                            $qr = "BETWEEN '15' AND '21'";
                            break;
                        case 4:
                            $qr = "BETWEEN '22' AND '30'";
                            break;
                        case 5:
                            $qr = "BETWEEN '31' AND '60'";
                            break;
                        case 6:
                            $qr = "BETWEEN '61' AND '90'";
                            break;
                        case 7:
                            $qr = "> 90";
                            break;
                    }
                    $sAvg = "SELECT DATEDIFF(Vendor_Promise_Dt, '$dtAhora') AS NDays, COUNT(DISTINCT idPodData) AS QNP "
                        . "FROM PodData "
                        . "WHERE Balance_Due > '0' AND Vendor_Promise_Dt >= '$dateToday' AND Disp_Type != 'G' AND PodData.Class_Code != '' AND Purch_Order_Number NOT LIKE '9CN%' "
                        . "$Extra "
                        . "AND DATEDIFF(Vendor_Promise_Dt, '$dtAhora') $qr "
                        . "GROUP BY NDays";
                    
                    //echo $sAvg . "<BR>";
                    
                    $nAvg = $cnx->query($sAvg)->numRows();
                    if($nAvg > 0){
                        $LAvg = $cnx->query($sAvg)->fetchAll();
                        foreach ($LAvg as &$rAvg) {
                            $gNDays = $rAvg['NDays'];
                            $gQNP = $rAvg['QNP'];
                            $TLevel += $gQNP;
                            $TQty += ($gNDays * $gQNP);
                        }
                        $Avg = round($TQty/$TLevel);
                        $AvgLevels .= "AVG:$Avg|";
                    } else {
                        //$AvgLevels .= "0|";
                    }

                }
                

                $AvgLevels = substr($AvgLevels, 0, -1);
                //echo $AvgLevels;
                //$ArrINFORisk['ExtraData'] = $AvgLevels;
                 * */
                

                $pLinkRisk = "Dashboard.php?KeyI=";
                //$pLinkRisk = "Include/reportCSV.php?report=GenPOControlDetail&KeyVII=";
                
                $GSQLRisk = "SELECT "
                    . "CASE "
                    . "WHEN Vendor_Promise_Dt < '$dateToday' AND Vendor_Promise_Dt != '2000-01-01' THEN 'Past Due' "
                    . "WHEN Vendor_Promise_Dt = '2000-01-01' THEN 'Unconfirm' "
                    . "WHEN Vendor_Promise_Dt >= '$dateToday' THEN 'Open Not Due' "
                    . "END AS PC_Name, COUNT(DISTINCT idPodData) AS PC_Qty, "
                    . "CONCAT('$pLinkRisk', " 
                    . " TO_BASE64("
                    . "CASE "
                    . "WHEN Vendor_Promise_Dt < '$dateToday' AND Vendor_Promise_Dt != '2000-01-01' THEN 'DueDate' "
                    . "WHEN Vendor_Promise_Dt = '2000-01-01' THEN 'NoPromise' "
                    . "WHEN Vendor_Promise_Dt >= '$dateToday' THEN 'Valid' "
                    . "END"
                    . "), '&KeyIV=$cVendor&KeyII=$cIDOwner&KeyIII=$cCustomer&KeyVI=$cStatus&KeyVII=$cDays') AS PC_Link "
                    . "FROM PodData WHERE Balance_Due > '0' AND Disp_Type != 'G' AND PodData.Class_Code != '' AND Purch_Order_Number NOT LIKE '9CN%' "
                    . "$Extra GROUP BY PC_Name "
                    . "ORDER BY FIELD(PC_Name, 'Past Due', 'Unconfirm', 'Open Not Due')";
                //echo $GSQLRisk;
                //Para el color
                //$rCol = $cnx->query($GSQLRisk)->fetchAll();
                $cadC = "";
                $conc = 0;
                foreach ($rCol as &$Color) {
                    $conc++;
                    if($conc == 1){
                        $cadC .= "colors:[";
                    }
                    $NameC = $Color['PC_Name'];
                    switch ($NameC){
                        case "Past Due":
                            $cadC .= "'red', ";
                            break;
                        case "Unconfirm":
                            $cadC .= "'orange', ";
                            break;
                        case "Open Not Due":
                            $cadC .= "'yellowgreen', ";
                            break;
                    }

                }

                if(!empty($cadC)){
                    $cadC = substr($cadC, 0, -2) . "]";
                }
                //echo $cadC;
                $ArrINFORisk['Colors'] = $cadC;
                //print_r($ArrINFORisk);
                //echo $GSQLRisk;
                //$GSQL01 = "SELECT Buyer AS PC_Name, COUNT(keyPPV) AS PC_Qty FROM PPVs GROUP BY Buyer ORDER BY PC_Qty DESC";
                //Crea el Dashboard
                //echo GraphDraw($GTypeRisk, $GTitleRisk, $GDivRisk, $ArrINFORisk, $GSQLRisk);
            } else {
                switch($gRisk){
                    case "ME8":
                        $Extra .= " AND DATEDIFF(Vendor_Promise_Dt, '$dtAhora') < '8'";
                        break;
                    case "ME15":
                        $Extra .= " AND DATEDIFF(Vendor_Promise_Dt, '$dtAhora') BETWEEN '8' AND '14'";
                        break;
                    case "ME22":
                        $Extra .= " AND DATEDIFF(Vendor_Promise_Dt, '$dtAhora') BETWEEN '15' AND '21'";
                        break;
                    case "ME31":
                        $Extra .= " AND DATEDIFF(Vendor_Promise_Dt, '$dtAhora') BETWEEN '22' AND '30'";
                        break;
                    case "ME61":
                        $Extra .= " AND DATEDIFF(Vendor_Promise_Dt, '$dtAhora') BETWEEN '31' AND '60'";
                        break;
                    case "ME91":
                        $Extra .= " AND DATEDIFF(Vendor_Promise_Dt, '$dtAhora') BETWEEN '61' AND '90'";
                        break;
                    case "MAS90":
                        $Extra .= " AND DATEDIFF(Vendor_Promise_Dt, '$dtAhora') > '90'";
                        break;
                }

                $GTypeRisk = "PieChartLink";
                $GTitleRisk = "By Qty of Days Chart";
                $GDivRisk = "levelChart";
                $ArrINFORisk['SubtitleName'] = "Days";
                $ArrINFORisk['Units'] = "Days";
                $ArrINFORisk['SubtitleQty'] = "Qty";
                $ArrINFORisk['LoadDriver'] = 0;

                $pLinkRisk = "Include/reportCSV.php?report=ActPOControlDetail&KeyVII=";
                //$pLink = base64_encode("DetailPOCCustomerRisk");
                //$D2x = base64_encode("CustomerDays");
                $GSQLRisk = "SELECT "
                        . "DATEDIFF(Vendor_Promise_Dt, '$dtAhora') AS PC_Name, COUNT(DISTINCT idPodData) AS PC_Qty, "
                        . "CONCAT('$pLinkRisk', "
                        . "TO_BASE64(DATEDIFF(Vendor_Promise_Dt, '$dtAhora')), '&KeyIV=$cVendor&KeyII=$cIDOwner&KeyIII=$cCustomer&KeyVI=$cStatus&KeyV=$cRisk') AS PC_Link "
                        . "FROM PodData WHERE Balance_Due > '0' AND Vendor_Promise_Dt >= '$dateToday' AND Disp_Type != 'G' AND PodData.Class_Code != '' AND Purch_Order_Number NOT LIKE '9CN%' "
                        . "$Extra GROUP BY PC_Name ORDER BY PC_Name DESC";
                //echo $GSQL01;
                //Crea el Dashboard
                //echo GraphDraw($GTypeRisk, $GTitleRisk, $GDivRisk, $ArrINFORisk, $GSQLRisk);
            }
            
            //echo $GSQLRisk;
            //********************************************************* Grafica Status
            $GTypeStatus = "PieChartLink";
            $GTitleStatus = "By Status Chart";
            $GDivStatus = "statusChart";
            $ArrINFOCustomer['SubtitleName'] = "Status";
            $ArrINFOCustomer['SubtitleQty'] = "Qty";
            $ArrINFOCustomer['LoadDriver'] = 0;
            
            if(empty($gStatus)){
                $pLinkStatus = "Dashboard.php?KeyI=" . base64_encode("Valid") . "&KeyVI=";
                $pLinkStatus = "Include/reportCSV.php?report=GenPOControlDetail&KeyVI=$cStatus";
                $GSQLStatus = "SELECT Status AS PC_Name, COUNT(DISTINCT idPodData) AS PC_Qty, "
                    . "CONCAT('$pLinkStatus', "
                    . " TO_BASE64(Status), '&KeyIII=$cCustomer&KeyIV=$cVendor&KeyII=$cIDOwner&KeyV=$cRisk&KeyVII=$cDays') AS PC_Link FROM PodData "
                    . "WHERE Balance_Due > '0' AND Disp_Type != 'G' AND PodData.Class_Code != '' AND Purch_Order_Number NOT LIKE '9CN%' "
                    . "$Extra GROUP BY PC_Name ORDER BY PC_Qty DESC";
            } else {
                $pLinkStatus = "Include/reportCSV.php?report=ActPOControlDetail&KeyIII=$cCustomer";
                $GSQLStatus = "SELECT Status AS PC_Name, COUNT(DISTINCT idPodData) AS PC_Qty, "
                    . "CONCAT('$pLinkStatus', "
                    . " '&KeyIV=$cVendor&KeyII=$cIDOwner&KeyV=$cRisk&KeyVI=$cStatus&KeyVII=$cDays') AS PC_Link FROM PodData "
                    . "WHERE Balance_Due > '0' AND Vendor_Promise_Dt >= '$dateToday' AND Disp_Type != 'G' AND PodData.Class_Code != '' AND Purch_Order_Number NOT LIKE '9CN%' "
                    . "$Extra GROUP BY PC_Name ORDER BY PC_Qty DESC";
            }
            
            //Crea el Dashboard
            //echo GraphDraw($GTypeStatus, $GTitleStatus, $GDivStatus, $ArrINFOStatus, $GSQLStatus);
            
            
            //********************************************************* Tabla
            //Obtiene fecha del ultimo POD
            $SPOD = "SELECT dtAdded FROM PodData ORDER BY dtAdded DESC LIMIT 0, 1";
            $rPOD = $cnx->query($SPOD)->fetchArray();
            $dtPOD = $rPOD['dtAdded'];
            
            /*
            $FGraph = "<div style='padding:3px;position:fixed;top:70px;left:180px;text-align:left;'>"
                    . "<form action='Include/reportCSV.php?' target='_blank' method='get'>"
                    . "<font class='Robss' style='color:red;'>Open PO by Part Number<BR></font>"
                    . "<input class='text' type='text' id='Key' name='Key' holder='Part Number'>"
                    . "<input class='text' type='hidden' id='report' name='report' value='PNPOControlDetail'>"
                    . "</form>"
                    . "</div>";
            */
            $FGraph .= "<table width='100%'>";
            $FGraph .= "<tr>"
                    . "<td width='25%' align='left'><font class='Exs'></font></td>"
                    . "<td colspan='2' align='center'><font class='Ex'>$TitleDashboard</font></td>"
                    . "<td width='25%' align='right'><font class='Robsss'><b>Updated on:</b><br></font><font class='Robss'>$dtPOD</font></td>"
                    . "</tr>"
                    . "<tr>"
                    . "<td width='25%' align='left'><font class='Exs'></font></td>"
                    . "<td colspan='2' align='center'><font class='Robs'>$SubtitleDashboard</font><BR>"
                    . "<font class='Robss'>$SubtitleDashboardDetail</font>"
                    . "</td>"
                    . "<td width='25%' align='right'><font class='Robsss'>"
                    . "<a href='Include/reportCSV.php?report=ActPODemand&KeyI=$cKeyI&KeyII=$cIDOwner&KeyIII=$cCustomer&KeyIV=$cVendor&KeyV=$cRisk&KeyVI=$cStatus&KeyVII=$cDays' target='_blank'><img src='Images/xls.svg' width='30'></a>"
                    . "</td>"
                    . "</tr>"
                    . "<tr><td colspan='4' height='40'></td></tr>";
            $FGraph .= "<tr>"
                    . "<td colspan='2' width='50%' align='center'><font class='Exss'>$GTitleOwner</font><br><div id='$GDivOwner' style='height:400px;'></div></td>"
                    . "</td>"
                    . "<td colspan='2' width='50%' align='center'><font class='Exss'>$GTitleVendor</font><br><div id='$GDivVendor' style='height:400px;'></div></td>"
                    . "</tr>";
            $FGraph .= "<tr><td width='100%' colspan='4' align='center'><table width='100%'>";
            $FGraph .= "<tr>"
                    . "<td align='center' width='33%'><font class='Exss'>$GTitleCustomer</font><br><div id='$GDivCustomer' style='height:400px;'></div></td>"
                    . "</td>"
                    . "<td align='center' width='34%'><font class='Exss'>$GTitleRisk</font><br><div id='$GDivRisk' style='height:400px;'></div></td>"
                    . "<td align='center' width='33%'><font class='Exss'>$GTitleStatus</font><br><div id='$GDivStatus' style='height:400px;'></div></td>"
                    . "</tr>";
            $FGraph .= "</table></td></tr>";
            $FGraph .= "</table>";
            $FGraph .= "<script lang='javascript/text'>"
                    . "function resetear(){ document.location.reload(); }"
                    . "setTimeout(resetear, 50000);"
                    . "</script>";
            break;
        case "General":
            $cKey = base64_encode($gKeyI);
            //Dependes
            $gIDOwner = $gKeyII;
            $gCustomer = $gKeyIII;
            $gVendor = $gKeyIV;
            $gRisk = $gKeyV;
            $gStatus = $gKeyVI;
            $gDays = $gKeyVII;
            
            //*********************************************************Titulo
            if(!empty($gIDOwner)){
                $cIDOwner = base64_encode($gIDOwner);
                //Obtiene el nombre del owner
                $sInfoU = "SELECT * FROM Users WHERE IDUser = '$gIDOwner'";
                $rInfoU = $cnx->query($sInfoU)->fetchArray();
                $gOwner = $rInfoU['Name'] . " " . $rInfoU['FLastName'];
                $gTOwner = " Owner: <b>$gOwner</b> ";
                $Extra .= " AND IDOwner = '$gIDOwner' ";
            } else {
                $gTOwner = "";
            }
            
            if(!empty($gCustomer)){
                $cCustomer = base64_encode($gCustomer);
                $gTCustomer = " Customer: <b>$gCustomer</b> ";
                $Extra .= " AND Customer = '$gCustomer' ";
            } else {
                $gTCustomer = "";
            }
            
            if(!empty($gVendor)){
                $cVendor = base64_encode($gVendor);
                $gTVendor = " Vendor: <b>$gVendor</b> ";
                $Extra .= " AND Vendor_Name = '$gVendor' ";
            } else {
                $gTVendor = "";
            }
            
            if(!empty($gRisk)){
                $cRisk = base64_encode($gRisk);
                
                
                switch($gRisk){
                    case "ME8":
                        $Extra .= " AND DATEDIFF(Vendor_Promise_Dt, '$dtAhora') < '8'";
                        $gTitRisk = "Less than 8 days";
                        break;
                    case "ME15":
                        $Extra .= " AND DATEDIFF(Vendor_Promise_Dt, '$dtAhora') BETWEEN '8' AND '14'";
                        $gTitRisk = "8 to 14 days";
                        break;
                    case "ME22":
                        $Extra .= " AND DATEDIFF(Vendor_Promise_Dt, '$dtAhora') BETWEEN '15' AND '21'";
                        $gTitRisk = "15 to 21 days";
                        break;
                    case "ME31":
                        $Extra .= " AND DATEDIFF(Vendor_Promise_Dt, '$dtAhora') BETWEEN '22' AND '30'";
                        $gTitRisk = "22 to 30 days";
                        break;
                    case "ME61":
                        $Extra .= " AND DATEDIFF(Vendor_Promise_Dt, '$dtAhora') BETWEEN '31' AND '60'";
                        $gTitRisk = "31 to 60 days";
                        break;
                    case "ME91":
                        $Extra .= " AND DATEDIFF(Vendor_Promise_Dt, '$dtAhora') BETWEEN '61' AND '90'";
                        $gTitRisk = "60 to 90 days";
                        break;
                    case "MAS90":
                        $Extra .= " AND DATEDIFF(Vendor_Promise_Dt, '$dtAhora') > '90'";
                        $gTitRisk = "More than 90 days";
                        break;
                }
                
                $gTRisk = " Risk: <font style='color:red;'><b>$gTitRisk</b></font> ";
                
            } else {
                $gTRisk = "";
            }
            
            if(!empty($gStatus)){
                $Extra .= " AND Status = '$gStatus' ";
                $cStatus = base64_encode($gStatus);
                $gTStatus = " Status: <font style='color:blue;'><b>$gStatus</b></font> ";
            } else {
                $gTStatus = "";
            }
            
            //General Graphic
            $TitleDashboard = "Supply Chain PO Control Dashboard";
            $SubtitleDashboard = "<font style='color:green;'>General</font> Impact by Delivery";
            $SubtitleDashboardDetail = "$gTOwner $gTCustomer $gTVendor $gTStatus $gTRisk";
            //********************************************************* Grafica Owner
            $GTypeOwner = "PieChartLink";
            $GTitleOwner = "By Owner Chart";
            $GDivOwner = "ownerChart";
            $ArrINFOOwner['SubtitleName'] = "Owner";
            $ArrINFOOwner['SubtitleQty'] = "Qty";
            $ArrINFOOwner['LoadDriver'] = 1;
            if(empty($gIDOwner)){
                $pLinkOwner = "Dashboard.php?KeyI=" . base64_encode("General") . "&KeyII=";
                //$pLinkOwner = "Include/reportCSV.php?report=GenPOControlDetail&KeyII=$cIDOwner";
                $GSQLOwner = "SELECT Owner AS PC_Name, COUNT(DISTINCT idPodData) AS PC_Qty, "
                    . "CONCAT('$pLinkOwner', "
                    . " TO_BASE64(IDOwner), '&KeyIII=$cCustomer&KeyIV=$cVendor&KeyV=$cRisk&KeyVI=$cStatus&KeyVII=$cDays') AS PC_Link FROM PodData "
                    . "WHERE Balance_Due > '0' AND Disp_Type != 'G' AND Class_Code != '' AND Purch_Order_Number NOT LIKE '9CN%' "
                    . "$Extra GROUP BY PC_Name ORDER BY PC_Qty DESC";
            
            } else {
                
                /*
                 * SELECT POControl.Owner, PodData.Buyer AS Buyer, COUNT(DISTINCT PodData.idPodData) AS Qty FROM PodData, POControl WHERE PodData.Purch_Order_Number = POControl.Purch_Order_Number AND PodData.Balance_Due > '0' AND PodData.Vendor_Promise_Dt > '2022-01-18' AND PodData.Disp_Type != 'G' AND PodData.Class_Code != '' AND PodData.Purch_Order_Number NOT LIKE '9CN%'  GROUP BY POControl.Owner;
                 */
                $pLinkOwner = "Include/reportCSV.php?report=GenPOControlDetail&KeyII=$cIDOwner";
                
                $GSQLOwner = "SELECT Owner AS PC_Name, COUNT(DISTINCT idPodData) AS PC_Qty, "
                    . "CONCAT('$pLinkOwner', "
                    . " '&KeyIII=$cCustomer&KeyIV=$cVendor&KeyV=$cRisk&KeyVI=$cStatus&KeyVII=$cDays') AS PC_Link FROM PodData "
                    . "WHERE Owner LIKE '$gOwner' AND Balance_Due > '0' AND Disp_Type != 'G' AND PodData.Class_Code != '' AND Purch_Order_Number NOT LIKE '9CN%' "
                    . "$Extra GROUP BY PC_Name ORDER BY PC_Qty DESC";
            
            }
            
            //echo $GSQLOwner;
            
            //Crea el Dashboard
            echo GraphDraw($GTypeOwner, $GTitleOwner, $GDivOwner, $ArrINFOOwner, $GSQLOwner);
            
            
            //********************************************************* Grafica Vendor
            $GTypeVendor = "PieChartLink";
            $GTitleVendor = "By Vendor Chart";
            $GDivVendor = "vendorChart";
            $ArrINFOVendor['SubtitleName'] = "Vendor";
            $ArrINFOVendor['SubtitleQty'] = "Qty";
            $ArrINFOVendor['LoadDriver'] = 0;
            
            if(empty($gVendor)){
                //$pLinkVendor = "Include/reportCSV.php?report=GenPOControlDetail&KeyIV=$cVendor";
                $pLinkVendor = "Dashboard.php?KeyI=" . base64_encode("General") . "&KeyIV=";
                $GSQLVendor = "SELECT Vendor_Name AS PC_Name, COUNT(DISTINCT idPodData) AS PC_Qty, "
                    . "CONCAT('$pLinkVendor', "
                    . " TO_BASE64(Vendor_Name), '&KeyIII=$cCustomer&KeyII=$cIDOwner&KeyV=$cRisk&KeyVI=$cStatus&KeyVII=$cDays') AS PC_Link FROM PodData "
                    . "WHERE Balance_Due > '0' AND Disp_Type != 'G' AND PodData.Class_Code != '' AND Purch_Order_Number NOT LIKE '9CN%' "
                    . "$Extra GROUP BY PC_Name ORDER BY PC_Qty DESC";
            } else {
                $pLinkVendor = "Include/reportCSV.php?report=GenPOControlDetail&KeyIV=$cVendor";
                $GSQLVendor = "SELECT Vendor_Name AS PC_Name, COUNT(DISTINCT idPodData) AS PC_Qty, "
                    . "CONCAT('$pLinkVendor', "
                    . " '&KeyIII=$cCustomer&KeyII=$cIDOwner&KeyV=$cRisk&KeyVI=$cStatus&KeyVII=$cDays') AS PC_Link FROM PodData "
                    . "WHERE Vendor_Name LIKE '$gVendor' AND Balance_Due > '0' AND Disp_Type != 'G' AND Class_Code != '' AND Purch_Order_Number NOT LIKE '9CN%' "
                    . "$Extra GROUP BY PC_Name ORDER BY PC_Qty DESC";
            }
            
            //Crea el Dashboard
            echo GraphDraw($GTypeVendor, $GTitleVendor, $GDivVendor, $ArrINFOVendor, $GSQLVendor);
            
            //********************************************************* Grafica Customer
            $GTypeCustomer = "PieChartLink";
            $GTitleCustomer = "By CustomerChart";
            $GDivCustomer = "customerChart";
            $ArrINFOCustomer['SubtitleName'] = "Customer";
            $ArrINFOCustomer['SubtitleQty'] = "Qty";
            $ArrINFOCustomer['LoadDriver'] = 0;
            
            if(empty($gCustomer)){
                $pLinkCustomer = "Dashboard.php?KeyI=" . base64_encode("General") . "&KeyIII=";
                //$pLinkCustomer = "Include/reportCSV.php?report=GenPOControlDetail&KeyIII=$cCustomer";
                $GSQLCustomer = "SELECT Customer AS PC_Name, COUNT(DISTINCT idPodData) AS PC_Qty, "
                    . "CONCAT('$pLinkCustomer', "
                    . " TO_BASE64(Customer), '&KeyIV=$cVendor&KeyII=$cIDOwner&KeyV=$cRisk&KeyVI=$cStatus&KeyVII=$cDays') AS PC_Link FROM PodData "
                    . "WHERE Balance_Due > '0' AND Disp_Type != 'G' AND PodData.Class_Code != '' AND Purch_Order_Number NOT LIKE '9CN%' "
                    . "$Extra GROUP BY PC_Name ORDER BY PC_Qty DESC";
            } else {
                $pLinkCustomer = "Include/reportCSV.php?report=GenPOControlDetail&KeyIII=$cCustomer";
                $GSQLCustomer = "SELECT Customer AS PC_Name, COUNT(DISTINCT idPodData) AS PC_Qty, "
                    . "CONCAT('$pLinkCustomer', "
                    . " '&KeyIV=$cVendor&KeyII=$cIDOwner&KeyV=$cRisk&KeyVI=$cStatus&KeyVII=$cDays') AS PC_Link FROM PodData "
                    . "WHERE Customer LIKE '$gCustomer' AND Balance_Due > '0' AND Disp_Type != 'G' AND PodData.Class_Code != '' AND Purch_Order_Number NOT LIKE '9CN%' "
                    . "$Extra GROUP BY PC_Name ORDER BY PC_Qty DESC";
            }
            
            //Crea el Dashboard
            echo GraphDraw($GTypeCustomer, $GTitleCustomer, $GDivCustomer, $ArrINFOCustomer, $GSQLCustomer);
            
            //********************************************************* Grafica Risk
            if(empty($gRisk)){
                $GTypeRisk = "PieChartLink";
                $GTitleRisk = "By Type of Impact";
                $GDivRisk = "LevelChart";
                $ArrINFORisk['SubtitleName'] = "Impact";
                $ArrINFORisk['SubtitleQty'] = "Qty";
                $ArrINFORisk['LoadDriver'] = 0;
                $ArrINFORisk['Colors'] = "colors:['red', 'orange', '#3366cc']";
                //Obtiene todos los campos
                //LOW
                /*
                $clevel = 0;
                $AvgLevels = "";
                while ($clevel < 7){
                    $clevel++;
                    $TLevel = 0;
                    $TQty = 0;
                    switch ($clevel){
                        case 1:
                            $qr = "< 8";
                            break;
                        case 2:
                            $qr = "BETWEEN '8' AND '14'";
                            break;
                        case 3:
                            $qr = "BETWEEN '15' AND '21'";
                            break;
                        case 4:
                            $qr = "BETWEEN '22' AND '30'";
                            break;
                        case 5:
                            $qr = "BETWEEN '31' AND '60'";
                            break;
                        case 6:
                            $qr = "BETWEEN '61' AND '90'";
                            break;
                        case 7:
                            $qr = "> 90";
                            break;
                    }
                    $sAvg = "SELECT DATEDIFF(Vendor_Promise_Dt, '$dtAhora') AS NDays, COUNT(DISTINCT idPodData) AS QNP "
                        . "FROM PodData "
                        . "WHERE Balance_Due > '0' AND Vendor_Promise_Dt >= '$dateToday' AND Disp_Type != 'G' AND PodData.Class_Code != '' AND Purch_Order_Number NOT LIKE '9CN%' "
                        . "$Extra "
                        . "AND DATEDIFF(Vendor_Promise_Dt, '$dtAhora') $qr "
                        . "GROUP BY NDays";
                    
                    //echo $sAvg . "<BR>";
                    
                    $nAvg = $cnx->query($sAvg)->numRows();
                    if($nAvg > 0){
                        $LAvg = $cnx->query($sAvg)->fetchAll();
                        foreach ($LAvg as &$rAvg) {
                            $gNDays = $rAvg['NDays'];
                            $gQNP = $rAvg['QNP'];
                            $TLevel += $gQNP;
                            $TQty += ($gNDays * $gQNP);
                        }
                        $Avg = round($TQty/$TLevel);
                        $AvgLevels .= "AVG:$Avg|";
                    } else {
                        //$AvgLevels .= "0|";
                    }

                }
                

                $AvgLevels = substr($AvgLevels, 0, -1);
                //echo $AvgLevels;
                //$ArrINFORisk['ExtraData'] = $AvgLevels;
                 * */
                

                $pLinkRisk = "Dashboard.php?KeyI=";
                //$pLinkRisk = "Include/reportCSV.php?report=GenPOControlDetail&KeyVII=";
                
                $GSQLRisk = "SELECT "
                    . "CASE "
                    . "WHEN Vendor_Promise_Dt < '$dateToday' AND Vendor_Promise_Dt != '2000-01-01' THEN 'Past Due' "
                    . "WHEN Vendor_Promise_Dt = '2000-01-01' THEN 'Unconfirm' "
                    . "WHEN Vendor_Promise_Dt >= '$dateToday' THEN 'Open Not Due' "
                    . "END AS PC_Name, COUNT(DISTINCT idPodData) AS PC_Qty, "
                    . "CONCAT('$pLinkRisk', " 
                    . " TO_BASE64("
                    . "CASE "
                    . "WHEN Vendor_Promise_Dt < '$dateToday' AND Vendor_Promise_Dt != '2000-01-01' THEN 'DueDate' "
                    . "WHEN Vendor_Promise_Dt = '2000-01-01' THEN 'NoPromise' "
                    . "WHEN Vendor_Promise_Dt >= '$dateToday' THEN 'Valid' "
                    . "END"
                    . "), '&KeyIV=$cVendor&KeyII=$cIDOwner&KeyIII=$cCustomer&KeyVI=$cStatus&KeyVII=$cDays') AS PC_Link "
                    . "FROM PodData WHERE Balance_Due > '0' AND Disp_Type != 'G' AND PodData.Class_Code != '' AND Purch_Order_Number NOT LIKE '9CN%' "
                    . "$Extra GROUP BY PC_Name "
                    . "ORDER BY FIELD(PC_Name, 'Past Due', 'Unconfirm', 'Open Not Due')";
                //echo $GSQLRisk;
                //Para el color
                $rCol = $cnx->query($GSQLRisk)->fetchAll();
                $cadC = "";
                $conc = 0;
                foreach ($rCol as &$Color) {
                    $conc++;
                    if($conc == 1){
                        $cadC .= "colors:[";
                    }
                    $NameC = $Color['PC_Name'];
                    switch ($NameC){
                        case "Past Due":
                            $cadC .= "'red', ";
                            break;
                        case "Unconfirm":
                            $cadC .= "'orange', ";
                            break;
                        case "Open Not Due":
                            $cadC .= "'yellowgreen', ";
                            break;
                    }

                }

                if(!empty($cadC)){
                    $cadC = substr($cadC, 0, -2) . "]";
                }
                //echo $cadC;
                $ArrINFORisk['Colors'] = $cadC;
                //print_r($ArrINFORisk);
                //echo $GSQLRisk;
                //$GSQL01 = "SELECT Buyer AS PC_Name, COUNT(keyPPV) AS PC_Qty FROM PPVs GROUP BY Buyer ORDER BY PC_Qty DESC";
                //Crea el Dashboard
                echo GraphDraw($GTypeRisk, $GTitleRisk, $GDivRisk, $ArrINFORisk, $GSQLRisk);
            } else {
                switch($gRisk){
                    case "ME8":
                        $Extra .= " AND DATEDIFF(Vendor_Promise_Dt, '$dtAhora') < '8'";
                        break;
                    case "ME15":
                        $Extra .= " AND DATEDIFF(Vendor_Promise_Dt, '$dtAhora') BETWEEN '8' AND '14'";
                        break;
                    case "ME22":
                        $Extra .= " AND DATEDIFF(Vendor_Promise_Dt, '$dtAhora') BETWEEN '15' AND '21'";
                        break;
                    case "ME31":
                        $Extra .= " AND DATEDIFF(Vendor_Promise_Dt, '$dtAhora') BETWEEN '22' AND '30'";
                        break;
                    case "ME61":
                        $Extra .= " AND DATEDIFF(Vendor_Promise_Dt, '$dtAhora') BETWEEN '31' AND '60'";
                        break;
                    case "ME91":
                        $Extra .= " AND DATEDIFF(Vendor_Promise_Dt, '$dtAhora') BETWEEN '61' AND '90'";
                        break;
                    case "MAS90":
                        $Extra .= " AND DATEDIFF(Vendor_Promise_Dt, '$dtAhora') > '90'";
                        break;
                }

                $GTypeRisk = "PieChartLink";
                $GTitleRisk = "By Qty of Days Chart";
                $GDivRisk = "levelChart";
                $ArrINFORisk['SubtitleName'] = "Days";
                $ArrINFORisk['Units'] = "Days";
                $ArrINFORisk['SubtitleQty'] = "Qty";
                $ArrINFORisk['LoadDriver'] = 0;

                $pLinkRisk = "Include/reportCSV.php?report=ActPOControlDetail&KeyVII=";
                //$pLink = base64_encode("DetailPOCCustomerRisk");
                //$D2x = base64_encode("CustomerDays");
                $GSQLRisk = "SELECT "
                        . "DATEDIFF(Vendor_Promise_Dt, '$dtAhora') AS PC_Name, COUNT(DISTINCT idPodData) AS PC_Qty, "
                        . "CONCAT('$pLinkRisk', "
                        . "TO_BASE64(DATEDIFF(Vendor_Promise_Dt, '$dtAhora')), '&KeyIV=$cVendor&KeyII=$cIDOwner&KeyIII=$cCustomer&KeyVI=$cStatus&KeyV=$cRisk') AS PC_Link "
                        . "FROM PodData WHERE Balance_Due > '0' AND Vendor_Promise_Dt >= '$dateToday' AND Disp_Type != 'G' AND PodData.Class_Code != '' AND Purch_Order_Number NOT LIKE '9CN%' "
                        . "$Extra GROUP BY PC_Name ORDER BY PC_Name DESC";
                //echo $GSQL01;
                //Crea el Dashboard
                echo GraphDraw($GTypeRisk, $GTitleRisk, $GDivRisk, $ArrINFORisk, $GSQLRisk);
            }
            
            //echo $GSQLRisk;
            //********************************************************* Grafica Status
            $GTypeStatus = "PieChartLink";
            $GTitleStatus = "By Status Chart";
            $GDivStatus = "statusChart";
            $ArrINFOCustomer['SubtitleName'] = "Status";
            $ArrINFOCustomer['SubtitleQty'] = "Qty";
            $ArrINFOCustomer['LoadDriver'] = 0;
            
            if(empty($gStatus)){
                $pLinkStatus = "Dashboard.php?KeyI=" . base64_encode("Valid") . "&KeyVI=";
                $pLinkStatus = "Include/reportCSV.php?report=GenPOControlDetail&KeyVI=$cStatus";
                $GSQLStatus = "SELECT Status AS PC_Name, COUNT(DISTINCT idPodData) AS PC_Qty, "
                    . "CONCAT('$pLinkStatus', "
                    . " TO_BASE64(Status), '&KeyIII=$cCustomer&KeyIV=$cVendor&KeyII=$cIDOwner&KeyV=$cRisk&KeyVII=$cDays') AS PC_Link FROM PodData "
                    . "WHERE Balance_Due > '0' AND Disp_Type != 'G' AND PodData.Class_Code != '' AND Purch_Order_Number NOT LIKE '9CN%' "
                    . "$Extra GROUP BY PC_Name ORDER BY PC_Qty DESC";
            } else {
                $pLinkStatus = "Include/reportCSV.php?report=ActPOControlDetail&KeyIII=$cCustomer";
                $GSQLStatus = "SELECT Status AS PC_Name, COUNT(DISTINCT idPodData) AS PC_Qty, "
                    . "CONCAT('$pLinkStatus', "
                    . " '&KeyIV=$cVendor&KeyII=$cIDOwner&KeyV=$cRisk&KeyVI=$cStatus&KeyVII=$cDays') AS PC_Link FROM PodData "
                    . "WHERE Balance_Due > '0' AND Vendor_Promise_Dt >= '$dateToday' AND Disp_Type != 'G' AND PodData.Class_Code != '' AND Purch_Order_Number NOT LIKE '9CN%' "
                    . "$Extra GROUP BY PC_Name ORDER BY PC_Qty DESC";
            }
            
            //Crea el Dashboard
            echo GraphDraw($GTypeStatus, $GTitleStatus, $GDivStatus, $ArrINFOStatus, $GSQLStatus);
            
            
            //********************************************************* Tabla
            //Obtiene fecha del ultimo POD
            $SPOD = "SELECT dtAdded FROM PodData ORDER BY dtAdded DESC LIMIT 0, 1";
            $rPOD = $cnx->query($SPOD)->fetchArray();
            $dtPOD = $rPOD['dtAdded'];
            
            $FGraph = "<div style='padding:3px;position:fixed;top:70px;left:180px;text-align:left;'>"
                    . "<form action='Include/reportCSV.php?' target='_blank' method='get'>"
                    . "<font class='Robss' style='color:red;'>Open PO by Part Number<BR></font>"
                    . "<input class='text' type='text' id='Key' name='Key' holder='Part Number'>"
                    . "<input class='text' type='hidden' id='report' name='report' value='PNPOControlDetail'>"
                    . "</form>"
                    . "</div>";
            
            $FGraph .= "<table width='100%'>";
            $FGraph .= "<tr>"
                    . "<td width='25%' align='left'><font class='Exs'></font></td>"
                    . "<td colspan='2' align='center'><font class='Ex'>$TitleDashboard</font></td>"
                    . "<td width='25%' align='right'><font class='Robsss'><b>Updated on:</b><br></font><font class='Robss'>$dtPOD</font></td>"
                    . "</tr>"
                    . "<tr>"
                    . "<td width='25%' align='left'><font class='Exs'></font></td>"
                    . "<td colspan='2' align='center'><font class='Robs'>$SubtitleDashboard</font><BR>"
                    . "<font class='Robss'>$SubtitleDashboardDetail</font>"
                    . "</td>"
                    . "<td width='25%' align='right'><font class='Robsss'>"
                    . "<a href='Include/reportCSV.php?report=GenPOControlDetail&KeyI=$cKeyI&KeyII=$cIDOwner&KeyIII=$cCustomer&KeyIV=$cVendor&KeyV=$cRisk&KeyVI=$cStatus&KeyVII=$cDays' target='_blank'><img src='Images/xls.svg' width='30'></a>"
                    . "</td>"
                    . "</tr>"
                    . "<tr><td colspan='4' height='40'></td></tr>";
            $FGraph .= "<tr>"
                    . "<td colspan='2' width='50%' align='center'><font class='Exss'>$GTitleOwner</font><br><div id='$GDivOwner' style='height:400px;'></div></td>"
                    . "</td>"
                    . "<td colspan='2' width='50%' align='center'><font class='Exss'>$GTitleVendor</font><br><div id='$GDivVendor' style='height:400px;'></div></td>"
                    . "</tr>";
            $FGraph .= "<tr><td width='100%' colspan='4' align='center'><table width='100%'>";
            $FGraph .= "<tr>"
                    . "<td align='center' width='33%'><font class='Exss'>$GTitleCustomer</font><br><div id='$GDivCustomer' style='height:400px;'></div></td>"
                    . "</td>"
                    . "<td align='center' width='34%'><font class='Exss'>$GTitleRisk</font><br><div id='$GDivRisk' style='height:400px;'></div></td>"
                    . "<td align='center' width='33%'><font class='Exss'>$GTitleStatus</font><br><div id='$GDivStatus' style='height:400px;'></div></td>"
                    . "</tr>";
            $FGraph .= "</table></td></tr>";
            $FGraph .= "</table>";
            $FGraph .= "<script lang='javascript/text'>"
                    . "function resetear(){ document.location.reload(); }"
                    . "setTimeout(resetear, 50000);"
                    . "</script>";
            break;
        case "Valid":
            $cKey = base64_encode($gKeyI);
            //Dependes
            $gIDOwner = $gKeyII;
            $gCustomer = $gKeyIII;
            $gVendor = $gKeyIV;
            $gRisk = $gKeyV;
            $gStatus = $gKeyVI;
            $gDays = $gKeyVII;
            
            //*********************************************************Titulo
            if(!empty($gIDOwner)){
                $cIDOwner = base64_encode($gIDOwner);
                //Obtiene el nombre del owner
                $sInfoU = "SELECT * FROM Users WHERE IDUser = '$gIDOwner'";
                $rInfoU = $cnx->query($sInfoU)->fetchArray();
                $gOwner = $rInfoU['Name'] . " " . $rInfoU['FLastName'];
                $gTOwner = " Owner: <b>$gOwner</b> ";
                $Extra .= " AND IDOwner = '$gIDOwner' ";
            } else {
                $gTOwner = "";
            }
            
            if(!empty($gCustomer)){
                $cCustomer = base64_encode($gCustomer);
                $gTCustomer = " Customer: <b>$gCustomer</b> ";
                $Extra .= " AND Customer = '$gCustomer' ";
            } else {
                $gTCustomer = "";
            }
            
            if(!empty($gVendor)){
                $cVendor = base64_encode($gVendor);
                $gTVendor = " Vendor: <b>$gVendor</b> ";
                $Extra .= " AND Vendor_Name = '$gVendor' ";
            } else {
                $gTVendor = "";
            }
            
            if(!empty($gRisk)){
                $cRisk = base64_encode($gRisk);
                
                
                switch($gRisk){
                    case "ME8":
                        $Extra .= " AND DATEDIFF(Vendor_Promise_Dt, '$dtAhora') < '8'";
                        $gTitRisk = "Less than 8 days";
                        break;
                    case "ME15":
                        $Extra .= " AND DATEDIFF(Vendor_Promise_Dt, '$dtAhora') BETWEEN '8' AND '14'";
                        $gTitRisk = "8 to 14 days";
                        break;
                    case "ME22":
                        $Extra .= " AND DATEDIFF(Vendor_Promise_Dt, '$dtAhora') BETWEEN '15' AND '21'";
                        $gTitRisk = "15 to 21 days";
                        break;
                    case "ME31":
                        $Extra .= " AND DATEDIFF(Vendor_Promise_Dt, '$dtAhora') BETWEEN '22' AND '30'";
                        $gTitRisk = "22 to 30 days";
                        break;
                    case "ME61":
                        $Extra .= " AND DATEDIFF(Vendor_Promise_Dt, '$dtAhora') BETWEEN '31' AND '60'";
                        $gTitRisk = "31 to 60 days";
                        break;
                    case "ME91":
                        $Extra .= " AND DATEDIFF(Vendor_Promise_Dt, '$dtAhora') BETWEEN '61' AND '90'";
                        $gTitRisk = "60 to 90 days";
                        break;
                    case "MAS90":
                        $Extra .= " AND DATEDIFF(Vendor_Promise_Dt, '$dtAhora') > '90'";
                        $gTitRisk = "More than 90 days";
                        break;
                }
                
                $gTRisk = " Risk: <font style='color:red;'><b>$gTitRisk</b></font> ";
                
            } else {
                $gTRisk = "";
            }
            
            if(!empty($gStatus)){
                $Extra .= " AND Status = '$gStatus' ";
                $cStatus = base64_encode($gStatus);
                $gTStatus = " Status: <font style='color:blue;'><b>$gStatus</b></font> ";
            } else {
                $gTStatus = "";
            }
            
            //General Graphic
            $TitleDashboard = "Supply Chain PO Control Dashboard";
            $SubtitleDashboard = "<font style='color:green;'>Open Not Due</font> Impact by Delivery";
            $SubtitleDashboardDetail = "$gTOwner $gTCustomer $gTVendor $gTStatus $gTRisk";
            //********************************************************* Grafica Owner
            $GTypeOwner = "PieChartLink";
            $GTitleOwner = "By Owner Chart";
            $GDivOwner = "ownerChart";
            $ArrINFOOwner['SubtitleName'] = "Owner";
            $ArrINFOOwner['SubtitleQty'] = "Qty";
            $ArrINFOOwner['LoadDriver'] = 1;
            if(empty($gIDOwner)){
                $pLinkOwner = "Dashboard.php?KeyI=" . base64_encode("Valid") . "&KeyII=";
                $GSQLOwner = "SELECT Owner AS PC_Name, COUNT(DISTINCT idPodData) AS PC_Qty, "
                    . "CONCAT('$pLinkOwner', "
                    . " TO_BASE64(IDOwner), '&KeyIII=$cCustomer&KeyIV=$cVendor&KeyV=$cRisk&KeyVI=$cStatus&KeyVII=$cDays') AS PC_Link FROM PodData "
                    . "WHERE Balance_Due > '0' AND Vendor_Promise_Dt >= '$dateToday' AND Disp_Type != 'G' AND PodData.Class_Code != '' AND Purch_Order_Number NOT LIKE '9CN%' "
                    . "$Extra GROUP BY PC_Name ORDER BY PC_Qty DESC";
            
            } else {
                $pLinkOwner = "Include/reportCSV.php?report=ActPOControlDetail&KeyII=$cIDOwner";
                /*
                 * SELECT POControl.Owner, PodData.Buyer AS Buyer, COUNT(DISTINCT PodData.idPodData) AS Qty FROM PodData, POControl WHERE PodData.Purch_Order_Number = POControl.Purch_Order_Number AND PodData.Balance_Due > '0' AND PodData.Vendor_Promise_Dt > '2022-01-18' AND PodData.Disp_Type != 'G' AND PodData.Class_Code != '' AND PodData.Purch_Order_Number NOT LIKE '9CN%'  GROUP BY POControl.Owner;
                 */
                
                $GSQLOwner = "SELECT Owner AS PC_Name, COUNT(DISTINCT idPodData) AS PC_Qty, "
                    . "CONCAT('$pLinkOwner', "
                    . " '&KeyIII=$cCustomer&KeyIV=$cVendor&KeyV=$cRisk&KeyVI=$cStatus&KeyVII=$cDays') AS PC_Link FROM PodData "
                    . "WHERE Balance_Due > '0' AND Vendor_Promise_Dt >= '$dateToday' AND Disp_Type != 'G' AND PodData.Class_Code != '' AND Purch_Order_Number NOT LIKE '9CN%' "
                    . "$Extra GROUP BY PC_Name ORDER BY PC_Qty DESC";
            
            }
            
            //echo $GSQLOwner;
            
            //Crea el Dashboard
            echo GraphDraw($GTypeOwner, $GTitleOwner, $GDivOwner, $ArrINFOOwner, $GSQLOwner);
            
            
            //********************************************************* Grafica Vendor
            $GTypeVendor = "PieChartLink";
            $GTitleVendor = "By Vendor Chart";
            $GDivVendor = "vendorChart";
            $ArrINFOVendor['SubtitleName'] = "Vendor";
            $ArrINFOVendor['SubtitleQty'] = "Qty";
            $ArrINFOVendor['LoadDriver'] = 0;
            
            if(empty($gVendor)){
                $pLinkVendor = "Dashboard.php?KeyI=" . base64_encode("Valid") . "&KeyIV=";
                $GSQLVendor = "SELECT Vendor_Name AS PC_Name, COUNT(DISTINCT idPodData) AS PC_Qty, "
                    . "CONCAT('$pLinkVendor', "
                    . " TO_BASE64(Vendor_Name), '&KeyIII=$cCustomer&KeyII=$cIDOwner&KeyV=$cRisk&KeyVI=$cStatus&KeyVII=$cDays') AS PC_Link FROM PodData "
                    . "WHERE Balance_Due > '0' AND Vendor_Promise_Dt >= '$dateToday' AND Disp_Type != 'G' AND PodData.Class_Code != '' AND Purch_Order_Number NOT LIKE '9CN%' "
                    . "$Extra GROUP BY PC_Name ORDER BY PC_Qty DESC";
            } else {
                $pLinkVendor = "Include/reportCSV.php?report=ActPOControlDetail&KeyIV=$cVendor";
                $GSQLVendor = "SELECT Vendor_Name AS PC_Name, COUNT(DISTINCT idPodData) AS PC_Qty, "
                    . "CONCAT('$pLinkVendor', "
                    . " '&KeyIII=$cCustomer&KeyII=$cIDOwner&KeyV=$cRisk&KeyVI=$cStatus&KeyVII=$cDays') AS PC_Link FROM PodData "
                    . "WHERE Balance_Due > '0' AND Vendor_Promise_Dt >= '$dateToday' AND Disp_Type != 'G' AND PodData.Class_Code != '' AND Purch_Order_Number NOT LIKE '9CN%' "
                    . "$Extra GROUP BY PC_Name ORDER BY PC_Qty DESC";
            }
            
            //Crea el Dashboard
            echo GraphDraw($GTypeVendor, $GTitleVendor, $GDivVendor, $ArrINFOVendor, $GSQLVendor);
            
            //********************************************************* Grafica Customer
            $GTypeCustomer = "PieChartLink";
            $GTitleCustomer = "By CustomerChart";
            $GDivCustomer = "customerChart";
            $ArrINFOCustomer['SubtitleName'] = "Customer";
            $ArrINFOCustomer['SubtitleQty'] = "Qty";
            $ArrINFOCustomer['LoadDriver'] = 0;
            
            if(empty($gCustomer)){
                $pLinkCustomer = "Dashboard.php?KeyI=" . base64_encode("Valid") . "&KeyIII=";
                $GSQLCustomer = "SELECT Customer AS PC_Name, COUNT(DISTINCT idPodData) AS PC_Qty, "
                    . "CONCAT('$pLinkCustomer', "
                    . " TO_BASE64(Customer), '&KeyIV=$cVendor&KeyII=$cIDOwner&KeyV=$cRisk&KeyVI=$cStatus&KeyVII=$cDays') AS PC_Link FROM PodData "
                    . "WHERE Balance_Due > '0' AND Vendor_Promise_Dt >= '$dateToday' AND Disp_Type != 'G' AND PodData.Class_Code != '' AND Purch_Order_Number NOT LIKE '9CN%' "
                    . "$Extra GROUP BY PC_Name ORDER BY PC_Qty DESC";
            } else {
                $pLinkCustomer = "Include/reportCSV.php?report=ActPOControlDetail&KeyIII=$cCustomer";
                $GSQLCustomer = "SELECT Customer AS PC_Name, COUNT(DISTINCT idPodData) AS PC_Qty, "
                    . "CONCAT('$pLinkCustomer', "
                    . " '&KeyIV=$cVendor&KeyII=$cIDOwner&KeyV=$cRisk&KeyVI=$cStatus&KeyVII=$cDays') AS PC_Link FROM PodData "
                    . "WHERE Balance_Due > '0' AND Vendor_Promise_Dt >= '$dateToday' AND Disp_Type != 'G' AND PodData.Class_Code != '' AND Purch_Order_Number NOT LIKE '9CN%' "
                    . "$Extra GROUP BY PC_Name ORDER BY PC_Qty DESC";
            }
            
            //Crea el Dashboard
            echo GraphDraw($GTypeCustomer, $GTitleCustomer, $GDivCustomer, $ArrINFOCustomer, $GSQLCustomer);
            
            //********************************************************* Grafica Risk
            if(empty($gRisk)){
                $GTypeRisk = "PieChartLink";
                $GTitleRisk = "By Risk Chart";
                $GDivRisk = "LevelChart";
                $ArrINFORisk['SubtitleName'] = "Risk";
                $ArrINFORisk['SubtitleQty'] = "Qty";
                $ArrINFORisk['LoadDriver'] = 0;
                $ArrINFORisk['Colors'] = "colors:['red', 'orange', '#3366cc']";
                //Obtiene todos los campos
                //LOW
                $clevel = 0;
                $AvgLevels = "";
                while ($clevel < 7){
                    $clevel++;
                    $TLevel = 0;
                    $TQty = 0;
                    switch ($clevel){
                        case 1:
                            $qr = "< 8";
                            break;
                        case 2:
                            $qr = "BETWEEN '8' AND '14'";
                            break;
                        case 3:
                            $qr = "BETWEEN '15' AND '21'";
                            break;
                        case 4:
                            $qr = "BETWEEN '22' AND '30'";
                            break;
                        case 5:
                            $qr = "BETWEEN '31' AND '60'";
                            break;
                        case 6:
                            $qr = "BETWEEN '61' AND '90'";
                            break;
                        case 7:
                            $qr = "> 90";
                            break;
                    }
                    $sAvg = "SELECT DATEDIFF(Vendor_Promise_Dt, '$dtAhora') AS NDays, COUNT(DISTINCT idPodData) AS QNP "
                        . "FROM PodData "
                        . "WHERE Balance_Due > '0' AND Vendor_Promise_Dt >= '$dateToday' AND Disp_Type != 'G' AND PodData.Class_Code != '' AND Purch_Order_Number NOT LIKE '9CN%' "
                        . "$Extra "
                        . "AND DATEDIFF(Vendor_Promise_Dt, '$dtAhora') $qr "
                        . "GROUP BY NDays";
                    
                    //echo $sAvg . "<BR>";
                    
                    $nAvg = $cnx->query($sAvg)->numRows();
                    if($nAvg > 0){
                        $LAvg = $cnx->query($sAvg)->fetchAll();
                        foreach ($LAvg as &$rAvg) {
                            $gNDays = $rAvg['NDays'];
                            $gQNP = $rAvg['QNP'];
                            $TLevel += $gQNP;
                            $TQty += ($gNDays * $gQNP);
                        }
                        $Avg = round($TQty/$TLevel);
                        $AvgLevels .= "AVG:$Avg|";
                    } else {
                        //$AvgLevels .= "0|";
                    }

                }
                

                $AvgLevels = substr($AvgLevels, 0, -1);
                //echo $AvgLevels;
                $ArrINFORisk['ExtraData'] = $AvgLevels;

                $pLinkRisk = "Dashboard.php?KeyI=" . base64_encode("Valid") . "&KeyV=";
                $GSQLRisk = "SELECT "
                    . "CASE "
                    . "WHEN DATEDIFF(Vendor_Promise_Dt, '$dtAhora') < 8 THEN 'Less than 8 days' "
                    . "WHEN DATEDIFF(Vendor_Promise_Dt, '$dtAhora') < 15 THEN '8 to 14 days' "
                    . "WHEN DATEDIFF(Vendor_Promise_Dt, '$dtAhora') < 22 THEN '15 to 21 days' "
                    . "WHEN DATEDIFF(Vendor_Promise_Dt, '$dtAhora') < 31 THEN '22 to 30 days' "
                    . "WHEN DATEDIFF(Vendor_Promise_Dt, '$dtAhora') < 61 THEN '31 to 60 days' "
                    . "WHEN DATEDIFF(Vendor_Promise_Dt, '$dtAhora') < 91 THEN '60 to 90 days' "
                    . "ELSE 'More than 90 days' "
                    . "END AS PC_Name, COUNT(DISTINCT idPodData) AS PC_Qty, "
                    . "CONCAT('$pLinkRisk', " 
                    . " TO_BASE64("
                    . "CASE "
                    . "WHEN DATEDIFF(Vendor_Promise_Dt, '$dtAhora') < 8 THEN 'ME8' "
                    . "WHEN DATEDIFF(Vendor_Promise_Dt, '$dtAhora') < 15 THEN 'ME15' "
                    . "WHEN DATEDIFF(Vendor_Promise_Dt, '$dtAhora') < 22 THEN 'ME22' "
                    . "WHEN DATEDIFF(Vendor_Promise_Dt, '$dtAhora') < 31 THEN 'ME31' "
                    . "WHEN DATEDIFF(Vendor_Promise_Dt, '$dtAhora') < 61 THEN 'ME61' "
                    . "WHEN DATEDIFF(Vendor_Promise_Dt, '$dtAhora') < 91 THEN 'ME91' "
                    . "ELSE 'MAS90'"
                    . "END"
                    . "), '&KeyIV=$cVendor&KeyII=$cIDOwner&KeyIII=$cCustomer&KeyVI=$cStatus&KeyVII=$cDays') AS PC_Link "
                    . "FROM PodData WHERE Balance_Due > '0' AND Vendor_Promise_Dt >= '$dateToday' AND Disp_Type != 'G' AND PodData.Class_Code != '' AND Purch_Order_Number NOT LIKE '9CN%' "
                    . "$Extra GROUP BY PC_Name "
                    . "ORDER BY FIELD(PC_Name, 'Less than 8 days', '8 to 14 days', '15 to 21 days', '22 to 30 days', '31 to 60 days', '60 to 90 days', 'More than 90 days')";
                //echo $GSQLRisk;
                //Para el color
                $rCol = $cnx->query($GSQLRisk)->fetchAll();
                $cadC = "";
                $conc = 0;
                foreach ($rCol as &$Color) {
                    $conc++;
                    if($conc == 1){
                        $cadC .= "colors:[";
                    }
                    $NameC = $Color['PC_Name'];
                    switch ($NameC){
                        case "Less than 8 days":
                            $cadC .= "'red', ";
                            break;
                        case "8 to 14 days":
                            $cadC .= "'orange', ";
                            break;
                        case "15 to 21 days":
                            $cadC .= "'yellow', ";
                            break;
                        case "22 to 30 days":
                            $cadC .= "'#3366cc', ";
                            break;
                        case "31 to 60 days":
                            $cadC .= "'blue', ";
                            break;
                        case "60 to 90 days":
                            $cadC .= "'green', ";
                            break;
                        case "More than 90 days":
                            $cadC .= "'yellowgreen', ";
                            break;
                    }

                }

                if(!empty($cadC)){
                    $cadC = substr($cadC, 0, -2) . "]";
                }
                //echo $cadC;
                $ArrINFORisk['Colors'] = $cadC;
                //print_r($ArrINFORisk);
                //echo $GSQLRisk;
                //$GSQL01 = "SELECT Buyer AS PC_Name, COUNT(keyPPV) AS PC_Qty FROM PPVs GROUP BY Buyer ORDER BY PC_Qty DESC";
                //Crea el Dashboard
                echo GraphDraw($GTypeRisk, $GTitleRisk, $GDivRisk, $ArrINFORisk, $GSQLRisk);
            } else {
                switch($gRisk){
                    case "ME8":
                        $Extra .= " AND DATEDIFF(Vendor_Promise_Dt, '$dtAhora') < '8'";
                        break;
                    case "ME15":
                        $Extra .= " AND DATEDIFF(Vendor_Promise_Dt, '$dtAhora') BETWEEN '8' AND '14'";
                        break;
                    case "ME22":
                        $Extra .= " AND DATEDIFF(Vendor_Promise_Dt, '$dtAhora') BETWEEN '15' AND '21'";
                        break;
                    case "ME31":
                        $Extra .= " AND DATEDIFF(Vendor_Promise_Dt, '$dtAhora') BETWEEN '22' AND '30'";
                        break;
                    case "ME61":
                        $Extra .= " AND DATEDIFF(Vendor_Promise_Dt, '$dtAhora') BETWEEN '31' AND '60'";
                        break;
                    case "ME91":
                        $Extra .= " AND DATEDIFF(Vendor_Promise_Dt, '$dtAhora') BETWEEN '61' AND '90'";
                        break;
                    case "MAS90":
                        $Extra .= " AND DATEDIFF(Vendor_Promise_Dt, '$dtAhora') > '90'";
                        break;
                }

                $GTypeRisk = "PieChartLink";
                $GTitleRisk = "By Qty of Days Chart";
                $GDivRisk = "levelChart";
                $ArrINFORisk['SubtitleName'] = "Days";
                $ArrINFORisk['Units'] = "Days";
                $ArrINFORisk['SubtitleQty'] = "Qty";
                $ArrINFORisk['LoadDriver'] = 0;

                $pLinkRisk = "Include/reportCSV.php?report=ActPOControlDetail&KeyVII=";
                //$pLink = base64_encode("DetailPOCCustomerRisk");
                //$D2x = base64_encode("CustomerDays");
                $GSQLRisk = "SELECT "
                        . "DATEDIFF(Vendor_Promise_Dt, '$dtAhora') AS PC_Name, COUNT(DISTINCT idPodData) AS PC_Qty, "
                        . "CONCAT('$pLinkRisk', "
                        . "TO_BASE64(DATEDIFF(Vendor_Promise_Dt, '$dtAhora')), '&KeyIV=$cVendor&KeyII=$cIDOwner&KeyIII=$cCustomer&KeyVI=$cStatus&KeyV=$cRisk') AS PC_Link "
                        . "FROM PodData WHERE Balance_Due > '0' AND Vendor_Promise_Dt >= '$dateToday' AND Disp_Type != 'G' AND PodData.Class_Code != '' AND Purch_Order_Number NOT LIKE '9CN%' "
                        . "$Extra GROUP BY PC_Name ORDER BY PC_Name DESC";
                //echo $GSQL01;
                //Crea el Dashboard
                echo GraphDraw($GTypeRisk, $GTitleRisk, $GDivRisk, $ArrINFORisk, $GSQLRisk);
            }
            
            //echo $GSQLRisk;
            //********************************************************* Grafica Status
            $GTypeStatus = "PieChartLink";
            $GTitleStatus = "By Status Chart";
            $GDivStatus = "statusChart";
            $ArrINFOCustomer['SubtitleName'] = "Status";
            $ArrINFOCustomer['SubtitleQty'] = "Qty";
            $ArrINFOCustomer['LoadDriver'] = 0;
            
            if(empty($gStatus)){
                $pLinkStatus = "Dashboard.php?KeyI=" . base64_encode("Valid") . "&KeyVI=";
                $GSQLStatus = "SELECT Status AS PC_Name, COUNT(DISTINCT idPodData) AS PC_Qty, "
                    . "CONCAT('$pLinkStatus', "
                    . " TO_BASE64(Status), '&KeyIII=$cCustomer&KeyIV=$cVendor&KeyII=$cIDOwner&KeyV=$cRisk&KeyVII=$cDays') AS PC_Link FROM PodData "
                    . "WHERE Balance_Due > '0' AND Vendor_Promise_Dt >= '$dateToday' AND Disp_Type != 'G' AND PodData.Class_Code != '' AND Purch_Order_Number NOT LIKE '9CN%' "
                    . "$Extra GROUP BY PC_Name ORDER BY PC_Qty DESC";
            } else {
                $pLinkStatus = "Include/reportCSV.php?report=ActPOControlDetail&KeyIII=$cCustomer";
                $GSQLStatus = "SELECT Status AS PC_Name, COUNT(DISTINCT idPodData) AS PC_Qty, "
                    . "CONCAT('$pLinkStatus', "
                    . " '&KeyIV=$cVendor&KeyII=$cIDOwner&KeyV=$cRisk&KeyVI=$cStatus&KeyVII=$cDays') AS PC_Link FROM PodData "
                    . "WHERE Balance_Due > '0' AND Vendor_Promise_Dt >= '$dateToday' AND Disp_Type != 'G' AND PodData.Class_Code != '' AND Purch_Order_Number NOT LIKE '9CN%' "
                    . "$Extra GROUP BY PC_Name ORDER BY PC_Qty DESC";
            }
            
            //Crea el Dashboard
            echo GraphDraw($GTypeStatus, $GTitleStatus, $GDivStatus, $ArrINFOStatus, $GSQLStatus);
            
            
            //********************************************************* Tabla
            //Obtiene fecha del ultimo POD
            $SPOD = "SELECT dtAdded FROM PodData ORDER BY dtAdded DESC LIMIT 0, 1";
            $rPOD = $cnx->query($SPOD)->fetchArray();
            $dtPOD = $rPOD['dtAdded'];
            
            $FGraph = "";
            $FGraph = "<table width='100%'>";
            $FGraph .= "<tr>"
                    . "<td width='25%' align='left'><font class='Exs'></font></td>"
                    . "<td colspan='2' align='center'><font class='Ex'>$TitleDashboard</font></td>"
                    . "<td width='25%' align='right'><font class='Robsss'><b>Updated on:</b><br></font><font class='Robss'>$dtPOD</font></td>"
                    . "</tr>"
                    . "<tr>"
                    . "<td width='25%' align='left'><font class='Exs'></font></td>"
                    . "<td colspan='2' align='center'><font class='Robs'>$SubtitleDashboard</font><BR>"
                    . "<font class='Robss'>$SubtitleDashboardDetail</font></td>"
                    . "<td width='25%' align='right'><font class='Robsss'><a href='Include/reportCSV.php?report=ActPOControlDetail&KeyI=$cKeyI&KeyII=$cIDOwner&KeyIII=$cCustomer&KeyIV=$cVendor&KeyV=$cRisk&KeyVI=$cStatus&KeyVII=$cDays' target='_blank'><img src='Images/xls.svg' width='30'></a></td>"
                    . "</tr>"
                    . "<tr><td colspan='4' height='40'></td></tr>";
            $FGraph .= "<tr>"
                    . "<td colspan='2' width='50%' align='center'><font class='Exss'>$GTitleOwner</font><br><div id='$GDivOwner' style='height:400px;'></div></td>"
                    . "</td>"
                    . "<td colspan='2' width='50%' align='center'><font class='Exss'>$GTitleVendor</font><br><div id='$GDivVendor' style='height:400px;'></div></td>"
                    . "</tr>";
            $FGraph .= "<tr><td width='100%' colspan='4' align='center'><table width='100%'>";
            $FGraph .= "<tr>"
                    . "<td align='center' width='33%'><font class='Exss'>$GTitleCustomer</font><br><div id='$GDivCustomer' style='height:400px;'></div></td>"
                    . "</td>"
                    . "<td align='center' width='34%'><font class='Exss'>$GTitleRisk</font><br><div id='$GDivRisk' style='height:400px;'></div></td>"
                    . "<td align='center' width='33%'><font class='Exss'>$GTitleStatus</font><br><div id='$GDivStatus' style='height:400px;'></div></td>"
                    . "</tr>";
            $FGraph .= "</table></td></tr>";
            $FGraph .= "</table>";
            $FGraph .= "<script lang='javascript/text'>"
                    . "function resetear(){ document.location.reload(); }"
                    . "setTimeout(resetear, 50000);"
                    . "</script>";
            break;
        case "DueDate":
            $cKey = base64_encode($gKeyI);
            //Dependes
            $gIDOwner = $gKeyII;
            $gCustomer = $gKeyIII;
            $gVendor = $gKeyIV;
            $gRisk = $gKeyV;
            $gStatus = $gKeyVI;
            $gDays = $gKeyVII;
            
            //*********************************************************Titulo
            if(!empty($gIDOwner)){
                $cIDOwner = base64_encode($gIDOwner);
                //Obtiene el nombre del owner
                $sInfoU = "SELECT * FROM Users WHERE IDUser = '$gIDOwner'";
                $rInfoU = $cnx->query($sInfoU)->fetchArray();
                $gOwner = $rInfoU['Name'] . " " . $rInfoU['FLastName'];
                $gTOwner = " Owner: <b>$gOwner</b> ";
                $Extra .= " AND IDOwner = '$gIDOwner' ";
            } else {
                $gTOwner = "";
            }
            
            if(!empty($gCustomer)){
                $cCustomer = base64_encode($gCustomer);
                $gTCustomer = " Customer: <b>$gCustomer</b> ";
                $Extra .= " AND Customer = '$gCustomer' ";
            } else {
                $gTCustomer = "";
            }
            
            if(!empty($gVendor)){
                $cVendor = base64_encode($gVendor);
                $gTVendor = " Vendor: <b>$gVendor</b> ";
                $Extra .= " AND Vendor_Name = '$gVendor' ";
            } else {
                $gTVendor = "";
            }
            
            if(!empty($gRisk)){
                $cRisk = base64_encode($gRisk);
                $gTRisk = " Risk: <font style='color:red;'><b>$gRisk</b></font> ";
                
                switch($gRisk){
                    case "LOW":
                        $Extra .= " AND DATEDIFF('$dtAhora', Purchase_Order_Add_Date) < '8'";
                        break;
                    case "MEDIUM":
                        $Extra .= " AND DATEDIFF('$dtAhora', Purchase_Order_Add_Date) BETWEEN '8' AND '15'";
                        break;
                    case "HIGH":
                        $Extra .= " AND DATEDIFF('$dtAhora', Purchase_Order_Add_Date) > '15'";
                        break;
                }
                
            } else {
                $gTRisk = "";
            }
            
            if(!empty($gStatus)){
                $Extra .= " AND Status = '$gStatus' ";
                $cStatus = base64_encode($gStatus);
                $gTStatus = " Status: <font style='color:blue;'><b>$gStatus</b></font> ";
            } else {
                $gTStatus = "";
            }
            
            //General Graphic
            $TitleDashboard = "Supply Chain PO Control Dashboard";
            $SubtitleDashboard = "<font style='color:red;'>Past Due</font> Impact by Delivery";
            $SubtitleDashboardDetail = "$gTOwner $gTCustomer $gTVendor $gTStatus $gTRisk";
            //********************************************************* Grafica Owner
            $GTypeOwner = "PieChartLink";
            $GTitleOwner = "By Owner Chart";
            $GDivOwner = "ownerChart";
            $ArrINFOOwner['SubtitleName'] = "Owner";
            $ArrINFOOwner['SubtitleQty'] = "Qty";
            $ArrINFOOwner['LoadDriver'] = 1;
            if(empty($gIDOwner)){
                $pLinkOwner = "Dashboard.php?KeyI=" . base64_encode("DueDate") . "&KeyII=";
                $GSQLOwner = "SELECT Owner AS PC_Name, SUM(QtyExpire) AS PC_Qty, "
                    . "CONCAT('$pLinkOwner', "
                    . " TO_BASE64(IDOwner), '&KeyIII=$cCustomer&KeyIV=$cVendor&KeyV=$cRisk&KeyVI=$cStatus&KeyVII=$cDays') AS PC_Link FROM POControl "
                    . "WHERE QtyExpire > '0' $Extra GROUP BY PC_Name ORDER BY PC_Qty DESC";
            
            } else {
                $pLinkOwner = "Include/reportCSV.php?report=DDPOControl&KeyII=$cIDOwner";
                $GSQLOwner = "SELECT Owner AS PC_Name, SUM(QtyExpire) AS PC_Qty, "
                    . "CONCAT('$pLinkOwner', "
                    . " '&KeyIII=$cCustomer&KeyIV=$cVendor&KeyV=$cRisk&KeyVI=$cStatus&KeyVII=$cDays') AS PC_Link FROM POControl "
                    . "WHERE QtyExpire > '0' $Extra GROUP BY PC_Name ORDER BY PC_Qty DESC";
            
            }
            
            //echo $GSQLOwner;
            
            //Crea el Dashboard
            echo GraphDraw($GTypeOwner, $GTitleOwner, $GDivOwner, $ArrINFOOwner, $GSQLOwner);
            
            
            //********************************************************* Grafica Vendor
            $GTypeVendor = "PieChartLink";
            $GTitleVendor = "By Vendor Chart";
            $GDivVendor = "vendorChart";
            $ArrINFOVendor['SubtitleName'] = "Vendor";
            $ArrINFOVendor['SubtitleQty'] = "Qty";
            $ArrINFOVendor['LoadDriver'] = 0;
            
            if(empty($gVendor)){
                $pLinkVendor = "Dashboard.php?KeyI=" . base64_encode("DueDate") . "&KeyIV=";
                $GSQLVendor = "SELECT Vendor_Name AS PC_Name, SUM(QtyExpire) AS PC_Qty, "
                    . "CONCAT('$pLinkVendor', "
                    . " TO_BASE64(Vendor_Name), '&KeyIII=$cCustomer&KeyII=$cIDOwner&KeyV=$cRisk&KeyVI=$cStatus&KeyVII=$cDays') AS PC_Link FROM POControl "
                    . "WHERE QtyExpire > '0' $Extra GROUP BY PC_Name ORDER BY PC_Qty DESC";
            } else {
                $pLinkVendor = "Include/reportCSV.php?report=DDPOControl&KeyIV=$cVendor";
                $GSQLVendor = "SELECT Vendor_Name AS PC_Name, SUM(QtyExpire) AS PC_Qty, "
                    . "CONCAT('$pLinkVendor', "
                    . " '&KeyIII=$cCustomer&KeyII=$cIDOwner&KeyV=$cRisk&KeyVI=$cStatus&KeyVII=$cDays') AS PC_Link FROM POControl "
                    . "WHERE QtyExpire > '0' $Extra GROUP BY PC_Name ORDER BY PC_Qty DESC";
            }
            
            //Crea el Dashboard
            echo GraphDraw($GTypeVendor, $GTitleVendor, $GDivVendor, $ArrINFOVendor, $GSQLVendor);
            
            //********************************************************* Grafica Customer
            $GTypeCustomer = "PieChartLink";
            $GTitleCustomer = "By CustomerChart";
            $GDivCustomer = "customerChart";
            $ArrINFOCustomer['SubtitleName'] = "Customer";
            $ArrINFOCustomer['SubtitleQty'] = "Qty";
            $ArrINFOCustomer['LoadDriver'] = 0;
            
            if(empty($gCustomer)){
                $pLinkCustomer = "Dashboard.php?KeyI=" . base64_encode("DueDate") . "&KeyIII=";
                $GSQLCustomer = "SELECT Customer AS PC_Name, SUM(QtyExpire) AS PC_Qty, "
                    . "CONCAT('$pLinkCustomer', "
                    . " TO_BASE64(Customer), '&KeyIV=$cVendor&KeyII=$cIDOwner&KeyV=$cRisk&KeyVI=$cStatus&KeyVII=$cDays') AS PC_Link FROM POControl "
                    . "WHERE QtyExpire > '0' $Extra GROUP BY PC_Name ORDER BY PC_Qty DESC";
            } else {
                $pLinkCustomer = "Include/reportCSV.php?report=DDPOControl&KeyIII=$cCustomer";
                $GSQLCustomer = "SELECT Customer AS PC_Name, SUM(QtyExpire) AS PC_Qty, "
                    . "CONCAT('$pLinkCustomer', "
                    . " '&KeyIV=$cVendor&KeyII=$cIDOwner&KeyV=$cRisk&KeyVI=$cStatus&KeyVII=$cDays') AS PC_Link FROM POControl "
                    . "WHERE QtyExpire > '0' $Extra GROUP BY PC_Name ORDER BY PC_Qty DESC";
            }
            
            //Crea el Dashboard
            echo GraphDraw($GTypeCustomer, $GTitleCustomer, $GDivCustomer, $ArrINFOCustomer, $GSQLCustomer);
            
            //********************************************************* Grafica Risk
            if(empty($gRisk)){
                $GTypeRisk = "PieChartLink";
                $GTitleRisk = "By Risk Chart";
                $GDivRisk = "LevelChart";
                $ArrINFORisk['SubtitleName'] = "Risk";
                $ArrINFORisk['SubtitleQty'] = "Qty";
                $ArrINFORisk['LoadDriver'] = 1;
                $ArrINFORisk['Colors'] = "colors:['red', 'orange', '#3366cc']";
                //Obtiene todos los campos
                //LOW
                $clevel = 0;
                $AvgLevels = "";
                while ($clevel < 3){
                    $clevel++;
                    $TLevel = 0;
                    $TQty = 0;
                    switch ($clevel){
                        case 1:
                            $qr = "> 15";
                            break;
                        case 2:
                            $qr = "BETWEEN '8' AND '15'";
                            break;
                        case 3:
                            $qr = "BETWEEN '0' AND '7'";
                            break;
                    }
                    $sAvg = "SELECT DATEDIFF('$dtAhora', Purchase_Order_Add_Date) AS NDays, SUM(QtyExpire) AS QNP "
                        . "FROM POControl WHERE QtyExpire > '0' $Extra "
                        . "AND DATEDIFF('$dtAhora', Purchase_Order_Add_Date) $qr "
                        . "GROUP BY NDays";
                    $nAvg = $cnx->query($sAvg)->numRows();
                    if($nAvg > 0){
                        $LAvg = $cnx->query($sAvg)->fetchAll();
                        foreach ($LAvg as &$rAvg) {
                            $gNDays = $rAvg['NDays'];
                            $gQNP = $rAvg['QNP'];
                            $TLevel += $gQNP;
                            $TQty += ($gNDays * $gQNP);
                        }
                        $Avg = round($TQty/$TLevel);
                        $AvgLevels .= "AVG:$Avg|";
                    } else {
                        //$AvgLevels .= "0|";
                    }

                }
                //echo $AvgLevels;

                $AvgLevels = substr($AvgLevels, 0, -1);
                $ArrINFORisk['ExtraData'] = $AvgLevels;

                $pLinkRisk = "Dashboard.php?KeyI=" . base64_encode("DueDate") . "&KeyV=";
                $GSQLRisk = "SELECT "
                    . "CASE "
                    . "WHEN DATEDIFF('$dtAhora', Purchase_Order_Add_Date) < 8 THEN 'LOW RISK - Less than 8 days' "
                    . "WHEN DATEDIFF('$dtAhora', Purchase_Order_Add_Date) < 16 THEN 'MEDIUM RISK - 8 to 15 days' "
                    . "ELSE 'HIGH RISK - More than 16 days' "
                    . "END AS PC_Name, SUM(QtyExpire) AS PC_Qty, "
                    . "CONCAT('$pLinkRisk', " 
                     . " TO_BASE64("
                    . "CASE "
                    . "WHEN DATEDIFF('$dtAhora', Purchase_Order_Add_Date) < 8 THEN 'LOW' "
                    . "WHEN DATEDIFF('$dtAhora', Purchase_Order_Add_Date) < 16 THEN 'MEDIUM' "
                    . "ELSE 'HIGH'"
                    . "END"
                    . "), '&KeyIV=$cVendor&KeyII=$cIDOwner&KeyIII=$cCustomer&KeyVI=$cStatus&KeyVII=$cDays') AS PC_Link "
                    . "FROM POControl WHERE QtyExpire > '0' $Extra GROUP BY PC_Name "
                    . "ORDER BY FIELD(PC_Name, 'HIGH RISK - More than 16 days', 'MEDIUM RISK - 8 to 15 days', 'LOW RISK - Less than 8 days')";

                //Para el color
                $rCol = $cnx->query($GSQLRisk)->fetchAll();
                $cadC = "";
                $conc = 0;
                foreach ($rCol as &$Color) {
                    $conc++;
                    if($conc == 1){
                        $cadC .= "colors:[";
                    }
                    $NameC = $Color['PC_Name'];
                    switch ($NameC){
                        case "HIGH RISK - More than 16 days":
                            $cadC .= "'red', ";
                            break;
                        case "MEDIUM RISK - 8 to 15 days":
                            $cadC .= "'orange', ";
                            break;
                        case "LOW RISK - Less than 8 days":
                            $cadC .= "'#3366cc', ";
                            break;
                    }

                }

                if(!empty($cadC)){
                    $cadC = substr($cadC, 0, -2) . "]";
                }
                //echo $cadC;
                $ArrINFORisk['Colors'] = $cadC;

                //echo $GSQLRisk;
                //$GSQL01 = "SELECT Buyer AS PC_Name, COUNT(keyPPV) AS PC_Qty FROM PPVs GROUP BY Buyer ORDER BY PC_Qty DESC";
                //Crea el Dashboard
                echo GraphDraw($GTypeRisk, $GTitleRisk, $GDivRisk, $ArrINFORisk, $GSQLRisk);
            } else {
                switch($gRisk){
                    case "LOW":
                        $Extra .= " AND DATEDIFF('$dtAhora', Purchase_Order_Add_Date) < '8'";
                        break;
                    case "MEDIUM":
                        $Extra .= " AND DATEDIFF('$dtAhora', Purchase_Order_Add_Date) BETWEEN '8' AND '15'";
                        break;
                    case "HIGH":
                        $Extra .= " AND DATEDIFF('$dtAhora', Purchase_Order_Add_Date) > '15'";
                        break;
                }

                $GTypeRisk = "PieChartLink";
                $GTitleRisk = "By Qty of Days Chart";
                $GDivRisk = "levelChart";
                $ArrINFORisk['SubtitleName'] = "Days";
                $ArrINFORisk['Units'] = "Days";
                $ArrINFORisk['SubtitleQty'] = "Qty";
                $ArrINFORisk['LoadDriver'] = 0;

                $pLinkRisk = "Include/reportCSV.php?report=DDPOControl&KeyVII=";
                //$pLink = base64_encode("DetailPOCCustomerRisk");
                //$D2x = base64_encode("CustomerDays");
                $GSQLRisk = "SELECT "
                        . "DATEDIFF('$dtAhora', Purchase_Order_Add_Date) AS PC_Name, SUM(QtyExpire) AS PC_Qty, "
                        . "CONCAT('$pLinkRisk', "
                        . "TO_BASE64(DATEDIFF('$dtAhora', Purchase_Order_Add_Date)), '&KeyIV=$cVendor&KeyII=$cIDOwner&KeyIII=$cCustomer&KeyVI=$cStatus&KeyV=$cRisk') AS PC_Link "
                        . "FROM POControl WHERE QtyExpire > '0' $Extra GROUP BY PC_Name ORDER BY PC_Name DESC";
                //echo $GSQL01;
                //Crea el Dashboard
                echo GraphDraw($GTypeRisk, $GTitleRisk, $GDivRisk, $ArrINFORisk, $GSQLRisk);
            }
            
            //echo $GSQLRisk;
            //********************************************************* Grafica Status
            $GTypeStatus = "PieChartLink";
            $GTitleStatus = "By Status Chart";
            $GDivStatus = "statusChart";
            $ArrINFOCustomer['SubtitleName'] = "Status";
            $ArrINFOCustomer['SubtitleQty'] = "Qty";
            $ArrINFOCustomer['LoadDriver'] = 0;
            
            if(empty($gStatus)){
                $pLinkStatus = "Dashboard.php?KeyI=" . base64_encode("DueDate") . "&KeyVI=";
                $GSQLStatus = "SELECT Status AS PC_Name, SUM(QtyExpire) AS PC_Qty, "
                    . "CONCAT('$pLinkStatus', "
                    . " TO_BASE64(Status), '&KeyIII=$cCustomer&KeyIV=$cVendor&KeyII=$cIDOwner&KeyV=$cRisk&KeyVII=$cDays') AS PC_Link FROM POControl "
                    . "WHERE QtyExpire > '0' $Extra GROUP BY PC_Name ORDER BY PC_Qty DESC";
            } else {
                $pLinkStatus = "Include/reportCSV.php?report=DDPOControl&KeyIII=$cCustomer";
                $GSQLStatus = "SELECT Status AS PC_Name, SUM(QtyExpire) AS PC_Qty, "
                    . "CONCAT('$pLinkStatus', "
                    . " '&KeyIV=$cVendor&KeyII=$cIDOwner&KeyV=$cRisk&KeyVI=$cStatus&KeyVII=$cDays') AS PC_Link FROM POControl "
                    . "WHERE QtyExpire > '0' $Extra GROUP BY PC_Name ORDER BY PC_Qty DESC";
            }
            
            //Crea el Dashboard
            echo GraphDraw($GTypeStatus, $GTitleStatus, $GDivStatus, $ArrINFOStatus, $GSQLStatus);
            
            
            //********************************************************* Tabla
            //Obtiene fecha del ultimo POD
            $SPOD = "SELECT dtAdded FROM PodData ORDER BY dtAdded DESC LIMIT 0, 1";
            $rPOD = $cnx->query($SPOD)->fetchArray();
            $dtPOD = $rPOD['dtAdded'];
            
            $FGraph = "";
            $FGraph = "<table width='100%'>";
            $FGraph .= "<tr>"
                    . "<td width='25%' align='left'><font class='Exs'></font></td>"
                    . "<td colspan='2' align='center'><font class='Ex'>$TitleDashboard</font></td>"
                    . "<td width='25%' align='right'><font class='Robsss'><b>Updated on:</b><br></font><font class='Robss'>$dtPOD</font></td>"
                    . "</tr>"
                    . "<tr>"
                    . "<td width='25%' align='left'><font class='Exs'></font></td>"
                    . "<td colspan='2' align='center'><font class='Robs'>$SubtitleDashboard</font><BR>"
                    . "<font class='Robss'>$SubtitleDashboardDetail</font></td>"
                    . "<td width='25%' align='right'><font class='Robsss'><a href='Include/reportCSV.php?report=DDPOControlDetail&KeyI=$cKeyI&KeyII=$cIDOwner&KeyIII=$cCustomer&KeyIV=$cVendor&KeyV=$cRisk&KeyVI=$cStatus&KeyVII=$cDays' target='_blank'><img src='Images/xls.svg' width='30'></a></td>"
                    . "</tr>"
                    . "<tr><td colspan='4' height='40'></td></tr>";
            $FGraph .= "<tr>"
                    . "<td colspan='2' width='50%' align='center'><font class='Exss'>$GTitleOwner</font><br><div id='$GDivOwner' style='height:400px;'></div></td>"
                    . "</td>"
                    . "<td colspan='2' width='50%' align='center'><font class='Exss'>$GTitleVendor</font><br><div id='$GDivVendor' style='height:400px;'></div></td>"
                    . "</tr>";
            $FGraph .= "<tr><td width='100%' colspan='4' align='center'><table width='100%'>";
            $FGraph .= "<tr>"
                    . "<td align='center' width='33%'><font class='Exss'>$GTitleCustomer</font><br><div id='$GDivCustomer' style='height:400px;'></div></td>"
                    . "</td>"
                    . "<td align='center' width='34%'><font class='Exss'>$GTitleRisk</font><br><div id='$GDivRisk' style='height:400px;'></div></td>"
                    . "<td align='center' width='33%'><font class='Exss'>$GTitleStatus</font><br><div id='$GDivStatus' style='height:400px;'></div></td>"
                    . "</tr>";
            $FGraph .= "</table></td></tr>";
            $FGraph .= "</table>";
            $FGraph .= "<script lang='javascript/text'>"
                    . "function resetear(){ document.location.reload(); }"
                    . "setTimeout(resetear, 50000);"
                    . "</script>";
            break;
        case "NoPromise":
            $cKey = base64_encode($gKeyI);
            //Dependes
            $gIDOwner = $gKeyII;
            $gCustomer = $gKeyIII;
            $gVendor = $gKeyIV;
            $gRisk = $gKeyV;
            $gStatus = $gKeyVI;
            $gDays = $gKeyVII;
            
            //*********************************************************Titulo
            if(!empty($gIDOwner)){
                $cIDOwner = base64_encode($gIDOwner);
                //Obtiene el nombre del owner
                $sInfoU = "SELECT * FROM Users WHERE IDUser = '$gIDOwner'";
                $rInfoU = $cnx->query($sInfoU)->fetchArray();
                $gOwner = $rInfoU['Name'] . " " . $rInfoU['FLastName'];
                $gTOwner = " Owner: <b>$gOwner</b> ";
                $Extra .= " AND IDOwner = '$gIDOwner' ";
            } else {
                $gTOwner = "";
            }
            
            if(!empty($gCustomer)){
                $cCustomer = base64_encode($gCustomer);
                $gTCustomer = " Customer: <b>$gCustomer</b> ";
                $Extra .= " AND Customer = '$gCustomer' ";
            } else {
                $gTCustomer = "";
            }
            
            if(!empty($gVendor)){
                $cVendor = base64_encode($gVendor);
                $gTVendor = " Vendor: <b>$gVendor</b> ";
                $Extra .= " AND Vendor_Name = '$gVendor' ";
            } else {
                $gTVendor = "";
            }
            
            if(!empty($gRisk)){
                $cRisk = base64_encode($gRisk);
                $gTRisk = " Risk: <font style='color:red;'><b>$gRisk</b></font> ";
                
                switch($gRisk){
                    case "LOW":
                        $Extra .= " AND DATEDIFF('$dtAhora', Purchase_Order_Add_Date) < '8'";
                        break;
                    case "MEDIUM":
                        $Extra .= " AND DATEDIFF('$dtAhora', Purchase_Order_Add_Date) BETWEEN '8' AND '15'";
                        break;
                    case "HIGH":
                        $Extra .= " AND DATEDIFF('$dtAhora', Purchase_Order_Add_Date) > '15'";
                        break;
                }
                
            } else {
                $gTRisk = "";
            }
            
            if(!empty($gStatus)){
                $Extra .= " AND Status = '$gStatus' ";
                $cStatus = base64_encode($gStatus);
                $gTStatus = " Status: <font style='color:blue;'><b>$gStatus</b></font> ";
            } else {
                $gTStatus = "";
            }
            
            //General Graphic
            $TitleDashboard = "Supply Chain PO Control Dashboard";
            $SubtitleDashboard = "<font style='color:orange;'>Unconfirm</font> Impact by Delivery";
            $SubtitleDashboardDetail = "$gTOwner $gTCustomer $gTVendor $gTStatus $gTRisk";
            //********************************************************* Grafica Owner
            $GTypeOwner = "PieChartLink";
            $GTitleOwner = "By Owner Chart";
            $GDivOwner = "ownerChart";
            $ArrINFOOwner['SubtitleName'] = "Owner";
            $ArrINFOOwner['SubtitleQty'] = "Qty";
            $ArrINFOOwner['LoadDriver'] = 1;
            if(empty($gIDOwner)){
                $pLinkOwner = "Dashboard.php?KeyI=" . base64_encode("NoPromise") . "&KeyII=";
                $GSQLOwner = "SELECT Owner AS PC_Name, SUM(QtyNPromise) AS PC_Qty, "
                    . "CONCAT('$pLinkOwner', "
                    . " TO_BASE64(IDOwner), '&KeyIII=$cCustomer&KeyIV=$cVendor&KeyV=$cRisk&KeyVI=$cStatus&KeyVII=$cDays') AS PC_Link FROM POControl "
                    . "WHERE QtyNPromise > '0' $Extra GROUP BY PC_Name ORDER BY PC_Qty DESC";
            
            } else {
                $pLinkOwner = "Include/reportCSV.php?report=UCPOControl&KeyII=$cIDOwner";
                $GSQLOwner = "SELECT Owner AS PC_Name, SUM(QtyNPromise) AS PC_Qty, "
                    . "CONCAT('$pLinkOwner', "
                    . " '&KeyIII=$cCustomer&KeyIV=$cVendor&KeyV=$cRisk&KeyVI=$cStatus&KeyVII=$cDays') AS PC_Link FROM POControl "
                    . "WHERE QtyNPromise > '0' $Extra GROUP BY PC_Name ORDER BY PC_Qty DESC";
            
            }
            
            //echo $GSQLOwner;
            
            //Crea el Dashboard
            echo GraphDraw($GTypeOwner, $GTitleOwner, $GDivOwner, $ArrINFOOwner, $GSQLOwner);
            
            
            //********************************************************* Grafica Vendor
            $GTypeVendor = "PieChartLink";
            $GTitleVendor = "By Vendor Chart";
            $GDivVendor = "vendorChart";
            $ArrINFOVendor['SubtitleName'] = "Vendor";
            $ArrINFOVendor['SubtitleQty'] = "Qty";
            $ArrINFOVendor['LoadDriver'] = 0;
            
            if(empty($gVendor)){
                $pLinkVendor = "Dashboard.php?KeyI=" . base64_encode("NoPromise") . "&KeyIV=";
                $GSQLVendor = "SELECT Vendor_Name AS PC_Name, SUM(QtyNPromise) AS PC_Qty, "
                    . "CONCAT('$pLinkVendor', "
                    . " TO_BASE64(Vendor_Name), '&KeyIII=$cCustomer&KeyII=$cIDOwner&KeyV=$cRisk&KeyVI=$cStatus&KeyVII=$cDays') AS PC_Link FROM POControl "
                    . "WHERE QtyNPromise > '0' $Extra GROUP BY PC_Name ORDER BY PC_Qty DESC";
            } else {
                $pLinkVendor = "Include/reportCSV.php?report=UCPOControl&KeyIV=$cVendor";
                $GSQLVendor = "SELECT Vendor_Name AS PC_Name, SUM(QtyNPromise) AS PC_Qty, "
                    . "CONCAT('$pLinkVendor', "
                    . " '&KeyIII=$cCustomer&KeyII=$cIDOwner&KeyV=$cRisk&KeyVI=$cStatus&KeyVII=$cDays') AS PC_Link FROM POControl "
                    . "WHERE QtyNPromise > '0' $Extra GROUP BY PC_Name ORDER BY PC_Qty DESC";
            }
            
            //Crea el Dashboard
            echo GraphDraw($GTypeVendor, $GTitleVendor, $GDivVendor, $ArrINFOVendor, $GSQLVendor);
            
            //********************************************************* Grafica Customer
            $GTypeCustomer = "PieChartLink";
            $GTitleCustomer = "By CustomerChart";
            $GDivCustomer = "customerChart";
            $ArrINFOCustomer['SubtitleName'] = "Customer";
            $ArrINFOCustomer['SubtitleQty'] = "Qty";
            $ArrINFOCustomer['LoadDriver'] = 0;
            
            if(empty($gCustomer)){
                $pLinkCustomer = "Dashboard.php?KeyI=" . base64_encode("NoPromise") . "&KeyIII=";
                $GSQLCustomer = "SELECT Customer AS PC_Name, SUM(QtyNPromise) AS PC_Qty, "
                    . "CONCAT('$pLinkCustomer', "
                    . " TO_BASE64(Customer), '&KeyIV=$cVendor&KeyII=$cIDOwner&KeyV=$cRisk&KeyVI=$cStatus&KeyVII=$cDays') AS PC_Link FROM POControl "
                    . "WHERE QtyNPromise > '0' $Extra GROUP BY PC_Name ORDER BY PC_Qty DESC";
            } else {
                $pLinkCustomer = "Include/reportCSV.php?report=UCPOControl&KeyIII=$cCustomer";
                $GSQLCustomer = "SELECT Customer AS PC_Name, SUM(QtyNPromise) AS PC_Qty, "
                    . "CONCAT('$pLinkCustomer', "
                    . " '&KeyIV=$cVendor&KeyII=$cIDOwner&KeyV=$cRisk&KeyVI=$cStatus&KeyVII=$cDays') AS PC_Link FROM POControl "
                    . "WHERE QtyNPromise > '0' $Extra GROUP BY PC_Name ORDER BY PC_Qty DESC";
            }
            
            //Crea el Dashboard
            echo GraphDraw($GTypeCustomer, $GTitleCustomer, $GDivCustomer, $ArrINFOCustomer, $GSQLCustomer);
            
            //********************************************************* Grafica Risk
            if(empty($gRisk)){
                $GTypeRisk = "PieChartLink";
                $GTitleRisk = "By Risk Chart";
                $GDivRisk = "LevelChart";
                $ArrINFORisk['SubtitleName'] = "Risk";
                $ArrINFORisk['SubtitleQty'] = "Qty";
                $ArrINFORisk['LoadDriver'] = 1;
                $ArrINFORisk['Colors'] = "colors:['red', 'orange', '#3366cc']";
                //Obtiene todos los campos
                //LOW
                $clevel = 0;
                $AvgLevels = "";
                while ($clevel < 3){
                    $clevel++;
                    $TLevel = 0;
                    $TQty = 0;
                    switch ($clevel){
                        case 1:
                            $qr = "> 15";
                            break;
                        case 2:
                            $qr = "BETWEEN '8' AND '15'";
                            break;
                        case 3:
                            $qr = "BETWEEN '0' AND '7'";
                            break;
                    }
                    $sAvg = "SELECT DATEDIFF('$dtAhora', Purchase_Order_Add_Date) AS NDays, SUM(QtyNPromise) AS QNP "
                        . "FROM POControl WHERE QtyNPromise > '0' $Extra "
                        . "AND DATEDIFF('$dtAhora', Purchase_Order_Add_Date) $qr "
                        . "GROUP BY NDays";
                    $nAvg = $cnx->query($sAvg)->numRows();
                    if($nAvg > 0){
                        $LAvg = $cnx->query($sAvg)->fetchAll();
                        foreach ($LAvg as &$rAvg) {
                            $gNDays = $rAvg['NDays'];
                            $gQNP = $rAvg['QNP'];
                            $TLevel += $gQNP;
                            $TQty += ($gNDays * $gQNP);
                        }
                        $Avg = round($TQty/$TLevel);
                        $AvgLevels .= "AVG:$Avg|";
                    } else {
                        //$AvgLevels .= "0|";
                    }

                }
                //echo $AvgLevels;

                $AvgLevels = substr($AvgLevels, 0, -1);
                $ArrINFORisk['ExtraData'] = $AvgLevels;

                $pLinkRisk = "Dashboard.php?KeyI=" . base64_encode("NoPromise") . "&KeyV=";
                $GSQLRisk = "SELECT "
                    . "CASE "
                    . "WHEN DATEDIFF('$dtAhora', Purchase_Order_Add_Date) < 8 THEN 'LOW RISK - Less than 8 days' "
                    . "WHEN DATEDIFF('$dtAhora', Purchase_Order_Add_Date) < 16 THEN 'MEDIUM RISK - 8 to 15 days' "
                    . "ELSE 'HIGH RISK - More than 16 days' "
                    . "END AS PC_Name, SUM(QtyNPromise) AS PC_Qty, "
                    . "CONCAT('$pLinkRisk', " 
                     . " TO_BASE64("
                    . "CASE "
                    . "WHEN DATEDIFF('$dtAhora', Purchase_Order_Add_Date) < 8 THEN 'LOW' "
                    . "WHEN DATEDIFF('$dtAhora', Purchase_Order_Add_Date) < 16 THEN 'MEDIUM' "
                    . "ELSE 'HIGH'"
                    . "END"
                    . "), '&KeyIV=$cVendor&KeyII=$cIDOwner&KeyIII=$cCustomer&KeyVI=$cStatus&KeyVII=$cDays') AS PC_Link "
                    . "FROM POControl WHERE QtyNPromise > '0' $Extra GROUP BY PC_Name "
                    . "ORDER BY FIELD(PC_Name, 'HIGH RISK - More than 16 days', 'MEDIUM RISK - 8 to 15 days', 'LOW RISK - Less than 8 days')";

                //Para el color
                $rCol = $cnx->query($GSQLRisk)->fetchAll();
                $cadC = "";
                $conc = 0;
                foreach ($rCol as &$Color) {
                    $conc++;
                    if($conc == 1){
                        $cadC .= "colors:[";
                    }
                    $NameC = $Color['PC_Name'];
                    switch ($NameC){
                        case "HIGH RISK - More than 16 days":
                            $cadC .= "'red', ";
                            break;
                        case "MEDIUM RISK - 8 to 15 days":
                            $cadC .= "'orange', ";
                            break;
                        case "LOW RISK - Less than 8 days":
                            $cadC .= "'#3366cc', ";
                            break;
                    }

                }

                if(!empty($cadC)){
                    $cadC = substr($cadC, 0, -2) . "]";
                }
                //echo $cadC;
                $ArrINFORisk['Colors'] = $cadC;

                //echo $GSQLRisk;
                //$GSQL01 = "SELECT Buyer AS PC_Name, COUNT(keyPPV) AS PC_Qty FROM PPVs GROUP BY Buyer ORDER BY PC_Qty DESC";
                //Crea el Dashboard
                echo GraphDraw($GTypeRisk, $GTitleRisk, $GDivRisk, $ArrINFORisk, $GSQLRisk);
            } else {
                switch($gRisk){
                    case "LOW":
                        $Extra .= " AND DATEDIFF('$dtAhora', Purchase_Order_Add_Date) < '8'";
                        break;
                    case "MEDIUM":
                        $Extra .= " AND DATEDIFF('$dtAhora', Purchase_Order_Add_Date) BETWEEN '8' AND '15'";
                        break;
                    case "HIGH":
                        $Extra .= " AND DATEDIFF('$dtAhora', Purchase_Order_Add_Date) > '15'";
                        break;
                }

                $GTypeRisk = "PieChartLink";
                $GTitleRisk = "By Qty of Days Chart";
                $GDivRisk = "levelChart";
                $ArrINFORisk['SubtitleName'] = "Days";
                $ArrINFORisk['Units'] = "Days";
                $ArrINFORisk['SubtitleQty'] = "Qty";
                $ArrINFORisk['LoadDriver'] = 0;

                $pLinkRisk = "Include/reportCSV.php?report=UCPOControl&KeyVII=";
                //$pLink = base64_encode("DetailPOCCustomerRisk");
                //$D2x = base64_encode("CustomerDays");
                $GSQLRisk = "SELECT "
                        . "DATEDIFF('$dtAhora', Purchase_Order_Add_Date) AS PC_Name, SUM(QtyNPromise) AS PC_Qty, "
                        . "CONCAT('$pLinkRisk', "
                        . "TO_BASE64(DATEDIFF('$dtAhora', Purchase_Order_Add_Date)), '&KeyIV=$cVendor&KeyII=$cIDOwner&KeyIII=$cCustomer&KeyVI=$cStatus&KeyV=$cRisk') AS PC_Link "
                        . "FROM POControl WHERE QtyNPromise > '0' $Extra GROUP BY PC_Name ORDER BY PC_Name DESC";
                //echo $GSQL01;
                //Crea el Dashboard
                echo GraphDraw($GTypeRisk, $GTitleRisk, $GDivRisk, $ArrINFORisk, $GSQLRisk);
            }
            
            //echo $GSQLRisk;
            //********************************************************* Grafica Status
            $GTypeStatus = "PieChartLink";
            $GTitleStatus = "By Status Chart";
            $GDivStatus = "statusChart";
            $ArrINFOCustomer['SubtitleName'] = "Status";
            $ArrINFOCustomer['SubtitleQty'] = "Qty";
            $ArrINFOCustomer['LoadDriver'] = 0;
            
            if(empty($gStatus)){
                $pLinkStatus = "Dashboard.php?KeyI=" . base64_encode("NoPromise") . "&KeyVI=";
                $GSQLStatus = "SELECT Status AS PC_Name, SUM(QtyNPromise) AS PC_Qty, "
                    . "CONCAT('$pLinkStatus', "
                    . " TO_BASE64(Status), '&KeyIII=$cCustomer&KeyIV=$cVendor&KeyII=$cIDOwner&KeyV=$cRisk&KeyVII=$cDays') AS PC_Link FROM POControl "
                    . "WHERE QtyNPromise > '0' $Extra GROUP BY PC_Name ORDER BY PC_Qty DESC";
            } else {
                $pLinkStatus = "Include/reportCSV.php?report=UCPOControl&KeyIII=$cCustomer";
                $GSQLStatus = "SELECT Status AS PC_Name, SUM(QtyNPromise) AS PC_Qty, "
                    . "CONCAT('$pLinkStatus', "
                    . " '&KeyIV=$cVendor&KeyII=$cIDOwner&KeyV=$cRisk&KeyVI=$cStatus&KeyVII=$cDays') AS PC_Link FROM POControl "
                    . "WHERE QtyNPromise > '0' $Extra GROUP BY PC_Name ORDER BY PC_Qty DESC";
            }
            
            //Crea el Dashboard
            echo GraphDraw($GTypeStatus, $GTitleStatus, $GDivStatus, $ArrINFOStatus, $GSQLStatus);
            
            
            //********************************************************* Tabla
            //Obtiene fecha del ultimo POD
            $SPOD = "SELECT dtAdded FROM PodData ORDER BY dtAdded DESC LIMIT 0, 1";
            $rPOD = $cnx->query($SPOD)->fetchArray();
            $dtPOD = $rPOD['dtAdded'];
            
            $FGraph = "";
            $FGraph = "<table width='100%'>";
            $FGraph .= "<tr>"
                    . "<td width='25%' align='left'><font class='Exs'></font></td>"
                    . "<td colspan='2' align='center'><font class='Ex'>$TitleDashboard</font></td>"
                    . "<td width='25%' align='right'><font class='Robsss'><b>Updated on:</b><br></font><font class='Robss'>$dtPOD</font></td>"
                    . "</tr>"
                    . "<tr>"
                    . "<td width='25%' align='left'><font class='Exs'></font></td>"
                    . "<td colspan='2' align='center'><font class='Robs'>$SubtitleDashboard</font><BR>"
                    . "<font class='Robss'>$SubtitleDashboardDetail</font></td>"
                    . "<td width='25%' align='right'><font class='Robsss'><a href='Include/reportCSV.php?report=UCPOControl&KeyI=$cKeyI&KeyII=$cIDOwner&KeyIII=$cCustomer&KeyIV=$cVendor&KeyV=$cRisk&KeyVI=$cStatus&KeyVII=$cDays' target='_blank'><img src='Images/xls.svg' width='30'></a></td>"
                    . "</tr>"
                    . "<tr><td colspan='4' height='40'></td></tr>";
            $FGraph .= "<tr>"
                    . "<td colspan='2' width='50%' align='center'><font class='Exss'>$GTitleOwner</font><br><div id='$GDivOwner' style='height:400px;'></div></td>"
                    . "</td>"
                    . "<td colspan='2' width='50%' align='center'><font class='Exss'>$GTitleVendor</font><br><div id='$GDivVendor' style='height:400px;'></div></td>"
                    . "</tr>";
            $FGraph .= "<tr><td width='100%' colspan='4' align='center'><table width='100%'>";
            $FGraph .= "<tr>"
                    . "<td align='center' width='33%'><font class='Exss'>$GTitleCustomer</font><br><div id='$GDivCustomer' style='height:400px;'></div></td>"
                    . "</td>"
                    . "<td align='center' width='34%'><font class='Exss'>$GTitleRisk</font><br><div id='$GDivRisk' style='height:400px;'></div></td>"
                    . "<td align='center' width='33%'><font class='Exss'>$GTitleStatus</font><br><div id='$GDivStatus' style='height:400px;'></div></td>"
                    . "</tr>";
            $FGraph .= "</table></td></tr>";
            $FGraph .= "</table>";
            $FGraph .= "<script lang='javascript/text'>"
                    . "function resetear(){ document.location.reload(); }"
                    . "setTimeout(resetear, 50000);"
                    . "</script>";
            break;
        case "DetailPOCCustomerRisk":
            //echo "$gKeyI - $gKeyII - $gKeyIII";
            $gCustomer = $gKeyII;
            $gRisk = $gKeyIII;
            $D4 = base64_encode($gCustomer);
            $D2 = base64_encode("byCustomerRisk");
            $D3 = base64_encode($gRisk);
            
            switch($gRisk){
                case "LOW":
                    $dateDiff = "DATEDIFF('$dtAhora', Purchase_Order_Add_Date) < '8'";
                    break;
                case "MEDIUM":
                    $dateDiff = "DATEDIFF('$dtAhora', Purchase_Order_Add_Date) BETWEEN '8' AND '15'";
                    break;
                case "HIGH":
                    $dateDiff = "DATEDIFF('$dtAhora', Purchase_Order_Add_Date) > '15'";
                    break;
            }
            
            //echo $sInfoU;
            $TitleDashboard = "Supply Chain PO Control Dashboard";
            $SubtitleDashboard = "Unconfirm Impact by Delivery ($gCustomer - <font style='color:red;'><b>$gKeyIII RISK</b></font>)";
            $GType = "PieChartLink";
            $GTitle = "By Qty of Days Chart";
            $GDiv = "levelChart";
            $ArrINFO['SubtitleName'] = "Days";
            $ArrINFO['Units'] = "Days";
            $ArrINFO['SubtitleQty'] = "Qty";
            $ArrINFO['LoadDriver'] = 1;
            $pLink = base64_encode("DetailPOCCustomerRisk");
            $D2x = base64_encode("CustomerDays");
            $GSQL01 = "SELECT "
                    . "DATEDIFF('$dtAhora', Purchase_Order_Add_Date) AS PC_Name, SUM(QtyNPromise) AS PC_Qty, "
                    . "CONCAT('Include/reportCSV.php?report=POControl"
                    . "&D1=$D1&D2=$D2x&D3=', TO_BASE64(DATEDIFF('$dtAhora', Purchase_Order_Add_Date)), '&D4=$D4') AS PC_Link "
                    . "FROM POControl WHERE Customer = '$gCustomer' AND QtyNPromise > '0' AND $dateDiff GROUP BY PC_Name ORDER BY PC_Name DESC";
            //echo $GSQL01;
            //Crea el Dashboard
            echo GraphDraw($GType, $GTitle, $GDiv, $ArrINFO, $GSQL01);
            
            $GType5 = "PieChart";
            $GTitle5 = "By CustomerChart";
            $GDiv5 = "customerChart";
            $ArrINFO5['SubtitleName'] = "Customer";
            $ArrINFO5['SubtitleQty'] = "Qty";
            $ArrINFO5['LoadDriver'] = 0;
            
            $GSQL015 = "SELECT Customer AS PC_Name, SUM(QtyNPromise) AS PC_Qty "
                    . "FROM POControl WHERE  Customer = '$gCustomer' AND QtyNPromise > '0' AND $dateDiff GROUP BY PC_Name ORDER BY PC_Qty DESC";
            //Crea el Dashboard
            echo GraphDraw($GType5, $GTitle5, $GDiv5, $ArrINFO5, $GSQL015);
            
            $GType2 = "PieChart";
            $GTitle2 = "By Vendor Chart";
            $GDiv2 = "vendorChart";
            $ArrINFO2['SubtitleName'] = "Vendor";
            $ArrINFO2['SubtitleQty'] = "Qty";
            $ArrINFO2['LoadDriver'] = 0;
            
            $GSQL012 = "SELECT Vendor_Name AS PC_Name, SUM(QtyNPromise) AS PC_Qty "
                    . "FROM POControl WHERE  Customer = '$gCustomer' AND QtyNPromise > '0' AND $dateDiff  GROUP BY PC_Name ORDER BY PC_Qty DESC";
            //Crea el Dashboard
            echo GraphDraw($GType2, $GTitle2, $GDiv2, $ArrINFO2, $GSQL012);
            
            $GType3 = "PieChart";
            $GTitle3 = "By Owner Chart";
            $GDiv3 = "ownerChart";
            $ArrINFO3['SubtitleName'] = "Owner";
            $ArrINFO3['SubtitleQty'] = "Qty";
            $ArrINFO3['LoadDriver'] = 0;
            
            $GSQL013 = "SELECT Owner AS PC_Name, SUM(QtyNPromise) AS PC_Qty "
                    . "FROM POControl WHERE Customer = '$gCustomer' AND QtyNPromise > '0' AND $dateDiff GROUP BY PC_Name ORDER BY PC_Qty DESC";
            //Crea el Dashboard
            echo GraphDraw($GType3, $GTitle3, $GDiv3, $ArrINFO3, $GSQL013);
            
            $GType4 = "PieChart";
            $GTitle4 = "By Status Chart";
            $GDiv4 = "statusChart";
            $ArrINFO4['SubtitleName'] = "Vendor";
            $ArrINFO4['SubtitleQty'] = "Qty";
            $ArrINFO4['LoadDriver'] = 0;
            
            $GSQL014 = "SELECT Status AS PC_Name, SUM(QtyNPromise) AS PC_Qty "
                    . "FROM POControl WHERE Customer = '$gCustomer' AND QtyNPromise > '0' AND $dateDiff GROUP BY PC_Name ORDER BY PC_Qty DESC";
            //Crea el Dashboard
            echo GraphDraw($GType4, $GTitle4, $GDiv4, $ArrINFO4, $GSQL014);
            
            $FGraph = "";
            $FGraph = "<table width='100%'>";
            $FGraph .= "<tr>"
                    . "<td width='25%' align='left'><font class='Exs'></font></td>"
                    . "<td colspan='2' align='center'><font class='Ex'>$TitleDashboard</font></td>"
                    . "<td width='25%' align='right'><font class='Robsss'><b>Updated on:</b><br></font><font class='Robss'>$dtAhora</font></td>"
                    . "</tr>"
                    . "<tr>"
                    . "<td width='25%' align='left'><font class='Exs'></font></td>"
                    . "<td colspan='2' align='center'><font class='Robs'>$SubtitleDashboard</font></td>"
                    . "<td width='25%' align='right'><font class='Robsss'><a href='Include/reportCSV.php?report=POControl&D1=$D1&D2=$D2&D3=$D3&D4=$D4' target='_blank'><img src='Images/xls.svg' width='30'></a></td>"
                    . "</tr>"
                    . "<tr><td colspan='4' height='40'></td></tr>";
            $FGraph .= "<tr>"
                    . "<td colspan='2' width='50%' align='center'><font class='Exss'>$GTitle3</font><br><div id='$GDiv3' style='height:400px;'></div></td>"
                    . "</td>"
                    . "<td colspan='2' width='50%' align='center'><font class='Exss'>$GTitle2</font><br><div id='$GDiv2' style='height:400px;'></div></td>"
                    . "</tr>";
            $FGraph .= "<tr><td width='100%' colspan='4' align='center'><table width='100%'>";
            $FGraph .= "<tr>"
                    . "<td align='center' width='33%'><font class='Exss'>$GTitle5</font><br><div id='$GDiv5' style='height:400px;'></div></td>"
                    . "</td>"
                    . "<td align='center' width='34%'><font class='Exss'>$GTitle</font><br><div id='$GDiv' style='height:400px;'></div></td>"
                    . "<td align='center' width='33%'><font class='Exss'>$GTitle4</font><br><div id='$GDiv4' style='height:400px;'></div></td>"
                    . "</tr>";
            $FGraph .= "</table></td></tr>";
            $FGraph .= "</table>";
            $FGraph .= "<script lang='javascript/text'>"
                    . "function resetear(){ document.location.reload(); }"
                    . "setTimeout(resetear, 50000);"
                    . "</script>";
            
            break;
        case "DetailPOCCustomer":
            //echo "$gKeyI - $gKeyII - $gKeyIII";
            //echo "$gKeyI - $gKeyII - $gKeyIII";
            $gCustomer = $gKeyII;
            $D3 = base64_encode($gCustomer);
            $D2 = base64_encode("byCustomer");
            //echo $sInfoU;
            $TitleDashboard = "Supply Chain PO Control Dashboard";
            $SubtitleDashboard = "Unconfirm Impact by Delivery ($gCustomer)";
            $GType = "PieChartLink";
            $GTitle = "By Risk Chart";
            $GDiv = "riskChart";
            $ArrINFO['SubtitleName'] = "Days";
            $ArrINFO['SubtitleQty'] = "Qty";
            $ArrINFO['LoadDriver'] = 1;
            $ArrINFO['Colors'] = "colors:['red', 'orange', '#3366cc']";
            $ArrINFO['ExtraL'] = "AVG";
            $clevel = 0;
            $AvgLevels = "";
            
            while ($clevel < 3){
                $clevel++;
                $TLevel = 0;
                $TQty = 0;
                switch ($clevel){
                    case 1:
                        $qr = "> 15";
                        break;
                    case 2:
                        $qr = "BETWEEN '8' AND '15'";
                        break;
                    case 3:
                        $qr = "BETWEEN '0' AND '7'";
                        break;
                }
                
                $sAvg = "SELECT DATEDIFF('$dtAhora', Purchase_Order_Add_Date) AS NDays, SUM(QtyNPromise) AS QNP "
                    . "FROM POControl WHERE QtyNPromise > '0' AND Customer = '$gCustomer' "
                    . "AND DATEDIFF('$dtAhora', Purchase_Order_Add_Date) $qr "
                    . "GROUP BY NDays";
                
                $nAvg = $cnx->query($sAvg)->numRows();
                if($nAvg > 0){
                    $LAvg = $cnx->query($sAvg)->fetchAll();
                    foreach ($LAvg as &$rAvg) {
                        $gNDays = $rAvg['NDays'];
                        $gQNP = $rAvg['QNP'];
                        $TLevel += $gQNP;
                        $TQty += ($gNDays * $gQNP);
                    }
                    $Avg = round($TQty/$TLevel);
                    $AvgLevels .= "$Avg|";
                } else {
                    //$AvgLevels .= "0|";
                }
                
            }
            $AvgLevels = substr($AvgLevels, 0, -1);
            $ArrINFO['ExtraData'] = $AvgLevels;
            $pLink = base64_encode("DetailPOCCustomerRisk");
            $GSQL01 = "SELECT "
                    . "CASE "
                    . "WHEN DATEDIFF('$dtAhora', Purchase_Order_Add_Date) < 8 THEN 'LOW RISK - Less than 8 days' "
                    . "WHEN DATEDIFF('$dtAhora', Purchase_Order_Add_Date) < 16 THEN 'MEDIUM RISK - 8 - 15 days' "
                    . "ELSE 'HIGH RISK - More than 16 days'"
                    . "END AS PC_Name, SUM(QtyNPromise) AS PC_Qty, "
                    . "CONCAT('Dashboard.php?KeyI="
                    . "$pLink" . "&KeyII=', TO_BASE64(Customer), '&KeyIII=', TO_BASE64("
                    . "CASE "
                    . "WHEN DATEDIFF('$dtAhora', Purchase_Order_Add_Date) < 8 THEN 'LOW' "
                    . "WHEN DATEDIFF('$dtAhora', Purchase_Order_Add_Date) < 16 THEN 'MEDIUM' "
                    . "ELSE 'HIGH'"
                    . "END"
                    . ")) AS PC_Link "
                    . "FROM POControl WHERE Customer LIKE '$gCustomer' AND QtyNPromise > '0' GROUP BY PC_Name "
                    . "ORDER BY FIELD(PC_Name, 'HIGH RISK - More than 16 days ', 'MEDIUM RISK - 8 - 15 days', 'LOW RISK - Less than 8 days')";
            //Crea el Dashboard
            //echo $GSQL01;
            echo GraphDraw($GType, $GTitle, $GDiv, $ArrINFO, $GSQL01);
            
            $GType2 = "PieChart";
            $GTitle2 = "By Vendor Chart";
            $GDiv2 = "vendorChart";
            $ArrINFO2['SubtitleName'] = "Vendor";
            $ArrINFO2['SubtitleQty'] = "Qty";
            $ArrINFO2['LoadDriver'] = 0;
            
            $GSQL012 = "SELECT Vendor_Name AS PC_Name, SUM(QtyNPromise) AS PC_Qty FROM "
                    . "POControl WHERE Customer = '$gCustomer' AND QtyNPromise > '0' GROUP BY PC_Name ORDER BY PC_Qty DESC";
            //Crea el Dashboard
            echo GraphDraw($GType2, $GTitle2, $GDiv2, $ArrINFO2, $GSQL012);
            
            $GType5 = "PieChart";
            $GTitle5 = "By CustomerChart";
            $GDiv5 = "customerChart";
            $ArrINFO5['SubtitleName'] = "Customer";
            $ArrINFO5['SubtitleQty'] = "Qty";
            $ArrINFO5['LoadDriver'] = 0;
            
            $GSQL015 = "SELECT Customer AS PC_Name, SUM(QtyNPromise) AS PC_Qty "
                    . "FROM POControl WHERE  Customer = '$gCustomer' AND QtyNPromise > '0' GROUP BY PC_Name ORDER BY PC_Qty DESC";
            //Crea el Dashboard
            echo GraphDraw($GType5, $GTitle5, $GDiv5, $ArrINFO5, $GSQL015);
            
            $GType3 = "PieChart";
            $GTitle3 = "By Owner Chart";
            $GDiv3 = "ownerChart";
            $ArrINFO3['SubtitleName'] = "Owner";
            $ArrINFO3['SubtitleQty'] = "Qty";
            $ArrINFO3['LoadDriver'] = 0;
            
            $GSQL013 = "SELECT Owner AS PC_Name, SUM(QtyNPromise) AS PC_Qty "
                    . "FROM POControl WHERE Customer = '$gCustomer' AND QtyNPromise > '0' GROUP BY PC_Name ORDER BY PC_Qty DESC";
            //Crea el Dashboard
            echo GraphDraw($GType3, $GTitle3, $GDiv3, $ArrINFO3, $GSQL013);
            
            $GType4 = "PieChart";
            $GTitle4 = "By Status Chart";
            $GDiv4 = "statusChart";
            $ArrINFO4['SubtitleName'] = "Status";
            $ArrINFO4['SubtitleQty'] = "Qty";
            $ArrINFO4['LoadDriver'] = 0;
            
            $GSQL014 = "SELECT Status AS PC_Name, SUM(QtyNPromise) AS PC_Qty "
                    . "FROM POControl WHERE Customer = '$gCustomer' AND QtyNPromise > '0' GROUP BY PC_Name ORDER BY PC_Qty DESC";
            //Crea el Dashboard
            echo GraphDraw($GType4, $GTitle4, $GDiv4, $ArrINFO4, $GSQL014);
            
            $FGraph = "";
            $FGraph = "<table width='100%'>";
            $FGraph .= "<tr>"
                    . "<td width='25%' align='left'><font class='Exs'></font></td>"
                    . "<td colspan='2' align='center'><font class='Ex'>$TitleDashboard</font></td>"
                    . "<td width='25%' align='right'><font class='Robsss'><b>Updated on:</b><br></font><font class='Robss'>$dtAhora</font></td>"
                    . "</tr>"
                    . "<tr>"
                    . "<td width='25%' align='left'><font class='Exs'></font></td>"
                    . "<td colspan='2' align='center'><font class='Robs'>$SubtitleDashboard</font></td>"
                    . "<td width='25%' align='right'><font class='Robsss'><a href='Include/reportCSV.php?report=POControl&D1=$D1&D2=$D2&D3=$D3' target='_blank'><img src='Images/xls.svg' width='30'></a></td>"
                    . "</tr>"
                    . "<tr><td colspan='4' height='40'></td></tr>";
            $FGraph .= "<tr>"
                    . "<td colspan='2' width='50%' align='center'><font class='Exss'>$GTitle3</font><br><div id='$GDiv3' style='height:400px;'></div></td>"
                    . "</td>"
                    . "<td colspan='2' width='50%' align='center'><font class='Exss'>$GTitle2</font><br><div id='$GDiv2' style='height:400px;'></div></td>"
                    . "</tr>";
            $FGraph .= "<tr><td width='100%' colspan='4' align='center'><table width='100%'>";
            $FGraph .= "<tr>"
                    . "<td align='center' width='33%'><font class='Exss'>$GTitle5</font><br><div id='$GDiv5' style='height:400px;'></div></td>"
                    . "</td>"
                    . "<td align='center' width='34%'><font class='Exss'>$GTitle</font><br><div id='$GDiv' style='height:400px;'></div></td>"
                    . "<td align='center' width='33%'><font class='Exss'>$GTitle4</font><br><div id='$GDiv4' style='height:400px;'></div></td>"
                    . "</tr>";
            $FGraph .= "</table></td></tr>";
            $FGraph .= "</table>";
            $FGraph .= "<script lang='javascript/text'>"
                    . "function resetear(){ document.location.reload(); }"
                    . "setTimeout(resetear, 50000);"
                    . "</script>";
            break;
        case "DetailPOCVendorRisk":
            //echo "$gKeyI - $gKeyII - $gKeyIII";
            $gVendor = $gKeyII;
            $gRisk = $gKeyIII;
            $D4 = base64_encode($gVendor);
            $D2 = base64_encode("byVendorRisk");
            $D3 = base64_encode($gRisk);
            
            switch($gRisk){
                case "LOW":
                    $dateDiff = "DATEDIFF('$dtAhora', Purchase_Order_Add_Date) < '8'";
                    break;
                case "MEDIUM":
                    $dateDiff = "DATEDIFF('$dtAhora', Purchase_Order_Add_Date) BETWEEN '8' AND '15'";
                    break;
                case "HIGH":
                    $dateDiff = "DATEDIFF('$dtAhora', Purchase_Order_Add_Date) > '15'";
                    break;
            }
            
            //echo $sInfoU;
            $TitleDashboard = "Supply Chain PO Control Dashboard";
            $SubtitleDashboard = "Unconfirm Impact by Delivery ($gVendor - <font style='color:red;'><b>$gKeyIII RISK</b></font>)";
            $GType = "PieChartLink";
            $GTitle = "By Qty of Days Chart";
            $GDiv = "levelChart";
            $ArrINFO['SubtitleName'] = "Days";
            $ArrINFO['Units'] = "Days";
            $ArrINFO['SubtitleQty'] = "Qty";
            $ArrINFO['LoadDriver'] = 1;
            $pLink = base64_encode("DetailPOCOwnerRisk");
            $D2x = base64_encode("VendorDays");
            $GSQL01 = "SELECT "
                    . "DATEDIFF('$dtAhora', Purchase_Order_Add_Date) AS PC_Name, SUM(QtyNPromise) AS PC_Qty, "
                    . "CONCAT('Include/reportCSV.php?report=POControl"
                    . "&D1=$D1&D2=$D2x&D3=', TO_BASE64(DATEDIFF('$dtAhora', Purchase_Order_Add_Date)), '&D4=$D4') AS PC_Link "
                    . "FROM POControl WHERE Vendor_Name = '$gVendor' AND QtyNPromise > '0' AND $dateDiff GROUP BY PC_Name ORDER BY PC_Name DESC";
            //echo $GSQL01;
            //Crea el Dashboard
            echo GraphDraw($GType, $GTitle, $GDiv, $ArrINFO, $GSQL01);
            
            $GType5 = "PieChart";
            $GTitle5 = "By Vendor Chart";
            $GDiv5 = "vendorChart";
            $ArrINFO5['SubtitleName'] = "Vendor";
            $ArrINFO5['SubtitleQty'] = "Qty";
            $ArrINFO5['LoadDriver'] = 0;
            
            $GSQL015 = "SELECT Vendor_Name AS PC_Name, SUM(QtyNPromise) AS PC_Qty FROM POControl WHERE QtyNPromise > '0' AND Vendor_Name LIKE '$gVendor' AND $dateDiff GROUP BY PC_Name ORDER BY PC_Qty DESC";
            //Crea el Dashboard
            echo GraphDraw($GType5, $GTitle5, $GDiv5, $ArrINFO5, $GSQL015);
            
            $GType2 = "PieChart";
            $GTitle2 = "By CustomerChart";
            $GDiv2 = "customerChart";
            $ArrINFO2['SubtitleName'] = "Customer";
            $ArrINFO2['SubtitleQty'] = "Qty";
            $ArrINFO2['LoadDriver'] = 0;
            
            $GSQL012 = "SELECT Customer AS PC_Name, SUM(QtyNPromise) AS PC_Qty "
                    . "FROM POControl WHERE  Vendor_Name = '$gVendor' AND QtyNPromise > '0' AND $dateDiff  GROUP BY PC_Name ORDER BY PC_Qty DESC";
            //Crea el Dashboard
            echo GraphDraw($GType2, $GTitle2, $GDiv2, $ArrINFO2, $GSQL012);
            
            $GType3 = "PieChart";
            $GTitle3 = "By Owner Chart";
            $GDiv3 = "ownerChart";
            $ArrINFO3['SubtitleName'] = "Owner";
            $ArrINFO3['SubtitleQty'] = "Qty";
            $ArrINFO3['LoadDriver'] = 0;
            
            $GSQL013 = "SELECT Owner AS PC_Name, SUM(QtyNPromise) AS PC_Qty "
                    . "FROM POControl WHERE Vendor_Name = '$gVendor' AND QtyNPromise > '0' AND $dateDiff GROUP BY PC_Name ORDER BY PC_Qty DESC";
            //Crea el Dashboard
            echo GraphDraw($GType3, $GTitle3, $GDiv3, $ArrINFO3, $GSQL013);
            
            $GType4 = "PieChart";
            $GTitle4 = "By Status Chart";
            $GDiv4 = "statusChart";
            $ArrINFO4['SubtitleName'] = "Vendor";
            $ArrINFO4['SubtitleQty'] = "Qty";
            $ArrINFO4['LoadDriver'] = 0;
            
            $GSQL014 = "SELECT Status AS PC_Name, SUM(QtyNPromise) AS PC_Qty "
                    . "FROM POControl WHERE Vendor_Name = '$gVendor' AND QtyNPromise > '0' AND $dateDiff GROUP BY PC_Name ORDER BY PC_Qty DESC";
            //Crea el Dashboard
            echo GraphDraw($GType4, $GTitle4, $GDiv4, $ArrINFO4, $GSQL014);
            
            $FGraph = "";
            $FGraph = "<table width='100%'>";
            $FGraph .= "<tr>"
                    . "<td width='25%' align='left'><font class='Exs'></font></td>"
                    . "<td colspan='2' align='center'><font class='Ex'>$TitleDashboard</font></td>"
                    . "<td width='25%' align='right'><font class='Robsss'><b>Updated on:</b><br></font><font class='Robss'>$dtAhora</font></td>"
                    . "</tr>"
                    . "<tr>"
                    . "<td width='25%' align='left'><font class='Exs'></font></td>"
                    . "<td colspan='2' align='center'><font class='Robs'>$SubtitleDashboard</font></td>"
                    . "<td width='25%' align='right'><font class='Robsss'><a href='Include/reportCSV.php?report=POControl&D1=$D1&D2=$D2&D3=$D3&D4=$D4' target='_blank'><img src='Images/xls.svg' width='30'></a></td>"
                    . "</tr>"
                    . "<tr><td colspan='4' height='40'></td></tr>";
            $FGraph .= "<tr>"
                    . "<td colspan='2' width='50%' align='center'><font class='Exss'>$GTitle3</font><br><div id='$GDiv3' style='height:400px;'></div></td>"
                    . "</td>"
                    . "<td colspan='2' width='50%' align='center'><font class='Exss'>$GTitle5</font><br><div id='$GDiv5' style='height:400px;'></div></td>"
                    . "</tr>";
            $FGraph .= "<tr><td width='100%' colspan='4' align='center'><table width='100%'>";
            $FGraph .= "<tr>"
                    . "<td align='center' width='33%'><font class='Exss'>$GTitle2</font><br><div id='$GDiv2' style='height:400px;'></div></td>"
                    . "</td>"
                    . "<td align='center' width='34%'><font class='Exss'>$GTitle</font><br><div id='$GDiv' style='height:400px;'></div></td>"
                    . "<td align='center' width='33%'><font class='Exss'>$GTitle4</font><br><div id='$GDiv4' style='height:400px;'></div></td>"
                    . "</tr>";
            $FGraph .= "</table></td></tr>";
            $FGraph .= "</table>";
            $FGraph .= "<script lang='javascript/text'>"
                    . "function resetear(){ document.location.reload(); }"
                    . "setTimeout(resetear, 50000);"
                    . "</script>";
            
            break;
        case "DetailPOCVendor":
            //echo "$gKeyI - $gKeyII - $gKeyIII";
            //echo "$gKeyI - $gKeyII - $gKeyIII";
            $gVendor = $gKeyII;
            $D3 = base64_encode($gVendor);
            $D2 = base64_encode("byVendor");
            //echo $sInfoU;
            $TitleDashboard = "Supply Chain PO Control Dashboard";
            $SubtitleDashboard = "Unconfirm Impact by Delivery ($gVendor)";
            $GType5 = "PieChart";
            $GTitle5 = "By Vendor Chart";
            $GDiv5 = "vendorChart";
            $ArrINFO5['SubtitleName'] = "Vendor";
            $ArrINFO5['SubtitleQty'] = "Qty";
            $ArrINFO5['LoadDriver'] = 1;
            
            $GSQL015 = "SELECT Vendor_Name AS PC_Name, SUM(QtyNPromise) AS PC_Qty FROM POControl WHERE QtyNPromise > '0' AND Vendor_Name LIKE '$gVendor' GROUP BY PC_Name ORDER BY PC_Qty DESC";
            //Crea el Dashboard
            echo GraphDraw($GType5, $GTitle5, $GDiv5, $ArrINFO5, $GSQL015);
            //echo $GSQL015;
            
            $GType = "PieChartLink";
            $GTitle = "By Qty of Days Chart";
            $GDiv = "DaysChart";
            $ArrINFO['SubtitleName'] = "Days";
            $ArrINFO['SubtitleQty'] = "Qty";
            $ArrINFO['LoadDriver'] = 0;
            $ArrINFO['Colors'] = "colors:['red', 'orange', '#3366cc']";
            $ArrINFO['ExtraL'] = "AVG";
            $clevel = 0;
            $AvgLevels = "";
            
            while ($clevel < 3){
                $clevel++;
                $TLevel = 0;
                $TQty = 0;
                switch ($clevel){
                    case 1:
                        $qr = "> 15";
                        break;
                    case 2:
                        $qr = "BETWEEN '8' AND '15'";
                        break;
                    case 3:
                        $qr = "BETWEEN '0' AND '7'";
                        break;
                }
                
                $sAvg = "SELECT DATEDIFF('$dtAhora', Purchase_Order_Add_Date) AS NDays, SUM(QtyNPromise) AS QNP "
                    . "FROM POControl WHERE QtyNPromise > '0' AND Vendor_Name = '$gVendor' "
                    . "AND DATEDIFF('$dtAhora', Purchase_Order_Add_Date) $qr "
                    . "GROUP BY NDays";
                $nAvg = $cnx->query($sAvg)->numRows();
                if($nAvg > 0){
                    $LAvg = $cnx->query($sAvg)->fetchAll();
                    foreach ($LAvg as &$rAvg) {
                        $gNDays = $rAvg['NDays'];
                        $gQNP = $rAvg['QNP'];
                        $TLevel += $gQNP;
                        $TQty += ($gNDays * $gQNP);
                    }
                    $Avg = round($TQty/$TLevel);
                    $AvgLevels .= "$Avg|";
                } else {
                    //$AvgLevels .= "0|";
                }
                
            }
            $AvgLevels = substr($AvgLevels, 0, -1);
            $ArrINFO['ExtraData'] = $AvgLevels;
            $pLink = base64_encode("DetailPOCVendorRisk");
            $GSQL01 = "SELECT "
                    . "CASE "
                    . "WHEN DATEDIFF('$dtAhora', Purchase_Order_Add_Date) < 8 THEN 'LOW RISK - Less than 8 days' "
                    . "WHEN DATEDIFF('$dtAhora', Purchase_Order_Add_Date) < 16 THEN 'MEDIUM RISK - 8 - 15 days' "
                    . "ELSE 'HIGH RISK - More than 16 days'"
                    . "END AS PC_Name, SUM(QtyNPromise) AS PC_Qty, "
                    . "CONCAT('Dashboard.php?KeyI="
                    . "$pLink" . "&KeyII=', TO_BASE64(Vendor_Name), '&KeyIII=', TO_BASE64("
                    . "CASE "
                    . "WHEN DATEDIFF('$dtAhora', Purchase_Order_Add_Date) < 8 THEN 'LOW' "
                    . "WHEN DATEDIFF('$dtAhora', Purchase_Order_Add_Date) < 16 THEN 'MEDIUM' "
                    . "ELSE 'HIGH'"
                    . "END"
                    . ")) AS PC_Link "
                    . "FROM POControl WHERE Vendor_Name LIKE '$gVendor' AND QtyNPromise > '0' GROUP BY PC_Name "
                    . "ORDER BY FIELD(PC_Name, 'HIGH RISK - More than 16 days ', 'MEDIUM RISK - 8 - 15 days', 'LOW RISK - Less than 8 days')";
            //Crea el Dashboard
            //echo $GSQL01;
            echo GraphDraw($GType, $GTitle, $GDiv, $ArrINFO, $GSQL01);
            
            $GType2 = "PieChart";
            $GTitle2 = "By CustomerChart";
            $GDiv2 = "customerChart";
            $ArrINFO2['SubtitleName'] = "Customer";
            $ArrINFO2['SubtitleQty'] = "Qty";
            $ArrINFO2['LoadDriver'] = 0;
            
            $GSQL012 = "SELECT Customer AS PC_Name, SUM(QtyNPromise) AS PC_Qty FROM "
                    . "POControl WHERE Vendor_Name = '$gVendor' AND QtyNPromise > '0' GROUP BY PC_Name ORDER BY PC_Qty DESC";
            //Crea el Dashboard
            echo GraphDraw($GType2, $GTitle2, $GDiv2, $ArrINFO2, $GSQL012);
            
            $GType3 = "PieChart";
            $GTitle3 = "By Owner Chart";
            $GDiv3 = "ownerChart";
            $ArrINFO3['SubtitleName'] = "Owner";
            $ArrINFO3['SubtitleQty'] = "Qty";
            $ArrINFO3['LoadDriver'] = 0;
            
            $GSQL013 = "SELECT Owner AS PC_Name, SUM(QtyNPromise) AS PC_Qty "
                    . "FROM POControl WHERE Vendor_Name = '$gVendor' AND QtyNPromise > '0' GROUP BY PC_Name ORDER BY PC_Qty DESC";
            //Crea el Dashboard
            echo GraphDraw($GType3, $GTitle3, $GDiv3, $ArrINFO3, $GSQL013);
            
            $GType4 = "PieChart";
            $GTitle4 = "By Status Chart";
            $GDiv4 = "statusChart";
            $ArrINFO4['SubtitleName'] = "Vendor";
            $ArrINFO4['SubtitleQty'] = "Qty";
            $ArrINFO4['LoadDriver'] = 0;
            
            $GSQL014 = "SELECT Status AS PC_Name, SUM(QtyNPromise) AS PC_Qty "
                    . "FROM POControl WHERE Vendor_Name = '$gVendor' AND QtyNPromise > '0' GROUP BY PC_Name ORDER BY PC_Qty DESC";
            //Crea el Dashboard
            echo GraphDraw($GType4, $GTitle4, $GDiv4, $ArrINFO4, $GSQL014);
            
            $FGraph = "";
            $FGraph = "<table width='100%'>";
            $FGraph .= "<tr>"
                    . "<td width='25%' align='left'><font class='Exs'></font></td>"
                    . "<td colspan='2' align='center'><font class='Ex'>$TitleDashboard</font></td>"
                    . "<td width='25%' align='right'><font class='Robsss'><b>Updated on:</b><br></font><font class='Robss'>$dtAhora</font></td>"
                    . "</tr>"
                    . "<tr>"
                    . "<td width='25%' align='left'><font class='Exs'></font></td>"
                    . "<td colspan='2' align='center'><font class='Robs'>$SubtitleDashboard</font></td>"
                    . "<td width='25%' align='right'><font class='Robsss'><a href='Include/reportCSV.php?report=POControl&D1=$D1&D2=$D2&D3=$D3' target='_blank'><img src='Images/xls.svg' width='30'></a></td>"
                    . "</tr>"
                    . "<tr><td colspan='4' height='40'></td></tr>";
            $FGraph .= "<tr>"
                    . "<td colspan='2' width='50%' align='center'><font class='Exss'>$GTitle3</font><br><div id='$GDiv3' style='height:400px;'></div></td>"
                    . "</td>"
                    . "<td colspan='2' width='50%' align='center'><font class='Exss'>$GTitle5</font><br><div id='$GDiv5' style='height:400px;'></div></td>"
                    . "</tr>";
            $FGraph .= "<tr><td width='100%' colspan='4' align='center'><table width='100%'>";
            $FGraph .= "<tr>"
                    . "<td align='center' width='33%'><font class='Exss'>$GTitle2</font><br><div id='$GDiv2' style='height:400px;'></div></td>"
                    . "</td>"
                    . "<td align='center' width='34%'><font class='Exss'>$GTitle</font><br><div id='$GDiv' style='height:400px;'></div></td>"
                    . "<td align='center' width='33%'><font class='Exss'>$GTitle4</font><br><div id='$GDiv4' style='height:400px;'></div></td>"
                    . "</tr>";
            $FGraph .= "</table></td></tr>";
            $FGraph .= "</table>";
            $FGraph .= "<script lang='javascript/text'>"
                    . "function resetear(){ document.location.reload(); }"
                    . "setTimeout(resetear, 50000);"
                    . "</script>";
            break;
        case "DetailPOCRisk":
            //echo "$gKeyI - $gKeyII - $gKeyIII";
            $gIDOwner = $gKeyII;
            $gRisk = $gKeyIII;
            $D1 = "";
            $D2 = base64_encode("byRisk");
            $D3 = base64_encode($gRisk);
            
            
            switch($gRisk){
                case "LOW":
                    $dateDiff = "DATEDIFF('$dtAhora', Purchase_Order_Add_Date) < '8'";
                    break;
                case "MEDIUM":
                    $dateDiff = "DATEDIFF('$dtAhora', Purchase_Order_Add_Date) BETWEEN '8' AND '15'";
                    break;
                case "HIGH":
                    $dateDiff = "DATEDIFF('$dtAhora', Purchase_Order_Add_Date) > '15'";
                    break;
            }
            
            $TitleDashboard = "Supply Chain PO Control Dashboard";
            $SubtitleDashboard = "Unconfirm Impact by Delivery (All - <font style='color:red;'><b>$gKeyIII RISK</b></font>)";
            $GType5 = "PieChart";
            $GTitle5 = "By Owner Chart";
            $GDiv5 = "ownerChart";
            $ArrINFO5['SubtitleName'] = "Owner";
            $ArrINFO5['SubtitleQty'] = "Qty";
            $ArrINFO5['LoadDriver'] = 1;
            $pLink5 = base64_encode("DetailPOCOwner");
            $GSQL015 = "SELECT Owner AS PC_Name, SUM(QtyNPromise) AS PC_Qty, "
                    . "CONCAT('Dashboard.php?KeyI="
                    . "$pLink4" . "&KeyII=', TO_BASE64(IDOwner), '&KeyIII=') AS PC_Link FROM POControl WHERE QtyNPromise > '0' AND $dateDiff GROUP BY PC_Name ORDER BY PC_Qty DESC";
            //$GSQL01 = "SELECT Buyer AS PC_Name, COUNT(keyPPV) AS PC_Qty FROM PPVs GROUP BY Buyer ORDER BY PC_Qty DESC";
            //Crea el Dashboard
            echo GraphDraw($GType5, $GTitle5, $GDiv5, $ArrINFO5, $GSQL015);
            
            $GType = "PieChartLink";
            $GTitle = "By Qty of Days Chart";
            $GDiv = "DaysChart";
            $ArrINFO['SubtitleName'] = "Days";
            $ArrINFO['Units'] = "Days";
            $ArrINFO['SubtitleQty'] = "Qty";
            $ArrINFO['LoadDriver'] = 0;
            $D2x = base64_encode("Days");
            $GSQL01 = "SELECT "
                    . "DATEDIFF('$dtAhora', Purchase_Order_Add_Date) AS PC_Name, SUM(QtyNPromise) AS PC_Qty, "
                    . "CONCAT('Include/reportCSV.php?report=POControl"
                    . "&D1=$D1&D2=$D2x&D3=', TO_BASE64(DATEDIFF('$dtAhora', Purchase_Order_Add_Date))) AS PC_Link "
                    . "FROM POControl WHERE QtyNPromise > '0' AND $dateDiff GROUP BY PC_Name ORDER BY PC_Name DESC";
            //echo $GSQL01;
            //Crea el Dashboard
            echo GraphDraw($GType, $GTitle, $GDiv, $ArrINFO, $GSQL01);
            
            $GType2 = "PieChart";
            $GTitle2 = "By CustomerChart";
            $GDiv2 = "customerChart";
            $ArrINFO2['SubtitleName'] = "Customer";
            $ArrINFO2['SubtitleQty'] = "Qty";
            $ArrINFO2['LoadDriver'] = 0;
            
            $GSQL012 = "SELECT Class_Code AS PC_Name, SUM(QtyNPromise) AS PC_Qty FROM POControl WHERE QtyNPromise > '0' AND $dateDiff  GROUP BY PC_Name ORDER BY PC_Qty DESC";
            //Crea el Dashboard
            echo GraphDraw($GType2, $GTitle2, $GDiv2, $ArrINFO2, $GSQL012);
            
            $GType3 = "PieChart";
            $GTitle3 = "By Vendor Chart";
            $GDiv3 = "vendorChart";
            $ArrINFO3['SubtitleName'] = "Vendor";
            $ArrINFO3['SubtitleQty'] = "Qty";
            $ArrINFO3['LoadDriver'] = 0;
            
            $GSQL013 = "SELECT Vendor_Name AS PC_Name, SUM(QtyNPromise) AS PC_Qty FROM POControl WHERE QtyNPromise > '0' AND $dateDiff GROUP BY PC_Name ORDER BY PC_Qty DESC";
            //Crea el Dashboard
            echo GraphDraw($GType3, $GTitle3, $GDiv3, $ArrINFO3, $GSQL013);
            
            $GType4 = "PieChart";
            $GTitle4 = "By Status Chart";
            $GDiv4 = "statusChart";
            $ArrINFO4['SubtitleName'] = "Vendor";
            $ArrINFO4['SubtitleQty'] = "Qty";
            $ArrINFO4['LoadDriver'] = 0;
            
            $GSQL014 = "SELECT Status AS PC_Name, SUM(QtyNPromise) AS PC_Qty FROM POControl WHERE QtyNPromise > '0' AND $dateDiff GROUP BY PC_Name ORDER BY PC_Qty DESC";
            //Crea el Dashboard
            echo GraphDraw($GType4, $GTitle4, $GDiv4, $ArrINFO4, $GSQL014);
            
            $FGraph = "";
            $FGraph = "<table width='100%'>";
            $FGraph .= "<tr>"
                    . "<td width='25%' align='left'><font class='Exs'></font></td>"
                    . "<td colspan='2' align='center'><font class='Ex'>$TitleDashboard</font></td>"
                    . "<td width='25%' align='right'><font class='Robsss'><b>Updated on:</b><br></font><font class='Robss'>$dtAhora</font></td>"
                    . "</tr>"
                    . "<tr>"
                    . "<td width='25%' align='left'><font class='Exs'></font></td>"
                    . "<td colspan='2' align='center'><font class='Robs'>$SubtitleDashboard</font></td>"
                    . "<td width='25%' align='right'><font class='Robsss'><a href='Include/reportCSV.php?report=POControl&D1=$D1&D2=$D2&D3=$D3' target='_blank'><img src='Images/xls.svg' width='30'></a></td>"
                    . "</tr>"
                    . "<tr><td colspan='4' height='40'></td></tr>";
            $FGraph .= "<tr>"
                    . "<td colspan='2' width='50%' align='center'><font class='Exss'>$GTitle5</font><br><div id='$GDiv5' style='height:400px;'></div></td>"
                    . "</td>"
                    . "<td colspan='2' width='50%' align='center'><font class='Exss'>$GTitle3</font><br><div id='$GDiv3' style='height:400px;'></div></td>"
                    . "</tr>";
            $FGraph .= "<tr><td width='100%' colspan='4' align='center'><table width='100%'>";
            $FGraph .= "<tr>"
                    . "<td align='center' width='33%'><font class='Exss'>$GTitle2</font><br><div id='$GDiv2' style='height:400px;'></div></td>"
                    . "</td>"
                    . "<td align='center' width='34%'><font class='Exss'>$GTitle</font><br><div id='$GDiv' style='height:400px;'></div></td>"
                    . "<td align='center' width='33%'><font class='Exss'>$GTitle4</font><br><div id='$GDiv4' style='height:400px;'></div></td>"
                    . "</tr>";
            $FGraph .= "</table></td></tr>";
            $FGraph .= "</table>";
            $FGraph .= "<script lang='javascript/text'>"
                    . "function resetear(){ document.location.reload(); }"
                    . "setTimeout(resetear, 50000);"
                    . "</script>";
            
            break;
        case "DetailPOCOwnerRisk":
            //echo "$gKeyI - $gKeyII - $gKeyIII";
            $gIDOwner = $gKeyII;
            $gRisk = $gKeyIII;
            $D1 = base64_encode($gIDOwner);
            $D2 = base64_encode("byOwnerRisk");
            $D3 = base64_encode($gRisk);
            $sInfoU = "SELECT * FROM Users WHERE IDUser = '$gIDOwner'";
            $rInfoU = $cnx->query($sInfoU)->fetchArray();
            $gOwner = $rInfoU['Name'] . " " . $rInfoU['FLastName'];
            switch($gRisk){
                case "LOW":
                    $dateDiff = "DATEDIFF('$dtAhora', Purchase_Order_Add_Date) < '8'";
                    break;
                case "MEDIUM":
                    $dateDiff = "DATEDIFF('$dtAhora', Purchase_Order_Add_Date) BETWEEN '8' AND '15'";
                    break;
                case "HIGH":
                    $dateDiff = "DATEDIFF('$dtAhora', Purchase_Order_Add_Date) > '15'";
                    break;
            }
            
            //echo $sInfoU;
            $TitleDashboard = "Supply Chain PO Control Dashboard";
            $SubtitleDashboard = "Unconfirm Impact by Delivery ($gOwner - <font style='color:red;'><b>$gKeyIII RISK</b></font>)";
            $GType5 = "PieChart";
            $GTitle5 = "By Owner Chart";
            $GDiv5 = "ownerChart";
            $ArrINFO5['SubtitleName'] = "Owner";
            $ArrINFO5['SubtitleQty'] = "Qty";
            $ArrINFO5['LoadDriver'] = 1;
            $pLink5 = base64_encode("DetailPOCOwner");
            $GSQL015 = "SELECT Owner AS PC_Name, SUM(QtyNPromise) AS PC_Qty, "
                    . "CONCAT('Dashboard.php?KeyI="
                    . "$pLink4" . "&KeyII=', TO_BASE64(IDOwner), '&KeyIII=') AS PC_Link FROM POControl WHERE QtyNPromise > '0' AND IDOwner = '$gIDOwner' AND $dateDiff GROUP BY PC_Name ORDER BY PC_Qty DESC";
            //$GSQL01 = "SELECT Buyer AS PC_Name, COUNT(keyPPV) AS PC_Qty FROM PPVs GROUP BY Buyer ORDER BY PC_Qty DESC";
            //Crea el Dashboard
            echo GraphDraw($GType5, $GTitle5, $GDiv5, $ArrINFO5, $GSQL015);
            
            
            $GType = "PieChartLink";
            $GTitle = "By Qty of Days Chart";
            $GDiv = "DaysChart";
            $ArrINFO['SubtitleName'] = "Days";
            $ArrINFO['Units'] = "Days";
            $ArrINFO['SubtitleQty'] = "Qty";
            $ArrINFO['LoadDriver'] = 1;
            $pLink = base64_encode("DetailPOCOwnerRisk");
            $D2x = base64_encode("OwnDays");
            $GSQL01 = "SELECT "
                    . "DATEDIFF('$dtAhora', Purchase_Order_Add_Date) AS PC_Name, SUM(QtyNPromise) AS PC_Qty, "
                    . "CONCAT('Include/reportCSV.php?report=POControl"
                    . "&D1=$D1&D2=$D2x&D3=', TO_BASE64(DATEDIFF('$dtAhora', Purchase_Order_Add_Date))) AS PC_Link "
                    . "FROM POControl WHERE IDOwner = '$gIDOwner' AND QtyNPromise > '0' AND $dateDiff GROUP BY PC_Name ORDER BY PC_Name DESC";
            //echo $GSQL01;
            //Crea el Dashboard
            echo GraphDraw($GType, $GTitle, $GDiv, $ArrINFO, $GSQL01);
            
            $GType2 = "PieChart";
            $GTitle2 = "By CustomerChart";
            $GDiv2 = "customerChart";
            $ArrINFO2['SubtitleName'] = "Customer";
            $ArrINFO2['SubtitleQty'] = "Qty";
            $ArrINFO2['LoadDriver'] = 0;
            
            $GSQL012 = "SELECT Customer AS PC_Name, SUM(QtyNPromise) AS PC_Qty FROM POControl WHERE  IDOwner = '$gIDOwner' AND QtyNPromise > '0' AND $dateDiff  GROUP BY PC_Name ORDER BY PC_Qty DESC";
            //Crea el Dashboard
            echo GraphDraw($GType2, $GTitle2, $GDiv2, $ArrINFO2, $GSQL012);
            
            $GType3 = "PieChart";
            $GTitle3 = "By Vendor Chart";
            $GDiv3 = "vendorChart";
            $ArrINFO3['SubtitleName'] = "Vendor";
            $ArrINFO3['SubtitleQty'] = "Qty";
            $ArrINFO3['LoadDriver'] = 0;
            
            $GSQL013 = "SELECT Vendor_Name AS PC_Name, SUM(QtyNPromise) AS PC_Qty FROM POControl WHERE IDOwner = '$gIDOwner' AND QtyNPromise > '0' AND $dateDiff GROUP BY PC_Name ORDER BY PC_Qty DESC";
            //Crea el Dashboard
            echo GraphDraw($GType3, $GTitle3, $GDiv3, $ArrINFO3, $GSQL013);
            
            $GType4 = "PieChart";
            $GTitle4 = "By Status Chart";
            $GDiv4 = "statusChart";
            $ArrINFO4['SubtitleName'] = "Vendor";
            $ArrINFO4['SubtitleQty'] = "Qty";
            $ArrINFO4['LoadDriver'] = 0;
            
            $GSQL014 = "SELECT Status AS PC_Name, SUM(QtyNPromise) AS PC_Qty FROM POControl WHERE IDOwner = '$gIDOwner' AND QtyNPromise > '0' AND $dateDiff GROUP BY PC_Name ORDER BY PC_Qty DESC";
            //Crea el Dashboard
            echo GraphDraw($GType4, $GTitle4, $GDiv4, $ArrINFO4, $GSQL014);
            
            $FGraph = "";
            $FGraph = "<table width='100%'>";
            $FGraph .= "<tr>"
                    . "<td width='25%' align='left'><font class='Exs'></font></td>"
                    . "<td colspan='2' align='center'><font class='Ex'>$TitleDashboard</font></td>"
                    . "<td width='25%' align='right'><font class='Robsss'><b>Updated on:</b><br></font><font class='Robss'>$dtAhora</font></td>"
                    . "</tr>"
                    . "<tr>"
                    . "<td width='25%' align='left'><font class='Exs'></font></td>"
                    . "<td colspan='2' align='center'><font class='Robs'>$SubtitleDashboard</font></td>"
                    . "<td width='25%' align='right'><font class='Robsss'><a href='Include/reportCSV.php?report=POControl&D1=$D1&D2=$D2&D3=$D3' target='_blank'><img src='Images/xls.svg' width='30'></a></td>"
                    . "</tr>"
                    . "<tr><td colspan='4' height='40'></td></tr>";
            $FGraph .= "<tr>"
                    . "<td colspan='2' width='50%' align='center'><font class='Exss'>$GTitle5</font><br><div id='$GDiv5' style='height:400px;'></div></td>"
                    . "</td>"
                    . "<td colspan='2' width='50%' align='center'><font class='Exss'>$GTitle3</font><br><div id='$GDiv3' style='height:400px;'></div></td>"
                    . "</tr>";
            $FGraph .= "<tr><td width='100%' colspan='4' align='center'><table width='100%'>";
            $FGraph .= "<tr>"
                    . "<td align='center' width='33%'><font class='Exss'>$GTitle2</font><br><div id='$GDiv2' style='height:400px;'></div></td>"
                    . "</td>"
                    . "<td align='center' width='34%'><font class='Exss'>$GTitle</font><br><div id='$GDiv' style='height:400px;'></div></td>"
                    . "<td align='center' width='33%'><font class='Exss'>$GTitle4</font><br><div id='$GDiv4' style='height:400px;'></div></td>"
                    . "</tr>";
            $FGraph .= "</table></td></tr>";
            $FGraph .= "</table>";
            $FGraph .= "<script lang='javascript/text'>"
                    . "function resetear(){ document.location.reload(); }"
                    . "setTimeout(resetear, 50000);"
                    . "</script>";
            
            break;
        case "DetailPOCOwner":
            //echo "$gKeyI - $gKeyII - $gKeyIII";
            $gIDOwner = $gKeyII;
            $D2 = base64_encode("byOwner");
            $D1 = base64_encode($gIDOwner);
            $sInfoU = "SELECT * FROM Users WHERE IDUser = '$gIDOwner'";
            $rInfoU = $cnx->query($sInfoU)->fetchArray();
            $gOwner = $rInfoU['Name'] . " " . $rInfoU['FLastName'];
            //echo $sInfoU;
            $TitleDashboard = "Supply Chain PO Control Dashboard";
            $SubtitleDashboard = "Unconfirm Impact by Delivery ($gOwner)";
            $GType4 = "PieChart";
            $GTitle4 = "By Owner Chart";
            $GDiv4 = "ownerChart";
            $ArrINFO4['SubtitleName'] = "Owner";
            $ArrINFO4['SubtitleQty'] = "Qty";
            $ArrINFO4['LoadDriver'] = 1;
            $pLink4 = base64_encode("DetailPOCOwner");
            $GSQL014 = "SELECT Owner AS PC_Name, SUM(QtyNPromise) AS PC_Qty, "
                    . "CONCAT('Dashboard.php?KeyI="
                    . "$pLink4" . "&KeyII=', TO_BASE64(IDOwner), '&KeyIII=') AS PC_Link FROM POControl WHERE QtyNPromise > '0' AND IDOwner = '$gIDOwner' GROUP BY PC_Name ORDER BY PC_Qty DESC";
            //$GSQL01 = "SELECT Buyer AS PC_Name, COUNT(keyPPV) AS PC_Qty FROM PPVs GROUP BY Buyer ORDER BY PC_Qty DESC";
            //Crea el Dashboard
            echo GraphDraw($GType4, $GTitle4, $GDiv4, $ArrINFO4, $GSQL014);
            
            
            $GType = "PieChartLink";
            $GTitle = "By Qty of Days Chart";
            $GDiv = "DaysChart";
            $ArrINFO['SubtitleName'] = "Days";
            $ArrINFO['SubtitleQty'] = "Qty";
            $ArrINFO['LoadDriver'] = 1;
            $ArrINFO['Colors'] = "colors:['red', 'orange', '#3366cc']";
            $ArrINFO['ExtraL'] = "AVG";
            $clevel = 0;
            $AvgLevels = "";
            
            while ($clevel < 3){
                $clevel++;
                $TLevel = 0;
                $TQty = 0;
                switch ($clevel){
                    case 1:
                        $qr = "> 15";
                        break;
                    case 2:
                        $qr = "BETWEEN '8' AND '15'";
                        break;
                    case 3:
                        $qr = "BETWEEN '0' AND '7'";
                        break;
                }
                
                $sAvg = "SELECT DATEDIFF('$dtAhora', Purchase_Order_Add_Date) AS NDays, SUM(QtyNPromise) AS QNP "
                    . "FROM POControl WHERE QtyNPromise > '0' AND IDOwner = '$gIDOwner' "
                    . "AND DATEDIFF('$dtAhora', Purchase_Order_Add_Date) $qr "
                    . "GROUP BY NDays";
                $nAvg = $cnx->query($sAvg)->numRows();
                if($nAvg > 0){
                    $LAvg = $cnx->query($sAvg)->fetchAll();
                    foreach ($LAvg as &$rAvg) {
                        $gNDays = $rAvg['NDays'];
                        $gQNP = $rAvg['QNP'];
                        $TLevel += $gQNP;
                        $TQty += ($gNDays * $gQNP);
                    }
                    $Avg = round($TQty/$TLevel);
                    $AvgLevels .= "AVG:$Avg|";
                } else {
                    //$AvgLevels .= "0|";
                }
                
            }
            $AvgLevels = substr($AvgLevels, 0, -1);
            $ArrINFO['ExtraData'] = $AvgLevels;
            $pLink = base64_encode("DetailPOCOwnerRisk");
            $GSQL01 = "SELECT "
                    . "CASE "
                    . "WHEN DATEDIFF('$dtAhora', Purchase_Order_Add_Date) < 8 THEN 'LOW RISK - Less than 8 days' "
                    . "WHEN DATEDIFF('$dtAhora', Purchase_Order_Add_Date) < 16 THEN 'MEDIUM RISK - 8 - 15 days' "
                    . "ELSE 'HIGH RISK - More than 16 days'"
                    . "END AS PC_Name, SUM(QtyNPromise) AS PC_Qty, "
                    . "CONCAT('Dashboard.php?KeyI="
                    . "$pLink" . "&KeyII=', TO_BASE64(IDOwner), '&KeyIII=', TO_BASE64("
                    . "CASE "
                    . "WHEN DATEDIFF('$dtAhora', Purchase_Order_Add_Date) < 8 THEN 'LOW' "
                    . "WHEN DATEDIFF('$dtAhora', Purchase_Order_Add_Date) < 16 THEN 'MEDIUM' "
                    . "ELSE 'HIGH'"
                    . "END"
                    . ")) AS PC_Link "
                    . "FROM POControl WHERE IDOwner = '$gIDOwner' AND QtyNPromise > '0' GROUP BY PC_Name "
                    . "ORDER BY FIELD(PC_Name, 'HIGH RISK - More than 16 days ', 'MEDIUM RISK - 8 - 15 days', 'LOW RISK - Less than 8 days')";
            //Crea el Dashboard
            echo GraphDraw($GType, $GTitle, $GDiv, $ArrINFO, $GSQL01);
            
            $GType2 = "PieChart";
            $GTitle2 = "By CustomerChart";
            $GDiv2 = "customerChart";
            $ArrINFO2['SubtitleName'] = "Customer";
            $ArrINFO2['SubtitleQty'] = "Qty";
            $ArrINFO2['LoadDriver'] = 0;
            
            $GSQL012 = "SELECT Customer AS PC_Name, SUM(QtyNPromise) AS PC_Qty FROM POControl WHERE IDOwner = '$gIDOwner' AND QtyNPromise > '0' GROUP BY PC_Name ORDER BY PC_Qty DESC";
            //Crea el Dashboard
            echo GraphDraw($GType2, $GTitle2, $GDiv2, $ArrINFO2, $GSQL012);
            
            $GType3 = "PieChart";
            $GTitle3 = "By Vendor Chart";
            $GDiv3 = "vendorChart";
            $ArrINFO3['SubtitleName'] = "Vendor";
            $ArrINFO3['SubtitleQty'] = "Qty";
            $ArrINFO3['LoadDriver'] = 0;
            
            $GSQL013 = "SELECT Vendor_Name AS PC_Name, SUM(QtyNPromise) AS PC_Qty FROM POControl WHERE IDOwner = '$gIDOwner' AND QtyNPromise > '0' GROUP BY PC_Name ORDER BY PC_Qty DESC";
            //Crea el Dashboard
            echo GraphDraw($GType3, $GTitle3, $GDiv3, $ArrINFO3, $GSQL013);
            
            $GType5 = "PieChart";
            $GTitle5 = "By Status Chart";
            $GDiv5 = "statusChart";
            $ArrINFO5['SubtitleName'] = "Vendor";
            $ArrINFO5['SubtitleQty'] = "Qty";
            $ArrINFO5['LoadDriver'] = 0;
            
            $GSQL015 = "SELECT Status AS PC_Name, SUM(QtyNPromise) AS PC_Qty FROM POControl WHERE IDOwner = '$gIDOwner' AND QtyNPromise > '0' GROUP BY PC_Name ORDER BY PC_Qty DESC";
            //Crea el Dashboard
            echo GraphDraw($GType5, $GTitle5, $GDiv5, $ArrINFO5, $GSQL015);
            
            $FGraph = "";
            $FGraph = "<table width='100%'>";
            $FGraph .= "<tr>"
                    . "<td width='25%' align='left'><font class='Exs'></font></td>"
                    . "<td colspan='2' align='center'><font class='Ex'>$TitleDashboard</font></td>"
                    . "<td width='25%' align='right'><font class='Robsss'><b>Updated on:</b><br></font><font class='Robss'>$dtAhora</font></td>"
                    . "</tr>"
                    . "<tr>"
                    . "<td width='25%' align='left'><font class='Exs'></font></td>"
                    . "<td colspan='2' align='center'><font class='Robs'>$SubtitleDashboard</font></td>"
                    . "<td width='25%' align='right'><font class='Robsss'><a href='Include/reportCSV.php?report=POControl&D1=$D1&D2=$D2' target='_blank'><img src='Images/xls.svg' width='30'></a></td>"
                    . "</tr>"
                    . "<tr><td colspan='4' height='40'></td></tr>";
            $FGraph .= "<tr>"
                    . "<td colspan='2' width='50%' align='center'><font class='Exss'>$GTitle4</font><br><div id='$GDiv4' style='height:400px;'></div></td>"
                    . "</td>"
                    . "<td colspan='2' width='50%' align='center'><font class='Exss'>$GTitle3</font><br><div id='$GDiv3' style='height:400px;'></div></td>"
                    . "</tr>";
            $FGraph .= "<tr><td width='100%' colspan='4' align='center'><table width='100%'>";
            $FGraph .= "<tr>"
                    . "<td align='center' width='33%'><font class='Exss'>$GTitle2</font><br><div id='$GDiv2' style='height:400px;'></div></td>"
                    . "</td>"
                    . "<td align='center' width='34%'><font class='Exss'>$GTitle</font><br><div id='$GDiv' style='height:400px;'></div></td>"
                    . "<td align='center' width='33%'><font class='Exss'>$GTitle5</font><br><div id='$GDiv5' style='height:400px;'></div></td>"
                    . "</tr>";
            $FGraph .= "</table></td></tr>";
            $FGraph .= "</table>";
            $FGraph .= "<script lang='javascript/text'>"
                    . "function resetear(){ document.location.reload(); }"
                    . "setTimeout(resetear, 50000);"
                    . "</script>";
            
            break;
        case "POCDashboard":
            $TitleDashboard = "Supply Chain PO Control Dashboard";
            $SubtitleDashboard = "Unconfirm Impact by Delivery";
            $GType = "PieChartLink";
            $GTitle = "By Owner Chart";
            $GDiv = "ownerChart";
            $ArrINFO['SubtitleName'] = "Owner";
            $ArrINFO['SubtitleQty'] = "Qty";
            $ArrINFO['LoadDriver'] = 1;
            $pLink = base64_encode("DetailPOCOwner");
            $GSQL01 = "SELECT Owner AS PC_Name, SUM(QtyNPromise) AS PC_Qty, "
                    . "CONCAT('Dashboard.php?KeyI="
                    . "$pLink" . "&KeyII=', TO_BASE64(IDOwner), '&KeyIII=') AS PC_Link FROM POControl WHERE QtyNPromise > '0' GROUP BY PC_Name ORDER BY PC_Qty DESC";
            //$GSQL01 = "SELECT Buyer AS PC_Name, COUNT(keyPPV) AS PC_Qty FROM PPVs GROUP BY Buyer ORDER BY PC_Qty DESC";
            //Crea el Dashboard
            echo GraphDraw($GType, $GTitle, $GDiv, $ArrINFO, $GSQL01);
            
            $GType2 = "PieChartLink";
            $GTitle2 = "By CustomerChart";
            $GDiv2 = "customerChart";
            $ArrINFO2['SubtitleName'] = "Customer";
            $ArrINFO2['SubtitleQty'] = "Qty";
            $ArrINFO2['LoadDriver'] = 0;
            $pLink2 = base64_encode("DetailPOCCustomer");
            
            $GSQL012 = "SELECT Customer AS PC_Name, SUM(QtyNPromise) AS PC_Qty, "
                    . "CONCAT('Dashboard.php?KeyI="
                    . "$pLink2" . "&KeyII=', TO_BASE64(Customer), '&KeyIII=') AS PC_Link"
                    . " FROM POControl WHERE QtyNPromise > '0' GROUP BY PC_Name ORDER BY PC_Qty DESC";
            //Crea el Dashboard
            echo GraphDraw($GType2, $GTitle2, $GDiv2, $ArrINFO2, $GSQL012);
            
            $GType3 = "PieChartLink";
            $GTitle3 = "By Vendor Chart";
            $GDiv3 = "vendorChart";
            $ArrINFO3['SubtitleName'] = "Vendor";
            $ArrINFO3['SubtitleQty'] = "Qty";
            $ArrINFO3['LoadDriver'] = 0;
            $pLink3 = base64_encode("DetailPOCVendor");
            
            $GSQL013 = "SELECT Vendor_Name AS PC_Name, SUM(QtyNPromise) AS PC_Qty, "
                    . "CONCAT('Dashboard.php?KeyI="
                    . "$pLink3" . "&KeyII=', TO_BASE64(Vendor_Name), '&KeyIII=') AS PC_Link "
                    . "FROM POControl WHERE QtyNPromise > '0' GROUP BY PC_Name ORDER BY PC_Qty DESC";
            //Crea el Dashboard
            echo GraphDraw($GType3, $GTitle3, $GDiv3, $ArrINFO3, $GSQL013);
            
            $GType4 = "PieChart";
            $GTitle4 = "By Status Chart";
            $GDiv4 = "statusChart";
            $ArrINFO4['SubtitleName'] = "Vendor";
            $ArrINFO4['SubtitleQty'] = "Qty";
            $ArrINFO4['LoadDriver'] = 0;
            
            $GSQL014 = "SELECT Status AS PC_Name, SUM(QtyNPromise) AS PC_Qty FROM POControl WHERE QtyNPromise > '0' GROUP BY PC_Name ORDER BY PC_Qty DESC";
            //Crea el Dashboard
            echo GraphDraw($GType4, $GTitle4, $GDiv4, $ArrINFO4, $GSQL014);
            
            $GType5 = "PieChartLink";
            $GTitle5 = "By Risk Chart";
            $GDiv5 = "LevelChart";
            $ArrINFO5['SubtitleName'] = "Risk";
            $ArrINFO5['SubtitleQty'] = "Qty";
            $ArrINFO5['LoadDriver'] = 1;
            $pLink5 = base64_encode("DetailPOCRisk");
            $ArrINFO5['Colors'] = "colors:['red', 'orange', '#3366cc']";
            //Obtiene todos los campos
            //LOW
            $clevel = 0;
            $AvgLevels = "";
            while ($clevel < 3){
                $clevel++;
                $TLevel = 0;
                $TQty = 0;
                switch ($clevel){
                    case 1:
                        $qr = "> 15";
                        break;
                    case 2:
                        $qr = "BETWEEN '8' AND '15'";
                        break;
                    case 3:
                        $qr = "BETWEEN '0' AND '7'";
                        break;
                }
                $sAvg = "SELECT DATEDIFF('$dtAhora', Purchase_Order_Add_Date) AS NDays, SUM(QtyNPromise) AS QNP "
                    . "FROM POControl WHERE QtyNPromise > '0' "
                    . "AND DATEDIFF('$dtAhora', Purchase_Order_Add_Date) $qr "
                    . "GROUP BY NDays";
                $nAvg = $cnx->query($sAvg)->numRows();
                if($nAvg > 0){
                    $LAvg = $cnx->query($sAvg)->fetchAll();
                    foreach ($LAvg as &$rAvg) {
                        $gNDays = $rAvg['NDays'];
                        $gQNP = $rAvg['QNP'];
                        $TLevel += $gQNP;
                        $TQty += ($gNDays * $gQNP);
                    }
                    $Avg = round($TQty/$TLevel);
                    $AvgLevels .= "AVG:$Avg|";
                } else {
                    //$AvgLevels .= "0|";
                }
                
            }
            
            $AvgLevels = substr($AvgLevels, 0, -1);
            $ArrINFO5['ExtraData'] = $AvgLevels;
            $GSQL05 = "SELECT "
                    . "CASE "
                    . "WHEN DATEDIFF('$dtAhora', Purchase_Order_Add_Date) < 8 THEN 'LOW RISK - Less than 8 days' "
                    . "WHEN DATEDIFF('$dtAhora', Purchase_Order_Add_Date) < 16 THEN 'MEDIUM RISK - 8 to 15 days' "
                    . "ELSE 'HIGH RISK - More than 16 days' "
                    . "END AS PC_Name, SUM(QtyNPromise) AS PC_Qty, "
                    . "CONCAT('Dashboard.php?KeyI="
                    . "$pLink5" . "&KeyII=', '&KeyIII=', TO_BASE64("
                    . "CASE "
                    . "WHEN DATEDIFF('$dtAhora', Purchase_Order_Add_Date) < 8 THEN 'LOW' "
                    . "WHEN DATEDIFF('$dtAhora', Purchase_Order_Add_Date) < 16 THEN 'MEDIUM' "
                    . "ELSE 'HIGH'"
                    . "END"
                    . ")) AS PC_Link "
                    . "FROM POControl WHERE QtyNPromise > '0' GROUP BY PC_Name "
                    . "ORDER BY FIELD(PC_Name, 'HIGH RISK - More than 16 days', 'MEDIUM RISK - 8 to 15 days', 'LOW RISK - Less than 8 days')";
            //echo $GSQL05;
            //$GSQL01 = "SELECT Buyer AS PC_Name, COUNT(keyPPV) AS PC_Qty FROM PPVs GROUP BY Buyer ORDER BY PC_Qty DESC";
            //Crea el Dashboard
            echo GraphDraw($GType5, $GTitle5, $GDiv5, $ArrINFO5, $GSQL05);
            $gD2 = base64_encode("All");
            
            $FGraph = "";
            $FGraph = "<table width='100%'>";
            $FGraph .= "<tr>"
                    . "<td width='25%' align='left'><font class='Exs'></font></td>"
                    . "<td colspan='2' align='center'><font class='Ex'>$TitleDashboard</font></td>"
                    . "<td width='25%' align='right'><font class='Robsss'><b>Updated on:</b><br></font><font class='Robss'>$dtAhora</font></td>"
                    . "</tr>"
                    . "<tr>"
                    . "<td width='25%' align='left'><font class='Exs'></font></td>"
                    . "<td colspan='2' align='center'><font class='Robs'>$SubtitleDashboard</font></td>"
                    . "<td width='25%' align='right'><font class='Robsss'><a href='Include/reportCSV.php?report=POControl&D1=&D2=$gD2' target='_blank'><img src='Images/xls.svg' width='30'></a></td>"
                    . "</tr>"
                    . "<tr><td colspan='4' height='40'></td></tr>";
            $FGraph .= "<tr>"
                    . "<td colspan='2' width='50%' align='center'><font class='Exss'>$GTitle</font><br><div id='$GDiv' style='height:400px;'></div></td>"
                    . "</td>"
                    . "<td colspan='2' width='50%' align='center'><font class='Exss'>$GTitle3</font><br><div id='$GDiv3' style='height:400px;'></div></td>"
                    . "</tr>";
            $FGraph .= "<tr><td width='100%' colspan='4' align='center'><table width='100%'>";
            $FGraph .= "<tr>"
                    . "<td align='center' width='33%'><font class='Exss'>$GTitle2</font><br><div id='$GDiv2' style='height:400px;'></div></td>"
                    . "</td>"
                    . "<td align='center' width='34%'><font class='Exss'>$GTitle5</font><br><div id='$GDiv5' style='height:400px;'></div></td>"
                    . "<td align='center' width='33%'><font class='Exss'>$GTitle4</font><br><div id='$GDiv4' style='height:400px;'></div></td>"
                    . "</tr>";
            $FGraph .= "</table></td></tr>";
            $FGraph .= "</table>";
            $FGraph .= "<script lang='javascript/text'>"
                    . "function resetear(){ document.location.reload(); }"
                    . "setTimeout(resetear, 50000);"
                    . "</script>";
            break;
        case "PPVDashboard":
            $TitleDashboard = "Supply Chain PPVs Dashboard";
            $SubtitleDashboard = "Impact by Vendor";
            $GType = "PieChart";
            $GTitle = "By Buyer Chart";
            $GDiv = "buyerChart";
            $ArrINFO['SubtitleName'] = "Buyer";
            $ArrINFO['SubtitleQty'] = "Qty";
            $ArrINFO['LoadDriver'] = 1;
            $GSQL01 = "SELECT Buyer AS PC_Name, COUNT(keyPPV) AS PC_Qty FROM PPVs GROUP BY Buyer ORDER BY PC_Qty DESC";
            //Crea el Dashboard
            echo GraphDraw($GType, $GTitle, $GDiv, $ArrINFO, $GSQL01);
            
            $GType2 = "PieChart";
            $GTitle2 = "By Status Chart";
            $GDiv2 = "statusChart";
            $ArrINFO2['SubtitleName'] = "Status";
            $ArrINFO2['SubtitleQty'] = "Qty";
            $ArrINFO2['LoadDriver'] = 0;
            
            $GSQL012 = "SELECT Status AS PC_Name, COUNT(keyPPV) AS PC_Qty FROM PPVs GROUP BY Status ORDER BY PC_Qty DESC";
            //Crea el Dashboard
            echo GraphDraw($GType2, $GTitle2, $GDiv2, $ArrINFO2, $GSQL012);
            
            $GType3 = "ComboChartBAR";
            $GTitle3 = "Impact By Vendor";
            $GDiv3 = "byvendor";
            $ArrINFO3['AxisX'] = "Vendor";
            $ArrINFO3['AxisY1'] = "Unfavorable ($)";
            $ArrINFO3['AxisY2'] = "Favorable ($)";
            
            $GSQL013 = "SELECT Vendor_Number AS PC_AxisX, "
                    . "SUM(CASE WHEN ImpactValue > 0 THEN ImpactValue ELSE 0 END) AS PC_AxisY1, "
                    . "ABS(SUM(CASE WHEN ImpactValue < 0 THEN ImpactValue ELSE 0 END)) AS PC_AxisY2 "
                    . "FROM PPVs GROUP BY Vendor_Number ORDER BY PC_AxisY1 DESC";
            //Crea el Dashboard
            echo GraphDraw($GType3, $GTitle3, $GDiv3, $ArrINFO3, $GSQL013);
            
            $FGraph = "";
            $FGraph = "<table width='100%'>";
            $FGraph .= "<tr>"
                    . "<td width='25%' align='left'><font class='Exs'></font></td>"
                    . "<td colspan='2' align='center'><font class='Ex'>$TitleDashboard</font></td>"
                    . "<td width='25%' align='right'><font class='Robsss'><b>Updated on:</b><br></font><font class='Robss'>$dtAhora</font></td>"
                    . "</tr>"
                    . "<tr>"
                    . "<td width='25%' align='left'><font class='Exs'></font></td>"
                    . "<td colspan='2' align='center'><font class='Robs'>$SubtitleDashboard</font></td>"
                    . "<td width='25%' align='right'><font class='Robsss'></td>"
                    . "</tr>"
                    . "<tr><td colspan='4' height='40'></td></tr>";
            $FGraph .= "<tr>"
                    . "<td colspan='2' width='50%' align='center'><font class='Exss'>$GTitle</font><br><div id='$GDiv' style='height:400px;'></div></td>"
                    . "</td>"
                    . "<td colspan='2' width='50%' align='center'><font class='Exss'>$GTitle2</font><br><div id='$GDiv2' style='height:400px;'></div></td>"
                    . "</tr>";
            $FGraph .= "<tr>"
                    . "<td colspan='4' align='center'><font class='Exss'>$GTitle3</font><br><div id='$GDiv3' style='height:400px;'></div></td>"
                    . "</td>"
                    . "</tr>";
            $FGraph .= "</table>";
            
            $FGraph .= "<script lang='javascript/text'>"
                    . "function resetear(){ document.location.reload(); }"
                    . "setTimeout(resetear, 5000);"
                    . "</script>";
            
            
            break;
    endswitch;
}

?>
