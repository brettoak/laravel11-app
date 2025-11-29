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

    public function getTitle(): string
    {
        return 'Reverb Single Job';
    }
}
