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

    // Verifica tipo
    if ($tipo != "1") {
        return ["erro" => "Tipo incorreto"];
    }

    // Verificar se o CNPJ contém apenas números
    for ($i = 0; $i < strlen($cnpj); $i++) {
        if ($cnpj[$i] < '0' || $cnpj[$i] > '9') {
            return ["erro" => "CNPJ contém caracteres inválidos"];
        }
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

    return [
        "cnpj" => $cnpjFormatado,
        "data" => $dataFormatada,
        "valor" => $valorFinal
    ];
}
