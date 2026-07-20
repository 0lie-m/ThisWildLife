<?php get_header(); ?>
<!-- Staging deployment is managed from GitHub's dev branch. -->

<main>
    <section class="hero">
        <div class="hero-slideshow">
            <div
                class="slide active"
                style="background-image: url('<?php
                    echo esc_url(
                        get_template_directory_uri() .
                        '/assets/images/Brigid the Badger.png'
                    );
                ?>');"
            ></div>

            <div
                class="slide"
                style="background-image: url('<?php
                    echo esc_url(
                        get_template_directory_uri() .
                        '/assets/images/Fionn the Fox .png'
                    );
                ?>');"
            ></div>

            <div
                class="slide"
                style="background-image: url('<?php
                    echo esc_url(
                        get_template_directory_uri() .
                        '/assets/images/Holly the Hedgehog.png'
                    );
                ?>');"
            ></div>

            <div
                class="slide"
                style="background-image: url('<?php
                    echo esc_url(
                        get_template_directory_uri() .
                        '/assets/images/Peadar the Puffin.png'
                    );
                ?>');"
            ></div>

            <div
                class="slide"
                style="background-image: url('<?php
                    echo esc_url(
                        get_template_directory_uri() .
                        '/assets/images/The Mystery of Puck Fair.png'
                    );
                ?>');"
            ></div>
        </div>

        <div class="hero-overlay"></div>

        <div class="hero-inner single-column">
            <div class="hero-copy reveal">
                <span class="hero-kicker">The Collection</span>

                <h1 class="hero-title">
                    Explore Our Wild Stories
                </h1>

                <p class="hero-sub">
                    Browse the This Wild Life Ireland collection and
                    discover beautifully illustrated stories inspired
                    by Irish wildlife, landscapes and imagination.
                    Select a title to view its details.
                </p>

                <div class="hero-actions">
                    <a href="#book-collection" class="btn bronze">
                        Browse the Books
                    </a>

                    <a href="#collection-note" class="btn">
                        Learn More
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section
        class="section books-section"
        id="book-collection"
    >
        <div class="container">
            <div class="decoration decoration-left">
                <img
                    src="<?php
                        echo esc_url(
                            get_template_directory_uri() .
                            '/assets/images/Additional Art Pieces/' .
                            '5F4EA352-411D-42B1-90FC-8EF0C245E776.png'
                        );
                    ?>"
                    alt="Decorative ferns"
                >
            </div>

            <h2 class="section-title reveal">
                The Book Collection
            </h2>

            <p class="section-intro reveal">
                Select a book to open more information, including
                story details, reader age guidance and availability.
            </p>

            <div
                class="books-carousel reveal"
                aria-label="Book carousel"
            >
                <button
                    class="carousel-btn prev"
                    id="booksPrev"
                    type="button"
                    aria-label="Previous books"
                >
                    &#10094;
                </button>

                <div
                    class="books-viewport"
                    id="booksViewport"
                >
                    <div
                        class="books-track"
                        id="booksTrack"
                    >
                        <?php
                        $books_query = new WP_Query([
                            'post_type'      => 'twl_book',
                            'post_status'    => 'publish',
                            'posts_per_page' => -1,
                            'meta_key'       => '_twl_display_order',
                            'orderby'        => [
                                'meta_value_num' => 'ASC',
                                'title'          => 'ASC',
                            ],
                            'order'           => 'ASC',
                        ]);

                        $availability_labels = [
                            'coming_soon' => 'Coming soon',
                            'available' => 'Available',
                            'out_of_stock' => 'Out of stock',
                            'unavailable' => 'Unavailable',
                        ];

                        if ($books_query->have_posts()) :
                            while ($books_query->have_posts()) :
                                $books_query->the_post();

                                $book_id = get_the_ID();

                                $cover_url =
                                    get_the_post_thumbnail_url(
                                        $book_id,
                                        'large'
                                    );

                                $author = get_post_meta(
                                    $book_id,
                                    '_twl_author',
                                    true
                                );

                                $format = get_post_meta(
                                    $book_id,
                                    '_twl_format',
                                    true
                                );

                                $minimum_age = get_post_meta(
                                    $book_id,
                                    '_twl_minimum_age',
                                    true
                                );

                                $maximum_age = get_post_meta(
                                    $book_id,
                                    '_twl_maximum_age',
                                    true
                                );

                                $price = get_post_meta(
                                    $book_id,
                                    '_twl_price',
                                    true
                                );

                                $amazon_url = get_post_meta(
                                    $book_id,
                                    '_twl_amazon_url',
                                    true
                                );

                                $availability = get_post_meta(
                                    $book_id,
                                    '_twl_availability',
                                    true
                                );

                                $availability_text =
                                    $availability_labels[
                                        $availability
                                    ] ?? 'Coming soon';
                                ?>

                                <article
                                    class="book-card"
                                    tabindex="0"
                                    role="button"
                                    data-title="<?php
                                        echo esc_attr(
                                            get_the_title()
                                        );
                                    ?>"
                                    data-cover="<?php
                                        echo esc_url($cover_url);
                                    ?>"
                                    data-description="<?php
                                        echo esc_attr(
                                            wp_strip_all_tags(
                                                get_the_content()
                                            )
                                        );
                                    ?>"
                                    data-author="<?php
                                        echo esc_attr($author);
                                    ?>"
                                    data-format="<?php
                                        echo esc_attr($format);
                                    ?>"
                                    data-minimum-age="<?php
                                        echo esc_attr(
                                            $minimum_age
                                        );
                                    ?>"
                                    data-maximum-age="<?php
                                        echo esc_attr(
                                            $maximum_age
                                        );
                                    ?>"
                                    data-price="<?php
                                        echo esc_attr($price);
                                    ?>"
                                    data-amazon-url="<?php
                                        echo esc_url($amazon_url);
                                    ?>"
                                    data-availability="<?php
                                        echo esc_attr(
                                            $availability_text
                                        );
                                    ?>"
                                >
                                    <div class="book-cover-wrap">
                                        <?php if ($cover_url) : ?>
                                            <img
                                                src="<?php
                                                    echo esc_url(
                                                        $cover_url
                                                    );
                                                ?>"
                                                alt="<?php
                                                    echo esc_attr(
                                                        get_the_title() .
                                                        ' front cover'
                                                    );
                                                ?>"
                                            >
                                        <?php endif; ?>
                                    </div>

                                    <h3>
                                        <?php
                                        echo esc_html(
                                            get_the_title()
                                        );
                                        ?>
                                    </h3>

                                    <p class="book-author">
                                        <?php
                                        echo esc_html($author);
                                        ?>
                                    </p>

                                    <p class="book-text">
                                        <?php
                                        echo esc_html(
                                            get_the_excerpt()
                                        );
                                        ?>
                                    </p>

                                    <div class="book-actions">
                                        <span
                                            class="btn bronze book-open"
                                        >
                                            View Book
                                        </span>
                                    </div>
                                </article>

                                <?php
                            endwhile;

                            wp_reset_postdata();
                        else :
                            ?>
                            <p class="books-empty">
                                No books are currently available.
                            </p>
                        <?php endif; ?>
                    </div>
                </div>

                <button
                    class="carousel-btn next"
                    id="booksNext"
                    type="button"
                    aria-label="Next books"
                >
                    &#10095;
                </button>
            </div>

            <div
                class="carousel-dots"
                id="booksDots"
                aria-label="Carousel pagination"
            ></div>

            <div class="decoration decoration-right">
                <img
                    src="<?php
                        echo esc_url(
                            get_template_directory_uri() .
                            '/assets/images/Additional Art Pieces/' .
                            'IMG_1637.png'
                        );
                    ?>"
                    alt="Decorative botanical art"
                >
            </div>

            <div
                class="collection-note reveal"
                id="collection-note"
            >
                <h3>Book Collection</h3>

                <p>
                    This collection is rooted in Irish wildlife and
                    landscapes, with each story designed to encourage
                    curiosity, empathy and a connection to nature for
                    young readers.
                </p>
            </div>
        </div>
    </section>
