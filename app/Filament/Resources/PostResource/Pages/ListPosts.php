<?php

namespace App\Filament\Resources\PostResource\Pages;

use Filament\Actions;
use App\Filament\Resources\PostResource;
use Filament\Resources\Pages\ListRecords;
use Pboivin\FilamentPeek\Pages\Actions\PreviewAction;
use Pboivin\FilamentPeek\Pages\Concerns\HasPreviewModal;

class ListPosts extends ListRecords
{
    protected static string $resource = PostResource::class;

    use HasPreviewModal;
    use ListRecords\Concerns\Translatable;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\LocaleSwitcher::make(),
        ];
    }

    protected function getTableActions(): array
    {
        return [
            PreviewAction::make('preview')
                ->record(fn($record) => $record)
                ->viewData(fn($record) => [
                    'post' => $record,
                ]),
        ];
    }

    protected function getPreviewModalView(): ?string
    {
        return 'posts.show';
    }

    protected function getPreviewModalDataRecordKey(): ?string
    {
        return 'post';
    }
}
