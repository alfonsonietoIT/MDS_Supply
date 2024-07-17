<?php
/**
 * Notificaciones 
 * 
 * @param   integer         $NTipo      Tipo Notificacion (1,2,3)
 * @param   string          $NTitulo    Titulo de la Notificacion    
 * @param   string          $NMensaje   Mensaje de la Notificacion    
 * @param   integer         $N_IDUser   Usuarion a Notificar
 * @param   string          $N_NUser    Nombre Usuario
 * @param   integer         $N_ID       ID App
 * @param   string          $N_NUser    App
 * @copyright   2021 Software Development MX
 * @license     https://www.softwaredevelopment.mx/license/Link_Function.txt
 * @return string
 */

function Notificacion($NTipo, $NTitulo, $NMensaje, $N_IDUser, $N_NUser, $N_ID, $N_App){
    global $cnx;
    global $dtAhora;
    //Depende el Tipo
    switch ($NTipo):
        case 1:
            //Alerta urgente
            //Email, Notificacion y SMS
            
            
            //Notificacion
            $sNot = "INSERT INTO Notificacion VALUES('0', '$NTipo', '$NTitulo', '$NMensaje', "
                . "'$N_IDUser', '$N_NUser', '$N_ID', '$N_App', "
                . "'$dtAhora', '0000-00-00 00:00:00', 'Open')";
            $iNot = $cnx->query("$sNot");
            break;
        case 2:
            //Alerta Media
            //Email, Notificacion
            
            //Notificacion
            $sNot = "INSERT INTO Notificacion VALUES('0', '$NTipo', '$NTitulo', '$NMensaje', "
                . "'$N_IDUser', '$N_NUser', '$N_ID', '$N_App', "
                . "'$dtAhora', '0000-00-00 00:00:00', 'Open')";
            $iNot = $cnx->query("$sNot");
            break;
        case 3:
            //Alerta Baja
            //Notificacion
            $sNot = "INSERT INTO Notificacion VALUES('0', '$NTipo', '$NTitulo', '$NMensaje', "
                . "'$N_IDUser', '$N_NUser', '$N_ID', '$N_App', "
                . "'$dtAhora', '0000-00-00 00:00:00', 'Open')";
            $iNot = $cnx->query("$sNot");
            
            break;
    endswitch;
    //echo $sNot;
    
}



?>