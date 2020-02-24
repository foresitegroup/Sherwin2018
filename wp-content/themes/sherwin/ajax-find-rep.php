<?php
function email($address, $name="") {
  $email = "";
  for ($i = 0; $i < strlen($address); $i++) { $email .= (rand(0, 1) == 0) ? "&#" . ord(substr($address, $i)) . ";" : substr($address, $i, 1); }
  if ($name == "") $name = $email;
  echo "<a href=\"&#109;&#97;&#105;&#108;&#116;&#111;&#58;$email\">$name</a>";
}
?>

<?php if ($_POST['state'] == "NoRep") { ?>
  <h3>Please contact our corporate headquarters.</h3>
<?php } ?>

<?php if ($_POST['state'] == "Europe") { ?>
  <div>
    <h3>United Kingdom and Europe Dealer</h3>

    <strong>Ernie Hill</strong><br>
    Bowmonk Limited<br>
    Norwich, England<br>
    <strong>Office:</strong> <a href="tel:011-44-1603-485153">011-44-1603-485153</a><br>
    <strong>Fax:</strong> <a href="tel:011-44-1603-418150">011-44-1603-418150</a>
  </div>
<?php } ?>

<?php if ($_POST['state'] == "Northwest") { ?>
  <div>
    <h3>Northwest Offices</h3>

    <strong>Jim Mascaro</strong><br>
    <?php email("jmas048@msn.com"); ?><br>
    Peoria, AZ<br>
    <strong>Office:</strong> <a href="tel:623-606-2373">623-606-2373</a><br>
    <strong>Fax:</strong> <a href="tel:623-979-1574">623-979-1574</a>
  </div>
<?php } ?>

<?php if ($_POST['state'] == "Southwest") { ?>
  <div>
    <h3>Southwest Offices</h3>

    <strong>Jim Mascaro</strong><br>
    <?php email("jmas048@msn.com"); ?><br>
    Peoria, AZ<br>
    <strong>Office:</strong> <a href="tel:623-606-2373">623-606-2373</a><br>
    <strong>Fax:</strong> <a href="tel:623-979-1574">623-979-1574</a>
  </div>
<?php } ?>

<?php if ($_POST['state'] == "South") { ?>
  <h3>Southeast Offices</h3>
  
  <div>
    <strong>Gill Meek</strong><br>
    <?php email("gmeek@sherwinindustries.com"); ?><br>
    Leland, NC<br>
    <strong>Office:</strong> <a href="tel:336-210-1046">336-210-1046</a><br>
    <strong>Fax:</strong> <a href="tel:910-399-1114">910-399-1114</a><br>
    <br>
  </div>

  <div>
    <h4>Western Office</h4>
    <strong>Eric Reinhardt</strong><br>
    <?php email("ereinhardt@sherwinindustries.com"); ?><br>
    State Road, NC<br>
    <strong>Office:</strong> <a href="tel:336-467-2928">336-467-2928</a><br>
    <strong>Fax:</strong> <a href="tel:910-399-1114">910-399-1114</a><br>
    <br>
  </div>

  <div>
    <h4>Eastern Office</h4>
    <strong>Michael Cornette</strong><br>
    <?php email("mcornette@sherwinindustries.com"); ?><br>
    Greensboro, NC<br>
    <strong>Office:</strong> <a href="tel:336-312-0656">336-312-0656</a><br>
    <br>
  </div>
  
  <div>
    <h3>North Carolina Warehouse</h3>
    <strong>Furniture City Warehouse</strong><br>
    2325 E. Kivett Drive<br>
    High Point, NC<br>
    <strong>Office:</strong> <a href="tel:336-869-8376">336-869-8376</a><br>
    <strong>Fax:</strong> <a href="tel:336-869-8389">336-869-8389</a><br>
    <br>

    <strong>Sherwin Industries, Inc.</strong><br>
    325-101 Habersham<br>
    High Point, NC 27260<br>
    <strong>Office:</strong> <a href="tel:336-210-1046">336-210-1046</a>
  </div>
<?php } ?>

