<?php
include_once("config/config.php");
include 'config/tables.php';
include 'head.php';

if (isset($_POST["submit"])) {
    if ($_POST['mensagem'] != 0 && $_POST['mensagem'] != ''  && isset($_POST['users']) && $_POST['mensagem'] != '') {


        $tpn = $_POST["tpno"];
        $assunto = $_POST["assunto"];
        $mensagem = $_POST['mensagem'];
        $enviar = $_POST['users'];


        $dt = new DateTime("now", new DateTimeZone('Europe/London'));
        $data = $dt->format('Y-m-d H:i');


        $stmnoti = $conn->prepare("INSERT INTO ntf (tpno, usrno, DATA, assunto, texto, TPCODE)
            VALUES (:msgno,:nome,:datas,:assunto,:texto,:tpcds)  ");

        $stmnoti->execute([
            'msgno' => $tpn,
            'nome' => $uc,
            'datas' => $data,
            'assunto' => $assunto,
            'texto' => $mensagem,
            'tpcds' => $tpn,
        ]);
        $idnoti = $conn->lastInsertId();

        if ($_FILES['files']['name'] && $_FILES['files']['name'][0]) {
            $uploadedfiles = $_FILES['files'];
            foreach ($uploadedfiles['tmp_name'] as $key => $tmp_name) {

                $fileData = bin2hex(file_get_contents($tmp_name)); //base64_encode(file_get_contents($tmp_name));
                $fileName = basename($uploadedfiles['name'][$key]);

                $stmfile = $conn->prepare('INSERT INTO doc (msgno, nome, base64)
                    VALUES (:notiid,:filename,:file)');

                $stmfile->bindParam(':notiid', $idnoti);
                $stmfile->bindParam(':filename', $fileName);
                $stmfile->bindParam(':file', $fileData, \PDO::PARAM_LOB, 0, \PDO::SQLSRV_ENCODING_BINARY);

                $stmfile->execute();
            }
        }
        foreach ($_POST['users'] as $id) {

            $stmdest = $conn->prepare('INSERT INTO dst (msgno, usrno)
                VALUES (:notiid,:iduser)');

            $stmdest->execute([
                'notiid' => $idnoti,
                'iduser' => $id,
            ]);
        }
        $redirect = true;
    }
}


?>
<?php if ($redirect): ?>
    <input type="hidden" id="redirect" value="true">
<?php endif; ?>


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
                    <a href="notify.php">Notify</a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="#">Enviar Mensagem</a>
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

                                        <label for="tpno" Style="color: rgb(106, 120, 135);">Tipo de Notificação</label>
                                        <select
                                            Style="color: rgb(106, 120, 135);"
                                            name="tpno"
                                            id="tpno"
                                            class="form-select">
                                            <?php foreach ($dda as $dd) { ?>
                                                <option value='<?= $dd['tpno'] ?>' Style="color: rgb(106, 120, 135);"><?= $dd['assunto'] ?></option>
                                            <?php } ?>

                                        </select>

                                    </div>
                                    <div class="form-group">
                                        <label for="assunto" Style="color: rgb(106, 120, 135);">Assunto</label>
                                        <input
                                            Style="color: rgb(106, 120, 135);"
                                            type="text"
                                            class="form-control"
                                            id="assunto"
                                            name="assunto" />
                                    </div>
                                    <div class="form-group">
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
                                                $us = $row['nome'] . ' - ' . $row['dir']; ?>
                                                <option value=' <?= $row['usrno'] ?> ' Style="color: rgb(106, 120, 135);"> <?= $us ?></option>';

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
    if (document.getElementById('redirect')) {
        window.location.href = 'enviadas.php';
    }
</script>

</body>

</html>