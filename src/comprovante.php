<?php
require_once "regras.php";
function gerarComprovante($cnpj,$valor)
{
    $resultado = validar_Pagamento($cnpj, $valor);
    $status = $resultado["status"];

    // Formatar CNPJ
    $c = preg_replace('/\D/', '', $cnpj);
    $cnpjFormatado =
        substr($c, 0, 2) . "." .
        substr($c, 2, 3) . "." .
        substr($c, 5, 3) . "/" .
        substr($c, 8, 4) . "-" .
        substr($c, 12, 2);

    // Formatar valor
    $valorFormatado = number_format($valor, 2, ',', '.');

    // Data
    $data = date("d/m/Y H:i:s");

    // ID
    $id = uniqid();

    // Conteúdo
    $conteudo  = "COMPROVANTE DE PROCESSAMENTO\n";
    $conteudo .= "CNPJ: $cnpjFormatado\n";
    $conteudo .= "VALOR: R$ $valorFormatado\n";
    $conteudo .= "DATA: $data\n";
    $conteudo .= "STATUS: $status\n";
    $conteudo .= "ID: $id\n";

    // Criar pasta se não existir
    if (!is_dir("comprovantes")) {
        mkdir("comprovantes");
    }

    $arquivo = "comprovantes/comprovante_$id.txt";
    file_put_contents($arquivo, $conteudo);

    return ["status" => $status, "arquivo" => $arquivo];
}