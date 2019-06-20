Este projeto foi desenvolvido utilizando basicamente:
    - PHP 
    - Laravel 
    - MySQL80 

O Projeto não está totalmente completo, embora sua maior parte esteja. Algumas partes como o envio de email e otimização, não estão prontas, pois não tive tempo de finalizar. Certas coisas que foram pedidas na proposta eu desensolvi da maneira que interpretei e achei ser melhor, incluse estou aberto para o feedback caso eu tenho feito/entendido algo errado.

Este foi meu primeiro projeto em PHP/Laravel. Tentei seguir os padrões do framework, então a estrutura do projeto eu mantive basicamente a mesma de quando ele é criado.

Não utilizei nenhuma tecnologia externa de contêineres, pois vi que o Laravel já tem algumas ferramentas para isso e é relativamente simples de rodar (pretendia utilizar docker e afins mas, por causa do tempo e a não familiaridade com as tecnologias do projeto, acabei priorizando desenvolver a API em si). As unicos procedimentos que terão que ser feitos, são alterar as configurações de conexão do banco, no arquivo ".env", para o que for criado para os testes (create database x), além dos outros passos, que eu não descreverei aqui, mas indicarei o tutorial abaixo, que explica muito bem cada um.

Tutorial passo a passo: https://devmarketer.io/learn/setup-laravel-project-cloned-github-com/

Obs: Coloquei seeds para popular o banco com usuarios e postagens, pois não existem endpointas para isso, e eles são necessários para teste, então é importante rodar o comando de seeds do tutorial.

Usuários de Teste:
1. id: 1 / name: "Joao Teste" / email: "joao.teste@gmail.com" / password: "senha" / login: "joao_teste" / subscriber: TRUE / cash: 100 
2. id: 2 / name: "Pedro Teste" / email: "pedro.teste@gmail.com" / password: "senha" / login: "pedro_teste" / subscriber: FALSE / cash: 10 

Postagens de Teste:
1. id: 1 / content: "Postagem de testes" / type: "text" / user_id: 1
2. id: 2 / content: "Postagem de testes 2" / type: "text" / user_id: 2

Por uma padronização de projetos Laravel e criação de componentes, deixe o nome das tabelas e atributos em inglês, mas fiz da maneira que achei mais intuitiva e correta possível.

Sobre a API, para autenticação, utilizei Basic Auth, baseada no email e senha do usuário. As chamadas só poderão ser realizadas por um usuário cadastrado, do contrário não será autorizado.

Todos os endpoints de listagem possuem paginação, então caso queira uma pagina especifica, é só inserir "?page=x" ao final da url. As informações de número da página e total de páginas estarão no início do json de retorno. 

Utilizei o Postman para testes, mas coloquei as chamadas com curl caso queiram utilizar (curl realizado no Windows).

Os Endpoints:

<h3>Comentar<h3>
<h5>
curl http://localhost:8000/api/comments/ --user joao.teste@gmail.com:senha -H "Content-type:application/json" -X POST -d @json.txt
<h5>

Conteúdo do arquivo json.txt:
```json
{
   "content":"Conteúdo",  // Conteúdo do comentário
   "type":"texto",        // Tipo do comentário
   "highlight_value":5,   // Valor de destaque (se não houver compra de destaque, passar 0)
   "post_id":1            // ID da postagem relacionada
}
```

# Listar comentarios de um Usuário
curl --user email:password -X GET http://localhost:8000/api/comments/user/{user_id}

# Listar comentários de uma Postagem
curl --user email:password -X GET http://localhost:8000/api/comments/post/{post_id}

# Remover comentário
curl --user email:password -X DELETE http://localhost:8000/api/comments/{comment_id}

# Listar notificações de um usuário
curl --user email:password -X GET http://localhost:8000/api/notifications/user/{user_id}

Se tiverem quaisquer dúvidas podem entrar em contato comigo.
