<?php

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register the main Website Content dashboard.
 */
function twl_register_website_content_menu()
{
    add_menu_page(
        'Website Content',
        'Website Content',
        'edit_twl_books',
        'twl-website-content',
        'twl_render_website_content_dashboard',
        'dashicons-edit-page',
        21
    );
}

add_action(
    'admin_menu',
    'twl_register_website_content_menu',
    5
);

/**
 * Display shortcuts to each editable content area.
 */
function twl_render_website_content_dashboard()
{
    if (!current_user_can('edit_twl_books')) {
        wp_die('You do not have permission to access this page.');
    }

    ?>
    <div class="wrap">
        <h1>Website Content</h1>

        <p>
            Choose the part of the website you want to update.
        </p>

        <p>
            <a
                class="button button-primary"
                href="<?php
                    echo esc_url(
                        admin_url(
                            'edit.php?post_type=twl_book'
                        )
                    );
                ?>"
            >
                Manage Books
            </a>

            <a
                class="button"
                href="<?php
                    echo esc_url(
                        admin_url(
                            'admin.php?page=twl-about-content'
                        )
                    );
                ?>"
            >
                Edit About Page
            </a>
        </p>
    </div>
    <?php
}