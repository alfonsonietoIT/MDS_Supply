<?php
/**
 * Mensaje alerta 
 * 
 * @param   string          $FID      ID Formato
 * @param   string          $FLink    Array Link
 * @param   integer|string  $Redirect   0(No redirecciona) y url(url redireccion)
 * @param   integer         $ATime      Tiempo en milisegundos para redireccion
 * @copyright   2021 Software Development MX
 * @license     https://www.softwaredevelopment.mx/license/Link_Function.txt
 * @return string
 */

function GFormato($FID){
    global $cnx;
    $FormVar = $cnx->query('SELECT nameIn FROM InputsF WHERE TypeIn != ? AND IdForm = ? ORDER BY IdInput ASC', "submit", "$FID")->fetchAll();
    return $FormVar;
}

function Formato($FID, $FLink, $FValues){
    //Info del Form
    global $cnx;
    $FormVar = $cnx->query('SELECT * FROM Forms WHERE IdForm = ?', "$FID")->fetchArray();
    //print_r($FormVar);
    $FV_Title = $FormVar['Title'];
    $FV_MethodF = $FormVar['MethodF'];
    $FV_TypeF = $FormVar['TypeF'];
    $FV_nameF = $FormVar['nameF'];
    $FV_classF = $FormVar['classF'];
    $FV_xtraF = $FormVar['xtraF'];
    $FV_targetF = $FormVar['targetF'];
    $FV_Active = $FormVar['Active'];
    //$FV_Active = 1;
    
    if($FV_Active == 1):
        //Depende el TypeF
        $FormF = "<center><br>"
            . "<font class='Ex' style='color: black;font-size: 2.5em;'>"
            . "$FV_Title</font>"
            . "</center><br>";
        $FormF .= "<form name='$FV_nameF' action='$FLink' class='$FV_classF' method='$FV_MethodF' target='$FV_targetF' $FV_xtraF>";
        
        //Obtiene los fields del Form
        $InputsF = $cnx->query('SELECT * FROM InputsF WHERE IdForm = ? ORDER BY IdInput ASC', $FID)->fetchAll();
        //echo $account['FLastName'];
        //print_r($SiteInfoA);

        foreach ($InputsF AS &$vInputs){
            //Valores
            $InTypeIn = $vInputs['TypeIn'];
            $InclassIn = $vInputs['classIn'];
            $InnameIn = $vInputs['nameIn'];
            $InplaceHolder = $vInputs['placeHolder'];
            $InfocusIn = $vInputs['focusIn'];
            $InRequiredIn = $vInputs['requiredIn'];
            $InvalueIn = $vInputs['valueIn'];
            
            //echo $InplaceHolder . "<BR>";
            
            //Clase
            if($InclassIn != ""){
                $ClaseIn = " class='$InclassIn' ";
            } else {
                $ClaseIn = "";
            }
            
            //Autofocus
            if($InfocusIn == 1){
                $FocusIn = " autofocus='autofocus' ";
            } else {
                $FocusIn = "";
            }
            
            //Place Holderr
            if($InplaceHolder != ""){
                $PHolderIn = " placeholder='$InplaceHolder' ";
            } else {
                $PHolderIn = "";
            }
            
            
            //Value
            if(isset($FValues[$InnameIn])){
                $InvalueIn = $FValues[$InnameIn];
                $ValueIn = " value='$InvalueIn' ";
            } else {
                $ValueIn = " value='$InvalueIn' ";
            }
            
            
            //Required
            if($InRequiredIn == 1){
                $RequiredIn = " required='required' ";
            } else {
                $RequiredIn = "";
            }
            
            switch ($InTypeIn){
                case "file":
                case "tel":
                case "text":
                case "password":
                case "number":
                case "email":
                case "date":
                    /* <input class="text" name="celular" type="tel" placeholder="Celular" autofocus="autofocus">*/
                    $FormF .= "<input $ClaseIn name='$InnameIn' style='width:75%;' type='$InTypeIn' $ValueIn $PHolderIn $FocusIn $RequiredIn><br><br>";
                    break;
                case "select":
                    if(substr($InplaceHolder, 0, 4) == "SQL*"){
                        $qry = substr($InplaceHolder, 4);
                        $iQry = $cnx->query("$qry")->fetchAll();
                        
                        foreach ($iQry as &$rOp) {
                            $valop = $rOp['valor'];
                            $opop = $rOp['opcion'];
                            $optionsx .= "<option value='$valop'>$opop</option>";
                        }
                        
                    } else {
                        //$opt = "";
                        $opt = explode("|", $InplaceHolder);

                        foreach ($opt as $options) {
                            $optionsx .= "<option value='$options'>$options</option>";
                        }
                    }
                    
                    
                    /* <input class="text" name="celular" type="tel" placeholder="Celular" autofocus="autofocus">*/
                    $FormF .= "<select $ClaseIn name='$InnameIn' style='width:75%;' $FocusIn $RequiredIn>"
                            . "$optionsx"
                            . "</select><BR><BR>";
                    $optionsx = "";
                    break;
                case "textarea":
                    
                    $FormF .= "<font class='Kohss' styte='color:black;'>$InplaceHolder</font><BR>"
                            . "<textarea $ClaseIn name='$InnameIn' rows='4' style='width:75%;' $FocusIn $RequiredIn>"
                            . ""
                            . "</textarea><BR><BR>";
                    break;
                case "submit":
                    $FormF .= "<input $ClaseIn name='$InnameIn' type='$InTypeIn' $ValueIn $PHolderIn $FocusIn $RequiredIn><br><br>";
                    break;
            }


        }
    
        $FormF .= "</form>";
        return $FormF;
    else:
        //Alerta
        $vATipo = "Rojo";
        $vAMensaje = "Formato Estado Inactivo";
        $vRedirect = "index.php";
        $vATime = 1000;
        //echo $vRedirect;
        echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
    endif;
    
}
?>