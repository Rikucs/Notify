<!DOCTYPE html>
<?php

include_once("config/config.php");
include_once("config/vendor.php");

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


<head>

    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Admin Dashboard</title>
    <meta
        content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
        name="viewport" />
    <link
        rel="icon"
        href="assets/img/kaiadmin/favicon.png"
        type="image/x-icon" />

    <!-- Fonts and icons -->

    <script>
        WebFont.load({
            google: {
                families: ["Public Sans:300,400,500,600,700"]
            },
            custom: {
                families: [
                    "Font Awesome 5 Solid",
                    "Font Awesome 5 Regular",
                    "Font Awesome 5 Brands",
                    "simple-line-icons",
                ],
                urls: ["assets/css/fonts.min.css"],
            },
            active: function() {
                sessionStorage.fonts = true;
            },
        });
    </script>


    <!-- CSS Files -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/plugins.min.css" />
    <link rel="stylesheet" href="assets/css/kaiadmin.min.css" />

</head>



<body>
    <div class="wrapper" style="align-content: center">
        <div class="container">
            <div class="page-inner">

                
                <div class="row">
                    <div class="col-6 col-sm-6 col-lg-6">
                        <div class="card">
                            <div class="card-header" style="background-color: #626567; text-align: center">
                                <div class="card-title" style="color: #FFFFFF; font-size: 28px;">TTS Ultimos 6 Meses</div>
                            </div>
                            <div class="card-body">
                                <div class="chart-container">
                                    <canvas id="barChart"
                                        style="width: 50%; height: 50%"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-lg-6">
                        <div class="card">
                            <div class="card-header" style="background-color:#626567;text-align: center">
                                <div class="card-title" style="color: #FFFFFF; font-size: 28px;">
                                    Pareto de Causas TTS
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="chart-container">
                                    <canvas
                                        id="pieChart2"
                                        style="width: 50%; height: 50%"></canvas>
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

        <!-- Sweet Alert -->
        <script src="assets/js/plugin/sweetalert/sweetalert.min.js"></script>

        <!-- JS -->
        <script src="assets/js/kaiadmin.min.js"></script>


        <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>


        <script>
            var pieChart = document.getElementById("pieChart").getContext("2d");
            var myPieChart = new Chart(pieChart, {

                type: "pie",
                data: {

                    labels: ["Desenvolvimento", "Suporte", "Melhoria Continua"],
                    datasets: [{

                        data: [<?php echo $Desenvolvimento2 . ', ';
                                echo $Suporte2 . ', ';
                                echo $MelhoriaContinua2 . ', ';     ?>],
                        backgroundColor: ["#f1c40f", "#f7dc6f", "#fcf3cf", ],
                        borderWidth: 2,
                    }, {

                        data: [<?php echo $Desenvolvimento . ', ';
                                echo $Suporte . ', ';
                                echo $MelhoriaContinua . ', ';     ?>],
                        backgroundColor: ["#f1c40f", "#f7dc6f", "#fcf3cf"],
                        borderWidth: 2,
                    }, ],


                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    legend: {
                        position: "right",
                        labels: {
                            fontColor: "rgb(86, 101, 115)",
                            fontSize: 24,
                            usePointStyle: true,
                            padding: 10,
                        },
                        label: {
                            fontColor: "rgb(86, 101, 115)",
                            fontSize: 24,
                            usePointStyle: true,
                            padding: 10,
                        },
                    },
                    pieceLabel: {
                        render: "percentage",
                        fontColor: "gray",
                        fontSize: 15,
                    },
                    tooltips: false,
                    layout: {
                        padding: {
                            left: 1,
                            right: 1,
                            top: 1,
                            bottom: 1,
                        },
                    },
                },
            });
        </script>
        <script>
            var multipleLineChart = document.getElementById("multipleLineChart").getContext("2d");
            var myMultipleLineChart = new Chart(multipleLineChart, {
                type: "line",
                data: {
                    labels: [<?php foreach ($line as $row) {
                                    echo '"' . $row['dat'] . '", ';
                                } ?>],
                    datasets: [{
                            label: "Abertos",
                            borderColor: "rgb(75, 192, 192)",
                            backgroundColor: "transparent",
                            data: [<?php foreach ($line as $row) {
                                        echo $row['A'] . ', ';
                                    } ?>],
                        },
                        {
                            label: "Fechados",
                            borderColor: "rgb(255, 99, 132)",
                            backgroundColor: "transparent",
                            data: [<?php foreach ($line as $row) {
                                        echo $row['F'] . ', ';
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
        <script>
            var barChart = document.getElementById("barChart").getContext("2d");
            var myBarChart = new Chart(barChart, {
                type: "bar",
                data: {
                    labels: [<?php foreach ($barchart as $row) {
                                    echo '"' . $row['D'] . '", ';
                                } ?>],
                    datasets: [{
                            label: "Abertos",
                            backgroundColor: "rgb(75, 192, 192)",
                            borderColor: "rgb(75, 192, 192)",
                            data: [<?php foreach ($barchart as $row) {
                                        echo $row['abertos'] . ', ';
                                    } ?>],
                        },
                        {
                            label: "Fechados",
                            backgroundColor: "rgb(255, 99, 132)",
                            borderColor: "rgb(255, 99, 132)",
                            data: [<?php foreach ($barchart as $row) {
                                        echo $row['fechados'] . ', ';
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
        <script>
            var pieChart2 = document.getElementById("pieChart2").getContext("2d");
            var myPieChart = new Chart(pieChart2, {

                type: "pie",
                data: {

                    labels: [<?php foreach ($pie26 as $row) {
                                    echo '"' . $row['causa'] . '", ';
                                } ?>],
                    datasets: [{

                        data: [<?php foreach ($pie26 as $row) {
                                    echo $row['n_tickets'] . ', ';
                                } ?>],
                        backgroundColor: ["#154360", "#1f618d", "#2980b9", "#7fb3d5", "#d6eaf8"],
                        borderWidth: 2,
                    }, {

                        data: [<?php foreach ($pie230 as $row) {
                                    echo $row['n_tickets'] . ', ';
                                } ?>],
                        backgroundColor: ["#154360", "#1f618d", "#2980b9", "#7fb3d5", "#d6eaf8"],
                        borderWidth: 2,


                    }, ],


                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    legend: {
                        position: "right",
                        labels: {
                            fontColor: "rgb(86, 101, 115)",
                            fontSize: 24,
                            usePointStyle: true,
                            padding: 10,
                        },
                        label: {
                            fontColor: "rgb(86, 101, 115)",
                            fontSize: 24,
                            usePointStyle: true,
                            padding: 10,
                        },
                    },
                    pieceLabel: {
                        render: "percentage",
                        fontColor: "silver",
                        fontSize: 20,
                    },
                    tooltips: false,
                    layout: {
                        padding: {
                            left: 1,
                            right: 1,
                            top: 1,
                            bottom: 1,
                        },
                    },
                },
            });
        </script>



</body>

</html>