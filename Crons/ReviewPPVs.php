<?php
include '/var/www/html/Supply/PHPClass/DB.php';
include '/var/www/html/Supply/PHPFunctions/var.php';
include '/var/www/html/Supply/PHPFunctions/Function_SMS.php';

/***************************************************************************** POD FILE ***********************/
//PodFile
$PodFile = "SELECT * FROM TempFiles WHERE TFile = 'Pod File' AND Status = 'Open'";
$rPFile = $cnx->query($PodFile)->fetchArray();
$Po_Link = "/home/softwaredevelop/public_html/masterwork/" . $rPFile['Link'];
$Po_idFiles = $rPFile['idFiles'];

//Actualiza POD
$uPod = "UPDATE TempFiles SET dtProcessed = '$dtAhora', Status = 'Runing' WHERE idFiles = '$Po_idFiles'";
//N echo "$uPod<BR><BR>";
$ruPod = $cnx->query($uPod);
$dnowx = date('Y-m-d H:i:s', time());
SMS("6862166100", "Inicia proceso Pod $dnowx", "", "Mario", "PodFile");
//Lee el archivo
$Row = 1;
if (($Gestor = fopen($Po_Link, "r")) !== FALSE) {
    
    while (($PoData = fgetcsv($Gestor, 1000, ",")) !== FALSE) {
        $numero = count($PoData);
        //N echo "<p> $numero de campos en la línea $Row: <br /></p>\n";
        $Row++;
        for ($c=0; $c < $numero; $c++) {
            if($PoData[0] != "Buyer"){
                $var = "C" . $c;
                $$var = str_replace("\\", "", str_replace("\"", "", str_replace("'", "", $PoData[$c])));
                $varant = "aC" . $c;
                if(($c >= 0 && $c < 8) || ($c > 15)){
                    if(empty($$var)){
                        $$var = "" . $$varant;
                    }
                }
                //N echo $var . "-" . $$var . "<br />\n";
                $$varant = $$var;
            }
            
            
        }
        
        
        
        //Solo cantidad mayor a 0
        if($C8 > 0){
            //Expected Delivery
            $C9 = date('Y-m-d', strtotime($C9));
            //Requested Delivery
            $C13 = date('Y-m-d', strtotime($C13));
            //Vendor Promise
            $C14 = date('Y-m-d', strtotime($C14));
            //Purchase Order
            $C20 = date('Y-m-d', strtotime($C20));
            
            
            $iPod = "INSERT INTO PodData VALUE("
                . "'0', '$dtAhora', '$C0', '$C1', '$C2', "
                . "'$C3', '$C4', '$C5', '$C6', '$C7', "
                . "'$C8', '$C9', '$C10', '$C11', '$C12', "
                . "'$C13', '$C14', '$C15', '$C16', '$C17', "
                . "'$C18', '$C19', '$C20', '0', '0', '0', '$dtAhora', '$dtAhora', '0', '', 'Open'"
                . ")";
        
            //N echo $iPod . "<BR>";
            $riPod = $cnx->query($iPod);
        }
        
        
    }
    fclose($Gestor);
}

//Actualiza POD
$uPod2 = "UPDATE TempFiles SET Status = 'Updated' WHERE idFiles = '$Po_idFiles'";
//N echo "$uPod<BR><BR>";
$ruPod2 = $cnx->query($uPod2);
//N unlink($Po_Link);
$dnow = date('Y-m-d H:i:s', time());
SMS("6862166100", "Se Termino Procesar PodFile $dnow", "", "Mario", "PodFile");

/***************************************************************************** PART FILE ***********************/

//PartFile
$PartFile = "SELECT * FROM TempFiles WHERE TFile = 'Parts File' AND Status = 'Open'";
$rPaFile = $cnx->query($PartFile)->fetchArray();
$Pa_Link = "/home/softwaredevelop/public_html/masterwork/" . $rPaFile['Link'];
$Pa_idFiles = $rPaFile['idFiles'];


