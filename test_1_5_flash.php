<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Http;

$apiKey = env('GEMINI_API_KEY');
$model = "gemini-1.5-flash"; // Standard name for v1beta
$url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key=" . $apiKey;

echo "Calling 1.5 Flash: " . substr($apiKey, 0, 10) . "...\n";

try {
    $response = Http::withoutVerifying()->post($url, [
        'contents' => [
            ['parts' => [['text' => 'Hello']]]
        ]
    ]);

    if ($response->successful()) {
        echo "SUCCESS! Gemini 1.5 Flash is WORKING.\n";
        echo "Response: " . substr($response->body(), 0, 100) . "...\n";
    } else {
        echo "FAILED. Status: " . $response->status() . "\n";
        echo "Body: " . $response->body() . "\n";
    }
} catch (Exception $e) {
    echo "Exception: " . $e->getMessage() . "\n";
}
