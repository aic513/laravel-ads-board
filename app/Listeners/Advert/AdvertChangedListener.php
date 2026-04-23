<?php
declare(strict_types=1);

namespace App\Listeners\Advert;

use App\Jobs\Advert\ReindexAdvert;

class AdvertChangedListener
{
    public function handle($event): void
    {
        ReindexAdvert::dispatch($event->advert);
    }
}
