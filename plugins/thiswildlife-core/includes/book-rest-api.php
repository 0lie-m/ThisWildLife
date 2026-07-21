<?php

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Convert a Book post into the public API format.
 */
function twl_prepare_book_api_data($book)
{
    $book_id = $book->ID;
    $fields = twl_get_book_fields();

    $availability = get_post_meta(
        $book_id,
        '_twl_availability',
        true
    );

    if (
        !isset(
            $fields['availability']['options'][$availability]
        )
    ) {
        $availability =
            $fields['availability']['default'];
    }

    $cover = null;
    $cover_id = get_post_thumbnail_id($book_id);

    if ($cover_id) {
        $cover_image = wp_get_attachment_image_src(
            $cover_id,
            'full'
        );

        if ($cover_image) {
            $cover = [
                'id'     => $cover_id,
                'url'    => esc_url_raw($cover_image[0]),
                'alt'    => get_post_meta(
                    $cover_id,
                    '_wp_attachment_image_alt',
                    true
                ),
                'width'  => (int) $cover_image[1],
                'height' => (int) $cover_image[2],
            ];
        }
    }

    return [
        'id'            => $book_id,
        'slug'          => $book->post_name,
        'title'         => get_the_title($book_id),
        'excerpt'       => get_the_excerpt($book_id),
        'description'   => apply_filters(
            'the_content',
            $book->post_content
        ),
        'author'        => get_post_meta(
            $book_id,
            '_twl_author',
            true
        ),
        'format'        => get_post_meta(
            $book_id,
            '_twl_format',
            true
        ),
        'minimum_age'   => (int) get_post_meta(
            $book_id,
            '_twl_minimum_age',
            true
        ),
        'maximum_age'   => (int) get_post_meta(
            $book_id,
            '_twl_maximum_age',
            true
        ),
        'price'         => get_post_meta(
            $book_id,
            '_twl_price',
            true
        ),
        'currency'      => 'EUR',
        'amazon_url'    => get_post_meta(
            $book_id,
            '_twl_amazon_url',
            true
        ),
        'availability'  => [
            'value' => $availability,
            'label' =>
                $fields['availability']['options'][$availability],
        ],
        'display_order' => (int) get_post_meta(
            $book_id,
            '_twl_display_order',
            true
        ),
        'cover'         => $cover,
    ];
}

/**
 * Return all published Books.
 */
function twl_rest_get_books()
{
    $query = new WP_Query([
        'post_type'      => 'twl_book',
        'post_status'    => 'publish',
        'posts_per_page' => 100,
        'meta_key'       => '_twl_display_order',
        'orderby'        => [
            'meta_value_num' => 'ASC',
            'title'          => 'ASC',
        ],
        'order'          => 'ASC',
        'no_found_rows'  => true,
    ]);

    $books = array_map(
        'twl_prepare_book_api_data',
        $query->posts
    );

    return rest_ensure_response($books);
}

/**
 * Return one published Book.
 */
function twl_rest_get_book($request)
{
    $book_id = absint($request['id']);
    $book = get_post($book_id);

    if (
        !$book ||
        $book->post_type !== 'twl_book' ||
        $book->post_status !== 'publish'
    ) {
        return new WP_Error(
            'twl_book_not_found',
            'Book not found.',
            [
                'status' => 404,
            ]
        );
    }

    return rest_ensure_response(
        twl_prepare_book_api_data($book)
    );
}

/**
 * Register the public, read-only Book endpoints.
 */
function twl_register_book_rest_routes()
{
    register_rest_route(
        'thiswildlife/v1',
        '/books',
        [
            'methods'             => WP_REST_Server::READABLE,
            'callback'            => 'twl_rest_get_books',
            'permission_callback' => '__return_true',
        ]
    );

    register_rest_route(
        'thiswildlife/v1',
        '/books/(?P<id>\d+)',
        [
            'methods'             => WP_REST_Server::READABLE,
            'callback'            => 'twl_rest_get_book',
            'permission_callback' => '__return_true',
            'args'                => [
                'id' => [
                    'required'          => true,
                    'sanitize_callback' => 'absint',
                    'validate_callback' => static function ($value) {
                        return absint($value) > 0;
                    },
                ],
            ],
        ]
    );
}

add_action(
    'rest_api_init',
    'twl_register_book_rest_routes'
);