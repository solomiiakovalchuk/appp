<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Like;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::query()->with(['categories', 'user', 'tags'])->orderBy('created_at', 'desc')
            ->paginate(10);
        $tags = Tag::get();
        return view('posts.index', [
            'posts' => $posts,
            'tags' => $tags,
        ]);
    }

    public function more(Request $request, $slug = null)
    {
        $categorySlug = $request->route()->parameter('category');
        $tagSlug = $request->route()->parameter('tag');
        $tags = Tag::all();

        $category = $categorySlug ? Category::where('slug', $categorySlug)->first() : null;
        $tag = $tagSlug ? Tag::where('slug', $tagSlug)->first() : null;

        if ($category) {
            $posts = Post::whereHas('categories', fn($query) => $query->where('slug', $category->slug))
                ->with(['categories', 'user', 'tags'])->orderBy('created_at', 'desc')
                ->paginate(10);
            $filterTitle = 'Category: ' . $category->title;
        } elseif ($tag) {
            $posts = Post::whereHas('tags', fn($query) => $query->where('slug', $tag->slug))
                ->with(['categories', 'user', 'tags'])->orderBy('created_at', 'desc')
                ->paginate(10);
            $filterTitle = 'Tag: ' . $tag->title;
        } else {
            $posts = Post::with(['categories', 'user', 'tags'])->orderBy('created_at', 'desc')->paginate(10);
            $filterTitle = null;
        }

        return view('posts.more', [
            'posts' => $posts,
            'tags' => $tags,
            'filterTitle' => $filterTitle,
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
                $query->where('title', 'like', '%' . $request->get('query') . '%')
                    ->orWhere('sub_title', 'like', '%' . $request->get('query') . '%');
            })
            ->paginate(10)->withQueryString();

        return response()->json([
            'posts' => $searchedPosts,
            'searchMessage' => 'Search result for ' . $request->get('query'),
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

    public function like(Request $request, Post $post)
    {
        $user = Auth::user();

        $existing_like = Like::where('post_id', $post->id)->where('user_id', $user->id)->first();

        if ($existing_like) {
            $existing_like->delete();
            return response()->json(['status' => 'unliked']);
        } else {
            Like::create([
                'post_id' => $post->id,
                'user_id' => $user->id,
            ]);
            return response()->json(['status' => 'liked']);
        }
    }
}
