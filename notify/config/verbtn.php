<?php

include 'config.php';

SESSION_START();
$login = ucfirst($_SESSION['login']);

$query = "select usrno from us where nome ='" . $login . "'";
$useres= $conn->query($query)->fetchAll();
foreach ($useres as $u) {
    $uc = $u['usrno'];
}

$now = new DateTime("now", new DateTimeZone("Europe/London"));
$dataf = $now->format('Y/m/d H:i');

$notis = $_GET['noti'];

if (isset($_POST["submits"])) {

    $query = "update dst set DATA='".$dataf."',rspt = 'S' where msgno='" . $notis . "' and  usrno='" . $uc . "'";
    $conn->query($query);
    header('Location: ../notify.php');

}
if (isset($_POST["submitn"])) {

    $query = "update dst set DATA='".$dataf."',rspt = 'N' where msgno='" . $notis . "' and  usrno='" . $uc . "'";
    $conn->query($query);
    header('Location: ../notify.php');

}
if (isset($_POST["submitok"])) {

    $query = "update dst set DATA='".$dataf."',rspt = 'OK' where msgno='" . $notis . "' and  usrno='" . $uc . "'";
    $conn->query($query);
    header('Location: ../notify.php');

}




?>