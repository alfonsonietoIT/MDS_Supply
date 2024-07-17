<?php
/**
 * Envio SMS 
 * 
 * @param   integer         $Cell       NCelular
 * @param   string          $Message    Mensaje    
 * @param   string          $CellIDUs   ID User Celular    
 * @param   string          $CellName   Nombre del Celular
 * @copyright   2021 Software Development MX
 * @license     https://www.softwaredevelopment.mx/license/Link_Function.txt
 * @return string
 */

function SMS($Cell, $Message, $CellIDUs, $CellName, $SMSType){
    global $cnxsms;
    global $dtAhora;
    
    $ssms = "INSERT INTO cron_sms VALUES('0', 'Tasks', 'masterworkelectronics.com', '$SMSType', "
            . "'Online', 'R2', '$dtAhora', '$CellName', '$Cell', 'Notificacion', '$Message', 'Pendiente', 'Received', '$dtAhora')";
    
    $iSMS = $cnxsms->query("$ssms");
    
}



?>