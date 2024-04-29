<?php

// Adatbázis kapcsolat beállítása
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "unbreakablenexusdb";

// Felhasználónevet és jelszót fogadjuk a POST kérésből
$usernameInput = $_POST['username'];
$passwordInput = $_POST['password'];

// Adatbázis kapcsolat létrehozása
$conn = new mysqli($servername, $username, $password, $dbname);

// Kapcsolat ellenőrzése
if ($conn->connect_error) {
    die("Kapcsolódási hiba: " . $conn->connect_error);
}

// Felhasználó ellenőrzése az adatbázisban
$sql = "SELECT id, username, password FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $usernameInput);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Felhasználó létezik, ellenőrizzük a jelszót
    $row = $result->fetch_assoc();
    $storedPasswordHash = $row['password'];

    // Jelszó ellenőrzése
    if (password_verify($passwordInput, $storedPasswordHash)) {
        // Jelszó helyes, küldjük vissza az id-t
        echo $row['id'];
    } else {
        // Hibás jelszó
        echo "001"; // Hibakód: 001
    }
} else {
    // Hibás felhasználónév
    echo "002"; // Hibakód: 002
}

$stmt->close();
$conn->close();

?>
