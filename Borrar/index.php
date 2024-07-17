<?php
$select = $_GET['select'];
$s2 = $_GET['s2'];
$s3 = $_GET['s3'];
$s4 = $_GET['s4'];
include 'gScripts/dbEmail.php';
//echo $varg;
//echo "Tiempo: " . date_default_timezone_get() . "<br>";
date_default_timezone_set('America/Los_Angeles');
$dtahora = date('Y-m-d H:i:s', time());
$fahora = date('Y-m-d', time());
//echo $select;
if($select == "DefStation"){
    $gStation = strtoupper($_POST['station']);
    setcookie("StationMDS", $gStation, time() + (86400 * 300), "/");
    //echo $gStation;
}

$StationMDS = $_COOKIE['StationMDS'];
if($select == "loginv" OR $select == "cpass")
	{
        //$StationMDS = $_COOKIE['StationMDS'];
	$cuser = $_COOKIE['puser'];	
	$cpass = $_COOKIE['ppass'];
	}
else
	{
	//Solo para loginv
	if($select == "logins")
		{
		$puser = md5($_POST['user']);
		$ppass = md5($_POST['pass']);
	
		setcookie("puser", $puser);
		setcookie("ppass", $ppass);	
		}
	else
		{
                if($select == "DefStation"){
                    //$gStationMDS = base64_decode($_GET['token']);
                    
                    setcookie("puser", "jajaja");
                    setcookie("ppass", "jajaja");
                    
                } else {
                    setcookie("puser", "jajaja");
                    setcookie("ppass", "jajaja");
                }
            
            
		
		}
	
	}


//echo $StationMDS;
if($StationMDS != ""): setcookie("StationMDS", $StationMDS, time() + (86400 * 300), "/"); endif;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Teleplan Mexicali, HPLaptops Master Debug System</title>
<link rel="stylesheet" href="style.css" />
<link rel="stylesheet" href="css/general.css" />
<link rel="stylesheet" href="boton.css" />
<link rel="stylesheet" href="menu_style.css" />
<link rel="shortcut icon" href="favicon.ico" />
<link rel="icon" href="favicon.ico" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="201a.js" type="text/javascript">
</script>
<script>
// When the user clicks on <div>, open the popup
function myFunction(popid) {
    //alert(popid);
    var popup = document.getElementById(popid);
    popup.classList.toggle("show");
}
</script>
<script type="text/javascript" src="calendarDateInput.js">
</script>

<!--<script type="text/javascript" src="Scripts/csspopup.js"></script>-->

<script type="text/javascript" language="javascript">
function fun_submit() {
	document.formx.submit();
}
</script>

<script type="text/javascript">
<!--
    function visibility(id) {
       var e = document.getElementById(id);
       if(e.style.display == 'block')
          e.style.display = 'none';
       else
          e.style.display = 'block';
    }
//-->
</script>

<script type="text/javascript">
<!--
function popUp(URL) {
day = new Date();
id = day.getTime();
eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0, scrollbars=1, location=0, statusbar=0, menubar=0, resizable=0, width=530, height=500, left=390, top=134');");
}
-->
</script>
<script type="text/javascript">
function popUp2(URL) {
day = new Date();
id = day.getTime();
eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0, scrollbars=1, location=0, statusbar=0, menubar=0, resizable=0, width=820, height=500, left=20, top=20');");
}
</script>
<script language="javascript">
<!--
function checkpass() {
if (document.cpass.cpass1.value != document.cpass.cpass2.value) {
alert ('Los 2 passwords deben ser identicos...')
return false;
}
}

