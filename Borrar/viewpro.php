<center>
<center>
<?php
$fecha = date('Y-m-d', time());
?>
<div style="z-index:1;">
<ul class="menu">
	<li class="top"><a class="top_link" href="index.php?select=viewpro&amp;s2=onprocesscur&amp;optionce=xarea&amp;fecha=<?php echo $fecha;?>&amp;all=NO"><span>InProcess</span></a>
    <ul class="sub">
    	<li><a href="index.php?select=viewpro&amp;s2=onprocesscur&amp;optionce=xarea&amp;fecha=<?php echo $fecha;?>&amp;all=NO">InProcess</a></li>
        <li><a href="index.php?select=viewpro&amp;s2=onprocesscrcur&amp;optionce=xarea&amp;fecha=<?php echo $fecha;?>&amp;all=NO">InProcess CR</a></li>
        <li><a href="index.php?select=viewpro&amp;s2=inhouse&amp;optionce=inicio&amp;cliente=all&amp;model=all&amp;ro=all">InHouse</a></li>
        <li><a href="index.php?select=viewpro&amp;s2=inhouse&amp;optionce=inicio&amp;cliente=new&amp;model=all&amp;ro=all">InHouse New</a></li>
        <li><a href="index.php?select=viewpro&amp;s2=inventariox&amp;optionce=inventariox&amp;s3=inicio">Inventario</a></li>
        <li><a href="burnin.php?s2=burnin&amp;optionce=one" target="_blank">BurnIn</a></li>
        <li><a href="index.php?select=viewpro&amp;s2=igsrep&amp;optionce=inicio">Reporte IGS</a></li>
        <li><a href="index.php?select=viewpro&amp;s2=inventario&amp;optionce=hfp">Hold For Part</a></li>
        <li><a href="index.php?select=viewpro&amp;s2=facturacion&amp;optionce=reportentf">Reporte NTF</a></li>
        <li><a href="index.php?select=viewpro&amp;s2=inventario&amp;optionce=xserial">Reporte Serial</a></li>
    </ul>
    </li>
    <li class="top"><a class="top_link" href="index.php?select=viewpro&amp;s2=calidad&amp;optionce=inicio&amp;fecha=<?php echo $fecha;?>"><span>Calidad</span></a>
    <ul class="sub">
    	<li><a href="index.php?select=viewpro&amp;s2=calidad&amp;optionce=inicio&amp;fecha=<?php echo $fecha;?>">Reporte XStation</a></li>
        <li><a href="index.php?select=viewpro&amp;s2=calidad&amp;optionce=oba&amp;fecha=<?php echo $fecha;?>">Reporte OBA</a></li>
        <li><a href="index.php?select=viewpro&amp;s2=calidad&amp;optionce=doas">Reporte DOAs</a></li>
        <!--<li><a href="index.php?select=viewpro&amp;s2=ntfs&amp;optionce=inicio&amp;s3=inicio">Reporte NTFs</a></li>-->
    </ul>
    </li>
    <li class="top"><a class="top_link" href="index.php?select=viewpro&amp;s2=tatreport&amp;optionce=inicio&amp;orden=fecharec&amp;s3=nocomcast"><span>Cierre Orden</span></a>
    <ul class="sub">
    	<li><a href="index.php?select=viewpro&amp;s2=tatreport&amp;optionce=inicio&amp;orden=fecharec&amp;s3=nocomcast">TAT Report</a></li>
        <li><a href="index.php?select=viewpro&amp;s2=tatreport&amp;optionce=inicio&amp;orden=fecharec&amp;s3=comcast">TAT Report Comcast</a></li>
    	<li><a href="index.php?select=viewpro&amp;s2=inventario&amp;optionce=xro">Reporte RO</a></li>
    </ul>
    </li>
    <li class="top"><a class="top_link" href="index.php?select=viewpro&amp;s2=mds&amp;optionce=dandpass&amp;s3=inicio&amp;fecha=<?php echo $fecha;?>"><span>Diagnostico MDS</span></a>
    <ul class="sub">
    	<li><a href="index.php?select=viewpro&amp;s2=mds&amp;optionce=dandpass&amp;s3=inicio&amp;fecha=<?php echo $fecha;?>">Reporte D&amp;Pass</a></li>
        <li><a href="index.php?select=viewpro&amp;s2=inventario&amp;optionce=diagnosticadas">Reporte Diagnosticadas</a></li>
        <li><a href="index.php?select=viewpro&amp;s2=inventario&amp;optionce=xempleado">Escaneadas XEmpleado</a></li>
    </ul>
    </li>
    <li class="top"><a class="top_link" href="index.php?select=viewpro&amp;s2=manuf&amp;optionce=inicio&amp;s3=inicio"><span>Manufacturing</span></a>
    <ul class="sub">
    	<li><a href="index.php?select=viewpro&amp;s2=manuf&amp;optionce=labor&amp;s3=inicio">Labor Efficiency</a></li>
        <li><a href="index.php?select=viewpro&amp;s2=manuf&amp;optionce=hrsprod&amp;s3=inicio">Horas Producidas</a></li>
        <li><a href="index.php?select=viewpro&amp;s2=manuf&amp;optionce=recibos&amp;s3=inicio">Recibos</a></li>
    </ul>
    </li>
</ul>
</div>
    <br /><br />
    <font class="blueH">
    Production System Teleplan Mexicali
    </font><br />
    <font class="naranja"><font size="+1"><b>Visor Production System</b></font></font>
    <br />
    <font class="blue">
    Selecciona el reporte del menu de la parte superior.
    </font>
    <br /><br />
    </center>

<?php
$s2 = $_GET['s2'];
$s3 = $_GET['s3'];
$s4 = $_GET['s4'];

$optionce = $_GET['optionce'];

//Reporte IGS
if($s2 == "igsrep"){
    //Inicio
    if($optionce == "inicio"){
        ?>
        <form action="index.php?select=viewpro&amp;s2=igsrep&amp;optionce=ver" method="post">
        <font class="negrom">Reporte IGS</font><br>
        <font class="azuls">
       	<br />
        Desde:<br>
        <script>DateInput('desde', true, 'YYYY-MM-DD')</script>
        <br /><br />
        Hasta:<br>
        <script>DateInput('hasta', true, 'YYYY-MM-DD')</script>
        <br>
        <input type="submit" value="Siguiente" class="subm">
        <br /><br />
        </font>
        </form>
        <?php
        }
    
    if($optionce == "ver"){
        $desde = $_POST['desde'];
        $hasta = $_POST['hasta'];
        ?>
        <font class="negrom">Reporte IGS</font><br>
        <a href="reporte_Xls.php?reporte=igs&desde=<?php echo $desde;?>&hasta=<?php echo $hasta;?>" target="_blank"><img src="images/xls_logo.jpg" width="92" height="93" alt="Download" border="0" /></a>
        <br /><br />
        <?php
        
        }
        
    }


//Calidad
if($s2 == "calidad")
	{
	//echo $optionce;
	if($optionce == "doaspost")
		{
		//Baja el archivo
		$desde = $_POST['desde'];
		$desdehora = $desde . " 06:00:00";
		$hasta = $_POST['hasta'];
		$manana1 = date('Y-m-d', strtotime("$hasta + 1 day"));
		
		?>
        
        <a href="reporte_Xls.php?reporte=doas&desde=<?php echo $desdehora;?>&hasta=<?php echo $manana1;?>" target="_blank"><img src="images/xls_logo.jpg" width="92" height="93" alt="Download" border="0" /></a>
        <br /><br />
        <?php		
		}
	
	
	//Reporte de DOAs
	if($optionce == "doas")
		{
		?>
        <form action="index.php?select=viewpro&amp;s2=calidad&amp;optionce=doaspost" method="post">
        <font class="negrom">Reporte DOAs Large</font><br>
        <font class="azuls">
       	<br />
        Desde:<br>
        <script>DateInput('desde', true, 'YYYY-MM-DD')</script>
        <br /><br />
        Hasta:<br>
        <script>DateInput('hasta', true, 'YYYY-MM-DD')</script>
        <br>
        <input type="submit" value="Siguiente" class="subm">
        <br /><br />
        </font>
        </form>
        <?php
		}
	
	
	//Cuando envia la fecha	
	if($optionce == "obapost")
		{
		$desde = $_POST['desde'];
		$desdehora = $desde . " 06:00:00";
		$hasta = $_POST['hasta'];
		$manana1 = date('Y-m-d', strtotime("$hasta + 1 day"));
		$hastahora = $manana1 . " 06:00:00";
		$stationman = "OBA";
		$stationaut = "OBARel";
		
		?>
        <br />
		<div id="box1000" >
		<div id="inbox_t">
		<br />
		<font class="negrom">Reporte OBA Large<br /></font>
        <font class="reds">
        Desde:<b><?php echo $desdehora;?></b>&nbsp;&nbsp;Hasta:<b><?php echo $hastahora;?></b></font>
		<br />
		</div>
        <div id="inbox_t">
        <br />
        <?php
		//Saca el reporte de Yield
		if($desde == $hasta)
			{
			include("scripts/yielhoraxhoraOBA.php");	
			}
		else
			{
			$desdedia = $desde . " 00:00:00";
			$hastadia = $hasta . " 23:59:59";
			include("scripts/yieldpordiaOBA.php");	
			}
			
			
		?>
        <br /><br />
        <?php
		//include("scripts/totalizadooba.php");
		include("scripts/paretofallas.php");
		?>
        </div>
        </div>
        
        <?php
		
			
		}
	
	//Inicio OBA
	if($optionce == "oba")
		{
		?>
        <form action="index.php?select=viewpro&amp;s2=calidad&amp;optionce=obapost" method="post">
        <font class="negrom">Reporte OBA Large</font><br>
        <font class="azuls">
       	<br />
        Desde:<br>
        <script>DateInput('desde', true, 'YYYY-MM-DD')</script>
        <br /><br />
        Hasta:<br>
        <script>DateInput('hasta', true, 'YYYY-MM-DD')</script>
        <br>
        <input type="submit" value="Siguiente" class="subm">
        <br /><br />
        </font>
        </form>
        <?php	
		}
	
	
	
	//Inicio o por area
	if($optionce == "inicio")
		{
		?>
		<form action="index.php?select=viewpro&amp;s2=calidad&amp;optionce=post" method="post">
        <font class="blueH">Reporte Yield Calidad</font><br>
        <font class="blue">
       	<br /><br />
        Station:<br />
        <select name="station" class="text">
            <?php
			//Obtiene los distintos procesos con condicion
			$sprocess = "SELECT DISTINCT status FROM process WHERE tipo = 'condicion' AND (status = 'ScreenTest' OR status = 'RBacklight' OR status = 'FallaTecnico' OR status = 'DesPolarizado' OR status = 'QC' OR status = 'LimpiezaF') ORDER BY status";
			$qprocess = mysql_query($sprocess, $cnx);
			
			while($rprocess = mysql_fetch_array($qprocess))
				{
				$gstatus = $rprocess['status'];	
				?>
       		<option value="<?php echo $gstatus;?>"><?php echo $gstatus;?></option>
                <?php	
				}
			?>
        </select>
        <br /><br />
        Desde:<br>
        <script>DateInput('desde', true, 'YYYY-MM-DD')</script>
        <br /><br />
        Hasta:<br>
        <script>DateInput('hasta', true, 'YYYY-MM-DD')</script>
        <br>
        <input type="submit" value="Siguiente" class="subm">
        </font>
        </form>
		<?php
		}
		
		
	//Cuando envia la fecha	
	if($optionce == "post")
		{
		$desde = $_POST['desde'];
		$desdehora = $desde . " 06:00:00";
		$hasta = $_POST['hasta'];
		$manana1 = date('Y-m-d', strtotime("$hasta + 1 day"));
		$hastahora = $manana1 . " 06:00:00";
		$station = $_POST['station'];
		
		?>
        <br />
		<div id="box1000" >
		<div id="inbox_t">
		<br />
		<font class="negrom">Reporte Yield <b><?php echo $station;?></b> Large<br /></font>
        <font class="reds">
        Desde:<b><?php echo $desdehora;?></b>&nbsp;&nbsp;Hasta:<b><?php echo $hastahora;?></b></font>
		<br />
		</div>
        <div id="inbox_t">
        <br />
        <?php
		//Saca el reporte de Yield
		if($desde == $hasta)
			{
			include("scripts/yielhoraxhora.php");	
			}
		else
			{
			$desdedia = $desde . " 00:00:00";
			$hastadia = $hasta . " 23:59:59";
			include("scripts/yieldpordia.php");	
			}
			
			
		?>
        <br /><br />
        <?php
		if($station == "QC")
			{
			$desdedia = $desde . " 00:00:00";
			$hastadia = $hasta . " 23:59:59";
			//Pareto
			$pareto = "qccr";
			include("scripts/multitotalizado.php");	
			}
		
		include("scripts/paretofallas.php");
		?>
        </div>
        </div>
        
        <?php
		
			
		}
		
	}



