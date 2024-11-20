<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Like;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::query()->with(['categories', 'user', 'tags'])->orderBy('created_at', 'desc')
            ->paginate(3);
        $slider_posts = Post::where('visible_on_slider', 1)->get();
        $recentPosts = Post::latest()->take(4)->get();
        $tags = Tag::get();
        $categories = Category::get();
        return view('posts.index', [
            'posts' => $posts,
            'sliderPosts' => $slider_posts,
            'recentPosts' => $recentPosts,
            'tags' => $tags,
            'categories' => $categories,
        ]);
    }

    public function more(Request $request, $slug = null)
    {
        $categorySlug = $request->route()->parameter('category');
        $tagSlug = $request->route()->parameter('tag');
        $tags = Tag::all();
        $categories = Category::all();
        $recentPosts = Post::latest()->take(4)->get();

        $category = $categorySlug ? Category::where('slug', $categorySlug)->first() : null;
        $tag = $tagSlug ? Tag::where('slug', $tagSlug)->first() : null;

        if ($category) {
            $posts = Post::whereHas('categories', fn($query) => $query->where('slug', $category->slug))
                ->with(['categories', 'user', 'tags'])->orderBy('created_at', 'desc')
                ->paginate(5);
            $filterTitle = __('post.categoryFilter')  . $category->title;
        } elseif ($tag) {
            $posts = Post::whereHas('tags', fn($query) => $query->where('slug', $tag->slug))
                ->with(['categories', 'user', 'tags'])->orderBy('created_at', 'desc')
                ->paginate(10);
            $filterTitle = __('post.tagFilter')  . $tag->title;
        } else {
            $posts = Post::with(['categories', 'user', 'tags'])->orderBy('created_at', 'desc')->paginate(10);
            $filterTitle = null;
        }

        return view('posts.more', [
            'posts' => $posts,
            'tags' => $tags,
            'categories' => $categories,
            'recentPosts' => $recentPosts,
            'filterTitle' => $filterTitle,
        ]);
    }

    public function search(Request $request)
    {
        $request->validate([
            'query' => 'required|string|min:2',
            'requestType' => 'in:api,route',
        ]);

        $query = $request->get('query');

        $searchedPosts = Post::query()
            ->with(['categories', 'user'])
            ->where(function ($q) use ($query) {
                $q->where('title', 'like', '%' . $query . '%')
                    ->orWhere('short_description', 'like', '%' . $query . '%');
            })
            ->paginate(10)->withQueryString();

        $searchedCategories = Category::where('title', 'like', '%' . $query . '%')
            ->select('id', 'title')
            ->get();

        $searchedTags = Tag::where('title', 'like', '%' . $query . '%')
            ->select('id', 'title')
            ->get();

        if ($request->get('requestType') === 'route') {
            $slider_posts = Post::where('visible_on_slider', 1)->get();
            $tags = Tag::get();
            $categories = Category::get();
            $recentPosts = Post::latest()->take(4)->get();

            return view('posts.index', [
                'posts' => $searchedPosts,
                'recentPosts' => $recentPosts,
                'sliderPosts' => $slider_posts,
                'tags' => $tags,
                'categories' => $categories,
            ]);
        }
        return response()->json([
            'posts' => $searchedPosts->items(),
            'categories' => $searchedCategories,
            'tags' => $searchedTags,
            'searchMessage' => 'Search results for: ' . $query,
            'pagination' => [
                'total' => $searchedPosts->total(),
                'current_page' => $searchedPosts->currentPage(),
                'last_page' => $searchedPosts->lastPage(),
            ]
        ]);
    }

    public function filterByCategories(Request $request)
    {
        $categories = $request->input('categories', []);

        $postsQuery = Post::with(['categories', 'tags', 'comments'])->withCount('comments');

        if (!empty($categories)) {
            $postsQuery->whereHas('categories', function ($query) use ($categories) {
                $query->whereIn('categories.id', $categories);
            });
        }

        $posts = $postsQuery->paginate(10);

        $data = $posts->map(function ($post) {
            return [
                'id' => $post->id,
                'title' => $post->title,
                'slug' => $post->slug,
                'cover_photo_path' => asset('storage/' . $post->cover_photo_path),
                'author' => $post->user->name,
                'created_at' => $post->created_at->format('F d, Y'),
                'short_description' => $post->short_description,
                'categories' => $post->categories->map(function ($category) {
                    return [
                        'title' => $category->title,
                        'slug' => $category->slug,
                    ];
                }),
                'tags' => $post->tags->map(function ($tag) {
                    return [
                        'title' => $tag->title,
                        'slug' => $tag->slug,
                    ];
                }),
                'is_liked' => $post->isLikedByUser(),
                'comments_count' => $post->comments_count,
            ];
        });

        return response()->json(['posts' => $data]);
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
        $post->setTranslation('body', 'en', $this->convertEditorContentToHtml($post->body));
        return view('posts.show', [
            'post' => $post,
        ]);
    }
    protected function convertEditorContentToHtml($content): string
    {
        if (is_array($content)) {
            return $this->parseRichText($content);
        }
        return $content;
    }
    protected function parseRichText(array $content): string
    {
        $html = '';

        foreach ($content['content'] as $block) {
            if ($block['type'] === 'paragraph') {
                $paragraphText = '';

                foreach ($block['content'] ?? [] as $innerContent) {
                    if ($innerContent['type'] === 'text') {
                        $paragraphText .= $innerContent['text'];
                    }
                }

                $html .= "<p>{$paragraphText}</p>";
            }
        }

        return $html;
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
