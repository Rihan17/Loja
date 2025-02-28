<?php
header("Content-Type: application/json");
include("conexao.php");

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents("php://input"),true);
$id = $_GET['id_categoria'] ?? null;

switch ($method) {
    //Consulta no Banco
    case 'GET':
        $sql = 'SELECT * FROM tb_categoria ';
        if($id>0){
            $sql .= 'WHERE id_categoria = ' . $id;
        }
        $resultado = $conexao->query($sql);
        $dados = [];
        while($linha = $resultado->fetch_object()){
            $dados[] = $linha;
        }
        echo json_encode($resultado);
        break;
    case 'POST':
        // Cadastro no banco
        $sql = 'INSERT INTO tb_categoria VALUE (2, "'.$input[0]['nm_categoria'].'")';
        $resultado = $conexao->query($sql);
        echo json_encode($conexao->insert_id);
        break;
    case 'PUT':
        //Atualizar um Registro
        $sql = 'UPDATE tb_categoria SET nm_categoria="'.$input[0]['nm_categoria'].'" WHERE id_categoria='.$input[0]['id_categoria'];
        $resultado = $conexao->query($sql);
        echo json_encode(["atualizado" => $conexao->affected_rows]);
        break;
    case 'DELETE':
        //Excluir um Registro
        $sql = 'DELETE FROM tb_categoria WHERE id_categoria = ' . $id;
        $resultado = $conexao->query($sql);
        echo json_encode(["excluido" => $conexao->affected_rows]);
        break;
    default:
        echo "Acesso inválido";
        break;
}