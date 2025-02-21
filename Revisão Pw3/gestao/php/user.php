<?php
header("Content-Type: application/json");
include("conexao.php");

$method = $_SERVER['REQUEST_METHOD'];

switch($method){
    case 'GET':
        echo "é get";
        break;
    case 'POST':
        echo "é post";
        break;
    case 'PUT':
        echo "é put";
        break;
    case 'DELETE':
        echo "é delete";
        break;
    default:
        echo "Acesso inválido";
        break;
}