//Actualiza PART
$uPart = "UPDATE TempFiles SET dtProcessed = '$dtAhora', Status = 'Runing' WHERE idFiles = '$Pa_idFiles'";
//N echo "Aqui - $uPart<BR><BR>";
$ruPart = $cnx->query($uPart);
//Lee el archivo
$RowPa = 1;
if (($GestorPa = fopen($Pa_Link, "r")) !== FALSE) {
    
    while (($PaData = fgetcsv($GestorPa, 1000, ",")) !== FALSE) {
        $numeropa = count($PaData);
        //N echo "<p> $numero de campos en la línea $Row: <br /></p>\n";
        $RowPa++;
        
        for ($x=0; $x < $numeropa; $x++) {
            $va = "X" . $x;
            $$va = "";
            if($PaData[0] != "Item Number"){
                
                
                $$va = str_replace("\\", "", str_replace("\"", "", str_replace("'", "", $PaData[$x])));
            }
            
            
        }
        
        
        //Solo cantidad mayor a 0
        if($X19 > 0){
            //Last Activity
            $X30 = date('Y-m-d', strtotime($X30));
            //Last Rcpt Date
            $X32 = date('Y-m-d', strtotime($X32));
            //On_HAndQty
            if(empty($X9)){
                $X9 = 0;
            }
            //On_HAnd_Qty_Acctg
            $X4 = str_replace(",", "", $X4);
            
            
            $iPar = "INSERT INTO PartData VALUE("
                . "'0', '$dtAhora', '$X0', '$X1', '$X2', "
                . "'$X3', '$X4', '$X5', '$X6', '$X7', "
                . "'$X8', '$X9', '$X10', '$X11', '$X12', "
                . "'$X13', '$X14', '$X15', '$X16', '$X17', "
                . "'$X18', '$X19', '$X20', '$X21', '$X22', "
                . "'$X23', '$X24', '$X25', '$X26', '$X27', "
                . "'$X28', '$X29', '$X30', '$X31', '$X32', "
                . "'$X33', '$X34', '$X35', '$X35', '$X37', "
                . "'$X38', '$X39', '$X40', "
                . "'Open'"
                . ")";
        
            //N echo $iPar . "<BR>";
            $riPart = $cnx->query($iPar);
        }
        
        
    }
    fclose($GestorPa);
}

//Actualiza POD
$uPart2 = "UPDATE TempFiles SET Status = 'Updated' WHERE idFiles = '$Pa_idFiles'";
//N echo "Aqui2 - $uPart2<BR><BR>";
$ruPart2 = $cnx->query($uPart2);

$dnow2 = date('Y-m-d H:i:s', time());
//N unlink($Po_Link);
SMS("6862166100", "Se Termino Procesar PartFile $dnow2", "", "Mario", "PartFile");

/***************************************************************************** Valida PPV ***********************/
$qPPV = "SELECT DISTINCT(Part_Nbr) AS nparte FROM PodData WHERE Status = 'Open' ORDER BY nparte ASC";
$rowPPV = $cnx->query($qPPV)->fetchAll();


foreach ($rowPPV as &$rparte) {
    $nparte = $rparte['nparte'];
    //N echo $NParte
    //Obtiene el precio del PartData
    $sPrice = "SELECT Acctg_Value AS price FROM PartData WHERE Item_Number = '$nparte' ORDER BY price DESC LIMIT 0, 1";
    $rPrice = $cnx->query($sPrice)->fetchArray();
    $gPrice = $rPrice['price'];
    //N echo $sPrice . "<BR>";
    
    //Actualiza el PodData
    $uPodPrice = "UPDATE PodData SET Acctg_Value = '$gPrice', Status = 'valueAdded' WHERE Part_Nbr = '$nparte'";
    $rPodP = $cnx->query($uPodPrice);
    //N echo $uPodPrice . "<BR>";
    
}

$dnow3 = date('Y-m-d H:i:s', time());
//N unlink($Po_Link);
SMS("6862166100", "Se Termino Procesar valueAdded $dnow3", "", "Mario", "valueAdded");


/***************************************************************************** Valida PPV ***********************/
$qImpact = "UPDATE PodData SET Delta_Value = (Currency_List_Unit_Price - Acctg_Value), "
    . "ImpactValue = ((Currency_List_Unit_Price - Acctg_Value) * Quantity_Ordered), dtDelta = NOW(), "
    . "Status = 'forPPV' WHERE Currency_List_Unit_Price != Acctg_Value AND Status = 'valueAdded'";
$rImp = $cnx->query($qImpact);

$dnow4 = date('Y-m-d H:i:s', time());
//N unlink($Po_Link);
SMS("6862166100", "Se Termino Procesar forPPV $dnow4", "", "Mario", "forPPV");



//N echo "Termine...!";




?>