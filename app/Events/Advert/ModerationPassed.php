<?php
declare(strict_types=1);

namespace App\Events\Advert;

use App\Models\Adverts\Advert\Advert;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ModerationPassed
{
    use Dispatchable, SerializesModels;

    public $advert;

    public function __construct(Advert $advert)
    {
        $this->advert = $advert;
    }
}
