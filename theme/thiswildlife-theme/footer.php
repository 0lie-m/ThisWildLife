<footer>
  <div class="footer-container">
    <div class="footer-top-line"></div>

    <div class="footer-grid">
      <div>
        <div class="footer-logo">
          <img src="<?php echo get_template_directory_uri(); ?>/assets/images/branding/logo.png" alt="This Wild Life logo">
        </div>
      </div>

      <div class="footer-column">
        <h3>Explore</h3>
        <a href="<?php echo home_url('/'); ?>">Home</a>
        <a href="<?php echo home_url('/books/'); ?>">Books</a>
        <a href="<?php echo home_url('/discover/'); ?>">Discover</a>
        <a href="<?php echo home_url('/contact/'); ?>">Contact</a>
      </div>

      <div class="footer-column">
        <h3>About</h3>
        <a href="<?php echo home_url('/about/'); ?>">Our Journey</a>
        <a href="<?php echo home_url('/about/'); ?>">FAQ</a>
      </div>

      <div class="footer-column">
        <h3>Connect</h3>
        <div class="subscribe-box">
          <input type="email" placeholder="Email address">
          <button type="button">Subscribe</button>
        </div>
        <a href="<?php echo home_url('/contact/'); ?>">Instagram</a>
        <a href="<?php echo home_url('/contact/'); ?>">Facebook</a>
        <a href="<?php echo home_url('/contact/'); ?>">Twitter</a>
        <a href="<?php echo home_url('/books/'); ?>">Shop on Amazon</a>
      </div>
    </div>

    <div class="footer-bottom">
      (c) 2026 This Wild Life - Designed in Ireland
    </div>
  </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>