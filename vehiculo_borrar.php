<?php
require_once 'config.php';

if (isset($_GET['id'])) {
  
    $stmt = $pdo->prepare("UPDATE vehiculos SET borrado = TRUE WHERE id = ?");
    $stmt->execute([$_GET['id']]);
}

header('Location: vehiculos.php');
exit;
?>