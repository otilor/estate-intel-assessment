<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\Book;

class BookService
{
    public function getExternalBooks(string $name = '')
    {
        return Http::get(config('iceandfireapi.base_url') . 'books', [
            'name' => $name
        ]);
    }

    public function saveBook(array $data)
    {
        return Book::create($data);
    }

    public function updateBook($data, $id)
    {
        $book = Book::find($id);
        $book->update($data);
        return $book;
    }
}
