<?php
include("config/config.php");

$Assunto = $_POST['Assunto'];
$Texto = $_POST['Texto'];
$Tipo = $_POST['tipo'];
$ok = $_POST['ok'];
$txtok = $_POST['txtok'];
$sim = $_POST['sim'];
$txtsim = $_POST['txtsim'];
$nao = $_POST['nao'];
$txtnao = $_POST['txtnao'];
$DSP = $_POST['DSP'];

try {
    $statement = $conn->prepare('INSERT INTO Tipo (assunto, texto, TPCODE, exok, exs, exn, TXTOK, txts, txtn, DSPUSR)
    VALUES (:Assunto, :Texto, :Tipo, :ok, :sim, :nao, :txtok, :txtsim, :txtnao, :dsp)');

    $statement->execute([
        'Assunto' => $Assunto,
        'Texto' => $Texto,
        'Tipo' => $Tipo,
        'ok' => $ok,
        'sim' => $sim,
        'nao' => $nao,
        'txtok' => $txtok,
        'txtsim' => $txtsim,
        'txtnao' => $txtnao,
        'dsp' => $DSP
    ]);

    echo "New record created successfully";
    header('Location: fassunto.php');
} catch(PDOException $e) {
    echo $conn . "<br>" . $e->getMessage();
}
?>