<?php
include 'config.php';
include 'confignewco.php';


$ty = date('Y');
$tm = date('m');
$tdata = date('Y-m-d');

$query = "SELECT * from us where nome = '" . $login . "' and vnd > 0 ";
$USER = $conn->query($query)->fetchall();

if (count($USER) > 0) {
    foreach ($USER as $u) {
        $vnd = $u['vnd'];
    }
} else {
    $vnd = 9;
}

$comissao = 0;
$fact365 = 0;
$divida = 0;
$ccaberta = 0;
$ccvencida = 0;

if (isset($_POST['submit'])) {
    $vnds = $_POST['vendedor'];
    array_walk($vnds, function (&$val) {
        $val = ltrim($val);
    });

    $placeholder = str_repeat('?,', count($vnds) - 1) . '?';

    $query = $conn->prepare("SELECT vnd,usrno from us where Nome in ($placeholder)");

    // Bind each value to the corresponding placeholder
    $query->execute($vnds);
    $kpinrvnd = $query->fetchAll();

    $vnd = [];
    $nrvend = [];
    foreach ($kpinrvnd as $kl) {
        $nrvend = ltrim($kl['usrno']);
        $query = $conn->prepare("SELECT nome FROM dbo.subordinados(:ghj) order by nivel asc");
        $query->bindvalue(':ghj', $nrvend);
        $query->execute();
        $subvend = $query->fetchAll();


        foreach ($subvend as $jk) {
            $vnd[] =  ltrim($jk['nome']);
        }
    }
    $placeholders = str_repeat('?,', count($vnd) - 1) . '?';

    $query = $conn1->prepare("select vendedor,sum(valor) as cm
 from u_rv where year(dtpag)=" . $ty . " and month(dtpag)=" . $tm . "  and nomevendedor in ($placeholders) 
 group by vendedor");
    $query->execute($vnd);
    $result = $query->fetchAll();


    foreach ($result as $r) {
        $comissao += $r['cm'];
    }

    $query = $conn1->prepare(" with rec as (
select ano,mes,vendedor vnd ,sum(valor) recebido from (
select year(rdata) ano , month(rdata)mes,vendedor, etotal valor
from re (nolock) where rdata >='20240201'   and re.anulado=0
union all
select  year(fdata) ano , month(fdata) mes,vendedor,  etotal  valor
from ft (nolock) join td (nolock) on ft.ndoc=td.ndoc  where lancaol=1
and fdata >='20240201'  and ft.anulado=0
) x  group by ano,mes,vendedor
), 
obj as(
select ano,mes,isnull(u_obj.vendedor,0) vnd,sum(valor) ValorObj
from  u_obj (nolock) 
where  DATEFROMPARTS(ano,mes,1) >= DATEFROMPARTS('2024',2,1) and vendedor=227
and u_obj.inactivo=0
group by  u_obj.vendedor, ano,mes 
), 
fact as (
select  year(fdata) ano ,month(fdata) mes,ft.vendedor vnd, 
convert(numeric(10,2),sum(case when fi.ivaincl=0 then etiliquido else etiliquido/(1+iva/100) end))    as Valorft
from fi (nolock) join ft (nolock) on fi.ftstamp=ft.ftstamp 
left join st (nolock)  on case when fi.ref='' then fi.oref else fi.ref end=st.ref   
where  ft.fdata >= DATEFROMPARTS(2024,2,1)
and ft.vendnm<>'GRUPO' and st.u_com=0 and 
(ft.tipodoc<>4 and ft.tipodoc<>5) and ft.anulado=0
group by year(fdata),month(fdata)  ,ft.vendedor
union all
select year(fdata) ano ,month(fdata) mes, pn.vendedor, sum( convert(numeric(15,2),etiliquido)) 
from  pn (nolock)  
join st (nolock)   on pn.ref=st.ref
where nmdoc='V/ Fatura CL' and 
fdata >= DATEFROMPARTS(2024,2,1)
and pn.vendnm<>'GRUPO' and st.u_com=0
group by  year(fdata),month(fdata)  , pn.vendedor
)
select obj.ano,obj.mes,obj.vnd,valorobj,valorft,convert(numeric(10,2),recebido) recebido 
from obj join fact on obj.ano=fact.ano and obj.mes=fact.mes and obj.vnd=fact.vnd
join rec on obj.ano=rec.ano and obj.mes=rec.mes and obj.vnd=rec.vnd
order by 1,2,3");

    $query->execute($vnd);
    $grafico = $query->fetchAll();



    $query = $conn1->prepare("select top 1 vnd,zona,grupocl,sum(Divida) divida,sum(Fact365) Fact365 from(
select cl.u_GrupoCl grupocl,cl.no,cl.estab,cl.Nome,cl.estab Establecimento,cl.zona,cl.vendedor vnd,cl.vendnm vendedor, isnull(mzona,0) mzona ,
isnull(SUM(cc_aberto),0)  Divida, isnull(sum(Valor),0) Fact365
from 
(
select cl.no,cl.estab,
isnull( round(sum(etiliquido* (1+iva/100)) ,2) ,0) as Valor   from pn 
left join st  on pn.ref = st.ref
left join cl  on pn.no=cl.no and cl.estab=pn.estab  
where pn.fdata between  dateadd(dd,-1, datefromparts(" . $ty . "-1," . $tm . "+1,1))  and  dateadd(dd,-1, datefromparts(" . $ty . "," . $tm . "+1,1) )
and cl.vendnm<>'GRUPO' and st.u_com=0 and nmdoc <>'Historico MQ'
group by cl.no,cl.estab
union all
select cl.no,cl.estab,
isnull(round(sum(etiliquido),2),0)  as Valor 
from fi  join ft  on fi.ftstamp=ft.ftstamp 
left join st  on case when fi.ref='' then fi.oref else fi.ref end=st.ref   
join cl  on ft.no=cl.no and cl.estab=ft.estab  
where ft.fdata between  dateadd(dd,-1, datefromparts(" . $ty . "-1," . $tm . "+1,1))  and  dateadd(dd,-1, datefromparts(" . $ty . "," . $tm . "+1,1) )
 and ft.ndoc = 13 and ft.anulado=0
group by cl.no,cl.estab
) a  left join (
select  CC.NO,CC.ESTAB,sum(convert(numeric(10,2),(edeb-edebf)-(ecred-ecredf)))  CC_Aberto 
from cc  where edeb<> edebf OR ecred<>ECREDF group by CC.NO,CC.ESTAB
) b on a.no=b.no and a.estab=b.estab
left join cl  on cl.no=a.no and cl.estab=a.estab
left join u_cm3zona c on C.cm=cl.vendedor and C.zona=cl.zona
where mzona = 1
group by  cl.u_GrupoCl,cl.no,cl.estab,cl.Nome,cl.estab,cl.zona,cl.vendedor,cl.vendnm , isnull(mzona,0)
 ) x  where vendedor in( $placeholders)
 group by vnd,zona ,grupocl");

    $query->execute($vnd);
    $rpmr = $query->fetchAll();

    foreach ($rpmr as $p) {
        $divida += $p['divida'];
        $fact365 += $p['Fact365'];
    }

    $pmr = $divida / $fact365 * 365;

    $query = $conn1->prepare("select a.*,isnull(b.mzona,0) mzona,isnull(b.ecom,0) ecom from (
select u_grupocl GrupoCL, 
convert(varchar,datalc,102) Data,iif(convert(varchar, datalc+cl.alimite,102)>getdate(),0,(edeb-edebf)-(ecred-ecredf)) CC_limite,cl.alimite,convert(varchar,dataven,102) vencimento,cmdesc+space(1)+convert(varchar,nrdoc) Documento, 
convert(varchar,cc.no) no,convert(varchar,cc.estab) Estab, cl.nome,cl.nome2 Estabelecimento,cl.zona Zona,cl.vendedor vnd,cl.vendnm Vendedor, 
convert(numeric(10,2),(edeb-edebf)-(ecred-ecredf))  CC_Aberto,
convert(numeric(10,2),case when dataven > GETDATE() then (edeb-edebf)-(ecred-ecredf) else 0 end) N_vencida,
convert(numeric(10,2),case when DATEDIFF(dd,dataven,getdate()) between 0 and 180 then (edeb-edebf)-(ecred-ecredf) else 0 end) Vencida_6m,
DATEDIFF(dd,dataven,getdate()) dias 
from cc  join cl  on cc.no=cl.no and cl.estab=cc.estab
where cl.U_EANL =0 and (edeb<> edebf OR ecred<>ECREDF) and ((edeb-edebf)-(ecred-ecredf))<>0
union all
select 
u_grupocl GrupoCL, 
convert(varchar,DATAEM  ,102) Data,iif(convert(varchar, DATA )>getdate(),0,0) CC_limite,cl.alimite,convert(varchar,DATA,102) vencimento,'Titulo'+space(1)+convert(varchar,clcheque) Documento, 
convert(varchar,ch.no) no,convert(varchar,ch.estab) Estab, cl.nome,cl.nome2 Estabelecimento,cl.zona Zona,cl.vendedor vnd,cl.vendnm Vendedor, 
convert(numeric(10,2),evalor)  CC_Aberto,
convert(numeric(10,2),case when data > GETDATE() then evalor else 0 end) N_vencida,
convert(numeric(10,2),case when DATEDIFF(dd,data,getdate()) between 0 and 180 then evalor else 0 end) Vencida_6m,
DATEDIFF(dd,data,getdate()) dias 
from ch 
join cl  on cl.no = ch.no and cl.estab = ch.estab
where cl.U_EANL  = 0 and ch.status = 1 
) a left join u_cm3zona  b on a.vnd=b.cm and a.zona=b.zona where vendedor in ($placeholders) and mzona = 1");

    $query->execute($vnd);
    $cc = $query->fetchAll();

    foreach ($cc as $c) {
        $ccaberta += $c['CC_Aberto'];
        $ccvencida += $c['N_vencida'];
    }
} else {


    $query = "select vendedor,sum(valor) as cm
 from u_rv where year(dtpag)=" . $ty . " and month(dtpag)=" . $tm . "  and vendedor = " . $vnd . "
 group by vendedor";
    $result = $conn1->query($query)->fetchall();

    foreach ($result as $r) {
        $comissao += $r['cm'];
    }

    $query = " with rec as (
select ano,mes,vendedor vnd ,sum(valor) recebido from (
select year(rdata) ano , month(rdata)mes,vendedor, etotal valor
from re (nolock) where rdata >='20240201'   and re.anulado=0
union all
select  year(fdata) ano , month(fdata) mes,vendedor,  etotal  valor
from ft (nolock) join td (nolock) on ft.ndoc=td.ndoc  where lancaol=1
and fdata >='20240201'  and ft.anulado=0
) x  group by ano,mes,vendedor
), 
obj as(
select ano,mes,isnull(u_obj.vendedor,0) vnd,sum(valor) ValorObj
from  u_obj (nolock) 
where  DATEFROMPARTS(ano,mes,1) >= DATEFROMPARTS('2024',2,1) and vendedor=227
and u_obj.inactivo=0
group by  u_obj.vendedor, ano,mes 
), 
fact as (
select  year(fdata) ano ,month(fdata) mes,ft.vendedor vnd, 
convert(numeric(10,2),sum(case when fi.ivaincl=0 then etiliquido else etiliquido/(1+iva/100) end))    as Valorft
from fi (nolock) join ft (nolock) on fi.ftstamp=ft.ftstamp 
left join st (nolock)  on case when fi.ref='' then fi.oref else fi.ref end=st.ref   
where  ft.fdata >= DATEFROMPARTS(2024,2,1)
and ft.vendnm<>'GRUPO' and st.u_com=0 and 
(ft.tipodoc<>4 and ft.tipodoc<>5) and ft.anulado=0
group by year(fdata),month(fdata)  ,ft.vendedor
union all
select year(fdata) ano ,month(fdata) mes, pn.vendedor, sum( convert(numeric(15,2),etiliquido)) 
from  pn (nolock)  
join st (nolock)   on pn.ref=st.ref
where nmdoc='V/ Fatura CL' and 
fdata >= DATEFROMPARTS(2024,2,1)
and pn.vendnm<>'GRUPO' and st.u_com=0
group by  year(fdata),month(fdata)  , pn.vendedor
)
select obj.ano,obj.mes,obj.vnd,valorobj,valorft,convert(numeric(10,2),recebido) recebido 
from obj join fact on obj.ano=fact.ano and obj.mes=fact.mes and obj.vnd=fact.vnd
join rec on obj.ano=rec.ano and obj.mes=rec.mes and obj.vnd=rec.vnd
order by 1,2,3";

    $grafico = $conn1->query($query)->fetchall();

    $query = "select top 1 vnd,zona,grupocl,sum(Divida) divida,sum(Fact365) Fact365 from(
select cl.u_GrupoCl grupocl,cl.no,cl.estab,cl.Nome,cl.estab Establecimento,cl.zona,cl.vendedor vnd,cl.vendnm vendedor, isnull(mzona,0) mzona ,
isnull(SUM(cc_aberto),0)  Divida, isnull(sum(Valor),0) Fact365
from 
(
select cl.no,cl.estab,
isnull( round(sum(etiliquido* (1+iva/100)) ,2) ,0) as Valor   from pn 
left join st  on pn.ref = st.ref
left join cl  on pn.no=cl.no and cl.estab=pn.estab  
where pn.fdata between  dateadd(dd,-1, datefromparts(" . $ty . "-1," . $tm . "+1,1))  and  dateadd(dd,-1, datefromparts(" . $ty . "," . $tm . "+1,1) )
and cl.vendnm<>'GRUPO' and st.u_com=0 and nmdoc <>'Historico MQ'
group by cl.no,cl.estab
union all
select cl.no,cl.estab,
isnull(round(sum(etiliquido),2),0)  as Valor 
from fi  join ft  on fi.ftstamp=ft.ftstamp 
left join st  on case when fi.ref='' then fi.oref else fi.ref end=st.ref   
join cl  on ft.no=cl.no and cl.estab=ft.estab  
where ft.fdata between  dateadd(dd,-1, datefromparts(" . $ty . "-1," . $tm . "+1,1))  and  dateadd(dd,-1, datefromparts(" . $ty . "," . $tm . "+1,1) )
 and ft.ndoc = 13 and ft.anulado=0
group by cl.no,cl.estab
) a  left join (
select  CC.NO,CC.ESTAB,sum(convert(numeric(10,2),(edeb-edebf)-(ecred-ecredf)))  CC_Aberto 
from cc  where edeb<> edebf OR ecred<>ECREDF group by CC.NO,CC.ESTAB
) b on a.no=b.no and a.estab=b.estab
left join cl  on cl.no=a.no and cl.estab=a.estab
left join u_cm3zona c on C.cm=cl.vendedor and C.zona=cl.zona
group by  cl.u_GrupoCl,cl.no,cl.estab,cl.Nome,cl.estab,cl.zona,cl.vendedor,cl.vendnm , isnull(mzona,0)
 ) x  where vnd = " . $vnd . "
 group by vnd,zona ,grupocl";

    $rpmr = $conn1->query($query)->fetchall();

    foreach ($rpmr as $p) {
        $divida += $p['divida'];
        $fact365 += $p['Fact365'];
    }

    $pmr = $divida / $fact365 * 365;

    $query = "select a.*,isnull(b.mzona,0) mzona,isnull(b.ecom,0) ecom from (
