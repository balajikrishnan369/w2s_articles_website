<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Article;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class PublishArticleScheduled extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:publish-article-scheduled';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish an article on admin scheduled time';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $mytime = Carbon::now('Asia/Kolkata');
       
        $articles = Article::where('status', 'draft')
            ->where('publishing_date', '<=',  $mytime)
            ->get();
        
        foreach ($articles as $article) {
            $article->status = 'published';
            $article->update();
            Log::info("{$article->title} Article Published!");
        }
        $this->info('Checked and published scheduled articles.');
    }
}
