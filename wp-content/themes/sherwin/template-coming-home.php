<?php
/* Template Name: Coming Home */

get_header();
?>

<style>
  #ch-hero {
    height: 679px; background-repeat: no-repeat; background-position: center;
    background-size: cover; position: relative;
  }

  #ch-hero .text {
    position: absolute; bottom: 0; left: 0; width: 100%; padding: 0.7em 0 0.5em;
    background: rgba(29,48,86,0.8); color: #FFFFFF; font-family: 'Teko', sans-serif;
    font-weight: 700; font-size: 44px; line-height: 1.2; text-transform: uppercase;
  }

  #ch-hero .text .site-width {
    display: flex; justify-content: space-between; align-items: center; gap: 1rem;

    @media (max-width: 700px) { & { flex-direction: column; } }
  }

  #ch-hero .text P { margin: 0; }

  #ch-hero .sw IMG { width: 150px; height: auto; }

  #ch-products { padding: 60px 0; }

  #ch-products H1 {
    margin: 0 0 0.5em; color: #1D3056; font-family: 'Teko', sans-serif;
    font-weight: 700; font-size: 60px; line-height: 1; text-transform: uppercase;
  }

  #ch-products H1 SPAN { color: #D85450; }

  #ch-products .products {
    display: flex; flex-wrap: wrap; gap: 2rem 1.3793%; padding-bottom: 3rem;

    @media (max-width: 900px) { & { gap: 2rem 5%; } }
    @media (max-width: 900px) { & { gap: 2rem 4%; } }
  }

  #ch-products .products > DIV {
    width: 23.9655%; color: #1D3056; font-family: 'Teko', sans-serif;
    font-weight: 700; font-size: 24px; line-height: 1; text-transform: uppercase;
    text-align: center;

    @media (max-width: 900px) { & { width: 30%; } }
    @media (max-width: 700px) { & { width: 48%; } }
    @media (max-width: 500px) { & { width: 100%; } }
  }

  #ch-products .products > DIV .image {
    margin-bottom: 0.5em; aspect-ratio: 1 / 1; background-repeat: no-repeat;
    background-position: center; background-size: cover;
  }

  .center { text-align: center; }

  .button {
    display: inline-block; margin: 0 auto; outline: none; border: 0;
    border-radius: 4px; min-width: 376px; padding: 0.5em 1em 0.3em;
    box-sizing: border-box; background: #E9484A; color: #FFFFFF !important;
    font-family: 'Teko', sans-serif; font-weight: 700; font-size: 24px;
    line-height: 1; text-transform: uppercase; text-align: center;

    @media (max-width: 450px) { & { min-width: 0; width: 100%; } }
  }

  .button:hover { background: #1D3056; }

  #form-coming-home {
    width: 572px; margin: 40px auto 80px;

    @media (max-width: 600px) { & { width: 96%; } }
  }

 #form-coming-home H2 {
    display: flex; justify-content: space-between; align-items: center;
    margin: 0 0 0.5em; color: #1D3056; font-family: 'Teko', sans-serif;
    font-weight: 700; font-size: 40px; line-height: 1; text-transform: uppercase;
  }

  #form-coming-home H2:after {
    content: '* Required'; font-weight: 400; font-size: 16px; text-transform: none;
  }

  #form-coming-home H3 {
    margin: 0; color: #1D3056; font-family: 'Teko', sans-serif;
     font-weight: 400; font-size: 24px; line-height: 1;
  }

  #ch-footer { padding: 60px 0; background: #EBEBEB; }

  #ch-footer .site-width {
    display: flex; justify-content: space-between; gap: 3rem 0;

    @media (max-width: 1000px) {&{ flex-wrap: wrap; justify-content: space-around; }}
    @media (max-width: 750px) { & { justify-content: space-between; } }
  }

  #ch-footer .site-width:after { display: none; }

  #ch-footer .site-width > DIV {
    font-size: 16px; line-height: 1;

    @media (max-width: 690px) { & { width: 100%; text-align: center; } }
  }

  @media (max-width: 1000px) {
    #ch-footer .site-width > DIV:last-of-type { width: 100%; text-align: center; }
  }

  #ch-footer .site-width > DIV H2 {
    margin: 0 0 0.5em; color: #1D3056; font-family: 'Teko', sans-serif;
    font-weight: 700; font-size: 40px; line-height: 1; text-transform: uppercase;
    white-space: nowrap;
  }

  #ch-footer .site-width > DIV A[href^="tel:"],
  #ch-footer .site-width > DIV A[href^="mailto:"] {
    display: inline-flex; align-items: center; gap: 12px; color: #353535;
    word-break: break-all;
  }

  #ch-footer .site-width > DIV A[href^="tel:"] { margin-bottom: 0.5em; }

  #ch-footer .site-width > DIV A[href^="tel:"]:before {
    content: ''; width: 32px; aspect-ratio: 1 / 1;
    background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512'%3E%3Cpath fill='%23E9484A' d='M160.2 25C152.3 6.1 131.7-3.9 112.1 1.4l-5.5 1.5c-64.6 17.6-119.8 80.2-103.7 156.4 37.1 175 174.8 312.7 349.8 349.8 76.3 16.2 138.8-39.1 156.4-103.7l1.5-5.5c5.4-19.7-4.7-40.3-23.5-48.1l-97.3-40.5c-16.5-6.9-35.6-2.1-47 11.8l-38.6 47.2C233.9 335.4 177.3 277 144.8 205.3L189 169.3c13.9-11.3 18.6-30.4 11.8-47L160.2 25z'/%3E%3C/svg%3E") no-repeat center;
    background-size: 80% auto;
  }

  #ch-footer .site-width > DIV A[href^="mailto:"]:before {
    content: ''; width: 32px; aspect-ratio: 1 / 1;
    background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath d='M0 0h24v24H0z' fill='none'/%3E%3Cpath fill='%23E9484A' d='M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z'/%3E%3C/svg%3E") no-repeat center;
    background-size: contain;
  }

  #ch-footer .site-width > DIV A[href^="tel:"]:hover,
  #ch-footer .site-width > DIV A[href^="mailto:"]:hover { color: #E9484A; }

  #ch-footer .site-width > DIV .button { min-width: 278px; }
