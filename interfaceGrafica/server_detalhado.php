<?php
    header('Content-Type: text/html; charset=utf-8');    
    require_once '../classes/Transacoes.php';
    require_once '../classes/Funcoes.php';
    
    if(date('m') == 01){
        $ano = date('Y') - 1;
    }else{
        $ano = date('Y');
    }
    
    
    //Objeto da classe Transacao
    $trans = new Transacoes();
    
    //Instancia de Classe Com variáveis estáticas e funções
    $fun = new Funcoes();
    
    //Retorna a data do dia anterior
    $data = $fun->dataAnterior();
    $periodos = $fun->retornarPeriodos();
    
    
    $Detalhes = $trans->totalizarGraficoServidores($periodos);
    $anual = $trans->totalizarGraficoAnual($ano);
    
    //Array com o total de clientes por servidor
    $totalCli = $trans->totalizarGraficoClientesServer();
    $totalClientesAtivos = array_sum($totalCli);
 
?>
<!DOCTYPE html>
<html lang="pt-br">

    <head>
        <!-- Required meta tags-->
        <meta charset="UTF-8">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="au theme template">
        <meta name="author" content="Hau Nguyen and Luan Michel">
        <link rel="shortcut icon" href="speedometer.svg.png" >

        <!-- Title Page-->
        <title>Sotech - Dashboard</title>

        <!-- Fontfaces CSS-->
        <link href="css/font-face.css" rel="stylesheet" media="all">
        <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
        <link href="vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
        <link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">

        <!-- Bootstrap CSS-->
        <link href="vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">

        <!-- Vendor CSS-->
        <link href="vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
        <link href="vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet" media="all">
        <link href="vendor/wow/animate.css" rel="stylesheet" media="all">
        <link href="vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
        <link href="vendor/slick/slick.css" rel="stylesheet" media="all">
        <link href="vendor/select2/select2.min.css" rel="stylesheet" media="all">
        <link href="vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">

        <!-- Main CSS-->
        <link href="css/theme.css" rel="stylesheet" media="all">
        
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
          google.charts.load('current', {'packages':['bar']});
          google.charts.setOnLoadCallback(drawChart);

          function drawChart() {
            var data = google.visualization.arrayToDataTable([
              ['Servidor', 'Transações',],
              ['VSP-10', <?php echo $Detalhes["VSP10:30"]; ?>],
              ['VSP-12', <?php echo $Detalhes["VSP12:30"]; ?>],
              ['VSP-14', <?php echo $Detalhes["VSP14:30"]; ?>],
              ['VSP-16', <?php echo $Detalhes["VSP16:30"]; ?>],
              ['VSP-18', <?php echo $Detalhes["VSP18:30"]; ?>],
              ['VSP-20', <?php echo $Detalhes["VSP20:30"]; ?>],
              ['VSP-22', <?php echo $Detalhes["VSP22:30"]; ?>],
              ['VSP-24', <?php echo $Detalhes["VSP24:30"]; ?>],
              ['VSP-26', <?php echo $Detalhes["VSP26:30"]; ?>],
              ['VSP-28', <?php echo $Detalhes["VSP28:30"]; ?>],
              ['VSP-30', <?php echo $Detalhes["VSP30:30"]; ?>],
              ['VSP-32', <?php echo $Detalhes["VSP32:30"]; ?>],
              ['VSP-34', <?php echo $Detalhes["VSP34:30"]; ?>],
              ['VSP-36', <?php echo $Detalhes["VSP36:30"]; ?>],
              ['VSP-38', <?php echo $Detalhes["VSP38:30"]; ?>],
              ['VSP-40', <?php echo $Detalhes["VSP40:30"]; ?>],
              ['VSP-42', <?php echo $Detalhes["VSP42:30"]; ?>],
              ['VSP-44', <?php echo $Detalhes["VSP44:30"]; ?>],
              ['VSP-46', <?php echo $Detalhes["VSP46:30"]; ?>],
              ['VSP-48', <?php echo $Detalhes["VSP48:30"]; ?>],
              ['VSP-50', <?php echo $Detalhes["VSP50:30"]; ?>]
            ]);

            var options = {
              chart: {
                title: 'Total de Transações por Servidor <?php echo $periodos["Trinta"] ?>'
              },
              bars: 'vertical',
              vAxis: {format: 'decimal'},
              height: 400
            };

            var chart = new google.charts.Bar(document.getElementById('chart_30'));

            chart.draw(data, google.charts.Bar.convertOptions(options));
          }
        </script>
       
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
          google.charts.load('current', {'packages':['bar']});
          google.charts.setOnLoadCallback(drawChart);

          function drawChart() {
            var data = google.visualization.arrayToDataTable([
              ['Servidor', 'Transações',],
              ['VSP-10', <?php echo $Detalhes["VSP10:60"]; ?>],
              ['VSP-12', <?php echo $Detalhes["VSP12:60"]; ?>],
              ['VSP-14', <?php echo $Detalhes["VSP14:60"]; ?>],
              ['VSP-16', <?php echo $Detalhes["VSP16:60"]; ?>],
              ['VSP-18', <?php echo $Detalhes["VSP18:60"]; ?>],
              ['VSP-20', <?php echo $Detalhes["VSP20:60"]; ?>],
              ['VSP-22', <?php echo $Detalhes["VSP22:60"]; ?>],
              ['VSP-24', <?php echo $Detalhes["VSP24:60"]; ?>],
              ['VSP-26', <?php echo $Detalhes["VSP26:60"]; ?>],
              ['VSP-28', <?php echo $Detalhes["VSP28:60"]; ?>],
              ['VSP-30', <?php echo $Detalhes["VSP30:60"]; ?>],
              ['VSP-32', <?php echo $Detalhes["VSP32:60"]; ?>],
              ['VSP-34', <?php echo $Detalhes["VSP34:60"]; ?>],
              ['VSP-36', <?php echo $Detalhes["VSP36:60"]; ?>],
              ['VSP-38', <?php echo $Detalhes["VSP38:60"]; ?>],
              ['VSP-40', <?php echo $Detalhes["VSP40:60"]; ?>],
              ['VSP-42', <?php echo $Detalhes["VSP42:60"]; ?>],
              ['VSP-44', <?php echo $Detalhes["VSP44:60"]; ?>],
              ['VSP-46', <?php echo $Detalhes["VSP46:60"]; ?>],
              ['VSP-48', <?php echo $Detalhes["VSP48:60"]; ?>],
              ['VSP-50', <?php echo $Detalhes["VSP50:60"]; ?>]
            ]);

            var options = {
              chart: {
                title: 'Total de Transações por Servidor <?php echo $periodos["Sessenta"] ?>'
              },
              bars: 'vertical',
              vAxis: {format: 'decimal'},
              height: 400,
              colors: ['#1b9e77']
            };

            var chart = new google.charts.Bar(document.getElementById('chart_60'));

            chart.draw(data, google.charts.Bar.convertOptions(options));
          }
        </script>
        
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
          google.charts.load('current', {'packages':['bar']});
          google.charts.setOnLoadCallback(drawChart);

          function drawChart() {
            var data = google.visualization.arrayToDataTable([
              ['Servidor', 'Transações',],
              ['VSP-10', <?php echo $Detalhes["VSP10:90"]; ?>],
              ['VSP-12', <?php echo $Detalhes["VSP12:90"]; ?>],
              ['VSP-14', <?php echo $Detalhes["VSP14:90"]; ?>],
              ['VSP-16', <?php echo $Detalhes["VSP16:90"]; ?>],
              ['VSP-18', <?php echo $Detalhes["VSP18:90"]; ?>],
              ['VSP-20', <?php echo $Detalhes["VSP20:90"]; ?>],
              ['VSP-22', <?php echo $Detalhes["VSP22:90"]; ?>],
              ['VSP-24', <?php echo $Detalhes["VSP24:90"]; ?>],
              ['VSP-26', <?php echo $Detalhes["VSP26:90"]; ?>],
              ['VSP-28', <?php echo $Detalhes["VSP28:90"]; ?>],
              ['VSP-30', <?php echo $Detalhes["VSP30:90"]; ?>],
              ['VSP-32', <?php echo $Detalhes["VSP32:90"]; ?>],
              ['VSP-34', <?php echo $Detalhes["VSP34:90"]; ?>],
              ['VSP-36', <?php echo $Detalhes["VSP36:90"]; ?>],
              ['VSP-38', <?php echo $Detalhes["VSP38:90"]; ?>],
              ['VSP-40', <?php echo $Detalhes["VSP40:90"]; ?>],
              ['VSP-42', <?php echo $Detalhes["VSP42:90"]; ?>],
              ['VSP-44', <?php echo $Detalhes["VSP44:90"]; ?>],
              ['VSP-46', <?php echo $Detalhes["VSP46:90"]; ?>],
              ['VSP-48', <?php echo $Detalhes["VSP48:90"]; ?>],
              ['VSP-50', <?php echo $Detalhes["VSP50:90"]; ?>]
            ]);

            var options = {
              chart: {
                title: 'Total de Transações por Servidor <?php echo $periodos["Noventa"] ?>'
              },
              bars: 'vertical',
              vAxis: {format: 'decimal'},
              height: 400,
              colors: ['#d95f02']
            };

            var chart = new google.charts.Bar(document.getElementById('chart_90'));

            chart.draw(data, google.charts.Bar.convertOptions(options));
          }
        </script>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
          google.charts.load('current', {'packages':['bar']});
          google.charts.setOnLoadCallback(drawChart);

          function drawChart() {
            var data = google.visualization.arrayToDataTable([
              ['Mês', 'Total', { role: 'style' }],
              ['Janeiro', <?php echo $anual["janeiro"]; ?>, 'color: white'],
              ['Fevereiro', <?php echo $anual["fevereiro"]; ?>, 'color: orange'],
              ['Março', <?php echo $anual["março"]; ?>, 'color: blue'],
              ['Abril', <?php echo $anual["abril"]; ?>, 'color: green'],
              ['Maio', <?php echo $anual["maio"]; ?>, 'color: yellow'],
              ['Junho', <?php echo $anual["junho"]; ?>, 'color: red'],
              ['Julho', <?php echo $anual["julho"]; ?>, 'color: yellow'],
              ['Agosto', <?php echo $anual["agosto"]; ?>, 'color: #daa520'],
              ['Setembro', <?php echo $anual["setembro"]; ?>, 'color: green'],
              ['Outubro', <?php echo $anual["outubro"]; ?>, 'color: pink'],
              ['Novembro', <?php echo $anual["novembro"]; ?>, 'color: blue'],
              ['Dezembro', <?php echo $anual["dezembro"]; ?>, 'color: red']
            ]);

            var options = {
              chart: {
                title: 'Total de Transações de <?php echo $ano; ?>'
              },
              bars: 'vertical',
              vAxis: {format: 'decimal'},
              height: 400,
              colors: ['green']            
            };

            var chart = new google.charts.Bar(document.getElementById('chart_anual'));

            chart.draw(data, google.charts.Bar.convertOptions(options));
          }
        </script>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
          google.charts.load('current', {'packages':['bar']});
          google.charts.setOnLoadCallback(drawChart);

          function drawChart() {
            var data = google.visualization.arrayToDataTable([
              ['Servidor', 'Total'],
              ['VSP-10', <?php echo $totalCli["VSP10"]; ?>],
              ['VSP-12', <?php echo $totalCli["VSP12"]; ?>],
              ['VSP-14', <?php echo $totalCli["VSP14"]; ?>],
              ['VSP-16', <?php echo $totalCli["VSP16"]; ?>],
              ['VSP-18', <?php echo $totalCli["VSP18"]; ?>],
              ['VSP-20', <?php echo $totalCli["VSP20"]; ?>],
              ['VSP-22', <?php echo $totalCli["VSP22"]; ?>],
              ['VSP-24', <?php echo $totalCli["VSP24"]; ?>],
              ['VSP-26', <?php echo $totalCli["VSP26"]; ?>],
              ['VSP-28', <?php echo $totalCli["VSP28"]; ?>],
              ['VSP-30', <?php echo $totalCli["VSP30"]; ?>],
              ['VSP-32', <?php echo $totalCli["VSP32"]; ?>],
              ['VSP-34', <?php echo $totalCli["VSP34"]; ?>],
              ['VSP-36', <?php echo $totalCli["VSP36"]; ?>],
              ['VSP-38', <?php echo $totalCli["VSP38"]; ?>],
              ['VSP-40', <?php echo $totalCli["VSP40"]; ?>],
              ['VSP-42', <?php echo $totalCli["VSP42"]; ?>],
              ['VSP-44', <?php echo $totalCli["VSP44"]; ?>],
              ['VSP-46', <?php echo $totalCli["VSP46"]; ?>],
              ['VSP-48', <?php echo $totalCli["VSP48"]; ?>],
              ['VSP-50', <?php echo $totalCli["VSP50"]; ?>]
            ]);

            var options = {
              chart: {
                title: 'Total de Clientes de <?php echo $periodos["Trinta"] ?>'
              },
              bars: 'vertical',
              vAxis: {format: 'decimal'},
              height: 400,
              colors: ['red']            
            };

            var chart = new google.charts.Bar(document.getElementById('chart_total_clientes'));

            chart.draw(data, google.charts.Bar.convertOptions(options));
          }
        </script>   
    </head>

    <body class="animsition">
        <div class="page-wrapper">
            
            <?php include 'includes/sidebar.php'; ?>

            <!-- PAGE CONTAINER-->
            <div class="page-container">
                <!-- HEADER DESKTOP-->
                <header class="header-desktop">
                    <div class="section__content section__content--p30">
                        <div class="container-fluid">
                            <div class="header-wrap">
