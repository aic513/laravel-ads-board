<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Route\PagePath;

class PageController extends Controller
{
    public function show(PagePath $path)
    {
        $page = $path->page;

        return view('page', compact('page'));
    }
}
