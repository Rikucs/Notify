<?php

include_once("config/config.php");
include_once("config/tt.php");
include('head.php');
$date = date('d/m/Y');
date_default_timezone_set("Europe/London");

?>


<div class="container">
    <div class="page-inner">
        <ul class="breadcrumbs mb-3">
            <li class="nav-home">
                <a href="../notify/notify.php">
                    <i class="icon-home"></i>
                </a>
            </li>
            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>
            <li class="nav-item">
                <a href="abertos.php">Trouble Tickets</a>
            </li>
            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>
            <li class="nav-item">
                <a href="#">Abertos</a>
            </li>
        </ul>
        <div
            class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
            </div>
            <div class="ms-md-auto py-2 py-md-0">
                <a href="historico.php" class="btn btn-round me-2 btncs">Ver Historico de TTs</a>
                <a href="abrirtt.php" class="btn  btn-round btncs">Abrir um TT</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Abertos</div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <!-- Projects table -->
                            <table class="table align-items-center mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Data</th>
                                        <th scope="col">Urgencia</th>
                                        <th scope="col">Tecnico</th>
                                        <th scope="col">Problema</th>
                                        <th scope="col">Resolução</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($abertos as $row) { ?>
                                        <tr>
                                            <th scope="row"><?= date_format(date_create($row['dataa']), "d/m/Y") ?></th>
                                            <td><?= $row['urg'] ?></td>
                                            <td><?= $row['tecnico'] ?></td>
                                            <td><?= substr($row['problema'], 0, 75) ?></td>
                                            <td><?= substr($row['resolucao'], 0, 50) ?></td>
                                            <td><a href="vertt.php"><i class="fa fa-arrow-right" aria-hidden="true"></i></a></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<footer class="footer">
    <div class="container-fluid d-flex justify-content-between">
        <nav class="pull-left">
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link" href="#"> Help </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"> Licenses </a>
                </li>
            </ul>
        </nav>
        <div class="copyright">
            © D.S.I - 2025 <!--, Feito com <i class="fa fa-heart heart text-danger"></i> por
              <a href="https://www.facebook.com/rafael.silva.737448" target="_blank">Rafael Silva</a> para um melhor gerenciamento de notificações. -->
        </div>
        <div>
            Distribuido por
            <a target="_blank" href="https://themewagon.com/">@NewCoffee</a>.
        </div>
    </div>
</footer>
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
<script src="../assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>

<!-- jQuery Vector Maps -->
<script src="../assets/js/plugin/jsvectormap/jsvectormap.min.js"></script>
<script src="../assets/js/plugin/jsvectormap/world.js"></script>

<!-- Google Maps Plugin -->
<script src="../assets/js/plugin/gmaps/gmaps.js"></script>

<!-- Sweet Alert -->
<script src="../assets/js/plugin/sweetalert/sweetalert.min.js"></script>

<!-- Kaiadmin JS -->
<script src="../assets/js/kaiadmin.min.js"></script>

<!-- Kaiadmin DEMO methods, don't include it in your project! -->
<script src="../assets/js/setting-demo2.js"></script>
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