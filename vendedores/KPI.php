<?php

include_once("config/config.php");
include_once("config/vendor.php");
include("config/kpi.php");
include("config/kpinc.php");
include("Header.php");

$months = [
    1 => 'Janeiro',
    2 => 'Fevereiro',
    3 => 'Março',
    4 => 'Abril',
    5 => 'Maio',
    6 => 'Junho',
    7 => 'Julho',
    8 => 'Agosto',
    9 => 'Setembro',
    10 => 'Outubro',
    11 => 'Novembro',
    12 => 'Dezembro'
];

$auxccvencida = 0;
$auxccaberta = 0;
$auxcrvvl = 0;
$auxcrvcom = 0;
$auxcrv = 0;
$auxmft = 0;
$auxmobj = 0;
$auxaft = 0;
$auxaobj = 0;
$auxn1ft = 0;
$auxn1obj = 0;
$auxkft = 0;
$auxn1kft = 0;

foreach ($Vft as $mft) {
    if ($mft['Ano'] == $y and $mft['Mes'] == $m) {
        $auxmft += $mft['Valor'];
        $auxkft += $mft['Volume'];
    }
}
foreach ($Vobj as $mobj) {
    if ($mobj['Ano'] == $y and $mobj['Mes'] == $m) {
        $auxmobj += $mobj['Valor'];
    }
}
foreach ($Vft as $mft) {
    if ($mft['Ano'] == $y and $mft['Mes'] <= $m) {
        $auxaft += $mft['Valor'];
    }
}
foreach ($Vobj as $mobj) {
    if ($mobj['Ano'] == $y and $mobj['Mes'] <= $m) {
        $auxaobj += $mobj['Valor'];
    }
}

foreach ($Vft as $mft) {
    if ($mft['Ano'] == $y - 1 and $mft['Mes'] == $m) {
        $auxn1ft += $mft['Valor'];
        $auxn1kft += $mft['Volume'];
    }
}
foreach ($Vobj as $mobj) {
    if ($mobj['Ano'] == $y - 1 and $mobj['Mes'] == $m) {
        $auxn1obj += $mobj['Valor'];
    }
}


if ($udir == 'Sistemas de Informação') {
    $query = "SELECT * FROM dbo.vndteams(9) order by 4 ";
} else {
    $query = "SELECT * FROM dbo.vndteams($vnd) order by 4 ";
}
$select = $conn->query($query)->fetchAll();


