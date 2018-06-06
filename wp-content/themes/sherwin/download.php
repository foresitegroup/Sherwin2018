<?php
header('Content-Disposition: attachment; filename='.basename($_GET["f"]));
header('Content-Type: application/octet-stream');
header("Content-Transfer-Encoding: Binary");
echo readfile($_GET["f"]);
exit;
?>