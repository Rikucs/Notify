<?php
include 'config/tables.php';
include 'head.php';

$ijs = 0;



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
                <a href="notify.php">Notify</a>
            </li>
            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>
            <li class="nav-item">
                <a href="#">Enviadas</a>
            </li>
        </ul>
        <div
            class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
            </div>
            <div class="ms-md-auto py-2 py-md-0">
                <a href="notify.php" class="btn btn-round me-2 btncs">Ver notificações recebidas</a>
                <a href="form.php" class="btn  btn-round btncs">Enviar uma notificação</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title"> Notificações Enviadas</div>
                        <div style="text-align: right;"><input type="text" id="search" placeholder="Pesquisar"></div>

                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <!-- Projects table -->
                            <table class="table align-items-center mb-0" id="table">
                                <thead class="thead-light">
                                    <tr>
                                        <th style="text-align: center;">ID</th>
                                        <th style="text-align: center;">Data/Hora</th>
                                        <th style="text-align: center;">Assunto</th>
                                        <th style="text-align: center;">Status</th>
                                        <th style="text-align: center;">Destinatario</th>
                                        <th style="text-align: center;">Data/Hora</th>
                                        <th style="text-align: center;">Resposta</th>
                                        <th style="text-align: center;"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($enviadas as $row) {
                                        $ijs += 1;
                                    ?>
                                        <tr>
                                            <?php
                                            $query = "select msgno, nome ,
                                                                iif(data<>'19000101',convert(varchar,data,104),iif(lida <> '19000101',convert(varchar,lida,104),'')) Data ,
                                                                iif(data<>'19000101',rspt,iif(lida <> '19000101','Lida','Não lida')) resposta  
                                                                from dst (nolock) a join us (nolock) c on c.USRNO=a.usrno -- receiver
                                                                where msgno='" . $row['msgno'] . "'";

                                            $dest = $conn->query($query)->fetchAll();
                                            ?>
                                            <th scope="row" style="text-align: center;color: rgb(106, 120, 135);"><?php echo $row['msgno'] ?></th>
                                            <td style="text-align: center; vertical-align:top;color: rgb(106, 120, 135);"><?php $dn = new datetime($row['data']);
                                                                                                                            echo $dn->format('d-m-Y H:i'); ?></td>
                                            <td style="text-align: center; vertical-align:top;color: rgb(106, 120, 135);"><?php echo $row['assunto'] ?></th>
                                                <form method="post">
                                                    <?php if (isset($dest) && count($dest) > 1) { ?>
                                                        <?php if ($row['status'] == 0) { ?>
                                            <td class="show-more-button" data-img-id="img<?= $ijs ?>" style="text-align: center;"><img id="img<?= $ijs ?>" src="../assets/img/mnr.jpg" width="40" height="40"></td>
                                        <?php } elseif ($row['status'] == 1) { ?>
                                            <td class="show-more-button" data-img-id="img<?= $ijs ?>" style="text-align: center;"><img id="img<?= $ijs ?>" src="../assets/img/mr.jpg" width="40" height="40"></td>
                                        <?php } elseif ($row['status'] > 1) { ?>
                                            <td class="show-more-button" data-img-id="img<?= $ijs ?>" style="text-align: center;"><img id="img<?= $ijs ?>" src="../assets/img/ml.jpg" width="40" height="40"></td>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <?php if ($row['status'] == 0) { ?>
                                            <td style="text-align: center;"><img src="../assets/img/naorespondido.jpg" width="40" height="40"></td>
                                        <?php } elseif ($row['status'] == 1) { ?>
                                            <td style="text-align: center;"><img src="../assets/img/respondido.jpg" width="40" height="40"></td>
                                        <?php } elseif ($row['status'] > 1) { ?>
                                            <td style="text-align: center;"><img src="../assets/img/lido.jpg" width="40" height="40"></td>
                                        <?php } ?>
                                    <?php } ?>
                                    </form>
                                    <?php
                                        if (count($dest) > 1) {
                                    ?>

                                        <td class="show-less" style="text-align: center;color: rgb(106, 120, 135);">--------------------------------------------------</td>
                                        <td class="show-less" style="text-align: center;color: rgb(106, 120, 135);">---------------</td>
                                        <td class="show-less" style="text-align: center;color: rgb(106, 120, 135);">----</td>
                                        <td class="show-more" style="text-align: center;color: rgb(106, 120, 135);"><?php foreach ($dest as $e) {
                                                                                                                        echo $e['nome'];
                                                                                                                        echo '<br>';
                                                                                                                    } ?> </td>
                                        <td class="show-more" style="text-align: center;color: rgb(106, 120, 135);"><?php foreach ($dest as $e) {
                                                                                                                        echo $e['Data'];
                                                                                                                        echo '<br>';
                                                                                                                    } ?> </td>
                                        <td class="show-more" style="text-align: center;color: rgb(106, 120, 135);"><?php foreach ($dest as $e) {
                                                                                                                        echo $e['resposta'];
                                                                                                                        echo "<br>";
                                                                                                                    } ?></td>

                                    <?php } else { ?>
                                        <?php foreach ($dest as $g) { ?>
                                            <td style="text-align: center;color: rgb(106, 120, 135);"><?= $g['nome']; ?>


                                            <td style="text-align: center;color: rgb(106, 120, 135);"><?= $g['Data'] ?></td>
                                            <td style="text-align: center;color: rgb(106, 120, 135);"><?= $g['resposta']; ?> </td>
                                        <?php } ?>
                                    <?php } ?>
                                    <td><a href="ver.php?noti=<?= $row['msgno'] ?>"><i class="fa fa-arrow-right" aria-hidden="true"></i></a></td>
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

<!-- Sweet Alert
    <script src="../assets/js/plugin/sweetalert/sweetalert.min.js"></script>-->

<!-- Kaiadmin JS -->
<script src="../assets/js/kaiadmin.min.js"></script>

<!-- Kaiadmin DEMO methods, don't include it in your project!
    <script src="../assets/js/setting-demo.js"></script>
    <script src="../assets/js/demo.js"></script>-->

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
        if (imgsrc == '../assets/img/mnr.jpg') {
            img.setAttribute('src', '../assets/img/lnr.jpg');
            $(this).closest('tr').children(".show-more").css('display', 'table-cell');
            $(this).closest('tr').children(".show-less").css('display', 'none');
        }
        if (imgsrc == '../assets/img/ml.jpg') {
            img.setAttribute('src', '../assets/img/ll.jpg');
            $(this).closest('tr').children(".show-more").css('display', 'table-cell');
            $(this).closest('tr').children(".show-less").css('display', 'none');
        }
        if (imgsrc == '../assets/img/mr.jpg') {
            img.setAttribute('src', '../assets/img/lr.jpg');
            $(this).closest('tr').children(".show-more").css('display', 'table-cell');
            $(this).closest('tr').children(".show-less").css('display', 'none');
        }
        if (imgsrc == '../assets/img/lnr.jpg') {
            img.setAttribute('src', '../assets/img/mnr.jpg');
            $(this).closest('tr').children(".show-more").css('display', 'none');
            $(this).closest('tr').children(".show-less").css('display', 'table-cell');
        }
        if (imgsrc == '../assets/img/ll.jpg') {
            img.setAttribute('src', '../assets/img/ml.jpg');
            $(this).closest('tr').children(".show-more").css('display', 'none');
            $(this).closest('tr').children(".show-less").css('display', 'table-cell');
        }
        if (imgsrc == '../assets/img/lr.jpg') {
            img.setAttribute('src', '../assets/img/mr.jpg');
            $(this).closest('tr').children(".show-more").css('display', 'none');
            $(this).closest('tr').children(".show-less").css('display', 'table-cell');
        }
    });
</script>

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