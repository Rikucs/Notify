<?php
include 'config/tables.php';
include 'head.php';
$login = ucfirst($_SESSION['login']);
$date = date('d/m/Y');
date_default_timezone_set("Europe/London");
$click = false;
?>

            <div class="container">
                <div class="page-inner">
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
                            <a href="#">Notify</a>
                        </li>
                        <li class="separator">
                            <i class="icon-arrow-right"></i>
                        </li>
                        <li class="nav-item">
                            <a href="#">Recebidas</a>
                        </li>
                    </ul>

                    <div
                        class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                        <!-- btncs -->
                        <div class="ms-md-auto py-4 py-md-4 ">
                            <a href="enviadas.php" class="btn btn-round me-2 btncs">Ver mensagens enviadas</a>
                            <a href="form.php" class="btn  btn-round me-2 btncs">Enviar uma mensagem</a>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title">Notificação Recebidas </div>
                                    <div style="text-align: right;"><input type="text" id="search" placeholder="Pesquisar"></div>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <!-- Projects table -->
                                        <table class="table align-items-center mb-0" id="table">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th style="text-align: center;" scope="col">ID</th>
                                                    <th style="text-align: center;" scope="col">data/Hora</th>
                                                    <th style="text-align: center;" scope="col">Remetente</th>
                                                    <th style="text-align: center;" scope="col">Assunto</th>
                                                    <th style="text-align: center;" scope="col">Status</th>
                                                    <th style="text-align: center;" scope="col">data/Hora</th>
                                                    <th style="text-align: center;" scope="col">resposta</th>
                                                    <th style="text-align: center;" scope="col"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($notify as $row) { ?>
                                                    <tr>
                                                        <th style="text-align: center;color: rgb(106, 120, 135);" scope="row"><?= $row['msgno'] ?></th>
                                                        <td style="text-align: center;color: rgb(106, 120, 135);"><?php $dn = new datetime($row['data']);
                                                                                                                    echo $dn->format('d-m-Y H:i'); ?></td>
                                                        <td style="text-align: center;color: rgb(106, 120, 135);"><?= $row['nome'] ?></td>
                                                        <td style="text-align: center;color: rgb(106, 120, 135);"><?= $row['assunto'] ?></td>
                                                        <?php if ($row['status'] == 1) { ?>
                                                            <td style="text-align: center;"><img src="../assets/img/respondido.jpg" width="40" height="40"></td>
                                                        <?php } elseif ($row['status'] == 0) { ?>
                                                            <td style="text-align: center;"><img src="../assets/img/naorespondido.jpg" width="40" height="40"></td>
                                                        <?php } else { ?>
                                                            <td style="text-align: center;"><img src="../assets/img/lido.jpg" width="40" height="40"></td>
                                                        <?php } ?>
                                                        <td style="text-align: center;color: rgb(106, 120, 135);"><?php $dn = new datetime($row['data']);
                                                                                                                    echo $dn->format('d-m-Y H:i'); ?></td>
                                                        <?php if ($row['status'] > 1) { ?>
                                                            <td style="text-align: center;color: rgb(106, 120, 135);">Lida</td>
                                                        <?php } else { ?>
                                                            <td style="text-align: center;color: rgb(106, 120, 135);"><?= $row['rspt'] ?></td>
                                                        <?php } ?>
                                                        <td style="text-align: center;"><a href="ver.php?noti=<?= $row['msgno'] ?>"><i class="fa fa-arrow-right" aria-hidden="true"></i></a></td>
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

    <!-- datatables -->
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
        var $rows = $('#table tr');
        $('#search').keyup(function() {
            var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();
            
            $rows.show().filter(function() {
                var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
                return !~text.indexOf(val);
            }).hide();
        });
    </script>


</body>

</html>