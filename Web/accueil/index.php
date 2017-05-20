<?php
session_start();
$titre = "Accueil";
require_once ("../jointures/header.php");
require_once ("../jointures/fonctions.php");
require_once("../configuration/baseDonnees.php");
?>

<div class="contenu">
    <div class="col-lg-9">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-line-chart" aria-hidden="true"></i> Graphique</h3>
            </div>
            <div class="panel-body">
                <div id="graph" style="height: 500px; margin: 0 auto"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-calendar" aria-hidden="true"></i> Plage de données</h3>
            </div>
            <div class="panel-body">
                <div class="list-group">
                    <?php

                    $param_graph = $_GET['graph'];
                    if (!isset($param_graph)) {
                        $param_graph = "0";
                    }
                    ?>
                    <a href="?graph=aujourdhui"
                       class="list-group-item <?php if ($param_graph == '0' || $param_graph == 'aujourdhui') {
                           echo "active";
                       } ?>">Aujourd'hui</a>
                    <a href="?graph=hier" class="list-group-item <?php if ($param_graph == 'hier') {
                        echo "active";
                    } ?>">Hier</a>
                    <a href="?graph=7j" class="list-group-item <?php if ($param_graph == '7j') {
                        echo "active";
                    } ?>">7 derniers jours</a>
                    <a href="?graph=30j" class="list-group-item <?php if ($param_graph == '30j') {
                        echo "active";
                    } ?>">30 derniers jours</a>
                    <a href="?graph=mois" class="list-group-item <?php if ($param_graph == 'mois') {
                        echo "active";
                    } ?>">Ce mois-ci</a>
                    <a href="?graph=all" class="list-group-item <?php if ($param_graph == 'all') {
                        echo "active";
                    } ?>">Tout</a>
                </div>
				Nombre de données sélectionné : <?php
                      $nb_data_base = $bdd->query('SELECT COUNT(*) AS nb_data FROM bac '.selecData());
                      $data = $nb_data_base->fetch();
                      echo $data['nb_data'];
                      ?>
	
            </div>
        </div>
    </div>
	
	
	
	<div class="col-lg-9">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-tachometer" aria-hidden="true"></i> Jauge</h3>
            </div>
            <div class="panel-body">
					<div id="temp" style="width: 300px; height: 200px; float: left"></div>
					<div id="lum" style="width: 300px; height: 200px; float: left"></div>
					<div id="hum" style="width: 300px; height: 200px; float: left"></div>
            </div>
        </div>
    </div>
	
	<div class="col-lg-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-tasks" aria-hidden="true"></i> Extremum</h3>
            </div>
            <div class="panel-body">
			<table class="table table-condensed">
				<thead>
				  <tr>
					<th>Capteurs</th>
					<th>MIN</th>
					<th>MAX</th>
				  </tr>
				</thead>
				<tbody>
				  <tr>
					<td>Température</td>
					<td><?php  $nb_temp_min = $bdd->query('SELECT MIN(int_temp) AS temp_min FROM bac '.selecData());
								  $temp_min = $nb_temp_min->fetch();
								  echo $temp_min['temp_min']." °C";
						?></td>
					<td>
					<?php 
					$nb_temp_max = $bdd->query('SELECT MAX(int_temp) AS temp_max FROM bac '.selecData());
								  $temp_max = $nb_temp_max->fetch();
								  echo $temp_max['temp_max']." °C";
					?>
					</td>
				  </tr>
				  <tr>
					<td>Luminosité</td>
					<td><?php  $nb_lum_min = $bdd->query('SELECT MIN(int_lum) AS lum_min FROM bac '.selecData());
								  $lum_min = $nb_lum_min->fetch();
								  echo $lum_min['lum_min']." %";
						?></td>
					<td>
					<?php $nb_lum_max = $bdd->query('SELECT MAX(int_lum) AS lum_max FROM bac '.selecData());
								  $lum_max = $nb_lum_max->fetch();
								  echo $lum_max['lum_max']." %";
					?>
					</td>
				  </tr>
				  <tr>
					<td>Humidité</td>
					<td><?php
					$nb_lum_min = $bdd->query('SELECT MIN(int_hum) AS lum_min FROM bac '.selecData());
								  $lum_min = $nb_lum_min->fetch();
								  echo $lum_min['lum_min']." %";
					?></td>
					<td><?php
					$nb_hum_min = $bdd->query('SELECT MAX(int_hum) AS hum_min FROM bac '.selecData());
								  $hum_min = $nb_hum_min->fetch();
								  echo $hum_min['hum_min']." %";
					?></td>
				  </tr>
				</tbody>
			  </table>
            </div>
        </div>
    </div>
	
    <script type="text/javascript">
        $(function () {
            Highcharts.chart('graph', {
                chart: {
                    zoomType: 'xy'
                },
                title: {
                    text: "<?php titre(); ?>"
                },
                xAxis: [{
                    categories: [
                        <?php
                        $query = $bdd->prepare('SELECT * FROM bac '.selecData());
                        $query->execute();
                        while ($results = $query->fetch(PDO::FETCH_OBJ)) {
                            echo "'" . $results->jour . "/". $results->mois . " - " . $results->heure . ":" . $results->minute . "',";
                        }
                        ?>
                    ],
                    crosshair: true
                }],
                yAxis: [{ // Primary yAxis
                    labels: {
                        format: '{value}°C',
                        style: {
                            color: Highcharts.getOptions().colors[1]
                        }
                    },
                    title: {
                        text: 'Température',
                        style: {
                            color: Highcharts.getOptions().colors[1]
                        }
                    },
					min: 0,
					max: 40,
                    opposite: false

                }, { // Secondary yAxis
                    gridLineWidth: 0,
                    title: {
                        text: 'Pourcentage',
                        style: {
                            color: Highcharts.getOptions().colors[0]
                        }
                    },
                    labels: {
                        format: '{value} %',
                        style: {
                            color: Highcharts.getOptions().colors[0]
                        }
                    },
                    min: 0,
                    max: 100,
                    opposite: true

                }],
                tooltip: {
                    shared: true
                },
                legend: {
                    align: 'center',
                    backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
                },
                series: [{
                    name: 'Température intérieure',
                    type: 'spline',
                    data: [
                        <?php
                        $query = $bdd->prepare('SELECT * FROM bac '.selecData());
                        $query->execute();
                        while ($results = $query->fetch(PDO::FETCH_OBJ)) {
                            echo $results->int_temp . ",";
                        }
                        ?>
                    ],
                    tooltip: {
                        valueSuffix: ' °C'
                    }
                }, {
                    name: 'Température extérieure',
                    type: 'spline',
                    data: [
                        <?php
                        $query = $bdd->prepare('SELECT * FROM bac '.selecData());
                        $query->execute();
                        while ($results = $query->fetch(PDO::FETCH_OBJ)) {
                            echo $results->ext_temp . ",";
                        }
                        ?>
                    ],
                    tooltip: {
                        valueSuffix: ' °C'
                    }
                }, {
                    name: 'Humidité intérieure',
                    type: 'spline',
                    yAxis: 1,
                    data: [
                        <?php
                        $query = $bdd->prepare('SELECT * FROM bac '.selecData());
                        $query->execute();
                        while ($results = $query->fetch(PDO::FETCH_OBJ)) {
                            echo $results->int_hum . ",";
                        }
                        ?>
                    ],
                    tooltip: {
                        valueSuffix: ' %'
                    }

                }, {
                    name: 'Humidité extérieure',
                    type: 'spline',
                    yAxis: 1,
                    data: [
                        <?php
                        $query = $bdd->prepare('SELECT * FROM bac '.selecData());
                        $query->execute();
                        while ($results = $query->fetch(PDO::FETCH_OBJ)) {
                            echo $results->ext_hum . ",";
                        }
                        ?>
                    ],
                    tooltip: {
                        valueSuffix: ' %'
                    }
                }, {
                    name: 'Luminosité intérieure',
                    type: 'spline',
                    yAxis: 1,
                    data: [
                        <?php
                        $query = $bdd->prepare('SELECT * FROM bac '.selecData());
                        $query->execute();
                        while ($results = $query->fetch(PDO::FETCH_OBJ)) {
                            echo $results->int_lum . ",";
                        }
                        ?>
                    ],
                    tooltip: {
                        valueSuffix: ' %'
                    }
                }
                ]
            });
        });

    </script>
	
	
	<script type="text/javascript">
   var gaugeOptions = {

    chart: {
        type: 'solidgauge'
    },

    title: null,

    pane: {
        center: ['50%', '85%'],
        size: '140%',
        startAngle: -90,
        endAngle: 90,
        background: {
            backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || '#EEE',
            innerRadius: '60%',
            outerRadius: '100%',
            shape: 'arc'
        }
    },

    tooltip: {
        enabled: false
    },

    // the value axis
    yAxis: {
        stops: [
            [0.1, '#55BF3B'], // green
            [0.5, '#DDDF0D'], // yellow
            [0.9, '#DF5353'] // red
        ],
        lineWidth: 0,
        minorTickInterval: null,
        tickAmount: 2,
        title: {
            y: -70
        },
        labels: {
            y: 16
        }
    },

    plotOptions: {
        solidgauge: {
            dataLabels: {
                y: 5,
                borderWidth: 0,
                useHTML: true
            }
        }
    }
};

