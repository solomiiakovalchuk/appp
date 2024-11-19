<?php

namespace App\Filament\Resources\PostResource\RelationManagers;

use App\Models\Post;
use App\Models\User;
use Filament\Actions\ActionGroup;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CommentsRelationManager extends RelationManager
{
    protected static string $relationship = 'comments';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->label('User')
                    ->options(User::all()->pluck('name', 'id'))
                    ->searchable()
                    ->required(),
                Select::make('post_id')
                    ->options(function () {
                        return Post::all()
                            ->mapWithKeys(function ($post) {
                                $translatedTitle = $post->getTranslation('title', app()->getLocale());
                                return [$post->id => $translatedTitle];
                            });
                    })
                    ->searchable()
                    ->required(),
                TextInput::make('comment')
                    ->required()
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Toggle::make('status'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->limit(20)
                    ->sortable(),
                Tables\Columns\TextColumn::make('post.title')
                    ->label('Title')
                    ->getStateUsing(fn($record) => $record->post->getTranslation('title', app()->getLocale())) // Отримуємо переклад назви поста
                    ->limit(20)
                    ->sortable(),

                Tables\Columns\TextColumn::make('comment')
                    ->searchable()
                    ->limit(20),
                Tables\Columns\ToggleColumn::make('status')
                    ->beforeStateUpdated(function ($record, $state) {
                        $record->status = $state;
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('post_id')
                    ->options(function () {
                        return \App\Models\Post::all()
                            ->mapWithKeys(function ($post) {
                                $translatedTitle = $post->getTranslation('title', app()->getLocale());
                                return [$post->id => $translatedTitle];
                            });
                    })
                    ->searchable(),
                Tables\Filters\SelectFilter::make('user')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->multiple(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    protected static bool $isLazy = false;
}
