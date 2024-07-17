<?php
//Users
switch ($sIII){
    case "Profile":
        switch ($sIV){
            case "sPass":
                $gPass1 = $_POST['npass'];
                $gPass2 = $_POST['npass2'];
                
                if($gPass1 == $gPass2){
                    //Cambia el password
                    $CodPass = md5($gPass1);
                    //Agrega usuario
                    $uUser = $cnx->query('UPDATE Users SET CodPass = ? WHERE MobileNumber = ?', $CodPass, $uMobileNumber);
                    $iVal = $uUser->affectedRows();

                    if($iVal == 1):
                        $vATipo = "Verde";
                        $vAMensaje = "Se cambio password con exito...!";
                        $vRedirect = "index.php";
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
                    
                    
                } else {
                    //Error Password Diferente
                    $vATipo = "Rojo";
                    $vAMensaje = "Error Passwords Diferentes...!";
                    $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sII&sIV=Home";
                    $vATime = 1000;
                    //echo $vRedirect;
                    echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                }
                
                
                
                break;
            case "Home":
                //echo "Aqui";
            ?>
            <main>
            <center>
            <?php
            $FID = 4;
            $FLink = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=sPass";
            echo Formato($FID, $FLink, $X, $vATime);
            ?>
            </center>
            </main>  
            <?php
                break;
        }
        break;
    case "sEditUser":
        $gIDUser = base64_decode($_GET['token']);
        $gettoken = base64_encode($gIDUser);
        ?>
        <main>
        <center>
        <?php
        //Ve el formato
        $FID = 2;
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
        if($gIDUser > 0){
            //Existe
            $EUser = $cnx->query('SELECT * FROM Users WHERE IDUser = ?', "$gIDUser");
            $cantUsers = $EUser->numRows();
            
            if($cantUsers == 1):
                //$RUsers = $EUser->fetchArray();
                
                //CodUser
                //$CodUser = md5($RUsers['User']);
                //$CodPass = md5("M3x1c4l11");
                
                $sql = "UPDATE Users SET MobileNumber = '$P_celular', Email = '$P_email', "
                    . "FLastName = '$P_apellidop', MLastName = '$P_apellidom', Name = '$P_nombres', "
                    . "Bday = '$P_bday', Account = '$P_cuenta', IDExtra = '$P_idextra', idSupervisor = '$P_supervisor' WHERE IDUser = '$gIDUser'";
                
                //echo $sql;
                //Agrega usuario
                $uUser = $cnx->query("$sql");
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
                    $vAMensaje = "Changes not detected...!";
                    $vRedirect = "index.php?sI=$sI&sII=Users&sIII=Home&sIV=Home&token=$gettoken";
                    $vATime = 1000;
                    //echo $vRedirect;
                    echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                endif;
                
            else:
                $vATipo = "Rojo";
                $vAMensaje = "User already exist...!";
                $vRedirect = "index.php?sI=$sI&sII=Users&sIII=Home&sIV=Home&token=$gettoken";
                $vATime = 1000;
                //echo $vRedirect;
                echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
            endif;
            
            
        } else {
            $vATipo = "Rojo";
            $vAMensaje = "Celular valor invalido ($gCell - $P_celular)...!";
            $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=Home&sIV=Home&token=$gettoken";
            $vATime = 1000;
            //echo $vRedirect;
            echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
        }
        
        
        ?>
        </center>
        </main>  
        <?php
        
        break;
    case "sDeleteUser":
        $P_IDUser = base64_decode($_GET['token']);
        
        //echo "$P_celular";
        
        
        $dUser = $cnx->query('DELETE FROM Users WHERE IDUser = ?', $P_IDUser);
        $dVal = $dUser->affectedRows();

        if($dVal == 1):
            $vATipo = "Verde";
            $vAMensaje = "Se elimino con exito usuario...!";
            $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=Home&sIV=Home";
            $vATime = 1000;
            //echo $vRedirect;
            echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
        else:
            $vATipo = "Rojo";
            $vAMensaje = "Error al eliminar usuario...!";
            $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=AddUser&sIV=Home";
            $vATime = 1000;
            //echo $vRedirect;
            echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
        endif;
        
        break;
    case "vDeleteUser":
        $P_IDUser = base64_decode($_GET['token']);
        //Verifica 10 digitos
        if($P_IDUser > 0){
            //Existe
            $EUser = $cnx->query('SELECT * FROM Users WHERE IDUser = ?', "$P_IDUser");
            $cantUsers = $EUser->numRows();
            //echo "Usuarios: $cantUsers<BR>";
            
            if($cantUsers == 1):
                //CodUser
                ?>
                <main>
                <center>
                <?php
                $gettoken = base64_encode($P_IDUser);
                
                $vEUser = $cnx->query('SELECT * FROM Users WHERE IDUser = ?', "$P_IDUser")->fetchArray();
                print_r($vEUser);
                $FormValues['celular'] = $vEUser['MobileNumber'];
                $FormValues['nombres'] = $vEUser['Name'];
                $FormValues['apellidop'] = $vEUser['FLastName'];
                $FormValues['apellidom'] = $vEUser['MLastName'];
                $FormValues['email'] = $vEUser['Email'];
                $FormValues['bday'] = $vEUser['Bday'];
                
                
                
                ?>
                    <font class="Ex">
                        Eliminar Usuario?
                    </font><br>
                    <font class="Exss" style="color:red;">
                        <?php echo$FormValues['apellidop'] . ", " . $FormValues['nombres'];?>
                    </font><br><br>
                    <?php
                    //Links
                    $ALinks[] = array('buttonb', '50', 'Images/Trash.svg', "index.php?sI=$sI&sII=$sII&sIII=sDeleteUser&sIV=$sIV&token=$gettoken", '_self', 'Eliminar', 'red', 'white');
                    $ALinks[] = array('buttonb', '50', 'Images/Cancel.svg', "index.php?sI=$sI&sII=$sII&sIII=Home&sIV=$sIV", '_self', 'Cancelar', '#E0E0E0', 'black');
                    echo FLink($ALinks);
                    ?>
                </center>
                </main>  
                <?php
                
                
            else:
                $vATipo = "Rojo";
                $vAMensaje = "Celular en usuario no existente...!";
                $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=Home&sIV=Home";
                $vATime = 1000;
                //echo $vRedirect;
                echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
            endif;
            
            
        } else {
            $vATipo = "Rojo";
            $vAMensaje = "Celular valor invalido...!";
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
    case "vEditUser":
        if(isset($_GET['token'])){
            $P_IDUser = base64_decode($_GET['token']);
            $gettoken = base64_encode($P_IDUser);
            //echo "Aqui:"  $P_IDUser;
            $vEUser = $cnx->query('SELECT * FROM Users WHERE IDUser = ?', "$P_IDUser")->fetchArray();
            //* print_r($vUser);
            $FormValues['celular'] = $vEUser['MobileNumber'];
            $FormValues['nombres'] = $vEUser['Name'];
            $FormValues['apellidop'] = $vEUser['FLastName'];
            $FormValues['apellidom'] = $vEUser['MLastName'];
            $FormValues['email'] = $vEUser['Email'];
            $FormValues['bday'] = $vEUser['Bday'];
            $FormValues['idextra'] = $vEUser['IDExtra'];
            $FormValues['idsupervisor'] = $vEUser['idSupervisor'];
            $FormValues['cuenta'] = $vEUser['Account'];
            
            //echo $FormValues['cuenta'] . "<BR>";
            $aGForm = array("Edit User - " . $FormValues['nombres'], "60%", "", "");
            //Link, Title, target, class, $sI, SII, $sIII, $sIV, token, tokeni, tokenii
            $aLinks = array(
                array("", "< Back", "", "linkr", "", "$sI", "$sII", "$sIII", "vEdit", "$gettoken", "", "")
            );
            
            //Trae todos los usuarios
            $sSup = "SELECT IDUser, CONCAT(FLastName, ' ', MLastName, ', ', Name) AS name FROM Users ORDER BY FLastName ASC";
            $rSup = $cnx->query($sSup)->fetchAll();
            
            foreach ($rSup as &$RSupX) {
                //print_r($RSupX);
                $valopt = $RSupX['IDUser'];
                $OptX = $RSupX['name'];
                $valSup .= "$valopt:$OptX|";
            }
            
            if(!empty($valSup)){
                $valSup = substr($valSup, 0, -1);
            }

            $Accs = "Buyer|Sourcing|Sourcing Manager|CSR Manager|CSR|Quote Manager|Accounting|Purchasing Leader|Purchasing Manager|Accounts Receivable";
            
            if($uAccount == "Admin"){
                $Accs .= "$Accs|SuperUser|Admin";
            } else {
                if($uAccount == "SuperUser"){
                    $Accs .= "$Accs|SuperUser";
                }
            }
            
            //campos: action, label, id, class, tipo, name, value, checked, selected, focus  
            $aFields = array(
                array("index.php?sI=$sI&sII=$sII&sIII=sEditUser&sIV=$sIV&token=$gettoken", "", "formx", "formx", "post", "addfile", "", "", "", ""),
                array("", "Celular:", "celular", "text", "text", "celular", $FormValues['celular'], "", "", "1"),
                array("", "<BR>Nombres:", "nombres", "text", "text", "nombres", $FormValues['nombres'], "", " size='50' ", ""),
                array("", "<BR>Apellido Paterno:", "apellidop", "text", "text", "apellidop", $FormValues['apellidop'], "", " size='50' ", ""),
                array("", "<BR>Apellido Materno:", "apellidom", "text", "text", "apellidom", $FormValues['apellidom'], "", " size='50' ", ""),
                array("", "<BR>Email:", "email", "text", "text", "email", $FormValues['email'], "", " size='50' ", ""),
                array("", "<BR>Fecha Nacimiento:", "bday", "text", "date", "bday", $FormValues['bday'], "", "", ""),
                array("", "<BR>ID Extra:", "idextra", "text", "text", "idextra", $FormValues['idextra'], "", " size='20' ", ""),
                array("", "<BR>Cuenta:", "cuenta", "stext", "select", "cuenta", "$Accs", "", $FormValues['cuenta'], ""),
                array("", "<BR>Supervisor:", "supervisor", "stext", "select", "supervisor", "$valSup", "", $FormValues['idsupervisor'], "")
            );
            echo drawForm($aGForm, $aLinks, $aFields);
            
            
        } else {
            $vATipo = "Rojo";
            $vAMensaje = "User not ready for editing...!";
            $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=EditUser&sIV=Home";
            $vATime = 1000;
            //echo $vRedirect;
            echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
        }
        break;
    case "vEditUserX":
        ?>
        <main>
        <center>
        <?php
        //echo "Aqui";
        //Solo si esta vacio
        if(isset($_GET['token'])){
            $P_IDUser = base64_decode($_GET['token']);
            //echo $P_IDUser;
        } else {
            //echo "Aqui2";
        
            $FID = 3;
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
            
            $EUserx = $cnx->query('SELECT IDUser FROM Users WHERE MobileNumber = ? OR User LIKE ? ORDER BY IDUser ASC LIMIT 0, 1', "$P_user", "$P_user")->fetchArray();
            $P_IDUser = $EUserx['IDUser'];
            //echo "******" . $P_IDUser;
        }
        
        //Verifica 10 digitos
        if($P_IDUser > 0){
            //* echo "Aqui3";
        
            //Existe
            $EUser = $cnx->query('SELECT * FROM Users WHERE IDUser = ?', "$P_IDUser");
            $cantUsers = $EUser->numRows();
            //* echo "Usuarios: $cantUsers<BR>";
            
            if($cantUsers == 1):
                //CodUser
                ?>
                <main>
                <center>
                <?php
                $gettoken = base64_encode($P_IDUser);
                
                $vEUser = $cnx->query('SELECT * FROM Users WHERE IDUser = ?', "$P_IDUser")->fetchArray();
                //* print_r($vUser);
                $FormValues['celular'] = $vEUser['MobileNumber'];
                $FormValues['nombres'] = $vEUser['Name'];
                $FormValues['apellidop'] = $vEUser['FLastName'];
                $FormValues['apellidom'] = $vEUser['MLastName'];
                $FormValues['email'] = $vEUser['Email'];
                $FormValues['bday'] = $vEUser['Bday'];
                $FormValues['idextra'] = $vEUser['IDExtra'];
                $FormValues['idsupervisor'] = $vEUser['idSupervisor'];
                
                $FID = 2;
                $FLink = "index.php?sI=$sI&sII=$sII&sIII=sEditUser&sIV=$sIV&token=$gettoken";
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
    case "EditUser":
        //echo "Aqui";
        ?>
        <main>
        <center>
        <?php
        $FID = 3;
        $FLink = "index.php?sI=$sI&sII=$sII&sIII=vEditUser&sIV=$sIV";
        echo Formato($FID, $FLink, $X, $vATime);
        ?>
        </center>
        </main>  
        <?php
        break;
    case "sUser":
        ?>
        <main>
        <center>
        <?php
        //Ve el formato
        $FID = 2;
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
        
        $P_email = strtolower($P_email);
                
        //Verifica 10 digitos
        if($P_email != ""){
            $UserX = explode("@", $P_email);
            $User = $UserX[0];
            //Existe
            $EUser = $cnx->query('SELECT * FROM Users WHERE User = ?', "$User");
            $cantUsers = $EUser->numRows();
            
            if($cantUsers == 0):
                //CodUser
                $CodUser = md5($User);
                $CodPass = md5("Masterwork1");
                
                $iUser = "INSERT INTO Users VALUES("
                        . "'0', '$User', '$CodUser', '$CodPass', '$P_celular', '$P_email', "
                        . "'$P_apellidop', '$P_apellidom', '$P_nombres', '$P_bday', '1', "
                        . "'$P_cuenta',  '$P_idextra', '$P_supervisor', '$P_turno'"
                        . ")";
                
                //Agrega usuario
                $iUser = $cnx->query("$iUser");
                $iVal = $iUser->affectedRows();
                
                if($iVal == 1):
                    $vATipo = "Verde";
                    $vAMensaje = "Se agrego con exito usuario...!";
                    $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=Home&sIV=Home";
                    $vATime = 1000;
                    //echo $vRedirect;
                    echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                else:
                    $vATipo = "Rojo";
                    $vAMensaje = "Error al agregar usuario...!";
                    $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=AddUser&sIV=Home";
                    $vATime = 1000;
                    //echo $vRedirect;
                    echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                endif;
                
            else:
                $vATipo = "Rojo";
                $vAMensaje = "Celular en usuario preexistente...!";
                $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=AddUser&sIV=Home";
                $vATime = 1000;
                //echo $vRedirect;
                echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
            endif;
            
            
        } else {
            $vATipo = "Rojo";
            $vAMensaje = "Email valor invalido...!";
            $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=AddUser&sIV=Home";
            $vATime = 1000;
            //echo $vRedirect;
            echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
        }
        
        
        ?>
        </center>
        </main>  
        <?php
        break;
    case "AddUser":
        //echo "Aqui";
        ?>
        <main>
        <center>
        <?php
        $FID = 2;
        $FLink = "index.php?sI=$sI&sII=$sII&sIII=sUser&sIV=$sIV";
        echo Formato($FID, $FLink, $X, $vATime);
        ?>
        </center>
        </main>  
        <?php
        break;
    case "Home":
        //echo "Aqui";
        ?>
        <main>
        <center>
        <?php
        $LID = 1;
        $IDOption = "IDUser";
        //Obrtiene usuarios
        if(isset($_GET['search'])){
            if($_GET['search'] == 1){
                $frase = $_POST['search'];
                $lfrase = "%$frase%";
                $LRows = $cnx->query('SELECT MobileNumber AS IDUser, IDExtra, MobileNumber AS Celular, CONCAT(Name, \' \', FLastName) AS Nombre FROM Users WHERE (MobileNumber LIKE ? OR Name LIKE ? OR FLastName LIKE ? OR MLastName LIKE ?) AND IDUser != ? ORDER BY FLastName ASC', $lfrase, $lfrase, $lfrase, $lfrase, '1')->fetchAll();
            }
            
        } else {
            $LRows = $cnx->query('SELECT IDUser, MobileNumber AS Mobile, CONCAT(Name, \' \', FLastName) AS Nombre, Account, Email, IDExtra FROM Users WHERE IDUser != ? ORDER BY FLastName ASC', '1')->fetchAll();
        
        }
        
        
        $ALinks[] = array('s_icon', '20', 'Images/Edit.svg', "index.php?sI=$sI&sII=$sII&sIII=vEditUser&sIV=$sIV", '_self', 'Edit User');
        $ALinks[] = array('s_icon', '20', 'Images/Trash.svg', "index.php?sI=$sI&sII=$sII&sIII=vDeleteUser&sIV=$sIV", '_self', 'Delete User');
        
        //$FLink = "index.php?sI=$sI&sII=$sII&sIII=sUser&sIV=$sIV";
        echo Lista($LID, $LRows, $IDOption, $ALinks);
        ?>
        </center>
        </main>  
        <?php
        break;
}

?>