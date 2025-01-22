<?php
header('Content-Type: application/json');

$request = json_decode(file_get_contents('php://input'), true);
$message = $request['message'] ?? '';

if (empty($message)) {
    echo json_encode(['response' => 'Keine Nachricht erhalten.']);
    exit;
}

// Hier können Sie die Logik hinzufügen, um die Nachricht zu verarbeiten und eine Antwort zu generieren
$responseMessage = 'Dies ist eine Beispielantwort von ChatGPT.';

echo json_encode(['response' => $responseMessage]);
?>