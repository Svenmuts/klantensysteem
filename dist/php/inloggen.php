<?php
include 'data.php'; // Hier laad je je verbindingsgegevens

// Maak verbinding met de database
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error); // Stop de uitvoering als er een verbindingsfout is
}

// Controleer of het formulier is ingediend

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['gebruikersnaam'], $_POST['wachtwoord'])) {
        $gebruikersnaam = $_POST['gebruikersnaam'];
        $wachtwoord = $_POST['wachtwoord'];

        $stmt = $conn->prepare("SELECT * FROM medewerkers WHERE gebruikersnaam = ?");
        if ($stmt === false) {
            die("Failed to prepare statement: " . $conn->error);
        }

        $stmt->bind_param("s", $gebruikersnaam);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($wachtwoord, $user['wachtwoord_hash'])) {
            // Wachtwoord is correct, start een nieuwe sessie en sla de gebruikersnaam van de gebruiker op in de sessie
            session_start();
            $_SESSION['gebruikersnaam'] = $gebruikersnaam;
            header("Location: succes.php"); // Stuur de gebruiker door naar de homepage
        } else {
            echo "Inloggen mislukt!";
        }
    } else {
        echo "Form data is not set";
    }
}
echo "<a href='../index.html'>Terug naar de homepage</a>";

