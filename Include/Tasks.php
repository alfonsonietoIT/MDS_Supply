<?php
switch ($sIII){
    case "EditTask":
        $IDTask = base64_decode($_GET['token']);
        if($IDTask == ""){
            $IDTask = $_POST['idtask'];
        }
        
        $gettoken = base64_encode($IDTask);
        $s_iTar = "SELECT * FROM Tasks WHERE idTask = '$IDTask'";
        $iTar = $cnx->query("$s_iTar")->fetchArray();
        //Todas las columnas
        //print_r($iTar);
        foreach ($iTar as $key => $value) {
            $Col = "T_" . $key;
            $$Col = $value;
            //echo $Col . "-" . $$Col . "<BR>";
        }
        
        switch ($sIV){
            case "RelProduction":
                //$LogM = "Se Termino Analisis ($IDTask)";
                //Inserta Log
                //$sDesc = "INSERT INTO TasksLogs VALUES('0', '$IDTask', 'Tarea Aceptada', "
                //        . "'$LogM', '$uIDUser', '$uFullName', '$dtAhora')";
                //echo $sDesc . "<BR>";
                //$isDesc = $cnx->query("$sDesc");
                
                //Actualiza Creador
                $uCreator = "UPDATE Tasks SET dtProduction = '$dtAhora', Status = 'Production' WHERE idTask = '$IDTask'";
                //echo $uCreator . "<BR>";
                $iuCreator = $cnx->query("$uCreator");
                
                $Process = "onDebug";
                //Obtiene el Tiempo de inicio
                $sTime = "SELECT idTasksTimes, dtCreated FROM TasksTimes WHERE "
                        . "App = 'Tareas' AND IDApp = '$IDTask' AND Process = '$Process' AND Status = 'Open' ORDER BY idTasksTimes DESC LIMIT 0, 1";
                $rTime = $cnx->query("$sTime")->fetchArray();
                $gIDTT = $rTime['idTasksTimes'];
                $gCTime = $rTime['dtCreated'];
                
                //Min
                $TAT = ceil((strtotime($dtAhora) - strtotime($gCTime)) / 60);
                
                //Agrega registro tiempo
                $sTime = "UPDATE TasksTimes SET dtReleased = '$dtAhora', TAT = '$TAT', Status = 'Closed' "
                        . "WHERE idTasksTimes = '$gIDTT' AND App = 'Tareas' AND IDApp = '$IDTask' AND Process = '$Process' AND Status = 'Open'";
                $isTime = $cnx->query("$sTime");
                
                $LogM = "Se Libero Production ($IDTask)";
                
                //Inserta Log
                $sDesc = "INSERT INTO TasksLogs VALUES('0', '$IDTask', 'Liberacion Production', "
                        . "'$LogM', '$uIDUser', '$uFullName', '$dtAhora')";
                //echo $sDesc . "<BR>";
                $isDesc = $cnx->query("$sDesc");
                
                $MNot = "Se Libero Production $IDTask - $T_TaskName";
                //Inserta Notificacion
                //$sNot = "INSERT INTO Notificacion VALUES('0', '3', '$T_Project', "
                //        . "'$MNot', '$T_idUserCreated', '$T_UserCreated', '$IDTask', 'Tareas', '$dtAhora', '0000-00-00 00:00:00', 'Open')";
                //echo $sNot;
                //$isNot = $cnx->query("$sNot");
                Notificacion(3, $T_Project, $MNot, $T_idUserCreated, $T_UserCreated, $IDTask, "Tareas");
                
                $vATipo = "Verde";
                $vAMensaje = "Se comenzo con el Development...!";
                $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=vEdit&token=$gettoken";
                $vATime = 1000;
                //echo $vRedirect;
                echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                break;
            case "PausedDebug":
                //$LogM = "Se Termino Analisis ($IDTask)";
                //Inserta Log
                //$sDesc = "INSERT INTO TasksLogs VALUES('0', '$IDTask', 'Tarea Aceptada', "
                //        . "'$LogM', '$uIDUser', '$uFullName', '$dtAhora')";
                //echo $sDesc . "<BR>";
                //$isDesc = $cnx->query("$sDesc");
                
                //Actualiza Creador
                $uCreator = "UPDATE Tasks SET datetime = '$dtAhora', Status = 'PausedDebug' WHERE idTask = '$IDTask'";
                //echo $uCreator . "<BR>";
                $iuCreator = $cnx->query("$uCreator");
                
                $Process = "onDebug";
                //Obtiene el Tiempo de inicio
                $sTime = "SELECT idTasksTimes, dtCreated FROM TasksTimes WHERE "
                        . "App = 'Tareas' AND IDApp = '$IDTask' AND Process = '$Process' AND Status = 'Open' ORDER BY idTasksTimes DESC LIMIT 0, 1";
                $rTime = $cnx->query("$sTime")->fetchArray();
                $gIDTT = $rTime['idTasksTimes'];
                $gCTime = $rTime['dtCreated'];
                
                //Min
                $TAT = ceil((strtotime($dtAhora) - strtotime($gCTime)) / 60);
                
                //Agrega registro tiempo
                $sTime = "UPDATE TasksTimes SET dtReleased = '$dtAhora', TAT = '$TAT', Status = 'Closed' "
                        . "WHERE idTasksTimes = '$gIDTT' AND App = 'Tareas' AND IDApp = '$IDTask' AND Process = '$Process' AND Status = 'Open'";
                $isTime = $cnx->query("$sTime");
                
                
                $vATipo = "Verde";
                $vAMensaje = "Se puso en pausa el Debug...!";
                $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=vEdit&token=$gettoken";
                $vATime = 1000;
                //echo $vRedirect;
                echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                break;
            case "StartDebug":
                //$LogM = "Se Termino Analisis ($IDTask)";
                //Inserta Log
                //$sDesc = "INSERT INTO TasksLogs VALUES('0', '$IDTask', 'Tarea Aceptada', "
                //        . "'$LogM', '$uIDUser', '$uFullName', '$dtAhora')";
                //echo $sDesc . "<BR>";
                //$isDesc = $cnx->query("$sDesc");
                
                //Actualiza Creador
                $uCreator = "UPDATE Tasks SET datetime = '$dtAhora', Status = 'onDebug' WHERE idTask = '$IDTask'";
                //echo $uCreator . "<BR>";
                $iuCreator = $cnx->query("$uCreator");
                
                $Process = "onDebug";
                //Obtiene el Tiempo de inicio
                //Agrega registro tiempo
                $sTime = "INSERT INTO TasksTimes VALUES('0', '$T_Project', "
                        . "'$Process', '$uIDUser', '$uFullName', '$IDTask', 'Tareas', '$dtAhora', '0000-00-00 00:00:00', '0', 'Open')";
                //echo $sNot;
                $isTime = $cnx->query("$sTime");
                
                $vATipo = "Verde";
                $vAMensaje = "Se comenzo con el Debugging...!";
                $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=vEdit&token=$gettoken";
                $vATime = 1000;
                //echo $vRedirect;
                echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                break;
            case "sAddPriority":
                $P_IDTask = $_POST['idtask'];
                $P_Priority = $_POST['priority'];
                
                //echo "$P_IDTask - $P_Priority";
                //Busca si existe prioridad
                $sPri = "SELECT * FROM Tasks WHERE GPriority = '$P_Priority' AND Status != 'Closed'";
                $nPri = $cnx->query("$sPri")->numRows();
                
                if($nPri == 0){
                    //No existe esa prioridad ocupada
                    $NPriority = $P_Priority;
                    $uPriority = "UPDATE Tasks SET GPriority = '$P_Priority' WHERE idTask = '$P_IDTask'";
                    //echo $uPriority . "<BR>";
                    $iuPriority = $cnx->query("$uPriority");

                    $LogM = "Se agrego Prioridad ($T_GPriority) ($P_IDTask)";

                    //Inserta Log
                    $sDesc = "INSERT INTO TasksLogs VALUES('0', '$P_IDTask', 'Agrego de Prioridad', "
                            . "'$LogM', '$uIDUser', '$uFullName', '$dtAhora')";
                    //echo $sDesc . "<BR>";
                    $isDesc = $cnx->query("$sDesc");

                    if($T_IdUserAssigned > 0){
                        $MNot = "Se Agrego Prioridad ($T_GPriority) ($P_IDTask)";
                        Notificacion(3, $T_Project, $MNot, $T_IdUserAssigned, $T_UserAssigned, $IDTask, "Tareas");
                    }

                    $vATipo = "Verde";
                    $vAMensaje = "Se Agrego Prioridad con exito...!";
                    $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=Priority&sIV=Home&token=$gettoken";
                    $vATime = 1000;
                    //echo $vRedirect;
                    echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                } else {
                    //Existe ocupada
                    $vATipo = "Rojo";
                    $vAMensaje = "Prioridad Invalida";
                    $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=AddPriority&token=$gettoken";
                    $vATime = 1000;
                    //echo $vRedirect;
                    echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                }
                
                
                
                break;
            case "AddPriority":
                ?>
                <main>
                <center>
                <?php
                //SQL*SELECT IDUser AS valor, CONCAT(FLastName, MLastName, ", ", Name) AS opcion FROM Users ORDER BY FLastName ASC
                $FID = 14;
                $FLink = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=sAddPriority&token=$gettoken";
                echo Formato($FID, $FLink, $X, $vATime);
                ?>
                </center>
                </main>  
                <?php
                break;
            case "dPriority";
                //echo "$T_GPriority -" . $T_TaskName;
                //Actualiza Creador
                $uPriority = "UPDATE Tasks SET GPriority = '0' WHERE idTask = '$IDTask'";
                //echo $uCreator . "<BR>";
                $iuPriority = $cnx->query("$uPriority");
                
                $LogM = "Se Elimino de Prioridad ($T_GPriority) ($IDTask)";
                
                //Inserta Log
                $sDesc = "INSERT INTO TasksLogs VALUES('0', '$IDTask', 'Eliminacion de Prioridad', "
                        . "'$LogM', '$uIDUser', '$uFullName', '$dtAhora')";
                //echo $sDesc . "<BR>";
                $isDesc = $cnx->query("$sDesc");
                
                if($T_IdUserAssigned > 0){
                    $MNot = "Se Elimino de Prioridad ($T_GPriority) ($IDTask)";
                    Notificacion(3, $T_Project, $MNot, $T_IdUserAssigned, $T_UserAssigned, $IDTask, "Tareas");
                }
                
                $vATipo = "Verde";
                $vAMensaje = "Se Elimino Prioridad con exito...!";
                $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=Priority&sIV=Home&token=$gettoken";
                $vATime = 1000;
                //echo $vRedirect;
                echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                
                break;
            case "sErrorVanilla":
                $P_error = $_POST['error'];
                //Actualiza Creador
                $uCreator = "UPDATE Tasks SET dtDebug = '$dtAhora', Status = 'pauseDebug' WHERE idTask = '$IDTask'";
                //echo $uCreator . "<BR>";
                $iuCreator = $cnx->query("$uCreator");
                
                $LogM = "Error Vanilla ($IDTask)";
                
                //Inserta Log
                $sDesc = "INSERT INTO TasksLogs VALUES('0', '$IDTask', 'Error Vanilla', "
                        . "'$LogM', '$uIDUser', '$uFullName', '$dtAhora')";
                //echo $sDesc . "<BR>";
                $isDesc = $cnx->query("$sDesc");
                
                $LogM = "$P_error";
                
                //Inserta Log
                $sDesc = "INSERT INTO TasksLogs VALUES('0', '$IDTask', 'Mensaje Creador', "
                        . "'$LogM', '$uIDUser', '$uFullName', '$dtAhora')";
                //echo $sDesc . "<BR>";
                $isDesc = $cnx->query("$sDesc");
                
                
                $MNot = "Cambio a Vanilla ($P_error) $IDTask - $T_TaskName";
                //Inserta Notificacion
                //$sNot = "INSERT INTO Notificacion VALUES('0', '3', '$T_Project', "
                //        . "'$MNot', '$T_idUserCreated', '$T_UserCreated', '$IDTask', 'Tareas', '$dtAhora', '0000-00-00 00:00:00', 'Open')";
                //echo $sNot;
                //$isNot = $cnx->query("$sNot");
                Notificacion(3, $T_Project, $MNot, $T_idUserCreated, $T_UserCreated, $IDTask, "Tareas");
                
                $vATipo = "Verde";
                $vAMensaje = "Se comenzo con el Development...!";
                $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=vEdit&token=$gettoken";
                $vATime = 1000;
                //echo $vRedirect;
                echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                break;
            case "ErrorVanilla":
                ?>
                <main>
                <center>
                <?php
                //SQL*SELECT IDUser AS valor, CONCAT(FLastName, MLastName, ", ", Name) AS opcion FROM Users ORDER BY FLastName ASC
                $FID = 13;
                $FLink = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=sErrorVanilla&token=$gettoken";
                echo Formato($FID, $FLink, $X, $vATime);
                ?>
                </center>
                </main>  
                <?php
                break;
            case "vClosed":
                //$LogM = "Se Termino Analisis ($IDTask)";
                //Inserta Log
                //$sDesc = "INSERT INTO TasksLogs VALUES('0', '$IDTask', 'Tarea Aceptada', "
                //        . "'$LogM', '$uIDUser', '$uFullName', '$dtAhora')";
                //echo $sDesc . "<BR>";
                //$isDesc = $cnx->query("$sDesc");
                
                //Obtiene las horas
                $sHoras = "SELECT SUM(TAT) AS Min FROM TasksTimes WHERE App = 'Tareas' AND IDApp = '$IDTask'";
                $rHoras = $cnx->query("$sHoras")->fetchArray();
                $Horas = ($rHoras['Min']/60);
                
                //Actualiza Creador
                $uCreator = "UPDATE Tasks SET RequireTimeHrs = '$Horas', dtProduction = '$dtAhora', dtClosed = '$dtAhora', Status = 'Closed' WHERE idTask = '$IDTask'";
                //echo $uCreator . "<BR>";
                $iuCreator = $cnx->query("$uCreator");
                
                $LogM = "Se cerro Tarea ($IDTask)";
                
                //Inserta Log
                $sDesc = "INSERT INTO TasksLogs VALUES('0', '$IDTask', 'Liberacion Vanilla', "
                        . "'$LogM', '$uIDUser', '$uFullName', '$dtAhora')";
                //echo $sDesc . "<BR>";
                $isDesc = $cnx->query("$sDesc");
                
                $MNot = "Se cerro con exito $IDTask - $T_TaskName";
                //Inserta Notificacion
                //$sNot = "INSERT INTO Notificacion VALUES('0', '3', '$T_Project', "
                //        . "'$MNot', '$T_idUserCreated', '$T_UserCreated', '$IDTask', 'Tareas', '$dtAhora', '0000-00-00 00:00:00', 'Open')";
                //echo $sNot;
                //$isNot = $cnx->query("$sNot");
                Notificacion(3, $T_Project, $MNot, $T_IdUserAssigned, $T_UserAssigned, $IDTask, "Tareas");
                
                $vATipo = "Verde";
                $vAMensaje = "Se cerro con exito Tarea...!";
                $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=vEdit&token=$gettoken";
                $vATime = 1000;
                //echo $vRedirect;
                echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                
                break;
            case "RelVanilla":
                //$LogM = "Se Termino Analisis ($IDTask)";
                //Inserta Log
                //$sDesc = "INSERT INTO TasksLogs VALUES('0', '$IDTask', 'Tarea Aceptada', "
                //        . "'$LogM', '$uIDUser', '$uFullName', '$dtAhora')";
                //echo $sDesc . "<BR>";
                //$isDesc = $cnx->query("$sDesc");
                
                //Actualiza Creador
                $uCreator = "UPDATE Tasks SET dtVanilla = '$dtAhora', Status = 'Vanilla' WHERE idTask = '$IDTask'";
                //echo $uCreator . "<BR>";
                $iuCreator = $cnx->query("$uCreator");
                
                $Process = "onDev";
                //Obtiene el Tiempo de inicio
                $sTime = "SELECT idTasksTimes, dtCreated FROM TasksTimes WHERE "
                        . "App = 'Tareas' AND IDApp = '$IDTask' AND Process = '$Process' AND Status = 'Open' ORDER BY idTasksTimes DESC LIMIT 0, 1";
                $rTime = $cnx->query("$sTime")->fetchArray();
                $gIDTT = $rTime['idTasksTimes'];
                $gCTime = $rTime['dtCreated'];
                
                //Min
                $TAT = ceil((strtotime($dtAhora) - strtotime($gCTime)) / 60);
                
                //Agrega registro tiempo
                $sTime = "UPDATE TasksTimes SET dtReleased = '$dtAhora', TAT = '$TAT', Status = 'Closed' "
                        . "WHERE idTasksTimes = '$gIDTT' AND App = 'Tareas' AND IDApp = '$IDTask' AND Process = '$Process' AND Status = 'Open'";
                $isTime = $cnx->query("$sTime");
                
                $LogM = "Se Libero Vanilla ($IDTask)";
                
                //Inserta Log
                $sDesc = "INSERT INTO TasksLogs VALUES('0', '$IDTask', 'Liberacion Vanilla', "
                        . "'$LogM', '$uIDUser', '$uFullName', '$dtAhora')";
                //echo $sDesc . "<BR>";
                $isDesc = $cnx->query("$sDesc");
                
                $MNot = "Se Libero Vanilla $IDTask - $T_TaskName";
                //Inserta Notificacion
                //$sNot = "INSERT INTO Notificacion VALUES('0', '3', '$T_Project', "
                //        . "'$MNot', '$T_idUserCreated', '$T_UserCreated', '$IDTask', 'Tareas', '$dtAhora', '0000-00-00 00:00:00', 'Open')";
                //echo $sNot;
                //$isNot = $cnx->query("$sNot");
                Notificacion(3, $T_Project, $MNot, $T_idUserCreated, $T_UserCreated, $IDTask, "Tareas");
                
                $vATipo = "Verde";
                $vAMensaje = "Se comenzo con el Development...!";
                $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=vEdit&token=$gettoken";
                $vATime = 1000;
                //echo $vRedirect;
                echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                break;
            case "PausedDev":
                //$LogM = "Se Termino Analisis ($IDTask)";
                //Inserta Log
                //$sDesc = "INSERT INTO TasksLogs VALUES('0', '$IDTask', 'Tarea Aceptada', "
                //        . "'$LogM', '$uIDUser', '$uFullName', '$dtAhora')";
                //echo $sDesc . "<BR>";
                //$isDesc = $cnx->query("$sDesc");
                
                //Actualiza Creador
                $uCreator = "UPDATE Tasks SET datetime = '$dtAhora', Status = 'PausedDev' WHERE idTask = '$IDTask'";
                //echo $uCreator . "<BR>";
                $iuCreator = $cnx->query("$uCreator");
                
                $Process = "onDev";
                //Obtiene el Tiempo de inicio
                $sTime = "SELECT idTasksTimes, dtCreated FROM TasksTimes WHERE "
                        . "App = 'Tareas' AND IDApp = '$IDTask' AND Process = '$Process' AND Status = 'Open' ORDER BY idTasksTimes DESC LIMIT 0, 1";
                $rTime = $cnx->query("$sTime")->fetchArray();
                $gIDTT = $rTime['idTasksTimes'];
                $gCTime = $rTime['dtCreated'];
                
                //Min
                $TAT = ceil((strtotime($dtAhora) - strtotime($gCTime)) / 60);
                
                //Agrega registro tiempo
                $sTime = "UPDATE TasksTimes SET dtReleased = '$dtAhora', TAT = '$TAT', Status = 'Closed' "
                        . "WHERE idTasksTimes = '$gIDTT' AND App = 'Tareas' AND IDApp = '$IDTask' AND Process = '$Process' AND Status = 'Open'";
                $isTime = $cnx->query("$sTime");
                
                
                $vATipo = "Verde";
                $vAMensaje = "Se comenzo con el Development...!";
                $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=vEdit&token=$gettoken";
                $vATime = 1000;
                //echo $vRedirect;
                echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                break;
            case "StartDev":
                //$LogM = "Se Termino Analisis ($IDTask)";
                //Inserta Log
                //$sDesc = "INSERT INTO TasksLogs VALUES('0', '$IDTask', 'Tarea Aceptada', "
                //        . "'$LogM', '$uIDUser', '$uFullName', '$dtAhora')";
                //echo $sDesc . "<BR>";
                //$isDesc = $cnx->query("$sDesc");
                
                //Actualiza Creador
                $uCreator = "UPDATE Tasks SET datetime = '$dtAhora', Status = 'onDev' WHERE idTask = '$IDTask'";
                //echo $uCreator . "<BR>";
                $iuCreator = $cnx->query("$uCreator");
                
                $Process = "onDev";
                //Obtiene el Tiempo de inicio
                //Agrega registro tiempo
                $sTime = "INSERT INTO TasksTimes VALUES('0', '$T_Project', "
                        . "'$Process', '$uIDUser', '$uFullName', '$IDTask', 'Tareas', '$dtAhora', '0000-00-00 00:00:00', '0', 'Open')";
                //echo $sNot;
                $isTime = $cnx->query("$sTime");
                
                $vATipo = "Verde";
                $vAMensaje = "Se comenzo con el Development...!";
                $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=vEdit&token=$gettoken";
                $vATime = 1000;
                //echo $vRedirect;
                echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                break;
            case "EndAnalyze":
                $LogM = "Se Termino Analisis ($IDTask)";
                //Inserta Log
                $sDesc = "INSERT INTO TasksLogs VALUES('0', '$IDTask', 'Tarea Aceptada', "
                        . "'$LogM', '$uIDUser', '$uFullName', '$dtAhora')";
                //echo $sDesc . "<BR>";
                $isDesc = $cnx->query("$sDesc");
                
                //Actualiza Creador
                $uCreator = "UPDATE Tasks SET datetime = '$dtAhora', Status = 'PausedDev' WHERE idTask = '$IDTask'";
                //echo $uCreator . "<BR>";
                $iuCreator = $cnx->query("$uCreator");
                
                $Process = "Analyzing";
                //Obtiene el Tiempo de inicio
                $sTime = "SELECT idTasksTimes, dtCreated FROM TasksTimes WHERE "
                        . "App = 'Tareas' AND IDApp = '$IDTask' AND Process = '$Process' AND Status = 'Open' ORDER BY idTasksTimes DESC LIMIT 0, 1";
                $rTime = $cnx->query("$sTime")->fetchArray();
                $gIDTT = $rTime['idTasksTimes'];
                $gCTime = $rTime['dtCreated'];
                
                //Min
                $TAT = ceil((strtotime($dtAhora) - strtotime($gCTime)) / 60);
                
                //Agrega registro tiempo
                $sTime = "UPDATE TasksTimes SET dtReleased = '$dtAhora', TAT = '$TAT', Status = 'Closed' "
                        . "WHERE idTasksTimes = '$gIDTT' AND App = 'Tareas' AND IDApp = '$IDTask' AND Process = '$Process' AND Status = 'Open'";
                $isTime = $cnx->query("$sTime");
                
                
                $vATipo = "Verde";
                $vAMensaje = "Se acepto con exito la tarea...!";
                $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=vEdit&token=$gettoken";
                $vATime = 1000;
                //echo $vRedirect;
                echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                
                
                break;
            case "sStart":
                $P_pdate = $_POST['pdate'];
                
                //Actualiza Creador
                $uCreator = "UPDATE Tasks SET dtStart = '$dtAhora', dtPlanned = '$P_pdate 18:00:00', Status = 'Analyzing' WHERE idTask = '$IDTask'";
                //echo $uCreator . "<BR>";
                $iuCreator = $cnx->query("$uCreator");
                $iVal = $iuCreator->affectedRows();
                
                $LogM = "Se agrego fecha plan ($P_pdate)";
                
                //Inserta Log
                $sDesc = "INSERT INTO TasksLogs VALUES('0', '$IDTask', 'Asignacion Fecha Plan', "
                        . "'$LogM', '$uIDUser', '$uFullName', '$dtAhora')";
                //echo $sDesc . "<BR>";
                $isDesc = $cnx->query("$sDesc");
                
                $MNot = "Se agrego fecha ($P_pdate) plan Tarea $IDTask - $T_TaskName";
                //Inserta Notificacion
                $sNot = "INSERT INTO Notificacion VALUES('0', '3', '$T_Project', "
                        . "'$MNot', '$T_idUserCreated', '$T_UserCreated', '$IDTask', 'Tareas', '$dtAhora', '0000-00-00 00:00:00', 'Open')";
                //echo $sNot;
                $isNot = $cnx->query("$sNot");
                
                $Process = "Analyzing";
                //Agrega registro tiempo
                $sTime = "INSERT INTO TasksTimes VALUES('0', '$T_Project', "
                        . "'$Process', '$uIDUser', '$uFullName', '$IDTask', 'Tareas', '$dtAhora', '0000-00-00 00:00:00', '0', 'Open')";
                //echo $sNot;
                $isTime = $cnx->query("$sTime");

                if($iVal == 1):
                    $vATipo = "Verde";
                    $vAMensaje = "Se realizo con exito asignacion plan tarea...!";
                    $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=vEdit&token=$gettoken";
                    $vATime = 1000;
                    //echo $vRedirect;
                    echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                else:
                    $vATipo = "Rojo";
                    $vAMensaje = "Error al asignar plan...!";
                    $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=vEdit&token=$gettoken";
                    $vATime = 1000;
                    //echo $vRedirect;
                    echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                endif;
                break;
            case "Start":
                ?>
                <main>
                <center>
                <?php
                //SQL*SELECT IDUser AS valor, CONCAT(FLastName, MLastName, ", ", Name) AS opcion FROM Users ORDER BY FLastName ASC
                $FID = 12;
                $FLink = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=sStart&token=$gettoken";
                echo Formato($FID, $FLink, $X, $vATime);
                ?>
                </center>
                </main>  
                <?php
                break;
            case "Accept":
                $LogM = "Tarea Aceptada ($IDTask)";
                //Inserta Log
                $sDesc = "INSERT INTO TasksLogs VALUES('0', '$IDTask', 'Tarea Aceptada', "
                        . "'$LogM', '$uIDUser', '$uFullName', '$dtAhora')";
                //echo $sDesc . "<BR>";
                $isDesc = $cnx->query("$sDesc");
                
                //Actualiza Creador
                $uCreator = "UPDATE Tasks SET dtAccepted = '$dtAhora', datetime = '$dtAhora', Status = 'Waiting' WHERE idTask = '$IDTask'";
                //echo $uCreator . "<BR>";
                $iuCreator = $cnx->query("$uCreator");
                
                $MNot = "Tarea $IDTask - $T_TaskName Aceptada";
                $sNot = "INSERT INTO Notificacion VALUES('0', '3', '$T_Project', "
                        . "'$MNot', '$T_idUserCreated', '$T_UserCreated', '$IDTask', 'Tareas', '$dtAhora', '0000-00-00 00:00:00', 'Open')";
                //echo $sNot;
                $isNot = $cnx->query("$sNot");
                

                $vATipo = "Verde";
                $vAMensaje = "Se acepto con exito la tarea...!";
                $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=vEdit&token=$gettoken";
                $vATime = 1000;
                //echo $vRedirect;
                echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                
                
                break;
            case "sAddFile":
                //Archivo
                $nombre_archivo = $_FILES['ufile']['name']; 
		$tipo_archivo = $_FILES['ufile']['type'];
		$linkfile = "TaskFiles/" . $nombre_archivo; 
                $gTitFile = $_POST['title'];
                
                $extension = strtolower(substr($nombre_archivo, strrpos($nombre_archivo, '.' )+1));
                
                //echo $extension . "<br>" . $linkfile;
                
                if($gTitFile != ""){
                    //Sube el archivo
                    if (move_uploaded_file($_FILES['ufile']['tmp_name'], $linkfile)){
                        $smid = "SELECT MAX(idFiles) AS mid FROM Files";
                        $rmid = $cnx->query("$smid")->fetchArray();
                        $ID = $rmid['mid'] + 1;
                        $filex = "Task_" . $IDTask . "_" . $ID . "." . $extension;
                        $link = "TaskFiles/" . $filex;
                        
                        copy($linkfile, $link);
                        unlink($linkfile);
                        //Actualiza el archivo
                        $siFile = "INSERT INTO Files VALUES("
                                . "'$ID', 'Tareas', '$IDTask', '$link', '$gTitFile', "
                                . "'$uIDUser', '$uFullName', 'Active', '$dtAhora'"
                                . ")";
                        $iFile = $cnx->query("$siFile");
                        
                        $LogM = "Archivo Agregado ($ID - $gTitFile)";
                        //Inserta Log
                        $sDesc = "INSERT INTO TasksLogs VALUES('0', '$IDTask', 'Archivo Agregado', "
                                . "'$LogM', '$uIDUser', '$uFullName', '$dtAhora')";
                        //echo $sDesc . "<BR>";
                        $isDesc = $cnx->query("$sDesc");
                        
                        $vATipo = "Verde";
                        $vAMensaje = "Se agrego archivo con exito a tarea...!";
                        $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=vEdit&token=$gettoken";
                        $vATime = 1000;
                        //echo $vRedirect;
                        echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                        
                    } else {
                        $vATipo = "Rojo";
                        $vAMensaje = "Error al subir archivo...!";
                        $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=vEdit&token=$gettoken";
                        $vATime = 1000;
                        //echo $vRedirect;
                        echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                    }
                
                } else {
                    $vATipo = "Rojo";
                    $vAMensaje = "Valor Titulo Invalido...!";
                    $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=vEdit&token=$gettoken";
                    $vATime = 1000;
                    //echo $vRedirect;
                    echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                }
                break;
            case "AddFile":
                ?>
                <main>
                <center>
                <?php
                //SQL*SELECT IDUser AS valor, CONCAT(FLastName, MLastName, ", ", Name) AS opcion FROM Users ORDER BY FLastName ASC
                $FID = 11;
                $FLink = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=sAddFile&token=$gettoken";
                echo Formato($FID, $FLink, $X, $vATime);
                ?>
                </center>
                </main>  
                <?php
                break;
            case "sAssignOwner":
                $P_iduser = $_POST['iduser'];
                $s_iUser = "SELECT * FROM Users WHERE IDUser = '$P_iduser'";
                $iUser = $cnx->query("$s_iUser")->fetchArray();
                //Todas las columnas
                //print_r($iTar);
                foreach ($iUser as $key => $value) {
                    $Col = "iU_" . $key;
                    $$Col = $value;
                    //echo $Col . "-" . $$Col . "<BR>";
                }
                $iU_FullName = "$iU_FLastName $iU_MLastName, $iU_Name";
                
                //Actualiza Creador
                $uCreator = "UPDATE Tasks SET dtAssigned = '$dtAhora', idUserAssigned = '$iU_IDUser', UserAssigned = '$iU_FullName' WHERE idTask = '$IDTask'";
                //echo $uCreator . "<BR>";
                $iuCreator = $cnx->query("$uCreator");
                $iVal = $iuCreator->affectedRows();
                
                $LogM = "Asignacion Due&ntilde;o ($iU_FullName)";
                
                //Inserta Log
                $sDesc = "INSERT INTO TasksLogs VALUES('0', '$IDTask', 'Asignacion Due&ntilde;o', "
                        . "'$LogM', '$uIDUser', '$uFullName', '$dtAhora')";
                //echo $sDesc . "<BR>";
                $isDesc = $cnx->query("$sDesc");
                
                $MNot = "Se te asigno accion para cerrar Tarea $IDTask - $T_TaskName";
                //Inserta Notificacion
                $sNot = "INSERT INTO Notificacion VALUES('0', '3', '$T_Project', "
                        . "'$MNot', '$iU_IDUser', '$iU_FullName', '$IDTask', 'Tareas', '$dtAhora', '0000-00-00 00:00:00', 'Open')";
                //echo $sNot;
                $isNot = $cnx->query("$sNot");
                
                //$iDesc = $cnx->query("$sDesc");
                //$iTask = $cnx->query("$sTask");
                //$iVal = $iDesc->affectedRows();

                if($iVal == 1):
                    $vATipo = "Verde";
                    $vAMensaje = "Se realizo con exito asignacion tarea...!";
                    $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=vEdit&token=$gettoken";
                    $vATime = 1000;
                    //echo $vRedirect;
                    echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                else:
                    $vATipo = "Rojo";
                    $vAMensaje = "Error al asignar due&ntilde;o...!";
                    $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=AssignOwner&token=$gettoken";
                    $vATime = 1000;
                    //echo $vRedirect;
                    echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                endif;
                break;
            case "AssignOwner":
                ?>
                <main>
                <center>
                <?php
                //SQL*SELECT IDUser AS valor, CONCAT(FLastName, MLastName, ", ", Name) AS opcion FROM Users ORDER BY FLastName ASC
                $FID = 10;
                $FLink = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=sAssignOwner&token=$gettoken";
                echo Formato($FID, $FLink, $X, $vATime);
                ?>
                </center>
                </main>  
                <?php
                break;
                break;
            case "schCreator":
                $P_iduser = $_POST['iduser'];
                $s_iUser = "SELECT * FROM Users WHERE IDUser = '$P_iduser'";
                $iUser = $cnx->query("$s_iUser")->fetchArray();
                //Todas las columnas
                //print_r($iTar);
                foreach ($iUser as $key => $value) {
                    $Col = "iU_" . $key;
                    $$Col = $value;
                    //echo $Col . "-" . $$Col . "<BR>";
                }
                $iU_FullName = "$iU_FLastName $iU_MLastName, $iU_Name";
                
                //Actualiza Creador
                $uCreator = "UPDATE Tasks SET idUserCreated = '$iU_IDUser', UserCreated = '$iU_FullName' WHERE idTask = '$IDTask'";
                //echo $uCreator . "<BR>";
                $iuCreator = $cnx->query("$uCreator");
                $iVal = $iuCreator->affectedRows();
                
                $LogM = "Cambio Creador ($iU_FullName)";
                
                //Inserta Log
                $sDesc = "INSERT INTO TasksLogs VALUES('0', '$IDTask', 'Cambio Creador', "
                        . "'$LogM', '$uIDUser', '$uFullName', '$dtAhora')";
                //echo $sDesc . "<BR>";
                $isDesc = $cnx->query("$sDesc");
                
                $MNot = "Se te asigno seguimiento Tarea $IDTask - $T_TaskName";
                //Inserta Notificacion
                $sNot = "INSERT INTO Notificacion VALUES('0', '3', '$T_Project', "
                        . "'$MNot', '$iU_IDUser', '$iU_FullName', '$IDTask', 'Tareas', '$dtAhora', '0000-00-00 00:00:00', 'Open')";
                //echo $sNot;
                $isNot = $cnx->query("$sNot");
                
                //$iDesc = $cnx->query("$sDesc");
                //$iTask = $cnx->query("$sTask");
                //$iVal = $iDesc->affectedRows();

                if($iVal == 1):
                    $vATipo = "Verde";
                    $vAMensaje = "Se realizo con exito cambio creador...!";
                    $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=vEdit&token=$gettoken";
                    $vATime = 1000;
                    //echo $vRedirect;
                    echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                else:
                    $vATipo = "Rojo";
                    $vAMensaje = "Error al agregar Creador...!";
                    $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=chCreator&token=$gettoken";
                    $vATime = 1000;
                    //echo $vRedirect;
                    echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                endif;
                
                break;
            case "chCreator":
                //$IDTask = base64_decode($_GET['token']);
                //$gettoken = base64_encode($IDTask);
                ?>
                <main>
                <center>
                <?php
                //SQL*SELECT IDUser AS valor, CONCAT(FLastName, MLastName, ", ", Name) AS opcion FROM Users ORDER BY FLastName ASC
                $FID = 9;
                $FLink = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=schCreator&token=$gettoken";
                echo Formato($FID, $FLink, $X, $vATime);
                ?>
                </center>
                </main>  
                <?php
                break;
            case "sAddMessage":
                
                ?>
                <main>
                <center>
                <?php
                //Ve el formato
                $FID = 8;
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

                if($P_message != ""){
                    //Si es usuario
                    if($uIDUser == $T_IdUserAssigned){
                        $tmess = "Mensaje Due&ntilde;o";
                    } else {
                        if($uIDUser == $T_idUserCreated){
                            $tmess = "Mensaje Creador";
                        } else {
                            $tmess = "Mensaje " . $uAccount;
                        }
                    }
                    
                    //Inserta descripcion
                    $sDesc = "INSERT INTO TasksLogs VALUES('0', '$IDTask', '$tmess', "
                            . "'$P_message', '$uIDUser', '$uFullName', '$dtAhora')";
                    $iDesc = $cnx->query("$sDesc");
                    //$iTask = $cnx->query("$sTask");
                    $iVal = $iDesc->affectedRows();
                    
                    if($iVal == 1):
                        $vATipo = "Verde";
                        $vAMensaje = "Se agrego con exito Mensaje...!";
                        $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=vEdit&token=$gettoken";
                        $vATime = 1000;
                        //echo $vRedirect;
                        echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                    else:
                        $vATipo = "Rojo";
                        $vAMensaje = "Error al agregar Tarea...!";
                        $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=AddMessage&token=$gettoken";
                        $vATime = 1000;
                        //echo $vRedirect;
                        echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                    endif;
                    
                    
                } else {
                    $vATipo = "Rojo";
                    $vAMensaje = "Valores invalidos...!";
                    $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=AddMessage&token=$gettoken";
                    $vATime = 1000;
                    //echo $vRedirect;
                    echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                }
                
                ?>
                </center>
                </main>  
                <?php
                
                break;
            case "AddMessage":
                //$IDTask = base64_decode($_GET['token']);
                //$gettoken = base64_encode($IDTask);
                ?>
                <main>
                <center>
                <?php
                $FID = 8;
                $FLink = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=sAddMessage&token=$gettoken";
                echo Formato($FID, $FLink, $X, $vATime);
                ?>
                </center>
                </main>  
                <?php
                break;
            case "vEdit":
                //Formato completo
                //$IDTask = base64_decode($_GET['token']);
                //$gettoken = base64_encode($IDTask);
                //echo $IDTask;
                $eForm = "EditTarea";
                include("Include/eForms.php");
                
                break;
        }
        break;
    case "AddTask":
        switch ($sIV){
            case "sAddTask":
                ?>
                <main>
                <center>
                <?php
                //Ve el formato
                $FID = 7;
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

                if($P_title != ""){
                    //Valida si existe tarea
                    $sTarea = "SELECT * FROM Tasks WHERE TaskName LIKE '$P_title'";
                    
                    $nTask = $cnx->query("$sTarea")->numRows();
                    //$cantCust = $ECust->numRows();
                    
                    //echo "Numero Tareas:" . $nTask;
                    if($nTask == 0){
                        $nDate = "0000-00-00 00:00:00";
                        //Trae idproyecto
                        $sProject = "SELECT Project FROM Projects WHERE idProject LIKE '$P_idproject' ORDER BY Project ASC LIMIT 0, 1";
                        $iProject = $cnx->query("$sProject")->fetchArray();
                        $P_Project = $iProject['Project'];
                        
                        $smid = "SELECT MAX(idTask) AS mid FROM Tasks";
                        $imid = $cnx->query("$smid")->fetchArray();
                        $gIDTask = $imid['mid'] + 1;
                        
                        //Agregar Cliente
                        $sTask = "INSERT INTO Tasks VALUES("
                                . "'$gIDTask', '$dtAhora', '$P_idproject', '$P_Project', '$P_typetask', '$P_title', "
                                . "'0', '0', '0', '$uIDUser', '$uFullName', '0', "
                                . "'', '0', '0', '$nDate', '$nDate', '$nDate', '$nDate', '$nDate', "
                                . "'$nDate', '$nDate', '$nDate', 'Open', '0', '$dtAhora'"
                                . ")";
                        //$iCust = $cnx->query('INSERT INTO Customers VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)', '0', $P_type, $P_razonsocial, $P_phone, $P_mobile, $P_email, $P_rfc, $P_address, $P_address2, $P_city, $P_state, $P_country, $P_postalcode, $P_c_name, $P_c_lastname, $P_c_mobile, $P_c_phone, $p_c_email, $P_notes, $dateToday, $uIDUser, '1');
                        $iTask = $cnx->query("$sTask");
                        $iVal = $iTask->affectedRows();
                        
                        //Inserta descripcion
                        $sDesc = "INSERT INTO TasksLogs VALUES('0', '$gIDTask', 'Descripcion', "
                                . "'$P_descripcion', '$uIDUser', '$uFullName', '$dtAhora')";
                        $iDesc = $cnx->query("$sDesc");
                        
                        //Notificacion
                        Notificacion(3, $P_Project, $P_title, 1, "Chavez Villalba, Mario Alberto", $gIDTask, "Tareas");

                        //echo $iTask;
                        
                        if($iVal == 1):
                            $vATipo = "Verde";
                            $vAMensaje = "Se agrego con exito Tarea...!";
                            $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=Home&sIV=Home";
                            $vATime = 1000;
                            //echo $vRedirect;
                            echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                        else:
                            $vATipo = "Rojo";
                            $vAMensaje = "Error al agregar Tarea...!";
                            $vRedirect = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=Home";
                            $vATime = 1000;
                            //echo $vRedirect;
                            echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                        endif;
                        
                        
                    } else {
                        $vATipo = "Rojo";
                        $vAMensaje = "Tarea Existente...!";
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
                $FID = 7;
                $FLink = "index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=sAddTask";
                echo Formato($FID, $FLink, $X, $vATime);
                ?>
                </center>
                </main>  
                <?php
                break;
        }
        break;
    case "Closed":
        //echo "Aqui";
        ?>
        <main>
        <center>
        <?php
        $LID = 4;
        $IDOption = "IdTask";
        //Obrtiene usuarios
        if(isset($_GET['search'])){
            if($_GET['search'] == 1){
                $frase = $_POST['search'];
                //$lfrase = "$frase";
                $star = "SELECT IdTask, IdTask AS IDTarea, GPriority AS P, TaskName AS Tarea, Project AS Proyecto, "
                        . "DATE(dtCreated) AS Fecha, UserCreated AS Creador, Status, TypeTask "
                        . "FROM Tasks WHERE (Project LIKE '$frase' OR TaskName LIKE '%$frase%' "
                        . "OR IDTask = '$frase' OR TypeTask LIKE '$frase') AND Status != 'Closed' AND GPriority > 0 ORDER BY dtCreated ASC";
                $LRows = $cnx->query("$star")->fetchAll();
            }
            
        } else {
            $star = "SELECT IdTask, IdTask AS IDTarea, GPriority AS P, TaskName AS Tarea, Project AS Proyecto, "
                    . "DATE(dtCreated) AS Fecha, UserCreated AS Creador, Status, TypeTask "
                    . "FROM Tasks WHERE Status = 'Closed' ORDER BY dtCreated ASC LIMIT 0, 100";
            $LRows = $cnx->query("$star")->fetchAll();
        
        }
        
        //Depende cuenta
        $ALinks[] = array('s_icon', '20', 'Images/Edit.svg', "index.php?sI=$sI&sII=$sII&sIII=EditTask&sIV=vEdit", '_self', 'Editar Tarea');
        //$ALinks[] = array('s_icon', '20', 'Images/Trash.svg', "index.php?sI=$sI&sII=$sII&sIII=EditTask&sIV=vDelete", '_self', 'Eliminar Cliente');
        //$ALinks[] = array('s_icon', '20', 'Images/Messages.svg', "index.php?sI=$sI&sII=$sII&sIII=Messages&sIV=Home", '_self', 'Ver Ordenes');
        
        //$FLink = "index.php?sI=$sI&sII=$sII&sIII=sUser&sIV=$sIV";
        echo Lista($LID, $LRows, $IDOption, $ALinks);
        ?>
        </center>
        </main>  
        <?php
        break;
    case "Priority":
        //echo "Aqui";
        ?>
        <main>
        <center>
        <?php
        //Depende cuenta
        $ALinks[] = array('s_icon', '20', 'Images/Edit.svg', "index.php?sI=$sI&sII=$sII&sIII=EditTask&sIV=vEdit", '_self', 'Editar Tarea');
        //$ALinks[] = array('s_icon', '20', 'Images/Trash.svg', "index.php?sI=$sI&sII=$sII&sIII=EditTask&sIV=vDelete", '_self', 'Eliminar Cliente');
        //$ALinks[] = array('s_icon', '20', 'Images/Messages.svg', "index.php?sI=$sI&sII=$sII&sIII=Messages&sIV=Home", '_self', 'Ver Ordenes');
        
        
        
        $LID = 7;
        $IDOption = "IdTask";
        
        //Obrtiene usuarios
        if(isset($_GET['search'])){
            if($_GET['search'] == 1){
                $frase = $_POST['search'];
                //$lfrase = "$frase";
                $star = "SELECT IdTask, GPriority AS P, TaskName AS Tarea, Project AS Proyecto, "
                        . "DATE(dtCreated) AS Fecha, UserCreated AS Creador, Status, TypeTask "
                        . "FROM Tasks WHERE (Project LIKE '$frase' OR TaskName LIKE '%$frase%' "
                        . "OR IDTask = '$frase' OR TypeTask LIKE '$frase') AND Status != 'Closed' AND GPriority > 0 ORDER BY dtCreated ASC";
                $LRows = $cnx->query("$star")->fetchAll();
            }
            
        } else {
            $star = "SELECT IdTask, GPriority AS P, TaskName AS Tarea, Project AS Proyecto, "
                    . "DATE(dtCreated) AS Fecha, UserCreated AS Creador, Status, TypeTask "
                    . "FROM Tasks WHERE GPriority > 0 AND Status != 'Closed' ORDER BY GPriority ASC";
            $LRows = $cnx->query("$star")->fetchAll();
        
        }
        
        $nRows = $cnx->query("$star")->numRows();
        //echo $nRows;
        
        if($uAccount == "Admin" OR $uAccount == "SuperUser"){
            $ALinksX[] = array('LinkRojo', '30', 'Images/Edit.svg', "index.php?sI=$sI&sII=$sII&sIII=EditTask&sIV=EditPriority&token=$gettoken", '_self', 'Editar Prioridades', 'red', 'white');
            
            if($nRows < 10){
                $ALinksX[] = array('LinkRojo', '30', 'Images/Edit.svg', "index.php?sI=$sI&sII=$sII&sIII=EditTask&sIV=AddPriority&token=$gettoken", '_self', 'Agregar Prioridades', 'red', 'white');
            }
            echo "<BR>" . FLink($ALinksX);
            $ALinks[] = array('s_icon', '20', 'Images/logout.svg', "index.php?sI=$sI&sII=$sII&sIII=EditTask&sIV=dPriority", '_self', 'Eliminar Prioridad');
        
        }
        
        //$FLink = "index.php?sI=$sI&sII=$sII&sIII=sUser&sIV=$sIV";
        echo Lista($LID, $LRows, $IDOption, $ALinks);
        ?>
        </center>
        </main>  
        <?php
        break;
    case "Vanilla":
        //echo "Aqui";
        ?>
        <main>
        <center>
        <?php
        $LID = 4;
        $IDOption = "IdTask";
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
            $star = "SELECT IdTask, IdTask AS IDTarea, GPriority AS P, TaskName AS Tarea, Project AS Proyecto, "
                    . "DATE(dtCreated) AS Fecha, UserCreated AS Creador, Status, TypeTask "
                    . "FROM Tasks WHERE Status = 'Vanilla' OR Status = 'Production' ORDER BY dtCreated ASC";
            $LRows = $cnx->query("$star")->fetchAll();
        }
        
        //Depende cuenta
        $ALinks[] = array('s_icon', '20', 'Images/Edit.svg', "index.php?sI=$sI&sII=$sII&sIII=EditTask&sIV=vEdit", '_self', 'Editar Tarea');
        //$ALinks[] = array('s_icon', '20', 'Images/Trash.svg', "index.php?sI=$sI&sII=$sII&sIII=EditTask&sIV=vDelete", '_self', 'Eliminar Cliente');
        //$ALinks[] = array('s_icon', '20', 'Images/Messages.svg', "index.php?sI=$sI&sII=$sII&sIII=Messages&sIV=Home", '_self', 'Ver Ordenes');
        
        //$FLink = "index.php?sI=$sI&sII=$sII&sIII=sUser&sIV=$sIV";
        echo Lista($LID, $LRows, $IDOption, $ALinks);
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
        $LID = 4;
        $IDOption = "IdTask";
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
            $star = "SELECT IdTask, IdTask AS IDTarea, GPriority AS P, TaskName AS Tarea, Project AS Proyecto, "
                    . "DATE(dtCreated) AS Fecha, UserCreated AS Creador, Status, TypeTask "
                    . "FROM Tasks WHERE Status != 'Closed' AND Status != 'Vanilla' AND Status != 'Production' ORDER BY dtCreated ASC";
            $LRows = $cnx->query("$star")->fetchAll();
        }
        
        //Depende cuenta
        $ALinks[] = array('s_icon', '20', 'Images/Edit.svg', "index.php?sI=$sI&sII=$sII&sIII=EditTask&sIV=vEdit", '_self', 'Editar Tarea');
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