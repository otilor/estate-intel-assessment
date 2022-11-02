<?php

namespace Tests\Feature\Controllers\Api;

use Tests\TestCase;
use App\Services\BookService;
use Illuminate\Support\Facades\Http;
use Illuminate\Testing\Fluent\AssertableJson;

class BooksControllerTest extends TestCase
{
    protected function getBookJsonStructure():array{
        return [
            'loft' => [
                'name',
                'isbn',
                'authors',
                'number_of_pages',
                'publisher',
                'country',
                'release_date'
            ]
        ];
    }

    /**
     * @group books
     */
    public function testGetBooksByName()
    {
        Http::fake([
            'anapioficeandfire.com/api/*' => Http::response([
                [
                    'url' => 'https=>//www.anapioficeandfire.com/api/books/1',
                        'name' => 'A Game of Thrones',
                        "isbn" => "978-0553103540",
                        "authors" => [
                            "George R. R. Martin"
                        ],
                        "numberOfPages"=> 694,
                        "publisher" => "Bantam Books",
                        "country" => "United States",
                        "mediaType" => "Hardcover",
                        "released" => "1996-08-01T00:00:00",
                        "characters" => [
                            "https://www.anapioficeandfire.com/api/characters/2",
                            "https://www.anapioficeandfire.com/api/characters/12",
                            "https://www.anapioficeandfire.com/api/characters/13",
                            "https://www.anapioficeandfire.com/api/characters/16",
                        ],
                        "povCharacters" => [
                            "https://www.anapioficeandfire.com/api/characters/148",
                            "https://www.anapioficeandfire.com/api/characters/208",
                            "https://www.anapioficeandfire.com/api/characters/232",
                            "https://www.anapioficeandfire.com/api/characters/339",
                        ]
                ]
            ])
        ]);

        $response = $this->get(route(
            'api.books.external', ['name' => 'A Game of Thrones']
        ));

        $response->assertOk();
        $this->assertSame('successful', $response->json()['status']);
        $this->assertSame(200, $response->json()['status_code']);

        $data = $response->json('data');
        
        $this->assertArrayHasKey(
            'name',
            $data[0]
        );
        
        $this->assertArrayHasKey(
            'isbn',
            $data[0]
        );
        
        $this->assertArrayHasKey(
            'authors',
            $data[0]
        );
        
        $this->assertArrayHasKey(
            'number_of_pages',
            $data[0]
        );
        
        $this->assertArrayHasKey(
            'publisher',
            $data[0]
        );
        
        $this->assertArrayHasKey(
            'country',
            $data[0]
        );
        
        $this->assertArrayHasKey(
            'release_date',
            $data[0]
        );   
        
        $this->assertSame(
            'A Game of Thrones',
            $data[0]['name']
        );
        
        $this->assertSame(
            '978-0553103540',
            $data[0]['isbn']
        );

        $this->assertSame(
            [
                "George R. R. Martin"
            ],
            $data[0]['authors']
        );

        $this->assertSame(
            694,
            $data[0]['number_of_pages']
        );

        $this->assertSame(
            'Bantam Books',
            $data[0]['publisher']
        );

        $this->assertSame(
            'United States',
            $data[0]['country']
        );

        $this->assertSame(
            '1996-08-01',
            $data[0]['release_date']
        );
    }

    public function testGetBooksByNameReturnsEmptyResult()
    {
        Http::preventStrayRequests();
        Http::fake([
            'anapioficeandfire.com/api/*' => Http::response([
                
            ])
        ]);

        
        $response = $this->get(route(
            'api.books.external', ['name' => 'A Game of Thrones']
        ));
        $response->assertNotFound();
        $this->assertSame('not found', $response->json()['status']);
        $this->assertSame(404, $response->json()['status_code']);

        $data = $response->json('data');
        $this->assertCount(0, $data);
    }
}
