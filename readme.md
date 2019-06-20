<h1>API Comentários</h1>

Este projeto foi desenvolvido utilizando basicamente:
```
    - PHP 7.1.30
    - Laravel Framework 5.8.23 
    - MySQL 8.0.13 
```

O Projeto não está totalmente completo, embora sua maior parte esteja. Algumas partes como o envio de email e otimização não estão prontas, pois não tive tempo de finalizar. Certas coisas que foram pedidas na prova eu desensolvi da maneira que interpretei e achei ser melhor, incluse estou aberto para o feedback caso eu tenho feito/entendido algo errado.

Este foi meu primeiro projeto em PHP/Laravel. Tentei seguir os padrões MVC do framework, então a estrutura do projeto eu mantive basicamente a mesma de quando ele é criado, com os models localizados dentro de "app/", os controllers em "app/Http/Controllers", as migrations e seeds em "database/", as rotas em "routes/api.php", entre outros. 

Não utilizei nenhuma tecnologia externa de contêineres, pois vi que o Laravel já tem algumas ferramentas para isso e é relativamente simples de rodar (pretendia utilizar docker e afins, mas por causa do tempo e a não familiaridade com as tecnologias do projeto, acabei priorizando desenvolver a API em si). Os únicos procedimentos que terão que ser feitos, são alterar as configurações de conexão do banco, no arquivo ".env", para o que for criado para os testes (create database x), além dos outros passos, que eu não descreverei aqui, mas indicarei o tutorial abaixo, que explica muito bem cada um.

Tutorial: https://devmarketer.io/learn/setup-laravel-project-cloned-github-com/

Obs: Coloquei seeds para popular o banco com usuarios e postagens, pois não existem endpointas para isso, e eles são necessários para teste, então é importante rodar o comando de seeds do tutorial.

Usuários de Teste:
```
1. id: 1 / name: "Joao Teste" / email: "joao.teste@gmail.com" / password: "senha" / login: "joao_teste" / subscriber: TRUE / cash: 100 
2. id: 2 / name: "Pedro Teste" / email: "pedro.teste@gmail.com" / password: "senha" / login: "pedro_teste" / subscriber: FALSE / cash: 10 
```

Postagens de Teste:
```
1. id: 1 / content: "Postagem de testes" / type: "text" / user_id: 1
2. id: 2 / content: "Postagem de testes 2" / type: "text" / user_id: 2
```

Por uma questão de padronização de projetos Laravel e criação de componentes, deixe o nome das tabelas/models e atributos em inglês, mas fiz da maneira que achei mais intuitiva e correta possível.

Sobre a API, para autenticação, utilizei Basic Auth, baseada no email e senha do usuário. As chamadas só poderão ser realizadas por um usuário cadastrado, do contrário não será autorizado.

Todos os endpoints de listagem possuem paginação, então caso queira uma página especifica, é só inserir "?page=x" ao final da url. As informações de número da página e total de páginas estarão no início do json de retorno. 

Utilizei o Postman para testes, mas coloquei as chamadas com curl caso queiram utilizar (curl realizado no Windows).

<h2>Endpoints:</h2>

<h3>Comentar</h3>
<h5>
curl http://localhost:8000/api/comments/ --user joao.teste@gmail.com:senha -H "Content-type:application/json" -X POST -d @json.txt
</h5>

Conteúdo do arquivo json.txt:
```json
{
   "content":"Conteúdo",  // Conteúdo do comentário
   "type":"texto",        // Tipo do comentário
   "highlight_value":5,   // Valor de destaque (se não houver compra de destaque, passar 0)
   "post_id":1            // ID da postagem relacionada
}
```

<h3>Listar comentarios de um Usuário</h3>
<h5>
curl --user email:password -X GET http://localhost:8000/api/comments/user/{user_id}
</h5>

<h3>Listar comentários de uma Postagem</h3>
<h5>
curl --user email:password -X GET http://localhost:8000/api/comments/post/{post_id}
</h5>

<h3>Remover comentário</h3>
<h5>
curl --user email:password -X DELETE http://localhost:8000/api/comments/{comment_id}
</h5>

<h3>Listar notificações de um usuário</h3>
<h5>
curl --user email:password -X GET http://localhost:8000/api/notifications/user/{user_id}
</h5>

Se tiverem quaisquer dúvidas podem entrar em contato comigo.
