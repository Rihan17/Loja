<?php
session_start();
include("conexao.php");

header('Content-Type: application/json');

if (!isset($_SESSION['id_usuario'])) {
    echo json_encode(["erro" => "Usuário não está logado"]);
    exit;
}

try {
    // Busca dados do usuário
    $sql_usuario = "SELECT nm_usuario, nm_login FROM tb_usuario WHERE id_usuario = ?";
    $stmt = $conexao->prepare($sql_usuario);
    $stmt->bind_param("i", $_SESSION['id_usuario']);
    $stmt->execute();
    $usuario = $stmt->get_result()->fetch_assoc();

    // Conta produtos do usuário
    $sql_produtos = "SELECT COUNT(*) as total_produtos FROM tb_produto WHERE id_usuario = ?";
    $stmt = $conexao->prepare($sql_produtos);
    $stmt->bind_param("i", $_SESSION['id_usuario']);
    $stmt->execute();
    $produtos = $stmt->get_result()->fetch_assoc();

    // Conta categorias
    $sql_categorias = "SELECT COUNT(*) as total_categorias FROM tb_categoria";
    $resultado = $conexao->query($sql_categorias);
    $categorias = $resultado->fetch_assoc();

    $dados = [
        "usuario" => [
            "nome" => $usuario['nm_usuario'],
            "login" => $usuario['nm_login']
        ],
        "estatisticas" => [
            "produtos" => $produtos['total_produtos'],
            "categorias" => $categorias['total_categorias']
        ]
    ];

    echo json_encode($dados);
} catch (Exception $e) {
    echo json_encode(["erro" => "Erro ao buscar dados: " . $e->getMessage()]);
}
?> 