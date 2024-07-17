<?php
switch ($sIII){
    case "AddOrder":
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
            case "seCustomer":
                $gSearch = $_POST['search'];
                echo $gSearch;
                
                
                break;
            case "Home":
                ?>
                <main>
                <center>
                <?php
                $FID = 6;
                $FLink = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=seCustomer";
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
        $LID = 3;
        $IDOption = "IdOrder";
        //Obrtiene usuarios
        if(isset($_GET['search'])){
            if($_GET['search'] == 1){
                $frase = $_POST['search'];
                $lfrase = "%$frase%";
                $LRows = $cnx->query('SELECT IdOrder, Mobile AS Celular, CustomerName AS Nombre FROM Customers WHERE (Mobile LIKE ? OR CustomerName LIKE ?) AND IDCustomer != ? ORDER BY CustomerName ASC', $lfrase, $lfrase, '1')->fetchAll();
            }
            
        } else {
            $LRows = $cnx->query('SELECT IdOrder, Mobile AS Celular, Customer AS Cliente FROM Orders ORDER BY dtCreated ASC')->fetchAll();
        
        }
        
        
        $ALinks[] = array('s_icon', '20', 'Images/Edit.svg', "index.php?sI=$sI&sII=$sII&sIII=EditOrder&sIV=vEdit", '_self', 'Editar Cliente');
        $ALinks[] = array('s_icon', '20', 'Images/Trash.svg', "index.php?sI=$sI&sII=$sII&sIII=EditOrder&sIV=vDelete", '_self', 'Eliminar Cliente');
        //$ALinks[] = array('s_icon', '20', 'Images/Messages.svg', "index.php?sI=$sI&sII=$sII&sIII=Messages&sIV=Home", '_self', 'Ver Ordenes');
        
        //$FLink = "index.php?sI=$sI&sII=$sII&sIII=sUser&sIV=$sIV";
        echo Lista($LID, $LRows, $IDOption, $ALinks);
        ?>
        </center>
        </main>  
        <?php
}
?>