</main>

<div
    class="modal"
    id="bookModal"
    aria-hidden="true"
>
    <div
        class="modal-dialog"
        role="dialog"
        aria-modal="true"
        aria-labelledby="modalBookTitle"
    >
        <button
            class="modal-close"
            id="closeModalBtn"
            type="button"
            aria-label="Close book details"
        >
            &times;
        </button>

        <div class="modal-body">
            <div class="modal-gallery">
                <h3>Book Preview</h3>

                <div class="modal-covers">
                    <div class="modal-cover-card">
                        <img
                            id="modalFrontCover"
                            src=""
                            alt="Book front cover"
                        >

                        <p class="cover-label">
                            Front Cover
                        </p>
                    </div>

                    <div class="modal-cover-card">
                        <div class="placeholder-back">
                            <div class="placeholder-top">
                                This Wild Life
                            </div>

                            <div class="placeholder-copy">
                                A heartfelt wildlife story inspired
                                by Ireland's landscapes, written to
                                spark curiosity, kindness and care
                                for the natural world.
                            </div>

                            <div class="placeholder-bottom">
                                Back Cover
                            </div>
                        </div>

                        <p class="cover-label">
                            Back Cover
                        </p>
                    </div>
                </div>
            </div>

            <div class="modal-text">
                <span class="modal-kicker">
                    Book Details
                </span>

                <h2
                    class="modal-title"
                    id="modalBookTitle"
                >
                    Book Title
                </h2>

                <p
                    class="modal-author"
                    id="modalBookAuthor"
                >
                    C. Burke
                </p>

                <p
                    class="modal-desc"
                    id="modalBookDesc"
                >
                    Select a book from the collection to read its
                    full description.
                </p>

                <div class="book-meta">
                    <div class="meta-box">
                        <span class="meta-label">
                            Format
                        </span>

                        <span
                            class="meta-value"
                            id="modalFormat"
                        >
                            Illustrated children's book
                        </span>
                    </div>

                    <div class="meta-box">
                        <span class="meta-label">
                            Age Range
                        </span>

                        <span
                            class="meta-value"
                            id="modalAgeRange"
                        >
                            4–8 years
                        </span>
                    </div>

                    <div class="meta-box">
                        <span class="meta-label">
                            Availability
                        </span>

                        <span
                            class="meta-value"
                            id="modalAvailability"
                        >
                            Coming soon
                        </span>
                    </div>
                </div>

                <p
                    class="price"
                    id="modalPrice"
                >
                    €12.99
                </p>

                <div class="modal-actions">
                    <a
                        href="#"
                        class="btn bronze"
                        target="_blank"
                        rel="noopener noreferrer"
                        id="amazonLink"
                    >
                        View on Amazon
                    </a>

                    <button
                        class="btn light"
                        type="button"
                        id="closeModalBtnSecondary"
                    >
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>