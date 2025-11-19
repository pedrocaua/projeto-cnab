<?php
function validar_pagamento($cnpj, $valor)
{
    // Remove caracteres não numéricos
    $cnpj = preg_replace('/\D/', '', $cnpj);

    // Verificação simples de CNPJ
    if (strlen($cnpj) != 14) {
        return ["status" => "rejeitado"];
    }

    // Regras
    if ($valor <= 10000) {
        return ["status" => "aprovado"];
    }

    if ($valor <= 50000) {
        return ["status" => "pendente_validacao"];
    }

    return ["status" => "rejeitado"];
}