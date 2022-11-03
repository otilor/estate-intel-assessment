<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookStoreRequest;
use App\Http\Requests\GetBooksByNameRequest;
use App\Services\BookService;
use App\Http\Resources\BookResource;
use App\Http\Resources\BookResourceWithId;
use App\Http\Resources\ExternalBookResource;
use Illuminate\Http\Request;
use App\Models\Book;

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
            'status_code' => 200,
            'status' => 'successful',
            'data' => ExternalBookResource::collection($data)
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // if there are no books in the database, return an empty array
        if (Book::count() === 0) {
            return response()->json([
                'status_code' => 200,
                'status' => 'successful',
                'data' => []
            ]);
        }
        // search for books in the database by name, country, release date and publisher
        $books = Book::where('name', 'like', '%' . request()->name . '%')
            ->where('country', 'like', '%' . request()->country . '%')
            ->where('publisher', 'like', '%' . request()->publisher . '%')
            ->where('release_date', 'like', '%' . request()->release_date . '%')
            ->paginate(15);

        return response()->json([
            'status_code' => 200,
            'status' => 'successful',
            'data' => BookResourceWithId::collection($books)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookStoreRequest $request)
    {
        // save book to database
        $book = (new BookService())->saveBook($request->validated());
        return response()->json([
            'status_code' => 201,
            'status' => 'success',
            'data' => new BookResource($book)
        ])->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}