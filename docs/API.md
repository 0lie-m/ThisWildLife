# Books REST API

## Overview

This Wild Life provides a custom, read-only REST API for retrieving published Book records from WordPress.

The API is implemented in the `thiswildlife-core` plugin. Book information is stored in the WordPress MySQL database and converted into JSON when a request is made.

The API does not use stored JSON files.

## Base URL

Production:

`https://thiswildlife.org/wp-json/thiswildlife/v1`

Staging:

`https://thiswildlife.org/staging/9632/wp-json/thiswildlife/v1`

The API uses the versioned namespace `thiswildlife/v1`. This allows a future version to be introduced without unexpectedly breaking applications that use version 1.

## Get all Books

`GET /books`

Production example:

`https://thiswildlife.org/wp-json/thiswildlife/v1/books`

This endpoint returns all published Books, ordered by their configured display order and then by title.

### Successful response

`200 OK`

The response is a JSON array containing Book objects. A shortened example is:

```json
[
  {
    "id": 28,
    "slug": "fionn-the-fox",
    "title": "Fionn the Fox",
    "excerpt": "Short public description.",
    "description": "<p>Full public description.</p>",
    "author": "C. Burke",
    "format": "Illustrated children's book",
    "minimum_age": 4,
    "maximum_age": 8,
    "price": "12.99",
    "currency": "EUR",
    "amazon_url": "",
    "availability": {
      "value": "coming_soon",
      "label": "Coming soon"
    },
    "display_order": 1,
    "cover": {
      "id": 36,
      "url": "https://example.com/cover.png",
      "alt": "Fionn the Fox book cover",
      "width": 1543,
      "height": 2000
    }
  }
]
```

The numeric IDs in this example are illustrative. Staging and production use separate databases, so the same Book can have a different ID in each environment.

## Get one Book

`GET /books/{id}`

Example:

`https://thiswildlife.org/wp-json/thiswildlife/v1/books/28`

If the requested ID belongs to a published Book, the endpoint returns one JSON Book object with an HTTP `200 OK` status.

## Book not found

If the ID does not exist, belongs to another content type or identifies an unpublished Book, the API returns an HTTP `404 Not Found` response:

```json
{
  "code": "twl_book_not_found",
  "message": "Book not found.",
  "data": {
    "status": 404
  }
}
```

This behaviour was tested using an ID that does not exist.

## Response fields

| Field | Type | Description |
| --- | --- | --- |
| `id` | Integer | WordPress database ID for the Book |
| `slug` | String | URL-friendly Book identifier |
| `title` | String | Public Book title |
| `excerpt` | String | Short description |
| `description` | String | Full rendered description, which may contain HTML |
| `author` | String | Book author |
| `format` | String | Book format |
| `minimum_age` | Integer | Minimum recommended reader age |
| `maximum_age` | Integer | Maximum recommended reader age |
| `price` | String | Price stored to two decimal places |
| `currency` | String | ISO currency code, currently `EUR` |
| `amazon_url` | String | Optional public Amazon URL |
| `availability` | Object | Stored availability value and readable label |
| `display_order` | Integer | Order used when returning the collection |
| `cover` | Object or null | Public cover-image information |

## Security

The Books API is intentionally public because it supplies information intended for visitors to the public website.

The API is read-only. It registers only HTTP `GET` routes and does not provide public routes for creating, updating or deleting Books.

Only Books with the WordPress status `publish` are returned. Draft, private and deleted Books are excluded.

The response does not contain:

- WordPress passwords
- User email addresses
- Database credentials
- Hosting details
- Admin settings
- Draft Book content
- WordPress permission data

Book creation and editing remain protected by WordPress authentication and the custom Book capabilities in the `thiswildlife-core` plugin.

## Application flow

```text
Client
→ HTTP GET request
→ WordPress REST route
→ PHP callback
→ WP_Query
→ WordPress MySQL database
→ Structured JSON response
```

## Relationship to the college project

The college full-stack project used Express routes, controller functions, Mongoose models and MongoDB to return JSON data.

The WordPress implementation follows the same separation using tools appropriate to WordPress:

```text
College project:
Express route
→ Controller
→ Mongoose
→ MongoDB
→ JSON

This Wild Life:
WordPress REST route
→ PHP callback
→ WP_Query
→ MySQL
→ JSON
```

In both projects, the client requests a resource through an HTTP endpoint, the backend retrieves stored data and the result is returned as JSON.

## Testing completed

The following behaviour was tested on staging and production:

- The collection endpoint returns the five published Books.
- Books are returned in the configured display order.
- Each response contains the required Book fields.
- Cover-image information is returned.
- Empty Amazon URLs are handled correctly.
- An individual published Book can be retrieved by ID.
- A nonexistent Book ID returns an HTTP `404` JSON response.
- The existing public Books page continues to work after deployment.