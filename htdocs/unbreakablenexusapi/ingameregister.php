<?php
$servername = "localhost";
$serverusername = "root";
$serverpassword = "";
$dbname = "unbreakablenexusdb";

if (empty($_POST['username'])==false or empty($_POST['password'])==false) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $conn = new mysqli($servername, $serverusername, $serverpassword, $dbname);
    if ($conn->connect_error) {
        echo "003"; // Hibakód: 003 SQL Hiba
        exit();
    }
    
    // Dupe check
    $sql = "SELECT id FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        echo "002"; // Hibakód: 002 Név foglalt
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $username, $hashedPassword);
    
        if ($stmt->execute()) {
            echo "001"; // Sikeres regisztráció
        } else {
            echo "004"; // Hibakód: 004 Egyéb hiba
        }
    }
    
    // Kapcsolat lezárása
    $stmt->close();
    $conn->close();    
} 
else {
    echo "005"; // Hibakód: 005 Hiányzó adatok
    exit();
}

?>