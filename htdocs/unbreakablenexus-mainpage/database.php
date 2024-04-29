<?php
  $host = "localhost";
  $user = "root";
  $pw = "";
  $dbNev = "unbreakablenexusdb";
  $conn = mysqli_connect($host, $user, $pw, $dbNev);
  if (!$conn) {
      echo '<div class="alert error-box">SQL ERROR!</div>';
  }
?>
