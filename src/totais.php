<?php
function calcular_totais($arquivo)
{
    $linhas = file($arquivo);

    $total = 0;
    $soma = 0;

    foreach ($linhas as $linha) {

        $linha = trim($linha);

        // Ignorar linhas vazias
        if ($linha == "") {
            continue;
        }

        // Verifica se é linha de detalhe (tipo 1)
        $tipo = substr($linha, 0, 1);
        if ($tipo != "1") {
            continue;
        }

        $total++;

        // Pega os últimos 10 caracteres (valor em centavos)
        $valorStr = substr($linha, -10);

        // Só processa se for numérico
        if (ctype_digit($valorStr)) {
            $valor = intval($valorStr) / 100;
            $soma += $valor;
        } else {
            continue;
        }
    }

    return [
        "total_registros" => $total,
        "total_valores" => round($soma, 2)
    ];
}
