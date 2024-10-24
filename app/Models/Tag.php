<?php
namespace App\Models;


use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
    ];

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'post_tag');
    }

    public static function getForm()
    {
        return [
            TextInput::make('name')
                ->live(true)->afterStateUpdated(fn(Set $set, ?string $state) => $set(
                    'slug',
                    Str::slug($state)
                ))
                ->unique('tags', 'name', null, 'id')
                ->required()
                ->maxLength(50),

            TextInput::make('slug')
                ->unique('tags', 'slug', null, 'id')
                ->readOnly()
                ->maxLength(155),
        ];
    }
}
