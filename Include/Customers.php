<?php
switch ($sIII){
    case "EditCustomer":
        switch ($sIV){
            case "sDelete":
                $P_idCustomer = base64_decode($_GET['token']);
                $gettoken = base64_encode($P_idCustomer);
                //echo "$P_celular";


                $dUser = $cnx->query('DELETE FROM Customers WHERE idCustomer = ?', $P_idCustomer);
                $dVal = $dUser->affectedRows();

                if($dVal == 1):
                    $vATipo = "Verde";
                    $vAMensaje = "Se elimino con exito cliente...!";
                    $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=Home&sIV=Home";
                    $vATime = 1000;
                    //echo $vRedirect;
                    echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                else:
                    $vATipo = "Rojo";
                    $vAMensaje = "Error al eliminar cliente...!";
                    $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=Home&sIV=Home";
                    $vATime = 1000;
                    //echo $vRedirect;
                    echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                endif;
                break;
            case "vDelete":
                $P_idCustomer = base64_decode($_GET['token']);
                //echo $P_idCustomer;
                $gettoken = base64_encode($P_idCustomer);
                //Verifica 10 digitos
                if($P_idCustomer > 0){
                    //Existe
                    $EUser = $cnx->query('SELECT * FROM Customers WHERE idCustomer = ?', "$P_idCustomer");
                    $cantUsers = $EUser->numRows();
                    //echo "Usuarios: $cantUsers<BR>";

                    if($cantUsers == 1):
                        //CodUser
                        ?>
                        <main>
                        <center>
                        <?php
                        //$gettoken = base64_encode($P_celular);

                        $vEUser = $cnx->query('SELECT * FROM Customers WHERE idCustomer = ?', "$P_idCustomer")->fetchArray();
                        //print_r($vUser);
                        $FormValues['CustomerName'] = $vEUser['CustomerName'];
                        $FormValues['RFC'] = $vEUser['RFC'];



                        ?>
                            <font class="Ex">
                                Eliminar Cliente?
                            </font><br>
                            <font class="Exss" style="color:red;">
                                <?php echo $FormValues['CustomerName'] . "<BR>" . $FormValues['RFC'];?>
                            </font><br><br>
                            <?php
                            //Links
                            $ALinks[] = array('buttonb', '50', 'Images/Trash.svg', "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=sDelete&token=$gettoken", '_self', 'Eliminar', 'red', 'white');
                            $ALinks[] = array('buttonb', '50', 'Images/Cancel.svg', "index.php?sI=$sI&sII=$sII&sIII=Home&sIV=Home", '_self', 'Cancelar', '#E0E0E0', 'black');
                            echo FLink($ALinks);
                            ?>
                        </center>
                        </main>  
                        <?php


                    else:
                        $vATipo = "Rojo";
                        $vAMensaje = "Cliente no existente...!";
                        $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=Home&sIV=Home";
                        $vATime = 1000;
                        //echo $vRedirect;
                        echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                    endif;


                } else {
                    $vATipo = "Rojo";
                    $vAMensaje = "Cliente valor invalido...!";
                    $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=Home&sIV=Home";
                    $vATime = 1000;
                    //echo $vRedirect;
                    echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                }

                ?>
                </center>
                </main>  
                <?php
                break;
            case "sEdit":
                $gidCustomer = base64_decode($_GET['token']);
                $gettoken = base64_encode($gidCustomer);
                ?>
                <main>
                <center>
                <?php
                //Ve el formato
                $FID = 5;
                //Obtiene todos los campos
                $AValues = GFormato($FID);
                //Saca el valor de cada form
                foreach ($AValues as &$nField) {
                    //print_r($nField);
                    //NFie3ld
                    $VarF = "P_" . $nField['nameIn'];
                    $$VarF = $_POST[$nField['nameIn']];

                    //echo "$VarF : *" . $$VarF . "*<BR>";

                }


                //Verifica 10 digitos
                if($P_idCustomer > 0){
                    //Existe
                    $EUser = $cnx->query('SELECT * FROM Customers WHERE idCustomer = ?', "$gidCustomer");
                    $cantUsers = $EUser->numRows();

                    if($cantUsers == 1):
                        //CodUser
                        //$CodUser = md5($P_celular);
                        //$CodPass = md5("M3x1c4l11");


                        //Agrega usuario
                        $uUser = $cnx->query('UPDATE Users SET CodUser = ?, MobileNumber = ?, Email = ?, FLastName = ?, MLastName = ?, Name = ?, Bday = ? WHERE MobileNumber = ?', $CodUser, $P_celular, $P_email, $P_apellidop, $P_apellidom, $P_nombres, $P_bday, $gCell);
                        $iVal = $uUser->affectedRows();

                        if($iVal == 1):
                            $vATipo = "Verde";
                            $vAMensaje = "Se edito con exito usuario...!";
                            $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=Home&sIV=Home";
                            $vATime = 1000;
                            //echo $vRedirect;
                            echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                        else:
                            $vATipo = "Rojo";
                            $vAMensaje = "Error al agregar usuario...!";
                            $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=vEditUser&sIV=Home&token=$gettoken";
                            $vATime = 1000;
                            //echo $vRedirect;
                            echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                        endif;

                    else:
                        $vATipo = "Rojo";
                        $vAMensaje = "Celular en usuario preexistente...!";
                        $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=vEditUser&sIV=Home&token=$gettoken";
                        $vATime = 1000;
                        //echo $vRedirect;
                        echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                    endif;


                } else {
                    $vATipo = "Rojo";
                    $vAMensaje = "Cliente valor invalido ($gidCustomer)...!";
                    $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=vEdit&sIV=Home&token=$gettoken";
                    $vATime = 1000;
                    //echo $vRedirect;
                    echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                }


                ?>
                </center>
                </main>  
                <?php
                break;
            case "vEdit":
                ?>
                <main>
                <center>
                <?php

                //Solo si esta vacio
                if(isset($_GET['token'])){
                    $P_idCustomer = base64_decode($_GET['token']);
                    //echo $P_celular;
                } else {
                    $FID = 5;
                    //Obtiene todos los campos
                    $AValues = GFormato($FID);
                    //Saca el valor de cada form
                    foreach ($AValues as &$nField) {
                        //print_r($nField);
                        //NFie3ld
                        $VarF = "P_" . $nField['nameIn'];
                        $$VarF = $_POST[$nField['nameIn']];

                        //echo "$VarF : *" . $$VarF . "*<BR>";
                    }
                }

                //echo $P_idCustomer;
                //Verifica 10 digitos
                if(strlen($P_idCustomer) > 0){
                    //Existe
                    $ECustomer = $cnx->query('SELECT * FROM Customers WHERE idCustomer = ?', "$P_idCustomer");
                    $cantCust = $ECustomer->numRows();
                    //echo "Usuarios: $cantUsers<BR>";

                    if($cantCust == 1):
                        //CodUser
                        ?>
                        <main>
                        <center>
                        <?php
                        $gettoken = base64_encode($P_idCustomer);

                        $vEUser = $cnx->query('SELECT * FROM Customers WHERE idCustomer = ?', "$P_idCustomer")->fetchArray();
                        //print_r($vUser);
                        $FormValues['idCustomer'] = $vEUser['idCustomer'];
                        $FormValues['type'] = $vEUser['CustomerType'];
                        $FormValues['razonsocial'] = $vEUser['CustomerName'];
                        $FormValues['phone'] = $vEUser['Phone'];
                        $FormValues['mobile'] = $vEUser['Mobile'];
                        $FormValues['email'] = $vEUser['Email'];
                        $FormValues['rfc'] = $vEUser['RFC'];
                        $FormValues['address'] = $vEUser['Address'];
                        $FormValues['address2'] = $vEUser['Address2'];
                        $FormValues['city'] = $vEUser['City'];
                        $FormValues['state'] = $vEUser['State'];
                        $FormValues['country'] = $vEUser['Country'];
                        $FormValues['postalcode'] = $vEUser['PostalCode'];
                        $FormValues['bday'] = $vEUser['C_LastName'];
                        $FormValues['bday'] = $vEUser['C_Mobile'];
                        $FormValues['bday'] = $vEUser['C_Phone'];
                        $FormValues['bday'] = $vEUser['C_Email'];
                        $FormValues['bday'] = $vEUser['Notes'];
                        $FormValues['bday'] = $vEUser['Created'];
                        $FormValues['bday'] = $vEUser['IDUser'];
                        $FormValues['bday'] = $vEUser['Active'];

                        $FID = 5;
                        $FLink = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=sEdit&token=$gettoken";
                        echo Formato($FID, $FLink, $FormValues, $vATime);
                        ?>
                        </center>
                        </main>  
                        <?php


                    else:
                        $vATipo = "Rojo";
                        $vAMensaje = "Celular en usuario no existente...!";
                        $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=EditUser&sIV=Home";
                        $vATime = 1000;
                        //echo $vRedirect;
                        echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                    endif;


                } else {
                    $vATipo = "Rojo";
                    $vAMensaje = "Celular valor invalido...!";
                    $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=EditUser&sIV=Home";
                    $vATime = 1000;
                    //echo $vRedirect;
                    echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                }

                ?>
                </center>
                </main>  
                <?php
                break;
        }
        break;
    case "AddCustomer":
        switch ($sIV){
            case "sCustomer":
                ?>
                <main>
                <center>
                <?php
                //Ve el formato
                $FID = 5;
                //Obtiene todos los campos
                $AValues = GFormato($FID);
                //Saca el valor de cada form
                foreach ($AValues as &$nField) {
                    //print_r($nField);
                    //NFie3ld
                    $VarF = "P_" . $nField['nameIn'];
                    $$VarF = strtoupper($_POST[$nField['nameIn']]);

                    //echo "$VarF : *" . $$VarF . "*<BR>";

                }

                if(strlen($P_phone) == 10 AND $P_razonsocial != "" AND strlen($P_mobile) == 10 AND $P_rfc != ""){
                    //Valida si existe usuario
                    $ECust = $cnx->query('SELECT * FROM Customers WHERE CustomerName LIKE ? OR RFC LIKE ?', $P_razonsocial, $P_rfc);
                    $cantCust = $ECust->numRows();
                    
                    if($cantCust == 0){
                        //Agregar Cliente
                        $iCust = $cnx->query('INSERT INTO Customers VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)', '0', $P_type, $P_razonsocial, $P_phone, $P_mobile, $P_email, $P_rfc, $P_address, $P_address2, $P_city, $P_state, $P_country, $P_postalcode, $P_c_name, $P_c_lastname, $P_c_mobile, $P_c_phone, $p_c_email, $P_notes, $dateToday, $uIDUser, '1');
                        $iVal = $iCust->affectedRows();

                        if($iVal == 1):
                            $vATipo = "Verde";
                            $vAMensaje = "Se agrego con exito Cliente...!";
                            $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=Home&sIV=Home";
                            $vATime = 1000;
                            //echo $vRedirect;
                            echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                        else:
                            $vATipo = "Rojo";
                            $vAMensaje = "Error al agregar usuario...!";
                            $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=Home";
                            $vATime = 1000;
                            //echo $vRedirect;
                            echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                        endif;
                        
                        
                    } else {
                        $vATipo = "Rojo";
                        $vAMensaje = "Razon Social o RFC Existente...!";
                        $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=Home";
                        $vATime = 1000;
                        //echo $vRedirect;
                        echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                    }
                    
                } else {
                    $vATipo = "Rojo";
                    $vAMensaje = "Valores invalidos...!";
                    $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=Home";
                    $vATime = 1000;
                    //echo $vRedirect;
                    echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                }
                
                ?>
                </center>
                </main>  
                <?php
                break;
            case "Home":
                ?>
                <main>
                <center>
                <?php
                $FID = 5;
                $FLink = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=sCustomer";
                echo Formato($FID, $FLink, $X, $vATime);
                ?>
                </center>
                </main>  
                <?php
                break;
        }
        break;
    case "Home":
        //echo "Aqui";
        ?>
        <main>
        <center>
        <?php
        $LID = 2;
        $IDOption = "IdCustomer";
        //Obrtiene usuarios
        if(isset($_GET['search'])){
            if($_GET['search'] == 1){
                $frase = $_POST['search'];
                $lfrase = "%$frase%";
                $LRows = $cnx->query('SELECT IdCustomer, Mobile AS Celular, CustomerName AS Nombre FROM Customers WHERE (Mobile LIKE ? OR CustomerName LIKE ?) AND IDCustomer != ? ORDER BY CustomerName ASC', $lfrase, $lfrase, '1')->fetchAll();
            }
            
        } else {
            $LRows = $cnx->query('SELECT IdCustomer, Mobile AS Celular, CustomerName AS Nombre FROM Customers ORDER BY CustomerName ASC')->fetchAll();
        
        }
        
        
        $ALinks[] = array('s_icon', '20', 'Images/Edit.svg', "index.php?sI=$sI&sII=$sII&sIII=EditCustomer&sIV=vEdit", '_self', 'Editar Cliente');
        $ALinks[] = array('s_icon', '20', 'Images/Trash.svg', "index.php?sI=$sI&sII=$sII&sIII=EditCustomer&sIV=vDelete", '_self', 'Eliminar Cliente');
        $ALinks[] = array('s_icon', '20', 'Images/Order.svg', "index.php?sI=$sI&sII=$sII&sIII=Orders&sIV=vOrders", '_self', 'Ver Ordenes');
        
        //$FLink = "index.php?sI=$sI&sII=$sII&sIII=sUser&sIV=$sIV";
        echo Lista($LID, $LRows, $IDOption, $ALinks);
        ?>
        </center>
        </main>  
        <?php
        break;
}