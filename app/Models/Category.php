<?php

namespace App\Models;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'is_active',
        'show_in_menu',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'show_in_menu' => 'boolean',
    ];

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'category_post');
    }

    public static function getForm()
    {
        return [
            TextInput::make('title')
                ->live(true)
                ->afterStateUpdated(function (Get $get, Set $set, ?string $operation, ?string $old, ?string $state) {

                    $set('slug', Str::slug($state));
                })
                ->unique('categories', 'title', null, 'id')
                ->required()
                ->maxLength(155),

            TextInput::make('slug')
                ->unique('categories', 'slug', null, 'id')
                ->readOnly()
                ->maxLength(255),
        ];
    }
}
