<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription au concours</title>
    <link rel="stylesheet" href="inscriptionstyle.css">
</head>
<body>
    <h2>Inscription au concours</h2>
    <h2>ENSA Marrakech</h2>
    <form action="traitement_inscr2.php" method="post" enctype="multipart/form-data">
        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" required><br><br>
        
        <label for="prenom">Prénom :</label>
        <input type="text" id="prenom" name="prenom" required><br><br>
        
        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required><br><br>
        
        <label for="naissance">Date de naissance :</label>
        <input type="date" id="naissance" name="naissance" required><br><br>
        
        <label for="diplome">Diplôme :</label>
        <select id="diplome" name="diplome" required>
            <option value="Bac+2">Bac+2</option>
            <option value="Bac+3">Bac+3</option>
        </select><br><br>
        
        <label for="niveau">Niveau :</label>
        <select id="niveau" name="niveau" required>
            <option value="3ème année">3ème année</option>
            <option value="4ème année">4ème année</option>
        </select><br><br>
        
        <label for="etablissement">Établissement d'origine :</label>
        <input type="text" id="etablissement" name="etablissement" required><br><br>
        
        <label for="photo">Photo d'identité (JPG, PNG, JPEG) :</label>
        <input type="file" id="photo" name="photo" accept="image/png, image/jpeg" required><br><br>
        
        <label for="cv">CV (PDF) :</label>
        <input type="file" id="cv" name="cv" accept="application/pdf" required><br><br><br>
        
        <h4>Création de votre compte : </h4><br>
        <label for="log">Login :</label>
        <input type="text" id="log" name="log" required><br><br>
        
        <label for="mdp">Mot de passe :</label>
        <input type="password" id="mdp" name="mdp" required><br><br>
        
        <input type="submit" value="S'inscrire">
    </form>
</body>
</html>
