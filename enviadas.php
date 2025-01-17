<?php
include 'config/tables.php';

$ijs = 0;



?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title> Notify </title>
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
    <style>
        .show-more {
            display: none;
        }

        .aling {
            text-align: center;
        }
    </style>
    <!-- CSS Files -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/plugins.min.css" />
    <link rel="stylesheet" href="assets/css/kaiadmin.min.css" />
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <link rel="stylesheet" href="assets/css/custom.css" />
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
                                    <span class="notification" id="notification-count"></span>
                                </a>
                                <ul
                                    class="dropdown-menu notif-box animated fadeIn"
                                    aria-labelledby="notifDropdown">
                                    <li>
                                        <div class="dropdown-title">
                                           Tem <span id="notification-count-text"> </span> notificações novas
                                        </div>
                                    </li>
                                    <li>
                                        <div class="notif-scroll scrollbar-outer">
                                            <div class="notif-center">
                                            <?php foreach ($nosino as $sino ){ ?>
                                                <a href="ver.php?noti=<?= $sino['NOSTAMP'] ?>">
                                                    <div class="notif-img">
                                                        <img
                                                                src="assets/img/kaiadmin/favicon.png"
                                                                alt="Img Profile"
                                                        />
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
                    <div
                        class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                        <div>
                        </div>
                        <div class="ms-md-auto py-2 py-md-0">
                            <a href="notify.php" class="btn btn-round me-2 btncs">Ver mensagens recebidas</a>
                            <a href="form.php" class="btn  btn-round btncs">Enviar uma mensagem</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title"> Notificações enviadas</div>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <!-- Projects table -->
                                        <table class="table align-items-center mb-0">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th style="text-align: center;">ID</th>
                                                    <th style="text-align: center;">Data/Hora</th>
                                                    <th style="text-align: center;">Assunto</th>
                                                    <th style="text-align: center;">Status</th>
                                                    <th style="text-align: center;"></th>
                                                    <th style="text-align: center;">Destinatario</th>
                                                    <th style="text-align: center;">Data/Hora</th>
                                                    <th style="text-align: center;">Resposta</th>
                                                    <th style="text-align: center;"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($enviadas as $row) { 
                                                        $ijs +=1;    
                                                ?>
                                                    <tr>
                                                        <?php
                                                        $query ="select nostamp, usrcode ,
                                                                iif(data<>'19000101',convert(varchar,data,104),iif(ldata <> '19000101',convert(varchar,ldata,104),'')) data ,
                                                                iif(data<>'19000101',resp,iif(ldata <> '19000101','Lida','Não lida')) resposta  
                                                                from destinatarios (nolock) a join utilizadores (nolock) c on c.USRNO=a.usrstamp -- receiver
                                                                where nostamp='" . $row['notino'] . "'";

                                                        $dest = $conn->query($query)->fetchAll();
                                                        ?>
                                                        <th scope="row" style="text-align: center;"><?php echo $row['notino'] ?></th>
                                                        <td style="text-align: center; vertical-align:top;"><?php $dn = new datetime($row['data']);
                                                                                                            echo $dn->format('d-m-Y H:i'); ?></td>
                                                        <td style="text-align: center; vertical-align:top;"><?php echo $row['head'] ?></th>
                                                            <form method="post">
                                                                <?php if (isset($dest) && count($dest) > 1) { ?>
                                                                    <?php if ($row['status'] == 0) { ?>
                                                        <td class="show-more-button" data-img-id="img<?= $ijs ?>" style="text-align: center;"><img id="img<?= $ijs ?>" src="assets/img/mnr.jpg" width="40" height="40"></td>
                                                    <?php } elseif ($row['status'] == 1) { ?>
                                                        <td class="show-more-button" data-img-id="img<?= $ijs ?>" style="text-align: center;"><img id="img<?= $ijs ?>" src="assets/img/mr.jpg" width="40" height="40"></td>
                                                    <?php } elseif ($row['status'] > 1) { ?>
                                                        <td class="show-more-button" data-img-id="img<?= $ijs ?>" style="text-align: center;"><img id="img<?= $ijs ?>" src="assets/img/ml.jpg" width="40" height="40"></td>
                                                    <?php } ?>
                                                <?php } else { ?>
                                                    <?php if ($row['status'] == 0) { ?>
                                                        <td style="text-align: center;"><img src="assets/img/respondido.jpg" width="40" height="40"></td>
                                                    <?php } elseif ($row['status'] == 1) { ?>
                                                        <td style="text-align: center;"><img src="assets/img/naorespondido.jpg" width="40" height="40"></td>
                                                    <?php } elseif ($row['status'] > 1) { ?>
                                                        <td style="text-align: center;"><img src="assets/img/lido.jpg" width="40" height="40"></td>
                                                    <?php } ?>
                                                <?php } ?>
                                                </form>
                                                <?php if ($row['clip'] > 0) { ?>
                                                    <td style="text-align: center;"><img
                                                        src="assets/img/clip2.png"
                                                        width="40" height="40">
                                                    </td>
                                                <?php } else { ?>
                                                    <td style="text-align: center;"></td>
                                                <?php } ?>
                                                <?php
                                                    if (count($dest) > 1) {
                                                ?>

                                                    <td class="show-less" style="text-align: center;">--------------------------------------------------</td>
                                                    <td class="show-less" style="text-align: center;">---------------</td>
                                                    <td class="show-less" style="text-align: center;">----</td>
                                                    <td class="show-more" style="text-align: center;"><?php foreach ($dest as $e) {
                                                                                                            echo $e['usrcode'];
                                                                                                            echo '<br>';
                                                                                                        } ?> </td>
                                                    <td class="show-more" style="text-align: center;"><?php foreach ($dest as $e) {
                                                                                                            $f = new datetime($e['data']);
                                                                                                            if ($f->format('d-m-Y H:i') == '01-01-1900 00:00') echo ' ';
                                                                                                            else echo $f->format('d-m-Y H:i');
                                                                                                            echo "<br>";
                                                                                                        } ?> </td>
                                                    <td class="show-more" style="text-align: center;"><?php foreach ($dest as $e) {
                                                                                                            echo $e['resposta'];
                                                                                                            echo "<br>";
                                                                                                        } ?></td>

                                                <?php } else { ?>
                                                    <?php foreach ($dest as $g) { ?>
                                                        <td style="text-align: center;"><?php echo $g['usrcode']; ?>


                                                        <td style="text-align: center;"><?php $f = new datetime($g['data']);
                                                                                        if ($f->format('d-m-Y H:i') == '01-01-1900 00:00') echo ' ';
                                                                                        else echo $f->format('d-m-Y H:i'); ?> </td>
                                                        <td style="text-align: center;"><?php echo $g['resposta']; ?> </td>
                                                    <?php } ?>
                                                <?php } ?>
                                                    <td><a href="ver.php?noti=<?= $row['notino'] ?>"><i class="fa fa-arrow-right" aria-hidden="true"></i></a></td>
                                                    </tr>
                                                <?php  } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
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
    <script src="assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>

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

    <script>
        function toggleIconClass2() {
            $(document).on("click", ".show-more-button", function() {
                var iconId = $(this).data('icon');
                var icon = document.getElementById(iconId);
                if (icon.classList.contains('fa-plus-circle')) {
                    icon.classList.replace('fa-plus-circle', 'fa-minus-circle');
                } else if (icon.classList.contains('fa-minus-circle')) {
                    icon.classList.replace('fa-minus-circle', 'fa-plus-circle');
                }
            });
        }

        function toggleIconClass() {
            var icon = document.getElementById('icon');
            if (icon.classList.contains('fa-plus-circle')) {
                icon.classList.replace('fa-plus-circle', 'fa-minus-circle');
            } else if (icon.classList.contains('fa-minus-circle')) {
                icon.classList.replace('fa-minus-circle', 'fa-plus-circle');
            }
        }

        function myFunction() {
            if (document.getElementById('icon').classList.contains('fa-plus-circle')) {
                return true;
            } else {
                return false;
            }
        }

        $(document).on("click", ".show-more-button", function() {
            var imgid = $(this).data('img-id');
            var img = document.getElementById(imgid)
            var imgsrc = img.getAttribute('src');
            if (imgsrc == 'assets/img/mnr.jpg') {
                img.setAttribute('src', 'assets/img/lnr.jpg');
                $(this).closest('tr').children(".show-more").css('display', 'table-cell');
                $(this).closest('tr').children(".show-less").css('display', 'none');
            }
            if (imgsrc == 'assets/img/ml.jpg') {
                img.setAttribute('src', 'assets/img/ll.jpg');
                $(this).closest('tr').children(".show-more").css('display', 'table-cell');
                $(this).closest('tr').children(".show-less").css('display', 'none');
            } 
            if (imgsrc == 'assets/img/mr.jpg') {
                img.setAttribute('src', 'assets/img/lr.jpg');
                $(this).closest('tr').children(".show-more").css('display', 'table-cell');
                $(this).closest('tr').children(".show-less").css('display', 'none');
            } 
            if (imgsrc == 'assets/img/lnr.jpg') {
                iimg.setAttribute('src', 'assets/img/mnr.jpg');
                $(this).closest('tr').children(".show-more").css('display', 'none');
                $(this).closest('tr').children(".show-less").css('display', 'table-cell');
            } 
            if (imgsrc == 'assets/img/ll.jpg') {
                img.setAttribute('src', 'assets/img/ml.jpg');
                $(this).closest('tr').children(".show-more").css('display', 'none');
                $(this).closest('tr').children(".show-less").css('display', 'table-cell');
            } 
            if (imgsrc == 'assets/img/lr.jpg') {
                img.setAttribute('src', 'assets/img/mr.jpg');
                $(this).closest('tr').children(".show-more").css('display', 'none');
                $(this).closest('tr').children(".show-less").css('display', 'table-cell');
            }  
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