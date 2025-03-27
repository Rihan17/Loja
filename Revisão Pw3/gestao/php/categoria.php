<?php
header("Content-Type: application/json");
include("conexao.php");

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents("php://input"),true);
$id = $_GET['id_categoria'] ?? null;

switch ($method) {
    //Consulta no Banco
    case 'GET':
        try {
            // Verifica se a tabela existe
            $result = $conexao->query("SHOW TABLES LIKE 'tb_categoria'");
            if ($result->num_rows == 0) {
                echo json_encode(["erro" => "Tabela tb_categoria não existe"]);
                exit;
            }

            // Consulta SQL modificada para incluir contagem de produtos
            $sql = "SELECT 
                        c.id_categoria,
                        c.nm_categoria,
                        COUNT(p.id_produto) as quantidade_produtos,
                        GROUP_CONCAT(p.nm_produto) as produtos
                    FROM tb_categoria c 
                    LEFT JOIN tb_produto p ON c.id_categoria = p.id_categoria 
                    WHERE 1=1";
                    
            if($id > 0) {
                $sql .= " AND c.id_categoria = " . $id;
            }
            
            $sql .= " GROUP BY c.id_categoria, c.nm_categoria ORDER BY c.nm_categoria";
            
            $resultado = $conexao->query($sql);
            
            if (!$resultado) {
                echo json_encode(["erro" => "Erro na consulta: " . $conexao->error]);
                exit;
            }

            $categorias = array();
            while ($categoria = $resultado->fetch_assoc()) {
                $categorias[] = array(
                    'id_categoria' => $categoria['id_categoria'],
                    'nm_categoria' => $categoria['nm_categoria'],
                    'quantidade_produtos' => (int)$categoria['quantidade_produtos'],
                    'produtos' => $categoria['produtos'] ?? ''
                );
            }

            // Log para debug
            error_log("SQL: " . $sql);
            error_log("Resultado: " . json_encode($categorias));

            echo json_encode($categorias);
        } catch (Exception $e) {
            echo json_encode(["erro" => "Erro: " . $e->getMessage()]);
        }
        break;
    case 'POST':
        // Cadastro no banco
        $sql = 'INSERT INTO tb_categoria VALUE (null, "'.$input[0]['nm_categoria'].'")';
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