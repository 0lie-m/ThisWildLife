<?php

function thiswildlife_scripts() {

    wp_enqueue_style(
        'shared-style',
        get_template_directory_uri() . '/assets/css/shared.css',
        array(),
        null
    );

    wp_enqueue_script(
        'shared-js',
        get_template_directory_uri() . '/assets/js/shared.js',
        array(),
        null,
        true
    );

    if (is_front_page()) {
        wp_enqueue_style(
            'home-style',
            get_template_directory_uri() . '/assets/css/home.css',
            array('shared-style'),
            null
        );

        wp_enqueue_script(
            'home-js',
            get_template_directory_uri() . '/assets/js/home.js',
            array('shared-js'),
            null,
            true
        );
    }

    if (is_page('books')) {
        wp_enqueue_style(
            'books-style',
            get_template_directory_uri() . '/assets/css/books.css',
            array('shared-style'),
            null
        );

        wp_enqueue_script(
            'books-js',
            get_template_directory_uri() . '/assets/js/books.js',
            array('shared-js'),
            null,
            true
        );

        wp_localize_script(
            'books-js',
            'thisWildLifeTheme',
            array(
                'themePath' => get_template_directory_uri()
            )
        );
    }

    if (is_page('discover')) {
        wp_enqueue_style(
            'discover-style',
            get_template_directory_uri() . '/assets/css/discover.css',
            array('shared-style'),
            null
        );

        wp_enqueue_script(
            'discover-js',
            get_template_directory_uri() . '/assets/js/discover.js',
            array('shared-js'),
            null,
            true
        );
    }

    if (is_page('about')) {
    wp_enqueue_style('about-css', get_template_directory_uri() . '/assets/css/about.css');
    wp_enqueue_script('about-js', get_template_directory_uri() . '/assets/js/about.js', array(), null, true);
    }
}

add_action('wp_enqueue_scripts', 'thiswildlife_scripts');