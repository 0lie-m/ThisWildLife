<?php

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Return the default About photograph settings.
 *
 * Unmanaged sections continue using the current theme photographs.
 */
function twl_get_default_about_media()
{
    return [
        'creator_photo_ids' => [],
        'creator_photos_managed' => '0',
        'facts_photo_id' => 0,
        'facts_photo_managed' => '0',
        'gallery_photo_ids' => [],
        'gallery_photos_managed' => '0',
    ];
}

/**
 * Return the saved About photograph settings.
 */
function twl_get_about_media()
{
    $saved_media = get_option(
        'twl_about_media',
        []
    );

    if (!is_array($saved_media)) {
        $saved_media = [];
    }

    return wp_parse_args(
        $saved_media,
        twl_get_default_about_media()
    );
}

/**
 * Clean a comma-separated list of Media Library IDs.
 */
function twl_sanitize_about_media_ids($value)
{
    if (is_string($value)) {
        $value = explode(',', $value);
    }

    if (!is_array($value)) {
        return [];
    }

    $ids = array_map('absint', $value);
    $ids = array_filter($ids);
    $ids = array_unique($ids);

    return array_values($ids);
}

/**
 * Clean the About photograph settings before saving.
 */
function twl_sanitize_about_media($input)
{
    if (!is_array($input)) {
        return twl_get_default_about_media();
    }

    return [
        'creator_photo_ids' =>
            twl_sanitize_about_media_ids(
                $input['creator_photo_ids'] ?? []
            ),

        'creator_photos_managed' =>
            !empty($input['creator_photos_managed'])
                ? '1'
                : '0',

        'facts_photo_id' =>
            isset($input['facts_photo_id'])
                ? absint($input['facts_photo_id'])
                : 0,

        'facts_photo_managed' =>
            !empty($input['facts_photo_managed'])
                ? '1'
                : '0',

        'gallery_photo_ids' =>
            twl_sanitize_about_media_ids(
                $input['gallery_photo_ids'] ?? []
            ),

        'gallery_photos_managed' =>
            !empty($input['gallery_photos_managed'])
                ? '1'
                : '0',
    ];
}

/**
 * Register the About photograph settings.
 */
function twl_register_about_media_setting()
{
    register_setting(
        'twl_about_media_group',
        'twl_about_media',
        [
            'type' => 'array',
            'sanitize_callback' =>
                'twl_sanitize_about_media',
            'default' =>
                twl_get_default_about_media(),
        ]
    );
}

add_action(
    'admin_init',
    'twl_register_about_media_setting'
);

/**
 * Allow the Publisher role to save About photographs.
 */
function twl_about_media_settings_capability()
{
    return 'edit_twl_books';
}

add_filter(
    'option_page_capability_twl_about_media_group',
    'twl_about_media_settings_capability'
);

/**
 * Add About Photos beneath Website Content.
 */
function twl_register_about_media_page()
{
    add_submenu_page(
        'twl-website-content',
        'About Photos',
        'About Photos',
        'edit_twl_books',
        'twl-about-photos',
        'twl_render_about_media_page'
    );
}

add_action(
    'admin_menu',
    'twl_register_about_media_page'
);

/**
 * Load WordPress's Media Library selector.
 */
function twl_enqueue_about_media_assets()
{
    $page = isset($_GET['page'])
        ? sanitize_key(wp_unslash($_GET['page']))
        : '';

    if ($page !== 'twl-about-photos') {
        return;
    }

    wp_enqueue_media();

    wp_enqueue_script(
        'twl-about-media',
        plugin_dir_url(__FILE__) .
            '../assets/js/about-media.js',
        [
    'jquery',
    'jquery-ui-sortable',
],
        '1.0.0',
        true
    );
}

add_action(
    'admin_enqueue_scripts',
    'twl_enqueue_about_media_assets'
);

/**
 * Display one photograph selector.
 */
