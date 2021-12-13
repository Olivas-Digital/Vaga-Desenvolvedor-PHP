<a href="https://www.olivas.digital" target="_blank" style="background-color: #fff"><img src="https://www.olivas.digital/wp-content/themes/olivasdigital/dist/img/logotipo.svg" style="background: white" width="320" align="center" /></a>


Vaga Desenvolvedor PHP
===============	
## Instalação

Primeiramente, clone este repositório:

```sh
git clone https://github.com/MatheusBespalec/Vaga-Desenvolvedor-PHP.git
```

Agora com os aquivos do projeto renomeie  o arquivo ".env.example" para ".env", em seguida iremos configurar este arquivo, mas antes, no diretório principal do projeto digite o comando

```sh
composer install
```
E logo em seguida 


```sh
php artisan key:generate
```

Agora, já no arquivo ".env" defina a url do projeto, por padrão no laravel: http://127.0.0.1:8000

```sh
APP_URL=http://127.0.0.1:8000
```

Enseguida defina os seguintes atributos referentes ao envio de emails e conexão com o banco de dados

```sh
MAIL_MAILER=
MAIL_HOST=
MAIL_PORT=
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=
MAIL_FROM_ADDRESS=
MAIL_FROM_NAME="${APP_NAME}"

DB_CONNECTION=
DB_HOST=
DB_PORT=
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
```

De volta ao terminal, exculte os comandos

```sh
php artisan jwt:secret
```

```sh
php artisan migrate --seed
```

```sh
php artisan storage:link
```
Por fim em um terminal separado sirva a aplicação

```sh
php artisan serve
```
E em outro, para o processamento das queues, deixe também em execução o comando

```sh
php artisan queue:work --tries=3
```

Tudo pronto, agora basta abrir o projeto em seu navegador e realizar o cadastro de seu usuario para usar a aplicação.

## API

Logo ao fazer login na aplicação você vera uma tela de boas vindas e seu token de autorização, que expira dentro do periodo de 1h após o login. Após esse tempo é nescessario realizar login novamente para receber um novo token.

Agora, para utilizar a API,com o token em mãos, você pode enviar uma requisição GET para <url_da_aplicação>/api/customers,  assumindo a url como http://127.0.0.1:8000/, teriamos http://127.0.0.1:8000/api/customers, mas antes nos headers da requisição adicione:

| key | Value |
|-------|--------|
| Accept | application/json | 
| Authorization | Bearer token | 
    
Substitua 'token' pelo seu token de autorização, e realize a requisição, você recebera uma relação dos clientes cadastrados, com suas informações e de seus relacionamentos em formato JSON.
    
### Buscas com API
    
Para realizar buscas utilizando a api iremos adicionar um parametro na url, o 'filters'. Inserir valores a pesquisa funciona da mesma forma que o método where do laravel onde passamor nos parametros: (chave, operador, valor_da_pesquisa), então supondo que iremos buscar os clientes com nome 'Erick", a url de busca ficaria:

```sh
http://127.0.0.1:8000/api/customers?filters=name,like,%erick%;
```
    
Assim como no SQL temos o operador like e podemos colocar o valor da pesquisa entre '%'. Outros parametros de bucsa que temos são email, id, customer_type_id(sendo 1 para  Pessoa Jurídica e 2 para Pessoa Física). Para fazer multiplas pesquisas urilizamos ';' entre os parametros. Supondo que fossemos buscar os clientes do tipo pessoa fisica com nome erick, nossa url de busca seria a seguinte:

```sh
http://127.0.0.1:8000/api/customers?filters=name,like,%erick%;customer_type_id,=,2;
```
