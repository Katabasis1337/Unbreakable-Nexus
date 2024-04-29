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
      <title>UN - Login</title>
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
            if (isset($_POST["loginSubmit"])) {
               $felhasznalonev = $_POST["username"];
               $jelszo = $_POST["password"];
                require_once "database.php";
                $sql = "SELECT users.id,username,password,diamonds,spentdiamonds FROM users JOIN userstats ON users.id = userstats.id WHERE username = '$felhasznalonev'";
                $result = mysqli_query($conn, $sql);
                $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
                if ($user) {
                    if (password_verify($jelszo, $user["password"])) {
                        session_start();
                        $_SESSION["user"] = "yes";
						            $_SESSION["felhasznalo"] = $felhasznalonev;
                        $_SESSION["dia"] = $user["diamonds"];
                        $_SESSION["spentdia"] = $user["spentdiamonds"];
                        $id = $user["id"];
                        header("Location: index.php");
                        die();
                    }else{
                        echo '<div class="alert error-box">Hibás jelszó!</div>';
                    }
                }else{
                    echo '<div class="alert error-box">Hibás felhasználónév!</div>';
                }

            }
            ?>
              <form class="p-4" id="login-form" action="login.php" method="post">
                  <img src="img/logo.png" class="mb-4" alt="logo" width="300">
                  <div class="form-group">
                      <input type="text" id="un" class="form-control" placeholder="&#xf007; Felhasználónév" name="username">
                  </div>
                  <div class="form-group">
                      <input type="password" id="pass" class="form-control" placeholder="&#xf023; Jelszó" name="password">
                  </div>
                  <button type="submit" id="loginGomb" name="loginSubmit"><i class="fa fa-sign-in" id="login_icon" aria-hidden="true"></i> Bejelentkezés</button>
                  <p class="mt-5 text-center" id="regtext">Regisztrálnál? <a href="register.php">Kattints ide!</a></p>
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
