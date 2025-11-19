<?php
require_once "src/leitor.php";
require_once "src/conversor.php";
require_once "src/regras.php";
require_once "src/comprovante.php";
require_once "src/totais.php";

echo json_encode([
    "leitura" => lerCnab("exemplos/cnab_exemplo1.txt"),
    "conversao" => converterLinhaCnabParaJson("1123456780001992025010100000023500"),
    "validacao" => validar_pagamento("12345678000199",2500),
    "comprovante" => gerarComprovante("87654321000199",5000),
    "totais" => calcular_totais("exemplos/cnab_exemplo2.txt")
], JSON_PRETTY_PRINT);