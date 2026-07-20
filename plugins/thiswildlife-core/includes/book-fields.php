<?php

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Define the additional fields stored for each Book.
 */
function twl_get_book_fields()
{
    return [
        'author' => [
            'label'   => 'Author',
            'type'    => 'text',
            'default' => 'C. Burke',
        ],
        'format' => [
            'label'   => 'Format',
            'type'    => 'text',
            'default' => "Illustrated children's book",
        ],
        'minimum_age' => [
            'label'   => 'Minimum age',
            'type'    => 'number',
            'default' => 4,
        ],
        'maximum_age' => [
            'label'   => 'Maximum age',
            'type'    => 'number',
            'default' => 8,
        ],
        'price' => [
            'label'   => 'Price (€)',
            'type'    => 'number',
            'default' => '12.99',
            'step'    => '0.01',
        ],
        'amazon_url' => [
            'label'   => 'Amazon URL',
            'type'    => 'url',
            'default' => '',
        ],
        'availability' => [
            'label'   => 'Availability',
            'type'    => 'select',
            'default' => 'coming_soon',
            'options' => [
                'coming_soon' => 'Coming soon',
                'available'   => 'Available',
                'out_of_stock'=> 'Out of stock',
                'unavailable' => 'Unavailable',
            ],
        ],
        'display_order' => [
            'label'   => 'Display order',
            'type'    => 'number',
            'default' => 0,
        ],
    ];
}

/**
 * Add the Book Details panel to the editor.
 */
function twl_add_book_details_meta_box()
{
    add_meta_box(
        'twl_book_details',
        'Book Details',
        'twl_render_book_details_meta_box',
        'twl_book',
        'normal',
        'high'
    );
}

add_action('add_meta_boxes', 'twl_add_book_details_meta_box');

/**
 * Display the Book Details fields.
 */
function twl_render_book_details_meta_box($post)
{
    wp_nonce_field('twl_save_book_details', 'twl_book_details_nonce');

    foreach (twl_get_book_fields() as $name => $field) {
        $meta_key = '_twl_' . $name;
        $value = get_post_meta($post->ID, $meta_key, true);

        if ($value === '') {
            $value = $field['default'];
        }

        echo '<p>';
        echo '<label for="' . esc_attr($name) . '">';
        echo '<strong>' . esc_html($field['label']) . '</strong>';
        echo '</label><br>';

        if ($field['type'] === 'select') {
            echo '<select id="' . esc_attr($name) . '" name="' . esc_attr($name) . '">';

            foreach ($field['options'] as $option_value => $option_label) {
                echo '<option value="' . esc_attr($option_value) . '" ' .
                    selected($value, $option_value, false) . '>';
                echo esc_html($option_label);
                echo '</option>';
            }

            echo '</select>';
        } else {
            $step = isset($field['step'])
                ? ' step="' . esc_attr($field['step']) . '"'
                : '';

            echo '<input class="widefat" id="' . esc_attr($name) . '"';
            echo ' name="' . esc_attr($name) . '"';
            echo ' type="' . esc_attr($field['type']) . '"';
            echo ' value="' . esc_attr($value) . '"';
            echo $step;
            echo '>';
        }

        echo '</p>';
    }
}

/**
 * Validate and save the Book Details fields.
 */
function twl_save_book_details($post_id)
{
    if (
        !isset($_POST['twl_book_details_nonce']) ||
        !wp_verify_nonce(
            sanitize_text_field(
                wp_unslash($_POST['twl_book_details_nonce'])
            ),
            'twl_save_book_details'
        )
    ) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (get_post_type($post_id) !== 'twl_book') {
        return;
    }

    if (!current_user_can('edit_twl_book', $post_id)) {
        return;
    }

    foreach (twl_get_book_fields() as $name => $field) {
        if (!isset($_POST[$name])) {
            continue;
        }

        $raw_value = wp_unslash($_POST[$name]);

        switch ($field['type']) {
            case 'url':
                $value = esc_url_raw($raw_value);
                break;

            case 'number':
                if ($name === 'price') {
                    $value = number_format(
                        max(0, (float) $raw_value),
                        2,
                        '.',
                        ''
                    );
                } else {
                    $value = absint($raw_value);
                }
                break;

            case 'select':
                $value = sanitize_key($raw_value);

                if (!array_key_exists($value, $field['options'])) {
                    $value = $field['default'];
                }
                break;

            default:
                $value = sanitize_text_field($raw_value);
                break;
        }

        update_post_meta($post_id, '_twl_' . $name, $value);
    }

    $minimum_age = absint(
        get_post_meta($post_id, '_twl_minimum_age', true)
    );

    $maximum_age = absint(
        get_post_meta($post_id, '_twl_maximum_age', true)
    );

    if ($maximum_age < $minimum_age) {
        update_post_meta(
            $post_id,
            '_twl_maximum_age',
            $minimum_age
        );
    }
}

add_action('save_post_twl_book', 'twl_save_book_details');