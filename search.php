<?php
// Include the database connection file
require("connect.php");

// Vérifier si le paramètre de recherche est défini dans la requête GET
if (isset($_GET['query'])) {
    // Nettoyer et sécuriser la valeur de recherche
    $query = htmlspecialchars($_GET['query']);
    
    // Préparer la requête SQL pour rechercher dans les tables etud3a et etud4a
    $sql = "SELECT * FROM etud3a WHERE nom LIKE :query OR prenom LIKE :query 
            UNION 
            SELECT * FROM etud4a WHERE nom LIKE :query OR prenom LIKE :query";
    
    // Préparer la déclaration de la requête
    $stmt = $conn->prepare($sql);
    
    // Liaison des valeurs
    $queryParam = "%$query%"; // Ajouter des wildcards autour de la requête pour correspondre partiellement
    $stmt->bindParam(':query', $queryParam);
    
    // Exécution de la requête
    $stmt->execute();
    
    // Récupérer les résultats de la recherche
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Renvoyer les résultats au format JSON
    header('Content-Type: application/json');
    echo json_encode($results);
} else {
    // Si le paramètre de recherche n'est pas défini, renvoyer une erreur
    echo json_encode(array('error' => 'Le paramètre de recherche est requis.'));
}
?>