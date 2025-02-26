<?php

include_once("config/config.php");
include_once("config/vendor.php");
include("Header.php");
date_default_timezone_set("Europe/London");
$y = date('Y');
$m = date('m');

$query = "select top 13 sum(valor)as total, mes, ano from ft where Nome= 'Avelino Soares' and ano = " . $y . " and mes <= " . $m . "  or ano = " . $y - 1 . "  and mes >= " . $m . " group by mes,ano order by ano desc,mes desc";
$graficoft = $conn->query($query)->fetchAll();

$query = "select top 13 sum(valor)as total, mes, ano from obj where Nome= 'Avelino Soares' and ano = " . $y . "  and mes <= " . $m . "  or ano = " . $y - 1 . "  and mes >= " . $m . " group by mes,ano order by ano desc,mes desc";
$graficoobj = $conn->query($query)->fetchAll();

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
                    <a href="#">Dashboard</a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="snapshot.php">Snapshot</a>
                </li>
            </ul>
        </div>
        <main>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Snapshot - <?= $login ?> - <?= $date; ?></div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <!-- Projects table -->
                                <table class="table align-items-center mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col">Campo</th>
                                            <th scope="col">mzona</th>
                                            <th scope="col">Clientes</th>
                                            <th scope="col">Objectivo</th>
                                            <th scope="col">Faturação</th>
                                            <th scope="col">DesvioFact</th>
                                            <th scope="col">KG</th>
                                            <th scope="col">PMV</th>
                                            <th scope="col">FactPend</th>
                                            <th scope="col">FactPrevista</th>
                                            <th scope="col">desvftprev</th>
                                            <th scope="col">Recebido</th>
                                            <th scope="col">Recsiva</th>
                                            <th scope="col">CC_Aberta</th>
                                            <th scope="col">n_vencida</th>
                                            <th scope="col">PMR</th>
                                            <th scope="col">ObjAcumulado</th>
                                            <th scope="col">FactAcumulada</th>
                                            <th scope="col">DesvFactAcum</th>
                                            <th scope="col">FactPrevAcum</th>
                                            <th scope="col">DesvFactPrevAcum</th>
                                            <th scope="col">cc_limite</th>
                                            <th scope="col">FT_Ant_AC</th>
                                            <th scope="col">Desvio_FT_Ant_AC</th>
                                            <th scope="col">fact365</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($Dados as $row) { ?>
                                            <tr>
                                                <th scope="row"><?= $row['campo'] ?></th>
                                                <td><?= $row['mzona'] ?></td>
                                                <td><?= $row['Clientes'] ?></td>
                                                <td><?= $row['Objectivo'] ?></td>
                                                <td class="clickable" data-toggle="modal" data-target="#myModal"><?= $row['Clientes'] ?></td>
                                                <td><?= $row['DesvioFact'] ?></td>
                                                <td><?= $row['Kg'] ?></td>
                                                <td><?= $row['PMV'] ?></td>
                                                <td><?= $row['FactPend'] ?></td>
                                                <td><?= $row['FactPrevista'] ?></td>
                                                <td><?= $row['desvftprev'] ?></td>
                                                <td><?= $row['Recebido'] ?></td>
                                                <td><?= $row['RecSiva'] ?></td>
                                                <td><?= $row['Cc_Aberta'] ?></td>
                                                <td><?= $row['n_vencida'] ?></td>
                                                <td><?= $row['PMR'] ?></td>
                                                <td><?= $row['ObjAcumulado'] ?></td>
                                                <td><?= $row['FactAcumulada'] ?></td>
                                                <td><?= $row['DesvFactAcum'] ?></td>
                                                <td><?= $row['FactPrevAcum'] ?></td>
                                                <td><?= $row['DesvFactPrevAcum'] ?></td>
                                                <td><?= $row['CC_limite'] ?></td>
                                                <td><?= $row['FT_ANT_AC'] ?></td>
                                                <td><?= $row['Desvio_FT_ANT_AC'] ?></td>
                                                <td><?= $row['fact365'] ?></td>
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
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="chart-container">
                                <canvas id="barChart"
                                    style="width: 50%; height: 50%"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <!-- modal -->
        <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                        <button type="button" class="close" onclick="$('#myModal').modal('hide');" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modalxbody">
                        <!-- Modal content will be loaded here -->
                        <div class="table-responsive">
                            <!-- Projects table -->
                            <table class="table align-items-center mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Campo</th>
                                        <th scope="col">mzona</th>
                                        <th scope="col">Clientes</th>
                                        <th scope="col">Objectivo</th>
                                        <th scope="col">Faturação</th>
                                        <th scope="col">DesvioFact</th>
                                        <th scope="col">KG</th>
                                        <th scope="col">PMV</th>
                                        <th scope="col">FactPend</th>
                                        <th scope="col">FactPrevista</th>
                                        <th scope="col">desvftprev</th>
                                        <th scope="col">Recebido</th>
                                        <th scope="col">Recsiva</th>
                                        <th scope="col">CC_Aberta</th>
                                        <th scope="col">n_vencida</th>
                                        <th scope="col">PMR</th>
                                        <th scope="col">ObjAcumulado</th>
                                        <th scope="col">FactAcumulada</th>
                                        <th scope="col">DesvFactAcum</th>
                                        <th scope="col">FactPrevAcum</th>
                                        <th scope="col">DesvFactPrevAcum</th>
                                        <th scope="col">cc_limite</th>
                                        <th scope="col">FT_Ant_AC</th>
                                        <th scope="col">Desvio_FT_Ant_AC</th>
                                        <th scope="col">fact365</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($Dados as $row) { ?>
                                        <tr>
                                            <th scope="row"><?= $row['campo'] ?></th>
                                            <td><?= $row['mzona'] ?></td>
                                            <td><?= $row['Clientes'] ?></td>
                                            <td><?= $row['Objectivo'] ?></td>
                                            <td class="clickable" data-toggle="modal" data-target="#myModal"><?= $row['Clientes'] ?></td>
                                            <td><?= $row['DesvioFact'] ?></td>
                                            <td><?= $row['Kg'] ?></td>
                                            <td><?= $row['PMV'] ?></td>
                                            <td><?= $row['FactPend'] ?></td>
                                            <td><?= $row['FactPrevista'] ?></td>
                                            <td><?= $row['desvftprev'] ?></td>
                                            <td><?= $row['Recebido'] ?></td>
                                            <td><?= $row['RecSiva'] ?></td>
                                            <td><?= $row['Cc_Aberta'] ?></td>
                                            <td><?= $row['n_vencida'] ?></td>
                                            <td><?= $row['PMR'] ?></td>
                                            <td><?= $row['ObjAcumulado'] ?></td>
                                            <td><?= $row['FactAcumulada'] ?></td>
                                            <td><?= $row['DesvFactAcum'] ?></td>
                                            <td><?= $row['FactPrevAcum'] ?></td>
                                            <td><?= $row['DesvFactPrevAcum'] ?></td>
                                            <td><?= $row['CC_limite'] ?></td>
                                            <td><?= $row['FT_ANT_AC'] ?></td>
                                            <td><?= $row['Desvio_FT_ANT_AC'] ?></td>
                                            <td><?= $row['fact365'] ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" onclick="$('#myModal').modal('hide');">Close</button>
                        <button type="button" class="btn btn-primary" onclick="$('#myModal').modal('hide');">Save changes</button>
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
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<script>
    $(document).ready(function() {
        $('.clickable').on('click', function() {
            var content = $(this).data('content');
            $('#myModal .modalxbody').text(content);
            $('#myModal').modal('show');
        });
    });
</script>

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
    var barChart = document.getElementById("barChart").getContext("2d");
    var myBarChart = new Chart(barChart, {
        type: "bar",
        data: {
            labels: [],
            datasets: [{
                    label: "Mes",
                    backgroundColor: "rgb(75, 192, 192)",
                    borderColor: "rgb(75, 192, 192)",
                    data: [<?php foreach ($auxmft as $row) {
                                echo $row . ', ';
                            } ?>],
                },
                {
                    label: "Mes ultimo ano",
                    backgroundColor: "rgb(255, 99, 132)",
                    borderColor: "rgb(255, 99, 132)",
                    data: [<?php foreach ($auxn1ft as $row) {
                                echo $row . ', ';
                            } ?>],
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            legend: {
                position: "none",
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                    },
                }, ],
            },
        },
    });
</script>

</body>

</html>