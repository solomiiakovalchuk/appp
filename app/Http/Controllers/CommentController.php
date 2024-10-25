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
        $validatedData = $request->validate([
            'message' => 'required|string|max:500',
            'post_id' => 'required|exists:posts,id',
        ]);

        $comment = new Comment();
        $comment->comment = $validatedData['message'];
        $comment->post_id = $validatedData['post_id'];
        $comment->user_id = Auth::id();
        $comment->status = true; // Позначити коментар як активний, якщо це необхідно
        $comment->save();

        // Відповідь JSON для AJAX-запиту
        return response()->json([
            'success' => true,
            'message' => 'Comment created successfully.',
            'comment' => [
                'message' => $comment->comment,
                'created_at' => $comment->created_at->format('M d, Y'),
            ],
            'user' => [
                'name' => Auth::user()->name,
            ]
        ]);
    }

}
