<?php

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Return the original About Page content as safe defaults.
 */
function twl_get_default_about_content()
{
    return [
        'creator_kicker' => 'About the Creator',
        'creator_name' => 'C. Burke',
        'intro_one' =>
            "Hi there and welcome to This Wild Life! I've always " .
            'loved two things: spending time with animals and ' .
            'sharing my love of animals. After working in wildlife ' .
            "education and exploring Ireland's wild places, I " .
            'wanted to find a way to share that love with children ' .
            'and families.',
        'intro_two' =>
            "That's how This Wild Life began—a series of books " .
            'where fact and imagination meet. Through the ' .
            'adventures of native Irish wildlife, I hope to spark ' .
            'curiosity, bring smiles, and remind readers that ' .
            "Ireland's animals are full of wonder.",
        'facts_heading' => 'Fun Facts About Me',
        'fun_facts' =>
            "Favourite Irish animal: the fox\n" .
            'Favourite place to explore: the Glenbeigh Fairy ' .
            "Forest\n" .
            'Animals I have worked and learned from: Turkey ' .
            'vultures, Hyena, Hamadryad Baboon, Common ' .
            'Bottlenose Dolphin, Indian Crested Porcupine, and ' .
            "many more\n" .
            'Inspiration for these books: my family and ' .
            "Ireland's wild landscapes\n" .
            "My dream: to connect the world's wildlife one " .
            'story at a time ✨',
        'facts_quote' =>
            'Big adventures, little lessons, straight from the wild.',
        'memories_heading' =>
            'Take a look at some of my favorite memories...',
    ];
}

/**
 * Return saved About content combined with safe defaults.
 */
function twl_get_about_content()
{
    $saved_content = get_option(
        'twl_about_content',
        []
    );

    if (!is_array($saved_content)) {
        $saved_content = [];
    }

    return wp_parse_args(
        $saved_content,
        twl_get_default_about_content()
    );
}

/**
 * Clean About content before saving it.
 */
function twl_sanitize_about_content($input)
{
    $defaults = twl_get_default_about_content();

    if (!is_array($input)) {
        return $defaults;
    }

    return [
        'creator_kicker' => isset($input['creator_kicker'])
            ? sanitize_text_field($input['creator_kicker'])
            : $defaults['creator_kicker'],

        'creator_name' => isset($input['creator_name'])
            ? sanitize_text_field($input['creator_name'])
            : $defaults['creator_name'],

        'intro_one' => isset($input['intro_one'])
            ? sanitize_textarea_field($input['intro_one'])
            : $defaults['intro_one'],

        'intro_two' => isset($input['intro_two'])
            ? sanitize_textarea_field($input['intro_two'])
            : $defaults['intro_two'],

        'facts_heading' => isset($input['facts_heading'])
            ? sanitize_text_field($input['facts_heading'])
            : $defaults['facts_heading'],

        'fun_facts' => isset($input['fun_facts'])
            ? sanitize_textarea_field($input['fun_facts'])
            : $defaults['fun_facts'],

        'facts_quote' => isset($input['facts_quote'])
            ? sanitize_text_field($input['facts_quote'])
            : $defaults['facts_quote'],

        'memories_heading' =>
            isset($input['memories_heading'])
                ? sanitize_text_field(
                    $input['memories_heading']
                )
                : $defaults['memories_heading'],
    ];
}

/**
 * Register the saved About Page option.
 */
function twl_register_about_content_setting()
{
    register_setting(
        'twl_about_content_group',
        'twl_about_content',
        [
            'type' => 'array',
            'sanitize_callback' =>
                'twl_sanitize_about_content',
            'default' =>
                twl_get_default_about_content(),
        ]
    );
}

add_action(
    'admin_init',
    'twl_register_about_content_setting'
);

/**
 * Allow the Publisher role to save About Page settings.
 */
function twl_about_content_settings_capability()
{
    return 'edit_twl_books';
}

add_filter(
    'option_page_capability_twl_about_content_group',
    'twl_about_content_settings_capability'
);

/**
 * Add About Page beneath Website Content.
 */