<?php if ($_POST['state'] == "Illinois") { ?>
    <h3>Illinois</h3>
  
  <div>
    <strong>Mike Baier</strong><br>
    <?php email("mbaier@sherwinindustries.com"); ?><br>
    North East Illinois<br>
    <strong>Office:</strong> <a href="tel:414-405-6511">414-405-6511</a><br>
    <strong>Fax:</strong> <a href="tel:414-281-6404">414-281-6404</a>
  </div>
  
  <div>
    <strong>Mike West</strong><br>
    <?php email("mwest@sherwinindustries.com"); ?><br>
    Peoria, IL<br>
    <strong>Office:</strong> <a href="tel:309-509-0061">309-509-0061</a><!-- <br>
    <strong>Fax:</strong> <a href="tel:630-613-9896">630-613-9896</a> -->
  </div>
<?php } ?>

<?php if ($_POST['state'] == "Indiana") { ?>
  <h3>Indiana</h3>
  
  <div>
    <h4>Indiana and Lower Michigan Sales Office</h4>
    <strong>Stuart Warner</strong><br>
    <?php email("swarner@sherwinindustries.com"); ?><br>
    Granger, IN<br>
    <strong>Office:</strong> <a href="tel:574-303-9093">574-303-9093</a><br>
    <strong>Fax:</strong> <a href="tel:574-329-5314">574-329-5314</a><br>
    <br>
  </div>
  
  <div>
    <h3>Indiana Warehouse</h3>
    <strong>Glenrock, Inc.</strong><br>
    4330 Hull Street, #300<br>
    Lawrence, IN 46226<br>
    <strong>Office:</strong> <a href="tel:414-281-6400">414-281-6400</a>
  </div>
<?php } ?>

<?php if ($_POST['state'] == "Kentucky") { ?>
  <h3>Virginia Sales Office</h3>

  <div>
    <strong>Todd Rushing</strong><br>
    <?php email("trushing@sherwinindustries.com"); ?><br>
    Midlothian, VA<br>
    <strong>Office:</strong> <a href="tel:804-512-2206">804-512-2206</a><br>
    <br>
  </div>
  
  <div>
    <strong>Kevin Doss</strong><br>
    <?php email("kdoss@sherwinindustries.com"); ?><br>
    Midlothian, VA<br>
    <strong>Office:</strong> <a href="tel:804-564-1668">804-564-1668</a><br>
    <br>
  </div>
  
  <div>
    <h3>Virginia Warehouse</h3>
    <strong>Bermuda Distribution</strong><br>
    12511 Bermuda Triangle Road<br>
    Chester, VA 23836<br>
    <strong>Office:</strong> <a href="tel:804-748-6385">804-748-6385</a><br>
    <br>
  </div>
<?php } ?>

<?php if ($_POST['state'] == "Michigan") { ?>
  <h3>Michigan</h3>
  
  <div>
    <h4>Northeastern Wisconsin and Western Upper Michigan Sales Office</h4>
    <strong>Dennis Fleischman</strong><br>
    <?php email("dfleischman@sherwinindustries.com"); ?><br>
    Wausau, WI<br>
    <strong>Office:</strong> <a href="tel:715-531-8119">715-531-8119</a><br>
    <strong>Fax:</strong> <a href="tel:715-355-0014">715-355-0014</a><br>
    <br>
  </div>
  
  <div>
    <h4>Northeastern Wisconsin and Upper Michigan Sales Office</h4>
    <strong>Keith Zepnick</strong><br>
    <?php email("kzepnick@sherwinindustries.com"); ?><br>
    Kiel, WI<br>
    <strong>Office:</strong> <a href="tel:920-894-4184">920-894-4184</a><br>
    <strong>Fax:</strong> <a href="tel:920-894-4101">920-894-4101</a><br>
    <br>
  </div>
  
  <div>
    <h4>Southern Wisconsin and Lower Michigan Sales Office</h4>
    <strong>Dan Morgan</strong><br>
    <?php email("dmorgan@sherwinindustries.com"); ?><br>
    Milwaukee, WI<br>
    <strong>Office:</strong> <a href="tel:414-281-6400">414-281-6400</a><br>
    <strong>Fax:</strong> <a href="tel:414-281-6404">414-281-6404</a><br>
    <br>
  </div>
  
  <div>
    <h4>Indiana and Lower Michigan Sales Office</h4>
    <strong>Stuart Warner</strong><br>
    <?php email("swarner@sherwinindustries.com"); ?><br>
    Granger, IN<br>
    <strong>Office:</strong> <a href="tel:574-303-9093">574-303-9093</a><br>
    <strong>Fax:</strong> <a href="tel:574-329-5314">574-329-5314</a>
  </div>
<?php } ?>

