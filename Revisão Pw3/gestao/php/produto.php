<?php
header("Content-Type: application/json");
include("conexao.php");

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents("php://input"),true);
$id = $_GET['id_produto'] ?? null;

switch ($method) {
    //Consulta no Banco
    case 'GET':
        $sql = 'SELECT * FROM tb_produto ';
        if($id>0){
            $sql .= ' WHERE id_produto = ' . $id;
        }
        $resultado = $conexao->query($sql);
        $dados = [];
        while($linha = $resultado->fetch_object()){
            $dados[] = $linha;
        }
        echo json_encode($dados);
        break;
    case 'POST':
        // Cadastro no banco
        $sql = 'INSERT INTO tb_produto (nm_produto, descricao, vl_produto, id_categoria) 
                VALUES ("'.$input[0]['nm_produto'].'", 
                        "'.$input[0]['descricao'].'", 
                        '.$input[0]['vl_produto'].', 
                        '.$input[0]['id_categoria'].')';
        $resultado = $conexao->query($sql);
        echo json_encode($conexao->insert_id);
        break;
    case 'PUT':
        //Atualizar um Registro
        $sql = 'UPDATE tb_produto SET 
                nm_produto="'.$input[0]['nm_produto'].'", 
                descricao="'.$input[0]['descricao'].'", 
                vl_produto='.$input[0]['vl_produto'].', 
                id_categoria='.$input[0]['id_categoria'].' 
                WHERE id_produto='.$input[0]['id_produto'];
        $resultado = $conexao->query($sql);
        echo json_encode(["atualizado" => $conexao->affected_rows]);
        break;
    case 'DELETE':
        //Excluir um Registro
        $sql = 'DELETE FROM tb_produto WHERE id_produto = ' . $id;
        $resultado = $conexao->query($sql);
        echo json_encode(["excluido" => $conexao->affected_rows]);
        break;
    default:
        echo "Acesso inválido";
        break;
}