Este projeto foi desenvolvido utilizando basicamente:
    - PHP 
    - Laravel 
    - MySQL80 

O Projeto não está totalmente completo, embora sua maior parte esteja. Algumas partes como o envio de email e otimização, não estão prontas, pois não tive tempo de finalizar. Certas coisas que foram pedidas na proposta eu desensolvi da maneira que interpretei e achei ser melhor, incluse estou aberto para o feedback caso eu tenho feito/entendido algo errado.

Este foi meu primeiro projeto em PHP/Laravel. Tentei seguir os padrões do framework, então a estrutura do projeto eu mantive basicamente a mesma de quando ele é criado.

Não utilizei nenhuma tecnologia externa de contêineres, pois vi que o Laravel já tem algumas ferramentas para isso e é relativamente simples de rodar. As unicas coisas que serão necessárias de ser feitas, são alterar as configurações de conexão do banco, no arquivo ".env", para o que for criado para os testes.

Um tutorial bem legal que achei com o passo a passo: https://devmarketer.io/learn/setup-laravel-project-cloned-github-com/

Obs: Coloquei seeds para popular o banco com usuarios e postagens, pois não existem endpointas para isso, e eles são necessários para teste

COLOCAR SEEDS

Por uma padronização de projetos Laravel e criação de componentes, deixe o nome das tabelas e atributos em inglês, mas fiz da maneira que achei mais intuitiva e correta possível.

Os Endpoints:

# Comentar

# Listar comentarios de um Usuário

# Listar comentários de uma Postagem

# Remover comentário

# Listar notificações de um usuário