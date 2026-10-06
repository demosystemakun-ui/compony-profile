<?php

namespace App\Observers;

use App\Models\Tariff;
use App\Models\ActivityLog;

class TariffObserver
{
    public function created(Tariff $tariff): void
    {
        ActivityLog::log('created', "Menambahkan tarif: {$tariff->title}", $tariff);
    }

    public function updated(Tariff $tariff): void
    {
        ActivityLog::log('updated', "Memperbarui tarif: {$tariff->title}", $tariff);
    }

    public function deleted(Tariff $tariff): void
    {
        ActivityLog::log('deleted', "Menghapus tarif: {$tariff->title}");
    }
}