// ################################################# Manufacturing
if($s2 == "manuf")
	{
	
	//estadisticas
	include("scripts/manufacturing.php");
		
	}



//####################################################33 CAlidad
if($s2 == "trend")
	{
	
	//Muestra el reporte
	if($optionce == "vreporte")
		{
		//include("veryield.php");
		include("veryieldstation.php");
		
		}
	
	//Solo para inicio
	if($optionce == "inicio")
		{
		?>
		<form action="index.php?select=viewpro&amp;s2=trend&amp;optionce=vreporte" method="post">
        <font class="blueH">Reporte Yield Calidad</font><br>
        <font class="blue">
       	<br /><br />
        Station:<br />
        <select name="proceso" class="stext">
            <option value="MTC" class="otext">MTC</option>
            <option value="PostScreen" class="otext">PostScreen</option>
            <option value="BurnIn" class="otext">BurnIn</option>
            <option value="HotQC" class="otext">HotQC</option>
            <option value="ColdQC" class="otext">ColdQC</option>
            <option value="OBA" class="otext">OBA</option>
        </select>
        <br /><br />
        Desde:<br>
        <script>DateInput('desde', true, 'YYYY-MM-DD')</script>
        <br /><br />
        Hasta:<br>
        <script>DateInput('hasta', true, 'YYYY-MM-DD')</script>
        <br>
        <input type="submit" value="Siguiente" class="text">
        </font>
        </form>
		<?php	
		}
	
	}




//In House
if($s2 == "inhouse")
	{
	$cliente = $_GET['cliente'];
	$modelo = $_GET['model'];
	$ro = $_GET['ro'];
	//echo $cliente;
	//Cliente
	if($cliente == "new")
		{
		//Script para inhouse
		include("scripts/inhousenew.php");	
		}
	else
		{
		//Script para inhouse
		include("scripts/inhouse.php");	
		}
	
	
	}



//On Process
if($s2 == "onprocesscrcur")
	{
	//echo $optionce;
	//Inicio o por area
	if($optionce == "" OR $optionce == "xarea")
		{
		//Obtiene la fecha
		$fecha = $_GET['fecha'];
		$manana1 = date('Y-m-d', strtotime("$fecha + 1 day"));
				
		//La fecha
		if($fecha == "")
			{
			$fecha = date('Y-d-m', time());
			$otra = "";
			//$horax = date('H', time());
			//echo $horax;
			//echo $fecha;
			
			$desde = date('Y-d-m', strtotime());
			?>
            <script language="javascript" type="text/javascript">
				setTimeout("location.href = 'index.php?select=viewpro&s2=onprocesscrcur&optionce=xarea&fecha=<?php echo $fecha;?>';", 600000);
			</script>
            <?php
			}
		
		//Postea la fecha
		if($fecha == "post")
			{
			$fecha = $_POST['desde'];
			$fechah = $_POST['hasta'];
			$otra = "otra";
			}
			
		//echo $fecha;
		?>
        <form name="fecha" action="index.php?select=viewpro&amp;s2=onprocesscrcur&amp;optionce=xarea&amp;fecha=post" method="post">
        <font class="blue">Desde:&nbsp;&nbsp;<br />
        <script>DateInput('desde', true, 'YYYY-MM-DD')</script><br /><br />
        <font class="blue">Hasta:&nbsp;&nbsp;<br />
        <script>DateInput('hasta', true, 'YYYY-MM-DD')</script><br />
        <input type="submit" value="Otra Fecha" />
        </font>
        </form>
        
        
        <?php
		include("scripts/vproduccioncrcur.php");
		
		}
		
		
	}

//On Process
if($s2 == "onprocesscur")
	{
	//echo $optionce;
	//Inicio o por area
	if($optionce == "" OR $optionce == "xarea")
		{
		//Obtiene la fecha
		$fecha = $_GET['fecha'];
		$manana1 = date('Y-m-d', strtotime("$fecha + 1 day"));
				
		//La fecha
		if($fecha == "")
			{
			$fecha = date('Y-d-m', time());
			$otra = "";
			//$horax = date('H', time());
			//echo $horax;
			//echo $fecha;
			
			$desde = date('Y-d-m', strtotime());
			?>
            <script language="javascript" type="text/javascript">
				setTimeout("location.href = 'index.php?select=viewpro&s2=onprocesscur&optionce=xarea&fecha=<?php echo $fecha;?>';", 600000);
			</script>
            <?php
			}
		
		//Postea la fecha
		if($fecha == "post")
			{
			$fecha = $_POST['desde'];
			$fechah = $_POST['hasta'];
			$otra = "otra";
			}
			
		//echo $fecha;
		?>
        <form name="fecha" action="index.php?select=viewpro&amp;s2=onprocesscur&amp;optionce=xarea&amp;fecha=post" method="post">
        <font class="blue">Desde:&nbsp;&nbsp;<br />
        <script>DateInput('desde', true, 'YYYY-MM-DD')</script><br /><br />
        <font class="blue">Hasta:&nbsp;&nbsp;<br />
        <script>DateInput('hasta', true, 'YYYY-MM-DD')</script><br />
        <input type="submit" value="Otra Fecha" />
        </font>
        </form>
        
        
        <?php
		include("scripts/vproduccioncur.php");
		
		}
		
		
	}


//On Process
if($s2 == "onprocess")
	{
	//echo $optionce;
	//Inicio o por area
	if($optionce == "" OR $optionce == "xarea")
		{
		//Obtiene la fecha
		$fecha = $_GET['fecha'];
		$manana1 = date('Y-m-d', strtotime("$fecha + 1 day"));
				
		//La fecha
		if($fecha == "")
			{
			$fecha = date('Y-d-m', time());
			$otra = "";
			//$horax = date('H', time());
			//echo $horax;
			//echo $fecha;
			
			$desde = date('Y-d-m', strtotime());
			?>
            <script language="javascript" type="text/javascript">
				setTimeout("location.href = 'index.php?select=viewpro&s2=onprocess&optionce=xarea&fecha=<?php echo $fecha;?>';", 600000);
			</script>
            <?php
			}
		
		//Postea la fecha
		if($fecha == "post")
			{
			$fecha = $_POST['desde'];
			$fechah = $_POST['hasta'];
			$otra = "otra";
			}
			
		//echo $fecha;
		?>
        <form name="fecha" action="index.php?select=viewpro&amp;s2=onprocess&amp;optionce=xarea&amp;fecha=post" method="post">
        <font class="blue">Desde:&nbsp;&nbsp;<br />
        <script>DateInput('desde', true, 'YYYY-MM-DD')</script><br /><br />
        <font class="blue">Hasta:&nbsp;&nbsp;<br />
        <script>DateInput('hasta', true, 'YYYY-MM-DD')</script><br />
        <input type="submit" value="Otra Fecha" />
        </font>
        </form>
        
        
        <?php
		include("scripts/vproduccion.php");
		
		}
		
		
	}


//Burnin & RunIn
if($s2 == "burnin")
	{
	//Solo para inicio
	if($optionce == "one")
		{
		?>
		<form action="index.php?select=viewpro&amp;s2=burnin&amp;optionce=show" method="post">
        <font class="blueH">BurnIn or RunIn Status</font><br>
        <font class="blue">
        Seleciona el Proyecto:<br>
            <select name="proyecto">
            <?php
            $cproyec = "SELECT DISTINCT proyecto_s FROM proyectos ORDER BY proyecto_s";
            $qproyec = mysql_query($cproyec, $cnx);

            //Repite por cada proyecto
            while($rproyec = mysql_fetch_array($qproyec))
                {
                ?>
                <option value="<?php echo $rproyec['proyecto_s'];?>" class="otext"><?php echo $rproyec['proyecto_s'];?></option>
                <?php
                }

            ?>
            </select>
        <br><br>
        <input type="submit" value="Siguiente" class="text">
        </font>
        </form>
		<?php	
		}
		
		
		
	//Muestra la tabla
	if($optionce == "show")
		{
		$gproy = $_POST['proyecto'];
		
		if($gproy == "")
			{
			$getp = $_GET['proyecto'];
			//Proyecto
			if($getp == "motorola")
				{
				$gproy = "Motorola SetUp Box";	
				}
			
			}
			
			
		//Obtiene las ubicaciones ocupadas
		$cubi = "SELECT * FROM burnin WHERE proyecto = '$gproy' ORDER BY minutes ASC, datetime ASC";
		$qubi = mysql_query($cubi, $cnx);
		?>
        <div style="width:600px; text-align:center; border:1px #05224e solid;">
    	<!-- Inicia Titulo-->
    	<div style="background-color:#05224e; border-bottom:1px #05224e solid; width:600px; text-align:center">
    	<font class="naranja">
    	Unidades de BurnIn
    	</font>
    	</div>
    	<table width="600" bgcolor="#05224e" cellpadding="1">
    	<tr class="trazul">
        	<td align="center">
        	<font class="negro">
        	Localidad
        	</font>
        	</td>
        	<td align="center">
        	<font class="negro">
        	Serial
        	</font>
        	</td>
        	<td align="center">
        	<font class="negro">
        	Tiempo Requerido
        	</font>
        	</td>
        	<td align="center">
        	<font class="negro">
        	Tiempo Restante
        	</font>
        	</td>
    	</tr>
        <?php
		//Despliega las localidades y estatus
		while($rubi = mysql_fetch_array($qubi))
			{
			$gdtt = $rubi['datetime'];
			//Obtiene la diferencia hora	
			$datetimek = time();
			//echo $datetimek . "<BR>";
			$datetimes = strtotime($gdtt);
			$seg = $datetimek - $datetimes;
			$min = $seg / 60;
			$minr = round($min, 0);
			
			$tiempor = $rubi['minutes'] - $minr;
			
			//Define color barra
			if($tiempor > 0)
				{
				$colorb = "#FF0000";	
				}
			
			if($tiempor == 0 OR $tiempor < 0)
				{
				$colorb = "#00FF00";	
				}
			
			
			?>
        <tr bgcolor="<?php echo $colorb;?>">
        	<td align="center">
            <font class="blue"><font color="#000000">
            <font size="+1">
            &nbsp;<?php echo $rubi['location'];?>&nbsp;
            </font></font>
            </font>
            </td>
            <td align="center">
            <font class="blue"><font color="#000000">
            <font size="+1">
            &nbsp;<?php echo $rubi['serial'];?>&nbsp;
            </font></font>
            </font>
            </td>
            <td align="center">
            <font class="blue"><font color="#000000">
            <font size="+1">
            &nbsp;<?php echo $rubi['minutes'];?>&nbsp;min&nbsp;
            </font></font>
            </font>
            </td>
            <td align="center">
            <font class="blue"><font color="#000000">
            <font size="+1">
			&nbsp;
			<?php
			echo round($tiempor, 0);
			?>
            &nbsp;min&nbsp;
            </font></font>
            </font>
            </td>
        </tr>
            <?php	
			}
		?>
        </table>
        </div>
        </center>
        <script language="javascript" type="text/javascript">
			setTimeout("location.href = 'index.php?select=viewpro&s2=burnin&optionce=show&proyecto=motorola';", 60000);
        </script>
        
        <?php
		
		
		
		}
		
	}



