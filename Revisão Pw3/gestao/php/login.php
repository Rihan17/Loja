<?php
session_start();
include("conexao.php");

header('Content-Type: application/json');

$input = json_decode(file_get_contents("php://input"), true);

if (isset($input[0]['login']) && isset($input[0]['senha'])) {
    $login = $input[0]['login'];
    $senha = $input[0]['senha'];

    $sql = "SELECT * FROM tb_usuario WHERE nm_login = ? AND ds_senha = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("ss", $login, $senha);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc();
        $_SESSION['id_usuario'] = $usuario['id_usuario'];
        $_SESSION['nm_usuario'] = $usuario['nm_usuario'];
        $_SESSION['nm_login'] = $usuario['nm_login'];
        echo json_encode(["sucesso" => true, "usuario" => $usuario['nm_usuario']]);
    } else {
        echo json_encode(["erro" => "Login ou senha inválidos"]);
    }
} else {
    echo json_encode(["erro" => "Dados incompletos"]);
}
?> 