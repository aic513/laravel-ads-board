<?php

namespace App\Http\Controllers\Cabinet;

use App\Http\Controllers\Controller;

class AdvertController extends Controller
{
    public function index()
    {
        return view('cabinet.adverts.index');
    }
}