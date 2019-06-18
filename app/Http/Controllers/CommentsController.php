<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Comment;
use App\User;
use App\Post;
use App\Transaction;
use App\Notification;

class CommentsController extends Controller
{
    # Lista todos comentários
    public function index()
    {
        $comments = Comment::with('post', 'user')->get();
        return response()->json($comments);
    }

    # Lista todos comentários de uma postagem
    public function index_post()
    {
        $comments = Comment::with('post', 'user')->get();
        return response()->json($comments);
    }

    # Lista todos comentários de um usuário
    public function index_user()
    {
        $comments = Comment::with('post', 'user')->get();
        return response()->json($comments);
    }

    # Cria novo comentário
    public function store(Request $request)
    {
        $highlight = FALSE;
        $params = $request->all();
        $comment_user = User::find($params['user_id']);
        $comment_post = Post::find($params['post_id']);

        # Se já houverem 10 comentarios no periodo de 50 segundos,
        # nao permite que seja feito um novo
        $last_comments = Comment::where(
            'created_at', '>=', \Carbon\Carbon::now()->subSeconds(50)
        )->get()->count();

        if ($last_comments >= 10) {
            return response()->json([
                'message' => 'O limite de comentários em um determinado tempo foi excedido',
            ], 429);
        }

        # Se for pedido destaque e o dinheiro do usuario for maior que o da compra,
        # entao pode comprar destaque do comentario
        if ($params['highlight_value'] > 0) {
            if ($comment_user->cash >= $params['highlight_value']) {
                $highlight = TRUE;
                $params['highlight'] = 1;
    
                # Se for possivel comprar destaque, gera a transação para historico
                $transaction = new Transaction();
                $transaction->value = $params['highlight_value'];
                $transaction->user_id = $comment_user->id;
                $transaction->save();

                # Desconta o valor da transacao do dinheiro que o usuario possui
                $comment_user->cash -= $params['highlight_value'];
                $comment_user->save();
    
            } else {
                return response()->json([
                    'message' => 'Não há dinheiro suficiente para esta compra de destaque',
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
                'message' => 'Os usuários não são assinantes, e nao houve compra de destaque',
            ], 405);
        }

        $comment = new Comment();
        $comment->fill($params);
        $comment->save();

        // Antes de retornar, cria a notificacao
        $notification = new Notification();
        $notification->post_id = $comment_post->id;
        $notification->comment_id = $comment->id;
        $notification->save();

        return response()->json($comment, 201);
    }

    # Deleta comentário
    public function destroy($id)
    {
        $comment = Comment::find($id);

        if(!$comment) {
            return response()->json([
                'message'   => 'Comentário não encontrado',
            ], 404);
        }

        $comment->delete();
    }
}
