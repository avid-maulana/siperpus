<?php

namespace App\Http\Controllers;

class JournalController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Ebook & Ejurnal
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        return view('journal.index', [
            'journals' => collect(config('journals.list'))
                ->sortBy('name')
                ->values(),
        ]);
    }
}