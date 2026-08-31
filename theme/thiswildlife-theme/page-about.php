<?php
get_header();

$about_content = twl_get_about_content();
$about_media = twl_get_about_media();

$theme_images =
  get_template_directory_uri() .
  '/assets/images/';

$fun_facts = preg_split(
  '/\r\n|\r|\n/',
  $about_content['fun_facts']
);

$creator_photos = [];

if ($about_media['creator_photos_managed'] === '1') {
  foreach (
    (array) $about_media['creator_photo_ids']
    as $attachment_id
  ) {
    $creator_photos[] = [
      'id' => absint($attachment_id),
    ];
  }
} else {
  $creator_photos = [
    [
      'url' =>
        $theme_images .
        'about photos/DSC06902-1.webp',
    ],
    [
      'url' =>
        $theme_images .
        'about photos/IMG_6215.webp',
    ],
    [
      'url' =>
        $theme_images .
        'about photos/IMG_7150-scaled.webp',
    ],
  ];
}

if ($about_media['facts_photo_managed'] === '1') {
  $facts_photo =
    absint($about_media['facts_photo_id']) > 0
      ? [
          'id' =>
            absint($about_media['facts_photo_id']),
        ]
      : null;
} else {
  $facts_photo = [
    'url' =>
      $theme_images .
      'about photos/IMG_5964-scaled.webp',
  ];
}

$gallery_photos = [];

if ($about_media['gallery_photos_managed'] === '1') {
  foreach (
    (array) $about_media['gallery_photo_ids']
    as $attachment_id
  ) {
    $gallery_photos[] = [
      'id' => absint($attachment_id),
    ];
  }
} else {
  $gallery_files = [
    '22856230-3FED-4BD7-9D36-6AD96EE4C872.webp',
    '31BEE921-B81A-49D6-8491-9E81B3A9D45F.webp',
    'IMG_8379-scaled.webp',
    'IMG_0314-scaled.webp',
    'IMG_5138-scaled.webp',
    'IMG_5645-scaled.webp',
    'IMG_5964-scaled.webp',
    'IMG_6215.webp',
    'IMG_7150-scaled.webp',
  ];

  foreach ($gallery_files as $gallery_file) {
    $gallery_photos[] = [
      'url' =>
        $theme_images .
        'about photos/' .
        $gallery_file,
    ];
  }
}

$render_about_image = static function (
  $image,
  $class_name
) {
  if (!empty($image['id'])) {
    echo wp_get_attachment_image(
      $image['id'],
      'large',
      false,
      [
        'class' => $class_name,
      ]
    );

    return;
  }

  if (empty($image['url'])) {
    return;
  }

  printf(
    '<img src="%s" class="%s" alt="">',
    esc_url($image['url']),
    esc_attr($class_name)
  );
};
?>

<main>

  <!-- ABOUT THE CREATOR -->
  <section class="section creator-section">
    <div class="container">

      <div class="decoration decoration-about-top-left">
        <img
          src="<?php
            echo esc_url(
              $theme_images .
              'Additional Art Pieces/' .
              '5F4EA352-411D-42B1-90FC-8EF0C245E776.png'
            );
          ?>"
          alt=""
        >
      </div>

      <div class="decoration decoration-about-top-right">
        <img
          src="<?php
            echo esc_url(
              $theme_images .
              'Additional Art Pieces/IMG_1637.png'
            );
          ?>"
          alt=""
        >
      </div>

      <div class="decoration decoration-about-left">
        <img
          src="<?php
            echo esc_url(
              $theme_images .
              'Additional Art Pieces/IMG_1637.png'
            );
          ?>"
          alt=""
        >
      </div>

      <div class="decoration decoration-about-mid-right">
        <img
          src="<?php
            echo esc_url(
              $theme_images .
              'Additional Art Pieces/' .
              '5F4EA352-411D-42B1-90FC-8EF0C245E776.png'
            );
          ?>"
          alt=""
        >
      </div>

      <div class="decoration decoration-about-bottom-left">
        <img
          src="<?php
            echo esc_url(
              $theme_images .
              'Additional Art Pieces/IMG_1637.png'
            );
          ?>"
          alt=""
        >
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
          <?php foreach ($creator_photos as $photo) : ?>
            <?php
            $render_about_image(
              $photo,
              'creator-photo'
            );
            ?>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </section>

  <!-- FUN FACTS -->
  <section class="section alt">
    <div class="container">

      <div class="decoration decoration-facts-top-left">
        <img
          src="<?php
            echo esc_url(
              $theme_images .
              'Additional Art Pieces/IMG_1637.png'
            );
          ?>"
          alt=""
        >
      </div>

      <div class="decoration decoration-about-right">
        <img
          src="<?php
            echo esc_url(
              $theme_images .
              'Additional Art Pieces/' .
              '5F4EA352-411D-42B1-90FC-8EF0C245E776.png'
            );
          ?>"
          alt=""
        >
      </div>

      <div class="decoration decoration-facts-bottom-right">
        <img
          src="<?php
            echo esc_url(
              $theme_images .
              'Additional Art Pieces/IMG_1637.png'
            );
          ?>"
          alt=""
        >
      </div>

      <div class="fun-facts-wrapper">

        <?php if ($facts_photo) : ?>
          <div class="fun-facts-image">
            <?php
            $render_about_image(
              $facts_photo,
              'fun-facts-photo'
            );
            ?>
          </div>
        <?php endif; ?>

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
        <img
          src="<?php
            echo esc_url(
              $theme_images .
              'Additional Art Pieces/' .
              '5F4EA352-411D-42B1-90FC-8EF0C245E776.png'
            );
          ?>"
          alt=""
        >
      </div>

      <div class="decoration decoration-memories-bottom-left">
        <img
          src="<?php
            echo esc_url(
              $theme_images .
              'Additional Art Pieces/IMG_1637.png'
            );
          ?>"
          alt=""
        >
      </div>

      <h2 style="text-align:center;">
        <?php
        echo esc_html(
          $about_content['memories_heading']
        );
        ?>
      </h2>

      <div class="memories-gallery">
        <?php foreach ($gallery_photos as $photo) : ?>
          <?php
          $render_about_image(
            $photo,
            'gallery-img'
          );
          ?>
        <?php endforeach; ?>
      </div>

    </div>
  </section>

</main>

<?php
get_footer();
?>