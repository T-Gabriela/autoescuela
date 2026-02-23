<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'] ?? '';
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $dni = $_POST['dni'];
    $telefono = $_POST['telefono'] ?? '';
    $email = $_POST['email'] ?? '';
    
    if (empty($id)) {
        $stmt = $pdo->prepare("INSERT INTO profesores (nombre, apellidos, dni, telefono, email) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$nombre, $apellidos, $dni, $telefono, $email]);
    } else {
        $stmt = $pdo->prepare("UPDATE profesores SET nombre = ?, apellidos = ?, dni = ?, telefono = ?, email = ? WHERE id = ?");
        $stmt->execute([$nombre, $apellidos, $dni, $telefono, $email, $id]);
    }
    
    header('Location: profesores.php');
    exit;
}
?>