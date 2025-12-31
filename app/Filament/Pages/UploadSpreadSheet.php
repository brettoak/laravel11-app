<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Support\Enums\Alignment;

class UploadSpreadSheet extends Page
{

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-arrow-up-circle';
    }

    public static function getNavigationBadge(): string
    {
        return 'new';
    }

    public function getTitle(): string
    {
        return 'Upload Spread Sheet And Show';
    }
    protected string $view = 'filament.pages.upload-spread-sheet';
}
