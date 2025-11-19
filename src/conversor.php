<?php
function converterLinhaCnabParaJson($linha)
{
    // Verifica tamanho mínimo
    if (strlen($linha) < 33) {
        return ["erro" => "Linha muito curta"];
    }

    $tipo  = substr($linha, 0, 1);
    $cnpj  = substr($linha, 1, 14);
    $data  = substr($linha, 15, 8);
    $valor = substr($linha, 23, 10);

    // Verifica se é linha do tipo 1
    if ($tipo != "1") {
        return ["erro" => "Tipo incorreto"];
    }

    // Formatar CNPJ
    $cnpjFormatado =
        substr($cnpj, 0, 2) . "." .
        substr($cnpj, 2, 3) . "." .
        substr($cnpj, 5, 3) . "/" .
        substr($cnpj, 8, 4) . "-" .
        substr($cnpj, 12, 2);

    // Formatar data
    $dataFormatada =
        substr($data, 6, 2) . "/" .
        substr($data, 4, 2) . "/" .
        substr($data, 0, 4);

    // Converter valor
    $valorFinal = intval($valor) / 100;

    // Garante a formatação com duas casas decimais, forçando o valor a ser uma string no JSON.
    $valorStringFormatado = number_format($valorFinal, 2, '.', '');

    return [
        "cnpj" => $cnpjFormatado,
        "data" => $dataFormatada,
        "valor" => $valorFinal
    ];
}