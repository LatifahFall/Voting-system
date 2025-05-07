<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_email'])) {
    // Redirect to the authentication page if the user is not logged in
    header("Location: authen.php");
    exit;
}

// Include the database connection file
require('connect.php');

// Get the user's email
$email = $_SESSION['user_email'];

// Get the current user's information
$sql_etud3a = "SELECT * FROM etud3a WHERE email = :email";
$stmt_etud3a = $conn->prepare($sql_etud3a);
$stmt_etud3a->bindParam(':email', $email);
$stmt_etud3a->execute();
$user_etud3a = $stmt_etud3a->fetch(PDO::FETCH_ASSOC);
$user_etud4a = null;

// If the user's information is not found in etud3a, try to find it in etud4a
if (!$user_etud3a) {
    $sql_etud4a = "SELECT * FROM etud4a WHERE email = :email";
    $stmt_etud4a = $conn->prepare($sql_etud4a);
    $stmt_etud4a->bindParam(':email', $email);
    $stmt_etud4a->execute();
    $user_etud4a = $stmt_etud4a->fetch(PDO::FETCH_ASSOC);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the new information from the form
    $new_nom = $_POST['nom'] ?? '';
    $new_prenom = $_POST['prenom'] ?? '';
    $new_email = $_POST['email'] ?? '';
    $new_niveau = $_POST['niveau'] ?? '';
    $new_etablissement = $_POST['etablissement'] ?? '';
    $new_date_naissance = isset($_POST['naissance']) ? $_POST['naissance'] : '';
    $new_login = $_POST['log'] ?? '';
    $new_mdp = $_POST['mdp'] ?? '';

    // Update the user's information
    if ($user_etud3a) {
        $sql_update = "UPDATE etud3a SET nom = :nom, prenom = :prenom, email = :email, etablissement = :etablissement, naissance = :naissance, log = :log, mdp = :mdp WHERE email = :email";
    } elseif ($user_etud4a) {
        $sql_update = "UPDATE etud4a SET nom = :nom, prenom = :prenom, email = :email, etablissement = :etablissement, naissance = :naissance, log = :log, mdp = :mdp WHERE email = :email";
    }
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bindParam(':nom', $new_nom);
    $stmt_update->bindParam(':prenom', $new_prenom);
    $stmt_update->bindParam(':email', $new_email);
    $stmt_update->bindParam(':etablissement', $new_etablissement);
    $stmt_update->bindParam(':naissance', $new_date_naissance);
    $stmt_update->bindParam(':log', $new_login);
    $stmt_update->bindParam(':mdp', $new_mdp);
    $stmt_update->execute();

    // Redirect to a confirmation or profile page
    header("Location: recap.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Mes Informations</title>
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

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"],
        input[type="date"],
        select {
            width: calc(100% - 20px);
            padding: 8px;
            margin-bottom: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        select {
            width: 100%;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            text-transform: uppercase;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Modifier Informations Personnelles</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="nom">Nom:</label>
            <input type="text" name="nom" value="<?php echo $user_etud3a['nom'] ?? $user_etud4a['nom']; ?>" required><br><br>
            <label for="prenom">Prénom:</label>
            <input type="text" name="prenom" value="<?php echo $user_etud3a['prenom'] ?? $user_etud4a['prenom']; ?>" required><br><br>
            <label for="email">Email:</label>
            <input type="email" name="email" value="<?php echo $user_etud3a['email'] ?? $user_etud4a['email']; ?>" required><br><br>
            <label for="niveau">Niveau:</label>
            <select name="niveau">
                <option value="3eme année" <?php echo isset($user_etud3a) ? 'selected' : ''; ?>>3eme année</option>
                <option value="4eme année" <?php echo isset($user_etud4a) ? 'selected' : ''; ?>>4eme année</option>
            </select><br><br>
            <label for="etablissement">Etablissement:</label>
            <input type="text" name="etablissement" value="<?php echo $user_etud3a['etablissement'] ?? $user_etud4a['etablissement']; ?>"><br><br>
            <label for="naissance">Date de Naissance:</label>
            <input type="date" name="naissance" value="<?php echo $user_etud3a['naissance'] ?? $user_etud4a['naissance']; ?>"><br><br>
            <label for="log">Login:</label>
            <input type="text" name="log" value="<?php echo $user_etud3a['log'] ?? $user_etud4a['log']; ?>"><br><br>
            <label for="mdp">Mot de Passe:</label>
            <input type="password" name="mdp" value="<?php echo $user_etud3a['mdp'] ?? $user_etud4a['mdp']; ?>"><br><br>

            <input type="submit" value="Enregistrer">
        </form>
    </div>
</body>
</html>