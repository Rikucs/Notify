<?php

include 'config.php';
include 'confignewco.php';

SESSION_START();
$login = ucfirst($_SESSION['login']);

$query = "select usrno,nome,dir  from us where nome ='" . $login . "'";
$useres= $conn->query($query)->fetchAll();
foreach ($useres as $u) {
    $uc = $u['usrno'];
    $udir = $u['dir'];
}

$stmt = $conn->prepare("select count(*)
from dst (nolock) a join us (nolock) c on c.usrno=a.usrno 
where  nome='".$login."' and data='19000101' and lida='19000101' ");
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
foreach ($result as $r) {
    $ns = $r;
}

$query ="select nome,msgno
from dst (nolock) a join us (nolock) c on c.usrno=a.usrno 
where  nome='".$login."' and data='19000101' and lida='19000101'";
$nosino = $conn->query($query)->fetchAll();

$query = "select * from Tipo where DSPUSR = 1";
$dda = $conn->query($query)->fetchAll();

$query = "select convert(varchar(100),a0.campo) campo ,A0.mzona,
isnull(a1.valor,0) Clientes,
isnull(convert(numeric(10,0),isnull(a2.valor,0)),0) Objectivo,
isnull(convert(numeric(10,0),isnull(a4.valor,0)),0) Facturacao,
isnull(convert(numeric(10,0),isnull(a4.valor,0)-isnull(a2.valor,0)),0) DesvioFact,
isnull(convert(numeric(10,0),isnull(a4.kg,0)),0) Kg,
convert(numeric(10,2),isnull(convert(numeric(10,0),isnull(a4.valor,0))/ nullif(convert(numeric(10,0),isnull(a4.kg,0)),0) ,0)) PMV,
isnull(convert(numeric(10,0),isnull(a3.valor,0)),0) FactPend,
isnull(convert(numeric(10,0),isnull(a3.valor,0))+convert(numeric(10,0),isnull(a4.valor,0)),0) FactPrevista,
isnull((convert(numeric(10,0),isnull(a3.valor,0))+convert(numeric(10,0),isnull(a4.valor,0)))-convert(numeric(10,0),isnull(a2.valor,0)),0) desvftprev,
isnull(convert(numeric(10,0),isnull(a5.valor,0)),0) Recebido,
isnull(convert(numeric(10,0),isnull(a6.valor,0)),0) RecSiva,
isnull(convert(numeric(10,0),isnull(a7.cc_aberto,0)),0) Cc_Aberta,
isnull(convert(numeric(10,0),isnull(a7.n_vencida,0)),0) n_vencida,
convert(numeric(10,2),isnull(convert(numeric(10,0),isnull(a7.cc_aberto,0))  /  nullif(convert(numeric(10,0),isnull(a8.fact,0)),0)  * 365,0))  PMR,
isnull(convert(numeric(10,0),isnull(a2.valoracum,0)),0) ObjAcumulado,
isnull(convert(numeric(10,0),isnull(a9.factacum,0)),0) FactAcumulada,
isnull(convert(numeric(10,0),isnull(a9.factacum,0)) - convert(numeric(10,0),isnull(a2.valoracum,0)),0) DesvFactAcum,
isnull(convert(numeric(10,0),isnull(a3.valor,0))+ convert(numeric(10,0),isnull(a9.factacum,0)),0) FactPrevAcum,
isnull((convert(numeric(10,0),isnull(a3.valor,0))+convert(numeric(10,0),isnull(a9.factacum,0))) -convert(numeric(10,0),isnull(a2.valoracum,0)),0) DesvFactPrevAcum,
isnull(convert(numeric(10,0),isnull(a7.CC_limite,0)),0)  'CC_limite',isnull(a10.facthom,0) 'FT_ANT_AC', isnull(a12.factclinte-a10.facthom,0) + isnull(convert(numeric(10,0),isnull(a3.valor,0)),0) as 'Desvio_FT_ANT_AC' ,
convert(numeric(10,0),isnull(a8.fact,0)) fact365,convert(numeric(10,2),isnull(a11.newcom,0)) newcom
from
(select cm3.cmdesc ,cm3.cm vnd,zona campo,mzona from u_cm3zona join cm3 on cm3.cm3stamp = u_cm3zona.cm3stamp  where cm3.cmdesc = 'avelino soares'   and zona in (select  zona   from u_cm3zona (nolock) where cm = 236 )) a0
left join
(select vnd,zona,round(count(*),0) valor from (select distinct vnd,no,estab,zona from u_dashv4Clientes) x group by vnd,zona) a1 on a0.vnd=a1.vnd and a0.campo = a1.zona
left join
(select vnd,zona,SUM(obj) valor,SUM(objacum) valoracum from u_dashv4objectivos group by vnd,zona) a2 on a0.vnd = a2.vnd and a0.campo = a2.zona
left join
(select vnd,zona,SUM(valor) valor from u_dashv4factpendente group by vnd,zona) a3 on a0.vnd = a3.vnd and a0.campo = a3.zona
left join
(select vnd,zona,SUM(Valor) valor,SUM(kg) kg from u_dashv4facturacao group by vnd,zona) a4 on a0.vnd=a4.vnd and a0.campo = a4.zona
left join
(select vnd,zona,SUM(Valor) valor from u_dashv4Recebido group by vnd,Zona) a5 on a0.vnd=a5.vnd and a0.campo = a5.zona
left join
(select vnd,zona,SUM(Valor) valor from u_dashv4RecLiquido group by vnd,zona) a6 on a0.vnd=a6.vnd and a0.campo = a6.zona
left join
(select vnd,zona,SUM(cc_aberto) cc_aberto,SUM(n_vencida) n_vencida,SUM(vencida_6m) vencida_6m,sum(CC_limite) CC_limite from u_dashv4ccaberta  where mzona = 1 group by vnd,zona) a7 on a0.vnd=a7.vnd and a0.campo = a7.zona
left join
(select vnd,zona,sum(divida) divida,sum(fact365) fact from u_dashv4PMR   group by vnd,zona   ) a8 on a0.vnd=a8.vnd  and a0.campo = a8.zona
left join
(select vnd,zona,SUM(valor) factacum from u_dashv4factacumulada group by vnd,zona) a9 on a0.vnd=a9.vnd and a0.campo = a9.zona
left join
(select vnd,zona,SUM(valor) facthom from u_dashv4facthomologa group by vnd,zona) a10 on a0.vnd=a10.vnd and a0.campo = a10.zona
left join
(select r_vend_no vnd,zona,SUM(valor) newcom from u_dashv4Comissao   group by r_vend_no,zona) a11 on a0.vnd=a11.vnd and a0.campo = a11.zona
left join
(select vnd,zona,SUM(valor) factclinte from u_DashV4Facturacaoclientes group by vnd,zona) a12 on a0.vnd=a12.vnd and a0.campo = a12.zona
where  isnull(a1.valor,0)+ isnull(a2.valor,0)+isnull(a9.factacum,0)+isnull(a5.valor,0) + isnull(a7.CC_limite,0) + isnull(a11.newcom,0) <>0
order by cmdesc,campo";
$Dados = $conn1->query($query)->fetchAll();

?>