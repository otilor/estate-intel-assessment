<?php

namespace Tests\Feature\Controllers\Api;

use Tests\TestCase;

class BooksControllerTest extends TestCase
{
    /**
     * @group books
     */
    public function testGetBooksByName()
    {
        $this->partialMock(BookService::class, function ($mock) {
            $mock->shouldReceive('retrieve')->andReturn(
                [
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
                        "released" => "1996-08-01T00=>00=>00",
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
                ]
            );
        });

        $response = $this->get(route(
            'api.books.external', ['name' => 'A Game of Thrones']
        ));
        $data = $response->json('data');
        
        $this->assertArrayHasKey(
            'name',
            $data
        );
        
        $this->assertArrayHasKey(
            'isbn',
            $data
        );
        
        $this->assertArrayHasKey(
            'authors',
            $data
        );
        
        $this->assertArrayHasKey(
            'number_of_pages',
            $data
        );
        
        $this->assertArrayHasKey(
            'publisher',
            $data
        );
        
        $this->assertArrayHasKey(
            'country',
            $data
        );
        
        $this->assertArrayHasKey(
            'release_date',
            $data
        );   
    }
}
