Boa noite,

Estou enviando o que deu para fazer entre ontem e hoje. Peço desculpas pela demora, mas a semana foi corrida.

Fiz os CRUDS vendedor e clientes, com seus respectivos controladores e models.
Coloquei uma API da sendgrid para envio de Email, mas poderia ter sido usado o phpmailer ou a funcao mail do laravel
Fiz uma autenticacao basica com JWT, eu mesmo fiz o processo de geracao do JWT e decodificacao, poderia ter sido usado a library Firebase JWT Library ou do laravel, mas acabei fazendo o token do zero reinventando a roda haha.

Faltou fazer os relacionamentos das tabelas usando Eloquent
Faltou fazer a pesquisa por nome

Nao fiz a checkagem completa dos campos, fiz de forma generica se o nome ou email tiver o char_count menor que 4, nome invalido e email invalido, como isso é apenas um teste não entrei a fundo mas poderia fazer as regex de email e tudo mais juntamente com as verificações de segurança, nos campos para evitar qualquer possivel vulnerabilidade como xxs, csrf, sql injec, embora o laravel ja disponha de um bom framework com protocolos de segurança, é bom fazer as verificações e sanitizar as variaveis.







<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>



------------------



Boa noite,

Esse final de semana, tive que terminar um projeto que estava em andamento, então acabei focando na obrigatoriedade afim de cumprir as metas.
Vou fazer o teste essa semana, inclusive ja tenho o CRUD feito no PHP puro, pois ja utilizei varias vezes nos projetos, mas vou precisar ajustar para o Laravel afim de atender os requisitos do teste.

Abaixo, estou enviando os comandos para criação das duas tabelas com o migration

php artisan make:migration Vendedor --create=vendedor
php artisan make:migration Clientes --create=clientes
php artisan migrate

E os respectivos campos solicitados:

public function up()
    {
        Schema::create('vendedor', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('email');
        });
    }
    
    


public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('email');
            $table->string('imagem');
            $table->string('telefone');
            $table->string('tipocliente');
            $table->bigInteger('vendedores');
        });
    }






--------


<a href="https://www.olivas.digital" target="_blank" style="background-color: #fff"><img src="https://www.olivas.digital/wp-content/themes/olivasdigital/dist/img/logotipo.svg" style="background: white" width="320" align="center" /></a>


Vaga Desenvolvedor PHP
===============	
Nós da Olivas Digital buscamos um(a) desenvolvedor(a) para transformar ideias em códigos que estará envolvido em vários aspectos, desde o conceito até o produto final, incluindo UX, criação e codificação utilizando PHP.


# Sobre a vaga
##### Responsabilidades:
- Desenvolvimento de plataformas, sites, e-commerce e aplicativos
- Manutenção e evolução de sistemas legados
- Apoio aos desenvolvedores Junior
- Identificar problemas e propor melhorias

##### Pré-requisitos:
- Ao menos 3 anos de experiência como desenvolvedor
- Experiência com PHP utilizando ao menos um dos frameworks Laravel, Magento ou Zend
- Conhecimento sobre APIs
- Noções de HTML/CSS utilizando (Webpack, Grunt ou Gulp)
- Boa comunicação e saber trabalhar em equipe
- Compreensão de necessidades para propor soluções frente aos problemas
- Bom entendimento de Design de Interface (UI) e Experiência do Usuário (UX)
- Curso técnico ou tecnólogo em Ciências da Computação, Análise e Desenvolvimento de Sistemas, Engenharia da Computação, Sistemas de Informação, Programação ou matérias correlatas e Curso Superior em andamento (mínimo 3°ano) nas áreas de Tecnologia da Informação ou Gestão da Tecnologia da Informação 

##### Serão Considerados como Diferenciais:
- Conhecimento em IONIC, React ou Angular
- Experiência com métodos ágeis/scrum
- Inglês intermediário e avançado
- Experiência com Node

##### Benefícios
- Contrato PJ com 30 dias de férias ao ano
- Vale-Refeição
- Bônus trimestral
- Participação nos Lucros (PLR)

##### Local e trabalho
- 100% remoto ou presencialmente em Barueri-SP

___

# Desafio para vaga (PARTICIPE!) 
### Como participar
- Forkar esse desafio e criar o seu projeto (ou workspace) usando a sua versão desse repositório, após terminar o desafio, submeta um pull request.
- Caso você tenha algum motivo para não submeter um pull request, crie um repositório privado no Github, faça todo desafio na branch master. Assim que terminar seu desenvolvimento, adicione como colaborador o usuário sistema@olivasdigital.com.br no seu repositório e o deixe disponível por pelo menos 30 dias.

### Escopo do projeto

1) **Criar um CRUD** de Vendedor com os campos
    - Nome*
    - Email*
 
Após a criação do CRUD de Clientes, um vendedor pode possuir 0 ou vários clientes.
    
2) **Criar um CRUD** de Clientes com os campos
    - Nome*
    - Email*
    - Imagem*
    - Telefones <em>(Relacionamento 1 pra N, com obrigatoriedade de ao menos 1 telefone)</em>
    - Tipo de cliente* <em>(Relacionamento 1 pra 1)</em>. Sendo que os tipos podem ser “Pessoa Física” e “Pessoa Jurídica”
    - Vendedores <em>(Relacionamento N pra N)</em>. Pode estar vinculado a um ou vários vendedores.

    ***Campos obrigatórios**
3) **Disparar um e-mail** de “Boas vindas” para o cliente
4) Utilizar **migrations** para a criação das tabelas
5) Utilizar o **[Eloquent](https://laravel.com/docs/8.x/eloquent)** para os relacionamentos
6) Disponilizar os dados de clientes via **API com autenticação JWT** permitindo busca por nome
___
### Critério de avaliação
- Organização do código: Separação de módulos, view, model e controller
- Clareza: O README explica de forma resumida como rodar a aplicação?
- Segurança: Existe alguma vulnerabilidade clara?
- Histórico de commits (estrutura e qualidade)
- UX: A interface é de fácil uso e auto-explicativa? A API é intuitiva?
- API: Códigos de Resposta/Verbos HTTP corretos

### Diferenciais:
- Testes automatizados
- Utilização de Cache
- Uso de Logs
- Documentação da API
- [LaravelMix](https://laravel-mix.com/)
- [Eloquent API Resources](https://laravel.com/docs/8.x/eloquent-resources)
- Disparo de e-mail utilizando filas [(Queues)](https://laravel.com/docs/8.x/queues)
