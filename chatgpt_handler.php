<?php
// Datei: chatgpt_handler.php
header('Content-Type: application/json');
// JSON-Daten aus der Anfrage abrufen
$requestPayload = file_get_contents('php://input');
$requestData = json_decode($requestPayload, true);

// Eingehende Nachricht des Benutzers
$userMessage = $requestData['message'] ?? '';

// OpenAI API-Schlüssel
$apiKey = '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';

// OpenAI API-Endpunkt
$url = 'https://api.openai.com/v1/chat/completions';

// Daten für die Anfrage vorbereiten
$data = [
    'model' => 'gpt-3.5-turbo', // Oder 'gpt-3.5-turbo' 'gpt-4'
    'messages' => [
        [
            'role' => 'system',
            'content' => 'Du bist ein hilfreicher Assistent.',
        ],
        [
            'role' => 'user',
            'content' => $userMessage,
        ],
    ],
    'max_tokens' => 200,
    'temperature' => 0.7,
];

// cURL-Anfrage senden
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $apiKey,
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

$response = curl_exec($ch);
if (curl_errno($ch)) {
    http_response_code(500);
    echo json_encode(['error' => 'Fehler bei der Anfrage: ' . curl_error($ch)]);
    exit;
}
curl_close($ch);

// Antwort von ChatGPT auslesen
$responseData = json_decode($response, true);
$chatgptReply = $responseData['choices'][0]['message']['content'] ?? 'Keine Antwort erhalten.';

// Antwort als JSON zurückgeben
header('Content-Type: application/json');
echo json_encode(['response' => $chatgptReply]);
