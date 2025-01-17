<?php
include("config/config.php");

$Assunto = $_POST['Assunto'];
$Texto = $_POST['Texto'];
$Tipo = $_POST['tipo'];
$ok = $_POST['ok'];
$sim = $_POST['sim'];
$nao = $_POST['nao'];
$cancelar = $_POST['cancelar'];

try {


    $statement = $conn->prepare('INSERT INTO Tipos (HEAD, BODY, TPCODE, ORESP,SRESP, NRESP,CRESP)
    VALUES (:Assunto,:Texto,:Tipo,:ok,:sim,:nao,:cancelar)');

    $statement->execute([
        'Assunto' => $Assunto,
        'Texto' => $Texto,
        'Tipo' => $Tipo,
        'ok' => $ok,
        'sim' => $sim,
        'nao' => $nao,
        'cancelar' => $cancelar
    ]);


    echo "New record created successfully";

    header('Location: test.php');

} catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}


?>