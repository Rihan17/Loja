<?php
session_start();
include("conexao.php");

header('Content-Type: application/json');
$input = json_decode(file_get_contents("php://input"), true);
$method = $_SERVER['REQUEST_METHOD'];
switch($method){
case 'POST';

    $login = htmlspecialchars($input[0]['nm_login'] );
    $senha = htmlspecialchars($input[0]['ds_senha']) ;

    $sql = 'SELECT * FROM tb_usuario WHERE nm_login = "'.$login.'" AND ds_senha = "'.$senha.'"';
    $res = $conexao->query($sql);
    $retorno['error'] = false;
    if($res->num_rows == 1){
        $retorno['dados'] = $res->fetch_object();
    }else{
        $retorno['error'] = true;
        $retorno['msg']="usuario e senha invalidos";
    }
    echo json_encode($retorno);
}