//Reporte Facturacion
if($s2 == "facturacion")
	{
	
	//Solo para pedir fechas
	if($optionce == "vntfs")
		{
		//Obtiene las fechas
		$desde = $_POST['fechad'];
		$desdex = $desde . " 00:00:00";
		$hasta = $_POST['fechah'];
		$hastax = $hasta . " 23:59:59";		
			
		?>
        <br /><br />
		<div id="box600" >
		<div id="inbox_t">
		<br />
		<font class="negrom">Salidas Acer<br /></font>
        <font class="reds">
        Desde:<b><?php echo $desde;?></b>&nbsp;Hasta:<b><?php echo $hasta;?></b></font>
		<br />
		</div>
		<div style="text-align:right">
        <a href="reporte_Xls.php?reporte=ntfs&amp;de=<?php echo $de;?>&amp;a=<?php echo $a;?>&amp;desde=<?php echo $desde;?>&amp;hasta=<?php echo $hasta;?>" target="_blank"><img src="images/xls_logo16.jpg" alt="Exportar a Excell" border="0" /></a>&nbsp;&nbsp;
        </div>
        <div id="inbox_t">
		<table width="580" cellpadding="3">
		<tr>
    		<td align="center" style="border:#CCC solid 1px; background:#999;">
    		<font class="negros">
    		Fecha
    		</font>
    		</td>
    		<td align="center" style="border:#CCC solid 1px; background:#999;">
    		<font class="negros">
    		Total Unidades
    		</font>
    		</td>
    		<td align="center" style="border:#CCC solid 1px; background:#999;">
    		<font class="negros">
    		Total NTF
    		</font>
    		</td>
    		<td align="center" style="border:#CCC solid 1px; background:#999;">
    		<font class="negros">
    		Total Rep
    		</font>
    		</td>
            <td align="center" style="border:#CCC solid 1px; background:#999;">
    		<font class="negros">
    		% NTF
    		</font>
    		</td>
            <td align="center" style="border:#CCC solid 1px; background:#999;">
    		<font class="negros">
    		Scrap
    		</font>
    		</td>
		</tr>
        <?php	
			
			
		
		
		//Obtiene las distintas fechas
		$sobtiene = "SELECT DATE(datetime) AS ddatetime FROM prosystem WHERE (status = 'Packout' OR status = 'ClosedScrap') AND datetime BETWEEN '$desdex' AND '$hastax' GROUP BY DATE(datetime) ORDER BY DATE(datetime) ASC";
		//echo $sobtiene;
		$qobtiene = mysql_query($sobtiene, $cnx);
		//Obtiene las fechas
		
		//Datos de la fila
		while($robtiene = mysql_fetch_array($qobtiene))
			{
					
		?>
        <tr bgcolor="#FFFFFF" onmouseover="this.bgColor='#E0ECF8'" onmouseout="this.bgColor='#FFFFFF'">
        <?php
		
			//Obtiene la informacion
			$dateactual = $robtiene['ddatetime'];
			//echo $dateactual;
			$ffecha = date('M d, Y', strtotime($dateactual));
			//Va el reporte
			$scantpack = "SELECT DISTINCT serial FROM prosystem WHERE (status = 'Packout' OR status = 'ClosedScrap') AND DATE(datetime) = '$dateactual'";
			//echo $scantpack;
			$qcantpack = mysql_query($scantpack, $cnx);
			$ncantpack = mysql_num_rows($qcantpack);
			//Obtiene si fue ntf o real
			$cantntf = 0;
			$cantrep = 0;
			$cantscrap = 0;
			
			while($rcantpack = mysql_fetch_array($qcantpack))
				{
				$serial = $rcantpack['serial'];
				//Obtiene el ultimo burnin
				$sserial = "SELECT * FROM prosystem WHERE serial = '$serial' AND (status LIKE 'BurnIn%' OR status = 'ClosedScrap') ORDER BY datetime DESC LIMIT 0, 1";
				//echo $sserial;
				$qserial = mysql_query($sserial, $cnx);
				$rserial = mysql_fetch_array($qserial);
				//Obtiene la informacion
				$gstatus = $rserial['status'];
				//echo $gstatus . "<br>";
				switch($gstatus){
					case "BurnIn1.5H":
					$cantrep = $cantrep + 1;	
					break;
					case "BurnIn3H":
					$cantntf = $cantntf + 1;
					break;
					case "ClosedScrap":
					$cantscrap = $cantscrap + 1;
					break;
					}
				
				}
			?>
            <td align="center" style="border:#CCC solid 1px;">
        	<font class="negros">
        	<?php echo $ffecha;?>
        	</font>
        	</td>
            <td align="center" style="border:#CCC solid 1px;">
        	<font class="negros">
        	<?php echo $ncantpack;?>
        	</font>
        	</td>
            <td align="center" style="border:#CCC solid 1px;">
        	<font class="negros">
        	<?php echo $cantntf;?>
        	</font>
        	</td>
            <td align="center" style="border:#CCC solid 1px;">
        	<font class="negros">
        	<?php echo $cantrep;?>
        	</font>
        	</td>
            <td align="center" style="border:#CCC solid 1px;">
        	<font class="negros">
        	<?php
            $porNTF = round(($cantntf / $ncantpack) * 100, 2);
			echo $porNTF . " %";
			?>
        	</font>
        	</td>
            <td align="center" style="border:#CCC solid 1px;">
        	<font class="reds">
        	<?php echo $cantscrap;?>
        	</font>
        	</td>
    	</tr>
            <?php
				
			}
		
		?>
        </table>
        </div>
        </div>
        <?php
		}
	
	
	//Solo para pedir fechas
	if($optionce == "reportentf")
		{
		?>
		<form action="index.php?select=viewpro&amp;s2=facturacion&amp;optionce=vntfs" method="post">
        <font class="negrom">Reporte Salidas</font><br>
        <font class="negros">
        
        Desde:<br>
        <script>DateInput('fechad', true, 'YYYY-MM-DD')</script>
        <br><br />
        Hasta:<br>
        <script>DateInput('fechah', true, 'YYYY-MM-DD')</script>
        <br>
        <input type="submit" value="Ver Reporte" class="subm">
        </font>
        </form>
		<?php	
		}
	
	
		
	}




