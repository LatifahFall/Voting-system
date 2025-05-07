<?php
require('fpdf186/fpdf.php'); // Inclure la classe FPDF
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Inclure les fichiers de PHPMailer
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

//Fonctions concernant le format du pdf
class PDF extends FPDF {
    function Header() {
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'Confirmation d\'inscription au concours', 0, 1, 'C');
        $this->Ln(10); // Saut de ligne
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', '', 8);
        $this->Cell(0, 10, 'Page '.$this->PageNo().'/{nb}', 0, 0, 'C');
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include the database connection file
    require("connect.php");

    // Check if the required fields are set in $_POST
    if (isset($_POST['nom'], $_POST['prenom'], $_POST['email'], $_POST['naissance'], $_POST['diplome'], $_POST['niveau'], $_POST['etablissement'], /*$_POST['photo'], $_POST['cv'],*/ $_POST['log'], $_POST['mdp'])) {
        // Retrieve form data
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $email = $_POST['email'];
        $naissance = $_POST['naissance'];
        $diplome = $_POST['diplome'];
        $niveau = $_POST['niveau'];
        $etablissement = $_POST['etablissement'];
        /*$photo = $_POST['photo'];
        $cv = $_POST['cv'];*/
        $log = $_POST['log'];
        $mdp = $_POST['mdp'];

        // Generation d'un token de validation
        $token = bin2hex(random_bytes(16)); // token aléatoire

        // Insertion des informations dans la base de données
        // Handle file uploads for profile picture and CV
        $profilePicPath = '';
        $cvPath = '';
        if (isset($_FILES['photo'], $_FILES['cv'])) {
            // Directory where uploaded files will be saved
            $uploadDir = 'uploads/';

            // Move uploaded files to the desired directory
            $profilePicPath = $uploadDir . basename($_FILES['photo']['name']);
            move_uploaded_file($_FILES['photo']['tmp_name'], $profilePicPath);

            $cvPath = $uploadDir . basename($_FILES['cv']['name']);
            move_uploaded_file($_FILES['cv']['tmp_name'], $cvPath);
        }

        // Vérifier si le candidat a déjà déposé une candidature
        $sql = "SELECT * FROM etud3a WHERE email = :email UNION SELECT * FROM etud4a WHERE email = :email";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Vérifier le nombre de résultats
        if (count($results) > 0) {
            echo "Vous avez déjà déposé une candidature.";
            exit();
        } 

        // Vérifier si un candidat titulaire d'un Bac+3 ne présente pas sa candidature en 3ème et 4ème année
        if ($diplome == 'Bac+3' && $niveau == '4ème année') {
            echo "Un candidat titulaire d'un Bac+3 ne peut pas présenter sa candidature en 4ème année.";
            exit();
        }

        // Insérer les données dans la bonne table selon le niveau demandé
        if ($niveau == '3ème année') {
            $table = 'etud3a';
        } else {
            $table = 'etud4a';
        }

        $sql = "INSERT INTO $table (nom, prenom, email, naissance, diplome, niveau, etablissement, photo, cv, log, mdp, token) 
                VALUES (:nom, :prenom, :email, :naissance, :diplome, :niveau, :etablissement, :photo, :cv, :log, :mdp, :token)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':naissance', $naissance);
        $stmt->bindParam(':diplome', $diplome);
        $stmt->bindParam(':niveau', $niveau);
        $stmt->bindParam(':etablissement', $etablissement);
        $stmt->bindParam(':photo', $profilePicPath);
        $stmt->bindParam(':cv', $cvPath);
        $stmt->bindParam(':log', $log);
        $stmt->bindParam(':mdp', $mdp);
        $stmt->bindParam(':token', $token);

        try {
            $stmt->execute();
            echo "User registration successful!";

            // Envoi d'un email de confirmation contenant le pdf avec le token de valitation
            $subject = "Confirmation d'inscription";
            $message = "Bonjour $prenom,\n\nVotre inscription a été enregistrée avec succès. Veuillez trouver ci-joint votre token de validation.\n\nCordialement,\nVotre équipe d'inscription";
            
            // Instantiation de PHPMailer
            $mail = new PHPMailer(true);

            // Configuration du serveur SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Remplacez avec le serveur SMTP
            $mail->SMTPAuth = true;
            $mail->Username = 'mllelatifahfall@gmail.com'; // Remplacez avec votre adresse email
            $mail->Password = 'jilm pyfp izuc jwkf'; // Remplacez avec votre mot de passe
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            // Configuration de l'email
            $mail->setFrom('mllelatifahfall@gmail.com', 'Latifah Fall');
            $mail->addAddress($email, $prenom);
            $mail->Subject = $subject;
            $mail->Body = $message;

            // Ajout du PDF en pièce jointe
            $pdf = new PDF();
            $pdf->AddPage();
            $pdf->SetFont('Arial', 'B', 16);
            $pdf->Cell(40, 10, "Token de validation: $token");
            $pdfContent = $pdf->Output('S');

            $mail->addStringAttachment($pdfContent, 'validation_token.pdf');

            // Envoi de l'email
            $mail->send();
            echo "Un email de confirmation avec le PDF en pièce jointe a été envoyé à votre adresse.";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        } catch (Exception $e) {
            echo "Error sending email: " . $mail->ErrorInfo;
        }
    } 
    else {
        echo "Please fill out all the required fields.";
    }
}
?>

