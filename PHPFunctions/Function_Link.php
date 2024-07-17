<?php
/**
 * Mensaje alerta 
 * 
 * @param   string          $LID        ID List
 * @param   array           $LRows      Data Rows
 * @param   string          $IDOption   Token para Option
 * @copyright   2021 Software Development MX
 * @license     https://www.softwaredevelopment.mx/license/Link_Function.txt
 * @return string
 */

function FLink($FuncLinks){
    //Info del Form
    //global $cnx;
    
    foreach ($FuncLinks as $valLinks) {
        $Type_L = $valLinks[0];
        $Size_L = $valLinks[1];
        $Icon_L = $valLinks[2];
        $Action_L = $valLinks[3];
        $Target_L = $valLinks[4];
        $Title_L = $valLinks[5];
        $Color_L = $valLinks[6];
        $Color_LT = $valLinks[7];

        switch ($Type_L){
            case "buttonb":
                $Size_Lx = $Size_L . "%";
                $TStyle = "vertical-align:middle;width:$Size_Lx;text-decoration:none;display:inline-block;background-color:$Color_L;color:$Color_LT;font-family:KoHoL;font-size:1.5em;";
                $LinkF .= "<a href='$Action_L' target='$Target_L' title='$Title_L' style='$TStyle'><img src='$Icon_L' width='20' alt='$Title_L' title='$Title_L' border='0'> <B>$Title_L<B></a><br><br>";
                break;
            case "s_icon":
                $LinkF .= "<a href='$Action_L' target='$Target_L' title='$Title_L'><img src='$Icon_L' width='$Size_L' alt='$Title_L' title='$Title_L' border='0'></a>";
                break;
            case "LinkRojo":
                $LinkF .= "<a href='$Action_L' class='linklr' target='$Target_L' title='$Title_L'>$Title_L</a>";
                break;
            case "LinkNegro":
                $LinkF .= "<a href='$Action_L' class='linkln' target='$Target_L' title='$Title_L'>$Title_L</a>";
                break;
        }
    }
    
    return $LinkF;
    
}
?>