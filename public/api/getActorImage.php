<?php
header('Content-Type: application/json');

// Vérification de la présence du paramètre "name"
if (!isset($_GET['name'])) {
    http_response_code(400);
    echo json_encode(["error" => "Le paramètre 'name' est requis."]);
    exit;
}

$actorName = urlencode($_GET['name']);

// URL de l'API Wikipédia en français
$apiUrl = "https://fr.wikipedia.org/w/api.php?action=query&titles={$actorName}&prop=pageimages|info&format=json&piprop=original&inprop=url";

// Appel à l'API de Wikipédia
$response = file_get_contents($apiUrl);

if ($response === FALSE) {
    http_response_code(500);
    echo json_encode(["error" => "Erreur lors de l'appel à l'API Wikipédia."]);
    exit;
}

// Décodage du JSON
$data = json_decode($response, true);

// Récupération des informations nécessaires
$page = reset($data['query']['pages']);
$imageUrl = $page['original']['source'] ?? null;
$pageUrl = $page['fullurl'] ?? null;

if ($imageUrl || $pageUrl) {
    echo json_encode([
        "image" => $imageUrl,
        "url" => $pageUrl
    ]);
} else {
    echo json_encode(["error" => "Informations non trouvées pour cet acteur."]);
}
