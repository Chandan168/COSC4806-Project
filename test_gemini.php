<?php
// Test script to verify Gemini API key
$geminiKey = getenv('GEMINI');

if (!$geminiKey) {
    echo "❌ GEMINI environment variable not found\n";
    exit(1);
}

echo "✓ GEMINI key found: " . substr($geminiKey, 0, 10) . "...\n";

// Test API call
$prompt = "Say hello in a friendly way.";

$payload = [
    'contents' => [
        [
            'parts' => [
                ['text' => $prompt]
            ]
        ]
    ]
];

$context = stream_context_create([
    'http' => [
        'method' => 'POST',
        'header' => [
            'Content-Type: application/json',
            'x-goog-api-key: ' . $geminiKey
        ],
        'content' => json_encode($payload)
    ]
]);

$url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent';

echo "Testing API call...\n";
$response = file_get_contents($url, false, $context);

if ($response === false) {
    echo "❌ API call failed - check your key or network connection\n";
    exit(1);
}

$data = json_decode($response, true);

if (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
    echo "✅ API key works! Response: " . $data['candidates'][0]['content']['parts'][0]['text'] . "\n";
} else {
    echo "❌ API key might be invalid. Response:\n";
    echo json_encode($data, JSON_PRETTY_PRINT) . "\n";
}
?>
