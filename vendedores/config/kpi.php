<?php

include 'config.php';

date_default_timezone_set("Europe/London");
$y = date('Y');
$m = ltrim(date('m'), '0');
$fy = date('Y');

if (isset($_POST['submit'])) {
    if (isset($_POST['ano']) && $_POST['ano'] != 0 && $_POST['ano'] != '' && $_POST['ano'] != null && isset($_POST['mes']) && $_POST['mes'] != 0 && $_POST['mes'] != '' && isset($_POST['vendedor'])) {
        $y = $_POST['ano'];
        $m = $_POST['mes'];
        $Vendedor = $_POST['vendedor'];

        // Create placeholders for the IN clause
        $placeholders = str_repeat('?,', count($Vendedor) - 1) . '?';

        $query = $conn->prepare("SELECT * from ft where Nome in (ltrim($placeholders))");

        // Bind each value to the corresponding placeholder
        $query->execute($Vendedor);
        $Vft = $query->fetchAll();


        $query = $conn->prepare("SELECT * from obj where Nome in (ltrim($placeholders))");

        // Bind each value to the corresponding placeholder      
        $query->execute($Vendedor);
        $Vobj = $query->fetchAll();


        $query = $conn->prepare("SELECT sum(valor) as total, mes, ano from ft where (nome in (ltrim($placeholders)) and ano = CAST(? AS int) and mes <= CAST(? AS int) ) or (nome in (ltrim($placeholders)) and ano = CAST(? AS int) and mes >= CAST(? AS int)) group by mes, ano order by ano desc, mes desc");

        // Bind each value to the corresponding placeholder
          
        $params = array_merge($Vendedor, [$y,$m], $Vendedor, [$y,$m]);
        $query->execute($params);
        print_r($query);
        $graficoft = $query->fetchAll();
        print_r($graficoft);
        $query = $conn->prepare("SELECT sum(valor) as total, mes, ano from obj where (nome in (ltrim($placeholders)) and ano = CAST(? AS int) AND mes <= CAST(? AS int)) or (nome in (ltrim($placeholders)) and ano = CAST(? AS int) AND mes >= CAST(? AS int)) group by mes, ano order by ano desc, mes desc");

        // Bind each value to the corresponding placeholder       
        $params = array_merge($Vendedor, [$y,$m], $Vendedor, [$y,$m]);
        $query->execute($params);
        $graficoobj = $query->fetchAll();
    }
}

else {

    date_default_timezone_set("Europe/London");
    $y = date('Y');
    $m = ltrim(date('m'), '0');

    $query = "SELECT * from us where nome = '" . $login . "' and vnd > 0 ";
    $ifvend = $conn->query($query)->fetchAll();

    if (isset($ifvend[0]['vnd'])) {

        $Vendedor = $login;
        $query = "select * from ft where Nome= '" . $Vendedor . "'";
        $Vft = $conn->query($query)->fetchAll();

        $query = "select * from obj where Nome= '" . $Vendedor . "'";
        $Vobj = $conn->query($query)->fetchAll();

        $query = "select sum(valor) as total, mes, ano from ft where (Nome= '" . $Vendedor . "' and ano = " . $y . " and mes <= " . $m . ") or (Nome= '" . $Vendedor . "' and ano = " . ($y - 1) . " and mes >= " . $m . ") group by mes, ano order by ano desc, mes desc";
        $graficoft = $conn->query($query)->fetchAll();

        $query = "select sum(valor) as total, mes, ano from obj where (Nome= '" . $Vendedor . "' and ano = " . $y . " and mes <= " . $m . ") or (Nome= '" . $Vendedor . "' and ano = " . ($y - 1) . " and mes >= " . $m . ") group by mes, ano order by ano desc, mes desc";
        $graficoobj = $conn->query($query)->fetchAll();
    } else {

        $query = "select * from ft where Nome= '' ";
        $Vft = $conn->query($query)->fetchAll();

        $query = "select * from obj where Nome= ''";
        $Vobj = $conn->query($query)->fetchAll();

        $query = "select sum(valor) as total, mes, ano from ft where (Nome= '' and ano = " . $y . " and mes <= " . $m . ") or (Nome= '' and ano = " . ($y - 1) . " and mes >= " . $m . ") group by mes, ano order by ano desc, mes desc";
        $graficoft = $conn->query($query)->fetchAll();

        $query = "select sum(valor) as total, mes, ano from obj where (Nome= '' and ano = " . $y . " and mes <= " . $m . ") or (Nome= '' and ano = " . ($y - 1) . " and mes >= " . $m . ") group by mes, ano order by ano desc, mes desc";
        $graficoobj = $conn->query($query)->fetchAll();
    }
}