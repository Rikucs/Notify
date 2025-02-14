<?php
include 'config/tt.php';

if (!isset($_SESSION['login'])) {
    header('Location: ../index.php');
}

$auz = 0;
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Notify</title>
    <meta
        content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
        name="viewport" />
    <link
        rel="icon"
        href="../assets/img/kaiadmin/favicon.png"
        type="image/x-icon" />

    <!-- Fonts and icons -->
    <script src="../assets/js/plugin/webfont/webfont.min.js"></script>
    <script>
        WebFont.load({
            google: {
                families: ["Public Sans:300,400,500,600,700"]
            },
            custom: {
                families: [
                    "Font Awesome 5 Solid",
                    "Font Awesome 5 Regular",
                    "Font Awesome 5 Brands",
                    "simple-line-icons",
                ],
                urls: ["../assets/css/fonts.min.css"],
            },
            active: function() {
                sessionStorage.fonts = true;
            },
        });
    </script>
    <!-- #8898aa 
            rgb(106, 120, 135) 
        -->
    <style>
        hr.rounded {
            border-top: 8px solid;
            border-radius: 5px;
            background-color: #D3e7fb;
        }
    </style>


    <!-- CSS Files -->
    <link rel="stylesheet" href="../assets/css/custom.css" />
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../assets/css/plugins.min.css" />
    <link rel="stylesheet" href="../assets/css/kaiadmin.min.css" />
    <link rel="stylesheet" href="../assets/css/custom.css" />