<!--                                <form class="form-header" action="" method="POST">
                                    <input class="au-input au-input--xl" type="text" name="search" placeholder="Pesquisar" />
                                    <button class="au-btn--submit" type="submit">
                                        <i class="zmdi zmdi-search"></i>
                                    </button>
                                </form>-->
                            </div>
                        </div>
                    </div>
                </header>
                <!-- HEADER DESKTOP-->

                <!-- MAIN CONTENT-->
                <div class="main-content">
                    <div class="section__content section__content--p30">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="overview-wrap">
                                        <h2 class="title-1">Dashboard - Servidores</h2>
                                        <a href="totalizarClientesServer.php">
                                            <button class="au-btn au-btn-icon au-btn--blue">
                                                    Totalizar Clientes
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="row m-t-25">
                                <div class="col-lg-12">
                                    <div class="au-card recent-report">
                                        <div class="au-card-inner">
                                            <div class="recent-report__chart">
                                                <div id="chart_30"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row m-t-25">
                                <div class="col-lg-12">
                                    <div class="au-card recent-report">
                                        <div class="au-card-inner">
                                            <div class="recent-report__chart">
                                                <div id="chart_60"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row m-t-25">
                                <div class="col-lg-12">
                                    <div class="au-card recent-report">
                                        <div class="au-card-inner">
                                            <div class="recent-report__chart">
                                                <div id="chart_90"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row m-t-25">
                                <div class="col-lg-12">
                                    <div class="au-card recent-report">
                                        <div class="au-card-inner">
                                            <div class="recent-report__chart">
                                                <div id="chart_anual"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row m-t-25">
                                <div class="col-sm-6 col-lg-3 offset-lg-9">
                                    <div class="text">
                                        <h2><?php echo $totalClientesAtivos ?></h2>
                                        <span>Total de Clientes Ativos</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row m-t-25">
                                <div class="col-lg-12">
                                    <div class="au-card recent-report">
                                        <div class="au-card-inner">
                                            <div class="recent-report__chart">
                                                <div id="chart_total_clientes"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row m-t-25">
                                <div class="col-md-12">
                                    <div class="copyright">
                                        <p>Copyright © 2018 Colorlib. All rights reserved. Template by <a href="https://colorlib.com">Colorlib</a>.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END MAIN CONTENT-->
                <!-- END PAGE CONTAINER-->
            </div>

        </div>

        <!-- Jquery JS-->
        <script src="vendor/jquery-3.2.1.min.js"></script>
        <!-- Bootstrap JS-->
        <script src="vendor/bootstrap-4.1/popper.min.js"></script>
        <script src="vendor/bootstrap-4.1/bootstrap.min.js"></script>
        <!-- Vendor JS       -->
        <script src="vendor/slick/slick.min.js">
        </script>
        <script src="vendor/wow/wow.min.js"></script>
        <script src="vendor/animsition/animsition.min.js"></script>
        <script src="vendor/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
        <script src="vendor/perfect-scrollbar/perfect-scrollbar.js"></script>
        <script src="vendor/select2/select2.min.js"></script>
        <!-- Main JS-->
        <script src="js/main.js"></script>
    </body>

</html>