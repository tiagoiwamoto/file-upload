<?php
/**
 * Created by: tiago
 * Email: tiago.iwamoto@gmail.com
 * Linkedin: https://www.linkedin.com/in/tiago-iwamoto/
 * Created at: 22/04/2021 - 19:53
 */

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        // Lista de imagens permitidas para enviar
        $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
        $filename = $_FILES["image"]["name"];
        $filetype = $_FILES["image"]["type"];
        $filesize = $_FILES["image"]["size"];
        $extension = substr(strrchr($filename, "."), 1);

        // Validando extensao do arquivo
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if (!array_key_exists($ext, $allowed)) die("Erro: Selecione uma imagem correta para enviar");

        // Verify file size - 5MB maximum
        $maxsize = 5 * 1024 * 1024;
        if ($filesize > $maxsize) die("Erro: Arquivo muito grande.");

        // Validando o tipo MYME
        if (in_array($filetype, $allowed)) {
            // Verifica se o arquivo ja existe no destino antes de mover
            if (file_exists("upload/" . $filename)) {
                echo $filename . " já foi enviado";
            } else {
                // Pegando o dia e hora atual
                $date = new DateTime();
                // Formatando data até os milisegundos
                $currentTime = $date->format('YmdHisu');
                //Movendo o arquivo
                move_uploaded_file($_FILES["image"]["tmp_name"], "upload/" . $currentTime . "." . $extension);
                echo "Seu arquivo foi enviado com sucesso";
            }
        } else {
            echo "Erro: Ocorreu um problema ao enviar este arquivo";
        }
    } else {
        echo "Erro: " . $_FILES["image"]["error"];
    }
}
