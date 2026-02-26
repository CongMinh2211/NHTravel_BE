<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class TestController extends Controller
{
    public function seedDb(Request $request)
    {
        try {
            Artisan::call('migrate:fresh', [
                '--seed' => true,
                '--force' => true
            ]);
            return response()->json([
                'status' => true,
                'message' => 'Database migrated and seeded successfully. All default data should now exist.',
                'output' => Artisan::output()
            ]);
        } catch (\Throwable $e) {
            return response()->make(json_encode([
                'status' => false,
                'message' => 'Error executing seeder: ' . $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]), 500, ['Content-Type' => 'application/json']);
        }
    }
}
