<?php

namespace App\Filament\Resources\PostResource\Pages;

use Filament\Actions;
use App\Filament\Resources\PostResource;
use Filament\Resources\Pages\EditRecord;
use Pboivin\FilamentPeek\Pages\Actions\PreviewAction;
use Pboivin\FilamentPeek\Pages\Concerns\HasPreviewModal;

class EditPost extends EditRecord
{
    protected static string $resource = PostResource::class;
    use EditRecord\Concerns\Translatable;
    use HasPreviewModal;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
            Actions\DeleteAction::make(),
            PreviewAction::make()
                ->viewData([
                    'post' => $this->record,
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
