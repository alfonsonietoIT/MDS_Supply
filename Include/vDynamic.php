<div style="position:absolute;left:5px;top:5px;width:90;text-align: center;vertical-align: middle;">
    <a href="<?php echo $homeLink;?>"><img src="<?php echo $txtLogo;?>" width="160"></a>
</div>
<table style="width:100%;">
    <caption></caption>
    <tr>
    <th scope="col" style="width:2%;">
    </th>
    <th scope="col" style="width:96%;">
        <?php
        switch ($sI){
            case "ClearTB":
                include("Forms/vClearTB.php");
                break;
            case "ProductionPlan53":
                include("Forms/vProductionPlan53.php");
                break;
            case "ProductionPlan":
                include("Forms/vProductionPlan.php");
                break;
            case "ProductionPlan16":
                include("Forms/vProductionPlan16.php");
                break;
            case "ProductionPlan16_2":
                include("Forms/vProductionPlan16_2.php");
                break;
            case "ProductionPlan16_3":
                include("Forms/vProductionPlan16_3.php");
                break;
            case "ProductionPlan16_4":
                include("Forms/vProductionPlan16_4.php");
                break;
            case "ProductionPlan2":
                include("Forms/vProductionPlan2.php");
                break;
            case "ProductionPlan3":
                include("Forms/vProductionPlan3.php");
                break;
            default:
                include("Forms/vProductionPlan4.php");
                break;
        }
        ?>
    </th>
    <th scope="col" style="width:2%;">
        
    </th>
    </tr>
</table>