function twl_render_about_media_selector(
    $field_name,
    $label,
    $ids,
    $multiple,
    $managed,
    $description
) {
    $ids = array_map(
        'absint',
        (array) $ids
    );

    $ids = array_values(
        array_filter($ids)
    );

    $managed_field_name =
        $field_name === 'facts_photo_id'
            ? 'facts_photo_managed'
            : str_replace(
                '_ids',
                's_managed',
                $field_name
            );

    ?>
    <div
        class="twl-media-selector"
        data-multiple="<?php
            echo $multiple ? 'true' : 'false';
        ?>"
    >
        <h3><?php echo esc_html($label); ?></h3>

        <p class="description">
            <?php echo esc_html($description); ?>
        </p>

        <input
            class="twl-media-ids"
            name="twl_about_media[<?php
                echo esc_attr($field_name);
            ?>]"
            type="hidden"
            value="<?php
                echo esc_attr(
                    implode(',', $ids)
                );
            ?>"
        >

        <input
            class="twl-media-managed"
            name="twl_about_media[<?php
                echo esc_attr($managed_field_name);
            ?>]"
            type="hidden"
            value="<?php
                echo $managed === '1' ? '1' : '0';
            ?>"
        >

        <div
            class="twl-media-preview"
            style="
                display:flex;
                flex-wrap:wrap;
                gap:12px;
                margin:12px 0;
            "
        >
            <?php foreach ($ids as $attachment_id) : ?>
                <?php
                $image_url = wp_get_attachment_image_url(
                    $attachment_id,
                    'thumbnail'
                );

                if (!$image_url) {
                    continue;
                }
                ?>

                <div
                    class="twl-media-item"
                    data-attachment-id="<?php
                        echo esc_attr($attachment_id);
                    ?>"
                >
                    <img
                        src="<?php echo esc_url($image_url); ?>"
                        alt=""
                        style="
                            display:block;
                            height:100px;
                            object-fit:cover;
                            width:100px;
                        "
                    >

                    <button
                        class="button-link-delete twl-remove-media"
                        type="button"
                    >
                        Remove
                    </button>
                </div>
            <?php endforeach; ?>
        </div>

        <button
            class="button twl-select-media"
            type="button"
        >
            <?php
            echo $multiple
                ? esc_html('Choose photographs')
                : esc_html('Choose photograph');
            ?>
        </button>

        <button
            class="button-link-delete twl-clear-media"
            type="button"
        >
            Hide all
        </button>
    </div>
    <?php
}

/**
 * Display the About Photos editor.
 */
function twl_render_about_media_page()
{
    if (!current_user_can('edit_twl_books')) {
        wp_die(
            'You do not have permission to edit these photographs.'
        );
    }

    $media = twl_get_about_media();

    ?>
    <div class="wrap">
        <h1>Edit About Photos</h1>

        <p>
            Choose photographs from the WordPress Media Library.
            Removing or hiding a photograph here does not delete
            the original Media Library file.
        </p>

        <p>
            The current theme photographs remain visible until
            replacements are selected for a section.
        </p>

        <?php settings_errors(); ?>

        <form method="post" action="options.php">
            <?php settings_fields('twl_about_media_group'); ?>

            <?php
            twl_render_about_media_selector(
                'creator_photo_ids',
                'Creator photographs',
                $media['creator_photo_ids'],
                true,
                $media['creator_photos_managed'],
                'Photographs displayed beside the introduction.'
            );

            twl_render_about_media_selector(
                'facts_photo_id',
                'Fun Facts photograph',
                [$media['facts_photo_id']],
                false,
                $media['facts_photo_managed'],
                'The main photograph beside the Fun Facts section.'
            );

            twl_render_about_media_selector(
                'gallery_photo_ids',
                'Memories gallery',
                $media['gallery_photo_ids'],
                true,
                $media['gallery_photos_managed'],
                'Photographs displayed in the Memories gallery.'
            );
            ?>

            <?php submit_button('Save About Photos'); ?>
        </form>
    </div>
    <?php
}