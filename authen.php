<?php
session_start();

// Inclure le fichier de connexion à la base de données
require('connect.php');

// Vérifier si le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier le type de connexion
    if ($_POST['type'] == 'admin') {
        // Vérifier les informations d'identification de l'administrateur
        $admin_email = $_POST['email'];
        $admin_password = $_POST['password'];

        // Requête pour vérifier les informations d'identification de l'administrateur
        $sql = "SELECT * FROM admins WHERE email = :email AND mdp = :password";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $admin_email);
        $stmt->bindParam(':password', $admin_password);
        $stmt->execute();
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin) {
            // Authentification réussie pour l'administrateur
            $_SESSION['user_type'] = 'admin';
            header("Location: administration.php");
            exit;
        } else {
            // Identifiants incorrects pour l'administrateur
            $error = "Identifiants incorrects pour l'administrateur.";
        }
    } elseif ($_POST['type'] == 'user') {
        // Vérifier les informations d'identification de l'utilisateur
        $user_email = $_POST['email'];
        $user_password = $_POST['password'];
    
        // Requête pour vérifier les informations d'identification de l'utilisateur dans etud3a
        $sql_etud3a = "SELECT * FROM etud3a WHERE email = :email AND mdp = :password";
        $stmt_etud3a = $conn->prepare($sql_etud3a);
        $stmt_etud3a->bindParam(':email', $user_email);
        $stmt_etud3a->bindParam(':password', $user_password);
        $stmt_etud3a->execute();
        $user_etud3a = $stmt_etud3a->fetch(PDO::FETCH_ASSOC);
    
        // Requête pour vérifier les informations d'identification de l'utilisateur dans etud4a
        $sql_etud4a = "SELECT * FROM etud4a WHERE email = :email AND mdp = :password";
        $stmt_etud4a = $conn->prepare($sql_etud4a);
        $stmt_etud4a->bindParam(':email', $user_email);
        $stmt_etud4a->bindParam(':password', $user_password);
        $stmt_etud4a->execute();
        $user_etud4a = $stmt_etud4a->fetch(PDO::FETCH_ASSOC);
    
        if ($user_etud3a) {
            // Authentification réussie pour l'utilisateur depuis etud3a
            $_SESSION['user_type'] = 'user';
            $_SESSION['user_email'] = $user_email; // Stockez l'email de l'utilisateur dans la session
            header("Location: recap.php");
            exit;
        } elseif ($user_etud4a) {
            // Authentification réussie pour l'utilisateur depuis etud4a
            $_SESSION['user_type'] = 'user';
            $_SESSION['user_email'] = $user_email; // Stockez l'email de l'utilisateur dans la session
            header("Location: recap.php");
            exit;
        } else {
            // Identifiants incorrects pour l'utilisateur
            $error = "Identifiants incorrects pour l'utilisateur.";
        }
    }}
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authentification</title>
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
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 300px;
        }
        h2 {
            text-align: center;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="email"],
        input[type="password"],
        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            width: 100%;
            background-color: #007bff;
            color: white;
            padding: 10px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .error {
            color: #ff0000;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Authentification</h2>
        <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="type">Type de connexion:</label>
            <select name="type" id="type">
                <option value="admin">Administrateur</option>
                <option value="user">Utilisateur</option>
            </select>
            <label for="email">Email:</label>
            <input type="email" name="email" required>
            <label for="password">Mot de passe:</label>
            <input type="password" name="password" required>
            <input type="submit" value="Connexion">
        </form>
    </div>
</body>
</html>
