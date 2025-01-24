<?php

include 'config.php';
include 'confignewco.php';

SESSION_START();
$login = ucfirst($_SESSION['login']);

$query = "select usrno,nome,dir  from us where nome ='" . $login . "'";
$useres= $conn->query($query)->fetchAll();
foreach ($useres as $u) {
    $uc = $u['usrno'];
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

$query = "select * from tipo where DSPUSR = 1";
$dda = $conn->query($query)->fetchAll();

$query = "SELECT dataa,urg,tecnico,problema,resolucao from u_tt (nolock) where quem = '".$login."' order by dataa desc";
$Dados = $conn1->query($query)->fetchAll();

?>