<?php
include 'config.php';
SESSION_START();
$login = ucfirst($_SESSION['login']);
$query = "select usrno,nome,dir  from us where nome <> '" . $login . "' order by nome Asc";
$user= $conn->query($query)->fetchAll();
$query = "select usrno,nome,dir  from us where nome ='" . $login . "'";
$useres= $conn->query($query)->fetchAll();
foreach ($useres as $u) {
    $uc = $u['usrno'];
}


// Query para obter os dados para a tabela de notificaçoes recebidas

$query = "select a.msgno,a.data,e.nome,a.assunto ,iif(b.rspt='',iif(lida<>'19000101','2','0'),'1') status,
iif(b.data='19000101',iif(lida<>'19000101',lida,''),b.data) Data, b.rspt, 
(select count(*) from doc (nolock) where msgno=a.msgno) clip
from ntf (nolock) a join dst (nolock) b  on a.msgno=b.msgno
join us (nolock) c on c.usrno=b.usrno -- receiver
join us (nolock) e on a.usrno=e.usrno -- sender
where  c.nome='" . $login . "'";
$notify = $conn->query($query)->fetchAll();
$n_count = count($notify);

// Query para obter os dados para a tabela de notificaçoes enviadas

$query = "select a.msgno,a.data,e.nome,a.assunto ,
(select isnull(convert(numeric(10,2),count(*)) /nullif(sum(iif(rspt > '',1,0)),0),0) 
from dst (nolock) where msgno=a.msgno) status,
-- status = 1 todos respondidos, 0 = nenhum respondido, > 1 alguns respondidos
(select count(*) from doc (nolock) where msgno=a.msgno) clip
from ntf (nolock) a
join us (nolock) e on a.usrno=e.usrno -- sender
where  e.nome='" . $login . "'";

$enviadas = $conn->query($query)->fetchAll();

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

$query = "select * from tipo where dspusr = 1";
$dda = $conn->query($query)->fetchAll();

?>