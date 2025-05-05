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

      <input type="text" name="billing_address" placeholder="Address *" required>

      <input type="text" name="billing_city" placeholder="City *" required>

      <input type="text" name="billing_state" placeholder="State *" required>

      <input type="text" name="billing_zip" placeholder="Zip Code *" required>

      <textarea name="shipping_address" placeholder="Shipping Address (Full Address) *" required></textarea>

      <select name="payment" id="payment" required>
        <option value="">Please Enter Your Payment Option *</option>
        <option value="Purchase Order">Purchase Order Number</option>
        <option value="Credit Card">Credit Card (MC/Visa/AMEX)</option>
        <option value="Contact Name">Contact Name: First and Last</option>
      </select>

      <div id="payment-po">
        <input type="text" name="po_number" placeholder="Please Enter Purchase Order Number *" id="po_number">
      </div>

      <div id="payment-cc">
        Please call our corporate office for credit card processing.<br>
        1-800-525-8876
      </div>

      <div id="payment-cn">
        <input type="text" name="po_name" placeholder="Please Enter Contact Name: First and Last *" id="po_name">
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

      <div id="units" data-rows="1">
        <div class="unit">
          <input type="text" name="serial_number0" placeholder="Serial Number of Unit *" required>
          
          <h2>Please Indicate Level of Service *</h2>
          <input type="checkbox" name="service0[]" value="Calibration Only" id="s1">
          <label for="s1">Calibration Only</label>

          <input type="checkbox" name="service0[]" value="Repair Only" id="s2">
          <label for="s2">Repair Only</label>

          <input type="checkbox" name="service0[]" value="Calibration and Repair as Needed" id="s3">
          <label for="s3">Calibration and Repair as Needed</label>

          <input type="checkbox" name="service0[]" value="Calibration and Repair under $250" id="s4">
          <label for="s4">Calibration and Repair under $250</label>

          <input type="checkbox" name="service0[]" value="Calibration and Repair Must Call Before Any Repairs Made" id="s5">
          <label for="s5">Calibration and Repair Must Call Before Any Repairs Made</label>

          <input type="checkbox" name="service0[]" value="Battery Replacement (6v and 3v )" id="s6">
          <label for="s6">Battery Replacement (6v and 3v )</label>
          <em style="font-size: 80%;">Batteries are automatically replaced every two years.</em><br>

          <br>

          <textarea name="description0" placeholder="Description of Problem/Error/Malfunction"></textarea>

          <textarea name="additional_info0" placeholder="Any Additional Information/Requests for this Unit?"></textarea>
        </div>
      </div> <!-- /#units -->

      <div onclick="add_row('units')" class="row-button">Add Unit</div>

      <input type="hidden" name="units" value="1" id="number_of_units">
      
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
      var cn = document.getElementById('payment-cn');
      var ponum = document.getElementById('po_number');

      payment.addEventListener('change', (option) => {
        if (option.target.value == 'Purchase Order') {
          po.style.display = 'block';
          cc.style.display = 'none';
          cn.style.display = 'none';
        }

        if (option.target.value == 'Credit Card') {
          po.style.display = 'none';
          cc.style.display = 'block';
          cn.style.display = 'none';
        }

        if (option.target.value == 'Contact Name') {
          po.style.display = 'none';
          cc.style.display = 'none';
          cn.style.display = 'block';
        }

        if (option.target.value == '') {
          po.style.display = 'none';
          cc.style.display = 'none';
          cn.style.display = 'none';
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

      function add_row(value) {
        var div = document.getElementById(value);
        var rowcount = div.dataset.rows;

        var row = '<div class="buttonrow">'+
          '<input type="text" name="serial_number'+rowcount+'" placeholder="Serial Number of Unit">'+
          '<div onclick="remove_row(this)" class="row-button">Remove</div>'+
        '</div>'+
        '<h2>Please Indicate Level of Service</h2>'+
        '<input type="checkbox" name="service'+rowcount+'[]" value="Calibration Only" id="s1'+rowcount+'">'+
        '<label for="s1'+rowcount+'">Calibration Only</label>'+
        '<input type="checkbox" name="service'+rowcount+'[]" value="Repair Only" id="s2'+rowcount+'">'+
        '<label for="s2'+rowcount+'">Repair Only</label>'+
        '<input type="checkbox" name="service'+rowcount+'[]" value="Calibration and Repair as Needed" id="s3'+rowcount+'">'+
        '<label for="s3'+rowcount+'">Calibration and Repair as Needed</label>'+
        '<input type="checkbox" name="service'+rowcount+'[]" value="Calibration and Repair under $250" id="s4'+rowcount+'">'+
        '<label for="s4'+rowcount+'">Calibration and Repair under $250</label>'+
        '<input type="checkbox" name="service'+rowcount+'[]" value="Calibration and Repair Must Call Before Any Repairs Made" id="s5'+rowcount+'">'+
        '<label for="s5'+rowcount+'">Calibration and Repair Must Call Before Any Repairs Made</label>'+
        '<input type="checkbox" name="service'+rowcount+'[]" value="Battery Replacement (6v and 3v )" id="s6'+rowcount+'">'+
        '<label for="s6'+rowcount+'">Battery Replacement (6v and 3v )</label>'+
        '<em style="font-size: 80%;">Batteries are automatically replaced every two years.</em><br><br>'+
        '<textarea name="description'+rowcount+'" placeholder="Description of Problem/Error/Malfunction"></textarea>'+
        '<textarea name="additional_info'+rowcount+'" placeholder="Any Additional Information/Requests for this Unit?"></textarea>';

        var unit = document.createElement('div');
        unit.setAttribute("id", "unit"+rowcount);
        unit.classList.add("unit", "added-dynamically");
        unit.innerHTML = row;
        div.append(unit);

        rowcount++;

        div.setAttribute("data-rows", rowcount);
        document.getElementById("number_of_units").value = rowcount;
      }

      function remove_row(value) {
        document.getElementById(value.parentNode.parentNode.id).remove();

        var units = document.querySelectorAll('.unit');

        for (let i = 0; i < units.length; i++) {
          units[i].setAttribute("id", "unit"+i);

          var sn = document.querySelectorAll('#unit'+i+' input[name^="serial_number"]');
          sn.forEach((snName) => { snName.name = "serial_number"+i; });

          var service = document.querySelectorAll('#unit'+i+' input[name^="service"]');
          service.forEach((serviceCheck) => {
            serviceCheck.name = "service"+i+"[]";
            var sid = serviceCheck.id.substring(0,2);
            serviceCheck.setAttribute("id", sid+i);
          });

          var serviceL = document.querySelectorAll('#unit'+i+' input[name^="service"] + label');
          serviceL.forEach((serviceLabel) => {
            var slfor = serviceLabel.htmlFor.substring(0,2);
            serviceLabel.htmlFor = slfor+i;
          });

          var desc = document.querySelectorAll('#unit'+i+' textarea[name^="description"]');
          desc.forEach((descName) => { descName.name = "description"+i; });

          var info = document.querySelectorAll('#unit'+i+' textarea[name^="additional_info"]');
          info.forEach((infoName) => { infoName.name = "additional_info"+i; });
        }

        document.getElementById("units").setAttribute("data-rows", units.length);
        document.getElementById("number_of_units").value = units.length;
      }

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
        const checkboxes = document.querySelectorAll('input[type="checkbox"][name^="service"]');
        let isChecked = false;

        for (let i = 0; i < checkboxes.length; i++) {
          if (checkboxes[i].checked) {
            isChecked = true;
            break;
          }
        }

        if (!isChecked) {
          const labels = document.querySelectorAll('input[type="checkbox"][name^="service"] + LABEL');

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
            cn.style.display = 'none';
            rscustomer.style.display = 'none';
            rsups.style.display = 'none';

            document.querySelectorAll('.added-dynamically').forEach(function (elem) {
              elem.remove();
            });
            document.getElementById("units").setAttribute("data-rows", 1);
            document.getElementById("number_of_units").value = 1;

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