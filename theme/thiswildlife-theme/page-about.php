<?php
get_header();

$about_content = twl_get_about_content();

$fun_facts = preg_split(
  '/\r\n|\r|\n/',
  $about_content['fun_facts']
);
?>

<main>

  <!-- ABOUT THE CREATOR -->
  <section class="section creator-section">
    <div class="container">

      <div class="decoration decoration-about-top-left">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/Additional Art Pieces/5F4EA352-411D-42B1-90FC-8EF0C245E776.png" alt="">
      </div>

      <div class="decoration decoration-about-top-right">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/Additional Art Pieces/IMG_1637.png" alt="">
      </div>

      <div class="decoration decoration-about-left">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/Additional Art Pieces/IMG_1637.png" alt="">
      </div>

      <div class="decoration decoration-about-mid-right">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/Additional Art Pieces/5F4EA352-411D-42B1-90FC-8EF0C245E776.png" alt="">
      </div>

      <div class="decoration decoration-about-bottom-left">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/Additional Art Pieces/IMG_1637.png" alt="">
      </div>

      <h2 class="section-kicker">
        <?php
        echo esc_html(
          $about_content['creator_kicker']
        );
        ?>
      </h2>

      <h1 class="creator-name">
        <?php
        echo esc_html(
          $about_content['creator_name']
        );
        ?>
      </h1>

      <div class="creator-intro">
        <div class="creator-text">
          <p>
            <?php
            echo esc_html(
              $about_content['intro_one']
            );
            ?>
          </p>

          <p>
            <?php
            echo esc_html(
              $about_content['intro_two']
            );
            ?>
          </p>
        </div>

        <div class="creator-photos">
          <img src="<?php echo get_template_directory_uri(); ?>/assets/images/about photos/DSC06902-1.webp" class="creator-photo">
          <img src="<?php echo get_template_directory_uri(); ?>/assets/images/about photos/IMG_6215.webp" class="creator-photo">
          <img src="<?php echo get_template_directory_uri(); ?>/assets/images/about photos/IMG_7150-scaled.webp" class="creator-photo">
        </div>
      </div>
    </div>
  </section>

  <!-- FUN FACTS -->
  <section class="section alt">
    <div class="container">

      <div class="decoration decoration-facts-top-left">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/Additional Art Pieces/IMG_1637.png" alt="">
      </div>

      <div class="decoration decoration-about-right">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/Additional Art Pieces/5F4EA352-411D-42B1-90FC-8EF0C245E776.png" alt="">
      </div>

      <div class="decoration decoration-facts-bottom-right">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/Additional Art Pieces/IMG_1637.png" alt="">
      </div>

      <div class="fun-facts-wrapper">

        <div class="fun-facts-image">
          <img src="<?php echo get_template_directory_uri(); ?>/assets/images/about photos/IMG_5964-scaled.webp" class="fun-facts-photo">
        </div>

        <div class="fun-facts-content">
          <h2>
            <?php
            echo esc_html(
              $about_content['facts_heading']
            );
            ?>
          </h2>

          <ul class="facts-list">
            <?php
            foreach ($fun_facts as $fact) :
              $fact = trim($fact);

              if ($fact === '') {
                continue;
              }
              ?>
              <li><?php echo esc_html($fact); ?></li>
            <?php endforeach; ?>
          </ul>

          <p class="facts-quote">
            &ldquo;<?php
            echo esc_html(
              $about_content['facts_quote']
            );
            ?>&rdquo;
          </p>
        </div>

      </div>
    </div>
  </section>

  <!-- MEMORIES -->
  <section class="section">
    <div class="container">

      <div class="decoration decoration-memories-top-right">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/Additional Art Pieces/5F4EA352-411D-42B1-90FC-8EF0C245E776.png" alt="">
      </div>

      <div class="decoration decoration-memories-bottom-left">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/Additional Art Pieces/IMG_1637.png" alt="">
      </div>

      <h2 style="text-align:center;">
        <?php
        echo esc_html(
          $about_content['memories_heading']
        );
        ?>
      </h2>

      <div class="memories-gallery">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/about photos/22856230-3FED-4BD7-9D36-6AD96EE4C872.webp" class="gallery-img">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/about photos/31BEE921-B81A-49D6-8491-9E81B3A9D45F.webp" class="gallery-img">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/about photos/IMG_8379-scaled.webp" class="gallery-img">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/about photos/IMG_0314-scaled.webp" class="gallery-img">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/about photos/IMG_5138-scaled.webp" class="gallery-img">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/about photos/IMG_5645-scaled.webp" class="gallery-img">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/about photos/IMG_5964-scaled.webp" class="gallery-img">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/about photos/IMG_6215.webp" class="gallery-img">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/about photos/IMG_7150-scaled.webp" class="gallery-img">
      </div>

    </div>
  </section>

</main>

<?php
get_footer();
?>