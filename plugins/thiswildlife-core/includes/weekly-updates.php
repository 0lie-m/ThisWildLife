<?php

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register the Weekly Update custom post type.
 */
function twl_register_weekly_update_post_type()
{
    $labels = [
        'name'               => 'Weekly Updates',
        'singular_name'      => 'Weekly Update',
        'menu_name'          => 'Weekly Updates',
        'add_new'            => 'Add New Update',
        'add_new_item'       => 'Add New Weekly Update',
        'edit_item'          => 'Edit Weekly Update',
        'new_item'           => 'New Weekly Update',
        'view_item'          => 'View Weekly Update',
        'search_items'       => 'Search Weekly Updates',
        'not_found'          => 'No weekly updates found',
        'not_found_in_trash' => 'No weekly updates found in Trash',
        'all_items'          => 'All Weekly Updates',
    ];

    register_post_type('twl_update', [
        'labels'          => $labels,
        'public'          => true,
        'show_in_rest'    => true,
        'show_in_menu'    => 'twl-website-content',
        'has_archive'     => true,
        'rewrite'         => [
            'slug' => 'updates',
        ],
        'capability_type' => [
            'twl_update',
            'twl_updates',
        ],
        'map_meta_cap'    => true,
        'supports'        => [
            'title',
            'editor',
            'excerpt',
            'thumbnail',
            'revisions',
        ],
    ]);
}

add_action(
    'init',
    'twl_register_weekly_update_post_type'
);