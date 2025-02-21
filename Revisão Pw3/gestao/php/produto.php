<?php
header("Content-Type: application/json");
include("conexao.php");

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents("php://input"),true);

switch($method){
    case 'GET':
        echo "é get";
        break;
    case 'POST':

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