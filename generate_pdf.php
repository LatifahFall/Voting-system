<?php
require('fpdf186/fpdf.php');

// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_email'])) {
    // Redirect to authentication page if user is not logged in
    header("Location: authen.php");
    exit;
}

// Include database connection file
require('connect.php');

// Get user email
$email = $_SESSION['user_email'];

// Query to check user in etud3a table
$sql_etud3a = "SELECT * FROM etud3a WHERE email = :email";
$stmt_etud3a = $conn->prepare($sql_etud3a);
$stmt_etud3a->bindParam(':email', $email);
$stmt_etud3a->execute();
$user_etud3a = $stmt_etud3a->fetch(PDO::FETCH_ASSOC);

// Check if user is found in etud3a table
if ($user_etud3a) {
    // Define a class that extends FPDF
    class PDF extends FPDF {
        // Add a header
        function Header() {
            // Select Arial bold 15
            $this->SetFont('Arial', 'B', 15);
            // Move to the right
            $this->Cell(80);
            // Title
            $this->Cell(30, 10, 'ENSA MARRAKECH - Recepisse d\'inscription', 0, 0, 'C');
            // Line break
            $this->Ln(20);
        }

        // Add a footer
        function Footer() {
            // Position at 1.5 cm from bottom
            $this->SetY(-15);
            // Arial italic 8
            $this->SetFont('Arial', 'I', 8);
            // Page number
            $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
        }
    }

    // Instantiate the PDF class
    $pdf = new PDF();
    $pdf->AddPage();

    // Add user information to the PDF
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, 'Nom d\'utilisateur: ' . $user_etud3a['log'], 0, 1);
    $pdf->Cell(0, 10, 'Nom: ' . $user_etud3a['nom'], 0, 1);
    $pdf->Cell(0, 10, 'Prénom: ' . $user_etud3a['prenom'], 0, 1);
    $pdf->Cell(0, 10, 'Email: ' . $user_etud3a['email'], 0, 1);
    $pdf->Cell(0, 10, 'Date de naissance: ' . $user_etud3a['naissance'], 0, 1);
    $pdf->Cell(0, 10, 'Etablissement: ' . $user_etud3a['etablissement'], 0, 1);
    $pdf->Cell(0, 10, 'Diplome: ' . $user_etud3a['diplome'], 0, 1);
    $pdf->Cell(0, 10, 'Niveau: ' . $user_etud3a['niveau'], 0, 1);
    $pdf->Cell(0, 10, ' ', 0, 1);
    $pdf->Cell(0, 10, 'Vous etes candidats au concours d\'entrée à l\'ENSA Marrakech', 0, 1);
    // Obtenir la largeur de la page
    $pageWidth = $pdf->GetPageWidth();
    // Spécifier la taille de l'image
    $imageSize = 30; 
    // Calculer les coordonnées pour positionner l'image dans le coin haut droit
    $imageX = $pageWidth - $imageSize - 10; // 10=marge
    $imageY = 10; 
    // Ajouter l'image dans le PDF
    $pdf->Image($user_etud3a['photo'], $imageX, $imageY, $imageSize);
    // Faire un saut de ligne après l'image
    $pdf->Ln($imageSize + 5); // Ajouter un espace supplémentaire
    // Output le PDF
    $pdf->Output();
} else {
    // Query to check user in etud4a table
    $sql_etud4a = "SELECT * FROM etud4a WHERE email = :email";
    $stmt_etud4a = $conn->prepare($sql_etud4a);
    $stmt_etud4a->bindParam(':email', $email);
    $stmt_etud4a->execute();
    $user_etud4a = $stmt_etud4a->fetch(PDO::FETCH_ASSOC);

    // Check if user is found in etud4a table
    if ($user_etud4a) {
        // Define a class that extends FPDF
        class PDF extends FPDF {
            // Add a header
            function Header() {
                // Select Arial bold 15
                $this->SetFont('Arial', 'B', 15);
                // Move to the right
                $this->Cell(80);
                // Title
                $this->Cell(30, 10, 'ENSA MARRAKECH - Recepisse d\'inscription', 0, 0, 'C');
                // Line break
                $this->Ln(20);
            }

            // Add a footer
            function Footer() {
                // Position at 1.5 cm from bottom
                $this->SetY(-15);
                // Arial italic 8
                $this->SetFont('Arial', 'I', 8);
                // Page number
                $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
            }
        }

        // Instantiate the PDF class
        $pdf = new PDF();
        $pdf->AddPage();

        // Add user information to the PDF
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 10, 'Nom d\'utilisateur: ' . $user_etud4a['log'], 0, 1);
        $pdf->Cell(0, 10, 'Nom: ' . $user_etud4a['nom'], 0, 1);
        $pdf->Cell(0, 10, 'Prénom: ' . $user_etud4a['prenom'], 0, 1);
        $pdf->Cell(0, 10, 'Email: ' . $user_etud4a['email'], 0, 1);
        $pdf->Cell(0, 10, 'Date de naissance: ' . $user_etud4a['naissance'], 0, 1);
        $pdf->Cell(0, 10, 'Etablissement: ' . $user_etud4a['etablissement'], 0, 1);
        $pdf->Cell(0, 10, 'Diplome: ' . $user_etud4a['diplome'], 0, 1);
        $pdf->Cell(0, 10, 'Niveau: ' . $user_etud4a['niveau'], 0, 1);
        $pdf->Cell(0, 10, ' ', 0, 1);
        $pdf->Cell(0, 10, 'Vous etes candidats au concours d\'entrée à l\'ENSA Marrakech', 0, 1);
        // Obtenir la largeur de la page
        $pageWidth = $pdf->GetPageWidth();
        // Spécifier la taille de l'image
        $imageSize = 30; 
        // Calculer les coordonnées pour positionner l'image dans le coin haut droit
        $imageX = $pageWidth - $imageSize - 10; // 10=marge
        $imageY = 10; 
        // Ajouter l'image dans le PDF
        $pdf->Image($user_etud4a['photo'], $imageX, $imageY, $imageSize);
        // Faire un saut de ligne après l'image
        $pdf->Ln($imageSize + 5); // Ajouter un espace supplémentaire
        // Output le PDF
        $pdf->Output();
    } else {
        // Redirect to authentication page if user is not found in etud3a or etud4a tables
        header("Location: authen.php");
        exit;
    }
}

?>