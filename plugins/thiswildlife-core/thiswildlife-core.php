<?php
/**
 * Plugin Name: This Wild Life Core
 * Description: Provides Book management and core functionality for This Wild Life.

 */

if (!defined('ABSPATH')) {
    exit;
}

require_once plugin_dir_path(__FILE__) . 'includes/book-fields.php';

/**
 * Register the Book custom post type.
 */
function twl_register_book_post_type()
{
    $labels = [
        'name'          => 'Books',
        'singular_name' => 'Book',
        'menu_name'     => 'Books',
        'add_new'       => 'Add New Book',
        'add_new_item'  => 'Add New Book',
        'edit_item'     => 'Edit Book',
        'new_item'      => 'New Book',
        'view_item'     => 'View Book',
        'search_items'  => 'Search Books',
        'not_found'     => 'No books found',
        'all_items'     => 'All Books',
    ];

    $capabilities = [
        'edit_post'              => 'edit_twl_book',
        'read_post'              => 'read_twl_book',
        'delete_post'            => 'delete_twl_book',
        'edit_posts'             => 'edit_twl_books',
        'edit_others_posts'      => 'edit_others_twl_books',
        'publish_posts'          => 'publish_twl_books',
        'read_private_posts'     => 'read_private_twl_books',
        'delete_posts'           => 'delete_twl_books',
        'delete_private_posts'   => 'delete_private_twl_books',
        'delete_published_posts' => 'delete_published_twl_books',
        'delete_others_posts'    => 'delete_others_twl_books',
        'edit_private_posts'     => 'edit_private_twl_books',
        'edit_published_posts'   => 'edit_published_twl_books',
        'create_posts'           => 'edit_twl_books',
    ];

    register_post_type('twl_book', [
        'labels'          => $labels,
        'public'          => true,
        'show_in_rest'    => true,
        'menu_icon'       => 'dashicons-book-alt',
        'has_archive'     => false,
        'rewrite'         => ['slug' => 'book'],
        'capabilities'    => $capabilities,
        'map_meta_cap'    => true,
        'supports'        => [
            'title',
            'editor',
            'excerpt',
            'thumbnail',
            'page-attributes',
        ],
    ]);
}

add_action('init', 'twl_register_book_post_type');

/**
 * Primitive capabilities granted to Book Managers.
 */
function twl_get_book_manager_capabilities()
{
    return [
        'read',
        'upload_files',
        'edit_twl_books',
        'edit_others_twl_books',
        'edit_private_twl_books',
        'edit_published_twl_books',
        'publish_twl_books',
        'read_private_twl_books',
        'delete_twl_books',
        'delete_private_twl_books',
        'delete_published_twl_books',
        'delete_others_twl_books',
    ];
}

/**
 * Create the Book Manager role and grant Book access to administrators.
 */
function twl_activate_plugin()
{
    $book_manager = get_role('twl_book_manager');

    if (!$book_manager) {
        $book_manager = add_role(
            'twl_book_manager',
            'Book Manager',
            ['read' => true]
        );
    }

    $book_capabilities = twl_get_book_manager_capabilities();

    if ($book_manager) {
        foreach ($book_capabilities as $capability) {
            $book_manager->add_cap($capability);
        }
    }

    $administrator = get_role('administrator');

    if ($administrator) {
        foreach ($book_capabilities as $capability) {
            $administrator->add_cap($capability);
        }
    }

    twl_register_book_post_type();
    flush_rewrite_rules();
}

/**
 * Enable featured images for Book covers.
 */
function twl_enable_book_cover_support()
{
    add_theme_support('post-thumbnails');
}

add_action('after_setup_theme', 'twl_enable_book_cover_support', 20);

register_activation_hook(__FILE__, 'twl_activate_plugin');