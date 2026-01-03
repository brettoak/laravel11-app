<?php

namespace App\Livewire;

use Livewire\Component;

class ContentManagement extends Component
{
    use \Livewire\WithPagination;

    public function delete($id)
    {
        $article = \App\Models\Article::find($id);
        if ($article) {
            $article->delete();
        }
    }

    public function render()
    {
        return view('livewire.content-management', [
            'articles' => \App\Models\Article::latest()->paginate(10)
        ]);
    }
}
