<?php
include 'config.php';
SESSION_START();
$login = ucfirst($_SESSION['login']);
$query = "select USRNO,USRCODE,USRGP,USRAR,USRDIR  from Utilizadores where USRCODE <> '" . $login . "' order by USRCODE Asc";
$user= $conn->query($query)->fetchAll();
$query = "select USRNO,USRCODE,USRGP,USRAR,USRDIR  from Utilizadores where USRCODE ='" . $login . "'";
$useres= $conn->query($query)->fetchAll();
foreach ($useres as $u) {
    $uc = $u['USRNO'];
    $gp = $u['USRGP'];
}


// Query para obter os dados para a tabela de notificaçoes recebidas

$query = "select a.notino,a.data,e.usrcode,a.head ,iif(b.resp='',iif(LDATA<>'19000101','2','0'),'1') status,
iif(b.data='19000101',iif(LDATA<>'19000101',ldata,''),b.data) Data, b.RESP, 
(select count(*) from documentos (nolock) where nostamp=a.notino) clip
from notificacoes (nolock) a join destinatarios (nolock) b  on a.NOTINO=b.nostamp
join utilizadores (nolock) c on c.USRNO=b.usrstamp -- receiver
join utilizadores (nolock) e on a.usrstamp=e.USRNO -- sender
where  c.usrcode='" . $login . "'";
$notify = $conn->query($query)->fetchAll();
$n_count = count($notify);

// Query para obter os dados para a tabela de notificaçoes enviadas

$query = "select a.notino,a.data,e.usrcode,a.head ,
(select isnull(convert(numeric(10,2),count(*)) /nullif(sum(iif(resp > '',1,0)),0),0) 
from destinatarios (nolock) where nostamp=a.notino) status,
-- status = 1 todos respondidos, 0 = nenhum respondido, > 1 alguns respondidos
(select count(*) from documentos (nolock) where nostamp=a.notino) clip
from notificacoes (nolock) a
join utilizadores (nolock) e on a.usrstamp=e.USRNO -- sender
where  e.usrcode='" . $login . "'";

$enviadas = $conn->query($query)->fetchAll();

$stmt = $conn->prepare("select count(*)
from destinatarios (nolock) a join utilizadores (nolock) c on c.USRNO=a.usrstamp 
where  USRCODE='".$login."' and data='19000101' and ldata='19000101' ");
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
foreach ($result as $r) {
    $ns = $r;
}

$query ="select USRCODE,NOSTAMP
from destinatarios (nolock) a join utilizadores (nolock) c on c.USRNO=a.usrstamp 
where  USRCODE='".$login."' and data='19000101' and ldata='19000101'";
$nosino = $conn->query($query)->fetchAll();

$query = "select * from Tipos where DSPUSR = 1";
$dda = $conn->query($query)->fetchAll();

?>