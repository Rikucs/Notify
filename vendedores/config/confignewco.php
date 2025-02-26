<?php
 
try
{
 
    $server = "NCSRV005";
    $door = 1433;
    $db = "Newco";
    $user = "link";
    $password = "!Qazxsw2#$%&";

    $conn1 = new PDO( "sqlsrv:Server={$server},{$door};Database={$db}", $user, $password );
    $conn1->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn1->setAttribute( PDO::SQLSRV_ATTR_QUERY_TIMEOUT, 20 );  
}
catch ( PDOException $e )
{
    echo "Connection failed: " . $e->getMessage();
}
 

?>