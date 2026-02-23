<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Services\GeminiService;
use Illuminate\Support\Facades\Http;

$apiKey = env('GEMINI_API_KEY');
$apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=" . $apiKey;

echo "Testing with Key: " . substr($apiKey, 0, 10) . "...\n";

try {
    $response = Http::withoutVerifying()->post($apiUrl, [
        'contents' => [
            [
                'parts' => [
                    ['text' => 'Hello, please reply with "SUCCESS" if you can read this.']
                ]
            ]
        ]
    ]);

    if ($response->successful()) {
        echo "Success! Response: " . json_encode($response->json(), JSON_PRETTY_PRINT) . "\n";
    } else {
        echo "Failed! Status: " . $response->status() . "\n";
        echo "Error detail: " . $response->body() . "\n";
    }
} catch (Exception $e) {
    echo "Exception: " . $e->getMessage() . "\n";
}
