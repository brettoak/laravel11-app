<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ExcuteTimeDelayJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $randomDelay = rand(5, 15);
        sleep($randomDelay);
        \Log::info("Job executed after a delay of {$randomDelay} seconds.");
    }
}
