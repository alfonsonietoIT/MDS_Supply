<?php

switch ($sIII){
    case "Readed":
        $IDNotificacion = base64_decode($_GET['token']);
        $gettoken = base64_encode($IDNotificacion);
        
        //Actualiza
        $uNot = "UPDATE Notificacion SET dtReaded = '$dtAhora', Status = 'Closed' WHERE idNotificacion = '$IDNotificacion'";
        $iNot = $cnx->query("$uNot");
        
        $vATipo = "Verde";
        $vAMensaje = "Se actualizo notificacion...!";
        $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=Home&sIV=Home";
        $vATime = 1000;
        //echo $vRedirect;
        echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
        
        break;
    case "Home":
        ?>
        <main>
        <center>
        <?php
        $LID = 6;
        $IDOption = "IdNotificacion";
        //Obrtiene usuarios
        if(isset($_GET['search'])){
            if($_GET['search'] == 1){
                $frase = $_POST['search'];
                //$lfrase = "$frase";
                $star = "SELECT IdTask, IdTask AS IDTarea, GPriority AS P, TaskName AS Tarea, Project AS Proyecto, "
                        . "DATE(dtCreated) AS Fecha, UserCreated AS Creador, Status, TypeTask "
                        . "FROM Tasks WHERE (Project LIKE '$frase' OR TaskName LIKE '%$frase%' "
                        . "OR IDTask = '$frase' OR TypeTask LIKE '$frase') AND Status != 'Closed' ORDER BY dtCreated ASC";
                $LRows = $cnx->query("$star")->fetchAll();
            }
            
        } else {
            $star = "SELECT IdNotificacion, N_Title AS Proyecto, N_Notes AS Notificacion, App, IDApp, "
                    . "DATE(dtCreated) AS Fecha "
                    . "FROM Notificacion WHERE Status != 'Closed' AND IDUser = '$uIDUser' ORDER BY dtCreated ASC";
            $LRows = $cnx->query("$star")->fetchAll();
        }
        
        //Depende cuenta
        $ALinks[] = array('s_icon', '20', 'Images/search.svg', "index.php?sI=$sI&sII=Notify&sIII=Readed&sIV=Home", '_self', 'Cerrar Notificacion');
        //$ALinks[] = array('s_icon', '20', 'Images/Trash.svg', "index.php?sI=$sI&sII=$sII&sIII=EditTask&sIV=vDelete", '_self', 'Eliminar Cliente');
        //$ALinks[] = array('s_icon', '20', 'Images/Messages.svg', "index.php?sI=$sI&sII=$sII&sIII=Messages&sIV=Home", '_self', 'Ver Ordenes');
        
        //$FLink = "index.php?sI=$sI&sII=$sII&sIII=sUser&sIV=$sIV";
        echo Lista($LID, $LRows, $IDOption, $ALinks);
        ?>
        </center>
        </main>  
        <?php
        break;
}
?>