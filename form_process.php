<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        echo '<p class="error">Échec : Token CSRF invalide.</p>';
        exit;
    }

    require 'db_config.php';

    $name = htmlspecialchars(trim($_POST['name']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $message = htmlspecialchars(trim($_POST['message']));

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo '<p class="error">Échec : Email invalide.</p>';
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO contacts (name, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $message);

    if ($stmt->execute()) {
        echo '<p class="success">Votre message a été envoyé avec succès !</p>';
    } else {
        echo "<p class='error'>Erreur lors de l'envoi du message.</p>";
    }

    $stmt->close();
    $conn->close();
}
?>
