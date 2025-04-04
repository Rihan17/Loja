<?php

include("conexao.php");

header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents("php://input"), true);

switch ($method) {
    case 'GET':
        $sql = "SELECT p.*, c.nm_categoria 
                FROM tb_produto p 
                LEFT JOIN tb_categoria c ON p.id_categoria = c.id_categoria 
                WHERE p.id_usuario = ?";
        
        if (isset($_GET['id_produto'])) {
            $sql .= " AND p.id_produto = " . $_GET['id_produto'];
        }
        
        $resultado = $conexao->prepare($sql);
        $resultado->execute();
        $resultado = $resultado->get_result();
        
        $dados = [];
        while ($linha = $resultado->fetch_object()) {
            $dados[] = $linha;
        }
        echo json_encode($dados);
        break;

    case 'POST':
        // Cadastro no banco
        $sql = "INSERT INTO tb_produto (nm_produto, ds_produto, vl_produto, id_categoria, id_usuario, qt_estoque) 
                VALUES (?, ?, ?, ?, ?, ?)";
        
        $resultado = $conexao->prepare($sql);
        $resultado->bind_param("ssdiis", 
            $input[0]['nm_produto'],
            $input[0]['ds_produto'],
            $input[0]['vl_produto'],
            $input[0]['id_categoria'],
            $id_usuario,
            $input[0]['qt_estoque']
        );
        
        if ($resultado->execute()) {
            echo json_encode(["sucesso" => true, "id" => $conexao->insert_id]);
        } else {
            echo json_encode(["erro" => "Erro ao cadastrar produto: " . $conexao->error]);
        }
        break;

    case 'PUT':
        // Atualizar um Registro
        $sql = "UPDATE tb_produto 
                SET nm_produto = ?, 
                    ds_produto = ?, 
                    vl_produto = ?, 
                    id_categoria = ?, 
                    qt_estoque = ? 
                WHERE id_produto = ? AND id_usuario = ?";
        
        $resultado = $conexao->prepare($sql);
        $resultado->bind_param("ssdiisi", 
            $input[0]['nm_produto'],
            $input[0]['ds_produto'],
            $input[0]['vl_produto'],
            $input[0]['id_categoria'],
            $input[0]['qt_estoque'],
            $input[0]['id_produto'],
            $id_usuario
        );
        
        if ($resultado->execute()) {
            echo json_encode(["sucesso" => true]);
        } else {
            echo json_encode(["erro" => "Erro ao atualizar produto: " . $conexao->error]);
        }
        break;

    case 'DELETE':
        // Excluir um Registro
        $sql = "DELETE FROM tb_produto WHERE id_produto = ? AND id_usuario = ?";
        $resultado = $conexao->prepare($sql);
        
        if ($resultado->execute()) {
            echo json_encode(["sucesso" => true]);
        } else {
            echo json_encode(["erro" => "Erro ao excluir produto: " . $conexao->error]);
        }
        break;

    default:
        echo json_encode(["erro" => "Método não permitido"]);
        break;
}