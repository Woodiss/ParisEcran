<?php
use parisecran\DBAL\Connector;
use parisecran\Entity\Subscribers;

session_start();
require_once __DIR__ . "/../../vendor/autoload.php";


header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dbh = new Connector();
    $subscribersModel = new Subscribers($dbh->dbConnector);

    // Récupérer les données JSON envoyées
    $input = json_decode(file_get_contents('php://input'), true);

    if (!isset($input['new_password'])) {
        echo json_encode(['success' => false, 'message' => 'Mot de passe manquant.']);
        exit;
    }

    $newPassword = $input['new_password'];

    // Valider et traiter le mot de passe
    if (strlen($newPassword) < 6) {
        echo json_encode(['success' => false, 'message' => 'Le mot de passe doit contenir au moins 6 caractères.']);
        exit;
    }

    // Exemple de mise à jour dans la base de données (à adapter selon votre logique)
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    // Exemple d'exécution SQL...
    if ($subscribersModel->updatePassword($hashedPassword, $_SESSION['id'])) {
        echo json_encode(['success' => true, 'message' => 'Mot de passe mis à jour avec succès.']);
    exit;
    }
    
} else {
    // Méthode non autorisée
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Méthode non autorisée.']);
    exit;
}
