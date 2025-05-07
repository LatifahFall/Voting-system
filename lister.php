<?php
// Vérifier si l'utilisateur est connecté en tant qu'admin
session_start();
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    // Rediriger vers la page d'authentification si l'utilisateur n'est pas un admin
    header("Location: authen.php");
    exit;
}

// Inclure le fichier de connexion à la base de données
require('connect.php');

// Récupérer toutes les inscriptions depuis la table etud3a
$sql_etud3a = "SELECT * FROM etud3a";
$stmt_etud3a = $conn->query($sql_etud3a);
$inscriptions_etud3a = $stmt_etud3a->fetchAll(PDO::FETCH_ASSOC);

// Récupérer toutes les inscriptions depuis la table etud4a
$sql_etud4a = "SELECT * FROM etud4a";
$stmt_etud4a = $conn->query($sql_etud4a);
$inscriptions_etud4a = $stmt_etud4a->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des inscriptions - ENSA Marrakech</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        h1 {
            color: #333;
            margin-top: 0;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>ENSA Marrakech - Liste des inscriptions</h1>

        <h2>3ème année</h2>
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Email</th>
                    <th>Naissance</th>
                    <th>Diplôme</th>
                    <th>Etablissement</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($inscriptions_etud3a as $inscription): ?>
                <tr>
                    <td><?php echo $inscription['nom']; ?></td>
                    <td><?php echo $inscription['prenom']; ?></td>
                    <td><?php echo $inscription['email']; ?></td>
                    <td><?php echo $inscription['naissance']; ?></td>
                    <td><?php echo $inscription['diplome']; ?></td>
                    <td><?php echo $inscription['etablissement']; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h2>4ème année</h2>
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Email</th>
                    <th>Naissance</th>
                    <th>Diplôme</th>
                    <th>Etablissement</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($inscriptions_etud4a as $inscription): ?>
                <tr>
                    <td><?php echo $inscription['nom']; ?></td>
                    <td><?php echo $inscription['prenom']; ?></td>
                    <td><?php echo $inscription['email']; ?></td>
                    <td><?php echo $inscription['naissance']; ?></td>
                    <td><?php echo $inscription['diplome']; ?></td>
                    <td><?php echo $inscription['etablissement']; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
