<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class BookService
{
    public function getExternalBooks(string $name = '')
    {
        return Http::get(config('iceandfireapi.base_url') . 'books', [
            'name' => $name
        ]);
    }
}