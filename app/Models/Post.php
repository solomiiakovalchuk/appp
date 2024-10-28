<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use phpDocumentor\Reflection\Types\Boolean;
use Spatie\Translatable\HasTranslations;

class Post extends Model
{
    use SoftDeletes;
    use HasFactory;
    use HasTranslations;

    public $translatable = ['title', 'short_description', 'body'];
    protected $fillable = [
        'slug',
        'status',
        'published_at',
        'scheduled_for',
        'cover_photo_path',
        'photo_alt_text',
        'user_id',
        'visible_on_slider',
    ];

    protected $dates = [
        'scheduled_for',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'published_at' => 'datetime',
        'scheduled_for' => 'datetime',
        'status' => 'boolean',
        'user_id' => 'integer',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_post');
    }

    public function comments(): hasmany
    {
        return $this->hasMany(Comment::class);
    }

    public function likes(): hasmany
    {
        return $this->hasMany(Like::class);
    }

    public function isLikedByUser()
    {
        return $this->likes()->where('user_id', auth()->id())->exists();
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'post_tag');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function formattedPublishedDate()
    {
        return $this->published_at?->format('d M Y');
    }
    //
    //    public function relatedPosts($take = 3)
    //    {
    //        return $this->whereHas('categories', function ($query) {
    //            $query->whereIn(config('filamentblog.tables.prefix').'categories.id', $this->categories->pluck('id'))
    //                ->whereNotIn(config('filamentblog.tables.prefix').'posts.id', [$this->id]);
    //        })->published()->with('user')->take($take)->get();
    //    }

    protected function getFeaturePhotoAttribute()
    {
        return asset('storage/' . $this->cover_photo_path);
    }

    public function getTranslationWithFallback($attribute, $locale = null)
    {
        $locale = $locale ?? app()->getLocale();
        $translation = $this->getTranslation($attribute, $locale);

        if (empty($translation)) {
            $translations = $this->getTranslations($attribute);
            return !empty($translations) ? reset($translations) : null;
        }

        return $translation;
    }
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($post) {
            foreach ($post->translatable as $attribute) {
                foreach (config('app.locales') as $locale) {
                    if (empty($post->getTranslation($attribute, $locale))) {
                        $fallbackValue = $post->getTranslationWithFallback($attribute);
                        if ($fallbackValue) {
                            $post->setTranslation($attribute, $locale, $fallbackValue);
                        }
                    }
                }
            }
        });
    }
}
