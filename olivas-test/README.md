<br> 

# Olivas Digital - test 

<br>
<p align="left">
    <img src="https://raw.githubusercontent.com/Marcos-SCO/Vaga-Desenvolvedor-PHP/main/olivas-test/public/images/api/default/showGif.gif" width="700" title="Show Gif">
</p>
<br>

## <p id='dependencies'>📋 Dependências</p>

<ul>
  <li>"bootstrap-icons": "^1.6.1"</li>
  <li>"sweetalert": "^2.1.2"</li>
  <li>"tymon/jwt-auth": "^1.0"</li>
</ul>

<br>

## <p id='install'>🔥 Como instalar</p>

- Copie ".env.example" e coloque suas variáveis de ambiente.


## Crie um banco de dados no MySql

- CREATE DATABASE db_test_olivas CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;


## Instale as dependências do composer.

```shell
$ composer install
```

## Rode os comandos do Laravel.

```shell
$ PHP artisan key: generate

$ php artisan jwt:secret

$ php artisan migrate --seed
```

<br/>

## Para fazer o teste das endpoints, utilize um api client como o Postman. 
## As collections estão disponiveis na raiz do projeto.

<br/>

## Exemplo de Login: 
url: {{BASE_API}}/auth/login/ 
Método: POST
```json
  {
      "email": "email", 
      "password": "password" 
  }
```

<br>

### Authorization token precisa ser inserido na requisição para rotas de clientes. 
#### Nos vendedores é precisao estar autenticado para editar ou deletar.

<br>

## Exibir informações de um cliente com id: 

url: {{BASE_API}}/clientes/{$id} 
Método: GET

<br>

## Atualizar informação de cliente: 
url: {{BASE_API}}/clientes/{$id}   
Método: PUT

  ### A imagem do cliente pode ser um arquivo enviado por formulário da aplicação ou uma inserção de link na api
```json
  {
      "name" : "Jho",
      "email" : "Jho@uniax.com",
      "image": "imagem" 
  }
```
<br>

## Pegar todos os registros de clientes:
url: {{BASE_API}}/clientes  
Método: GET

<br>

## Deletar Cliente
url: {{BASE_API}}/clientes/22
Método: DELETE

<br>

## As tabelas que possuem elo com clientes precisam ser inseridas atraves da api.

### Ex de tipos de cliente
```json  
  {
    "client_id": 7,
    "client_type": 1
  }
```
- Caso seja enviado um id que não exista a api retornará uma mensagem com erro

```json  
  {
    "client_id": 7,
    "client_type": 100000000
  }
```

```json  
  {
    "message": "O tipo de documento para clientes com id: 3000, não existe!"
  }
``` 
