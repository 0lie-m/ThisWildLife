<?php

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add the Book status column to the Books list.
 */
function twl_add_book_status_column($columns)
{
    $updated_columns = [];

    foreach ($columns as $key => $label) {
        if ($key === 'date') {
            $updated_columns['twl_book_status'] =
                'Book status';
        }

        $updated_columns[$key] = $label;
    }

    return $updated_columns;
}

add_filter(
    'manage_twl_book_posts_columns',
    'twl_add_book_status_column'
);

/**
 * Display Active or Inactive for each Book.
 */
function twl_render_book_status_column($column, $post_id)
{
    if ($column !== 'twl_book_status') {
        return;
    }

    $is_active = get_post_meta(
        $post_id,
        '_twl_is_active',
        true
    );

    echo $is_active === '0'
        ? esc_html('Inactive')
        : esc_html('Active');
}

add_action(
    'manage_twl_book_posts_custom_column',
    'twl_render_book_status_column',
    10,
    2
);

/**
 * Add an Active/Inactive filter above the Books list.
 */
function twl_add_book_status_filter()
{
    global $typenow;

    if ($typenow !== 'twl_book') {
        return;
    }

    $selected = isset($_GET['twl_book_status'])
        ? sanitize_key(
            wp_unslash($_GET['twl_book_status'])
        )
        : '';

    ?>
    <select name="twl_book_status">
        <option value="">All book statuses</option>
        <option
            value="active"
            <?php selected($selected, 'active'); ?>
        >
            Active
        </option>
        <option
            value="inactive"
            <?php selected($selected, 'inactive'); ?>
        >
            Inactive
        </option>
    </select>
    <?php
}

add_action(
    'restrict_manage_posts',
    'twl_add_book_status_filter'
);

/**
 * Apply the selected Book status filter.
 */
function twl_filter_books_by_status($query)
{
    if (!is_admin() || !$query->is_main_query()) {
        return;
    }

    if ($query->get('post_type') !== 'twl_book') {
        return;
    }

    $status = isset($_GET['twl_book_status'])
        ? sanitize_key(
            wp_unslash($_GET['twl_book_status'])
        )
        : '';

    if ($status === 'active') {
        $query->set('meta_query', [
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
        ]);
    }

    if ($status === 'inactive') {
        $query->set('meta_query', [
            [
                'key'     => '_twl_is_active',
                'value'   => '0',
                'compare' => '=',
            ],
        ]);
    }
}

add_action(
    'pre_get_posts',
    'twl_filter_books_by_status'
);