# Projeto CNAB

Este projeto foi desenvolvido como parte do teste técnico para a vaga de Estágio em Desenvolvimento de Software na Finnet. O objetivo era criar um conjunto de funções capazes de ler, interpretar e processar arquivos CNAB (em um layout fictício), aplicando regras de negócio e transformando os dados em formatos mais úteis, como JSON.

---

## **Pergunta 01 - Leitura básica do arquivo CNAB**

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

**a) Como você trataria um arquivo com linhas vazias ou linhas com tamanho incorreto?**

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
        

**b) Onde você colocaria a lógica de validação (mesma função, função separada, classe, etc.)? Justifique.**
       
Para este desafio utilizando PHP optei por colocar na mesma função, pois torna o código simples de ler e suficiente para o objetivo.
Acredito que em sistemas reais a validação poderia ser separada, facilitando a manutenção e reutilização

---

## **Pergunta 02 - Conversão simples entre layouts**
### 🎯 Objetivo

Converter uma linha CNAB 400 contendo:

Tipo
CNPJ
Data
Valor

Para um JSON formatado com:
CNPJ formatado
Data em DD/MM/AAAA
Valor convertido de centavos para decimal

Exemplo de linha (sem espaços reais, apenas para leitura):
`1 12345678000199 20250101 0000023500`

E converta para um layout em JSON assim:
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
- Validação simples do CNPJ
- Formatação do CNPJ para o padrão brasileiro
- Conversão da data
- Conversão do valor de centavos para decimal
- Retorno estruturado em JSON 

### ❓ Questões

**a) Como você testaria essa função para garantir que ela funciona em diferentes cenários?**

Para garantir que a função funciona corretamente, vários testes cobrindo diferentes tipos de situações, com o objetivo de verificar como a função se comporta com entradas válidas, inválidas e casos extremos. Sendo:
Linha válida;
Linha curta (menos de 33 caracteres);
Linha com tipo incorreto (não inicia com "1");
Linha com espaços extras;
Linha com caracteres não numéricos no valor ou data.


**b) O que você faria se o CNPJ viesse com caracteres não numéricos?**

Resolvi adicionar uma validação simples afim de checar se não existe nenhuma caracteres inválidos
```
for ($i = 0; $i < strlen($cnpj); $i++) {
    if ($cnpj[$i] < '0' || $cnpj[$i] > '9') {
    	return ["erro" => "CNPJ contém caracteres inválidos"];
    }
}
```

---

## **Pergunta 03 - Aplicação de regra de negócio**
### 🎯 Objetivo

Implementar uma função que avalie um pagamento com base em:
- CNPJ válido (14 dígitos numéricos)
- Valor informado
E deve retornar:
- **"aprovado"** → se o CNPJ for válido e o valor for ≤ 10.000
- **"pendente_validacao"** → se o valor estiver entre 10.001 e 50.000
- **"rejeitado"** → se o CNPJ for inválido ou o valor for > 50.000
A função deve sempre retornar a resposta no formato JSON:
```
{ "status": "aprovado" }
```

### 🧠 O que foi implementado
- Limpeza do CNPJ
- Validação simples do CNPJ
- Aplicação da regra de negócio:
    - Valores até 10.000 → aprovado
    - Valores até 50.000 → pendente_validacao
    - Demais casos → rejeitado
- Retorno estruturado

### ❓ Questões

**a) Onde você centralizaria as regras de negócio para facilitar futuras mudanças?**

No caso implementei na classe `regras.php`, deixando centralizado em uma classe só faz com que futuras mudanças sejam mais simples, para que quando alguém for mexer ja saber onde estão as regras de negócio
	

**b) Como garantir que mudanças nessas regras não quebrem funcionalidades antigas?**

- Usando lógica simples de programação para separar os casos: CNPJ válido, CNPJ inválido, valor em cada faixa.
- Você pode manter métodos pequenos e claros, testando cada cenário dentro da própria classe. 
- O polimorfismo ajuda aqui também: se criar uma nova regra em uma subclasse, a lógica antiga continua funcionando na classe base, evitando que mudanças quebrem o que já estava funcionando.
- Além disso, podem ser usados testes automatizados para validar todos os cenários sempre que houver alterações.

---

## **04 - Geração simples de comprovante**
### 🎯 Objetivo

Criar uma função que receba uma linha CNAB 400 no seguinte formato fictício:
- Tipo de registro
- CNPJ
- Data
- Valor

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
- Criação da pasta comprovantes automaticamente caso não exista.
- Geração e salvamento do arquivo .txt com todas as informações organizadas.
Exemplo de arquivo gerado:
```
COMPROVANTE DE PROCESSAMENTO
CNPJ: 12.345.678/0001-95
VALOR: R$ 1.500,00
DATA: 19/11/2025 22:10:05
STATUS: aprovado
ID: 651f1a4c8e7d9
```

### ❓ Questões

**a) Como você organizaria a pasta de saída desses comprovantes?**

Pasta dedicada chamada comprovantes dentro do projeto.
Organizar subpastas por ano/mês para facilitar a manutenção e pesquisa de arquivos, organização parecida com explorador de arquivos de seu computador, isso mantém todos os comprovantes centralizados e de fácil acesso.


**b) O que você faria se o sistema não tivesse permissão de escrita na pasta configurada?**

