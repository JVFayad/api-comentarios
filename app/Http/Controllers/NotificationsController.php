<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Notification;
use App\Post;
use App\Comment;

class NotificationsController extends Controller
{
    public function index_user($user_id)
    {
        $content_array = array();

        $notifications = Notification::with('post', 'comment'
            )->whereIn(
                'post_id', Post::where(
                    'user_id', $user_id)->get()->pluck('id')
            )->orWhere(
                'comment_id', Comment::where(
                    'user_id', $user_id)->get()->pluck('id')
            )->orderBy(
                'created_at', 'desc'
        )->get();

        foreach($notifications as $notification) {
            if (!$notification->expired()) {
                $content_array[] = array(
                    "id" => $notification->id,
                    "comment_id" => $notification->comment_id,
                    "comment_user_id" => $notification->comment->user_id,
                    "post_id" => $notification->post_id,
                    "post_user_id" => $notification->post->user_id,
                    "date_created" => $notification->created_at->format('d-m-Y H:i:s'),
                );
            }
        }

        return response()->json($content_array);
    }
}
