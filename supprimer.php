<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_email'])) {
    // Rediriger vers la page d'authentification si l'utilisateur n'est pas connecté
    header("Location: authen.php");
    exit;
}

// Inclure le fichier de connexion à la base de données
require('connect.php');

// Récupérer l'email de l'utilisateur
$email = $_SESSION['user_email'];

// Requête pour supprimer l'utilisateur de la table etud3a
$sql_delete_etud3a = "DELETE FROM etud3a WHERE email = :email";
$stmt_delete_etud3a = $conn->prepare($sql_delete_etud3a);
$stmt_delete_etud3a->bindParam(':email', $email);
$stmt_delete_etud3a->execute();

// Requête pour supprimer l'utilisateur de la table etud4a
$sql_delete_etud4a = "DELETE FROM etud4a WHERE email = :email";
$stmt_delete_etud4a = $conn->prepare($sql_delete_etud4a);
$stmt_delete_etud4a->bindParam(':email', $email);
$stmt_delete_etud4a->execute();

// Détruire la session de l'utilisateur pour le déconnecter
session_destroy();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suppression du Compte</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            text-align: center;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 300px;
        }

        h2 {
            margin-top: 0;
        }

        p {
            margin-bottom: 20px;
        }

        a {
            text-decoration: none;
            color: #4caf50;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Suppression du Compte</h2>
        <p>Votre compte a été supprimé avec succès.</p>
        <a href="authen.php">Se Connecter</a>
    </div>
</body>
</html>
