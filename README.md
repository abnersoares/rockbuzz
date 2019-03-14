# Rockbuzz Blog
Blog com Frotend + Backoffice desenvolvido em PHP sem a utilização de frameworks.

## Prós
- Utilizado o mínimo de recursos externos possível;
- Log de consumo de APIs RESTful;
- Todos os recursos do Backoffice/Frontend foram desenvolvidos consumindo as APIs;
- Orientado a Objetos;
- Estrutura de arquivos simples;
- Todo o código foi desenvolvido especificamente para esta aplicação.

## Importante
**Como se trata de um app para análise, algumas validações não foram implementadas.**

Caso queira utilizar este projeto para algum fim, sugiro criar validações como:
- Verificar se user esta logado para consumir as APIs;
- Validar se a imagem de cadastro/alteração do post realmente está em base64.

## Ambiente Recomendado
- PHP: 7.2.10
- MySQL: 5.7.23
- OS: MacOS ou Linux

## Instalação
1. Clonar o repositório para o seu servidor (MAMP, XAMPP, WAMP, etc);
2. Criar o banco de dados de acordo com a estrutura abaixo ou **importar o arquivo rockbuzz.sql**.
3. Configurar o arquivo **Config/Config.php** de acordo com a url do seu servidor e dados do banco de dados.
4. *OPCIONAL:* pode ser alterada a constante LOG_FILE em **Config/Config.php** para o nome do arquivo que você queira salvar os logs RESTful.

![](https://bytebucket.org/rockbuzz1/fullstack-test/raw/095a31cac3e41a87be58fe926f39d37cf6b60d3f/database.png)

## Utilização
Ao acessar a url do projeto, será exibida a tela do front-end. Para entrar no módulo administrativo, basta ir para a url **/Admin**.

**Usuário:** teste@teste.com.br
**Senha:** 123

## APIs
Para a utilização das APIs, é necessário utilizar a url **/Api/?op=OPERACAO** passando os parâmetros (quando necessário) via POST em formato JSON.
Segue abaixo a lista de operações disponíveis e seus respectivos parâmetros:

#### Autores
| Operação | Parâmetros | Descrição
| ------------ | ------------ | ------------ |
| AddAuthor  | name (string)  | Insere um novo autor
| EditAuthor  | name (string), id (int)  | Edita o autor existente
| GetAuthor  | id (int)  | Retorna os dados do autor via ID
| GetAuthors  | -  | Retorna todos os autores do banco
| RemoveAuthor  | id (int)  | Remove o autor via ID

> Ao remover um autor, todos os posts publicados pelo mesmo são removidos automaticamente.

#### Posts
| Operação | Parâmetros | Descrição
| ------------ | ------------ | ------------ |
| AddPost  | title (string), body (text), published (boolean), image (base64), tags (string)  | Insere um novo post (tags separadas por vígula)
| EditPost  | title (string), body (text), published (boolean), image (base64), tags (string), id (int)  | Edita o post existente (tags separadas por vígula)
| GetPost  | id (int)  | Retorna os dados do post via ID
| GetPostBySlug  | slug (string)  | Retorna os dados do post via SLUG
| GetPosts  | -  | Retorna todos os posts do banco
| RemovePost  | id (int)  | Remove o post via ID
| EnableDisablePost  | id (int), action (varchar)  | Ativa ou desativa o post passando o parâmetro action = enable/disable

#### Tags
| Operação | Parâmetros | Descrição
| ------------ | ------------ | ------------ |
| AddTag  | name (string)  | Insere uma nova tag
| EditTag  | name (string), id (int)  | Edita a tag existente
| GetTag  | id (int)  | Retorna os dados da tag via ID
| GetTags  | -  | Retorna todas as tags do banco
| RemoveTag  | id (int)  | Remove a tag via ID

> Ao remover uma tag, o vínculo da mesma com o post será removida automaticamente.

#### Usuários (admin)
| Operação | Parâmetros | Descrição
| ------------ | ------------ | ------------ |
| AddUser  | name (string), email (string), password (string)  | Insere um novo usuário
| EditUser  | name (string), email (string), password (string), id (int)  | Edita o usuário existente
| GetUser  | id (int)  | Retorna os dados do usuaário via ID
| GetUsers  | -  | Retorna todos os usuários do banco
| RemoveUser  | id (int)  | Remove o usuário via ID

#### Logs
| Operação | Parâmetros | Descrição
| ------------ | ------------ | ------------ |
| GetLogs  | -  | Retorna os logs de requisições das APIs