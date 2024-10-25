<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\Pages\EditPost;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Pages\Page;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use FilamentTiptapEditor\TiptapEditor;
use Illuminate\Support\Str;
class PostResource extends Resource
{
    use Translatable;
    protected static ?string $model = Post::class;
    protected static ?string $navigationLabel = 'News';
    protected static ?string $pluralLabel = 'News';

    protected static ?string $label = 'News';
    protected static ?string $navigationGroup = 'News';

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?int $navigationSort = 3;

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationBadge(): ?string
    {
        return Post::count();
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Blog Details')
                    ->schema([
                        Fieldset::make('Titles')
                            ->schema([
                                Select::make('category_id')
                                    ->multiple()
                                    ->preload()
                                    ->createOptionForm(Category::getForm())
                                    ->searchable()
                                    ->relationship('categories', 'name')
                                    ->columnSpanFull(),

                                TextInput::make('title')
                                    ->live(true)
                                    ->afterStateUpdated(fn (Set $set, ?string $state) => $set(
                                        'slug',
                                        Str::slug($state)
                                    ))
                                    ->required()
                                    ->unique('posts', 'title', null, 'id')
                                    ->maxLength(255),

                                TextInput::make('slug')
                                    ->maxLength(255),

                                Textarea::make('sub_title')
                                    ->maxLength(255)
                                    ->columnSpanFull(),

                                Select::make('tag_id')
                                    ->multiple()
                                    ->preload()
                                    ->createOptionForm(Tag::getForm())
                                    ->searchable()
                                    ->relationship('tags', 'name')
                                    ->columnSpanFull(),
                            ]),
                        TiptapEditor::make('body')
                            ->profile('default')
                            ->disableFloatingMenus()
                            ->extraInputAttributes(['style' => 'max-height: 30rem; min-height: 24rem'])
                            ->required()
                            ->columnSpanFull(),
                        Fieldset::make('Feature Image')
                            ->schema([
                                FileUpload::make('cover_photo_path')
                                    ->label('Cover Photo')
                                    ->disk('local')
                                    ->directory('images/posts')
                                    ->hint('This cover image is used in your blog post as a feature image. Recommended image size 1200 X 628')
                                    ->image()
                                    ->preserveFilenames()
                                    ->imageEditor()
                                    ->nullable(),
                                TextInput::make('photo_alt_text')->nullable(),
                            ])->columns(1),
                        Select::make('user_id')
                        ->relationship('user', 'name')
                        ->nullable(false)
                        ->default(auth()->id()),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->deferLoading()
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->description(function (Post $record) {
                        return Str::limit($record->sub_title, 40);
                    })
                    ->searchable()->limit(20),
                Tables\Columns\ImageColumn::make('cover_photo_path')->label('Cover Photo'),
                Tables\Columns\TextColumn::make('user.name')
                ->label('Author'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])->defaultSort('id', 'desc')
            ->filters([
                SelectFilter::make('user')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->multiple(),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                ]),
            ])
            ->headerActions([
                Tables\Actions\LocaleSwitcher::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRecordSubNavigation(Page $page): array
    {
        return $page->generateNavigationItems([
            EditPost::class,
        ]);
    }
    protected function getHeaderActions(): array
    {
        return [
            Action::make('edit')
                ->label('Edit')
                ->icon('heroicon-o-pencil')
                ->url(fn(Post $record) => route('filament.admin.resources.posts.edit', $record->id)),
        ];
    }
    public static function getRelations(): array
    {
        return [
            RelationManagers\CommentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
