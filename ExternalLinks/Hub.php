<?php

include_once("config/config.php");
include("config/confighub.php");
include("Header.php");

$colors = [
    1 => '#155f80',
    2 => '#1a2035'
]



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
                <a href="Hub.php">Links</a>
            </li>
        </ul>
        <div
            class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
            </div>
            <!--
            <div class="ms-md-auto py-2 py-md-0">
                <a href="#" class="btn btn-round me-2 btncs">Adicionar </a>
            </div>
            -->
        </div>
        <div class="col-12 col-sm-12 col-lg-12 col-xl-12">
            <div class="row">
                <?php foreach ($links as $l) {
                    $bk = $colors[rand(1, 2)]
                ?>
                    <div class="col-3 col-sm-3 col-lg-3 col-xl-3">
                        <div class="card ani" style="background-color: <?= $bk ?> ; border-radius: 30px;">
                            <div class="card-body">
                                <div class="bodycs">
                                    <button class="btn ani " style="background-color: <?= $bk ?> ;border-radius: 30px;height: 100px; width: 100%;color:#ffffff;"
                                        onclick="window.open('<?= $l['link'] ?>', '_blank')">
                                        <h3>
                                            <span class="btn-label">
                                                <i class="fa fa-link"></i>
                                            </span>
                                            <?= $l['nome'] ?>
                                        </h3>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
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
</div>

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="../assets/js/multiselect-dropdown.js"></script>

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
    var colors = ['#ff0000', '#00ff00', '#0000ff'];
    var random_color = colors[Math.floor(Math.random() * colors.length)];
    document.getElementByClassName('bk').style.backgroundColor = random_color;
</script>

</body>

</html>