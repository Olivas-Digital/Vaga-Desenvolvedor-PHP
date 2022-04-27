# Instalação

Requerimentos:
- [PHP >= 7.3](https://www.php.net/downloads)
- [MySQL](https://dev.mysql.com/downloads/mysql/)
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

Tudo pronto! 😎
