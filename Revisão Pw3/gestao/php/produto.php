<?php

include("conexao.php");

header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents("php://input"), true);

switch ($method) {
    case 'GET':
        $sql = 'SELECT p.*, c.nm_categoria 
                FROM tb_produto p 
                INNER JOIN tb_categoria c ON p.id_categoria = c.id_categoria';
        
        if (isset($_GET['id_produto'])) {
            $sql .= " AND p.id_produto = " . $_GET['id_produto'];
        }
        
        $resultado = $conexao->query
        ($sql);
        
        $dados = [];
        while ($linha = $resultado->fetch_object()) {
            $dados[] = $linha;
        }
        echo json_encode($dados);
        break;

    case 'POST':
        // Cadastro no banco
        $sql = 'INSERT INTO tb_produto
                VALUES ("'.$input[0]['nm_produto'].'",
            "'.$input[0]['ds_produto'].'",
            "'.$input[0]['vl_produto'].'",
            "'.$input[0]['id_categoria'].'",
            "'.$input[0]['qt_estoque'].'")';
        
        $resultado = $conexao->prepare($sql);
        
        $resultado = $conexao->query($sql);
        echo json_encode($conexao->insert_id);
        break;

    case 'PUT':
        // Atualizar um Registro
        $sql = 'UPDATE tb_produto 
                SET "'.$input[0]['nm_produto'].'",
            "'.$input[0]['ds_produto'].'",
            "'.$input[0]['vl_produto'].'",
            "'.$input[0]['id_categoria'].'",
            "'.$input[0]['qt_estoque'].'") 
                WHERE id_produto = "'.$input[0]['id_produto'].'"';
        
        $resultado = $conexao->prepare($sql);
        
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