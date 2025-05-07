<?php
// administration.php

// Vérifier si l'utilisateur est connecté en tant qu'administrateur
session_start();
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté en tant qu'administrateur
    header("Location: authen.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration - Concours ENSA Marrakech</title>
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

        h2 {
            margin-top: 0;
        }

        .button {
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

        .button:hover {
            background-color: #45a049;
        }

        #search {
            margin-bottom: 20px;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
            width: 300px;
        }

        #loader {
            display: none;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            $("#search").on("keyup", function() {
                var query = $(this).val();
                if(query !== ''){
                    $.ajax({
                        url: "search.php",
                        method: "POST",
                        data: {query: query},
                        beforeSend:function(){
                            $("#loader").show();
                        },
                        success:function(data){
                            $("#loader").hide();
                            $("#result").html(data);
                        }
                    });
                } else {
                    $("#result").empty();
                }
            });
        });
    </script>
</head>
<body>
<div class="container">
    <h1>ENSA MARRAKECH</h1>
    <h2>Bonjour, admin</h2>
    <input type="text" id="searchInput" onkeyup="searchCandidates()" placeholder="Rechercher...">
    <div id="searchResults"></div>
    <button class="button" onclick="window.location.href='lister.php'">Lister les inscriptions</button>
</div>

<script>
// Cette fonction est appelée lorsqu'un utilisateur tape dans le champ de recherche
function searchCandidates() {
    // Récupérer la valeur du champ de recherche
    var query = document.getElementById("searchInput").value;

    // Création de l'objet XMLHttpRequest
    var xhr = new XMLHttpRequest();

    // Spécification de la méthode GET et de l'URL avec le paramètre de recherche
    xhr.open("GET", "search.php?query=" + encodeURIComponent(query), true);

    // Définition de la fonction de rappel pour gérer la réponse
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            // Afficher les résultats de la recherche dans la page
            displaySearchResults(response);
        }
    };

    // Envoi de la requête
    xhr.send();
}

// Cette fonction affiche les résultats de la recherche dans la page
function displaySearchResults(results) {
    var searchResultsDiv = document.getElementById("searchResults");
    searchResultsDiv.innerHTML = ''; // Effacer les résultats précédents

    // Générer le HTML des résultats
    var html = "<h3>Résultats de la recherche :</h3><ul>";
    results.forEach(function(result) {
        html += "<li>" + result.nom + " " + result.prenom + "</li>";
    });
    html += "</ul>";

    // Afficher les résultats dans la page
    searchResultsDiv.innerHTML = html;
}
</script>
</body>
</html>