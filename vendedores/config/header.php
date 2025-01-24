<?php 
$login = ucfirst($_SESSION['login']);

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