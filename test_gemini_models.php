<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Services\GeminiService;
use Illuminate\Support\Facades\Http;

$apiKey = env('GEMINI_API_KEY');
$models = ['gemini-2.0-flash', 'gemini-1.5-flash'];

foreach ($models as $model) {
    $apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key=" . $apiKey;
    echo "--- Testing Model: {$model} ---\n";

    try {
        $response = Http::withoutVerifying()->post($apiUrl, [
            'contents' => [['parts' => [['text' => 'Hi']]]]
        ]);

        if ($response->successful()) {
            echo "Success! Model {$model} is working.\n";
            // break; // If one works, we are good
        } else {
            echo "Failed! Status: " . $response->status() . "\n";
            echo "Error: " . $response->json()['error']['message'] ?? $response->body() . "\n";
        }
    } catch (Exception $e) {
        echo "Exception: " . $e->getMessage() . "\n";
    }
    echo "\n";
}