</style>

<section id="ch-hero"<?php if (has_post_thumbnail()) echo ' style="background-image: url('.get_the_post_thumbnail_url().');"'; ?>>
  <div class="text">
    <div class="site-width">
      <?php
      if (have_posts()) :
        while (have_posts()) : the_post();
          the_content();
        endwhile;
      endif;
      ?>

      <a href="https://www.sourcewell-mn.gov/cooperative-purchasing/110122-SWN" target="sw" class="sw"><img src="<?php echo get_template_directory_uri(); ?>/images/sourcewell.webp"></a>
    </div>
  </div>
</section>

<section id="ch-products" class="site-width">
  <h1>Unmatched Quality at an <span>Affordable Price</span></h1>

  <div class="products">
    <div>
      <div class="image" style="background-image: url(https://sherwinindustries.com/wp-content/uploads/2026/02/ch-runway-closure.webp);"></div>
      Runway Closure
    </div>

    <div>
      <div class="image" style="background-image: url(https://sherwinindustries.com/wp-content/uploads/2026/02/ch-barricades.webp);"></div>
      Barricades
    </div>

    <div>
      <div class="image" style="background-image: url(https://sherwinindustries.com/wp-content/uploads/2026/02/ch-painting-equipment.webp);"></div>
      Painting Equipment
    </div>

    <div>
      <div class="image" style="background-image: url(https://sherwinindustries.com/wp-content/uploads/2026/02/ch-pavement-repair.webp);"></div>
      Pavement Repair
    </div>

    <div>
      <div class="image" style="background-image: url(https://sherwinindustries.com/wp-content/uploads/2026/02/ch-airfield-markings.webp);"></div>
      Airfield Markings
    </div>

    <div>
      <div class="image" style="background-image: url(https://sherwinindustries.com/wp-content/uploads/2026/02/ch-friction-measurement.webp);"></div>
      Friction Measurement
    </div>

    <div>
      <div class="image" style="background-image: url(https://sherwinindustries.com/wp-content/uploads/2026/02/ch-hi-viz-gear.webp);"></div>
      Hi Viz Gear
    </div>

    <div>
      <div class="image" style="background-image: url(https://sherwinindustries.com/wp-content/uploads/2026/02/ch-stencils.webp);"></div>
      Stencils
    </div>
  </div>

  <div class="center">
    <a href="<?php echo home_url(); ?>/product-catalog/" class="button">Explore Our Products</a>
  </div>
