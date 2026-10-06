<?php

namespace App\Observers;

use App\Models\News;
use App\Models\ActivityLog;

class NewsObserver
{
    public function created(News $news): void
    {
        ActivityLog::log('created', "Menambahkan berita: {$news->title}", $news);
    }

    public function updated(News $news): void
    {
        ActivityLog::log('updated', "Memperbarui berita: {$news->title}", $news);
    }

    public function deleted(News $news): void
    {
        ActivityLog::log('deleted', "Menghapus berita: {$news->title}");
    }
}