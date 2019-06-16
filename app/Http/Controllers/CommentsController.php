<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Comment;

class CommentsController extends Controller
{
    public function index()
    {
        $comments = Comment::with('post', 'user')->get();
        return response()->json($comments);
    }
}
