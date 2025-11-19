# Projeto CNAB

Descrição

---

## Leitura básica do arquivo CNAB
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
       Acredito que em sistemas reais a validação poderia ser serarada, facilitando a manutenção e reutilização

---

