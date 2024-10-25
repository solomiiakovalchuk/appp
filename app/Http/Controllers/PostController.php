<?php
namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::query()->with(['categories', 'user', 'tags'])
            ->paginate(10);

        return view('posts.index', [
            'posts' => $posts,
        ]);
    }

    public function allPosts()
    {
        $posts = Post::query()->with(['categories', 'user'])
            ->paginate(20);

        return response()->json([
            'posts' => $posts,
        ]);
    }

    public function search(Request $request)
    {
        $request->validate([
            'query' => 'required',
        ]);

        $searchedPosts = Post::query()
            ->with(['categories', 'user'])
            ->where(function ($query) use ($request) {
                $query->where('title', 'like', '%'.$request->get('query').'%')
                    ->orWhere('sub_title', 'like', '%'.$request->get('query').'%');
            })
            ->paginate(10)->withQueryString();

        return response()->json([
            'posts' => $searchedPosts,
            'searchMessage' => 'Search result for '.$request->get('query'),
        ]);
    }

    public function show(Post $post)
    {
        $post->load([
            'user',
            'categories',
            'tags',
            'comments' => fn($query) => $query->where('status', true),
            'comments.user'
        ]);
        return view('posts.show', [
            'post' => $post,
        ]);
    }
}
