<?php 
session_start();
if (!isset ($_SESSION['login'])) {
    header('Location: index.php');
}

?>

<html lang="en">
<head>
    <title>Sample Form</title>
</head>
<body>
<center>
    <h1>Inserção de Tipos</h1>
    <form action="addassunto.php" method="post">
        <p>
            <label for="Assunto">Assunto:</label>
            <input type="text" name="Assunto" id="Assunto">
        </p>
        <p>
            <label for="Texto">Texto:</label>
            <textarea name="Texto" id="Texto"> </textarea>
        </p>
        <p>
            <input type="radio" id="sql" name="tipo" value="1">
            <label for="sql">sql</label><br>
            <input type="radio" id="txt" name="tipo" value="2">
            <label for="txt">txt</label><br>
        </p>
        <p>
            <label for="ok">OK:</label>
            <textarea name="ok" id="ok"> </textarea>
        </p>
        <p>
            <label for="txtok">texto para o OK:</label>
            <textarea name="txtok" id="txtok"> </textarea>
        </p>
        <p>
            <label for="sim">SIM:</label>
            <textarea name="sim" id="sim"> </textarea>
        </p>
        <p>
            <label for="txtsim">texto para o SIM:</label>
            <textarea name="txtsim" id="txtsim"> </textarea>
        </p>
        <p>
            <label for="nao">NAO:</label>
            <textarea name="nao" id="nao"> </textarea>
        </p>
        <p>
            <label for="txtnao">texto para o NAO:</label>
            <textarea name="txtnao" id="txtnao"> </textarea>
        </p>
        <p>
            <input type="radio" id="AC" name="DSP" value="0">
            <label for="AC">User com Acesso</label><br>
            <input type="radio" id="SC" name="DSP" value="1">
            <label for="SC">User sem Acesso</label><br>
        </p>
        <input type="submit" value="Submit">
    </form>
</center>
</body>
</html>
