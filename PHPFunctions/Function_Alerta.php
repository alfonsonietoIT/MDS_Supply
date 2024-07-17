<?php
/**
 * Mensaje alerta 
 * 
 * @param   strint          $ATipo      Color de la alerta
 * @param   string          $AMensaje   Mensaje de la alerta    
 * @param   integer|string  $Redirect   0(No redirecciona) y url(url redireccion)
 * @param   integer         $ATime      Tiempo en milisegundos para redireccion
 * @copyright   2021 Software Development MX
 * @license     https://www.softwaredevelopment.mx/license/Link_Function.txt
 * @return string
 */


function Alerta($ATipo, $AMensaje, $Redirect, $ATime){
    $AlertX = "";
    
    switch ($ATipo){
        case "Rojo":
            $AColor = "#EF3B3A";
            $ABColor = "red";
            $ATColor = "white";
            break;
        case "Verde":
            $AColor = "#dfc";
            $ABColor = "yellowgreen";
            $ATColor = "black";
            break;
        case "Amarillo":
            $AColor = "yellow";
            $ABColor = "yellowgreen";
            $ATColor = "black";
            break;
    }
    
    $AlertX .= "<center><div style='width:300px;'><center>"
            . "<div style='width: 90%; border: $ABColor solid 1px; background-color: $AColor; color:$ATColor; text-align: center; padding: 5px;border-radius: 4px;'>"
            . "<font class='Bahs' style='color:$ATColor;'>$AMensaje</font>"
            . "</div><br>"
            . "</center>";
    
    if($Redirect != "0"){
        $AlertX .= "<br><br><font class='Ex' style='color:gray;'>"
                //. "<img src='/images/SoftDevBox.jpg' width='30%' style='-webkit-filter: grayscale(100%);filter: grayscale(100%);opacity: 0.3;filter: alpha(opacity=30);'><br>"
                . "on process...<br>"
                . "<div class='lds-ellipsis'><div></div><div></div><div></div><div></div></div>"
                . "</font><br>"
                . "<script language='javascript' type='text/javascript'>"
                . "setTimeout(\"location.href = '$Redirect';\", $ATime);"
                . "</script>";
    }
    
    $AlertX .= "</div></center>";
    
    return $AlertX;
}

?>