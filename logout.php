<?php
  include 'tilpark.php';
  session_start();
  unset($_SESSION["login_id"]);
  header("Location: ".get_site_url());
 ?>
