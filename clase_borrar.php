<?php
require_once 'config.php';

if (isset($_GET['id'])) {
    
    $stmt = $pdo->prepare("UPDATE clases SET borrado = TRUE WHERE id = ?");
    $stmt->execute([$_GET['id']]);
}

header('Location: agenda.php');
exit;
?>