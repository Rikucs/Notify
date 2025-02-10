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
    
    // Create placeholders for the IN clause
    $placeholders = implode(',', array_fill(0, count($Vendedor), '?'));
    $stm = $conn->prepare("SELECT * from us where Nome in ($placeholders) and vnd <> 0");
    
    // Bind each value to the corresponding placeholder       
    $stm->execute($Vendedor);
    $Vendedor = $stm -> fetchAll();
} else {
    $stm = $conn->prepare("SELECT * from us where Nome = :nome and vnd <> 0 ");
    $stm->bindvalue(':nome',$Vendedor);
    $stm->execute();
    $Vendedor = $stm -> fetchAll();
}

$testcount = count($Vendedor);

if ($testcount > 0) {
    $query = "select right(rtrim(valor),4) anodc,substring(valor,4,2) mesdc from para1 (nolock) where descricao ='mc_atadf'";
    $DC = $conn1->query($query)->fetchAll();
    foreach ($DC as $z) {
        $ano = $z['anodc'];
        $mes = $z['mesdc'];
    }

    $query = $conn->prepare("SELECT * from ft where Nome in ($placeholders)");
    
    // Bind each value to the corresponding placeholder
    $query->execute($Vendedor);
    $Vft = $query->fetchAll();

    
    $query = $conn->prepare("SELECT * from obj where Nome in ($placeholders)");
    
    // Bind each value to the corresponding placeholder      
    $query->execute($Vendedor);
    $Vobj = $query->fetchAll();


    $query = $conn->prepare("SELECT sum(valor) as total, mes, ano from ft where Nome in ($placeholders) and ano = 2025 and mes <= 1 or Nome in ($placeholders) and ano = 2024 and mes >= 1 group by mes, ano order by ano desc, mes desc");
    
    // Bind each value to the corresponding placeholder       
    $query->execute($Vendedor);
    $graficoft = $query->fetchAll();


    $query = $conn->prepare("SELECT sum(valor) as total, mes, ano from obj where Nome in ($placeholders) and ano = 2025 and mes <= 1 or Nome in ($placeholders) and ano = 2024 and mes >= 1 group by mes, ano order by ano desc, mes desc");
    
    // Bind each value to the corresponding placeholder       
    $query->execute($Vendedor);
    $graficoobj = $query->fetchAll();

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

    $query = "select sum(valor) as total, mes, ano from ft where (Nome= 'Avelino Soares' and ano = " . $y . " and mes <= " . $m . ") or (Nome= 'Avelino Soares' and ano = " . ($y - 1) . " and mes >= " . $m . ") group by mes, ano order by ano desc, mes desc";
    $graficoft = $conn->query($query)->fetchAll();

    $query = "select sum(valor) as total, mes, ano from obj where (Nome= 'Avelino Soares' and ano = 2025 and mes <= 1) or (Nome= 'Avelino Soares' and ano = 2024 and mes >= 1) group by mes, ano order by ano desc, mes desc";
    $graficoobj = $conn->query($query)->fetchAll();
}
