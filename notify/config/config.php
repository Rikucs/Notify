<?php
 
try
{
 
    $server = "10.88.1.30";
    $door = 1433;
    $db = "webPortal";
    $user = "sa";
    $password = "DEVbin3!";

    $conn = new PDO( "sqlsrv:Server={$server},{$door};Database={$db}", $user, $password );
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute( PDO::SQLSRV_ATTR_QUERY_TIMEOUT, 1 );  
}
catch ( PDOException $e )
{
    echo "Connection failed: " . $e->getMessage();
}
 

?>