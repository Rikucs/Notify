<?php

include 'config.php';
include 'config copy.php';

SESSION_START();
$login = ucfirst($_SESSION['login']);

$query = "select USRNO,USRCODE,USRGP,USRAR,USRDIR  from Utilizadores where USRCODE ='" . $login . "'";
$useres= $conn->query($query)->fetchAll();
foreach ($useres as $u) {
    $uc = $u['USRNO'];
    $gp = $u['USRGP'];
}

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

$query = "SELECT dataa,urg,tecnico,problema,resolucao from u_tt (nolock) where quem = '".$login."' order by dataa desc";
$Dados = $conn1->query($query)->fetchAll();

?>