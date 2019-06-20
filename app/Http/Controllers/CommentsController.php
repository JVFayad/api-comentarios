<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Comment;
use App\User;
use App\Post;
use App\Transaction;
use App\Notification;

use Illuminate\Support\Facades\Validator;

class CommentsController extends Controller
{
    # Lista todos comentários
    public function index()
    {
        $comments = Comment::with('post', 'user')->get();
        return response()->json($comments);
    }

    # Ordena e formata o conteudo de retorno de listagem da api
    private function orderContent($comments)
    {
        # Paginacao de 5 comentarios por chamada
        $comments = $comments->paginate(5);
        $content_array = array(
            'page' => $comments->currentPage(),
            'total_pages' => $comments->lastPage(),
            'comments' => array(),
        );

        # Cria a estrutura de retorno e que
        # auxiliara na ordenacao por destaque
        foreach($comments as $comment) {
            $comment_user = $comment->user;
            $content_array['comments'][] = array(
                'user_id' => $comment->user_id,
                'id' => $comment->id,
                'login' => $comment_user->login,
                'subscriber' => (bool) $comment_user->subscriber,
                'highlight' => (bool) $comment->highlight,
                'still_highlight' => $comment->still_highlight(),
                'date_created' =>  $comment->created_at->format('d-m-Y H:i:s'),
                'content' => $comment->content, 
            );
        }

        # Ordena pela prioridade criada
        # para o destaque
        usort ($content_array['comments'], function ($left, $right) {
            return $right['still_highlight'] - $left['still_highlight'];
        });

        return $content_array;
    }

    # Lista todos comentários de uma postagem
    public function index_post($post_id)
    {
        $comments = Comment::with('post', 'user'
            )->where(
                'post_id', $post_id
            )->orderBy(
                'created_at', 'desc'
            )->orderBy(
                'highlight_value', 'desc'
            );
        
        $content_array = $this->orderContent($comments);

        return response()->json($content_array);
    }

    # Lista todos comentários de um usuário
    public function index_user($user_id)
    {
        $comments = Comment::with('post', 'user'
            )->where(
                'user_id', $user_id
            )->orderBy(
                'created_at', 'desc'
            )->orderBy(
                'highlight_value', 'desc'
            );
        
        $content_array = $this->orderContent($comments);

        return response()->json($content_array);
    }

    # Função responsavel por validar se todos
    # os dados do comentario foram enviados
    # TODO: Fazer atraves do requests (tentei mas apresentou problemas)
    private function commentValidator($request) 
    {

        $validator = Validator::make($request->all(), [
            'content' => 'required',
            'type' => 'required|max:8',
            'highlight_value' => 'required',
            'post_id' => 'required',
        ]);

        return $validator;
    }

    # Cria novo comentário
    public function store(Request $request)
    {
        $highlight = FALSE;
        $validator = $this->commentValidator($request);

        if ($validator->fails()) {
            return response()->json([
                "status" => 400,
                "message" => $validator->messages()->all(),
            ], 400);
        }

        # Se já houverem 10 comentarios no periodo de 50 segundos,
        # nao permite que seja feito um novo
        $last_comments = Comment::where(
            'created_at', '>=', \Carbon\Carbon::now()->subSeconds(50)
        )->get()->count();

        if ($last_comments >= 10) {
            return response()->json([
                "status" => 429,
                "message" => "O limite de comentários em um determinado tempo foi excedido",
            ], 429);
        }

        $params = $request->all();

        # Pega o usario direto da basic auth
        $params['user_id'] = auth()->user()->id;

        $comment_user = User::find($params['user_id']);
        $comment_post = Post::find($params['post_id']);

        # Se for pedido destaque e o dinheiro do usuario for maior que o da compra,
        # entao pode comprar destaque do comentario
        if ($params['highlight_value'] > 0) {
            if ($comment_user->cash >= $params['highlight_value']) {
                $highlight = TRUE;
                $params['highlight'] = 1;
    
                # Se for possivel comprar destaque, gera a transação para historico
                $transaction = new Transaction();
                $transaction->createTransaction(
                    $params['highlight_value'],
                    $comment_user->id
                );

                # Desconta o valor da transacao do dinheiro que o usuario possui
                $comment_user->discountCash($params['highlight_value']);
    
            } else {
                return response()->json([
                    "status" => 405,
                    "message" => "Não há dinheiro suficiente para esta compra de destaque",
                ], 405);
            }
        }

        # Se os usuarios do comentário e da postagem nao forem assinantes, ou
        # nao houver destaque para compra, 
        if (
            !$comment_user->subscriber 
            && !$comment_post->subscriber
            && !$highlight
        ) {
            return response()->json([
                "status" => 405,
                "message" => "Os usuários não são assinantes, e nao houve compra de destaque",
            ], 405);
        }

        # Cria o comentario
        $comment = new Comment();
        $comment->createComment($params);

        # Antes de retornar, cria a notificacao
        $notification = new Notification();
        $notification->createNotification($comment_post->id, $comment->id);

        return response()->json($comment, 201);
    }

    # Deleta comentário
    public function destroy($id)
    {
        $comment = Comment::find($id);
        $user = auth()->user();

        if(!$comment) {
            return response()->json([
                "status" => 404,
                "message" => "Comentário não encontrado",
            ], 404);
        }

        if (
            $user->id == $comment->user->id
            || $user->id == $comment->post->user->id
        ) {
            $comment->delete();
        } else {
            return response()->json([
                "status" => 405,
                "message" => "Você não pode apagar este comentário",
            ], 405);
        }
    }
}
