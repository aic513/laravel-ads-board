<?php
declare(strict_types=1);

namespace App\Providers;

use App\Http\View\MenuPagesComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        View::composer('layouts.app', MenuPagesComposer::class);
    }
}
