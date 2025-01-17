<?php
include 'config/display.php';
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
        href="assets/img/kaiadmin/favicon.png"
        type="image/x-icon" />

    <!-- Fonts and icons -->
    <script src="assets/js/plugin/webfont/webfont.min.js"></script>
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
                urls: ["assets/css/fonts.min.css"],
            },
            active: function() {
                sessionStorage.fonts = true;
            },
        });
    </script>
    <!-- #8898aa 
            rgb(106, 120, 135) 
        -->



    <!-- CSS Files -->
    <link rel="stylesheet" href="assets/css/custom.css" />
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/plugins.min.css" />
    <link rel="stylesheet" href="assets/css/kaiadmin.min.css" />

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="assets/css/demo.css" />
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <div class="sidebar sidebar-style-2" data-background-color="dark">
            <div class="sidebar-logo">
                <!-- Logo Header -->
                <div class="logo-header" data-background-color="dark">
                    <a href="notify.php" class="logo">
                        <img
                            src="assets/img/kaiadmin/logo.png"
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
                                href="#dashboard"
                                class="collapsed"
                                aria-expanded="false">
                                <i class="fas fa-home"></i>
                                <p>Inicio</p>
                                <span class="caret"></span>
                            </a>
                            <div class="collapse" id="dashboard">
                                <ul class="nav nav-collapse">
                                    <li>
                                        <a href="notify.php">
                                            <span class="sub-item">Recebidas</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="enviadas.php">
                                            <span class="sub-item">Enviadas</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="form.php">
                                            <span class="sub-item">Enviar Mensagem</span>
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
                        <a href="notify.php" class="logo">
                            <!--<img
                              src="assets/img/kaiadmin/logo_light.svg"
                              alt="navbar brand"
                              class="navbar-brand"
                              height="20"
                          />-->
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
                <!-- Navbar Header -->
                <nav
                    class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
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
                                    <span class="notification" id="notification-count-text"> </span>
                                </a>
                                <ul
                                    class="dropdown-menu notif-box animated fadeIn"
                                    aria-labelledby="notifDropdown">
                                    <li>
                                        <div class="dropdown-title">
                                            Tem <span id="notification-count-text"></span> notificações novas
                                        </div>
                                    </li>
                                    <li>
                                        <div class="notif-scroll scrollbar-outer">
                                            <div class="notif-center">
                                                <?php foreach ($nosino as $sino) { ?>
                                                    <a href="ver.php?noti=<?= $sino['NOSTAMP'] ?>">
                                                        <div class="notif-img">
                                                            <img
                                                                src="assets/img/kaiadmin/favicon.png"
                                                                alt="Img Profile" />
                                                        </div>
                                                        <div class="notif-content">
                                                            <span class="block"> New Coffee - Notify </span>
                                                            <span class="time">Nova Notificação de <?= $sino["usercode"] ?></span>
                                                        </div>
                                                    </a>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <a class="see-all" href="notify.php">Ver todas as notificações<i class="fa fa-angle-right"></i>
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
                                            src="assets/img/profile.jpg"
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
                                                    <img
                                                        src="assets/img/profile.jpg"
                                                        alt="image profile"
                                                        class="avatar-img rounded" />
                                                </div>
                                                <div class="u-text">
                                                    <h4><?php echo $login ?></h4>
                                                    <p class="text-muted">hello@example.com</p>
                                                    <a
                                                        href="profile.html"
                                                        class="btn btn-xs btn-secondary btn-sm">Ver Perfil</a>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="enviadas.php">Enviadas</a>
                                            <a class="dropdown-item" href="notify.php">Recebidas</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="form.php">Enviar mensagem</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="login/logout.php">Sair</a>
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
                        <div class="col-4 col-sm-2 col-lg-4">
                            <div class="card">
                                <div class="card-header" style="background-color: rgb(236, 227, 220); text-align: center">
                                    <div class="headcs">Data/Hora</div>
                                </div>
                                <div class="card-body">
                                    <div class="bodycs"> <?= $data ?> </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4 col-sm-2 col-lg-4">
                            <div class="card">
                                <div class="card-header" style="background-color: rgb(236, 227, 220); text-align: center">
                                    <div class="headcs">Remetente</div>
                                </div>
                                <div class="card-body">
                                    <div class="bodycs"> <?= $remetente ?> </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4 col-sm-2 col-lg-4">
                            <div class="card">
                                <div class="card-header" style="background-color: rgb(236, 227, 220); text-align: center">
                                    <div class="headcs">Assunto</div>
                                </div>
                                <div class="card-body">
                                    <div class="bodycs"> <?= $assunto ?> </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-12 col-lg-12">
                            <div class="card">
                                <div class="card-header" style="background-color: rgb(236, 227, 220); text-align: center">
                                    <div class="headcs">Notificação</div>
                                </div>
                                <div class="card-body">
                                    <div class="textoc" style=" text-align: justify">
                                        <?= $notificacao ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php 

                        $query= "select * from destinatarios where NOSTAMP='".$noti."' and USRSTAMP='".$uc."' ";
                        $e = $conn->query($query)->fetchAll();
                        foreach ($e as $z) {
                            $auz +=1;
                        }        
                        if ($auz != 0){                    
                    ?>
                
                    <?php if ($tpa == 2) { ?>
                        <div class="row">
                            <div class="col-6 col-sm-2 col-lg-6">
                                <div class="card">
                                    <div class="card-header" style="background-color: #b4e8a0; text-align: center">
                                        <div class="headcs"><?= $sim ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-sm-2 col-lg-6">
                                <div class="card">
                                    <div class="card-header" style="background-color: #f59b99; text-align: center">
                                        <div class="headcs"><?= $nao ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="row">
                            <div class="col-12 col-sm-2 col-lg-12">
                                <div class="card">
                                    <div class="card-header" style="background-color: #b4e8a0; text-align: center">
                                        <div class="headcs"><?= $ok ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <?php } ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header" style="background-color: rgb(236, 227, 220); text-align: center">

                                    <h4 class="headcs">Destinatarios</h4>

                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table
                                            id="add-row"
                                            class="table align-items-center mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Destinatarios</th>
                                                    <th>Data/Hora</th>
                                                    <th>Resposta</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <?php foreach ($dest as $d) {
                                                ?>
                                                    <tr>
                                                        <td><b><?= $d['usrcode'] ?></b></td>
                                                        <td><?= $d['data'] ?></td>
                                                        <td><?= $d['resposta'] ?></td>
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
                        <div class="col-12 col-sm-12 col-lg-12">
                            <div class="card">
                                <!-- rgba(227, 232, 236, 0.95) 
                                     rgb(236, 227, 220) -->
                                <div class="card-header" style="background-color:rgb(236, 227, 220); text-align: center">
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
                                                echo '<div style="text-align: center"><img src="data:image/' . $fileExtension . ';base64,' . base64_encode(hex2bin($file['DOC64'])) . '" alt="" ></div><br>';
                                            } else {
                                                echo "<div>Ficheiro Desconhecido: " . $file['DOCCODE'] . " <br> Por favor falar com o remetente</div><br>";
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
    <script src="assets/js/core/jquery-3.7.1.min.js"></script>
    <script src="assets/js/core/popper.min.js"></script>
    <script src="assets/js/core/bootstrap.min.js"></script>

    <!-- jQuery Scrollbar -->
    <script src="assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>

    <!-- Chart JS -->
    <script src="assets/js/plugin/chart.js/chart.min.js"></script>

    <!-- jQuery Sparkline -->
    <script src="assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>

    <!-- Chart Circle -->
    <script src="assets/js/plugin/chart-circle/circles.min.js"></script>

    <!-- Datatables -->
    <script src="assets/js/plugin/datatables/datatables.min.js"></script>

    <!-- Bootstrap Notify -->
    <script src="assets/js/plugin/bootstrap-notify/bootstrap-notify.phpmin.js"></script>

    <!-- jQuery Vector Maps -->
    <script src="assets/js/plugin/jsvectormap/jsvectormap.min.js"></script>
    <script src="assets/js/plugin/jsvectormap/world.js"></script>

    <!-- Sweet Alert
    <script src="assets/js/plugin/sweetalert/sweetalert.min.js"></script>-->

    <!-- Kaiadmin JS -->
    <script src="assets/js/kaiadmin.min.js"></script>

    <!-- Kaiadmin DEMO methods, don't include it in your project!
    <script src="assets/js/setting-demo.js"></script>
    <script src="assets/js/demo.js"></script>-->

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