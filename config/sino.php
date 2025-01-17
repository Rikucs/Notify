<?php 
SESSION_START();
$login = ucfirst($_SESSION['login']);
require 'config/config.php'; 

$stmt = $conn->prepare("select count(*)
from destinatarios (nolock) a join utilizadores (nolock) c on c.USRNO=a.usrstamp 
where  USRCODE='".$login."' and data='19000101' and ldata='19000101' ");
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

echo json_encode(['count' => $result['count']]);
?>