function ocultar3(id) {
if(id == "abrir")
	{
	document.getElementById('abriral').style.display = "block";
	document.getElementById('actualizaral').style.display = "none";
	document.getElementById('evaluacional').style.display = "none";
	document.getElementById('generalal').style.display = "none";
	document.getElementById('generalal2').style.display = "none";
	document.getElementById('detalleal').style.display = "none";
	document.getElementById('nivelal').style.display = "none";
	}
if(id == "actualizar")
	{
	document.getElementById('abriral').style.display = "none";
	document.getElementById('actualizaral').style.display = "block";
	document.getElementById('evaluacional').style.display = "none";
	document.getElementById('generalal').style.display = "none";
	document.getElementById('generalal2').style.display = "none";
	document.getElementById('detalleal').style.display = "block";
	document.getElementById('nivelal').style.display = "none";
	}
if(id == "evaluacion")
	{
	document.getElementById('abriral').style.display = "none";
	document.getElementById('actualizaral').style.display = "none";
	document.getElementById('evaluacional').style.display = "block";
	document.getElementById('generalal').style.display = "none";
	document.getElementById('generalal2').style.display = "none";
	document.getElementById('detalleal').style.display = "none";
	document.getElementById('nivelal').style.display = "none";
	}

if(id == "general")
	{
	document.getElementById('abriral').style.display = "none";
	document.getElementById('actualizaral').style.display = "none";
	document.getElementById('evaluacional').style.display = "none";
	document.getElementById('generalal').style.display = "block";
	document.getElementById('generalal2').style.display = "none";
	document.getElementById('detalleal').style.display = "none";
	document.getElementById('nivelal').style.display = "none";
	}

if(id == "general2")
	{
	document.getElementById('abriral').style.display = "none";
	document.getElementById('actualizaral').style.display = "none";
	document.getElementById('evaluacional').style.display = "none";
	document.getElementById('generalal').style.display = "none";
	document.getElementById('generalal2').style.display = "block";
	document.getElementById('detalleal').style.display = "none";
	document.getElementById('nivelal').style.display = "none";
	}

if(id == "nivel")
	{
	document.getElementById('abriral').style.display = "none";
	document.getElementById('actualizaral').style.display = "none";
	document.getElementById('evaluacional').style.display = "none";
	document.getElementById('generalal').style.display = "none";
	document.getElementById('generalal2').style.display = "none";
	document.getElementById('detalleal').style.display = "none";
	document.getElementById('nivelal').style.display = "block";
	}

}

function apply(){
  document.fai.sub.disabled=true;
  
if(document.fai.chk.checked==true)
  {
    document.fai.sub.disabled=false;
  }
if(document.fai.chk.checked==false)
  {
    document.fai.sub.enabled=false;
  }

}

function na() {
	if(document.fai.acal.checked == true)
		{
		document.getElementById('vcal').style.display="none";
		}
	else
		{
		document.getElementById('vcal').style.display="block";	
		}
	}

function apply2(){
  document.fae.sub.disabled=true;
  
if(document.fae.chk.checked==true)
  {
    document.fae.sub.disabled=false;
  }
if(document.fae.chk.checked==false)
  {
    document.fae.sub.enabled=false;
  }

}

function ocultar(id) {
if(id == "ver")
	{
	document.getElementById('divver').style.display = "block";
	document.getElementById('divagregar').style.display = "none";
	document.getElementById('diveditar').style.display = "none";
	}
if(id == "agregar")
	{
	document.getElementById('divver').style.display = "none";
	document.getElementById('divagregar').style.display = "block";
	document.getElementById('diveditar').style.display = "none";
	document.frmagregar.proyecto.focus();
	}
if(id == "editar")
	{
	document.getElementById('divver').style.display = "none";
	document.getElementById('divagregar').style.display = "none";
	document.getElementById('diveditar').style.display = "block";
	}


}

function turnonS(val) {
	if(val != "") {
		document.nfolio.submitb.disabled = false;	
	}
	else {
		alert("Tienes que seleccionar un equipo...");
		document.nfolio.submitb.disabled = true;
	}
}

function turnonSe(val) {
	if(val != "") {
		document.nfolio.proyecto.disabled = false;
		document.nfolio.lineas.disebled = false;
	}
	else {
		alert("Tienes que seleccionar un supervisor...");
		document.nfolio.proyecto.disabled = true;
	}
}

function turnonSe2(val) {
	if(val != "") {
		document.nfolio.familia.disabled = false;
	}
	else {
		alert("Tienes que seleccionar una linea...");
		document.nfolio.familia.disabled = true;
	}
}

//-->
</script> 

<script language="javascript" type="text/javascript">
function showhide(val) {
	if (val == "SI") {
		document.getElementById('ecoiss').style.display = "block";
		document.getElementById('ecoiss2').style.display = "none";
		}
	else
		{
		document.getElementById('ecoiss').style.display = "none";
		document.getElementById('ecoiss2').style.display = "block";
		}
	}
</script>

<script language="javascript" type="text/javascript">
function mostrar(ids) {
    document.getElementById(ids).style.display = "block";
}

function ocultar(ids) {
    document.getElementById(ids).style.display = "none";
}
</script>

<?php
//Solo Reportes
switch ($select){
    case "viewpro":
        //Busca graficas
        include("Reports/chartscode.php");
        break;
}

?>

<script>
    function AddSerial(value){
        document.getElementById("serial").value = value;
        //document.getElementById("count").value= 500*value;
        //document.getElementById("totalValue").innerHTML= "Total price: $" + 500*value;
    }