</section>

<form action="<?php echo get_template_directory_uri(); ?>/form-coming-home.php" method="POST" id="form-coming-home" class="form" novalidate>
  <div>
    <h2>Please Contact Us</h2>

    <input type="text" name="name" placeholder="Name *" required>

    <input type="text" name="company" placeholder="Company/Organization">

    <input type="email" name="email" placeholder="Email *" required>

    <input type="tel" name="phone" placeholder="Phone">

    <h3>I work for/with:</h3>
    <input type="radio" name="workfor" value="Commercial Service Airport" id="r1" checked>
    <label for="r1">Commercial Service Airport</label>

    <input type="radio" name="workfor" value="General Aviation Airport" id="r2">
    <label for="r2">General Aviation Airport</label>

    <input type="radio" name="workfor" value="Contractor/Engineer/Corporate" id="r3">
    <label for="r3">Contractor/Engineer/Corporate</label>

    <textarea name="additional" placeholder="Any Additional Requests" style="margin-top: 1.125rem;"></textarea>

    <input type="hidden" name="id" value="<?php echo $post->ID; ?>">

    <button type="submit" id="submit">Submit</button>
  </div>
</form>

<div id="modal">
  <div id="modal-box">
    <div id="modal-button"></div>
    <div id="modal-content"></div>
  </div>
</div>

<script>
  const form = document.getElementById('form-coming-home');
  form.addEventListener('submit', submitForm);

  function submitForm(event) {
    event.preventDefault();

    // Validate any fields with "required" selector
    var valid = 'yes';

    for (const el of form.querySelectorAll('[required]')) {
      if (!el.checkValidity()) {
        document.getElementsByName(el.name).forEach(function (input) {
          input.classList.add('alert');
          input.placeholder = input.placeholder+' REQUIRED';
        });

        valid = 'no';
      }
    }

    // If fields are valid, send the data
    if (valid == 'yes') {
      document.getElementById('submit').classList.add('loader');

      const data = new FormData(form);

      fetch(form.action, {
        method: 'POST',
        body: data
      })
      .then((response) => response.text())
      .then((result) => {
        // Data sent, so display success message
        // and clear all the form fields
        document.getElementById('modal-content').innerHTML = result;
        modal.style.display = "block";
        form.reset();

        // Clear alerts
        document.querySelectorAll('.alert').forEach(function (alert) {
          alert.classList.remove('alert');
          alert.placeholder = alert.placeholder.substring(0, alert.placeholder.length-9);
        });

        document.getElementById('submit').classList.remove('loader');
      });
    }
  } // END submitForm

  const modal = document.getElementById("modal");
  const modalbutton = document.getElementById("modal-button");

  window.onclick = function(event) {
    if (event.target == modal) modal.style.display = "none";
  }

  modalbutton.onclick = function() { modal.style.display = "none"; }
</script>

<section id="ch-footer">
  <div class="site-width">
    <div>
      <h2>Corporate Office</h2>
      <a href="tel:8005258876">800-525-8876</a><br>
      <a href="mailto:corporate@sherwinindustries.com">corporate@sherwinindustries.com</a>
    </div>

    <div>
      <h2>Aviation Division</h2>
      <a href="tel:8005122206">800-512-2206</a><br>
      <a href="mailto:trushing@sherwinindustries.com">trushing@sherwinindustries.com</a>
    </div>

    <div>
      <h2>Regional Offices</h2>
      <a href="<?php echo home_url(); ?>/contact/" class="button">Find Your Office</a>
    </div>
  </div>
</section>

<?php get_footer(); ?>