<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class ReverbSingleJob extends Page
{
    protected string $view = 'filament.pages.reverb-single-job';

    protected function getHeaderActions(): array
    {
        return [];
    }

    public static function getNavigationBadge(): ?string
    {
        return "New";
    }

    public static function getNavigationIcon(): string
    {
        return "heroicon-o-star";
    }

    public function getTitle(): string
    {
        return "Job Progress Real-time Monitoring(Single Job)";
    }
}
