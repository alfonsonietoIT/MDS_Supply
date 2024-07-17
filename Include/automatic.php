<?php
/*
 * $tipo = "";title="";
 */

//echo $tipo;
//echo "aqui";
switch ($tipo){
    case "form_file":
        ?>
        <br>
        <div id="<?php echo $classid;?>">
            <div id="inbox_t">
		<font class="rojo"><?php echo $title;?></font>
            </div>
            <?php 
            //*********************************************************Links extras
            //echo sizeof($links);
            //print_r($links);
            
            if(sizeof($links) > 0){
                //Desplega los lins
                ?>
            <div style="text-align:right;">
                <?php
                for ( $row = 0; $row < sizeof($links); $row++ ){
                    $getclass = $links[$row][3];
                    $gettarget = $links[$row][2];
                    $gettitle = $links[$row][1];
                    $getthref = $links[$row][0];
                    
                    switch ($getthref){
                        case "index.php?select=loginv":
                        case "index.php?select=viewpro":
                            $s2_l = $links[$row][6];
                            $s3_l = $links[$row][7];
                            $s4_l = $links[$row][8];
                            $gettoken = $links[$row][9];
                            $gettokeni = $links[$row][10];
                            $gettokenii = $links[$row][11];
                            
                            $gethref = $getthref . "&s2=" . $s2_l . "&s3=" . $s3_l . "&s4=" . $s4_l. "&token=" . $gettoken. "&tokeni=" . $gettokeni. "&tokenii=" . $gettokenii;
                            break;
                        case "reporte_Xls.php?":
                            $reporte = $links[$row][6];
                            $s3_l = $links[$row][7];
                            $s4_l = $links[$row][8];
                            $gettoken = $links[$row][9];
                            $gettokeni = $links[$row][10];
                            $gettokenii = $links[$row][11];
                            
                            $gethref = $getthref . "&reporte=" . $reporte . "&s3=" . $s3_l . "&s4=" . $s4_l . "&token=" . $gettoken. "&tokeni=" . $gettokeni. "&tokenii=" . $gettokeni;
                            break;
                    }
                    
                    ?>
                    <a <?php if($getclass != "") { ?> class="<?php echo $getclass;?>" <?php }?> <?php if($gettarget != "") { ?> target="<?php echo $gettarget;?>" <?php }?> <?php if($gettitle != "") { ?> title="<?php echo $gettitle;?>" <?php }?> href="<?php echo $gethref;?>"><?php echo $gettitle;?></a>
                    <?php
                    
                //echo '|<br />';
                }
                ?>
                &nbsp;&nbsp;
                <!--<div style="text-align:right;">
                <!--<a class="link" target="_blank" title="Descargar" href="reporte_Xls.php?reporte=ginfprosystem&status=<?php echo base64_encode("PAC");?>">Descargar TarRMA</a>
                <a class="link" title="Relocacionar Box FF" href="index.php?select=loginv&s2=rmas&s3=full&s4=reloc">(&Sqrt;) Cambiar Loc Box FF</a>
                <a class="link" title="Agregar BOX Tarima RMA" href="index.php?select=loginv&s2=produccion&s3=tarrma&s4=agregarbox&tarima=<?php echo $gtarrma;?>">(+) Agregar BOX</a>&nbsp;&nbsp;
            </div>-->
            </div>
            <?php
            //*********************************************************Links extras
            
            }
            
            ?>
            <div id="inbox_t">
                <?php
                //$varg = base64_encode("mmd1xorden");
                //Depende el mensaje
                if($messgood != ""){
                    ?>
		<div id="messok">
		<?php echo $messgood;?>
                </div>
                <?php
		}
    	
                //Depende el mensaje
                if($messerror != ""){
                    ?>
                <div id="messno">
                <?php echo $messerror;?>
                </div>
                <?php
                }
                
                //Empieza el automatico
                
                //Empieza el automatico
                //*********************************************************INFO
                if($info != ""){
                    echo $info;
                }
                
                //*********************************************************INFO
                
                
                //*********************************************************LIST
                if(sizeof($columnas) > 0){
                    //Entonces muestra
                    $sizetab = sizeof($columnas);
                    ?>
                <center>
                <table width="100%">
                    <?php
                    $contr = 0;
                    for ( $rowx = 0; $rowx < sizeof($columnas); $rowx++ ){
                        //print_r($columnas[$rowx]);
                        //echo sizeof($columnas[$rowx]);
                        
                        for ( $colx = 0; $colx < sizeof($columnas[$rowx]); $colx++ ){
                            //Depenede ColorRow, ClassRow, ClasCol1, Col1,  ...!
                            //echo $colx . "<br>";
                            //echo $columnas[$rowx][$colx] . "<br>";
                            switch ($colx){
                                case 0:
                                    $tr_color = $columnas[$rowx][$colx];
                                    break;
                                case 1:
                                    $tr_class = $columnas[$rowx][$colx];
                                    break;
                                default :
                                    if($contr == 0){
                                        $contr++;
                                        ?>
                    <tr 
                    <?php 
                    if($tr_class != "") {
                        ?>
                        class = "<?php echo $tr_class;?>"; 
                        <?php 
                        
                    }
                    
                    if($tr_color != ""){
                        ?>
                        bgcolor="<?php echo $tr_color;?>" onmouseover="this.bgColor='#E0ECF8'" onmouseout="this.bgColor='<?php echo $tr_color;?>'"
                        <?php
                    } 
                    ?>
                        
                    >                
                    <?php
                                    }
                                    
                                    //Cada columna
                                    if($colx & 1){
                                        //echo 'Even number!';
                                        $td_value = $columnas[$rowx][$colx];
                                        ?>
                            <font class="negross"><?php echo $td_value;?></font>
                        </td>
                                        <?php
                                    }else{
                                        //echo 'Odd number!';
                                        $td_class = $columnas[$rowx][$colx];
                                        ?>
                        <td class="<?php echo $td_class;?>">                
                                        <?php
                                    }
                                    break;
                            }
                        }
                        
                    $contr = 0;
                    ?>
                    </tr>
                    <?php
                    }
                    ?>
                </table>
                </center>
                <?php
                    
                }
                
                
                
                
                
                //*********************************************************LIST
                
                
                //*********************************************************FORM
                if(sizeof($campos) > 0){
                    //Entonces muestra
                    $sizetab = sizeof($campos);
                    
                    
                    $contr = 0;
                    for ( $rowx = 0; $rowx < sizeof($campos); $rowx++ ){
                        //print_r($columnas[$rowx]);
                        //echo sizeof($columnas[$rowx]);
                        $getaction = $campos[$rowx][0];
                        $getlabel = $campos[$rowx][1];
                        $getid = $campos[$rowx][2];
                        $getclass = $campos[$rowx][3];
                        $gettipo = $campos[$rowx][4];
                        $getname = $campos[$rowx][5];
                        $getvalue = $campos[$rowx][6];
                        $getchecked = $campos[$rowx][7];
                        $getselected = $campos[$rowx][8];
                        $getfocus = $campos[$rowx][9];
                        
                        //echo $getselected;
                        switch ($rowx){
                            case 0:
                                
                                ?>
                <form class="<?php echo $getclass;?>" id="<?php echo $getid;?>" name="<?php echo $getname;?>" method="<?php echo $gettipo;?>" action="<?php echo $getaction;?>" enctype="multipart/form-data">
                    <center>
                        <font class="negros">
                                <?php
                                break;
                            default :
                                ?>
                        <br>
                        <?php echo $getlabel;?><br>
                                <?php
                                //echo $gettipo;
                                switch ($gettipo){
                                    case "select":
                                        ?>
                        <select <?php if($getfocus == 1) { ?> autofocus="autofocus" <?php } ?> name="<?php echo $getname;?>" class="<?php echo $getclass;?>">
                            <?php
                            $options = explode("|", $getvalue);
                            for ( $selx = 0; $selx < sizeof($options); $selx++ ){
                                $getoption = $options[$selx];
                                ?>
                            <option value="<?php echo $getoption;?>" <?php if($getoption == $getselected) { ?> selected="selected" <?php }?> ><?php echo $getoption;?></option>
                            <?php
                            }
                            
                            ?>
                        </select>
                        <br>
                                        <?php
                                        break;
                                    case "textarea":
                                        $options = explode("|", $getvalue);
                                        $count = 0;
                                        for ( $selx = 0; $selx < sizeof($options); $selx++ ){
                                            //$count++;
                                            if($selx == 0){
                                                $gcol = $options[$selx];
                                            } else {
                                                $grow = $options[$selx];
                                            }
                                            
                                            
                                        }
 
                                        ?>
                        <textarea cols="<?php echo $gcol;?>" rows="<?php echo $grow;?>" <?php if($getfocus == 1) { ?> autofocus="autofocus" <?php } ?> name="<?php echo $getname;?>" class="<?php echo $getclass;?>"></textarea>
                        <br>
                                        <?php
                                        break;
                                    default:
                                        //solo number
                                        if($gettipo == "number"){
                                            $gextra = " step='any' ";
                                        }
                                        
                                        ?>
                        <input <?php if($getfocus == 1) { ?> autofocus="autofocus" <?php } ?> name="<?php echo $getname;?>" type="<?php echo $gettipo;?>" <?php echo $gextra;?> class="<?php echo $getclass;?>">
                        <br>
                                        <?php
                                        break;
                                }
                                
                                
                                break;
                        }
                        
                    $contr = 0;
                    }
                    ?>
                    <br><br>
                    <input type="submit" value="Siguiente >" class="subm">
                    <br><br>
                    </font>
                    </center>
                    </form>
                    <?php
                }
                
                
                
                
                
                //*********************************************************FORM
                
                
                
                ?>
                
            </div>
            
        </div>
        <?php
        break;
    case "form_mix":
        ?>
        <br>
        <div id="<?php echo $classid;?>">
            <div id="inbox_t">
		<font class="rojo"><?php echo $title;?></font>
            </div>
            <?php 
            //*********************************************************Links extras
            //echo sizeof($links);
            //print_r($links);
            
            if(sizeof($links) > 0){
                //Desplega los lins
                ?>
            <div style="text-align:right;">
                <?php
                for ( $row = 0; $row < sizeof($links); $row++ ){
                    $getclass = $links[$row][3];
                    $gettarget = $links[$row][2];
                    $gettitle = $links[$row][1];
                    $getthref = $links[$row][0];
                    //echo $getthref;
                    switch ($getthref){
                        case "index.php?select=loginv":
                        case "index.php?select=viewpro":
                            $s2_l = $links[$row][6];
                            $s3_l = $links[$row][7];
                            $s4_l = $links[$row][8];
                            $gettoken = $links[$row][9];
                            $gettokeni = $links[$row][10];
                            $gettokenii = $links[$row][11];
                            
                            $gethref = $getthref . "&s2=" . $s2_l . "&s3=" . $s3_l . "&s4=" . $s4_l. "&token=" . $gettoken. "&tokeni=" . $gettokeni. "&tokenii=" . $gettokenii;
                            break;
                        case "reporte_Xls.php?":
                            $reporte = $links[$row][6];
                            $s3_l = $links[$row][7];
                            $s4_l = $links[$row][8];
                            $gettoken = $links[$row][9];
                            $gettokeni = $links[$row][10];
                            $gettokenii = $links[$row][11];
                            
                            $gethref = $getthref . "&reporte=" . $reporte . "&s3=" . $s3_l . "&s4=" . $s4_l . "&token=" . $gettoken. "&tokeni=" . $gettokeni. "&tokenii=" . $gettokeni;
                            break;
                        case "href":
                            $href = $links[$row][6];
                            $s3_l = $links[$row][7];
                            $s4_l = $links[$row][8];
                            $gettoken = $links[$row][9];
                            $gettokeni = $links[$row][10];
                            $gettokenii = $links[$row][11];

                            $gethref = $href;
                            break;
                    }
                    
                    ?>
                    <a <?php if($getclass != "") { ?> class="<?php echo $getclass;?>" <?php }?> <?php if($gettarget != "") { ?> target="<?php echo $gettarget;?>" <?php }?> <?php if($gettitle != "") { ?> title="<?php echo $gettitle;?>" <?php }?> href="<?php echo $gethref;?>"><?php echo $gettitle;?></a>
                    <?php
                    
                //echo '|<br />';
                }
                ?>
                &nbsp;&nbsp;
                <!--<div style="text-align:right;">
                <!--<a class="link" target="_blank" title="Descargar" href="reporte_Xls.php?reporte=ginfprosystem&status=<?php echo base64_encode("PAC");?>">Descargar TarRMA</a>
                <a class="link" title="Relocacionar Box FF" href="index.php?select=loginv&s2=rmas&s3=full&s4=reloc">(&Sqrt;) Cambiar Loc Box FF</a>
                <a class="link" title="Agregar BOX Tarima RMA" href="index.php?select=loginv&s2=produccion&s3=tarrma&s4=agregarbox&tarima=<?php echo $gtarrma;?>">(+) Agregar BOX</a>&nbsp;&nbsp;
            </div>-->
            </div>
            <?php
            
            
            }
            //*********************************************************Links extras
            
            
            ?>
            <div id="inbox_t">
                <?php
                //$varg = base64_encode("mmd1xorden");
                //Depende el mensaje
                if($messgood != ""){
                    ?>
		<div id="messok">
		<?php echo $messgood;?>
                </div>
                <?php
		}
    	
                //Depende el mensaje
                if($messerror != ""){
                    ?>
                <div id="messno">
                <?php echo $messerror;?>
                </div>
                <?php
                }
                
                //Empieza el automatico
                //*********************************************************INFO
                if($info != ""){
                    echo $info;
                }
                
                //*********************************************************INFO
                
                //*********************************************************FORM
                if(sizeof($campos) > 0){
                    //Entonces muestra
                    $sizetab = sizeof($campos);
                    
                    
                    $contr = 0;
                    for ( $rowx = 0; $rowx < sizeof($campos); $rowx++ ){
                        //print_r($columnas[$rowx]);
                        //echo sizeof($columnas[$rowx]);
                        $getaction = $campos[$rowx][0];
                        $getlabel = $campos[$rowx][1];
                        $getid = $campos[$rowx][2];
                        $getclass = $campos[$rowx][3];
                        $gettipo = $campos[$rowx][4];
                        $getname = $campos[$rowx][5];
                        $getvalue = $campos[$rowx][6];
                        $getchecked = $campos[$rowx][7];
                        $getselected = $campos[$rowx][8];
                        $getfocus = $campos[$rowx][9];
                        
                        //echo "Va:" . $gettipo . "<br>";
                        
                        
                        switch ($rowx){
                            case 0:
                                $getform = $getname;
                                
                                ?>
                    <form class="<?php echo $getclass;?>" id="<?php echo $getid;?>" name="<?php echo $getname;?>" method="<?php echo $gettipo;?>" action="<?php echo $getaction;?>">
                    <center>
                        <font class="negros">
                                <?php
                                break;
                            default :
                                ?>
                        <br>
                        <?php echo $getlabel;?><br>
                                <?php
                                //echo $gettipo;
                                switch ($gettipo){
                                    case "select":
                                        if($getfocus == 1){
                                            $jav_foc = "<script language='javascript' type='text/javascript'>"
                                                    . "document.$getform.$getname.focus();"
                                                    . "</script>";
                                        }
                                        ?>
                        <select <?php if($getfocus == 1) { ?> autofocus="autofocus" <?php } ?> name="<?php echo $getname;?>" class="<?php echo $getclass;?>">
                            <?php
                            $options = explode("|", $getvalue);
                            for ( $selx = 0; $selx < sizeof($options); $selx++ ){
                                $getoption = $options[$selx];
                                ?>
                            <option value="<?php echo $getoption;?>" <?php if($getoption == $getselected) { ?> selected="selected" <?php }?> ><?php echo $getoption;?></option>
                            <?php
                            }
                            
                            ?>
                        </select>
                        <br>
                                        <?php
                                        break;
                                    case "textarea":
                                        if($getfocus == 1){
                                            $jav_foc = "<script language='javascript' type='text/javascript'>"
                                                    . "document.$getform.$getname.focus();"
                                                    . "</script>";
                                        }
                                        $options = explode("|", $getvalue);
                                        $count = 0;
                                        for ( $selx = 0; $selx < sizeof($options); $selx++ ){
                                            $count++;
                                            if($count == 1){
                                                $gcol = $options[$selx];
                                            } else {
                                                $grow = $options[$selx];
                                            }
                                            
                                            
                                        }
 
                                        ?>
                        <textarea cols="<?php echo $gcol;?>" rows="<?php echo $grow;?>" <?php if($getfocus == 1) { ?> autofocus="autofocus" <?php } ?> name="<?php echo $getname;?>" class="<?php echo $getclass;?>"></textarea>
                        <br>
                                        <?php
                                        break;
                                    default:
                                        if($getfocus == 1){
                                            $jav_foc = "<script language='javascript' type='text/javascript'>"
                                                    . "document.$getform.$getname.focus();"
                                                    . "</script>";
                                        }
                                        //solo number
                                        if($gettipo == "number"){
                                            $gextra = " step='any' ";
                                        }
                                        ?>
                        <input <?php if($getfocus == 1) { ?> autofocus="autofocus" <?php } ?> name="<?php echo $getname;?>" type="<?php echo $gettipo;?>" <?php echo $gextra;?> class="<?php echo $getclass;?>">
                        <br>
                                        <?php
                                        break;
                                }
                                
                                
                                break;
                        }
                        
                    $contr = 0;
                    }
                    ?>
                    <input type="submit" value="Siguiente >">
                    <br><br>
                    </font>
                    </center>
                    </form>
                    <?php
                    echo $jav_foc;
                    
                }
                
                
                
                
                
                //*********************************************************FORM
                
                
                //*********************************************************Links Grandes
                //echo sizeof($links);
                //print_r($links);
            
                if(sizeof($links_b) > 0){
                    //echo "aqui";
                    //Desplega los lins
                    for ( $row2 = 0; $row2 < sizeof($links_b); $row2++ ){
                        $getclass2 = $links_b[$row2][3];
                        $gettarget2 = $links_b[$row2][2];
                        $gettitle2 = $links_b[$row2][1];
                        $getthref2 = $links_b[$row2][0];
                    
                        switch ($getthref2){
                            case "index.php?select=loginv":
                            case "index.php?select=viewpro":
                                $s2_l = $links_b[$row2][6];
                                $s3_l = $links_b[$row2][7];
                                $s4_l = $links_b[$row2][8];
                                $gettoken = $links_b[$row2][9];
                                $gettokeni = $links_b[$row2][10];
                                $gettokenii = $links_b[$row2][11];
                            
                                $gethref2 = $getthref2 . "&s2=" . $s2_l . "&s3=" . $s3_l . "&s4=" . $s4_l. "&token=" . $gettoken. "&tokeni=" . $gettokeni. "&tokenii=" . $gettokenii;
                                break;
                            case "reporte_Xls.php?":
                                $reporte = $links_b[$row][6];
                                $s3_l = $links_b[$row2][7];
                                $s4_l = $links_b[$row2][8];
                                $gettoken = $links_b[$row2][9];
                                $gettokeni = $links_b[$row2][10];
                                $gettokenii = $links_b[$row2][11];
                            
                                $gethref2 = $getthref2 . "&reporte=" . $reporte . "&s3=" . $s3_l . "&s4=" . $s4_l . "&token=" . $gettoken. "&tokeni=" . $gettokeni. "&tokenii=" . $gettokeni;
                                break;
                            case "href":
                                $href = $links_b[$row2][6];
                                $s3_l = $links_b[$row2][7];
                                $s4_l = $links_b[$row2][8];
                                $gettoken = $links_b[$row2][9];
                                $gettokeni = $links_b[$row2][10];
                                $gettokenii = $links_b[$row2][11];
                            
                                $gethref2 = $href;
                                break;
                        }
                    
                        ?>
                        <br>
                        <a <?php if($getclass2 != "") { ?> class="<?php echo $getclass2;?>" <?php }?> <?php if($gettarget2 != "") { ?> target="<?php echo $gettarget2;?>" <?php }?> <?php if($gettitle2 != "") { ?> title="<?php echo $gettitle2;?>" <?php }?> href="<?php echo $gethref2;?>"><?php echo $gettitle2;?></a>
                        <br><br>
                        <?php
                    
                //echo '|<br />';
                    }
                }
                //*********************************************************Links extras
            
                
                
                //*********************************************************LIST
                if(sizeof($columnas) > 0){
                    //Entonces muestra
                    $sizetab = sizeof($columnas);
                    ?>
                <table width="98%">
                    <?php
                    $contr = 0;
                    for ( $rowx = 0; $rowx < sizeof($columnas); $rowx++ ){
                        //print_r($columnas[$rowx]);
                        //echo sizeof($columnas[$rowx]);
                        
                        for ( $colx = 0; $colx < sizeof($columnas[$rowx]); $colx++ ){
                            //Depenede ColorRow, ClassRow, ClasCol1, Col1,  ...!
                            //echo $colx . "<br>";
                            //echo $columnas[$rowx][$colx] . "<br>";
                            switch ($colx){
                                case 0:
                                    $tr_color = $columnas[$rowx][$colx];
                                    break;
                                case 1:
                                    $tr_class = $columnas[$rowx][$colx];
                                    break;
                                default :
                                    if($contr == 0){
                                        $contr++;
                                        ?>
                    <tr 
                    <?php 
                    if($tr_class != "") {
                        ?>
                        class = "<?php echo $tr_class;?>"; 
                        <?php 
                        
                    }
                    
                    if($tr_color != ""){
                        ?>
                        bgcolor="<?php echo $tr_color;?>" onmouseover="this.bgColor='#E0ECF8'" onmouseout="this.bgColor='<?php echo $tr_color;?>'"
                        <?php
                    } 
                    ?>
                        
                    >                
                    <?php
                                    }
                                    
                                    //Cada columna
                                    if($colx & 1){
                                        //echo 'Even number!';
                                        $td_value = $columnas[$rowx][$colx];
                                        ?>
                            <font class="negross"><?php echo $td_value;?></font>
                        </td>
                                        <?php
                                    }else{
                                        //echo 'Odd number!';
                                        $td_class = $columnas[$rowx][$colx];
                                        ?>
                        <td class="<?php echo $td_class;?>">                
                                        <?php
                                    }
                                    break;
                            }
                        }
                        
                    $contr = 0;
                    ?>
                    </tr>
                    <?php
                    }
                    ?>
                </table>
                <?php
                    
                }
                
                
                
                
                
                //*********************************************************LIST
                
                
                
                ?>
                
            </div>
            
        </div>
        <?php
        break;
    case "form":
        ?>
        <br>
        <div id="<?php echo $classid;?>">
            <div id="inbox_t">
		<font class="rojo"><?php echo $title;?></font>
            </div>
            <?php 
            //*********************************************************Links extras
            //echo sizeof($links);
            //print_r($links);
            
            if(sizeof($links) > 0){
                //Desplega los lins
                ?>
            <div style="text-align:right;">
                <?php
                for ( $row = 0; $row < sizeof($links); $row++ ){
                    $getclass = $links[$row][3];
                    $gettarget = $links[$row][2];
                    $gettitle = $links[$row][1];
                    $getthref = $links[$row][0];
                    
                    switch ($getthref){
                        case "index.php?select=loginv":
                        case "index.php?select=viewpro":
                            $s2_l = $links[$row][6];
                            $s3_l = $links[$row][7];
                            $s4_l = $links[$row][8];
                            $gettoken = $links[$row][9];
                            $gettokeni = $links[$row][10];
                            $gettokenii = $links[$row][11];
                            
                            $gethref = $getthref . "&s2=" . $s2_l . "&s3=" . $s3_l . "&s4=" . $s4_l. "&token=" . $gettoken. "&tokeni=" . $gettokeni. "&tokenii=" . $gettokenii;
                            break;
                        case "reporte_Xls.php?":
                            $reporte = $links[$row][6];
                            $s3_l = $links[$row][7];
                            $s4_l = $links[$row][8];
                            $gettoken = $links[$row][9];
                            $gettokeni = $links[$row][10];
                            $gettokenii = $links[$row][11];
                            
                            $gethref = $getthref . "&reporte=" . $reporte . "&s3=" . $s3_l . "&s4=" . $s4_l . "&token=" . $gettoken. "&tokeni=" . $gettokeni. "&tokenii=" . $gettokeni;
                            break;
                    }
                    
                    ?>
                    <a <?php if($getclass != "") { ?> class="<?php echo $getclass;?>" <?php }?> <?php if($gettarget != "") { ?> target="<?php echo $gettarget;?>" <?php }?> <?php if($gettitle != "") { ?> title="<?php echo $gettitle;?>" <?php }?> href="<?php echo $gethref;?>"><?php echo $gettitle;?></a>
                    <?php
                    
                //echo '|<br />';
                }
                ?>
                &nbsp;&nbsp;
                <!--<div style="text-align:right;">
                <!--<a class="link" target="_blank" title="Descargar" href="reporte_Xls.php?reporte=ginfprosystem&status=<?php echo base64_encode("PAC");?>">Descargar TarRMA</a>
                <a class="link" title="Relocacionar Box FF" href="index.php?select=loginv&s2=rmas&s3=full&s4=reloc">(&Sqrt;) Cambiar Loc Box FF</a>
                <a class="link" title="Agregar BOX Tarima RMA" href="index.php?select=loginv&s2=produccion&s3=tarrma&s4=agregarbox&tarima=<?php echo $gtarrma;?>">(+) Agregar BOX</a>&nbsp;&nbsp;
            </div>-->
            </div>
            <?php
            //*********************************************************Links Grandes
                
            //*********************************************************Links extras
            
            }
            
            ?>
            <div id="inbox_t">
                <?php
                //$varg = base64_encode("mmd1xorden");
                //Depende el mensaje
                if($messgood != ""){
                    ?>
		<div id="messok">
		<?php echo $messgood;?>
                </div>
                <?php
		}
    	
                //Depende el mensaje
                if($messerror != ""){
                    ?>
                <div id="messno">
                <?php echo $messerror;?>
                </div>
                <?php
                }
                
                //Empieza el automatico
                //echo sizeof($links);
                //print_r($links_b);
            
                if(sizeof($links_b) > 0){
                    //echo "aqui";
                    //Desplega los lins
                    for ( $row2 = 0; $row2 < sizeof($links_b); $row2++ ){
                        $getclass2 = $links_b[$row2][3];
                        $gettarget2 = $links_b[$row2][2];
                        $gettitle2 = $links_b[$row2][1];
                        $getthref2 = $links_b[$row2][0];
                    
                        switch ($getthref2){
                            case "index.php?select=loginv":
                            case "index.php?select=viewpro":
                                $s2_l = $links_b[$row2][6];
                                $s3_l = $links_b[$row2][7];
                                $s4_l = $links_b[$row2][8];
                                $gettoken = $links_b[$row2][9];
                                $gettokeni = $links_b[$row2][10];
                                $gettokenii = $links_b[$row2][11];
                            
                                $gethref2 = $getthref2 . "&s2=" . $s2_l . "&s3=" . $s3_l . "&s4=" . $s4_l. "&token=" . $gettoken. "&tokeni=" . $gettokeni. "&tokenii=" . $gettokenii;
                                break;
                            case "reporte_Xls.php?":
                                $reporte = $links_b[$row2][6];
                                $s3_l = $links_b[$row2][7];
                                $s4_l = $links_b[$row2][8];
                                $gettoken = $links_b[$row2][9];
                                $gettokeni = $links_b[$row2][10];
                                $gettokenii = $links_b[$row2][11];
                            
                                $gethref2 = $getthref2 . "&reporte=" . $reporte . "&s3=" . $s3_l . "&s4=" . $s4_l . "&token=" . $gettoken. "&tokeni=" . $gettokeni. "&tokenii=" . $gettokeni;
                                break;
                            case "href":
                                $href = $links_b[$row2][6];
                                $s3_l = $links_b[$row2][7];
                                $s4_l = $links_b[$row2][8];
                                $gettoken = $links_b[$row2][9];
                                $gettokeni = $links_b[$row2][10];
                                $gettokenii = $links_b[$row2][11];
                            
                                $gethref2 = $href;
                                break;
                        }
                    
                        ?>
                        <br>
                        <a <?php if($getclass2 != "") { ?> class="<?php echo $getclass2;?>" <?php }?> <?php if($gettarget2 != "") { ?> target="<?php echo $gettarget2;?>" <?php }?> <?php if($gettitle2 != "") { ?> title="<?php echo $gettitle2;?>" <?php }?> href="<?php echo $gethref2;?>"><?php echo $gettitle2;?></a>
                        <br><br>
                        <?php
                    
                //echo '|<br />';
                    }
                }
                
                
                //Empieza el automatico
                //*********************************************************INFO
                if($info != ""){
                    echo $info;
                }
                
                //*********************************************************INFO
                
                //*********************************************************LIST
                if(sizeof($campos) > 0){
                    //Entonces muestra
                    $sizetab = sizeof($campos);
                    
                    
                    $contr = 0;
                    for ( $rowx = 0; $rowx < sizeof($campos); $rowx++ ){
                        //print_r($columnas[$rowx]);
                        //echo sizeof($columnas[$rowx]);
                        $getaction = $campos[$rowx][0];
                        $getlabel = $campos[$rowx][1];
                        $getid = $campos[$rowx][2];
                        $getclass = $campos[$rowx][3];
                        $gettipo = $campos[$rowx][4];
                        $getname = $campos[$rowx][5];
                        $getvalue = $campos[$rowx][6];
                        $getchecked = $campos[$rowx][7];
                        $getselected = $campos[$rowx][8];
                        $getfocus = $campos[$rowx][9];
                        
                        //echo $getselected;
                        switch ($rowx){
                            case 0:
                                $getform = $getname;
                                ?>
                    <form <?php echo $getvalue;?> class="<?php echo $getclass;?>" id="<?php echo $getid;?>" name="<?php echo $getname;?>" method="<?php echo $gettipo;?>" action="<?php echo $getaction;?>">
                    <center>
                        <font class="negros">
                                <?php
                                break;
                            default :
                                ?>
                        <br>
                        <?php echo $getlabel;?><br>
                                <?php
                                switch ($gettipo){
                                    case "checkbox":
                                        if($getfocus == 1){
                                            $jav_foc = "<script language='javascript' type='text/javascript'>"
                                                    . "document.$getform.$getname.focus();"
                                                    . "</script>";
                                        }
                                        ?>
                        <div style=" text-align: justify; width: 60%;">
                                        <?php
                                        $options = explode("|", $getvalue);
                                        for ( $selx = 0; $selx < sizeof($options); $selx++ ){
                                            $getoption = $options[$selx];
                                            $option = explode(":", $getoption);
                                            $var = $option[0];
                                            $texto = $option[1];
                                        ?>   
                        <input type="checkbox" value="OK" name="<?php echo $var;?>"><?php echo $texto;?><br>
                                        <?php    
                                        }
                                        ?>
                        </div>
                                        <?php
                                        break;
                                    case "select":
                                        if($getfocus == 1){
                                            $jav_foc = "<script language='javascript' type='text/javascript'>"
                                                    . "document.$getform.$getname.focus();"
                                                    . "</script>";
                                        }
                                        
                                        ?>
                        <select <?php if($getfocus == 1) { ?> autofocus="autofocus" <?php } ?> name="<?php echo $getname;?>" class="<?php echo $getclass;?>">
                            <?php
                            $options = explode("|", $getvalue);
                            for ( $selx = 0; $selx < sizeof($options); $selx++ ){
                                $getoption = explode(":", $options[$selx]);
                                $getval = $getoption[0];
                                $gettitval = $getoption[1];
                                if($gettitval == ""){
                                    $gettitval = $getval;
                                }
                                
                                
                                ?>
                            <option value="<?php echo $getval;?>" <?php if($getval == $getselected) { ?> selected="selected" <?php }?> ><?php echo $gettitval;?></option>
                            <?php
                            }
                            
                            ?>
                        </select>
                        <br>
                                        <?php
                                        break;
                                    case "textarea":
                                        $options = explode("|", $getvalue);
                                        $count = 0;
                                        for ( $selx = 0; $selx < sizeof($options); $selx++ ){
                                            //$count++;
                                            //echo $selx . "<br>";
                                            
                                            if($selx == 0){
                                                $gcol = $options[$selx];
                                            } else {
                                                $grow = $options[$selx];
                                            }
                                            
                                            
                                        }
 
                                        if($getfocus == 1){
                                            $jav_foc = "<script language='javascript' type='text/javascript'>"
                                                    . "document.$getform.$getname.focus();"
                                                    . "</script>";
                                        }
                                        
                                        ?>
                        <textarea cols="<?php echo $gcol;?>" rows="<?php echo $grow;?>" <?php if($getfocus == 1) { ?> autofocus="autofocus" <?php } ?> name="<?php echo $getname;?>" class="<?php echo $getclass;?>"></textarea>
                        <br>
                                        <?php
                                        break;
                                    default:
                                        //solo number
                                        if($gettipo == "number"){
                                            $gextra = " step='any' ";
                                        }
                                        
                                        if($getfocus == 1){
                                            $jav_foc = "<script language='javascript' type='text/javascript'>"
                                                    . "document.$getform.$getname.focus();"
                                                    . "</script>";
                                        }
                                        
                                        ?>
                        <input <?php if($getfocus == 1) { ?> autofocus="autofocus" <?php } ?> name="<?php echo $getname;?>" type="<?php echo $gettipo;?>" value="<?php echo $getvalue;?>" <?php if($getselected != "") { echo $getselected;}?> <?php echo $gextra;?> class="<?php echo $getclass;?>">
                        <br>
                                        <?php
                                        break;
                                }
                                
                                
                                break;
                        }
                        
                    $contr = 0;
                    }
                    ?>
                    <br><br>
                    <input type="submit" value="Siguiente >" class="subm">
                    <br><br>
                    </font>
                    </center>
                    </form>
                    <?php
                    
                    echo $jav_foc;
                }
                
                
                
                
                
                //*********************************************************LIST
                
                
                
                ?>
                
            </div>
            
        </div>
        <?php
        break;
    case "list":
        
	?>
        <center>
        <div style='width: <?php echo $Width;?>;border: 1px solid black;'>
            <?php
            $ListF = "<center><br>"
                . "<font class='Ex' style='color: black;font-size: 2.5em;'>"
                . "$TituloList</font><BR>";
            
            echo $ListF;
            //*********************************************************Links extras
            //echo sizeof($links);
            //print_r($links);
            
            if(sizeof($links) > 0){
                //Desplega los lins
                ?>
            <div style="text-align:right;">
                <?php
                for ( $row = 0; $row < sizeof($links); $row++ ){
                    $getclass = $links[$row][3];
                    $gettarget = $links[$row][2];
                    $gettitle = $links[$row][1];
                    $getthref = $links[$row][0];
                    
                    switch ($getthref){
                        case "index.php?":
                        case "index.php?":
                            $sI_l = $links[$row][5];
                            $sII_l = $links[$row][6];
                            $sIII_l = $links[$row][7];
                            $sIV_l = $links[$row][8];
                            $gettoken = $links[$row][9];
                            $gettokeni = $links[$row][10];
                            $gettokenii = $links[$row][11];
                            
                            $gethref = $getthref . "sI=" . $sI_l . "&sII=" . $sII_l . "&sIII=" . $sIII_l . "&sIV=" . $sIV_l. "&token=" . $gettoken. "&tokeni=" . $gettokeni. "&tokenii=" . $gettokenii;
                            break;
                        case "reporte_Xls.php?":
                            $reporte = $links[$row][6];
                            $s3_l = $links[$row][7];
                            $s4_l = $links[$row][8];
                            $gettoken = $links[$row][9];
                            $gettokeni = $links[$row][10];
                            $gettokenii = $links[$row][11];
                            
                            $gethref = $getthref . "&reporte=" . $reporte . "&s3=" . $s3_l . "&s4=" . $s4_l . "&token=" . $gettoken. "&tokeni=" . $gettokeni. "&tokenii=" . $gettokeni;
                            break;
                        case "href":
                            $href = $links[$row][6];
                            $s3_l = $links[$row][7];
                            $s4_l = $links[$row][8];
                            $gettoken = $links[$row][9];
                            $gettokeni = $links[$row][10];
                            $gettokenii = $links[$row][11];

                            $gethref = $href;
                            break;
                    }
                    
                    ?>
                    <a <?php if($getclass != "") { ?> class="<?php echo $getclass;?>" <?php }?> <?php if($gettarget != "") { ?> target="<?php echo $gettarget;?>" <?php }?> <?php if($gettitle != "") { ?> title="<?php echo $gettitle;?>" <?php }?> href="<?php echo $gethref;?>"><?php echo $gettitle;?></a>
                    <?php
                    
                //echo '|<br />';
                }
                ?>
                &nbsp;&nbsp;
                <!--<div style="text-align:right;">
                <!--<a class="link" target="_blank" title="Descargar" href="reporte_Xls.php?reporte=ginfprosystem&status=<?php echo base64_encode("PAC");?>">Descargar TarRMA</a>
                <a class="link" title="Relocacionar Box FF" href="index.php?select=loginv&s2=rmas&s3=full&s4=reloc">(&Sqrt;) Cambiar Loc Box FF</a>
                <a class="link" title="Agregar BOX Tarima RMA" href="index.php?select=loginv&s2=produccion&s3=tarrma&s4=agregarbox&tarima=<?php echo $gtarrma;?>">(+) Agregar BOX</a>&nbsp;&nbsp;
            </div>-->
            </div>
            <?php
            //*********************************************************Links extras
            
            }
            
            
            
            
            
            ?>
            
            
            <div id="inbox_t">
                <!--<font class="negrom">Listado SI</font><br />
                <br />-->
                <?php
                //Depende el mensaje
                if($messgood != ""){
                    ?>
		<div id="messok">
		<?php echo $messgood;?>
                </div>
                <?php
		}
    	
                //Depende el mensaje
                if($messerror != ""){
                    ?>
                <div id="messno">
                <?php echo $messerror;?>
                </div>
                <?php
                }
                
                //*********************************************************BUSCAR
                if($buscar == 1){
                    $FormSearch = "<form action='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=$sIV&search=1' method='post'>"
                    . "<input type='text' class='text' name='search' placeholder='$campobuscar'>"
                    . "</form>";
                    echo $FormSearch;
                }
                
                //*********************************************************BUSCAR
                
                //Empieza el automatico
                //*********************************************************INFO
                if($info != ""){
                    echo $info;
                }
                
                //*********************************************************INFO
                
                
                //*********************************************************Links Grandes
                //echo sizeof($links);
                //print_r($links);
            
                if(sizeof($links_b) > 0){
                    //echo "aqui";
                    //Desplega los lins
                    for ( $row2 = 0; $row2 < sizeof($links_b); $row2++ ){
                        $getclass2 = $links_b[$row2][3];
                        $gettarget2 = $links_b[$row2][2];
                        $gettitle2 = $links_b[$row2][1];
                        $getthref2 = $links_b[$row2][0];
                    
                        switch ($getthref2){
                            case "index.php?select=loginv":
                            case "index.php?select=viewpro":
                                $s2_l = $links_b[$row2][6];
                                $s3_l = $links_b[$row2][7];
                                $s4_l = $links_b[$row2][8];
                                $gettoken = $links_b[$row2][9];
                                $gettokeni = $links_b[$row2][10];
                                $gettokenii = $links_b[$row2][11];
                            
                                $gethref2 = $getthref2 . "&s2=" . $s2_l . "&s3=" . $s3_l . "&s4=" . $s4_l. "&token=" . $gettoken. "&tokeni=" . $gettokeni. "&tokenii=" . $gettokenii;
                                break;
                            case "reporte_Xls.php?":
                                $reporte = $links_b[$row][6];
                                $s3_l = $links_b[$row2][7];
                                $s4_l = $links_b[$row2][8];
                                $gettoken = $links_b[$row2][9];
                                $gettokeni = $links_b[$row2][10];
                                $gettokenii = $links_b[$row2][11];
                            
                                $gethref2 = $getthref2 . "&reporte=" . $reporte . "&s3=" . $s3_l . "&s4=" . $s4_l . "&token=" . $gettoken. "&tokeni=" . $gettokeni. "&tokenii=" . $gettokeni;
                                break;
                        }
                    
                        ?>
                        <br>
                        <a <?php if($getclass2 != "") { ?> class="<?php echo $getclass2;?>" <?php }?> <?php if($gettarget2 != "") { ?> target="<?php echo $gettarget2;?>" <?php }?> <?php if($gettitle2 != "") { ?> title="<?php echo $gettitle2;?>" <?php }?> href="<?php echo $gethref2;?>"><?php echo $gettitle2;?></a>
                        <br><br>
                        <?php
                    
                //echo '|<br />';
                    }
                }
                //*********************************************************Links extras
            
                
                
                //*********************************************************LIST
                if(sizeof($columnas) > 0){
                    //Entonces muestra
                    $sizetab = sizeof($columnas);
                    ?>
                <center>
                <table width="100%">
                    <?php
                    $contr = 0;
                    for ( $rowx = 0; $rowx < sizeof($columnas); $rowx++ ){
                        //print_r($columnas[$rowx]);
                        //echo sizeof($columnas[$rowx]);
                        
                        for ( $colx = 0; $colx < sizeof($columnas[$rowx]); $colx++ ){
                            //Depenede ColorRow, ClassRow, ClasCol1, Col1,  ...!
                            //echo $colx . "<br>";
                            //echo $columnas[$rowx][$colx] . "<br>";
                            switch ($colx){
                                case 0:
                                    $tr_color = $columnas[$rowx][$colx];
                                    break;
                                case 1:
                                    $tr_class = $columnas[$rowx][$colx];
                                    break;
                                default :
                                    if($contr == 0){
                                        $contr++;
                                        ?>
                    <tr 
                    <?php 
                    if($tr_class != "") {
                        ?>
                        class = "<?php echo $tr_class;?>"; 
                        <?php 
                        
                    }
                    
                    if($tr_color != ""){
                        ?>
                        bgcolor="<?php echo $tr_color;?>" onmouseover="this.bgColor='#E0ECF8'" onmouseout="this.bgColor='<?php echo $tr_color;?>'"
                        <?php
                    } 
                    ?>
                        
                    >                
                    <?php
                                    }
                                    
                                    //Cada columna
                                    if($colx & 1){
                                        //echo 'Even number!';
                                        $td_value = $columnas[$rowx][$colx];
                                        ?>
                            <?php echo $td_value;?>
                        </td>
                                        <?php
                                    }else{
                                        //echo 'Odd number!';
                                        $td_class = $columnas[$rowx][$colx];
                                        ?>
                        <td class="<?php echo $td_class;?>">                
                                        <?php
                                    }
                                    break;
                            }
                        }
                        
                    $contr = 0;
                    ?>
                    </tr>
                    <?php
                    }
                    ?>
                </table>
                </center>
                <?php
                    
                }
                
                
                
                
                
                //*********************************************************LIST
                
                ?>
        	<br />
            </div>
	</div>
        </center>
	<?php
        break;
}

?>