<center>
    <br><br>
    <div style="width: 95%;border: 1px solid black;">
        <div style="height: 5px;background-color: <?php echo $cSt;?>;">
        </div>
        <table width="100%">
            <tr>
                <td colspan="7" align="center">
                    <font class="Bahss">Titulo Tarea:<br></font>
                    <font class="Kohs"><?php echo $T_TaskName;?></font>
                </td>
                <td align="center" colspan="2">
                    <font class="Bahss">ESTADO:<br></font>
                    <font class="Koh" style="color:<?php echo $cSt;?>;"><?php echo $T_Status;?></font>
                </td>
                <td align="center" width="10%">
                    <div style="background-color: gainsboro;border:1px solid black;padding: 2px 5px 2px 5px;">
                        <font class="Bahss">
                            Numero Tarea:
                        </font>
                    </div>
                    <div style="background-color: white;border:1px solid black;padding: 2px 5px 2px 5px;">
                        <font class="Bahss">
                            <?php echo $T_idTask;?>
                        </font>
                    </div>
                </td>
            </tr>
            <tr>
                <td align="right" colspan="5" style="background-color: #f7f7f7;">
                </td>
                <td align="right" width="10%" style="background-color: #e7e7e7;">
                    <font class="Bahss">Fecha Plan:<br></font>
                </td>
                <td align="center" style="background-color: white;border:1px solid black;">
                    <font class="Kohss" style="color:<?php echo $cSt;?>;"><?php echo $T_dtPlanned;?><br></font>
                </td>
                <td align="right" width="10%" style="background-color: #e7e7e7;">
                    <font class="Bahss">Due&ntilde;o:<br></font>
                </td>
                <td align="right" colspan="2" width="20%" style="background-color: white;border:1px solid black;">
                    <font class="Kohss" style="color:<?php echo $cSt;?>;"><?php echo $T_UserAssigned;?><br></font>
                </td>
            </tr>
            <tr>
                <td align="right" width="10%" style="background-color: #e7e7e7;">
                    <font class="Bahss">Fecha Creaci&oacute;n:<br></font>
                </td>
                <td align="center" width="10%" style="background-color: white;border:1px solid black;">
                    <font class="Kohss"><?php echo $T_dtCreated;?><br></font>
                </td>
                <td align="right" width="10%" style="background-color: #e7e7e7;">
                    <font class="Bahss">Tipo Tarea:<br></font>
                </td>
                <td align="center" width="10%" style="background-color: white;border:1px solid black;">
                    <font class="Kohss"><?php echo $T_TypeTask;?><br></font>
                </td>
                <td align="right" width="10%" style="background-color: #e7e7e7;">
                    <font class="Bahss">Proyecto:<br></font>
                </td>
                <td align="center" colspan="2" width="20%" style="background-color: white;border:1px solid black;">
                    <font class="Kohss"><?php echo $T_Project;?><br></font>
                </td>
                <td align="right" width="10%" style="background-color: #e7e7e7;">
                    <font class="Bahss">Creador:<br></font>
                </td>
                <td align="right" colspan="2" width="20%" style="background-color: white;border:1px solid black;">
                    <font class="Kohss"><?php echo $T_UserCreated;?><br></font>
                </td>
            </tr>
            <tr>
                <td align="center" valign="top" colspan="4" width="40%">
                    <font class="Bahs">Descripci&oacute;n Tarea:<br></font>
                    <div style="text-align: justify;">
                        <font class="Kohss"><?php echo nl2br($T_L_Descripcion);?></font>
                    </div>
                </td>
                <td align="center" valign="top">
                    <font class="Bahs"><br></font>
                </td>
                <td align="center" valign="top" colspan="3">
                    <font class="Bahs">Archivos Adjuntos:<br></font>
                    <?php 
                    //print_r($LFiles);
                    foreach ($LFiles AS &$gFile){
                        //Datos
                        $f_idFiles = $gFile['idFiles'];
                        $f_FLink = $gFile['FLink'];
                        $f_FTitle = $gFile['FTitle'];
                        $f_ext = explode(".", $f_FLink);
                        $extension = $f_ext[1];
                        
                        switch ($extension):
                            case "xlsx":
                            case "xls":
                            case "csv":
                                $f_icon = "xls.svg";
                                break;
                            case "doc":
                            case "docx":
                                $f_icon = "doc.svg";
                                break;
                            case "jpg":
                            case "jpeg":
                            case "png":
                            case "bmp":
                            case "tif":
                                $f_icon = "img.svg";
                                break;
                            case "pdf":
                                $f_icon = "pdf.svg";
                                break;
                            case "ppt":
                            case "pptx":
                                $f_icon = "ppt.svg";
                                break;
                            case "txt":
                                $f_icon = "txt.svg";
                                break;
                            case "zip":
                                $f_icon = "zip.svg";
                                break;
                            default :
                                $f_icon = "files.svg";
                                break;
                        endswitch;
                        
                        ?>
                    <div style="display:inline-block;padding: 2px 10px 2px 10px;border:1px solid #f6f6f6;">
                        <a href="<?php echo $f_FLink;?>"  title="<?php echo $f_FTitle;?>" target="_blank"><img src="<?php echo "Images/$f_icon";?>" width="40" title="<?php echo $f_FTitle;?>"></a><br>
                        <font class="Kohsss"><?php echo $f_FTitle;?></font>
                    </div>
                    <?php    
                    }
                    
                    ?>
                </td>
                <td align="right" valign="top" colspan="2">
                    <font class="Bahs">Opciones:<br></font><br>
                    <?php echo $links_op;?>
                </td>
            </tr>
            <tr>
                <td align="right" width="10%" style="background-color: #e7e7e7;">
                    <font class="Bahss">Fecha Aceptaci&oacute;n:<br></font>
                </td>
                <td align="center" width="10%" style="background-color: white;border:1px solid black;">
                    <font class="Kohss">
                        <?php
                        if($T_dtAccepted != "0000-00-00 00:00:00"){
                            echo $T_dtAccepted;
                        } else {
                            echo "ND";
                        }
                        
                        ?><br>
                    </font>
                </td>
                <td align="right" width="10%" style="background-color: #e7e7e7;">
                    <font class="Bahss">Fecha Comienzo:<br></font>
                </td>
                <td align="center" width="10%" style="background-color: white;border:1px solid black;">
                    <font class="Kohss">
                        <?php 
                        if($T_dtStart != "0000-00-00 00:00:00"){
                            echo $T_dtStart;
                        } else {
                            echo "ND";
                        }
                        ?><br>
                    </font>
                </td>
                <td align="right" width="10%" style="background-color: Turquoise;">
                    <font class="Bahss">Fecha Vanilla:<br></font>
                </td>
                <td align="center" width="10%" style="background-color: white;border:1px solid black;">
                    <font class="Kohss">
                        <?php 
                        if($T_dtVanilla != "0000-00-00 00:00:00"){
                            echo $T_dtVanilla;
                        } else {
                            echo "ND";
                        }
                        ?><br>
                    </font>
                </td>
                <td align="right" width="10%" style="background-color: OliveDrab;">
                    <font class="Bahss" style="color:white;">Fecha Producci&oacute;n:<br></font>
                </td>
                <td align="center" width="10%" style="background-color: white;border:1px solid black;">
                    <font class="Kohss">
                        <?php 
                        if($T_dtProduction != "0000-00-00 00:00:00"){
                            echo $T_dtProduction;
                        } else {
                            echo "ND";
                        }
                        ?><br>
                    </font>
                </td>
                <td align="right" width="10%" style="background-color: LimeGreen;">
                    <font class="Bahss">Fecha Cierre:<br></font>
                </td>
                <td align="center" width="10%" style="background-color: white;border:1px solid black;">
                    <font class="Kohss">
                        <?php 
                        if($T_dtClosed != "0000-00-00 00:00:00"){
                            echo $T_dtClosed;
                        } else {
                            echo "ND";
                        }
                        ?><br>
                    </font>
                </td>
            </tr>
            <tr>
                <td colspan="5" valign="top" align="center" style="border-right:1px solid #c7c7c7;">
                    <font class="Bahs">Mensajes:<br></font>
                    <div style="text-align:right;">
                        <?php
                        //Depende usuario
                        if($uIDUser == $T_idUserCreated OR $uIDUser == $T_IdUserAssigned OR $uAccount == "Admin" OR $uAccount == "SuperUser"){
                            //Menu mensajes
                            ?>
                            <a href="index.php?sI=<?php echo $sI;?>&sII=<?php echo $sII;?>&sIII=<?php echo $sIII;?>&sIV=AddMessage&token=<?php echo $gettoken;?>" class="linklr" target="_self">Agregar Mensaje</a>
                        <?php
                        }
                        ?>
                    </div>
                    <section class="discussion">
                        <?php
                        //Mensajes Logs...
                        //print_r($LMess);
                        foreach ($LMess as &$vM) {
                            //Data
                            //print_r($vM);
                            $Ms_datetime = $vM['datetime'];
                            $Ms_TypeLog = $vM['TypeLog'];
                            $Ms_UserCreated = $vM['UserCreated'];
                            $Ms_DetailLog = $vM['DetailLog'];
                            
                            switch ($Ms_TypeLog):
                                case "Mensaje Due&ntilde;o":
                                    $Ms_class = "bubble recipient first";
                                    break;
                                case "Mensaje Creador":
                                    $Ms_class = "bubble sender first";
                                    break;
                                default:
                                    $Ms_class = "bubble general first";
                                    break;
                            endswitch;
                            
                            ?>
                        <div class="<?php echo $Ms_class;?>">
                            <font class="Kohsss"><?php echo $Ms_datetime;?><br></font>
                            <font class="Bahs"><?php echo $Ms_UserCreated;?><br></font>
                            <?php echo nl2br($Ms_DetailLog);?>
                        </div>
                            <?php
                        }
                        ?>
                        <!-- Descripcion -->
                        <div class="bubble sender first">
                            <font class="Kohsss"><?php echo $T_L_datetime;?><br></font>
                            <font class="Bahs"><?php echo $T_L_UserCreated;?><br></font>
                            <?php echo nl2br($T_L_Descripcion);?>
                        </div>
                    </section>
                    <!--
                    <section class="discussion">
	
                        <div class="bubble sender first">Hello</div>
                        <div class="bubble sender last">This is a CSS demo of the Messenger chat bubbles, that merge when stacked together.</div>

                        <div class="bubble recipient first">Oh that's cool!</div>
                        <div class="bubble recipient last">Did you use JavaScript to perform that kind of effect?</div>

                        <div class="bubble sender first">No, that's full CSS3!</div>
                        <div class="bubble sender middle">(Take a look to the 'JS' section of this Pen... it's empty! 😃</div>
                        <div class="bubble sender last">And it's also really lightweight!</div>

                        <div class="bubble recipient">Dope!</div>

                        <div class="bubble sender first">Yeah, but I still didn't succeed to get rid of these stupid .first and .last classes.</div>
                        <div class="bubble sender middle">The only solution I see is using JS, or a &lt;div&gt; to group elements together, but I don't want to ...</div>
                        <div class="bubble sender last">I think it's more transparent and easier to group .bubble elements in the same parent.</div>

                    </section>-->
                </td>
                <td colspan="5" valign="top" align="center">
                    <font class="Bahs">Historial:<br></font>
                    <?php
                    $LID = 5;
                    echo Lista($LID, $LLogs, $IDOption, $ALinks);
                    ?>
                </td>
            </tr>
        </table>
        <br><br>
        <div style="height: 5px;background-color: <?php echo $cSt;?>;">
        </div>
    </div>
</center>