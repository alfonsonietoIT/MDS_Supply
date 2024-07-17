<?php
/**
 * Mensaje alerta 
 * 
 * @param   array           $aGList         Array Data Title, Size, Info, Alert, Search, DataSearch
 * @param   array           $aLinks         Array Links
 * @param   array           $aColumns       Array Columns
 * @copyright   2021 Software Development MX
 * @license     https://www.softwaredevelopment.mx/license/List_Function.txt
 * @return string
 */

function drawList($aGList, $aLinks, $aColumns){
    global $cnx;
    global $sI, $sII, $sIII, $sIV;
    
    //General Form Data
    $F_Title = $aGList[0];
    $F_Width = $aGList[1];
    $F_Info = $aGList[2];
    $F_Alert = $aGList[3];
    $F_ActiveSearch = $aGList[4];
    $F_ValSearch = $aGList[5];
    
    $DataList = "";
    //Draw DIV
    $DataList .= "<center><div style='width:$F_Width;'>";
    //Form Title
    if(!empty($F_Title)){
        $DataList .= "<center><br>"
            . "<font class='Ex' style='color: black;font-size: 2.5em;'>"
            . "$F_Title</font><BR>";
    }
    
    $DataList .= "$F_Alert";
    $DataList .= "$F_Info";
    
    //Links
    if(!empty($aLinks)){
        //Links Draw
        $DataList .= "<div style='text-align:right;'>";
        for ($row = 0; $row < sizeof($aLinks); $row++ ){
            $L_class = $aLinks[$row][3];
            $L_target = $aLinks[$row][2];
            $L_title = $aLinks[$row][1];
            $getthref = $aLinks[$row][0];

            switch ($getthref){
                case "":
                    $sI_l = $aLinks[$row][5];
                    $sII_l = $aLinks[$row][6];
                    $sIII_l = $aLinks[$row][7];
                    $sIV_l = $aLinks[$row][8];
                    $gettoken = $aLinks[$row][9];
                    $gettokeni = $aLinks[$row][10];
                    $gettokenii = $aLinks[$row][11];
                    $NLink = "index.php?sI=" . $sI_l . "&sII=" . $sII_l . "&sIII=" . $sIII_l . "&sIV=" . $sIV_l. "&token=" . $gettoken. "&tokeni=" . $gettokeni. "&tokenii=" . $gettokenii;
                    $DataList .= "<a "
                        . "title='$L_title' href='$NLink' "
                        . "class='$L_class' target='$L_target' >"
                        . "$L_title"
                        . "</a>&nbsp;&nbsp;";
                    break;
                case "file":
                    break;
                default :
                    echo "Default";
                    break;
            }

        }
        $DataList .= "</div>";
        
    }
    
    
    //Search
    if($F_ActiveSearch == 1){
        $DataList .= "<br><form action='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=$sIV&search=1' method='post'>"
            . "<input type='text' class='text' name='search' placeholder='$F_ValSearch'>"
            . "</form>";
            //N echo $FormSearch;
    }
    
    
    //Columnas
    if(!empty($aColumns)){
        //Echo
        $DataList .= "<center><table width='100%'>";
        $contr = 0;
        for ( $rowx = 0; $rowx < sizeof($aColumns); $rowx++ ){
            //Columns
            for ( $colx = 0; $colx < sizeof($aColumns[$rowx]); $colx++ ){
                switch ($colx){
                    case 0:
                        $tr_color = $aColumns[$rowx][$colx];
                        break;
                    case 1:
                        $tr_class = $aColumns[$rowx][$colx];
                        break;
                    default :
                        if($contr == 0){
                            $contr++;
                            $onmouseover = "onmouseover=\"this.bgColor='#E0ECF8'\"";
                            $onmouseout = "onmouseout=\"this.bgColor='$tr_color'\"";
                            $DataList .= "<tr class='$tr_class' bgcolor='$tr_color' $onmouseover $onmouseout >";
                        }
                        //Cada columna
                        if($colx & 1){
                            //N echo 'Even number!';
                            $td_value = $aColumns[$rowx][$colx];
                            $DataList .= "$td_value</td>";
                        }else{
                            //N echo 'Odd number!';
                            $td_class = $aColumns[$rowx][$colx];
                            $DataList .= "<td class='$td_class'>";
                        }
                        break;
                }
            }
            $contr = 0;
            $DataList .= "</tr>";
            
        }
        
        
        $DataList .= "</table></center>";
    }
    
    
    
    $DataList .= "</div></center>";
    
    return $DataList;
}