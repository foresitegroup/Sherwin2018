<?php
/**
 * Template Name: Bowmonk AFM2 Calibration
 */
get_header();

while (have_posts()) : the_post();
  echo '<div class="site-width">'."\n";
    the_content();
    ?>

    <form action="<?php echo get_template_directory_uri(); ?>/form-bowmonk.php" method="POST" id="form-bowmonk" class="form" novalidate>
      <!-- <input type="text" name="username" tabindex="-1" aria-hidden="true" autocomplete="off"> -->

      <h2>* Required</h2>
      <br>

      <input type="email" name="email" placeholder="Email *" required>

      <input type="text" name="business_airport_name" placeholder="Business/Airport Name *" required>

      <input type="text" name="contact_person" placeholder="Contact Person *" required>

      <input type="tel" name="phone" placeholder="Daytime Contact Telephone Number *" required>

      <textarea name="billing_address" placeholder="Billing Address (Full Address) *" required></textarea>

      <textarea name="shipping_address" placeholder="Shipping Address (Full Address) *" required></textarea>

      <input type="text" name="serial_number" placeholder="Serial Number of Unit *" required>
      
      <h2>Please Indicate Level of Service *</h2>
      <input type="checkbox" name="service[]" value="Calibration Only" id="s1">
      <label for="s1">Calibration Only</label>

      <input type="checkbox" name="service[]" value="Repair Only" id="s2">
      <label for="s2">Repair Only</label>

      <input type="checkbox" name="service[]" value="Calibration and Repair as Needed" id="s3">
      <label for="s3">Calibration and Repair as Needed</label>

      <input type="checkbox" name="service[]" value="Calibration and Repair under $250" id="s4">
      <label for="s4">Calibration and Repair under $250</label>

      <input type="checkbox" name="service[]" value="Calibration and Repair Must Call Before Any Repairs Made" id="s5">
      <label for="s5">Calibration and Repair Must Call Before Any Repairs Made</label>

      <input type="checkbox" name="service[]" value="Battery Replacement (6v and 3v )" id="s6">
      <label for="s6">Battery Replacement (6v and 3v )</label>
      <em style="font-size: 80%;">Batteries are automatically replaced every two years.</em><br>

      <br>

      <textarea name="description" placeholder="Description of Problem/Error/Malfunction"></textarea>

      <textarea name="additional_info" placeholder="Any Additional Information/Requests for this Unit?"></textarea>

      <select name="payment" id="payment" required>
        <option value="">Please Enter Your Payment Option *</option>
        <option value="Purchase Order">Purchase Order Number</option>
        <option value="Credit Card">Credit Card (MC/Visa/AMEX)</option>
      </select>

      <div id="payment-po">
        <input type="text" name="po_number" placeholder="Please Enter Purchase Order Number *" id="po_number">
      </div>

      <div id="payment-cc">
        Please call our corporate office for credit card processing.<br>
        1-800-525-8876
      </div>

      <select name="returnshipping" id="returnshipping" required>
        <option value="">Return Shipping of the Unit *</option>
        <option value="Sherwin Industries to Ship and Bill">Sherwin Industries to Ship and Bill</option>
        <option value="Customer UPS Account Number">Customer UPS Account Number</option>
        <option value="UPS Prepaid Return Label Included">UPS Prepaid Return Label Included</option>
        <option value="Local Pick-Up">Local Pick-Up</option>
      </select>

      <div id="rs-customer">
        <input type="text" name="rs_customer_ups" placeholder="Please Enter Your UPS Account Number *" id="rs_customer_ups">
      </div>

      <div id="rs-ups">
        Note: we only accept UPS, not FEDEX, DHL, USPS or other carriers.
      </div>

      <input type="hidden" name="id" value="<?php echo $post->ID; ?>">

      <button type="submit" id="submit">Submit</button>
    </form>

    <div id="modal">
      <div id="modal-box">
        <div id="modal-button"></div>
        <div id="modal-content"></div>
      </div>
    </div>

    <script>
      var payment = document.getElementById('payment');
      var po = document.getElementById('payment-po');
      var cc = document.getElementById('payment-cc');
      var ponum = document.getElementById('po_number');

      payment.addEventListener('change', (option) => {
        if (option.target.value == 'Purchase Order') {
          po.style.display = 'block';
          cc.style.display = 'none';
        }

        if (option.target.value == 'Credit Card') {
          po.style.display = 'none';
          cc.style.display = 'block';
        }

        if (option.target.value == '') {
          po.style.display = 'none';
          cc.style.display = 'none';
        }
      });

      var returnshipping = document.getElementById('returnshipping');
      var rscustomer = document.getElementById('rs-customer');
      var rsups = document.getElementById('rs-ups');
      var rscustomerups = document.getElementById('rs_customer_ups');

      returnshipping.addEventListener('change', (option) => {
        if (option.target.value == 'Customer UPS Account Number') {
          rscustomer.style.display = 'block';
          rsups.style.display = 'none';
        }

        if (option.target.value == 'UPS Prepaid Return Label Included') {
          rscustomer.style.display = 'none';
          rsups.style.display = 'block';
        }

        if (option.target.value != 'Customer UPS Account Number' && option.target.value != 'UPS Prepaid Return Label Included') {
          rscustomer.style.display = 'none';
          rsups.style.display = 'none';
        }
      });

      // BEGIN form submit
      const form = document.getElementById('form-bowmonk');
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
        
        // Validate checkboxes
        const checkboxes = document.querySelectorAll('input[type="checkbox"][name="service[]"]');
        let isChecked = false;

        for (let i = 0; i < checkboxes.length; i++) {
          if (checkboxes[i].checked) {
            isChecked = true;
            break;
          }
        }

        if (!isChecked) {
          const labels = document.querySelectorAll('input[type="checkbox"][name="service[]"] + LABEL');

          labels.forEach(label => {
            label.classList.add('alert');
          });

          valid = 'no';
        }
        
        // Validate purchase order number
        if (payment.value == 'po' && ponum.value == "") {
          ponum.classList.add('alert');
          ponum.placeholder = ponum.placeholder+' REQUIRED';
          valid = 'no';
        }

        // Validate customer UPS number
        if (returnshipping.value == 'Customer UPS Account Number' && rscustomerups.value == "") {
          rscustomerups.classList.add('alert');
          rscustomerups.placeholder = rscustomerups.placeholder+' REQUIRED';
          valid = 'no';
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

            po.style.display = 'none';
            cc.style.display = 'none';
            rscustomer.style.display = 'none';
            rsups.style.display = 'none';

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

    <?php
  echo "</div> <!-- /.site-width -->\n";
endwhile;

get_footer();
?>