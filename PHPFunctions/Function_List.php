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

function Lista($LID, $LRows, $IDOption, $ALinks){
    //Info del Form
    global $cnx;
    global $sI, $sII, $sIII, $sIV;
    $ListVar = $cnx->query('SELECT * FROM Lists WHERE IdList = ?', "$LID")->fetchArray();
    //print_r($ListVar);
    
    if($ListVar['Active'] == 1){
        $TituloList = $ListVar['Title'];
        $LWidhList = $ListVar['LWidth'];
        $LSearchList = $ListVar['LSearch'];
        
        //Buscador
        if($LSearchList == 1){
            $FormSearch = "<form action='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=$sIV&search=1' method='post'>"
                    . "<input type='text' class='text' name='search' placeholder='Buscar'>"
                    . "</form>";
            
        }
        
        //*********************************Titulo Lista
        if($TituloList != ""){
            $ListF = "<center><br>"
                . "<font class='Ex' style='color: black;font-size: 2.5em;'>"
                . "$TituloList</font><BR>";
        }
        
        
        //*********************************Formato para Busqueda
        $ListF .= "<div style='width:$LWidhList%;'>"
                . "$FormSearch<BR>"
                . "<table width='100%' cellpaddin='1'>";
        
        
        //*********************************Titulo Columnas
        $ListF .= "<thead><tr>";
        
        //Obtiene las Columnas del List
        $ColsL = $cnx->query('SELECT * FROM ColsL WHERE IdList = ? ORDER BY IdCol ASC', $LID)->fetchAll();
        //print_r($ColsL);
        foreach ($ColsL as $valuesCol) {
            //print_r($valuesCol);
            $ClassCol = $valuesCol['classIn'];
            $classtitcol = "tit_" . $ClassCol;
            $NameCol = $valuesCol['nameIn'];
            $ListF .= "<th class='$classtitcol'>$NameCol</th>";
        }
        
        $ListF .= "</tr></thead>";
        
        
        //*********************************Titulo Columnas
        $ListF .= "<tbody>";
        
        $countRows = 0;
        $colorRow = 0;
        
        //print_r($LRows);
        foreach ($LRows as $vRows) {
            $colorRow++;
            
            switch ($colorRow){
                case 1:
                    $bgColorTD = "white";
                    break;
                case 2:
                    $bgColorTD = "#f7f7f7";
                    $colorRow = 0;
                    break;
            }
            
            
            $countcol = 0;
            $ListF .= "<tr bgcolor='$bgColorTD' onmouseover=\"this.bgColor='#E0ECF8'\" onmouseout=\"this.bgColor='$bgColorTD'\" >";
            foreach ($vRows as $keyCol => $valueCol) {
                //Depende el valor
                $claseL = $ColsL[$countcol]['classIn'];
                //echo "<BR><BR>$keyCol - $IDOption<BR>";
                if($keyCol == $IDOption){
                    $gettoken = base64_encode($valueCol);
                    $ListF .= "<td class='$claseL'>";
                    //Define links
                    foreach ($ALinks as $valLinks) {
                        $Type_L = $valLinks[0];
                        $Size_L = $valLinks[1];
                        $Icon_L = $valLinks[2];
                        $Action_L = $valLinks[3];
                        $Target_L = $valLinks[4];
                        $Title_L = $valLinks[5];
                        
                        $Action_L = $Action_L . "&token=$gettoken";
                        //onclick = 'if (! confirm('Continue?')) { return false; }'
                        
                        switch ($Type_L){
                            case "s_icon":
                                $ListF .= "<a href='$Action_L' target='$Target_L' title='$Title_L $valueCol'><img src='$Icon_L' width='$Size_L' alt='$Title_L $valueCol' title='$Title_L $valueCol' border='0'></a>&nbsp;";
                                break;
                        }
                        
                        
                    }
                    
                    $ListF .= "</td>";
                    //echo "$valueCol - $gettoken<BR>";
                } else {
                    //echo "$valueCol - $gettoken<BR>";
                    //solo para text
                    if($claseL == "col_justify_br"){
                        $valueCol = nl2br($valueCol);
                    }
                    $ListF .= "<td class='$claseL'>";
                    $ListF .= "$valueCol";
                    $ListF .= "</td>";
                }
                $countcol++;
            }
            
            $ListF .= "<tr>";
        }
        
        $ListF .= "</tbody>";
        
        
        $ListF .= "</table>"
                . "</div>"
                . "</center>";
        return $ListF;
    } else {
        //Alerta
        $vATipo = "Rojo";
        $vAMensaje = "Lista Estado Inactivo";
        $vRedirect = "index.php";
        $vATime = 1000;
        //echo $vRedirect;
        echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
    }
    
}
?>