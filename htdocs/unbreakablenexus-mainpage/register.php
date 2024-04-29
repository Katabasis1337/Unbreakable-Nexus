<!DOCTYPE html>
<?php
session_start();
if (isset($_SESSION["user"])) {
   header("Location: index.php");
}
?>
<html lang="hu">
  <head>
      <meta charset="UTF-8">
      <title>UN - Register</title>
      <link rel="icon" href="img/icon.ico">
      <meta name='description' content='Unbreakable Nexus weboldal'>
      <meta name='author' content='Föőr Tamás Dániel, Molnár Elek Péter, Nyikon Nándor'>
      <meta name='owner' content='érett fiatalok'>
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
      <link rel="stylesheet" href="style.css">
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  </head>
  <body>
  <div class="container" id="main">
      <div class="row justify-content-center">
          <div class="col-md-6">
            <?php
            if (isset($_POST["registerSubmit"])) {
               $felhasznalonev = $_POST["username"];
               $jelszo = $_POST["password"];
               $jelszoUjra = $_POST["repassword"];

               $passwordHash = password_hash($jelszo, PASSWORD_DEFAULT);

               $hibaüzenet = array();

               if (empty($felhasznalonev) OR empty($jelszo) OR empty($jelszoUjra)) {
                array_push($hibaüzenet,"Töltsd ki az összes mezőt!");
               }
               if (strlen($jelszo)<5) {
                array_push($hibaüzenet,"A jelszónak minimum 5 karaktert kell tartalmaznia!");
               }
               if ($jelszo!==$jelszoUjra) {
                array_push($hibaüzenet,"A jelszavak nem egyeznek!");
               }
               if (!preg_match('/^[a-zA-Z0-9]+$/', $felhasznalonev)) {
                $hibasKar = preg_replace('/[a-zA-Z0-9]/', '', $felhasznalonev);
                array_push($hibaüzenet,"Helytelen karakter a felhasználónévben! (" . $hibasKar . ")");
               }
               require_once "database.php";
               $sql = "SELECT * FROM users WHERE username = '$felhasznalonev'";
               $result = mysqli_query($conn, $sql);
               $rowCount = mysqli_num_rows($result);
               if ($rowCount>0) {
                array_push($hibaüzenet,"Ez a felhasználónév már regisztrálva van!");
               }
               if (count($hibaüzenet)>0) {
                foreach ($hibaüzenet as $hiba) {
                    echo '<div class="alert error-box">'.$hiba.'</div>';
                }
               }else{

                /*
                $value1 = 0;
                $value2 = 0;
                $idsql = "SELECT * FROM users WHERE username = '$felhasznalonev'";
                $result = mysqli_query($conn, $idsql);
                $userid = mysqli_fetch_array($result, MYSQLI_ASSOC);
                if ($userid) {
                  $id = $userid["id"];
                }
                $sql_userstats = "INSERT INTO userstats (id, diamonds, spentdiamonds) VALUES (?, ?, ?)";
                $stmt_userstats = mysqli_stmt_init($conn);
                $prepareStmt_userstats = mysqli_stmt_prepare($stmt_userstats,$sql_userstats);
                if ($prepareStmt_userstats) {
                    mysqli_stmt_bind_param($stmt_userstats,"sss",$id,$value1,$value2);
                    mysqli_stmt_execute($stmt_userstats);
                }
                */
                $sql = "INSERT INTO users (username, password) VALUES ( ?, ?)";
                $stmt = mysqli_stmt_init($conn);
                $prepareStmt = mysqli_stmt_prepare($stmt,$sql);
                if ($prepareStmt) {
                    mysqli_stmt_bind_param($stmt,"ss",$felhasznalonev, $passwordHash);
                    mysqli_stmt_execute($stmt);
                    echo '<div class="alert valid-box">Sikeres regisztráció!</div>';
                }else{
                    echo '<div class="alert error-box">SQL ERROR!</div>';
                }
               }
            }
            ?>
              <form class="p-4" id="register-form" action="register.php" method="post">
                  <img src="img/logo.png" class="mb-4" alt="logo" width="300">
                  <div class="form-group">
                      <input type="text" id="un" class="form-control" placeholder="&#xf007; Felhasználónév" name="username" required>
                  </div>
                  <div class="form-group">
                      <input type="password" id="pass" class="form-control" placeholder="&#xf023; Jelszó" name="password" required>
                  </div>
                  <div class="form-group">
                      <input type="password" id="pass" class="form-control" placeholder="&#xf01e; Jelszó (újra)" name="repassword" required>
                  </div>
                  <button type="submit" id="registerGomb" name="registerSubmit"><i class="fa fa-user-plus" id="register_icon" aria-hidden="true"></i> Regisztráció</button>
                  <p class="mt-5 text-center" id="regtext">Esetleg már regisztráltál? <a href="login.php">Kattints ide!</a></p>
              </form>
          </div>
      </div>
  </div>
  <div class="container-fluid text-center mt-5">
      <div class="row">
          <div class="col-md-12 col-sm-12">
              <p class="h2 lead" id="loginctext">© 2024 érett fiatalok</p>
          </div>
      </div>
  </div>
  </body>
</html>
