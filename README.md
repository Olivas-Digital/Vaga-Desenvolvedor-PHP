# Instalação

Requerimentos:
- [PHP >= 7.3](https://www.php.net/downloads)
- [MySQL >= 5.7](https://dev.mysql.com/downloads/mysql/)
- [Composer](https://getcomposer.org/download/)
- Descomente as linhas abaixo no arquivo `[diretorio_php]/php.ini`:
    - extension=fileinfo
    - extension=mbstring
    - extension=openssl
    - extension=pdo_mysql
    - extension=pdo_sqlite

Utilize o comando abaixo para baixar o repositório do projeto e executar o script de instalação:
```bash
git clone https://github.com/kvn-alcantara/Vaga-Desenvolvedor-PHP && cd Vaga-Desenvolvedor-PHP && sh ./scripts/install.sh
```

Crie um schema chamado `olivas_crud` e altere as variáveis no arquivo `.env` para corresponder ao seu ambiente local.

Para conseguir enviar emails você vai precisar criar uma conta no [Mailtrap](https://mailtrap.io/) e alterar as variáveis no arquivo `.env` para corresponder as suas credenciais.

Tudo pronto! 😎

> Caso precise fazer alterações diretamente no banco ou gerar as seeders novamente, use `php artisan cache:clear` para limpar o cache e ver as mudanças.
