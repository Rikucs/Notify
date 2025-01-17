<?php
include_once("config/config.php");
include 'config/tables.php';

if (!isset ($_SESSION['login'])) {
    header('Location: login/index.php');
}

if (isset($_POST["submit"])) {
    if ($_POST['mensagem'] != 0 && $_POST['mensagem'] != ''  && isset($_POST['users'] ) && $_POST['mensagem'] != '') {


        $tpn = $_POST["tpno"];
        $assunto = $_POST["assunto"];
        $mensagem = $_POST['mensagem'];
        $enviar = $_POST['users'];


        $dt = new DateTime("now", new DateTimeZone('Europe/London'));
        $data = $dt->format('Y-m-d H:i:s');


        $stmnoti = $conn->prepare("INSERT INTO Notificacoes (TPSTAMP, USRSTAMP, DATA, HEAD, BODY, TPCODE)
            VALUES (:TPSTAMP,:usrcode,:datas,:head,:body,:tpcds)  ");

        $stmnoti->execute([
            'TPSTAMP' => $tpn,
            'usrcode' => $uc,
            'datas' => $data,
            'head' => $assunto,
            'body' => $mensagem,
            'tpcds' => $tpn,
        ]);
        $idnoti = $conn->lastInsertId();

        if ($_FILES['files']['name'] && $_FILES['files']['name'][0]) {
            $uploadedfiles = $_FILES['files'];
            foreach ($uploadedfiles['tmp_name'] as $key => $tmp_name) {

                $fileData = bin2hex(file_get_contents($tmp_name)); //base64_encode(file_get_contents($tmp_name));
                $fileName = basename($uploadedfiles['name'][$key]);

                $stmfile = $conn->prepare('INSERT INTO Documentos (NOSTAMP, DOCCODE, DOC64)
                    VALUES (:notiid,:filename,:file)');

                $stmfile->bindParam(':notiid', $idnoti);
                $stmfile->bindParam(':filename', $fileName);
                $stmfile->bindParam(':file', $fileData, \PDO::PARAM_LOB, 0, \PDO::SQLSRV_ENCODING_BINARY);

                $stmfile->execute();
            }
        }
        foreach ($_POST['users'] as $id) {

            $stmdest = $conn->prepare('INSERT INTO Destinatarios (NOSTAMP, USRSTAMP)
                VALUES (:notiid,:iduser)');

            $stmdest->execute([
                'notiid' => $idnoti,
                'iduser' => $id,
            ]);
        }
        header("location:enviadas.php");
    }
}


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

    <!-- CSS Files -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/plugins.min.css" />
    <link rel="stylesheet" href="assets/css/kaiadmin.min.css" />

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="assets/css/demo.css" />
    <script src="assets/js/multiselect-dropdown.js"></script>
    <style>
        .box {
            background-color: white;
            outline: 2px dashed black;
            height: 200px;
        }

        .box.is-dragover {
            background-color: grey;
        }

        .box {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .box label strong {
            text-decoration: underline;
            color: blue;
            cursor: pointer;
        }

        .box label strong:hover {
            color: blueviolet
        }

        .box input {
            display: none;
        }
    </style>
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
                            src="assets/img/kaiadmin/NC.png"
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
                                    <li>
                                        <a href="fassunto.php">
                                            <span class="sub-item">Adicionar Assunto</span>
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
                                    <span class="notification"><?= $ns ?></span>
                                </a>
                                <ul
                                    class="dropdown-menu notif-box animated fadeIn"
                                    aria-labelledby="notifDropdown">
                                    <li>
                                        <div class="dropdown-title">
                                            Tem <span><?= $ns ?></span> Notificaçoes Novas
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
                                                            <span class="block"> NewCoffee - Notify </span>
                                                            <span class="time">Nova Notificação de <?= $sino["usercode"] ?></span>
                                                        </div>
                                                    </a>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <a class="see-all" href="javascript:void(0);">Ver todas as notificações <i class="fa fa-angle-right"></i>
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
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="notify.php">Enviadas</a>
                                            <a class="dropdown-item" href="recebidas.php">Recebidas</a>
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
                    <div class="page-header">
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
                                <a href="form.php">Notify</a>
                            </li>
                            <li class="separator">
                                <i class="icon-arrow-right"></i>
                            </li>
                            <li class="nav-item">
                                <a href="form.php">Enviar Mensagem</a>
                            </li>
                        </ul>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title">Enviar Mensagens</div>
                                </div>
                                <form action="form.php" method="post" enctype="multipart/form-data">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 col-lg-6">
                                                <div class="form-group">

                                                    <label for="tpn" Style="color: rgb(106, 120, 135);">Tipo de Notificação</label>
                                                    <select
                                                        Style="color: rgb(106, 120, 135);"
                                                        name="tpno"
                                                        id="tpn"
                                                        class="form-select">
                                                        <?php foreach ($dda as $dd) { ?>
                                                            <option value='<?= $dd['TPNO'] ?>' Style="color: rgb(106, 120, 135);"><?= $dd['HEAD'] ?></option>
                                                        <?php } ?>

                                                    </select>

                                                </div>
                                                <div class="form-group" >
                                                    <label for="assunto" Style="color: rgb(106, 120, 135);">Assunto</label>
                                                    <input
                                                        Style="color: rgb(106, 120, 135);"
                                                        type="text"
                                                        class="form-control"
                                                        id="assunto"
                                                        name="assunto" />
                                                </div>
                                                <div class="form-group" >
                                                    <label for="mensagem" Style="color: rgb(106, 120, 135);">Texto</label>
                                                    <textarea name="mensagem" class="form-control" id="mensagem" rows="7" Style="color: rgb(106, 120, 135);"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-6">
                                                <div class="form-group">
                                                    <label for="multiselect" Style="color: rgb(106, 120, 135);">Destinatários</label>
                                                    <select name="users[]"
                                                        id="multiselect"
                                                        class="form-control"
                                                        size="10"
                                                        multiple="multiple"
                                                        multiselect-search="true"
                                                        multiselect-select-all="true"
                                                        required>
                                                        <?php foreach ($user as $row) {
                                                            $us = $row['USRCODE'] . ' - ' . $row['USRGP'] . ' - ' . $row['USRAR'] . ' - ' . $row['USRDIR']; ?>
                                                            <option value=' <?= $row['USRNO'] ?> ' Style="color: rgb(106, 120, 135);"> <?= $us ?></option>';

                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <br>
                                                <br>
                                                <br>
                                                <br>
                                                <div class="box">
                                                    <label>
                                                        <span Style="color: rgb(106, 120, 135);">Faça drag & drop de um ou mais ficheiros simultaneamente ou escolha os seus ficheiros</span>
                                                        <strong>Aqui</strong>
                                                        <input class="box__file" type="file" name="files[]" multiple>
                                                    </label>
                                                    <div class="file-list"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-action" style="text-align:right">
                                        <button type="submit" name="submit" class="btn" style="background-color: #b4e8a0;">Enviar</button>
                                        <button class="btn" style="background-color: #f59b99">Cancelar</button>
                                    </div>
                                </form>
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

    <!-- Google Maps Plugin -->
    <script src="assets/js/plugin/gmaps/gmaps.js"></script>

    <!-- Sweet Alert -->
    <script src="assets/js/plugin/sweetalert/sweetalert.min.js"></script>

    <!-- Kaiadmin JS -->
    <script src="assets/js/kaiadmin.min.js"></script>

    <!-- Kaiadmin DEMO methods, don't include it in your project! -->
    <script src="assets/js/setting-demo2.js"></script>
    <script>
        window.onmousedown = function(e) {
            var el = e.target;
            if (el.tagName.toLowerCase() == 'option' && el.parentNode.hasAttribute('multiple')) {
                e.preventDefault();

                // toggle selection
                if (el.hasAttribute('selected')) el.removeAttribute('selected');
                else el.setAttribute('selected');

                // hack to correct buggy behavior
                var select = el.parentNode.cloneNode(true);
                el.parentNode.parentNode.replaceChild(select, el.parentNode);
            }
        }
    </script>

    <script>
        const box = document.querySelector('.box');
        const fileInput = document.querySelector('[name="files[]"');
        const selectButton = document.querySelector('label strong');
        const fileList = document.querySelector('.file-list');

        let droppedFiles = [];

        ['drag', 'dragstart', 'dragend', 'dragover', 'dragenter', 'dragleave', 'drop'].forEach(event => box.addEventListener(event, function(e) {
            e.preventDefault();
            e.stopPropagation();
        }), false);

        ['dragover', 'dragenter'].forEach(event => box.addEventListener(event, function(e) {
            box.classList.add('is-dragover');
        }), false);

        ['dragleave', 'dragend', 'drop'].forEach(event => box.addEventListener(event, function(e) {
            box.classList.remove('is-dragover');
        }), false);

        box.addEventListener('drop', function(e) {
            droppedFiles = e.dataTransfer.files;
            fileInput.files = droppedFiles;
            updateFileList();
        }, false);

        fileInput.addEventListener('change', updateFileList);

        function updateFileList() {
            const filesArray = Array.from(fileInput.files);
            if (filesArray.length > 1) {
                fileList.innerHTML = '<p>Ficheiros Selecionados:</p><ul><li>' + filesArray.map(f => f.name).join('</li><li>') + '</li></ul>';
            } else if (filesArray.length == 1) {
                fileList.innerHTML = `<p>Ficheiro Selecionados: ${filesArray[0].name}</p>`;
            } else {
                fileList.innerHTML = '';
            }
        }
    </script>





</body>

</html>