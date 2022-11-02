<?php

use App\Http\Controllers\Controller;
use App\Http\Requests\GetBooksByNameRequest;
use Illuminate\Http\Request;

class BooksController extends Controller
{
    public function externalBooks(GetBooksByNameRequest $request)
    {
        $data = (new BookService())->getExternalBook($request?->name);
        return response()->json([
            'data' => BookResource::collection($data)
        ]);
    }
}