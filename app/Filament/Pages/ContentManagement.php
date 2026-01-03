<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class ContentManagement extends Page
{

    public static function getNavigationIcon(): ?string
    {
        return 'heroicon-o-document-text';
    }

    public static function getNavigationBadge(): ?string
    {
        return 'new';
    }


    public static function getNavigationSort(): ?int
    {
        return 0;
    }


    protected string $view = 'filament.pages.content-management';
}
