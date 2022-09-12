Tecnologia em Análise e Desenvolvimento de Sistemas
Setor de Educação Profissional e Tecnológica - SEPT
Universidade Federal do Paraná - UFPR

# Trabalho para a disciplina DS122 - Desenvolvimento de Aplicações Web 1
Aluno: Cristopher Kovalski Saporiti GRR20214715

## Tema: Blog 
###  Características:
- Sistema de registro de usuários com dois tipos posivéis: Admin ou Usuários Normais
- O blog possui uma área separada para público e admin;
- A área de admin só é acessada através de login de um Admin.
- Na área de admin existem dois tipos de usuários:
- Admin:
- Pode criar, ver, editar, excluir, publicar ou não publicar qualquer post (CRUD simples);
- Pode também criar, ver, editar e excluir tópicos.
- Um usuário Admin pode criar outros admins e autores
- Pode ver, editar e deletar outros admins.
- Autor:
- Pode ver, atualizar, criar e deletar posts apenas que ele mesmo criou;
- Eles não pode publicar um post. Todo forma de publicação é feita pelo Admin.
- Só posts publicados são mostrados na área publica;
- Cada post tem sua categoria/tópico.
- A página de entrada/publica mostra os posts com imagem principal, nome do autor e data de criação.
- O usuário pode buscar posts parecidos clicando nos tópicos.

### Ferramentes de Desenvolvimento
A maioria do código foi escrito em PHP em conjunção com manipulação de CSS. Em casos limitados foram usadas funçoes Javascript. O Banco de Dados foi o MariaDB(Mysql).

### Registro - Login
Foi implementando um sistema de registro e  login simples com validação frontend por funções de Javascript e validação de formulário em conjunto com php e o banco de dados.

### Área Admin 
#### Dashboard
Exibe o número total de usuários, posts e tópicos. Pode encaminhar para área de Criação de Posts, Usuários e Tópicos.
### Menu
#### Criar Posts
Permite criar posts com Titulo, imagem principal, texto¹ e seleção do tópico. Não deixa criar se um dos campos não estiver preenchido.
#### Editar Posts
Permite editar, publicar ou retirar da publicação e deletar posts através dos botões;
#### Criar Tópicos
Permite criar tópicos com Titulo, não deixa criar sem preencher.
#### Editar Tópicos
Permite editar e deletar Tópicos através dos botões;
#### Criar Usuários
Permite criar Usuários com Nome, Email, Senha, função.
#### Editar Usuários
Permite editar e deletar usuários através dos botões;
### Banco de Dados
Foi usado a ferramenta XAMPP para emular um banco de dados; As tabelas criadas foram de usuários (users), posts, topicos (topics) e (post_topics). Sendo todas relacionados em algum grau;
#### Topologia BD:

#### Posts (TABLE posts):
+----+-----------+--------------+--------------+
|     Campo      |     tipo     |especificação |
+----+-----------+--------------+--------------+
|  id            | INT(11)      |              |
|  user_id       | INT(11)      |              |
|  title         | VARCHAR(255) |              |
|  slug          | VARCHAR(255) | UNIQUE       |
|  views         | INT(11)      |              |
|  image         | VARCHAR(255) |              |
|  body          | TEXT         |              |
|  published     | boolean      |              |
|  created_at    | TIMESTAMP    |              |
|  updated_at    | TIMESTAMP    |              |
+----------------+--------------+--------------+
#### Usuários (Table users):
+----+-----------+------------------------+--------------+
|    Campo       |     tipo               |especificação |
+----+-----------+------------------------+--------------+
|  id            | INT(11)                |              |
|  username      | VARCHAR(255)           | UNIQUE       |
|  email         | VARCHAR(255)           | UNIQUE       |
|  role          | ENUM("Admin","Author") |              |
|  password      | VARCHAR(255)           |              |
|  created_at    | TIMESTAMP              |              |
|  updated_at    | TIMESTAMP              |              |
+----------------+--------------+---------+--------------+

#### Topicos (Table topics):
+----+-----------+------------------------+--------------+
|    Campo       |     tipo               | Especificação|
+----+-----------+------------------------+--------------+
|  id            | INT(11)                |              |
|  name          | VARCHAR(255)           |              |
|  slug          | VARCHAR(255)           | UNIQUE       |
+----------------+--------------+---------+--------------+

#### Relação entre tópico e posts (Table post_topics)
+----+-----------+------------------------+---------------+
|   Campo        |     tipo               | especificação |
+----+-----------+------------------------+---------------+
|  id            | INT(11)                |               |
|  post_id       | INT(11)                |  UNIQUE       |
|  topic_id      | INT(11)                |               |
+----------------+--------------+---------+---------------+


### To-do list:
- Implementação de uma seção de comentários.
- Melhoria da interface gráfica.
- ¹Implementação de um editor de texto consequente na área de edição de posts.