?>
<div class="container">
    <div class="page-inner">
        <div class="row row-card-no-pd">
            <div class="col-md-12">
                <div class="card">
                    <?php if (isset($vendnr)) { ?>
                        <div class="card-title" style="text-align:left; padding-left: 2.5%;">
                            <div class="headcs">
                                <h5><b><?php foreach ($vendnr as $vnr) {
                                            echo ' > ' . $vnr['nome'];
                                        } ?></b></h5>
                            </div>
                        </div>
                    <?php  } ?>
                    <form action="KPI.php" method="post" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group" style="top:50%;">
                                        <select name="vendedor[]"
                                            id="multiselect"
                                            class="form-select form-control"
                                            size="10"
                                            multiple="multiple"
                                            multiselect-search="true"
                                            multiselect-select-all="true"
                                            required>
                                            <?php foreach ($select as $s) {

                                            ?>
                                                <option value=' <?= $s['nome'] ?> ' Style="color: rgb(106, 120, 135);"> <?= $s['caminho'] ?></option>';
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-2 col-lg-2">
                                    <div class="form-group">
                                        <select
                                            name="mes"
                                            class="form-select form-control"
                                            id="smallSelect">
                                            <?php for ($i = 1; $i <= count($months); $i++) { ?>
                                                <option value="<?= $i ?>" <?php if ($i == $m) { ?> selected <?php } ?>><?= $months[$i] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 col-lg-3">
                                    <div class="form-group " style=" top:50%;">
                                        <div class="selectgroup w-100">
                                            <label class="selectgroup-item">
                                                <input
                                                    id="oy"
                                                    type="radio"
                                                    name="ano"
                                                    value="<?= $fy - 1 ?>"
                                                    <?php if ($fy - 1 == $y) {  ?>
                                                    checked=""
                                                    <?php } ?>
                                                    class="selectgroup-input" />
                                                <span class="selectgroup-button" style="height: 100%"><?= $fy - 1 ?></span>
                                            </label>
                                            <label class="selectgroup-item">
                                                <input
                                                    id="ty"
                                                    type="radio"
                                                    name="ano"
                                                    value="<?= $fy ?>"
                                                    <?php if ($fy == $y) {  ?>
                                                    checked=""
                                                    <?php } ?>
                                                    class="selectgroup-input" />
                                                <span class="selectgroup-button" style="height: 100%"><?= $fy ?></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-1 col-lg-1">
                                    <div class="form-group" style=" top:50%;">
                                        <button type="submit" name="submit" class="btn" style="background-color: #D3e7fb;"><i class="fas fa-sync-alt"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-3 col-sm-6 col-lg-6 col-xl-3">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between" style="text-align: right">
                            <div class="headcs">
                                <h4><b>Faturação</b></h4>
                            </div>
                            <?php if ($auxmobj == 0) {
                                $ptn1 = 0;
                            } else {
                                $ptn1 = round(($auxmft * 100) / $auxmobj, 2);
                            } ?>
                            <h4 class="text-info fw-bold"><?= $ptn1 ?>%</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between bodycs">
                            <div>
                                <h5>Mês</h5>
                            </div>

                            <h5><?= number_format($auxmft, 2, '.', ' ') ?> €</h5>

                        </div>
                        <div class="progress progress-sm" style="height:20px;">
                            <div
                                class="progress-bar bg-info"
                                style=" width: <?= $ptn1 ?>%"
                                role="progressbar"
                                aria-valuenow="<?= $ptn1 ?>"
                                aria-valuemin="0"
                                aria-valuemax="100"><?= $ptn1 ?></div>
                        </div>
                        <br>
                        <div class="d-flex justify-content-between bodycs">
                            <div>
                                <h6>Objetivo:</h6>
                            </div>
                            <h6 class="text"><?= number_format($auxmobj, 2, '.', ' ') ?> €</h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-3 col-sm-6 col-md-6 col-xl-3">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between" style="text-align: right">
                            <div class="headcs">
                                <h4><b>Faturação Acumulada</b></h4>
                            </div>
                            <?php if ($auxaobj == 0) {
                                $ptn2 = 0;
                            } else {
                                $ptn2 = round(($auxaft * 100) / $auxaobj, 2);
                            } ?>
                            <h4 class="text-success fw-bold"><?= $ptn2 ?>%</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between bodycs">
                            <div>
                                <h5>Mês</h5>
                            </div>
                            <h5><?= number_format($auxaft, 2, '.', ' ') ?> €</h5>
                        </div>
                        <div class="progress progress-sm" style="height:20px;">
                            <div
                                class="progress-bar bg-success"
                                style=" width: <?= $ptn2 ?>%"
                                role="progressbar"
                                aria-valuenow="<?= $ptn2 ?>"
                                aria-valuemin="0"
                                aria-valuemax="100"><?= $ptn2 ?></div>
                        </div>
                        <br>
                        <div class="d-flex justify-content-between bodycs">
                            <div>
                                <h6>Objetivo</h6>
                            </div>
                            <h6 class="text"><?= number_format($auxaobj, 2, '.', ' ') ?> €</h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-3 col-sm-6 col-md-6 col-xl-3">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between" style="text-align: right">
                            <div class="headcs">
                                <h4><b>Faturação em Valor </b></h4>
                            </div>
                            <?php if ($auxn1ft == 0) {
                                $ptn3 = 0;
                            } else {
                                $ptn3 = round(($auxmft * 100) / $auxn1ft, 2);
                            } ?>
                            <h4 class="text-danger fw-bold"><?= $ptn3 ?>%</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between bodycs">
                            <div>
                                <h5>Mês</h5>
                            </div>
                            <h5><?= number_format($auxmft, 2, '.', ' ') ?> €</h5>
                        </div>
                        <div class="progress progress-sm" style="height:20px;">
                            <div
                                class="progress-bar bg-danger"
                                style="width: <?= $ptn3 ?>%;"
                                role="progressbar"
                                aria-valuenow="<?= $ptn3 ?>"
                                aria-valuemin="0"
                                aria-valuemax="100"><?= $ptn3 ?></div>
                        </div>
                        <br>
                        <div class="d-flex justify-content-between bodycs">
                            <div>
                                <h6>Mês Ano n-1</h6>
                            </div>
                            <h6 class="text"><?= number_format($auxn1ft, 2, '.', ' ') ?> €</h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-3 col-sm-6 col-md-6 col-xl-3">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between" style="text-align: right">
                            <div class="headcs">
                                <h4><b>Faturação em Volume</b></h4>
                            </div>
                            <?php if ($auxn1kft == 0) {
                                $ptn4 = 0;
                            } else {
                                $ptn4 = round(($auxkft * 100) / $auxn1kft, 2);
                            } ?>
                            <h4 class="text-warning fw-bold"><?= $ptn4 ?>%</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between bodycs">
                            <div>
                                <h5>Mês</h5>
                            </div>
                            <h5><?= number_format($auxkft, 2, '.', ' ') ?> Kg</h5>
                        </div>
                        <div class="progress progress-sm" style="height:20px;">
                            <div
                                class="progress-bar bg-warning"
                                style="width: <?= $ptn4 ?>%;"
                                role="progressbar"
                                aria-valuenow="<?= $ptn4 ?>"
                                aria-valuemin="0"
                                aria-valuemax="100"><?= $ptn4 ?></div>
                        </div>
                        <br>
                        <div class="d-flex justify-content-between bodycs">
                            <div>
                                <h6>Mês Ano n-1</h6>
                            </div>
                            <h6 class="text"><?= number_format($auxn1kft, 2, '.', ' ') ?> Kg</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-12 col-lg-12 col-xl-12">
            <div class="row">
                <div class="col-3 col-sm-3 col-md-3 col-xl-3">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-3">
                                    <div class="icon-big text-center">
                                        <i class="far fa-clock text-warning"></i>
                                    </div>
                                </div>
                                <div class="col-9 col-stats">
                                    <div class="numbers">
                                        <p class="card-category headcs text-warning">Prazo Medio Recebimento</p>
                                        <h4 class="card-title bodycs" style="font-size: 19px;"><?= (round($pmr) == 365) ? 0 : round($pmr);  ?> Dias</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-3 col-sm-3 col-md-3 col-xl-3">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-3">
                                    <div class="icon-big text-center">
                                        <i class="icon-wallet text-success"></i>
                                    </div>
                                </div>
                                <div class="col-9 col-stats">
                                    <div class="numbers">
                                        <p class="card-category headcs text-success">Valor de comissão provisorio</p>
                                        <h4 class="card-title bodycs" style="font-size: 19px;"><?= number_format($comissao, 2, '.', ' ') ?> €</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-3 col-sm-3 col-md-3 col-xl-3">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-3">
                                    <div class="icon-big text-center">
                                        <i class="fas fa-calendar-alt text-info"></i>
                                    </div>
                                </div>
                                <div class="col-9 col-stats">
                                    <div class="numbers">
                                        <p class="card-category headcs text-info">Valor C.C. não regularizado</p>
                                        <h4 class="card-title bodycs" style="font-size: 19px;"><?= number_format($ccaberta, 2, '.', ' ') ?> €</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-3 col-sm-3 col-md-3 col-xl-3">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-3">
                                    <div class="icon-big text-center">
                                        <i class="fas fa-euro-sign text-danger"></i>
                                    </div>
                                </div>
                                <div class="col-9 col-stats">
                                    <div class="numbers">
                                        <p class="card-category headcs text-danger">Valor C.C. Vencido </p>
                                        <h4 class="card-title bodycs" style="font-size: 19px;"><?= number_format($ccvencida, 2, '.', ' ') ?> €</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-sm-12 col-lg-12">
                    <div class="card">
                        <div class="card-header" style="text-align: center;">
                            <div class="card-title headcs" style="font-size: 20px;">Evolução ultimos 12m Objetivo vs Faturação e Recebimentos</div>
                        </div>
                        <div class="card-body">
                            <div class="chart-container">
                                <canvas id="multipleLineChart"
                                    style="width: 50%; height: 50%"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6 col-sm-6 col-md-6 col-xl-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-head-row">
                                <div class="card-title headcs" style="font-size : 20px;">Notificações</div>
                            </div>
                        </div>
                        <div class="card-body">

                            <?php
                            if ($n_count != 0 && $c != 0) {
                                foreach ($notify as $n) { ?>
                                    <div class="d-flex">
                                        <div class="avatar">
                                            <span
                                                class="avatar-title rounded-circle border border-white bg-danger"><?= substr($n['nome'], 0, 1) ?></span>
                                        </div>
                                        <div class="flex-1 ms-3 pt-1">
                                            <h6 class="text-uppercase fw-bold mb-1">
                                                <?= $n['nome'] ?>
                                                <!-- Status -->
                                                <?php if ($n['status'] == 0) { ?>
                                                    <span class="text-warning ps-3">Por Responder</span>
                                                <?php } elseif ($n['status'] == 2) { ?>
                                                    <span class="text-danger ps-3">Por Abrir</span>
                                                <?php } ?>
                                            </h6>
                                            <span class="text-muted"><?= $n['assunto'] ?></span>
                                        </div>
                                        <div class="float-end pt-1">
                                            <small class="text-muted"><?= $n['data'] ?></small>
                                        </div>
                                    </div>
                                    <div class="separator-dashed"></div>
                                <?php }
                            } else { ?>
                                <div class="flex-1 ms-3 pt-1">
                                    <h6 class="text-uppercase fw-bold mb-1 bodycs">
                                        Sem Notificações Pendentes
                                    </h6>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-sm-6 col-md-6 col-xl-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-head-row card-tools-still-right">
                                <div class="card-title headcs" style="font-size : 20px;">Trouble Tickets</div>
                            </div>
                        </div>
                        <div class="card-body">
                            <ol class="activity-feed">
                                <li class="feed-item feed-item-success">
                                    <time class="date" datetime="9-25">Sep 25</time>
                                    {Tecnico}
                                    <span class="text-success"><a href="single-group.php">"Sem Tecnico Atribuido"</a></span>
                                </li>
                                <li class="feed-item feed-item-success">
                                    <time class="date" datetime="9-24">Sep 24</time>
                                    {Tecnico}
                                    <span class="text-success"><a href="single-group.php">"Sem Tecnico Atribuido"</a></span>
                                </li>
                                <li class="feed-item feed-item-warning">
                                    <time class="date" datetime="9-23">Sep 23</time>
                                    {Tecnico}
                                    <span class="text-warning"><a href="single-group.php">"Nova Intervenção"</a></span>
                                </li>
                                <li class="feed-item feed-item-warning">
                                    <time class="date" datetime="9-21">Sep 21</time>
                                    {Tecnico}
                                    <span class="text-warning"><a href="single-group.php">"Nova Intervenção"</a></span>
                                </li>
                                <li class="feed-item feed-item-danger">
                                    <time class="date" datetime="9-18">Sep 18</time>
                                    Ticket Aberto
                                    <span class="text-danger"><a href="single-group.php">"Sem Tecnico Atribuido"</a></span>
                                </li>
                                <li class="feed-item feed-item-danger">
                                    <time class="date" datetime="9-17">Sep 17</time>
                                    Ticket Aberto
                                    <span class="text-danger"><a href="single-group.php">"Sem Tecnico Atribuido"</a></span>
                                </li>
                            </ol>
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
            <a target="_blank" href="https://www.newcoffee.pt/pt/">@NewCoffee</a>.
        </div>
    </div>
</footer>
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
    $("#lineChart").sparkline([39.97, 31.02, 27.11, 79.91, 9.55, 38.80, 14.19, 16.40, 23.48, 65.47, 27.09, 2.16, 31.02, 27.11, 79.91, 9.55, 38.80, 14.19, 16.40, 23.48, 65.47, 27.09, 2.16], {
        type: "line",
        height: "70",
        width: "100%",
        lineWidth: "2",
        lineColor: "#177dff",
        fillColor: "rgba(23, 125, 255, 0.14)",
    });
    $("#lineChart2").sparkline([39.97, 31.02, 27.11, 79.91, 9.55, 38.80, 14.19, 16.40, 23.48, 65.47, 27.09, 2.16, 31.02, 27.11, 79.91, 9.55, 38.80, 14.19, 16.40, 23.48, 65.47, 27.09, 2.16], {
        type: "line",
        height: "70",
        width: "100%",
        lineWidth: "2",
        lineColor: "#ffa534",
        fillColor: "rgba(255, 165, 52, .14)",
    });
</script>

<?php
$reversedGraficoft = array_reverse($graficoft);
$reversedGraficoobj = array_reverse($graficoobj);
?>


<script>
    var multipleLineChart = document.getElementById("multipleLineChart").getContext("2d");
    var myMultipleLineChart = new Chart(multipleLineChart, {
        type: "line",
        data: {
            labels: [
                <?php foreach ($grafico as $row) {
                    echo '"' . $months[$row['mes']] . '", ';
                } ?>
            ],
            datasets: [{
                    label: "Objetivo",
                    borderColor: "#ff0000",
                    pointBorderColor: "#FFF",
                    pointBackgroundColor: "#ff0000",
                    pointBorderWidth: 2,
                    pointHoverRadius: 4,
                    pointHoverBorderWidth: 1,
                    pointRadius: 4,
                    backgroundColor: "#ff0000", //"transparent",
                    fill: false,
                    borderWidth: 2,
                    data: [<?php foreach ($grafico as $row) {
                                echo $row['valorobj'] . ', ';
                            } ?>],
                }, {
                    label: "Faturação",
                    borderColor: "#2a00ff",
                    pointBorderColor: "#FFF",
                    pointBackgroundColor: "#2a00ff",
                    pointBorderWidth: 2,
                    pointHoverRadius: 4,
                    pointHoverBorderWidth: 1,
                    pointRadius: 4,
                    backgroundColor: "#2a00ff",
                    fill: false,
                    borderWidth: 2,
                    data: [<?php foreach ($grafico as $row) {
                                echo $row['valorft'] . ', ';
                            } ?>],
                },
                {
                    label: "Recebimentos",
                    borderColor: "#00beff",
                    pointBorderColor: "#FFF",
                    pointBackgroundColor: "#00beff",
                    pointBorderWidth: 2,
                    pointHoverRadius: 4,
                    pointHoverBorderWidth: 1,
                    pointRadius: 4,
                    backgroundColor: "#00beff",
                    fill: false,
                    borderWidth: 2,
                    data: [<?php foreach ($grafico as $row) {
                                echo $row['recebido'] . ', ';
                            } ?>],
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            legend: {
                position: "right",
            },
            tooltips: {
                bodySpacing: 4,
                mode: "nearest",
                intersect: 0,
                position: "nearest",
                xPadding: 10,
                yPadding: 10,
                caretPadding: 10,
            },
            layout: {
                padding: {
                    left: 15,
                    right: 15,
                    top: 15,
                    bottom: 15
                },
            },
        },
    });
</script>


</body>

</html>