<?php if ($_POST['state'] == "Virginia") { ?>
  <h3>Virginia Sales Office</h3>

  <div>
    <strong>Todd Rushing</strong><br>
    <?php email("trushing@sherwinindustries.com"); ?><br>
    Midlothian, VA<br>
    <strong>Office:</strong> <a href="tel:804-512-2206">804-512-2206</a><br>
    <br>

    <strong>Kevin Doss</strong><br>
    <?php email("kdoss@sherwinindustries.com"); ?><br>
    Midlothian, VA<br>
    <strong>Office:</strong> <a href="tel:804-564-1668">804-564-1668</a><br>
    <br>
  </div>
  
  <div>
    <h3>Virginia Warehouse</h3>
    <strong>Bermuda Distribution</strong><br>
    12511 Bermuda Triangle Road<br>
    Chester, VA 23836<br>
    <strong>Office:</strong> <a href="tel:804-748-6385">804-748-6385</a>
  </div>
<?php } ?>

<?php if ($_POST['state'] == "Wisconsin") { ?>
  <h3>Wisconsin Sales Office</h3>
  
  <div>
    <h4>Southern Wisconsin and Lower Michigan Sales Office</h4>
    <strong>Dan Morgan</strong><br>
    <?php email("dmorgan@sherwinindustries.com"); ?><br>
    Milwaukee, WI<br>
    <strong>Office:</strong> <a href="tel:414-281-6400">414-281-6400</a><br>
    <strong>Fax:</strong> <a href="tel:414-281-6404">414-281-6404</a><br>
    <br>
  </div>
  
  <div>
    <h4>Northern Wisconsin and Western Upper Michigan Sales Office</h4>
    <strong>Dennis Fleischman</strong><br>
    <?php email("dfleischman@sherwinindustries.com"); ?><br>
    Wausau, WI<br>
    <strong>Office:</strong> <a href="tel:715-531-8119">715-531-8119</a><br>
    <strong>Fax:</strong> <a href="tel:715-355-0014">715-355-0014</a><br>
    <br>
  </div>

  <div>
    <h4>Northeastern Wisconsin and Eastern Upper Michigan Sales Office</h4>
    <strong>Keith Zepnick</strong><br>
    <?php email("kzepnick@sherwinindustries.com"); ?><br>
    Kiel, WI<br>
    <strong>Office:</strong> <a href="tel:920-894-4184">920-894-4184</a><br>
    <strong>Fax:</strong> <a href="tel:920-894-4101">920-894-4101</a><br>
    <br>
  </div>
  
  <div>
    <h3>Wisconsin Warehouses</h3>

    2129 W. Morgan Ave<br>
    Milwaukee, WI 53221<br>
    <strong>Office:</strong> <a href="tel:414-281-6400">414-281-6400</a><br>
    <br>

    <strong>Jack and Dick's</strong><br>
    975 S. Jackson St.<br>
    Janesville, Wisconsin 53545<br>
    <strong>Office:</strong> <a href="tel:608-752-3058">608-752-3058</a>
  </div>
<?php } ?>