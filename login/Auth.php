<?php

session_start();

$ldaprdn  = $_POST["username"];
$ldappass = $_POST["password"];
$ldapconn = ldap_connect("ncsrv001") or die("Could not connect to LDAP server.");
ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);
if ($ldapconn)
{
    $ldapbind = ldap_bind($ldapconn, $ldaprdn, $ldappass);
    if ($ldapbind)
    {
        $_SESSION["login"] = $ldaprdn;
        header('Location: ../notify.php');
    }
    else
    {
        header('Location: ../index.php');
        session_destroy();
    }
}

?>