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

  <!-- Begin Mailchimp Signup Form -->
  <div id="mc_embed_signup">
    Receive periodic <span>news</span> and <span>product information</span>
    <form action="https://sherwinindustriesinc.us19.list-manage.com/subscribe/post?u=6567fb15ec7bd620806521ea0&amp;id=7d3a271abb" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate site-width" target="_blank" novalidate>
      <div id="mc_embed_signup_scroll">
        <div id="mce-responses" class="clear">
          <div class="response" id="mce-error-response" style="display:none"></div>
          <div class="response" id="mce-success-response" style="display:none"></div>
        </div>
        <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
        <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_6567fb15ec7bd620806521ea0_7d3a271abb" tabindex="-1" value=""></div>

        <input type="email" value="" name="EMAIL" id="mce-EMAIL" placeholder="Email">
        <input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe">
      </div>
    </form>
  </div>
  <!--End mc_embed_signup-->

  <footer id="main-footer">
    All rights reserved. Sherwin Industries, Inc. &copy; <?php echo date("Y"); ?>
  </footer>

</body>
</html>