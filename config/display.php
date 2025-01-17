<?php
include 'config.php';

SESSION_START();
$login = ucfirst($_SESSION['login']);

$query = "select USRNO,USRCODE,USRGP,USRAR,USRDIR  from Utilizadores where USRCODE ='" . $login . "'";
$useres= $conn->query($query)->fetchAll();
foreach ($useres as $u) {
    $uc = $u['USRNO'];
}

$now = new DateTime("now", new DateTimeZone("Europe/London"));
$datav = $now->format('Y/m/d H:i');

$noti = $_GET['noti'];

$lida = $conn->prepare("UPDATE Destinatarios SET LDATA = '" . $datav . "' WHERE USRSTAMP= '" . $uc . "' AND NOSTAMP = '" . $noti . "' ");
$lida->execute();

$query ="select nostamp, usrcode ,
        iif(data<>'19000101',convert(varchar,data,104),iif(ldata <> '19000101',convert(varchar,ldata,104),'')) data ,
        iif(data<>'19000101',resp,iif(ldata <> '19000101','Lida','Não lida')) resposta  
        from destinatarios (nolock) a join utilizadores (nolock) c on c.USRNO=a.usrstamp -- receiver
        where nostamp='".$noti."'";
$dest = $conn->query($query)->fetchAll();

$query ="select a.notino,a.data,e.usrcode,a.head ,a.body,
        a.tpcode,TXTOK,TXTYES,TXTNO
        From notificacoes (nolock) a join destinatarios (nolock) b  on a.NOTINO=b.nostamp
        join utilizadores (nolock) c on c.USRNO=b.usrstamp -- receiver
        join utilizadores (nolock) e on a.usrstamp=e.USRNO -- sender
        JOIN TIPOS (NOLOCK) ON A.TPSTAMP= TIPOS.TPNO
        where  a.notino='".$noti."' or b.NOSTAMP='".$noti."' and e.USRNO= '".$uc."' ";
$display = $conn->query($query)->fetchAll();
foreach ($display as $row){
    $data = (new DateTime($row['data']))->format('d/m/Y H:i');
    $remetente = $row['usrcode']; 
    $assunto = $row['head'];
    $notificacao = $row['body'];
    $sim = $row['TXTYES'];
    $nao = $row['TXTNO'];
    $ok = $row['TXTOK'];
    $tpa = $row['tpcode'];
}

$query ="select * from documentos where  NOSTAMP    ='".$noti."'";
$files = $conn->query($query)->fetchAll();

$query="select count(*)
from destinatarios (nolock) a join utilizadores (nolock) c on c.USRNO=a.usrstamp 
where  USRCODE='".$login."' and data='19000101' and ldata='19000101' ";
$Nsino = $conn->query($query)->fetchAll();
foreach ($Nsino as $n) {
    $ns = $n[0];
}

$query ="select USRCODE,NOSTAMP
from destinatarios (nolock) a join utilizadores (nolock) c on c.USRNO=a.usrstamp 
where  USRCODE='".$login."' and data='19000101' and ldata='19000101'";
$nosino = $conn->query($query)->fetchAll();
?>

