<?php
namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:500',
            'post_id' => 'required|exists:posts,id', // Ensure to validate post_id
        ]);

        $comment = Comment::create([
            'user_id' => Auth::id(), // Assuming the user is logged in
            'post_id' => $request->post_id,
            'comment' => $request->message,
            'status' => true, // Assuming comments are active by default
        ]);

        return response()->json($comment);
    }
}
