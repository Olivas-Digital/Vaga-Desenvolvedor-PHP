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