</script>

<?php
if($select == "viewpro"){
    ?>
<script type="text/javascript">
$(window).load(function() {
    $(".loader").fadeOut("slow");
});
</script>
<?php
}

if($s3 == "recibo" AND $s4 == "recserial"){
    //*********CONECT DB
    $dbhost = 'localhost';
    $dbuser = 'wwweb';
    $dbpass = 'chapala';

    $cnx = mysql_connect($dbhost, $dbuser, $dbpass) or die ('Error connecting to mysql');

    $dbname = 'chapalac_hplaptops';
    mysql_select_db($dbname, $cnx);
    mysql_query("SET time_zone='America/Los_Angeles'");
    ?>
<script language="javascript" type="text/javascript">
function dynamicdropdown(listindex){
    //document.getElementById("nparte").options.length = 0;
    document.getElementById("nparte").innerHTML = "";
    <?php 
    //Obtiene los datos
    $smodelo = "SELECT modelo FROM modelos ORDER BY modelo ASC";
    $qmodelo = mysql_query($smodelo, $cnx);
    $nmodelo = mysql_num_rows($qmodelo);

    if($nmodelo > 0){
        
        ?>
        switch (listindex){
        <?php
        
        while($rmodelo = mysql_fetch_array($qmodelo)){
            $modelo = $rmodelo['modelo'];
            ?>
            case "<?php echo $modelo;?>":
            <?php
            //Obtiene los numeros de parte del modelo
            $snparte = "SELECT DISTINCT nparte FROM nparte WHERE modelo = '$modelo'";
            $qnparte = mysql_query($snparte, $cnx);
            $count = 0;
            while($rnp = mysql_fetch_array($qnparte)){
                $nparte = $rnp['nparte'];
                ?>
                document.getElementById("nparte").options[<?php echo $count;?>]=new Option("<?php echo $nparte;?>","<?php echo $nparte;?>");
                <?php
                $count++;
                
            }
            
            
            ?>
                break;
            <?php
        }
        
        ?>
        }
        <?php
        
    }
    
    ?>

    return true;
}
</script>
<?php
mysql_close($cnx);

}

?>



</head>
<body marginheight="0" marginwidth="0">

<?php

//echo "aqui<br>";
//date_default_timezone_set('America/Los_Angeles');
//Obtiene variable select....
$select = $_GET['select'];
$s2 = $_GET['s2'];
$s3 = $_GET['s3'];
$s4 = $_GET['s4'];



//*********CONECT DB
$dbhost = 'localhost';
$dbuser = 'wwweb';
$dbpass = 'chapala';

$cnx = mysql_connect($dbhost, $dbuser, $dbpass) or die ('Error connecting to mysql');

$dbname = 'chapalac_hplaptops';
mysql_select_db($dbname, $cnx);
mysql_query("SET time_zone='America/Los_Angeles'");
//echo "aqui<br>";

//echo "Tiempo: " . date_default_timezone_get() . "<br>";
date_default_timezone_set('America/Los_Angeles');
//echo "Tiempo: " . date_default_timezone_get();

?>
<center>
<div style="text-align:justify; background-color:white;">
<table width="100%">
<tr>
	<td width="260" align="left">
            <img src="../ReconextLogoX.png" width="200"/>
	</td>
	<td align="left" valign="bottom">
	<img src="images/mdslogo_s.jpg" width="123" height="50" alt="MDSSystem" />&nbsp;
	</td>
        <td align="center" valign="middle">
            Station: <b><?php echo $StationMDS;?></b>
	</td>
	<td width="260" align="right">
	<font class="blue">
	Teleplan Mexicali, BC<br />
	<font class="rojos"><b>&reg;Software Development MX</b></font><br>
	<a href="http://www.softwaredevelopment.mx" target="_blank">www.softwaredevelopment.mx</a>
	</font>
	</td>
</tr>
</table>

</div>
<div style="background-color:#F4F4F4; text-align:right;">
<font class="blue">
    