function twl_register_about_content_page()
{
    add_submenu_page(
        'twl-website-content',
        'About Page',
        'About Page',
        'edit_twl_books',
        'twl-about-content',
        'twl_render_about_content_page'
    );
}

add_action(
    'admin_menu',
    'twl_register_about_content_page'
);

/**
 * Display the protected About Page editor.
 */
function twl_render_about_content_page()
{
    if (!current_user_can('edit_twl_books')) {
        wp_die(
            'You do not have permission to edit this page.'
        );
    }

    $content = twl_get_about_content();

    ?>
    <div class="wrap">
        <h1>Edit About Page</h1>

        <p>
            Update the About Page text without changing its design.
        </p>

        <?php settings_errors(); ?>

        <form method="post" action="options.php">
            <?php
            settings_fields('twl_about_content_group');
            ?>

            <h2>About the Creator</h2>

            <table class="form-table">
                <tr>
                    <th scope="row">
                        <label for="creator_kicker">
                            Section heading
                        </label>
                    </th>
                    <td>
                        <input
                            class="regular-text"
                            id="creator_kicker"
                            name="twl_about_content[creator_kicker]"
                            type="text"
                            value="<?php
                                echo esc_attr(
                                    $content['creator_kicker']
                                );
                            ?>"
                        >
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="creator_name">
                            Creator name
                        </label>
                    </th>
                    <td>
                        <input
                            class="regular-text"
                            id="creator_name"
                            name="twl_about_content[creator_name]"
                            type="text"
                            value="<?php
                                echo esc_attr(
                                    $content['creator_name']
                                );
                            ?>"
                        >
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="intro_one">
                            Introduction paragraph one
                        </label>
                    </th>
                    <td>
                        <textarea
                            class="large-text"
                            id="intro_one"
                            name="twl_about_content[intro_one]"
                            rows="5"
                        ><?php
                            echo esc_textarea(
                                $content['intro_one']
                            );
                        ?></textarea>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="intro_two">
                            Introduction paragraph two
                        </label>
                    </th>
                    <td>
                        <textarea
                            class="large-text"
                            id="intro_two"
                            name="twl_about_content[intro_two]"
                            rows="5"
                        ><?php
                            echo esc_textarea(
                                $content['intro_two']
                            );
                        ?></textarea>
                    </td>
                </tr>
            </table>

            <h2>Fun Facts</h2>

            <table class="form-table">
                <tr>
                    <th scope="row">
                        <label for="facts_heading">
                            Section heading
                        </label>
                    </th>
                    <td>
                        <input
                            class="regular-text"
                            id="facts_heading"
                            name="twl_about_content[facts_heading]"
                            type="text"
                            value="<?php
                                echo esc_attr(
                                    $content['facts_heading']
                                );
                            ?>"
                        >
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="fun_facts">
                            Fun facts
                        </label>
                    </th>
                    <td>
                        <textarea
                            class="large-text"
                            id="fun_facts"
                            name="twl_about_content[fun_facts]"
                            rows="8"
                        ><?php
                            echo esc_textarea(
                                $content['fun_facts']
                            );
                        ?></textarea>

                        <p class="description">
                            Put each fun fact on a separate line.
                        </p>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="facts_quote">
                            Quote
                        </label>
                    </th>
                    <td>
                        <input
                            class="large-text"
                            id="facts_quote"
                            name="twl_about_content[facts_quote]"
                            type="text"
                            value="<?php
                                echo esc_attr(
                                    $content['facts_quote']
                                );
                            ?>"
                        >
                    </td>
                </tr>
            </table>

            <h2>Memories Gallery</h2>

            <table class="form-table">
                <tr>
                    <th scope="row">
                        <label for="memories_heading">
                            Gallery heading
                        </label>
                    </th>
                    <td>
                        <input
                            class="large-text"
                            id="memories_heading"
                            name="twl_about_content[memories_heading]"
                            type="text"
                            value="<?php
                                echo esc_attr(
                                    $content['memories_heading']
                                );
                            ?>"
                        >
                    </td>
                </tr>
            </table>

            <?php submit_button('Save About Page'); ?>
        </form>
    </div>
    <?php
}