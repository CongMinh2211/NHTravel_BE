<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Http;

$apiKey = env('GEMINI_API_KEY');
$url = "https://generativelanguage.googleapis.com/v1beta/models?key=" . $apiKey;

echo "Listing models for Key: " . substr($apiKey, 0, 10) . "...\n";

try {
    $response = Http::withoutVerifying()->get($url);

    if ($response->successful()) {
        echo "Models list success!\n";
        $models = $response->json()['models'];
        foreach ($models as $idx => $m) {
            echo ($idx + 1) . ". " . $m['name'] . " - " . implode(', ', $m['supportedGenerationMethods']) . "\n";
        }
    } else {
        echo "Failed! Status: " . $response->status() . "\n";
        echo "Error: " . $response->body() . "\n";
    }
} catch (Exception $e) {
    echo "Exception: " . $e->getMessage() . "\n";
}
