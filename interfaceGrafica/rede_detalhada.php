<?php
    header('Content-Type: text/html; charset=utf-8');    
    require_once '../classes/Transacoes.php';
    require_once '../classes/Funcoes.php';
    
    //Recebe o nome da rede da qual irá detalhar
    $rede = $_GET['rede'];
    
    //Objeto da classe Transacao
    $trans = new Transacoes();
    
    //Instancia de Classe Com variáveis estáticas e funções
    $fun = new Funcoes();
    
    $periodos = $fun->retornarPeriodos();
    
    //Retorna a data do dia anterior
    $data = $fun->dataAnterior();
    
    $Detalhes = $trans->totalizarTransRedeDetalhada($rede);
    
    $valorTotalAnual = $trans->totalizarGraficoValorAnual($rede);
    
    $valorTotalBandeiras = $trans->totalizarGraficoValorBandeira($rede, $periodos['Trinta']);
 
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
          google.charts.load('current', {'packages':['corechart']});
          google.charts.setOnLoadCallback(drawChart);

          function drawChart() {

            var data = google.visualization.arrayToDataTable([
              ['Task', 'TransaÃ§Ãµes por Dia'],
              ['Débito',       <?php echo $Detalhes[0]["Débito"] ?>],
              ['Crédito',      <?php echo $Detalhes[0]["Crédito"] ?>]
            ]);

            var options = {
              title: 'Sotech'
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart01'));

            chart.draw(data, options);
          }
        </script>
        <script type="text/javascript">
          google.charts.load('current', {'packages':['corechart']});
          google.charts.setOnLoadCallback(drawChart);

          function drawChart() {

            var data = google.visualization.arrayToDataTable([
              ['Task', 'TransaÃ§Ãµes por Dia'],
              ['A Vista',     <?php echo $Detalhes[0]["A Vista"] ?>],
              ['Parcelado',    <?php echo $Detalhes[0]["Parcelado"] ?>],
              ['Pré-Datado',  <?php echo $Detalhes[0]["Pré-Datado"] ?>]
            ]);

            var options = {
              title: 'Sotech'
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart02'));

            chart.draw(data, options);
          }
        </script>
        <script type="text/javascript">
            google.charts.load('current', {packages: ['corechart', 'bar']});
            google.charts.setOnLoadCallback(drawAxisTickColors);
            
            <?php if($rede == "Banese"){ ?>
                function drawAxisTickColors() {
                    var data = google.visualization.arrayToDataTable([
                      ['Bandeiras', 'Total de Transações'],
                      ['Banesecard',  <?php echo $Detalhes[2]["Banesecard"] ?>]
                    ]);

                    var options = {
                      chartArea: {width: '50%'},
                      hAxis: {
                        title: 'Total de Transações',
                        minValue: 0,
                        textStyle: {
                          bold: true,
                          fontSize: 12,
                          color: '#4d4d4d'
                        },
                        titleTextStyle: {
                          bold: true,
                          fontSize: 18,
                          color: '#4d4d4d'
                        }
                      },
                      vAxis: {
                        title: 'Bandeiras',
                        textStyle: {
                          fontSize: 15,
                          bold: true,
                          color: '#848484'
                        },
                        titleTextStyle: {
                          fontSize: 14,
                          bold: true,
                          color: '#848484'
                        }
                      }
                    };
                    var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
                    chart.draw(data, options);
                  }
            <?php }else{ ?>
                    function drawAxisTickColors() {
                    var data = google.visualization.arrayToDataTable([
                      ['Bandeiras', 'Total de Transações'],
                      ['Amex',       <?php echo $Detalhes[2]["Amex"] ?>],
                      ['Diners',     <?php echo $Detalhes[2]["Diners"] ?>],
                      ['Elo',        <?php echo $Detalhes[2]["Elo"] ?>],
                      ['Hipercard',  <?php echo $Detalhes[2]["Hipercard"] ?>],
                      ['Mastercard', <?php echo $Detalhes[2]["Mastercard"] ?>],
                      ['Visa',       <?php echo $Detalhes[2]["Visa"] ?>]
                    ]);

                    var options = {
                      chartArea: {width: '50%'},
                      hAxis: {
                        title: 'Total de Transações',
                        minValue: 0,
                        textStyle: {
                          bold: true,
                          fontSize: 12,
                          color: '#4d4d4d'
                        },
                        titleTextStyle: {
                          bold: true,
                          fontSize: 18,
                          color: '#4d4d4d'
                        }
                      },
                      vAxis: {
                        title: 'Bandeiras',
                        textStyle: {
                          fontSize: 15,
                          bold: true,
                          color: '#848484'
                        },
                        titleTextStyle: {
                          fontSize: 14,
                          bold: true,
                          color: '#848484'
                        }
                      }
                    };
                    var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
                    chart.draw(data, options);
                  }
            <?php } ?>
    </script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
          google.charts.load('current', {'packages':['bar']});
          google.charts.setOnLoadCallback(drawChart);

          function drawChart() {
            var data = google.visualization.arrayToDataTable([
              ['Mês', 'Total'],
              ['Janeiro',   <?php echo $valorTotalAnual["janeiro"];     ?>],
              ['Fevereiro', <?php echo $valorTotalAnual["fevereiro"];   ?>],
              ['Março',     <?php echo $valorTotalAnual["março"];       ?>],
              ['Abril',     <?php echo $valorTotalAnual["abril"];       ?>],
              ['Maio',      <?php echo $valorTotalAnual["maio"];        ?>],
              ['Junho',     <?php echo $valorTotalAnual["junho"];       ?>],
              ['Julho',     <?php echo $valorTotalAnual["julho"];       ?>],
              ['Agosto',    <?php echo $valorTotalAnual["agosto"];      ?>],
              ['Setembro',  <?php echo $valorTotalAnual["setembro"];    ?>],
              ['Outubro',   <?php echo $valorTotalAnual["outubro"];     ?>],
              ['Novembro',  <?php echo $valorTotalAnual["novembro"];    ?>],
              ['Dezembro',  <?php echo $valorTotalAnual["dezembro"];    ?>]
            ]);

            var options = {
              chart: {
                title: 'Valor Total de Transações por Mês do Ano Atual'
              },
              bars: 'vertical',
              vAxis: {format: 'decimal'},
              height: 400,
              <?php if($rede == "Cielo"){ ?>
                colors: ['Blue']  
              <?php }elseif ($rede == "Userede") { ?>
                colors: ['Orange']
              <?php }elseif($rede == "Bin"){ ?>
                  colors: ['Red']
              <?php }else{ ?>
                  colors: ['Green']
              <?php } ?>
            };

            var chart = new google.charts.Bar(document.getElementById('chart_valorTotal'));

            chart.draw(data, google.charts.Bar.convertOptions(options));
          }
        </script>
        <script type="text/javascript">
            google.charts.load('current', {packages: ['corechart', 'bar']});
            google.charts.setOnLoadCallback(drawAxisTickColors);
            function drawAxisTickColors() {
                var data = google.visualization.arrayToDataTable([
                  ['Bandeiras', 'Valor Total de Transações Débito'],
                  ['Elo',        <?php echo $valorTotalBandeiras["EloDebito"] ?>],
                  ['Hipercard',  <?php echo $valorTotalBandeiras["HiperDebito"] ?>],
                  ['Mastercard', <?php echo $valorTotalBandeiras["MasterDebito"] ?>],
                  ['Visa',       <?php echo $valorTotalBandeiras["VisaDebito"] ?>]
                ]);

                var options = {
                  chartArea: {width: '50%'},
                  hAxis: {
                    title: 'Valor Total de Transações',
                    minValue: 0,
                    textStyle: {
                      bold: true,
                      fontSize: 12,
                      color: '#4d4d4d'
                    },
                    titleTextStyle: {
                      bold: true,
                      fontSize: 18,
                      color: '#4d4d4d'
                    }
                  },
                  vAxis: {
                    title: 'Bandeiras',
                    textStyle: {
                      fontSize: 15,
                      bold: true,
                      color: '#848484'
                    },
                    titleTextStyle: {
                      fontSize: 14,
                      bold: true,
                      color: '#848484'
                    }
                  }
                };
                var chart = new google.visualization.BarChart(document.getElementById('chart_TotalDebito'));
                chart.draw(data, options);
              }
    </script>
    <script type="text/javascript">
            google.charts.load('current', {packages: ['corechart', 'bar']});
            google.charts.setOnLoadCallback(drawAxisTickColors);
            function drawAxisTickColors() {
                var data = google.visualization.arrayToDataTable([
                  ['Bandeiras', 'Valor Total de Transações Crédito'],
                  ['Amex',        <?php echo $valorTotalBandeiras["Amex"] ?>],
                  ['Elo',        <?php echo $valorTotalBandeiras["EloCredito"] ?>],
                  ['Hipercard',  <?php echo $valorTotalBandeiras["HiperCredito"] ?>],
                  ['Mastercard', <?php echo $valorTotalBandeiras["MasterCredito"] ?>],
                  ['Visa',       <?php echo $valorTotalBandeiras["VisaCredito"] ?>]
                ]);

                var options = {
                  chartArea: {width: '50%'},
                  hAxis: {
                    title: 'Valor Total de Transações',
                    minValue: 0,
                    textStyle: {
                      bold: true,
                      fontSize: 12,
                      color: '#4d4d4d'
                    },
                    titleTextStyle: {
                      bold: true,
                      fontSize: 18,
                      color: '#4d4d4d'
                    }
                  },
                  vAxis: {
                    title: 'Bandeiras',
                    textStyle: {
                      fontSize: 15,
                      bold: true,
                      color: '#848484'
                    },
                    titleTextStyle: {
                      fontSize: 14,
                      bold: true,
                      color: '#848484'
                    }
                  }
                };
                var chart = new google.visualization.BarChart(document.getElementById('chart_TotalCredito'));
                chart.draw(data, options);
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
                                        <?php if($rede == "Userede"){ ?>
                                            <h2 class="title-1">Dashboard - <?php echo $rede;?> e Redecard</h2>
                                        <?php }else{ ?>
                                            <h2 class="title-1">Dashboard - <?php echo $rede;?></h2>
                                        <?php } ?>
                                        <span class="au-btn au-btn-icon au-btn--blue">
                                            <?php echo "Data Origem: " . date('d/m/Y', $data); ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row m-t-25">
                                <div class="col-sm-6 col-lg-3 offset-lg-9">
                                    <div class="text">
                                        <h2><?php echo $trans->totalizarTransacoesRedeDetalhada($rede); ?></h2>
                                        <span>Total de Transações</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row m-t-25">
                                <div class="col-lg-6">
                                    <div class="au-card chart-percent-card">
                                        <div class="au-card-inner">
                                            <h3 class="title-2 tm-b-5">Total Crédito/Débito</h3>
                                            <div class="recent-report__chart">
                                                <div class="percent-chart">
                                                    <div id="piechart01" style="width: auto; height: auto;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="au-card chart-percent-card">
                                        <div class="au-card-inner">
                                            <h3 class="title-2 tm-b-5">Total À Vista/Parcelado</h3>
                                            <div class="recent-report__chart">
                                                <div class="percent-chart">
                                                    <div id="piechart02" style="width: auto; height: auto;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="au-card recent-report">
                                        <div class="au-card-inner">
                                            <h3 class="title-2">Transações Por Bandeira</h3>
                                            <div class="recent-report__chart">
                                                <div id="chart_div"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="au-card recent-report">
                                        <div class="au-card-inner">
                                            <h3 class="title-2">Valor Total Transações Por Bandeira Mês Anterior</h3>
                                            <div class="recent-report__chart">
                                                <div id="chart_TotalDebito"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="au-card recent-report">
                                        <div class="au-card-inner">
                                            <h3 class="title-2">Valor Total Transações Por Bandeira Mês Anterior</h3>
                                            <div class="recent-report__chart">
                                                <div id="chart_TotalCredito"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="au-card recent-report">
                                        <div class="au-card-inner">
                                            <div class="recent-report__chart">
                                                <div id="chart_valorTotal"></div>
                                            </div>
                                        </div>
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