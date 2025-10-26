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
        // 启用 SQL 查询日志
        DB::enableQueryLog();
        $this->user = auth()->user();


        $hotArticles = $this->user->comments()
            ->with('article')
            ->get()
            ->pluck('article')
            ->unique('id')
            ->filter(fn ($a) => $a->views > 100)      // 筛选热门
            ->sortByDesc('views')                      // 按热度排序
            ->map(fn ($a) => [                        // 转换格式
                'title111' => $a->title,
                'views' => $a->views,
                'label' => $a->views > 110 ? '✨爆款' : '🔥热门',
            ])
//            ->flatten()
            ->toArray();

        $allArticles = $this->user->articles()           // 用户创建的文章
        ->get()
            ->merge(
                $this->user->comments()                  // 合并：用户评论过的文章
                ->with('article')
                    ->get()
                    ->pluck('article')
                    ->unique('id')
            )
            ->unique('id')                               // 再去重
            ->filter(fn ($a) => $a->views > 100)        // 筛选热门
            ->toArray();

        $queries = DB::getQueryLog();
//        dd($hotArticles);
        echo "<pre>";
        print_r($allArticles);die();

        dump($articles->toSql());

    }




    public function render(): View
    {
        return view('livewire.service-greeting4');
    }
}
