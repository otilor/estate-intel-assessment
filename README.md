
Books API v1
=========

The Books API facilitates the management of books in the books data center. This document describes the resources and syntax used in the Books API and is intended for developers who want to integrate our wonderful API.

- [Installation](#installation)
- [Release Version](#release-version)
- [Authentication](#authentication)
- [Management](#management)


Installation
----
- git clone
    - `git clone git@github.com:humaneguy/estate-intel-assessment.git`
- Copy `.env-example` to `.env`
- Run database migration and seeders
    - `php artisan migrate`
- Start server
    - `php artisan serve`
- Run tests
    - `php artisan test`
    
Release Version
----
_Last Updated Fri 4, 2022;  Note that this is the official release of Books V1 API. No breaking changes will be introduced to this version of the API._
 

Authentication
----

The operations you perform against the Books API do not require authentication.



Management
----
The Books API provides for the management of books.  This includes the creation, deletion and updating of resources.

### GET external book

Returns a book from the [Ice And Fire](https://anapioficeandfire.com/Documentation#books) API

    GET /api/external-books?name=:nameOfABook

**Response**

```json
{
    "status_code":200, "status":"success", "data":[
        {
            "name":"A Game of Thrones",
            "isbn":"978-0553103540",
            "authors":[
                "George R. R. Martin"
            ],
            "number_of_pages":694,
            "publisher":"Bantam Books",
            "country":"United States",
            "release_date":"1996-08-01"
        },
        {
            "name":"A Clash of Kings",
            "isbn":"978-0553108033",
            "authors":[
                "George R. R. Martin"
            ],
            "number_of_pages":768,
            "publisher":"Bantam Books",
            "country":"United States",
            "release_date":"1999-02-02"
        } 
    ]
}
```
### GET /book/{id}

Returns a book resource.

**Response**
```json
{
   "status_code":200,
   "status":"success",
   "data":{
      "id":1,
      "name":"My First Book",
      "isbn":"123-3213243567",
      "authors":[
        "John Doe"
    ],
    "number_of_pages":350,
    "publisher":"Acme Books Publishing",
    "country":"United States",
    "release_date":"2019-01-01"
    }
}

```
### GET /books
The GET method retrieves a paginated response of all records found for the book resource.  The response is returned in JSON format.

**Example 1: Get all books**

Get books.

    GET /api/v1/books

**Response**

    200 Ok
```json
    {
        "status_code": 200,
        "status": "success",
        "data": [
            {
                "id": 1,
                "title": "The Great Gatsby",
                "author": "F. Scott Fitzgerald",
                "isbn": "978-1-56619-909-4",
                "created_at": "2021-04-04T15:00:00.000000Z",
                "updated_at": "2021-04-04T15:00:00.000000Z"
            },
            {
                "id": 2,
                "title": "The Catcher in the Rye",
                "author": "J. D. Salinger",
                "isbn": "978-1-56619-909-4",
                "created_at": "2021-04-04T15:00:00.000000Z",
                "updated_at": "2021-04-04T15:00:00.000000Z"
            }
        ]
    }

```

**Example 2: Get books by country**

Get books.

    GET /api/v1/books?country=Romania

**Response**

    200 Ok
```json
    {
        "status_code":200,
        "status":"success",
        "data":[
            {
                "id":1,
                "name":"A Game of Thrones",
                "isbn":"978-0553103540",
                "authors":[
                    "George R. R. Martin"
                ],
                "number_of_pages":694,
                "publisher":"Bantam Books",
                "country":"Romania",
                "release_date":"1996-08-01"
            }, 
            {
                "id":2,
                "name":"A Clash of Kings",
                "authors":
                [
                    "George R. R. Martin"
                ],
                "number_of_pages":768,
                "publisher":"Bantam Books",
                "country":"Romania",
                "release_date":"1999-02-02"
            }
        ]
    }
```


**Example 3: Get books by name**

Get books.

    GET /api/v1/books?name=A Game of Thrones

**Response**

    200 Ok
```json
    {
        "status_code":200,
        "status":"success",
        "data":[
            {
                "id":1,
                "name":"A Game of Thrones",
                "isbn":"978-0553103540",
                "authors":[
                    "George R. R. Martin"
                ],
                "number_of_pages":694,
                "publisher":"Bantam Books",
                "country":"Romania",
                "release_date":"1996-08-01"
            },
        ]
    }
```


**Example 4: Get books by Publisher**

Get books.

    GET /api/v1/books?publisher=Bantam Books

**Response**

    200 Ok
```json
    {
        "status_code":200,
        "status":"success",
        "data":[
            {
                "id":1,
                "name":"A Clash of Kings",
                "isbn":"978-0553103540",
                "authors":[
                    "George R. R. Martin"
                ],
                "number_of_pages":694,
                "publisher":"Bantam Books",
                "country":"Romania",
                "release_date":"1996-08-01"
            },
            {
                "id":2,
                "name":"A Game of Thrones",
                "isbn":"978-0553103540",
                "authors":[
                    "George R. R. Martin"
                ],
                "number_of_pages":694,
                "publisher":"Bantam Books",
                "country":"Romania",
                "release_date":"1996-08-01"
            },
        ]
    }
```


**Example 4: Get books by release year**

Get books.

    GET /api/v1/books?release_date=1996

**Response**

    200 Ok
```json
{
    "status_code":200,
    "status":"success",
    "data":[
        {
            "id":1,
            "name":"A Clash of Kings",
            "isbn":"978-0553103540",
            "authors":[
                "George R. R. Martin"
            ],
            "number_of_pages":694,
            "publisher":"Bantam Books",
            "country":"Romania",
            "release_date":"1996-08-01"
        },
        {
            "id":2,
            "name":"A Game of Thrones",
            "isbn":"978-0553103540",
            "authors":[
                "George R. R. Martin"
            ],
            "number_of_pages":694,
            "publisher":"Bantam Books",
            "country":"Romania",
            "release_date":"1996-08-01"
        },
    ]
}
```


### POST
The POST method creates a new resource. If a new resource is created then a 201 response code is returned alongside the response data.

**Example**

Create a book.

    POST /api/v1/books

**Body**
```json
{
    "data":{
        "book":{
            "name":"My First Book",
            "isbn":"123-3213243567",
            "authors":[
                "John Doe"
            ],
            "number_of_pages":350,
            "publisher":"Acme Books",
            "country":"United States",
            "release_date":"2019-08-01"
        }
    }
}
```
**Response**

    201 Created

```json
{
    "status_code":201,
    "status":"success",
    "data":{
        "book":{
            "name":"My First Book",
            "isbn":"123-3213243567",
            "authors":[
                "John Doe"
            ],
            "number_of_pages":350,
            "publisher":"Acme Books",
            "country":"United States",
            "release_date":"2019-08-01"
        }
    }
}
```

### PATCH
Use the PATCH method to update resources.

**Example**

Update a book.


    PATCH /api/v1/books/:id

**Body**

```json
{
    "data":{
        "book":{
            "name":"My First Book",
            "isbn":"123-3213243567",
            "authors":[
                "John Doe"
            ],
            "number_of_pages":350,
            "publisher":"Acme Books",
            "country":"United States",
            "release_date":"2019-08-01"
        }
    }
}
```


**Response**



    200 Ok
```json
{
   "status_code":200,
   "status":"success",
   "message":"The book My First Book was updated successfully",
   "data":{
      "id":1,
      "name":"My First Updated Book",
      "isbn":"123-3213243567",
      "authors":[
        "John Doe"
      ],
      "number_of_pages":350,
      "publisher":"Acme Books Publishing",
      "country":"United States",
      "release_date":"2019-01-01"
    }
}

```


### DELETE
Use the DELETE method to delete a resource. If an existing resource is deleted then a 200 response code is retrurned to indicate successful completion of the request.

**Example**

Delete the book with id 1.

    DELETE /api/v1/books/1

**Response**

    200 OK
```json
{
   "status_code":204,
   "status":"success",
   "message":"The book ‘My first book’ was deleted successfully",
   "data":[]
}
```
 
HTTP Return Codes
----

The following HTTP codes may be returned by the API.
<table>
  <tr>
    <th>HTTP CODE</th>
    <th>Description</th>
  </tr>
  <tr>
    <td>200</td>
    <td>OK</td>  
  </tr>
  <tr>
    <td>400</td>
    <td>Bad Request</td>  
  </tr>
  <tr>
    <td>401</td>
    <td>Unauthorized</td>  
  </tr>
  <tr>
    <td>403</td>
    <td>Forbidden</td>  
  </tr> 
  <tr>
    <td>404</td>
    <td>Not Found</td>  
  </tr>
  <tr>
    <td>500</td>
    <td>Internal Server Error</td>  
  </tr>
</table>