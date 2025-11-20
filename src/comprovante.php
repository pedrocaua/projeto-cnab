<?php
require_once "regras.php";

function gerarComprovante($cnpj, $valor)
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

    // ID único
    $id = uniqid();

    // Conteúdo do comprovante
    $conteudo  = "COMPROVANTE DE PROCESSAMENTO\n";
    $conteudo .= "CNPJ: $cnpjFormatado\n";
    $conteudo .= "VALOR: R$ $valorFormatado\n";
    $conteudo .= "DATA: $data\n";
    $conteudo .= "STATUS: $status\n";
    $conteudo .= "ID: $id\n";

    // Definir pasta padrão
    $pasta = "comprovantes";

    // Criar pasta se não existir ou se não for gravável
    if (!is_dir($pasta) || !is_writable($pasta)) {
        $pasta = "comprovantes_temp";
        if (!is_dir($pasta)) {
            mkdir($pasta);
        }
    }

    // Caminho do arquivo
    $arquivo = "$pasta/comprovante_$id.txt";
    file_put_contents($arquivo, $conteudo);

    return ["status" => $status, "arquivo" => $arquivo];
}
