<?php

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Return the database query for Active Books.
 *
 * Books without a saved status are treated as Active so that
 * existing Books remain visible.
 */
function twl_get_active_book_meta_query()
{
    return [
        'relation' => 'OR',
        [
            'key'     => '_twl_is_active',
            'compare' => 'NOT EXISTS',
        ],
        [
            'key'     => '_twl_is_active',
            'value'   => '1',
            'compare' => '=',
        ],
    ];
}

/**
 * Hide inactive individual Book pages from customers.
 */
function twl_hide_inactive_book_pages($query)
{
    if (is_admin() || !$query->is_main_query()) {
        return;
    }

    if (!$query->is_singular('twl_book')) {
        return;
    }

    if (current_user_can('edit_twl_books')) {
        return;
    }

    $query->set(
        'meta_query',
        [
            twl_get_active_book_meta_query(),
        ]
    );
}

add_action(
    'pre_get_posts',
    'twl_hide_inactive_book_pages'
);

/**
 * Hide inactive Books from WordPress's standard REST list.
 */
function twl_hide_inactive_books_from_core_rest(
    $args,
    $request
) {
    if (current_user_can('edit_twl_books')) {
        return $args;
    }

    $meta_query = isset($args['meta_query'])
        ? $args['meta_query']
        : [];

    $meta_query[] = twl_get_active_book_meta_query();
    $args['meta_query'] = $meta_query;

    return $args;
}

add_filter(
    'rest_twl_book_query',
    'twl_hide_inactive_books_from_core_rest',
    10,
    2
);

/**
 * Return a 404 for a direct REST request for an inactive Book.
 */
function twl_hide_inactive_book_core_rest_response(
    $response,
    $book
) {
    if (current_user_can('edit_twl_books')) {
        return $response;
    }

    $is_active = get_post_meta(
        $book->ID,
        '_twl_is_active',
        true
    );

    if ($is_active === '' || $is_active === '1') {
        return $response;
    }

    return new WP_Error(
        'twl_book_not_found',
        'Book not found.',
        [
            'status' => 404,
        ]
    );
}

add_filter(
    'rest_prepare_twl_book',
    'twl_hide_inactive_book_core_rest_response',
    10,
    2
);