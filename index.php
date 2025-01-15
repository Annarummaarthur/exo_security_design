<?php
session_start();

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de Contact Sécurisé</title>
    <link rel="stylesheet" href="styles.css">
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $('form').submit(function (event) {
                event.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                    type: 'POST',
                    url: 'form_process.php',
                    data: formData,
                    success: function (response) {
                        $('#response').html(response);

                        if (response.includes('Votre message a été envoyé avec succès !')) {
                            $('form')[0].reset();
                        }
                    },
                    error: function () {
                        $('#response').html('<p class="error">Une erreur est survenue, veuillez réessayer.</p>');
                    }
                });
            });
        });
    </script>
</head>
<body>
    <div>
        <h1>Formulaire de Contact Sécurisé</h1>
        <form method="POST">
            <label for="name">Nom :</label>
            <input type="text" id="name" name="name" required minlength="3" maxlength="50">

            <label for="email">Email :</label>
            <input type="email" id="email" name="email" required>

            <label for="message">Message :</label>
            <textarea id="message" name="message" required minlength="10" maxlength="500"></textarea>
            
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">

            <button type="submit">Envoyer</button>
        </form>

        <div id="response"></div>
    </div>
</body>
</html>
