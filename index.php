<?php
require_once 'classes/Transacoes.php';
require_once 'classes/Funcoes.php';

//Instancia de Classe com os métodos de consulta de transações
$tran = new Transacoes();

//Instancia de Classe Com variáveis estáticas e funções
$fun = new Funcoes();

//Retorna a data do dia anterior
$data = $fun->dataAnterior();

//retorna um Array com a Quantidade Total dos Principais Estabelecimentos
$quantidadeTransEstabelecimento =  $tran->totalizarTranEstabelecimento($fun->getEstabelecimentos());

//Retorna total de transações das quatros redes principais
$quantidadeTransRede = $tran->totalizarTransacoesRedeIndex($fun->getPrincipaisRedes());

//Quantidade de dias para consulta e alimentar o gráfico
$periodos = $fun->retornarPeriodos();

$quantidadeTransGraficoMensal = $tran->totalizarGraficoMensal($periodos, $fun->getPrincipaisRedes());

?>
<!DOCTYPE html>
<html lang="pt-br">

    <head>
        <!-- Required meta tags-->
        <meta charset="UTF-8">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Dashboard de monitração de servidores">
        <meta http-equiv="refresh" content="7200">
        <meta name="author" content="Luan Michel">
        <link rel="shortcut icon" href="speedometer.svg.png" >
        <!-- Title Page-->
        <title>Sotech - Dashboard</title>

        <!-- Fontfaces CSS-->
        <link href="interfaceGrafica/css/font-face.css" rel="stylesheet" media="all">
        <link href="interfaceGrafica/vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
        <link href="interfaceGrafica/vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
        <link href="interfaceGrafica/vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">

        <!-- Bootstrap CSS-->
        <link href="interfaceGrafica/vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">

        <!-- Vendor CSS-->
        <link href="interfaceGrafica/vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
        <link href="interfaceGrafica/vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet" media="all">
        <link href="interfaceGrafica/vendor/wow/animate.css" rel="stylesheet" media="all">
        <link href="interfaceGrafica/vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
        <link href="interfaceGrafica/vendor/slick/slick.css" rel="stylesheet" media="all">
        <link href="interfaceGrafica/vendor/select2/select2.min.css" rel="stylesheet" media="all">
        <link href="interfaceGrafica/vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">

        <!-- Main CSS-->
        <link href="interfaceGrafica/css/theme.css" rel="stylesheet" media="all">

        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
          google.charts.load('current', {'packages':['bar']});
          google.charts.setOnLoadCallback(drawChart);

          function drawChart() {
            var data = google.visualization.arrayToDataTable([
              ['Ano/Mês', 'Banesecard', 'Bin', 'Cielo', 'Userede'],
              ['<?php echo $periodos["Noventa"] ?>',   
                  <?php echo $quantidadeTransGraficoMensal["Banesecard"]["Noventa"]; ?>,  
                  <?php echo $quantidadeTransGraficoMensal["Bin"]["Noventa"]; ?>,     
                  <?php echo $quantidadeTransGraficoMensal["Cielo"]["Noventa"]; ?>, 
                  <?php echo $quantidadeTransGraficoMensal["Userede"]["Noventa"]; ?>],
              ['<?php echo $periodos["Sessenta"] ?>',  
                  <?php echo $quantidadeTransGraficoMensal["Banesecard"]["Sessenta"]; ?>, 
                  <?php echo $quantidadeTransGraficoMensal["Bin"]["Sessenta"]; ?>,    
                  <?php echo $quantidadeTransGraficoMensal["Cielo"]["Sessenta"]; ?>, 
                  <?php echo $quantidadeTransGraficoMensal["Userede"]["Sessenta"]; ?>],
              ['<?php echo $periodos["Trinta"] ?>',    
                  <?php echo $quantidadeTransGraficoMensal["Banesecard"]["Trinta"]; ?>,   
                  <?php echo $quantidadeTransGraficoMensal["Bin"]["Trinta"]; ?>,      
                  <?php echo $quantidadeTransGraficoMensal["Cielo"]["Trinta"]; ?>, 
                  <?php echo $quantidadeTransGraficoMensal["Userede"]["Trinta"]; ?>]
            ]);

             var options = {
                chart: {
                  title: 'Transações dos Ultimos Meses',
                },
                bars: 'vertical',
                vAxis: {format: 'decimal'},
                height: 400,
                colors: ['green', 'black', 'blue', 'orange']
              };

            var chart = new google.charts.Bar(document.getElementById('grafico_mensal'));

            chart.draw(data, google.charts.Bar.convertOptions(options));
          }
        </script>

        <!-- Total de VEndas por % -->
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
            google.charts.load('current', {'packages': ['corechart']});
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {

                var data = google.visualization.arrayToDataTable([
                    ['Task', 'Por Dia'],
                    ['CIELO',       <?php echo $quantidadeTransRede["Cielo"] ?>],
                    ['BIN',         <?php echo $quantidadeTransRede["Bin"] ?>],
                    ['USEREDE',     <?php echo $quantidadeTransRede["Userede"] ?>],
                    ['BANESECARD',  <?php echo $quantidadeTransRede["Banesecard"] ?>]


                ]);

                var options = {
                    title: 'Todas as Redes'
                };

                var chart = new google.visualization.PieChart(document.getElementById('piechart'));

                chart.draw(data, options);
            }
        </script>

    </head>

    <body class="animsition">
        <div class="page-wrapper">
            <?php include 'interfaceGrafica/includes/sidebar_index.php'; ?>
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
                                        <h2 class="title-1">Dashboard - Transações</h2>
                                        <span class="au-btn au-btn-icon au-btn--blue">
                                            <?php echo "Data Origem: " . date('d/m/Y', $data); ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row m-t-25">
                                <div class="col-sm-6 col-lg-3 offset-lg-9">
                                    <div class="text">
                                        <h2><?php echo $tran->totalizarTodasRedes(); ?></h2>
                                        <span>Total de Transações</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row m-t-25">
                                <div class="col-sm-6 col-lg-3">
                                    <div class="overview-item overview-item--c1">
                                        <div class="overview__inner">
                                            <div class="overview-box clearfix">
                                                <div class="icon">
                                                    <i class="zmdi zmdi-money"></i>
                                                </div>
                                                <div class="text">
                                                    <h2><?php echo $quantidadeTransRede["Banesecard"] ?></h2>
                                                    <span>Banese</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="overview-item overview-item--c2">
                                        <div class="overview__inner">
                                            <div class="overview-box clearfix">
                                                <div class="icon">
                                                    <i class="zmdi zmdi-money"></i>
                                                </div>
                                                <div class="text">
                                                    <h2><?php echo $quantidadeTransRede["Bin"] ?></h2>
                                                    <span>Bin</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="overview-item overview-item--c3">
                                        <div class="overview__inner">
                                            <div class="overview-box clearfix">
                                                <div class="icon">
                                                    <i class="zmdi zmdi-money"></i>
                                                </div>
                                                <div class="text">
                                                    <h2><?php echo $quantidadeTransRede["Cielo"] ?></h2>
                                                    <span>Cielo</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="overview-item overview-item--c4">
                                        <div class="overview__inner">
                                            <div class="overview-box clearfix">
                                                <div class="icon">
                                                    <i class="zmdi zmdi-money"></i>
                                                </div>
                                                <div class="text">
                                                    <h2><?php echo $quantidadeTransRede["Userede"] ?></h2>
                                                    <span>Userede</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="au-card recent-report">
                                        <div class="au-card-inner">
                                            <div class="recent-report__chart">
                                                <div id="grafico_mensal"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <div class="au-card chart-percent-card">
                                        <div class="au-card-inner">
                                            <h3 class="title-2 tm-b-5">Total</h3>
                                            <div class="recent-report__chart">
                                                <div class="percent-chart">
                                                    <div id="piechart" style="width: auto; height: auto;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <h2 class="title-1 m-b-25">Top Clientes</h2>
                                    <div class="au-card au-card--bg-blue au-card-top-countries m-b-40">
                                        <div class="au-card-inner">
                                            <div class="table-responsive">
                                                <table class="table table-top-countries">
                                                    <tbody>
                                                        <?php foreach ($quantidadeTransEstabelecimento as $key02 => $value02) { ?>
                                                        <tr>
                                                            <?php if($key02 == "NewOtica") {?>
                                                            <td><?php echo $key02." OFL e MFA";?></td>
                                                            <?php }else{ ?>
                                                            <td><?php echo $key02;?></td>
                                                            <?php } ?>
                                                            <td class="text-right">
                                                                <?php echo $value02; ?>
                                                            </td>
                                                        </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <h2 class="title-1 m-b-25">Ultimas Transações</h2>
                                    <div class="table-responsive table--no-card m-b-40">
                                        <table class="table table-borderless table-striped table-earning">
                                            <thead>
                                                <tr>
                                                    <th>Estabelecimento</th>
                                                    <th>Rede</th>
                                                    <th>Valor</th>
                                                    <th class="text-right">Tipo Cartão</th>
                                                    <th class="text-right">Administrador</th>
                                                    <th class="text-right">Server</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $result = $tran->totalizarUltimasTrans();

                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                ?>
                                                    <tr>
                                                        <td><?php echo $row['estabelecimento'] ?></td>
                                                        <td><?php echo $row['rede'] ?></td>
                                                        <td><?php echo $row['transacao_valor'] ?></td>
                                                        <td class="text-right"><?php echo $row['tipo_cartao'] ?></td>
                                                        <td class="text-right"><?php echo $row['administrador'] ?></td>
                                                        <td class="text-right"><?php echo $row['ds_servidor_tef'] ?></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
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
        <script src="interfaceGrafica/vendor/jquery-3.2.1.min.js"></script>
        <!-- Bootstrap JS-->
        <script src="interfaceGrafica/vendor/bootstrap-4.1/popper.min.js"></script>
        <script src="interfaceGrafica/vendor/bootstrap-4.1/bootstrap.min.js"></script>
        <!-- Vendor JS       -->
        <script src="interfaceGrafica/vendor/slick/slick.min.js">
        </script>
        <script src="interfaceGrafica/vendor/wow/wow.min.js"></script>
        <script src="interfaceGrafica/vendor/animsition/animsition.min.js"></script>
        <script src="interfaceGrafica/vendor/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
        <script src="interfaceGrafica/vendor/perfect-scrollbar/perfect-scrollbar.js"></script>
        <script src="interfaceGrafica/vendor/select2/select2.min.js"></script>
        <!-- Main JS-->
        <script src="interfaceGrafica/js/main.js"></script>
    </body>

</html>