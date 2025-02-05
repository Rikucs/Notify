<?php

include 'config.php';
$Vendedor = $login;

date_default_timezone_set("Europe/London");
$y = date('Y');
$m = ltrim(date('m'), '0');
$fy = date('Y');


if (isset($_POST["submit"])) {
    if (isset($_POST["ano"]) && $_POST['ano'] != 0 && $_POST['ano'] != '' && $_POST['ano'] != null) {
        $y = $_POST['ano'];
    }
    if (isset($_POST["mes"]) && $_POST['mes'] != 0 && $_POST['mes'] != '') {
        $m = $_POST['mes'];
    }
    $Vendedor = $_POST['vendedor'];
}

$query = "select * from obj where Nome= '" . $Vendedor . "'";
$testcount = $conn->query($query)->rowCount();

if ($testcount != 0) {
    $query = "select right(rtrim(valor),4) anodc,substring(valor,4,2) mesdc from para1 (nolock) where descricao ='mc_atadf'";
    $DC = $conn1->query($query)->fetchAll();
    foreach ($DC as $z) {
        $ano = $z['anodc'];
        $mes = $z['mesdc'];
    }

    $query = "select * from ft where Nome= '" . $Vendedor . "'";
    $Vft = $conn->query($query)->fetchAll();

    $query = "select * from obj where Nome= '" . $Vendedor . "'";
    $Vobj = $conn->query($query)->fetchAll();

    $query = "select sum(valor)as total, mes, ano from ft where Nome= '" . $Vendedor . "' and ano = " . $y . " and mes <= " . $m . "  or Nome= '" . $Vendedor . "' and ano = " . $y - 1 . "  and mes >= " . $m . " group by mes,ano order by ano desc,mes desc";
    $graficoft = $conn->query($query)->fetchAll();

    $query = "select sum(valor)as total, mes, ano from obj where Nome= '" . $Vendedor . "' and ano = 2025 and mes <= 1 or  Nome= '" . $Vendedor . "' and  ano = 2024 and  mes >= 1 group by mes,ano order by ano desc,mes desc";
    $graficoobj = $conn->query($query)->fetchAll();
} else {
    $query = "select right(rtrim(valor),4) anodc,substring(valor,4,2) mesdc from para1 (nolock) where descricao ='mc_atadf'";
    $DC = $conn1->query($query)->fetchAll();
    foreach ($DC as $z) {
        $ano = $z['anodc'];
        $mes = $z['mesdc'];
    }

    $query = "select * from ft where Nome= 'Avelino Soares'";
    $Vft = $conn->query($query)->fetchAll();

    $query = "select * from obj where Nome= 'Avelino Soares'";
    $Vobj = $conn->query($query)->fetchAll();

    $query = "select sum(valor)as total, mes, ano from ft where Nome= 'Avelino Soares' and ano = " . $y . " and mes <= " . $m . "  or Nome= 'Avelino Soares' and ano = " . $y - 1 . "  and mes >= " . $m . " group by mes,ano order by ano desc,mes desc";
    $graficoft = $conn->query($query)->fetchAll();

    $query = "select sum(valor)as total, mes, ano from obj where Nome= 'Avelino Soares' and ano = 2025 and mes <= 1 or  Nome= 'Avelino Soares' and  ano = 2024 and  mes >= 1 group by mes,ano order by ano desc,mes desc";
    $graficoobj = $conn->query($query)->fetchAll();
}
