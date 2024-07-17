<div style="position:absolute;left:5px;top:5px;width:90;text-align: center;vertical-align: middle;">
    <a href="index.php?sI=vLogin&sII=Home&sIII=Home&sIV=Home"><img src="<?php echo $txtLogo;?>" width="160" border='0'></a>
    <div id="Countdown10" style="border:1px solid gray;padding:3px;">*</div>
</div>
<?php
//Depeden el SII
$cadInclude = "Include/$sII" . ".php";
//echo $cadInclude;
include("$cadInclude");

?>
<script lang="text/javascript">
    function countdown( elementName, minutes, seconds ){
        var element, endTime, hours, mins, msLeft, time;

        function twoDigits( n ){
            return (n <= 9 ? "0" + n : n);
        }

        function updateTimer(){
            msLeft = endTime - (+new Date);
            if ( msLeft < 2000 ) {
                element.innerHTML = "<font class='Robss' style='color:red;'>Time is up!</font>";
                document.location.href="index.php"; 
            } else {
                time = new Date( msLeft );
                hours = time.getUTCHours();
                mins = time.getUTCMinutes();
                element.innerHTML = "<font class='Robss' style='color:gray;'>Logout on <b>" + (hours ? hours + ':' + twoDigits( mins ) : mins) + ':' + twoDigits( time.getUTCSeconds() ) + "</b></font>";
                setTimeout( updateTimer, time.getUTCMilliseconds() + 500 );
            }
        }

        element = document.getElementById( elementName );
        endTime = (+new Date) + 1000 * (60*minutes + seconds) + 500;
        updateTimer();
    }
    countdown("Countdown10", 30, 0 );
</script>