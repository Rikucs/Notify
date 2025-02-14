<?php

include 'config.php';

date_default_timezone_set("Europe/London");
$y = date('Y');
$m = ltrim(date('m'), '0');
$fy = date('Y');

$query = "select right(rtrim(valor),4) anodc,substring(valor,4,2) mesdc from para1 (nolock) where descricao ='mc_dataf'";
$DC = $conn1->query($query)->fetchAll();
foreach ($DC as $z) {
    $ano = $z['anodc'];
    $mes = $z['mesdc'];
}
/*
if ($ano > $y){
    $i1rt = $conn1;
}elseif ($ano == $y && $mes > $m ){
    $11rt = $conn1;
}else{
    $i1rt = $conn;
}
*/

if (isset($_POST['submit'])) {
    if (isset($_POST['ano']) && $_POST['ano'] != 0 && $_POST['ano'] != '' && $_POST['ano'] != null && isset($_POST['mes']) && $_POST['mes'] != 0 && $_POST['mes'] != '' && isset($_POST['vendedor'])) {
        $y = $_POST['ano'];
        $m = $_POST['mes'];
        $Vendedores = $_POST['vendedor'];
        array_walk($Vendedores, function (&$val) {
            $val = ltrim($val);
        });

        // Create placeholders for the IN clause    
        $placeholder = str_repeat('?,', count($Vendedores) - 1) . '?';


        $query = $conn->prepare("SELECT nome,usrno from us where Nome in ($placeholder)");

        // Bind each value to the corresponding placeholder
        $query->execute($Vendedores);
        $vendnr = $query->fetchAll();

        $Vendedor = [];
        $nrvend = [];
        foreach ($vendnr as $kl) {
            $vendnro = ltrim($kl['usrno']);
            $query = $conn->prepare("SELECT nome FROM dbo.subordinados(:ghj) order by nivel asc");
            $query->bindvalue(':ghj', $vendnro);
            $query->execute();
            $subvend = $query->fetchAll();

            $Vendedor = [];
            foreach ($subvend as $jk) {
                $Vendedor[] =  ltrim($jk['nome']);
            }
        }



        $placeholders = str_repeat('?,', count($Vendedor) - 1) . '?';

//----------------------------------------------------------------------------------------------------------------//

        $query = $conn->prepare("SELECT * from ft where Nome in ($placeholders)");

        // Bind each value to the corresponding placeholder

        $query->execute($Vendedor);
        $Vft = $query->fetchAll();

//----------------------------------------------------------------------------------------------------------------//

        $query= $conn1->prepare("
        select a.grupocl,vnd,vendedor,sum(CC_Aberto) ccaberta,sum(N_vencida) n_vencida   from (
        select u_grupocl GrupoCL, 
        convert(varchar,datalc,102) Data,iif(convert(varchar, datalc+cl.alimite,102)>getdate(),0,(edeb-edebf)-(ecred-ecredf)) CC_limite,cl.alimite,convert(varchar,dataven,102) vencimento,cmdesc+space(1)+convert(varchar,nrdoc) Documento, 
        convert(varchar,cc.no) no,convert(varchar,cc.estab) Estab, cl.nome,cl.nome2 Estabelecimento,cl.zona Zona,cl.vendedor vnd,cl.vendnm Vendedor, 
        convert(numeric(10,2),(edeb-edebf)-(ecred-ecredf))  CC_Aberto,
        convert(numeric(10,2),case when dataven > GETDATE() then (edeb-edebf)-(ecred-ecredf) else 0 end) N_vencida,
        convert(numeric(10,2),case when DATEDIFF(dd,dataven,getdate()) between 0 and 180 then (edeb-edebf)-(ecred-ecredf) else 0 end) Vencida_6m,
        DATEDIFF(dd,dataven,getdate()) dias 
        from cc (nolock) join cl (nolock) on cc.no=cl.no and cl.estab=cc.estab
        where cl.U_EANL  =0 and (edeb<> edebf OR ecred<>ECREDF) and ((edeb-edebf)-(ecred-ecredf))<>0
        union all
        --trocado a segunda condição do iif de evalor para 0 (TTC 6743 Filipe Ribeiro)
        select 
        u_grupocl GrupoCL, 
        convert(varchar,DATAEM  ,102) Data,iif(convert(varchar, DATA )>getdate(),0,0) CC_limite,cl.alimite,convert(varchar,DATA,102) vencimento,'Titulo'+space(1)+convert(varchar,clcheque) Documento, 
        convert(varchar,ch.no) no,convert(varchar,ch.estab) Estab, cl.nome,cl.nome2 Estabelecimento,cl.zona Zona,cl.vendedor vnd,cl.vendnm Vendedor, 
        convert(numeric(10,2),evalor)  CC_Aberto,
        convert(numeric(10,2),case when data > GETDATE() then evalor else 0 end) N_vencida,
        convert(numeric(10,2),case when DATEDIFF(dd,data,getdate()) between 0 and 180 then evalor else 0 end) Vencida_6m,
        DATEDIFF(dd,data,getdate()) dias 
        from ch 
        join cl on cl.no = ch.no and cl.estab = ch.estab
        where   cl.U_EANL  = 0 and ch.status = 1
        ) a left join u_cm3zona b on a.vnd=b.cm and a.zona=b.zona and b.mzona=1
        where vendedor in ($placeholders)
        group by a.grupocl,vnd,vendedor
        ");

        $query->execute($Vendedor);
        $CC = $query->fetchAll();

//----------------------------------------------------------------------------------------------------------------//

        $query = $conn->prepare("SELECT * from crv where mes = $m nome in ($placeholders) and ano = ?  and mes <= ?");

        // Bind each value to the corresponding placeholder

        $params = array_merge($Vendedor, [$y, $m]);
        $crv = $query->fetchAll();

//----------------------------------------------------------------------------------------------------------------//
        
        $query = $conn->prepare("SELECT * from obj where Nome in ($placeholders)");

        // Bind each value to the corresponding placeholder      
        $query->execute($Vendedor);
        $Vobj = $query->fetchAll();

//----------------------------------------------------------------------------------------------------------------//

        $query = $conn->prepare("SELECT sum(valor) as total, mes, ano from ft where (nome in ($placeholders) and ano = ?  and mes <= ?  ) or (nome in ($placeholders) and ano = ?  and mes >= ? ) group by mes, ano order by ano desc, mes desc");

        // Bind each value to the corresponding placeholder

        $params = array_merge($Vendedor, [$y, $m], $Vendedor, [$y, $m]);
        $query->execute($params);
        $graficoft = $query->fetchAll();

//----------------------------------------------------------------------------------------------------------------//

        $query = $conn->prepare("SELECT sum(valor) as total, mes, ano from obj where (nome in ($placeholders) and ano = ?  AND mes <= ? ) or (nome in ($placeholders) and ano = ?  AND mes >= ? ) group by mes, ano order by ano desc, mes desc");

        // Bind each value to the corresponding placeholder       
        $params = array_merge($Vendedor, [$y, $m], $Vendedor, [$y, $m]);
        $query->execute($params);
        $graficoobj = $query->fetchAll();
    }
} else {

    date_default_timezone_set("Europe/London");
    $y = date('Y');
    $m = ltrim(date('m'), '0');

    $query = "SELECT * from us where nome = '" . $login . "' and vnd > 0 ";
    $ifvend = $conn->query($query)->fetchAll();

    if (isset($ifvend[0]['vnd'])) {

        $Vendedor = $login;
        $query = "select * from ft where Nome= '" . $Vendedor . "'";
        $Vft = $conn->query($query)->fetchAll();

//----------------------------------------------------------------------------------------------------------------//

        $query= "
        select a.grupocl,vnd,vendedor,sum(CC_Aberto) ccaberta,sum(N_vencida) n_vencida   from (
        select u_grupocl GrupoCL, 
        convert(varchar,datalc,102) Data,iif(convert(varchar, datalc+cl.alimite,102)>getdate(),0,(edeb-edebf)-(ecred-ecredf)) CC_limite,cl.alimite,convert(varchar,dataven,102) vencimento,cmdesc+space(1)+convert(varchar,nrdoc) Documento, 
        convert(varchar,cc.no) no,convert(varchar,cc.estab) Estab, cl.nome,cl.nome2 Estabelecimento,cl.zona Zona,cl.vendedor vnd,cl.vendnm Vendedor, 
        convert(numeric(10,2),(edeb-edebf)-(ecred-ecredf))  CC_Aberto,
        convert(numeric(10,2),case when dataven > GETDATE() then (edeb-edebf)-(ecred-ecredf) else 0 end) N_vencida,
        convert(numeric(10,2),case when DATEDIFF(dd,dataven,getdate()) between 0 and 180 then (edeb-edebf)-(ecred-ecredf) else 0 end) Vencida_6m,
        DATEDIFF(dd,dataven,getdate()) dias 
        from cc (nolock) join cl (nolock) on cc.no=cl.no and cl.estab=cc.estab
        where cl.U_EANL  =0 and (edeb<> edebf OR ecred<>ECREDF) and ((edeb-edebf)-(ecred-ecredf))<>0
        union all
        --trocado a segunda condição do iif de evalor para 0 (TTC 6743 Filipe Ribeiro)
        select 
        u_grupocl GrupoCL, 
        convert(varchar,DATAEM  ,102) Data,iif(convert(varchar, DATA )>getdate(),0,0) CC_limite,cl.alimite,convert(varchar,DATA,102) vencimento,'Titulo'+space(1)+convert(varchar,clcheque) Documento, 
        convert(varchar,ch.no) no,convert(varchar,ch.estab) Estab, cl.nome,cl.nome2 Estabelecimento,cl.zona Zona,cl.vendedor vnd,cl.vendnm Vendedor, 
        convert(numeric(10,2),evalor)  CC_Aberto,
        convert(numeric(10,2),case when data > GETDATE() then evalor else 0 end) N_vencida,
        convert(numeric(10,2),case when DATEDIFF(dd,data,getdate()) between 0 and 180 then evalor else 0 end) Vencida_6m,
        DATEDIFF(dd,data,getdate()) dias 
        from ch 
        join cl on cl.no = ch.no and cl.estab = ch.estab
        where   cl.U_EANL  = 0 and ch.status = 1
        ) a left join u_cm3zona b on a.vnd=b.cm and a.zona=b.zona and b.mzona=1
        where vendedor= '" . $Vendedor . "'
        group by a.grupocl,vnd,vendedor
        ";

        $CC = $conn1->query($query)->fetchAll();

//----------------------------------------------------------------------------------------------------------------//

        $query = "select * from obj where Nome= '" . $Vendedor . "'";
        $Vobj = $conn->query($query)->fetchAll();

//----------------------------------------------------------------------------------------------------------------//

        $query = "select sum(valor) as total, mes, ano from ft where (Nome= '" . $Vendedor . "' and ano = " . $y . " and mes <= " . $m . ") or (Nome= '" . $Vendedor . "' and ano = " . ($y - 1) . " and mes >= " . $m . ") group by mes, ano order by ano desc, mes desc";
        $graficoft = $conn->query($query)->fetchAll();

//----------------------------------------------------------------------------------------------------------------//

        $query = "select sum(valor) as total, mes, ano from obj where (Nome= '" . $Vendedor . "' and ano = " . $y . " and mes <= " . $m . ") or (Nome= '" . $Vendedor . "' and ano = " . ($y - 1) . " and mes >= " . $m . ") group by mes, ano order by ano desc, mes desc";
        $graficoobj = $conn->query($query)->fetchAll();
    } else {

        $query = "select * from ft where Nome= '' ";
        $Vft = $conn->query($query)->fetchAll();

//----------------------------------------------------------------------------------------------------------------//

        $query = "select * from obj where Nome= ''";
        $Vobj = $conn->query($query)->fetchAll();

//----------------------------------------------------------------------------------------------------------------//

        $query = "select sum(valor) as total, mes, ano from ft where (Nome= '' and ano = " . $y . " and mes <= " . $m . ") or (Nome= '' and ano = " . ($y - 1) . " and mes >= " . $m . ") group by mes, ano order by ano desc, mes desc";
        $graficoft = $conn->query($query)->fetchAll();

//----------------------------------------------------------------------------------------------------------------//

        $query = "select sum(valor) as total, mes, ano from obj where (Nome= '' and ano = " . $y . " and mes <= " . $m . ") or (Nome= '' and ano = " . ($y - 1) . " and mes >= " . $m . ") group by mes, ano order by ano desc, mes desc";
        $graficoobj = $conn->query($query)->fetchAll();
    
//----------------------------------------------------------------------------------------------------------------//

    $query= "
    select a.grupocl,vnd,vendedor,sum(CC_Aberto) ccaberta,sum(N_vencida) n_vencida   from (
    select u_grupocl GrupoCL, 
    convert(varchar,datalc,102) Data,iif(convert(varchar, datalc+cl.alimite,102)>getdate(),0,(edeb-edebf)-(ecred-ecredf)) CC_limite,cl.alimite,convert(varchar,dataven,102) vencimento,cmdesc+space(1)+convert(varchar,nrdoc) Documento, 
    convert(varchar,cc.no) no,convert(varchar,cc.estab) Estab, cl.nome,cl.nome2 Estabelecimento,cl.zona Zona,cl.vendedor vnd,cl.vendnm Vendedor, 
    convert(numeric(10,2),(edeb-edebf)-(ecred-ecredf))  CC_Aberto,
    convert(numeric(10,2),case when dataven > GETDATE() then (edeb-edebf)-(ecred-ecredf) else 0 end) N_vencida,
    convert(numeric(10,2),case when DATEDIFF(dd,dataven,getdate()) between 0 and 180 then (edeb-edebf)-(ecred-ecredf) else 0 end) Vencida_6m,
    DATEDIFF(dd,dataven,getdate()) dias 
    from cc (nolock) join cl (nolock) on cc.no=cl.no and cl.estab=cc.estab
    where cl.U_EANL  =0 and (edeb<> edebf OR ecred<>ECREDF) and ((edeb-edebf)-(ecred-ecredf))<>0
    union all
    --trocado a segunda condição do iif de evalor para 0 (TTC 6743 Filipe Ribeiro)
    select 
    u_grupocl GrupoCL, 
    convert(varchar,DATAEM  ,102) Data,iif(convert(varchar, DATA )>getdate(),0,0) CC_limite,cl.alimite,convert(varchar,DATA,102) vencimento,'Titulo'+space(1)+convert(varchar,clcheque) Documento, 
    convert(varchar,ch.no) no,convert(varchar,ch.estab) Estab, cl.nome,cl.nome2 Estabelecimento,cl.zona Zona,cl.vendedor vnd,cl.vendnm Vendedor, 
    convert(numeric(10,2),evalor)  CC_Aberto,
    convert(numeric(10,2),case when data > GETDATE() then evalor else 0 end) N_vencida,
    convert(numeric(10,2),case when DATEDIFF(dd,data,getdate()) between 0 and 180 then evalor else 0 end) Vencida_6m,
    DATEDIFF(dd,data,getdate()) dias 
    from ch 
    join cl on cl.no = ch.no and cl.estab = ch.estab
    where   cl.U_EANL  = 0 and ch.status = 1
    
    ) a left join u_cm3zona b on a.vnd=b.cm and a.zona=b.zona and b.mzona=1
    where vendedor= ''
    group by a.grupocl,vnd,vendedor
    ";

    $CC = $conn1->query($query)->fetchAll();

    }
}
