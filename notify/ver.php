<?php
include 'config/display.php';
include 'head.php';


$auz = 0;


?>


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
            <div class="col-4 col-sm-4 col-lg-4">
                <div class="card">
                    <div class="card-header" style="background-color: #D3e7fb; text-align: center">
                        <div class="headcs">Data/Hora</div>
                    </div>
                    <div class="card-body">
                        <div class="bodycs"> <?= $data ?> </div>
                    </div>
                </div>
            </div>
            <div class="col-4 col-sm-4 col-lg-4">
                <div class="card">
                    <div class="card-header" style="background-color: #D3e7fb; text-align: center">
                        <div class="headcs">Remetente</div>
                    </div>
                    <div class="card-body">
                        <div class="bodycs"> <?= $remetente ?> </div>
                    </div>
                </div>
            </div>
            <div class="col-4 col-sm-4 col-lg-4">
                <div class="card">
                    <div class="card-header" style="background-color: #D3e7fb; text-align: center">
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
                    <div class="card-header" style="background-color: #D3e7fb; text-align: center">
                        <div class="headcs">Notificação</div>
                    </div>
                    <div class="card-body">
                        <div class="bodycs" style=" text-align: justify">
                            <?= $notificacao ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php

        $query = "select * from dst where msgno='" . $noti . "' and usrno='" . $uc . "' ";
        $e = $conn->query($query)->fetchAll();
        foreach ($e as $z) {
            $auz += 1;
        }
        if ($auz != 0) {
        ?>
            <form action="config/verbtn.php?noti=<?= $noti ?>" method="post">
                <?php if ($resbtn == 1) { ?>
                    <?php if ($tpa == 2) { ?>
                        <div class="row">
                            <div class="col-3 col-sm-0 col-lg-3"></div>
                            <div class="col-3 col-sm-0 col-lg-3"></div>
                            <div class="col-3 col-sm-0 col-lg-3">
                                <div class="card">
                                    <button style="padding: 0;border: none;background: none;" name="submits">
                                        <div class="card-header" style="background-color: #b4e8a0; text-align: center">
                                            <div class="headcs"><?= $sim ?></div>
                                        </div>
                                    </button>
                                </div>
                            </div>
                            <div class="col-3 col-sm-3 col-lg-3">
                                <div class="card">
                                    <button style="padding: 0;border: none;background: none;" name="submitn">
                                        <div class="card-header" style="background-color: #f59b99; text-align: center">
                                            <div class="headcs"><?= $nao ?></div>
                                        </div>
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="row">
                            <div class="col-4 col-sm-0 col-lg-4"></div>
                            <div class="col-4 col-sm-0 col-lg-4"></div>
                            <div class="col-4 col-sm-0 col-lg-4">
                                <div class="card">
                                    <button style="padding: 0;border: none;background: none;" name="submitok">
                                        <div class="card-header" style="background-color: #b4e8a0; text-align: center">
                                            <div class="headcs"><?= $ok ?></div>
                                        </div>
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>
            </form>
        <?php } ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="background-color: #D3e7fb; text-align: center">

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
                                            <td><b><?= $d['nome'] ?></b></td>
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
                                     #D3e7fb -->
                    <div class="card-header" style="background-color:#D3e7fb; text-align: center">
                        <div class="headcs">Documentos</div>
                    </div>
                    <div class="card-body">
                        <?php

                        if (!empty($files)) {
                            foreach ($files as $file) {
                                $fileExtension = pathinfo($file['nome'], PATHINFO_EXTENSION);
                                if ($fileExtension == 'pdf') {
                                    $fileName = $file['nome'];
                                    $fileData = hex2bin($file['base64']);
                                    $tmpFilePath = '../temp/' . $fileName;
                                    file_put_contents($tmpFilePath, $fileData);
                                    echo 'Use CTRL + Scroll para aumentar ou diminuir o zoom<br>';
                                    echo '<iframe
                                                    src="' . $tmpFilePath . '#toolbar=0&navpanes=0&scrollbar=0"
                                                    frameBorder="0"
                                                    scrolling="auto"
                                                    height="750px"
                                                    width="100%"
                                                    ></iframe>';
                                    //echo '<div><a href="pdf.php?noti='.$file['DOCNO'].'" target="_blank">Abrir ' . $file["nome"] . '</a></div><br>';
                                } elseif (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif'])) {
                                    echo '<hr class="rounded">';
                                    echo '<div style="text-align: center"><img src="data:image/' . $fileExtension . ';base64,' . base64_encode(hex2bin($file['base64'])) . '" alt="" ></div><br>';
                                    echo '<hr class="rounded">';
                                } else {
                                    echo '<hr class="rounded">';
                                    echo "<div>Ficheiro Desconhecido: " . $file['nome'] . " <br> Por favor falar com o remetente</div><br>";
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
            <a target="_blank" href="https://www.newcoffee.pt/pt/">@NewCoffee</a>.
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
<script src="../assets/js/plugin/bootstrap-notify/bootstrap-notify.phpmin.js"></script>

<!-- jQuery Vector Maps -->
<script src="../assets/js/plugin/jsvectormap/jsvectormap.min.js"></script>
<script src="../assets/js/plugin/jsvectormap/world.js"></script>

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