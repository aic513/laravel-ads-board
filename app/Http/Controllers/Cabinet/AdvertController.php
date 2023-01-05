<?php

namespace App\Http\Controllers\Cabinet;

use App\Http\Controllers\Controller;
use App\Http\Middleware\FilledProfile;

class AdvertController extends Controller
{

    public function __construct()
    {
        $this->middleware(FilledProfile::class);
    }

    public function index()
    {
        return view('cabinet.adverts.index');
    }
}