//Inicio de Inventario
if($s2 == "inventario" OR $s2 == "")
	{
	
	//###########################33 Por Serial
	if($optionce == "xserialv")
		{
		$pserial = $_POST['serial'];
		
		$cserus = "SELECT * FROM prosystem WHERE serial = '$pserial' ORDER BY datetime DESC LIMIT 0,1";
		$qserus = mysql_query($cserus, $cnx);
		$nserus = mysql_fetch_array($qserus);
		
		//Solo si lo encontro
		if($nserus > 0)
			{
			?>
            <table width="600" bgcolor="#05224e" cellpadding="1">
    		<tr class="trazul">
       			<td align="center">
       			<font class="negro">
       			Ubicacion
       			</font>
       			</td>
                <td align="center">
       			<font class="negro">
       			RO
       			</font>
       			</td>
                <td align="center">
       			<font class="negro">
       			Serial
       			</font>
       			</td>
       			<td align="center">
       			<font class="negro">
       			Owner
       			</font>
       			</td>
       			<td align="center">
       			<font class="negro">
       			Fecha
       			</font>
       			</td>
       			<td align="center">
       			<font class="negro">
       			Estacion
       			</font>
       			</td>
                <td align="center">
       			<font class="negro">
       			Estatus
       			</font>
       			</td>
    		</tr>
            <?php
			$cserus1 = "SELECT * FROM prosystem WHERE serial = '$pserial' ORDER BY datetime DESC LIMIT 0,1";
			$qserus1 = mysql_query($cserus1, $cnx);
            //Despliega el resustado
			$rserus = mysql_fetch_array($qserus1);
			$locations = $rserus['location'];
			$ROs = $rserus['RO'];
			$mods = $rserus['modifico'];
			$datetimes = $rserus['datetime'];
			$stations = $rserus['station'];
			$statuss = $rserus['status'];
			
			?>
            <tr bgcolor="#FFFFFF">
            	<td align="center">
                <font class="blue">
               	<?php echo $locations;?>
                </font>
                </td>
                <td align="center">
                <font class="blue">
                <?php echo $ROs;?>
                </font>
                </td>
                <td align="center">
                <font class="blue">
                <?php echo $pserial;?>
                </font>
                </td>
                <td align="center">
                <font class="blue">
                <?php echo $mods;?>
                </font>
                </td>
                <td align="center">
                <font class="blue">
                <?php echo $datetimes;?>
                </font>
                </td>
                <td align="center">
                <font class="blue">
                <?php echo $stations;?>
                </font>
                </td>
                <td align="center">
                <font class="blue">
                <?php echo $statuss;?>
                </font>
                </td>
            </tr>
            
            </table>
			<?php	
			}
		else
			{
			?>
            <script language="javascript" type="text/javascript">
				alert("No se encontro el serial <?php echo $pserial;?> en la base de datos...");
            </script>
            <?php	
			}
		
		
		}
	
	//###########################33 Por Serial
	if($optionce == "xserial")
		{
		?>
        <center>
        <form action="index.php?select=viewpro&amp;s2=inventario&amp;optionce=xserialv" method="post">
        <font class="blueH">Ver Ultimo Status Serial</font><br>
        <font class="blue">
        Serial Number:<br />
        <input name="serial" class="text" type="text" />
        <br /><br />
        <input type="submit" value="Ver Status" />
        </font>
        </form>
        <br /><br />
        </center>
		<?php
		}
	
	//############################ Ver diagnosticadas
	if($optionce == "xempleadov")
		{
		$fechap = $_POST['fecha'];
		$fechaph = $_POST['fechah'];
		$turnop = $_POST['turno'];
		$s3 = $_POST['proyecto'];
		
		$ayer = date('Y-m-d', strtotime("$fechap - 1 day"));
		$manana = date('Y-m-d', strtotime("$fechaph + 1 day"));
		
		//Solo si es 1er Turno
		switch($turnop) {
			case "1";
			$down = 30;
			$up = 45;
			$desde = $fechap . " 06:00:00";
			$hasta = $fechaph . " 18:00:00";
			break;
			case "2";
			$down = 35;
			$up = 60;
			$desde = $fechap . " 18:00:00";
			$hasta = $manana . " 06:00:00";
			break;
		}
		
$sdatatemp = "SELECT * FROM prosystem WHERE datetime BETWEEN '$desde' AND '$hasta'";
//echo $sdatatemp;
$qdatatemp = mysql_query($sdatatemp, $cnx);
$ndatatemp = mysql_num_rows($qdatatemp);

$nrand = rand();
	
//Por cada registro encontrado lo crea en la tabla temporal
while($rdatatemp = mysql_fetch_array($qdatatemp))
	{
	//Datos Necesarios
	$wro = $rdatatemp['RO'];
	$wserial = $rdatatemp['serial'];
	$wflujo = $rdatatemp['flujo'];
	$wcliente = $rdatatemp['family'];
	$wmodelo = $rdatatemp['model'];
	$wproyecto = $rdatatemp['project'];
	$wdatetime = $rdatatemp['datetime'];
	$wmodifico = $rdatatemp['modifico'];
	$wowner = $rdatatemp['owner'];
	$wstation = $rdatatemp['station'];
	$wstatus = $rdatatemp['status'];
		
	//Inseta el registro
	$itemp = "INSERT INTO rprosystem VALUES('$nrand', '$wro', '$wserial', '$wflujo', '$wcliente', '$wmodelo', '$wproyecto', '$wdatetime', '$wmodifico', '$wowner', '$wstation', '$wstatus')";
	//echo $itemp . "<br>";
	mysql_query($itemp, $cnx);
		
	}


?>
	<table width="600" bgcolor="#05224e" cellpadding="1">
    <tr class="trazul">
       	<td align="center">
       	<font class="negro">
       	Nomina
       	</font>
       	</td>
       	<td align="center">
       	<font class="negro">
       	Empleado
       	</font>
       	</td>
       	<td align="center">
       	<font class="negro">
       	Cant
       	</font>
       	</td>
       	<td align="center">
       	<font class="negro">
       	Eficiencia
       	</font>
       	</td>
    </tr>
        <?php
		//Obtiene el numero de escaneadas
		$sempleados = "SELECT DISTINCT modifico FROM rprosystem WHERE nrand = '$nrand' ORDER BY modifico";
		$qempleados = mysql_query($sempleados, $cnx);
		
		
		//Despliega las localidades y estatus
		while($remp = mysql_fetch_array($qempleados))
			{
			$who = $remp['modifico'];
			
			//Obtiene la cantidad
			$obcantidad = "SELECT DISTINCT serial FROM rprosystem WHERE modifico = '$who' AND nrand = '$nrand'";
			$qbcantidad = mysql_query($obcantidad, $cnx);
			$nbcant = mysql_num_rows($qbcantidad);
			
			$ldown = $down - 1;
			$lup = $up - 1;
			
			//Colores
			if($nbcant < $down)
				{
				$bgcolor = "red";	
				}
			
			if($nbcant > $ldown AND $nbcant < $up)
				{
				$bgcolor = "yellow";	
				}
				
			if($nbcant > $lup)
				{
				$bgcolor = "green";	
				}
			?>
        <tr bgcolor="#FFFFFF">
        	<td align="center">
            <font class="blue"><font color="#000000">
            <font size="+1">
            &nbsp;&nbsp;
            </font></font>
            </font>
            </td>
            <td align="center">
            <font class="blue"><font color="#000000">
            <font size="+1">
            &nbsp;<?php echo $who;?>&nbsp;
            </font></font>
            </font>
            </td>
            <td align="center" bgcolor="<?php echo $bgcolor;?>">
            <font class="blue"><font color="#000000">
            <font size="+1">
            &nbsp;<?php echo $nbcant;?>&nbsp;
            </font></font>
            </font>
            </td>
            <td align="center">
            <font class="blue"><font color="#000000">
            <font size="+1">
			&nbsp;
			<?php
			
			?>
            &nbsp;
            </font></font>
            </font>
            </td>
        </tr>
            <?php	
			}
		?>
        </table>

<?php


//Elimina el dato de la tabla temporal
$ddatatemp = "DELETE FROM rprosystem WHERE nrand = '$nrand'";
mysql_query($ddatatemp, $cnx);



	}
	
	
	
	//################################ Por Burning Form
	if($optionce == "xempleado")
		{
		?>
		<form action="index.php?select=viewpro&amp;s2=inventario&amp;optionce=xempleadov" method="post">
        <font class="blueH">Reporte Escaneadas</font><br>
        <font class="blue">
        Seleciona el Proyecto:<br>
            <select name="proyecto">
            <?php
            $cproyec = "SELECT DISTINCT proyecto_s FROM proyectos ORDER BY proyecto_s";
            $qproyec = mysql_query($cproyec, $cnx);

            //Repite por cada proyecto
            while($rproyec = mysql_fetch_array($qproyec))
                {
                ?>
                <option value="<?php echo $rproyec['proyecto_s'];?>" class="otext"><?php echo $rproyec['proyecto_s'];?></option>
                <?php
                }

            ?>
            </select>
        <br><br>
        Turno:<br />
        <select name="turno" class="stext">
        	<option value="">Seleccionar...</option>
            <option value="1">1er Turno</option>
            <option value="2">2do Turno</option>
        </select>
        <br /><br />
        Desde:<br>
        <script>DateInput('fecha', true, 'YYYY-MM-DD')</script>
        <br><br />
        Hasta:<br>
        <script>DateInput('fechah', true, 'YYYY-MM-DD')</script>
        <br>
        <input type="submit" value="Siguiente" class="text">
        </font>
        </form>
		<?php
		}
	
	
	//############################ Ver diagnosticadas
	if($optionce == "diagnosticadasv")
		{
		$fechap = $_POST['fecha'];
		$turnop = $_POST['turno'];
		$s3 = $_POST['proyecto'];
		
		include("verdiagnosticadas.php");
			
		}
	
	
	
	//################################ Por Burning Form
	if($optionce == "diagnosticadas")
		{
		?>
		<form action="index.php?select=viewpro&amp;s2=inventario&amp;optionce=diagnosticadasv" method="post">
        <font class="blueH">Reporte Diagnosticadas</font><br>
        <font class="blue">
        Seleciona el Proyecto:<br>
            <select name="proyecto">
            <?php
            $cproyec = "SELECT DISTINCT proyecto_s FROM proyectos ORDER BY proyecto_s";
            $qproyec = mysql_query($cproyec, $cnx);

            //Repite por cada proyecto
            while($rproyec = mysql_fetch_array($qproyec))
                {
                ?>
                <option value="<?php echo $rproyec['proyecto_s'];?>" class="otext"><?php echo $rproyec['proyecto_s'];?></option>
                <?php
                }

            ?>
            </select>
        <br><br>
        Turno:<br />
        <select name="turno" class="stext">
        	<option value="">Seleccionar...</option>
            <option value="1">1er Turno</option>
            <option value="2">2do Turno</option>
        </select>
        <br /><br />
        Fecha:<br>
        <script>DateInput('fecha', true, 'YYYY-MM-DD')</script>
        <br>
        <input type="submit" value="Siguiente" class="text">
        </font>
        </form>
		<?php
		}
	
	
	
	//################################ Muestra el reporte de Burning
	if($optionce == "salidasv")
		{
		$gproj = $_POST['proyecto'];
		$dia = $_POST['fecha'];
		
		//Incluye el reporte
		include("prosalidas.php");
		
		
		}
	
	//################################ Por Burning Form
	if($optionce == "salidas")
		{
		?>
		<form action="index.php?select=viewpro&amp;s2=inventario&amp;optionce=salidasv" method="post">
        <font class="blueH">Reporte Salidas</font><br>
        <font class="blue">
        Seleciona el Proyecto:<br>
            <select name="proyecto">
            <?php
            $cproyec = "SELECT DISTINCT proyecto_s FROM proyectos ORDER BY proyecto_s";
            $qproyec = mysql_query($cproyec, $cnx);

            //Repite por cada proyecto
            while($rproyec = mysql_fetch_array($qproyec))
                {
                ?>
                <option value="<?php echo $rproyec['proyecto_s'];?>" class="otext"><?php echo $rproyec['proyecto_s'];?></option>
                <?php
                }

            ?>
            </select>
        <br><br>
        <select name="proceso" class="stext">
            <option value="ECO" class="otext">ECO</option>
            <option value="PreScreen" class="otext">PreScreen</option>
            <option value="RepEco" class="otext">RepEco</option>
            <option value="Reload" class="otext">Reload</option>
        </select>
        <br /><br />
        Fecha:<br>
        <script>DateInput('fecha', true, 'YYYY-MM-DD')</script>
        <br>
        <input type="submit" value="Siguiente" class="text">
        </font>
        </form>
		<?php
		}
	
	
	//################################ Por RO
	if($optionce == "xro")
		{
		
		
		//ver ro
		if($s3 == "show")
			{
			$gro = $_POST['ro'];
			
			//Si no viene en post
			if($gro == "")
				{
				$gro = $_GET['ro'];	
				}
			
			include("roview.php");
			
			}
		
		
		//inicio
		if($s3 == "")
			{
			?>
            <center>
    		<form action="index.php?select=viewpro&amp;s2=inventario&amp;optionce=xro&amp;s3=show" method="post">
    		<font class="blueH">Reporte XRO</font><br>
    		<font class="naranja">Selecciona el RO</font><br>
    		<br>
    		<font class="blue">
            Escribe el numero RO:<br />
            <input type="text" class="text" name="ro" />
            </font>
            <br /><br />
            <input type="submit" value="Ver Status" />
            </form>
            </center>
			<?php
			
			}
		
		}
	
	
	
	//#################################Hold For Part
	if($optionce == "hfp")
		{
		//Obtiene todos los numeros de parte que estan en HFP y activos
		$sqlcantidad = "SELECT COUNT(prosystem.location), prosystem.location FROM ginfprosystem, prosystem WHERE ginfprosystem.serial=prosystem.serial AND ginfprosystem.status='HFP' AND ginfprosystem.datetime= prosystem.datetime";
		//$qsqlcantidad = mysql_query($sqlcantidad, $cnx);
		//$ncantidad = mysql_num_rows($qsqlcantidad);
		//echo "x";
		//echo $ncantidad;
		
		?>
        <a href="reporte_Xls.php?reporte=hfp" target="_blank"><img src="images/xls_logo.jpg" width="92" height="93" alt="Download" border="0" /></a>
        <?php
		}
	
	
	
	//#################################Por Area
	if($optionce == "xarea")
		{
		//Ver el reporte
		if($s3 == "show")
			{
			$gproj = $_POST['proyecto'];
			$garea = $_POST['area'];
			
			include("invprogeneral.php");
			}
	
		//Inicio
		if($s3 == "")
			{
			?>
        	<center>
    		<form action="index.php?select=viewpro&amp;s2=inventario&amp;optionce=xarea&amp;s3=show" method="post">
    		<font class="blueH">Reporte XProyecto</font><br>
    		<font class="naranja">Inventario Actual</font><br>
    		<br>
    		<font class="blue">
    		Seleciona el Proyecto:<br>
    		<select name="proyecto">
    		<?php
    		$cproyec = "SELECT DISTINCT proyecto_s FROM proyectos ORDER BY proyecto_s";
    		$qproyec = mysql_query($cproyec, $cnx);

    		//Repite por cada proyecto
    		while($rproyec = mysql_fetch_array($qproyec))
    			{
        		?>
        		<option value="<?php echo $rproyec['proyecto_s'];?>" class="otext"><?php echo $rproyec['proyecto_s'];?></option>
        		<?php
        		}

     		?>
        	</select>
     		<br /><br />
			Seleciona el Area:<br>
    		<select name="area">
    		<?php
    		$carea = "SELECT DISTINCT status FROM prosystem WHERE status <> 'Pack' ORDER BY status";
    		$qarea = mysql_query($carea, $cnx);

    		//Repite por cada proyecto
    		while($rarea = mysql_fetch_array($qarea))
    			{
        		?>
        		<option value="<?php echo $rarea['status'];?>" class="otext"><?php echo $rarea['status'];?></option>
        		<?php
        		}

     		?>
        	</select>
     		<br /><br />

     		<input type="submit" value="Siguiente" class="text">
        	</font>
        	</form>
        	</center>
        	<?php	
			}	
		}
	
	
	
	?>
    
	
	<?php
	
	}









//  ######################################### Reporte E&E ############################
if($s2 == "eande")
    {
    ?>
    <center>
    <div style="width: 500px; background-color: #F7F7F7; border: solid orange 1px;">
    <font class="naranja"><b>Selecciona Tipo de Reporte</b></font><br />
    <a class="ablueH" href="index.php?select=viewfa&amp;s2=eande&amp;optionce=inicio&amp;s3=inicio">Reportes XProyecto</a>&nbsp;&nbsp;
    |&nbsp;&nbsp;
    <a class="ablueH" href="index.php?select=viewfa&amp;s2=eande&amp;optionce=xfamilia">Reporte XFamilia</a>
    |&nbsp;&nbsp;
    <a class="ablueH" href="index.php?select=viewfa&amp;s2=eande&amp;optionce=xtecnico">Reportes XTecnico</a>
    </div>
    <br />
    </center>
    <?php
    //Opcion de Inicio o Reporte por Proyecto
    if($optionce == "inicio")
        {
        //Para Inicio
        if($s3 == "inicio")
            {
            ?>
            <center>
                <form action="index.php?select=viewfa&amp;s2=eande&amp;optionce=inicio&amp;s3=gfecha" method="post">
            <font class="blueH">Reporte XProyecto</font><br>
            <font class="naranja">Eficiencia y Eficacia MDS</font><br>
            <br>
            <font class="blue">
            Seleciona el Proyecto:<br>
            <select name="proyecto">
            <?php
            $cproyec = "SELECT DISTINCT proyecto_s FROM proyectos ORDER BY proyecto_s";
            $qproyec = mysql_query($cproyec, $cnx);

            //Repite por cada proyecto
            while($rproyec = mysql_fetch_array($qproyec))
                {
                ?>
                <option value="<?php echo $rproyec['proyecto_s'];?>" class="otext"><?php echo $rproyec['proyecto_s'];?></option>
                <?php
                }

            ?>
            </select><br><br>
            <input type="submit" value="Siguiente" class="text">
            </font>
            </form>
            </center>
            <?php
            }
        
        //Requiere fecha
        if($s3 == "gfecha")
            {
            $s4 = $_POST['proyecto'];
            ?>
            <center>
            <form action="index.php?select=viewfa&amp;s2=eande&amp;optionce=inicio&amp;s3=greport&amp;s4=<?php echo $s4;?>" method="post">
            <font class="blueH">Reporte XTecnico</font><br>
            <font class="naranja">Unidades Pasadas <?php echo $s3;?></font><br>
            <br>
            <font class="blue">
            Desde:<br>
            <script>DateInput('desde', true, 'YYYY-MM-DD')</script>
            <br>
            Hasta:<br>
            <script>DateInput('hasta', true, 'YYYY-MM-DD')</script>
            <br>
            <input type="submit" value="Siguiente" class="text">
            </font>
            </form>
            </center>
            <?php
            }

        //Optiene los reportes
        if($s3 == "greport")
            {
            $gproy = $s4;
            $desde = $_POST['desde'];
            $hasta = $_POST['hasta'];

            //Aqui van los reportes
            include("ee_pastel.php");

            }



        }
    
        
    
    }



