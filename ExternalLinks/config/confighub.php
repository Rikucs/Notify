<?php

SESSION_START();
$login = ucfirst($_SESSION['login']);

$query = "select usrno,nome,dir,vnd  from us where nome ='" . $login . "'";
$useres= $conn->query($query)->fetchAll();
foreach ($useres as $u) {
    $uc = $u['usrno'];
    $udir = $u['dir'];
    $vnd = $u['vnd'];
}

$query = "SELECT * from extl where usrno ='" . $uc . "' or usrno = 0";
$links= $conn->query($query)->fetchAll();

?>