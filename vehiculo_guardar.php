<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'] ?? '';
    $matricula = $_POST['matricula'];
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $anyo = $_POST['anyo'] ?? null;
    
    if (empty($id)) {
        
        $stmt = $pdo->prepare("INSERT INTO vehiculos (matricula, marca, modelo, anyo) VALUES (?, ?, ?, ?)");
        $stmt->execute([$matricula, $marca, $modelo, $anyo]);
    } else {
        
        $stmt = $pdo->prepare("UPDATE vehiculos SET matricula = ?, marca = ?, modelo = ?, anyo = ? WHERE id = ?");
        $stmt->execute([$matricula, $marca, $modelo, $anyo, $id]);
    }
    
    header('Location: vehiculos.php');
    exit;
}
?>