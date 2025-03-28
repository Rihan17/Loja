<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../HTML/index.html");
    exit;
}

$usuario = [
    'id' => $_SESSION['id_usuario'],
    'nome' => $_SESSION['nm_usuario'],
    'login' => $_SESSION['nm_login'] ?? null
];

header('Content-Type: application/json');
echo json_encode($usuario);
?> 