<?php
/**
 * Graph Creation Function 
 * 
 * @param   string      $GType          Graph Type (PieChart)
 * @param   string      $GTitle         Graph Title
 * @param   string      $GDiv           Graph DIV
 * @param   array       $ArrINFO        General INFO
 * @param   string      $GSQL01         SQL Query
 * @copyright   2021 Software Development MX
 * @license     https://www.softwaredevelopment.mx/license/Func_Form.txt
 * @return string
 */

function GraphDraw($GType, $GTitle, $GDiv, $ArrINFO, $GSQL01){
    global $cnx;
    global $cnxw;
    
    
    $PC_LoadDriver = $ArrINFO['LoadDriver'];
    //Parte primaria
    $PCd = "
            }
        </script>
         ";
    
    //Depende el tipo
    switch ($GType):
        case "ComboChartBAR":
            $LC_AxisX = $ArrINFO['AxisX'];
            $LC_AxisY1 = $ArrINFO['AxisY1'];
            $LC_AxisY2 = $ArrINFO['AxisY2'];
            //Obtiene data
            if($PC_LoadDriver == 1){
                $PCa = "<script type='text/javascript' src='https://www.gstatic.com/charts/loader.js'></script>";
            } else {
                $PCa = "";
            }
            
            
            $PCb = "
                <script type='text/javascript'>
                    google.charts.load('current', {packages:['corechart', 'line']});
                    google.charts.setOnLoadCallback(drawChartX);
                    function drawChartX() {";
            
            $LC_Data = "data.addRows([";
            
            
            $LData = $cnx->query($GSQL01)->fetchAll();
            //Data
            $PCCount = 0;
            $PCTotal = 0;
            
            foreach ($LData as &$LDatax) {
                $PC_AxisX = $LDatax['PC_AxisX'];
                $PC_AxisY1 = $LDatax['PC_AxisY1'];
                $PC_AxisY2 = $LDatax['PC_AxisY2'];
                $LCDatax .= "['" . $PC_AxisX . "', $PC_AxisY1, 0, 0],";
                $PCCount++;
                $PCTotal += $PC_Qty;
                
            }
            
            $LCDatax = substr($LCDatax, 0, -1);
            
            $LC_Data .= $LCDatax . "])";
            
            /*
             * 
                
             */
            
            $PCc = "
                var data = new google.visualization.DataTable();
                data.addColumn('string', '$LC_AxisX');
                data.addColumn('number', '$LC_AxisY1');
                data.addColumn('number', '$LC_AxisY2');
                data.addColumn({type:'number', role:'annotation'});
    
                $LC_Data
                
                var options = {
                    title: '$GTitle',
                    titleTextStyle: {
                        color: 'black',
                        fontSize: 20
                        },
                    backgroundColor: 'transparent',
                    colors: ['red', 'yellowgreen'],
                    seriesType: 'bars',
                    series: {
                        0: {
                            lineWidth: 5,
                            lineDashStyle: [4,1]
                        },
                        1: {
                            annotations: {
                                textStyle: {
                                    fontSize: 10,
                                    color: 'yellowgreen',
                                    auraColor: 'black',
                                    bold: true
                                    }
                            },
                            lineWidth: 7
                        }
                    },
                    legend: {
                        position: 'top',
                        textStyle: { color: 'black'}
                        },
                    hAxis: {
                        title: 'Vendor Number',
                        titleTextStyle: {
                            fontSize: 15,
                            color: 'black'
                            },
                        textStyle: {
                            fontSize: 10,
                            color: 'black'
                            },
                        gridlines: {
                            color: '#999999'
                            }
                        },
                    vAxis: {
                        title: '(%) Result',
                        titleTextStyle: {
                            fontSize: 15,
                            color: 'black'
                            },
                        textStyle: {
                            fontSize: 15,
                            color: 'black'
                            },
                        minValue: 80,
                        maxValue: 120,
                        gridlines: {
                            color: '#999999'
                            }
                    }
                };
                
                
                var chart = new google.visualization.ComboChart(document.getElementById('$GDiv'));
                chart.draw(data, options);
                
                 ";
            
            echo $PCa . $PCb . $PCc . $PCd;
            break;
        case "PieChartLink":
            $PC_SubtitleName = $ArrINFO['SubtitleName'];
            $PC_SubtitleQty = $ArrINFO['SubtitleQty'];
            $PC_Units = $ArrINFO['Units'];
            $PC_Colors = $ArrINFO['Colors'];
            $PC_ExtraL = $ArrINFO['ExtraL'];
            $PC_ExtraData = $ArrINFO['ExtraData'];
            if(!empty($PC_ExtraData)){
                $PC_ED = explode("|", $PC_ExtraData);
            }
            if($PC_LoadDriver == 1){
                $PCa = "<script type='text/javascript' src='https://www.gstatic.com/charts/loader.js'></script>";
            } else {
                $PCa = "";
            }
            
            $PCb = "
                <script type='text/javascript'>
                    google.charts.load('current', {packages:['corechart']});
                    google.charts.setOnLoadCallback(drawChart);
                    function drawChart() {";
            
            //echo "Aqui";
            //echo $GSQL01;
            if(substr($GSQL01, 0, 2) == "W|"){
                //echo "Warehouse";
                $GSQL01 = substr($GSQL01, 2);
                $LData = $cnxw->query($GSQL01)->fetchAll();
            } else {
                $LData = $cnx->query($GSQL01)->fetchAll();
            }
            
            
            
            //Data
            $PCDatax = "";
            $PCData = "[['$PC_SubtitleName', '$PC_SubtitleQty', { role: 'link' }],";
            $PCCount = 0;
            $PCTotal = 0;
            
            foreach ($LData as &$LDatax) {
                //Solo para extra data
                if(!empty($PC_ED[$PCCount])){
                    $DataL = "[" . $PC_ED[$PCCount] . "] ";
                }
                
                $PC_Qty = $LDatax['PC_Qty'];
                $PC_Name = "($PC_Qty) " . $DataL . $ExtraL . $LDatax['PC_Name'] . " $PC_Units ";
                $PC_Link = $LDatax['PC_Link'];
                $PCDatax .= "['" . $PC_Name . "', $PC_Qty, '$PC_Link'],";
                $PCCount++;
                $PCTotal += $PC_Qty;
                
            }
            
            $PCDatax = substr($PCDatax, 0, -1);
            
            $PCData .= $PCDatax . "]";
            
            
            $PCc = "
                var data = google.visualization.arrayToDataTable(
                    $PCData
                );
                
                var options = {
                    backgroundColor: 'transparent',
                    title: '$GTitle ($PCTotal)',
                    is3D: true,
                    $PC_Colors
                };

                var chart = new google.visualization.PieChart(document.getElementById('$GDiv'));
                    
                google.visualization.events.addListener(chart, 'select', function (e) {
                    var selection = chart.getSelection();
                        if (selection.length) {
                            var row = selection[0].row;
                            let link =data.getValue(row, 2);
                            location.href = link;
                        }
                });
                chart.draw(data, options);
                 ";
            
            echo $PCa . $PCb . $PCc . $PCd;
            break;
        case "PieChart":
            $PC_SubtitleName = $ArrINFO['SubtitleName'];
            $PC_SubtitleQty = $ArrINFO['SubtitleQty'];
    
            if($PC_LoadDriver == 1){
                $PCa = "<script type='text/javascript' src='https://www.gstatic.com/charts/loader.js'></script>";
            } else {
                $PCa = "";
            }
            
            $PCb = "
                <script type='text/javascript'>
                    google.charts.load('current', {packages:['corechart']});
                    google.charts.setOnLoadCallback(drawChart);
                    function drawChart() {";
            
            
            
            
            $LData = $cnx->query($GSQL01)->fetchAll();
            
            //Data
            $PCDatax = "";
            $PCData = "[['$PC_SubtitleName', '$PC_SubtitleQty'],";
            $PCCount = 0;
            $PCTotal = 0;
            
            foreach ($LData as &$LDatax) {
                $PC_Qty = $LDatax['PC_Qty'];
                $PC_Name = "($PC_Qty)" . $LDatax['PC_Name'];
                $PCDatax .= "['" . $PC_Name . "', $PC_Qty],";
                $PCCount++;
                $PCTotal += $PC_Qty;
                
            }
            
            $PCDatax = substr($PCDatax, 0, -1);
            
            $PCData .= $PCDatax . "]";
            
            
            $PCc = "
                var data = google.visualization.arrayToDataTable(
                    $PCData
                );
                
                var options = {
                    backgroundColor: 'transparent',
                    title: '$GTitle ($PCTotal)',
                    is3D: true
                };

                var chart = new google.visualization.PieChart(document.getElementById('$GDiv'));
                chart.draw(data, options);
                 ";
            
            echo $PCa . $PCb . $PCc . $PCd;
            break;
    endswitch;
    
    
    
}