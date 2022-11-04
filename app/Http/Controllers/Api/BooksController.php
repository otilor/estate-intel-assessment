<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookIndexRequest;
use App\Http\Requests\BookStoreRequest;
use App\Http\Requests\BookUpdateRequest;
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
            'status' => 'success',
            'data' => ExternalBookResource::collection($data)
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(BookIndexRequest $request)
    {
        // if there are no books in the database, return an empty array
        if (Book::count() === 0) {
            return response()->json([
                'status_code' => 200,
                'status' => 'success',
                'data' => []
            ]);
        }
        // search for books in the database by name, country, release date and publisher
        $books = Book::where('name', 'like', '%' . $request->name . '%')
            ->where('country', 'like', '%' . $request->country . '%')
            ->where('publisher', 'like', '%' . $request->publisher . '%')
            ->where('release_date', 'like', '%' . $request->release_date . '%')
            ->paginate(15);

        return response()->json([
            'status_code' => 200,
            'status' => 'success',
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
        // if book with the given id does not exist, return 404
        if (! Book::find($id)) {
            return response()->json([
                'status_code' => 404,
                'status' => 'not found',
                'data' => []
            ])->setStatusCode(404);
        }
        // return book with the given id
        return response()->json([
            'status_code' => 200,
            'status' => 'success',
            'data' => new BookResourceWithId(Book::find($id))
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BookUpdateRequest $request, $id)
    {
        // if book with the given id does not exist, return 404
        if (! Book::find($id)) {
            return response()->json([
                'status_code' => 404,
                'status' => 'not found',
                'data' => []
            ])->setStatusCode(404);
        }
        // update book with the given id
        $book = (new BookService())->updateBook($request->validated(), $id);
        return response()->json([
            'status_code' => 200,
            'status' => 'success',
            'message' => "The book $book->name was updated successfully",
            'data' => new BookResource($book)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // delete book with id
        $book = Book::find($id);
        if (! $book) {
            return response()->json([
                'status_code' => 404,
                'status' => 'not found',
                'data' => []
            ])->setStatusCode(404);
        }

        $book->delete();

        return response()->json([
            'status_code' => 204,
            'message' => "The book $book->name was deleted successfully",
            'status' => 'success',
            'data' => []
        ])->setStatusCode(200);
    }
}