// ################################################# Reportes Pasadas
if($s2 == "reportesd")
	{
	
	//Muestra el reporte
	if($optionce == "tecnicosd")
		{
		$s3 = $_POST['proyecto'];
        $desde = $_POST['desde'];
        $hasta = $_POST['hasta'];
        ?>
        <font class="blueH">Reporte XTecnico</font><br>
        <font class="naranja">Unidades Pasadas <?php echo $s3;?><br>
        desde: <font class="blue"><?php echo $desde;?></font>&nbsp;&nbsp;&nbsp;
        hasta: <font class="blue"><?php echo $hasta;?></font>
        </font><br><br>
        <?php
        include("verdiagnosticadas.php");	
		}
		
	//Pide el Proyecto
	if($optionce == "inicio")
		{
		?>
        <center>
    	<form action="index.php?select=viewfa&amp;s2=reportesd&amp;optionce=tecnicosd" method="post">
    	<font class="blueH">Reporte XTecnico</font><br>
    	<font class="naranja">Unidades Diagnositcadas</font><br>
    	<br>
    	<font class="blue">
    	Seleciona el Proyecto:<br>
    	<select name="proyecto">
    	<?php
    	$cproyec = "SELECT DISTINCT proyecto_s FROM proyectos ORDER BY proyecto_s";
    	$qproyec = mysql_query($cproyec, $cnx);

    	//Repite por cada proyecto
    	while($rproyec = mysql_fetch_array($qproyec))
    		{
        	?>
        	<option value="<?php echo $rproyec['proyecto_s'];?>" class="otext"><?php echo $rproyec['proyecto_s'];?></option>
        	<?php
        	}
		?>
        </select><br><br>
        <font class="blue">
        Desde:<br>
        <script>DateInput('desde', true, 'YYYY-MM-DD')</script>
        <br>
        Hasta:<br>
        <script>DateInput('hasta', true, 'YYYY-MM-DD')</script>
        <br /><br />
        <input type="submit" value="Siguiente" class="text">
        </font>
        </font>
        </form>
        </center>
        <?php	
		}
	
	
	
	
	
	}




//********************************************************************************** MDS
if($s2 == "mds")
	{
	//Inicio o por area
	if($optionce == "" OR $optionce == "inicio" OR $optionce == "dandpass")
		{
		//Obtiene la fecha
		$fecha = $_GET['fecha'];
		$manana1 = date('Y-m-d', strtotime("$fecha + 1 day"));
				
		//La fecha
		if($fecha == "")
			{
			$fecha = date('Y-d-m', time());
			$otra = "";
			//$horax = date('H', time());
			//echo $horax;
			//echo $fecha;
			
			//$desde = date('Y-d-m', strtotime());
			?>
            <script language="javascript" type="text/javascript">
				setTimeout("location.href = 'index.php?select=viewpro&s2=mds&optionce=dandpass&fecha=<?php echo $fecha;?>';", 600000);
			</script>
            <?php
			}
		
		//Postea la fecha
		if($fecha == "post")
			{
			$fecha = $_POST['desde'];
			$fechah = $_POST['hasta'];
			$otra = "otra";
			}
			
		//echo $fecha;
		?>
        <form name="fecha" action="index.php?select=viewpro&amp;s2=mds&amp;optionce=dandpass&amp;fecha=post" method="post">
        <font class="blue">Desde:&nbsp;&nbsp;<br />
        <script>DateInput('desde', true, 'YYYY-MM-DD')</script><br /><br />
        <font class="blue">Hasta:&nbsp;&nbsp;<br />
        <script>DateInput('hasta', true, 'YYYY-MM-DD')</script><br />
        <input type="submit" value="Otra Fecha" />
        </font>
        </form>
        
        
        <?php
		include("vmds.php");
		
		}
		
		
	}






// ################################################## Opciones Reportes inventario
if($s2 == "reportes")
    {
    ?>
    <center>
    <div style="width: 500px; background-color: #F7F7F7; border: solid orange 1px;">
    <font class="naranja"><b>Selecciona Tipo de Reporte</b></font><br />
    <a class="ablueH" href="index.php?select=viewfa&amp;s2=reportes&amp;optionce=componentes">Reportes Componentes</a>&nbsp;&nbsp;
    |&nbsp;&nbsp;
    <a class="ablueH" href="index.php?select=viewfa&amp;s2=reportes&amp;optionce=proyecto">Download XProyecto</a>
    |&nbsp;&nbsp;
    <a class="ablueH" href="index.php?select=viewfa&amp;s2=reportes&amp;optionce=tecnicos">Reportes XTecnico</a>
    </div>
    <br />
    </center>
    <?php

    //Reportes por Tecnico
    if($optionce == "tecnicos")
        {
        ?>
        <center>
        <form action="index.php?select=viewfa&amp;s2=reportes&amp;optionce=tecnicosp" method="post">
        <font class="blueH">Reporte XTecnico</font><br>
        <font class="naranja">Unidades Pasadas</font><br>
        <br>
        <font class="blue">
        Seleciona el Proyecto:<br>
        <select name="proyecto">
        <?php
        $cproyec = "SELECT DISTINCT proyecto_s FROM proyectos ORDER BY proyecto_s";
        $qproyec = mysql_query($cproyec, $cnx);
        //Repite por cada proyecto
        while($rproyec = mysql_fetch_array($qproyec))
            {
            ?>
            <option value="<?php echo $rproyec['proyecto_s'];?>" class="otext"><?php echo $rproyec['proyecto_s'];?></option>
            <?php
            }

        ?>
        </select><br><br>
        <input type="submit" value="Siguiente" class="text">
        </font>
        </form>
        </center>
        <?php
        }

    //Reportes Salidas Tecnicos
    if($optionce == "tecnicosp")
        {
        $s3 = $_POST['proyecto'];

        ?>
        <center>
        <form action="index.php?select=viewfa&amp;s2=reportes&amp;optionce=tecnicosv&amp;s3=<?php echo $s3;?>" method="post">
        <font class="blueH">Reporte XTecnico</font><br>
        <font class="naranja">Unidades Pasadas <?php echo $s3;?></font><br>
        <br>
        <font class="blue">
        Desde:<br>
        <script>DateInput('desde', true, 'YYYY-MM-DD')</script>
        <br>
        Hasta:<br>
        <script>DateInput('hasta', true, 'YYYY-MM-DD')</script>
        <br>
        <input type="submit" value="Siguiente" class="text">
        </font>
        </form>
        </center>
        <?php
        }

    //Ver Reporte por tecnico
    if($optionce == "tecnicosv")
        {
        $s3 = $_GET['s3'];
        $desde = $_POST['desde'];
        $hasta = $_POST['hasta'];
        ?>
        <font class="blueH">Reporte XTecnico</font><br>
        <font class="naranja">Unidades Pasadas <?php echo $s3;?><br>
        desde: <font class="blue"><?php echo $desde;?></font>&nbsp;&nbsp;&nbsp;
        hasta: <font class="blue"><?php echo $hasta;?></font>
        </font><br><br>
        <?php
        include("verpasadasfa.php");
        }

    //Ver Reporte por tecnico
    if($optionce == "tecnico")
        {
        $s3 = $_GET['s3'];
        $desde = $_GET['desde'];
        $hasta = $_GET['hasta'];
        $tec = $_GET['tec'];
        ?>
        <font class="blueH">Reporte XTecnico</font><br>
        <font class="naranja">Unidades Pasadas <?php echo $s3;?><br>
        Tecnico: <font class="blue"><b><?php echo $tec;?></b></font><br>
        desde: <font class="blue"><?php echo $desde;?></font>&nbsp;&nbsp;&nbsp;
        hasta: <font class="blue"><?php echo $hasta;?></font>
        </font><br><br>
        <?php

        }

    //Reportes de Componentes
    if($optionce == "componentes" OR $optionce == "inicio")
        {
        ?>
        <center>
        <form action="index.php?select=viewfa&amp;s2=reportes&amp;optionce=componentesp" method="post">
        <font class="blueH">Reporte XComponente</font><br>
        <font class="naranja">Unidades Pasadas</font><br><br>
        <font class="blue">
        Seleciona el Proyecto:<br>
        <select name="proyecto">
        <?php
        $cproyec = "SELECT DISTINCT proyecto_s FROM proyectos ORDER BY proyecto_s";
        $qproyec = mysql_query($cproyec, $cnx);
        
        //Repite por cada proyecto
        while($rproyec = mysql_fetch_array($qproyec))
            {
            ?>
            <option value="<?php echo $rproyec['proyecto_s'];?>" class="otext"><?php echo $rproyec['proyecto_s'];?></option>
            <?php
            }
        
        ?>
        </select><br><br>
        <input type="submit" value="Siguiente" class="text">
        </font>
        </form>
        </center>
        <?php
        }


        
    //Reportes de Componentes
    if($optionce == "componentesp")
        {
        $s3 = $_POST['proyecto'];

        ?>
        <center>
        <form action="index.php?select=viewfa&amp;s2=reportes&amp;optionce=componentesv&amp;s3=<?php echo $s3;?>" method="post">
        <font class="blueH">Reporte XComponente</font><br>
        <font class="naranja">Unidades Pasadas <?php echo $s3;?></font><br><br>
        <font class="blue">
        Seleciona la Familia:<br>
        <font class="naranja"><font size="-1">
        Solo muestra Familias con unidades<br>
        bien diagnosticadas.
        </font></font><br>
        <select name="family">
        <?php
        $cmodel = "SELECT DISTINCT family FROM fasystem WHERE status = 'ToTest' AND project = '$s3' ORDER BY family";
        $qmodel = mysql_query($cmodel, $cnx);

        //Repite por cada proyecto
        while($rmodel = mysql_fetch_array($qmodel))
            {
            ?>
            <option value="<?php echo $rmodel['family'];?>" class="otext"><?php echo $rmodel['family'];?></option>
            <?php
            }

        ?>
        </select><br><br>
        <input type="submit" value="Siguiente" class="text">
        </font>
        </form>
        </center>
        <?php
        }

    //Reporte Final
    if($optionce == "componentesv")
        {
        $s3 = $_GET['s3'];
        $s4 = $_POST['family'];
        ?>
        <font class="blueH">Reporte XComponente</font><br>
        <font class="naranja">Unidades Pasadas <?php echo $s3 . "- " . $s4;?></font><br><br>
        <?php
        include("vercomponentes.php");

        }


        
    }



