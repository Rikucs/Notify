<?php

include_once("config/config.php");
include_once("config/vendor.php");
include("Header.php");

$date = date('d/m/Y');
date_default_timezone_set("Europe/London");


?>
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <div class="d-flex justify-content-between">
                <div>
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
                            <a href="snapshot.php">KPI</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header" style="text-align: center;">
                <div class="d-flex justify-content-between">
                    <div class="card-title">Bruno Clemente
                        <div class="text-info fw-bold">---------------</div>
                        <div>Lisboa 01/2025</div>
                        <div class="text-info fw-bold">---------------</div>
                    </div>
                    <form>
                        <div class="form-group">
                            <select
                                class="form-select form-control-sm"
                                id="smallSelect">
                                <option>Janeiro</option>
                                <option>Fevereiro</option>
                                <option>Março</option>
                                <option>Abril</option>
                                <option>Maio</option>
                                <option>Junho</option>
                                <option>Julho</option>
                                <option>Agosto</option>
                                <option>Setembro</option>
                                <option>Outubro</option>
                                <option>Novembro</option>
                                <option>Dezembro</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="selectgroup w-100">
                                <label class="selectgroup-item">
                                    <input
                                        type="radio"
                                        name="value"
                                        value="2024"
                                        class="selectgroup-input" />
                                    <span class="selectgroup-button">2024</span>
                                </label>
                                <label class="selectgroup-item">
                                    <input
                                        type="radio"
                                        name="value"
                                        checked=""
                                        value="2025"
                                        class="selectgroup-input" />
                                    <span class="selectgroup-button">2025</span>
                                </label>
                            </div>
                        </div>
                        <a type="submit" classe="btn btn-round me-2 btncs">Atualizar</a>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-12 col-lg-12 col-xl-12">
            <div class="row">
                <div class="col-3 col-sm-6 col-lg-6 col-xl-3">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between" style="text-align: right">
                                <div>
                                    <h4><b>Faturação</b></h4>
                                </div>
                                <h4 class="text-info fw-bold">75%</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5>Mês:</h5>
                                </div>
                                <h5>300 000€</h5>
                            </div>
                            <div class="progress progress-sm" style="height:20px;">
                                <div
                                    class="progress-bar bg-info w-75"
                                    role="progressbar"
                                    aria-valuenow="75"
                                    aria-valuemin="0"
                                    aria-valuemax="100">75%</div>
                            </div>
                            <br>
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6>Objetivo:</h6>
                                </div>
                                <h6 class="text">400 000€</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-3 col-sm-6 col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between" style="text-align: right">
                                <div>
                                    <h4><b>Faturação Acumulada</b></h4>
                                </div>
                                <h4 class="text-success fw-bold">75%</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5>Mês:</h5>
                                </div>
                                <h5>300 000€</h5>
                            </div>
                            <div class="progress progress-sm" style="height:20px;">
                                <div
                                    class="progress-bar bg-success w-75"
                                    role="progressbar"
                                    aria-valuenow="75"
                                    aria-valuemin="0"
                                    aria-valuemax="100">75%</div>
                            </div>
                            <br>
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6>Objetivo:</h6>
                                </div>
                                <h6 class="text">400 000€</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-3 col-sm-6 col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between" style="text-align: right">
                                <div>
                                    <h4><b>Faturação vs n-1 </b></h4>
                                </div>
                                <h4 class="text-danger fw-bold">75%</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5>Mês:</h5>
                                </div>
                                <h5>300 000€</h5>
                            </div>
                            <div class="progress progress-sm" style="height:20px;">
                                <div
                                    class="progress-bar bg-danger w-75"
                                    role="progressbar"
                                    aria-valuenow="75"
                                    aria-valuemin="0"
                                    aria-valuemax="100">75%</div>
                            </div>
                            <br>
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6>Ano passado:</h6>
                                </div>
                                <h6 class="text">400 000€</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-3 col-sm-6 col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between" style="text-align: right">
                                <div>
                                    <h4><b>Faturação vs n-1 Kg</b></h4>
                                </div>
                                <h4 class="text-warning fw-bold">75%</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5>Mês:</h5>
                                </div>
                                <h5>300 000€</h5>
                            </div>
                            <div class="progress progress-sm" style="height:20px;">
                                <div
                                    class="progress-bar bg-warning w-75"
                                    role="progressbar"
                                    aria-valuenow="75"
                                    aria-valuemin="0"
                                    aria-valuemax="100">75%</div>
                            </div>
                            <br>
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6>Ano passado:</h6>
                                </div>
                                <h6 class="text">400 000€</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-4 col-sm-6 col-md-6 col-xl-4">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between" style="text-align: right">
                                <div>
                                    <h4><b>Conta Corrente</b></h4>
                                </div>
                                <h4 class="text-secondary fw-bold">75%</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5>Valor cc:</h5>
                                </div>
                                <h5>300 000€</h5>
                            </div>
                            <div class="progress progress-sm" style="height:20px;">
                                <div
                                    class="progress-bar bg-secondary w-75"
                                    role="progressbar"
                                    aria-valuenow="75"
                                    aria-valuemin="0"
                                    aria-valuemax="100">75%</div>
                            </div>
                            <br>
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6>Valor cc f:</h6>
                                </div>
                                <h6 class="text">400 000€</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-4 col-sm-6 col-md-6 col-xl-4">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between" style="text-align: right">
                                <div>
                                    <h4><b>PMR</b></h4>
                                </div>
                                <h4 class="text-primary fw-bold">75%</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5>Vendas médias:</h5>
                                </div>
                                <h5>300 000€</h5>
                            </div>
                            <div class="progress progress-sm" style="height:20px;">
                                <div
                                    class="progress-bar bg-primary w-75"
                                    role="progressbar"
                                    aria-valuenow="75"
                                    aria-valuemin="0"
                                    aria-valuemax="100">75%</div>
                            </div>
                            <br>
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6>CC em aberto:</h6>
                                </div>
                                <h6 class="text">400 000€</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-4 col-sm-6 col-md-6 col-xl-4">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between" style="text-align: right">
                                <div>
                                    <h4><b>Comissões</b></h4>
                                </div>
                                <h4 class="text-primary fw-bold">75%</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5>Mês:</h5>
                                </div>
                                <h5>300 000€</h5>
                            </div>
                            <div class="progress progress-sm" style="height:20px;">
                                <div
                                    class="progress-bar bg-primary w-75"
                                    role="progressbar"
                                    aria-valuenow="75"
                                    aria-valuemin="0"
                                    aria-valuemax="100">75%</div>
                            </div>
                            <br>
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6>Objetivo:</h6>
                                </div>
                                <h6 class="text">400 000€</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6 col-sm-6 col-md-6 col-xl-6">
                    <div class="card">
                        <div class="card-body pb-0">
                            <div class="h1 fw-bold float-end text-primary">375,15€</div>
                            <h2 class="mb-2">Comissão media: 1,52 </h2>
                            <p class="text-muted">Remuneração diaria</p>
                            <div class="pull-in sparkline-fix">
                                <div id="lineChart"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-sm-6 col-md-6 col-xl-6">
                    <div class="card">
                        <div class="card-body pb-0">
                            <div class="h1 fw-bold float-end text-warning">375,15€</div>
                            <h2 class="mb-2">Comissão media: 1,52 </h2>
                            <p class="text-muted">Remuneração diaria</p>
                            <div class="pull-in sparkline-fix">
                                <div id="lineChart2"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-head-row card-tools-still-right">
                                <div class="card-title">Trouble tickets</div>
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
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-head-row">
                                <div class="card-title">Notificaçãoes</div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="avatar">
                                    <span
                                        class="avatar-title rounded-circle border border-white bg-info">J</span>
                                </div>
                                <div class="flex-1 ms-3 pt-1">
                                    <h6 class="text-uppercase fw-bold mb-1">
                                        Joko Subianto
                                        <span class="text-warning ps-3">Lida</span>
                                    </h6>
                                    <span class="text-muted">I am facing some trouble with my viewport. When i
                                        start my</span>
                                </div>
                                <div class="float-end pt-1">
                                    <small class="text-muted">8:40 PM</small>
                                </div>
                            </div>
                            <div class="separator-dashed"></div>
                            <div class="d-flex">
                                <div class="avatar">
                                    <span
                                        class="avatar-title rounded-circle border border-white bg-secondary">P</span>
                                </div>
                                <div class="flex-1 ms-3 pt-1">
                                    <h6 class="text-uppercase fw-bold mb-1">
                                        Prabowo Widodo
                                        <span class="text-success ps-3">respondida</span>
                                    </h6>
                                    <span class="text-muted">I have some query regarding the license issue.</span>
                                </div>
                                <div class="float-end pt-1">
                                    <small class="text-muted">1 Day Ago</small>
                                </div>
                            </div>
                            <div class="separator-dashed"></div>
                            <div class="d-flex">
                                <div class="avatar">
                                    <span
                                        class="avatar-title rounded-circle border border-white bg-danger">L</span>
                                </div>
                                <div class="flex-1 ms-3 pt-1">
                                    <h6 class="text-uppercase fw-bold mb-1">
                                        Lee Chong Wei
                                        <span class="text-danger ps-3">Por Responder</span>
                                    </h6>
                                    <span class="text-muted">Is there any update plan for RTL version near
                                        future?</span>
                                </div>
                                <div class="float-end pt-1">
                                    <small class="text-muted">2 Days Ago</small>
                                </div>
                            </div>
                            <div class="separator-dashed"></div>
                            <div class="d-flex">
                                <div class="avatar ">
                                    <span
                                        class="avatar-title rounded-circle border border-white bg-secondary">P</span>
                                </div>
                                <div class="flex-1 ms-3 pt-1">
                                    <h6 class="text-uppercase fw-bold mb-1">
                                        Peter Parker
                                        <span class="text-success ps-3">open</span>
                                    </h6>
                                    <span class="text-muted">I have some query regarding the license issue.</span>
                                </div>
                                <div class="float-end pt-1">
                                    <small class="text-muted">2 Day Ago</small>
                                </div>
                            </div>
                            <div class="separator-dashed"></div>
                            <div class="d-flex">
                                <div class="avatar">
                                    <span
                                        class="avatar-title rounded-circle border border-white bg-danger">L</span>
                                </div>
                                <div class="flex-1 ms-3 pt-1">
                                    <h6 class="text-uppercase fw-bold mb-1">
                                        Logan Paul <span class="text-muted ps-3">closed</span>
                                    </h6>
                                    <span class="text-muted">Is there any update plan for RTL version near
                                        future?</span>
                                </div>
                                <div class="float-end pt-1">
                                    <small class="text-muted">2 Days Ago</small>
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
    $(document).ready(function() {
        $('.clickable').on('click', function() {
            var content = $(this).data('content');
            $('#myModal .modalxbody').text(content);
            $('#myModal').modal('show');
        });
    });
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

</body>

</html>