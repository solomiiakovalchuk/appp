<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LikeResource\Pages;
use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class LikeResource extends Resource
{
    protected static ?string $model = Like::class;

    protected static ?string $navigationIcon = 'heroicon-o-heart';
    protected static ?string $navigationGroup = 'News';

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('post_id')
                    ->label('Post')
                    ->options(function () {
                        return Post::all()
                            ->mapWithKeys(function ($post) {
                                $translatedTitle = $post->getTranslation('title', app()->getLocale());
                                return [$post->id => $translatedTitle];
                            });
                    })
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('user_id')
                    ->label('User')
                    ->relationship('user', 'name')
                    ->required(),
                Forms\Components\Toggle::make('is_liked')
                    ->label('Liked')
                    ->disabled()
                    ->onIcon('heroicon-s-heart')
                    ->offIcon('heroicon-s-heart')
                    ->onColor('success')
                    ->offColor('danger'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('User')
                    ->searchable(),
                Tables\Columns\TextColumn::make('post.title')
                    ->label('Title')
                    ->getStateUsing(fn($record) => $record->post->getTranslation('title', app()->getLocale())) // Отримуємо переклад назви поста
                    ->limit(20)
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_liked')
                    ->label('Liked')
                    ->boolean()
                    ->trueIcon('heroicon-s-heart')
                    ->falseIcon('heroicon-o-heart')
                    ->trueColor('danger')
                    ->default('danger'),

            ])
            ->filters([

                Tables\Filters\SelectFilter::make('post_id')
                    ->label('Post')
                    ->options(function () {
                        return \App\Models\Post::all()
                            ->mapWithKeys(function ($post) {
                                $translatedTitle = $post->getTranslation('title', app()->getLocale());
                                return [$post->id => $translatedTitle];
                            });
                    })
                    ->searchable(),

                Tables\Filters\SelectFilter::make('user_id')
                    ->label('User')
                    ->relationship('user', 'name'),

                Tables\Filters\TernaryFilter::make('is_liked')
                    ->label('Liked')
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // 
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLikes::route('/'),
            'create' => Pages\CreateLike::route('/create'),
            'edit' => Pages\EditLike::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['post', 'user'])
            ->latest();
    }
}