// ################################################## Opciones Inventario 
if($s2 == "inventariox")
	{
	$modelx = $_GET['modelo'];	
	//echo $s3;
	if($s4 == "new")
		{
		$cliente = "RCLM";	
		}
	else
		{
		$cliente = "GSCE";	
		}
	
	
	//Solo Inicio
	if($s3 == "inicio")
		{	
		include("scripts/inventario.php");	
		}
	else
		{
			
		//Solo para days in house
		if($s3 == "dias")
			{
			//Dias inhouse
			$gdays = $_GET['days'];
			$hoyes = date('Y-m-d', time());
			$finddate = date('Y-m-d', strtotime("$hoyes - $gdays day"));
			
			//echo $finddate;
			$smisu = "SELECT ginfprosystem.*, ros.frecibo FROM ginfprosystem, ros WHERE ginfprosystem.RO = ros.ro AND ros.frecibo = '$finddate' AND ginfprosystem.status != 'Pack' AND ginfprosystem.status != 'HoldFC' ORDER BY datetime";
			$s3 = $gdays . " Days";
			}
		else
			{
			//Solo por modelo
			if($modelx == "all")
				{
				//Obtiene los seriales
				$smisu = "SELECT * FROM ginfprosystem WHERE status = '$s3' AND cliente = '$cliente' ORDER BY datetime";	
				}
			else
				{
				//Obtiene los seriales
				$smisu = "SELECT * FROM ginfprosystem WHERE status = '$s3' AND cliente = '$cliente' AND modelo = '$modelx' ORDER BY datetime";	
				}
					
			}
			
		//Detalle Inventario
		?>
		<br /><br />
		<div id="box900" >
		<div id="inbox_t">
		<br />
		<font class="negrom">Unidades en <?php echo $s3;?></font>
		<br /><br />
		</div>
		<br />
        <div id="inbox_t">
		<table width="879" cellpadding="3">
		<tr>
    		<td align="center" style="border:#CCC solid 1px; background:#999;">
    		<font class="negros">
    		Count
    		</font>
    		</td>
    		<td align="center" style="border:#CCC solid 1px; background:#999;">
    		<font class="negros">
    		Serial
    		</font>
    		</td>
    		<td align="center" style="border:#CCC solid 1px; background:#999;">
    		<font class="negros">
    		Cliente
    		</font>
    		</td>
    		<td align="center" style="border:#CCC solid 1px; background:#999;">
    		<font class="negros">
    		Modelo
    		</font>
    		</td>
    		<td align="center" style="border:#CCC solid 1px; background:#999;">
    		<font class="negros">
            Modifico
            </font>
    		</td>
    		<td align="center" style="border:#CCC solid 1px; background:#999;">
    		<font class="negros">
    		Ultimo Cambio
    		</font>
    		</td>
    		<td align="center" style="border:#CCC solid 1px; background:#999;">
    		<font class="negros">
    		Status
    		</font>
    		</td>
		</tr>
		<?php
		$qmisu = mysql_query($smisu, $cnx);
		$count = 0;
		while ($rmisu = mysql_fetch_array($qmisu))
    		{
    		$count = $count + 1;
    		//Datos
    		$miserial = $rmisu['serial'];
			$gRO = $rmisu['RO'];
    		$gploc = $rmisu['plocation'];
    		$gfam = $rmisu['cliente'];
    		$gmod = $rmisu['modelo'];
    		$gown = $rmisu['modifico'];
    		$gdat = $rmisu['datetime'];
    		$gst = $rmisu['status'];
			$gcliente = $rmisu['cliente'];
			
			
			
    		$cstatus = $gst;
	
    		$hoyfecha = date('Y-m-d', time());
			$movfecha = date('Y-m-d', strtotime($gdat));
			
			//Cambia color la fecha
			if($movfecha == $hoyfecha)
				{
				$datcolor = "#D8F781";	
				}	
			else
				{
				$datcolor = "#F6CECE";	
				}
			
    		?>
    	<tr bgcolor="#FFFFFF" onmouseover="this.bgColor='#E0ECF8'" onmouseout="this.bgColor='#FFFFFF'">
       		<td align="center" width="80" style="border:#CCC solid 1px;">
        	<font class="negross">
        	<?php echo $count;?>
        	</font>
        	</td>
        	<td align="left" style="border:#CCC solid 1px;">
        	<font class="negross">
            <a href="javascript:popUp2('historial.php?select=ver&serial=<?php echo $miserial;?>')"><img src="images/lupa16.png" width="16" height="16" alt="Ver Historial" border="0" /></a>
        	<?php echo $miserial;?>
        	</font>
       	  </td>
        	<td align="center" width="80" style="border:#CCC solid 1px;">
        	<font class="negross">
        	<?php echo $gcliente;?>
        	</font>
        	</td>
        	<td align="center" width="80" style="border:#CCC solid 1px;">
        	<font class="negross">
        	<?php echo $gmod;?>
        	</font>
        	</td>
        	<td align="center" width="80" style="border:#CCC solid 1px;">
        	<font class="negross">
        	<?php echo $gown;?>
        	</font>
        	</td>
        	<td align="center" width="80" style="border:#CCC solid 1px; background-color:<?php echo $datcolor;?>;">
        	<font class="negross">
        	<?php echo $gdat;?>
        	</font>
        	</td>
        	<td align="center" width="80" style="border:#CCC solid 1px;">
        	<font class="negross">
        	<?php echo $gst;?>
        	</font>
        	</td>
    	</tr>
    	<?php
    		}
			?>
		</table>
 		</div>
		</div>
		</center>
		</font>
        
		
		<?php
			
		}
	
	}




