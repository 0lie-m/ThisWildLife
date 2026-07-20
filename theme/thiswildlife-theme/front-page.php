<?php get_header(); ?>

<main>

  <!-- HERO -->
  <section class="hero" id="home">
    <div class="hero-inner">
      <div>
        <h1 class="hero-title">Discover Ireland's<br>Wild Stories</h1>
        <p class="hero-sub">
          Beautifully illustrated books inspired by Ireland's native wildlife.
          Explore the characters, learn the real animals behind the stories, and browse the collection.
        </p>
        <a class="btn bronze" href="#books">Explore the Books</a>
      </div>

      <div class="hero-media">
        <img class="hero-photo" src="<?php echo get_template_directory_uri(); ?>/assets/images/miscImages/comuirgheasa-connemara-national-park-6713140.jpg" alt="Connemara National Park landscape in Ireland">
      </div>
    </div>
  </section>

  <!-- FEATURED BOOKS -->
  <section class="section" id="books">
    <div class="container">
      <div class="decoration decoration-books-left">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/Additional Art Pieces/IMG_1638.png" alt="Decorative botanical art">
      </div>
      
      <h2 class="h2">Featured Books</h2>
      <p class="p-center">A small selection from the collection. Tap any title to open the full books page.</p>

      <div class="grid-3">
        <div class="card">
          <div class="placeholder-img">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/Brigid the Badger.png" alt="Brigid the Badger book cover">
          </div>
          <h3>Brigid the Badger</h3>
          <p>A gentle adventure inspired by one of Ireland's best-known native animals.</p>
          <a class="btn" href="<?php echo home_url('/books/'); ?>">View on Books Page</a>
        </div>

        <div class="card">
          <div class="placeholder-img">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/Fionn the Fox .png" alt="Fionn the Fox book cover">
          </div>
          <h3>Fionn the Fox</h3>
          <p>A warm woodland story full of curiosity, friendship and wild Irish places.</p>
          <a class="btn" href="<?php echo home_url('/books/'); ?>">View on Books Page</a>
        </div>

        <div class="card">
          <div class="placeholder-img">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/Holly the Hedgehog.png" alt="Holly the Hedgehog book cover">
          </div>
          <h3>Holly the Hedgehog</h3>
          <p>A cosy, playful tale inspired by hedgerows, leaves and native wildlife.</p>
          <a class="btn" href="<?php echo home_url('/books/'); ?>">View on Books Page</a>
        </div>
      </div>
    </div>
  </section>

  <!-- MEET THE WILD ONES -->
  <section class="section alt" id="discover">
    <div class="container">
      <div class="decoration decoration-wild-left">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/Additional Art Pieces/5F4EA352-411D-42B1-90FC-8EF0C245E776.png" alt="Decorative ferns">
      </div>
      
      <h2 class="h2">Meet the Wild Ones</h2>
      <p class="p-center">Meet the characters and learn about the real animals that inspired the stories.</p>

      <div class="grid-4">
        <div class="card">
          <div class="placeholder-img">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/wild-ones/fox.jpg" alt="Red fox in nature">
          </div>
          <h3>Fox</h3>
          <p>Quick, clever and adaptable, foxes are one of Ireland's most iconic wild mammals.</p>
          <a class="btn" href="#">Learn More</a>
        </div>

        <div class="card">
          <div class="placeholder-img">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/wild-ones/badger.jpg" alt="Badger in woodland habitat">
          </div>
          <h3>Badger</h3>
          <p>Badgers are nocturnal burrowers and an important part of woodland ecosystems.</p>
          <a class="btn" href="#">Learn More</a>
        </div>

        <div class="card">
          <div class="placeholder-img">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/wild-ones/hedgehog.jpg" alt="Hedgehog on grass">
          </div>
          <h3>Hedgehog</h3>
          <p>Hedgehogs are beloved night-time foragers and thrive in healthy mixed habitats.</p>
          <a class="btn" href="#">Learn More</a>
        </div>

        <div class="card">
          <div class="placeholder-img">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/wild-ones/puffin.jpg" alt="Puffin on a coastal cliff">
          </div>
          <h3>Puffin</h3>
          <p>Puffins nest on Ireland's sea cliffs and are a highlight of coastal wildlife watching.</p>
          <a class="btn" href="#">Learn More</a>
        </div>
      </div>

      <div class="decoration decoration-wild-right">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/Additional Art Pieces/IMG_1637.png" alt="Decorative botanical art">
      </div>
    </div>
  </section>

  <!-- MISSION -->
  <section class="section" id="about">
    <div class="container">
      <div class="split mission">
        <div>
          <h2>Rooted in Ireland.</h2>
          <p>
            These stories are inspired by the real animals that call Ireland home.
            The aim is to encourage curiosity and care for nature - through gentle storytelling and illustration.
          </p>
          <a class="btn" href="#">Learn More</a>
        </div>

        <div class="placeholder-img tall" style="border-radius:18px;">
          <img src="<?php echo get_template_directory_uri(); ?>/assets/images/miscImages/comuirgheasa-skellig-7394565.jpg" alt="Skellig coastal landscape in Ireland">
        </div>
      </div>
    </div>
  </section>

  <!-- FINAL CTA -->
  <section class="section alt" id="contact">
    <div class="container">
      <div class="split" style="align-items:center;">
        <div>
          <h2 style="font-family:'Cormorant Garamond',serif;font-weight:600;font-size:40px;margin:0 0 10px 0;">
            Every story begins with nature.
          </h2>
          <p style="margin:0 0 18px 0;color:var(--muted);line-height:1.7;max-width:60ch;">
            Browse the collection and follow the adventures inspired by Ireland's wildlife.
          </p>
          <a class="btn bronze" href="#books">Browse the Collection</a>
        </div>

        <div class="placeholder-img tall" style="border-radius:18px;">
          <img src="<?php echo get_template_directory_uri(); ?>/assets/images/miscImages/declandoran-robin-5146569.jpg" alt="Robin bird perched in natural habitat">
        </div>
      </div>
    </div>
  </section>

</main>

<?php get_footer(); ?>
