<?php
/* Template Name: Contact */

get_header();

function email($address, $name="") {
  $email = "";
  for ($i = 0; $i < strlen($address); $i++) { $email .= (rand(0, 1) == 0) ? "&#" . ord(substr($address, $i)) . ";" : substr($address, $i, 1); }
  if ($name == "") $name = $email;
  echo "<a href=\"&#109;&#97;&#105;&#108;&#116;&#111;&#58;$email\">$name</a>";
}
?>

<script type="text/javascript">
  jQuery(document).ready(function() {
    jQuery('#find-rep').submit(function(event) {
      event.preventDefault();

      jQuery.ajax({
        type: 'POST',
        url: jQuery('#find-rep').attr('action'),
        data: jQuery('#find-rep').serialize() + '&src=ajax'
      })
      .done(function(response) {
        jQuery('#contact-results').css('display', 'block');
        jQuery('#find-rep-results').html(response);
      });
    });
  });
</script>

<div class="site-width contact">
  <div id="contact-find">
    <h2>Find Your Local Rep</h2>
    PLEASE NOTE that not every area will have a local Sherwin representative. If that is the case, you will be directed to our corporate headquarters.

    <h3>Choose Your Area</h3>
    
    <form action="<?php echo get_template_directory_uri(); ?>/ajax-find-rep.php" method="POST" id="find-rep">
      <div class="select">
        <select name="state" id="state">
          <option value="">Select...</option>
          <option value="South">Alabama</option>
          <option value="NoRep">Alaska</option>
          <option value="NoRep">Arizona</option>
          <option value="NoRep">Arkansas</option>
          <option value="Southwest">California</option>
          <option value="NoRep">Colorado</option>
          <option value="NoRep">Connecticut</option>
          <option value="NoRep">Delaware</option>
          <option value="NoRep">District of Columbia</option>
          <option value="NoRep">Florida</option>
          <option value="South">Georgia</option>
          <option value="NoRep">Hawaii</option>
          <option value="NoRep">Idaho</option>
          <option value="Illinois">Illinois</option>
          <option value="Indiana">Indiana</option>
          <option value="NoRep">Iowa</option>
          <option value="NoRep">Kansas</option>
          <option value="Kentucky">Kentucky</option>
          <option value="NoRep">Louisiana</option>
          <option value="NoRep">Maine</option>
          <option value="Virginia">Maryland</option>
          <option value="NoRep">Massachusetts</option>
          <option value="Michigan">Michigan</option>
          <option value="NoRep">Minnesota</option>
          <option value="NoRep">Mississippi</option>
          <option value="NoRep">Missouri</option>
          <option value="NoRep">Montana</option>
          <option value="NoRep">Nebraska</option>
          <option value="NoRep">Nevada</option>
          <option value="NoRep">New Hampshire</option>
          <option value="NoRep">New Jersey</option>
          <option value="NoRep">New Mexico</option>
          <option value="NoRep">New York</option>
          <option value="South">North Carolina</option>
          <option value="NoRep">North Dakota</option>
          <option value="NoRep">Ohio</option>
          <option value="NoRep">Oklahoma</option>
          <option value="NoRep">Oregon</option>
          <option value="NoRep">Pennsylvania</option>
          <option value="NoRep">Rhode Island</option>
          <option value="South">South Carolina</option>
          <option value="NoRep">South Dakota</option>
          <option value="Virginia">Tennessee</option>
          <option value="NoRep">Texas</option>
          <option value="NoRep">Utah</option>
          <option value="NoRep">Vermont</option>
          <option value="Virginia">Virginia </option>
          <option value="NoRep">Washington</option>
          <option value="Virginia">West Virginia</option>
          <option value="Wisconsin">Wisconsin</option>
          <option value="NoRep">Wyoming</option>
          <option value="Europe">Europe</option>
        </select>
      </div>

      <button id="find-my-rep">Find My Sherwin Rep</button>
    </form>
  </div>

  <div id="contact-map">
    <img src="<?php echo get_the_post_thumbnail_url(get_the_ID(),'full'); ?>" alt="">
  </div>
</div>

<div id="contact-results">
  <div class="site-width">
    <div id="results-corporate">
      <h1>Local Sherwin Reps</h1>

      <h3>Corporate Headquarters</h3>

      <strong>Sherwin Industries, Inc.</strong><br>
      2129 W. Morgan Ave<br>
      Milwaukee, WI 53221<br>
      <strong>Office:</strong> <a href="tel:414-281-6400">414-281-6400</a><br>
      <strong>Toll Free:</strong> <a href="tel:800-525-8876">800-525-8876</a><br>
      <br>

      <strong>President:</strong> Al Schultz<br>
      <?php email("aschultz@sherwinindustries.com"); ?><br>
      <br>

      <strong>Vice President:</strong> Randy Jackson<br>
      <?php email("rjackson@sherwinindustries.com"); ?>
    </div>

    <div id="find-rep-results"></div>
  </div>
</div>

<?php get_footer(); ?>