<a class="link" href="index.php?select=inicio&amp;s2=inicio&amp;s3=inicio&amp;s4=inicio" target="_self">Inicio</a>
<a class="link" href="index.php?select=inicio&amp;s2=station&amp;s3=inicio&amp;s4=inicio" target="_self">Station</a>
<a class="link" href="index.php?select=viewpro&amp;s2=inicio&amp;optionce=inicio" target="_self">Production System</a>&nbsp;&nbsp;
<a class="linkv" href="http://10.124.0.89/viewproject.php?select=large&s2=produccion" target="_self">Production</a>&nbsp;&nbsp;
</font>
</div>
<div style="background-color:#000000; text-align:right; height:3px;">
</div>
</center>
<div style="height:5px;"></div>
<center>
<?php
//############################################################################################   Inicio o Login
if($select == "" OR $select == "inicio"){
    switch ($s2){
        case "":
        case "inicio":
            echo $gStation;
            ?>
    <br /><br />
    <div id="box600">
    <div id="inbox_t">
    <font class="rojo">MDS Login</font>
    </div>
    <div id="inbox_t">
    <form name="formx" action="index.php?select=logins&amp;s2=inicio&amp;s3=inicio&amp;s4=inicio" method="post">
    <font class="negros">Numero Empleado:<br />
    <input type="text" class="text" name="user" />
    <br /><br />
    Password:<br />
    <input type="password" class="text" name="pass" /><br /><br />
    <input type="submit" value="Entrar" class="subm" />
    </font>
    <br /><br />
    </form>
    </div>
    </div>
	<script language="javascript" type="text/javascript">
		document.formx.user.focus();
    </script>
            <?php
            break;
        case "station":
            ?>
    <br /><br />
    <div id="box600">
    <div id="inbox_t">
    <font class="rojo">Station Name</font>
    </div>
    <div id="inbox_t">
    <form name="formx" action="index.php?select=DefStation&amp;s2=inicio&amp;s3=inicio&amp;s4=inicio" method="post">
    <font class="negros">Station:<br />
    <input type="text" class="text" name="station" />
    <br /><br /><br /><br />
    <input type="submit" value="Guardar" class="subm" />
    </font>
    <br /><br />
    </form>
    </div>
    </div>
    <script language="javascript" type="text/javascript">
        document.formx.station.focus();
    </script>
            <?php
            break;
    }
	?>

<?php
}



if($select == "DefStation")
	{
	?>
	<br>
	<br>
	<br>
    <img src="images/waiting_animation.gif" width="52" height="52" border="0"/>
    <br />
    <font class="azuls">Conectando...</font> 
	<script language="javascript">
		location.href = 'index.php';
	</script>
	<?php
	}



//############################################################################################  Guarda Usuario y Password
if($select == "logins")
	{
	?>
	<br>
	<br>
	<br>
    <img src="images/waiting_animation.gif" width="52" height="52" border="0"/>
    <br />
    <font class="azuls">Conectando...</font> 
	<script language="javascript">
		location.href = 'index.php?select=loginv&s2=inicio&s3=inicio&s4=inicio';
	</script>
	<?php
	}






//############################################################################################   Valida el Login
if($select == "loginv")
	{
	//Acceso
	include("acceso.php");
	
	//echo $nuser;
	
	if($nuser > 0){
		include("menusinternos.php");
	
		//################################## Menu principal
		switch($s2){
                    case "material":
                        include("material.php");
                        break;
                    case "Alerts":
                        include("Alerts.php");
                        break;
                    case "calexico":
                        include("calexico.php");
                        break;
			case "afr":
				include("afr.php");
				break;
			case "dreturn":
				include("dreturn.php");
				break;
			case "orders":
				include("orders.php");
				break;
			case "rmas":
				include("rmas.php");
				break;
			case "srequest":
				include("srequest.php");
				break;
			case "ingenieria":
				include("ingenieria.php");
				break;
			case "invibm":
				include("invibm.php");
				break;
			case "usuarios":
				include("usuarios.php");
				break;
			case "empaque":
				include("empaque.php");
				break;
			case "produccion":
				include("produccion.php");
				break;
			case "qa":
				include("qa.php");
				break;
			case "vens":
				include("vens.php");
				break;
			case "oow":
				include("oow.php");
				break;
			case "calidad":
				include("calidad.php");
				break;
			case "reports":
				include("reports.php");
				break;
			}
	
		}
	
	}




//############################################################################################   Ver Produccion
if($select == "viewpro")
	{
        
        //Incluye ViewPro	
	include("Reports/viewpro.php");
		
	}
        
        
	
?>

</center>


<?php
//Solo para LoginV deslogear
if($select == "loginv")
    {
    ?>
    <script language="javascript" type="text/javascript">
    	setTimeout("location.href = 'index.php?select=inicio&s2=inicio&s3=inicio&s4=inicio';", 1600000);
    </script>
    <?php
    }

mysql_close($cnx);
?>
</body>
</html>
