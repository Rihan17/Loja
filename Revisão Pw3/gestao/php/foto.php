<?php
if($_SERVER['REQUEST_METHOD']=== 'POST'){
    $imagens = [];

    foreach ($_FILES['imagens']['tmp_name'] as $index => $tmpName) {
        $imageName = $_FILES['imagens']['name'][$index];
        $imageType = $_FILES['imagens']['type'][$index];
        $imageTmpPath = $_FILES['imagens']['tmp_name'][$index];

        $destino = '../imgs/'.$_POST['idProduto'].'/';
        if(!is_dir($destino)){
            mkdir($destino, 0777);
        }
        $targetFilePath = $destino.basename(($imageName));

        if(move_uploaded_file($imageTmpPath, $targetFilePath)){
            $imagens[] = [
                'nome' => $imageName,
                'tipo' => $imageType,
                'caminho' => $targetFilePath
            ];
        }else{
            $imagens[] = [
                'erro' => "Falha ao mover o arquivo: ". $imageName
            ];
        }
    }
    echo json_encode($imagens);
}