<?php
include 'config.php';

SESSION_START();
$login = ucfirst($_SESSION['login']);

$query = "select usrno,nome,dir  from us where nome ='" . $login . "'";
$useres= $conn->query($query)->fetchAll();
foreach ($useres as $u) {
    $uc = $u['usrno'];
}

$now = new DateTime("now", new DateTimeZone("Europe/London"));
$datav = $now->format('Y/m/d H:i');

$noti = $_GET['noti'];

$lida = $conn->prepare("UPDATE dst SET lida = '" . $datav . "' WHERE usrno= '" . $uc . "' AND msgno = '" . $noti . "' ");
$lida->execute();

$query ="select msgno, nome ,
        iif(data<>'19000101',convert(varchar,data,104),iif(lida <> '19000101',convert(varchar,lida,104),'')) data ,
        iif(data<>'19000101',rspt,iif(lida <> '19000101','Lida','Não lida')) resptosta  
        from dst (nolock) a join us (nolock) c on c.usrno=a.usrno -- receiver
        where msgno='".$noti."'";
$dest = $conn->query($query)->fetchAll();

$query ="select a.msgno,a.data,e.nome,a.assunto ,a.texto,
        tipo.tpcode,TXTOK,txts,txtn
        From ntf (nolock) a join dst (nolock) b  on a.msgno=b.msgno
        join us (nolock) c on c.usrno=b.usrno -- receiver
        join us (nolock) e on a.usrno=e.usrno -- sender
        JOIN tipo (NOLOCK) ON A.tpno= tipo.TPNO
        where  a.msgno='".$noti."' or b.msgno='".$noti."' and e.usrno= '".$uc."' ";
$display = $conn->query($query)->fetchAll();
foreach ($display as $row){
    $data = (new DateTime($row['data']))->format('d/m/Y H:i');
    $remetente = $row['nome']; 
    $assunto = $row['assunto'];
    $notificacao = $row['texto'];
    $sim = $row['txts'];
    $nao = $row['txtn'];
    $ok = $row['TXTOK'];
    $tpa = $row['tpcode'];
}
$query ="select iif(rspt='','1','2') as rspt from dst where  msgno    ='".$noti."' and usrno='".$uc."'";
$rsptbtn= $conn->query($query)->fetchAll();
foreach ($rsptbtn as $r) {
    $resbtn = $r['rspt'];
}

$query ="select * from doc where  msgno    ='".$noti."'";
$files = $conn->query($query)->fetchAll();

$query="select count(*)
from dst (nolock) a join us (nolock) c on c.usrno=a.usrno 
where  nome='".$login."' and data='19000101' and lida='19000101' ";
$Nsino = $conn->query($query)->fetchAll();
foreach ($Nsino as $n) {
    $ns = $n[0];
}

$query ="select nome,msgno
from dst (nolock) a join us (nolock) c on c.usrno=a.usrno 
where  nome='".$login."' and data='19000101' and lida='19000101'";
$nosino = $conn->query($query)->fetchAll();
?>

