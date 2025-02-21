<?php

$servidor = 'localhost';
$user = 'root';
$pass = '';
$bd = 'db_gestao';

$conexao = new mysqli ($servidor, $user, $pass, $bd);

if(!$conexao){
    $retorno['erro'] = true;
    $retorno['msg'] = "Erro na conexão: ".$conexao->error;
}