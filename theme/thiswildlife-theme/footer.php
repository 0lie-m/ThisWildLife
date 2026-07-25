<footer>
  <div class="footer-container">
    <div class="footer-top-line"></div>

    <div class="footer-grid">
      <div class="footer-brand">
        <div class="footer-logo">
          <img src="<?php echo get_template_directory_uri(); ?>/assets/images/branding/logo.png" alt="This Wild Life logo">
        </div>
        <p class="footer-tagline">
          Children's stories inspired by Ireland's wildlife.
        </p>
      </div>

      <div class="footer-column">
        <h3>Explore</h3>
        <a href="<?php echo home_url('/'); ?>">Home</a>
        <a href="<?php echo home_url('/books/'); ?>">Books</a>
        <a href="<?php echo home_url('/discover/'); ?>">Discover</a>
      </div>

      <div class="footer-column">
        <h3>This Wild Life</h3>
        <a href="<?php echo home_url('/about/'); ?>">About the Creator</a>
        <a href="<?php echo home_url('/contact/'); ?>">Contact</a>
      </div>

      <div class="footer-column footer-updates">
        <h3>Newsletter</h3>
        <p>
          Book news, wildlife stories and new releases will be shared here.
        </p>
        <span class="footer-coming-soon">Coming soon</span>
      </div>
    </div>

    <div class="footer-bottom">
      &copy; <?php echo esc_html(wp_date('Y')); ?> This Wild Life &middot; Designed in Ireland
    </div>
  </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>