<?php
/**
 * FORM Creation Function 
 * 
 * @param   array           $aGForm         Title, Size, Info, Alert
 * @param   array           $aLinks         Links
 * @param   array           $aFields        Fields
 * @copyright   2021 Software Development MX
 * @license     https://www.softwaredevelopment.mx/license/Func_Form.txt
 * @return string
 */

function drawForm($aGForm, $aLinks, $aFields){
    global $cnx;
    global $sI, $sII, $sIII, $sIV;
    $gextra = "";
    //General Form Data
    $F_Title = $aGForm[0];
    $F_Width = $aGForm[1];
    $F_Info = $aGForm[2];
    $F_Alert = $aGForm[3];
    
    $DataForm = "";
    //Draw DIV
    $DataForm .= "<center><div style='width:$F_Width;'>";
    //Form Title
    $DataForm .= "<center><br>"
                . "<font class='Ex' style='color: black;font-size: 2.5em;'>"
                . "$F_Title</font><BR>";
    $DataForm .= "$F_Alert";
    $DataForm .= "$F_Info";
    //Links
    if(!empty($aLinks)){
        //Links Draw
        $DataForm .= "<div style='text-align:right;'>";
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
                    $DataForm .= "<a "
                        . "title='$L_title' href='$NLink' "
                        . "class='$L_class' target='$L_target' >"
                        . "$L_title"
                        . "</a>&nbsp;&nbsp;";
                    break;
                case "file":
                    break;
                default :
                    $sI_l = $aLinks[$row][5];
                    $sII_l = $aLinks[$row][6];
                    $sIII_l = $aLinks[$row][7];
                    $sIV_l = $aLinks[$row][8];
                    $gettoken = $aLinks[$row][9];
                    $gettokeni = $aLinks[$row][10];
                    $gettokenii = $aLinks[$row][11];
                    $NLink = $getthref . "&" . $sI_l . "&sII=" . $sII_l . "&sIII=" . $sIII_l . "&sIV=" . $sIV_l. "&token=" . $gettoken. "&tokeni=" . $gettokeni. "&tokenii=" . $gettokenii;
                    $DataForm .= "<a "
                        . "title='$L_title' href='$NLink' "
                        . "class='$L_class' target='$L_target' >"
                        . "$L_title"
                        . "</a>&nbsp;&nbsp;";
                    break;
            }

        }
        $DataForm .= "</div>";
        
    }
        
    //Forms
    if(!empty($aFields)){
        //Draw Forms
        for ( $rowx = 0; $rowx < sizeof($aFields); $rowx++ ){
            $F_action = $aFields[$rowx][0];
            $F_label = $aFields[$rowx][1];
            $F_id = $aFields[$rowx][2];
            $F_class = $aFields[$rowx][3];
            $F_tipo = $aFields[$rowx][4];
            $F_name = $aFields[$rowx][5];
            $F_value = $aFields[$rowx][6];
            $F_checked = $aFields[$rowx][7];
            $F_selected = $aFields[$rowx][8];
            $F_focus = $aFields[$rowx][9];
            $F_JFocus = "";

            if($rowx == 0){
                //FData
                $F_form = $F_name;
                $DataForm .= "<form "
                        . "$F_value class='$F_class' id='$F_id' "
                        . "name='$F_name' method='$F_tipo' action='$F_action'>"
                        . "<center><font class='Kohss'>";
            } else {
                //Type Depends
                $DataForm .= "$F_label<BR>";
                switch ($F_tipo){
                    case "textarea":
                        $options = explode("|", $F_value);
                        $count = 0;
                        for ( $selx = 0; $selx < sizeof($options); $selx++ ){
                            if($selx == 0){
                                $gcol = $options[$selx];
                            } else {
                                $grow = $options[$selx];
                            }
                        }

                        $DataForm .= "<$F_tipo cols='$gcol' rows='$grow' name='$F_name' class='$F_class'></$F_tipo><BR>";

                        //Focus
                        if($F_focus == 1){
                            $F_Focusx = $F_name;
                        }
                        break;
                    case "select":
                        $DataForm .= "<$F_tipo name='$F_name' class='$F_class'>";
                        //Options
                        $options = explode("|", $F_value);
                        for ( $selx = 0; $selx < sizeof($options); $selx++ ){
                            $getoption = explode(":", $options[$selx]);
                            $getval = $getoption[0];
                            $gettitval = $getoption[1];
                            if($gettitval == ""){
                                $gettitval = $getval;
                            }
                            //echo "$getval - $F_selected<BR>";
                            $sel = "";
                            //Para seleccionar
                            if($getval == $F_selected){
                                $sel = "selected='selected'";
                            }

                            $DataForm .= "<option value='$getval' $sel>$gettitval</option>";
                        }

                        $DataForm .= "</$F_tipo><BR>";
                        //Focus
                        if($F_focus == 1){
                            $F_Focusx = $F_name;
                        }
                        break;
                    case "checkbox":
                        $DataForm .= "<div style='text-align: justify; width: 60%;'>";
                        $options = explode("|", $F_value);
                        for ( $selx = 0; $selx < sizeof($options); $selx++ ){
                            $getoption = $options[$selx];
                            $option = explode(":", $getoption);
                            $var = $option[0];
                            $texto = $option[1];
                            //Data
                            $DataForm .= "<input type='$F_tipo' value='OK' name='$var'>$texto<BR>";
                        }
                        $DataForm .= "</div><BR>";
                        //Focus
                        if($F_focus == 1){
                            $F_Focusx = $F_name;
                        }
                        break;
                    default:
                        //Solo number
                        if($F_tipo == "number"){
                            $gextra = " step='any' ";
                        }

                        $DataForm .= "<input name='$F_name' type='$F_tipo' value='$F_value' class='$F_class' $F_selected $gextra><br>";
                        //Focus
                        if($F_focus == 1){
                            $F_Focusx = $F_name;
                        }
                        break;
                }


            }


        }
        $DataForm .= "<br><br><input type='submit' value='Accept' class='subm'><br>";
        $DataForm .= "</font></center></form>";
        $DataForm .= "<script language='javascript' type='text/javascript'>"
            . "document.$F_form.$F_Focusx.focus();"
            . "</script>";

    }
        
        
    $DataForm .= "</center></div>";
    
    return $DataForm;
    
}

?>