select u_grupocl GrupoCL, 
convert(varchar,datalc,102) Data,iif(convert(varchar, datalc+cl.alimite,102)>getdate(),0,(edeb-edebf)-(ecred-ecredf)) CC_limite,cl.alimite,convert(varchar,dataven,102) vencimento,cmdesc+space(1)+convert(varchar,nrdoc) Documento, 
convert(varchar,cc.no) no,convert(varchar,cc.estab) Estab, cl.nome,cl.nome2 Estabelecimento,cl.zona Zona,cl.vendedor vnd,cl.vendnm Vendedor, 
convert(numeric(10,2),(edeb-edebf)-(ecred-ecredf))  CC_Aberto,
convert(numeric(10,2),case when dataven > GETDATE() then (edeb-edebf)-(ecred-ecredf) else 0 end) N_vencida,
convert(numeric(10,2),case when DATEDIFF(dd,dataven,getdate()) between 0 and 180 then (edeb-edebf)-(ecred-ecredf) else 0 end) Vencida_6m,
DATEDIFF(dd,dataven,getdate()) dias 
from cc  join cl  on cc.no=cl.no and cl.estab=cc.estab
where cl.U_EANL =0 and (edeb<> edebf OR ecred<>ECREDF) and ((edeb-edebf)-(ecred-ecredf))<>0
union all
select 
u_grupocl GrupoCL, 
convert(varchar,DATAEM  ,102) Data,iif(convert(varchar, DATA )>getdate(),0,0) CC_limite,cl.alimite,convert(varchar,DATA,102) vencimento,'Titulo'+space(1)+convert(varchar,clcheque) Documento, 
convert(varchar,ch.no) no,convert(varchar,ch.estab) Estab, cl.nome,cl.nome2 Estabelecimento,cl.zona Zona,cl.vendedor vnd,cl.vendnm Vendedor, 
convert(numeric(10,2),evalor)  CC_Aberto,
convert(numeric(10,2),case when data > GETDATE() then evalor else 0 end) N_vencida,
convert(numeric(10,2),case when DATEDIFF(dd,data,getdate()) between 0 and 180 then evalor else 0 end) Vencida_6m,
DATEDIFF(dd,data,getdate()) dias 
from ch 
join cl  on cl.no = ch.no and cl.estab = ch.estab
where cl.U_EANL  = 0 and ch.status = 1 
) a left join u_cm3zona  b on a.vnd=b.cm and a.zona=b.zona where vnd = " . $vnd . " and mzona = 1";

    $cc = $conn1->query($query)->fetchall();

    foreach ($cc as $c) {
        $ccaberta += $c['CC_Aberto'];
        $ccvencida += $c['N_vencida'];
    }
}
