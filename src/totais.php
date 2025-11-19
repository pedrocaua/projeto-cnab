<?php
function calcular_totais($arquivo)
{
    $linhas = file($arquivo);

    $total = 0;
    $soma = 0;

    foreach ($linhas as $linha) {

        $linha = trim($linha);

        if ($linha == "") {
            continue;
        }

        if (substr($linha, 0, 1) == "1") {

            $total++;

            // últimos 10 caracteres
            $valorStr = substr($linha, -10);

            // converte p/ decimal
            $valor = intval($valorStr) / 100;

            $soma += $valor;
        }
    }

    return [
        "total_registros" => $total,
        "total_valores" => $soma
    ];
}