<?php

//Obtiene los menus
if($uIDUser == 1){
    //$vMenus = $cnx->query('SELECT * FROM Menus WHERE Menu = ? ORDER BY OrdenMenu ASC', "$sII")->fetchAll();
    $vMenus = $cnx->query('SELECT * FROM Menus WHERE Menu = ? AND Active = 1 ORDER BY OrdenMenu ASC', "$sII")->fetchAll();
} else {
    $vMenus = $cnx->query('SELECT * FROM Menus WHERE Menu = ? AND Active = 1 ORDER BY OrdenMenu ASC', "$sII")->fetchAll();
}
//
//$vMenus = $cnx->query('SELECT * FROM Menus WHERE Menu = ? AND Active = 1 ORDER BY OrdenMenu ASC', "$sII")->fetchAll();
//print_r($vMenus);
//Despliega los menus
$CadMenu = "";
//$CadLMenu = "<a class='linkn' href='index.php?sI=$sI&sII=Home&sIII=Home&sIV=Home'>Home</a> ";
foreach ($vMenus as $gMenu) {
    //Variables menu
    $mMenu = $gMenu['Menu'];
    $mtMenu = $gMenu['tMenu'];
    $mSubmenu = $gMenu['Submenu'];
    $msI = $gMenu['sI'];
    $msII = $gMenu['sII'];
    $msIII = $gMenu['sIII'];
    $msIV = $gMenu['sIV'];

    $CadMenu .= "<a href='index.php?sI=$msI&sII=$msII&sIII=$msIII&sIV=$msIV'>$mSubmenu</a>";
    $CadLMenu .= "<a class='linkn' href='index.php?sI=$msI&sII=$msII&sIII=$msIII&sIV=$msIV'>$mSubmenu</a>";
}

$CadLMenu .= "<a class='linkn' href='index.php'>Logout</a>";


//Busca notificaciones
$sNot = "SELECT COUNT(IDUser) AS cnot FROM Notificacion WHERE IDUser = '$uIDUser' AND Status = 'Open'";
$rNot = $cnx->query("$sNot")->fetchArray();
$qtyNot = $rNot['cnot'];

//echo "Not: $qtyNot";

?>
<br><br>
<center>
<div style="width: 95%;text-align: center;">
    <font class="Koh" style="color:gray;font-size: 1em;">
        <?php
        echo strtoupper($mtMenu) . "<BR>";
        echo $CadLMenu;
        ?>
    </font>
</div>
</center>
<div style="right:0px;top:0px;position:absolute;">
    <?php
    if($qtyNot > 0){
        ?>
    <a style="text-decoration:none;" href="index.php?sI=<?php echo $sI;?>&sII=Notify&sIII=Home&sIV=Home">
        <img src="Images/Notify.svg" width="20">
        <div class="numberCircle"><?php echo $qtyNot;?></div>
    </a>
    <?php
    }
    ?><font class="Kohss" style="color:#c7c7c7;">Usuario:</font>
    &nbsp;
    <font class="Kohss" style="color:red;"><?php echo $uName;?></font>
    &nbsp;&nbsp;
    <span style="font-family: 'Bahianita';font-size:30px;cursor:pointer;" onclick="openNav()">Menu &#9776;</span>
</div>
<div id="mySidenav" class="sidenav">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <?php
    if($sII != "Home"):
        echo "<a href='index.php?sI=$sI&sII=Home&sIII=Home&sIV=Home'>Home</a>";
    endif;
    echo $CadMenu;
    ?>
    <a href="index.php">Logout</a>
</div>
<script>
function openNav() {
  document.getElementById("mySidenav").style.width = "250px";
}

function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
}
</script>


