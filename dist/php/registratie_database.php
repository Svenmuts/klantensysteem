<?php
include 'data.php'; // Hier laad je je verbindingsgegevens

// Maak verbinding met de database
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error); // Stop de uitvoering als er een verbindingsfout is
}

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if form data is set
    if (!isset($_POST['voornaam'], $_POST['tussenvoegsel'], $_POST['achternaam'], $_POST['gebruikersnaam'], $_POST['wachtwoord_hash'], $_POST['email'])) {
        die("Form data is not set");
    }

    // Maak een query die de gegevens in de tabel zet
    $hashedPassword = password_hash($_POST['wachtwoord_hash'], PASSWORD_DEFAULT); // Hash het wachtwoord

    // Prepare an SQL statement
    $stmt = $conn->prepare("INSERT INTO medewerkers (voornaam, tussenvoegsel, achternaam, gebruikersnaam, wachtwoord_hash, email) VALUES (?, ?, ?, ?, ?, ?)");

    // Check if the statement was prepared successfully
    if ($stmt === false) {
        die("Failed to prepare statement: " . $conn->error);
    }

    // Bind parameters
    $stmt->bind_param("ssssss", $_POST['voornaam'], $_POST['tussenvoegsel'], $_POST['achternaam'], $_POST['gebruikersnaam'], $hashedPassword, $_POST['email']);

    // Execute the statement
    if ($stmt->execute()) {
        echo "registratie succesvol!";
        echo "<br>";
    } else {
        echo "Error: " . $stmt->error; // Stop de uitvoering als er een fout is
    }
}

echo "<a href='../index.html'>Terug naar de homepage</a>";

// Sluit de verbinding
$conn->close();
?>

