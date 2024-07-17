<?php
//Depende sII

switch ($sII){
    case "vLogin":
        //Depence Actvie
        switch ($gActive):
            case 1:
                $vATipo = "Verde";
                $vAMensaje = "Acceso Correcto";
                $vRedirect = "index.php?sI=vLogin&sII=Home&sIII=Home&sIV=Home";
                $vATime = 1000;
                //echo $vRedirect;
                echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                break;
            default :
                $vATipo = "Rojo";
                $vAMensaje = "Acceso Incorrecto";
                $vRedirect = "index.php";
                $vATime = 1000;
                //echo $vRedirect;
                echo Alerta($vATipo, $vAMensaje, $vRedirect, $vATime);
                break;
        endswitch;
        
        break;
    case "":
    case "inicio":
        ?>
        <main>
        <center>
        <br><br>
        <img src="<?php echo $txtLogo;?>" width="200"><br>
        <?php
        $FID = 1;
        $FLink = "index.php?sI=$sI&sII=vLogin&sIII=$sIII&sIV=$sIV";
        echo Formato($FID, $FLink, $X, $vATime);
        ?>
        </center>
        </main>        
        <?php
        break;
}
?>