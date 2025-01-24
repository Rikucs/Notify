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
$dataf = $now->format('Y/m/d H:i');

$notis = $_GET['noti'];

if (isset($_POST["submits"])) {

    $query = "update destinatarios set DATA='".$dataf."',RESP = 'S' where NOSTAMP='" . $notis . "' and  USRSTAMP='" . $uc . "'";
    $conn->query($query);
    header('Location: ../notify.php');

}
if (isset($_POST["submitn"])) {

    $query = "update destinatarios set DATA='".$dataf."',RESP = 'N' where NOSTAMP='" . $notis . "' and  USRSTAMP='" . $uc . "'";
    $conn->query($query);
    header('Location: ../notify.php');

}
if (isset($_POST["submitok"])) {

    $query = "update destinatarios set DATA='".$dataf."',RESP = 'OK' where NOSTAMP='" . $notis . "' and  USRSTAMP='" . $uc . "'";
    $conn->query($query);
    header('Location: ../notify.php');

}




?>