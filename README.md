# Projeto CNAB

Descrição

---

## 01 - Leitura básica do arquivo CNAB
### 🎯 Objetivo

Criar uma função capaz de ler um arquivo CNAB linha a linha, identificar o tipo de cada registro e retornar a quantidade de headers, detalhes e trailers.

### 🧠 O que foi implementado
- Leitura do arquivo utilizando `file()`
- Limpeza das linhas com `trim()` para remover quebras e espaços. 
- Ignora linhas vazias para evitar erros de classificação.  
- Identificação do tipo de registro pela primeira posição:
   - `"0"` → header
   - `"1"` → detalhe
   - `"9"` → trailer
- Contagem acumulada para cada tipo.
- Retorno final em forma de array/JSON, conforme solicitado.
 Exemplo de Retoro esperado
```
{
  "header": 1,
  "detalhes": 150,
  "trailer": 1
}
```

### ❓ Questões

a) Como você trataria um arquivo com linhas vazias ou linhas com tamanho incorreto?

Nesse caso foi utilizado `trim()` para remover espaços e quebras de linha
```
$linha = trim($linha);
```
Para ignorar linhas vazias 
```
if ($linha == "") {
   continue;
}
```
        

b) Onde você colocaria a lógica de validação (mesma função, função separada, classe, etc.)?
Justifique.
       
Para este desafio utilzando PHP optei por colocar na mesma função, pois torna o código simples de ler e suficiente para o objetivo.
Acredito que em sistemas reais a validação poderia ser separada, facilitando a manutenção e reutilização

---

## 02 - Conversão simples entre layouts
### 🎯 Objetivo

Criar uma função que receba uma linha CNAB 400 no seguinte formato fictício:
- [1] Tipo de registro (1 caractere, sempre "1")
- [2] CNPJ (14 caracteres numéricos)
- [3] Data (8 caracteres – AAAAMMDD)
- [4] Valor (10 caracteres – sem vírgulas, em centavos)

Exemplo de linha (sem espaços reais, apenas para leitura):
`1 12345678000199 20250101 0000023500`

E converta para um layout de saída JSON assim:
```
{
 "cnpj": "12.345.678/0001-99",
 "data": "01/01/2025",
 "valor": 23.50
}
```

### 🧠 O que foi implementado
- Verificação de tamanho mínimo da linha
- Validação do tipo do registro
- Extração dos campos usando posições fixas `(substr)`
- Formatação do CNPJ para o padrão brasileiro
- Conversão da data
- Conversão do valor de centavos para decimal
- Retorno estruturado em JSON 

### ❓ Questões

a) Como você testaria essa função para garantir que ela funciona em diferentes cenários?

Para garantir que a função funciona corretamente, eu criaria vários testes cobrindo diferentes tipos de situações, com o objetivo de verificar como a função se comporta com entradas válidas, inválidas e casos extremos. Sendo:
Linha válida;
Linha curta (menos de 33 caracteres);
Linha com tipo incorreto (não inicia com "1");
Linha com espaços extras;
Linha com caracteres não numéricos no valor ou data.


b) O que você faria se o CNPJ viesse com caracteres não numéricos?

Uma abordagem mais permissiva é remover tudo que não seja número antes de processar. Assim, mesmo que venha `"12.345.678/0001-99"`, a função converte para `"12345678000199"`.

---

