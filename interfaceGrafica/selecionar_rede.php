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
    
    //Retorna a data do dia anterior
    $data = $fun->dataAnterior();

    //Redes
    $redes = array ( "Algorix", "Banrisul", "Credishop", "Dacasacard", "Elavon", "Getnet", "Globalpay", 
    "Policard", "Softnex", "Stone", "Sysdata", "Telenet", "Valecard");


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
                                <div class="col-lg-12">
                                    <div class="overview-wrap">
                                        <h2 class="title-1">Dashboard - Selecionar Redes</h2>
                                        <span class="au-btn au-btn-icon au-btn--blue">
                                            <?php echo "Data Origem: " . date('d/m/Y', $data); ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row m-t-25">
                                <div class="col-lg-12">
                                    <div class="table-responsive table--no-card m-b-40">
                                        <table class="table table-borderless table-striped table-earning">
                                            <thead>
                                                <tr>
                                                    <th>Nome</th>
                                                    <th>Detalhes</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    while (list($key, $value) = each($redes)) {
                                                ?>
                                                    <tr>
                                                        <td><?php echo $value?></td>
                                                        <td><a href="rede_detalhada.php?rede=<?php echo $value ?>" target="_blank">Detalhes</a></td>
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