// Temp gauge
var chartSpeed = Highcharts.chart('temp', Highcharts.merge(gaugeOptions, {
    yAxis: {
        min: 0,
        max: 40,
        title: {
            text: 'Température moyenne'
        }
    },

    credits: {
        enabled: false
    },

    series: [{
        name: 'Température',
        data: [<?php
		$temp_moy_base = $bdd->query('SELECT AVG(int_temp) AS temp_moy FROM bac '.selecData());
                      $temp_moy = $temp_moy_base->fetch();
                      echo mb_strimwidth($temp_moy['temp_moy'], 0, 5);
		
		?>],
        dataLabels: {
            format: '<div style="text-align:center"><span style="font-size:25px;color:' +
                ((Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black') + '">{y}</span><br/>' +
                   '<span style="font-size:12px;color:silver">°C</span></div>'
        }
    }]

}));

// Lum gauge
var chartSpeed = Highcharts.chart('lum', Highcharts.merge(gaugeOptions, {
    yAxis: {
        min: 0,
        max: 100,
        title: {
            text: 'Luminosité moyenne'
        }
    },

    credits: {
        enabled: false
    },

    series: [{
        name: 'Luminosité',
        data: [<?php
		$lum_moy_base = $bdd->query('SELECT AVG(int_lum) AS lum_moy FROM bac '.selecData());
                      $lum_moy = $lum_moy_base->fetch();
                      echo mb_strimwidth($lum_moy['lum_moy'], 0, 5);
		
		?>],
        dataLabels: {
            format: '<div style="text-align:center"><span style="font-size:25px;color:' +
                ((Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black') + '">{y}</span><br/>' +
                   '<span style="font-size:12px;color:silver">%</span></div>'
        }
    }]

}));

// Hum gauge
var chartSpeed = Highcharts.chart('hum', Highcharts.merge(gaugeOptions, {
    yAxis: {
        min: 0,
        max: 100,
        title: {
            text: 'Humidité moyenne'
        }
    },

    credits: {
        enabled: false
    },

    series: [{
        name: 'Humidité',
        data: [<?php
		$hum_moy_base = $bdd->query('SELECT AVG(int_hum) AS hum_moy FROM bac '.selecData());
                      $hum_moy = $hum_moy_base->fetch();
                      echo mb_strimwidth($hum_moy['hum_moy'], 0, 5);
		
		?>],
        dataLabels: {
            format: '<div style="text-align:center"><span style="font-size:25px;color:' +
                ((Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black') + '">{y}</span><br/>' +
                   '<span style="font-size:12px;color:silver">%</span></div>'
        }
    }]

}));

    </script>
</div>
<?php
require_once ("../jointures/footer.php");
?>