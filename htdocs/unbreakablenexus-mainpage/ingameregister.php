<?php

// Adatbázis kapcsolat beállítása
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "unbreakablenexusdb";

// Felhasználónevet és jelszót fogadjuk a POST kérésből
$username = $_POST['username'];
$password = $_POST['password'];

// Kapcsolat létrehozása az adatbázissal
$conn = new mysqli($servername, $username, $password, $dbname);

// Kapcsolat ellenőrzése
if ($conn->connect_error) {
    // Hiba történt a kapcsolódás során
    echo "003"; // Hibakód: 003
    exit();
}

// Ellenőrizzük, hogy van-e már ilyen felhasználónév az adatbázisban
$sql = "SELECT id FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    // Ha már létezik ilyen felhasználónév, küldünk vissza egy 002-es hibakódot
    echo "002"; // Hibakód: 002 (már foglalt felhasználónév)
} else {
    // Ha nincs ilyen felhasználónév, végrehajtjuk a regisztrációt
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $hashedPassword);

    if ($stmt->execute()) {
        // Sikeres regisztráció, küldünk vissza egy 001-es kódot
        echo "001"; // Sikeres regisztráció
    } else {
        // Hiba történt a regisztráció során
        echo "003"; // Hibakód: 003
    }
}

// Kapcsolat lezárása
$stmt->close();
$conn->close();

?>
