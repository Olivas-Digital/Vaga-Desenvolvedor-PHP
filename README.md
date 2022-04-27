# Olivas CRUD 💻

### Requerimentos 🤔
- [PHP >= 7.3](https://www.php.net/downloads)
- [MySQL >= 5.7](https://dev.mysql.com/downloads/mysql/)
- [Composer](https://getcomposer.org/download/)
- Descomente as linhas abaixo no arquivo `[diretorio_php]/php.ini`:
    - extension=fileinfo
    - extension=mbstring
    - extension=openssl
    - extension=pdo_mysql
    - extension=pdo_sqlite

### Instalação 🥱

Utilize o comando abaixo para baixar o repositório do projeto e executar o script de instalação:
```bash
git clone https://github.com/kvn-alcantara/Vaga-Desenvolvedor-PHP && cd Vaga-Desenvolvedor-PHP && sh ./scripts/install.sh
```
Powershell:
```powershell
git clone https://github.com/kvn-alcantara/Vaga-Desenvolvedor-PHP; cd Vaga-Desenvolvedor-PHP; ./scripts/install.sh
```

Crie um schema chamado `olivas_crud` e altere as variáveis no arquivo `.env` para corresponder ao seu ambiente local e execute o comando abaixo para criar as tabelas e popular o banco de dados.
```bash
php artisan migrate:fresh --seed
```

Gerar documentação da API:
```bash
php artisan scribe:generate
```

Subir servidor local:
```bash
php artisan serve
```

Verifique se está tudo ok, rode os testes:
```bash
php artisan test
```
Para conseguir enviar emails você vai precisar criar uma conta grátis no [Mailtrap](https://mailtrap.io/) e alterar as variáveis no arquivo `.env` para corresponder as suas credenciais.

## Tudo pronto! 😎

Visualize a documentação da API em: http://localhost:8000/docs

> Você encontra na raiz do projeto o arquivo `olivas-crud.postman_collection.json` para importar a collection no [Postman](https://www.postman.com/downloads/).

> Caso precise fazer alterações diretamente no banco ou gerar as seeders novamente, use `php artisan cache:clear` para limpar o cache e ver as mudanças.
