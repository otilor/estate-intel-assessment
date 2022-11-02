<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\GetBooksByNameRequest;
use App\Services\BookService;
use App\Http\Resources\BookResource;

class BooksController extends Controller
{
    public function externalBooks(GetBooksByNameRequest $request)
    {
        $data = json_decode((new BookService())->getExternalBooks($request?->name));
        if (! $data) {
            return response()->json([
                'status_code' => 404,
                'status' => 'not found',
                'data' => $data
            ])->setStatusCode(404);
        }

        return response()->json([
            'data' => BookResource::collection($data)
        ]);
    }
}