Resolvi adicionar uma validação simples para garantir que o arquivo sempre seja salvo, mesmo que a pasta original não exista ou não seja gravável
```
if (!is_dir($pasta) || !is_writable($pasta)) {
    $pasta = "comprovantes_temp";
    if (!is_dir($pasta)) {
        mkdir($pasta);
    }
}
```

---

## **05 - Estatísticas em arquivos CNAB**
### 🎯 Objetivo

Criar uma função que calcule totais a partir de um arquivo CNAB, considerando apenas as linhas de detalhe (tipo 1), e retorne:
- Número total de registros de detalhe
- Soma total dos valores contidos nessas linhas (em reais)

O valor de cada linha está nos últimos 10 caracteres, em centavos. Header e trailer devem ser desconsiderados.

### 🧠 O que foi implementado
- Leitura de todas as linhas do arquivo usando file().
- Ignora linhas vazias para evitar erros.
- Filtra apenas linhas de detalhe (tipo 1) usando substr($linha, 0, 1).
- Extrai o valor nos últimos 10 caracteres e converte para decimal dividindo por 100.
- Acumula total de registros e soma total dos valores.
Retorna os resultados no formato JSON:
```
[
    "total_registros" => 150,
    "total_valores" => 12345.67
]
```

### ❓ Questões

**a) Como você lidaria com uma linha de detalhe com valor inválido (por exemplo, letras no campo
numérico)?**

Implementei uma validação simples usando ctype_digit() para garantir que apenas valores numéricos fossem processados:
```
$valorStr = substr($linha, -10);
if (ctype_digit($valorStr)) {
    $valor = intval($valorStr) / 100;
    $soma += $valor;
} else {
    continue;
}
```

**b) Como você escreveria testes para validar essa função usando arquivos pequenos de exemplo?**

Implementei testes simples diretamente no script principal do projeto (como uma “classe main”), usando arquivos CNAB pequenos:
```
"totais" => calcular_totais("exemplos/cnab_exemplo2.txt")
```

---

## **Perginta 06 - Conceitos básicos de Docker**

**1. O que é Docker?**

Docker é uma plataforma que permite criar ambientes isolados chamados containers. Onde é possível "empacotar" uma aplicação junto com tudo o que ela precisa como bibliotecas, dependências, configurações para que funcione da mesma forma em qualquer computador.

**2. O que é uma imagem Docker?**

É um tipo de modelo, onde contém dependências, arquivos da aplicação e instruções de como rodar o programa e com base nessa imagem, podem ser criados vários containers.

**3. O que é um container?**

É uma instância em execução de uma imagem, ele funciona como um ambiente isolado menor, rodando o aplicativo exatamente como pede na imagem.

**4. Para que serve um Dockerfile?**

É um arquivo onde você informa como a imagem deve ser construída.
Nele você descreve versões a serem utilizadas, copiar arquivos do projeto, extensões instaladas, ou seja, funciona como uma receita para montar o ambiente.

**5. Como você faria para executar um script que processa arquivos CNAB dentro de um container?
 (Explique em alto nível: montagem de volume, comando de execução, etc.)**

Tomei a iniciativa de criar um Dockerfile e adicioná-lo ao projeto, mesmo não tendo muito conhecimento prévio sobre Docker.

```
FROM php:8.2-cli
WORKDIR /app
COPY . .
CMD ["php", "main.php"]
```

Para isso, utilizei vídeos do YouTube e algumas referências simples para montar uma imagem que permite executar o script PHP dentro de um container.
Apesar de ser algo básico, executa o processamento CNAB dentro de um ambiente isolado.
Onde: 
- Baseei a imagem no PHP 8.2 CLI
- Defini a pasta de trabalho /app dentro do container
- Copiei todos os arquivos do projeto para dentro do container
- Configurei o comando padrão (CMD) para rodar main.php

E pude intender que isso permite rodar o script em um ambiente isolado, independente do PHP local, facilitado  e execução em qualquer máquina com Docker


---

## **Pergunta 07 - Boas práticas e qualidade de código**

**a) Cite 3 boas práticas de desenvolvimento que você considera importantes em projetos de backend.**

- 01: Manter funções pequenas e com responsabilidade única.
- 02: Utilizar nomes claros e significativos para variáveis e funções.
- 03: Separar regras de negócio da lógica de entrada/saída organizado o código em arquivos.

**b) Como você nomearia variáveis e funções em um projeto que processa arquivos CNAB? Dê exemplos**

Usaria nomes que descrevem exatamente o que a função ou variável representa:
- `lerCnab()`
- `converterLinhaCnabParaJson()`
- `validarPagamento()`
- `gerarComprovante()`
- `totalRegistros`
- `valorEmCentavos`
- `linhaCnab`
Sempre deixando claro o que cada função faz.

**c) O que é um teste automatizado e por que ele é importante?**

Um teste automatizado é um código que verifica automaticamente se outra parte do sistema está funcionando como deveria.
Ele é importante porque:
- Evita que mudanças novas quebrem funcionalidades antigas.
- Garante que regras de negócio continuam válidas.
- Reduz erros e retrabalho.

**d) Como você organizaria a estrutura de pastas de um pequeno projeto de processamento CNAB? (Exemplo de layout)**
```
src/        → Arquivos PHP principais (funções e regras)
exemplos/   → Arquivos CNAB de teste (.txt)
comprovantes/ → Arquivos gerados pela aplicação
main.php    → Arquivo principal para executar o sistema
README.md   → Documentação do projeto
Dockerfile → docker
```
Essa estrutura separa bem cada responsabilidade, facilitando a manutenção.

