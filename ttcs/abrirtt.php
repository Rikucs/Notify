<?php
include_once("config/config.php");
include 'config/tables.php';
include 'head.php';

if (!isset($_SESSION['login'])) {
    header('Location: ../index.php');
}

if (isset($_POST["submit"])) {
    if ($_POST['problema'] != 0 && $_POST['problema'] != ''  && isset($_POST['tppr']) && $_POST['causa'] != '') {


        $tpproblema = $_POST["tppr"];
        $problema = $_POST["problema"];
        $causa = $_POST['causa'];

        $dt = new DateTime("now", new DateTimeZone('Europe/London'));
        $data = $dt->format('Y-m-d H:i:s');
        $hora = $dt->format('H:i:s');

        $stmnoti = $conn->prepare("INSERT INTO u_tt (u_ttstamp, dataa, DATA, HEAD, BODY, TPCODE)
            VALUES ((right(newid(),12) + left(newid(),8) +right(newid(),5)),:TPSTAMP,:usrcode,:datas,:head,:body,:tpcds)  ");

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
                    <a href="abertos.php">Trouble Tickets</a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="#">Abrir TT</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Abrir Ticket</div>
                    </div>
                    <form action="form.php" method="post" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">

                                        <label for="tppr" Style="color: rgb(106, 120, 135);">Tipo de Problema</label>
                                        <select
                                            Style="color: rgb(106, 120, 135);"
                                            name="tppr"
                                            id="tppr"
                                            class="form-select">
                                            <option value='E-Mail' Style="color: rgb(106, 120, 135);">E-Mail</option>
                                            <option value='Gesfrota' Style="color: rgb(106, 120, 135);">Gesfrota</option>
                                            <option value='Impressora' Style="color: rgb(106, 120, 135);">Impressora</option>
                                            <option value='Internet' Style="color: rgb(106, 120, 135);">Internet</option>
                                            <option value='Manutenção de Ativos' Style="color: rgb(106, 120, 135);">Manutenção de Ativos</option>
                                            <option value='Manutenção de Software' Style="color: rgb(106, 120, 135);">Manutenção de Software</option>
                                            <option value='MSS' Style="color: rgb(106, 120, 135);">MSS</option>
                                        </select>

                                    </div>

                                    <div class="form-group">
                                        <label for="problema" Style="color: rgb(106, 120, 135);">Problema</label>
                                        <textarea name="problema" class="form-control" id="problema" rows="7" Style="color: rgb(106, 120, 135);"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="causa" Style="color: rgb(106, 120, 135);">Tipo de Problema</label>
                                        <select
                                            Style="color: rgb(106, 120, 135);"
                                            name="causa"
                                            id="causa"
                                            class="form-select">
                                            <option value='Hardware' Style="color: rgb(106, 120, 135);">Hardware</option>
                                            <option value='Melhoria Continua' Style="color: rgb(106, 120, 135);">Melhoria Continua</option>
                                            <option value='Retrabalho' Style="color: rgb(106, 120, 135);">Retrabalho</option>
                                            <option value='Software de Terceiros' Style="color: rgb(106, 120, 135);">Software de Terceiros</option>
                                            <option value='Suporte ao Utilizador' Style="color: rgb(106, 120, 135);">Suporte ao Utilizador</option>
                                            <option value='Outros' Style="color: rgb(106, 120, 135);">Outros</option>
                                        </select>

                                    </div>

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