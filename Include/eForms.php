<?php
//Depende eForm
switch ($eForm):
    case "EditPPV":
        if($uAccount == "Buyer"){
            //Alerta yellow
            $vATipo = "Amarillo";
            $vAMensaje = "Please complete the questionare";
            $vRedirect = 0;
            //$vATime = 3000;
            echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
        }
        
        //Obtiene Informacion
        //Obtiene los mensajes
        $s_iLog = "SELECT UserCreated, TypeLog, datetime FROM TasksLogs WHERE idTask = '$IDTask' ORDER BY datetime DESC";
        $LLogs = $cnx->query("$s_iLog")->fetchAll();
        
        $s_iMess = "SELECT * FROM PPVLogs WHERE idPPV = '$IDPPV' AND Message > 0 ORDER BY datetime DESC";
        $LMess = $cnx->query("$s_iMess")->fetchAll();
        
        //Obtiene los archivos
        $s_iFile = "SELECT * FROM Files WHERE App = 'PPV' AND idApp = '$IDTask' ORDER BY datetime DESC";
        $LFiles = $cnx->query("$s_iFile")->fetchAll();
        
        //Verifica existe notas...
        $sQNotes = "SELECT * FROM PPVLogs WHERE TypeLog = 'Quote Notes Added' AND idPPV = '$IDPPV'";
        $nQNotes = $cnx->query($sQNotes)->numRows();
        //N print_r($LLogs);
        
        $links_op = "";
        switch ($pp_Status){
            case "DraftPPV":
                $cSt = "blue";
                if($uAccount == "Buyer" || $uAccount == "Admin" || $uAccount == "SuperUser"){
                    $links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=AddPODraft&token=$gettoken' target='_self'>Add PO</a><br>";
                }
                break;
            case "Requote":
                $cSt = "Orange";
                if($uAccount == "CSR" || $uAccount == "Admin" || $uAccount == "SuperUser"){
                    $links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=AddNoCustPO&token=$gettoken' target='_self'>No Customer PO</a><br>";
                }
                break;
            case "ApprovePermanent":
                $cSt = "Orange";
                if($uAccount == "CSR" || $uAccount == "Admin" || $uAccount == "SuperUser"){
                    $links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=AddNoCustPO&token=$gettoken' target='_self'>No Customer PO</a><br>";
                    $links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=AddSONumber&token=$gettoken' target='_self'>Add SO Number</a><br>";    
                        
                }
                break;
            case "Permanent":
                $cSt = "Orange";
                if($uAccount == "Sourcing Manager" || $uAccount == "Admin" || $uAccount == "SuperUser"){
                    $links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=PaidPermanent&token=$gettoken' target='_self'>Approve Permanent</a><br>";
                    $links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=RejPermanent&token=$gettoken' target='_self'>Reject Permanent</a><br>";
                    //$links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=Requote&token=$gettoken' target='_self'>Reject Permanent</a><br>";
                }
                break;
            case "WaitingPayment":
                $cSt = "green";
                //Solo si es Dueno
                if($uAccount == "Accounts Receivable" || $uAccount == "Admin" || $uAccount == "SuperUser"){
                    //Revisa PO End Customer
                    $links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=PaymentConfirmation&token=$gettoken' target='_self'>Payment Confirmation</a><br>";    
                }
                break;
            case "WaitingInvoice":
                $cSt = "green";
                //Solo si es Dueno
                if($uAccount == "Accounts Receivable" || $uAccount == "Admin" || $uAccount == "SuperUser"){
                    //Revisa PO End Customer
                    $links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=AddInvoice&token=$gettoken' target='_self'>Add Invoice</a><br>";    
                }
                break;
            case "EndCustomerCost":
            case "PaidPermanent":
                $cSt = "green";
                //Solo si es Dueno
                if($uAccount == "CSR" || $uAccount == "Admin" || $uAccount == "SuperUser"){
                    //Revisa PO End Customer
                    $links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=AddNoCustPO&token=$gettoken' target='_self'>No Customer PO</a><br>";
                    $links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=AddSONumber&token=$gettoken' target='_self'>Add SO Number</a><br>";    
                }
                break;
            case "MasterWorkCost":
                $cSt = "orange";
                //Solo si es Dueno
                if($uAccount == "Purchasing Manager" || $uAccount == "Admin" || $uAccount == "SuperUser"){
                    //Approval or Reject
                    $links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=MWCApprove&token=$gettoken' target='_self'>Approve</a><br>";
                    $links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=MWCReject&token=$gettoken' target='_self'>Reject</a><br>";
                }
                break;
            case "RevCoverCost":
                $cSt = "DarkSeaGreen";
                if($uAccount == "Purchasing Leader" || $uAccount == "Admin" || $uAccount == "SuperUser"){
                    $links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=MasterWorkCost&token=$gettoken' target='_self'>Masterwork Cost</a><br>";
                    $links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=EndCustomerCost&token=$gettoken' target='_self'>End Customer Cost</a><br>";
                }
                break;
            case "OneTime":
                $cSt = "DarkSeaGreen";
                if($uAccount == "Buyer" || $uAccount == "Admin" || $uAccount == "SuperUser"){
                    if($nPO < 1){
                        $links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=AddPO&token=$gettoken' target='_self'>Add PO</a><br>";
                        //N $links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=ReqApprQuote&token=$gettoken' target='_self'>Request Approval (No Quotes)</a><br>";
                    } else {
                        //N $links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=AddFile&token=$gettoken' target='_self'>Add Quote</a><br>";
                        $links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=RevCoverCost&token=$gettoken' target='_self'>Review Cover Cost</a><br>";
                    }
                }
                break;
            case "NQRejected":
                $cSt = "red";
                if($uAccount == "Buyer" || $uAccount == "Admin" || $uAccount == "SuperUser"){
                    if($nQt < 3){
                        $links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=AddQuote&token=$gettoken' target='_self'>Add Quote</a><br>";
                        //N $links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=ReqApprQuote&token=$gettoken' target='_self'>Request Approval (No Quotes)</a><br>";
                    } else {
                        $links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=AddQuote&token=$gettoken' target='_self'>Add Quote</a><br>";
                        $links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=OneTime&token=$gettoken' target='_self'>One Time</a><br>";
                        $links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=Permanent&token=$gettoken' target='_self'>Permanent</a><br>";
                    }
                }
                break;
            case "NQApproved":
                $cSt = "gray";
                //Solo si es Dueno
                if($uAccount == "Buyer" || $uAccount == "Admin" || $uAccount == "SuperUser"){
                    //Approval or Reject
                    $links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=OneTime&token=$gettoken' target='_self'>One Time</a><br>";
                    $links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=Permanent&token=$gettoken' target='_self'>Permanent</a><br>";
                }
                break;
            case "NQApproval":
                $cSt = "orange";
                //Solo si es Dueno
                if($uAccount == "Purchasing Leader" || $uAccount == "Admin" || $uAccount == "SuperUser"){
                    //Approval or Reject
                    $links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=NQApprove&token=$gettoken' target='_self'>Approve</a><br>";
                    $links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=NQReject&token=$gettoken' target='_self'>Reject</a><br>";
                }
                break;
            case "RejectPermanent":
            case "Open":
            case "OpenPPV":
                
                $cSt = "black";
                //Solo si es Dueno
                if($uAccount == "Buyer" || $uAccount == "Admin" || $uAccount == "SuperUser"){
                    if($nQt >= 1 || $nQNotes == 1){
                        $links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=AddQuote&token=$gettoken' target='_self'>Add Quote</a><br>";
                        $links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=OneTime&token=$gettoken' target='_self'>One Time</a><br>";
                        $links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=Permanent&token=$gettoken' target='_self'>Permanent</a><br>";
                    } else {
                        $links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=AddQuote&token=$gettoken' target='_self'>Add File Quotes</a><br>";
                        $links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=AddQuoteNotes&token=$gettoken' target='_self'>Add Quotes Notes</a><br>";
                        $links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=NoQuotes&token=$gettoken' target='_self'>No Quotes</a><br>";
                        //$links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=ReqApprQuote&token=$gettoken' target='_self'>Request Approval (No Quotes)</a><br>";
                    }
                }
                $links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=AddPO&token=$gettoken' target='_self'>Add PO</a><br>";
                        
                //* n $links_op .= "<a href='Print.php?page=$eForm&token=$gettoken' class='linklr' target='_blank'>Imprimir</a>";
                
                break;
            case "Waiting":
                $cSt = "purple";
                if($uIDUser == $T_IdUserAssigned){
                    $links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=Start&token=$gettoken' target='_self'>Comenzar Tarea</a><br>";
                }
                
                if($uAccount == "Admin" OR $uAccount == "SuperUser"){
                    $links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=AddFile&token=$gettoken' target='_self'>Agregar Archivo</a><br>";
                    //$links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=AssignOwner&token=$gettoken' target='_self'>Asignar Due&ntilde;o</a><br>";
                    $links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=chCreator&token=$gettoken' target='_self'>Cambiar Creador</a><br>";
                    //$links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=chTypeTask&token=$gettoken' target='_self'>Cambiar Tipo Tarea</a><br>";
                    //$links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=Delete&token=$gettoken' target='_self'>Eliminar Tarea</a><br>";
                } else {
                    if($uIDUser == $T_idUserCreated OR $uIDUser == $T_IdUserAssigned){
                        $links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=AddFile&token=$gettoken' target='_self'>Agregar Archivo</a><br>";
                    }
                }
                
                
                break;
            case "Closed":
                $cSt = "#005769";
                break;
            default:
                break;
        }
        
        $s_DTar = "SELECT DetailLog, datetime, UserCreated FROM TasksLogs WHERE idTask = '$IDTask' AND TypeLog = 'Descripcion'";
        $dTar = $cnx->query("$s_DTar")->fetchArray();
        $T_L_Descripcion = $dTar['DetailLog'];
        $T_L_UserCreated = $dTar['UserCreated'];
        $T_L_datetime = $dTar['datetime'];
        
        include("Forms/EditPPV.php");
        break;
    case "EditTarea":
        //Obtiene Informacion
        //Obtiene los mensajes
        $s_iLog = "SELECT UserCreated, TypeLog, datetime FROM TasksLogs WHERE idTask = '$IDTask' ORDER BY datetime DESC";
        $LLogs = $cnx->query("$s_iLog")->fetchAll();
        
        $s_iMess = "SELECT * FROM TasksLogs WHERE idTask = '$IDTask' AND TypeLog LIKE 'Mensaje%' ORDER BY datetime DESC";
        $LMess = $cnx->query("$s_iMess")->fetchAll();
        
        //Obtiene los archivos
        $s_iFile = "SELECT * FROM Files WHERE App = 'Tareas' AND idApp = '$IDTask' ORDER BY datetime DESC";
        $LFiles = $cnx->query("$s_iFile")->fetchAll();
        
        
        //print_r($LLogs);
        
        $links_op = "";
        switch ($T_Status){
            case "Open":
                $cSt = "black";
                //Solo si es Dueno
                if($uIDUser == $T_IdUserAssigned){
                    $links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=Accept&token=$gettoken' target='_self'>Aceptar Tarea</a><br>";
                }
                
                
                if($uAccount == "Admin" OR $uAccount == "SuperUser"){
                    $links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=AddFile&token=$gettoken' target='_self'>Agregar Archivo</a><br>";
                    $links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=AssignOwner&token=$gettoken' target='_self'>Asignar Due&ntilde;o</a><br>";
                    $links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=chCreator&token=$gettoken' target='_self'>Cambiar Creador</a><br>";
                    //$links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=chTypeTask&token=$gettoken' target='_self'>Cambiar Tipo Tarea</a><br>";
                    //$links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=Delete&token=$gettoken' target='_self'>Eliminar Tarea</a><br>";
                } else {
                    if($uIDUser == $T_idUserCreated OR $uIDUser == $T_IdUserAssigned){
                        $links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=AddFile&token=$gettoken' target='_self'>Agregar Archivo</a><br>";
                    }
                }
                
                
                
                $links_op .= "<a href='Print.php?page=$eForm&token=$gettoken' class='linklr' target='_blank'>Imprimir</a>";
                
                break;
            case "Waiting":
                $cSt = "purple";
                if($uIDUser == $T_IdUserAssigned){
                    $links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=Start&token=$gettoken' target='_self'>Comenzar Tarea</a><br>";
                }
                
                if($uAccount == "Admin" OR $uAccount == "SuperUser"){
                    $links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=AddFile&token=$gettoken' target='_self'>Agregar Archivo</a><br>";
                    //$links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=AssignOwner&token=$gettoken' target='_self'>Asignar Due&ntilde;o</a><br>";
                    $links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=chCreator&token=$gettoken' target='_self'>Cambiar Creador</a><br>";
                    //$links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=chTypeTask&token=$gettoken' target='_self'>Cambiar Tipo Tarea</a><br>";
                    //$links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=Delete&token=$gettoken' target='_self'>Eliminar Tarea</a><br>";
                } else {
                    if($uIDUser == $T_idUserCreated OR $uIDUser == $T_IdUserAssigned){
                        $links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=AddFile&token=$gettoken' target='_self'>Agregar Archivo</a><br>";
                    }
                }
                
                
                break;
            case "Analyzing":
                $cSt = "DeepPink";
                if($uIDUser == $T_IdUserAssigned){
                    $links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=EndAnalyze&token=$gettoken' target='_self'>Terminar Analisis</a><br>";
                }
                
                if($uAccount == "Admin" OR $uAccount == "SuperUser"){
                    $links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=AddFile&token=$gettoken' target='_self'>Agregar Archivo</a><br>";
                    //$links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=AssignOwner&token=$gettoken' target='_self'>Asignar Due&ntilde;o</a><br>";
                    $links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=chCreator&token=$gettoken' target='_self'>Cambiar Creador</a><br>";
                    //$links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=chTypeTask&token=$gettoken' target='_self'>Cambiar Tipo Tarea</a><br>";
                    //$links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=Delete&token=$gettoken' target='_self'>Eliminar Tarea</a><br>";
                } else {
                    if($uIDUser == $T_idUserCreated OR $uIDUser == $T_IdUserAssigned){
                        $links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=AddFile&token=$gettoken' target='_self'>Agregar Archivo</a><br>";
                    }
                }
                break;
            case "PausedDev":
                $cSt = "Orange";
                if($uIDUser == $T_IdUserAssigned){
                    $links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=StartDev&token=$gettoken' target='_self'>Desarrollar</a><br>";
                }
                
                if($uAccount == "Admin" OR $uAccount == "SuperUser"){
                    $links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=AddFile&token=$gettoken' target='_self'>Agregar Archivo</a><br>";
                    //$links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=AssignOwner&token=$gettoken' target='_self'>Asignar Due&ntilde;o</a><br>";
                    $links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=chCreator&token=$gettoken' target='_self'>Cambiar Creador</a><br>";
                    //$links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=chTypeTask&token=$gettoken' target='_self'>Cambiar Tipo Tarea</a><br>";
                    //$links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=Delete&token=$gettoken' target='_self'>Eliminar Tarea</a><br>";
                } else {
                    if($uIDUser == $T_idUserCreated OR $uIDUser == $T_IdUserAssigned){
                        $links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=AddFile&token=$gettoken' target='_self'>Agregar Archivo</a><br>";
                    }
                }
                break;
            case "onDev":
                $cSt = "cornflowerblue";
                if($uIDUser == $T_IdUserAssigned){
                    $links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=PausedDev&token=$gettoken' target='_self'>Pausar</a><br>";
                    $links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=RelVanilla&token=$gettoken' target='_self'>Liberar Vanilla</a><br>";
                }
                
                if($uAccount == "Admin" OR $uAccount == "SuperUser"){
                    $links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=AddFile&token=$gettoken' target='_self'>Agregar Archivo</a><br>";
                    //$links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=AssignOwner&token=$gettoken' target='_self'>Asignar Due&ntilde;o</a><br>";
                    $links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=chCreator&token=$gettoken' target='_self'>Cambiar Creador</a><br>";
                    //$links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=chTypeTask&token=$gettoken' target='_self'>Cambiar Tipo Tarea</a><br>";
                    //$links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=Delete&token=$gettoken' target='_self'>Eliminar Tarea</a><br>";
                } else {
                    if($uIDUser == $T_idUserCreated OR $uIDUser == $T_IdUserAssigned){
                        $links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=AddFile&token=$gettoken' target='_self'>Agregar Archivo</a><br>";
                    }
                }
                break;
            case "Vanilla":
                $cSt = "Turquoise";
                if($uIDUser == $T_idUserCreated){
                    $links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=vClosed&token=$gettoken' target='_self'>Cerrar</a><br>";
                    $links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=ErrorVanilla&token=$gettoken' target='_self'>Reportar Error Vanilla</a><br>";
                }
                
                if($uAccount == "Admin" OR $uAccount == "SuperUser"){
                    $links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=AddFile&token=$gettoken' target='_self'>Agregar Archivo</a><br>";
                    //$links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=AssignOwner&token=$gettoken' target='_self'>Asignar Due&ntilde;o</a><br>";
                    $links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=chCreator&token=$gettoken' target='_self'>Cambiar Creador</a><br>";
                    //$links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=chTypeTask&token=$gettoken' target='_self'>Cambiar Tipo Tarea</a><br>";
                    //$links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=Delete&token=$gettoken' target='_self'>Eliminar Tarea</a><br>";
                } else {
                    if($uIDUser == $T_idUserCreated OR $uIDUser == $T_IdUserAssigned){
                        $links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=AddFile&token=$gettoken' target='_self'>Agregar Archivo</a><br>";
                    }
                }
                break;
            case "PausedDebug":
                $cSt = "Orange";
                if($uIDUser == $T_IdUserAssigned){
                    $links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=StartDebug&token=$gettoken' target='_self'>Debugg</a><br>";
                }
                
                if($uAccount == "Admin" OR $uAccount == "SuperUser"){
                    $links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=AddFile&token=$gettoken' target='_self'>Agregar Archivo</a><br>";
                    //$links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=AssignOwner&token=$gettoken' target='_self'>Asignar Due&ntilde;o</a><br>";
                    $links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=chCreator&token=$gettoken' target='_self'>Cambiar Creador</a><br>";
                    //$links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=chTypeTask&token=$gettoken' target='_self'>Cambiar Tipo Tarea</a><br>";
                    //$links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=Delete&token=$gettoken' target='_self'>Eliminar Tarea</a><br>";
                } else {
                    if($uIDUser == $T_idUserCreated OR $uIDUser == $T_IdUserAssigned){
                        $links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=AddFile&token=$gettoken' target='_self'>Agregar Archivo</a><br>";
                    }
                }
                break;
            case "onDebug":
                $cSt = "cornflowerblue";
                if($uIDUser == $T_IdUserAssigned){
                    $links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=PausedDebug&token=$gettoken' target='_self'>Pausar Debug</a><br>";
                    $links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=RelProduction&token=$gettoken' target='_self'>Liberar Production</a><br>";
                }
                
                if($uAccount == "Admin" OR $uAccount == "SuperUser"){
                    $links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=AddFile&token=$gettoken' target='_self'>Agregar Archivo</a><br>";
                    //$links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=AssignOwner&token=$gettoken' target='_self'>Asignar Due&ntilde;o</a><br>";
                    $links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=chCreator&token=$gettoken' target='_self'>Cambiar Creador</a><br>";
                    //$links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=chTypeTask&token=$gettoken' target='_self'>Cambiar Tipo Tarea</a><br>";
                    //$links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=Delete&token=$gettoken' target='_self'>Eliminar Tarea</a><br>";
                } else {
                    if($uIDUser == $T_idUserCreated OR $uIDUser == $T_IdUserAssigned){
                        $links_op .= "<a class='linklr' href='index.php?sI=$sI&sII=$sII&sIII=$sIII&sIV=AddFile&token=$gettoken' target='_self'>Agregar Archivo</a><br>";
                    }
                }
                break;
            case "Debugging":
                $cSt = "lightskyblue";
                break;
            case "Production":
                $cSt = "blue";
                break;
            case "Closed":
                $cSt = "greenyellow";
                break;
        }
        
        $s_DTar = "SELECT DetailLog, datetime, UserCreated FROM TasksLogs WHERE idTask = '$IDTask' AND TypeLog = 'Descripcion'";
        $dTar = $cnx->query("$s_DTar")->fetchArray();
        $T_L_Descripcion = $dTar['DetailLog'];
        $T_L_UserCreated = $dTar['UserCreated'];
        $T_L_datetime = $dTar['datetime'];
        
        include("Forms/EditTarea.php");
        break;
endswitch;



?>