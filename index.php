<!-- Datei: index.php -->
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChatGPT Interface</title>
    <style>
        body { font-family: Arial, sans-serif; }
        #chatBox { max-width: 600px; margin: 0 auto; }
        #messages { border: 1px solid #ccc; padding: 10px; height: 300px; overflow-y: auto; }
        #inputArea { display: flex; margin-top: 10px; }
        #userMessage { flex: 1; padding: 10px; }
        #sendBtn { padding: 10px 20px; background-color: #007BFF; color: white; border: none; cursor: pointer; }
    </style>
</head>
<body>
    <div id="chatBox">
        <h1>ChatGPT Interface</h1>
        <div id="messages"></div>
        <div id="inputArea">
            <input type="text" id="userMessage" placeholder="Schreibe eine Nachricht..." />
            <button id="sendBtn">Senden</button>
        </div>
    </div>

    <script>
    document.getElementById('sendBtn').addEventListener('click', async function() {
        const userMessage = document.getElementById('userMessage').value.trim();
        if (!userMessage) return;

        // Zeige die Nachricht des Benutzers im Chat
        const messagesDiv = document.getElementById('messages');
        messagesDiv.innerHTML += `<div><strong>Du:</strong> ${userMessage}</div>`;
        document.getElementById('userMessage').value = '';

        try {
            console.log('Sende Nachricht an den Server:', userMessage);

            // Sende die Nachricht an den Server
            const response = await fetch('chatgpt_handler.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ message: userMessage })
            });

            console.log('Antwort vom Server erhalten:', response);

            if (!response.ok) {
                throw new Error('Netzwerkantwort war nicht ok');
            }

            const data = await response.json();
            console.log('Daten vom Server:', data);

            // Überprüfen Sie, ob die Antwort das erwartete Format hat
            if (data && data.response) {
                messagesDiv.innerHTML += `<div><strong>ChatGPT:</strong> ${data.response}</div>`;
            } else {
                messagesDiv.innerHTML += `<div><strong>Fehler:</strong> Ungültige Antwort vom Server</div>`;
            }
        } catch (error) {
            console.error('Fehler beim Abrufen der Antwort:', error);
            messagesDiv.innerHTML += `<div><strong>Fehler:</strong> ${error.message}</div>`;
        }

        messagesDiv.scrollTop = messagesDiv.scrollHeight; // Automatisch scrollen
    });
</script>
</body>
</html>
