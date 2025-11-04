<?php

namespace App\Livewire;

use App\Models\Article;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class ServiceGreeting4 extends Component
{

    public $user;

    public function mount(): void
    {
        // Enable SQL query logging
        DB::enableQueryLog();
        $this->user = auth()->user();


        $hotArticles = $this->user->comments()
            ->with('article')
            ->get()
            ->pluck('article')
            ->unique('id')
            ->filter(fn($a) => $a->views > 100)      // Filter popular articles
            ->sortByDesc('views')                      // Sort by popularity
            ->map(fn($a) => [                        // Transform format
                'title111' => $a->title,
                'views' => $a->views,
                'label' => $a->views > 110 ? '✨Bestseller' : '🔥Popular',
            ])
//            ->flatten()
            ->toArray();

        $allArticles = $this->user->articles()           // Articles created by user
        ->get()
            ->merge(
                $this->user->comments()                  // Merge: articles commented by user
                ->with('article')
                    ->get()
                    ->pluck('article')
                    ->unique('id')
            )
            ->unique('id')                               // Remove duplicates
            ->filter(fn($a) => $a->views > 100)        // Filter popular articles
            ->toArray();
    }


    public function render(): View
    {
        return view('livewire.service-greeting4');
    }
}
