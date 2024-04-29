<?php
session_start();
if (!isset($_SESSION["user"])) {
   header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="hu">
	<head>
		<meta charset="UTF-8">
		<link rel="icon" href="img/icon.ico">
		<meta name='description' content='Unbreakable Nexus weboldal'>
		<meta name='author' content='Föőr Tamás Dániel, Molnár Elek Péter, Nyikon Nándor'>
		<meta name='owner' content='érett fiatalok'>
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<meta charset="utf-8">
		<link rel="stylesheet" href="style.css">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<title>UN - Dashboard</title>
		<script>
			function kij() {
			window.location.href = "logout.php";
			}
		</script>
	</head>
	<body>
	  <div class="container-fluid" id="navbar">
		<div class="row">
			  <div class="col-md-4">
				<img src="img/logo.png" class="" alt="logo">
			  </div>
			  <div class="col-md-4 text-center">
				<p class="mt-3" id="udv">Üdvözöllek, <span><?php echo $_SESSION['felhasznalo']; ?></span>!</p>
				<button id="logoutGomb" class="ml-3" onClick="kij()"><i class="fa fa-key" id="logout_icon" aria-hidden="true"></i> Kijelentkezés</button>
			  </div>
			  <div class="col-md-4 mt-5">
          <form method="POST">
  				<input type="text" id="kereses" class="text-center ml-5" name="keresettUser" placeholder="&#xf0c0; Felhasználó keresése">
  				<button id="searchGomb" method="POST" type="submit" name="searchGomb"><i class="fa fa-search" id="search_icon" aria-hidden="true"></i> Keresés</button>
          </form>
          <div id="searchResult" style="display: none; margin-left:65px;margin-top:15px; color: red;"></div>
			  </div>
		</div>
		<hr>
	<div class="container-fluid my-4" id="panel">
		<div class="row">
			<div class="col-lg-6 text-center" id="vertical-line">
				<h1 class="mb-3" id="maintext"><i class="fa fa-area-chart" aria-hidden="true"></i> Statisztika</h1>
				<p class="h2 lead" id="user_name"><img src="img/user_icon.png" id="user-icon"> Felhasználónév: <?php echo $_SESSION['felhasznalo']; ?></p>
        <p class="h2 lead" id="diamonds"><img src="img/diamond.png" id="diamond-icon"> Gyémántegyenleg: <?php echo $_SESSION['dia']; ?></p>
				<p class="h2 lead" id="sdiamonds"><img src="img/spent_diamonds.png" id="diamond-icon"> Elköltött gyémántok: <?php echo $_SESSION['spentdia']; ?></p>
			</div>
			<div class="col-lg-6 text-center" id="news">
			<h1 class="mb-3" id="maintext"><i class="fa fa-question-circle" aria-hidden="true"></i> Információk</h1>
				<div class="newsItem">
					<blockquote class="blockquote">
					  <p class="mb-0">Az „Unbreakable Nexus” egy stratégiai „idle tower defense”, magyarul torony védelmi játék, amit rengeteg más ehhez hasonló „tower defense” játék inspirált. A játék a többihez hasonlóan több nehézségi fokozaton nyújt egy végtelen ellenfélhullámszámú kihívást.</p>
					  <a href="https://github.com/Katabasis1337/Unbreakable-Nexus" target="_blank">Innen lehet letölteni a játékot</a>
					</blockquote>
				</div>
			</div>
		</div>
	</div>
  <div class="container-fluid text-center" id="float-bottom">
      <div class="row">
          <div class="col-md-12 col-sm-12">
            <button id="wikiGomb"><i class="fa fa-wikipedia-w" id="search_icon" aria-hidden="true"></i><a id="wiki-href" href="../wikipedia/index.html">ikipedia</a></button>
              <p class="h2 lead mt-2" id="regtext">© 2024 érett fiatalok</p>
          </div>
      </div>
  </div>
	</body>
</html>
<?php
if (isset($_POST["searchGomb"])) {
    require_once "database.php";
    $keresettnev = $conn->real_escape_string($_POST["keresettUser"]);

    $sql = "SELECT username,diamonds,spentdiamonds FROM users JOIN userstats ON users.id = userstats.id WHERE username LIKE '$keresettnev'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<script>document.getElementById('user_name').innerHTML = ' <img src=\"img/user_icon.png\" id=\"user-icon\"> Felhasználónév: " . $row["username"] . "';</script>";
            echo "<script>document.getElementById('diamonds').innerHTML = ' <img src=\"img/diamond.png\" id=\"diamond-icon\"> Gyémántegyenleg: " . $row["diamonds"] . "';</script>";
            echo "<script>document.getElementById('sdiamonds').innerHTML = ' <img src=\"img/spent_diamonds.png\" id=\"diamond-icon\"> Elköltött gyémántok: " . $row["spentdiamonds"] . "';</script>";
        }
    } else {
        echo "<script>document.getElementById('searchResult').innerHTML = 'Nincs ilyen felhasználó!'; document.getElementById('searchResult').style.display = 'block';</script>";
    }
}
?>