</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <div class="sidebar sidebar-style-2" data-background-color="dark">
            <div class="sidebar-logo">
                <!-- Logo Header -->
                <div class="logo-header" data-background-color="dark">
                    <a href="../notify/notify.php" class="logo">
                        <img
                            src="../assets/img/kaiadmin/NC.png"
                            alt="navbar brand"
                            class="navbar-brand"
                            height="40" />
                    </a>
                    <div class="nav-toggle">
                        <button class="btn btn-toggle toggle-sidebar">
                            <i class="gg-menu-right"></i>
                        </button>
                        <button class="btn btn-toggle sidenav-toggler">
                            <i class="gg-menu-left"></i>
                        </button>
                    </div>
                    <button class="topbar-toggler more">
                        <i class="gg-more-vertical-alt"></i>
                    </button>
                </div>
                <!-- End Logo Header -->
            </div>
            <div class="sidebar-wrapper scrollbar scrollbar-inner">
                <div class="sidebar-content">
                    <ul class="nav nav-secondary">
                        <li class="nav-item">
                            <a
                                data-bs-toggle="collapse"
                                href="#Notify"
                                class="collapsed"
                                aria-expanded="false">
                                <i class="fa fa-bell" aria-hidden="true"></i>
                                <p>Notify</p>
                                <span class="badge badge-success"><?= $ns ?></span>
                                <span class="caret"></span>
                            </a>
                            <div class="collapse" id="Notify">
                                <ul class="nav nav-collapse">
                                    <li>
                                        <a href="../notify/notify.php">
                                            <span class="sub-item">Recebidas</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="../notify/enviadas.php">
                                            <span class="sub-item">Enviadas</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="../notify/form.php">
                                            <span class="sub-item">Enviar Mensagem</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                    <ul class="nav nav-secondary">
                        <li class="nav-item">
                            <a
                                data-bs-toggle="collapse"
                                href="#dashboard"
                                class="collapsed"
                                aria-expanded="false">
                                <i class="fas fa-chart-area"></i>
                                <p>Dashboard</p>
                                <span class="caret"></span>
                            </a>
                            <div class="collapse" id="dashboard">
                                <ul class="nav nav-collapse">
                                    <li>
                                        <!-- TO Change Link -->
                                        <a href="../vendedor/KPI.php">
                                            <span class="sub-item">KPI</span>
                                        </a>
                                    </li>
                                    <li>
                                        <!-- TO Change Link -->
                                        <a href="../vendedor/snapshot.php">
                                            <span class="sub-item">Snapshot</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                    <ul class="nav nav-secondary">
                        <li class="nav-item">
                            <a
                                data-bs-toggle="collapse"
                                href="#TT"
                                class="collapsed"
                                aria-expanded="false">
                                <i class="fa fa-wrench" aria-hidden="true"></i>
                                <p>Trouble Tickets</p>
                                <span class="caret"></span>
                            </a>
                            <div class="collapse" id="TT">
                                <ul class="nav nav-collapse">
                                    <li>
                                        <!-- TO Change Link -->
                                        <a href="#">
                                            <span class="sub-item">Abrir TT</span>
                                        </a>
                                    </li>
                                    <li>
                                        <!-- TO Change Link -->
                                        <a href="#">
                                            <span class="sub-item">Abertos</span>
                                        </a>
                                    </li>
                                    <li>
                                        <!-- TO Change Link -->
                                        <a href="historico.php">
                                            <span class="sub-item">Historico</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                    <ul class="nav nav-secondary">
                        <li class="nav-item">
                            <a
                                data-bs-toggle="collapse"
                                href="#Outros"
                                class="collapsed"
                                aria-expanded="false">
                                <i class="fab fa-cloudversify" aria-hidden="true"></i>
                                <p>Aplicações Externas</p>
                                <span class="caret"></span>
                            </a>
                            <div class="collapse" id="Outros">
                                <ul class="nav nav-collapse">
                                    <li>
                                        <!-- TO Change Link -->
                                        <a href="https://books.newcoffee.pt/login">
                                            <span class="sub-item">Books Online</span>
                                        </a>
                                    </li>
                                    <li>
                                        <!-- TO Change Link -->
                                        <a href="https://nextcloud.newcoffee.pt">
                                            <span class="sub-item">NextCloud</span>
                                        </a>
                                    </li>
                                    <li>
                                        <!-- TO Change Link -->
                                        <a href="https://mudarpassword.newcoffee.pt">
                                            <span class="sub-item">Mudar Password</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- End Sidebar -->

        <div class="main-panel">
            <div class="main-header">
                <div class="main-header-logo">
                    <!-- Logo Header -->
                    <div class="logo-header" data-background-color="dark">
                        <a href="../notify/notify.php" class="logo">
                            <!--<img
                              src="../assets/img/kaiadmin/logo_light.svg"
                              alt="navbar brand"
                              class="navbar-brand"
                              height="20"
                          />-->
                        </a>
                    </div>
                    <!-- End Logo Header -->
                </div>
                <!-- Navbar Header -->
                <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
                    <div class="container-fluid">

                        <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">

                            <li class="nav-item topbar-icon dropdown hidden-caret">
                                <a
                                    class="nav-link dropdown-toggle"
                                    href="#"
                                    id="notifDropdown"
                                    role="button"
                                    data-bs-toggle="dropdown"
                                    aria-haspopup="true"
                                    aria-expanded="false">
                                    <i class="fa fa-bell"></i>
                                    <span class="notification"> <?= $ns ?></span>
                                </a>
                                <ul
                                    class="dropdown-menu notif-box animated fadeIn"
                                    aria-labelledby="notifDropdown">
                                    <li>
                                        <div class="dropdown-title">
                                            Tem <span><?= $ns ?></span> notificações novas
                                        </div>
                                    </li>
                                    <li>
                                        <div class="notif-scroll scrollbar-outer">
                                            <div class="notif-center">
                                                <?php foreach ($nosino as $sino) { ?>
                                                    <a href="ver.php?noti=<?= $sino['NOSTAMP'] ?>">
                                                        <div width="170" height="40">
                                                            <img
                                                                src="../assets/img/kaiadmin/favicon.png"
                                                                width="170"
                                                                height="40"
                                                                alt="Img Profile" />
                                                        </div>
                                                        <div class="notif-content">
                                                            <span class="block"> NewCoffee - Notify </span>
                                                            <span class="time">Nova Notificação de <?= $sino["USRCODE"] ?></span>
                                                        </div>
                                                    </a>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <a class="see-all" href="../notify/notify.php">Ver todas as notificações<i class="fa fa-angle-right"></i>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item topbar-user dropdown hidden-caret">
                                <a
                                    class="dropdown-toggle profile-pic"
                                    data-bs-toggle="dropdown"
                                    href="#"
                                    aria-expanded="false">
                                    <div class="avatar-sm">
                                        <img
                                            src="../assets/img/profile.jpg"
                                            alt="..."
                                            class="avatar-img rounded-circle" />
                                    </div>
                                    <span class="profile-username">
                                        <span class="op-7">Olá,</span>
                                        <span class="fw-bold"><?php echo $login ?></span>
                                    </span>
                                </a>
                                <ul class="dropdown-menu dropdown-user animated fadeIn">
                                    <div class="dropdown-user-scroll scrollbar-outer">
                                        <li>
                                            <div class="user-box">
                                                <div class="avatar-lg">
                                                <span class="avatar-title rounded-circle border border-white bg-danger"><?= substr($login, 0, 1); ?></span>
                                                </div>
                                                <div class="u-text">
                                                    <h4><?php echo $login ?></h4>
                                                </div>
                                        </li>
                                        <li>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="../notify/enviadas.php">Enviadas</a>
                                            <a class="dropdown-item" href="../notify/notify.php">Recebidas</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="../notify/form.php">Enviar mensagem</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="../login/logout.php">Sair</a>
                                        </li>
                                    </div>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
                <!-- End Navbar -->
            </div>
            
            <div class="container">
                <div class="page-inner">
                    <!--<div class="page-header">
                        <ul class="breadcrumbs mb-3">
                            <li class="nav-home">
                                <a href="notify.php">
                                    <i class="icon-home"></i>
                                </a>
                            </li>
                            <li class="separator">
                                <i class="icon-arrow-right"></i>
                            </li>
                            <li class="nav-item">
                                <a href="form.php">Mensagem</a>
                            </li>
                        </ul>
                    </div>-->
                    <div class="row">
                        <div class="col-3 col-sm-2 col-lg-3">
                            <div class="card">
                                <div class="card-header" style="background-color: #D3e7fb; text-align: center">
                                    <div class="headcs">ID</div>
                                </div>
                                <div class="card-body">
                                    <div class="bodycs"> 9169 </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-3 col-sm-2 col-lg-3">
                            <div class="card">
                                <div class="card-header" style="background-color: #D3e7fb; text-align: center">
                                    <div class="headcs">Data/Hora</div>
                                </div>
                                <div class="card-body">
                                    <div class="bodycs"> 21/01/2025 15:26 </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-3 col-sm-2 col-lg-3">
                            <div class="card">
                                <div class="card-header" style="background-color: #D3e7fb; text-align: center">
                                    <div class="headcs">Tecnico</div>
                                </div>
                                <div class="card-body">
                                    <div class="bodycs"> Ruben Ribeiro </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-3 col-sm-2 col-lg-3">
                            <div class="card">
                                <div class="card-header" style="background-color: #D3e7fb; text-align: center">
                                    <div class="headcs">Urgencia</div>
                                </div>
                                <div class="card-body">
                                    <div class="bodycs"> Pode Esperar </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 col-sm-6 col-lg-6">
                            <div class="card">
                                <div class="card-header" style="background-color: #D3e7fb; text-align: center">
                                    <div class="headcs">Problema</div>
                                </div>
                                <div class="card-body">
                                    <div class="bodycs" style=" text-align: justify">
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-sm-6 col-lg-6">
                            <div class="card">
                                <div class="card-header" style="background-color: #D3e7fb; text-align: center">
                                    <div class="headcs">Intervenções</div>
                                </div>
                                <div class="card-body">
                                    <ol class="activity-feed">
                                        <li class="feed-item feed-item-secondary">
                                            <time class="date" datetime="9-25">Ruben</time>
                                            <span class="bodycs"><b>Intervenção x:</b>
                                                Problema resolvido, fecho do tt</span>
                                        </li>
                                        <li class="feed-item feed-item-success">
                                            <time class="date" datetime="9-24">Eu</time>
                                            <span class="bodycs"><b>Intervenção x:</b>
                                                Lorem ipsum odor amet, consectetuer adipiscing elit.</span>
                                        </li>
                                        <li class="feed-item feed-item-info">
                                            <time class="date" datetime="9-23">Ruben</time>
                                            <span class="bodycs"><b>Intervenção x:</b>

                                                Lorem ipsum odor amet, consectetuer adipiscing elit.</span>
                                        </li>
                                        <li class="feed-item feed-item-warning">
                                            <time class="date" datetime="9-21">Eu</time>
                                            <span class="bodycs"><b>Intervenção x:</b>
                                                Lorem ipsum odor amet, consectetuer adipiscing elit</span>
                                        </li>
                                        <li class="feed-item feed-item-danger">
                                            <time class="date" datetime="9-18">Ruben</time>
                                            <span class="bodycs"><b>Intervenção x:</b>
                                                Lorem ipsum odor amet, consectetuer adipiscing elit.</span>
                                        </li>
                                        <li class="feed-item">
                                            <time class="date" datetime="9-17">Eu</time>
                                            <span class="bodycs"><b>Intervenção x:</b>
                                                Lorem ipsum odor amet, consectetuer adipiscing elit.</span>
                                        </li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-12 col-lg-12">
                            <div class="card">
                                <!-- rgba(227, 232, 236, 0.95) #D3e7fb -->
                                <div class="card-header" style="background-color:#D3e7fb; text-align: center">
                                    <div class="headcs">Documentos</div>
                                </div>
                                <div class="card-body">
                                    <?php

                                    if (!empty($files)) {
                                        foreach ($files as $file) {
                                            $fileExtension = pathinfo($file['DOCCODE'], PATHINFO_EXTENSION);
                                            if ($fileExtension == 'pdf') {
                                                $fileName = $file['DOCCODE'];
                                                $fileData = hex2bin($file['DOC64']);
                                                $tmpFilePath = 'temp/' . $fileName;
                                                file_put_contents($tmpFilePath, $fileData);
                                                echo 'Use CTRL + Scroll para aumentar ou diminuir o zoom<br>';
                                                echo '<iframe
                                                    src="' . $tmpFilePath . '#toolbar=0&navpanes=0&scrollbar=0"
                                                    frameBorder="0"
                                                    scrolling="auto"
                                                    height="750px"
                                                    width="100%"
                                                    ></iframe>';
                                                //echo '<div><a href="pdf.php?noti='.$file['DOCNO'].'" target="_blank">Abrir ' . $file["DOCCODE"] . '</a></div><br>';
                                            } elseif (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif'])) {
                                                echo '<hr class="rounded">';
                                                echo '<div style="text-align: center"><img src="data:image/' . $fileExtension . ';base64,' . base64_encode(hex2bin($file['DOC64'])) . '" alt="" ></div><br>';
                                                echo '<hr class="rounded">';
                                            } else {
                                                echo '<hr class="rounded">';
                                                echo "<div>Ficheiro Desconhecido: " . $file['DOCCODE'] . " <br> Por favor falar com o remetente</div><br>";
                                                echo '<hr class="rounded">';
                                            }
                                        }
                                    } else {
                                        echo '<div>Sem ficheiros em anexo.</div>';
                                    }

                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--   Core JS Files   -->
    <script src="../assets/js/core/jquery-3.7.1.min.js"></script>
    <script src="../assets/js/core/popper.min.js"></script>
    <script src="../assets/js/core/bootstrap.min.js"></script>

    <!-- jQuery Scrollbar -->
    <script src="../assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>

    <!-- Chart JS -->
    <script src="../assets/js/plugin/chart.js/chart.min.js"></script>

    <!-- jQuery Sparkline -->
    <script src="../assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>

    <!-- Chart Circle -->
    <script src="../assets/js/plugin/chart-circle/circles.min.js"></script>

    <!-- Datatables -->
    <script src="../assets/js/plugin/datatables/datatables.min.js"></script>

    <!-- Bootstrap Notify -->
    <script src="../assets/js/plugin/bootstrap-notify/bootstrap-notify.phpmin.js"></script>

    <!-- jQuery Vector Maps -->
    <script src="../assets/js/plugin/jsvectormap/jsvectormap.min.js"></script>
    <script src="../assets/js/plugin/jsvectormap/world.js"></script>

    <!-- Sweet Alert
    <script src="../assets/js/plugin/sweetalert/sweetalert.min.js"></script>-->

    <!-- Kaiadmin JS -->
    <script src="../assets/js/kaiadmin.min.js"></script>

    <!-- Kaiadmin DEMO methods, don't include it in your project!
    <script src="../assets/js/setting-demo.js"></script>
    <script src="../assets/js/demo.js"></script>-->

    <!-- Show more table -->
    <script>
        $(document).ready(function() {
            $("#basic-datatables").DataTable({});

            $("#multi-filter-select").DataTable({
                pageLength: 5,
                initComplete: function() {
                    this.api()
                        .columns()
                        .every(function() {
                            var column = this;
                            var select = $(
                                    '<select class="form-select"><option value=""></option></select>'
                                )
                                .appendTo($(column.footer()).empty())
                                .on("change", function() {
                                    var val = $.fn.dataTable.util.escapeRegex($(this).val());

                                    column
                                        .search(val ? "^" + val + "$" : "", true, false)
                                        .draw();
                                });

                            column
                                .data()
                                .unique()
                                .sort()
                                .each(function(d, j) {
                                    select.append(
                                        '<option value="' + d + '">' + d + "</option>"
                                    );
                                });
                        });
                },
            });

            // Add Row
            $("#add-row").DataTable({
                pageLength: 5,
            });


        });
    </script>

    <script>
        $(document).ready(function() {
            function fetchNotifications() {
                $.ajax({
                    url: 'config/sino.php',
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#notification-count').text(data.count);
                        $('#notification-count-text').text(data.count);
                    }
                });
            }

            // Fetch notifications every 10 seconds
            setInterval(fetchNotifications, 10000);
        });
    </script>



</body>

</html>