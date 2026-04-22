<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

class HomeController
{
    public function home()
    {
        return [
            'name' => 'Board API',
        ];
    }
}
