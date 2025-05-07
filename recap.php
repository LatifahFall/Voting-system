<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Utilisateur</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .profile-info {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 600px;
            margin: 0 auto;
            position: relative; /* Set the position of the parent container to relative */
        }

        h2 {
            margin-top: 0;
            margin-bottom: 20px;
            color: #333;
        }

        p {
            margin: 10px 0;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4caf50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .button.delete {
            background-color: #f44336;
        }

        .button:hover {
            background-color: #45a049;
        }

        .button.delete:hover {
            background-color: #d32f2f;
        }

        .error-message {
            color: #f44336;
        }

        .profile-picture-container {
            position: absolute; /* Position the profile picture container absolutely */
            top: 0; /* Align the top edge of the profile picture container with the top edge of the parent container */
            right: 0; /* Align the right edge of the profile picture container with the right edge of the parent container */
            margin: 20px; /* Add some margin for spacing */
        }

        .profile-picture-container img {
            max-width: 100%;
            height: auto;
            border-radius: 4px;
        }
    </style>
</head>
<body>

<?php
require_once('fpdf.php');
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

// Requête pour vérifier l'utilisateur dans la table etud3a
$sql_etud3a = "SELECT * FROM etud3a WHERE email = :email";
$stmt_etud3a = $conn->prepare($sql_etud3a);
$stmt_etud3a->bindParam(':email', $email);
$stmt_etud3a->execute();
$user_etud3a = $stmt_etud3a->fetch(PDO::FETCH_ASSOC);

// Vérifier si l'utilisateur est trouvé dans la table etud3a
if ($user_etud3a) {
    // Afficher les informations de l'utilisateur depuis etud3a
    echo "<h1>ENSA MARRAKECH</h1>";
    echo "<h2>Informations personnelles</h2>";
    echo "<div class='profile-info'>";
    echo "<p><strong>Nom d'utilisateur:</strong> " . $user_etud3a['log'] . "</p>";
    echo "<p><strong>Nom:</strong> " . $user_etud3a['nom'] . "</p>";
    echo "<p><strong>Prénom:</strong> " . $user_etud3a['prenom'] . "</p>";
    echo "<p><strong>Email:</strong> " . $user_etud3a['email'] . "</p>";
    echo "<p><strong>Date de naissance:</strong> " . $user_etud3a['naissance'] . "</p>";
    echo "<p><strong>Etablissement:</strong> " . $user_etud3a['etablissement'] . "</p>";
    echo "<p><strong>Diplome:</strong> " . $user_etud3a['diplome'] . "</p>";
    echo "<p><strong>Niveau:</strong> " . $user_etud3a['niveau'] . "</p>";
    
    // Display profile picture on the right
    echo "<div class='profile-picture-container' style='float: right;'>";
    echo "<p><strong>Photo d'identité :</strong> <br><img src='" . $user_etud3a['photo'] . "' alt='Profile Picture' style='max-width: 200px;'></p>";
    echo "</div>";

    // Display CV
    echo "<p><strong>CV :</strong> <br><a href='" . $user_etud3a['cv'] . "' target='_blank'>Télécharger CV</a></p>";

    // Ajouter un bouton pour télécharger le PDF
    echo "<div class='button-container'>";
    echo "<a class='button download' href='generate_pdf.php'>Télécharger PDF</a>";
    echo "</div>";
    
    // Ajouter un bouton pour modifier les informations personnelles
    echo "<div class='button-container'>";
    echo "<a class='button modify' href='modifier_infos.php'>Modifier mes informations personnelles</a>";
    echo "</div>";
    
    // Ajouter un bouton pour supprimer le compte
    echo "<div class='button-container'>";
    echo "<a class='button delete' href='supprimer.php'>Supprimer mon compte</a>";
    echo "</div>";
    echo "</div>";
} else {
    // L'utilisateur n'est pas trouvé dans la table etud3a, vérifier dans la table etud4a
    $sql_etud4a = "SELECT * FROM etud4a WHERE email = :email";
    $stmt_etud4a = $conn->prepare($sql_etud4a);
    $stmt_etud4a->bindParam(':email', $email);
    $stmt_etud4a->execute();
    $user_etud4a = $stmt_etud4a->fetch(PDO::FETCH_ASSOC);

    // Vérifier si l'utilisateur est trouvé dans la table etud4a
    if ($user_etud4a) {
        // Afficher les informations de l'utilisateur depuis etud4a
        echo "<h1>ENSA MARRAKECH</h1>";
        echo "<h2>Informations personnelles</h2>";
        echo "<div class='profile-info'>";
        echo "<p><strong>Nom d'utilisateur:</strong> " . $user_etud4a['log'] . "</p>";
        echo "<p><strong>Nom:</strong> " . $user_etud4a['nom'] . "</p>";
        echo "<p><strong>Prénom:</strong> " . $user_etud4a['prenom'] . "</p>";
        echo "<p><strong>Email:</strong> " . $user_etud4a['email'] . "</p>";
        echo "<p><strong>Date de naissance:</strong> " . $user_etud4a['naissance'] . "</p>";
        echo "<p><strong>Etablissement:</strong> " . $user_etud4a['etablissement'] . "</p>";
        echo "<p><strong>Diplome:</strong> " . $user_etud4a['diplome'] . "</p>";
        echo "<p><strong>Niveau:</strong> " . $user_etud4a['niveau'] . "</p>";

        // Display profile picture on the right
        echo "<div class='profile-picture-container' style='float: right;'>";
        echo "<p><strong>Photo d'identité :</strong> <br><img src='" . $user_etud4a['photo'] . "' alt='Profile Picture' style='max-width: 200px;'></p>";
        echo "</div>";

        // Display CV
        echo "<p><strong>CV :</strong> <br><a href='" . $user_etud4a['cv'] . "' target='_blank'>Télécharger CV</a></p>";
                // Ajouter un bouton pour télécharger le PDF
                echo "<div class='button-container'>";
                echo "<a class='button download' href='generate_pdf.php'>Télécharger PDF</a>";
                echo "</div>";
                
                // Ajouter un bouton pour modifier les informations personnelles
                echo "<div class='button-container'>";
                echo "<a class='button modify' href='modifier_infos.php'>Modifier mes informations personnelles</a>";
                echo "</div>";
                
                // Ajouter un bouton pour supprimer le compte
                echo "<div class='button-container'>";
                echo "<a class='button delete' href='supprimer.php'>Supprimer mon compte</a>";
                echo "</div>";
                echo "</div>";
            } else {
                // Utilisateur introuvable dans les deux tables
                echo "<p class='error-message'>Utilisateur introuvable.</p>";
            }
        }
        ?> 

</body>
</html>