// ################################################## Opciones TAT Report
if($s2 == "tatreport")
	{
	//Opciones para inicio
	if($optionce == "inicio" AND $s3 == "nocomcast")
		{
		$orden = $_GET['orden'];
		
		//Cambia el orden
		switch($orden) {
			case "ber":
			$order = "ber DESC";
			break;
			case "closeon":
			$order = "closeon ASC";
			break;
			case "fecharec":
			$order = "fecharec";
			break;
			case "RO":
			$order = "RO";
			break;
            case "hfp":
			$order = "cliente ASC, hfp DESC";
			break;
			case "cliente":
			$order = "cliente ASC, days DESC";
			break;
			case "days":
			$order = "days DESC";
			break;
			case "cant":
			$order = "cliente ASC, cant DESC";
			break;
			case "checkin":
			$order = "checkin DESC";
			break;
			case "ing":
			$order = "ing DESC";
			break;
			case "bga":
			$order = "bga DESC";
			break;
			case "predata":
			$order = "predata DESC";
			break;
			case "postdata":
			$order = "postdata DESC";
			break;
		}
		
		?>
        <script language="javascript" type="text/javascript">
    		setTimeout("location.href = 'index.php?select=viewpro&s2=tatreport&optionce=inicio&orden=<?php echo $orden;?>&s3=nocomcast';", 800000);
    	</script>
        
        <font class="blueH">
        TAT Report No Comcast
        </font>
        <br /><br />
        <table width="800" bgcolor="#05224e" cellpadding="1">
		<tr>
    		<td colspan="15" align="center">
    		<font class="naranja">
    		TAT Report
    		</font>
    		</td>
		</tr>
		<tr class="trazul">
    		<td align="center">
    		<a href="index.php?select=viewpro&amp;s2=tatreport&amp;optionce=inicio&amp;orden=RO&amp;s3=nocomcast" class="ablueH">RO</a>
    		</td>
    		<td align="center">
    		<a href="index.php?select=viewpro&amp;s2=tatreport&amp;optionce=inicio&amp;orden=fecharec&amp;s3=nocomcast" class="ablueH">RecCalexico</a>
    		</td>
    		<td align="center">
    		<a href="index.php?select=viewpro&amp;s2=tatreport&amp;optionce=inicio&amp;orden=cliente&amp;s3=nocomcast" class="ablueH">Cliente</a>
            </td>
    		<td align="center">
    		<a href="index.php?select=viewpro&amp;s2=tatreport&amp;optionce=inicio&amp;orden=days&amp;s3=nocomcast" class="ablueH">DaysInHouse</a>
            </td>
    		<td align="center">
    		<a href="index.php?select=viewpro&amp;s2=tatreport&amp;optionce=inicio&amp;orden=cant&amp;s3=nocomcast" class="ablueH">Cantidad</a>
            </td>
            <td align="center">
    		<a href="index.php?select=viewpro&amp;s2=tatreport&amp;optionce=inicio&amp;orden=checkin&amp;s3=nocomcast" class="ablueH">CheckIn</a>
            </td>
    		<td align="center">
    		<a href="index.php?select=viewpro&amp;s2=tatreport&amp;optionce=inicio&amp;orden=ing&amp;s3=nocomcast" class="ablueH">Ing</a>
            </td>
            <td align="center">
    		<a href="index.php?select=viewpro&amp;s2=tatreport&amp;optionce=inicio&amp;orden=bga&amp;s3=nocomcast" class="ablueH">BGA</a>
            </td>
            <td align="center">
    		<a href="index.php?select=viewpro&amp;s2=tatreport&amp;optionce=inicio&amp;orden=hfp&amp;s3=nocomcast" class="ablueH">HFP</a>
            </td>
    		<td align="center">
    		<a href="index.php?select=viewpro&amp;s2=tatreport&amp;optionce=inicio&amp;orden=predata&amp;s3=nocomcast" class="ablueH">WIP</a>
            </td>
    		<td align="center">
    		<a href="index.php?select=viewpro&amp;s2=tatreport&amp;optionce=inicio&amp;orden=postdata&amp;s3=nocomcast" class="ablueH">Pack</a>
            </td>
            <td align="center">
    		<a href="index.php?select=viewpro&amp;s2=tatreport&amp;optionce=inicio&amp;orden=shipped&amp;s3=nocomcast" class="ablueH">Shipped</a>
            </td>
            <td bgcolor="#CCCCCC">&nbsp;
            
            </td>
            <td align="center">
    		<a href="index.php?select=viewpro&amp;s2=tatreport&amp;optionce=inicio&amp;orden=closeon&amp;s3=nocomcast" class="ablueH">CloseOn</a>
            </td>
            <td align="center">
    		<a href="index.php?select=viewpro&amp;s2=tatreport&amp;optionce=inicio&amp;orden=ber&amp;s3=nocomcast" class="ablueH">BER</a>
            </td>
    	</tr>
        <?php
		//Obtiene los RO's con pendiente cierre orden
		$sorden = "SELECT DISTINCT RO FROM ginfprosystem WHERE status != 'Pack' AND (cliente != 'comcast' OR cliente != 'COMCAST' OR cliente != 'ComCast' OR cliente != 'Comcast') ORDER BY RO";
		$qorden = mysql_query($sorden, $cnx);
		
		//Totales
		$tcheckin = 0;
		$tnbga = 0;
		$tnpredata = 0;
		$tpdata = 0;
		
		//Nuevo Rand
		$nrand = rand();
		//Por cada RO
		while($rorden = mysql_fetch_array($qorden))
			{
			$fooRO = $rorden['RO'];
			//Busca la informacion
			//Obtiene la fecha
			$sro = "SELECT * FROM ros WHERE RO = '$fooRO'";
			$qro = mysql_query($sro, $cnx);
			$rro = mysql_fetch_array($qro);
			//Datos del RO
			$frecibo1 = $rro['frecibo'];
			$cant = $rro['cant'];
			$cliente = $rro['cliente'];
			$shipped = $rro['shipped'];
			//Obtiene los dias inhous
			$pdays = (strtotime(date('Y-m-d')) - strtotime($frecibo1)) / (60*60*24);
			$days = round($pdays, 2);
				
			//Despliega la fecha de recibo
			$frecibo = date('M d, Y', strtotime($frecibo1));
			
			//Obtiene el status de las unidades
			$sbga = "SELECT * FROM ginfprosystem WHERE RO = '$fooRO' AND status = 'BGARepair'";
			$qbga = mysql_query($sbga, $cnx);
			$nbga = mysql_num_rows($qbga);
				
			//Total BGA
			$tnbga = $tnbga + $nbga;
				
			//Obtiene el status de las unidades
			$spack = "SELECT * FROM ginfprosystem WHERE RO = '$fooRO' AND status = 'Pack'";
			//echo $spack;
			$qpack = mysql_query($spack, $cnx);
			$npack = mysql_num_rows($qpack);
            //PostData
			$pdata = $npack - $shipped;
			
			//Total de Pack
			$tpdata = $tpdata + $pdata;
			            
            //Obtiene el status de las unidades HFP
			$shfp = "SELECT * FROM ginfprosystem WHERE RO = '$fooRO' AND status = 'HFP'";
			//echo $spack;
			$qhfp = mysql_query($shfp, $cnx);
			$nhfp = mysql_num_rows($qhfp);
			
			//Obtiene el status de las unidades
			$sber = "SELECT * FROM ginfprosystem WHERE RO = '$fooRO' AND status = 'Pack' AND estacion = 'SCRAP'";
			$qber = mysql_query($sber, $cnx);
			$nber = mysql_num_rows($qber);
			
			$ber = (($nber / $cant) * 100);
			//echo $ber;
			
			//Obtiene el status de las unidades
			$spredata = "SELECT * FROM ginfprosystem WHERE RO = '$fooRO' AND status <> 'Pack' AND status <> 'BGARepair' AND status <> 'HFP'";
			$qpredata = mysql_query($spredata, $cnx);
			$npredata = mysql_num_rows($qpredata);
				
			//Total predata
			$tnpredata = $tnpredata + $npredata;
			
			//CheckIn
			$checkin = $cant - ($nbga + $npack + $npredata + $nhfp);
				
			//Total CheckIn
			$tcheckin = $tcheckin + $checkin;
			
			
			//Obtiene la fecha RO
			$scdro = "SELECT * FROM ros WHERE ro = '$fooRO'";
			$qcdro = mysql_query($scdro, $cnx);
			$rcdro = mysql_fetch_array($qcdro);
			//Convierte a Fecha
			$cdro_ = $rcdro['cierre'];
			$comentros = $rcdro['comentarios'];
			//Inserta a la tabla temporal
			$itempTAT = "INSERT INTO tempTAT VALUES('$nrand', '$fooRO', '$frecibo1', '$cliente', '$days', '$cant', '$checkin', '$ing', '$nbga', '$nhfp', '$nhfc', '$npredata', '$pdata', '$shipped', NOW(), '$cdro_', '$ber', '', '', '$comentros')";
			mysql_query($itempTAT, $cnx);
			
			}
		
		
		//Obtiene Info de cada RO
		$oinfo = "SELECT * FROM tempTAT WHERE id = '$nrand' ORDER BY $order";
		$qinfo = mysql_query($oinfo, $cnx);
		//echo $oinfo;
		
		//Por cada RO
		while($rinfo = mysql_fetch_array($qinfo))
			{
			//Va la info
			?>
			<tr bgcolor="#FFFFFF" onmouseover="this.bgColor='#E0ECF8'" onmouseout="this.bgColor='#FFFFFF'">
            	<td align="left">
                <font class="blue">
                &nbsp;
				<a href="index.php?select=viewpro&amp;s2=inventario&amp;optionce=xro&amp;s3=show&amp;ro=<?php echo $rinfo['RO'];?>"><img src="images/lupa16.png" width="16" height="16" alt="VerRO" border="0" /></a>&nbsp;<?php echo $rinfo['RO'];?>
				&nbsp;
                </font>
                </td>
              <td align="center">
                <font class="blue">
                <?php 
				$frecibox = $rinfo['fecharec'];
				$frecibo = date('M d, Y', strtotime($frecibox));
				echo $frecibo;
				?>
                </font>
                </td>
                <td align="center">
                <font class="blue">
                <?php echo $rinfo['cliente'];?>
                </font>
                </td>
                <td align="center">
                <font class="blue">
                <?php echo $rinfo['days'];?>
                </font>
                </td>
                <td align="center" bgcolor="#CCCCCC"><font class="blue"><b><?php echo $rinfo['cant'];?></b></font></td>
                <td align="center">
                <font class="blue">
                
				<font color="#FF0000"><b>
				<?php 
				//Solo si es mayor a 0
				if($rinfo['checkin'] > 0)
					{
					echo $rinfo['checkin'];
					}
				?></b></font>
                </font>
                </td>
                <td align="center" bgcolor="#CCCCCC">
                <font class="blue"><font color="#FFFFFF"><b>
                <?php echo $rinfo['ing'];?>
                </b></font>
                </font>
                </td>
                <td align="center" bgcolor="#FF0000">
                <font class="blue"><font color="#FFFFFF"><b>
                <?php echo $rinfo['bga'];?>
                </b></font>
                </font>
                </td>
                <td align="center" bgcolor="orange">
                <font class="blue"><font color="#000000"><b>
                <?php echo $rinfo['hfp'];?>
                </b></font>
                </font>
                </td>
                <td align="center" bgcolor="#FFFF00">
                <font class="blue"><font color="#000000"><b>
                <?php echo $rinfo['predata'];?>
                </b></font>
                </font>
                </td>
                <td align="center" bgcolor="#00FF00">
                <font class="blue"><font color="#000000"><b>
                <?php echo $rinfo['postdata'];?>
                </b></font>
                </font>
                </td>
                <td align="center" bgcolor="#006633">
                <font class="blue"><font color="#000000"><b>
                <?php echo $rinfo['shipped'];?>
                </b></font>
                </font>
                </td>
                <td bgcolor="#CCCCCC">&nbsp;
                </td>
                <?php
				$fechacom = $rinfo['closeon'];
				$coment = $rinfo['comentarios'];
				
				//Solo si es hay compromiso cierre
				if($fechacom <> "0000-00-00")
					{
					$cdro = strtotime($fechacom);
					$todaytime = strtotime(date('Y-m-d', time()));
					
					$fechacomp = date('M d', $cdro);
					
					//Color de la columna
					//echo $cdro . "<br>";
					//echo $todaytime . "<br>";
				
					//Igual compromiso al dia de hoy
					if($cdro == $todaytime)
						{
						$colorfecha = "#FFFF00";
						$fcolorfecha = "#000000";	
						}
				
					//Mayor compromiso al dia de hoy
					if($cdro > $todaytime)
						{
						$colorfecha = "#00FF00";
						$fcolorfecha = "#000000";	
						}
				
					//Menor compromiso al dia de hoy
					if($cdro < $todaytime)
						{
						$colorfecha = "#FF0000";
						$fcolorfecha = "#FFFFFF";	
						}
				
					}
				else
					{
					$fechacomp = $coment;	
					$colorfecha = "#FFFFFF";
					$fcolorfecha = "#000000";	
					}
				?>
                <td bgcolor="<?php echo $colorfecha;?>">
                <font class="blue"><font color="<?php echo $fcolorfecha;?>"><b>
                &nbsp;<?php echo $fechacomp;?>&nbsp;
                </b></font>
                </td>
                <td>
                <font class="blue"><font color="red" size="-2"><b>
                <?php echo $rinfo['ber'];?>&nbsp;%
                </b></font></font>
                </td>
            </tr>
			<?php
			}
		?>
        </table>
<br /><br /><br />
        <table width="400" bgcolor="#05224e" cellpadding="1">
		<tr>
    		<td colspan="4" align="center">
    		<font class="naranja">
    		Resumen TAT Report
    		</font>
    		</td>
		</tr>
		<tr class="trazul">
        	<td align="center">
    		<font class="negro">
    		Total Checkin
    		</font>
    		</td>
            <td align="center">
            <font class="negro">
    		Total BGA
    		</font>
    		</td>
            <td align="center">
            <font class="negro">
    		Total PreData
    		</font>
    		</td>
            <td align="center">
            <font class="negro">
    		Total Pack
    		</font>
    		</td>
        </tr>
        <tr bgcolor="#FFFFFF">
        <td align="center">
                <font class="blue">
                &nbsp;
				<font color="#FF0000" size="+2"><b>
				<?php 
				//Solo si es mayor a 0
				if($tcheckin > 0)
					{
					echo $tcheckin;
					}
				?>&nbsp;</b></font>
                </font>
                </td>
                <td align="center" bgcolor="#FF0000">
                <font class="blue"><font color="#FFFFFF" size="+2"><b>
                &nbsp;
				<?php
                echo $tnbga;
				?>&nbsp;</b></font>
                </font>
                </td>
                <td align="center" bgcolor="#FFFF00">
                <font class="blue"><font color="#000000" size="+2"><b>
                &nbsp;
				<?php
                echo $tnpredata;
				?>&nbsp;</b></font>
                </font>
                </td>
                <td align="center" bgcolor="#00FF00">
                <font class="blue"><font color="#000000" size="+2"><b>
                &nbsp;
				<?php
                echo $tpdata;
				?>&nbsp;</b></font>
                </font>
                </td>	
        </tr>
        </table>
<br /><br />
		<?php
		
		//Eliminia la tabla
		$dtabla = "DELETE FROM tempTAT WHERE id = '$nrand'";
		mysql_query($dtabla, $cnx);
		
		}




	//Opciones para inicio
	if($optionce == "inicio" AND $s3 == "comcast")
		{
		$orden = $_GET['orden'];
		
		//Cambia el orden
		switch($orden) {
			case "ber":
			$order = "ber DESC";
			break;
			case "closeon":
			$order = "closeon ASC";
			break;
			case "fecharec":
			$order = "fecharec";
			break;
			case "RO":
			$order = "RO";
			break;
            case "hfp":
			$order = "cliente ASC, hfp DESC";
			break;
			case "cliente":
			$order = "cliente ASC, days DESC";
			break;
			case "days":
			$order = "days DESC";
			break;
			case "cant":
			$order = "cliente ASC, cant DESC";
			break;
			case "checkin":
			$order = "checkin DESC";
			break;
			case "ing":
			$order = "ing DESC";
			break;
			case "bga":
			$order = "bga DESC";
			break;
			case "predata":
			$order = "predata DESC";
			break;
			case "postdata":
			$order = "postdata DESC";
			break;
		}
		
		?>
        <script language="javascript" type="text/javascript">
    		setTimeout("location.href = 'index.php?select=viewpro&s2=tatreport&optionce=inicio&orden=<?php echo $orden;?>&s3=comcast';", 800000);
    	</script>
        
        <font class="blueH">
        TAT Report Comcast
        </font>
        <br /><br />
        <table width="800" bgcolor="#05224e" cellpadding="1">
		<tr>
    		<td colspan="15" align="center">
    		<font class="naranja">
    		TAT Report Comcast
    		</font>
    		</td>
		</tr>
		<tr class="trazul">
    		<td align="center">
    		<a href="index.php?select=viewpro&amp;s2=tatreport&amp;optionce=inicio&amp;orden=RO&amp;s3=comcast" class="ablueH">RO</a>
    		</td>
    		<td align="center">
    		<a href="index.php?select=viewpro&amp;s2=tatreport&amp;optionce=inicio&amp;orden=fecharec&amp;s3=comcast" class="ablueH">RecCalexico</a>
    		</td>
    		<td align="center">
    		<a href="index.php?select=viewpro&amp;s2=tatreport&amp;optionce=inicio&amp;orden=cliente&amp;s3=comcast" class="ablueH">Cliente</a>
            </td>
    		<td align="center">
    		<a href="index.php?select=viewpro&amp;s2=tatreport&amp;optionce=inicio&amp;orden=days&amp;s3=comcast" class="ablueH">DaysInHouse</a>
            </td>
    		<td align="center">
    		<a href="index.php?select=viewpro&amp;s2=tatreport&amp;optionce=inicio&amp;orden=cant&amp;s3=comcast" class="ablueH">Cantidad</a>
            </td>
            <td align="center">
    		<a href="index.php?select=viewpro&amp;s2=tatreport&amp;optionce=inicio&amp;orden=checkin&amp;s3=comcast" class="ablueH">CheckIn</a>
            </td>
    		<td align="center">
    		<a href="index.php?select=viewpro&amp;s2=tatreport&amp;optionce=inicio&amp;orden=ing&amp;s3=comcast" class="ablueH">Ing</a>
            </td>
            <td align="center">
    		<a href="index.php?select=viewpro&amp;s2=tatreport&amp;optionce=inicio&amp;orden=bga&amp;s3=comcast" class="ablueH">BGA</a>
            </td>
            <td align="center">
    		<a href="index.php?select=viewpro&amp;s2=tatreport&amp;optionce=inicio&amp;orden=hfp&amp;s3=comcast" class="ablueH">HFP</a>
            </td>
            <td align="center">
    		<a href="index.php?select=viewpro&amp;s2=tatreport&amp;optionce=inicio&amp;orden=hfc&amp;s3=comcast" class="ablueH">HoldFC</a>
            </td>
    		<td align="center">
    		<a href="index.php?select=viewpro&amp;s2=tatreport&amp;optionce=inicio&amp;orden=predata&amp;s3=comcast" class="ablueH">WIP</a>
            </td>
    		<td align="center">
    		<a href="index.php?select=viewpro&amp;s2=tatreport&amp;optionce=inicio&amp;orden=postdata&amp;s3=comcast" class="ablueH">Pack</a>
            </td>
            <td bgcolor="#CCCCCC">&nbsp;
            
            </td>
            <td align="center">
    		<a href="index.php?select=viewpro&amp;s2=tatreport&amp;optionce=inicio&amp;orden=closeon&amp;s3=comcast" class="ablueH">CloseOn</a>
            </td>
            <td align="center">
    		<a href="index.php?select=viewpro&amp;s2=tatreport&amp;optionce=inicio&amp;orden=ber&amp;s3=comcast" class="ablueH">BER</a>
            </td>
    	</tr>
        <?php
		//Obtiene los RO's con pendiente cierre orden
		$sorden = "SELECT DISTINCT RO FROM ginfprosystem WHERE status != 'Pack' AND status != 'HoldFC' AND (cliente = 'comcast' OR cliente = 'COMCAST' OR cliente = 'ComCast' OR cliente = 'Comcast') ORDER BY RO";
		$qorden = mysql_query($sorden, $cnx);
		//echo mysql_num_rows($qorden);
		//echo $sorden;
		
		//Totales
		$tcheckin = 0;
		$tnbga = 0;
		$tnpredata = 0;
		
		//Nuevo Rand
		$nrand = rand();
		//Por cada RO
		while($rorden = mysql_fetch_array($qorden))
			{
			$fooRO = $rorden['RO'];
			//Busca la informacion
			//Obtiene la fecha
			$sro = "SELECT * FROM ros WHERE RO = '$fooRO'";
			$qro = mysql_query($sro, $cnx);
			$rro = mysql_fetch_array($qro);
			//echo $sro . "<br>";
			//Datos del RO
			$frecibo1 = $rro['frecibo'];
			$cant = $rro['cant'];
			$cliente = $rro['cliente'];
			//Obtiene los dias inhous
			$pdays = (strtotime(date('Y-m-d')) - strtotime($frecibo1)) / (60*60*24);
			$days = round($pdays, 2);
				
			//Despliega la fecha de recibo
			$frecibo = date('M d, Y', strtotime($frecibo1));
			
			//Obtiene el status de las unidades
			$sbga = "SELECT * FROM ginfprosystem WHERE RO = '$fooRO' AND status = 'BGARepair'";
			$qbga = mysql_query($sbga, $cnx);
			$nbga = mysql_num_rows($qbga);
				
			//Total BGA
			$tnbga = $tnbga + $nbga;
				
			//Obtiene el status de las unidades
			$spack = "SELECT * FROM ginfprosystem WHERE RO = '$fooRO' AND status = 'Pack'";
			//echo $spack;
			$qpack = mysql_query($spack, $cnx);
			$npack = mysql_num_rows($qpack);
                        
            //Obtiene el status de las unidades HFP
			$shfp = "SELECT * FROM ginfprosystem WHERE RO = '$fooRO' AND status = 'HFP'";
			//echo $spack;
			$qhfp = mysql_query($shfp, $cnx);
			$nhfp = mysql_num_rows($qhfp);
			
			//Obtiene el status de las unidades HFC
			$shfc = "SELECT * FROM ginfprosystem WHERE RO = '$fooRO' AND status = 'HoldFC'";
			//echo $spack;
			$qhfc = mysql_query($shfc, $cnx);
			$nhfc = mysql_num_rows($qhfc);
			
			//Obtiene el status de las unidades
			$sber = "SELECT * FROM ginfprosystem WHERE RO = '$fooRO' AND status = 'Pack' AND estacion = 'SCRAP'";
			$qber = mysql_query($sber, $cnx);
			$nber = mysql_num_rows($qber);
			
			$ber = (($nber / $cant) * 100);
			//echo $ber;
			
			//Obtiene el status de las unidades
			$spredata = "SELECT * FROM ginfprosystem WHERE RO = '$fooRO' AND status <> 'Pack' AND status <> 'BGARepair' AND status <> 'HFP' AND status <> 'HoldFC'";
			$qpredata = mysql_query($spredata, $cnx);
			$npredata = mysql_num_rows($qpredata);
				
			//Total predata
			$tnpredata = $tnpredata + $npredata;
			
			//CheckIn
			$checkin = $cant - ($nbga + $npack + $npredata + $nhfp + $nhfc);
				
			//Total CheckIn
			$tcheckin = $tcheckin + $checkin;
			
			
			//Obtiene la fecha RO
			$scdro = "SELECT * FROM ros WHERE ro = '$fooRO'";
			$qcdro = mysql_query($scdro, $cnx);
			$rcdro = mysql_fetch_array($qcdro);
			//Convierte a Fecha
			$cdro_ = $rcdro['cierre'];
			$comentros = $rcdro['comentarios'];
			//Inserta a la tabla temporal
			$itempTAT = "INSERT INTO tempTAT VALUES('$nrand', '$fooRO', '$frecibo1', '$cliente', '$days', '$cant', '$checkin', '$ing', '$nbga', '$nhfp', '$nhfc', '$npredata', '$npack', '', NOW(), '$cdro_', '$ber', '', '', '$comentros')";
			mysql_query($itempTAT, $cnx);
			
			}
		
		
		//Obtiene Info de cada RO
		$oinfo = "SELECT * FROM tempTAT WHERE id = '$nrand' ORDER BY $order";
		$qinfo = mysql_query($oinfo, $cnx);
		//echo $oinfo;
		
		//Por cada RO
		while($rinfo = mysql_fetch_array($qinfo))
			{
			//echo "x<br>";
			//Va la info
			?>
			<tr bgcolor="#FFFFFF" onmouseover="this.bgColor='#E0ECF8'" onmouseout="this.bgColor='#FFFFFF'">
            	<td align="left">
                <font class="blue">
                &nbsp;
				<a href="index.php?select=viewpro&amp;s2=inventario&amp;optionce=xro&amp;s3=show&amp;ro=<?php echo $rinfo['RO'];?>"><img src="images/lupa16.png" width="16" height="16" alt="VerRO" border="0" /></a>&nbsp;<?php echo $rinfo['RO'];?>
				&nbsp;
                </font>
                </td>
              <td align="center">
                <font class="blue">
                <?php 
				$frecibox = $rinfo['fecharec'];
				$frecibo = date('M d, Y', strtotime($frecibox));
				echo $frecibo;
				?>
                </font>
                </td>
                <td align="center">
                <font class="blue">
                <?php echo $rinfo['cliente'];?>
                </font>
                </td>
                <td align="center">
                <font class="blue">
                <?php echo $rinfo['days'];?>
                </font>
                </td>
                <td align="center" bgcolor="#CCCCCC"><font class="blue"><b><?php echo $rinfo['cant'];?></b></font></td>
                <td align="center">
                <font class="blue">
                
				<font color="#FF0000"><b>
				<?php 
				//Solo si es mayor a 0
				if($rinfo['checkin'] > 0)
					{
					echo $rinfo['checkin'];
					}
				?></b></font>
                </font>
                </td>
                <td align="center" bgcolor="#CCCCCC">
                <font class="blue"><font color="#FFFFFF"><b>
                <?php echo $rinfo['ing'];?>
                </b></font>
                </font>
                </td>
                <td align="center" bgcolor="#FF0000">
                <font class="blue"><font color="#FFFFFF"><b>
                <?php echo $rinfo['bga'];?>
                </b></font>
                </font>
                </td>
                <td align="center" bgcolor="orange">
                <font class="blue"><font color="#000000"><b>
                <?php echo $rinfo['hfp'];?>
                </b></font>
                </font>
                </td>
                <td align="center" bgcolor="#9900FF">
                <font class="blue"><font color="#FFFFFF"><b>
                <?php echo $rinfo['holdfc'];?>
                </b></font>
                </font>
                </td>
                <td align="center" bgcolor="#FFFF00">
                <font class="blue"><font color="#000000"><b>
                <?php echo $rinfo['predata'];?>
                </b></font>
                </font>
                </td>
                <td align="center" bgcolor="#00FF00">
                <font class="blue"><font color="#000000"><b>
                <?php echo $rinfo['postdata'];?>
                </b></font>
                </font>
                </td>
                <td bgcolor="#CCCCCC">&nbsp;
                </td>
                <?php
				$fechacom = $rinfo['closeon'];
				$coment = $rinfo['comentarios'];
				
				//Solo si es hay compromiso cierre
				if($fechacom <> "0000-00-00")
					{
					$cdro = strtotime($fechacom);
					$todaytime = strtotime(date('Y-m-d', time()));
					
					$fechacomp = date('M d', $cdro);
					
					//Color de la columna
					//echo $cdro . "<br>";
					//echo $todaytime . "<br>";
				
					//Igual compromiso al dia de hoy
					if($cdro == $todaytime)
						{
						$colorfecha = "#FFFF00";
						$fcolorfecha = "#000000";	
						}
				
					//Mayor compromiso al dia de hoy
					if($cdro > $todaytime)
						{
						$colorfecha = "#00FF00";
						$fcolorfecha = "#000000";	
						}
				
					//Menor compromiso al dia de hoy
					if($cdro < $todaytime)
						{
						$colorfecha = "#FF0000";
						$fcolorfecha = "#FFFFFF";	
						}
				
					}
				else
					{
					$fechacomp = $coment;	
					$colorfecha = "#FFFFFF";
					$fcolorfecha = "#000000";	
					}
				?>
                <td bgcolor="<?php echo $colorfecha;?>">
                <font class="blue"><font color="<?php echo $fcolorfecha;?>"><b>
                &nbsp;<?php echo $fechacomp;?>&nbsp;
                </b></font>
                </td>
                <td>
                <font class="blue"><font color="red" size="-2"><b>
                <?php echo $rinfo['ber'];?>&nbsp;%
                </b></font></font>
                </td>
            </tr>
			<?php
			}
		?>
        </table>
<br /><br /><br />
        <table width="400" bgcolor="#05224e" cellpadding="1">
		<tr>
    		<td colspan="3" align="center">
    		<font class="naranja">
    		Resumen TAT Report
    		</font>
    		</td>
		</tr>
		<tr class="trazul">
        	<td align="center">
    		<font class="negro">
    		Total Checkin
    		</font>
    		</td>
            <td align="center">
            <font class="negro">
    		Total BGA
    		</font>
    		</td>
            <td align="center">
            <font class="negro">
    		Total PreData
    		</font>
    		</td>
        </tr>
        <tr bgcolor="#FFFFFF">
        <td align="center">
                <font class="blue">
                &nbsp;
				<font color="#FF0000" size="+2"><b>
				<?php 
				//Solo si es mayor a 0
				if($tcheckin > 0)
					{
					echo $tcheckin;
					}
				?>&nbsp;</b></font>
                </font>

                </td>
                <td align="center" bgcolor="#FF0000">
                <font class="blue"><font color="#FFFFFF" size="+2"><b>
                &nbsp;
				<?php
                echo $tnbga;
				?>&nbsp;</b></font>
                </font>
                </td>
                <td align="center" bgcolor="#FFFF00">
                <font class="blue"><font color="#000000" size="+2"><b>
                &nbsp;
				<?php
                echo $tnpredata;
				?>&nbsp;</b></font>
                </font>
                </td>	
        </tr>
        </table>
<br /><br />
		<?php
		
		//Eliminia la tabla
		$dtabla = "DELETE FROM tempTAT WHERE id = '$nrand'";
		mysql_query($dtabla, $cnx);
		
		}


		
	}





// ################################################## Opciones Inicio Inventario
if($s2 == "inventario")
    {

    //Inicio y general
    if($optionce == "general")
        {
        include ("invfageneral.php");
        }
    
    //Ver los proyectos
    if($optionce == "vproj")
        {
        include("pproyectofa.php");
        }
    }
?>
</center>
