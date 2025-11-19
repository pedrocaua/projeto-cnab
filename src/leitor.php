<?php
function lerCnab($arquivo)
{
    $linhas = file($arquivo);

    $header = 0;
    $detalhes = 0;
    $trailer = 0;

    foreach ($linhas as $linha) {

        // Remove quebras de linha
        $linha = trim($linha);

        // Ignora linhas vazias
        if ($linha == "") {
            continue;
        }

        $tipo = substr($linha, 0, 1);

        if ($tipo == "0") {
            $header++;
        } else if ($tipo == "1") {
            $detalhes++;
        } else if ($tipo == "9") {
            $trailer++;
        }
    }

    return [
        "header" => $header,
        "detalhes" => $detalhes,
        "trailer" => $trailer
    ];
}