  </div> <!-- #content -->

  <?php wp_footer(); ?>

  <?php if (is_product()) { ?>
    <div id="footer-product">
      <div class="site-width">
        <span>Interested or need more information?</span>
        <h1>Contact a Sherwin rep today</h1>
        Call <a href="tel:1-800-525-8876">1-800-525-8876</a> or <a href="<?php echo home_url(); ?>/contact">e-mail us</a>
      </div>
    </div>
  <?php } ?>
  
  <?php if ($post->post_name != "about") { ?>
  <div id="footer-contact">
    <div class="site-width">
      Sherwin Industries, Inc.<br>
      2129 W. Morgan Ave<br>
      Milwaukee, WI 53221<br>
      <a href="tel:1-800-525-8876"><span style="color: #FFFFFF;">1-800-</span>525-8876</a>
    </div>
  </div>
  <?php } ?>

  <footer id="main-footer">
    All rights reserved. Sherwin Industries, Inc. &copy; <?php echo date("Y"); ?>
  </footer>

</body>
</html>